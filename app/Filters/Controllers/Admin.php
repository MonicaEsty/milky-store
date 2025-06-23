<?php

namespace App\Controllers;

use App\Models\ProductModel;
use App\Models\CategoryModel;
use App\Models\OrderModel;
use App\Models\OrderItemModel;
use App\Models\UserModel;

class Admin extends BaseController
{
    protected $productModel;
    protected $categoryModel;
    protected $orderModel;
    protected $orderItemModel;
    protected $userModel;

    public function __construct()
    {
        $this->productModel = new ProductModel();
        $this->categoryModel = new CategoryModel();
        $this->orderModel = new OrderModel();
        $this->orderItemModel = new OrderItemModel();
        $this->userModel = new UserModel();
    }

    public function dashboard()
    {
        $data = [
            'title' => 'Admin Dashboard - Milky Dessert Box',
            'totalProducts' => $this->productModel->countAll(),
            'totalOrders' => $this->orderModel->countAll(),
            'totalUsers' => $this->userModel->where('role', 'customer')->countAllResults(),
            'recentOrders' => $this->orderModel->getOrdersWithUser(),
            'totalRevenue' => $this->calculateTotalRevenue()
        ];

        return view('admin/dashboard', $data);
    }

    public function products()
    {
        $data = [
            'title' => 'Kelola Produk - Admin',
            'products' => $this->productModel->getProductsWithCategory()
        ];

        return view('admin/products/index', $data);
    }

    public function createProduct()
    {
        $data = [
            'title' => 'Tambah Produk - Admin',
            'categories' => $this->categoryModel->getActiveCategories()
        ];

        return view('admin/products/create', $data);
    }

    public function storeProduct()
    {
        $rules = [
            'name' => 'required|min_length[3]|max_length[100]',
            'price' => 'required|decimal',
            'stock' => 'required|integer',
            'category_id' => 'required|integer',
            'image' => 'uploaded[image]|max_size[image,2048]|is_image[image]'
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $image = $this->request->getFile('image');
        $imageName = $image->getRandomName();
        $image->move('images/', $imageName);

        $data = [
            'category_id' => $this->request->getPost('category_id'),
            'name' => $this->request->getPost('name'),
            'description' => $this->request->getPost('description'),
            'price' => $this->request->getPost('price'),
            'stock' => $this->request->getPost('stock'),
            'weight' => $this->request->getPost('weight') ?: 300,
            'image' => $imageName,
            'is_active' => $this->request->getPost('is_active') ? 1 : 0
        ];

        if ($this->productModel->insert($data)) {
            return redirect()->to('/admin/products')->with('success', 'Produk berhasil ditambahkan.');
        } else {
            return redirect()->back()->withInput()->with('error', 'Gagal menambahkan produk.');
        }
    }

    public function editProduct($id)
    {
        $product = $this->productModel->find($id);
        if (!$product) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('Produk tidak ditemukan');
        }

        $data = [
            'title' => 'Edit Produk - Admin',
            'product' => $product,
            'categories' => $this->categoryModel->getActiveCategories()
        ];

        return view('admin/products/edit', $data);
    }

    public function updateProduct($id)
    {
        $product = $this->productModel->find($id);
        if (!$product) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('Produk tidak ditemukan');
        }

        $rules = [
            'name' => 'required|min_length[3]|max_length[100]',
            'price' => 'required|decimal',
            'stock' => 'required|integer',
            'category_id' => 'required|integer'
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $data = [
            'category_id' => $this->request->getPost('category_id'),
            'name' => $this->request->getPost('name'),
            'description' => $this->request->getPost('description'),
            'price' => $this->request->getPost('price'),
            'stock' => $this->request->getPost('stock'),
            'weight' => $this->request->getPost('weight') ?: 300,
            'is_active' => $this->request->getPost('is_active') ? 1 : 0
        ];

        $image = $this->request->getFile('image');
        if ($image && $image->isValid()) {
            $imageName = $image->getRandomName();
            $image->move('images/', $imageName);
            $data['image'] = $imageName;

            // Delete old image
            if (file_exists('images/' . $product['image'])) {
                unlink('images/' . $product['image']);
            }
        }

        if ($this->productModel->update($id, $data)) {
            return redirect()->to('/admin/products')->with('success', 'Produk berhasil diupdate.');
        } else {
            return redirect()->back()->withInput()->with('error', 'Gagal mengupdate produk.');
        }
    }

