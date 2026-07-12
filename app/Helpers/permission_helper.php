<?php

if (!function_exists('has_permission')) {
    function has_permission($feature)
    {
        $role = session()->get('role');
        if (!$role) return false;
        
        $db = \Config\Database::connect();
        $builder = $db->table('permissions');
        $builder->where('role', $role);
        $builder->where('feature', $feature);
        $builder->where('is_allowed', 1);
        return $builder->countAllResults() > 0;
    }
}
