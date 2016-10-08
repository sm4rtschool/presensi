<?php 

	//function indonesian_date ($timestamp = '', $date_format = 'l, j F Y | H:i', $suffix = '') {
	
	function indonesian_date ($timestamp = '', $date_format = 'l, j F Y', $suffix = '') {
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
    $pattern = array (
        '/Mon[^day]/','/Tue[^sday]/','/Wed[^nesday]/','/Thu[^rsday]/',
        '/Fri[^day]/','/Sat[^urday]/','/Sun[^day]/','/Monday/','/Tuesday/',
        '/Wednesday/','/Thursday/','/Friday/','/Saturday/','/Sunday/',
        '/Jan[^uary]/','/Feb[^ruary]/','/Mar[^ch]/','/Apr[^il]/','/May/',
        '/Jun[^e]/','/Jul[^y]/','/Aug[^ust]/','/Sep[^tember]/','/Oct[^ober]/',
        '/Nov[^ember]/','/Dec[^ember]/','/January/','/February/','/March/',
        '/April/','/June/','/July/','/August/','/September/','/October/',
        '/November/','/December/',
    );
    $replace = array ( 'Sen','Sel','Rab','Kam','Jum','Sab','Min',
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
	
	function left($str, $length){
		return substr($str, 0, $length);
	}

	function right($str, $length){
		return substr($str, -$length);
	}
	
?>

<?php 
foreach($list->result() as $v){
?>
	
<div class="box-body no-padding">
    
	<table class="table table-condensed">
        
		<tbody>
		
			<?php 
				foreach($tabsen->result() as $val){
			?>
			
			<tr>
                <td><strong>Tanggal Absen</strong><td> :</td></td>
                <td>
					<?php 
						$tanggal_absen = $val->Tanggal;
						echo indonesian_date($tanggal_absen);
					?>
                </td>
            </tr>
			
			<tr>
                <td><strong>Alasan Terlambat Datang</strong><td> :</td></td>
                <td>
					<?php 
						if ($val->alasan != NULL){
							echo $val->alasan; 
						}
						else
						{
							echo 'Tidak ada konfirmasi';
						}
					?>
                </td>
            </tr>
                    
            <tr>
                <td><strong>Nama Pegawai</strong><td> :</td></td>
                <td>
					<?php If ($level == 'Pimpinan')
					{
						echo $v->Nama;
					}
					else if ($level == 'Operator')
					{
						echo $v->nama_pegawai;
					}
					else if ($level == 'Pegawai')
					{
						echo $v->nama_pegawai;
					}
					?>
                </td>
            </tr>
                    
            <tr>
                <td><strong>Unit Kerja </strong><td> :</td></td>
                <td>
					<?php If ($level == 'Pimpinan')
					{
						echo $v->Departemen;
					}
					else if ($level == 'Operator')
					{
						echo $v->departemen;
					}
					else if ($level == 'Pegawai')
					{
						echo $v->departemen;
					}
					?>
                </td>
			</tr>
                    
            <tr>
				<td><strong>Jabatan </strong><td> :</td></td>
                <td>
					<?php If ($level == 'Pimpinan')
					{
						echo $v->Jabatan;
					}
					else if ($level == 'Operator')
					{
						echo $v->jabatan;
					}
					else if ($level == 'Pegawai')
					{
						echo $v->jabatan;
					}
					?>
                </td>
            </tr>
			
			<?php
			
			/* set status approval oleh pimpinan */
			
			$is_pimpinan_approve_tl = $val->is_pimpinan_approve_tl;
			
			if ($is_pimpinan_approve_tl == 0)
			{
				
				echo '<tr>
						<td><strong>Persetujuan Pimpinan </strong>
						<td> :</td>
						</td>
						<td>
							Belum di proses oleh ' . $v->nama_pimpinan . '
						</td>
					</tr>';
				
			}		
			else if ($is_pimpinan_approve_tl == 1)
			{
				
				echo '<tr>
						<td><strong>Persetujuan Pimpinan </strong>
						<td> :</td>
						</td>
						<td>
							Sudah di approval oleh ' . $v->nama_pimpinan . '
						</td>
					</tr>';
				
			}
			else //if ($is_pimpinan_approve_tl == 2)
			{
				
				echo '<tr>
						<td><strong>Persetujuan Pimpinan </strong>
						<td> :</td>
						</td>
						<td>
							Di reject oleh ' . $v->nama_pimpinan . '
						</td>
					</tr>';
				
			}
						
				
				
			/* set status approval oleh pimpinan */
			?>
			
			<?php
			
			/* set status approval oleh petugas */
			
			$is_petugas_approve_tl = $val->is_petugas_approve_tl;
			
			if ($is_petugas_approve_tl == 0)
			{
				
				echo '<tr>
						<td><strong>Persetujuan Petugas </strong>
						<td> :</td>
						</td>
						<td>
							Belum di proses oleh petugas' . '
						</td>
					</tr>';
				
			}
			else if ($is_petugas_approve_tl == 1)
			{
				
				echo '<tr>
						<td><strong>Persetujuan Petugas </strong>
						<td> :</td>
						</td>
						<td>
							Sudah di approval oleh ' . $v->nama_petugas . '
						</td>
					</tr>';
				
			}			
			else 
			{
				
				echo '<tr>
						<td><strong>Persetujuan Petugas </strong>
						<td> :</td>
						</td>
						<td>
							Di reject oleh petugas' . '
						</td>
					</tr>';
				
			}				
				
				
			/* set status approval oleh petugas */
			?>
			
			<tr>
				<td><strong>Keterangan </strong><td> :</td></td>
                <td>
					<?php //echo $val->Keterangan; ?>
                </td>
            </tr>
			
			<tr>
				<td><strong>Lampiran </strong><td> :</td></td>
                <td>
				
					<?php 
					
						$type_file = right($val->nama_file_tl, 3);
						
						If ($type_file == 'pdf')
						{
							
							echo '<a target="_blank" href="' . base_url() . 'attachment_tl/' . $val->nama_file_tl . '"><span class="label label-success">Attachment Pdf</span></a>';
							
						}
						else
						{
							
							echo '<img src="' . base_url() . 'attachment_tl/' . $val->nama_file_tl . '" alt="Attachment bermasalah" class="post_images" width="700" height="750" title="Lampiran alasan terlambat datang pegawai" rel="lightbox" />';
							
						}
					
					?>
				
				</td>
            </tr>
			
			<input type ="hidden" name="idabsen" value="<?php //echo $val->idabsen ?>">
			
			<?php
			}
			?>
			
			<?php //echo $level; ?>
					
            <tr>
                <td></td>
                <td></td>
                <td></td>
            </tr>
                    
        </tbody>				  
	</table>
</div>
<?php
}
?>
<?php
/* End of file detail_ijintl.php */
/* Location: ./application/views/transaksi_ijintl.php */
?>