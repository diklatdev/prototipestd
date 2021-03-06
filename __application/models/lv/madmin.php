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
                                . "WHERE idx_sub_bidang_id = $p1 AND idx_tipe_pemerintahan_id = $p2"; 
                        break;
                        case "sub_sub_fungsional":
                               $sql = "SELECT A.* FROM idx_sub_subbidang A "
                                . "WHERE idx_sub_bidang_id = $p1 "; 
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
                        case "unit_kompetensi":
                            $sql ="SELECT A.id as id_fungsi_dasar, A.idx_bidang_id as id_bidang, A.idx_sub_bidang_id as id_sub_bidang, A.idx_sub_subbidang_id as id_sub_subbidang,
                                    A.no_urutan, A.revisi, A.judul_unit, A.deskripsi, A.batasan_variabel, A.panduan_penilaian, A.kode_unit_kompetensi,
                                    B.inisial as ini_bidang, C.inisial as ini_sub_bidang, A.idx_kelompok_kompetensi_id as id_kel
                                    FROM `tbl_unit_kompetensi` A
                                    LEFT JOIN idx_bidang B ON B.id = A.idx_bidang_id
                                    LEFT JOIN idx_sub_bidang C ON C.id = A.idx_sub_bidang_id
                                    WHERE A.id = '$p1';";
                        break;
                        case "list_bkl":
                            $sql ="SELECT CONCAT(id,'_B') as id, nama_bidang as nama FROM idx_bidang 
                                    UNION
                                   SELECT CONCAT(id,'_K') as id, nama_kl as nama FROM idx_kl
                                   ORDER BY nama ASC;";
                        break;
                        case "sub_bkl":
                            if ($p2 == 'B'){
                               $sql = "SELECT id, nama_sub_bidang as nama FROM idx_sub_bidang WHERE idx_bidang_id = $p1";
                            }
                            elseif ($p2 == 'K'){
                                $sql = "SELECT id, nama_dirjen as nama FROm idx_dirjen WHERE idx_kl_id = $p1";
                            }else{
                                $sql = "    SELECT id, nama_sub_bidang as nama FROM idx_sub_bidang"
                                        . " UNION "
                                        . " SELECT id, nama_dirjen as nama FROm idx_dirjen";
                            }
                        break;
                        case "list_pangkat":
                            $sql = "SELECT id, jenjang FROM idx_jenjang_kknipdn";
                        break;
                        case 'skema_sert':
                            $sql = "SELECT A.*, CONCAT (A.idx_bkl_id,'_',A.jenis_bkl) as id_bkl,
                                    CONCAT (A.idx_sub_bkl_id,'_',A.jenis_bkl) as id_sub_bkl
                                    FROM `tbl_skema_sertifikasi` A WHERE A.id = '$p1'";
                        break;
                        case "skesert_unit_kompetensi":
                            $sql = "SELECT A.id, B.judul_unit, B.kode_unit_kompetensi "
                                . "FROM tbl_skesert_unit_kompetensi A "
                                . "LEFT JOIN tbl_unit_kompetensi B ON B.id = A.tbl_unit_kompetensi_id "
                                . "WHERE A.tbl_skema_sertifikasi_id = '$p1'";
                        break;
                        case "skesert_prsayarat_dasar":
                           $sql = "SELECT A.* FROM tbl_skesert_prasyarat_dasar A "
                                . "WHERE tbl_skema_sertifikasi_id = '$p1'";
                        break;    
                        case "kom_kunci_uk":
                            $sql = "SELECT A.*, CONCAT (B.level, '-', B.deskripsi) as level, C.nama as kom_kunci, B.level "
                                . "FROM tbl_kompetensi_kunci_unit_kompetensi A "
                                . "LEFT JOIN idx_level_kompetensi_kunci B ON B.id = A.idx_level_kompetensi_kunci_id "
                                . "LEFT JOIN idx_kompetensi_kunci C ON C.id = B.idx_kompetensi_kunci_id "
                                . "WHERE A.tbl_unit_kompetensi_id = $p1";
                        break;
                        case "dasar_hukum_uk":
                            $sql = "SELECT A.id, C.dasar_hukum FROM tbl_dasar_hukum_unit_kompetensi A
                                    LEFT JOIN tbl_unit_kompetensi B ON B.id = A.tbl_unit_kompetensi_id
                                    LEFT JOIN idx_dasar_hukum C ON C.id = A.idx_dasar_hukum_id
                                    WHERE A.tbl_unit_kompetensi_id = '$p1'";
                        break;
                        case "unit_kompetensi_pemerintahan":
                            $sql ="SELECT A.id as id_ukp, A.idx_kompetensi_pemerintahan_id,
                                    A.judul_unit, A.deskripsi, A.batasan_variabel, A.panduan_penilaian, A.kode_unit_kompetensi_pemerintahan,
                                    B.inisial as ini_bidang
                                    FROM `tbl_unit_kompetensi_pemerintahan` A
                                    LEFT JOIN idx_kompetensi_pemerintahan B ON B.id = A.idx_kompetensi_pemerintahan_id
                                    WHERE A.id = '$p1';";
                        break;   
                        case "kom_kunci_uk_pemerintahan":
                            $sql = "SELECT A.*, CONCAT (B.level, '-', B.deskripsi) as level, C.nama as kom_kunci "
                                . "FROM tbl_kompetensi_kunci_unit_kompetensi_pemerintahan A "
                                . "LEFT JOIN idx_level_kompetensi_kunci B ON B.id = A.idx_level_kompetensi_kunci_id "
                                . "LEFT JOIN idx_kompetensi_kunci C ON C.id = B.idx_kompetensi_kunci_id "
                                . "WHERE A.tbl_unit_kompetensi_pemerintahan_id = $p1";
                        break;
                        case "dasar_hukum_uk_pemerintahan":
                            $sql = "SELECT A.id, C.dasar_hukum 
                                    FROM tbl_dasar_hukum_unit_kompetensi_pemerintahan A
                                    LEFT JOIN tbl_unit_kompetensi_pemerintahan B ON B.id = A.tbl_unit_kompetensi_pemerintahan_id
                                    LEFT JOIN idx_dasar_hukum C ON C.id = A.idx_dasar_hukum_id
                                    WHERE A.tbl_unit_kompetensi_pemerintahan_id = '$p1'";
                        break;
                    
			
		}
		
		if($balikan == "result_array"){
			return $this->db->query($sql)->result_array();
		}elseif($balikan == "row_array"){
			return $this->db->query($sql)->row_array();
		}
		
	}
	
	function get_data_grid($type="", $p1="", $p2="", $p3=""){
		$this->load->library('lib');
		$where = "";
                switch($type){
                    case 'kementrian_grid' :
                        $sql = "SELECT A.id, A.nama_kl, A.inisial
                                FROM idx_kl A";
                    break;
                    case 'bidang_urusan':
                        $sql = 'SELECT A.id, A.nama_bidang, A.inisial '
                            . 'FROM idx_bidang A WHERE idx_kelompok_urusan_id IN (1,2,3)';
                    break;
                    case 'bidang_lain':
                        $sql = "SELECT A.id, A.nama_bidang, A.inisial "
                            . "FROM idx_bidang A WHERE idx_kelompok_urusan_id = '4'";
                    break;
                    
                    case 'bidang_umum':
                        $sql = "SELECT A.id, A.nama_bidang, A.inisial "
                            . "FROM idx_bidang A WHERE idx_kelompok_urusan_id = '5'";
                    break;
                    case 'sub_bidang_umum':
                         $sql = "SELECT A.*, B.nama_bidang FROM idx_sub_bidang A "
                            . "LEFT JOIN idx_bidang B ON B.id = A.idx_bidang_id "
                            . "WHERE A.idx_bidang_id = $p1";
                    break;
                    case 'fungsional_umum':
                         $sql = "SELECT A.* FROM idx_sub_subbidang A "
                            . " WHERE A.idx_sub_bidang_id = $p1";
                    break;

                    case 'bidang_binwas':
                        $sql = "SELECT A.id, A.nama_bidang, A.inisial "
                            . "FROM idx_bidang A WHERE idx_kelompok_urusan_id = '6'";
                    break;
                    case 'sub_bidang_binwas':
                         $sql = "SELECT A.*, B.nama_bidang FROM idx_sub_bidang A "
                            . "LEFT JOIN idx_bidang B ON B.id = A.idx_bidang_id "
                            . "WHERE A.idx_bidang_id = $p1";
                    break;
                    case 'fungsional_binwas':
                         $sql = "SELECT A.* FROM idx_sub_subbidang A "
                            . " WHERE A.idx_sub_bidang_id = $p1";
                    break;
                    
                    case 'bidang_sekwan':
                        $sql = "SELECT A.id, A.nama_bidang, A.inisial "
                            . "FROM idx_bidang A WHERE idx_kelompok_urusan_id = '7'";
                    break;
                    case 'sub_bidang_sekwan':
                         $sql = "SELECT A.*, B.nama_bidang FROM idx_sub_bidang A "
                            . "LEFT JOIN idx_bidang B ON B.id = A.idx_bidang_id "
                            . "WHERE A.idx_bidang_id = $p1";
                    break;
                    case 'fungsional_sekwan':
                         $sql = "SELECT A.* FROM idx_sub_subbidang A "
                            . " WHERE A.idx_sub_bidang_id = $p1";
                    break;

                    case 'bidang_kecamatan':
                        $sql = "SELECT A.id, A.nama_bidang, A.inisial "
                            . "FROM idx_bidang A WHERE idx_kelompok_urusan_id = '8'";
                    break;
                    case 'sub_bidang_kecamatan':
                         $sql = "SELECT A.*, B.nama_bidang FROM idx_sub_bidang A "
                            . "LEFT JOIN idx_bidang B ON B.id = A.idx_bidang_id "
                            . "WHERE A.idx_bidang_id = $p1";
                    break;
                    case 'fungsional_kecamatan':
                         $sql = "SELECT A.* FROM idx_sub_subbidang A "
                            . " WHERE A.idx_sub_bidang_id = $p1";
                    break;
    
                    case 'bidang_kelurahan':
                        $sql = "SELECT A.id, A.nama_bidang, A.inisial "
                            . "FROM idx_bidang A WHERE idx_kelompok_urusan_id = '9'";
                    break;
                    case 'sub_bidang_kelurahan':
                         $sql = "SELECT A.*, B.nama_bidang FROM idx_sub_bidang A "
                            . "LEFT JOIN idx_bidang B ON B.id = A.idx_bidang_id "
                            . "WHERE A.idx_bidang_id = $p1";
                    break;
                    case 'fungsional_kelurahan':
                         $sql = "SELECT A.* FROM idx_sub_subbidang A "
                            . " WHERE A.idx_sub_bidang_id = $p1";
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
                    case 'kompetensi_pemerintahan':
                         $sql = "SELECT * FROM idx_kompetensi_pemerintahan";
                    break;
                    case 'bakat_list':
                         $sql = "SELECT id, nama_bakat FROM idx_bakat";
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
                    case 'sub_bidang_lain':
                         $sql = "SELECT A.*, B.nama_bidang FROM idx_sub_bidang A "
                            . "LEFT JOIN idx_bidang B ON B.id = A.idx_bidang_id "
                            . "WHERE A.idx_bidang_id = $p1";
                    break;
                    case 'fungsional':
                         $sql = "SELECT A.* FROM idx_sub_subbidang A "
                            . " WHERE A.idx_sub_bidang_id = $p1";
                    break;
                    case "pemetaan_fungsi-UK":
                        $sql = 'SELECT A.*, A.id as fishbone, A.id as fungsi_dasar, A.id as unit_kompetensi '
                            . 'FROM idx_bidang A WHERE idx_kelompok_urusan_id IN(1,2,3)';
                    break;
                    case "pemetaan_fungsi-UP":
                        $sql = 'SELECT A.*, A.id as fishbone, A.id as fungsi_dasar, A.id as unit_kompetensi '
                            . 'FROM idx_bidang A WHERE idx_kelompok_urusan_id = 4';
                    break;
                    case "pemetaan_fungsi-UU":
                        $sql = 'SELECT A.*, A.id as fishbone, A.id as fungsi_dasar, A.id as unit_kompetensi '
                            . 'FROM idx_bidang A WHERE idx_kelompok_urusan_id = 5';
                    break;
                    case "pemetaan_fungsi-UB":
                        $sql = 'SELECT A.*, A.id as fishbone, A.id as fungsi_dasar, A.id as unit_kompetensi '
                            . 'FROM idx_bidang A WHERE idx_kelompok_urusan_id = 6';
                    break;
                    case "pemetaan_fungsi-US":
                        $sql = 'SELECT A.*, A.id as fishbone, A.id as fungsi_dasar, A.id as unit_kompetensi '
                            . 'FROM idx_bidang A WHERE idx_kelompok_urusan_id = 7';
                    break;
                    case "pemetaan_fungsi-UC":
                        $sql = 'SELECT A.*, A.id as fishbone, A.id as fungsi_dasar, A.id as unit_kompetensi '
                            . 'FROM idx_bidang A WHERE idx_kelompok_urusan_id = 8';
                    break;
                    case "pemetaan_fungsi-UH":
                        $sql = 'SELECT A.*, A.id as fishbone, A.id as fungsi_dasar, A.id as unit_kompetensi '
                            . 'FROM idx_bidang A WHERE idx_kelompok_urusan_id = 9';
                    break;
                    case "pemetaan_fungsi-UL":
                        $sql = 'SELECT A.*, A.id as fishbone, A.id as fungsi_dasar, A.id as unit_kompetensi '
                            . 'FROM idx_bidang A WHERE idx_kelompok_urusan_id IN(4,5,6)';
                    break;
                    case "pemetaan_fungsi-JFU":
                        $sql = 'SELECT A.*, A.id as fishbone, A.id as fungsi_dasar, A.id as unit_kompetensi '
                            . 'FROM idx_bidang A WHERE idx_kelompok_urusan_id = 7';
                    break;
                    case "unit_kompetensi":
                        $sql = "SELECT A.* FROM tbl_unit_kompetensi A WHERE idx_bidang_id = $p1 "
                            . "ORDER BY (CASE WHEN no_urutan IS NULL THEN 1000 ELSE no_urutan END)";
                    break;
                    case "skema_sertifikasi":
                        $sql = "SELECT A.id, IF (A.jenis_bkl = 'b', B.nama_bidang, C.nama_kl) as nama_bkl, 
                                IF (A.jenis_bkl = 'b',D.nama_sub_bidang, '') as nama_sub_bkl, 
                                CASE 
                                        WHEN A.idx_skema_id = '1' THEN 'KLASTER'
                                        WHEN A.idx_skema_id = '2' THEN 'JABATAN'
                                        WHEN A.idx_skema_id = '3' THEN 'KKNI'
                                END AS skema, A.pekerjaan
                                FROM `tbl_skema_sertifikasi` A
                                LEFT JOIN idx_bidang B ON A.idx_bkl_id = B.id
                                LEFT JOIN idx_kl C ON A.idx_bkl_id = C.id
                                LEFT JOIN idx_sub_bidang D ON D.id = A.idx_sub_bkl_id";
                    break;
                    case "dasar_hukum":
                        $sql = "SELECT * FROM idx_dasar_hukum";
                    break;
                    case "unit_kompetensi_pemerintahan":
                        $sql = "SELECT A.* FROM tbl_unit_kompetensi_pemerintahan A "
                            . "WHERE idx_kompetensi_pemerintahan_id = $p1 "
                            . "ORDER BY id";
                    break;
                    
                    
                    
                    
		}
		
		return $this->lib->jsondata($sql, $type);
	}
	
	function simpansavedatabase($type="", $post="", $p1="", $p2="", $p3=""){
		$this->load->library('lib');
		$this->db->trans_begin();
                
                switch ($type){
                    case "fungsi_dasar":
                            $post_bnr = array();
                            $id_bidang = $post['id_bidang'];
                            $sub_bidang = $this->db->query("SELECT id FROM idx_sub_bidang "
                                    . "WHERE idx_bidang_id = '$id_bidang'")->result_array();
                            
                            foreach ($sub_bidang as $v){
                                $sub2_bidang = $this->db->query("SELECT id FROM idx_sub_subbidang "
                                        . "WHERE idx_sub_bidang_id = '".$v['id']."'")->result_array();
                                foreach ($sub2_bidang as $n){
                                    
                                    if (isset($post['fd_'.$v['id'].'_'.$n['id']])){
                                        $count_post = count($post['fd_'.$v['id'].'_'.$n['id']]) -1;

                                        for($i = 0; $i <= $count_post;$i++){
                                            
                                            $post_bnr['judul_unit'] = $post['fd_'.$v['id'].'_'.$n['id']][$i];
                                            $post_bnr['idx_kelompok_kompetensi_id'] = $post['kel_'.$v['id'].'_'.$n['id']][$i];
                                            $post_bnr['idx_sub_bidang_id'] = $v['id'];
                                            $post_bnr['idx_sub_subbidang_id'] = $n['id'];
                                            $post_bnr['idx_bidang_id'] = $id_bidang;
                                            
                                            //print_r($post_bnr);
                                            if ($p1 == 'sv'){				
                                                $insert_reg = $this->db->insert("tbl_unit_kompetensi", $post_bnr);
                                            }
                                        }
                                        
                                    }
                                    
                                }
                                
                            }
                            /*
                            $post_bnr['judul_unit'] = $post['fungsi_dasar'];
                            $post_bnr['idx_kelompok_kompetensi_id'] = $post['kel_kom'];
                            $post_bnr['idx_sub_bidang_id'] = $post['id_sub'];
                            $post_bnr['idx_sub_subbidang_id'] = $post['id_sub2'];
                            $post_bnr['idx_bidang_id'] = $post['id_bidang'];
                            
                            $sql = $this->db->query("SELECT MAX(no_urutan) as no_urut FROM tbl_unit_kompetensi WHERE idx_bidang_id = '".$post['id_bidang']."'")->row_array();
                            $no_urut = '';
                            if (!$sql['no_urut']){$no_urut = '001';}
                            else{
                                $nol = '';
                                $jum_no = strlen($sql['no_urut']+1);
                                if($jum_no == 1){$nol = '00';}elseif($jum_no == 2){$nol = '0';}else{$nol='';} 
                                $no_urut = $nol.$sql['no_urut']+1;
                                
                            }
                            $post_bnr['no_urutan'] = $no_urut;

                            if ($p1 == 'sv'){				
                                    $insert_reg = $this->db->insert("tbl_unit_kompetensi", $post_bnr);
                            }elseif ($p1 == 'up'){
                                    $insert_reg = $this->db->where("id", $post['kode']);
                                    $insert_reg = $this->db->update("idx_tuk", $post_bnr);
                            }*/
                    break;
                    case "unit_kompetensi":
                        $id_fungsi_dasar = $post['id_fungsi_dasar'];
                        $ini_bidang = $post['ini_bidang'];
                        $ini_sub_bidang = $post['ini_sub_bidang'];
                        $kode_kelompok = '0'.$post['kel_kom'];
                                
                        $post_bnr = array();
                        $post_bnr['idx_kelompok_kompetensi_id'] = $post['kel_kom'];
                        $post_bnr['no_urutan'] = $post['nomor_urut'];
                        $post_bnr['revisi'] = $post['revisi'];
                        $post_bnr['judul_unit'] = $post['nama_bidang'];
                        $post_bnr['deskripsi'] = $post['deskripsi'];
                        $post_bnr['batasan_variabel'] = $post['batasan_var'];
                        $post_bnr['panduan_penilaian'] = $post['panduan_penilaian']; 
                        $post_bnr['kode_unit_kompetensi'] = $ini_bidang.".".$ini_sub_bidang.".".$kode_kelompok.".".$post['nomor_urut'].".".$post['revisi'];
          
                        $insert_reg = $this->db->where("id", $id_fungsi_dasar);
                        $insert_reg = $this->db->update("tbl_unit_kompetensi", $post_bnr);
                        
                        if (isset($post['elemen'])){
                            $count_el = count($post['elemen']) - 1;
                            $post_el = array();
                            for($i = 0; $i <= $count_el; $i++){
                                $post_el['nama'] = $post['elemen'][$i];
                                $post_el['tbl_unit_kompetensi_id']=$id_fungsi_dasar;
                                $insert_el = $this->db->insert("tbl_elemen_unit_kompetensi", $post_el);
                            }
                        }
                        
                        $elemen_sql = $this->db->query("SELECT id, nama FROM tbl_elemen_unit_kompetensi "
                                . "WHERE tbl_unit_kompetensi_id = '$id_fungsi_dasar'");
                        $elemen_data = $elemen_sql->result_array();
                        $elemen_num = $elemen_sql->num_rows();
                        
                        foreach($elemen_data as $k => $v){
                            if (isset($post['unjuk_'.$v['id']])){
                                
                                $count_kuk = count($post['unjuk_'.$v['id']]) -1;
                                //print_r ($post['unjuk_'.$v['id']]);
                                
                                $post_kuk = array();
                                for($i = 0; $i <= $count_kuk; $i++){
                                    
                                    $post_kuk['nama'] = $post['unjuk_'.$v['id']][$i];
                                    $post_kuk['tbl_elemen_unit_kompetensi_id'] = $v['id'];
                                    //print_r($post_kuk);
                                    $insert_kuk = $this->db->insert("tbl_kuk_elemen_unit_kompetensi", $post_kuk);
                                }
                                
                            }
                        }
                        
                        foreach ($elemen_data as $k => $v){
                            if (isset($post['editelemen_'.$v['id']])){
                                $count_ed_el = count($post['editelemen_'.$v['id']]) -1 ;
                                for($i = 0;$i <= $count_ed_el; $i++){
                                    $nama_elem = $post['editelemen_'.$v['id']][$i];
                                    
                                    
                                    $post_ed_el = array();
                                    $post_ed_el['nama'] = $nama_elem;
                                    
                                    $edit_elem = $this->db->where('id', $v['id']);
                                    $edit_elem = $this->db->update('tbl_elemen_unit_kompetensi', $post_ed_el);
                                    /*
                                    $kuk_que = "SELECT * FROM tbl_kuk_elemen_unit_kompetensi "
                                            . "WHERE tbl_elemen_unit_kompetensi_id = '".$v['id']."'";
                                    $kuk_que = $this->db->query($kuk_que)->result_array();
                                    
                                    foreach($kuk_que as $kv){
                                        if (isset($post['editkuk_'.$kv['id']])){
                                            $count_ed_kuk = count($post['editkuk_'.$kv['id']])-1;
                                            for($j=0;$j<=$count_ed_kuk;$j++){
                                                $nama_kuk = $post['editkuk_'.$kv['id']][$j];
                                                $kuks = explode('_', $nama_kuk);
                                                $id_kuk = $kuks[1];
                                                
                                                $post_ed_kuk = array();
                                                $post_ed_kuk['nama'] = $nama_kuk;
                                                
                                                $edit_kuk = $this->db->where('id', $id_kuk);
                                                $edit_kuk = $this->db->update('tbl_kuk_elemen_unit_kompetensi', $post_ed_kuk);
                                            }
                                        }
                                    }*/
                                }
                            }else{
                                $kuk_que = "SELECT * FROM tbl_kuk_elemen_unit_kompetensi "
                                            . "WHERE tbl_elemen_unit_kompetensi_id = '".$v['id']."'";
                                $kuk_que = $this->db->query($kuk_que)->result_array();

                                foreach($kuk_que as $kv){
                                    if (isset($post['editkuk_'.$kv['id']])){
                                        $count_ed_kuk = count($post['editkuk_'.$kv['id']])-1;
                                        for($j=0;$j<=$count_ed_kuk;$j++){
                                            $nama_kuk = $post['editkuk_'.$kv['id']][$j];

                                            $post_ed_kuk = array();
                                            $post_ed_kuk['nama'] = $nama_kuk;

                                            $edit_kuk = $this->db->where('id', $kv['id']);
                                            $edit_kuk = $this->db->update('tbl_kuk_elemen_unit_kompetensi', $post_ed_kuk);
                                        }
                                    }
                                }
                                
                            }
                        }
                        
                        if (isset($post['del_kuk'])){
                          $count_del_kuk = count($post['del_kuk']) - 1;
                          
                          for($i = 0; $i <= $count_del_kuk; $i++){
                              $delete_kuk = $this->db->where('id', $post['del_kuk'][$i]);
                              $delete_kuk = $this->db->delete('tbl_kuk_elemen_unit_kompetensi');
                          }
                        }
                        
                        if (isset($post['del_elemen'])){
                          $count_del_elem = count($post['del_elemen']) - 1;
                          
                          for($i = 0; $i <= $count_del_elem; $i++){
                              $delete_elem = $this->db->where('id', $post['del_elemen'][$i]);
                              $delete_elem = $this->db->delete('tbl_elemen_unit_kompetensi');
                              
                              $sql_kuk_el = $this->db->query("SELECT * FROM tbl_kuk_elemen_unit_kompetensi "
                                      . "WHERE tbl_elemen_unit_kompetensi_id = '".$post['del_elemen'][$i]."'")->result_array();
                              
                              foreach($sql_kuk_el as $val_kuk){
                                  $del_kuk_el = $this->db->where('id', $val_kuk['id']);
                                  $del_kuk_el = $this->db->delete('tbl_kuk_elemen_unit_kompetensi');
                              }
                          }
                        }
                        
                        if (isset($post['level_kom_kunci'])){
                            $count_level_kk = count($post['level_kom_kunci'])-1;
                            for($i= 0; $i <= $count_level_kk; $i++){
                                $post_lkk = array();
                                $post_lkk['idx_level_kompetensi_kunci_id'] = $post['level_kom_kunci'][$i];
                                $post_lkk['tbl_unit_kompetensi_id'] = $id_fungsi_dasar;
                                
                                $insert_lkk = $this->db->insert('tbl_kompetensi_kunci_unit_kompetensi', $post_lkk);
                            }
                        }
                        
                        if (isset($post['del_lev_kk'])){
                            $count_del_lkk = count($post['del_lev_kk']) - 1;
                            $post_del_kll = array();
                            for($i = 0;$i<=$count_del_lkk;$i++){
                                $delete_lkk = $this->db->where('id', $post['del_lev_kk'][$i]);
                                $delete_lkk = $this->db->delete('tbl_kompetensi_kunci_unit_kompetensi');
                            }
                        }
                        
                        if (isset($post['dasar_hukum'])){
                            $count_das_hukum = count($post['dasar_hukum']) - 1;
                            $post_dHukum = array();
                            for ($i = 0; $i <= $count_das_hukum; $i++){
                                $post_dHukum['idx_dasar_hukum_id'] = $post['dasar_hukum'][$i];
                                $post_dHukum['tbl_unit_kompetensi_id'] = $id_fungsi_dasar;
                                
                                $insert_dasar_hukum = $this->db->insert('tbl_dasar_hukum_unit_kompetensi', $post_dHukum);
                            }
                        }
                        
                        if (isset($post['del_dasar_hukum'])){
                            $count_del_dh = count($post['del_dasar_hukum']) - 1;
                            $post_del_dh = array();
                            for($i = 0;$i<=$count_del_dh;$i++){
                                $delete_dh = $this->db->where('id', $post['del_dasar_hukum'][$i]);
                                $delete_dh = $this->db->delete('tbl_dasar_hukum_unit_kompetensi');
                            }
                        }
                        
                    break;
                    
                    case "skema_sertifikasi":
                        if ($p1 == 'sv'){
                            $post_bnr = array();

                            $bkl = explode('_',$post['bkl']);
                            $id_bkl = $bkl[0];
                            $jenis_bkl = $bkl[1];

                            $post_bnr['jenis_bkl'] = $jenis_bkl;
                            $post_bnr['idx_bkl_id'] = $id_bkl;
                            $post_bnr['idx_sub_bkl_id'] = $post['sub_bkl'];
                            $post_bnr['pekerjaan'] = $post['pekerjaan'];
                            $post_bnr["idx_skema_id"] = $post['skema_sert'];
                            $post_bnr['idx_jenjang_kknipdn_id'] = $post['pangkat_jabatan'];                        

                            $insert_skema = $this->db->insert("tbl_skema_sertifikasi", $post_bnr);

                            $last_id = $this->db->query("SELECT LAST_INSERT_ID() as last_id")->row_array();
                            $last_skema_id = $last_id['last_id'];

                            if (isset($post['unit_id'])){
                                $count_unit = count($post['unit_id']) - 1;
                                $post_unit = array();

                                for($i = 0;$i <= $count_unit; $i++){
                                    $post_unit['tbl_skema_sertifikasi_id'] =  $last_skema_id ;
                                    $post_unit['tbl_unit_kompetensi_id']= $post['unit_id'][$i];
                                    if ($p1 == 'sv'){
                                        $insert_unit = $this->db->insert("tbl_skesert_unit_kompetensi", $post_unit);
                                    }elseif($p1 == 'up'){

                                    }

                                }
                            }

                            if (isset($post['dasar']) && isset($post['bukti'])){
                                $count_dasar = count($post['dasar']) - 1;

                                $post_dasar = array();

                                for($i = 0;$i <= $count_dasar; $i++){
                                    $post_dasar['tbl_skema_sertifikasi_id'] =  $last_skema_id ;
                                    $post_dasar['prasyarat_dasar']= $post['dasar'][$i];
                                    $post_dasar['bukti']= $post['bukti'][$i];
                                    $insert_unit = $this->db->insert("tbl_skesert_prasyarat_dasar", $post_dasar);
                                }
                            }
                        }elseif ($p1 == 'up'){
                            $post_bnr = array();
                            
                            $id_skema_sert = $post['id_skema_sert'];
                            
                            $bkl = explode('_',$post['bkl']);
                            $id_bkl = $bkl[0];
                            $jenis_bkl = $bkl[1];

                            $post_bnr['jenis_bkl'] = $jenis_bkl;
                            $post_bnr['idx_bkl_id'] = $id_bkl;
                            $post_bnr['idx_sub_bkl_id'] = $post['sub_bkl'];
                            $post_bnr['pekerjaan'] = $post['pekerjaan'];
                            $post_bnr["idx_skema_id"] = $post['skema_sert'];
                            $post_bnr['idx_jenjang_kknipdn_id'] = $post['pangkat_jabatan'];                        
                            
                            $update_skema = $this->db->where("id", $id_skema_sert);
                            $update_skema = $this->db->update("tbl_skema_sertifikasi", $post_bnr);

                            if (isset($post['unit_id'])){
                                $count_unit = count($post['unit_id']) - 1;
                                $post_unit = array();

                                for($i = 0;$i <= $count_unit; $i++){
                                    $post_unit['tbl_skema_sertifikasi_id'] =  $id_skema_sert ;
                                    $post_unit['tbl_unit_kompetensi_id']= $post['unit_id'][$i];
                                    
                                    $insert_unit = $this->db->insert("tbl_skesert_unit_kompetensi", $post_unit);
                                    

                                }
                            }

                            if (isset($post['dasar']) && isset($post['bukti'])){
                                $count_dasar = count($post['dasar']) - 1;

                                $post_dasar = array();

                                for($i = 0;$i <= $count_dasar; $i++){
                                    $post_dasar['tbl_skema_sertifikasi_id'] =  $id_skema_sert ;
                                    $post_dasar['prasyarat_dasar']= $post['dasar'][$i];
                                    $post_dasar['bukti']= $post['bukti'][$i];
                                    $insert_unit = $this->db->insert("tbl_skesert_prasyarat_dasar", $post_dasar);
                                }
                            }
                            
                            if (isset($post['del_unit_id'])){
                                $count_unit_del = count($post['del_unit_id']) -1;
                                $post_del_unit = array();
                                
                                for($i = 0;$i <= $count_unit_del; $i++){
                                    $delete_unit = $this->db->where('id',$post['del_unit_id'][$i]);
                                    $delete_unit = $this->db->delete('tbl_skesert_unit_kompetensi');
                                }
                            }
                            
                            if (isset($post['del_dasar_id'])){
                                $count_dasar_del = count($post['del_dasar_id']) - 1;
                                $post_del_dasar = array();
                                
                                for($i = 0;$i <= $count_dasar_del; $i++){
                                    $delete_dasar = $this->db->where('id',$post['del_dasar_id'][$i]);
                                    $delete_dasar = $this->db->delete('tbl_skesert_prasyarat_dasar');
                                }
                            }
                        }
                        
                    break;
                    case "delete_fd":
                        $delete_fd = $this->db->where('id',$post['id_fd']);
                        $delete_fd = $this->db->delete('tbl_unit_kompetensi');
                    break;
                    case "delete_skema":
                        $delete_skema = $this->db->where('id', $post['id_skema']);
                        $delete_skema = $this->db->delete('tbl_skema_sertifikasi');
                    break;
                    case "dasar_hukum":
                        $post_data = array();
                        if ($p1 == 'sv'){
                            $post_data['dasar_hukum'] = $post['dasar_hukum'];
                            $insert_db = $this->db->insert("idx_dasar_hukum", $post_data);
                        }elseif($p1 == 'up'){
                            $post_data['dasar_hukum'] = $post['dasar_hukum'];
                            $update_db = $this->db->where('id', $post['id']);
                            $update_db = $this->db->update('idx_dasar_hukum', $post_data);
                        }elseif($p1 == 'del'){
                            $update_db = $this->db->where('id', $post['id_dasar_hukum']);
                            $update_db = $this->db->delete('idx_dasar_hukum');                            
                        }
					break;
                    case "bidang":
						$post_data = array();
						$post_data['nama_bidang'] = $post['nama_bidang'];
						$post_data['inisial'] = $post['inisial'];
						$this->db->where('id', $post['id']);
                        $this->db->update('idx_bidang', $post_data);
                    break;
					case "sub_bidang":
						$post_data = array();
						$post_data['nama_sub_bidang'] = $post['nama_sub_bidang'];
						$post_data['inisial'] = $post['inisial'];
						$this->db->where('id', $post['id']);
                        $this->db->update('idx_sub_bidang', $post_data);
                    break;     
                                   
                    case "bidang_lain":
						$post_data = array();
						$post_data['nama_bidang'] = $post['nama_bidang'];
						$post_data['inisial'] = $post['inisial'];
						$post_data['idx_kelompok_urusan_id'] = $post['idx_kelompok_urusan_id'];
						
						if($post['editstatus'] == 'add'){
							$this->db->insert("idx_bidang", $post_data);
						}elseif($post['editstatus'] == 'edit'){
							$update_db = $this->db->where('id', $post['id']);
                            $update_db = $this->db->update('idx_bidang', $post_data);
						}
                    break;
                    case "submit_subbidang_lain":
						$post_data = array();
						$post_data['idx_bidang_id'] = $post['idx_bidang_id'];
						$post_data['nama_sub_bidang'] = $post['nama_sub_bidang'];
						$post_data['inisial'] = $post['inisial'];
						
						if($post['editstatus'] == 'add'){
							$this->db->insert("idx_sub_bidang", $post_data);
						}elseif($post['editstatus'] == 'edit'){
							$update_db = $this->db->where('id', $post['id']);
                            $update_db = $this->db->update('idx_sub_bidang', $post_data);
						}
                    break;
                    case "submit_sub_subbidang_lain":
						$post_data = array();
						$post_data['idx_sub_bidang_id'] = $post['idx_sub_bidang_id'];
						$post_data['nama_sub_subbidang'] = $post['nama_sub_subbidang'];
						$post_data['inisial'] = $post['inisial'];
						
						if($post['editstatus'] == 'add'){
							$this->db->insert("idx_sub_subbidang", $post_data);
						}elseif($post['editstatus'] == 'edit'){
							$update_db = $this->db->where('id', $post['id']);
                            $update_db = $this->db->update('idx_sub_subbidang', $post_data);
						}
                    break;
                    
                    case "bidang_umum":
						$post_data = array();
						$post_data['nama_bidang'] = $post['nama_bidang'];
						$post_data['inisial'] = $post['inisial'];
						$post_data['idx_kelompok_urusan_id'] = '5';//$post['idx_kelompok_urusan_id'];
						
						if($post['editstatus'] == 'add'){
							$this->db->insert("idx_bidang", $post_data);
						}elseif($post['editstatus'] == 'edit'){
							$update_db = $this->db->where('id', $post['id']);
                            $update_db = $this->db->update('idx_bidang', $post_data);
						}
                    break;
                    case "submit_subbidang_umum":
						$post_data = array();
						$post_data['idx_bidang_id'] = $post['idx_bidang_id'];
						$post_data['nama_sub_bidang'] = $post['nama_sub_bidang'];
						$post_data['inisial'] = $post['inisial'];
						
						if($post['editstatus'] == 'add'){
							$this->db->insert("idx_sub_bidang", $post_data);
						}elseif($post['editstatus'] == 'edit'){
							$update_db = $this->db->where('id', $post['id']);
                            $update_db = $this->db->update('idx_sub_bidang', $post_data);
						}
                    break;
                    case "submit_sub_subbidang_umum":
						$post_data = array();
						$post_data['idx_sub_bidang_id'] = $post['idx_sub_bidang_id'];
						$post_data['nama_sub_subbidang'] = $post['nama_sub_subbidang'];
						$post_data['inisial'] = $post['inisial'];
						
						if($post['editstatus'] == 'add'){
							$this->db->insert("idx_sub_subbidang", $post_data);
						}elseif($post['editstatus'] == 'edit'){
							$update_db = $this->db->where('id', $post['id']);
                            $update_db = $this->db->update('idx_sub_subbidang', $post_data);
						}
                    break;
                    case "submit_sub_subbidang_umum":
						$post_data = array();
						$post_data['idx_sub_bidang_id'] = $post['idx_sub_bidang_id'];
						$post_data['nama_sub_subbidang'] = $post['nama_sub_subbidang'];
						$post_data['inisial'] = $post['inisial'];
						
						if($post['editstatus'] == 'add'){
							$this->db->insert("idx_sub_subbidang", $post_data);
						}elseif($post['editstatus'] == 'edit'){
							$update_db = $this->db->where('id', $post['id']);
                            $update_db = $this->db->update('idx_sub_subbidang', $post_data);
						}
                    break;
                    
                    case "bidang_binwas":
						$post_data = array();
						$post_data['nama_bidang'] = $post['nama_bidang'];
						$post_data['inisial'] = $post['inisial'];
						$post_data['idx_kelompok_urusan_id'] = '6';//$post['idx_kelompok_urusan_id'];
						
						if($post['editstatus'] == 'add'){
							$this->db->insert("idx_bidang", $post_data);
						}elseif($post['editstatus'] == 'edit'){
							$update_db = $this->db->where('id', $post['id']);
                            $update_db = $this->db->update('idx_bidang', $post_data);
						}
                    break;
                    case "submit_subbidang_binwas":
						$post_data = array();
						$post_data['idx_bidang_id'] = $post['idx_bidang_id'];
						$post_data['nama_sub_bidang'] = $post['nama_sub_bidang'];
						$post_data['inisial'] = $post['inisial'];
						
						if($post['editstatus'] == 'add'){
							$this->db->insert("idx_sub_bidang", $post_data);
						}elseif($post['editstatus'] == 'edit'){
							$update_db = $this->db->where('id', $post['id']);
                            $update_db = $this->db->update('idx_sub_bidang', $post_data);
						}
                    break;
                    case "submit_sub_subbidang_binwas":
						$post_data = array();
						$post_data['idx_sub_bidang_id'] = $post['idx_sub_bidang_id'];
						$post_data['nama_sub_subbidang'] = $post['nama_sub_subbidang'];
						$post_data['inisial'] = $post['inisial'];
						
						if($post['editstatus'] == 'add'){
							$this->db->insert("idx_sub_subbidang", $post_data);
						}elseif($post['editstatus'] == 'edit'){
							$update_db = $this->db->where('id', $post['id']);
                            $update_db = $this->db->update('idx_sub_subbidang', $post_data);
						}
                    break;
                    case "submit_sub_subbidang_binwas":
						$post_data = array();
						$post_data['idx_sub_bidang_id'] = $post['idx_sub_bidang_id'];
						$post_data['nama_sub_subbidang'] = $post['nama_sub_subbidang'];
						$post_data['inisial'] = $post['inisial'];
						
						if($post['editstatus'] == 'add'){
							$this->db->insert("idx_sub_subbidang", $post_data);
						}elseif($post['editstatus'] == 'edit'){
							$update_db = $this->db->where('id', $post['id']);
                            $update_db = $this->db->update('idx_sub_subbidang', $post_data);
						}
                    break;
                    
                    case "bidang_sekwan":
						$post_data = array();
						$post_data['nama_bidang'] = $post['nama_bidang'];
						$post_data['inisial'] = $post['inisial'];
						$post_data['idx_kelompok_urusan_id'] = '7';//$post['idx_kelompok_urusan_id'];
						
						if($post['editstatus'] == 'add'){
							$this->db->insert("idx_bidang", $post_data);
						}elseif($post['editstatus'] == 'edit'){
							$update_db = $this->db->where('id', $post['id']);
                            $update_db = $this->db->update('idx_bidang', $post_data);
						}
                    break;
                    case "submit_subbidang_sekwan":
						$post_data = array();
						$post_data['idx_bidang_id'] = $post['idx_bidang_id'];
						$post_data['nama_sub_bidang'] = $post['nama_sub_bidang'];
						$post_data['inisial'] = $post['inisial'];
						
						if($post['editstatus'] == 'add'){
							$this->db->insert("idx_sub_bidang", $post_data);
						}elseif($post['editstatus'] == 'edit'){
							$update_db = $this->db->where('id', $post['id']);
                            $update_db = $this->db->update('idx_sub_bidang', $post_data);
						}
                    break;
                    case "submit_sub_subbidang_sekwan":
						$post_data = array();
						$post_data['idx_sub_bidang_id'] = $post['idx_sub_bidang_id'];
						$post_data['nama_sub_subbidang'] = $post['nama_sub_subbidang'];
						$post_data['inisial'] = $post['inisial'];
						
						if($post['editstatus'] == 'add'){
							$this->db->insert("idx_sub_subbidang", $post_data);
						}elseif($post['editstatus'] == 'edit'){
							$update_db = $this->db->where('id', $post['id']);
                            $update_db = $this->db->update('idx_sub_subbidang', $post_data);
						}
                    break;
                    case "submit_sub_subbidang_sekwan":
						$post_data = array();
						$post_data['idx_sub_bidang_id'] = $post['idx_sub_bidang_id'];
						$post_data['nama_sub_subbidang'] = $post['nama_sub_subbidang'];
						$post_data['inisial'] = $post['inisial'];
						
						if($post['editstatus'] == 'add'){
							$this->db->insert("idx_sub_subbidang", $post_data);
						}elseif($post['editstatus'] == 'edit'){
							$update_db = $this->db->where('id', $post['id']);
                            $update_db = $this->db->update('idx_sub_subbidang', $post_data);
						}
                    break;
                    
                    case "bidang_kecamatan":
						$post_data = array();
						$post_data['nama_bidang'] = $post['nama_bidang'];
						$post_data['inisial'] = $post['inisial'];
						$post_data['idx_kelompok_urusan_id'] = '8';//$post['idx_kelompok_urusan_id'];
						
						if($post['editstatus'] == 'add'){
							$this->db->insert("idx_bidang", $post_data);
						}elseif($post['editstatus'] == 'edit'){
							$update_db = $this->db->where('id', $post['id']);
                            $update_db = $this->db->update('idx_bidang', $post_data);
						}
                    break;
                    case "submit_subbidang_kecamatan":
						$post_data = array();
						$post_data['idx_bidang_id'] = $post['idx_bidang_id'];
						$post_data['nama_sub_bidang'] = $post['nama_sub_bidang'];
						$post_data['inisial'] = $post['inisial'];
						
						if($post['editstatus'] == 'add'){
							$this->db->insert("idx_sub_bidang", $post_data);
						}elseif($post['editstatus'] == 'edit'){
							$update_db = $this->db->where('id', $post['id']);
                            $update_db = $this->db->update('idx_sub_bidang', $post_data);
						}
                    break;
                    case "submit_sub_subbidang_kecamatan":
						$post_data = array();
						$post_data['idx_sub_bidang_id'] = $post['idx_sub_bidang_id'];
						$post_data['nama_sub_subbidang'] = $post['nama_sub_subbidang'];
						$post_data['inisial'] = $post['inisial'];
						
						if($post['editstatus'] == 'add'){
							$this->db->insert("idx_sub_subbidang", $post_data);
						}elseif($post['editstatus'] == 'edit'){
							$update_db = $this->db->where('id', $post['id']);
                            $update_db = $this->db->update('idx_sub_subbidang', $post_data);
						}
                    break;
                    case "submit_sub_subbidang_kecamatan":
						$post_data = array();
						$post_data['idx_sub_bidang_id'] = $post['idx_sub_bidang_id'];
						$post_data['nama_sub_subbidang'] = $post['nama_sub_subbidang'];
						$post_data['inisial'] = $post['inisial'];
						
						if($post['editstatus'] == 'add'){
							$this->db->insert("idx_sub_subbidang", $post_data);
						}elseif($post['editstatus'] == 'edit'){
							$update_db = $this->db->where('id', $post['id']);
                            $update_db = $this->db->update('idx_sub_subbidang', $post_data);
						}
                    break;

                    case "bidang_kelurahan":
						$post_data = array();
						$post_data['nama_bidang'] = $post['nama_bidang'];
						$post_data['inisial'] = $post['inisial'];
						$post_data['idx_kelompok_urusan_id'] = '9';//$post['idx_kelompok_urusan_id'];
						
						if($post['editstatus'] == 'add'){
							$this->db->insert("idx_bidang", $post_data);
						}elseif($post['editstatus'] == 'edit'){
							$update_db = $this->db->where('id', $post['id']);
                            $update_db = $this->db->update('idx_bidang', $post_data);
						}
                    break;
                    case "submit_subbidang_kelurahan":
						$post_data = array();
						$post_data['idx_bidang_id'] = $post['idx_bidang_id'];
						$post_data['nama_sub_bidang'] = $post['nama_sub_bidang'];
						$post_data['inisial'] = $post['inisial'];
						
						if($post['editstatus'] == 'add'){
							$this->db->insert("idx_sub_bidang", $post_data);
						}elseif($post['editstatus'] == 'edit'){
							$update_db = $this->db->where('id', $post['id']);
                            $update_db = $this->db->update('idx_sub_bidang', $post_data);
						}
                    break;
                    case "submit_sub_subbidang_kelurahan":
						$post_data = array();
						$post_data['idx_sub_bidang_id'] = $post['idx_sub_bidang_id'];
						$post_data['nama_sub_subbidang'] = $post['nama_sub_subbidang'];
						$post_data['inisial'] = $post['inisial'];
						
						if($post['editstatus'] == 'add'){
							$this->db->insert("idx_sub_subbidang", $post_data);
						}elseif($post['editstatus'] == 'edit'){
							$update_db = $this->db->where('id', $post['id']);
                            $update_db = $this->db->update('idx_sub_subbidang', $post_data);
						}
                    break;
                    case "submit_sub_subbidang_kelurahan":
						$post_data = array();
						$post_data['idx_sub_bidang_id'] = $post['idx_sub_bidang_id'];
						$post_data['nama_sub_subbidang'] = $post['nama_sub_subbidang'];
						$post_data['inisial'] = $post['inisial'];
						
						if($post['editstatus'] == 'add'){
							$this->db->insert("idx_sub_subbidang", $post_data);
						}elseif($post['editstatus'] == 'edit'){
							$update_db = $this->db->where('id', $post['id']);
                            $update_db = $this->db->update('idx_sub_subbidang', $post_data);
						}
                    break;
                    case "unit_kompetensi_pemerintahan":
                        $id_ukp = '';
                                
                        $post_bnr = array();
                        $post_bnr['judul_unit'] = $post['nama_bidang'];
                        $post_bnr['deskripsi'] = $post['deskripsi'];
                        $post_bnr['batasan_variabel'] = $post['batasan_var'];
                        $post_bnr['panduan_penilaian'] = $post['panduan_penilaian']; 
                        $post_bnr['kode_unit_kompetensi_pemerintahan'] = $post['kode_unit'];
                        $post_bnr['idx_kompetensi_pemerintahan_id'] = $post['id_kompetensi_pemerintahan'];
                        
                        if ($p1 == 'update'){
                            $id_ukp = $post['id_ukp'];
                            $insert_reg = $this->db->where("id", $id_ukp);
                            $insert_reg = $this->db->update("tbl_unit_kompetensi_pemerintahan", $post_bnr);                            
                        }elseif ($p1 == 'submit'){
                            $insert_reg = $this->db->insert("tbl_unit_kompetensi_pemerintahan", $post_bnr);
                            $id_ukp = $this->db->query('SELECT LAST_INSERT_ID() as last_id;')->row_array();
                            $id_ukp = $id_ukp['last_id'];
                        }
                        
                        if (isset($post['elemen'])){
                            $count_el = count($post['elemen']) - 1;
                            $post_el = array();
                            for($i = 0; $i <= $count_el; $i++){
                                $post_el['nama'] = $post['elemen'][$i];
                                $post_el['tbl_unit_kompetensi_pemerintahan_id']= $id_ukp;
                                $insert_el = $this->db->insert("tbl_elemen_unit_kompetensi_pemerintahan", $post_el);
                            }
                        }
                        
                        $elemen_sql = $this->db->query("SELECT id, nama FROM tbl_elemen_unit_kompetensi_pemerintahan "
                                . "WHERE tbl_unit_kompetensi_pemerintahan_id = '$id_ukp'");
                        $elemen_data = $elemen_sql->result_array();
                        $elemen_num = $elemen_sql->num_rows();
                        
                        foreach($elemen_data as $k => $v){
                            if (isset($post['unjuk_'.$v['id']])){
                                
                                $count_kuk = count($post['unjuk_'.$v['id']]) -1;
                                //print_r ($post['unjuk_'.$v['id']]);
                                
                                $post_kuk = array();
                                for($i = 0; $i <= $count_kuk; $i++){
                                    
                                    $post_kuk['nama'] = $post['unjuk_'.$v['id']][$i];
                                    $post_kuk['tbl_elemen_unit_kompetensi_pemerintahan_id'] = $v['id'];
                                    //print_r($post_kuk);
                                    $insert_kuk = $this->db->insert("tbl_kuk_elemen_unit_kompetensi_pemerintahan", $post_kuk);
                                }
                                
                            }
                        }
                        
                        foreach ($elemen_data as $k => $v){
                            if (isset($post['editelemen_'.$v['id']])){
                                $count_ed_el = count($post['editelemen_'.$v['id']]) -1 ;
                                for($i = 0;$i <= $count_ed_el; $i++){
                                    $nama_elem = $post['editelemen_'.$v['id']][$i];
                                    
                                    
                                    $post_ed_el = array();
                                    $post_ed_el['nama'] = $nama_elem;
                                    
                                    $edit_elem = $this->db->where('id', $v['id']);
                                    $edit_elem = $this->db->update('tbl_elemen_unit_kompetensi_pemerintahan', $post_ed_el);
                                    
                                }
                            }else{
                                $kuk_que = "SELECT * FROM tbl_kuk_elemen_unit_kompetensi_pemerintahan "
                                            . "WHERE tbl_elemen_unit_kompetensi_pemerintahan_id = '".$v['id']."'";
                                $kuk_que = $this->db->query($kuk_que)->result_array();

                                foreach($kuk_que as $kv){
                                    if (isset($post['editkuk_'.$kv['id']])){
                                        $count_ed_kuk = count($post['editkuk_'.$kv['id']])-1;
                                        for($j=0;$j<=$count_ed_kuk;$j++){
                                            $nama_kuk = $post['editkuk_'.$kv['id']][$j];

                                            $post_ed_kuk = array();
                                            $post_ed_kuk['nama'] = $nama_kuk;

                                            $edit_kuk = $this->db->where('id', $kv['id']);
                                            $edit_kuk = $this->db->update('tbl_kuk_elemen_unit_kompetensi_pemerintahan', $post_ed_kuk);
                                        }
                                    }
                                }
                                
                            }
                        }
                        
                        if (isset($post['del_kuk'])){
                          $count_del_kuk = count($post['del_kuk']) - 1;
                          
                          for($i = 0; $i <= $count_del_kuk; $i++){
                              $delete_kuk = $this->db->where('id', $post['del_kuk'][$i]);
                              $delete_kuk = $this->db->delete('tbl_kuk_elemen_unit_kompetensi_pemerintahan');
                          }
                        }
                        
                        if (isset($post['del_elemen'])){
                          $count_del_elem = count($post['del_elemen']) - 1;
                          
                          for($i = 0; $i <= $count_del_elem; $i++){
                              $delete_elem = $this->db->where('id', $post['del_elemen'][$i]);
                              $delete_elem = $this->db->delete('tbl_elemen_unit_kompetensi_pemerintahan');
                              
                              $sql_kuk_el = $this->db->query("SELECT * FROM tbl_kuk_elemen_unit_kompetensi_pemerintahan "
                                      . "WHERE tbl_elemen_unit_kompetensi_pemerintahan_id = '".$post['del_elemen'][$i]."'")->result_array();
                              
                              foreach($sql_kuk_el as $val_kuk){
                                  $del_kuk_el = $this->db->where('id', $val_kuk['id']);
                                  $del_kuk_el = $this->db->delete('tbl_kuk_elemen_unit_kompetensi_pemerintahan');
                              }
                          }
                        }
                        
                        if (isset($post['level_kom_kunci'])){
                            $count_level_kk = count($post['level_kom_kunci'])-1;
                            for($i= 0; $i <= $count_level_kk; $i++){
                                $post_lkk = array();
                                $post_lkk['idx_level_kompetensi_kunci_id'] = $post['level_kom_kunci'][$i];
                                $post_lkk['tbl_unit_kompetensi_pemerintahan_id'] = $id_ukp;
                                
                                $insert_lkk = $this->db->insert('tbl_kompetensi_kunci_unit_kompetensi_pemerintahan', $post_lkk);
                            }
                        }
                        
                        if (isset($post['del_lev_kk'])){
                            $count_del_lkk = count($post['del_lev_kk']) - 1;
                            $post_del_kll = array();
                            for($i = 0;$i<=$count_del_lkk;$i++){
                                $delete_lkk = $this->db->where('id', $post['del_lev_kk'][$i]);
                                $delete_lkk = $this->db->delete('tbl_kompetensi_kunci_unit_kompetensi_pemerintahan');
                            }
                        }
                        
                        if (isset($post['dasar_hukum'])){
                            $count_das_hukum = count($post['dasar_hukum']) - 1;
                            $post_dHukum = array();
                            for ($i = 0; $i <= $count_das_hukum; $i++){
                                $post_dHukum['idx_dasar_hukum_id'] = $post['dasar_hukum'][$i];
                                $post_dHukum['tbl_unit_kompetensi_pemerintahan_id'] = $id_ukp;
                                
                                $insert_dasar_hukum = $this->db->insert('tbl_dasar_hukum_unit_kompetensi_pemerintahan', $post_dHukum);
                            }
                        }
                        
                        if (isset($post['del_dasar_hukum'])){
                            $count_del_dh = count($post['del_dasar_hukum']) - 1;
                            $post_del_dh = array();
                            for($i = 0;$i<=$count_del_dh;$i++){
                                $delete_dh = $this->db->where('id', $post['del_dasar_hukum'][$i]);
                                $delete_dh = $this->db->delete('tbl_dasar_hukum_unit_kompetensi_pemerintahan');
                            }
                        }
                        
                    break;
                    case "del_kompetensi_pemerintahan":
                        $delete_ukp = $this->db->where('id',$post['id_ukp']);
                        $delete_ukp = $this->db->delete('tbl_unit_kompetensi_pemerintahan');                        
                    break;
                                        
                }
		
		
		
		if($this->db->trans_status() == false){
			$this->db->trans_rollback();
			return "Data not saved";
		} else{
                    if ($type == 'unit_kompetensi_pemerintahan' && $p1 == 'submit'){
                        $this->db->trans_commit();
                        return $id_ukp;
                    }else{
			return $this->db->trans_commit();
                    }
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