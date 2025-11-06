@props(['title', 'data', 'chartId', 'pdfRoute', 'excelRoute', 'limit' => null, 'startDate' => null, 'endDate' => null])

<div class="card">
    <div class="card-header">
        <span>{{ $title }}</span>
        <div>
            <a href="{{ route($pdfRoute, array_filter(['limit' => $limit, 'start_date' => $startDate, 'end_date' => $endDate])) }}"
               class="export-btn pdf"><i class="fas fa-file-pdf"></i> PDF</a>
            <a href="{{ route($excelRoute, array_filter(['limit' => $limit, 'start_date' => $startDate, 'end_date' => $endDate])) }}"
               class="export-btn excel"><i class="fas fa-file-excel"></i> Excel</a>
        </div>
    </div>
    <div class="card-body">
        @if($data->isEmpty())
            <p class="text-center text-muted py-4">{{ __('No data available.') }}</p>
        @else
            <div class="chart-container">
                <canvas id="{{ $chartId }}"></canvas>
            </div>
            <table class="table table-hover">
                <thead>
                    <tr>
                        {{ $headers }}
                    </tr>
                </thead>
                <tbody>
                    {{ $slot }}
                </tbody>
            </table>
        @endif
    </div>
</div>
