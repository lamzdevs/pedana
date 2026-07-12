<?php

if (!function_exists('log_activity')) {
    function log_activity($action, $targetData = '')
    {
        if (session()->has('id')) {
            $logModel = new \App\Models\ActivityLogModel();
            $logModel->insert([
                'user_id' => session()->get('id'),
                'action' => $action,
                'target_data' => $targetData,
                'created_at' => date('Y-m-d H:i:s')
            ]);
        }
    }
}
