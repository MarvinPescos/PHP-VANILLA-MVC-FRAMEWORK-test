<?php

namespace App\Models;

use App\Core\Model;

class UserStats Extends Model {

    protected static $table = 'userstats';

    public function createUserStats(array $data)
    {
        return self::$db->query("INSERT INTO userStats (user_id, xp, level, hearts) VALUES (:user_id, :xp, :level, :hearts)")
            ->bind($data)
            ->execute();
    }

    public function getByUserId ($user_id){
        return self::$db->query("
        SELECT  userstats.id, userstats.xp, userstats.level, userstats.hearts
        FROM userstats
        INNER JOIN users ON users.id = userstats.user_id
        WHERE userstats.user_id = ? ")
        ->bind([1=>$user_id])
        ->execute()
        ->fetch();
    }

    public function addXp ($user_id, $xpReward){
        $userstats = $this->getByUserId($user_id);

        $newxp = $userstats['xp'] + $xpReward;
        $level = $userstats['level'];
        $xpThreshold = $userstats['level'] * 100;

        if($newxp >= $xpThreshold){
            $level++;
            $newxp -= $xpThreshold;
        }

        return $this->update($userstats['id'],[
            'xp' => $newxp,
            'level' => $level
        ]);

    }

}
?>