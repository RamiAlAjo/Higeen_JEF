<!-- Footer -->
<footer class="ABOUT-footer py-5">
  <div class="container">
    <div class="row">

      <!-- Logo + tagline + social media -->
      <div class="col-md-4 mb-4 mb-md-0 text-center text-md-start">
        <img src="{{ asset('Logo.svg') }}" alt="{{ __('footer.company_logo_alt') }}" class="mb-2" style="max-width: 200px;">
        <p class="small mb-2 mb-md-3">{{ __('footer.company_tagline') }}</p>

        <!-- Social Media Icons -->
        <div class="d-flex justify-content-center justify-content-md-start gap-3">
          <a href="{{ $globalsettings->facebook ?? '#' }}" class="text-dark" aria-label="Facebook" target="_blank" rel="noopener"><i class="bi bi-facebook fs-5"></i></a>
          <a href="{{ $globalsettings->instagram ?? '#' }}" class="text-dark" aria-label="Instagram" target="_blank" rel="noopener"><i class="bi bi-instagram fs-5"></i></a>
          <a href="{{ $globalsettings->twitter ?? '#' }}" class="text-dark" aria-label="Twitter" target="_blank" rel="noopener"><i class="bi bi-twitter-x fs-5"></i></a>
          <a href="{{ $globalsettings->linkedin ?? '#' }}" class="text-dark" aria-label="LinkedIn" target="_blank" rel="noopener"><i class="bi bi-linkedin fs-5"></i></a>
        </div>
      </div>

      <!-- Quick Links -->
      <div class="col-md-4 mb-4 mb-md-0 text-center text-md-start">
        <h5 class="ABOUT-footer-title">{{ __('footer.quick_links') }}</h5>
        <ul class="list-unstyled">
          <a href="{{ route('front.homepage') }}" class="nav-link NAVBAR-link-Footer {{ Route::is('front.homepage') ? 'active' : '' }}">{{ __('footer.home') }}</a>
          <a href="{{ route('front.about') }}" class="nav-link NAVBAR-link-Footer {{ Route::is('front.about') ? 'active' : '' }}">{{ __('footer.about_us') }}</a>
          <a href="{{ route('front.product') }}" class="nav-link NAVBAR-link-Footer {{ Route::is('front.product') ? 'active' : '' }}">{{ __('footer.products') }}</a>
          <a href="{{ route('front.gallery') }}" class="nav-link NAVBAR-link-Footer {{ Route::is('front.gallery') ? 'active' : '' }}">{{ __('footer.gallery') }}</a>
          <a href="{{ route('front.contact') }}" class="nav-link NAVBAR-link-Footer {{ Route::is('front.contact') ? 'active' : '' }}">{{ __('footer.contact') }}</a>
        </ul>
      </div>

      <!-- Contact Us -->
      <div class="col-md-4 text-center text-md-start">
        <h5 class="ABOUT-footer-title">{{ __('footer.contact_us') }}</h5>
        <ul class="list-unstyled">
          <li><i class="bi bi-telephone-fill me-2"></i>{{ $globalsettings->phone ?? '#' }}</li>
          <li><i class="bi bi-envelope-fill me-2"></i>{{ $globalsettings->email ?? '#' }}</li>
          <li><i class="bi bi-geo-alt-fill me-2"></i>{{ $globalsettings->address ?? '#' }}</li>
        </ul>
      </div>
    </div>
  </div>

  <!-- Bottom Strip -->
  <div class="ABOUT-footer-bottom mt-4 py-2 px-3" style="width: 280px;">
    <div class="d-flex align-items-center">
      <span class="me-3 text-white fw-bold">{{ __('footer.authorized_distributor') }}</span>
      <img src="{{ asset('Logo_2.svg') }}" alt="{{ __('footer.distributor_logo_alt') }}" style="height: 30px;">
    </div>
  </div>
</footer>

<!-- Footer Styles -->
<style>
  .ABOUT-footer {
    background-color: #e0e0e0;
    color: #1f2c45;
  }

  .ABOUT-footer-title {
    color: #8B3C2B; /* brown title */
    font-weight: 600;
    margin-bottom: 15px;
  }

  .ABOUT-footer-link {
    color: #1f2c45;
    text-decoration: none;
    display: inline-block;
    margin-bottom: 8px;
  }

  .ABOUT-footer-link:hover {
    text-decoration: underline;
  }

  .ABOUT-footer-bottom {
    background-color: #8B3C2B; /* brown strip */
    border-radius: 5px;
  }


</style>
