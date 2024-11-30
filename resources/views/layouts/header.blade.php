<!-- <header>
    <nav class="navbar navbar-light bg-light fixed-top" style="height: 60px;">            
        <div class="container">                               
            <a href="{{ route('posts.index') }}" class="navbar-brand">投稿アプリ</a>                     
        </div>
    </nav>
</header> -->

<header>
        <nav class="navbar navbar-light bg-light fixed-top" style="height: 60px;">
        {{-- <nav> --}}
            <a href="{{ route('posts.index') }}">投稿アプリ</a>

            <ul>
                <li>
                    <a href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">ログアウト</a>
                    <form id="logout-form" action="{{ route('logout') }}" method="POST">
                        @csrf
                    </form>
                </li>
            </ul>
        </nav>
</header>
