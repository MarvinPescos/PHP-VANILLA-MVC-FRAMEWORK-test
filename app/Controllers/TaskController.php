<?php

// app/Controllers/UserController.php

namespace App\Controllers;

use App\Core\Controller;
use App\Core\Input;
use App\Models\Tasks;
use App\Models\UserStats;
use App\Models\Activities;

use function PHPUnit\Framework\isEmpty;

class TaskController extends Controller 
{

protected $TaskM;
protected $UserStatsM;

public function  __construct()
{
$this->TaskM = new Tasks();
$this->UserStatsM = new UserStats();
}

public function index()
{
 $tasks =$this->TaskM->all();
 $userStats = $this->UserStatsM->all();

 return $this->view('task/index', [
    'title' => 'tasks',
    'tasks' => $tasks,
    'userStats' => $userStats
 ]);

 }

 public function create(){
    return $this->view('task/create', [
        'title'=> 'create task'
    ]);
 }

 public function store () {
    $data = Input::sanitize([
        'title' => Input::post('title'),
        'status' => Input::post('status'),
        'difficulty' => Input::post('difficulty')
    ]);

    $this->TaskM->create($data);
    $this->redirect('task/index');
 }

 public function edit ($id){
    $task = $this->TaskM->find($id);

    return $this->view('task/edit', [
        'title' => 'Edit Task',
        'task' => $task
    ]);
 }

 public function update ($id){
    $data = Input::sanitize([
        'title' => Input::post('title'),
        'status' => Input::post('status'),
        'difficulty' => Input::post('difficulty')
    ]);

    $updated = $this->TaskM->update($id, $data);

    if($updated){
        $_SESSION['success'] = 'Task updated successfully!';
        $this->redirect('task/index');
    } else{
        $_SESSION['error'] = 'Failed to update task!';
        $this->redirect('task/index');
    }
 }

public function destroy ($id){
    $deleted =$this->TaskM->delete($id);

    if($deleted){
        $_SESSION['success'] = 'Task deleted successfully!';
        $this->redirect('task/index');
    } else{
        $_SESSION['error'] = 'Failed to delete task!';
        $this->redirect('task/index');
    }

}

public function toggle ($id){
    $task = $this->TaskM->find($id);

    $newStatus = $task['status'] === 'completed' ? 'pending' : 'completed';

    $updated = $this->TaskM->update($id, ['status' => $newStatus]);

    if($updated){
        $_SESSION['success'] = 'Task status updated!';
        if($newStatus === 'completed')
        {
            $xpRewards = [
                'easy' => 10,
                'medium' => 20,
                'hard' => 30,
            ];
            $xpReward = $xpRewards[$task['difficulty']];
            $user_id = $_SESSION['user_id'];

            $this->UserStatsM->addXp($user_id, $xpReward);
        }
    } else {
        $_SESSION['error'] = 'Failed to update task!';
    }

    $this->redirect('/task/index');

}

}


?>
