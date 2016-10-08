	<!-- DATA TABLES -->
    <link href="<?php echo base_url(); ?>plugins/datatables/dataTables.bootstrap.css" rel="stylesheet" type="text/css" />
      
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
        
        <?php echo $this->session->flashdata('notif');?>  
		
          <div class="row">
            <div class="col-md-12">
			
				<!-- general form elements -->
				<div class="box box-primary">
				
					<div class="box-header with-border">
						<h3 class="box-title">Isilah data user dengan lengkap dan benar.</h3>
					</div><!-- /.box-header -->
             
					<!-- form start -->
					<form class="form-horizontal" method="POST" action="<?php echo site_url(); ?>/msuser/save_edit_password">
					
						<div class="box-body">
                        
                        	<div class="form-group">
					
								<label for="inputEmail3" class="col-sm-1 control-label">Username</label>
                      
								<div class="col-sm-3">
									<input type="text" id="edusername" name="edusername" class="form-control" id="inputEmail3" readonly value="<?php echo $this->session->userdata('username'); ?>">
								</div>
					  
							</div>
						
							<div class="form-group">
					
								<label for="inputEmail3" class="col-sm-1 control-label">Password Lama</label>
                      
								<div class="col-sm-3">
									<input type="password" id="old_password" name="old_password" class="form-control" id="inputEmail3" placeholder="Password Lama" required="required" autofocus>
								</div>
					  
							</div>
                            
                            <div class="form-group">
					
								<label for="inputPassword3" class="col-sm-1 control-label">Password Baru</label>
					  
								<div class="col-sm-3">
									<input type="password" id="new_password" name="new_password" class="form-control" id="inputPassword3" placeholder="Password Baru" required>
								</div>
					  
							</div>
                            
                            <div class="form-group">
					
								<label for="inputPassword3" class="col-sm-1 control-label">Konfirmasi Password Baru</label>
					  
								<div class="col-sm-3">
									<input type="password" id="confirm_password" name="confirm_password" class="form-control" id="inputPassword3" placeholder="Konfirmasi Password Baru" required>
								</div>
					  
							</div>
					
							
						
						</div><!-- /.box-body -->
						
						<div class="box-footer">

							<button type="submit" class="btn btn-default"><i class="fa fa-save"></i> Simpan</button>
							<button type="button" onClick="window.location='<?php echo site_url();?>/msuser';" class="btn btn-default"><i class="fa fa-undo"></i> Cancel</button>
				  
						</div><!-- /.box-footer -->
					
					</form>
								 
				</div>			 
			  
            </div><!-- /.col -->
          </div><!-- /.row -->
		  
        </section><!-- /.content -->
      </div><!-- /.content-wrapper -->	    

    <!-- jQuery 2.1.4 -->
    <script src="<?php echo base_url(); ?>plugins/jQuery/jQuery-2.1.4.min.js" type="text/javascript"></script>
    <!-- Bootstrap 3.3.2 JS -->
    <script src="<?php echo base_url(); ?>bootstrap/js/bootstrap.min.js" type="text/javascript"></script>
    <!-- DATA TABES SCRIPT -->
    <script src="<?php echo base_url(); ?>plugins/datatables/jquery.dataTables.min.js" type="text/javascript"></script>
    <script src="<?php echo base_url(); ?>plugins/datatables/dataTables.bootstrap.min.js" type="text/javascript"></script>
    <!-- SlimScroll -->
    <script src="<?php echo base_url(); ?>plugins/slimScroll/jquery.slimscroll.min.js" type="text/javascript"></script>
    <!-- FastClick -->
    <script src="<?php echo base_url(); ?>plugins/fastclick/fastclick.min.js" type="text/javascript"></script>
    <!-- AdminLTE App -->
    <script src="<?php echo base_url(); ?>dist/js/app.min.js" type="text/javascript"></script>
    <!-- AdminLTE for demo purposes -->
    <script src="<?php echo base_url(); ?>dist/js/demo.js" type="text/javascript"></script>
    <!-- page script -->