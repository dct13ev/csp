<!-- resources/views/post_create.blade.php -->

@extends('Layout.app')

@section('title', 'Create Post')

@section('content')
    <h1>Create Post</h1>
    @foreach ($errors->all() as $error)
        <p> {{ $error }} </p>
    @endforeach
    <form action="{{ route('post.store') }}" method="post"  enctype="multipart/form-data"></form>
        @csrf
        <label>
            Author
            <select name="user_id" required>
                <option value="">Select an author</option>
                @foreach ($users as $user)
                    <option value="{{ $user->id }}" @selected(old('user_id') == $user->id)>
                        {{ $user->name }}
                    </option>
                @endforeach
            </select>
        </label>
        <input type="text" name="title" placeholder="Title" value="{{ old('title') }}" required>
        <textarea name="content" placeholder="Content" required>{{ old('content') }}</textarea>
        <button type="submit">Create</button>
    </form>
    @include('components.validation-errors')
    