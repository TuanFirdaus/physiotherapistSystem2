<?php

namespace App\Models;

use CodeIgniter\Model;

class userActivityModel extends Model
{
    protected $table = 'useractivity';
    protected $primaryKey = 'activityId';
    protected $allowedFields = ['userId', 'activity', 'create_at', 'updated_at'];
    protected $useTimestamps = true;
    protected $createdField  = 'create_at';
    protected $updatedField  = 'updated_at';

    public function someAction()
    {
        $activityModel = new UserActivityModel();

        // Example data
        $userId = session()->get('userId'); // or however you track logged-in user
        $activity = 'You updated your appointment on June 5.';

        $activityModel->save([
            'userId' => $userId,
            'activity' => $activity
        ]);
    }
}
