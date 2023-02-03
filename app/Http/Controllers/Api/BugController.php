<?php

namespace App\Http\Controllers\Api;

use App\Models\Bug;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

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
            'completed_by' => 'required|string|nullable',
            'date_completed' => 'required|date|nullable',
        ]);

        return Bug::create($request->all());
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return Bug::find($id);
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

        $request->validate([
            'project_id' => 'exists:projects,id',
            'completed' => 'boolean',
            'completed_by' => 'string|nullable',
            'date_completed' => 'date|nullable',
        ]);

        $bug->update($request->all());

        return $bug;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        return Bug::destroy($id);
    }
}
