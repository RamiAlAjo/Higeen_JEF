<!-- Font Awesome CSS -->
<!-- This link loads the Font Awesome stylesheet, allowing you to use a wide range of icons in your project. -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">

<!-- Bootstrap 5 CSS -->
<!-- This link loads Bootstrap version 5's CSS file, providing styling and layout features like grids, buttons, and forms. -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

<!-- Bootstrap Icons CSS -->
<!-- This link loads the Bootstrap Icons CSS, which includes a collection of vector-based icons for use in your project. -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">

<!-- Leaflet CSS -->
<link rel="stylesheet" href="https://unpkg.com/leaflet/dist/leaflet.css" />

<!-- Summernote WYSIWYG Editor -->
<link
  href="https://cdn.jsdelivr.net/npm/summernote@0.8.20/dist/summernote-bs5.min.css"
  rel="stylesheet"
/>

{{-- Swiper + Lightbox + Custom Styles --}}
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/lightbox2/2.11.4/css/lightbox.min.css">


<style>
  body {
    position: relative;
    z-index: 1;
  }

  body::before {
    content: "";
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background-image: url('{{ asset('GREENHOUSES SKETCH WITH BG.svg') }}');
    background-repeat: no-repeat;
    background-size: cover;
    background-position: center;
    opacity: 0.2; /* Adjust this for more or less visibility */
    z-index: -1; /* Keep it behind all content */
  }
</style>

