<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Project;

class ProjectController extends Controller
{
    public function index()
    {
        $projects = Project::select('*');
        if (!$projects) {
            return response()->json([
                'error' => 'No hay proyectos creados',
            ], 404);
        } else {

            return response()->json([
                'items' => $projects,
                'count' => count($projects),
                'total' => count($projects),
            ], 200);
        }
    }
}
