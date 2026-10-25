<?php
class PostController extends Controller
{
    public function index(){
        $post = Post::all();
        return view('posts.index', ['post'=> $post]);
    }
}