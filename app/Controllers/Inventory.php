<?php

namespace App\Controllers;

use App\Models\InventoryModel;
use App\Models\InventoryHistoryModel;
use CodeIgniter\Controller;

class Inventory extends BaseController
{
    public function index()
    {
        $inventoryModel = new InventoryModel();
        $data['items'] = $inventoryModel->findAll();
        return view('inventory/list', $data);
    }

    public function create()
    {
        return view('inventory/add');
    }

    public function save()
    {
        $inventoryModel = new InventoryModel();
        $inventoryHistoryModel = new InventoryHistoryModel();

        $rules = [
            'sku' => [
                'rules' => 'required|is_unique[inventory.sku]',
                'errors' => [
                    'is_unique' => 'This SKU already exists. Please use a unique SKU.',
                ],
            ],
            'name' => 'required',
            'quantity' => 'required|numeric',
            'location' => 'permit_empty',
        ];
        
        if (! $this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $data = [
            'sku' => $this->request->getPost('sku'),
            'name' => $this->request->getPost('name'),
            'quantity' => $this->request->getPost('quantity'),
            'location' => $this->request->getPost('location'),
        ];
        
        $itemId = $inventoryModel->insert($data);
        if ($itemId) {
            $historyData = [
                'item_id' => $itemId,
                'action'  => 'Item Created',
                'notes'   => 'New item was added to the inventory.',
            ];
            $inventoryHistoryModel->insert($historyData);
            
            return redirect()->to('/inventory')->with('success', 'Item added successfully!');
        } else {
            return redirect()->back()->withInput()->with('error', 'Failed to add item. Please try again.');
        }
    }

    public function details($id = null)
    {
        $inventoryModel = new InventoryModel();
        $inventoryHistoryModel = new InventoryHistoryModel();

        $data['item'] = $inventoryModel->find($id);

        if ($data['item'] === null) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        }

        $data['history'] = $inventoryHistoryModel->where('item_id', $id)->orderBy('created_at', 'DESC')->findAll();

        return view('inventory/details', $data);
    }

    public function edit($id = null)
    {
        $inventoryModel = new InventoryModel();
        $data['item'] = $inventoryModel->find($id);

        if ($data['item'] === null) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        }

        return view('inventory/edit', $data);
    }

    public function update($id = null)
    {
        $inventoryModel = new InventoryModel();
        $inventoryHistoryModel = new InventoryHistoryModel();

        $item = $inventoryModel->find($id);

        if ($item === null) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        }

        $newData = [
            'sku' => $this->request->getPost('sku'),
            'name' => $this->request->getPost('name'),
            'quantity' => $this->request->getPost('quantity'),
            'location' => $this->request->getPost('location'),
        ];

        if ($newData['sku'] !== $item['sku'] || $newData['name'] !== $item['name'] || $newData['quantity'] !== $item['quantity'] || $newData['location'] !== $item['location']) {
             $historyData = [
                'item_id' => $id,
                'action'  => 'Item Updated',
                'notes'   => 'Details were changed.',
            ];
            $inventoryHistoryModel->insert($historyData);
        }

        if ($inventoryModel->update($id, $newData)) {
            return redirect()->to('/inventory/details/' . $id)->with('success', 'Item updated successfully!');
        } else {
            return redirect()->back()->withInput()->with('error', 'Failed to update item. Please try again.');
        }
    }

    public function delete($id = null)
    {
        $inventoryModel = new InventoryModel();
        $inventoryHistoryModel = new InventoryHistoryModel();

        $item = $inventoryModel->find($id);
        if ($item === null) {
            return redirect()->to('/inventory')->with('error', 'Item not found.');
        }

        $inventoryHistoryModel->where('item_id', $id)->delete();

        if ($inventoryModel->delete($id)) {
            return redirect()->to('/inventory')->with('success', 'Item deleted successfully!');
        } else {
            return redirect()->to('/inventory')->with('error', 'Failed to delete item.');
        }
    }

    // New API method to get an item by its SKU
    public function get_by_sku($sku = null)
    {
        $inventoryModel = new InventoryModel();
        $item = $inventoryModel->where('sku', $sku)->first();

        if ($item === null) {
            return $this->response->setJSON(['status' => 'error', 'message' => 'Item not found']);
        }

        return $this->response->setJSON(['status' => 'success', 'data' => $item]);
    }
}
