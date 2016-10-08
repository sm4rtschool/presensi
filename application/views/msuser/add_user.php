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
		
		<!-- Main content -->
        <section class="content">               
   
                                                         
                <?php $this->session->flashdata('notif'); ?>  
				<?php
					echo form_error('edusername');
					echo form_error('edpassword');
					echo form_error('cbopegawai');
					echo form_error('cboleveluser');
				?> 
                      
        
          <div class="row">
          
            <!-- left column -->
            <div class="col-md-12">
			
              <!-- general form elements -->
              <div class="box box-primary">
                
				<div class="box-header with-border">
                  <h3 class="box-title">Isilah data user dengan lengkap dan benar.</h3>
                </div><!-- /.box-header -->
                
				<!-- form start -->
                <form class="form-horizontal" method="POST" action="<?php echo site_url(); ?>/msuser/save_add">
				
                  <div class="box-body">
				  
                    <div class="form-group">
					
                      <label for="inputEmail3" class="col-sm-1 control-label">Username</label>
                      
					  <div class="col-sm-3">
                        <input type="text" name="edusername" class="form-control" id="inputEmail3" placeholder="Username" required="required">
                      </div>
					  
                    </div>
					
                    <div class="form-group">
					
                      <label for="inputPassword3" class="col-sm-1 control-label">Password</label>
					  
                      <div class="col-sm-3">
                        <input type="password" name="edpassword" class="form-control" id="inputPassword3" placeholder="Password" required>
                      </div>
					  
                    </div>
					
					<div class="form-group">
					
                      <label for="inputEmail3" class="col-sm-1 control-label">Nama Pegawai</label>
                      
					  <div class="col-sm-3">
                      
						<select class="form-control select2" id = "cbopegawai" name="cbopegawai" required="required">
						<option selected="selected">- Pilih Pegawai -</option>
						
						</select>
					  
					  </div>
					  
                    </div>	

					<div class="form-group">
					
                      <label for="inputEmail3" class="col-sm-1 control-label">Level User</label>
                      
					  <div class="col-sm-3">
                      
						<select class="form-control select2" name="cboleveluser" required="required">
						<option selected="selected">- Pilih Level User -</option>
						
													
							<option value = "Super Admin">Super Admin</option>
							<option value = "Pimpinan">Pimpinan</option>
							<option value = "Operator">Operator</option>
							<option value = "Pegawai">Pegawai</option>					
						
						</select>
					  
					  </div>
					  
                    </div>	
					
                  </div><!-- /.box-body -->
				  
				
				<div class="box-footer">
				
				<!--
                  <div class="pull-right">
                    <button class="btn btn-default"><i class="fa fa-reply"></i> Reply</button>
                    <button class="btn btn-default"><i class="fa fa-share"></i> Forward</button>
                  </div>
				  -->
				  
                  <button type="submit" class="peringatan btn btn-default"><i class="fa fa-save"></i> Simpan</button>
                  
                  <button type="button" onClick="window.location='<?php echo site_url();?>/msuser';" class="btn btn-default"><i class="fa fa-undo"></i> Cancel</button>
                  
				  
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
	<!-- Select2 -->
    <script src="<?php echo base_url(); ?>asset/plugins/select2/select2.full.min.js" type="text/javascript"></script>
	
	<script>
      $(function () {
        //Initialize Select2 Elements
        $(".select2").select2();
	  })
    </script>
	
	<script type = "text/javascript">
	$(document).ready(function()
	{
		load_dropdown_pegawai();
	});	
	
	function load_dropdown_pegawai(){
				//$("#cboalasan").change(function(){ //any select change on the dropdown with id country trigger this code
		
			//get a reference to the select element
			var $cbopegawai = $('#cbopegawai');
        
			//request the JSON data and parse into the select element
			$.ajax({
			url:'<?php echo site_url() . '/msuser/load_dropdown_pegawai'; ?>',
			dataType: 'JSON', 
			success: function(data){

				//clear the current content of the select
				$cbopegawai.html('');
				//iterate over the data and append a select option
				$.each(data.qrymskaryawan, function (key, val){
					$cbopegawai.append('<option value = "' + val.KdKaryawan + '">' + val.Nama + '</option>');
				})

			}, 			
			error: function(){
								//<strong>
                                //if there is an error append a 'none available' option
                                $cbopegawai.html('<option value = "-1">- Data Pegawai Tidak Ada -</option>');
                            }
							
			});
	}
	
	
	</script>