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

    public function __construct(){
        $this->DailyTaskM = new DailyTasks();
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

    public function edit (){
        return $this->view('dailyTask/edit', [
            'title' => 'Edit Daily Tasks'
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


}
?>
