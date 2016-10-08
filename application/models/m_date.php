<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of m_date
 *
 * @author Jejen Suhendar
 */
class m_date extends CI_Model {

    function __construct() {
        parent::__construct();
        $this->load->database();
    }

    function getTanggal() {
        $this->db->flush_cache();
        $this->db->select('Tanggal');
        $this->db->distinct();
        $this->db->order_by('Tanggal', 'ASC');
        return $this->db->get('tabsen');
    }

    function getDateAbsent($emp) {
        $this->db->flush_cache();
        $this->db->select('tabsen.Tanggal');
        $this->db->distinct();
        $this->db->where('tabsen.KdKaryawan', $emp);
        $this->db->order_by('Tanggal', 'DESC');
        $date = $this->db->get('tabsen');
        $data = array();
        foreach ($date->result() as $d) {
            $data [] = datex($d->Tanggal);
        }
        return $data;
    }

    function getDateAbsence($emp) {
        $this->db->flush_cache();
        $this->db->select('ex_ketidakhadirandetail.Tanggal');
        $this->db->distinct();
        $this->db->where('ex_ketidakhadiran.KdKaryawan', $emp);
        $this->db->join('ex_ketidakhadirandetail', 'ex_ketidakhadiran.KdKetidakhadiran = ex_ketidakhadirandetail.KdKetidakhadiran');
        $this->db->order_by('ex_ketidakhadirandetail.Tanggal', 'DESC');
        $date = $this->db->get('ex_ketidakhadiran');
        $data = array();
        foreach ($date->result() as $d) {
            $data [] = datex($d->Tanggal);
        }
        return $data;
    }
    
    function getHolidays($date){
        $this->db->like('CONVERT(VARCHAR, Tanggal, 120)', $date, 'after');
        $this->db->order_by('Tanggal', 'asc');
        return $this->db->get('mslibur');
    }
	
	function getCurrMonth() {
		return date('Y').'-'.date('m');
	}

	function getPrevMonth($str) { // contoh: 0801 -> 0712, 0705 -> 0704
		$y = substr($str, 0, 4);

		$m = substr($str, 5, 2);
		$prevM = intval($m) - 1;

		if ($prevM==0){
			$prevY = $y - 1;
			return $prevY . '-12';
		} else
			return $y .'-'. sprintf('%02s', $prevM);
	}

	function getNextMonth($str) { // contoh: 0801 -> 0802, 0712 -> 0801
		$y = substr($str, 0, 4);

		$m = substr($str, 5, 2);
		$nextM = intval($m) + 1;

		if ($nextM==13){
			$nextY = intval($y) + 1;
			return $nextY.'-01';
		} else
			return $y .'-'. sprintf('%02s', $nextM);
	}

	function arrPeriode($jangka=3,$thnbln='',$limit='2011-06') {
		$thnbln = ($thnbln=='')? $this->getCurrMonth() : $thnbln;
		$arr_thnbln=array($thnbln=>$thnbln);
		for ($i=0;$i<$jangka;$i++){
			$thnbln=$this->getPrevMonth($thnbln);
			$arr_thnbln=array_merge($arr_thnbln,array($thnbln=>$thnbln));
			if ($thnbln==$limit) $i=$jangka;
		}
		return $arr_thnbln;
	}

}

?>
