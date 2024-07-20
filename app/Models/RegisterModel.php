<?php

namespace App\Models;
use App\Libraries\Auth;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

require 'vendor/autoload.php';

class RegisterModel extends \App\Models\BaseModel
{
	public function getUserByEmail($email) {
		$sql = 'SELECT * FROM user WHERE email = ?';
		$result = $this->db->query($sql, $email)->getRowArray();
		return $result;
	}
	
	public function resendLink() 
	{
		$error = false;
		$message['status'] = 'error';
		
		$user = $this->getUserByEmail( $_POST['email'] );
					
		$this->db->transBegin();
		
		$this->db->table('user_token')->delete(['action' => 'activation', 'id_user' => $user['id_user']]);

		$auth = new Auth;
		$token = $auth->generateDbToken();	
		$data_db['selector'] = $token['selector'];
		$data_db['token'] = $token['db'];
		$data_db['action'] = 'activation';
		$data_db['id_user'] = $user['id_user'];
		$data_db['created'] = date('Y-m-d H:i:s');
		$data_db['expires'] = date('Y-m-d H:i:s', strtotime('+1 hour'));
		
		$insert_token = $this->db->table('user_token')->insert($data_db);
		
		// $save = true;
		if ($insert_token)
		{
			$send_email = $this->sendConfirmEmail($token, $user, 'link_aktivasi');
						
			if ($send_email['status'] == 'ok')
			{
				$this->db->transCommit();
				$email_config = new \Config\EmailConfig;
				$message['status'] = 'ok';
				$message['message'] = '
				Link aktivasi berhasil dikirim ke alamat email: <strong>'. $_POST['email'] . '</strong>, silakan gunakan link tersebut untuk aktivasi akun Anda<br/></br>Biasanya, email akan sampai kurang dari satu menit, namun jika lebih dari lima menit email belum sampai, coba cek folder spam. Jika email benar benar tidak sampai, silakan hubungi kami di <a href="mailto:'.$email_config->emailSupport.'" target="_blank">'.$email_config->emailSupport.'</a>';
			} else {
				$message['message'] = 'Error: Link aktivasi gagal dikirim... <strong>' . $send_email['message'] . '</strong>';
				$error = true;
			}
		} else {
			$message['message'] = 'Gagal menyimpan data token, silakan hubungi kami di: <a href="mailto:'.$email_config->emailSupport.'" target="_blank">'.$config['email_support'].'</a>';
			$error = true;
		}
		
		if ($error) {
			$this->db->transRollback();
		}
		
		return $message;
	}
	
	public function checkUserById($id_user) 
	{
		$sql = 'SELECT * FROM user WHERE id_user = ?';
		$user = $this->db->query($sql, $id_user)->getRowArray();
		return $user;
	}


	

	
	public function checkToken($selector) {
		
		$sql = 'SELECT * FROM user_token
				WHERE selector = ?';
			
		$dbtoken = $this->db->query($sql, $selector)->getRowArray();
		return $dbtoken;
	}


	public function checkHari($idwilayah) {
		
		$sql = 'SELECT kd_wilayah FROM wilayah WHERE id_wilayah = "'.$idwilayah.'"';			
		$cekhari = $this->db->query($sql)->getRowArray();
		return $cekhari;
	}
	
	public function insertUser() 
	{
		$error = false;
		$message['status'] = 'error';
		
		$this->db->transBegin();
		
		$idwilayah = $_POST['id_wilayah1'].''.$_POST['id_wilayah2'].''.$_POST['id_wilayah3'].''.$_POST['id_wilayah4'];
		$harike = $this->checkHari($idwilayah);
		#die(print_r($harike));
		$data_db['instansi'] = $_POST['instansi'];
		$data_db['id_wilayah'] = $idwilayah;
		$data_db['hadir'] = $_POST['hw'];
		$data_db['jabatan'] = $_POST['jabatan'];
		$data_db['no_hp'] = $_POST['no_hp'];
		$data_db['nama'] = $_POST['nama'];
		$data_db['email'] = $_POST['email'];
		$data_db['hari'] = $harike['kd_wilayah'];
		$data_db['status'] = 'active';
		$data_db['created'] = date('Y-m-d H:i:s');
	

		$insert_user = $this->db->table('user')->insert($data_db);
		#die(print_r($this->db->getLastQuery()));
		$id_user = $this->db->insertID();
		
		if (!$id_user)
		{
			$message['message'] = 'System error, please try again lakioiki';
			$error = true;
		
		} else {


			$send_email = $this->send_email($data_db);

			$message['message'] = 'Sukses';
			
		}
		
		if ($error) {
			$this->db->transRollback();
		} else {
			$this->db->transCommit();
			$message['status'] = 'ok';
		}
	
		return $message;
	}


