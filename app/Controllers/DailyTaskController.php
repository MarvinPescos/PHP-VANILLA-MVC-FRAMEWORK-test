<?php

namespace App\Controllers;

use App\Core\Auth;
use App\Core\Controller;
use App\Core\Input;
use App\Models\DailyTasks;
use App\Models\UserStats;
use App\Models\Activities;


class DailyTaskController extends Controller 
{

    protected $DailyTaskM;
    protected $UserStatsM;


    public function __construct(){
        $this->DailyTaskM = new DailyTasks();
        $this->UserStatsM = new UserStats();

    }

    public function index (){
        $currentUser = Auth::user();
        $dailyTasks = $this->DailyTaskM->getDailyTasksByUserId($currentUser['id']);

        return $this->view('dailyTask/index',[
            'title' => 'Daily Task',
            'dailyTasks' => $dailyTasks
        ]); 
    }

    public function create () {
        return $this->view('dailyTask/create', [
            'title' => 'Create Daily Tasks'
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

            $this->DailyTaskM->create($data);
            $this->redirect('/dailyTask/index');
    }

    public function edit ($id){
        $dailyTasks = $this->DailyTaskM->find($id);

        return $this->view('dailyTask/edit', [
            'title' => 'Edit Daily Tasks',
            'dailyTasks' => $dailyTasks
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

        $updated = $this->DailyTaskM->update($id, $data);

        if($updated){
            $_SESSION['success'] = 'Daily Task Updated Successfully';
            $this->redirect('/dailyTask/index');
        }else {
            $_SESSION['error'] = 'Failed to Update Daily Task';
            $this->redirect('/dailyTask/index');
        }
    }

    public function destroy ($id){
        $currentUser = Auth::user();
        $task = $this->DailyTaskM->find($id);
    
        // Check if task exists and belongs to current user
        if (!$task || $task['user_id'] !== $currentUser['id']) {
            $_SESSION['error'] = 'Unauthorized access!';
            $this->redirect('dailyTask/index');
            return;
        }
    
        $deleted = $this->DailyTaskM->delete($id);
    
        if ($deleted) {
            $_SESSION['success'] = 'Task deleted successfully!';
        } else {
            $_SESSION['error'] = 'Failed to delete task!';
        }
    
        $this->redirect('/dailyTask/index');
    }

    public function toggle($id) {
        $currentUser = Auth::user();
        $dailyTasks = $this->DailyTaskM->find($id);

        $newStatus = $dailyTasks['status'] === 'completed' ? 'pending' : 'completed';
        
        $updated = $this->DailyTaskM->update($id, [
            "status" => $newStatus,
            "user_id" => $currentUser['id']
        ]);

        if($updated){
            $_SESSION['success'] = 'Daily task updated!';
            if($newStatus === 'completed'){
                $xpRewards = [
                    'easy' => 10,
                    'medium' => 20,
                    'hard' => 30,
                ];

                $xpReward = $xpRewards[$dailyTasks['difficulty']] ;
                $user_id = $currentUser['id'];

                $this->UserStatsM->addXp($user_id, $xpReward);
            }
        }else{
                $_SESSION['error'] = 'Daily task failed to update!';
            }
                $this->redirect('/dailyTask/index');
        }
    }

?>
