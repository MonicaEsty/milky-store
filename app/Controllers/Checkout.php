<?php

namespace App\Controllers;

use App\Models\ProductModel;
use App\Models\OrderModel;
use App\Models\OrderItemModel;
use App\Models\UserModel;

class Checkout extends BaseController
{
    protected $productModel;
    protected $orderModel;
    protected $orderItemModel;
    protected $userModel;

    public function __construct()
    {
        $this->productModel = new ProductModel();
        $this->orderModel = new OrderModel();
        $this->orderItemModel = new OrderItemModel();
        $this->userModel = new UserModel();
    }

    public function quick()
    {
        $productId = $this->request->getPost('product_id');
        $quantity = $this->request->getPost('quantity') ?: 1;

        // Validate product
        $product = $this->productModel->find($productId);
        if (!$product || $product['stock'] < $quantity || !$product['is_active']) {
            return redirect()->back()->with('error', 'Produk tidak tersedia atau stok tidak mencukupi.');
        }

        // Store in session for checkout
        session()->set('quick_checkout', [
            'product_id' => $productId,
            'quantity' => $quantity
        ]);

        return redirect()->to('/checkout/product/' . $productId);
    }

    public function productCheckout($productId)
    {
        $quickCheckout = session()->get('quick_checkout');
        
        if (!$quickCheckout || $quickCheckout['product_id'] != $productId) {
            return redirect()->to('/product/' . $productId)->with('error', 'Session checkout tidak valid.');
        }

        $product = $this->productModel->find($productId);
        if (!$product) {
            return redirect()->to('/shop')->with('error', 'Produk tidak ditemukan.');
        }

        $quantity = $quickCheckout['quantity'];
        $subtotal = $product['price'] * $quantity;
        $shippingCost = $this->calculateShippingCost($subtotal);
        $grandTotal = $subtotal + $shippingCost;

        // Get user data
        $userId = session()->get('user_id');
        $user = $this->userModel->find($userId);

        $data = [
            'title' => 'Checkout - ' . $product['name'],
            'product' => $product,
            'quantity' => $quantity,
            'subtotal' => $subtotal,
            'shippingCost' => $shippingCost,
            'grandTotal' => $grandTotal,
            'user' => $user
        ];

        return view('checkout/product', $data);
    }

    public function processProductCheckout()
    {
        $quickCheckout = session()->get('quick_checkout');
        
        if (!$quickCheckout) {
            return redirect()->to('/shop')->with('error', 'Session checkout tidak valid.');
        }

        $productId = $quickCheckout['product_id'];
        $quantity = $quickCheckout['quantity'];

        // Validate product again
        $product = $this->productModel->find($productId);
        if (!$product || $product['stock'] < $quantity) {
            return redirect()->back()->with('error', 'Produk tidak tersedia atau stok tidak mencukupi.');
        }

        $rules = [
            'shipping_address' => 'required|min_length[10]',
            'customer_phone' => 'required|min_length[10]|max_length[15]'
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $subtotal = $product['price'] * $quantity;
        $shippingCost = $this->calculateShippingCost($subtotal);
        $grandTotal = $subtotal + $shippingCost;
        $orderNumber = $this->orderModel->generateOrderNumber();

        // Get user data
        $userId = session()->get('user_id');
        $user = $this->userModel->find($userId);

        // Create order
        $orderData = [
            'user_id' => $userId,
            'order_number' => $orderNumber,
            'total_amount' => $subtotal,
            'shipping_cost' => $shippingCost,
            'grand_total' => $grandTotal,
            'customer_name' => $user['full_name'],
            'customer_email' => $user['email'],
            'customer_phone' => $this->request->getPost('customer_phone'),
            'shipping_address' => $this->request->getPost('shipping_address'),
            'notes' => $this->request->getPost('notes'),
            'payment_method' => 'midtrans',
            'status' => 'pending',
            'payment_status' => 'pending'
        ];

        $orderId = $this->orderModel->insert($orderData);

        if ($orderId) {
            // Create order item
            $orderItemData = [
                'order_id' => $orderId,
                'product_id' => $productId,
                'product_name' => $product['name'],
                'quantity' => $quantity,
                'price' => $product['price'],
                'subtotal' => $subtotal
            ];
            $this->orderItemModel->insert($orderItemData);

            // Update product stock
            $newStock = $product['stock'] - $quantity;
            $this->productModel->update($productId, ['stock' => $newStock]);

            // Clear session
            session()->remove('quick_checkout');

            // Redirect to payment
            return redirect()->to('/payment/process/' . $orderNumber);
        } else {
            return redirect()->back()->with('error', 'Gagal membuat pesanan.');
        }
    }

    private function calculateShippingCost($subtotal)
    {
        // Free shipping for orders above 100,000
        if ($subtotal >= 100000) {
            return 0;
        }
        
        // Standard shipping cost
        return 15000;
    }
}
