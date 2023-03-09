<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\API\BaseController as BaseController;
use App\Models\Blog;
use App\Http\Resources\Blog as BlogResource;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class BlogController extends BaseController
{
    public function index()
    {
        $user = auth()->user();

        if ($user->hasRole(['admin','manager'])) {
            $blogs = Blog::all();
        } else {
            $blogs = Blog::where('user_id', $user->id)->get();
        }
        return $this->sendResponse(BlogResource::collection($blogs), 'Posts fetched.');
    }

    public function store(Request $request)
    {
        $input = $request->all();
        $validator = Validator::make($input, [
            'title' => 'required',
            'description' => 'required',

        ]);
        if($validator->fails()){
            return $this->sendError($validator->errors());
        }

        $blog = Blog::create($input);

        return $this->sendResponse(new BlogResource($blog), 'Post created.');
    }

    public function show($id)
    {
        $blog = Blog::find($id);
        if (is_null($blog)) {
            return $this->sendError('Post does not exist.');
        }
        if ($blog->user_id !== Auth::id()){
            return $this->sendError('You dont have access to view the post');
        }

        return $this->sendResponse(new BlogResource($blog), 'Post fetched.');
    }

    public function update(Request $request, Blog $blog)
    {
        if ($blog->user_id !== Auth::id()){
            return $this->sendError('You dont have access to modify the  post');
        }

        $input = $request->all();
        $validator = Validator::make($input, [
            'title' => 'required',
            'description' => 'required'
        ]);
        if($validator->fails()){
            return $this->sendError($validator->errors());
        }
        $blog->title = $input['title'];
        $blog->description = $input['description'];
        $blog->save();

        return $this->sendResponse(new BlogResource($blog), 'Post updated.');
    }

    public function destroy(Blog $blog)
    {
        if ($blog->user_id !== Auth::id()){
            return $this->sendError('You dont have access to delete this post');
        }

        $blog->delete();
        return $this->sendResponse([], 'Post deleted.');
    }
}
