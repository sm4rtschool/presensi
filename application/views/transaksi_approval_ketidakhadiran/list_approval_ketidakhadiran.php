	<!-- DATA TABLES -->
    <link href="<?php echo base_url(); ?>asset/plugins/datatables/dataTables.bootstrap.css" rel="stylesheet" type="text/css" />
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
        
        <!--
        <div class="box-body">
        	<?php echo $this->session->flashdata('notif');?>  
        </div>
        -->
        
          <div class="row">
            <div class="col-xs-12">
             
              <div class="box">
                <div class="box-header">
                  <h3 class="box-title"><?php echo $tabletitle?></h3>
                </div><!-- /.box-header -->

				
                <div class="box-body">
                
                <?php echo $this->session->flashdata('notif');?> 
                
                <table id="dataTables-list" class="table table-bordered table-striped" cellspacing="0" width="100%">
					<thead>
						<tr>
							<th></th>
							<th>Unit Kerja</th>
							<th>NIP</th>
							<th>Nama</th>
							<th>Tanggal</th>
							<th>Kd Absen</th>
							<th>Keterangan</th>
							
							<?php If ($this->session->userdata('level') == 'Pimpinan') 
							{ 
								echo '<th>Status</th>';
							}
							else If ($this->session->userdata('level') == 'Operator') 
							{
								
								echo '<th>Pimpinan</th>';
								echo '<th>Petugas</th>';
								
							}
							?>
							
							<th>Aksi</th>
						</tr>
					</thead>
					
				</table>
                </div><!-- /.box-body -->			
              </div><!-- /.box -->
			  
            </div><!-- /.col -->
          </div><!-- /.row -->	  
		  
        </section><!-- /.content -->
      </div><!-- /.content-wrapper -->
	  
	  <style>
	  #history-absen-dialog {
		  width: 100%;
		  height: 100%;
		  margin: 0;
		  padding: 0;
		}

		#history-absen-content {
		  height: auto;
		  min-height: 100%;
		  border-radius: 0;
		}
	  </style>
      
      
	  <!-- Modal fullscreen -->
<div class="modal modal-fullscreen fade" id="modal-fullscreen" tabindex="-1" role="dialog" aria-labelledby="HistoryAbsenModalLabel" aria-hidden="true">
  
  <div class="modal-dialog" id="history-absen-dialog">
    <div class="modal-content" id="history-absen-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
        <h4 class="modal-title" id="HistoryAbsenModalLabel">History Absensi Pegawai</h4>
      </div>
      <div class="modal-body" id="modal-history-absen">
      
      </div>
	  
      <div class="modal-footer" id="modal-footerq-history-absen">
        
      </div>
	  
    </div>
  </div>
  
</div>


	  <!-- Modal -->

	  <form action="#" id="form" class="form-horizontal">
	  
                <!-- Modal form-->
                <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                  <div class="modal-dialog ">
                    <div class="modal-content">
					
                      <div class="modal-header">
					  
                        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                        <h4 class="modal-title" id="myModalLabel"></h4>
                      
					  </div>
					  
                      <div class="modal-body" id="modal-bodyku">
                      </div>
					  
                      <div class="modal-footer" id="modal-footerq">
                      </div>
					  
                    </div>
                  </div>
                </div>

	  </form>

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
    
    <!-- <link type="text/css" rel="stylesheet" href="<?php //echo base_url(); ?>css/style.css"> --> 
    <!-- <link type="text/css" rel="stylesheet" href="<?php //echo base_url(); ?>css/bootstrap.css"> --> 
    
    <!-- page script -->
	
	<?php
	/*
body {
  background: #72cffa;
}

 .modal-transparent 

.modal-transparent {
  background: transparent;
}
.modal-transparent .modal-content {
  background: transparent;
}
.modal-backdrop.modal-backdrop-transparent {
  background: #ffffff;
}
.modal-backdrop.modal-backdrop-transparent.in {
  opacity: .9;
  filter: alpha(opacity=90);
}

 .modal-fullscreen 

.modal-fullscreen {
  background: transparent;
}
.modal-fullscreen .modal-content {
  background: transparent;
  border: 0;
  -webkit-box-shadow: none;
  box-shadow: none;
}
.modal-backdrop.modal-backdrop-fullscreen {
  background: #ffffff;
}
.modal-backdrop.modal-backdrop-fullscreen.in {
  opacity: .97;
  filter: alpha(opacity=97);
}

 .modal-fullscreen size: we use Bootstrap media query breakpoints 

.modal-fullscreen .modal-dialog {
  margin: 0;
  margin-right: auto;
  margin-left: auto;
  width: 100%;
}
@media (min-width: 768px) {
  .modal-fullscreen .modal-dialog {
    width: 750px;
  }
}
@media (min-width: 992px) {
  .modal-fullscreen .modal-dialog {
    width: 970px;
  }
}
@media (min-width: 1200px) {
  .modal-fullscreen .modal-dialog {
     width: 1170px;
  }
}

 centering styles for jsbin 
html,
body {
  width:100%;
  height:100%;
}
html {
  display:table;
}
body {
  display:table-cell;
  vertical-align:middle;
}
body > .btn {
  display: block;
  margin: 0 auto;
}
*/
?>
	
