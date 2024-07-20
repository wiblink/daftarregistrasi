<?php
namespace App\Controllers;
use App\Models\RegisterModel;
use \Config\App;
use App\Libraries\Auth;

class Verify extends \App\Controllers\BaseController
{
	protected $model = '';
	
	public function __construct() {
		parent::__construct();
		$this->model = new RegisterModel;	
		$this->data['site_title'] = 'Register Akun';
		
		helper(['cookie', 'form']);
		
		$this->addJs($this->config->baseURL . 'public/vendors/jquery/jquery.min.js');
		$this->addJs($this->config->baseURL . 'public/vendors/bootstrap/js/bootstrap.min.js');
										
		$this->addStyle($this->config->baseURL . 'public/vendors/bootstrap/css/bootstrap.min.css');
		$this->addStyle($this->config->baseURL . 'public/vendors/font-awesome/css/font-awesome.min.css');
		$this->addStyle($this->config->baseURL . 'public/themes/modern/css/register.css');

		$this->addJs ( $this->config->baseURL . 'public/vendors/jquery.select2/js/select2.full.min.js' );
		$this->addStyle ( $this->config->baseURL . 'public/vendors/jquery.select2/css/select2.min.css' );
		$this->addStyle ( $this->config->baseURL . 'public/vendors/jquery.select2/bootstrap-5-theme/select2-bootstrap-5-theme.min.css' );
		
	}
	
	public function index()
	{
		
		$this->mustNotLoggedIn();
		$this->data['title'] = 'Register Akun';
		$message = [];
		$id=$_GET['id'];

		$harike = $this->checkValidHari($id);
		if$harike['hari'];
		$message = $this->model->UpdateVerify($id);
		
		$file = 'verify.php';

		#die(print_r($data['wilayah']));
		$this->data['message'] = $message;
		$this->data['style'] = ' style="max-width:500px; margin-top:50px"';
		return view('themes/modern/register/' . $file, $this->data);
	}


	public function checkValidHari($idwilayah) {
		
		$sql = 'SELECT hari FROM user WHERE id_user = "'.$id.'"';			
		$cekhari = $this->db->query($sql)->getRowArray();
		return $cekhari;
	}
	
}