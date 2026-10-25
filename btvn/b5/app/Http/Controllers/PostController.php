<?php
class PostController extends Controller
{
    public function index(){
        $post = Post::all();
        return view('posts.index', ['post'=> $post]);
    }
}

public function show($id){
    $post = post::select('id', 'title', 'content', 'created_at', 'updated_at')->where('id', $id)->first();
    return view('post_show', ['post' => $post]);
}

public function create(){
    return view('post_create');
}
public function store(Request $request){
    $post = new Post();
    $post->title = $request->input('title');
    $post->content = $request->input('content');
    $post->save();
    return redirect()->route('posts.index');
}

public function edit($id){
    $post = Post::seclect('id', 'title', 'content', 'created_at', 'updated_at')->where('id', $id)->first();
    return view('post_edit', ['post' => $post]);}