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
				$is_pimpinan_approve_psw = $val->is_pimpinan_approve_psw;
				$is_petugas_approve_psw = $val->is_petugas_approve_psw;
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
                <td><strong>Alasan Pulang Cepat</strong><td> :</td></td>
                <td>
					<?php echo $val->alasan; ?>
                </td>
            </tr>
                    
            <tr>
                <td><strong>Nama Pegawai</strong><td> :</td></td>
                <td>
					<?php echo $v->nama_pegawai; ?>
                </td>
            </tr>
                    
            <tr>
                <td><strong>Unit Kerja </strong><td> :</td></td>
                <td>
					<?php echo $v->departemen; ?>
                </td>
			</tr>
                    
            <tr>
				<td><strong>Jabatan </strong><td> :</td></td>
                <td>
					<?php echo $v->jabatan; ?>
                </td>
            </tr>
			
			<tr>
				<td><strong>Pimpinan yang menyetujui </strong><td> :</td></td>
                <td>
					<?php If ($is_pimpinan_approve_psw == 0){
					
						echo 'Belum diproses oleh ' . $v->nama_pimpinan; 
						
					}
					else If ($is_pimpinan_approve_psw == 1)
					{
						 
						echo 'Disetujui oleh ' . $v->nama_pimpinan; 
						
					}
					else 
					{
						
						echo 'Direject oleh ' . $v->nama_pimpinan;
						
					}
					?>
					
                </td>
            </tr>
							
							<?php 
							If ($is_petugas_approve_psw == 2)
							{
					
								echo '<tr>
								<td><strong>Setuju / Tidak Setuju </strong>
								<td> :</td>
								</td>
								<td>
									<input type = "radio" id = "is_approve" name = "cbois_approve" value = "1"/>  Setuju
									<input type = "radio" id = "is_approve" name = "cbois_approve" value = "2"/ checked>  Tidak Setuju
									<span class="help-block"></span>
								</td>
								</tr>';
					
							}
							else If ($is_petugas_approve_psw == 0)
							{
					
								echo '<tr>
								<td><strong>Setuju / Tidak Setuju </strong>
								<td> :</td>
								</td>
								<td>
									<input type = "radio" id = "is_approve" name = "cbois_approve" value = "1"/>  Setuju
									<input type = "radio" id = "is_approve" name = "cbois_approve" value = "2"/>  Tidak Setuju
									<span class="help-block"></span>
								</td>
								</tr>';
					
							}
							?>
						
				
			<tr>
				<td><strong>Keterangan </strong><td> :</td></td>
                <td>
					<?php echo $val->Keterangan; ?>
                </td>
            </tr>
			
			<tr>
				<td><strong>Lampiran </strong><td> :</td></td>
                <td>
				
					<?php 
					
						$type_file = right($val->nama_file_psw, 3);
						
						If ($type_file == 'pdf')
						{
							
							echo '<a target="_blank" href="' . base_url() . 'attachment_psw/' . $val->nama_file_psw . '"><span class="label label-success">Attachment Pdf</span></a>';
							
						}
						else
						{
							
							echo '<img src="' . base_url() . 'attachment_psw/' . $val->nama_file_psw . '" alt="Attachment bermasalah" class="post_images" width="700" height="750" title="Lampiran alasan pulang sebelum waktu pegawai" rel="lightbox" />';
							
						}
					
					?>
                
				</td>
            </tr>
			
			<input type ="hidden" name="idabsen" value="<?php echo $val->idabsen ?>">
			
			<?php
			}
			?>
					
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
/* End of file petugas_approval_ijintpsw.php */
/* Location: ./application/views/petugas_approval_ijinpsw.php */
?>