<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Project;
use App\Models\Task;

use function PHPUnit\Framework\isEmpty;

class ProjectController extends Controller
{
    public function index()
    {
        $projects = Project::select('*')->get();
        $projects_count = $projects->count();
        if ($projects_count <= 0) {
            return response()->json([
                'error' => 'No hay proyectos creados',
            ], 404);
        } else {
            return response()->json([
                'items' => $projects,
                'total' => $projects_count,
                'count' => $projects_count,
            ], 200);
        }
    }
    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required|unique:projects',
        ],[
            'name.unique' => 'El nombre ya esta tomado',
            'name.required' => 'El nombre es requerido'
        ]);

        $project = Project::create([
            'name' => $request->name,
            'deleted' => 0,
        ]);
        return response()->json([
            $project,
        ],201);
    }
    public function report(Request $request)
    {
        $projectId = $request->id;
        $projectTasks = Task::where('project_id','=',$projectId)->get();
        $total_time = 0;
        foreach ($projectTasks as $task) {
            $total_time += $task->elapsed_time;
        }
        return response()->json([
            'tasks' => $projectTasks,
            'total_time' => $total_time
        ]);
    }
    public function delete(Request $request)
    {
        $projectId = $request->id;
        try {
            $project = Project::findOrFail($projectId);
            if($project->deleted){
                return response()->json([
                    'error' => 'El projecto ya esta eliminado'
                ]);
            }
            $project->update([
                'deleted' => 1
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                'error' => 'Projecto no eliminado'
            ]);
        }
        return response()->json([
            $project
        ]);
    }
}
