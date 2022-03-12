<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserCreateRequest;
use App\Http\Requests\UserUpdateRequest;
use App\Http\Resources\UserResource;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpFoundation\Response;

class UserController extends Controller
{
    public function index()
    {
        // Gate::authorize('update', $post);
        // \Gate::authorize('view','users');
        if(Gate::allows('view','users')) {
            $user = User::paginate();
            Log::info("inside index method after gate allows line: ");
            return UserResource::collection($user);
        } else {
            return "You are not authorized to do this. Please look at the code.";
        }
    }

    public function show($id)
    {
        if(Gate::allows('view','users')) {
            $user = User::find($id);

            return new UserResource($user);
        } else {
            return "You are not authorized to do this. Please look at the code.";
        }
    }

    public function store(UserCreateRequest $request)
    {
        if(Gate::allows('edit','users')) {
            Log::info("request is".print_r($request->only('password'),true));
            $user = User::create($request->only('first_name','last_name','email','role_id') + [
                'password' => Hash::make(implode('',$request->only('password')))
            ]);

            return response(new UserResource($user), Response::HTTP_CREATED);

        } else {
            return "You are not authorized to do this. Please look at the code.";
        }
    }

    public function update(UserUpdateRequest $request, $id)
    {
        if(Gate::allows('edit','users')) {
            // Log::info("request is".print_r($request,true));
            $user = User::find($id);
            $user->update($request->only('first_name','last_name','email','role_id'));
            return response(new UserResource($user), Response::HTTP_ACCEPTED);
        } else {
            return "You are not authorized to do this. Please look at the code.";
        }
    }

    public function destroy($id)
    {
        if(Gate::allows('edit','users')) {

            User::destroy($id);

            return response(null, Response::HTTP_NO_CONTENT);
        } else {
            return "You are not authorized to do this. Please look at the code.";
        }
    }

    public function user()
    {
        $user = \Auth::user();
        return (new UserResource($user))->additional([
            "data" => [
                'permissions' => $user->permissions()
            ]
        ]);
    }

    public function updateInfo(Request $request)
    {
        $user = \Auth::user();
        $user->update($request->only('first_name','last_name','email'));
        return response(new UserResource($user), Response::HTTP_ACCEPTED);
    }

    public function updatePassword(Request $request)
    {
        $user = \Auth::user();

        $user->update([
            'password' => Hash::make($request->input('password'))
        ]);

        return response(new UserResource($user), Response::HTTP_ACCEPTED);
    }
}
