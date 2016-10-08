<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Eventmodel extends CI_Model{
	
	function __construct()
	{
		parent::__construct();
	}
	
	public function getEvents()
	{
	
		// Sungguh, gua Putus asa browsing kemana2 tak juga ketemu untuk timezone Indonesia
		// Saya siasati untuk menambah 1 hari berikutnya. 
		// DATE_ADD(end, INTERVAL 1 DAY) AS endD
		// Jika tanpa script ini, maka event end day akan berkurang 1 hari... Blooooonn
		// 8 Ramadhan 1435H
		//$rs = $mysqli->query("SELECT id, title, start, DATE_ADD(end, INTERVAL 1 DAY) AS endD FROM events ORDER BY start ASC");
		// $arr = array();
		// Kalau anda lihat tutorial lain di internet, mereka menggunakan ini
		// Tapi karena saya ingin menyesuaikan dengan Program, saya mengabaikan ini.
		
		$query = $this->db->query('SELECT id, title, start, DATEADD(day, 1, [end]) AS endD 
FROM msevents ORDER BY start ASC');
		
		If ($query->num_rows() > 0)
		{
		
			foreach($query->result_array() as $row)
			{
			
				$arr[] = array(
				'id' => $row['id'],
				'title' => $row['title'],
				'start' => $row['start'],
				'end' => $row['endD']);
			
			}
		
		}
		
		echo json_encode($arr);
					
	}
	
	public function getKalenderAbsen()
	{
			
		$kdkaryawan = $this->session->userdata('kdkaryawan');
			
$hadir = 'H';	


		$ssql = "
SELECT idabsen as id, CASE KdAbsen
WHEN '" . $hadir . "' THEN CONVERT(VARCHAR(8), CONVERT(time, DutyOn)) + ' - ' + CONVERT(VARCHAR(8), CONVERT(time, DutyOff))
ELSE 
KdAbsen
END
AS title, CONVERT(char(10), Tanggal,126) as start, CONVERT(CHAR(10), DATEADD(day, 1, Tanggal), 126) AS endD FROM tabsen 
WHERE KdKaryawan = " . $kdkaryawan . " 


UNION


SELECT idabsen as id, CASE KdAbsen 
WHEN '" . $hadir . "' THEN CONVERT(VARCHAR(8), CONVERT(time, DutyOn)) + ' - ' + CONVERT(VARCHAR(8), CONVERT(time, DutyOff))
ELSE 
	KdAbsen + ' (masih diproses)'
END
AS title, 
CONVERT(char(10), Tanggal,126) as start, CONVERT(CHAR(10), DATEADD(day, 1, Tanggal), 126) AS endD FROM tabsen_request 
WHERE KdKaryawan = " . $kdkaryawan . " AND is_finish = 0


UNION


SELECT id, Keterangan as title, CONVERT(char(10), Tanggal,126) as start, CONVERT(CHAR(10), DATEADD(day, 1, Tanggal), 126) AS endD FROM mslibur";


/*
-- SELECT CONVERT(char(10), GetDate(),126) BIAR FORMAT SELECT NYA YYYY-MM-DD
$ssql = "(
SELECT idabsen as id, CASE KdAbsen
WHEN '" . $hadir . "' THEN CONVERT(VARCHAR(8), CONVERT(time, DutyOn)) + ' - ' + CONVERT(VARCHAR(8), CONVERT(time, DutyOff))
ELSE 
KdAbsen
END
AS title, Tanggal as start, DATEADD(day, 1, Tanggal) AS endD FROM tabsen 
WHERE KdKaryawan = " . $kdkaryawan . " 
)

UNION

(
SELECT id, Keterangan as title, Tanggal as start, DATEADD(day, 1, Tanggal) AS endD FROM mslibur
)";
*/

//echo $ssql;


$query = $this->db->query($ssql);

		
		If ($query->num_rows() > 0)
		{
		
			foreach($query->result_array() as $row)
			{
			
				$arr[] = array(
				'id' => $row['id'],
				'title' => $row['title'],
				'start' => $row['start'],
				'end' => $row['endD']);
			
			}
		
		}
		
		echo json_encode($arr);
							
	}
	
}