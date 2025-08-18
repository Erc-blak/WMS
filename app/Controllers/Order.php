<?php

namespace App\Controllers;

use App\Models\OrderModel;
use App\Models\OrderItemModel;
use App\Models\InventoryModel; 
use CodeIgniter\Controller;

class Order extends BaseController
{
    public function index()
    {
        $orderModel = new OrderModel();
        $data['orders'] = $orderModel->findAll();

        return view('order/list', $data);
    }

    public function create()
    {
        $inventoryModel = new InventoryModel();
        $data['items'] = $inventoryModel->findAll();

        return view('order/add', $data);
    }

    public function save()
    {
        $orderModel = new OrderModel();
        $orderItemModel = new OrderItemModel();
        
        $rules = [
            'customer_name' => 'required|min_length[3]',
            'item_ids' => 'required',
        ];
        
        if (! $this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $orderData = [
            'customer_name' => $this->request->getPost('customer_name'),
            'status' => 'pending',
        ];
        
        $orderId = $orderModel->insert($orderData);
        
        if ($orderId) {
            $itemIds = $this->request->getPost('item_ids');
            $quantities = $this->request->getPost('quantities');

            for ($i = 0; $i < count($itemIds); $i++) {
                if ($quantities[$i] > 0) {
                    $orderItemData = [
                        'order_id' => $orderId,
                        'item_id' => $itemIds[$i],
                        'quantity' => $quantities[$i],
                    ];
                    $orderItemModel->insert($orderItemData);
                }
            }
            
            return redirect()->to('/order')->with('success', 'Order created successfully!');
        } else {
            return redirect()->back()->withInput()->with('error', 'Failed to create order. Please try again.');
        }
    }

    // New method to view order details
    public function details($id = null)
    {
        $orderModel = new OrderModel();
        $orderItemModel = new OrderItemModel();
        
        $data['order'] = $orderModel->find($id);

        if ($data['order'] === null) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        }

        // Use a join to fetch order items with their corresponding inventory item names and SKUs
        $data['items'] = $orderItemModel
                            ->select('order_items.*, inventory.name, inventory.sku')
                            ->join('inventory', 'inventory.id = order_items.item_id')
                            ->where('order_id', $id)
                            ->findAll();

        return view('order/details', $data);
    }
}