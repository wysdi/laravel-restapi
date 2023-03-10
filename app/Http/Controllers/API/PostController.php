<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\API\BaseController as BaseController;
use App\Models\Post;
use App\Http\Resources\Blog as BlogResource;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class PostController extends BaseController
{
    public function index()
    {
        $user = auth()->user();
        if ($user->hasRole('user')) {
            $blogs = Post::where('user_id', $user->id)->get();
        } else {
            $blogs = Post::all();
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

        $blog = Post::create($input);

        return $this->sendResponse(new BlogResource($blog), 'Post created.');
    }

    public function show(Post $post)
    {
        if (is_null($post)) {
            return $this->sendError('Post does not exist.');
        }
        $user =Auth::user();
        if ($user->hasRole('user') && $post->user_id !== Auth::id()){
            return $this->sendError('You dont have access to view the post');
        }

        return $this->sendResponse(new BlogResource($post), 'Post fetched.');
    }

    public function update(Request $request, Post $post)
    {
        $user =Auth::user();
        if ($user->hasRole('user') && $post->user_id !== Auth::id()){
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
        $post->title = $input['title'];
        $post->description = $input['description'];
        $post->save();

        return $this->sendResponse(new BlogResource($post), 'Post updated.');
    }

    public function destroy(Post $post)
    {

        $user =Auth::user();
        if ($user->hasRole('user') && $post->user_id !== Auth::id()){
            return $this->sendError('You dont have access to delete this post');
        }

        $post->delete();
        return $this->sendResponse([], 'Post deleted.');
    }


}
