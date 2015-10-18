<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class modul_admin extends SHIPMENT_Controller{
	function __construct(){
		parent::__construct();		
		$this->auth = unserialize(base64_decode($this->session->userdata('d1kl4tst4nd41215451-4dm117')));
		$this->host	= $this->config->item('base_url');
		$host = $this->host;
		
		$this->smarty->assign('host',$this->host);
		$this->smarty->assign('auth', $this->auth);
		$this->load->model("why/madmin");
	}
	
	function index() {
		if($this->auth) {
			
			$module = $this->madmin->get_data('get_module', 'result_array');
			$submodule = $this->madmin->get_data('get_submodule', 'result_array');
			
			foreach($module as $k=>$v){
				$menu = strtolower($v['nama_module']);
				$menu = str_replace(" ","", $menu);
				$menu = str_replace("/","", $menu);
				
				$access = $this->madmin->is_access($v['function_id'], $this->auth['level_admin']);
				$this->smarty->assign($menu, $access);
			}
			
			foreach($submodule as $y=>$t){
				$menu = strtolower($t['nama_submodule']);
				$menu = str_replace(" ","", $menu);
				$menu = str_replace("/","", $menu);
				
				$access = $this->madmin->is_access($t['function_id'], $this->auth['level_admin']);
				$this->smarty->assign($menu, $access);
			}			
			
			
			$this->smarty->display('index-admin.html');
		}else {
			$this->smarty->display('login.html');
		}
	}
	
	function getdisplay($type="", $p1="", $p2="", $p3=""){
		switch($type){
			case "pembentukan_tim":
				$content = "modul-why/pembentukan-tim/main.html";
			break;
			case "form_pembentukan_tim":
				$editstatus = $this->input->post('editstatus');
				$content = "modul-why/pembentukan-tim/form.html";
				
				if($editstatus == 'edit'){
					$id = $this->input->post('id');
					$data = $this->db->get_where('tbl_tim_kerja', array('id'=>$id) )->row_array();
					$data_anggota = $this->db->get_where('tbl_anggota_tim_kerja', array('tbl_tim_kerja_id'=>$id))->result_array();
					if($data_anggota){
						$array_combo = array();
						$idx = 1;
						foreach($data_anggota as $k => $v){
							$this->smarty->assign('combo_'.$idx, $this->lib->fillcombo('idx_jabatan_tim_kerja', 'return', $v['idx_jabatan_tim_kerja_id'] ) );
							$this->smarty->assign('combo_isuser_'.$idx, $this->lib->fillcombo('ya_tidak', 'return', $v['is_user'] ) );
							$idx++;
						}
					}
					
					$this->smarty->assign('data', $data);
					$this->smarty->assign('data_anggota', $data_anggota);
					$this->smarty->assign('class', "active");
				}
				
				$this->smarty->assign('editstatus', $editstatus);
				$this->smarty->assign('idx_kl', $this->lib->fillcombo('idx_kl', 'return', ($editstatus == 'edit' ? $data['idx_kl_id'] : "") ));
				$this->smarty->assign('idx_bidang', $this->lib->fillcombo('idx_bidang', 'return', ($editstatus == 'edit' ? $data['idx_bidang_id'] : "") ));
				$this->smarty->assign('idx_tim_kerja', $this->lib->fillcombo('idx_tim_kerja', 'return', ($editstatus == 'edit' ? $data['idx_tim_kerja_id'] : "") ));
			break;
			
			
			case "rencana_perumusan":
				$content = "modul-why/rencana-perumusan/main.html";
			break;
			case "form_rencana_perumusan":
				$editstatus = $this->input->post('editstatus');
				$content = "modul-why/rencana-perumusan/form.html";
				
				if($editstatus == 'edit'){
					$id = $this->input->post('id');
					$data = $this->db->get_where('tbl_perumusan', array('id'=>$id) )->row_array();
					$data_subbidang = $this->db->get_where('tbl_subbidang_perumusan', array('tbl_perumusan_id'=>$id))->result_array();
					if($data_subbidang){
						$array_combo = array();
						$idx = 1;
						foreach($data_subbidang as $k => $v){
							$this->smarty->assign('combo_'.$idx, $this->lib->fillcombo('tbl_subbidang_perumusan', 'return', $v['idx_sub_bidang_id'] ) );
							$idx++;
						}
					}
					
					$data_dasarhukum = $this->db->get_where('tbl_dasarhukum_perumusan', array('tbl_perumusan_id'=>$id))->result_array();
					if($data_dasarhukum){
						$array_combos = array();
						$idxw = 1;
						foreach($data_dasarhukum as $kz => $vz){
							$this->smarty->assign('combos_'.$idxw, $this->lib->fillcombo('idx_dasar_hukum', 'return', $vz['idx_dasar_hukum_id'] ) );
							$idxw++;
						}
					}
					
					$count = ($data['estimasi_waktu']-1);
					for($i = 1; $i <= 22; $i++){
						$exp_cekbox = explode(":", $data['3_'.$i]);
						$cekbox = "";
						for($t = 0; $t <= $count; $t++){
							if($exp_cekbox[$t] == 0){
								$checked = "";
								$nilai = 0;
							}else{
								$checked = "checked";
								$nilai = ($t+1);
							}
														
							$cekbox .= "<input type='hidden' name='3_".$i."[]' value='".$nilai."'>";
							$cekbox .= "<input type='checkbox'  ".$checked." onclick='this.previousSibling.value=".($t+1)."-this.previousSibling.value' > ".($t+1)." &nbsp; ";
						}
						$this->smarty->assign('3_'.$i, $cekbox);
					}
					
					for($ii = 1; $ii <= 2; $ii++){
						$exp_cekbox = explode(":", $data['4_'.$ii]);
						$cekbox = "";
						for($t = 0; $t <= $count; $t++){
							if($exp_cekbox[$t] == 0){
								$checked = "";
								$nilais = 0;
							}else{
								$checked = "checked";
								$nilais = ($t+1);
							}
														
							$cekbox .= "<input type='hidden' name='4_".$ii."[]' value='".$nilais."'>";
							$cekbox .= "<input type='checkbox'  ".$checked." onclick='this.previousSibling.value=".($t+1)."-this.previousSibling.value' > ".($t+1)." &nbsp; ";
						}
						$this->smarty->assign('4_'.$ii, $cekbox);
					}
					
					for($iii = 1; $iii <= 2; $iii++){
						$exp_cekbox = explode(":", $data['5_'.$iii]);
						$cekbox = "";
						for($t = 0; $t <= $count; $t++){
							if($exp_cekbox[$t] == 0){
								$checked = "";
								$nilaiss = 0;
							}else{
								$checked = "checked";
								$nilaiss = ($t+1);
							}
														
							$cekbox .= "<input type='hidden' name='5_".$iii."[]' value='".$nilaiss."'>";
							$cekbox .= "<input type='checkbox'  ".$checked." onclick='this.previousSibling.value=".($t+1)."-this.previousSibling.value' > ".($t+1)." &nbsp; ";
						}
						$this->smarty->assign('5_'.$iii, $cekbox);
					}
					
					$this->smarty->assign('data', $data);
					$this->smarty->assign('data_subbidang', $data_subbidang);
					$this->smarty->assign('data_dasarhukum', $data_dasarhukum);
					$this->smarty->assign('class', "active");
				}				
				
				$this->smarty->assign('editstatus', $editstatus);
				$this->smarty->assign('idx_bidang', $this->lib->fillcombo('idx_bidang', 'return', ($editstatus == 'edit' ? $data['idx_bidang_id'] : "") ));
				$this->smarty->assign('idx_tim_kerja_perumus', $this->lib->fillcombo('idx_tim_kerja_perumus', 'return', ($editstatus == 'edit' ? $data['tbl_tim_kerja_perumus_id'] : "") ));
				$this->smarty->assign('idx_tim_verifikasi_perumus', $this->lib->fillcombo('idx_tim_verifikasi_perumus', 'return', ($editstatus == 'edit' ? $data['tbl_tim_kerja_verifikasi_id'] : "") ));
				$this->smarty->assign('idx_tim_komite_perumus', $this->lib->fillcombo('idx_tim_komite_perumus', 'return', ($editstatus == 'edit' ? $data['tbl_tim_kerja_komite_id'] : "") ));
				$this->smarty->assign('idx_kl', $this->lib->fillcombo('idx_kl', 'return', ($editstatus == 'edit' ? $data['idx_kl_id'] : "") ));
				$this->smarty->assign('idx_dirjen', ($editstatus == 'add' ? "<option value='0'> -- Pilih Combo Kementerian Dahulu --</option>" : ""));
			break;
			
			case "peta_jabatan":
				$content = "modul-why/peta-jabatan/main.html";
				$this->smarty->assign('breadcumb', "PETA JABATAN");
			break;
			case "detail_peta_jabatan":
				$tipologi = $this->input->post('tipgi');
				$jenis_bkl = $this->input->post('jns_bkl');
				$id_bkl = $this->input->post('idx_kbl');
				$label_bkl = $this->input->post('lbl');
				
				if($jenis_bkl == 'B'){
					$label_bkl = $label_bkl." - TIPOLOGI ".$tipologi;
				}
				
				$content = "modul-why/peta-jabatan/main.html";
				$this->smarty->assign('breadcumb', $label_bkl);
				$this->smarty->assign('tipologi', $tipologi);
				$this->smarty->assign('jenis_bkl', $jenis_bkl);
				$this->smarty->assign('id_bkl', $id_bkl);
				$this->smarty->assign('label', $label_bkl);
			break;
			case "form_detail_peta_jabatan":
				$editstatus = $this->input->post('editstatus');
				$tipologi = $this->input->post('tipgi');
				$jenis_bkl = $this->input->post('jns_bkl');
				$id_bkl = $this->input->post('idx_kbl');
				$label = $this->input->post('lbl');
				$tipologi_id = $this->db->get_where('idx_tipologi', array('inisial'=>$tipologi) )->row_array();
				
				if($editstatus == 'edit'){
					$id = $this->input->post('idxny');
					$data = $this->db->get_where('tbl_peta_jabatan', array('id'=>$id) )->row_array();
					
					$data_manajerial = $this->madmin->get_data('level_kompetensi_manajerial', 'result_array', $id);   //$this->db->get_where('tbl_petjab_level_kompetensi_manajerial', array('tbl_peta_jabatan_id'=>$id))->result_array();
					if($data_manajerial){
						$idx = 1;
						foreach($data_manajerial as $k => $v){
							$this->smarty->assign('combo_level_kompetensi_manajerial_'.$idx, $this->lib->fillcombo('idx_level_kompetensi_manajerial', 'return', $v['idx_level_kompetensi_manajerial'], $v['idx_kompetensi_manajerial_id'] ) );
							$this->smarty->assign('combo_kompetensi_manajerial_'.$idx, $this->lib->fillcombo('idx_kompetensi_manajerial', 'return', $v['idx_kompetensi_manajerial_id'] ) );
							$idx++;
						}
					}else{
						$this->smarty->assign('sts_data_manajerial', 'T');
					}
					
					$data_teknis = $this->madmin->get_data('kompetensi_teknis', 'result_array', $id);   //$this->db->get_where('tbl_petjab_kompetensi_teknis', array('tbl_peta_jabatan_id'=>$id))->result_array();
					if($data_teknis){
						$idxx = 1;
						foreach($data_teknis as $k => $v){
							$this->smarty->assign('combo_unit_kompetensi_'.$idxx, $this->lib->fillcombo('tbl_unit_kompetensi', 'return', $v['tbl_unit_kompetensi_id'] ) );
							$idxx++;
						}
					}else{
						$this->smarty->assign('sts_data_teknis', 'T');
					}
					
					$data_bakat = $this->db->get_where('tbl_petjab_bakat', array('tbl_peta_jabatan_id'=>$id))->result_array();
					if($data_bakat){
						$idxxx = 1;
						foreach($data_bakat as $k => $v){
							$this->smarty->assign('combo_bakat_'.$idxxx, $this->lib->fillcombo('idx_bakat', 'return', $v['idx_bakat_id'] ) );
							$idxxx++;
						}
					}else{
						$this->smarty->assign('sts_data_bakat', 'T');
					}
					
					$data_prasyarat = $this->db->get_where('tbl_petjab_prasyarat_dasar', array('tbl_peta_jabatan_id'=>$id))->result_array();
					if($data_prasyarat){
					
					}else{
						$this->smarty->assign('sts_data_prasyarat', 'T');
					}
					
					
					$this->smarty->assign('data', $data);
					$this->smarty->assign('class', "active");

					$this->smarty->assign('data_manajerial', $data_manajerial);
					$this->smarty->assign('data_teknis', $data_teknis);
					$this->smarty->assign('data_bakat', $data_bakat);
					$this->smarty->assign('data_prasyarat', $data_prasyarat);
						
				}
				
				$content = "modul-why/peta-jabatan/form-detail-peta-jabatan.html";
				$this->smarty->assign('editstatus', $editstatus);
				$this->smarty->assign('tipologi_id', $tipologi_id['id']);
				$this->smarty->assign('tipologi', $tipologi);
				$this->smarty->assign('jenis_bkl', $jenis_bkl);
				$this->smarty->assign('id_bkl', $id_bkl);		
				$this->smarty->assign('label', $label);		
				
				$this->smarty->assign('atasan_langsung_id', $this->lib->fillcombo('tbl_peta_jabatan', 'return', ($editstatus == 'edit' ? $data['atasan_langsung_id'] : ""), $tipologi_id['id'], $jenis_bkl, $id_bkl ));
				$this->smarty->assign('idx_pangkat_kknipdn_id', $this->lib->fillcombo('idx_pangkat_kknipdn', 'return', ($editstatus == 'edit' ? $data['idx_pangkat_kknipdn_id'] : ""), $jenis_bkl ));
				$this->smarty->assign('idx_pendidikan_kknipdn_id', $this->lib->fillcombo('idx_pendidikan_kknipdn', 'return', ($editstatus == 'edit' ? $data['idx_pendidikan_kknipdn_id'] : "") ));
			break;
			case "get_kode_kompetensi":
				$id_komp = $this->input->post('idxn');
				$unit_kompetensi = $this->db->get_where('tbl_unit_kompetensi', array('id'=>$id_komp) )->row_array();
				echo $unit_kompetensi['kode_unit_kompetensi'];
				exit;
			break;

            case "manajemen_user_list":
				$content = "modul-why/manajemen-user/main-user-list.html";
			break;
            case "form_manajemen_user_list":
                $editstatus = $this->input->post('editstatus');
                if($editstatus == 'edit'){
                    $this->load->library('encrypt');
                    $id = $this->input->post('id');
                    $data = $this->db->get_where('tbl_user_admin', array('id'=>$id) )->row_array();
                    $data['password'] = $this->encrypt->decode($data['password']);
                    
                    $this->smarty->assign('data', $data);
					$this->smarty->assign('class', "active");
                }
                
                $content = "modul-why/manajemen-user/form-manajemen-user-list.html";
                
                $this->smarty->assign('editstatus', $editstatus);
                $this->smarty->assign('level_admin', $this->lib->fillcombo('idx_level_user', 'return', ($editstatus == 'edit' ? $data['level_admin'] : "") ));
                $this->smarty->assign('status_aktif', $this->lib->fillcombo('status', 'return', ($editstatus == 'edit' ? $data['aktif'] : "") ));
            break;
            
            case "manajemen_user_role":
				$content = "modul-why/manajemen-user/main-user-role.html";
			break;
            case "form_manajemen_user_role":
                
            break;
            
            case "user_role":
                $content = "modul-why/manajemen-user/user-role.html";
                $id_group = $this->input->post('id_group');
                $array = array();
                $dataParent = $this->madmin->get_data('menu_parent', 'result_array');
                    foreach($dataParent as $k=>$v){
								$dataChild = $this->madmin->get_data('menu_child', 'result_array', $v['id']);
								$dataPrev = $this->madmin->get_data('previliges_menu', 'row_array', $v['id'], $id_group);
								
								$array[$k]['id'] = $v['id'];
								$array[$k]['nama_module'] = $v['nama_module'];
								$array[$k]['id_prev'] = (isset($dataPrev['id']) ? $dataPrev['id'] : 0) ;
								$array[$k]['is_access'] = (isset($dataPrev['is_access']) ? $dataPrev['is_access'] : 0) ;
                                $array[$k]['is_crud'] = (isset($dataPrev['is_crud']) ? $dataPrev['is_crud'] : 0) ;

								$array[$k]['child_menu'] = array();
								$jml = 0;
								foreach($dataChild as $y => $t){
									$dataPrevChild = $this->madmin->get_data('previliges_menu', 'row_array', $t['id'], $id_group);
									$array[$k]['child_menu'][$y]['id_child'] = $t['id'];
									$array[$k]['child_menu'][$y]['nama_menu_child'] = $t['nama_submodule'];
									$array[$k]['child_menu'][$y]['id_prev'] = (isset($dataPrevChild['id']) ? $dataPrevChild['id'] : 0) ;
									$array[$k]['child_menu'][$y]['is_access'] = (isset($dataPrevChild['is_access']) ? $dataPrevChild['is_access'] : 0) ;
                                    $array[$k]['child_menu'][$y]['is_crud'] = (isset($dataPrevChild['is_crud']) ? $dataPrevChild['is_crud'] : 0) ;
									$jml++;
								}
								$array[$k]['total_child'] = $jml;
                    }
                    /*
                    echo "<pre>";
                    print_r($array);
                    exit;
                    */
                    
                $this->smarty->assign('role', $array);
                $this->smarty->assign('id_group', $id_group);
            break;
		}
		
		$this->smarty->assign('type', $type);
		$this->smarty->display($content);
	}	
	
	function getdatagrid($type){
		echo $this->madmin->get_data_grid($type);
	}
	
	function simpansavedbx($type=""){
		$post = array();
        //foreach($_POST as $k=>$v) $post[$k] = $this->db->escape_str($this->input->post($k));
        foreach($_POST as $k=>$v) $post[$k] = $this->input->post($k);
		
		/*
		echo "<pre>";
		print_r($post);
		exit;
		//*/
		
		echo $this->madmin->simpansavedatabase($type, $post);
	}
	
	function getcombo($type){
		echo $this->lib->fillcombo($type, "echo");
	}
	
	function test(){
		/*
		$str = "1";
		$exp = explode(":", $str);
		print_r($exp);
		*/
		
		$this->load->library('encrypt');
		$datauser = $this->db->get_where('tbl_user_admin', array('username'=>'triwahyunugroho11@gmail.com') )->row_array();
		$password = $this->encrypt->decode($datauser['password']);
		
		$html = "
			passwordnya = ".$password."
		";
		
		echo $html;
		
	}
	
	function get_access_data($type=""){
		switch($type){
			case "peta_jabatan":
				$array = array();
				$array['bidang'] = array();
				$array['kl'] = array();
				
				$sql = "
					SELECT B.idx_bidang_id, B.idx_kl_id
					FROM tbl_anggota_tim_kerja A
					LEFT JOIN tbl_tim_kerja B ON A.tbl_tim_kerja_id = B.id
					WHERE email = 'itil'
				";
				$data = $this->db->query($sql)->result_array();
				if($data){
					foreach($data as $k => $v){
						$array['bidang'][] = $v['idx_bidang_id'];
						$array['kl'][] = $v['idx_kl_id'];
					}
				}
				echo "<pre>";
				print_r($array);exit;
			break;
		}
	}	
	
}