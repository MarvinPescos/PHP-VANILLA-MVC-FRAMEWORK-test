<?php

namespace App\Models;

use App\Core\Model;

class DailyTasks extends Model {
    protected static $table = 'daily_tasks';

    public function getDailyTasksByUserId($userId) {
        return self::$db->query("SELECT * FROM daily_tasks WHERE user_id = ?")
            ->bind([1 => $userId])
            ->execute()
            ->fetchAll();
    }
    
}