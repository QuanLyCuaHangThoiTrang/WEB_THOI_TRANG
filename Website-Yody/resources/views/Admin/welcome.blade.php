<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <title>@yield('title')</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <link rel="stylesheet" href="http://cdn.bootcss.com/toastr.js/latest/css/toastr.min.css">

    <!-- Thêm Bootstrap CSS và JS (nếu chưa có) -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>

    <!-- Toastr JS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>

    <link rel="stylesheet" href="{{ asset('vendors/feather/feather.css') }}">
    <link rel="stylesheet" href="{{ asset('vendors/mdi/css/materialdesignicons.min.css') }}">
    <link rel="stylesheet" href="{{ asset('vendors/ti-icons/css/themify-icons.css') }}">
    <link rel="stylesheet" href="{{ asset('vendors/typicons/typicons.css') }}">
    <link rel="stylesheet" href="{{ asset('vendors/simple-line-icons/css/simple-line-icons.css') }}">
    <link rel="stylesheet" href="{{ asset('vendors/css/vendor.bundle.base.css') }}">
    <!-- endinject -->
    <!-- Plugin css for this page -->
    <!-- <link rel="stylesheet" href="{{ asset('vendors/datatables.net-bs4/dataTables.bootstrap4.css') }}"> -->
    <link rel="stylesheet" href="{{ asset('js/select.dataTables.min.css') }}">
    <!-- End plugin css for this page -->
    <!-- inject:css -->
    <link rel="stylesheet" href="{{ asset('css/vertical-layout-light/style.css') }}">
    <!-- endinject -->
    <link rel="shortcut icon" href="{{ asset('images/favicon.png') }}" />
</head>

<body>
    <div class="container-scroller">
        <!-- partial:partials/_navbar.html -->
        @include('Admin.layouts.navbar')
        <!-- partial -->
        <div class="container-fluid page-body-wrapper">
            <!-- partial:partials/_settings-panel.html -->
            <!-- partial -->
            <!-- partial:partials/_sidebar.html -->
            @include('Admin.layouts.header')
            <!-- partial -->
            <div class="main-panel">
                <div class="container">
                    @yield('content')
                </div>
                <!-- content-wrapper ends -->
                <!-- partial:partials/_footer.html -->
                <!-- partial -->
            </div>
            <!-- main-panel ends -->
        </div>
        <!-- page-body-wrapper ends -->
    </div>
    <!-- container-scroller -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js"></script>
    <!-- Bootstrap JS -->
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    @yield('scripts')
    <!-- plugins:js -->
    <script src="{{ asset('vendors/js/vendor.bundle.base.js') }}" defer></script>
    <!-- endinject -->
    <!-- Plugin js for this page -->
    <script src="{{ asset('vendors/chart.js/Chart.min.js') }}"></script>
    <script src="{{ asset('vendors/bootstrap-datepicker/bootstrap-datepicker.min.js') }}"></script>
    <script src="{{ asset('vendors/progressbar.js/progressbar.min.js') }}"></script>

    <!-- End plugin js for this page -->
    <!-- inject:js -->
    <!-- <script src="{{ asset('js/off-canvas.js') }}" defer></script> -->
    <!-- <script src="{{ asset('js/hoverable-collapse.js') }}" defer></script> -->
    <script src="{{ asset('js/template.js') }}"></script>
    <!-- <script src="{{ asset('js/settings.js') }}"></script> -->
    <!-- <script src="{{ asset('js/todolist.js') }}"></script> -->
    <!-- endinject -->
    <!-- Custom js for this page-->
    <script src="{{ asset('js/file-upload.js') }}"></script>
    <!-- <script src="{{ asset('js/typeahead.js') }}"></script> -->
    <script src="{{ asset('js/select2.js') }}"></script>
    <script src="{{ asset('js/dashboard.js') }}"></script>
    <!-- <script src="{{ asset('js/Chart.roundedBarCharts.js') }}"></script> -->


    <!-- End custom js for this page-->
</body>

</html>
