<?php
defined('BASEPATH') or exit('No direct script access allowed');

require APPPATH . 'libraries/REST_Controller.php';

class Laporan_transaksi extends REST_Controller
{

    //declare constructor
    function __construct()
    {
        parent::__construct();
        $this->load->model('Transaksi_model');
    }

    //function get/show data pengguna
    public function index_get()
    {
        //cek token
        //$this->token_check();

        //call function getPengguna from model
        $data = $this->Transaksi_model->laporanMingguan();

        // response / result
        $result = $data;

        $this->response($result, REST_Controller::HTTP_OK);
    }
}
