@extends('layouts.app')

@section('content')


{{-- <div class="container mb-4">
  <div class="row pb-2 mb-2 border-bottom">
      <div class="col-3">
        <h4 class="text-align-center">{{ $user->name }} さんのプロフィール</h4>
      </div>
  </div>

  
  設定したユーザーアイコン表示
  <div class="row pb-2 mb-2 border-bottom">
      <div class="col-3">
          <span class="fw-bold">ユーザーアイコン</span>
      </div>
      @if ($user->icon === null)
          <div class="col">
              <img src="{{ asset('storage/images/' . (!empty($post->user->icon) ? $post->user->icon : 'noimage.png')) }}" alt="User Icon" class="img-thumbnail" width="50">
          </div>
      @else
          <div class="col">
              <img src="{{ asset('storage/images/' . basename($user->icon)) }}" alt="User Icon" class="img-thumbnail rounded-circle" width="100">
          </div>
      @endif
  </div>
  自己紹介
  <div class="row pb-2 mb-2 border-bottom">
      <div class="col-3">
          <span class="fw-bold">自己紹介</span>
      </div>

      <div class="col">
          <span>{{ $user->comment }}</span>
      </div>
  </div>
</div> --}}

<div class="container">
    <div class="d-flex flex-column align-items-center">
      <h4 class="text-align-center">
        @if ($user->icon)
        <img src="{{ asset('storage/images/' . basename($user->icon)) }}" alt="User Icon" class="img-thumbnail rounded-circle mb-4" width="80">
      @else
          <img src="{{ asset('storage/images/noimage.png') }}" alt="No User Icon" class="rounded-circle mb-4" width="80">
      @endif
        {{ $user->name }} 
        
        さんのページ</h4>
      {{-- <div>
        <div class="container">
          <div class="row border-bottom">
          <div class="d-flex col-md-6">
            <span class="fw-bold">自己紹介</span>
          </div>
          <div class="col-md-6">
            <span>{{ $user->comment }}</span>
          </div>

        </div>
      </div> --}}
        
        <p class="d-flex"><strong>自己紹介:</strong> {{ $user->comment }}</p>
        {{-- <div class="col">
            <strong>アイコン:</strong><br>
            @if ($user->icon)
              <img src="{{ asset('storage/images/' . basename($user->icon)) }}" alt="User Icon" class="img-thumbnail rounded-circle mb-4" width="100">
            @else
                <img src="{{ asset('storage/images/noimage.png') }}" alt="No User Icon" class="rounded-circle mb-4" width="100">
            @endif
        </div> --}}
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
        <div class="col row-cols-1 g-4">
          @forelse ($posts as $post)
              <div class="card mb-3">
                  <div class="card-body">
                      <h4 class="card-title">{{ $post->title }}</h4>
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
      </div>

      <!-- コメントタブ -->
      <div class="tab-pane fade" id="comments">
        <div class="col row-cols-1 g-4">
          @forelse ($comments as $comment)
              <div class="card mb-3">
                  <div class="card-body">
                      <p>{{ $comment->content }}</p>
                      <small><a href="{{ route('posts.show', $comment->post) }}">{{ $comment->post->title }}</a>へのコメント</small>
                      <p>{{$comment->created_at}}</p>
                  </div>
              </div>
          @empty
              <p>コメントはありません。</p>
          @endforelse
          {{ $comments->links() }}
        </div>
      </div>

      <!-- いいねタブ -->
      <div class="tab-pane fade" id="likes">
        <div class="row row-cols-1 g-4">
          @forelse ($likes as $like)
              <div class="card mb-3">
                  <div class="card-body">
                      <h4 class="card-title">{{ $like->post->title }}</h4>
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
  </div>
@endsection
