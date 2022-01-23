<?php
defined('BASEPATH') or exit('No direct script access allowed');

require APPPATH . 'libraries/REST_Controller.php';

class Makanan extends REST_Controller
{

    //declare constructor
    function __construct()
    {
        parent::__construct();
        $this->load->model('Makanan_model');
        $this->load->helper(array('form', 'url'));
    }

    //function get/show data pengguna
    function index_get()
    {
        //cek token
        //$this->token_check();

        //value paramater nama
        $nama = $this->get('nama');
        //call function getPengguna from model
        $data = $this->Makanan_model->getMakanan($nama);

        /*response / result
        $result = array(
            'success' => true,
            'message' => 'data found',
            'data' => array('pengguna' => $data)
        );*/
        $result = $data;

        //show response
        $this->response($result, REST_Controller::HTTP_OK);
    }

    //function insert (POST) pengguna
    function index_post()
    {
        //cek token
        //$this->token_check();
        $id_makanan = $this->post('id_makanan');
        $flag = $this->post('flag');

        //validasi jika inputan kosong/format tidak sesuai
        $validasi_message = [];

        //jika id kosong
        if ($id_makanan == '') {
            array_push($validasi_message, 'ID can not be empty');
        }

        //jika nama kosong
        if ($this->post('nama_makanan') == '') {
            array_push($validasi_message, 'Name can not be blank');
        }

        //jika harga kosong
        if ($this->post('harga') == '') {
            array_push($validasi_message, 'Harga can not be empty');
        }

        //jika harga bukan angka
        if ( is_numeric($this->post('harga')) == FALSE) {
            array_push($validasi_message, 'Harga is invalid');
        }

        //show message
        if (count($validasi_message) > 0) {
            $output = array(
                'success' => false,
                'message' => 'insert data failed, data not valid',
                'data' => $validasi_message
            );

            $this->response($output, REST_Controller::HTTP_OK);
            $this->output->_display();
            exit();
        }

        $config['upload_path']          = './foto/';
        $config['allowed_types']        = 'gif|jpg|jpeg|png';
        $config['max_size']             = 10240; // 1MB

        $this->load->library('upload', $config);  

        $gambar = base_url() . "foto/" . $_FILES['gambar']['name'];
        $data = array(
            'id_makanan' => $this->post('id_makanan'),
            'nama_makanan' => $this->post('nama_makanan'),
            'harga' => $this->post('harga'),
            'gambar' => $gambar
        );

        if ($flag == 'insert') {
            //call function insertMakanan from model
            $result = $this->Makanan_model->insertMakanan($data);

            //response
            if (empty($result)) {
                $output = array(
                    'success' => false,
                    'message' => 'data already exists',
                    'data' => null
                );
            } else {
                $this->upload->do_upload('gambar');

                $output = array(
                    'success' => true,
                    'message' => 'insert data success',
                    'data' => array(
                        'makanan' => $result
                    )
                );
            }
        } elseif ($flag == 'update') {
            // call function updateMakanan from model
            $image = $this->Makanan_model->get_by_id(array('id_makanan' => $id_makanan))->row_object();
            $result = $this->Makanan_model->updateMakanan($data, $id_makanan);

            if ($this->upload->do_upload('gambar')) {
                $old_image = preg_replace("/http:\/\/192.168.18.15\/rest_api\/foto\//", "", $image->gambar);
                
                $target_file = './foto/' . $old_image;
                unlink($target_file);
            }
            //response
            $output = array(
                'success' => true,
                'message' => 'update data success',
                'data' => array(
                    'pengguna' => $result
                )
            );
        }
        
        $this->response($output, REST_Controller::HTTP_OK);
    }

    //function delete (DELETE) data makanan
    function index_delete()
    {
        //cek token
        //$this->token_check();

        //get id_makanan
        $id_makanan = $this->delete('id_makanan');

        //validasi input kosong/tdk
        $validasi_message = [];

        //jika id_makanan kosong
        if ($id_makanan == '') {
            array_push($validasi_message, 'id_makanan can not be empty');
        }

        //show message
        if (count($validasi_message) > 0) {
            $output = array(
                'success' => false,
                'message' => 'delete data failed, id_makanan is invalid',
                'data' => $validasi_message
            );

            $this->response($output, REST_Controller::HTTP_OK);
            $this->output->_display();
            exit();
        }

        //call deletePengguna from model
        $result = $this->Makanan_model->deleteMakanan($id_makanan);

        //cek result
        if (empty($result)) {
            $output = array(
                'success' => false,
                'message' => 'id_makanan not found',
                'data' => null
            );
        } else {
            $old_image = preg_replace("/http:\/\/192.168.18.15\/rest_api\/foto\//", "", $result['gambar']);

            $target_file = './foto/' . $old_image;
            unlink($target_file);

            $output = array(
                'success' => true,
                'message' => 'delete data success',
                'data' => array(
                    'pengguna' => $result
                )
            );
        }

        $this->response($output,
            REST_Controller::HTTP_OK
        );
    }
}
