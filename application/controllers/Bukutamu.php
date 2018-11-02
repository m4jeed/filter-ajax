<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Bukutamu extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->model('M_bukutamu','buku');
	}

	public function index()
	{
		$negara =$this->buku->get_list_negara();
		// print_r($negara);
		$opt =array('' => 'Negara');

		foreach ($negara as $key) {
			$opt[$key] = $key;
		}
		// print_r($opt);

		$data['form_country'] = form_dropdown('',$opt,'','id="country" class="form-control"');
		// $data['form_country'] = form_dropdown('',$opt,'','id="country" class="form-control"');
		 //print_r($data['form_country']);die();
		$this->load->view('v_bukutamu',$data);
	}

	public function ajax_list(){
		$list = $this->buku->get_datatables();
		$data = array();
		$no =$_POST['start'];
		foreach ($list as $ambil) {
			$no++;
			$row = array();
			$row[] =$no;
			$row[] =$ambil->FirstName;
			$row[] =$ambil->LastName;
			$row[] =$ambil->phone;
			$row[] =$ambil->address;
			$row[] =$ambil->city;
			$row[] =$ambil->country;

			$data[] = $row;

			//print_r($data);die();
		}

		$output = array(
			"draw" => $_POST['draw'],
			"recordsTotal" => $this->buku->count_all(),
			"recordsFiltered" => $this->buku->count_filtered(),
			"data" => $data,
		);

		echo json_encode($output);

	}

}