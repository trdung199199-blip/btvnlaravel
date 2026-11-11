<header>
    <nav class="navbar navbar-expand-lg navbar-light bg-white border-bottom">
        <div class="container">
            <a class="navbar-brand font-weight-bold text-primary" href="{{ route('post.index') }}">SENSIVE BLOG</a>
            
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#blogNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            
            <div class="collapse navbar-collapse" id="blogNav">
                <ul class="navbar-nav ml-auto">
                    <li class="nav-item active">
                        <a class="nav-link" href="{{ route('post.index') }}">Trang chủ</a>
                    </li>

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
                                @can('admin')
                                    <h6 class="dropdown-header font-weight-bold text-dark">Khu vực Admin</h6>
                                    <a class="dropdown-item" href="{{ route('admin.dashboard') }}">📊 Thống kê</a>
                                    <a class="dropdown-item" href="{{ route('admin.category.index') }}">📁 Quản lý Danh mục</a>
                                    <div class="dropdown-divider"></div>
                                @endcan

                                <a class="dropdown-item" href="{{ route('post.create') }}">+ Viết bài mới</a>
                                <a class="dropdown-item" href="{{ route('post.trash') }}">🗑️ Thùng rác của tôi</a>
                                
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