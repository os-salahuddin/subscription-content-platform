<x-app-layout>
    <x-slot name="header">
        <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
        <script>
    document.addEventListener('DOMContentLoaded', function () {
        // Daily Access Count Per User
        const accessCtx = document.getElementById('accessChart').getContext('2d');
        new Chart(accessCtx, {
            type: 'bar',
            data: {
                labels: @json($accessData->pluck('name')),
                datasets: [{
                    label: 'Access Count',
                    data: @json($accessData->pluck('count')->map(fn($c) => (int)$c)),
                    backgroundColor: 'rgba(54, 162, 235, 0.5)',
                    borderColor: 'rgba(54, 162, 235, 1)',
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });

        // Top Viewed Articles
        const articlesCtx = document.getElementById('articlesChart').getContext('2d');
        new Chart(articlesCtx, {
            type: 'bar',
            data: {
                labels: @json($topArticles->pluck('title')),
                datasets: [{
                    label: 'Views',
                    data: @json($topArticles->pluck('views')->map(fn($v) => (int)$v)),
                    backgroundColor: 'rgba(255, 99, 132, 0.5)',
                    borderColor: 'rgba(255, 99, 132, 1)',
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });
    });
</script>
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
        <div class="col-md-6">
            <h4>Daily Access Count Per User</h4>
            <canvas id="accessChart"></canvas>
        </div>

        <div class="col-md-6">
            <h4>Top Viewed Articles</h4>
            <canvas id="articlesChart"></canvas>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    {{ __("You're logged in!") }}
                </div>
            </div>

            <div class="row">
        
    </div>
        </div>
    </div>
</x-app-layout>