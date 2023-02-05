<?php

namespace App\Http\Controllers\Api;

use App\Models\Project;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;

class ProjectUserController extends Controller
{
    /**
     *
     * Display the specified project_user row.
     *
     * @param  int  $projectId
     * @param  int  $userId
     * @return \Illuminate\Http\Response
     */
    public function show($projectId, $userId) {
        return DB::table('project_user')
                ->where('project_id', $projectId)
                ->where('user_id', $userId)
                ->get();
    }

    /**
     *
     * Adds a user to a project.
     *
     * @param  int  $projectId
     * @param  int  $userId
     * @return \Illuminate\Http\Response
     */
    public function store($projectId, $userId) {
        $project = Project::find($projectId);
        $project->users()->attach($userId, array('project_score' => 0));

        return response(200);
    }

    /**
     *
     * Updates the specified project_user row.
     *
     * @param  int  $projectId
     * @param  int  $userId
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function update($projectId, $userId, Request $request) {
        DB::table('project_user')
            ->where('project_id', $projectId)
            ->where('user_id', $userId)
            ->update(
                array("project_score" => $request->input('project_score'))
            );

        return response(200);

    }

    /**
     *
     * Deletes the specified project_user row.
     *
     * @param  int  $projectId
     * @param  int  $userId
     * @return \Illuminate\Http\Response
     */
    public function destroy($projectId, $userId) {
        DB::table('project_user')
            ->where('project_id', $projectId)
            ->where('user_id', $userId)
            ->delete();

        return response(200);

    }

}
