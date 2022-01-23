<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Transaksi_model extends CI_Model{

    //declare constructor
    function __construct(){
        parent::__construct();
        //akses database
        $this->load->database();
    }

    // function laporan mingguan
    public function laporanMingguan()
    {
        $dataMingguan = $this->db->query('SELECT tanggal, SUM(harga) AS total FROM penjualan JOIN detail_penjualan ON penjualan.no_transaksi = detail_penjualan.no_transaksi WHERE tanggal BETWEEN DATE_ADD(CURDATE(), INTERVAL - 1 WEEK) AND CURDATE() GROUP BY tanggal');

        return $dataMingguan->result_array();
    }

    // functin insert data penjualan
    public function insertPenjualan($data){
        $this->db->insert('penjualan', $data);

        $last_id = $this->db->insert_id();
        $data['last_id'] = $last_id;

        return $data;
    }

    //function insert data detail penjualan
    public function insertDetailPenjualan($data){
        $this->db->insert('detail_penjualan', $data);

        $last_id = $this->db->insert_id();
        $data['last_id'] = $last_id;

        return $data;
    }
}
?>