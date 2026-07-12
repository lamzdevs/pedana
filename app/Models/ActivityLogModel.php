<?php

namespace App\Models;

use CodeIgniter\Model;

class ActivityLogModel extends Model
{
    protected $table            = 'activity_logs';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $allowedFields    = ['user_id', 'action', 'target_data', 'created_at'];

    // We can define a helper method to get logs with user info
    public function getLogsWithUsersPaginated($perPage = 10, $roleFilter = null)
    {
        $builder = $this->select('activity_logs.*, users.fullname, users.role')
                        ->join('users', 'users.id = activity_logs.user_id')
                        ->orderBy('activity_logs.created_at', 'DESC');
                        
        if ($roleFilter && $roleFilter !== 'all') {
            $builder->where('users.role', $roleFilter);
        }
        
        return $builder->paginate($perPage, 'logs');
    }
}
