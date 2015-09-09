<?PHP

require "../../config/config.php";
?>
<!DOCTYPE html>
<html>
<head>
<title>Stock Manager | Printer Usage Report | &copy; Robin Wright 2014</title>
  <!--Load the AJAX API-->
    <script type="text/javascript" src="https://www.google.com/jsapi"></script>
    <script type="text/javascript">

      // Load the Visualization API and the piechart package.
      google.load('visualization', '1.0', {'packages':['corechart']});

      // Set a callback to run when the Google Visualization API is loaded.
      google.setOnLoadCallback(drawChart);

      // Callback that creates and populates a data table,
      // instantiates the pie chart, passes in the data and
      // draws it.
      function drawChart() {

        // Create the data table.
        var data = new google.visualization.DataTable();
        data.addColumn('string', 'Ink Name');
        data.addColumn('number', '<?php echo $_GET['v']; ?>');
        data.addRows([
		<?php
		foreach($_SESSION[strtolower($_GET['v'])] as $value){
			echo "['" . $value[0] . "', " . $value[1] . "],\r\n";
		}
		unset($_SESSION[strtolower($_GET['v'])]);
		?>
        ]);

        // Set chart options
        var options = {'title':'Ink Usage Report | <?php echo $_GET['v']; ?>',
                       'width':800,
                       'height':580};

        // Instantiate and draw our chart, passing in some options.
        var chart = new google.visualization.PieChart(document.getElementById('chart_div'));
        chart.draw(data, options);
      }
    </script>
  </head>

  <body>
    <!--Div that will hold the pie chart-->
    <div style="margin-top:-80px; padding-top:0px;" id="chart_div"></div>
  </body>
</html>















































