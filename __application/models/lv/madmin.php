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
                        case "sub_sub2bidang":
                               $sql = "SELECT A.* FROM idx_sub_subbidang A "
                                . "WHERE idx_sub_bidang_id = $p1 AND tingkat_pemerintahan = $p2"; 
                        break;
                        case "kompetensi_manajerial":
                            if ($p2 == 'detil'){
                                $sql = "SELECT A.*, B.nama_kelompok, B.inisial as ini_kelompok 
                                    FROM `idx_kompetensi_manajerial` A 
                                    LEFT JOIN idx_kelompok_kompetensi_manajerial B 
                                        ON B.id = A.idx_kelompok_kompetensi_manajerial_id
                                    WHERE A.id = $p1;";                                
                            }
                            if ($p2 == 'level'){
                                $sql = "SELECT A.* 
                                    FROM `idx_level_kompetensi_manajerial` A
                                    WHERE A.idx_kompetensi_manajerial_id = $p1;";
                            }
                        break;
                        case "kompetensi_kunci":
                            if ($p2 == 'detil'){
                                $sql = "SELECT A.* FROM idx_kompetensi_kunci A "
                                        . "WHERE id = $p1";
                            }
                            if ($p2 == 'level'){
                                $sql = "SELECT * FROM idx_level_kompetensi_kunci "
                                        . "WHERE idx_kompetensi_kunci_id = $p1";
                            }
                        break;
			
			
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
                switch($type){
                    case 'kementrian_grid' :
                        $sql = "SELECT A.id, A.nama_kl, A.inisial
                                FROM idx_kl A";
                    break;
                    case 'bidang_urusan':
                        $sql = 'SELECT A.id, A.nama_bidang, A.inisial '
                            . 'FROM idx_bidang A';
                    break;
                    case 'kel_kompetensi':
                        $sql = 'SELECT A.id, A.nama_kelompok_kompetensi, A.inisial '
                            . 'FROM idx_kelompok_kompetensi A';
                    break;
                    case 'kompetensi_manajerial':
                        $sql = 'SELECT A.id, A.nama_kompetensi_manajerial, A.inisial as ini_komp, A.deskripsi,'
                            . 'A.kata_kunci, B.nama_kelompok, B.inisial as ini_kelompok '
                            . 'FROM idx_kompetensi_manajerial A '
                            . 'LEFT JOIN idx_kelompok_kompetensi_manajerial B ON B.id = A.idx_kelompok_kompetensi_manajerial_id';
                    break;
                    case 'kompetensi_kunci':
                         $sql = "SELECT * FROM idx_kompetensi_kunci";
                    break;
                    case 'bakat':
                         $sql = "SELECT * FROM idx_bakat";
                    break;
                    case 'list_eselon':
                         $sql = "SELECT A.*, B.nama_kl FROM idx_dirjen A "
                            . "LEFT JOIN idx_kl B ON B.id = A.idx_kl_id "
                            . "WHERE A.idx_kl_id = $p1";
                    break;
                    case 'sub_bidang':
                         $sql = "SELECT A.*, B.nama_bidang FROM idx_sub_bidang A "
                            . "LEFT JOIN idx_bidang B ON B.id = A.idx_bidang_id "
                            . "WHERE A.idx_bidang_id = $p1";
                    break;
                    case "pemetaan_fungsi":
                         $sql = 'SELECT A.* FROM idx_bidang A';
                    break;
		}
		
		return $this->lib->jsondata($sql, $type);
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