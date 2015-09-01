<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
/*
	LIBRARY CIPTAAN ABANG DJENONKS DKK
	KONTEN LIBRARY :
	- Upload File
	- Upload File Multiple
*/
class lib {
	public function __construct(){
		
	}
	
	//class Upload File Version 1.0 - Beta
	function uploadnong($upload_path="", $object="", $file=""){
		//$upload_path = "./__repository/".$folder."/";
		
		$ext = explode('.',$_FILES[$object]['name']);
		$exttemp = sizeof($ext) - 1;
		$extension = $ext[$exttemp];
		
		$filename =  $file.'.'.$extension;
		
		$files = $_FILES[$object]['name'];
		$tmp  = $_FILES[$object]['tmp_name'];
		if(file_exists($upload_path.$filename)){
			unlink($upload_path.$filename);
			$uploadfile = $upload_path.$filename;
		}else{
			$uploadfile = $upload_path.$filename;
		} 
		
		move_uploaded_file($tmp, $uploadfile);
		if (!chmod($uploadfile, 0775)) {
			echo "Gagal mengupload file";
			exit;
		}
		
		return $filename;
	}
	// end class Upload File
	
	//class Upload File Multiple Version 1.0 - Beta
	function uploadmultiplenong($upload_path="", $object="", $file="", $idx=""){
		$ext = explode('.',$_FILES[$object]['name'][$idx]);
		$exttemp = sizeof($ext) - 1;
		$extension = $ext[$exttemp];
		
		$filename =  $file.'.'.$extension;
		
		$files = $_FILES[$object]['name'][$idx];
		$tmp  = $_FILES[$object]['tmp_name'][$idx];
		if(file_exists($upload_path.$filename)){
			unlink($upload_path.$filename);
			$uploadfile = $upload_path.$filename;
		}else{
			$uploadfile = $upload_path.$filename;
		} 
		
		move_uploaded_file($tmp, $uploadfile);
		if (!chmod($uploadfile, 0775)) {
			echo "Gagal mengupload file";
			exit;
		}
		
		return $filename;
	}
	//end Class Upload File
	
	//class Random String Version 1.0
	function randomString($length,$parameter="") {
        $str = "";
		$rangehuruf = range('A','Z');
		$rangehuruf_kecil = range('a','z');
		$rangeangka = range('0','9');
		if($parameter == 'reg'){
			$characters = array_merge($rangeangka);
		}elseif($parameter == 'huruf'){
			$characters = array_merge($rangehuruf_kecil);
		}else{
			$characters = array_merge($rangehuruf, $rangeangka);
		}
         $max = count($characters) - 1;
         for ($i = 0; $i < $length; $i++) {
              $rand = mt_rand(0, $max);
              $str .= $characters[$rand];
         }
         return $str;
    }
	//end Class Random String
	
	//Class CutString
	function cutstring($text, $length) {
		$isi_teks = htmlentities(strip_tags($text));
		$isi = substr($isi_teks,0,$length);
		$isi = substr($isi_teks,0,strrpos($isi," "));
		$isi = $isi.' ...';
		return $isi;
	}
	//end Class CutString
	
	//Class Kirim Email
	function kirimemail($email_content="", $subject="", $email_address="", $email_cc="", $attachment=""){
		$ci =& get_instance();
		$ci->load->library('My_PHPMailer');
		
		try{
			$mail = new PHPMailer();
			$email_body = $email_content;
			
			if($ci->config->item('SMTP')) $mail->IsSMTP();
			$mail->SMTPAuth   = $ci->config->item('SMTPAuth');       
			$mail->SMTPSecure = "ssl";
			$mail->Port       = $ci->config->item('Port');                    
			$mail->Host       = $ci->config->item('Host'); 
			$mail->Username   = $ci->config->item('Username');     
			$mail->Password   = $ci->config->item('Password');            

			$mail->AddReplyTo($ci->config->item('EmaiFrom'),$ci->config->item('EmaiFromName'));
			$mail->SetFrom    = $ci->config->item('EmaiFrom');
			$mail->FromName   = $ci->config->item('EmaiFromName');			
			
			$mail->AddAddress($email_address);
			if($email_cc){
				foreach($email_cc as $k){
					$mail->AddCC($k);
				}
			}
			
			$mail->Subject   = $subject;
			$mail->AltBody   = "To view the message, please use an HTML compatible email viewer!"; 
			$mail->WordWrap  = 100; 
			$mail->MsgHTML($email_body);
			$mail->IsHTML(true);
			if($attachment){
				foreach($attachment as $s){
					$mail->AddAttachment($s);
				}
			}			
			$mail->SMTPDebug=1;
			
			if($mail->Send()){
				return 1;
			}else{
				return 0;
			}
			
		} catch (phpmailerException $e) {
			return 0;
		}
	}	
	//End Class KirimEmail
	
