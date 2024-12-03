
@extends('layouts.app')
@section('title', '投稿詳細')
@section('content')
<div class="container">
    @if (session('flash_message'))
         <p class="text-success">{{ session('flash_message') }}</p>
    @endif                

    <div class="mb-2">    
        <a href="{{ route('posts.index') }}"class="text-decoration-none">&lt; 戻る</a>                              
    </div>

    <div class="card mb-3">
        <div class="card-body">
            <p class="card-text">投稿者：{{$post->user->name}}</p>
            <h2 class="card-title fs-5">{{ $post->title }}</h2>
            <p class="card-text">{{ $post->content }}</p>
            <p class="card-text">{{$post->created_at}}</p>

            <div class="d-flex">
                @if (Auth::id() === $post->user_id)
                    {{-- ログインユーザーのみ編集と削除を表示 --}}
                    <a href="{{ route('posts.edit', $post) }}" class="btn btn-outline-primary d-block me-1">編集</a>  
                
                    <form action="{{ route('posts.destroy', $post) }}" method="post">
                        @csrf
                        @method('delete')                                        
                            <button type="submit" class="btn btn-outline-danger">削除</button>
                    </form>
                @endif
            </div>
            @foreach($post->comments as $comment)
                    {{-- 親コメントを取得 --}}
                        <hr>
                        <p><strong>>{{ $comment->user->name }}</strong> {{ $comment->content }}</p>
                        <p>{{$comment->created_at->format('Y-m-d H:i') }}</p>

                        {{-- 返信がある場合は表示 --}}
                        {{-- @if ($comment->replies->isNotEmpty())
                            <div style="margin-left: 20px;">
                                @foreach($comment->replies as $reply)
                                    <hr>
                                    <p>>>{{ $reply->user->name }}: {{ $reply->content }}</p>
                                    <p>{{ $reply->created_at->format('Y-m-d H:i')  }}</p>
                                @endforeach
                            </div>
                        @endif --}}
            @endforeach


        </div>
    </div>                 
</div>
@endsection
      