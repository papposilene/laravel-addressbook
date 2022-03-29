<div>
    <div id="pieChart" style="w-full"></div>

    <script type="text/javascript">
        document.addEventListener('livewire:load', function () {
            async function getData() {
                let api = await fetch('{!! $api !!}');

                return api.json();
            }

            const chartDom = document.getElementById('pieChart');
            const pieChart = echarts.init(chartDom, 'dark');
            let option;

            console.info(getData())

            option = {
                aria: {
                    enabled: true,
                    show: true
                },
                darkMode: true,
                title: {
                    text: 'Referer of a Website',
                    subtext: 'Fake Data',
                    left: 'center'
                },
                tooltip: {
                    trigger: 'item'
                },
                legend: {
                    orient: 'vertical',
                    left: 'left'
                },
                series: [
                    {
                        name: 'Access From',
                        type: 'pie',
                        radius: '50%',
                        data: [
                            {value: 1048, name: 'Search Engine'},
                            {value: 735, name: 'Direct'},
                            {value: 580, name: 'Email'},
                            {value: 484, name: 'Union Ads'},
                            {value: 300, name: 'Video Ads'}
                        ],
                        emphasis: {
                            itemStyle: {
                                shadowBlur: 10,
                                shadowOffsetX: 0,
                                shadowColor: 'rgba(0, 0, 0, 0.5)'
                            }
                        }
                    }
                ]
            };

            option && pieChart.setOption(option);

        });
    </script>
</div>