	//Class Json Data
	function jsondata($sql, $type, $p1=""){
		$ci =& get_instance();
		
		$page = (integer) (($ci->input->post('page')) ? $ci->input->post('page') : "1");
		$limit = (integer) (($ci->input->post('rows')) ? $ci->input->post('rows') : "10");
		$count = $ci->db->query($sql)->num_rows();
		
		if( $count >0 ) { $total_pages = ceil($count/$limit); } else { $total_pages = 0; } 
		if ($page > $total_pages) $page=$total_pages; 
		$start = $limit*$page - $limit; // do not put $limit*($page - 1)
		if($start<0) $start=0;
		 
		$sql = $sql . " LIMIT $start, $limit";
					
		$data = $ci->db->query($sql)->result_array();  
		
		if($type == 'peta_jabatan'){
			$sql2 = "
				SELECT *
				FROM idx_kl
				WHERE 1=1 $p1
			";
			$data2 = $ci->db->query($sql2)->result_array();
			
			foreach($data as $k => $v){
				$data[$k]['jenis_bkl'] = 'B';
			}
			
			$idx = count($data);
			foreach($data2 as $z => $r){
				$data[$idx]['id'] = $r['id'];
				$data[$idx]['nama_bidang'] = $r['nama_kl'];
				$data[$idx]['jenis_bkl'] = 'K';
				$idx++;
			}
			
		}
				
		if($data){
		   $responce = new stdClass();
		   $responce->rows= $data;
		   $responce->total =$count;
		   return json_encode($responce);
		}else{ 
		   $responce = new stdClass();
		   $responce->rows = 0;
		   $responce->total = 0;
		   return json_encode($responce);
		} 
	}
	//END Class Json Data
	
	//Class Fillcombo
	function fillcombo($type="", $balikan="", $p1="", $p2="", $p3="", $p4=""){
		$ci =& get_instance();
		$ci->load->model(array('why/madmin'));
		
		$v = $ci->input->post('v');
		if($v != ""){
			$selTxt = $v;
		}else{
			$selTxt = $p1;
		}
		
		
		$optTemp = '<option value="0"> -- Pilih -- </option>';
		switch($type){
			case "jenis_kelamin":
				$data = array(
					'0' => array('id'=>'L','txt'=>'Laki-Laki'),
					'1' => array('id'=>'P','txt'=>'Perempuan'),
				);
			break;
			case "status":
				$data = array(
					'0' => array('id'=>'1','txt'=>'Active'),
					'1' => array('id'=>'0','txt'=>'Inactive'),
				);
			break;
			case "ya_tidak":
				$optTemp = '';
				$data = array(
					'0' => array('id'=>'Y','txt'=>'Ya'),
					'1' => array('id'=>'N','txt'=>'Tidak'),
				);
			break;
			default:
				$data = $ci->madmin->get_data_fillcombo($type, $p1, $p2, $p3, $p4);
			break;
		}
		
		if($data){
			foreach($data as $k=>$v){
				if($selTxt == $v['id']){
					$optTemp .= '<option selected value="'.$v['id'].'">'.$v['txt'].'</option>';
				}else{ 
					$optTemp .= '<option value="'.$v['id'].'">'.$v['txt'].'</option>';	
				}
			}
		}
		
		if($balikan == 'return'){
			return $optTemp;
		}elseif($balikan == 'echo'){
			echo $optTemp;
		}
		
	}
	//End Class Fillcombo
	
}