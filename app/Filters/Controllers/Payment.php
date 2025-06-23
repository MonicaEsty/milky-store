<?php

namespace App\Controllers;

use App\Models\OrderModel;
use App\Models\OrderItemModel;
use App\Models\PaymentLogModel;
use App\Libraries\MidtransLibrary;

class Payment extends BaseController
{
    protected $orderModel;
    protected $orderItemModel;
    protected $paymentLogModel;
    protected $midtrans;

    public function __construct()
    {
        $this->orderModel = new OrderModel();
        $this->orderItemModel = new OrderItemModel();
        $this->paymentLogModel = new PaymentLogModel();
        $this->midtrans = new MidtransLibrary();
    }

    public function process($orderNumber)
    {
        $order = $this->orderModel->where('order_number', $orderNumber)->first();
        
        if (!$order) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('Pesanan tidak ditemukan');
        }

        // Check if user owns this order
        if (session()->get('user_id') != $order['user_id']) {
            return redirect()->to('/')->with('error', 'Akses ditolak.');
        }

        // Check if order is already paid
        if ($order['payment_status'] == 'paid') {
            return redirect()->to('/customer/orders/' . $order['id'])->with('info', 'Pesanan sudah dibayar.');
        }

        // Get order items
        $orderItems = $this->orderItemModel->getOrderItems($order['id']);

        // Prepare Midtrans transaction parameters
        $transactionDetails = [
            'order_id' => $order['order_number'],
            'gross_amount' => (int) $order['grand_total']
        ];

        $itemDetails = [];
        foreach ($orderItems as $item) {
            $itemDetails[] = [
                'id' => $item['product_id'],
                'price' => (int) $item['price'],
                'quantity' => $item['quantity'],
                'name' => $item['product_name']
            ];
        }

        // Add shipping cost if any
        if ($order['shipping_cost'] > 0) {
            $itemDetails[] = [
                'id' => 'SHIPPING',
                'price' => (int) $order['shipping_cost'],
                'quantity' => 1,
                'name' => 'Biaya Pengiriman'
            ];
        }

        $customerDetails = [
            'first_name' => $order['customer_name'],
            'email' => $order['customer_email'],
            'phone' => $order['customer_phone'],
            'billing_address' => [
                'address' => $order['shipping_address']
            ],
            'shipping_address' => [
                'address' => $order['shipping_address']
            ]
        ];

        $params = [
            'transaction_details' => $transactionDetails,
            'item_details' => $itemDetails,
            'customer_details' => $customerDetails,
            'enabled_payments' => [
                'credit_card', 'bca_va', 'bni_va', 'bri_va', 'echannel', 
                'permata_va', 'other_va', 'gopay', 'shopeepay', 'qris'
            ],
            'vtweb' => [],
            'callbacks' => [
                'finish' => base_url('/payment/success/' . $order['order_number'])
            ]
        ];

        // Create Midtrans transaction
        $result = $this->midtrans->createTransaction($params);

