<?php

namespace App\Models;

use CodeIgniter\Model;

class InventoryHistoryModel extends Model
{
    protected $table = 'inventory_history';
    protected $primaryKey = 'id';
    protected $allowedFields = ['item_id', 'action', 'notes'];
    protected $useTimestamps = true;
    protected $createdField = 'created_at';
    protected $updatedField = null;
}