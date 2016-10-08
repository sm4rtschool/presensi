	<!-- Content Wrapper. Contains page content -->
      <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
          <h1>
            <?php echo $title?>
            <small><?php echo $subtitle?></small>
          </h1>
          <ol class="breadcrumb">
			<?php echo $navigasi;?>
          </ol>
        </section>        
		
		
		
		<div class="pad margin no-print">
          <!-- dari sini --> 

		  <!-- sampe sini -->

		  <?=$this->session->flashdata('notif');?>  
				<?php
					echo form_error('edpekerjaan');
					//echo form_error('edpassword');
					//echo form_error('edemail');
					//echo form_error('ednohp');
				?>
        </div>
	
		
		<!-- Main content -->
        <section class="content">
          <div class="row">
            <!-- left column -->
            <div class="col-md-12">
			
              <!-- general form elements -->
              <div class="box box-primary">
                
				<div class="box-header with-border">
                  <h3 class="box-title">Isilah data pekerjaan dengan lengkap dan benar.</h3>
                </div><!-- /.box-header -->
                
				<!-- form start -->
                <form class="form-horizontal" method="POST" action="<?php echo site_url(); ?>/mspekerjaan/save_add">
				
                  <div class="box-body">
				                  
					<div class="form-group">
					
                      <label for="inputEmail3" class="col-sm-1 control-label">Dari Tanggal</label>
                      
					  <div class="col-sm-3">
                        
						<div class='input-group date' id='dtptanggalpekerjaan'>
							<input type='text' class="form-control" name="dttanggalpekerjaan" placeholder="Isi Tanggal..." />
								<span class="input-group-addon">
									<span class="fa fa-calendar">
									</span>
								</span>
						</div>
						
                      </div>
					  
                    </div>
					
					<div class="form-group">
					
                      <label for="inputEmail3" class="col-sm-1 control-label">Sampai Tanggal</label>
                      
					  <div class="col-sm-3">
                        
						<div class='input-group date' id='dtptanggalpekerjaan'>
							<input type='text' class="form-control" name="dttanggalpekerjaan" placeholder="Isi Tanggal..." />
								<span class="input-group-addon">
									<span class="fa fa-calendar">
									</span>
								</span>
						</div>
						
                      </div>
					  
                    </div>
					
					<div class="form-group">
					
                      <label for="inputEmail3" class="col-sm-1 control-label">Alasan</label>
                      
					  <div class="col-sm-3">
								<select id="select-alasan" class="form-control select2" name="actugas">
									<option selected="selected">Alabama</option>
                      <option>Alaska</option>
                      <option>California</option>
                      <option>Delaware</option>
                      <option>Tennessee</option>
                      <option>Texas</option>
                      <option>Washington</option>
								</select>
                      </div>
					  
                    </div>
					
					
					
					<div class="form-group">
					
                      <label for="inputPassword3" class="col-sm-1 control-label">Keterangan</label>
					  
                      <div class="col-sm-3">
                        <textarea name="memodeskripsi" class="form-control" rows="3" placeholder="Isi Keterangan..."></textarea>
                      </div>
					  
                    </div>
					
							
                  </div><!-- /.box-body -->
				  
				
				<div class="box-footer">
				  
                  <button type="submit" class="btn btn-default"><i class="fa fa-save"></i> Simpan</button>
                  <button type="button" onClick="window.location='<?php echo site_url();?>/mspekerjaan';" class="btn btn-default"><i class="fa fa-undo"></i> Cancel</button>
				  
                </div><!-- /.box-footer -->
				        
				<!--
                <button type="submit" class="btn btn-default">Simpan</button>
				<button type="reset" class="btn btn-info pull-right">Cancel</button>
                -->
				  
                </form>
				
				
				
              </div><!-- /.box -->
			  
			            
            </div><!--/.col (left) -->
			
           
          </div>   <!-- /.row -->
		  
		  
        </section><!-- /.content -->
      </div><!-- /.content-wrapper -->
	  
    <!-- jQuery 2.1.4 -->
    <script src="<?php echo base_url(); ?>asset/plugins/jQuery/jQuery-2.1.4.min.js" type="text/javascript"></script>
    <!-- Bootstrap 3.3.2 JS -->
    <script src="<?php echo base_url(); ?>asset/bootstrap/js/bootstrap.min.js" type="text/javascript"></script>
    <!-- DATA TABES SCRIPT -->
    <script src="<?php echo base_url(); ?>asset/plugins/datatables/jquery.dataTables.min.js" type="text/javascript"></script>
    <script src="<?php echo base_url(); ?>asset/plugins/datatables/dataTables.bootstrap.min.js" type="text/javascript"></script>
    <!-- SlimScroll -->
    <script src="<?php echo base_url(); ?>asset/plugins/slimScroll/jquery.slimscroll.min.js" type="text/javascript"></script>
    <!-- FastClick -->
    <script src="<?php echo base_url(); ?>asset/plugins/fastclick/fastclick.min.js" type="text/javascript"></script>
    <!-- AdminLTE App -->
    <script src="<?php echo base_url(); ?>asset/dist/js/app.min.js" type="text/javascript"></script>
    <!-- AdminLTE for demo purposes -->
    <script src="<?php echo base_url(); ?>asset/dist/js/demo.js" type="text/javascript"></script>  
	
	<!-- datepicker --> 
	<script src="<?php echo base_url(); ?>asset/plugins/datepicker/bootstrap-datepicker.js" type="text/javascript"></script>
	<link href="<?php echo base_url(); ?>asset/plugins/datepicker/datepicker3.css" rel="stylesheet" type="text/css" />
	<script src="<?php echo base_url(); ?>asset/plugins/timepicker/bootstrap-timepicker.min.js" type="text/javascript"></script>
	
	<link href="<?php echo base_url(); ?>asset/plugins/timepicker/bootstrap-timepicker.css" rel="stylesheet" type="text/css" />
	<link href="<?php echo base_url(); ?>asset/plugins/timepicker/bootstrap-timepicker.min.css" rel="stylesheet" type="text/css" />
	
	<!--<link href="<?php echo base_url(); ?>asset/dist/css/select2.min.css" rel="stylesheet" />-->
	<script src="<?php echo base_url(); ?>asset/dist/js/select2.min.js"></script>
	
    <!-- Select2 -->
    <script src="<?php echo base_url(); ?>asset/plugins/select2/select2.full.min.js" type="text/javascript"></script>
	

	
    <!--
    <script type="text/javascript" src="js/jquery.min.js"></script>
	-->
	
	<script type="text/javascript">
		$('#dtptanggalpekerjaan').datepicker({
		autoclose: true,
		todayHighlight: true,
		format: 'yyyy/mm/dd'
		//format: 'dd/mm/yyyy'
		});
	</script>
	
	<script type="text/javascript">
        $('#timepekerjaangadipake').timepicker();
    </script>
	
	<!--
	<script type="text/javascript">
            $('#timepekerjaan').timepicker({
                minuteStep: 1,
                template: 'modal',
                appendWidgetTo: 'body',
                showSeconds: true,
                showMeridian: false,
                defaultTime: false
            });
        </script>
		-->
		
	<!-- Page script -->
    <script type="text/javascript">
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
        $('#reservationtime').daterangepicker({timePicker: true, timePickerIncrement: 30, format: 'MM/DD/YYYY h:mm A'});
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