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
		
		switch($type){
			case "pembentukan_tim":
				$sql = "
					SELECT A.*, B.nama_kl, C.nama_dirjen, D.nama_bidang, E.nama as nama_timkerja
					FROM tbl_tim_kerja A
					LEFT JOIN idx_kl B ON A.idx_kl_id = B.id
					LEFT JOIN idx_dirjen C ON A.idx_dirjen_id = C.id
					LEFT JOIN idx_bidang D ON A.idx_bidang_id = D.id
					LEFT JOIN idx_tim_kerja E ON A.idx_tim_kerja_id = E.id
				";
			break;
			case "rencana_perumusan":
				$sql = "
					SELECT A.*, B.nama_bidang
					FROM tbl_perumusan A
					LEFT JOIN idx_bidang B ON A.idx_bidang_id = B.id
				";
			break;
		}
		
		return $this->lib->jsondata($sql, $type);
	}
	
	function get_data_fillcombo($type="", $p1="", $p2=""){
		$where = " WHERE 1=1 ";
		$join = "";
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
			case "tbl_subbidang_perumusan":
				$select = "A.idx_sub_bidang_id as id, B.nama_sub_bidang as txt";
				$tabel = "tbl_subbidang_perumusan A";
				$join .= " LEFT JOIN idx_sub_bidang B ON A.idx_sub_bidang_id = B.id ";
			break;
		}
		
		$sql = "
			SELECT $select
			FROM $tabel
			$join
			$where
		";
		
		return $this->db->query($sql)->result_array();
	}
	
	function simpansavedatabase($type="", $post="", $p1="", $p2="", $p3=""){
		$this->load->library('lib');
		$this->db->trans_begin();
		$this->db->trans_strict(TRUE);
		$post_bnr = array();
		
		switch($type){
			case "pembentukan_tim":
				if($post['editstatus'] != 'delete'){
					$kode_gen = strtoupper($this->lib->randomString(5));
					$post_bnr['idx_kl_id'] 			= $post['kementerian'];
					$post_bnr['idx_dirjen_id'] 		= $post['dirjen'];
					$post_bnr['idx_bidang_id'] 		= $post['bidangfungsi'];
					$post_bnr['idx_tim_kerja_id'] 	= $post['kelompok'];
					$post_bnr['nama'] 				= $post['namatim'];
					$post_bnr['kode_gen'] 			= $kode_gen;
				}
				
				if($post['editstatus'] == 'add'){
					$execute = $this->db->insert('tbl_tim_kerja', $post_bnr);
				}elseif($post['editstatus'] == 'edit'){
					$execute = $this->db->update('tbl_tim_kerja', $post_bnr, array('id'=>$post['id']) );
				}elseif($post['editstatus'] == 'delete'){
					$execute = $this->db->delete('tbl_tim_kerja', array('id'=>$post['id']) );
				}
				
				if($execute){
					if($post['editstatus'] == 'add'){
						$get_id = $this->db->get_where('tbl_tim_kerja', array('kode_gen'=>$kode_gen))->row_array();
						$tbl_tim_kerja_id = $get_id['id'];
					}elseif($post['editstatus'] == 'edit'){	
						$tbl_tim_kerja_id = $post['id'];
						$this->db->delete('tbl_anggota_tim_kerja', array('tbl_tim_kerja_id'=>$tbl_tim_kerja_id));
					}
					
					if($post['editstatus'] == 'delete'){
						$this->db->delete('tbl_anggota_tim_kerja', array( 'tbl_tim_kerja_id'=>$post['id']) );
					}else{
						$count = count($post['nama'])-1;
						$array_insert_batch = array();
						for($i = 0; $i <= $count; $i++){
							$array_insert = array(
								'tbl_tim_kerja_id' => $tbl_tim_kerja_id,
								'idx_jabatan_tim_kerja_id' => $post['jabatan_tim_kerja'][$i],
								'jabatan' =>  $post['jabatan'][$i],
								'nama' =>  $post['nama'][$i],
							);
							array_push($array_insert_batch, $array_insert);
						}
						$this->db->insert_batch("tbl_anggota_tim_kerja", $array_insert_batch);
					}
				}
			break;
			case "rencana_perumusan":				
				if($post['editstatus'] != 'delete'){
					$kode_gen = strtoupper($this->lib->randomString(5));
					$post_bnr['idx_bidang_id'] 					= $post['bidang_fungsi'];
					$post_bnr['tbl_tim_kerja_perumus_id'] 		= $post['tim_perumus'];
					$post_bnr['tbl_tim_kerja_verifikasi_id'] 	= $post['tim_verifikasi'];
					$post_bnr['tbl_tim_kerja_komite_id'] 		= $post['komite_standarisasi'];
					$post_bnr['idx_kl_id'] 						= $post['kementerian_lembaga'];
					$post_bnr['idx_dirjen_id'] 					= $post['dirjen_eselon'];
					$post_bnr['nama_kegiatan'] 					= $post['namaperumusan'];
					$post_bnr['estimasi_waktu'] 				= $post['estimasi_wkt'];
					$post_bnr['dasar_hukum'] 					= $post['dasar_hukum'];
					$post_bnr['kode_gen'] 						= $kode_gen;
					
					for($i = 1; $i <= 22; $i++){
						if(isset($post['3_'.$i])){
							$count_elemen = count($post['3_'.$i])-1;
							$el = "";
							for($r = 0; $r <= $count_elemen; $r++){
								if($r == $count_elemen){
									$el .= $post['3_'.$i][$r];
								}else{
									$el .= $post['3_'.$i][$r].":";
								}
							}
						}else{
							$el = null;
						}
						$post_bnr['3_'.$i] = $el;
					}
					
					for($i = 1; $i <= 2; $i++){
						if(isset($post['4_'.$i])){
							$count_elemen = count($post['4_'.$i])-1;
							$els = "";
							for($r = 0; $r <= $count_elemen; $r++){
								if($r == $count_elemen){
									$els .= $post['4_'.$i][$r];
								}else{
									$els .= $post['4_'.$i][$r].":";
								}
							}
						}else{
							$els = null;
						}
						$post_bnr['4_'.$i] = $els;
					}
					
					for($i = 1; $i <= 2; $i++){
						if(isset($post['5_'.$i])){
							$count_elemen = count($post['5_'.$i])-1;
							$elss = "";
							for($r = 0; $r <= $count_elemen; $r++){
								if($r == $count_elemen){
									$elss .= $post['5_'.$i][$r];
								}else{
									$elss .= $post['5_'.$i][$r].":";
								}
							}
						}else{
							$elss = null;
						}
						$post_bnr['5_'.$i] = $elss;
					}					
				}
				
				if($post['editstatus'] == 'add'){
					$execute = $this->db->insert('tbl_perumusan', $post_bnr);
				}elseif($post['editstatus'] == 'edit'){
					$execute = $this->db->update('tbl_perumusan', $post_bnr, array('id'=>$post['id']) );
				}elseif($post['editstatus'] == 'delete'){
					$execute = $this->db->delete('tbl_perumusan', array('id'=>$post['id']) );
				}
				
				if($execute){
					if($post['editstatus'] == 'add'){
						$get_id = $this->db->get_where('tbl_perumusan', array('kode_gen'=>$kode_gen))->row_array();
						$tbl_perumusan_id = $get_id['id'];
					}elseif($post['editstatus'] == 'edit'){	
						$tbl_tim_kerja_id = $post['id'];
						$this->db->delete('tbl_subbidang_perumusan', array('tbl_perumusan_id'=>$tbl_perumusan_id));
					}
					
					if($post['editstatus'] == 'delete'){
						$this->db->delete('tbl_subbidang_perumusan', array( 'tbl_perumusan_id'=>$post['id']) );
					}else{
						$count = count($post['subbidang'])-1;
						$array_insert_batch = array();
						for($i = 0; $i <= $count; $i++){
							$array_insert = array(
								'tbl_perumusan_id' => $tbl_perumusan_id,
								'idx_sub_bidang_id' => $post['subbidang'][$i],
							);
							array_push($array_insert_batch, $array_insert);
						}
						$this->db->insert_batch("tbl_subbidang_perumusan", $array_insert_batch);
					}
				}
				
			break;
		}
		
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