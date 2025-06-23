<?php

namespace App\Controllers;

use App\Models\OrderModel;
use App\Models\OrderItemModel;
use App\Models\UserModel;

class Customer extends BaseController
{
    protected $orderModel;
    protected $orderItemModel;
    protected $userModel;

    public function __construct()
    {
        $this->orderModel = new OrderModel();
        $this->orderItemModel = new OrderItemModel();
        $this->userModel = new UserModel();
    }

    public function dashboard()
    {
        $userId = session()->get('user_id');
        $recentOrders = $this->orderModel->getUserOrders($userId);

        $data = [
            'title' => 'Dashboard - Milky Dessert Box',
            'recentOrders' => array_slice($recentOrders, 0, 5)
        ];

        return view('customer/dashboard', $data);
    }

    public function profile()
    {
        $userId = session()->get('user_id');
        $user = $this->userModel->find($userId);

        $data = [
            'title' => 'Profil Saya - Milky Dessert Box',
            'user' => $user
        ];

        return view('customer/profile', $data);
    }

    public function updateProfile()
    {
        $userId = session()->get('user_id');
        
        $rules = [
            'full_name' => 'required|min_length[3]|max_length[100]',
            'phone' => 'permit_empty|min_length[10]|max_length[15]'
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $data = [
            'full_name' => $this->request->getPost('full_name'),
            'phone' => $this->request->getPost('phone'),
            'address' => $this->request->getPost('address')
        ];

        if ($this->userModel->update($userId, $data)) {
            session()->set('full_name', $data['full_name']);
            return redirect()->back()->with('success', 'Profil berhasil diupdate.');
        } else {
            return redirect()->back()->with('error', 'Gagal mengupdate profil.');
        }
    }

    public function orders()
    {
        $userId = session()->get('user_id');
        $orders = $this->orderModel->getUserOrders($userId);

        $data = [
            'title' => 'Pesanan Saya - Milky Dessert Box',
            'orders' => $orders
        ];

        return view('customer/orders', $data);
    }

    public function orderDetail($id)
    {
        $userId = session()->get('user_id');
        $order = $this->orderModel->where('id', $id)
                                  ->where('user_id', $userId)
                                  ->first();

        if (!$order) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('Pesanan tidak ditemukan');
        }

        $orderItems = $this->orderItemModel->getOrderItems($id);

        $data = [
            'title' => 'Detail Pesanan - Milky Dessert Box',
            'order' => $order,
            'orderItems' => $orderItems
        ];

        return view('customer/order_detail', $data);
    }
}
