<?php
require_once '../component/header.php';
require_once '../functions/sql.php';
require_once 'bdd.php';
?>
<style>
    .miseEnPage{
        display: flex;
        flex-wrap: wrap;
    }
    .miseEnPage p{
        display: inline;
        margin-left: 2%;
        margin-right: 2%;
    }
</style>
<div class="content">

    <?php
$alls = getAllViews($dbh);

$total = 0;
$nb = 0;

foreach ($alls as $all){
    $total = $total + $all['vues'];
}
?>
    <div class="miseEnPage">
    <?php
foreach ($alls as $all){
    $prcnt = $all['vues'] * 100 / $total;
    $nb = $nb+1;
    ?>
        <p>
            Chambre n° <?= $nb ?> = <?= $prcnt ?> % des vues <br>
            Total des vues de la chambre n° <?= $nb ?> = <?= $all['vues'] ?>
        </p>
    <?php
}
?>
    </div>
    <div><br>
        Total des vues du site : <?= $total ?>
    </div>


    <!-- Graphique en construction-->
    <head>
        <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
    </head>
    <script type="text/javascript">
        google.charts.load('current', {'packages':['corechart']});
        google.charts.setOnLoadCallback(drawVisualization);

        function drawVisualization() {
            // Some raw data (not necessarily accurate)
            var data = google.visualization.arrayToDataTable([
                ['Month', 'Vues', 'Réservations'],
                ['2021/01',  1,      1,  ],
                ['2021/02',  1,      1,   ],
                ['2021/03',  7,      10,  ],
                ['2021/04',  <?= $total ?> ,      10, ],
                ['2021/05',  5,      1,   ]
            ]);

            var options = {
                title : 'Nombre de vues et de réservations par mois',
                vAxis: {title: 'Nombre'},
                hAxis: {title: 'mois'},
                seriesType: 'bars',
                series: {5: {type: 'line'}}
            };

            var chart = new google.visualization.ComboChart(document.getElementById('chart_div'));
            chart.draw(data, options);
        }
    </script>

    <div id="chart_div" style="width: 900px; height: 500px;"></div>

</div>

</body>
</html>
statistics.php
3 Ko