<?php

namespace App\Http\Controllers;

use App\Models\Blog;
use App\Models\Sanctum\PersonalAccessToken;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BlogController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // $blogs = Blog::latest()->paginate(10);
        $blogs = Blog::first()->paginate(10);
        foreach ($blogs as $blog) {
            // $blog = Blog::all();
            return [
                "status" => 1,
                "title" => $blog->title,
                "body" => $blog->body,
                "category_name" => $blog->category->category_name,
                "author" => $blog->user->name
            ];
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
    public function store(Request $request)
    {
        $blogData = $request->validate([
            'title' => 'required',
            'body' => 'required',
            // 'user_id' => 'required',
            'category_id' => 'required'
        ]);

        $blogData['user_id'] = Auth::user()->id;
        $blog = Blog::create($blogData);
        return [
            "status" => 1,
            "data" => $blog,
            // "category" => $blog->category->
        ];
    }

    /**
     * Display the specified resource.
     */
    public function show(Blog $blog)
    {
        return [
            "status" => 1,
            "data" => $blog,
            "category_name" => $blog->category->category_name,
            "author" => $blog->user->name
        ];
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
    public function update(Request $request, PersonalAccessToken $token)
    {
        $blogData = $request->validate([
            'title' => 'required',
            'body' => 'required',
            'category_id' => 'required'
        ]);

        $blogs = Blog::all();

        foreach ($blogs as $blog) {
            if ($blog->user->name === Auth::user()->name) {
                $blog->update($blogData);
                return [
                    "status" => 1,
                    "data" => $blog,
                    "message" => "Blog updated successfully"
                ];
            } else {
                return response()->json([
                    "warning" => "You're not the author or the post doesn't exist"
                ], 401);
            }
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $blogs = Blog::all();

        foreach ($blogs as $blog) {
            if ($blog->user->name === Auth::user()->name) {
                return Blog::destroy($id);
            } else {
                return response()->json([
                    "warning" => "You're not the author or the post doesn't exist"
                ], 401);
            }
        }
    }
}
