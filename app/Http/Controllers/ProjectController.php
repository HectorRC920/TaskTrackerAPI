<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Project;

use function PHPUnit\Framework\isEmpty;

class ProjectController extends Controller
{
    public function index()
    {
        $projects = Project::select('*')->get();
        $projects_count = $projects->count();
        if (isEmpty($projects)) {
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
        ]);
    }
}
