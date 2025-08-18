<?php

namespace App\Controllers;

use App\Models\WarehouseLocationModel;
use CodeIgniter\Controller;

class WarehouseLayout extends BaseController
{
    public function index()
    {
        $warehouseLocationModel = new WarehouseLocationModel();
        $data['locations'] = $warehouseLocationModel->findAll();

        return view('warehouse_layout/list', $data);
    }
    
    public function create()
    {
        return view('warehouse_layout/add');
    }

    public function save()
    {
        $warehouseLocationModel = new WarehouseLocationModel();

        $rules = [
            'location_code' => 'required|is_unique[warehouse_locations.location_code]|max_length[50]',
            'aisle' => 'required|max_length[50]',
            'shelf' => 'required|max_length[50]',
        ];

        if (! $this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $data = [
            'location_code' => $this->request->getPost('location_code'),
            'aisle' => $this->request->getPost('aisle'),
            'shelf' => $this->request->getPost('shelf'),
        ];
        
        if ($warehouseLocationModel->insert($data)) {
            return redirect()->to('/warehouse-layout')->with('success', 'Location added successfully!');
        } else {
            return redirect()->back()->withInput()->with('error', 'Failed to add location. Please try again.');
        }
    }

    // New method to display the edit form
    public function edit($id = null)
    {
        $warehouseLocationModel = new WarehouseLocationModel();
        $data['location'] = $warehouseLocationModel->find($id);

        if ($data['location'] === null) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        }

        return view('warehouse_layout/edit', $data);
    }

    // New method to handle the form submission for updating a location
    public function update($id = null)
    {
        $warehouseLocationModel = new WarehouseLocationModel();
        $location = $warehouseLocationModel->find($id);

        if ($location === null) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        }

        $rules = [
            'location_code' => 'required|max_length[50]',
            'aisle' => 'required|max_length[50]',
            'shelf' => 'required|max_length[50]',
        ];
        // Only apply the is_unique rule if the SKU has changed
        if ($this->request->getPost('location_code') !== $location['location_code']) {
            $rules['location_code'] .= '|is_unique[warehouse_locations.location_code]';
        }

        if (! $this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $data = [
            'location_code' => $this->request->getPost('location_code'),
            'aisle' => $this->request->getPost('aisle'),
            'shelf' => $this->request->getPost('shelf'),
        ];

        if ($warehouseLocationModel->update($id, $data)) {
            return redirect()->to('/warehouse-layout')->with('success', 'Location updated successfully!');
        } else {
            return redirect()->back()->withInput()->with('error', 'Failed to update location. Please try again.');
        }
    }

    // New method to handle the deletion of a location
    public function delete($id = null)
    {
        $warehouseLocationModel = new WarehouseLocationModel();
        $location = $warehouseLocationModel->find($id);

        if ($location === null) {
            return redirect()->to('/warehouse-layout')->with('error', 'Location not found.');
        }

        if ($warehouseLocationModel->delete($id)) {
            return redirect()->to('/warehouse-layout')->with('success', 'Location deleted successfully!');
        } else {
            return redirect()->to('/warehouse-layout')->with('error', 'Failed to delete location.');
        }
    }
}