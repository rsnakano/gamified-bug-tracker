<?php

namespace App\Http\Controllers\Api;

use App\Models\Project;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ProjectController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return Project::all();
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
            'completed' => 'required'
        ]);

        return Project::create($request->all());
    }

    /**
     * Display the specified project with its bugs.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return Project::find($id)->with('bugs')->get();
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

        $request->validate([
            'description' => 'max:100',
            'leader_id' => 'exists:users,id',
        ]);

        $project->update($request->all());

        return $project;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        return Project::destroy($id);
    }

    /**
     * Search for a project name.
     *
     * @param  string  $name
     * @return \Illuminate\Http\Response
     */
    public function search($name)
    {
        return Project::where('name', 'like', '%'.$name.'%')->get();
    }

    /**
     * PROBABLY NOT NEEDED
     *
     * Shows all bugs for a project.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function bugs($id)
    {
        return Project::find($id)->bugs;
    }


}
