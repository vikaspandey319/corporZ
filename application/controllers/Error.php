<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Error extends CI_Controller
{
	function __construct()
	{
		parent::__construct();
		$this->load->model('home_model');
	}
	public function index()
	{

		$data['metatags'] = array();

		$data['styles'] = array(
			'<link href="' . base_url() . 'assets/frontend/css/3/bootstrap.min.css" rel="stylesheet">',
			'<link href="' . base_url() . 'assets/frontend/css/bootstrap.min.css" rel="stylesheet">',
			'<link href="' . base_url() . 'assets/frontend/css/style.css" rel="stylesheet">',
		);

		$data['scripts'] = array(
			'<script src="' . base_url() . 'assets/frontend/js/jquery-min.js"></script>',
			'<script src="' . base_url() . 'assets/frontend/js/popper.min.js"></script>',
			'<script src="' . base_url() . 'assets/frontend/js/jquery.mainmenu.js"></script>',
			'<script src="' . base_url() . 'assets/frontend/js/plugins.js"></script>',
			'<script src="' . base_url() . 'assets/frontend/js/wow.js"></script>',
			'<script src="' . base_url() . 'assets/frontend/js/magnific-popup.min.js"></script>',
			'<script src="' . base_url() . 'assets/frontend/js/custom.js"></script>',
		);

		// Get Website Settings
		$setting = $this->home_model->getWebsiteSettings();
		$data['title'] = "Home | " . $setting['name'];
		$data['logo'] = $setting['logo'];
		$data['footer_logo'] = $setting['footer_logo'];
		$data['footer_about'] = $setting['footer_about'];
		$data['alt'] = $setting['name'];

		// Main Navbar
		$data['navigations'] = $this->home_model->getNavigation();



		$this->load->view('includes/header', $data);
		$this->load->view('includes/navigation', $data);
		$this->load->view('404', $data);
		$this->load->view('includes/footer', $data);
	}
}
