<?php
//echo '<pre>',var_dump($data),'</pre>';
?>
@if(count($data['final']))
@push('scripts')
<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
@endpush

@push('inline-scripts')
    <script type="text/javascript">
        google.charts.load('current', {'packages':['corechart']});
        google.charts.setOnLoadCallback(drawVisualization);
        function drawVisualization() {
            // Some raw data (not necessarily accurate)
            <?php
                $series = count($data['final'][0]) - 2;
            ?>
            var data = google.visualization.arrayToDataTable(<?php echo json_encode($data['final']) ?>);

            var formatter = new google.visualization.NumberFormat({
                decimalSymbol : ',',
                groupingSymbol : '.',
                fractionDigits : 2
            });

            @for($i = 1; $i <= $series; $i++)
            formatter.format(data, <?php echo $i ?>);
            @endfor

            var options = {
                @if($data['range'][1])
                title : 'Performance Comercial entre <?php echo $data['range'][0] ?> a <?php echo $data['range'][1] ?>',
                @else
                    title : 'Performance Comercial para <?php echo $data['range'][0] ?>',
                @endif
                vAxis: {title: 'Ventas'},
                hAxis: {title: 'Fecha'},
                seriesType: 'bars',
                series: {<?php echo $series ?>: {type: 'line'}}
            };
            var chart = new google.visualization.ComboChart(document.getElementById('chart_div'));
            chart.draw(data, options);
        }
        $(window).resize(function(){
            drawVisualization();
        });

    </script>
@endpush
<div class="row">
    <div class="col-md-12">
        <div class="well bs-component">
            <div id="chart_div" class="chart"></div>
        </div>
    </div>
</div>
@endif