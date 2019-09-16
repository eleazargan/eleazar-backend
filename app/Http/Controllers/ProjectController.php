<?php

namespace App\Http\Controllers;

use App\Repositories\Project;
use Illuminate\Http\Request;

class ProjectController extends Controller
{
    private $project;

    public function __construct(Project $project)
    {
        $this->project = $project;
    }

    public function get(Request $request)
    {
        $response = $this->project->get($request->input());

        return $response->json();
    }

    public function getById($projectId)
    {
        $response = $this->project->getById($projectId);

        return $response->json();
    }

    public function create(Request $request)
    {
        $response = $this->project->create($request->all());

        return $response->json();
    }

    public function update(Request $request, $projectId)
    {
        $response = $this->project->update($projectId, $request->all());

        return $response->json();
    }

    public function delete($projectId)
    {
        $response = $this->project->delete($projectId);

        return $response->json();
    }
}
