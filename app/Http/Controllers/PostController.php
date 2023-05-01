<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post;
use App\Http\Requests\PostRequest;
use Illuminate\Support\Facades\Auth;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try {
            $user = Auth::user();
            if ($user->role_id == 1 || $user->role_id == 2) {
                $post = Post::with('user')->get();
                return apiResponseSuccess($post);
            }else if ($user->role_id == 3) {
                $post = Post::with('user')->where('user_id', $user->id)->get();
                return apiResponseSuccess($post);
            }else{
                return apiResponseFailed('Invalid Role User.');
            }
        } catch (\Throwable $th) {
            return apiResponseFailed('Invalid Credentials.');
        }
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(PostRequest $request)
    {
        try {
            $user = Auth::user();
            $create = Post::create($request->validated());
            return apiResponseSuccess($create);
        } catch (\Throwable $th) {
            return apiResponseFailed('Invalid Credentials.');
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(PostRequest $request, string $id)
    {
        try {
            $user = Auth::user();
            if ($user->role_id == 1 || $user->role_id == 2) {
                $post = Post::find($id)->update($request->validated());
                $returndata = Post::with('user')->find($id);
                return apiResponseSuccess($returndata);
            }else if ($user->role_id == 3) {
                $cekdata = Post::with('user')->find($id);
                if ($cekdata->user_id == $user->id) {
                    $post = Post::find($id)->update($request->validated());
                    $returndata = Post::with('user')->find($id);
                    return apiResponseSuccess($returndata);
                }else{
                    return apiResponseFailed('Sorry, This post is not belongs to you.');
                }
            }else{
                return apiResponseFailed('Sorry, Invalid Role User.');
            }
        } catch (\Throwable $th) {
            return apiResponseFailed('Sorry, Invalid Credentials.');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function delete(string $id)
    {
        try {
            $user = Auth::user();
            if ($user->role_id == 1 || $user->role_id == 2) {
                $post = Post::find($id)->delete();
                return apiResponseSuccess('Post successfully deleted.');
            }else if ($user->role_id == 3) {
                $cekdata = Post::find($id);
                if ($cekdata->user_id == $user->id) {
                    $post = Post::find($id)->delete();
                    return apiResponseSuccess('Post successfully deleted.');
                }else{
                    return apiResponseFailed('Sorry, This post is not belongs to you.');
                }
            }else{
                return apiResponseFailed('Sorry, Invalid Role User.');
            }
        } catch (\Throwable $th) {
            return apiResponseFailed('Sorry, Invalid Credentials.');
        }
    }
}
