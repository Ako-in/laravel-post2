@extends('layouts.app')

@section('content')
    <h1>トップ画面</h1>

    <div>
        <h2>通知一覧</h2>
        {{-- <ul>
            @forelse ($unreadNotifications as $notification)
                <li>
                    <p>{{ $notification->data['message'] }}</p>
                    <a href="{{ url('/posts/' . $notification->data['post_id']) }}">投稿を見る</a>
                    <a href="{{ route('notifications.read', $notification->id) }}">既読にする</a>
                </li>
            @empty
                <p>新しい通知はありません。</p>
            @endforelse
        </ul> --}}
        {{-- @if($notifications->isEmpty())
            <p>新しい通知はありません。</p>
        @else
            <ul class="list-group">
                @foreach($notifications as $notification)
                    <li class="list-group-item">
                        {{ $notification->data['message'] ?? '通知内容がありません。' }}
                        <small class="text-muted">{{ $notification->created_at->diffForHumans() }}</small>
                    </li>
                @endforeach
            </ul>
        @endif --}}
    </div>
@endsection
