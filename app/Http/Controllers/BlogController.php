<?php

namespace App\Http\Controllers;

use App\Models\Blog;
use App\Http\Controllers\AuthorizeCheckController as AuthCheck;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BlogController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $blogs = Blog::latest()->paginate(10);

        if(!$blogs->count()){
            return response()->json([
                'status' => 1,
                'message' => "No blogs found"
            ], 200);
        }

        foreach ($blogs as $blog) {
            $blogsData[] = [
                'id' => $blog->id,
                'title' => $blog->title,
                'category' => $blog->category->category_name,
                'body' => $blog->body,
                'author' => $blog->user->name
            ];
        }

        return response()->json([
            'status' => 1,
            'blogs' => $blogsData,
        ]);
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
        return response()->json([
            "status" => 1,
            "title" => $blog->title,
            "body" => $blog->body,
            "category_name" => $blog->category->category_name,
            "author" => $blog->user->name
        ]);
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
    public function update(Request $request, $id)
    {
        $blog = Blog::find($id);
        $authCheck = new AuthCheck(); // alias of App\Http\Controllers\AuthorizeCheckController

        if($blog == null){
            return response()->json([
                "status" => 0,
                'message' => "Blog not found",
            ], 404);
        }

        else if (!$authCheck->isNotAuthor(Auth::user()->id, $blog->user_id)) {
            $blogData = $request->validate([
                'title' => 'required',
                'body' => 'required',
                'category_id' => 'required'
            ]);

            $blog->update($blogData);
        }

        return response()->json([
            "status" => 1,
            'message' => "Blog updated successfully",
            "data" => $blog
        ], 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $blog = Blog::find($id);
        $authCheck = new AuthCheck(); // alias of App\Http\Controllers\AuthorizeCheckController

        if($blog == null){
            return response()->json([
                "status" => 0,
                'message' => "Blog not found",
            ], 404);
        }

        else if (!$authCheck->isNotAuthor(Auth::user()->id, $blog->user_id)) {
            Blog::destroy($id);
        }

        return response()->json([
            "status" => 1,
            'message' => "Blog deleted successfully",
        ], 200);
    }
}
