<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Task;

class TaskController extends Controller{
    public function index()
    {
        $tasks = Task::select('*')->get();
        $task_count = $tasks->count();
        if(!$tasks){
            return response()->json([
                'error' => 'No hay tareas creadas'
            ],404);
        } else {
            return response()->json([
                'items' => $tasks,
                'total' => $task_count,
                'count' => $task_count,
            ],200);
        }
    }
    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required|unique:tasks',
        ],[
            'name.unique' => 'El nombre ya esta tomado',
            'name.required' => 'El nombre es requerido'
        ]);
        $task = Task::create([
            'name' => $request->name,
            'deleted' => 0,
        ]);
        return response()->json([
            'id' => $task->id,
            'name' => $task->name,
        ],200);
    }
}
