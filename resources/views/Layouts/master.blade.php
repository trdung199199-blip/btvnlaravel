<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Tin tức')</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css">
    <style>
        body { font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; background-color: #f9f9ff; }
        .hero-banner { background: #355c7d; color: #fff; padding: 60px 0; }
        .blog-card { border: none; margin-bottom: 30px; box-shadow: 0 4px 12px rgba(0,0,0,0.05); }
        .blog-card img { height: 200px; object-fit: cover; }
        .sidebar-widget { background: #fff; padding: 25px; margin-bottom: 30px; border-radius: 5px; }
    </style>
</head>
<body>
    @include('layouts.header')

    <main>
        @yield('content')
    </main>

    @include('layouts.footer')

    <script src="https://cdn.jsdelivr.net/npm/jquery@3.7.1/dist/jquery.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>