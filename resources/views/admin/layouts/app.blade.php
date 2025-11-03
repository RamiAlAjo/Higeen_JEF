<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/nprogress/0.2.0/nprogress.min.js"></script>
    @include('admin.layouts.meta_tags')
    @include('admin.layouts.styles')
    </head>
    <body class="navbar-fixed sidebar-fixed" id="body">
        <div id="toaster"></div>


        <!-- ====================================
        ——— WRAPPER with page content
        ===================================== -->
        <div class="wrapper">
            @include('admin.layouts.sidebar')
            @include('admin.layouts.page_wrapper')
        </div>
    </body>
    @include('admin.layouts.scripts')
</html>
