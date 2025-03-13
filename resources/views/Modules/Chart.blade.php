@extends('layouts.app')

@section('content')
<div class="container-fluid mt-4">
    <div class="text-left">
        <a href="{{ route('dashboard') }}" class="btn btn-outline-primary mt-3">Back to Dashboard</a>
    </div>

    <br>
    <h5 class="text-primary text-center">Module Readings Chart</h5>

    <div class="chart-container">
        <canvas id="moduleChart"></canvas>
    </div>


</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script src="https://cdn.jsdelivr.net/npm/moment"></script>
<script src="https://cdn.jsdelivr.net/npm/chartjs-adapter-moment"></script>

<script>
document.addEventListener("DOMContentLoaded", function ()
{
    let moduleData = @json($modules);

    if (!moduleData.length)
    {
        console.error("No data available for the chart.");
        return;
    }

    let datasets = moduleData.map(module => ({
        label: module.name,
        data: module.readings.map(reading => ({
            x: reading.timestamp,
            y: reading.measured_value
        })),
        borderColor: getRandomColor(),
        borderWidth: 2,
        pointRadius: 3,
        fill: false
    }));

    let ctx = document.getElementById('moduleChart').getContext('2d');
    new Chart(ctx,
    {
        type: 'line',
        data: {
            datasets: datasets
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            scales: {
                x: {
                    type: 'time',
                    time: {
                        unit: 'minute',
                        tooltipFormat: 'YYYY-MM-DD HH:mm:ss',
                        displayFormats: {
                            minute: 'HH:mm',
                            hour: 'HH:mm'
                        }
                    },
                    title: {
                        display: true,
                        text: 'Timestamp'
                    }
                },
                y: {
                    min: 0,
                    max: 110,
                    ticks: {
                        stepSize: 10
                    },
                    title: {
                        display: true,
                        text: 'Measured Value'
                    }
                }
            },
            plugins: {
                legend: {
                    display: true,
                    position: 'top'
                }
            }
        }
    });

    function getRandomColor()
    {
        return `hsl(${Math.random() * 360}, 100%, 50%)`;
    }
});
</script>

<style>
.chart-container {
    width: 100%;
    height: 600px;
}

/* Responsive Adjustments */
@media (max-width: 768px) {
    .chart-container {
        height: 280px;
    }
}
</style>
@endsection
