<?php
use Restserver\Libraries\REST_Controller;
require APPPATH . 'libraries/REST_Controller.php';
require APPPATH . 'libraries/Format.php';

class Rest_wisata extends REST_Controller {

    // Konfigurasi letak folder untuk upload image
    private $folder_upload = 'uploads/';

    function all_get(){
        $get_wisata = $this->db->query("
            SELECT
                id_wisata,
                id_kecamatan,
                nama_wisata,
                alamat,
                cp,
                deskripsi,
                gambar
            FROM wisata")->result();
       $this->response(
           array(
               "status" => "success",
               "result" => $get_wisata
           )
       );
    }

    function all_post() {

        $action  = $this->post('action');
        $data_wisata = array(
                        'id_wisata' => $this->post('id_wisata'),
                        'id_kecamatan' => $this->post('id_kecamatan'),
                        'nama_wisata'       => $this->post('nama_wisata'),
                        'alamat'     => $this->post('alamat'),
                        'cp'      => $this->post('cp'),
                        'deskripsi'      => $this->post('deskripsi'),
                        'gambar'   => $this->post('gambar')
                    );

        switch ($action) {
            case 'insert':
                $this->insertWisata($data_wisata);
                break;
            
            case 'update':
                $this->updateWisata($data_wisata);
                break;
            
            case 'delete':
                $this->deleteWisata($data_wisata);
                break;
            
            default:
                $this->response(
                    array(
                        "status"  =>"failed",
                        "message" => "action harus diisi"
                    )
                );
                break;
        }
    }

    function insertPembeli($data_wisata){

        // Cek validasi
        if (empty($data_wisata['id_wisata']) || empty($data_wisata['id_kecamatan']) || empty($data_wisata['nama_wisata']) || empty($data_wisata['alamat']) || empty($data_wisata['cp']) || empty($data_wisata['deskripsi']) || empty($data_wisata['gambar']) ){
            $this->response(
                array(
                    "status" => "failed",
                    "message" => "Semua field harus diisi"
                )
            );
        } else {

            $data_wisata['gambar'] = $this->uploadPhoto();

            $do_insert = $this->db->insert('wisata', $data_wisata);
           
            if ($do_insert){
                $this->response(
                    array(
                        "status" => "success",
                        "result" => array($data_wisata),
                        "message" => $do_insert
                    )
                );
            }
        }
    }

    function updateWisata($data_wisata){

        // Cek validasi
        if (empty($data_wisata['id_wisata']) || empty($data_wisata['id_kecamatan']) || empty($data_wisata['nama_wisata']) || empty($data_wisata['alamat']) || empty($data_wisata['cp']) || empty($data_wisata['deskripsi']) || empty($data_wisata['gambar']) ){
            $this->response(
                array(
                    "status" => "failed",
                    "message" => "Semua field harus diisi"
                )
            );
        } else {
            // Cek apakah ada di database
            $get_wisata_baseID = $this->db->query("
                SELECT 1
                FROM wisata
                WHERE id_wisata =  {$data_wisata['id_wisata']}")->num_rows();

            if($get_wisata_baseID === 0){
                // Jika tidak ada
                $this->response(
                    array(
                        "status"  => "failed",
                        "message" => "ID wisata tidak ditemukan"
                    )
                );
            } else {
                // Jika ada
                $data_wisata['gambar'] = $this->uploadPhoto();

                if ($data_wisata['gambar']){
                    // Jika upload foto berhasil, eksekusi update
                    $update = $this->db->query("
                        UPDATE wisata SET
                            id_kecamatan = '{$data_wisata['id_kecamatan']}',
                            nama_wisata = '{$data_wisata['nama_wisata']}',
                            alamat = '{$data_wisata['alamat']}',
                            cp = '{$data_wisata['cp']}',
                            deskripsi = '{$data_wisata['deskripsi']}',
                            gambar = '{$data_wisata['gambar']}'
                        WHERE id_wisata = '{$data_wisata['id_wisata']}'");

                } else {
                    // Jika foto kosong atau upload foto tidak berhasil, eksekusi update
                    $update = $this->db->query("
                        UPDATE wisata
                        SET
                            id_kecamatan = '{$data_wisata['id_kecamatan']}',
                            nama_wisata = '{$data_wisata['nama_wisata']}',
                            alamat = '{$data_wisata['alamat']}',
                            cp = '{$data_wisata['cp']}',
                            deskripsi = '{$data_wisata['deskripsi']}',
                        WHERE id_wisata = {$data_wisata['id_wisata']}"
                    );
                }
               
                if ($update){
                    $this->response(
                        array(
                            "status"    => "success",
                            "result"    => array($data_wisata),
                            "message"   => $update
                        )
                    );
                }
            }   
        }
    }

    function deletePembeli($data_pembeli){

        if (empty($data_wisata['id_wisata'])){
            $this->response(
                array(
                    "status" => "failed",
                    "message" => "ID wisata harus diisi"
                )
            );
        } else {
            // Cek apakah ada di database
            $get_wisata_baseID =$this->db->query("
                SELECT 1
                FROM wisata
                WHERE id_wisata = {$data_wisata['id_wisata']}")->num_rows();

            if($get_pembeli_baseID > 0){
                
                $get_photo_url =$this->db->query("
                SELECT gambar
                FROM wisata
                WHERE id_wisata = {$data_wisata['id_wisata']}")->result();
            
                if(!empty($get_photo_url)){

                    // Dapatkan nama file
                    $photo_nama_file = basename($get_photo_url[0]->photo_url);
                    // Dapatkan letak file di folder upload
                    $photo_lokasi_file = realpath(FCPATH . $this->folder_upload . $photo_nama_file);
                    
                    // Jika file ada, hapus
                    if(file_exists($photo_lokasi_file)) {
                        // Hapus file
                        unlink($photo_lokasi_file);
                    }

                    $this->db->query("
                        DELETE FROM wisata
                        WHERE id_wisata = {$data_wisata['id_wisata']}");
                    $this->response(
                        array(
                            "status" => "success",
                            "message" => "Data ID = " .$data_wisata['id_wisata']. " berhasil dihapus"
                        )
                    );
                }
            
            } else {
                $this->response(
                    array(
                        "status" => "failed",
                        "message" => "ID wisata tidak ditemukan"
                    )
                );
            }
        }
    }

    function uploadPhoto() {

        // Apakah user upload gambar?
        if ( isset($_FILES['photo_url']) && $_FILES['photo_url']['size'] > 0 ){

            // Foto disimpan di android-api/uploads
            $config['upload_path'] = realpath(FCPATH . $this->folder_upload);
            $config['allowed_types'] = 'jpg|png';

            // Load library upload & helper
            $this->load->library('upload', $config);
            $this->load->helper('url');

            // Apakah file berhasil diupload?
            if ( $this->upload->do_upload('photo_url')) {

               // Berhasil, simpan nama file-nya
               // URL image yang disimpan adalah http://localhost/android-api/uploads/namafile
               $img_data = $this->upload->data();
               $post_image = base_url(). $this->folder_upload .$img_data['file_name'];

            } else {

                // Upload gagal, beri nama image dengan errornya
                // Ini bodoh, tapi efektif
                $post_image = $this->upload->display_errors();
                
            }
        } else {
            // Tidak ada file yang di-upload, kosongkan nama image-nya
            $post_image = '';
        }

        return $post_image;
    }
}
