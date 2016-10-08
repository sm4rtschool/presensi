
<!-- saved from url=(0061)http://202.58.199.202:1234/dbrea/2015/engine/form/f_rkakl.php -->
<html xmlns="http://www.w3.org/1999/xhtml" lang="id"><head><meta http-equiv="Content-Type" content="text/html; charset=UTF-8">

<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
<title>History Absen Pegawai - 2016</title>

<!--google web font-->
<!--<link href='http://fonts.googleapis.com/css?family=Raleway:400,600,700' rel='stylesheet' type='text/css'>-->
<!-- Bootstrap 3.3.4 -->
<!-- <link href="<?php echo base_url(); ?>asset/bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css" /> -->

	<!-- Bootstrap 3.3.4 -->
    <link href="<?php echo base_url(); ?>asset/bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
    <!-- FontAwesome 4.3.0 -->
    <link href="<?php echo base_url(); ?>asset/bootstrap/css/font-awesome.min.css" rel="stylesheet" type="text/css" />
    <!-- Ionicons 2.0.0 -->
    <link href="<?php echo base_url(); ?>asset/bootstrap/css/ionicons.min.css" rel="stylesheet" type="text/css" />	 

	<!-- Select2 -->
    <link href="<?php echo base_url(); ?>asset/plugins/select2/select2.min.css" rel="stylesheet" type="text/css" />
		
	<!-- Theme style -->
    <link href="<?php echo base_url(); ?>asset/dist/css/AdminLTE.min.css" rel="stylesheet" type="text/css" />
    <!-- AdminLTE Skins. Choose a skin from the css/skins
         folder instead of downloading all of them to reduce the load. -->
    <!--<link href="<?php echo base_url(); ?>asset/dist/css/skins/_all-skins.min.css" rel="stylesheet" type="text/css" />-->

</head>

<body>

	<input type ="hidden" name="kdkaryawan" value="<?php echo $kdkaryawan ?>">
	<!-- Table row -->
          <div class="row">
            <div class="col-xs-12 table-responsive">
              <table class="table table-striped">
                <thead>
                  <tr>
                    <th>No</th>
                    <th>Tahun</th>
                    <th>Alasan</th>
                    <th>Januari</th>
                    <th>Februari</th>
					<th>Maret</th>
                    <th>April</th>
					<th>Mei</th>
                    <th>Juni</th>
					<th>Juli</th>
                    <th>Agustus</th>
					<th>September</th>
                    <th>Oktober</th>
					<th>November</th>
                    <th>Desember</th>
                    <th>Total</th>
                    <th>Keterangan</th>
                  </tr>
                </thead>
                <tbody>
				
				<?php 
				$no = 1;
				foreach($history_absen->result() as $val){
				?>
                
				<tr>
                    <td><?php echo $no ?></td>
                    <td><?php echo $val->Tahun ?></td>
                    <td><?php echo $val->Jenis ?></td>
                    <td><?php echo $val->januari ?></td>
                    <td><?php echo $val->februari ?></td>
					<td><?php echo $val->maret ?></td>
                    <td><?php echo $val->april ?></td>
					<td><?php echo $val->mei ?></td>
                    <td><?php echo $val->juni ?></td>
					<td><?php echo $val->juli ?></td>
                    <td><?php echo $val->agustus ?></td>
					<td><?php echo $val->september ?></td>
                    <td><?php echo $val->oktober ?></td>
					<td><?php echo $val->november ?></td>
                    <td><?php echo $val->desember ?></td>
                    <td><?php echo $val->akumulasi_desember ?></td>
                    <td><?php echo $val->keterangan ?></td>
                  </tr>
			
				<?php
				$no++;
				}
				?>
				  
                </tbody>
              </table>
            </div><!-- /.col -->
          </div><!-- /.row -->
 
</body>
</html>
 
      <?php  //require_once('script.php') ?>
 