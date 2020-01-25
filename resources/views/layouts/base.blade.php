<!--
**
** Base layout for all other layouts
**
-->

<!DOCTYPE html>
<html lang="en" class="govuk-template ">

<head>
  <meta charset="utf-8" />
  <title>NICS Architecture Catalogue</title>
  <meta name="viewport" content="width=device-width, initial-scale=1, viewport-fit=cover">
  <meta name="theme-color" content="#0b0c0c" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />

  <!-- <link rel="shortcut icon" sizes="16x16 32x32 48x48" href="/assets/images/favicon.ico" type="image/x-icon" /> -->
  <link rel="mask-icon" href="/assets/images/govuk-mask-icon.svg" color="#0b0c0c">
  <link rel="apple-touch-icon" sizes="180x180" href="/assets/images/govuk-apple-touch-icon-180x180.png">
  <link rel="apple-touch-icon" sizes="167x167" href="/assets/images/govuk-apple-touch-icon-167x167.png">
  <link rel="apple-touch-icon" sizes="152x152" href="/assets/images/govuk-apple-touch-icon-152x152.png">
  <link rel="apple-touch-icon" href="/assets/images/govuk-apple-touch-icon.png">

  <!-- CSRF Token -->
  <meta name="csrf-token" content="{{ csrf_token() }}">

  <!-- favicon -->
  <link rel="shortcut icon" href="{{ asset('favicon.ico') }}" type="image/x-icon">

  <!-- Styles -->
  <link href="{{ mix('css/app.css') }}" rel="stylesheet">

  <!-- Global site tag (gtag.js) - Google Analytics -->
  <script async src="https://www.googletagmanager.com/gtag/js?id=UA-150837477-3"></script>
  <script>
    window.dataLayer = window.dataLayer || [];
    function gtag(){dataLayer.push(arguments);}
    gtag('js', new Date());

    gtag('config', 'UA-150837477-3', { 'anonymize_ip': true });
  </script>
</head>

