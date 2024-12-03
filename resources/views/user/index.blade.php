@extends('layouts.app')

@push('scripts')
    <script src="{{ asset('/js/reservation-modal.js') }}"></script>
@endpush

@section('content')
    <div class="container pb-5">
        <div class="row justify-content-center">
            <div class="col-xl-5 col-lg-6 col-md-8">
                <nav class="my-3" style="--bs-breadcrumb-divider: '>';" aria-label="breadcrumb">
                    <ol class="breadcrumb mb-0">
                        <li class="breadcrumb-item"><a href="{{ route('home') }}">ホーム</a></li>
                        <li class="breadcrumb-item active" aria-current="page">会員情報</li>
                    </ol>
                </nav>

                <h1 class="mb-3 text-center">会員情報</h1>

                <div class="d-flex justify-content-end align-items-end mb-3">
                    <div>
                        <a href="{{ route('user.edit',$user) }}">編集</a>
                        <form action="{{ route('user.destroy', $user) }}" method="post" class="d-inline">
                            @csrf
                            @method('delete')                                        
                            <button type="submit" class="dropdown-item text-danger">削除</button>
                        </form>
                        
                    </div>
                </div>

                @if (session('flash_message'))
                    <div class="alert alert-info" role="alert">
                        <p class="mb-0">{{ session('flash_message') }}</p>
                    </div>
                @endif

                @if (session('error_message'))
                    <div class="alert alert-danger" role="alert">
                        <p class="mb-0">{{ session('error_message') }}</p>
                    </div>
                @endif

                <div class="container mb-4">
                    <div class="row pb-2 mb-2 border-bottom">
                        <div class="col-3">
                            <span class="fw-bold">氏名</span>
                        </div>

                        <div class="col">
                            <span>{{ $user->name }}</span>
                        </div>
                    </div>

                    <div class="row pb-2 mb-2 border-bottom">
                        <div class="col-3">
                            <span class="fw-bold">メールアドレス</span>
                        </div>

                        <div class="col">
                            <span>{{ $user->email }}</span>
                        </div>
                    </div>
                    {{-- 設定したユーザーアイコン表示 --}}
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

                                {{-- <img src="{{ asset('storage/images/' . $user->icon) }}" alt="User Icon" class="img-thumbnail" width="100"> --}}
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection