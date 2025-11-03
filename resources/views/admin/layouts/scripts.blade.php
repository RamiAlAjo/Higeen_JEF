<script src="{{ asset('dist/plugins/jquery/jquery.min.js') }}"></script>
<script src="{{ asset('dist/plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
<script src="{{ asset('dist/plugins/simplebar/simplebar.min.js') }}"></script>
<script src="https://unpkg.com/hotkeys-js/dist/hotkeys.min.js"></script>
<script src="{{ asset('dist/plugins/apexcharts/apexcharts.min.js') }}"></script>
<script src="{{ asset('dist/js/chart.js') }}"></script>
<script src="{{ asset('dist/plugins/DataTables/DataTables-1.10.18/js/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('dist/plugins/jvectormap/jquery-jvectormap-2.0.3.min.js') }}"></script>
<script src="{{ asset('dist/plugins/jvectormap/jquery-jvectormap-world-mill.js') }}"></script>
<script src="{{ asset('dist/plugins/jvectormap/jquery-jvectormap-us-aea.js') }}"></script>
<script src="{{ asset('dist/js/map.js') }}"></script>

<!-- Moment.js and DateRangePicker -->
<script src="{{ asset('dist/plugins/daterangepicker/moment.min.js') }}"></script>
<script src="{{ asset('dist/plugins/daterangepicker/daterangepicker.js') }}"></script>

<!-- Toastr for notifications -->
<script src="{{ asset('dist/plugins/toaster/toastr.min.js') }}"></script>

<!-- Custom Mono JS -->
<script src="{{ asset('dist/js/mono.js') }}"></script>

<script>
    jQuery(document).ready(function() {
        // Initialize Date Range Picker
        jQuery('input[name="dateRange"]').daterangepicker({
            autoUpdateInput: false,
            singleDatePicker: true,
            locale: {
                cancelLabel: 'Clear'
            }
        });

        // Handle Apply Action
        jQuery('input[name="dateRange"]').on('apply.daterangepicker', function (ev, picker) {
            jQuery(this).val(picker.startDate.format('MM/DD/YYYY'));
        });

        // Handle Clear Action
        jQuery('input[name="dateRange"]').on('cancel.daterangepicker', function (ev, picker) {
            jQuery(this).val('');
        });
    });
</script>

<!-- jQuery -->
<script src="{{ asset('dist/plugins/jquery/jquery.min.js') }}"></script>

<!-- Bootstrap 5 Bundle (contains both Bootstrap JS and Popper.js) -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/js/bootstrap.bundle.min.js"></script>

<!-- Link to Summernote JS -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.18/summernote-lite.min.js"></script>


<script>
    $(document).ready(function () {
        // Initialize Summernote for Arabic textarea
        $('#about_us_description_ar').summernote({
            height: 200,  // Set the height of the editor
            lang: 'ar-AR', // Use Arabic language settings
            direction: 'rtl',  // Right-To-Left for Arabic text
            placeholder: 'اكتب هنا...', // Placeholder text for the editor
        });

        // Initialize Summernote for English textarea
        $('#about_us_description_en').summernote({
            height: 200,  // Set the height of the editor
            lang: 'en-US', // Use English language settings
            direction: 'ltr',  // Left-To-Right for English text
            placeholder: 'Write here...', // Placeholder text for the editor
        });
    });
</script>

  <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <!-- Moment.js -->
    <script src="https://cdn.jsdelivr.net/npm/moment@2.29.4/moment.min.js"></script>

    <!-- Daterangepicker -->
    <script src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>

    <!-- Chart.js (UMD version) -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.4/dist/chart.umd.min.js"></script>

    <!-- Your custom script -->
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            // Chart.js example
            const ctx = document.getElementById('myChart').getContext('2d');
            const myChart = new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: ['Red', 'Blue', 'Yellow'],
                    datasets: [{
                        label: 'Votes',
                        data: [12, 19, 3],
                        backgroundColor: ['red', 'blue', 'yellow']
                    }]
                },
                options: {
                    responsive: true,
                    scales: {
                        y: { beginAtZero: true }
                    }
                }
            });

            // Date Range Picker example
            $('#myDateRangeInput').daterangepicker();
        });
    </script>
