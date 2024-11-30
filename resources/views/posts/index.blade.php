@extends('layouts.app')
@section('title', '投稿一覧')
@section('content')

@if (session('flash_message'))
    {{-- <p>{{ session('flash_message') }}</p> --}}
    <p class="text-success">{{ session('flash_message') }}</p>
@endif

<div class="mb-2">
    <a href="{{ route('posts.create') }}" class="text-decoration-none">新規投稿</a>                                   
</div>

@if($posts->isEmpty())
    <p>投稿がありません</p>
@else
    @foreach($posts as $post)
        <div class="card mb-3">
            <div class="card-body d-flex justify-content-between align-items-start">
                <!-- 左側の投稿情報 -->
                <div>
                    <p class="card-text">投稿者：{{$post->user->name}}</p>
                    <h2 class="card-title fs-5">{{ $post->title }}</h2>
                    <p class="card-text">{{ $post->content }}</p>
                    <p class="card-text">{{$post->created_at->format('Y-m-d H:i') }}</p>
                </div>

                <!-- 右側のケバブメニュー -->

                @if(Auth::id() === $post->user_id)
                    <div class="d-flex justify-content-end align-items-center">
                        <a href="{{ route('posts.edit', $post) }}" class="btn btn-outline-primary me-1">編集</a>
                        <form action="{{ route('posts.destroy', $post) }}" method="post">
                            @csrf
                            @method('delete')                                        
                            <button type="submit" class="btn btn-outline-danger">削除</button>
                        </form>    
                        <div class="dropdown">
                            {{-- <a href="#" class="btn p-2 kebab-menu" id="dropdownMenuButton" data-bs-toggle="dropdown" aria-expanded="false">
                                ⋮
                            </a> --}}
                            {{-- <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton" data-bs-toggle="dropdown" aria-expanded="false"> --}}
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

            <!-- いいねボタンやコメントフォーム -->
            <div class="card-body d-flex align-items-center">
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
            <div class="card-body">
                
                <!-- コメントフォーム -->
                @auth
                    <form action="{{ route('comments.store', $post) }}" method="post">
                        @csrf
                        <textarea name="content" class="form-control mb-2" rows="2"></textarea>
                        <button type="submit" class="btn btn-primary">コメントを投稿</button>
                    </form>
                @endauth
                <p>コメント一覧</p>
                @if($post->comments->isEmpty())
                    <p>コメントはまだありません。</p>
                @else
                    @foreach($post->comments as $comment)
                    {{-- 親コメントを取得 --}}
                        <hr>
                        <p><strong>>{{ $comment->user->name }}</strong> {{ $comment->content }}</p>
                        <p>{{$comment->created_at->format('Y-m-d H:i') }}</p>
                        {{-- {{ dd($comments) }} --}}
                        

                        <!-- 返信がある場合は表示 -->
                        @if ($comment->replies->isNotEmpty())
                            <div style="margin-left: 20px;">
                                @foreach($comment->replies as $reply)
                                    <hr>
                                    <p>>>{{ $reply->user->name }}: {{ $reply->content }}</p>
                                    <p>{{ $reply->created_at->format('Y-m-d H:i')  }}</p>
                                    {{-- <hr> --}}
                                @endforeach
                            </div>
                        @endif
                        <!-- 返信フォームは返信の一番最後に入れたい -->
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
@endif
<div class="d-flex justify-content-center">
    {{ $posts->links() }}
</div>
@endsection 



