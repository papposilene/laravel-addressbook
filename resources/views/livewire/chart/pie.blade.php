<div id="chart-pie" style="w-full"></div>

<script type="text/javascript">
    document.addEventListener('livewire:load', function () {
        async function getData() {
            let api = await fetch('{{ $api }}');

            return api.json();
        }

        const pieChart = echarts.init(document.getElementById('chart-pie'), null, {
            aria: {
                show: true
            },
            renderer: 'svg'
        });
    });
</script>
