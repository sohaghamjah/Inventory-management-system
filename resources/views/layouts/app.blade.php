
<!DOCTYPE html>
<html lang="en">

<!-- Mirrored from wieldy-html.g-axon.work/default/ by HTTrack Website Copier/3.x [XR&CO'2014], Wed, 19 Aug 2020 08:12:55 GMT -->
<head>
  <!-- Meta tags -->
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="Wieldy - A fully responsive, HTML5 based admin template">
  <meta name="keywords" content="Responsive, HTML5, admin theme, business, professional, jQuery, web design, CSS3, sass">
  <!-- /meta tags -->
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <title>{{ config('settings.title') ? config('settings.title') : env('APP_NAME') }} - @yield('title')</title>

  <!-- Site favicon -->
  <link rel="shortcut icon" href="{{ 'storage/'.LOGO_PATH.config('settings.favicon') }}" type="image/x-icon">
  <!-- /site favicon -->

  <!-- Font Icon Styles -->
  <link rel="stylesheet" href="{{ asset('assets/node_modules/flag-icon-css/css/flag-icon.min.css') }}">
  <link rel="stylesheet" href="{{ asset('assets/vendors/gaxon-icon/style.css') }}">
  <!-- /font icon Styles -->

  <link rel="stylesheet" href="{{ asset('assets/default/assets/css/all.css') }}">
  <link rel="stylesheet" href="{{ asset('assets/default/assets/css/dropify.min.css') }}">
  <link rel="stylesheet" href="{{ asset('assets/default/assets/css/jquery.nestable.min.css') }}">
  <link rel="stylesheet" href="{{ asset('assets/default/assets/css/bootstrap-select.min.css') }}">

  <!-- Perfect Scrollbar stylesheet -->
  <link rel="stylesheet" href="{{ asset('assets/node_modules/perfect-scrollbar/css/perfect-scrollbar.css') }}">
  <!-- /perfect scrollbar stylesheet -->
  {{-- datatable --}}
  <link rel="stylesheet" href="{{ asset('assets/default/assets/css/datatables.bundle7.0.8.css') }}">

  <!-- Load Styles -->

  <link rel="stylesheet" href="{{ asset('assets/default/assets/css/lite-style-1.min.css') }}">
  <link rel="stylesheet" href="{{ asset('assets/default/assets/css/custom.css') }}">
  <!-- /load styles -->
  @stack('stylesheet')

</head>
<body class="dt-sidebar--fixed dt-header--fixed">

<!-- Loader -->
<div class="dt-loader-container">
  <div class="dt-loader">
    <svg class="circular" viewBox="25 25 50 50">
      <circle class="path" cx="50" cy="50" r="20" fill="none" stroke-width="2" stroke-miterlimit="10"></circle>
    </svg>
  </div>
</div>
<!-- /loader -->

<!-- Root -->
<div class="dt-root">
  <!-- Header -->
    @include('includes.header')
  <!-- /header -->

  <!-- Site Main -->
  <main class="dt-main">
    <!-- Sidebar -->
    <x-sidebar/>
    <!-- /sidebar -->

    <!-- Site Content Wrapper -->
    <div class="dt-content-wrapper">

      <!-- Site Content -->
        @yield('content')
      <!-- /site content -->

      <!-- Footer -->
      @include('includes.footer')
      <!-- /footer -->

    </div>
    <!-- /site content wrapper -->

    <!-- Theme Chooser -->
    <div class="dt-customizer-toggle">
      <a href="javascript:void(0)" data-toggle="customizer"> <i class="icon icon-spin icon-setting"></i> </a>
    </div>
    <!-- /theme chooser -->

    <!-- Customizer Sidebar -->
    <x-right-sidebar/>
    <!-- /customizer sidebar -->

  </main>
</div>
<!-- /root -->

<!-- Optional JavaScript -->
<script src="{{ asset('assets/node_modules/jquery/dist/jquery.min.js') }}"></script>
<script src="{{ asset('assets/node_modules/moment/moment.js') }}"></script>
<script src="{{ asset('assets/node_modules/bootstrap/dist/js/bootstrap.bundle.min.js') }}"></script>
<!-- Perfect Scrollbar jQuery -->
<script src="{{ asset('assets/node_modules/perfect-scrollbar/dist/perfect-scrollbar.min.js') }}"></script>
<!-- /perfect scrollbar jQuery -->

<!-- masonry script -->
<script src="{{ asset('assets/node_modules/masonry-layout/dist/masonry.pkgd.min.js') }}"></script>

{{-- others js --}}
<script src="{{ asset('assets/default/assets/js/dropify.min.js') }}"></script>
<script src="{{ asset('assets/default/assets/js/jquery.nestable.min.js') }}"></script>
<script src="{{ asset('assets/default/assets/js/bootstrap-select.min.js') }}"></script>
<script src="{{ asset('assets/default/assets/js/sweetalert2@11.js') }}"></script>
<script src="{{ asset('assets/node_modules/chart.js/dist/Chart.min.js') }}"></script>
<script src="{{ asset('assets/default/assets/js/datatables.bundle7.0.8.js') }}"></script>
<script src="{{ asset('assets/default/assets/js/script.js') }}"></script>
<script src="{{ asset('assets/default/assets/js/custom.js') }}"></script>
<script>
    let _token = '{!! csrf_token() !!}'
</script>
@stack('script')
<script>
   // Flash message
   $(document).ready(function ($) {
        @if (session('success'))
            notification('success', "{{ session('success') }}");
        @endif
    });
</script>
</body>

<!-- Mirrored from wieldy-html.g-axon.work/default/ by HTTrack Website Copier/3.x [XR&CO'2014], Wed, 19 Aug 2020 08:14:49 GMT -->
</html>
