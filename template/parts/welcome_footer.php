 <!-- Main Footer -->
  <footer class="main-footer">
    <!-- To the right -->
    <div class="pull-right hidden-xs">
      IntraNet <?=$c['websitevertion']?>
    </div>
    <!-- Default to the left -->
    <strong>Copyright &copy; 2015 <a href="http://404.ge" target="_blank">Studio 404</a>.</strong> All rights reserved.
  </footer>

    </div><!-- ./wrapper -->

    <!-- REQUIRED JS SCRIPTS -->

    <!-- jQuery 2.1.4 -->
    <script src="<?=TEMPLATE?>plugins/jQuery/jQuery-2.1.4.min.js?v=<?=$c['websitevertion']?>"></script>
    <!-- Bootstrap 3.3.5 -->
    <script src="<?=TEMPLATE?>bootstrap/js/bootstrap.min.js?v=<?=$c['websitevertion']?>"></script>
    <!-- Select2 -->
    <script src="<?=TEMPLATE?>plugins/select2/select2.full.min.js?v=<?=$c['websitevertion']?>"></script>
    <!-- InputMask -->
    <script src="<?=TEMPLATE?>plugins/input-mask/jquery.inputmask.js?v=<?=$c['websitevertion']?>"></script>
    <script src="<?=TEMPLATE?>plugins/input-mask/jquery.inputmask.date.extensions.js?v=<?=$c['websitevertion']?>"></script>
    <script src="<?=TEMPLATE?>plugins/input-mask/jquery.inputmask.extensions.js?v=<?=$c['websitevertion']?>"></script>
    <!-- date-range-picker -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.10.2/moment.min.js?v=<?=$c['websitevertion']?>"></script>
    <script src="<?=TEMPLATE?>plugins/fullcalendar/fullcalendar.min.js"></script>

    <script src="<?=TEMPLATE?>plugins/daterangepicker/daterangepicker.js?v=<?=$c['websitevertion']?>"></script>
    <!-- bootstrap color picker -->
    <script src="<?=TEMPLATE?>plugins/colorpicker/bootstrap-colorpicker.min.js?v=<?=$c['websitevertion']?>"></script>
    <!-- bootstrap time picker -->
    <script src="<?=TEMPLATE?>plugins/timepicker/bootstrap-timepicker.min.js?v=<?=$c['websitevertion']?>"></script>
    <!-- SlimScroll 1.3.0 -->
    <script src="<?=TEMPLATE?>plugins/slimScroll/jquery.slimscroll.min.js?v=<?=$c['websitevertion']?>"></script>
    <!-- iCheck 1.0.1 -->
    <script src="<?=TEMPLATE?>plugins/iCheck/icheck.min.js"></script>
    <!-- FastClick -->
    <script src="<?=TEMPLATE?>plugins/fastclick/fastclick.min.js"></script>
    <!-- AdminLTE App -->
    <script src="<?=TEMPLATE?>dist/js/app.min.js"></script>
    <!-- AdminLTE for demo purposes -->
    <script src="<?=TEMPLATE?>dist/js/demo.js"></script>
    <script src="<?=TEMPLATE?>dist/js/general.js"></script>

    <!-- bootstrap datepicker -->
    <script src="<?=TEMPLATE?>plugins/datepicker/bootstrap-datepicker.js"></script>

    <!-- Page script -->
    <script>
      $(function () {
        //Initialize Select2 Elements
        $(".select2").select2();

        //Datemask dd/mm/yyyy
        $("#datemask").inputmask("dd/mm/yyyy", {"placeholder": "dd/mm/yyyy"});
        //Datemask2 mm/dd/yyyy
        $("#datemask2").inputmask("mm/dd/yyyy", {"placeholder": "mm/dd/yyyy"});
        //Money Euro
        $("[data-mask]").inputmask();

        //Date range picker
        $('#reservation').daterangepicker();
        //Date range picker with time picker
        $('.reservationtime').daterangepicker(
            {
               showDropdowns: true,
               showWeekNumbers: true,
               timePicker: true,
               format: 'MM/DD/YYYY h:mm A'
                },
            function(start, end){
                var uniqueId = $(this)[0].element.context.attributes[2].nodeValue;
                $("#"+uniqueId).val(start.format('MM/DD/YYYY h:mm A') + ' - ' + end.format('MM/DD/YYYY h:mm A'));
                startDate = start;
                endDate = end; 
            }
        );
        //Date range as a button
        $('#daterange-btn').daterangepicker(
            {
              ranges: {
                'Today': [moment(), moment()],
                'Yesterday': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
                'Last 7 Days': [moment().subtract(6, 'days'), moment()],
                'Last 30 Days': [moment().subtract(29, 'days'), moment()],
                'This Month': [moment().startOf('month'), moment().endOf('month')],
                'Last Month': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
              },
              startDate: moment().subtract(29, 'days'),
              endDate: moment()
            },
        function (start, end) {
          $('#reportrange span').html(start.format('MMMM D, YYYY') + ' - ' + end.format('MMMM D, YYYY'));
        }
        );

        $('.datepicker').datepicker({
          autoclose: true,
          format: 'dd/mm/yyyy'
        });

        //iCheck for checkbox and radio inputs
        $('input[type="checkbox"].minimal, input[type="radio"].minimal').iCheck({
          checkboxClass: 'icheckbox_minimal-blue',
          radioClass: 'iradio_minimal-blue'
        });
        //Red color scheme for iCheck
        $('input[type="checkbox"].minimal-red, input[type="radio"].minimal-red').iCheck({
          checkboxClass: 'icheckbox_minimal-red',
          radioClass: 'iradio_minimal-red'
        });
        //Flat red color scheme for iCheck
        $('input[type="checkbox"].flat-red, input[type="radio"].flat-red').iCheck({
          checkboxClass: 'icheckbox_flat-green',
          radioClass: 'iradio_flat-green'
        });

        //Colorpicker
        $(".my-colorpicker1").colorpicker();
        //color picker with addon
        $(".my-colorpicker2").colorpicker();

        //Timepicker
        $(".timepicker").timepicker({
          showInputs: false
        });
      });
    </script>
  </body>
</html>