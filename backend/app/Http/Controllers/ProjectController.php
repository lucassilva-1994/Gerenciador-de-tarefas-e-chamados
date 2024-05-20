<?php

namespace App\Http\Controllers;

use App\Helpers\HelperModel;
use App\Http\Requests\ProjectRequest;
use App\Models\Project;

class ProjectController extends Controller
{
    use HelperModel;
    public function showAll(){
        return Project::all();
    }

    public function showById(Project $project){
        return $project;
    }

    public function create(ProjectRequest $request){
        return self::setData($request->all(), Project::class);
    }

    public function update(ProjectRequest $request, Project $project){
        return self::updateData($request->all(), Project::class,['id' => $project->id]);
    }

    public function delete(Project $project){
        return self::setStatusDeleted(Project::class,['id' => $project->id]);
    }
}
