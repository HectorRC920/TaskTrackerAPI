<?php
namespace App\Http\Controllers;

use App\Models\Project;
use Illuminate\Http\Request;
use App\Models\Task;
use Illuminate\Database\Eloquent\ModelNotFoundException;

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
    public function assign(Request $request)
    {
        try {
            $project = Project::findOrFail($request->projectId);
            $task = Task::findOrFail($request->taskId);
        } catch (\Throwable $th) {
            return response()->json([
                'error' => 'No se encontro el proyecto o tarea'
            ],404);
        }
        $task->project_id = $project->id;
        $task->save();
        return response()->json([
            $task,
        ]);
    }
    public function start($id)
    {
        //Check if usere tries to run more than one task
        $tasks_running = Task::where('running','=',1)->count();
        if($tasks_running > 1){
            return response()->json([
                'error' => 'Solo se puede tener una tarea con timer activo'
            ]);
        }

        try {
            // check if given task exists
            $task = Task::findOrFail($id);
            // check if given task is running
            if($task->running){
                return response()->json([
                    'error' => 'El timer de esta tarea ya esta corriendo',
                ]);
            }
        } catch (\Throwable $th) {
            return response()->json([
                'error' => 'La tarea no fue encontrada'
            ]);
        }
        $task->update([
            'elapsed_time' => 0,
            'running' => 1,
            'start_time' => time()
        ]);
        return response()->json([
            $task
        ],200);
    }
    public function stop($id)
    {
        try {
            // check if given task exists
            $task = Task::findOrFail($id);
            $start_time = $task->start_time;
            $current_time = time();
            $time_consumed_secs = $current_time - $start_time;
            // check if given task is not running
            if(!$task->running){
                return response()->json([
                    'error' => 'El timer de esta tarea ya esta parado',
                ]);
            }
        } catch (\Throwable $th) {
            return response()->json([
                'error' => 'La tarea no fue encontrada'
            ]);
        }
        $task->update([
            'elapsed_time' => $time_consumed_secs,
            'running' => 0,
            'start_time' => $start_time
        ]);
        return response()->json([
            $task
        ],200);

    }
}
