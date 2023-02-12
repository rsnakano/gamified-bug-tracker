<?php

namespace App\Http\Controllers\Api;

use App\Models\Project;
use Illuminate\Http\Request;
use GuzzleHttp\Handler\Proxy;
use App\Http\Controllers\Controller;
use App\Http\Resources\ProjectResource;
use Symfony\Component\HttpFoundation\Response as HttpResponse;

class ProjectController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $project = ProjectResource::collection(Project::all());

        return response()->json([
            'data' => $project
        ], $status = HttpResponse::HTTP_OK);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'slug' => 'required',
            'description' => 'max:100',
            'leader_id' => 'required|exists:users,id',
            'completed' => 'required|boolean'
        ]);

        $project = Project::create($request->all());

        return response()->json([
            'data' => $project
        ], $status = HttpResponse::HTTP_CREATED);
    }

    /**
     * Display the specified project with its bugs and users.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $project = Project::with('bugs', 'users')->find($id);
        if (!$project) {
            return response()->json([
                'error' => 'The project requested does not exist'
            ], $status = HttpResponse::HTTP_NOT_FOUND);
        }

        return response()->json([
            'data' => $project
        ], $status = HttpResponse::HTTP_OK);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $project = Project::find($id);
        if (!$project) {
            return response()->json([
                'error' => 'The project requested does not exist'
            ], $status = HttpResponse::HTTP_NOT_FOUND);
        }

        $request->validate([
            'description' => 'max:100',
            'leader_id' => 'exists:users,id',
        ]);

        $project->update($request->all());

        return response()->noContent();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $project = Project::find($id);
        if (!$project) {
            return response()->json([
                'error' => 'The project requested does not exist'
            ], $status = HttpResponse::HTTP_NOT_FOUND);
        }

        $project->delete();

        return response()->noContent();
    }

    /**
     * Search for a project name.
     *
     * @param  string  $name
     * @return \Illuminate\Http\Response
     */
    public function search($name)
    {
        $project = Project::where('name', 'like', '%'.$name.'%')->get();

        return response()->json([
            'data' => $project
        ], $status = HttpResponse::HTTP_OK);
    }

}
