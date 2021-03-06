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
					echo form_error('edtgldari');
					echo form_error('edtglsampai');
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
                  <h3 class="box-title">Isilah data transaksi ketidakhadiran dengan lengkap dan benar.</h3>
                </div><!-- /.box-header -->
                
				<!-- form start -->
                <form class="form-horizontal" method="POST" action="<?php echo site_url(); ?>/transaksi_ketidakhadiran/save_add" enctype="multipart/form-data">
				
                  <div class="box-body">
				  
                    <div class="form-group">
					
                      <label for="inputEmail3" class="col-sm-1 control-label">Tanggal Absen</label>
                      
					  <div class="col-sm-3">
                        <input type="text" name="edtgldari" class="form-control" id='dtptanggal_dari' placeholder="Isi Tanggal Absen..." required="required">
                      </div>
					  
                    </div>
					
					<div class="form-group">
					
                      <label for="inputEmail3" class="col-sm-1 control-label">Jenis Absen</label>
                      
					  <div class="col-sm-3">
                        <label for="inputEmail3" class="col-sm-1 control-label">Hadir</label>
                      </div>
					  
                    </div>
					
					<div class="form-group">
					
                      <label for="inputEmail3" class="col-sm-1 control-label">Jam Absen</label>
                      
					  <div class="col-sm-3">
                        <label for="inputEmail3" class="col-sm-1 control-label">Hadir</label>
                      </div>
					  
                    </div>
					
					<!-- radio -->
                    <div class="form-group">
					
						<label for="inputEmail3" class="col-sm-1 control-label">IN / OUT</label>
						
						<div class="col-sm-3">
                        
						
							<div class="radio">
                        <label>
                          <input type="radio" name="optionsRadios" id="optionsRadios1" value="option1" checked />
                          IN
                        </label>
                      </div>
                      <div class="radio">
                        <label>
                          <input type="radio" name="optionsRadios" id="optionsRadios2" value="option2" />
                          OUT
                        </label>
                      </div>
						
						</div>
					
                    </div>
					                    
                    <div class="form-group">
                      
					  <label for="inputPassword3" class="col-sm-1 control-label">Lampiran</label>
					  
					  <div class="col-sm-3">
                        <input type="file" name = "userfile" id="attachment">
						<p class="help-block">Pastikan Anda mengupload file gambar / pdf.</p>
                      </div>
					  
					  <div id="uploads">

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
                  
                  <button type="button" onClick="window.location='<?php echo site_url();?>/transaksi_ketidakhadiran';" class="btn btn-default"><i class="fa fa-undo"></i> Cancel</button>
                  
				  
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
	
	<script src="<?php echo base_url()?>asset/plugins/jQuery/ajaxfileupload.js"></script>
	<script src="<?php echo base_url()?>asset/plugins/jQuery/site.js"></script>
		
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
	$(document).ready(function()
	{
		
		load_dropdown_alasan();
		
		$('#cboalasan').change(function()
		{
			
			var KdJenisKetidakhadiran = $('#cboalasan').val();
			
			/*
			$.ajax({
			url: '<?php echo site_url() . '/transaksi_ketidakhadiran/GetIsLimit/'; ?>/' + KdJenisKetidakhadiran,
			cache: false, 
			dataType: "json",
			timeout:3000,
			success : function(data){
				
				//y = data["is_limit"];
				//alert('The id number is '+ y);
				//$('#is_limit').val(y);
				
				//$('#is_limit').val(data['is_limit']);
				
				alert(data);
				
			},
			error : function (xmlHttpRequest, textStatus, errorThrown){
				alert("Error " + errorThrown);
				if(textStatus==='timeout')
				alert("request timed out");
			}
			});
			*/
						
			//alert(KdJenisKetidakhadiran);						
						
			//$.getJSON('index.php',{action:'getpersons', kdkaryawan:$(this).val()}, function(json){
    		//$.getJSON('<?php echo site_url();?>/transaksi_ketidakhadiran/GetIsLimit/' + $("#cboalasan").text(), 
						
			//$.getJSON('<?php echo site_url() . '/transaksi_ketidakhadiran/GetIsLimit/'; ?>/' + $("cboalasan").val(),
			//$.getJSON('<?php echo site_url() . '/transaksi_ketidakhadiran/GetIsLimit/'; ?>/' + KdJenisKetidakhadiran,
			
			
			$.getJSON('<?php echo site_url() . '/transaksi_ketidakhadiran/GetIsLimit/'; ?>/' + KdJenisKetidakhadiran,
			function(json)
			{
    						
				if (json == null)
				{
					alert("json nya kosong");
    			} 
				else
				{
					
					//alert("json nya ajib");
					$('#is_limit').val(json.ex_jenisketidakhadiran[0].is_limit);
													
    			}
    		});
			
						
    	});
		
	});	
	
	function load_dropdown_alasan(){
				
			//$("#cboalasan").change(function(){ //any select change on the dropdown with id country trigger this code
		
			//get a reference to the select element
			var $cboalasan = $('#cboalasan');
        
			//request the JSON data and parse into the select element
			$.ajax({
			url:'<?php echo site_url() . '/transaksi_ketidakhadiran/load_dropdown_alasan'; ?>',
			dataType: 'JSON', 
			success: function(data){

				//clear the current content of the select
				$cboalasan.html('');
				
				$cboalasan.append('<option value = "- Pilih Alasan -">- Pilih Alasan -</option>');
				
				//iterate over the data and append a select option
				$.each(data.ex_jenisketidakhadiran, function (key, val){
					$cboalasan.append('<option value = "' + val.KdJenisKetidakhadiran + '">' + val.Jenis + ' | ' + val.PersenPotonganTK + ' % </option>');
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
	</script>
	
	<script type="text/javascript">
	/*
    			$(document).ready(function()
				{
    				
					$('#cboalasan').change(function()
					{
						
						var KdJenisKetidakhadiran = $("cboalasan").val()
						
						//$.getJSON('index.php',{action:'getpersons', kdkaryawan:$(this).val()}, function(json){
    					//$.getJSON('<?php echo site_url();?>/transaksi_ketidakhadiran/GetIsLimit/' + $("#cboalasan").text(), 
						
						//$.getJSON('<?php echo site_url() . '/transaksi_ketidakhadiran/GetIsLimit/'; ?>/' + $("cboalasan").val(),
						$.getJSON('<?php echo site_url() . '/transaksi_ketidakhadiran/GetIsLimit/'; ?>/' + KdJenisKetidakhadiran,
						function(json)
						{
    						if (json == null)
							{
    							$('#is_limit').text('');
    							//$('#first_name').val('');
    							//$('#last_name').val('');
    						} 
							else
							{
    							$('#is_limit').text(json.is_limit);
    							//$('#first_name').val(json.first_name);
    							//$('#last_name').val(json.last_name);
    						}
    					});
						
    				});
					
    			});
				*/
    </script>
	
	<script type="text/javascript">
	/*
		$(document).ready(function() 
		{
			$("#attachment").AjaxFileUpload({
				onComplete: function(filename, response) {
					$("#uploads").append(
						$("<img />").attr("src", filename).attr("width", 200)
					);
				}
			});
		});
	*/
	</script>