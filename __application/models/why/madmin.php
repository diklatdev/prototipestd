<?php if (!defined('BASEPATH')) {exit('No direct script access allowed');}

class madmin extends SHIPMENT_Model{
	function __construct(){
		parent::__construct();
		$this->auth = unserialize(base64_decode($this->session->userdata('d1kl4tst4nd41215451-4dm117')));
	}
	
	function get_data($type="", $balikan="", $p1="", $p2="", $p3="", $p4="", $p5="", $p6=""){
		$where = " WHERE 1=1 ";
		$join = "";
		
		switch($type){
			// User Manajemen & ACL
			case "data_login_admin":
				$sql = "
					SELECT A.*
					FROM tbl_user_admin A
					WHERE A.username = '".$p1."' AND A.aktif = '1'
				";
			break;
			case "get_module":
				$sql = "
					SELECT A.nama_module, B.id as function_id
					FROM idx_menu_module A
					LEFT JOIN idx_menu_submodule B ON A.id = B.idx_module_id
					WHERE B.nama_submodule = 'Main Menu'
				";
			break;
			case "get_submodule":
				$sql = "
					SELECT nama_submodule, id as function_id
					FROM idx_menu_submodule
					WHERE nama_submodule <> 'Main Menu'
				";
			break;
			// End User Manajemen & ACL
			
			
		}
		
		if($balikan == "result_array"){
			return $this->db->query($sql)->result_array();
		}elseif($balikan == "row_array"){
			return $this->db->query($sql)->row_array();
		}
		
	}
	
	function get_data_grid($type="", $p1="", $p2=""){
		$this->load->library('lib');
		$where = "";
		
		return $this->lib->jsondata($sql, $type);
	}
	
	function get_data_fillcombo($type="", $p1="", $p2=""){
		$where = " WHERE 1=1 ";
		$tabel = $type;
		switch($type){
			case "idx_kl":
				$select = "
					id, nama_kl as txt
				";
			break;
			case "idx_dirjen":
				$param = $this->input->post('v2');
				$select = "
					id, nama_dirjen as txt
				";			
				$where .= "
					AND idx_kl_id = '".$param."'
				";
			break;
			case "idx_bidang":
				$select = "
					id, nama_bidang as txt
				";			
			break;
			case "idx_sub_bidang":
				$param = $this->input->post('v2');
				$select = "
					id, nama_sub_bidang as txt
				";		
				$where .= "
					AND idx_bidang_id = '".$param."'
				";
			break;
			case "idx_tim_kerja":
				$select = "
					id, nama as txt
				";
			break;
			case "idx_jabatan_tim_kerja":
				$select = "
					id, nama as txt
				";
			break;
			
			case "idx_tim_verifikasi_perumus":
				$select = "
					id, nama as txt
				";
				$tabel = "tbl_tim_kerja";
				$where .= " AND idx_tim_kerja_id = '3'";
			break;
			case "idx_tim_kerja_perumus":
				$select = "
					id, nama as txt
				";
				$tabel = "tbl_tim_kerja";
				$where .= " AND idx_tim_kerja_id = '2'";
			break;
			case "idx_tim_komite_perumus":
				$select = "
					id, nama as txt
				";
				$tabel = "tbl_tim_kerja";
				$where .= " AND idx_tim_kerja_id = '1'";
			break;
		}
		
		$sql = "
			SELECT $select
			FROM $tabel
			$where
		";
		
		return $this->db->query($sql)->result_array();
	}
	
	function simpansavedatabase($type="", $post="", $p1="", $p2="", $p3=""){
		$this->load->library('lib');
		$this->db->trans_begin();
		
		
		
		if($this->db->trans_status() == false){
			$this->db->trans_rollback();
			return "Data not saved";
		} else{
			return $this->db->trans_commit();
		}
	
	}
	
	function is_access($function_id="", $level_id=""){
		$get_policy = $this->db->get_where('idx_menu_policy', array('idx_submodule_id'=>$function_id, 'idx_level_user_id'=>$level_id))->row_array();
		$ret = false;
		
		if($get_policy){
			if($get_policy['is_access'] == 1){
				$ret = true;
			}else{
				$ret = false;
			}
		}
		
		return $ret;
	}
	
	
}