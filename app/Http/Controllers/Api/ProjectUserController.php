<?php

namespace App\Http\Controllers\Api;

use App\Models\User;
use App\Models\Project;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Symfony\Component\HttpFoundation\Response as HttpResponse;

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
        if(DB::table('project_user')
                ->where('project_id', $projectId)
                ->where('user_id', $userId)
                ->doesntExist())
        {
            return response()->json([
                'error' => 'The user is not part of the project'
            ], $status = HttpResponse::HTTP_NOT_FOUND);
        }

        $projectUser = DB::table('project_user')
                ->where('project_id', $projectId)
                ->where('user_id', $userId)
                ->get();

        return response()->json([
            'data' => $projectUser
        ], $status = HttpResponse::HTTP_OK);
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

        return response()->json([
            'data' => $project
        ], $status = HttpResponse::HTTP_CREATED);
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
        if(DB::table('project_user')
                ->where('project_id', $projectId)
                ->where('user_id', $userId)
                ->doesntExist())
        {
            return response()->json([
                'error' => 'The user is not part of the project'
            ], $status = HttpResponse::HTTP_NOT_FOUND);
        }

        DB::table('project_user')
            ->where('project_id', $projectId)
            ->where('user_id', $userId)
            ->update(
                array("project_score" => $request->input('project_score'))
            );

        return response()->noContent();

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
        $project = Project::find($projectId);
        $user = User::find($userId);
        if(!$project || !$user) {
            return response()->json([
                'error' => 'The user is not part of the project'
            ], $status = HttpResponse::HTTP_NOT_FOUND);
        }

        $project->users()->detach($userId);

        return response()->noContent();

    }

}
