<!-- resources/views/post_edit.blade.php -->

@extends('Layout.app')

@section('title', 'Edit Post')

@section('content')
    <h1>Edit Post</h1>
    <form action="{{ route('post.update', $post->id) }}" method="post">
        @csrf
        @method('PUT')
        <label>
            Author
            <select name="user_id" required>
                @foreach ($users as $user)
                    <option value="{{ $user->id }}" @selected(old('user_id', $post->user_id) == $user->id)>
                        {{ $user->name }}
                    </option>
                @endforeach
            </select>
        </label>
        <input type="text" name="title" placeholder="Title" value="{{ old('title', $post->title) }}" required>
        <textarea name="content" placeholder="Content" required>{{ old('content', $post->content) }}</textarea>
        <button type="submit">Update</button>
    </form>
    @include('components.validation-errors')
@endsection