<?php
require_once '../component/session.php';
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
    //on récupère toutes les vues pour chacune des chambres
$alls = getAllViews($dbh);

$total = 0;
$nb = 0;

foreach ($alls as $all){
    //on récupère le nombre de vues totales toutes chambres confondu
    $total = $total + $all['vues'];
}
?>
    <div class="miseEnPage">
    <?php
foreach ($alls as $all){
    //on calcule le poid de chaque chambre sur le nombre de vue total
    $prcnt = $all['vues'] * 100 / $total;
    //arrondit pour un
    $prcnt = round($prcnt);
    //on crée un itérateur fictif
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
    <!--Code du graphique de google charts-->
    <script type="text/javascript">
        google.charts.load('current', {'packages':['corechart']});
        google.charts.setOnLoadCallback(drawVisualization);

        function drawVisualization() {
            // Some raw data (not necessarily accurate)
            var data = google.visualization.arrayToDataTable([
                ['Month', 'Vues', 'Réservations'],
                <?php
                $totalMonthSeeInformation = getAllMonth($dbh);
                foreach ($totalMonthSeeInformation as $information){
                    //je récupére qu'une partie de la date en base de donnée qui a cette forme 2021-04-12 ici je récup 2021-04
                $TakeYearsAndMonths = substr($information['mois'], 0,-3);
                //je remplace les tirets de la date pour un / pour un affichage plus jolie
                $yearAndMonth = strtr($TakeYearsAndMonths, '-', '/');
                $vues = $information['vuesTotale'];
                ?>
                ['<?= $yearAndMonth ?>',  <?= $vues ?>,  1],
                <?php
                }
                ?>
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