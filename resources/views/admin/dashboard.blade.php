@extends('admin.master')
@section('content')

<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
    <script type="text/javascript">
      google.charts.load('current', {'packages':['corechart']});
      google.charts.setOnLoadCallback(drawChart);

      function drawChart() {

        var data = google.visualization.arrayToDataTable([
          ['Task', 'Hours per Day'],
         <?php echo $chartData ?>
        ]);

        var options = {
          title: 'Asset types(piechart)'
        };
      
        var chart = new google.visualization.PieChart(document.getElementById('piechart'));

        chart.draw(data, options);
      }
    </script>
  </head>

<style>
  .content-wrapper{
    background-color: silver;
  }
 
</style>
  
  <!-- Content Wrapper. Contains page content -->
  <!-- <div class="content-wrapper"> -->
    <!-- Content Header (Page header) -->
    <!-- <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Chart</h1>
          </div>
          
        </div>
      </div> -->
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="container border shadow rounded w-10 ">
        <div class="row">
          <div class="col-md-6">
            
           
          
                <div class="content-wrapper bg-primary">

<div id="piechart" class="bg-primary" style="width: 900px; height: 500px;"></div>
</div>
                


         


  <!-- Control Sidebar -->
  <aside class="control-sidebar control-sidebar-dark">
    <!-- Control sidebar content goes here -->
  </aside>
  <!-- /.control-sidebar -->
</div>
<!-- ./wrapper -->

<!-- jQuery -->
<script src="{{asset('plugins/jquery/jquery.min.js')}}"></script>

<!-- ChartJS -->
<script src="{{asset('plugins/chart.js/Chart.min.js')}}"></script>
<!-- AdminLTE App -->




 

   
    
@endsection

