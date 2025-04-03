<?php

namespace App\Models;

use App\Core\Model;

class DailyTasks extends Model {
    protected static $table = 'dailytasks';

    public function getDailyTasksByUserId($userId) {
        return self::$db->query("SELECT * FROM dailytasks WHERE user_id = ?")
            ->bind([1 => $userId])
            ->execute()
            ->fetchAll();
    }

    public function resetDailyTasks(){
        return self::$db->query("
        UPDATE dailytasks 
        SET status = 'pending', last_reset = CURRENT_TIMESTAMP
        WHERE TIMESTAMPDIFF(HOUR, last_reset, CURRENT_TIMESTAMP) >= 24")
        ->execute();
    }
    
}