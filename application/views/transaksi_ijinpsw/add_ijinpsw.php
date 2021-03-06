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
        
        <?php 
			if ($is_posting_data == 0)
			{
				foreach ($tabsen->result() as $val):
		?>
		
		<!-- Main content -->
        <section class="content">               
   
                 
                                        
                <?php $this->session->flashdata('notif'); ?>  
				<?php
					echo form_error('cboalasan');
					echo form_error('cbopimpinan');
					echo form_error('userfile');
				?> 
                      
        
          <div class="row">
          
            <!-- left column -->
            <div class="col-md-12">
			
              <!-- general form elements -->
              <div class="box box-primary">
                
				<div class="box-header with-border">
                  <h3 class="box-title">Isilah data transaksi pulang sebelum waktu dengan lengkap dan benar.</h3>
                </div><!-- /.box-header -->
                
				<!-- form start -->
                <form id = "f_konfirmasi_psw" class="form-horizontal" method="POST" action="<?php echo site_url(); ?>/transaksi_ijinpsw/save_add" enctype="multipart/form-data">
				
                  <div class="box-body">
				  
                    <div class="form-group">
					
                      <label for="inputEmail3" class="col-sm-1 control-label">Jadwal Datang</label>
                      
					  <div class="col-sm-3">
                        <label for="inputEmail3" class="col-sm-1 control-label"><?php echo date('h:i:s', strtotime($val->WorkOn)); ?></label>
                      </div>
					  
                    </div>
										
					<div class="form-group">
					
                      <label for="inputEmail3" class="col-sm-1 control-label">Jadwal Pulang</label>
                      
					  <div class="col-sm-3">
                        <label for="inputEmail3" class="col-sm-1 control-label"><?php echo date('h:i:s', strtotime($val->WorkOff)); ?></label>
                      </div>
					  
                    </div>
				  
                    <div class="form-group">
					
                      <label for="inputEmail3" class="col-sm-1 control-label">Jam Datang</label>
                      
					  <div class="col-sm-3">
                        <label for="inputEmail3" class="col-sm-1 control-label"><?php echo date('h:i:s', strtotime($val->DutyOn)); ?></label>
                      </div>
					  
                    </div>
										
					<div class="form-group">
					
                      <label for="inputEmail3" class="col-sm-1 control-label">Jam Pulang</label>
                      
					  <div class="col-sm-3">
                        <label for="inputEmail3" class="col-sm-1 control-label"><?php echo date('h:i:s', strtotime($val->DutyOff)); ?></label>
                      </div>
					  
                    </div>
					
					<div class="form-group">
					
                      <label for="inputEmail3" class="col-sm-1 control-label">Jumlah PSW</label>
                      
					  <div class="col-sm-3">
                        <label for="inputEmail3" class="col-sm-1 control-label"><?php echo $val->HomeEarly; ?>&nbsp;Menit</label>
                      </div>
					  
                    </div>
					
					<div class="form-group">
					
                      <label for="inputEmail3" class="col-sm-1 control-label">Alasan</label>
                      
					  <div class="col-sm-3">
                      
						<select id = "cboalasan" class="form-control select2" name="cboalasan" required="required">
						
						<option selected="selected">- Pilih Alasan -</option>
											
						</select>
					  
					  </div>
					  
                    </div>
					
					<input type = "hidden" id = "idabsen" name = "idabsen" value = "<?php echo $val->idabsen; ?>">
									
					<div class="form-group">
					
                      <label for="inputEmail3" class="col-sm-1 control-label">Pimpinan</label>
                      
					  <div class="col-sm-3">
                      
						<select id = "cbopimpinan" class="form-control select2" name="cbopimpinan" required="required">
						
							<option selected="selected">- Pilih Pimpinan -</option>
						
						</select>
					  
					  </div>
					  
                    </div>
                    
                    <div class="form-group">
                      
					  <label for="inputPassword3" class="col-sm-1 control-label">Lampiran</label>
					  
					  <div class="col-sm-3">
                        <input type="file" name = "userfile" id="attachment" accept=".jpg, .png, .pdf" required>
						<p class="help-block">Pastikan Anda mengupload file gambar / pdf.</p>

						<div id="preview_image">
							
						</div>
							
						<p id="error2" style="display:none; color:#FF0000;">
						Maximum File Size Limit is 2 MB.
						</p>
						
						<p class="help-block">File Size is : <b><label id="lblSize" /></b></p>
						
                      </div>
					  
                    </div>
					
					<!--
					<div class="form-group">
					
                      <label for="inputPassword3" class="col-sm-1 control-label">Keterangan</label>
					  
                      <div class="col-sm-3">
                        <textarea name="memoketerangan" class="form-control" rows="3" placeholder="Isi Keterangan..."></textarea>
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
				  
                  <button name="submit" type="submit" class="peringatan btn btn-default" id = "submit"><i class="fa fa-save"></i> Simpan</button>
                  
                  <button type="button" onClick="window.location='<?php echo site_url();?>/transaksi_ijinpsw/';" class="btn btn-default"><i class="fa fa-undo"></i> Cancel</button>
                  
				  
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
        
        <?php endforeach;} ?>
        
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
	
	<script src="<?php echo base_url()?>asset/plugins/jQuery/ajaxfileupload.js"></script>
	<script src="<?php echo base_url()?>asset/plugins/jQuery/site.js"></script>
		
	<!-- Page script -->
    <script>
      $(function () {
        //Initialize Select2 Elements
        $(".select2").select2();
	  })
    </script>
	
	<script type = "text/javascript">
	$(document).ready(function()
	{
		
		// add
		$("#preview_image").append("<img id='blah' src='#' alt='' class='post_images' width='700' height='750' title='Attachment' rel='lightbox' />")
		load_dropdown_alasan();
		load_dropdown_pimpinan();
		
		// $("#f_konfirmasi_psw").submit(function (e){
        $("#f_konfirmasi_psw").submit(function (){
            //e.preventDefault();
            //e.preventDefault();
			
			if ($("#cboalasan").val() == '- Pilih Alasan -')
			{
				alert('Alasan harus diisi');
				return false;
			}
			
			if ($("#cbopimpinan").val() == '- Pilih Pimpinan -')
			{
				alert('Pimpinan harus diisi');
				return false;
			}
			
			/*
            var url = $(this).attr('action');
            var data = $(this).serialize();
            $.ajax({
                url:url,
                type:'POST',
                data:data
            }).done(function (data){
                //$("#response").html(data);
                //$("#loader").hide();
				alert(data);
            });
			*/
		
		});	
				
			
		function load_dropdown_alasan(){
			
			//get a reference to the select element
			var $cboalasan = $('#cboalasan');
        
			//request the JSON data and parse into the select element
			$.ajax({
			url:'<?php echo site_url() . '/transaksi_ijinpsw/load_dropdown_alasan'; ?>',
			dataType: 'JSON', 
			success: function(data){

					//clear the current content of the select
					$cboalasan.html('');
				
					$cboalasan.append('<option value = "- Pilih Alasan -">- Pilih Alasan -</option>');
				
					//iterate over the data and append a select option
					$.each(data.msalasan_psw, function (key, val){
					$cboalasan.append('<option value = "' + val.id_alasan + '">' + val.alasan + '</option>');
					//$cboalasan.append('<option value = "' + val.KdJenisKetidakhadiran + '">' + val.Jenis + ' <br/> <small>' + val.PersenPotonganTK + ' % </small></option>');
				})

			}, 			
			error: function(){
								//<strong>
                                //if there is an error append a 'none available' option
                                $cboalasan.html('<option value = "-1">- Data Alasan Tidak Ada -</option>');
                            }
							
			});
		}
		
		function load_dropdown_pimpinan(){
			
			//get a reference to the select element
			var $cbopimpinan = $('#cbopimpinan');
        
			//request the JSON data and parse into the select element
			$.ajax({
			url:'<?php echo site_url() . '/transaksi_ijintl/load_dropdown_pimpinan'; ?>',
			dataType: 'JSON', 
			success: function(data){

					//clear the current content of the select
					$cbopimpinan.html('');
				
					$cbopimpinan.append('<option value = "- Pilih Pimpinan -">- Pilih Pimpinan -</option>');
				
					//iterate over the data and append a select option
					$.each(data.pimpinan, function (key, val){
					$cbopimpinan.append('<option value = "' + val.idkaryawan + '">' + val.nama_karyawan + '</option>');
				})

			}, 			
			error: function(){
								//<strong>
                                //if there is an error append a 'none available' option
                                $cbopimpinan.html('<option value = "-1">- Data Pimpinan Tidak Ada -</option>');
                            }
							
			});
		}
			
	});
	</script>
	
	<script type="text/javascript">
	
	function readURL(input) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();
            
            reader.onload = function (e) {
                $('#blah').attr('src', e.target.result);
            }
            
            reader.readAsDataURL(input.files[0]);
        }
    }
    
    $("#attachment").change(function(){
		
		var iSize = ($("#attachment")[0].files[0].size / 1024); 
		if (iSize / 1024 > 1) 
		{ 
			if (((iSize / 1024) / 1024) > 1) 
			{ 
				iSize = (Math.round(((iSize / 1024) / 1024) * 100) / 100);
				$("#lblSize").html( iSize + "Gb"); 
			}
			else
			{ 
				iSize = (Math.round((iSize / 1024) * 100) / 100)
				$("#lblSize").html( iSize + "Mb"); 
			} 
		} 
		else 
		{
			iSize = (Math.round(iSize * 100) / 100)
			$("#lblSize").html( iSize  + "kb"); 
		}    
		
    });
	
	</script>
	
	<script type = "text/javascript">
	
		$('#attachment').attr('src', '');
	
		$('input[type="submit"]').prop("disabled", true);
		var a=0;

		//binds to onchange event of your input field
		$('#attachment').bind('change', function(){

		if ($('input:submit').attr('disabled',false)){
			$('input:submit').attr('disabled',true);
		}

		var ext = $('#attachment').val().split('.').pop().toLowerCase();

		if ($.inArray(ext, ['gif','png','jpg','jpeg','pdf']) == -1)
		{
			$('#error1').slideDown("slow");
			$('#error2').slideUp("slow");
			a=0;
		}
		else
		{
	
			var picsize = (this.files[0].size);
			
			if (picsize > 2000000)	// 2 Mb
			{
				$('#error2').slideDown("slow");
				a=0;
				// remove
				$("#blah img:last-child").remove()
				$('#blah').attr('src', '');
				$("#lblSize").html(""); 
				var $el = $('#attachment');
				$el.wrap('<form>').closest('form').get(0).reset();
				$el.unwrap();				
			}
			else
			{
				a=1;
				$('#error2').slideUp("slow");
				readURL(this);
				//var $el = $('#attachment');
				//$el.wrap('<form>').closest('form').get(0).reset();
				//$el.unwrap();
			}
			
			$('#error1').slideUp("slow");
			if (a==1){
				$('input:submit').attr('disabled',false);
			}
			
		}
		});
			
	</script>