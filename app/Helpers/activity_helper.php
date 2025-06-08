<?php

use App\Models\userActivityModel;

if (!function_exists('log_user_activity')) {
    function log_user_activity($userId, $message)
    {
        $model = new UserActivityModel();
        $model->save([
            'userId' => $userId,
            'activity' => $message
        ]);
    }
}
