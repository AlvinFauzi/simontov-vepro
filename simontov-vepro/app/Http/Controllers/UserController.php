<?php

namespace App\Http\Controllers;

use App\Http\Resources\UserResource;
use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Yajra\DataTables\DataTables;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if (auth()->user()->roles->pluck('name')[0] === 'superAdmin') {
            $query = UserResource::collection(User::all());
            $roles = Role::all();
        } else {
            $query = UserResource::collection(User::whereHas('roles', function ($q) {
                $q->where('name', '!=', 'superAdmin');
            })->get());
            $roles = Role::where('name', '!=', 'superAdmin')->get();
        }
        // return $query;
        if ($request->ajax()) {
            return DataTables::of($query)
                ->addIndexColumn()
                ->escapeColumns([])
                ->make(true);
        }
        $data = [
            'roles' => $roles,
        ];
        return view('user-list', $data);
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
            'name' => 'required|string|max:100',
            'email' => 'required|email|unique:users,email|max:100',
            'password' => ['required', 'string', 'min:8', 'confirmed'],
            'role' => 'required|exists:roles,id',
            'description' => 'required|string|max:200',
        ]);

        $user = new User();
        $user->name = $request->name;
        $user->email = $request->email;
        $user->password = Hash::make($request->password);
        $user->description = $request->description;
        $user->save();

        $user->assignRole($request->role);

        return response()->json([
            'status' => 200,
            'message' => trans('messages.success.save')
        ], 200);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function show(User $user)
    {
        return response()->json([
            'status' => 200,
            'data' => new UserResource($user),
        ], 200);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, User $user)
    {
        $request->validate([
            'name' => 'required|string|max:100',
            'email' => 'required|max:100|email|unique:users,email,' . $user->id,
            'password' => ['nullable', 'string', 'min:8', 'confirmed'],
            'role' => 'required|exists:roles,id',
            'description' => 'required|string|max:200',
        ]);

        $user->name = $request->name;
        $user->email = $request->email;
        if ($request->password != null) {
            $user->password = Hash::make($request->password);
        }
        $user->description = $request->description;
        $user->update();

        $user->syncRoles($request->role);

        return response()->json([
            'status' => 200,
            'message' => trans('messages.success.update')
        ], 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user)
    {
        $user->delete();
        return response()->json([
            'status' => 200,
            'message' => trans('messages.success.delete')
        ], 200);
    }
}
