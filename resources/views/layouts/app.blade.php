<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" dir="@lang('trans.dir')">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="astoken" content="{{ csrf_token() }}">
        <meta name="loadimg" content="{{ asset('imgs/loading.gif') }}">
        <meta name="path" content="{{ url('') }}">
        <title>@yield('page_title') | {{ config('app.name') }}</title>
        <script src="{{ asset('js/jquery.min.js') }}"></script>
        <script src="{{ asset('js/jquery.form.js') }}"></script>
        <script src="{{ asset('js/codes.top.js') }}"></script>
        <script src="{{ asset('js/popper.min.js') }}"></script>
        <script src="{{ asset('js/bootstrap.min.js') }}"></script>
        <script src="{{ asset('js/clipboard.min.js') }}"></script>
        <link rel="stylesheet" href="{{ asset('css/style.css') }}" />
        <link rel="stylesheet" href="{{ asset('css/font-awesome.css') }}" />
        <link rel="stylesheet" href="{{ asset('css/bootstrap.min.css') }}" />
        <link rel="icon" type="image/png" href="{{ asset("imgs/favicon.png") }}" />
        <style type="text/css">
          .custom-control-label::before, .custom-control-label::after{
           @lang('trans.align') : -1.5rem;
           @if (App::isLocale('ar')) margin-right:15px; @endif
          }
          @if (App::isLocale('ar'))
          .switch.switch-sm input:checked + label::after {
              margin-right: calc(2.4375rem * .8);
          }
          .switch input:checked + label::after {
              margin-right: calc(2.375rem * .8);
          }
          .switch input + label::after{
            right: 2px;
          }
          @endif
        </style>
    </head>
    <body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark" style="position: fixed; top: 0; @lang('trans.align'): 0; @lang('trans.alignV'): 0; z-index: 1; box-shadow: 0px 0px 16px #0000002b;">
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarToggler" aria-controls="navbarToggler" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>
  {{-- ============= Data array words to translation puroses ============= --}}
  <div id="data-options" style="display: none;">{"today":"@lang('trans.today')","posting":"@lang('trans.posting')"}</div>
  {{-- ======================= end ======================= --}}
  <div class="collapse navbar-collapse" @if(App::isLocale('ar')) style="text-align: right;" @endif id="navbarToggler">
    <a class="navbar-brand" @if(App::isLocale('ar')) style="margin-left: 1rem;" @endif href="{{ route('welcome') }}"><div class="navbar-brand-img"></div></a>
    <ul class="navbar-nav @lang('trans.navbar_margin')-auto mt-2 mt-lg-0" @if(App::isLocale('ar')) style="padding-right:0" @endif>
      <li class="nav-item @if(\Request::is('home')) active @endif" style="position: relative;">
        <input type="text" class="navbar-search-field" placeholder="@lang('trans.search')" />
        <div class="navbar-search-card" style="text-align: @lang('trans.align')">
        </div>
      </li>
    </ul>
    <ul class="navbar-nav mr-@lang('trans.alignV') mt-2 mt-lg-0"  @if(App::isLocale('ar')) style="padding-right: 0;" @endif>
    @guest
    <li class="nav-item">
        <a class="nav-link @if(\Request::is('login')) active @endif" href="{{ route('login') }}">@lang('trans.login')</a>
    </li>
    <li class="nav-item">
        <a class="nav-link @if(\Request::is('register')) active @endif" href="{{ route('register') }}">@lang('trans.register')</a>
    </li>
@else
    <li class="nav-item dropdown">
        <li>
            <a class="nav-link @if(\Request::is(url(Auth::user()->username))) active @endif" href="{{ route('home') }}">
               <span class="fas fa-home"></span> @lang('trans.home')
            </a>
        </li>
        <li>
            <a class="nav-link @if(\Request::is(url(Auth::user()->username))) active @endif" href="{{ url(Auth::user()->username) }}">
                <span class="fas fa-user-circle"></span> @lang('trans.profile')
            </a>
        </li>
        <li>
            <a  class="nav-link @if(\Request::is("settings")) active @endif" href="{{ url(Auth::user()->username."/settings") }}">
                <span class="fas fa-cog"></span> @lang('trans.settings')
            </a>
        </li>
        <li class="nav-item">
            <a  class="nav-link" href="{{ route('logout') }}"
               onclick="event.preventDefault();
                             document.getElementById('logout-form').submit();">
                <span class="fas fa-sign-out-alt"></span> @lang('trans.logout')
            </a>

            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                @csrf
            </form>
        </li>
    </li>
@endguest
</ul>
  </div>
</nav>
    @yield('content')
     <div class="footer">
        <strong><a class="footer-btn" href="#"><span class="fab fa-instagram"></span> @lang('trans.followUsInsta')</a></strong>
        <strong><a class="footer-btn" href="#">@lang('trans.give_us_fb')</a></strong>
        <strong><a class="footer-btn" href="#">@lang('trans.terms_of_service')</a></strong>
        <strong><a class="footer-btn" href="#">@lang('trans.about')</a></strong>
        <strong><a class="footer-btn" href="{{ url("lang/ar") }}">العربية</a></strong>
        <strong><a class="footer-btn" href="{{ url("lang/en") }}">English</a></strong>
        <p style="font-size: 12px; margin: 0 3%; border-top: 1px solid #eaeaea; margin-top: 5px; padding-top: 5px;direction: ltr;">&copy; {{ date('Y') }} {{ config('app.name') }}, @lang('trans.all_right_reserved').</p>
     </div>
     {{-- ========= Image LightBox Modal ========= --}}
    <div id="imgLightbox" class="imgLightbox">
      <span class="imgLightboxClose">&times;</span>
      <img class="imgLightbox-content" id="imgLightbox_preview">
    </div>
     {{-- ========= end ========= --}}
     <script src="{{ asset('js/codes.bottom.js') }}"></script>
    </body>
</html>