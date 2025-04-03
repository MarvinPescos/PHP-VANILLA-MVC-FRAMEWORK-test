<?php

// app/Controllers/UserController.php

namespace App\Controllers;

use App\Core\Auth;
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
    $currentUser = Auth::user();
    $tasks = $this->TaskM->getTasksByUserId($currentUser['id']); // Get only current user's tasks
    $userStats = $this->UserStatsM->getByUserId($currentUser['id']);

 return $this->view('task/index', [
    'title' => 'tasks',
    'tasks' => $tasks,
    'userStats' => $userStats,
    'currentUser' => $currentUser
 ]);

 }

 public function create(){
    return $this->view('task/create', [
        'title'=> 'create task'
    ]);
 }

 public function store () {
    $currentUser = Auth::user();
    $data = Input::sanitize([
        'title' => Input::post('title'),
        'status' => Input::post('status'),
        'difficulty' => Input::post('difficulty'),
        'user_id' => $currentUser['id']
    
    ]);

    $this->TaskM->create($data);
    $this->redirect('/task/index');
 }

 public function edit ($id){
    $task = $this->TaskM->find($id);

    return $this->view('/task/edit', [
        'title' => 'Edit Task',
        'task' => $task
    ]);
 }

 public function update ($id){
    $currentUser = Auth::user();
    $data = Input::sanitize([
        'title' => Input::post('title'),
        'status' => Input::post('status'),
        'difficulty' => Input::post('difficulty'),
        'user_id' => $currentUser['id']

    ]);

    $updated = $this->TaskM->update($id, $data);
    
    if($updated){
        $_SESSION['success'] = 'Task updated successfully!';
        $this->redirect('/task/index');
    } else{
        $_SESSION['error'] = 'Failed to update task!';
        $this->redirect('/task/index');
    }
 }

 public function destroy($id) {
    $currentUser = Auth::user();
    $task = $this->TaskM->find($id);

    // Check if task exists and belongs to current user
    if (!$task || $task['user_id'] !== $currentUser['id']) {
        $_SESSION['error'] = 'Unauthorized access!';
        $this->redirect('task/index');
        return;
    }

    $deleted = $this->TaskM->delete($id);

    if ($deleted) {
        $_SESSION['success'] = 'Task deleted successfully!';
    } else {
        $_SESSION['error'] = 'Failed to delete task!';
    }

    $this->redirect('/task/index');
}

public function toggle ($id){
    $currentUser = Auth::user();
    $task = $this->TaskM->find($id);

    $newStatus = $task['status'] === 'completed' ? 'pending' : 'completed';

    $updated = $this->TaskM->update($id, [
        'status' => $newStatus,
        'user_id' => $currentUser['id']
    ]);

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
            $user_id = $currentUser['id'];

            $this->UserStatsM->addXp($user_id, $xpReward);
        }
    } else {
        $_SESSION['error'] = 'Failed to update task!';
    }

    $this->redirect('/task/index');

}

}


?>
