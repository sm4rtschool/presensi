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
		
		<?php foreach ($data->result() as $val):?>
		
		<div class="pad margin no-print">
           
				<?=$this->session->flashdata('notif');?>  
				<?php
					echo form_error('edusername');
					echo form_error('edpassword');
					echo form_error('edemail');
					echo form_error('ednohp');
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
                  <h3 class="box-title">Isilah data user dengan lengkap dan benar.</h3>
                </div><!-- /.box-header -->
                
				<!-- form start -->
                <form class="form-horizontal" method="POST" action="<?php echo site_url(); ?>/msuser/save_edit">
				
                  <div class="box-body">
				  
				  <input type ="hidden" name="id_user" value="<?php echo $val->userid?>">
				  
                    <div class="form-group">
					
                      <label for="inputEmail3" class="col-sm-1 control-label">Username</label>
                      
					  <div class="col-sm-3">
                        <input type="text" name="edusername" class="form-control" id="inputEmail3" placeholder="Username" value="<?php echo $val->username?>">
                      </div>
					  
                    </div>
					
                    <div class="form-group">
					
                      <label for="inputPassword3" class="col-sm-1 control-label">Password</label>
					  
                      <div class="col-sm-3">
                        <input type="password" name="edpassword" class="form-control" id="inputPassword3" placeholder="Password" value="<?php echo $val->password?>">
                      </div>
					  
                    </div>
					
					<div class="form-group">
					
                      <label for="inputEmail3" class="col-sm-1 control-label">Email</label>
                      
					  <div class="col-sm-3">
                        <input type="email" name="edemail" class="form-control" id="exampleInputEmail1" placeholder="Email" value="<?php echo $val->email?>">
                      </div>
					  
                    </div>
					
					<div class="form-group">
					
                      <label for="inputEmail3" class="col-sm-1 control-label">Nama Lengkap</label>
                      
					  <div class="col-sm-3">
                        <input type="text" name="ednamalengkap" class="form-control" id="exampleInputEmail1" placeholder="Nama Lengkap" value="<?php echo $val->name?>">
                      </div>
					  
                    </div>
					
					<div class="form-group">
					
                      <label for="inputEmail3" class="col-sm-1 control-label">No.HP</label>
                      
					  <div class="col-sm-3">
                        <input type="text" name="ednohp" class="form-control" id="exampleInputEmail1" placeholder="No.HP" value="<?php echo $val->phone?>">
                      </div>
					  
                    </div>
					
					<div class="form-group">
					
                      <label for="inputPassword3" class="col-sm-1 control-label">Alamat</label>
					  
                      <div class="col-sm-3">
                        <textarea name="memoalamat" class="form-control" rows="3" placeholder="Isi Alamat..."><?php echo $val->address?></textarea>
                      </div>
					  
                    </div>
					
					<!-- checkbox -->
                    <div class="form-group">
					
					<label for="inputEmail3" class="col-sm-1 control-label">Lock / Un Lock</label>
					
					<div class="col-sm-3">
                      <div class="checkbox">
                        <label>
                          <input type="checkbox" id="ChkIsReadOnly" onclick="GetIsReadOnly(this)" />
							<p id="ParIs_readonly"></p>
                        </label>
                      </div>
					 </div>
					  
					 </div>
					
					<!--
                    <div class="form-group">
                      <div class="col-sm-offset-2 col-sm-10">
                        <div class="checkbox">
                          <label>
                            <input type="checkbox"> Remember me
                          </label>
                        </div>
                      </div>
                    </div>
					-->
					
                  </div><!-- /.box-body -->
				  
				
				<div class="box-footer">
				
				<!--
                  <div class="pull-right">
                    <button class="btn btn-default"><i class="fa fa-reply"></i> Reply</button>
                    <button class="btn btn-default"><i class="fa fa-share"></i> Forward</button>
                  </div>
				  -->
				  
                  <button type="submit" class="btn btn-default"><i class="fa fa-save"></i> Simpan</button>
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
		
		<?php endforeach; ?>
		
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