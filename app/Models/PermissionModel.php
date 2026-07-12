<?php

namespace App\Models;

use CodeIgniter\Model;

class PermissionModel extends Model
{
    protected $table            = 'permissions';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $allowedFields    = ['role', 'feature', 'is_allowed'];

    // Get all permissions organized by role
    public function getPermissionsMatrix()
    {
        $perms = $this->findAll();
        $matrix = [];
        foreach ($perms as $p) {
            $matrix[$p['feature']][$p['role']] = $p['is_allowed'] == 1;
        }
        return $matrix;
    }
}
