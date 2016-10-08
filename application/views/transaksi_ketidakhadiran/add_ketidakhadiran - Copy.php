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
          
            <!-- left column -->
            <div class="col-md-12">
			
              <!-- general form elements -->
              <div class="box box-primary">
                
				<div class="box-header with-border">
                  <h3 class="box-title">Isilah data transaksi ketidakhadiran dengan lengkap dan benar.</h3>
                </div><!-- /.box-header -->
                
				<!-- form start -->
                <form class="form-horizontal" method="POST" action="<?php echo site_url(); ?>/transaksi_ketidakhadiran/save_add">
				
                  <div class="box-body">
				  
                    <div class="form-group">
					
                      <label for="inputEmail3" class="col-sm-1 control-label">Dari Tanggal</label>
                      
					  <div class="col-sm-3">
                        <input type="text" name="edtgldari" class="form-control" id='dtptanggal_dari' placeholder="Isi Dari Tanggal..." required="required">
                      </div>
					  
                    </div>
					
                 
					
					<div class="form-group">
					
                      <label for="inputEmail3" class="col-sm-1 control-label">Sampai Tanggal</label>
                      
					  <div class="col-sm-3">
                        <input type="text" name="edtglsampai" class="form-control" id='dtptanggal_sampai' placeholder="Isi Sampai Tanggal..." required>
                      </div>
					  
                    </div>
					
					<div class="form-group">
					
                      <label for="inputEmail3" class="col-sm-1 control-label">Alasan</label>
                      
					  <div class="col-sm-3">
                      
						<select id = "cboalasan" class="form-control select2" name="cboalasan" required="required">
						<option selected="selected">- Pilih Alasan -</option>
						
						<?php //foreach ($msjenisketidakhadiran as $val){?>
							
							<option value = "<?php echo $val->KdJenisKetidakhadiran;?>"><?php echo $val->Jenis;?></option>
						
						<?php } ?>
						
						</select>
					  
					  </div>
					  
                    </div>
					
					<div class="form-group">
					
                      <label for="inputEmail3" class="col-sm-1 control-label">Pimpinan</label>
                      
					  <div class="col-sm-3">
                      
						<select class="form-control select2" name="cbopimpinan">
						
							<option selected="selected">- Pilih Pimpinan -</option>
						
							<?php foreach ($mspimpinan as $val){?>
							
							<option value = "<?php echo $val->id; ?>"><?php echo $val->fname; ?></option>
						
							<?php }?>
						
						</select>
					  
					  </div>
					  
                    </div>
                    
                    <div class="form-group">
                      
					  <label for="inputPassword3" class="col-sm-1 control-label">Lampiran</label>
					  
					  <div class="col-sm-3">
                        <input type="file" id="exampleInputFile">
						<p class="help-block">Pastikan Anda mengupload file gambar / pdf.</p>
                      </div>
					  
                    </div>
					
					<div class="form-group">
					
                      <label for="inputPassword3" class="col-sm-1 control-label">Keterangan</label>
					  
                      <div class="col-sm-3">
                        <textarea name="memoketerangan" class="form-control" rows="3" placeholder="Isi Keterangan..."></textarea>
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
                  
                  <button type="button" onClick="window.location='<?php echo site_url();?>/beranda';" class="btn btn-default"><i class="fa fa-undo"></i> Cancel</button>
                  
				  
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
	
	<!-- datepicker --> 
	<script src="<?php echo base_url(); ?>asset/plugins/datepicker/bootstrap-datepicker.js" type="text/javascript"></script>
	<link href="<?php echo base_url(); ?>asset/plugins/datepicker/datepicker3.css" rel="stylesheet" type="text/css" />
		
	<!-- Page script -->
    <script>
      $(function () {
        //Initialize Select2 Elements
        $(".select2").select2();
	  })
    </script>
	
	<script type="text/javascript">
	
		$('#dtptanggal_dari').datepicker({
		autoclose: true,
		todayHighlight: true,
		format: 'dd/mm/yyyy'
		});
		
		$('#dtptanggal_sampai').datepicker({
		autoclose: true,
		todayHighlight: true,
		format: 'dd/mm/yyyy'
		});
		
	</script>
	
	<script type="text/javascript">
		$('#select-tugas').select2({
        minimumInputLength: 3,
        multiple: false,
        ajax: {
            type: "POST",
            url: '<?php echo site_url();?>/mspekerjaan/getJsonTugas',
            dataType: 'json',
            contentType: "application/json",
            delay: 250,
            data: function (params) {
                return  JSON.stringify({
                    term: params.term
                });
            },
            processResults: function (data) {
                return {
                    results: $.map(data, function (item, i) {
                        return {
                            text: item.nama,
                            id: item.id_tugas
                        }
                    })
                };
            }
        },
    });		
    </script>
	
	<script type = "text/javascript">
	
		 //get a reference to the select element
                        $select = $('#cboalasan');
                        //request the JSON data and parse into the select element
                        $.ajax({
                            url: "<?php echo  site_url('dealer_controller/dealer_list')?>", 
							dataType: 'JSON', 
							success: function(data)
							{
                                //clear the current content of the select
                                $select.html('');
                                //iterate over the data and append a select option
                                $.each(data.dealer, function (key, val) {
                                    $select.append('<option value = "' + val.id + '">' + val.name + '</option>');
                                })
                            }
                            , error: function () { <strong>
                                //if there is an error append a 'none available' option
                                $select.html('<option id="-1">none available</option>');
                            }
                        });
	
	</script>