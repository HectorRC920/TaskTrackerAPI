<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Project extends Model{
    protected $table = "projects";

    protected $fillable = ['name','deleted'];

    // public $timestamps = false;
}
