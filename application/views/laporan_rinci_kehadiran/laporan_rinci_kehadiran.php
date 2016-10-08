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
					echo form_error('edemail');
					echo form_error('ednohp');
				?> 
                      
        
          <div class="row">
                    
						<div class="col-md-6">
                            <!-- general form elements -->
                            <div class="box box-primary">
                                <div class="box-header">
                                    <h3 class="box-title">Laporan Kebutuhan Anggaran</h3>
                                </div><!-- /.box-header -->
								
                            <!-- form start -->
                                
							<form role="form" action = "<?php echo site_url(); ?>/laporan_rinci_kehadiran/layar">
								
                                    <div class="box-body">
									
										<!-- select -->
                                        <div class="form-group">
                                            <label>Pilih Bulan & Tahun</label>
											
                                            <select name="cboBulanTahun" class="form-control">
												<!-- <option>option 1</option> -->
                                                
												<?php 
												$date = $this->m_date->arrPeriode(24); 
												foreach ($date as $d): 
												$arrdate=explode('-',$d)
												?>
												
												<!-- echo date("M-d-Y", mktime(0, 0, 0, 12, 32, 1997))."<br>"; -->
												
												<option value="<?php echo date("Y-m-d", mktime(0, 0, 0, date($arrdate[1]),1, date($arrdate[0]))); ?>" 
												<?php //echo ($selected == $arrdate[0].'-'.$arrdate[1] ? 'selected' : '') ?>>
												<?php echo $arrdate[1].'-'.$arrdate[0]; ?>
												</option>
												<?php endforeach; ?>
                                                
                                            </select>									
											
                                        </div>
                                        
                                        <div class="form-group">
                                            <label for="exampleInputFile">Unit Kerja</label>
											                                           
                                            <select name="cboUnitKerja" class="form-control">
                                            
                                            	<?php foreach ($unit_kerja as $val){?>
                                            		<option value="<?php echo $val->unit_kerja;?>"><?php echo $val->unit_kerja;?></option>
                                            	<?php } ?>	 
                                            
                                            </select>
											
											<p class="help-block">Pastikan parameter yang tersedia tidak kosong </p>
											
                                        </div>
																			
										
                                    </div><!-- /.box-body -->

                                    <div class="box-footer">
																		
									<button name="save" type="submit" class="btn btn-primary">Generate</button>
										
                                    </div>
									
							</form>
							
                            </div><!-- /.box -->

                           
                        </div><!--/.col (left) -->
					
					</div>
		  
		  
		  
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