<?php

namespace App\Http\Controllers\Api;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Symfony\Component\HttpFoundation\Response as HttpResponse;

class UserController extends Controller
{
     /**
     * Display the specified user with their projects.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $user = User::find($id)->with('projects')->get();
        if (!$user) {
            return response()->json([
                'error' => 'The user requested does not exist'
            ], $status = HttpResponse::HTTP_NOT_FOUND);
        }

        return response()->json([
            'data' => $user
        ], $status = HttpResponse::HTTP_OK);
    }
}
