<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Task;

class TaskController extends Controller{
    public function index()
    {
        $tasks = Task::select('*');
        if(!$tasks){
            return response()->json([
                'error' => 'No hay tareas creadas'
            ],404);
        } else {
            return response()->json([
                'items' => $tasks,
                'count' => count($tasks),
                'count' => count($tasks),
            ],200);
        }
    }
}
