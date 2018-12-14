<?php
use Restserver\Libraries\REST_Controller;
require APPPATH . 'libraries/REST_Controller.php';
require APPPATH . 'libraries/Format.php';

class Rest_penginapan extends REST_Controller {


    // Konfigurasi letak folder untuk upload image
    private $folder_upload = 'uploads/';

    function all_get(){
        $get_penginapan = $this->db->query("
            SELECT
                id_penginapan,
                id_kecamatan,
                nama_inap,
                alamat,
                cp,
                wisata,
                tarif_jam,
                gambar
            FROM penginapan")->result();
       $this->response(
           array(
               "status" => "success",
               "result" => $get_penginapan
           )
       );
    }

    function all_post() {

        $action  = $this->post('action');
        $data_penginapan = array(
                     'id_penginapan' => $this->post('id_penginapan'),
                     'id_kecamatan'  => $this->post('id_kecamatan'),
                     'nama_inap'     => $this->post('nama_inap'),
                     'alamat'      => $this->post('alamat'),
                     'cp'      => $this->post('cp'),
                     'wisata'      => $this->post('wisata'),
                     'tarif_jam'      => $this->post('tarif_jam'),
                     'photo_url'   => $this->post('photo_url')
                 );

        switch ($action) {
            case 'insert':
                $this->insertPenginapan($data_penginapan);
                break;
            
            case 'update':
                $this->updatePenginapan($data_penginapan);
                break;
            
            case 'delete':
                $this->deletePembeli($data_penginapan);
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

    function insertPenginapan($data_penginapan){

     // Cek validasi
     if (empty($data_penginapan['id_kecamatan']) || empty($data_penginapan['nama_inap']) || empty($data_penginapan['alamat']) || empty($data_penginapan['cp']) || empty($data_penginapan['wisata']) || empty($data_penginapan['tarif_jam'])){
         $this->response(
             array(
                 "status" => "failed",
                 "message" => "Semua field harus diisi"
             )
         );
     } else {

         $data_penginapan['gambar'] = $this->uploadPhoto();

         $do_insert = $this->db->insert('penginapan', $data_penginapan);
        
         if ($do_insert){
             $this->response(
                 array(
                     "status" => "success",
                     "result" => array($data_penginapan),
                     "message" => $do_insert
                 )
             );
            }
     }
    }

    function updatePenginapan($data_penginapan){

     // Cek validasi
     if (empty($data_penginapan['id_kecamatan']) || empty($data_penginapan['nama_inap']) || empty($data_penginapan['alamat']) || empty($data_penginapan['cp']) || empty($data_penginapan['wisata']) || empty($data_penginapan['tarif_jam'])){
         $this->response(
             array(
                 "status" => "failed",
                 "message" => "Semua field harus diisi"
             )
         );
     } else {
         // Cek apakah ada di database
         $get_penginapan_baseID = $this->db->query("
             SELECT 1
             FROM penginapan
             WHERE id_penginapan =  {$data_penginapan['id_penginapan']}")->num_rows();

         if($get_penginapan_baseID === 0){
             // Jika tidak ada
             $this->response(
                 array(
                     "status"  => "failed",
                     "message" => "ID penginapan tidak ditemukan"
                 )
             );
         } else {
             // Jika ada
             $data_penginapan['gambar'] = $this->uploadPhoto();

             if ($data_penginapan['gambar']){
                 // Jika upload foto berhasil, eksekusi update
                 $update = $this->db->query("
                     UPDATE penginapan SET
                         id_kecamatan = '{$data_penginapan['id_kecamatan']}',
                         nama_inap = '{$data_penginapan['nama_inap']}',
                         alamat = '{$data_penginapan['alamat']}',
                         cp = '{$data_penginapan['cp']}',
                         wisata = '{$data_penginapan['wisata']}',
                         tarif_jam = '{$data_penginapan['tarif_jam']}',
                         gambar = '{$data_penginapan['gambar']}'
                     WHERE id_penginapan = '{$data_penginapan['id_penginapan']}'");

             } else {
                 // Jika foto kosong atau upload foto tidak berhasil, eksekusi update
                    $update = $this->db->query("
                        UPDATE penginapan SET
                           id_kecamatan = '{$data_penginapan['id_kecamatan']}',
                           nama_inap = '{$data_penginapan['nama_inap']}',
                           alamat = '{$data_penginapan['alamat']}',
                           cp = '{$data_penginapan['cp']}',
                           wisata = '{$data_penginapan['wisata']}',
                           tarif_jam = '{$data_penginapan['tarif_jam']}'
                        WHERE id_penginapan = '{$data_penginapan['id_penginapan']}'");
             }
            
             if ($update){
                 $this->response(
                     array(
                         "status"    => "success",
                         "result"    => array($data_penginapan),
                         "message"   => $update
                     )
                 );
                }
         }   
     }
    }

    function deletePenginapan($data_penginapan){

        if (empty($data_penginapan['id_penginapan'])){
         $this->response(
             array(
                 "status" => "failed",
                 "message" => "ID penginapan harus diisi"
             )
         );
     } else {
         // Cek apakah ada di database
         $get_penginapan_baseID =$this->db->query("
             SELECT 1
             FROM penginapan
             WHERE id_penginapan = {$data_penginapan['id_penginapan']}")->num_rows();

         if($get_penginapan_baseID > 0){
             
             $get_photo_url =$this->db->query("
             SELECT gambar
             FROM penginapan
             WHERE id_penginapan = {$data_penginapan['id_penginapan']}")->result();
         
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
                     DELETE FROM penginapan
                     WHERE id_penginapan = {$data_penginapan['id_penginapan']}");
                 $this->response(
                     array(
                         "status" => "success",
                         "message" => "Data penginapan dengan ID " .$data_penginapan['id_penginapan']. " berhasil dihapus"
                     )
                 );
             }
         
            } else {
                $this->response(
                    array(
                        "status" => "failed",
                        "message" => "ID penginapan tidak ditemukan"
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


?>