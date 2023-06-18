<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Home extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->model('Home_model', 'hm');
	}

	public function faskes()
	{
		$data =$this->hm->get_faskes();
		echo json_encode($data);
	}

	public function bidang()
	{
		$data =$this->hm->get_bidang();
		echo json_encode($data);
	}

	public function index()
	{
		$this->load->view('v_home');
	}

	public function foto($kode=null)
	{
		$data = $this->db->limit(1)->get_where('bidang', array('kode' => $kode))->row()->gambar;
		echo json_encode ($data);
	}

	public function detilbidang($kode=null)
	{
		$data['kode'] = $kode;
		$data['bidang'] = $this->db->get_where('bidang',array('kode'=>$kode))->row_array();
		$data['dok'] = $this->db->get_where('dokumentasi', array('kode_bidang'=>$kode))->result_array();
		$this->load->view('v_detil',$data);
	}
}


