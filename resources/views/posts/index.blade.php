@extends('layouts.app')
@section('title', '投稿一覧')
@section('content')

@if (session('flash_message'))
    <p class="text-success">{{ session('flash_message') }}</p>
@endif

<div class="mb-2">
    <a href="{{ route('posts.create') }}" class="text-decoration-none btn btn-primary">新規投稿</a>                                   
</div>

@if($posts->isEmpty())
    <p>投稿がありません</p>
@else
<div class="container">
    <div class="row">
         @foreach($posts as $post)
        <div class="card mb-3 mt-3">
            <div class="card-body flex-start align-items-start">
                <!-- 左側の投稿情報 -->
                <div class="d-flex align-items-center mb-3">
                     {{-- 左アイコンのみ --}}
                    
                        {{-- 投稿者アイコンの表示 --}}
                        <div class="">
                            <a href="{{ route('user.show', $post->user) }}">
                                @if ($post->user->icon === null)
                                    <img src="{{ asset('storage/images/noimage.png') }}" alt="User Icon" class="img-thumbnail rounded-circle" width="60">
                                @else
                                    <img src="{{ asset('storage/images/' . basename($post->user->icon)) }}" alt="User Icon" class="img-thumbnail rounded-circle" width="60">
                                @endif
                            </a>
                        </div>
                        
                    {{-- 右側情報 --}}
                    <div class="ms-3">
                        <p>
                            <p>投稿者：
                                <a href="{{ route('user.show', $post->user->id) }}" class="text-decoration-none">
                                    {{$post->user->name}}
                                </a>
                            </p>
                        </p>
                        <small class="text-muted">{{$post->created_at->format('Y-m-d H:i') }}</small>
                    </div>
                    <!-- 右側　ログインユーザーの場合、編集削除ボタンを表示 -->
                    @if(Auth::id() === $post->user_id)
                        <div class="d-flex justify-content-end align-items-center w-100">
                            <a href="{{ route('posts.edit', $post) }}" class="btn btn-outline-primary me-1">編集</a>
                            <form action="{{ route('posts.destroy', $post) }}" method="post">
                                @csrf                                    
                                @method('delete')                                        
                                <button type="submit" class="btn btn-outline-danger">削除</button>
                            </form>    
                            <div class="dropdown">
                                
                                <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="dropdownMenuButton">
                                    {{-- 編集 --}}
                                    <li>
                                        <a href="{{ route('posts.edit', $post) }}" class="dropdown-item">編集</a>  
                                    </li>
                                    {{-- 削除 --}}
                                    <li>
                                        <form action="{{ route('posts.destroy', $post) }}" method="post" class="d-inline">
                                            @csrf
                                            @method('delete')                                        
                                            <button type="submit" class="dropdown-item text-danger">削除</button>
                                        </form>
                                   </li>
                                </ul>
                            </div>
                        </div>
                    @endif
            </div>

            <div class="card-body justify-content-between align-items-start">
                <h2 class="card-title fs-5">{{ $post->title }}</h2>
                @if (Str::length($post->content) > 100)
                    {{-- 100文字まで表示 --}}
                    <p class="card-text">{{ Str::limit($post->content, 100, '...') }}</p>
                    {{-- 詳細ボタン --}}
                    <a href="{{ route('posts.show', $post) }}" class="btn ms-auto">詳細を見る</a>
                @else
                    {{-- 内容が100文字以下の場合はそのまま表示 --}}
                    <p class="card-text">{{ $post->content }}</p>
                @endif
            </div>

            <!-- いいねボタンやコメントフォーム -->
            <div class="card-footer d-flex align-items-center pb-1">
                @if ($post->likes->where('user_id', auth()->id())->isNotEmpty())
                    <!-- いいね済み -->
                    <form action="{{ route('likes.destroy', $post) }}" method="post">
                        @csrf
                        @method('delete')
                        <button type="submit" class="btn">♡いいね済</button>
                        
                    </form>
                @else
                    <!-- 未いいね -->
                    <form action="{{ route('likes.store', $post) }}" method="post">
                        @csrf
                        <button type="submit" class="btn btn-primary">♡いいねする</button>
                    </form>
                @endif
                {{-- いいね数を表示 --}}
                <span class="ms-2">{{ $post->likes->count() }}件</span>
            </div>

           



            <div class="card-footer">
                <!-- コメントフォーム -->
                @auth
                    <form action="{{ route('comments.store', $post) }}" method="post">
                        @csrf
                        <textarea name="content" class="form-control mb-2" rows="2"></textarea>
                        <button type="submit" class="btn btn-primary">コメントを投稿</button>
                    </form>
                @endauth
                
                @if($post->comments->isEmpty())
                    <p class="mt-2">コメントはまだありません。</p>
                @else
                    <p class="mt-3">コメント一覧</p>
                    @foreach($post->comments as $comment)
                        {{-- 親コメントを取得 --}}
                        <p>
                            <a href="{{ route('users.show', $comment->user->id) }}" class="text-decoration-none">
                                >{{ $comment->user->name }}
                            </a>
                            {{ $comment->content }}
                        </p>
                        <p>{{$comment->created_at->format('Y-m-d H:i') }}</p>

                        {{-- 返信がある場合は表示 --}}
                        @if ($comment->replies->isNotEmpty())
                            <div style="margin-left: 20px;">
                                @foreach($comment->replies as $reply)
                                    <hr>
                                    <p>>>{{ $reply->user->name }}: {{ $reply->content }}</p>
                                    <p>{{ $reply->created_at->format('Y-m-d H:i')  }}</p>
                                @endforeach
                            </div>
                        @endif
                        {{-- 返信フォームは返信の一番最後に入れたい --}}
                        <form action="{{ route('comments.reply', $comment->id) }}" method="POST">
                            @csrf
                            <textarea name="content" class="form-control mb-2" rows="2" required></textarea>
                            <button type="submit" class="btn btn-outline-secondary">返信する</button>
                        </form>
                    @endforeach
                @endif
            </div> 
        </div>
    @endforeach
    </div>
   
</div>
     
@endif
<div class="d-flex justify-content-center">
    {{ $posts->links() }}
</div>
@endsection 



