<?php 

/* CONNECTION TO DATABASE */ 
$conn = mysqli_connect('localhost','root','','watercloud');
$today = date("Y-m-d");

/* EXPORTING MORNING DATA */
$sql1 = "SELECT reading_time FROM esp_data WHERE reading_time BETWEEN '$today 00:00:00' AND '$today 11:59:59'";
$result = $conn->query($sql1);
if ($result->num_rows > 0) {
    $matin_cons = 0;
    while ($row = $result->fetch_assoc()) {
        $matin_cons = $matin_cons + 100; 
    }
}else {
    $matin_cons = 0;
}

/* EXPORTING AFTERNOON DATA */
$sql2 = "SELECT reading_time FROM esp_data WHERE reading_time BETWEEN '$today 12:00:00' AND '$today 18:59:59'";
$result = $conn->query($sql2);
if ($result->num_rows > 0) {
    $apres_midi_cons = 0;
    while ($row = $result->fetch_assoc()) {
        $apres_midi_cons = $apres_midi_cons + 100; 
    }
}else {
    $apres_midi_cons = 0;
}

/* EXPORTING NIGHT DATA */
$sql3 = "SELECT reading_time FROM esp_data WHERE reading_time BETWEEN '$today 19:00:00' AND '$today 23:59:59'";
$result = $conn->query($sql3);
if ($result->num_rows > 0) {
    $soir_cons = 0;
    while ($row = $result->fetch_assoc()) {
        $soir_cons = $soir_cons + 100; 
    }
}else {
    $soir_cons = 0;
}


?>



<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css" integrity="sha384-9aIt2nRpC12Uk9gS9baDl411NQApFmC26EwAOH8WgZl5MYYxFfc+NcPb1dKGj7Sk" crossorigin="anonymous">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="style.css">
  <title>water cloud</title>
  <script>

    // IMPORT PHP VARIABLES
    <?php echo "var matin = '$matin_cons';"; ?>
    <?php echo "var apres_midi = '$apres_midi_cons';"; ?>
    <?php echo "var soir = '$soir_cons';"; ?>

    // PARSE IT TO INTEGER VALUES
    matin = parseInt(matin);
    apres_midi = parseInt(apres_midi);
    soir = parseInt(soir);

    // THE COLUMN AND PIE GRAPH FROM GOOGLE CHARTS 
    google.charts.load("current", {packages:['corechart']});
    google.charts.setOnLoadCallback(drawChart);
    function drawChart() {
      var data = google.visualization.arrayToDataTable([
        ["Element", "Quantity", { role: "style" } ],
        ["Matin", matin, "#b87333"],
        ["Aprés Midi", apres_midi, "silver"],
        ["Soir", soir, "color: #e5e4e2"]
      ]);

      var data2 = google.visualization.arrayToDataTable([
          ['DAY', 'Consommation'],
          ['Matin',     matin],
          ['Apres Midi',      apres_midi],
          ['Soir',    soir]
        ]);


      var view = new google.visualization.DataView(data);
      view.setColumns([0, 1,
                     { calc: "stringify",
                       sourceColumn: 1,
                       type: "string",
                       role: "annotation" },
                     2]);

      var options = {
        title: "Statistique du jour",
        width: 500,
        height: 400,
        bar: {groupWidth: "95%"},
        legend: { position: "none" },
      };

      var options2 = {
          title: 'Taux de Consommation'
      };


      var chart = new google.visualization.ColumnChart(document.getElementById("columnchart_values"));
      chart.draw(view, options);

      var chart2 = new google.visualization.PieChart(document.getElementById('piechart'));
      chart2.draw(data2, options2);

    }



    
  </script>
</head>
<body>
<div class="container-fluid">
        <!--  HEADER NAV  -->
        <div id="header">
            <ul>
                <li id="title">Water Cloud</li>
                <li style="float:right"><a class="active" href="">About</a></li>
                <li style="float:right"><a class="active" href="">Contact</a></li>
            </ul>
        </div>

        <hr>

        <!--  COVER  -->
        <div id="cover">
            <div class="row">
                <div class="col-sm-6">
                    <center><p id="desc">Bienvenue chez watercloud pour consulter tous les statistiques sur votre systeme aquatique.</p></center>
                </div>
                <div class="col-sm-6">
                    <img src="water.jpg" width="500px" height="300px" id="cover" >
                </div>
            </div>
        </div>
        
        <!--  DASHBOARD  -->
        <div id="dashboard">
            <center><p id="dash">Dashboard</p></center>
            <hr>
            <div class="row">
                <div class="col-sm-6">
                    <center><div id="columnchart_values" style="width: 500px; height: 400px;"></div></center>
                </div>
                <div class="col-sm-6">
                    <br><br>
                    <center><div id="piechart" style="width: 500px; height: 400px;"></div></center>
                </div>
            </div>

        </div>
    </div>



</body>
</html>
