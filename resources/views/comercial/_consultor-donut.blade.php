<?php
//echo '<pre>',var_dump($data),'</pre>';
?>
@push('scripts')
    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
@endpush
@push('inline-scripts')
    <script type="text/javascript">
        google.charts.load("current", {packages:["corechart"]});
        google.charts.setOnLoadCallback(drawChart);
        function drawChart() {
            var data = google.visualization.arrayToDataTable([
            ['Consulor', 'Paricipación'],
            @foreach($data as $row)
            ['{!! $row->no_usuario !!}',     <?php echo (float) $row->beneficio_neto ?>],
            @endforeach
            ]);

            var formatter = new google.visualization.NumberFormat({
                decimalSymbol : ',',
                groupingSymbol : '.',
                fractionDigits : 2
            });
            formatter.format(data, 1);

            var options = {
            title: 'Participación en los ingresos',
            pieHole: 0.2,
            };
            var chart = new google.visualization.PieChart(document.getElementById('donutchart'));
            chart.draw(data, options);
        }

        $(window).resize(function(){
            drawChart();
        });

    </script>
@endpush
<div class="row">
    <div class="col-md-12">
        <div class="well bs-component">
            <div id="donutchart" class="chart"></div>
        </div>
    </div>
</div>