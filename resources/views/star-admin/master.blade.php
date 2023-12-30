<!DOCTYPE html>
<html lang="en">

<head>
    @livewireStyles
    @include('star-admin.partials.head')

</head>

<body>
    <div class="container-scroller">
        <!-- partial:partials/_navbar.html -->
        @include('star-admin.blocks.navbar')
        <!-- partial -->
        <div class="container-fluid page-body-wrapper">
            <!-- partial:partials/_settings-panel.html -->
            @include('star-admin.blocks.theme-setting')
            @include('star-admin.blocks.setting-panel')
            <!-- partial -->
            <!-- partial:partials/_sidebar.html -->
            @include('star-admin.blocks.sidebar')
            <!-- partial -->
            <div class="main-panel">
                <div class="content-wrapper">
                    <div class="row">
                        @yield('content')
                    </div>
                </div>
                <!-- content-wrapper ends -->
                <!-- partial:partials/_footer.html -->
                <footer class="footer">
                    @include('star-admin.blocks.footer')
                </footer>
                <!-- partial -->
            </div>
            <!-- main-panel ends -->
        </div>
        <!-- page-body-wrapper ends -->
    </div>
    <!-- container-scroller -->

    @livewireScripts
    @include('star-admin.partials.scripts')
</body>

</html>