	public function send_email($data_db) {
    
        $email          = $data_db['email'];
        $subject        = 'Tes Email';
        $message        = 'Oke emailnya dah masuk';
        
        $mail = new PHPMailer(true);  
		try {
		    
		    $mail->isSMTP();  
		    $mail->Host         = 'smtp.google.com'; //smtp.google.com
		    $mail->SMTPAuth     = true;     
		    $mail->Username     = 'mywbstorage@gmail.com';  
		    $mail->Password     = 'scsdcdssdc';
			$mail->SMTPSecure   = 'ssl';  
			$mail->Port         = 465;  
			$mail->Subject      = $subject;
			$mail->Body         = $message;
			$mail->setFrom('username', 'display_name');
			
			$mail->addAddress($email);  
			$mail->isHTML(true);      
			
			if(!$mail->send()) {
			    $message['message'] = "Something went wrong. Please try again.";
			}
		    else {
			    $message['message'] =  "Email sent successfully.";
		    }
		    
		} catch (Exception $e) {
		    echo "Something went wrong. Please try again.";
		}
        
    }
	
	private function sendConfirmEmail($token, $user)
	{
		helper('email_registrasi');
		
		
		$url_token = $token['selector'] . ':' . $token['external'];
		$url = base_url() .'/register/confirm?token='.$url_token;
		$email_content = str_replace('{{NAME}}'
									, $user['nama']
									, $email_text
								);
								
		$email_content = str_replace('{{url}}', $url, $email_content);
		
		$email_config = new \Config\EmailConfig;
		$email_data = array('from_email' => $email_config->from
						, 'from_title' => 'Jagowebdev'
						, 'to_email' => $user['email']
						, 'to_name' => $user['nama']
						, 'email_subject' => 'Konfirmasi Registrasi Akun'
						, 'email_content' => $email_content
						, 'images' => ['logo_text' => ROOTPATH . 'public/images/logo_text.png']
		);
		
		require_once('app/Libraries/SendEmail.php');

		$emaillib = new \App\Libraries\SendEmail;
		$emaillib->init();
		$emaillib->setProvider($email_config->provider);
		$send_email =  $emaillib->send($email_data);
		
		return $send_email;
	}

	public function getWilayah() {
		$sql = 'SELECT * FROM wilayah where kpwdn is null';
		$query = $this->db->query($sql)->getResultArray();
		return $query;
	}

	public function getWilayahbpd() {
		$sql = 'SELECT * FROM wilayah where kpwdn != "col_kpwdn"';
		$query = $this->db->query($sql)->getResultArray();
		return $query;
	}

	public function getWilayahcolkpwdn() {
		$sql = 'SELECT * FROM wilayah where kode is null and tingkat is null and kpwdn = "col_kpwdn"';
		$query = $this->db->query($sql)->getResultArray();
		return $query;
	}

	public function getWilayahcolbpd() {
		$sql = 'SELECT * FROM wilayah where kode is null and tingkat is null and kpwdn = "col_bpd"';
		$query = $this->db->query($sql)->getResultArray();
		return $query;
	}


	public function UpdateVerify($id) {
		$this->db->transStart();

		$query = $this->db->table('user')->update(['verified' => 1], ['id_user' => $id]);
		
		$update = $this->db->transComplete();
		return $update;
	}
	
}
?>