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
			case "level_kompetensi_manajerial":
				$sql = "
					SELECT A.*, B.idx_kompetensi_manajerial_id
					FROM tbl_petjab_level_kompetensi_manajerial A
					LEFT JOIN idx_level_kompetensi_manajerial B ON A.idx_level_kompetensi_manajerial = B.id
					WHERE A.tbl_peta_jabatan_id = '".$p1."'
				";
			break;
			case "kompetensi_teknis":
				$sql = "
					SELECT A.*, B.kode_unit_kompetensi
					FROM tbl_petjab_kompetensi_teknis A
					LEFT JOIN tbl_unit_kompetensi B ON A.tbl_unit_kompetensi_id = B.id 
					WHERE A.tbl_peta_jabatan_id = '".$p1."'
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
		$join = "";
		
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
			case "peta_jabatan":
				$sql = "
					SELECT *
					FROM idx_bidang
					WHERE id IN ('1','2','3')
				";
			break;
			case "detail_peta_jabatan":
				$tipologi = $this->input->post('tipgi');
				$jenis_bkl = $this->input->post('jns_bkl');
				$id_bkl = $this->input->post('idx_kbl');
				
				/*
				if($jenis_bkl == 'B'){
					$join .= " LEFT JOIN idx_bidang C ON  LEFT JOIN idx_tipologi B ON A.idx_tipologi_id = B.id";
				}
				*/
				
				$id_tipologi = $this->db->get_where('idx_tipologi', array('inisial'=>$tipologi) )->row_array();
				$sql = "
					SELECT A.*
					FROM tbl_peta_jabatan A
					WHERE 1=1 
					AND A.idx_tipologi_id = '".$id_tipologi['id']."' 
					AND A.jenis_bkl = '".$jenis_bkl."' 
					AND A.idx_bkl_id = '".$id_bkl."' 
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
			
			case "tbl_peta_jabatan" :
				$select = "id, nama_jabatan as txt";
				$tabel = "tbl_peta_jabatan";
			break;
			case "idx_pendidikan_kknipdn" :
				$select = "id, jenjang as txt";
				$tabel = "idx_jenjang_kknipdn";
				$where .= " AND idx_tipe_kknipdn_id = '1' OR idx_tipe_kknipdn_id = '2' ";
			break;
			case "idx_pangkat_kknipdn" :
				$select = "id, jenjang as txt";
				$tabel = "idx_jenjang_kknipdn";
				$where .= " AND idx_tipe_kknipdn_id = '3' OR idx_tipe_kknipdn_id = '4' OR idx_tipe_kknipdn_id = '5' OR idx_tipe_kknipdn_id = '6' OR idx_tipe_kknipdn_id = '7' OR idx_tipe_kknipdn_id = '8' ";
			break;
			
			case "idx_kompetensi_manajerial":
				$select = "id, nama_kompetensi_manajerial as txt";
				$tabel = "idx_kompetensi_manajerial";
			break;
			case "idx_level_kompetensi_manajerial":
				$param = $this->input->post('v2');
				if($param){
					$parameter = $param;
				}else{
					$parameter = $p2;
				}
				$select = "
					id, level as txt
				";
				$tabel = "idx_level_kompetensi_manajerial";				
				$where .= "
					AND idx_kompetensi_manajerial_id = '".$parameter."'
				";
			break;
			case "tbl_unit_kompetensi":
				$select = "
					id, judul_unit as txt
				";
				$where .= "
					AND kode_unit_kompetensi IS NOT NULL
				";
			break;
			case "idx_bakat":
				$select = "
					id, nama_bakat as txt
				";
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
		$this->load->library('encrypt');
		
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
					}elseif($post['editstatus'] == 'edit' || $post['editstatus'] == 'delete'){	
						$tbl_tim_kerja_id = $post['id'];
						$this->db->delete('tbl_anggota_tim_kerja', array('tbl_tim_kerja_id'=>$tbl_tim_kerja_id));
					}
					
					if($post['editstatus'] == 'delete'){
						$this->db->delete('tbl_anggota_tim_kerja', array( 'tbl_tim_kerja_id'=>$post['id']) );
					}else{
						$count = count($post['nama'])-1;
						$array_insert_batch = array();
						$array_insert_user = array();
						for($i = 0; $i <= $count; $i++){
							//blok program insert to tbl_user
							if($post['isuser'][$i] == 'Y'){
								if($post['email'] != ''){
									$password_asli = $this->lib->randomString(5, 'huruf');
									$password = $this->encrypt->encode($password_asli);
									$array_user = array(
										'username' => $post['email'][$i],
										'password' => $password,
										'real_name' => $post['nama'][$i],
										'level_admin' => $post['jabatan_tim_kerja'][$i],
										'email' => $post['email'][$i],
										'aktif' => 1,
									);
									$isusernya = 'Y';
									array_push($array_insert_user, $array_user);
									
									$konten = "
										Data user anda dalam aplikasi Sistem Informasi SK3APDN <br/>
										Username : ".$post['email'][$i]." <br/>
										Password : ".$password_asli." <br/>
										Demikian yang bisa disampaikan <br/>
										Terima Kasih.
									";
									$subjek = "Notifikasi Email User Aplikasi Sistem Informasi SK3APDN";
									
									$this->lib->kirimemail($konten, $subjek, $post['email'][$i]);
								}else{
									$isusernya = 'N';
								}
							}else{
								$isusernya = 'N';
							}
							
							//blok program insert to tbl_tim_kerja
							$array_insert = array(
								'tbl_tim_kerja_id' => $tbl_tim_kerja_id,
								'idx_jabatan_tim_kerja_id' => $post['jabatan_tim_kerja'][$i],
								'jabatan' =>  $post['jabatan'][$i],
								'is_user' => $isusernya,
								'email' =>  $post['email'][$i],
								'nama' =>  $post['nama'][$i],
							);
							array_push($array_insert_batch, $array_insert);
							
						}
						$this->db->insert_batch("tbl_anggota_tim_kerja", $array_insert_batch);
						$this->db->insert_batch("tbl_user_admin", $array_insert_user);
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
			case "detail_peta_jabatan":
				if($post['editstatus'] != 'delete'){
					$kode_gen = strtoupper($this->lib->randomString(5));
					$post_bnr['idx_tipologi_id'] 	= $post['tipid'];
					$post_bnr['jenis_bkl'] 		= $post['jnsbk'];
					$post_bnr['idx_bkl_id'] 	= $post['idxbk'];
					
					$post_bnr['nama_jabatan'] 	= $post['namajabatan'];
					$post_bnr['tugas'] 	= $post['tgs'];
					$post_bnr['uraian_tugas'] 	= $post['uraiantugas'];
					$post_bnr['target_capaian_pekerjaan'] 	= $post['targetcapaian'];
					$post_bnr['resiko_pekerjaan'] 	= $post['resikopekerjaan'];
					$post_bnr['bahan_kerja'] 	= $post['bahankerja'];
					$post_bnr['peralatan_kerja'] 	= $post['peralatankerja'];
					$post_bnr['pelaksanaan_kerja'] 	= $post['pelaksanaankerja'];
					$post_bnr['kondisi_fisik'] 	= $post['kondisifisik'];
					$post_bnr['atasan_langsung_id'] 	= $post['atasanlangsung'];
					$post_bnr['idx_pangkat_kknipdn_id'] 	= $post['pangkatjenjangjabatan'];
					$post_bnr['idx_pendidikan_kknipdn_id'] 	= $post['pendidikanformal'];
					
					$post_bnr['kode_gen'] 			= $kode_gen;
				}
				
				if($post['editstatus'] == 'add'){
					$execute = $this->db->insert('tbl_peta_jabatan', $post_bnr);
				}elseif($post['editstatus'] == 'edit'){
					$execute = $this->db->update('tbl_peta_jabatan', $post_bnr, array('id'=>$post['id']) );
				}elseif($post['editstatus'] == 'delete'){
					$execute = $this->db->delete('tbl_peta_jabatan', array('id'=>$post['id']) );
				}
			
				if($execute){
					if($post['editstatus'] == 'add'){
						$get_id = $this->db->get_where('tbl_peta_jabatan', array('kode_gen'=>$kode_gen))->row_array();
						$tbl_petjab_id = $get_id['id'];
						
						$array_skema = array(
							'tbl_peta_jabatan_id' => $tbl_petjab_id,
							'jenis_bkl' => $post['jnsbk'],
							'idx_bkl_id' => $post['idxbk'],
							'pekerjaan' => $post['tgs'],
							'idx_jenjang_kknipdn_id' => $post['pangkatjenjangjabatan']
						);
						
						$this->db->insert('tbl_skema_sertifikasi', $array_skema);
					}elseif($post['editstatus'] == 'edit' || $post['editstatus'] == 'delete'){	
						$tbl_petjab_id = $post['id'];
						
						$this->db->delete("tbl_petjab_level_kompetensi_manajerial", array('tbl_peta_jabatan_id'=>$post['id']) );
						$this->db->delete("tbl_petjab_kompetensi_teknis", array('tbl_peta_jabatan_id'=>$post['id']) );
						$this->db->delete("tbl_petjab_bakat", array('tbl_peta_jabatan_id'=>$post['id']) );
						$this->db->delete("tbl_petjab_prasyarat_dasar", array('tbl_peta_jabatan_id'=>$post['id']) );						
						
						if($post['editstatus'] == 'edit'){
							$array_skema = array(
								'jenis_bkl' => $post['jnsbk'],
								'idx_bkl_id' => $post['idxbk'],
								'pekerjaan' => $post['tgs'],
								'idx_jenjang_kknipdn_id' => $post['pangkatjenjangjabatan']
							);
							$this->db->update('tbl_skema_sertifikasi', $array_skema, array('tbl_peta_jabatan_id' => $tbl_petjab_id) );
						}elseif($post['editstatus'] == 'delete'){
							$this->db->delete("tbl_skema_sertifikasi", array('tbl_peta_jabatan_id'=>$post['id']) );						
						}
					}
					
					if($post['editstatus'] == 'add' || $post['editstatus'] == 'edit'){
						$count_manajerial = count($post['levelkompetensimanajerial'])-1;
						$count_teknis = count($post['unit_kompetensi'])-1;
						$count_bakat = count($post['bakat'])-1;
						$count_prasyarat = count($post['prasyarat_dasar'])-1;
						
						$array_manajerial_batch = array();
						for($i = 0; $i <= $count_manajerial; $i++){
							$array_manajerial_insert = array(
								'tbl_peta_jabatan_id' => $tbl_petjab_id,
								'idx_level_kompetensi_manajerial' => $post['levelkompetensimanajerial'][$i],
							);
							array_push($array_manajerial_batch, $array_manajerial_insert);
						}
						
						$array_teknis_batch = array();
						for($ii = 0; $ii <= $count_teknis; $ii++){
							$array_teknis_insert = array(
								'tbl_peta_jabatan_id' => $tbl_petjab_id,
								'tbl_unit_kompetensi_id' => $post['unit_kompetensi'][$ii],
							);
							array_push($array_teknis_batch, $array_teknis_insert);
						}
						
						$array_bakat_batch = array();
						for($iii = 0; $iii <= $count_bakat; $iii++){
							$array_bakat_insert = array(
								'tbl_peta_jabatan_id' => $tbl_petjab_id,
								'idx_bakat_id' => $post['bakat'][$iii],
							);
							array_push($array_bakat_batch, $array_bakat_insert);
						}
						
						$array_prasyarat_batch = array();
						for($iiii = 0; $iiii <= $count_prasyarat; $iiii++){
							$array_prasyarat_insert = array(
								'tbl_peta_jabatan_id' => $tbl_petjab_id,
								'prasyarat_dasar' => $post['prasyarat_dasar'][$iiii],
								'bukti' => $post['bukti'][$iiii],
							);
							array_push($array_prasyarat_batch, $array_prasyarat_insert);
						}
						
						$this->db->insert_batch("tbl_petjab_level_kompetensi_manajerial", $array_manajerial_batch);
						$this->db->insert_batch("tbl_petjab_kompetensi_teknis", $array_teknis_batch);
						$this->db->insert_batch("tbl_petjab_bakat", $array_bakat_batch);
						$this->db->insert_batch("tbl_petjab_prasyarat_dasar", $array_prasyarat_batch);
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