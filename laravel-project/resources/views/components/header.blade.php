<header>
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark"> 
        <div class="collapse navbar-collapse  text-white" id="navbarSupportedContent" style="margin-left:100px;">

            <a class="navbar-brand" href="{{route('index')}}">たべにっき</a>
            <ul class="navbar-nav mr-auto" style="margin-top: 20px;">
            <li class="nav-item">
                <a class="nav-link" href="{{route('showContentRegistForm')}}">登録フォーム</a>
            </li>
                <li class="nav-item">
                <a class="nav-link" href="{{route('RagSearch')}}">RAG検索</a>
            </li>
            <li>
                <p class="nav-link">ユーザー：{{\Illuminate\Support\Facades\Auth::user()->name}}</p>
            </li>
            

            <!-- 記録検索(index画面のみ使用) -->
            @if(Request::is('index'))
                <li>
                    <form class="form-inline mx-2 my-2 my-lg-0" style="display: flex;gap:10px;" action={{route('SearchContent')}} method="POST">
                        @csrf
                        <input class="form-control mr-sm-2" type="text" name="SearchText" placeholder="Search" aria-label="Search"> 
                        <button class="btn btn-outline-success my-2 my-sm-0" type="submit">Search</button>
                    </form>
                </li>
            @endif
            <li class="nav-item">
                <a class="nav-link" href="{{route('user.logout')}}">ログアウト</a>
            </li>
            </ul>
        </div>
            
    </nav>
</header>