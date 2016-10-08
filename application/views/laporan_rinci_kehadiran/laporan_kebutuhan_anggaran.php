	<!-- begin content-->
	
	<!-- Right side column. Contains the navbar and content of the page -->
    <aside class="right-side">
	
	<!-- Content Header (Page header) -->
                <section class="content-header">
                    <h1>
                        Laporan
                        <small> Kebutuhan Anggaran</small>
                    </h1>
                    <ol class="breadcrumb">
                        <li><a href="#"><i class="fa fa-dashboard"></i> Laporan</a></li>
                        <li class="active">Kebutuhan Anggaran</li>
                    </ol>
                </section>
				
		
	<!-- Begin Data Tables -->
	
	
	<form name="f_laporan_keb_anggaran" action="<?php echo site_url();?>/laporan_kebutuhan_anggaran/generate_laporan_anggaran" method="post" enctype="multipart/form-data">
				
				
				<section class="content">
	
                    <div class="row">
                    
						<div class="col-md-6">
                            <!-- general form elements -->
                            <div class="box box-primary">
                                <div class="box-header">
                                    <h3 class="box-title">Laporan Kebutuhan Anggaran</h3>
                                </div><!-- /.box-header -->
                                <!-- form start -->
                                
								<!-- <form role="form"> -->
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
											
                                        </div>
										
										<div class="form-group">
                                
                                            <label for="exampleInputEmail1">Pengali Bulan</label>
                                            <input type="text" name="edpengalibulan" class="form-control" placeholder="Isi pengali bulan">
											
                                            <p class="help-block">Pastikan parameter yang tersedia tidak kosong </p>
                                        </div>
										
										
                                    </div><!-- /.box-body -->

                                    <div class="box-footer">
									
									<!-- <button onclick="location.href='<?php echo site_url(); ?>/user/add'" Tambah User</button> -->
																		
										<button name="save" type="submit" class="btn btn-primary">Generate</button>
										
                                    </div>
                            <!--    </form> -->
                            </div><!-- /.box -->

                           
                        </div><!--/.col (left) -->
					
					</div>

                </section><!-- /.content -->
				
	</form>
				
				</aside><!-- /.right-side -->
        </div><!-- ./wrapper -->
				
		
		
		
	
		<script src="//ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
        <script src="//maxcdn.bootstrapcdn.com/bootstrap/3.2.0/js/bootstrap.min.js" type="text/javascript"></script>
        <!-- AdminLTE App -->
        <script src="<?php echo base_url();?>asset-master/js/AdminLTE/app.js" type="text/javascript"></script>
        <!-- AdminLTE for demo purposes -->
        <script src="<?php echo base_url();?>asset-master/js/AdminLTE/demo.js" type="text/javascript"></script>     
        

	<!-- end content-->
