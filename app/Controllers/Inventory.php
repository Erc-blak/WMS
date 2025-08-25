<?php namespace App\Controllers;

use App\Models\InventoryModel;
use CodeIgniter\Controller;

class Inventory extends Controller
{
    protected $inventoryModel;

    public function __construct()
    {
        $this->inventoryModel = new InventoryModel();
    }

    public function index()
    {
        $data['inventory'] = $this->inventoryModel->findAll();
        return view('inventory/list', $data);
    }

    public function create()
    {
        // Load the form and URL helpers needed for the view
        helper(['form', 'url']);
        
        $data = [];
        
        if ($this->request->getMethod() === 'post') {
            $rules = [
                'sku' => 'required|is_unique[inventory.sku]',
                'name' => 'required',
                'quantity' => 'required|integer',
            ];

            if ($this->validate($rules)) {
                $this->inventoryModel->save([
                    'sku' => $this->request->getPost('sku'),
                    'name' => $this->request->getPost('name'),
                    'quantity' => $this->request->getPost('quantity'),
                    'location' => $this->request->getPost('location'),
                ]);
                return redirect()->to('/inventory')->with('success', 'Item added successfully!');
            } else {
                $data['validation'] = $this->validator;
            }
        }
        
        // This is the view that contains the form, now with validation data
        return view('inventory/add', $data);
    }

    // You can add other methods like edit, update, delete, etc. here
}
