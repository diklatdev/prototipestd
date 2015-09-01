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
                        case "bakat_list":
                            $content = "modul-lv/bakat/tabel.html";      
                            $this->smarty->assign('tipe',$p1);                     
                        break;
                        case "list_eselon":
                            $id_kl = $this->input->post('id_kementrian');
                            $sql = $this->db->query("SELECT * FROM idx_kl WHERE id = '$id_kl'")->row_array();
                            
                            $content = "modul-lv/kementrian_lembaga/dirjen.html";   
                            $this->smarty->assign('row',$sql);
                            $this->smarty->assign('tipe',$p1);                
                            $this->smarty->assign('id_where', $id_kl);     
                        break;
                        case "sub_bidang":
                            $id_bidang = $this->input->post('id_bidang');
                            $sql = $this->db->query("SELECT * FROM idx_bidang WHERE id = '$id_bidang'")->row_array(); 
                            $this->smarty->assign('row',$sql);
                            $content = "modul-lv/bidang/sub_bidang.html";
                            $this->smarty->assign('tipe',$p1);  
                            $this->smarty->assign('id_where', $id_bidang);
                        break;		
                        case "pemetaan_fungsi":
                            $content = "modul-lv/pemetaan-fungsi/main.html";
                            $this->smarty->assign('tipe',$p1); 
                        break;
                        case "unit_kompetensi":
                            $id_bidang = $this->input->post('id_bidang');
                            $content = "modul-lv/pemetaan-fungsi/unit_kompetensi.html";
                            $this->smarty->assign('tipe',$p1); 
                            $this->smarty->assign('id_where', $id_bidang);                            
                        break;
                        case "skema_sertifikasi":
                            $content = "modul-lv/skema_sertifikasi/main.html";
                            $this->smarty->assign('tipe',$p1);                             
                        break;     
                        case "dasar_hukum":
                            $content = "modul-lv/dasar_hukum/tabel.html";      
                            $this->smarty->assign('tipe',$p1);                     
                        break;                       
                    }
                break; 
                case 'kementrian_grid':
                    $content = "modul-lv/kementrian_lembaga/tabel.html";
                break;
                case 'sub_subbidang':
                    $id_sub2bidang = $this->input->post('id_subbidang');
                    $sql_pusat = $this->madmin->get_data('sub_sub2bidang','result_array',$id_sub2bidang,'1');
                    $sql_prov = $this->madmin->get_data('sub_sub2bidang','result_array',$id_sub2bidang,'2');
                    $sql_kab = $this->madmin->get_data('sub_sub2bidang','result_array',$id_sub2bidang,'3');
                    $this->smarty->assign('data_pusat',$sql_pusat);
                    $this->smarty->assign('data_prov',$sql_prov);
                    $this->smarty->assign('data_kab',$sql_kab);
                    $this->smarty->assign('id_sub_bidang', $id_sub2bidang);
                    $content = "modul-lv/bidang/sub_subbidang.html";
                break;
                case 'detil_komp_manaj':
                    $id_kompt_man = $this->input->post('id_komp_man');
                    $sql = $this->madmin->get_data('kompetensi_manajerial', 'row_array', $id_kompt_man,'detil');
                    $level_sql = $this->madmin->get_data('kompetensi_manajerial','result_array',$id_kompt_man,'level');
                    $this->smarty->assign('data', $sql);
                    $this->smarty->assign('data_level', $level_sql);
                    $content = "modul-lv/kompetensi_manajerial/form.html";
                    
                break;
                case "level_komp_kunci":
                    $id_komp_kunci = $this->input->post('id_komp_kunci');
                    $sql_detail = $this->madmin->get_data('kompetensi_kunci', 'row_array', $id_komp_kunci,'detil');
                    $sql = $this->madmin->get_data('kompetensi_kunci', 'result_array', $id_komp_kunci,'level');
                    $this->smarty->assign('data', $sql);
                    $this->smarty->assign('detil', $sql_detail);
                    $content = "modul-lv/kompetensi_kunci/tabel_level.html";                    
                break;
                case "fungsi_dasar":
                    $id_bidang_all = $this->input->post('id_bidang');
                    $id_bidang_all = explode('-', $id_bidang_all);
                    $id_bidang = $id_bidang_all[0];
                    $id_pemerintahan = $id_bidang_all[1];
                    
                    $nama_pemerintahan = "";
                    switch ($id_pemerintahan){
                        case "1":
                            $nama_pemerintahan = "Pemerintahan Pusat";
                        break;
                        case "2":
                            $nama_pemerintahan = "Pemerintahan Provinsi";
                        break;
                        case "3":
                            $nama_pemerintahan = "Pemerintahan Kabupaten/Kota";
                        break;
                            
                    }
                    $this->smarty->assign('nama_pemerintahan', $nama_pemerintahan);
                    
                    $this->smarty->assign('id_bidang', $id_bidang);
                    $this->smarty->assign('id_pemerintahan', $id_pemerintahan);
                    
                    $sql = $this->db->query("SELECT * FROM idx_bidang WHERE id = $id_bidang ORDER BY id")->row_array();
                    $sql2 = $this->db->query("SELECT id as id_sub, nama_sub_bidang "
                            . "FROM idx_sub_bidang "
                            . "WHERE idx_bidang_id = $id_bidang ORDER BY id")->result_array();
                    $sub = '';

                    foreach ($sql2 as $k => $v){ 
                        $sql3 = $this->db->query("SELECT id as id_sub2, nama_sub_subbidang "
                                . "FROM idx_sub_subbidang "
                                . "WHERE idx_sub_bidang_id = ".$v['id_sub']." "
                                . "AND idx_tipe_pemerintahan_id = ".$id_pemerintahan." "
                                . "ORDER BY id")->result_array();
                        
                        $sub[$k]["id_sub"] = $v["id_sub"];
                        $sub[$k]["nama_sub_bidang"] = $v["nama_sub_bidang"];
                        $sub[$k]["sub_2"] = $sql3;
                        
                        foreach ($sql3 as $key =>$val){
                            $sqlFD = "SELECT A.id as id_fungsi_dasar, A.judul_unit, B.nama_kelompok_kompetensi "
                                    . "FROM tbl_unit_kompetensi A "
                                    . "LEFT JOIN idx_kelompok_kompetensi B ON A.idx_kelompok_kompetensi_id = B.id "
                                    . "WHERE idx_sub_subbidang_id = ".$val['id_sub2']." ORDER BY A.id";
                            $sqlFD = $this->db->query($sqlFD)->result_array();
                             
                            $sub[$k]["sub_2"][$key]["fungsi_dasar"] = $sqlFD; 
                        }
                        
                    }
                    