        if ($result['success']) {
            // Update order with Midtrans order ID
            $this->orderModel->update($order['id'], [
                'midtrans_order_id' => $order['order_number'],
                'payment_method' => 'midtrans'
            ]);

            $data = [
                'title' => 'Pembayaran - Milky Dessert Box',
                'order' => $order,
                'orderItems' => $orderItems,
                'snapToken' => $result['snap_token'],
                'clientKey' => $this->midtrans->getClientKey()
            ];

            return view('payment/process', $data);
        } else {
            return redirect()->back()->with('error', 'Gagal membuat transaksi pembayaran: ' . $result['message']);
        }
    }

    public function notification()
    {
        $json = file_get_contents('php://input');
        $notification = json_decode($json, true);

        if (!$notification) {
            http_response_code(400);
            echo json_encode(['status' => 'error', 'message' => 'Invalid JSON']);
            return;
        }

        // Log the notification
        log_message('info', 'Midtrans Notification: ' . $json);

        $orderId = $notification['order_id'];
        $transactionStatus = $notification['transaction_status'];
        $fraudStatus = isset($notification['fraud_status']) ? $notification['fraud_status'] : '';
        $grossAmount = $notification['gross_amount'];
        $signatureKey = $notification['signature_key'];

        // Verify signature
        $serverKey = config('Midtrans')->serverKey;
        $expectedSignature = $this->midtrans->verifySignature($orderId, $notification['status_code'], $grossAmount, $serverKey);

        if ($signatureKey !== $expectedSignature) {
            http_response_code(400);
            echo json_encode(['status' => 'error', 'message' => 'Invalid signature']);
            return;
        }

        // Find order
        $order = $this->orderModel->where('order_number', $orderId)->first();
        if (!$order) {
            http_response_code(404);
            echo json_encode(['status' => 'error', 'message' => 'Order not found']);
            return;
        }

        // Log payment notification
        $this->paymentLogModel->insert([
            'order_id' => $order['id'],
            'transaction_id' => $notification['transaction_id'],
            'payment_type' => $notification['payment_type'],
            'transaction_status' => $transactionStatus,
            'fraud_status' => $fraudStatus,
            'gross_amount' => $grossAmount,
            'signature_key' => $signatureKey,
            'notification_body' => $json
        ]);

        // Update order status based on transaction status
        $updateData = [
            'midtrans_transaction_id' => $notification['transaction_id'],
            'midtrans_payment_type' => $notification['payment_type'],
            'midtrans_transaction_time' => date('Y-m-d H:i:s', strtotime($notification['transaction_time'])),
            'midtrans_transaction_status' => $transactionStatus,
            'midtrans_fraud_status' => $fraudStatus,
            'midtrans_gross_amount' => $grossAmount,
            'midtrans_signature_key' => $signatureKey
        ];

        if ($transactionStatus == 'capture') {
            if ($fraudStatus == 'challenge') {
                $updateData['payment_status'] = 'pending';
                $updateData['status'] = 'pending';
            } else if ($fraudStatus == 'accept') {
                $updateData['payment_status'] = 'paid';
                $updateData['status'] = 'paid';
            }
        } else if ($transactionStatus == 'settlement') {
            $updateData['payment_status'] = 'paid';
            $updateData['status'] = 'processing';
        } else if ($transactionStatus == 'pending') {
            $updateData['payment_status'] = 'pending';
            $updateData['status'] = 'pending';
        } else if ($transactionStatus == 'deny') {
            $updateData['payment_status'] = 'failed';
            $updateData['status'] = 'cancelled';
        } else if ($transactionStatus == 'expire') {
            $updateData['payment_status'] = 'expired';
            $updateData['status'] = 'cancelled';
        } else if ($transactionStatus == 'cancel') {
            $updateData['payment_status'] = 'cancelled';
            $updateData['status'] = 'cancelled';
        }

        $this->orderModel->update($order['id'], $updateData);

        // Send response
        http_response_code(200);
        echo json_encode(['status' => 'success']);
    }

    public function success($orderNumber)
    {
        $order = $this->orderModel->where('order_number', $orderNumber)->first();
        
        if (!$order) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('Pesanan tidak ditemukan');
        }

        // Check transaction status from Midtrans
        $status = $this->midtrans->getTransactionStatus($orderNumber);
        
        if ($status['success']) {
            $transactionStatus = $status['data']->transaction_status;
            $fraudStatus = isset($status['data']->fraud_status) ? $status['data']->fraud_status : '';

            // Update order status if needed
            if ($transactionStatus == 'settlement' || ($transactionStatus == 'capture' && $fraudStatus == 'accept')) {
                $this->orderModel->update($order['id'], [
                    'payment_status' => 'paid',
                    'status' => 'processing'
                ]);
                $order['payment_status'] = 'paid';
                $order['status'] = 'processing';
            }
        }

        $data = [
            'title' => 'Pembayaran Berhasil - Milky Dessert Box',
            'order' => $order
        ];

        return view('payment/success', $data);
    }

    public function pending($orderNumber)
    {
        $order = $this->orderModel->where('order_number', $orderNumber)->first();
        
        if (!$order) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('Pesanan tidak ditemukan');
        }

        $data = [
            'title' => 'Pembayaran Pending - Milky Dessert Box',
            'order' => $order
        ];

        return view('payment/pending', $data);
    }

    public function error($orderNumber)
    {
        $order = $this->orderModel->where('order_number', $orderNumber)->first();
        
        if (!$order) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('Pesanan tidak ditemukan');
        }

        $data = [
            'title' => 'Pembayaran Gagal - Milky Dessert Box',
            'order' => $order
        ];

        return view('payment/error', $data);
    }
}
