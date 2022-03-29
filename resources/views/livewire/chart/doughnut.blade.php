<div id="chart-doughnut" style="w-full"></div>

<script type="text/javascript">
    document.addEventListener('livewire:load', function () {
        async function getData() {
            let api = await fetch('{{ $api }}');

            return api.json();
        }

        const doughnutChart = echarts.init(document.getElementById('chart-doughnut'), null, {
            aria: {
                show: true
            },
            renderer: 'svg'
        });
    });
</script>
