<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class modul_admin extends SHIPMENT_Controller{
	function __construct(){
		parent::__construct();		
		$this->auth = unserialize(base64_decode($this->session->userdata('d1kl4tst4nd41215451-4dm117')));
		$this->host	= $this->config->item('base_url');
		$host = $this->host;
		
		$this->smarty->assign('host',$this->host);
		$this->smarty->assign('auth', $this->auth);
		$this->load->model("lv/madmin");
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
            $modul = "front/";
            switch($type){
                case "datagridview":
                    switch ($p1){
                        case 'kementrian_grid':
                            $content = "modul-lv/kementrian_lembaga/main.html";
                            $this->smarty->assign('tipe',$p1);
                        break;
                        case 'bidang_urusan':
                            $content = "modul-lv/bidang/tabel.html";
                            $this->smarty->assign('tipe',$p1);
                        break; 
                        case "kel_kompetensi":
                            $content = "modul-lv/kel_kompetensi/tabel.html";
                            $this->smarty->assign('tipe',$p1);                    
                        break;
                        case "kompetensi_manajerial":
                            $content = "modul-lv/kompetensi_manajerial/tabel.html";     
                            $this->smarty->assign('tipe',$p1);                
                        break;
                        case "kompetensi_kunci":
                            $content = "modul-lv/kompetensi_kunci/tabel.html";     
                            $this->smarty->assign('tipe',$p1);                      
                        break;
                        case "bakat":
                            $content = "modul-lv/bakat/tabel.html";      
                            $this->smarty->assign('tipe',$p1);                     
                        break;
                        case "list_eselon":
                            $id_kl = $this->input->post('id_kementrian');
                            $sql = $this->db->query("SELECT * FROM idx_kl WHERE id = '$id_kl'")->row_array();
                            
                            $content = "modul-lv/kementrian_lembaga/dirjen.html";   
                            $this->smarty->assign('row',$sql);
                            $this->smarty->assign('tipe',$p1);                     
                        break;
                            
                    }
                break; 
                case 'kementrian_grid':
                    $content = "modul-lv/kementrian_lembaga/tabel.html";
                break;
                case "sub_bidang":
                    $id_bidang = $this->input->post('id_bidang');
                    $sql = $this->db->query("SELECT * FROM idx_bidang WHERE id = '$id_bidang'")->row_array(); 
                    $this->smarty->assign('row',$sql);
                    $content = "modul-lv/bidang/sub_bidang.html";
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
	
	
}