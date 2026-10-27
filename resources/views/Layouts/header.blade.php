<header>
    <nav class="navbar navbar-expand-lg navbar-light bg-white border-bottom">
        <div class="container">
            <a class="navbar-brand font-weight-bold text-primary" href="{{ route('post.index') }}">SENSIVE BLOG</a>
            
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#blogNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            
            <div class="collapse navbar-collapse" id="blogNav">
                <ul class="navbar-nav ml-auto">
                    <li class="nav-item active"><a class="nav-link" href="{{ route('post.index') }}">Trang chủ</a></li>
                    <li class="nav-item"><a class="nav-link" href="#">Tin tức</a></li>
                    <li class="nav-item"><a class="nav-link" href="#">Thời trang</a></li>
                    <li class="nav-item"><a class="nav-link" href="#">Du lịch</a></li>
                    <li class="nav-item"><a class="nav-link" href="#">Liên hệ</a></li>
                
                    @guest
                        <li class="nav-item ml-lg-3">
                            <a class="nav-link text-primary font-weight-bold" href="{{ route('login') }}">Đăng nhập</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link text-success font-weight-bold" href="{{ route('register') }}">Đăng ký</a>
                        </li>
                    @endguest

                    @auth
                        <li class="nav-item dropdown ml-lg-3">
                            <a class="nav-link dropdown-toggle text-primary font-weight-bold" href="#" id="userDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                Chào, {{ Auth::user()->name }}
                            </a>
                            <div class="dropdown-menu dropdown-menu-right" aria-labelledby="userDropdown">
                                <a class="dropdown-item" href="{{ route('post.create') }}">Viết bài mới</a>
                                <div class="dropdown-divider"></div>
                                
                                <form action="{{ route('logout') }}" method="POST">
                                    @csrf
                                    <button type="submit" class="dropdown-item text-danger" style="cursor: pointer;">Đăng xuất</button>
                                </form>
                            </div>
                        </li>
                    @endauth
                </ul>
            </div>
        </div>
    </nav>
</header>