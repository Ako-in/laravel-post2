@extends('layouts.app')

@section('content')
<div class="container">
    <div class="d-flex flex-column align-items-center">
      <h4 class="text-align-center">{{ $user->name }} さんのプロフィール</h4>
      <div>
        <p class="d-flex"><strong>自己紹介:</strong> {{ $user->comment }}</p>
        <div class="col">
            <strong>アイコン:</strong><br>
            @if ($user->icon)
              <img src="{{ asset('storage/images/' . basename($user->icon)) }}" alt="User Icon" class="img-thumbnail rounded-circle mb-4" width="100">
            @else
                <img src="{{ asset('storage/images/noimage.png') }}" alt="No User Icon" class="rounded-circle mb-4" width="100">
            @endif
        </div>
      </div>

      <ul class="nav nav-tabs">
        <li class="nav-item">
            <a class="nav-link active" id="posts-tab" data-bs-toggle="tab" href="#posts">投稿</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" id="comments-tab" data-bs-toggle="tab" href="#comments">コメント</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" id="likes-tab" data-bs-toggle="tab" href="#likes">いいね</a>
        </li>
    </ul>

    <div class="tab-content mt-3">
      <!-- 投稿タブ -->
      <div class="tab-pane fade show active" id="posts">
          @forelse ($posts as $post)
              <div class="card mb-3">
                  <div class="card-body">
                      <h2 class="card-title">{{ $post->title }}</h2>
                      <p>{{ Str::limit($post->content, 100, '...') }}</p>
                      <a href="{{ route('posts.show', $post) }}" class="btn btn-primary">詳細を見る</a>
                      <p>{{$post->created_at}}</p>
                  </div>
              </div>
          @empty
              <p>投稿はありません。</p>
          @endforelse
          {{ $posts->links() }}
      </div>

      <!-- コメントタブ -->
      <div class="tab-pane fade" id="comments">
          @forelse ($comments as $comment)
              <div class="card mb-3">
                  <div class="card-body">
                      <p>{{ $comment->content }}</p>
                      <small>投稿: <a href="{{ route('posts.show', $comment->post) }}">{{ $comment->post->title }}</a></small>
                      <p>{{$comment->created_at}}</p>
                  </div>
              </div>
          @empty
              <p>コメントはありません。</p>
          @endforelse
          {{ $comments->links() }}
      </div>

      <!-- いいねタブ -->
      <div class="tab-pane fade" id="likes">
          @forelse ($likes as $like)
              <div class="card mb-3">
                  <div class="card-body">
                      <h2 class="card-title">{{ $like->post->title }}</h2>
                      <p>{{ Str::limit($like->post->content, 100, '...') }}</p>
                      <a href="{{ route('posts.show', $like->post) }}" class="btn btn-primary">詳細を見る</a>
                      <p>{{$like->created_at}}</p>
                  </div>
              </div>
          @empty
              <p>いいねした投稿はありません。</p>
          @endforelse
          {{ $likes->links() }}
      </div>
    </div>
  </div>
@endsection
