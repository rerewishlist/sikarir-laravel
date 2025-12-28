<?php

namespace App\Http\Controllers;

use App\Models\Forum;
use App\Models\Comment;
use Illuminate\Http\Request;

class CommentController extends Controller
{
    public function store(Request $request, Forum $forum)
    {
        $request->validate([
            'body' => 'required|string',
        ]);

        $comment = new Comment;
        $comment->forum_id = $forum->id;
        $comment->body = $request->body;

        if (auth()->user()->level == 'superadmin') {
            $comment->admin_id = auth()->id();
            $comment->save();
            return redirect()->route('admin.dataforum.detail', $forum->id);
        } else if (auth()->user()->level == 'admin') {
            $comment->admin_id = auth()->id();
            $comment->save();
            return redirect()->route('admin.dataforum.detail', $forum->id);
        } else if (auth()->user()->level == 'siswa') {
            $comment->user_id = auth()->id();
            $comment->save();
            return redirect()->route('user.dataforum.detail', $forum->id);
        }
    }
}
