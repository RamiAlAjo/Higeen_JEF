<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}" dir="{{ app()->getLocale() === 'ar' ? 'rtl' : 'ltr' }}">

<head>
    <meta charset="UTF-8" />
    <!-- Responsive viewport -->
    <meta name="viewport" content="width=device-width, initial-scale=1" />

    {{-- <title>{{ config('app.name', 'Rayyan') }}</title> --}}

    {{-- Styles (Bootstrap CSS or your own styles) --}}
    @include('front.layouts.styles')

    <style>
      /* Responsive padding for body */
      @media (max-width: 576px) {
        body {
          padding-left: 10px;
          padding-right: 10px;
        }
        /* Example: reduce heading sizes on small devices */
        h1, h2, h3 {
          font-size: 1.2rem;
        }
      }
    </style>

    {{-- Extra head content --}}
    {{-- @yield('head') --}}
</head>
<body class="min-vh-100 text-dark container-fluid">

    {{-- Responsive Navbar example --}}
    @include('front.layouts.navbar')
    {{-- Make sure your navbar uses Bootstrap responsive classes like navbar-expand-md, etc. --}}

    {{-- Main content --}}
    <main class="flex-grow-1">
      <!-- Use container-fluid for full width on xs, container-md for fixed width on md+ -->
      <div class="container-fluid py-3">
        @yield('content')
      </div>
    </main>

    {{-- Responsive Footer --}}
    @include('front.layouts.footer')
    {{-- Ensure your footer content wraps well on small screens --}}

    {{-- Scripts --}}
    @include('front.layouts.scripts')
    @yield('scripts')
</body>
</html>

