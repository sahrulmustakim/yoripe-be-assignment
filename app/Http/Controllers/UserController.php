<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Http\Requests\UserRequest;
use Hash;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $this->authorize('crud-user');
        $user = User::all();
        return apiResponseSuccess($user);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(UserRequest $request)
    {
        $this->authorize('crud-user');
        $create = User::create($request->validated());
        return apiResponseSuccess($create);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update($id, Request $request)
    {
        $this->authorize('crud-user');
        $user = User::find($id);
        $user->name = $request->name;
        $user->email = $request->email;
        $user->role_id = $request->role_id;
        if ($request->password != null && $request->password != '') {
            $user->password = Hash::make($request->password);
        }
        $user->save();
        return apiResponseSuccess($user);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function delete(string $id)
    {
        $this->authorize('crud-user');
        $user = User::find($id);
        $user->delete();
        return apiResponseSuccess('User successfully deleted.');
    }
}
