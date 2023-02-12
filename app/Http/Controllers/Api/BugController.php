<?php

namespace App\Http\Controllers\Api;

use App\Models\Bug;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Symfony\Component\HttpFoundation\Response as HttpResponse;

class BugController extends Controller
{

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'bug_name' => 'required',
            'project_id' => 'required|exists:projects,id',
            'completed' => 'required|boolean',
            'completed_by' => 'string|nullable',
            'date_completed' => 'date|nullable',
        ]);

        $bug = Bug::create($request->all());

        return response()->json([
            'data' => $bug
        ], $status = HttpResponse::HTTP_CREATED);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $bug = Bug::find($id);
        if (!$bug) {
            return response()->json([
                'error' => 'The bug requested does not exist'
            ], $status = HttpResponse::HTTP_NOT_FOUND);
        }

        return response()->json([
            'data' => $bug
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
        $bug = Bug::find($id);
        if (!$bug) {
            return response()->json([
                'error' => 'The bug requested does not exist'
            ], $status = HttpResponse::HTTP_NOT_FOUND);
        }

        $request->validate([
            'project_id' => 'exists:projects,id',
            'completed' => 'boolean',
            'completed_by' => 'string',
            'date_completed' => 'date',
        ]);

        $bug->update($request->all());

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
        $bug = Bug::find($id);
        if (!$bug) {
            return response()->json([
                'error' => 'The bug requested does not exist'
            ], $status = HttpResponse::HTTP_NOT_FOUND);
        }

        $bug->delete();

        return response()->noContent();
    }
}