    public function deleteProduct($id)
    {
        $product = $this->productModel->find($id);
        if (!$product) {
            return redirect()->back()->with('error', 'Produk tidak ditemukan.');
        }

        if ($this->productModel->delete($id)) {
            // Delete image file
            if (file_exists('images/' . $product['image'])) {
                unlink('images/' . $product['image']);
            }
            return redirect()->to('/admin/products')->with('success', 'Produk berhasil dihapus.');
        } else {
            return redirect()->back()->with('error', 'Gagal menghapus produk.');
        }
    }

    public function categories()
    {
        $data = [
            'title' => 'Kelola Kategori - Admin',
            'categories' => $this->categoryModel->findAll()
        ];

        return view('admin/categories/index', $data);
    }

    public function storeCategory()
    {
        $rules = [
            'name' => 'required|min_length[3]|max_length[100]'
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $data = [
            'name' => $this->request->getPost('name'),
            'description' => $this->request->getPost('description')
        ];

        if ($this->categoryModel->insert($data)) {
            return redirect()->to('/admin/categories')->with('success', 'Kategori berhasil ditambahkan.');
        } else {
            return redirect()->back()->withInput()->with('error', 'Gagal menambahkan kategori.');
        }
    }

    public function updateCategory($id)
    {
        $rules = [
            'name' => 'required|min_length[3]|max_length[100]'
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $data = [
            'name' => $this->request->getPost('name'),
            'description' => $this->request->getPost('description'),
            'is_active' => $this->request->getPost('is_active') ? 1 : 0
        ];

        if ($this->categoryModel->update($id, $data)) {
            return redirect()->to('/admin/categories')->with('success', 'Kategori berhasil diupdate.');
        } else {
            return redirect()->back()->with('error', 'Gagal mengupdate kategori.');
        }
    }

    public function deleteCategory($id)
    {
        if ($this->categoryModel->delete($id)) {
            return redirect()->to('/admin/categories')->with('success', 'Kategori berhasil dihapus.');
        } else {
            return redirect()->back()->with('error', 'Gagal menghapus kategori.');
        }
    }

    public function orders()
    {
        $data = [
            'title' => 'Kelola Pesanan - Admin',
            'orders' => $this->orderModel->getOrdersWithUser()
        ];

        return view('admin/orders/index', $data);
    }

    public function orderDetail($id)
    {
        $order = $this->orderModel->select('orders.*, users.full_name, users.email, users.phone')
                                 ->join('users', 'users.id = orders.user_id')
                                 ->find($id);
        
        if (!$order) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('Pesanan tidak ditemukan');
        }

        $orderItems = $this->orderItemModel->getOrderItems($id);

        $data = [
            'title' => 'Detail Pesanan - Admin',
            'order' => $order,
            'orderItems' => $orderItems
        ];

        return view('admin/orders/detail', $data);
    }

    public function updateOrderStatus($id)
    {
        $status = $this->request->getPost('status');
        
        if ($this->orderModel->update($id, ['status' => $status])) {
            return redirect()->back()->with('success', 'Status pesanan berhasil diupdate.');
        } else {
            return redirect()->back()->with('error', 'Gagal mengupdate status pesanan.');
        }
    }

    public function orderReceipt($id)
    {
        $order = $this->orderModel->select('orders.*, users.full_name, users.email, users.phone')
                                 ->join('users', 'users.id = orders.user_id')
                                 ->find($id);
        
        if (!$order) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('Pesanan tidak ditemukan');
        }

        // Only show receipt for paid orders
        if ($order['payment_status'] !== 'paid') {
            return redirect()->back()->with('error', 'Bukti pembayaran hanya tersedia untuk pesanan yang sudah dibayar.');
        }

        $orderItems = $this->orderItemModel->getOrderItems($id);

        $data = [
            'title' => 'Bukti Pembayaran - ' . $order['order_number'],
            'order' => $order,
            'orderItems' => $orderItems
        ];

        return view('admin/orders/receipt', $data);
    }

