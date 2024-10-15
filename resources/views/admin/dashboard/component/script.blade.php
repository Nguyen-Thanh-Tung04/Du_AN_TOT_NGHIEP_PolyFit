

    <script src="admin/js/bootstrap.min.js"></script>
    <script src="admin/js/plugins/metisMenu/jquery.metisMenu.js"></script>
    <script src="admin/js/plugins/slimscroll/jquery.slimscroll.min.js"></script>
    <script src="admin/library/library.js"></script>
    <script src="admin/plugins/jquery-ui.js"></script>


    <!-- Custom and plugin javascript -->
    <script src="admin/js/inspinia.js"></script>
    <script src="admin/js/plugins/pace/pace.min.js"></script>

    <script src="admin/js/plugins/slimscroll/jquery.slimscroll.min.js"></script>


    <!-- jQuery UI -->
    <script src="admin/js/plugins/jquery-ui/jquery-ui.min.js"></script>

    @if (isset($config['js']) && is_array($config['js']))
        @foreach ($config['js'] as $key => $val)
            {!! '<script src="'.$val.'"></script>' !!}
        @endforeach
    @endif

     <script>
         $(document).ready(function() {
             var data = [
                 [1, 700000], // Tháng 1
                 [2, 950000], // Tháng 2
                 [3, 0],      // Tháng 3
                 [4, 119900],      // Tháng 4
                 [5, 0],      // Tháng 5
                 [6, 0],      // Tháng 6
                 [7, 0],      // Tháng 7
                 [8, 0],      // Tháng 8
                 [9, 0],      // Tháng 9
                 [10, 0],     // Tháng 10
                 [11, 0],     // Tháng 11
                 [12, 0]      // Tháng 12
             ];

             var dataset = [
                 {
                     label: "Doanh thu",
                     text: "center",
                     data: data,
                     color: "#1ab394",
                     bars: {
                         show: true,
                         align: "center",
                         barWidth: 0.5,
                         lineWidth: 1,
                         fill: true,
                         fillColor: {
                             colors: [
                                 { opacity: 0.8 },
                                 { opacity: 0.1 }
                             ]
                         }
                     }
                 }
             ];

             var options = {
                 xaxis: {
                     ticks: [
                         [1, "Tháng 1"], [2, "Tháng 2"], [3, "Tháng 3"], [4, "Tháng 4"], [5, "Tháng 5"],
                         [6, "Tháng 6"], [7, "Tháng 7"], [8, "Tháng 8"], [9, "Tháng 9"], [10, "Tháng 10"],
                         [11, "Tháng 11"], [12, "Tháng 12"]
                     ],
                     color: "#d5d5d5"
                 },
                 yaxis: {
                     min: 0,
                     max: 1000000,
                     color: "#d5d5d5"
                 },
                 legend: {
                     labelBoxBorderColor: "#000000",
                     position: "nw"
                 },
                 grid: {
                     hoverable: true,
                     borderWidth: 0,
                     color: "#f0f0f0"
                 },
                 tooltip: true,
                 tooltipOpts: {
                     content: "%s: %y.0",
                     shifts: {
                         x: -60,
                         y: 25
                     },
                     defaultTheme: false
                 }
             };

             $.plot($("#flot-dashboard-chart"), dataset, options);
         });

     </script>
