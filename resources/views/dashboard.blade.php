@extends('layouts.app')

@section('content')

<!-- Main Dashboard Container -->
<div class="container mt-5 pt-4">
    <h2 class="mb-3">IoT Modules</h2>

    <!-- Refresh Button -->
    <div class="d-flex justify-content-between align-items-center mb-3">
        <button onclick="fetchModules()" class="btn btn-primary">Refresh Data</button>
        <a href="{{ route('modules.create') }}" class="btn btn-success">Add New Module</a>
    </div>

    <div id="toastContainer" class="position-fixed bottom-0 end-0 p-3" style="z-index: 11;"></div>

    <!-- Data Table -->
    <div class="table-responsive">
        <table class="table table-bordered table-hover table-striped text-center align-middle">
            <thead class="table-dark">
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Type</th>
                    <th>Current Value</th>
                    <th>Status</th>
                    <th>Timestamp</th>
                </tr>
            </thead>
            <tbody id="moduleTable">
                @if(isset($modules) && count($modules) > 0)
                    @foreach ($modules as $module)
                        <tr>
                            <td>{{ $module->id }}</td>
                            <td>{{ $module->name }}</td>
                            <td>{{ $module->type }}</td>
                            <td>{{ $module->readings->first()->measured_value ?? 'N/A' }}</td>
                            <td>{{ $module->readings->first()->status ?? 'N/A' }}</td>
                            <td>{{ $module->readings->first()->timestamp ?? 'N/A' }}</td>
                        </tr>
                    @endforeach
                @else
                    <tr><td colspan="6" class="text-center text-danger">No modules available</td></tr>
                @endif
            </tbody>
        </table>
    </div>

    <div class="d-flex justify-content-center mt-3">
        <a href="{{ route('modules.chart') }}" class="btn btn-info">View Module Readings Chart</a>
    </div>
</div>

<script>
    function fetchModules() {
        fetch('/api/modules')
            .then(response => response.json())
            .then(data => {
                let tbody = document.getElementById("moduleTable");
                tbody.innerHTML = "";
                let malfunctionDetected = false; // Flag for malfunction

                data.forEach(module => {
                    let latestReading = module.readings.length ? module.readings[0] : null;
                    let status = latestReading ? latestReading.status : 'N/A';

                    // Check if the module status is 'Malfunction'
                    if (status === 'Malfunction') {
                        malfunctionDetected = true;
                    }

                    tbody.innerHTML += `
                        <tr>
                            <td>${module.id}</td>
                            <td>${module.name}</td>
                            <td>${module.type}</td>
                            <td>${latestReading ? latestReading.measured_value : 'N/A'}</td>
                            <td class="${status === 'Malfunction' ? 'text-danger fw-bold' : ''}">
                                ${status}
                            </td>
                            <td>${latestReading ? latestReading.timestamp : 'N/A'}</td>
                        </tr>
                    `;
                });

                // Show notification if any module is in 'Malfunction' state
                if (malfunctionDetected) {
                    showNotification("Module Failure", "One or more modules are in Malfunction state!");
                }
            })
            .catch(error => console.error('Error fetching data:', error));
    }

    function showNotification(title, message) {
        let toastContainer = document.getElementById("toastContainer");
        let toastHTML = `
            <div class="toast align-items-center text-white bg-danger border-0 show" role="alert" aria-live="assertive" aria-atomic="true">
                <div class="d-flex">
                    <div class="toast-body">
                        <strong>${title}:</strong> ${message}
                    </div>
                    <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
                </div>
            </div>
        `;

        toastContainer.innerHTML = toastHTML;
        let toastElement = toastContainer.querySelector(".toast");
        let toast = new bootstrap.Toast(toastElement);
        toast.show();
    }

    // Refresh every 5 seconds
    setInterval(fetchModules, 5000);
</script>


@endsection
