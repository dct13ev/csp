<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Log;

class CommentController extends Controller
{
    public function store(Request $request, $postId)
    {
        $validated = $request->validate([
            'content' => 'required|string|max:1000',
        ]);

        $comment = new Comment;
        $comment->post_id = $postId;
        $comment->user_id = auth()->id();
        $comment->content = $validated['content'];
        $comment->save();

        Log::channel('blog')->info('Bình luận mới được tạo.', [
            'comment_id' => $comment->id,
            'post_id' => $comment->post_id,
            'user_id' => $comment->user_id,
        ]);

        return back()->with('success', 'Đã gửi bình luận thành công!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Comment $comment)
    {
        Gate::authorize('delete', $comment);
        $comment->delete();

        Log::channel('blog')->info('Bình luận đã bị xóa.', [
            'comment_id' => $comment->id,
            'post_id' => $comment->post_id,
            'user_id' => auth()->id(),
        ]);

        return back()->with('success', 'Đã xóa bình luận!');
    }
}
