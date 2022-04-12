<div>
    <canvas id="barChart" width="400" height="400"></canvas>

    <script type="text/javascript">
        document.addEventListener('livewire:load', function () {
            let getLabels = [];
            let getDatasets = [];
            async function loadChart() {
                await fetch('{!! $api !!}')
                    .then(response => response.json())
                    .then(json => {
                        json.data.map(function(e) {
                            getLabels.push(e.name_eng_common);
                        });
                        json.data.map(function(e) {
                            getDatasets.push(e.has_addresses_count);
                        });
                    });

                const chartDom = document.getElementById('barChart').getContext('2d');
                const barChart = new Chart(chartDom, {
                    type: 'bar',
                    data: {
                        labels: getLabels,
                        datasets: [{
                            label: '# of Votes',
                            data: getDatasets,
                            borderWidth: 1
                        }]
                    },
                    options: {
                        responsive: true,
                        plugins: {
                            legend: {
                                position: 'top',
                            },
                            title: {
                                display: true,
                                text: 'Chart.js Pie Chart'
                            }
                        }
                    }
                });
            }

            loadChart();

        });
    </script>
</div>