<body class="govuk-template__body ">
  <script>
    document.body.className = ((document.body.className) ? document.body.className + ' js-enabled' : 'js-enabled');
  </script>

  <a href="#main-content" class="govuk-skip-link">Skip to main content</a>

  <header class="govuk-header " role="banner" data-module="govuk-header">
    <div class="govuk-header__container govuk-width-container">
      <div class="govuk-header__logo">
        <a href="/" class="govuk-header__link govuk-header__link--homepage">
          <span class="govuk-header__logotype">
            <svg role="presentation" focusable="false" class="govuk-header__logotype-crown" xmlns="http://www.w3.org/2000/svg" width="35" height="35" viewBox="10 25 150 170">
                 <g>
                   <polygon points="85.1,134.4 70.9,126.2 70.9,109.6 85.1,101.3 99.3,109.6 99.3,126.2 	"></polygon>
                   <polygon points="85.1,167.5 70.9,159.3 70.9,142.7 85.1,134.4 99.3,142.7 99.3,159.3 	"></polygon>
                   <polygon points="56.8,84.8 42.6,76.5 42.6,59.9 56.8,51.7 70.9,59.9 70.9,76.5 	"></polygon>
                   <polygon points="56.8,117.9 42.6,109.6 42.6,93.1 56.8,84.8 70.9,93.1 70.9,109.6 	"></polygon>
                   <polygon points="56.8,151 42.6,142.7 42.6,126.2 56.8,117.9 70.9,126.2 70.9,142.7 	"></polygon>
                   <polygon points="28.4,101.3 28.4,68.2 42.6,76.5 42.6,93.1 	"></polygon>
                   <polygon points="28.4,134.4 28.4,101.3 42.6,109.6 42.6,126.2 	"></polygon>
                 </g>
                 <g>
                   <polygon points="85.1,68.2 70.9,59.9 70.9,43.4 85.1,35.1 99.3,43.4 99.3,59.9 "></polygon>
                   <polygon points="85.1,101.3 70.9,93.1 70.9,76.5 85.1,68.2 99.3,76.5 99.3,93.1 "></polygon>
                   <polygon points="113.5,84.8 99.3,76.5 99.3,59.9 113.5,51.7 127.7,59.9 127.7,76.5 "></polygon>
                   <polygon points="113.5,117.9 99.3,109.6 99.3,93.1 113.5,84.8 127.7,93.1 127.7,109.6 "></polygon>
                   <polygon points="113.5,151 99.3,142.7 99.3,126.2 113.5,117.9 127.7,126.2 127.7,142.7 "></polygon>
                   <polygon points="141.9,101.3 127.7,93.1 127.7,76.5 141.9,68.2 "></polygon>
                   <polygon points="141.9,134.4 127.7,126.2 127.7,109.6 141.9,101.3 "></polygon>
                 </g>
                </svg>
            <span class="govuk-header__logotype-text">NICS</span>
          </span>
          <span class="govuk-header__product-name">Architecture Catalogue</span>
        </a>
      </div>
      <div class="govuk-header__content">
        <button type="button" class="govuk-header__menu-button govuk-js-header-toggle" aria-controls="navigation" aria-label="Show or hide Top Level Navigation">Menu</button>
        <nav>
            <ul id="navigation" class="govuk-header__navigation " aria-label="Top Level Navigation">
                @if (Auth::check())
                    <li class="govuk-header__navigation-item {{ url()->current() == url('/home') ? 'govuk-header__navigation-item--active' : '' }}">
                      <a class="govuk-header__link" href="/home">
                        Home
                      </a>
                    </li>
                    <li class="govuk-header__navigation-item {{ url()->current() == url('/entries/search') ? 'govuk-header__navigation-item--active' : '' }}">
                      <a class="govuk-header__link" href="/entries/search">
                        Search
                      </a>
                    </li>
                    <li class="govuk-header__navigation-item {{ url()->current() == url('/entries') ? 'govuk-header__navigation-item--active' : '' }}">
                      <a class="govuk-header__link" href="/entries">
                        Browse
                      </a>
                    </li>
                    <li class="govuk-header__navigation-item {{ url()->current() == url('/admin') ? 'govuk-header__navigation-item--active' : '' }}">
                      <a class="govuk-header__link" href="/admin">
                        Admin
                      </a>
                    </li>
                    <li class="govuk-header__navigation-item">
                      <form method="POST" id="logout" action="{{ route('logout') }}">
                          {{ csrf_field() }}
                          <a class="govuk-header__link" href="javascript:{}" onclick="document.getElementById('logout').submit();">Sign out</a>
                      </form>
                    </li>
                @endif
            </ul>
        </nav>
      </div>
    </div>
  </header>

  <div class="govuk-width-container app-site-width-container">
    <div class="govuk-phase-banner">
      <p class="govuk-phase-banner__content">
        <strong class="govuk-tag govuk-phase-banner__content__tag">
      alpha
    </strong>
        <span class="govuk-phase-banner__text">
          This is a prototype service – your <a class="govuk-link" href="mailto:ea-team@ea.finance-ni.gov.uk?subject=Architecture Catalogue Enquiry">feedback</a> will help us to improve it.
        </span>
      </p>
    </div>
    @yield('back')
    <main class="govuk-main-wrapper" id="main-content" role="main">
      @yield('content')
    </main>
  </div>

  <footer class="govuk-footer " role="contentinfo">
    <div class="govuk-width-container app-site-width-container">
      <div class="govuk-footer__navigation">
          <div class="govuk-footer__section">
              <h2 class="govuk-footer__heading govuk-heading-m">Related resources</h2>
              <ul class="govuk-footer__list govuk-footer__list--columns-1">
                  <li class="govuk-footer__list-item">
                      <a class="govuk-footer__link" href="{{ config('app.architecture_portal_url') }}">
                          Architecture Portal
                      </a>
                  </li>
                  <li class="govuk-footer__list-item">
                      <a class="govuk-footer__link" href="{{ config('app.ea_principles_url') }}">
                          Enterprise Architecture Principles
                      </a>
                  </li>
                  <li class="govuk-footer__list-item">
                      <a class="govuk-footer__link" href="{{ config('app.citizen_services_architecture_url') }}">
                          Citizen Services Architecture
                      </a>
                  </li>
              </ul>
          </div>
      </div>
      <hr class="govuk-footer__section-break">
      <div class="govuk-footer__meta">
          <div class="govuk-footer__meta-item govuk-footer__meta-item--grow">
              <h2 class="govuk-visually-hidden">Support links</h2>
              <ul class="govuk-footer__inline-list">
                  <li class="govuk-footer__inline-list-item">
                      <a class="govuk-footer__link" href="/accessibility">
                          Accessibility
                      </a>
                  </li>
                  <li class="govuk-footer__inline-list-item">
                      <a class="govuk-footer__link" href="/cookies">
                        Cookies
                      </a>
                  </li>
                  <li class="govuk-footer__inline-list-item">
                    <a class="govuk-footer__link" href="/privacy-policy">
                      Privacy policy
                    </a>
                  </li>
                  <li class="govuk-footer__inline-list-item">
                    <a class="govuk-footer__link" href="https://www.nationalarchives.gov.uk/information-management/re-using-public-sector-information/uk-government-licensing-framework/crown-copyright/">
                      © Crown copyright
                    </a>
                  </li>
              </ul>
          </div>
      </div>
    </div>
  </footer>

  <script src="{{ mix('js/app.js') }}"></script>

  <script>
    window.GOVUKFrontend.initAll()
  </script>
</body>

</html>
