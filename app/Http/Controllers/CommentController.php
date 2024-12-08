<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Post;
use App\Models\user;
use App\Models\Comment;

class CommentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $comments = Comment::all();
        return view('posts.index', compact('comments'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, Post $post)
    {
        $request->validate([
            'content' => 'required|max:500',
        ]);

        $comment = new Comment();
        $comment->content = $request->content;
        $comment->user_id = auth()->id();
        $comment->post_id = $post->id;
        $comment->save();

        return redirect()->route('posts.show', $post)->with('flash_message', 'コメントを投稿しました。');
        // return back()->with('message', 'コメントしました');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Post $post)
    {
        $comments = $post->comments()->with('user', 'replies.user')->whereNull('parent_id')->get(); // 親コメントのみ
        return view('posts.index', compact('post', 'comments'));
        // $comment = Comment::findOrFail($id);
        // return view('posts.show', compact('comment'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    public function reply(Request $request, Comment $comment)
    {
        $request->validate([
            'content' => 'required|max:500',
        ]);

        $reply = new Comment();
        $reply->content = $request->input('content');
        $reply->user_id = auth()->id();
        $reply->post_id = $comment->post_id;// 元の投稿IDを継承
        $reply->parent_id = $comment->id;// 親コメントのIDを設定
        $reply->save();

        return redirect()->route('posts.show', $comment->post_id)->with('flash_message', '返信を投稿しました。');
        // return back()->with('message', '返信しました');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Comment $comment)
    {
        $this->authorize('delete', $comment);
        $comment->delete();

        return back()->with('message', 'コメントを削除しました');
    }

    public function addComment(Request $request)
    {
        // コメントの保存処理
        $comment = new Comment();
        $comment->content = $request->input('content');
        $comment->post_id = $postId;
        $comment->user_id = auth()->id();
        $comment->save();

        // 投稿者に通知を送信
        $postOwner = User::find($comment->post->user_id); // 投稿者を取得
        if ($postOwner) { // 投稿者が存在する場合のみ通知
            $postOwner->notify(new CommentLikedNotification('新しいコメントが追加されました！'));
        }

        return redirect()->route('posts.show', $postId)
                         ->with('flash_message', 'コメントを投稿しました！');
    }

}