<script type="text/javascript">

	<?php 
	If ($this->session->userdata('level') == 'Pimpinan') 
	{ 
		$sURL = "/transaksi_approval_ketidakhadiran/datatables_pimpinan";
	}
	else If ($this->session->userdata('level') == 'Operator') 
	{
		$sURL = "/transaksi_approval_ketidakhadiran/datatables_operator";
	}
	?>

	var site_url = "<?php echo site_url() . $sURL  ?>";
    var table;
    $(document).ready(function() {
      table = $('#dataTables-list').DataTable({ 
	  
		"bSort" : false,
		"sPaginationType": "full_numbers",
		"bAutoWidth": true, // Disable the auto width calculation
        "bProcessing": true, //Feature control the processing indicator.
        "bServerSide": true, //Feature control DataTables' server-side processing mode.
            
		"sAjaxSource": site_url
			
		// Load data for the table's content from an Ajax source
        /*
		"ajax": {
            "url": site_url,
            "type": "POST",
			
			error: function(){  // error handling
                    $(".table-error").html("");
                    $("#dataTables-list").append('<tbody class="employee-grid-error"><tr><th colspan="3">No data found in the server</th></tr></tbody>');
                    $("#table_processing").css("display","none");
					//"bProcessing": false; //Feature control the processing indicator.
                }			
        }
		*/
			
      });
    });
	
	function reload_table()
    {
      table.ajax.reload(null,false); //reload datatable ajax 
    }
</script>

<script type="text/javascript">
// .modal-backdrop classes

$(".modal-transparent").on('show.bs.modal', function () {
  setTimeout( function() {
    $(".modal-backdrop").addClass("modal-backdrop-transparent");
  }, 0);
});
$(".modal-transparent").on('hidden.bs.modal', function () {
  $(".modal-backdrop").addClass("modal-backdrop-transparent");
});

$(".modal-fullscreen").on('show.bs.modal', function () {
  setTimeout( function() {
    $(".modal-backdrop").addClass("modal-backdrop-fullscreen");
  }, 0);
});
$(".modal-fullscreen").on('hidden.bs.modal', function () {
  $(".modal-backdrop").addClass("modal-backdrop-fullscreen");
});

</script>

