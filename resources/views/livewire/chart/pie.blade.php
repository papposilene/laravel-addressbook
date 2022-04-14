<div>
    <canvas id="{{ $name }}" width="400" height="400"></canvas>

    <script type="text/javascript">
        document.addEventListener('livewire:load', function () {
            let getColors = [];
            let getDatasets = [];
            let getLabels = [];
            const getDefaultColors = [
                '#EF4444', '#F97316', '#F59E0B', '#EAB308', '#84CC16', '#22C55E',
                '#10B981', '#14B8A6', '#06B6D4', '#0EA5E9', '#3B82F6', '#818CF8',
                '#8B5CF6', '#A855F7', '#D946EF', '#EC4899', '#F43F5E',
                '#F87171', '#FB923C', '#FBBF24', '#FACC15', '#A3E635', '#4ADE80',
                '#34D399', '#2DD4BF', '#22D3EE', '#38BDF8', '#60A5FA', '#6366F1',
                '#A78BFA', '#C084FC', '#E879F9', '#F472B6', '#FB7185',
            ];
            async function loadChart() {
                await fetch('{!! $api !!}')
                    .then(response => response.json())
                    .then(json => {
                        json.data.map(function(e) {
                            getLabels.push(e.name);
                            getDatasets.push(e.has_addresses_count);
                            if(e.icon_color) { getColors.push(e.icon_color); }
                        });
                    });

                const {{ $name }}ChartDom = document.getElementById('{{ $name }}').getContext('2d');
                const {{ $name }}PieChart = new Chart({{ $name }}ChartDom, {
                    type: 'pie',
                    data: {
                        labels: getLabels,
                        datasets: [{
                            label: '# of Votes',
                            data: getDatasets,
                            borderWidth: 1,
                            borderColor: '#000',
                            backgroundColor: (getColors.length !== 0 ? getColors : getDefaultColors.sort(() => Math.random() - 0.5)),
                        }]
                    },
                    options: {
                        responsive: true,
                        plugins: {
                            legend: {
                                position: 'bottom',
                                labels: {
                                    color: '#fff',
                                }
                            },
                            title: {
                                display: false,
                                color: '#fff',
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
