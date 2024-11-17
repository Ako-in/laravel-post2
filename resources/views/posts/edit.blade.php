@extends('layouts.app')
@section('title', '投稿編集')
@section('content')

  @if ($errors->any())
  <div class="alert alert-danger">
      <ul>
          @foreach ($errors->all() as $error)
              <li>{{ $error }}</li>
          @endforeach
      </ul>
  </div>  
  @endif

  <div class="mb-2">

    <a href="{{ route('posts.index') }}"class="text-decoration-none">&lt; 戻る</a>
  </div>

  

  <form action="{{ route('posts.update', $post) }}" method="POST">
      @csrf
      @method('PATCH')
      <div class="form-group mb-3">
          <label for="title">タイトル</label>
          <input type="text" id="title" name="title"  class="form-control" value="{{ old('title', $post->title) }}">
      </div>
      <div class="form-group mb-3">
          <label for="content">本文</label>
          <textarea id="content" name="content" class="form-control">{{ old('content', $post->content) }}</textarea>
      </div>
      <button type="submit"class="btn btn-outline-primary">更新</button>
  </form>
</div>
@endsection

