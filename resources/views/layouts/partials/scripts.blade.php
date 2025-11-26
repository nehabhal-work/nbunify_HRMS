<!-- Core JS -->
<script src="{{ asset('assets/vendor/libs/jquery/jquery.js') }}"></script>
<script src="{{ asset('assets/vendor/libs/popper/popper.js') }}"></script>
<script src="{{ asset('assets/vendor/js/bootstrap.js') }}"></script>
<script src="{{ asset('assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.js') }}"></script>
<script src="{{ asset('assets/vendor/libs/hammer/hammer.js') }}"></script>
<script src="{{ asset('assets/vendor/libs/i18n/i18n.js') }}"></script>
<script src="{{ asset('assets/vendor/libs/typeahead-js/typeahead.js') }}"></script>
<script src="{{ asset('assets/vendor/js/menu.js') }}"></script>



<!-- Vendors JS -->
<script src="{{ asset('assets/vendor/libs/select2/select2.js') }}"></script>
<script src="{{ asset('assets/js/forms-selects.js') }}"></script>
<script src="https://cdn.datatables.net/2.3.4/js/dataTables.js"></script>
<script src="https://cdn.datatables.net/2.3.4/js/dataTables.bootstrap5.js"></script>
<script src="{{ asset('assets/vendor/libs/sweetalert2/sweetalert2.js') }}"></script>
<script src="{{ asset('assets/js/extended-ui-sweetalert2.js') }}"></script>

<script src="{{ asset('assets/vendor/libs/flatpickr/flatpickr.js') }}"></script>
<script src="{{ asset('assets/vendor/libs/bootstrap-datepicker/bootstrap-datepicker.js') }}"></script>
<script src="{{ asset('assets/vendor/libs/bootstrap-daterangepicker/bootstrap-daterangepicker.js') }}"></script>
{{-- <script src="{{ asset('assets/vendor/libs/jquery-timepicker/jquery-timepicker.js') }}"></script> --}}
{{-- <script src="{{ asset('assets/vendor/libs/pickr/pickr.js') }}"></script> --}}
{{-- <script src="{{ asset('assets/js/forms-pickers.js') }}"></script> --}}
@stack('vendorjs')


<!-- Main JS -->
<script src="{{ asset('assets/js/main.js') }}"></script>
<script src="{{ asset('assets/js/forms-extras.js') }}"></script>
<script src="{{ asset('assets/js/custom.js') }}?v={{ time() }}"></script>



<!-- Page JS -->
@stack('pagejs')
@stack('scripts')

<script>
    $(document).ready(function() {

        // Initialize DataTable
        var table = new DataTable('.srkdataTable', {
            searchable: true,
            fixedHeight: true
        });

        // -----------------------------
        // SAVE PAGE NUMBER ON EDIT CLICK
        // -----------------------------
        $(document).on("click", ".edit-btn", function() {
            localStorage.setItem("client_dt_page", table.page);
        });

        // -----------------------------
        // RESTORE PAGE AFTER REDIRECT
        // -----------------------------
        var storedPage = localStorage.getItem("client_dt_page");
        if (storedPage !== null) {
            table.page = parseInt(storedPage);
            table.update();
            localStorage.removeItem("client_dt_page");
        }

    });
</script>
