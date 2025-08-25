<?php

namespace App\Models;

use CodeIgniter\Model;

class WarehouseLocationModel extends Model
{
    protected $table = 'warehouse_locations';
    protected $primaryKey = 'id';
    protected $allowedFields = ['location_code', 'aisle', 'shelf'];
    protected $useTimestamps = true;
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
}