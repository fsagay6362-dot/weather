<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <title>Ciśnienie atmosferyczne</title>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 text-gray-800">
<div class="max-w-4xl mx-auto py-10">
    <h1 class="text-3xl font-bold text-center mb-8">Historia ciśnienia atmosferycznego</h1>

    <div class="bg-white shadow-lg rounded-lg p-6">
        <canvas id="pressureChart" class="w-full h-96"></canvas>
    </div>
</div>

<script>
    fetch('/press')
        .then(res => res.json())
        .then(data => {
            const ctx = document.getElementById('pressureChart').getContext('2d');
            new Chart(ctx, {
                type: 'line',
                data: {
                    labels: data.map(d => new Date(d.recorded_at).toLocaleString()),
                    datasets: [{
                        label: 'Ciśnienie (hPa)',
                        data: data.map(d => d.pressure),
                        borderColor: '#3b82f6',
                        backgroundColor: 'rgba(59,130,246,0.2)',
                        fill: true,
                        tension: 0.4,
                        pointRadius: 4,
                        pointBackgroundColor: '#1d4ed8'
                    }]
                },
                options: {
                    responsive: true,
                    plugins: {
                        legend: { labels: { font: { size: 14 } } }
                    },
                    scales: {
                        x: {
                            title: { display: true, text: 'Czas', font: { size: 16 } }
                        },
                        y: {
                            title: { display: true, text: 'Ciśnienie (hPa)', font: { size: 16 } }
                        }
                    }
                }
            });
        });
</script>
</body>
</html>
