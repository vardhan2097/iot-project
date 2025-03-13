@extends('layouts.app')

@section('content')
    <!-- Include the Navigation Bar -->
    @include('layouts.navigation')

    <div class="container mt-4">
        <h2>IOT Module</h2>
        <button onclick="fetchModules()" class="btn btn-primary">Refresh</button>

        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Id</th>
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
                    <tr><td colspan="6" class="text-center">No modules available</td></tr>
                @endif
            </tbody>
        </table>
    </div>

    <script>
        function fetchModules() {
            fetch('/api/modules')
                .then(response => response.json())
                .then(data => {
                    let tbody = document.getElementById("moduleTable");
                    tbody.innerHTML = "";
                    data.forEach(module => {
                        let latestReading = module.readings.length ? module.readings[0] : null;
                        tbody.innerHTML += `
                            <tr>
                                <td>${module.id}</td>
                                <td>${module.name}</td>
                                <td>${module.type}</td>
                                <td>${latestReading ? latestReading.measured_value : 'N/A'}</td>
                                <td>${latestReading ? latestReading.status : 'N/A'}</td>
                                <td>${latestReading ? latestReading.timestamp : 'N/A'}</td>
                            </tr>
                        `;
                    });
                })
                .catch(error => console.error('Error fetching data:', error));
        }

        // Auto refresh the table every 5 seconds
        setInterval(fetchModules, 5000);
    </script>
@endsection
