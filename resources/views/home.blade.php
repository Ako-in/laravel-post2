@extends('layouts.app')

@section('content')
    <h1>トップ画面</h1>

    <div>
        <h2>通知</h2>
        <ul>
            @forelse ($unreadNotifications as $notification)
                <li>
                    <p>{{ $notification->data['message'] }}</p>
                    <a href="{{ url('/posts/' . $notification->data['post_id']) }}">投稿を見る</a>
                    <a href="{{ route('notifications.read', $notification->id) }}">既読にする</a>
                </li>
            @empty
                <p>新しい通知はありません。</p>
            @endforelse
        </ul>
    </div>
@endsection
