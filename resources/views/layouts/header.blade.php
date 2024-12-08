<!-- <header>
    <nav class="navbar navbar-light bg-light fixed-top" style="height: 60px;">            
        <div class="container">                               
            <a href="{{ route('posts.index') }}" class="navbar-brand">投稿アプリ</a>                     
        </div>
    </nav>
</header> -->


<header>
    <nav class="navbar navbar-expand-lg navbar-light bg-light fixed-top shadow-sm" style="height: 60px;">
        <div class="container-fluid">
            <!-- 左側のロゴ -->
            <a class="navbar-brand fw-bold" href="{{ route('posts.index') }}">投稿アプリ</a>

            <!-- トグルボタン（レスポンシブ対応） -->
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            <!-- ナビゲーションメニュー -->
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <!-- ホーム -->
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('home') }}">ホーム</a>
                    </li>
                    <!-- 会員情報 -->
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('user.index') }}">会員情報</a>
                    </li>
                    <!-- ログアウト -->
                    <li class="nav-item">
                        <a class="nav-link text-danger" href="{{ route('logout') }}" 
                           onclick="event.preventDefault(); document.getElementById('logout-form').submit();">ログアウト</a>
                        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                            @csrf
                        </form>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
</header>
