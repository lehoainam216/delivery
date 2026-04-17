<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <title>Laravel 12 + Bootstrap 4</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

    <style>
        #sidebar {
            background-image: url('images/layout_img/pattern_h.png');
        }

        .dash_head {
            background-image: url('images/layout_img/pattern_h.png');
        }

        .error_404 {
            background: url('images/layout_img/pattern_h.png');
        }

        .topbar {
            background-image: url('images/layout_img/pattern.png');
        }
    </style>
</head>

<body class="dashboard dashboard_1">
    <div class="full_container">
        <div class="inner_container">
            @include('layouts.sidebar')
            <div id="content">
                @include('layouts.topbar')
                <div class="midde_cont">
                    @yield('content')
                    @include('layouts.footer')
                </div>
            </div>
        </div>
    </div>
</body>

</html>