    public function users()
    {
        $data = [
            'title' => 'Kelola Users - Admin',
            'users' => $this->userModel->where('role', 'customer')->findAll()
        ];

        return view('admin/users/index', $data);
    }

    public function storeUser()
    {
        $rules = [
            'username' => 'required|min_length[3]|max_length[50]|is_unique[users.username]',
            'email' => 'required|valid_email|is_unique[users.email]',
            'password' => 'required|min_length[6]',
            'full_name' => 'required|min_length[3]|max_length[100]'
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $data = [
            'username' => $this->request->getPost('username'),
            'email' => $this->request->getPost('email'),
            'password' => $this->request->getPost('password'),
            'full_name' => $this->request->getPost('full_name'),
            'phone' => $this->request->getPost('phone'),
            'address' => $this->request->getPost('address'),
            'role' => 'customer',
            'is_active' => 1
        ];

        if ($this->userModel->insert($data)) {
            return redirect()->to('/admin/users')->with('success', 'User berhasil ditambahkan.');
        } else {
            return redirect()->back()->withInput()->with('error', 'Gagal menambahkan user.');
        }
    }

    public function updateUser($id)
    {
        $user = $this->userModel->find($id);
        if (!$user) {
            return redirect()->back()->with('error', 'User tidak ditemukan.');
        }

        $rules = [
            'username' => "required|min_length[3]|max_length[50]|is_unique[users.username,id,{$id}]",
            'email' => "required|valid_email|is_unique[users.email,id,{$id}]",
            'full_name' => 'required|min_length[3]|max_length[100]'
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $data = [
            'username' => $this->request->getPost('username'),
            'email' => $this->request->getPost('email'),
            'full_name' => $this->request->getPost('full_name'),
            'phone' => $this->request->getPost('phone'),
            'address' => $this->request->getPost('address'),
            'is_active' => $this->request->getPost('is_active') ? 1 : 0
        ];

        // Only update password if provided
        $password = $this->request->getPost('password');
        if (!empty($password)) {
            $data['password'] = $password;
        }

        if ($this->userModel->update($id, $data)) {
            return redirect()->to('/admin/users')->with('success', 'User berhasil diupdate.');
        } else {
            return redirect()->back()->withInput()->with('error', 'Gagal mengupdate user.');
        }
    }

    public function toggleUserStatus($id)
    {
        $user = $this->userModel->find($id);
        if (!$user) {
            return redirect()->back()->with('error', 'User tidak ditemukan.');
        }

        $newStatus = $user['is_active'] == 1 ? 0 : 1;
        
        if ($this->userModel->update($id, ['is_active' => $newStatus])) {
            $message = $newStatus == 1 ? 'User berhasil diaktifkan.' : 'User berhasil dinonaktifkan.';
            return redirect()->back()->with('success', $message);
        } else {
            return redirect()->back()->with('error', 'Gagal mengubah status user.');
        }
    }

    public function userOrders($userId)
    {
        $user = $this->userModel->find($userId);
        if (!$user) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('User tidak ditemukan');
        }

        $orders = $this->orderModel->getUserOrders($userId);

        $data = [
            'title' => 'Riwayat Pesanan - ' . $user['full_name'],
            'user' => $user,
            'orders' => $orders
        ];

        return view('admin/users/orders', $data);
    }

    private function calculateTotalRevenue()
    {
        $orders = $this->orderModel->where('payment_status', 'paid')->findAll();
        $total = 0;
        foreach ($orders as $order) {
            $total += $order['grand_total'];
        }
        return $total;
    }
}
