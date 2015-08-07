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
			/*
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
			*/
			
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
				
				$this->smarty->assign('editstatus', $editstatus);
				$this->smarty->assign('idx_bidang', $this->lib->fillcombo('idx_bidang', 'return', ($editstatus == 'edit' ? "buat" : "") ));
				$this->smarty->assign('idx_tim_kerja_perumus', $this->lib->fillcombo('idx_tim_kerja_perumus', 'return', ($editstatus == 'edit' ? "buat" : "") ));
				$this->smarty->assign('idx_tim_verifikasi_perumus', $this->lib->fillcombo('idx_tim_verifikasi_perumus', 'return', ($editstatus == 'edit' ? "buat" : "") ));
				$this->smarty->assign('idx_tim_komite_perumus', $this->lib->fillcombo('idx_tim_komite_perumus', 'return', ($editstatus == 'edit' ? "buat" : "") ));
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
	
	
}