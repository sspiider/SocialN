<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;

class PostController extends Controller
{
    /**
     * Returns the view for creating a new post.
     */
    public function showCreateForm(){
        return view('create-post');
    }


    /**
     * Handles the submission of a new post and redirects
     * the user to that post's page.
     */
    public function storeNNewPost(Request $request){

        $incommngFields = $request->validate([
            'title' => 'required',
            'body'=> 'required'
        ]);
        $incommngFields['title'] = strip_tags($incommngFields['title']);
        $incommngFields['body'] = strip_tags($incommngFields['body']);
        $incommngFields['user_id'] = auth()->id();

        $newPost = Post::create($incommngFields);
        return redirect("/post/{$newPost->id}");
    }

    /**
     * Displays a single post by its ID.
     *
     * -param Post $post
     * -return View --> single-post & table associative $post
     */
    public function viewSinglePost(Post $post){

        return view('single-post',['post' => $post]);
    }

    /**
     * Deletes a post by its ID, and redirects the user to
     * their profile page.
     *
     * -param Post $post
     * -return Redirect
     */
    public function delete(Post $post){

        $post->delete();
        return redirect('/profile/'. auth()->user()->username);
    }

    /**
     * Displays the edit form for a post, passing
     * the Post object to the edit-post view.
     *
     * -param Post $post
     * -return View --> edit-post, associative $post
     */
    public function showEditForm(Post $post){
        return view('edit-post',['post'=>$post]);
    }

    /**
     * Handles the submission of the edit form for a post,
     * and redirects the user to the same page.
     *
     * -param Post $post
     * -param Request $request
     * -traitment update()
     * -return Redirect
     */
    public function update(Post $post, Request $request){
        $incommngFields = $request->validate([
            'title' => 'required',
            'body'=> 'required'
        ]);
        $incommngFields['title'] = strip_tags($incommngFields['title']);
        $incommngFields['body'] = strip_tags($incommngFields['body']);

        $post->update($incommngFields);

        return back();
    }
}