<script type="text/javascript">
	
	function proses_approval_ketidakhadiran(id, level)
    {

		$.ajax({
		type:'POST',
		url:'<?php echo site_url().'/transaksi_approval_ketidakhadiran/proses_approval_ketidakhadiran';?>/'+id,
		success:function(data)
		{
			
			$('#bddetail').html(data);
			$('.help-block').empty(); // clear error string
			var size='large';
			var content = data;
			var title = 'Proses Approval Pengajuan Ketidakhadiran Kerja Pegawai Oleh ' + level;
												
			//var footer = '<button type="button" id = "update_isapprove" class="btn btn-primary" data-dismiss="modal" id="btnproses" onclick="save()">Proses</button><button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>';
			var footer = '<button type="button" id = "update_isapprove" class="btn btn-primary" id="btnproses" onclick="save()">Proses</button><button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>';
			setModalBox(title,content,footer,size);
			
			//if success close modal and reload ajax table
			$('#myModal').modal('show');
			
		}
			
		});
				
    }
	
	function petugas_approval_ketidakhadiran(id, level, is_pimpinan_approve)
    {

		$.ajax({
		type:'POST',
		url:'<?php echo site_url().'/transaksi_approval_ketidakhadiran/petugas_approval_ketidakhadiran';?>/'+id,
		success:function(data){
			$('#bddetail').html(data);
			$('.help-block').empty(); // clear error string
			var size='large';
			var content = data;
			var title = 'Proses Approval Pengajuan Ketidakhadiran Kerja Pegawai Oleh Petugas';
			
			if (is_pimpinan_approve == 1)
			{
				var footer = '<button type="button" class="btn btn-primary" data-dismiss="modal" id="btnproses" onclick="petugas_approval_save()">Proses</button><button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>';
			}
			
			if (is_pimpinan_approve == 2)
			{
				var footer = '<button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>';
			}
			
			if (is_pimpinan_approve == 0)
			{
				var footer = '<button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>';
			}
			
			setModalBox(title,content,footer,size);
			$('#myModal').modal('show');
		}
		
		});
				
    }
	
	function history_absen(Tahun, sKdKaryawan, sNip, sNama, sDepartemen, sNamaJabatan)
    {
		
		/*
		$Tahun = $this->uri->segment(3);
		$sKdKaryawan = $this->uri->segment(4);
		$sNip = $this->uri->segment(5);		
		$sNama = $this->uri->segment(6);
		$sDepartemen = $this->uri->segment(7);
		$sNamaJabatan = $this->uri->segment(8);		
		*/

		$.ajax({
		type:'POST',
		url:'<?php echo site_url().'/transaksi_approval_ketidakhadiran/history_absen';?>/' + Tahun + '/' + sKdKaryawan + '/' + sNip + '/' + sNama + '/' + sDepartemen + '/' + sNamaJabatan,
		success:function(data)
		{
			
			$('#bddetail').html(data);
			$('.help-block').empty(); // clear error string
			var size='large';
			var content = data;
			var title = 'History Absensi ' + sNama + ' Tahun ' + Tahun;
												
			//var footer = '<button type="button" id = "update_isapprove" class="btn btn-primary" data-dismiss="modal" id="btnproses" onclick="save()">Proses</button><button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>';
			//var footer = '<button type="button" id = "update_isapprove" class="btn btn-primary" id="btnproses" onclick="save()">Proses</button><button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>';
			var footer = '<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>';
			setModalBoxHistory(title,content,footer,size);
			
			//if success close modal and reload ajax table
			$('#modal-fullscreen').modal('show');
			
		}
			
		});
				
    }
	
	
		function setModalBox(title,content,footer,$size)
        {
            document.getElementById('modal-bodyku').innerHTML=content;
            document.getElementById('myModalLabel').innerHTML=title;
            document.getElementById('modal-footerq').innerHTML=footer;
            if($size == 'large')
            {
                $('#myModal').attr('class', 'modal fade bs-example-modal-lg')
                             .attr('aria-labelledby','myLargeModalLabel');
                $('.modal-dialog').attr('class','modal-dialog modal-lg');
            }
            if($size == 'standart')
            {
                $('#myModal').attr('class', 'modal fade')
                             .attr('aria-labelledby','myModalLabel');
                $('.modal-dialog').attr('class','modal-dialog');
            }
            if($size == 'small')
            {
                $('#myModal').attr('class', 'modal fade bs-example-modal-sm')
                             .attr('aria-labelledby','mySmallModalLabel');
                $('.modal-dialog').attr('class','modal-dialog modal-sm');
            }
        }	
		
		function setModalBoxHistory(title,content,footer,$size)
        {
            document.getElementById('modal-history-absen').innerHTML=content;
            document.getElementById('HistoryAbsenModalLabel').innerHTML=title;
            document.getElementById('modal-footerq-history-absen').innerHTML=footer;
            if($size == 'large')
            {
                $('#modal-fullscreen').attr('class', 'modal fade bs-example-modal-lg')
                             .attr('aria-labelledby','myLargeModalLabel');
                $('.modal-dialog').attr('class','modal-dialog modal-lg');
            }
            if($size == 'standart')
            {
                $('#modal-fullscreen').attr('class', 'modal fade')
                             .attr('aria-labelledby','HistoryAbsenModalLabel');
                $('.modal-dialog').attr('class','modal-dialog');
            }
            if($size == 'small')
            {
                $('#modal-fullscreen').attr('class', 'modal fade bs-example-modal-sm')
                             .attr('aria-labelledby','mySmallModalLabel');
                $('.modal-dialog').attr('class','modal-dialog modal-sm');
            }
        }	
