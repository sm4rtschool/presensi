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
		
		<?php 
		
		function indonesian_date ($timestamp = '', $date_format = 'l, j F Y', $suffix = '') 
		{
		
		if (trim ($timestamp) == '')
		{
            $timestamp = time ();
		}
		elseif (!ctype_digit ($timestamp))
		{
			$timestamp = strtotime ($timestamp);
		}
    
		# remove S (st,nd,rd,th) there are no such things in indonesia :p
		$date_format = preg_replace ("/S/", "", $date_format);
		$pattern = array(
        '/Mon[^day]/','/Tue[^sday]/','/Wed[^nesday]/','/Thu[^rsday]/',
        '/Fri[^day]/','/Sat[^urday]/','/Sun[^day]/','/Monday/','/Tuesday/',
        '/Wednesday/','/Thursday/','/Friday/','/Saturday/','/Sunday/',
        '/Jan[^uary]/','/Feb[^ruary]/','/Mar[^ch]/','/Apr[^il]/','/May/',
        '/Jun[^e]/','/Jul[^y]/','/Aug[^ust]/','/Sep[^tember]/','/Oct[^ober]/',
        '/Nov[^ember]/','/Dec[^ember]/','/January/','/February/','/March/',
        '/April/','/June/','/July/','/August/','/September/','/October/',
        '/November/','/December/',
		);
		
		$replace = array( 'Sen','Sel','Rab','Kam','Jum','Sab','Min',
        'Senin','Selasa','Rabu','Kamis','Jumat','Sabtu','Minggu',
        'Jan','Feb','Mar','Apr','Mei','Jun','Jul','Ags','Sep','Okt','Nov','Des',
        'Januari','Februari','Maret','April','Juni','Juli','Agustus','Sepember',
        'Oktober','November','Desember',
		);
    
		$date = date ($date_format, $timestamp);
		$date = preg_replace ($pattern, $replace, $date);
		$date = "{$date} {$suffix}";
		return $date;
		
		} 
		
		?>
        
        <!-- Main content -->
        <section class="invoice">
          <!-- title row -->
          <div class="row">
            <div class="col-xs-12">
              <h2 class="page-header">
                <i class="fa fa-globe"></i> DAFTAR PEGAWAI YANG HADIR 
				
                <small class="pull-right">
					<?php
						$waktu_sekarang = Date('Y-m-d');;
						echo indonesian_date($waktu_sekarang);
					?>
				</small>
				
              </h2>
            </div><!-- /.col -->
          </div>

          <!-- Table row -->
          <div class="row">
            <div class="col-xs-12 table-responsive">
              <table class="table table-striped">
                <thead>
                  <tr>
                    <th>No.</th>
                    <th>NIP</th>
                    <th>Nama</th>
                    <th>Datang</th>
                    <th>Pulang</th>
                  </tr>
                </thead>
                <tbody>
				
                <?php 
				$no = 1;
				foreach($getlist_kehadiran->result() as $val){
				?>
				
                  <tr>
				  
                    <td><?php echo $no ?></td>
                    <td><?php echo $val->nip ?></td>
                    <td><?php echo $val->Nama ?></td>
                    <td><?php if ($val->DutyOn != NULL){echo date('H:i:s', strtotime($val->DutyOn));} ?></td>
                    <td>
						<?php 
						
							if ($val->DutyOff != NULL) 
							{
								echo date('H:i:s', strtotime($val->DutyOff)); 
							}
							
						?>
					</td>
					
                  </tr>
				  
				<?php 
				$no++;
				} 
				?>
				  
                </tbody>
              </table>
            </div><!-- /.col -->
          </div><!-- /.row -->
		  
        </section><!-- /.content -->
		
        <div class="clearfix"></div>
		
		<!-- Main content -->
        <section class="invoice">
          <!-- title row -->
          <div class="row">
            <div class="col-xs-12">
              <h2 class="page-header">
                <i class="fa fa-globe"></i> DAFTAR PEGAWAI YANG TIDAK HADIR
                <small class="pull-right">
					<?php
						$waktu_sekarang = Date('Y-m-d');;
						echo indonesian_date($waktu_sekarang);
					?></small>
              </h2>
            </div><!-- /.col -->
          </div>
			
          <!-- Table row -->
          <div class="row">
            <div class="col-xs-12 table-responsive">
              <table class="table table-striped">
			  
                <thead>
                  <tr>
                    <th>No.</th>
                    <th>NIP</th>
                    <th>Nama</th>
                    <th>Keterangan</th>
                  </tr>
                </thead>
				
                <tbody>
				
				
				<?php 
				$no = 1;
				foreach($getlist_ketidakhadiran->result() as $val){
				?>
				
                  <tr>
				  
                    <td><?php echo $no ?></td>
                    <td><?php echo $val->nip ?></td>
                    <td><?php echo $val->Nama ?></td>
                    <td><?php echo $val->Jenis ?></td>
					
                  </tr>
				  
				<?php 
				$no++;
				} 
				?>
                  
                </tbody>
				
              </table>
            </div><!-- /.col -->
          </div><!-- /.row -->
        </section><!-- /.content -->
		
        <div class="clearfix"></div>
		
		<!-- Main content -->
        <section class="invoice">
          <!-- title row -->
          <div class="row">
            <div class="col-xs-12">
              <h2 class="page-header">
                <i class="fa fa-globe"></i> DAFTAR PEGAWAI YANG TIDAK HADIR (TANPA KETERANGAN)
                <small class="pull-right">
					<?php
						$waktu_sekarang = Date('Y-m-d');;
						echo indonesian_date($waktu_sekarang);
					?>
				</small>
              </h2>
            </div><!-- /.col -->
          </div>

          <!-- Table row -->
          <div class="row">
            <div class="col-xs-12 table-responsive">
              <table class="table table-striped">
                <thead>
                  <tr>
                    <th>No.</th>
                    <th>NIP</th>
                    <th>Nama</th>
                    <th>Keterangan</th>
                  </tr>
                </thead>
                <tbody>
				
                <?php 
				$no = 1;
				foreach($getlist_alpa->result() as $val){
				?>
				
                  <tr>
				  
                    <td><?php echo $no ?></td>
                    <td><?php echo $val->nip ?></td>
                    <td><?php echo $val->Nama ?></td>
                    <td><?php echo $val->Jenis ?></td>
					
                  </tr>
				  
				<?php 
				$no++;
				} 
				?>

                </tbody>
              </table>
            </div><!-- /.col -->
          </div><!-- /.row -->
        </section><!-- /.content -->
		
        <div class="clearfix"></div>
		
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
		$sURL = "/transaksi_ijintl/datatables_pimpinan";
	}
	else If ($this->session->userdata('level') == 'Operator') 
	{
		$sURL = "/transaksi_ijintl/datatables_operator";
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
		url:'<?php echo site_url().'/transaksi_ketidakhadiran/detail_absen';?>/'+id,
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
	
	function hapus_absen(reg)
		{
		var r=confirm("Anda yakin akan menghapus ID \""+reg+"\"?");
		if (r==true)
		  {
			x=confirm("Data absen dengan ID \" " + reg + "\" akan terhapus permanen.");
			if(x==true)
			{
				window.location='<?php echo site_url();?>'+'/transaksi_ketidakhadiran/hapus_absen/'+reg;
				//window.location=siteUrl+'proses/delete/'+reg;
			}
			return false;
		  }
		else
		  {
		  return false;
		  }
		}
	
</script>