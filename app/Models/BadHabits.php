<?php

namespace App\Models;

use App\Core\Model;
use App\Core\Auth;

class BadHabits Extends Model {

    protected static $table = 'badhabits';

    public function getBadHabitsByUserId($userId)
{
    return self::$db->query("SELECT * FROM badhabits WHERE user_id = ?")
        ->bind([1 => $userId])
        ->execute()
        ->fetchAll();
}

}