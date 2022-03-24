<?php

namespace App\Http\Controllers;

use App\Http\Resources\RoleResource;
use Illuminate\Http\Request;
use App\Models\Role;
use Illuminate\Support\Facades\Gate;
// use Illuminate\Support\Facades\Response;
use Symfony\Component\HttpFoundation\Response;

class RoleController extends Controller
{

    public function index()
    {
        if(Gate::allows('view','roles')) {
            return RoleResource::collection(Role::all());
        } else {
            return "You are not authorized to do this. Please look at the code.";
        }
    }

    public function store(Request $request)
    {
        if(Gate::allows('edit','roles')) {
            $role = Role::create($request->only('name'));

            if($permissions = $request->input('permissions')) {
                foreach($permissions as $permission_id) {
                    \DB::table('role_permission')->insert([
                        'role_id' => $role->id,
                        'permission_id' => $permission_id,
                    ]);
                }
            }

            return response(new RoleResource($role), Response::HTTP_CREATED);
        } else {
            return "You are not authorized to do this. Please look at the code.";
        }

    }

    public function show($id)
    {
        if(Gate::allows('view','roles')) {
            return new RoleResource(Role::find($id));
        } else {
            return "You are not authorized to do this. Please look at the code.";
        }
    }

    public function update(Request $request, $id)
    {
        if(Gate::allows('edit','roles')) {
            $role = Role::find($id);

            $role->update($request->only('name'));

            \DB::table('role_permission')->where('role_id',$role->id)->delete();

            if($permissions = $request->input('permissions')) {
                foreach($permissions as $permission_id) {
                    \DB::table('role_permission')->insert([
                        'role_id' => $role->id,
                        'permission_id' => $permission_id,
                    ]);
                }
            }

            return response(new RoleResource($role), Response::HTTP_ACCEPTED);
        } else {
            return "You are not authorized to do this. Please look at the code.";
        }
    }

    public function destroy($id)
    {
        if(Gate::allows('edit','roles')) {
            \DB::table('role_permission')->where('role_id',$id)->delete();
            Role::destroy($id);

            return response(null, Response::HTTP_NO_CONTENT);
        } else {
            return "You are not authorized to do this. Please look at the code.";
        }
    }
}