//                    echo "<pre>";
//                    print_r($sub);
                    $this->smarty->assign('bidang', $sql);
                    $this->smarty->assign('sub_data', $sub);
                    $content = "modul-lv/pemetaan-fungsi/fungsi_dasar.html";                                     
                break;
                case "form_kompetensi":
                    $id_kompetensi = $this->input->post("id_unit_kompetensi");
                    $data = $this->madmin->get_data("unit_kompetensi","row_array",$id_kompetensi);
                    $this->smarty->assign("row",$data);    
                    $no_urut = $data['no_urutan'];
                    
                      
                    if (!$no_urut){
                        
                        $urut = $this->db->query("SELECT MAX(no_urutan) as no_urut FROM tbl_unit_kompetensi "
                                . "WHERE idx_bidang_id = '".$data['id_bidang']."'")->row_array();
                        if (!$urut){
                            $no_urut = '001';
                        }else{
                            $nol = '';
                            $num = strlen($urut['no_urut']);
                            if ($num = 1 && $urut['no_urut'] != 9){
                                $no_urut = $urut['no_urut']+1;
                                $nol = '00';
                            }elseif($num = 2 && $urut['no_urut'] != 99){
                                $no_urut = $urut['no_urut']+1;
                                $nol = '0';
                            }else{
                                $no_urut = $urut['no_urut']+1;
                            }
                            $no_urut = $nol.$no_urut;
                        }                        
                    }
                    $this->smarty->assign('no_urut', $no_urut);
                    
                    $elemen = $this->db->query("SELECT * FROM tbl_elemen_unit_kompetensi "
                            . "WHERE tbl_unit_kompetensi_id = $id_kompetensi")->result_array();
                    $elem = "";
                    foreach ($elemen as $k => $v){
                        $unjuk = $this->db->query("SELECT * "
                                . "FROM tbl_kuk_elemen_unit_kompetensi "
                                . "WHERE tbl_elemen_unit_kompetensi_id = '".$v['id']."';")->result_array();
                        $elem[$k]["id_elemen"]=$v['id'];
                        $elem[$k]["nama_elemen"]=$v['nama']; 
                        $elem[$k]["kuk"] = $unjuk;
                    }
                    $this->smarty->assign('elemen', $elem);
                    
                    $kom_kunci_uk = $this->madmin->get_data('kom_kunci_uk','result_array',$id_kompetensi);
                    $this->smarty->assign('kompetensi_kunci', $kom_kunci_uk); 
                    
                    $das_hukum = $this->madmin->get_data('dasar_hukum_uk', 'result_array', $id_kompetensi);
                    $this->smarty->assign('das_hukum', $das_hukum);
                    
                    $content = "modul-lv/pemetaan-fungsi/form_kompetensi.html";
                break;
                case "skema_sertifikasi":
                    switch($p1){
                        case "form":
                            $bkl =$this->madmin->get_data('list_bkl','result_array');
                            $this->smarty->assign('bkl', $bkl);
                            $pangkat =$this->madmin->get_data('list_pangkat','result_array');
                            $this->smarty->assign('pangkat', $pangkat);
                            $content = "modul-lv/skema_sertifikasi/form_skema.html";
                        break;
                    }
                break;
                case "edit_skema_sertifikasi":
                    $id_bkl = $this->input->post('id_bkl');
                    $data = $this->madmin->get_data('skema_sert', 'row_array', $id_bkl);
                    $this->smarty->assign('data',$data);
                    
                    $bkl =$this->madmin->get_data('list_bkl','result_array');
                    $this->smarty->assign('bkl', $bkl);
                    
                    $pangkat =$this->madmin->get_data('list_pangkat','result_array');
                    $this->smarty->assign('pangkat', $pangkat);
                    
                    $sub_bkl = $this->madmin->get_data('sub_bkl', 'result_array',$data['idx_bkl_id'], $data['jenis_bkl']);
                    $this->smarty->assign('sub_bkl', $sub_bkl);
                    
                    $unit_komp = $this->madmin->get_data('skesert_unit_kompetensi', 'result_array', $id_bkl);
                    $this->smarty->assign('unit_kompt', $unit_komp);
                    
                    $syarat_dasar = $this->madmin->get_data('skesert_prsayarat_dasar', 'result_array', $id_bkl);
                    $this->smarty->assign('syarat_dasar', $syarat_dasar);
                    $this->smarty->assign('id_bkl', $id_bkl);
                    
                    $content = "modul-lv/skema_sertifikasi/form_skema_edit.html";
                break;
                case "dasar_hukum" :
                    if ($p1 == 'form'){
                        $content = "modul-lv/dasar_hukum/form-add.html";
                    }elseif ($p1 == 'edit'){
                       $id_dasar_hukum = $this->input->post('id_dasar_hukum');
                       $dukum = $this->db->query("SELECT id, dasar_hukum FROM idx_dasar_hukum WHERE id = '$id_dasar_hukum';")->row_array();
                       $this->smarty->assign('data', $dukum);
                       $content = "modul-lv/dasar_hukum/form-ed.html"; 
                    }
                break;
                        
            }
            $this->smarty->assign('type', $type);
            $this->smarty->display($content);
	}
        
        function display_flek($type){
            switch ($type){
                case "select_unit":
                    $id_bidang = $this->input->post('id_bidang');
                    $counter = $this->input->post("counter");
                    $query = "SELECT * FROM tbl_unit_kompetensi WHERE idx_bidang_id = '$id_bidang' ";
                    $unit_kompt = $this->db->query($query)->result_array();
                    $this->smarty->assign('unit', $unit_kompt);
                    $this->smarty->assign('counter', $counter);
                    $this->smarty->assign('id_bidang', $id_bidang);
                    $content = "modul-lv/skema_sertifikasi/select_input.html";
                break;
                case "select_sub":
                    $id_bkl = $this->input->post('id_bkl');
                    $id_bkl = explode('_', $id_bkl);
                    $id = $id_bkl[0];
                    $tipe_bkl = $id_bkl[1];
                    $sub_bkl = $this->madmin->get_data('sub_bkl','result_array', $id, $tipe_bkl);
                    $this->smarty->assign('sub_bkl', $sub_bkl);
                    $content = "modul-lv/skema_sertifikasi/select_sub_bkl.html";
                break;
                case "select_kompt_kunci":
                    $counter = $this->input->post("counter");
                    $query = "SELECT * FROM idx_kompetensi_kunci";
                    $kompt_kunci = $this->db->query($query)->result_array();
                    $this->smarty->assign('kom_kunci', $kompt_kunci);
                    $this->smarty->assign('counter', $counter);
                    $content = "modul-lv/pemetaan-fungsi/select_komp_kunci.html";
                break;
                case "select_level_kk":
                    $id_komp_kunci = $this->input->post('id_kom_kunci');
                    $sql = "SELECT * FROM idx_level_kompetensi_kunci WHERE idx_kompetensi_kunci_id = $id_komp_kunci";
                    $level_kk = $this->db->query($sql)->result_array();
                    $this->smarty->assign('level_kk', $level_kk);
                    $content = "modul-lv/pemetaan-fungsi/select_level_kk.html";
                break;
                case "select_jabatan":
                    $id_skema = $this->input->post('id_skema');
                    $where = '';
                    if ($id_skema == 2 ){
                        $where = "WHERE idx_tipe_kknipdn_id IN('5,6,7,8')";
                    }elseif ($id_skema == 3){
                        $where = "WHERE idx_tipe_kknipdn_id IN('4')";
                    }
                    $sql = "SELECT id, jenjang FROM idx_jenjang_kknipdn $where";
                    $jabatan = $this->db->query($sql)->result_array();
                    $this->smarty->assign('jabatan', $jabatan);
                    $content = "modul-lv/skema_sertifikasi/select_jabatan.html";
                break;
                case "select_dasar_hukum":                    
                    $counter = $this->input->post("counter");
                    $id_bidang = $this->input->post('id_bidang');
                    
                    $query = "SELECT C.id as id, B.idx_bidang_id, C.dasar_hukum FROM `tbl_dasarhukum_perumusan` A
                        LEFT JOIN tbl_perumusan B ON B.id = A.tbl_perumusan_id
                        LEFT JOIN idx_dasar_hukum C ON C.id = A.idx_dasar_hukum_id
                        WHERE B.idx_bidang_id = '$id_bidang';";
                    
                    $dasar_hukum = $this->db->query($query)->result_array();
                    $this->smarty->assign('dasar_hukum', $dasar_hukum);
                    $this->smarty->assign('counter', $counter);
                    $content = "modul-lv/pemetaan-fungsi/select_dasar_hukum.html";
                break;
                    
            }
            $this->smarty->display($content);
        }
        
        function display_fisbone($type, $p=''){
            switch ($type){
                case "data":
                    $this->json_fishbone($p);                    
                    $content = "modul-lv/pemetaan-fungsi/fishbone.html";
                break;
                case "view":
                    $id_bidang = $this->input->post('id_bidang');
                    $this->smarty->assign('id_bidang', $id_bidang);
                    $content = "modul-lv/pemetaan-fungsi/fishbone_view.html";
                break;
                    
            }  
            $this->smarty->display($content);   
        }
        
        function json_fishbone($p){
            $sql = $this->db->query("SELECT IF (LENGTH(nama_bidang) > 30,CONCAT(LEFT(nama_bidang, 30),'...'),nama_bidang) as name FROM idx_bidang WHERE id = $p")->row_array();
            $sql2 = $this->db->query("SELECT id, IF (LENGTH(nama_sub_bidang ) > 60,CONCAT(LEFT(nama_sub_bidang , 60),'...'),nama_sub_bidang ) as name "
                    . "FROM idx_sub_bidang WHERE idx_bidang_id = $p")->result_array();
            $child2 = '';
                
            foreach ($sql2 as $k => $v){ 
                $sql3 = $this->db->query("SELECT IF (LENGTH(nama_sub_subbidang ) > 40,CONCAT(LEFT(nama_sub_subbidang , 40),'...'),nama_sub_subbidang ) as name "
                        . "FROM idx_sub_subbidang WHERE idx_sub_bidang_id = ".$v['id']."")->result_array();
                
                $child2[$k]["name"] = $v["name"];
                $child2[$k]["children"] = $sql3; 
            }
            
            $json_data =array("name" => $sql['name'], "children" => $child2); 
//            echo '<pre>';
//            print_r($sql2);
            
            $json = json_encode($json_data);
//            echo '<pre>';
//            echo $json;
            $file = "__assets/js/data/data.json";
            //using the FILE_APPEND flag to append the content.
            file_put_contents ($file, $json);
        }
        
        function new_fishbone($p = ''){
            $sql = $this->db->query("SELECT "
                    . "IF (LENGTH(nama_bidang) > 30,CONCAT(LEFT(nama_bidang, 30),'...'),nama_bidang) as name, "
                    . "'18' as size, 'Bold' as weight FROM idx_bidang WHERE id = $p")->row_array();
            
            $sql2 = $this->db->query("SELECT id, IF (LENGTH(nama_sub_bidang ) > 60,CONCAT(LEFT(nama_sub_bidang , 60),'...'),nama_sub_bidang ) as name "
                    . "FROM idx_sub_bidang WHERE idx_bidang_id = $p")->result_array();
            $child2 = '';
                
            foreach ($sql2 as $k => $v){ 
                $sql3 = $this->db->query("SELECT IF (LENGTH(nama_sub_subbidang ) > 40,CONCAT(LEFT(nama_sub_subbidang , 40),'...'),nama_sub_subbidang ) as text "
                        . "FROM idx_sub_subbidang WHERE idx_sub_bidang_id = ".$v['id']."")->result_array();
                
                $child2[$k]["text"] = $v["name"];
                $child2[$k]["size"] = "14";
                $child2[$k]["weight"] = "Bold";
                $child2[$k]["causes"] = $sql3; 
            }
            
            $json_data =array("text" => $sql['name'], "size" =>'18', "weight" => 'Bold', "causes" => $child2); 
//            echo '<pre>';
//            print_r($json_data);
            
            $json = json_encode($json_data);
//            echo $json;
            $this->smarty->assign('json', $json);
            $this->smarty->display("modul-lv/fishbone/fishbone.html");
        }
	
	function getdatagrid($type, $p1 = '', $p2 = ''){
		echo $this->madmin->get_data_grid($type, $p1, $p2);
	}
        
        function simpandgnView($type="", $p1=""){
            $post = array();
            foreach($_POST as $k=>$v) $post[$k] = $this->input->post($k);
            echo $this->madmin->simpansavedatabase($type, $post, $p1);
            $html = "";
            switch($type){
               /* case "fungsi_dasar":
                    //$sql = "@last_id := SELECT LAST_INSERT_ID();";
                    $sql = "SELECT id, judul_unit, "
                        . "CASE idx_kelompok_kompetensi_id "
                        . "     WHEN 1 THEN 'Umum' "
                        . "     WHEN 2 THEN 'Inti' "
                        . "     WHEN 3 THEN 'Pilihan' "
                        . "END AS tipe FROM tbl_unit_kompetensi WHERE id = LAST_INSERT_ID()";
                    $data = $this->db->query($sql)->row_array();
                    $html = "<td></td>"
                        . "<td></td>"
                        . "<td>".$data['judul_unit']."</td>"
                        . "<td>".$data['tipe']."</td>"
                        . "<td>"
                        . "     <a class='btn-floating btn-small waves-effect waves-light green' href='.shtml'><i class='mdi-action-search'></i></a>"
                        . "     <a class='btn-floating btn-small waves-effect waves-light orange' href='.shtml'><i class='mdi-content-create'></i></a>"
                        . "     <a class='btn-floating btn-small waves-effect waves-light '><i class='mdi-content-clear'></i></a>	"
                        . "</td>";
                break; */
                case "fungsi_dasar":
                break;
                case "unit_kompetensi":
                case "delete_fd":
                case "delete_skema":
                case "dasar_hukum":
                break;
            }
            $this->smarty->display("string:" . $html);
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