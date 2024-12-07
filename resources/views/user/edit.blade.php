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
                        <li class="breadcrumb-item"><a href="{{ route('user.index') }}">会員情報</a></li>
                        <li class="breadcrumb-item active" aria-current="page">会員情報編集</li>
                    </ol>
                </nav>

                <h1 class="mb-3 text-center">会員情報編集</h1>

                <hr class="mb-4">

                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul class="mb-0">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form method="POST" action="{{ route('user.update', $user) }}"method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <div class="form-group row mb-3">
                        <label for="name" class="col-md-5 col-form-label text-md-left fw-bold">
                            <div class="d-flex align-items-center">
                                <span class="me-1">氏名</span>
                                <span class="badge bg-danger">必須</span>
                            </div>
                        </label>

                        <div class="col-md-7">
                            <input type="text" class="form-control" id="name" name="name" value="{{ old('name', $user->name) }}" required autocomplete="name" autofocus placeholder="侍 太郎">
                        </div>
                    </div>
              
                    {{-- <div class="form-group row mb-3">
                        <label for="birthday" class="col-md-5 col-form-label text-md-left fw-bold">誕生日</label>

                        <div class="col-md-7">
                            <input type="text" class="form-control" id="birthday" name="birthday" value="{{ old('birthday', date('Ymd', strtotime($user->birthday))) }}" pattern="[0-9]{8}" title="誕生日は8桁の半角数字で入力してください。" maxlength="8" autocomplete="bday" placeholder="19950401">
                        </div>
                    </div> --}}

                    <div class="form-group row mb-3">
                        <label for="email" class="col-md-5 col-form-label text-md-left fw-bold">
                            <div class="d-flex align-items-center">
                                <span class="me-1">メールアドレス</span>
                                <span class="badge bg-danger">必須</span>
                            </div>
                        </label>

                        <div class="col-md-7">
                            <input type="email" class="form-control" id="email" name="email" value="{{ old('email', $user->email) }}" required autocomplete="email" placeholder="taro.samurai@example.com">
                        </div>
                    </div>

                    {{-- ユーザーアイコン更新 --}}
                    <div class="form-group row mb-3">
                        <label for="icon" class="col-md-5 col-form-label text-md-left fw-bold">ユーザーアイコン</label>

                        <div class="col-md-7">
                            @if ($user->icon)
                                <div class="mb-3">
                                    <img src="{{ asset('storage/images/' . basename($user->icon)) }}" alt="User Icon" class="img-thumbnail rounded-circle" width="100">
                                    {{-- <img src="{{ asset('storage/' . $user->icon) }}" alt="User Icon" class="rounded-circle" width="100"> --}}
                                </div>
                                
                            @endif

                          <input type="file" class="form-control" id="icon" name="icon" accept="image/*">
                        </div>
                    </div>
                    <hr class="my-4">

                    {{-- 自己紹介コメント --}}
                    <div class="form-group row mb-3">
                        <label for="comment" class="col-md-5 col-form-label text-md-left fw-bold">コメント</label>

                        <div class="col-md-7">
                            <textarea class="form-control" id="comment" name="comment" rows="3" placeholder="自己紹介やコメントを入力">{{ old('comment', $user->comment) }}</textarea>
                        </div>
                    </div>
                    {{-- パスワード変更 --}}
                    {{-- <div class="form-grouprow mb-3">
                        <label for="password" class="col-md-5 col-form-label text-md-left fw-bold">新しいパスワード</label>

                        <div class="col-md-7">
                            <input type="password" class="form-control" id="password" name="password" autocomplete="new-password" placeholder="8文字以上の半角英数字">
                        </div>
                    </div> --}}
                    <div class="form-group d-flex justify-content-center">
                        <button type="submit" class="btn shadow-sm w-50">更新</button>
                        
                    </div>
                </form>

            </div>
        </div>
    </div>
@endsection