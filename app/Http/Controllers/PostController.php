<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post;
use App\Models\Comment;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\PostRequest;
use Illuminate\Support\Facades\Log;
use App\Notifications\CommentLikedNotification;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //一覧ページの表示
        // 投稿を取得（ページネーション付き）
        // $posts = Post::with('user')->latest()->paginate(3);
        // // $posts = Post::with('user')->latest()->paginate(3);
        // // $posts = Post::with('user', 'likes', 'comments.replies')->latest()->get();
        // // 親コメントを取得（parent_idがNULLのコメント）
        // // $comments = $posts->comments()->whereNull('parent_id')->get();
        // // すべての投稿に関連する親コメントを取得
        // $comments = Comment::whereIn('post_id', $posts->pluck('id')) // 各投稿の ID を取得
        // ->whereNull('parent_id')                // 親コメントのみ
        // ->get();
        // return view('posts.index',compact('posts','comments'));
        // 投稿データを取得（例: ページネーション）
        $posts = Post::with(['user', 'comments.replies', 'likes'])->latest()->paginate(3);
        $notifications = Auth::user()->notifications;

        // 通知を既読にする
        Auth::user()->unreadNotifications->markAsRead();

        // ビューにデータを渡す
        return view('posts.index', compact('posts','notifications'));
    }   

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //作成ページ
        return view('posts.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(PostRequest $request)
    {
        //詳細ページ
        // ユーザーがログインしているか確認
        // if (!auth()->check()) {
        //     return redirect()->route('login')->with('error', 'ログインしてください');
        // }

        //バリデーションPostRequestで行う為コメントアウト
        // $request->validate([
        //     'title' => 'required|max:20',
        //     'content' => 'required|max:255',
        // ]);
        $post = new Post();
        $post->title = $request->input('title');
        $post->content = $request->input('content');
        $post->user_id = auth()->id();
        //parent_idを入れる
        // $post->parent_id = $request->input('parent_id');
        $post->save();

        return redirect()->route('posts.index')->with('flash_message', '投稿が完了しました');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Post $post)
    {
        //詳細ページ
        // $post = Post::findOrFail($post->id);

        //コメントとその返信を取得
        // $comments = $post->comments()->with('user','replies.user')->get();
        // $comments = $post->comments()->whereNull('parent_id')->get();
        // Log::debug($comments);
        // ddd( $comments );
        // 親コメントを取得（parent_idがNULLのコメント）
        // $comments = $post->comments()->whereNull('parent_id')->get();

        // 親コメントを取得（parent_idがNULLのコメント）
        // $comments = $post->comments()->whereNull('parent_id')->with(['user', 'replies.user'])->get();
        // parent_idがNULLのコメント（親コメント）のみ取得
        $comments = $post->comments()
        ->whereNull('parent_id') // 返信コメントを除外
        ->with(['user', 'replies.user']) // ユーザー情報を取得
        ->get();
        // dd($comments);

        // $comments_replies = $post->comments()->whereNotNull('parent_id')->get();
        // var_dump($comments->toArray());
        return view('posts.show',compact('post','comments'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Post $post)
    {   
        //編集ページ// ログインユーザーが投稿の所有者であることを確認する
        $this->authorize('update', $post);

        return view('posts.edit',compact('post'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(PostRequest $request, Post $post)
    {
        //更新ページ
        // if ($post->user_id !== Auth::id()) {
        //     return redirect()->route('posts.index')->with('error_message', '不正なアクセスです。');
        // }
        // $request->validate([
        //     'title' => 'required|max:255',
        //     'content' => 'required',
        // ]);
        $post->title = $request->input('title');
        $post->content = $request->input('content');
        $post->save();

        return redirect()->route('posts.show',$post)->with('flash_message', '投稿が更新されました');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Post $post)
    {
        //削除ページ
        // ログインユーザーが投稿の所有者であることを確認する
        $this->authorize('delete', $post);
        $post->delete();
        return redirect()->route('posts.index')->with('flash_message', '投稿が削除されました');
    }

    // public function addComment(Request $request)
    // {
    //     // コメントの保存処理
    //     $comment = Comment::create($request->all());

    //     // 投稿者に通知を送信
    //     $postOwner = User::find($comment->post->user_id);
    //     $postOwner->notify(new CommentLikedNotification('あなたの投稿にコメントが追加されました！'));

    //     return redirect()->back();
    // }
    
}
