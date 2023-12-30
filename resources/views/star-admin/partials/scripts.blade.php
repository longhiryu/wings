    <!-- plugins:js -->
    <script src="vendors/js/vendor.bundle.base.js"></script>
    <!-- endinject -->
    <!-- Plugin js for this page -->
    <script src="vendors/chart.js/Chart.min.js"></script>
    <script src="vendors/bootstrap-datepicker/bootstrap-datepicker.min.js"></script>
    <script src="vendors/progressbar.js/progressbar.min.js"></script>

    <!-- End plugin js for this page -->
    <!-- inject:js -->
    <script src="js/off-canvas.js"></script>
    <script src="js/hoverable-collapse.js"></script>
    <script src="js/template.js"></script>
    <script src="js/settings.js"></script>
    <script src="js/todolist.js"></script>
    <!-- endinject -->
    <!-- Custom js for this page-->
    <script src="js/jquery.cookie.js" type="text/javascript"></script>
    <script src="js/dashboard.js"></script>
    <script src="js/Chart.roundedBarCharts.js"></script>

    {{-- <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script> --}}
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.12.9/dist/umd/popper.min.js"
        integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous">
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js"
        integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous">
    </script>
    <!-- Select2 -->
    <script src="{{ asset('plugins/select2/select2.min.js') }}"></script>
    <!-- Toastr -->
    <script src="{{ asset('plugins/toastr/toastr.min.js') }}"></script>
    <!-- jqZoom -->
    <script src="{{ asset('plugins/viewbox-master/jquery.viewbox.min.js') }}"></script>
    <!-- End custom js for this page-->

    <script>
        $(document).ready(function() {
            // Bắt sự kiện keydown trong tất cả các input của form
            $('form input').keydown(function(event) {
                if (event.keyCode == 13) {
                    event.preventDefault();
                    return false;
                }
            });

            // Đóng popup hình ảnh khi người dùng nhấn vào nó
            document.getElementById('imagePopup').addEventListener('click', function() {
                this.style.display = 'none';
            });
        });

        toastr.options = {
            "closeButton": false,
            "debug": false,
            "newestOnTop": true,
            "progressBar": true,
            "positionClass": "toast-top-right",
            "preventDuplicates": false,
            "onclick": null,
            "showDuration": "300",
            "hideDuration": "1000",
            "timeOut": "10000",
            "extendedTimeOut": "1000",
            "showEasing": "swing",
            "hideEasing": "linear",
            "showMethod": "fadeIn",
            "hideMethod": "fadeOut"
        }
        window.livewire.on('closeModal', (idModal) => {
            $('#' + idModal).modal('hide');
        })
        window.livewire.on('notification_update_success', ($event = null) => {
            toastr.success($event || "{{ __('text.notification_update_success') }}")
        })
        window.livewire.on('notification_error', ($event = null) => {
            toastr.error($event || "{{ __('text.notification_error') }}")
        })
        window.livewire.on('notification_delete_success', (message = null) => {
            toastr.success(message || "{{ __('text.notification_delete_success') }}")
        })
        window.livewire.on('page_refresh', () => {
            location.reload();
        })
        window.livewire.on('change_title', (title) => {
            document.title = title;
        });
        @if (session()->has('success'))
            toastr.success("{{ session('success') }}")
        @endif

        // Hàm hiển thị popup hình ảnh ở danh sách list
        function showImagePopup(imageUrl) {
            var popup = document.getElementById('imagePopup');
            var image = document.getElementById('popupImage');

            // Thiết lập src cho thẻ img trong popup
            image.src = imageUrl;

            // Hiển thị popup
            popup.style.display = 'block';
        }
    </script>

    @stack('scripts')
