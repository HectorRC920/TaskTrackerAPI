<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Task extends Model{
    protected $table = "tasks";

    protected $fillable =
    ['name',
     'elapsed_time',
      'running',
      'start_time',
      'deleted',
      'project_id'];

    // public $timestamps = false;
}
