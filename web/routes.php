<?php

use App\Controllers\HomeController;
use App\Controllers\UserController;
use App\Controllers\AuthController;
use App\Middleware\AuthMiddleware;
use App\Controllers\TaskController;
use App\Controllers\DailyTaskController;



  // Define routes
  $router->get('/', [HomeController::class, 'index']);
  $router->get('/about', [HomeController::class, 'about']);
  
  // Auth routes
  $router->get('/login', [AuthController::class, 'index']);
  $router->post('/login', [AuthController::class, 'login']);
  $router->get('/logout', [AuthController::class, 'logout'], [AuthMiddleware::class]);
  $router->get('/register', [AuthController::class, 'register']);
  $router->post('/register', [AuthController::class, 'store']);
  
  
  // User routes
  $router->get('/contact', [HomeController::class, 'contact'], [AuthMiddleware::class]);
  $router->get('/users', [UserController::class, 'index'], [AuthMiddleware::class]);
  $router->get('/users/create', [UserController::class, 'create'], [AuthMiddleware::class]);
  $router->post('/users', [UserController::class, 'store'], [AuthMiddleware::class]);
  $router->get('/users/{id}', [UserController::class, 'show'], [AuthMiddleware::class]);
  $router->get('/users/{id}/edit', [UserController::class, 'edit'], [AuthMiddleware::class]);
  $router->put('/users/{id}', [UserController::class, 'update'], [AuthMiddleware::class]);
  $router->delete('/users/{id}', [UserController::class, 'destroy'], [AuthMiddleware::class]);


  //task routes
  $router->get('/task/index',[TaskController::class, 'index'], [AuthMiddleware::class]);
  $router->get('/task/create', [TaskController::class, 'create'], [AuthMiddleware::class]);
  $router->post('/tasks', [TaskController::class, 'store'], [AuthMiddleware::class]);
  $router->get('/task/{id}/edit', [TaskController::class, 'edit'], [AuthMiddleware::class]);
  $router->put('/task/{id}', [TaskController::class, 'update'], [AuthMiddleware::class]);
  $router->delete('/task/{id}/delete', [TaskController::class, 'destroy'], [AuthMiddleware::class]);
  $router->post('/task/{id}/toggle', [TaskController::class, 'toggle'], [AuthMiddleware::class]);

   //Daily task routes
   $router->get('/dailyTask/index',[DailyTaskController::class, 'index'], [AuthMiddleware::class]);
   $router->get('/dailyTask/create', [DailyTaskController::class, 'create'], [AuthMiddleware::class]);
   $router->post('/dailyTask', [DailyTaskController::class, 'store'], [AuthMiddleware::class]);
   $router->get('/dailyTask/{id}/edit', [DailyTaskController::class, 'edit'], [AuthMiddleware::class]);
   $router->put('/dailyTask/{id}', [DailyTaskController::class, 'update'], [AuthMiddleware::class]);
   $router->delete('/dailyTask/{id}/delete', [DailyTaskController::class, 'destroy'], [AuthMiddleware::class]);
   $router->post('/dailyTask/{id}/toggle', [DailyTaskController::class, 'toggle'], [AuthMiddleware::class]);

