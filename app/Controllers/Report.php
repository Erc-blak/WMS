<?php

namespace App\Controllers;

use App\Models\InventoryHistoryModel;
use App\Models\InventoryModel;
use CodeIgniter\Controller;

class Report extends BaseController
{
    public function index()
    {
        $inventoryHistoryModel = new InventoryHistoryModel();
        $inventoryModel = new InventoryModel();

        $data['history'] = $inventoryHistoryModel
            ->select('inventory_history.*, inventory.name, inventory.sku')
            ->join('inventory', 'inventory.id = inventory_history.item_id')
            ->orderBy('inventory_history.created_at', 'DESC')
            ->findAll();

        return view('report/history_log', $data);
    }

    public function low_stock()
    {
        $inventoryModel = new InventoryModel();
        $data['low_stock_items'] = $inventoryModel->where('quantity <', 10)->findAll();

        return view('report/low_stock', $data);
    }

    // New method to export all inventory to a CSV file
    public function export_inventory_csv()
    {
        $inventoryModel = new InventoryModel();
        $items = $inventoryModel->findAll();

        // Prepare the CSV content
        $csv_file = fopen('php://temp', 'w');

        // Add CSV headers
        fputcsv($csv_file, ['ID', 'SKU', 'Name', 'Quantity', 'Location', 'Last Updated']);

        // Add data rows
        foreach ($items as $item) {
            fputcsv($csv_file, $item);
        }

        rewind($csv_file);
        $csv_content = stream_get_contents($csv_file);
        fclose($csv_file);

        // Send the file to the browser for download
        return $this->response
                    ->setHeader('Content-Type', 'text/csv')
                    ->setHeader('Content-Disposition', 'attachment; filename="inventory_report_' . date('Y-m-d') . '.csv"')
                    ->setBody($csv_content);
    }
}