</script>

<script type = "text/javascript">
	function save()
    {
		
            var is_approve = $('#is_approve').val();
			
            if ($("#is_approve:checked").length == 0){
                //$('.is_approveValidation').text("Persetujuan harus dipilih !!");
                alert('Persetujuan harus dipilih !!');
				$('#myModal').modal('show');
                //return false;
            }			
			
			if ($("#is_approve:checked").length != 0){
			
			// ajax adding data to database
          	$.ajax({
            url : "<?php echo site_url(); ?>/transaksi_approval_ketidakhadiran/ajax_proses_approval",
            type: "POST",
            data: $('#form').serialize(),
            dataType: "JSON",
            success: function(data)
			{
 
				if(data.status) //if success close modal and reload ajax table
				{
					
					//reload_table();
					alert('Proses approval berhasil');
					$('#myModal').modal('hide');
					reload_table();
					return true;
					
				}
				else
				{
					for (var i = 0; i < data.inputerror.length; i++) 
					{
						$('[name="'+data.inputerror[i]+'"]').parent().parent().addClass('has-error'); //select parent twice to select div form-group class and add has-error class
						$('[name="'+data.inputerror[i]+'"]').next().text(data.error_string[i]); //select span help-block class set text error string
					}
					$('#myModal').modal('hide');
					alert('Error');
					return false;
				}
			
				//$('#btnSave').text('Save'); //change button text
				//$('#btnSave').attr('disabled',false); //set button enable 
 
			},
			error: function (jqXHR, textStatus, errorThrown)
			{
				alert('Error adding / update data');
				$('#btnSave').text('Save'); //change button text
				$('#btnSave').attr('disabled',false); //set button enable 
			}
			
			});
			
			}
			
    }
</script>

<script type = "text/javascript">
	function petugas_approval_save()
    {
		
       		// ajax adding data to database
          	$.ajax({
            url : "<?php echo site_url(); ?>/transaksi_approval_ketidakhadiran/ajax_proses_approval_bypetugas",
            type: "POST",
            data: $('#form').serialize(),
            dataType: "JSON",
            success: function(data)
			{
 
				if(data.status) //if success close modal and reload ajax table
				{
					$('#myModal').modal('hide');
					reload_table();
					alert('Proses approval berhasil');
				}
				else
				{
					for (var i = 0; i < data.inputerror.length; i++) 
					{
						$('[name="'+data.inputerror[i]+'"]').parent().parent().addClass('has-error'); //select parent twice to select div form-group class and add has-error class
						$('[name="'+data.inputerror[i]+'"]').next().text(data.error_string[i]); //select span help-block class set text error string
					}
					alert('gembel');
				}
			
				//$('#btnSave').text('Save'); //change button text
				//$('#btnSave').attr('disabled',false); //set button enable 
 
			},
			error: function (jqXHR, textStatus, errorThrown)
			{
				alert('Error adding / update data');
				$('#btnSave').text('Save'); //change button text
				$('#btnSave').attr('disabled',false); //set button enable 
			}
			
			});
			
    }
</script>