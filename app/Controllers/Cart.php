<?php

namespace App\Controllers;

use App\Models\CartModel;
use App\Models\ProductModel;
use App\Models\OrderModel;
use App\Models\OrderItemModel;

class Cart extends BaseController
{
    protected $cartModel;
    protected $productModel;
    protected $orderModel;
    protected $orderItemModel;

    public function __construct()
    {
        $this->cartModel = new CartModel();
        $this->productModel = new ProductModel();
        $this->orderModel = new OrderModel();
        $this->orderItemModel = new OrderItemModel();
    }

    public function index()
    {
        $userId = session()->get('user_id');
        $cartItems = $this->cartModel->getCartItems($userId);
        $total = $this->cartModel->getCartTotal($userId);

        $data = [
            'title' => 'Keranjang Belanja - Milky Dessert Box',
            'cartItems' => $cartItems,
            'total' => $total
        ];

        return view('cart/index', $data);
    }

    public function add()
    {
        $productId = $this->request->getPost('product_id');
        $quantity = $this->request->getPost('quantity') ?: 1;
        $userId = session()->get('user_id');

        // Check if product exists and has enough stock
        $product = $this->productModel->find($productId);
        if (!$product || $product['stock'] < $quantity) {
            return redirect()->back()->with('error', 'Produk tidak tersedia atau stok tidak mencukupi.');
        }

        // Check if item already in cart
        $existingItem = $this->cartModel->where('user_id', $userId)
                                       ->where('product_id', $productId)
                                       ->first();

        if ($existingItem) {
            $newQuantity = $existingItem['quantity'] + $quantity;
            if ($product['stock'] < $newQuantity) {
                return redirect()->back()->with('error', 'Stok tidak mencukupi untuk jumlah yang diminta.');
            }
            $this->cartModel->update($existingItem['id'], ['quantity' => $newQuantity]);
        } else {
            $data = [
                'user_id' => $userId,
                'product_id' => $productId,
                'quantity' => $quantity
            ];
            $this->cartModel->insert($data);
        }

        return redirect()->back()->with('success', 'Produk berhasil ditambahkan ke keranjang.');
    }

    public function update()
    {
        $cartId = $this->request->getPost('cart_id');
        $quantity = $this->request->getPost('quantity');
        $userId = session()->get('user_id');

        $cartItem = $this->cartModel->where('id', $cartId)
                                   ->where('user_id', $userId)
                                   ->first();

        if (!$cartItem) {
            return redirect()->back()->with('error', 'Item tidak ditemukan di keranjang.');
        }

        $product = $this->productModel->find($cartItem['product_id']);
        if ($product['stock'] < $quantity) {
            return redirect()->back()->with('error', 'Stok tidak mencukupi.');
        }

        $this->cartModel->update($cartId, ['quantity' => $quantity]);
        return redirect()->back()->with('success', 'Keranjang berhasil diupdate.');
    }

    public function remove()
    {
        $cartId = $this->request->getPost('cart_id');
        $userId = session()->get('user_id');

        $this->cartModel->where('id', $cartId)
                        ->where('user_id', $userId)
                        ->delete();

        return redirect()->back()->with('success', 'Item berhasil dihapus dari keranjang.');
    }

    public function checkout()
    {   
        log_message('debug', 'User ID from session: ' . print_r(session()->get('user_id'), true));

        $userId = session()->get('user_id');
        $cartItems = $this->cartModel->getCartItems($userId);
        
        if (empty($cartItems)) {
            return redirect()->to('/cart')->with('error', 'Keranjang belanja kosong.');
        }

        $total = $this->cartModel->getCartTotal($userId);

        $data = [
            'title' => 'Checkout - Milky Dessert Box',
            'cartItems' => $cartItems,
            'total' => $total
        ];

        return view('cart/checkout', $data);
    }

    public function processCheckout()
    {
        $userId = session()->get('user_id');
        $cartItems = $this->cartModel->getCartItems($userId);
        
        if (empty($cartItems)) {
            return redirect()->to('/cart')->with('error', 'Keranjang belanja kosong.');
        }

        $rules = [
            'shipping_address' => 'required|min_length[10]',
            'customer_phone' => 'required|min_length[10]|max_length[15]'
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $subtotal = $this->cartModel->getCartTotal($userId);
        $shippingCost = $this->calculateShippingCost($subtotal);
        $grandTotal = $subtotal + $shippingCost;
        $orderNumber = $this->orderModel->generateOrderNumber();

        // Get user data
        $userModel = new \App\Models\UserModel();
        $user = $userModel->find($userId);

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
            // Create order items
            foreach ($cartItems as $item) {
                $orderItemData = [
                    'order_id' => $orderId,
                    'product_id' => $item['product_id'],
                    'product_name' => $item['name'],
                    'quantity' => $item['quantity'],
                    'price' => $item['price'],
                    'subtotal' => $item['price'] * $item['quantity']
                ];
                $this->orderItemModel->insert($orderItemData);

                // Update product stock
                $newStock = $item['stock'] - $item['quantity'];
                $this->productModel->update($item['product_id'], ['stock' => $newStock]);
            }

            // Clear cart
            $this->cartModel->clearCart($userId);

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
