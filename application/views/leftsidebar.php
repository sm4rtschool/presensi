      <!-- Left side column. contains the logo and sidebar -->
      <aside class="main-sidebar">
        <!-- sidebar: style can be found in sidebar.less -->
        <section class="sidebar">
          <!-- Sidebar user panel -->
          <div class="user-panel">
            <div class="pull-left image">
              <img src="<?php echo base_url(); ?>asset/dist/img/user2-160x160.jpg" class="img-circle" alt="User Image" />
            </div>
            <div class="pull-left info">
              <p><?php echo $username?></p>
              <a href="#"><i class="fa fa-circle text-success"></i> Online</a>
            </div>
          </div>
          </form>
          <!-- /.search form -->
		  
		  <?php If ($this->session->userdata('level')=='Super Admin'){
		  
		  echo '
		  
          <!-- sidebar menu: : style can be found in sidebar.less -->
          <ul class="sidebar-menu">
            <li class="header">MAIN NAVIGATION</li>
            
			<li class="active treeview">
              <a href="' . site_url() . '/beranda/">
                <i class="fa fa-dashboard"></i> <span>Dashboard</span>				
              </a>			  			  
            </li>

            <li class="treeview">
              <a href="#">
                <i class="fa fa-folder"></i> <span>Data Master</span>
                <i class="fa fa-angle-left pull-right"></i>
              </a>
              <ul class="treeview-menu">
                <li><a href="<?php echo site_url(); ?>/mscustomer"><i class="fa fa-circle-o"></i> Agama</a></li>
                <li><a href="<?php echo site_url(); ?>/mstugas"><i class="fa fa-circle-o"></i> Unit Kerja</a></li>
                <li><a href="#"><i class="fa fa-circle-o"></i> Jabatan</a></li>
                <li><a href="<?php echo site_url(); ?>/mspekerjaan"><i class="fa fa-circle-o"></i> Jenis Ketidakhadiran</a></li>
                <li><a href="<?php echo site_url(); ?>/msuser"><i class="fa fa-circle-o"></i> Jenis Jadwal Kerja</a></li>
                <li><a href="<?php echo site_url(); ?>/mscalendar"><i class="fa fa-circle-o"></i> Pegawai</a></li>
                <li><a href="<?php echo site_url(); ?>/mscalendar"><i class="fa fa-circle-o"></i> Libur</a></li>
                <li><a href="<?php echo site_url(); ?>/mscalendar"><i class="fa fa-circle-o"></i> Terlambat Datang</a></li>
                <li><a href="<?php echo site_url(); ?>/mscalendar"><i class="fa fa-circle-o"></i> Pulang Sebelum Waktu</a></li>
                <li><a href="<?php echo site_url(); ?>/mscalendar"><i class="fa fa-circle-o"></i> Tunjangan Kinerja</a></li>
                <li><a href="<?php echo site_url(); ?>/mscalendar"><i class="fa fa-circle-o"></i> Pengaturan Jam Kerja</a></li>
                <li><a href="<?php echo site_url(); ?>/mscalendar"><i class="fa fa-circle-o"></i> Pengaturan Shift</a></li>
                <li><a href="<?php echo site_url(); ?>/mscalendar"><i class="fa fa-circle-o"></i> Pengaturan TMT Pegawai</a></li>
              </ul>
            </li>
			
			<li class="treeview">
              <a href="#">
                <i class="fa fa-folder"></i> <span>Transaksi</span>
                <i class="fa fa-angle-left pull-right"></i>
              </a>
              <ul class="treeview-menu">
                <li><a href="<?php echo site_url(); ?>/demand"><i class="fa fa-circle-o"></i> Kehadiran</a></li>
                <li><a href="<?php echo site_url(); ?>/demand_assign"><i class="fa fa-circle-o"></i> Ketidakhadiran</a></li>
                <li><a href="#"><i class="fa fa-circle-o"></i> Absensi Bermasalah</a></li>
				<li><a href="#"><i class="fa fa-circle-o"></i> Ijin Terlambat Datang</a></li>
				<li><a href="#"><i class="fa fa-circle-o"></i> Ijin Pulang Sebelum Waktu</a></li>
				<li><a href="#"><i class="fa fa-circle-o"></i> Pensiun Pegawai </a></li>
				<li><a href="#"><i class="fa fa-circle-o"></i> Sanksi</a></li>
              </ul>
            </li>
			
            <li class="treeview">
              <a href="#">
                <i class="fa fa-folder"></i> <span>Utility</span>
                <i class="fa fa-angle-left pull-right"></i>
              </a>
              <ul class="treeview-menu">
                <li><a href="#"><i class="fa fa-circle-o"></i> Import Data Pegawai</a></li>
                <li><a href="#"><i class="fa fa-circle-o"></i> Import Data Absen</a></li>
                <li><a href="#"><i class="fa fa-circle-o"></i> Kalkulasi Data Absen</a></li>
                <li><a href="#"><i class="fa fa-circle-o"></i> Monitoring Data Absen</a></li>
                <li><a href="#"><i class="fa fa-circle-o"></i> Monitoring Log Transaksi Mesin</a></li>
                <li><a href="#"><i class="fa fa-circle-o"></i> Monitoring Log Transaksi Applikasi</a></li>
                <li><a href="' . site_url() . '/msuser"><i class="fa fa-circle-o"></i> User Administration</a></li>
                <li><a href="#"><i class="fa fa-circle-o"></i> Privileges Applikasi</a></li>
              </ul>
            </li>
			
			<li class="treeview">
              <a href="#">
                <i class="fa fa-folder"></i> <span>Pengaturan</span>
                <i class="fa fa-angle-left pull-right"></i>
              </a>
              <ul class="treeview-menu">
                <li><a href="#"><i class="fa fa-circle-o"></i> Applikasi</a></li>
                <li><a href="#"><i class="fa fa-circle-o"></i> Hukuman Alpa</a></li>
                <li><a href="#"><i class="fa fa-circle-o"></i> Hukuman Terlambat Datang</a></li>
                <li><a href="#"><i class="fa fa-circle-o"></i> Hukuman Pulang Sebelum Waktu</a></li>
                <li><a href="#"><i class="fa fa-circle-o"></i> Ijin Tidak Hadir</a></li>				
              </ul>
            </li>
			
			<li class="treeview">
			
              <a href="#">
                <i class="fa fa-folder"></i> <span>Laporan</span>
                <i class="fa fa-angle-left pull-right"></i>
              </a>
			  
              <ul class="treeview-menu">
			  
                <li><a href="#"><i class="fa fa-circle-o"></i> Biodata Pegawai</a></li>
				
                <li>
				
                  <a href="#"><i class="fa fa-circle-o"></i> Kehadiran <i class="fa fa-angle-left pull-right"></i></a>
                  
				  <ul class="treeview-menu">
				  
                    <li><a href="#"><i class="fa fa-circle-o"></i> Detail Harian</a></li>
					<li><a href="#"><i class="fa fa-circle-o"></i> Kehadiran Bulanan</a></li>                   
					<li><a href="#"><i class="fa fa-circle-o"></i> Per Minggu</a></li>                   
					<li><a href="#"><i class="fa fa-circle-o"></i> Summary</a></li>                   
					
                  </ul>
				  
                </li>
				
                <li><a href="#"><i class="fa fa-circle-o"></i> Ketidakhadiran</a></li>
				
                <li>
				
					<a href="#"><i class="fa fa-circle-o"></i> Kedisiplinan <i class="fa fa-angle-left pull-right"></i></a>
				
					<ul class="treeview-menu">
				  
						<li><a href="#"><i class="fa fa-circle-o"></i> Kedisiplinan Kerja </a></li>
					
						<li>
						
							<a href="#"><i class="fa fa-circle-o"></i> Akumulasi Alpa <i class="fa fa-angle-left pull-right"></i></a>
							
							<ul class="treeview-menu">
				  
								<li><a href="#"><i class="fa fa-circle-o"></i> Per Tahun</a></li>
								<li><a href="#"><i class="fa fa-circle-o"></i> Per Bulan</a></li>                   
								<li><a href="#"><i class="fa fa-circle-o"></i> Per Periode</a></li>                  
					
							</ul>
							
						</li>    
					
						<li>
						
							<a href="#"><i class="fa fa-circle-o"></i> TL + PSW <i class="fa fa-angle-left pull-right"></i></a>
							
							<ul class="treeview-menu">
				  
								<li><a href="#"><i class="fa fa-circle-o"></i> Per Tahun</a></li>
								<li><a href="#"><i class="fa fa-circle-o"></i> Per Bulan</a></li>                   
								<li><a href="#"><i class="fa fa-circle-o"></i> Per Periode</a></li>                  
					
							</ul>
							
						</li>                
					
                  </ul>
				
				</li>
				
				
				<li>
				
					<a href="#"><i class="fa fa-circle-o"></i> Tunjangan Kinerja <i class="fa fa-angle-left pull-right"></i></a>
				
					<ul class="treeview-menu">
				  
						<li><a href="#"><i class="fa fa-circle-o"></i> Daftar Penerima </a></li>
						<li><a href="#"><i class="fa fa-circle-o"></i> Normatif </a></li>    
					
						<li>
						
							<a href="#"><i class="fa fa-circle-o"></i> Rekapitulasi <i class="fa fa-angle-left pull-right"></i></a>
							
							<ul class="treeview-menu">
				  
								<li><a href="#"><i class="fa fa-circle-o"></i> Per Bulan</a></li>                  
					
							</ul>
							
						</li>  

						<li>
						
							<a href="#"><i class="fa fa-circle-o"></i> Tunjangan Kinerja <i class="fa fa-angle-left pull-right"></i></a>
							
							<ul class="treeview-menu">
				  
								<li><a href="#"><i class="fa fa-circle-o"></i> Per Pegawai</a></li>                  
					
							</ul>
							
						</li>
					
                  </ul>
				
				</li>
				
				
              </ul>
			  
            </li>
			
			<!--
            <li class="treeview">
              <a href="#">
                <i class="fa fa-folder"></i> <span>Kalender</span>
                <i class="fa fa-angle-left pull-right"></i>
              </a>
              <ul class="treeview-menu">
                <li><a href="<?php //echo site_url(); ?>/laporan_tugas"><i class="fa fa-circle-o"></i> Kalender kegiatan</a></li>
              </ul>
            </li>
			-->
			
			<!--
			<li class="active">
              <a href="<?php echo site_url(); ?>/calendar">
                <i class="fa fa-calendar"></i> <span> Kalender kegiatan</span>
                <small class="label pull-right bg-red">3</small>
              </a>
            </li>
			-->
                       
          </ul>
		  
		  '; 
		  
		  }
		  else if ($this->session->userdata('level')=='Operator')
		  {
			  
				echo '				
		  
          <!-- sidebar menu: : style can be found in sidebar.less -->
          <ul class="sidebar-menu">
            <li class="header">MAIN NAVIGATION</li>
            
			<li class="active treeview">
              <a href="' . site_url() . '/beranda/">
                <i class="fa fa-dashboard"></i> <span>Dashboard</span>				
              </a>			  			  
            </li>
			
			<li class="treeview">
              <a href="#">
                <i class="fa fa-folder"></i> <span>Transaksi</span>
                <i class="fa fa-angle-left pull-right"></i>
              </a>
              <ul class="treeview-menu">
			  			  
				<li><a href="' . site_url() . '/transaksi_kehadiran"><i class="fa fa-circle-o"></i> Kehadiran</a></li>
                <li><a href="' . site_url() . '/transaksi_ketidakhadiran/"><i class="fa fa-circle-o"></i> Ketidakhadiran</a></li>
				<li><a href="' . site_url() . '/transaksi_ijintl/"><i class="fa fa-circle-o"></i> Ijin Terlambat Datang</a></li>
				<li><a href="' . site_url() . '/transaksi_ijinpsw/"><i class="fa fa-circle-o"></i> Ijin Pulang Sebelum Waktu</a></li>
                <li><a href="' . '#' . '"><i class="fa fa-circle-o"></i> Approval Kehadiran</a></li>
                <li><a href="' . site_url() . '/transaksi_approval_ketidakhadiran/"><i class="fa fa-circle-o"></i> Approval Ketidakhadiran</a></li>
				<li><a href="' . site_url() . '/transaksi_approval_ijintl/"><i class="fa fa-circle-o"></i> Approval Ijin Telat</a></li>
				<li><a href="' . site_url() . '/transaksi_approval_ijinpsw/"><i class="fa fa-circle-o"></i> Approval Ijin Pulang Cepat</a></li>
				
              </ul>
            </li>
                       
          </ul>
		  
		  ';
			  
		  }
		  
		  else if ($this->session->userdata('level')=='Pegawai')
		  {
			  
				echo '				
		  
          <!-- sidebar menu: : style can be found in sidebar.less -->
          <ul class="sidebar-menu">
            <li class="header">MAIN NAVIGATION</li>
            
			<li class="active treeview">
              <a href="' . site_url() . '/beranda/">
                <i class="fa fa-dashboard"></i> <span>Dashboard</span>				
              </a>			  			  
            </li>
			
			<li class="treeview">
              <a href="#">
                <i class="fa fa-folder"></i> <span>Transaksi</span>
                <i class="fa fa-angle-left pull-right"></i>
              </a>
              <ul class="treeview-menu">
                <li><a href="' . site_url() . '/transaksi_kehadiran"><i class="fa fa-circle-o"></i> Kehadiran</a></li>
                <li><a href="' . site_url() . '/transaksi_ketidakhadiran/"><i class="fa fa-circle-o"></i> Ketidakhadiran</a></li>
				<li><a href="' . site_url() . '/transaksi_ijintl/"><i class="fa fa-circle-o"></i> Ijin Terlambat Datang</a></li>
				<li><a href="' . site_url() . '/transaksi_ijinpsw/"><i class="fa fa-circle-o"></i> Ijin Pulang Sebelum Waktu</a></li>
              </ul>
            </li>
			
			<li class="treeview">
              <a href="' . site_url() . '/monitoring_absensi_harian/">
                <i class="fa fa-folder"></i> <span>Lihat Absensi Harian Satker</span>				
              </a>			  			  
            </li>
			
			
			                       
          </ul>
		  
		  ';
			  
		  }
		  
		  else if ($this->session->userdata('level')=='Pimpinan')
		  {
			  
				echo '				
		  
          <!-- sidebar menu: : style can be found in sidebar.less -->
          <ul class="sidebar-menu">
            <li class="header">MAIN NAVIGATION</li>
            
			<li class="active treeview">
              <a href="' . site_url() . '/beranda/">
                <i class="fa fa-dashboard"></i> <span>Dashboard</span>				
              </a>			  			  
            </li>
			
			<li class="treeview">
              <a href="#">
                <i class="fa fa-folder"></i> <span>Transaksi</span>
                <i class="fa fa-angle-left pull-right"></i>
              </a>
              <ul class="treeview-menu">
				<li><a href="' . site_url() . '/transaksi_kehadiran"><i class="fa fa-circle-o"></i> Kehadiran</a></li>
                <li><a href="' . site_url() . '/transaksi_ketidakhadiran/"><i class="fa fa-circle-o"></i> Ketidakhadiran</a></li>
				<li><a href="' . site_url() . '/transaksi_ijintl/"><i class="fa fa-circle-o"></i> Ijin Terlambat Datang</a></li>
				<li><a href="' . site_url() . '/transaksi_ijinpsw/"><i class="fa fa-circle-o"></i> Ijin Pulang Sebelum Waktu</a></li>
                <li><a href="' . '#' . '"><i class="fa fa-circle-o"></i> Approval Kehadiran</a></li>
                <li><a href="' . site_url() . '/transaksi_approval_ketidakhadiran/"><i class="fa fa-circle-o"></i> Approval Ketidakhadiran</a></li>
				<li><a href="' . site_url() . '/transaksi_approval_ijintl/"><i class="fa fa-circle-o"></i> Approval Ijin Terlambat</a></li>
				<li><a href="' . site_url() . '/transaksi_approval_ijinpsw/"><i class="fa fa-circle-o"></i> Approval Ijin Pulang Cepat</a></li>
              </ul>
            </li>
			
			<li class="treeview">
			
              <a href="#">
                <i class="fa fa-folder"></i> <span>Laporan</span>
                <i class="fa fa-angle-left pull-right"></i>
              </a>
			  
              <ul class="treeview-menu">
			  
                <li><a href="#"><i class="fa fa-circle-o"></i> Biodata Pegawai</a></li>
				
                <li>
				
                  <a href="#"><i class="fa fa-circle-o"></i> Kehadiran <i class="fa fa-angle-left pull-right"></i></a>
                  
				  <ul class="treeview-menu">
				  
                    <li><a href="' . site_url() . '/laporan_rinci_kehadiran/"><i class="fa fa-circle-o"></i> Detail Harian</a></li>
					<li><a href="#"><i class="fa fa-circle-o"></i> Kehadiran Bulanan</a></li>                   
					<li><a href="#"><i class="fa fa-circle-o"></i> Per Minggu</a></li>                   
					<li><a href="#"><i class="fa fa-circle-o"></i> Summary</a></li>                   
					
                  </ul>
				  
                </li>
				
                <li><a href="#"><i class="fa fa-circle-o"></i> Ketidakhadiran</a></li>
				
                <li>
				
					<a href="#"><i class="fa fa-circle-o"></i> Kedisiplinan <i class="fa fa-angle-left pull-right"></i></a>
				
					<ul class="treeview-menu">
				  
						<li><a href="#"><i class="fa fa-circle-o"></i> Kedisiplinan Kerja </a></li>
					
						<li>
						
							<a href="#"><i class="fa fa-circle-o"></i> Akumulasi Alpa <i class="fa fa-angle-left pull-right"></i></a>
							
							<ul class="treeview-menu">
				  
								<li><a href="#"><i class="fa fa-circle-o"></i> Per Tahun</a></li>
								<li><a href="#"><i class="fa fa-circle-o"></i> Per Bulan</a></li>                   
								<li><a href="#"><i class="fa fa-circle-o"></i> Per Periode</a></li>                  
					
							</ul>
							
						</li>    
					
						<li>
						
							<a href="#"><i class="fa fa-circle-o"></i> TL + PSW <i class="fa fa-angle-left pull-right"></i></a>
							
							<ul class="treeview-menu">
				  
								<li><a href="#"><i class="fa fa-circle-o"></i> Per Tahun</a></li>
								<li><a href="#"><i class="fa fa-circle-o"></i> Per Bulan</a></li>                   
								<li><a href="#"><i class="fa fa-circle-o"></i> Per Periode</a></li>                  
					
							</ul>
							
						</li>                
					
                  </ul>
				
				</li>
				
				
				<li>
				
					<a href="#"><i class="fa fa-circle-o"></i> Tunjangan Kinerja <i class="fa fa-angle-left pull-right"></i></a>
				
					<ul class="treeview-menu">
				  
						<li><a href="#"><i class="fa fa-circle-o"></i> Daftar Penerima </a></li>
						<li><a href="#"><i class="fa fa-circle-o"></i> Normatif </a></li>    
					
						<li>
						
							<a href="#"><i class="fa fa-circle-o"></i> Rekapitulasi <i class="fa fa-angle-left pull-right"></i></a>
							
							<ul class="treeview-menu">
				  
								<li><a href="#"><i class="fa fa-circle-o"></i> Per Bulan</a></li>                  
					
							</ul>
							
						</li>  

						<li>
						
							<a href="#"><i class="fa fa-circle-o"></i> Tunjangan Kinerja <i class="fa fa-angle-left pull-right"></i></a>
							
							<ul class="treeview-menu">
				  
								<li><a href="#"><i class="fa fa-circle-o"></i> Per Pegawai</a></li>                  
					
							</ul>
							
						</li>
					
                  </ul>
				
				</li>
				
				
              </ul>
			  
            </li>
			                       
          </ul>
		  
		  ';
			  
		  }
		  
		  ?>
		  		  
        </section>
        <!-- /.sidebar -->
      </aside>