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
							<!--<th>Unit Kerja</th>
							<th>NIP</th>-->
							<th>Nama</th>
							<th>Tanggal</th>
							<th>J.Datang</th>
							<th>J.Pulang</th>
							<th>Datang</th>

							<th>Terlambat</th>
							<th>Alasan</th>
							<th>Pimpinan</th>
							<th>Petugas</th>
							<!--<th>Keterangan</th>-->
							<th>Aksi</th>
						</tr>
					</thead>
					
				</table>
                </div><!-- /.box-body -->	
				
				<div class="box-footer">
					<!-- <button onclick="location.href='<?php echo site_url(); ?>/transaksi_ketidakhadiran/add_ketidakhadiran'" class="btn btn-primary" type="submit">Tambah Kehadiran</button>-->
				</div>
				
              </div><!-- /.box -->
			  
            </div><!-- /.col -->
          </div><!-- /.row -->	  
		  
        </section><!-- /.content -->
      </div><!-- /.content-wrapper -->
      
	  <!-- Modal -->

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

<script type="text/javascript">

	<?php 
	If ($this->session->userdata('level') == 'Pimpinan') 
	{ 
		$sURL = "/transaksi_ijintl/datatables_pegawai";
	}
	else If ($this->session->userdata('level') == 'Operator') 
	{
		$sURL = "/transaksi_ijintl/datatables_pegawai";
	}
	else If ($this->session->userdata('level') == 'Pegawai') 
	{
		$sURL = "/transaksi_ijintl/datatables_pegawai";
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
		
		//"bFilter": true,
		//"bSort": true,
            
		"sAjaxSource": site_url,
		
		//Set column definition initialisation properties.
        /*
		"columnDefs": [
        { 
          "targets": [ -1 ], //last column
          "orderable": false, //set not orderable
        },
        ]
		*/
			
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
	
	function detail_absen(id)
    {

		$.ajax({
		type:'POST',
		url:'<?php echo site_url().'/transaksi_ijintl/detail_absen';?>/'+id,
		success:function(data)
		{
			
			$('#bddetail').html(data);
			$('.help-block').empty(); // clear error string
			var size='large';
			var content = data;
			var title = 'Detail Absen';
												
			var footer = '<button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>';
			setModalBox(title,content,footer,size);
			
			//if success close modal and reload ajax table
			$('#myModal').modal('show');
			
		}
			
		});
				
    }
		
	function konfirmasi_tl(id)
	{
		
		window.location = '<?php echo site_url(); ?>' + '/transaksi_ijintl/add_ijintl/' + id;
		
	}
	
</script>