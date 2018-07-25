@extends('layouts.default')

@section('content')

    <div class="row">
        <div class="col-sm-12">
            <div class="custom-panel">
                <div class="custom-panel-heading">Dashboard</div>
                <canvas id="canvas"></canvas>
            </div>
        </div>
    </div>

@stop

@section('js')

<script src="/js/plugins/Chart.js"></script>
<script src="/js/plugins/utils.js"></script>
<script type="text/javascript">

		var jsonData = '{!! $timeLogs->content() !!}';
		var jsonData = JSON.parse(jsonData);

        var color = Chart.helpers.color;
        var barChartData = {
            labels: Object.keys(jsonData),
            datasets: [{
                label: 'Time log',
                backgroundColor: color(window.chartColors.red).alpha(0.5).rgbString(),
                borderColor: window.chartColors.red,
                borderWidth: 1,
                data: Object.values(jsonData)
            }]
        };

        window.onload = function() {
            var ctx = document.getElementById("canvas").getContext("2d");
            window.myBar = new Chart(ctx, {
                type: 'bar',
                data: barChartData,
                options: {
                    responsive: true,
                    legend: {
                        position: 'top',
                    },
                    title: {
                        display: true,
                        text: 'Weekly time log for all users'
                    }
                }
            });

        };
    </script>
	
</script>
@stop 