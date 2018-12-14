<?php
use Restserver\Libraries\REST_Controller;
require APPPATH . 'libraries/REST_Controller.php';
require APPPATH . 'libraries/Format.php';

class Rest_travel extends REST_Controller {

   // show data travel
   function biro_get() {
       $get_biro = $this->db->query("SELECT b.id_biro, b.id_kecamatan, b.nama_biro, b.alamat, b.cp, b.wisata FROM kecamatan, biro b, wisata Where b.id_kecamatan=kecamatan.id_kec AND b.wisata=wisata.id_wisata")->result();
     
       $this->response(array("status"=>"success","result" => $get_biro));
   }

   // insert travel
   function biro_post() {
       $data_biro = array(
           'id_biro'   => $this->post('id_biro'),
           'id_kecamatan'     => $this->post('id_kecamatan'),
           'nama_biro'   => $this->post('nama_biro'),
           'alamat'    => $this->post('alamat'),
           'cp'    => $this->post('cp'),
           'wisata'    => $this->post('wisata')
           );
      
       if  (empty($data_biro['id_biro'])){
            $this->response(array('status'=>'fail',"message"=>"id_biro kosong"));
       }
       else {
           $getId = $this->db->query("Select id_biro from biro where id_biro='".$data_biro['id_biro']."'")->result();
          
           //jika id_biro tidak ada dalam database maka eksekusi insert
           if (empty($getId)){
                    if (empty($data_biro['id_kecamatan'])){
                       $this->response(array('status'=>'fail',"message"=>"id_kecamatan kosong"));
                    }
                    else if(empty($data_biro['nama_biro'])){
                       $this->response(array('status'=>'fail',"message"=>"nama_inap kosong"));
                    }else if(empty($data_biro['alamat'])){
                       $this->response(array('status'=>'fail',"message"=>"alamat kosong"));
                    }else if(empty($data_biro['cp'])){
                       $this->response(array('status'=>'fail',"message"=>"cp kosong"));
                    }else if(empty($data_biro['wisata'])){
                       $this->response(array('status'=>'fail',"message"=>"wisata kosong"));
                    }
                    else{
                       //jika masuk pada else atau kondisi ini maka dipastikan seluruh input telah di set
                       //jika akan melakukan penambahan wisata id_kecamatan dan id_wisata harus dipastikan ada
                       $message="";
                       $getIdKecamatan = $this->db->query("Select id_kec from kecamatan Where id_kec='".$data_biro['id_kecamatan']."'")->result();
                       $getIdWisata = $this->db->query("Select id_wisata from wisata Where id_wisata='".$data_biro['wisata']."'")->result();
                       $message="";
                       if (empty($getIdKecamatan)) $message.="id_kecamatan tidak ada/salah ";
                       if (empty($getIdWisata)) {
                           if (empty($message)) {
                               $message.="id_wisata tidak ada/salah";
                           }
                           else {
                               $message.="dan id_wisata tidak ada/salah";
                           }
                       }
                       if (empty($message)){
                           $insert= $this->db->insert('biro',$data_biro);
                           if ($insert){
                               $this->response(array('status'=>'success','result' => $data_biro,"message"=>$insert));   
                           }
                          
                       }else{
                           $this->response(array('status'=>'fail',"message"=>$message));   
                       }
                      
                    }
           }else{
               $this->response(array('status'=>'fail',"message"=>"id_biro sudah ada"));
           }  
       }
   }

   // update data biro
   function biro_put() {
       $data_biro = array(
                   'id_biro'    => $this->put('id_biro'),
                   'id_kecamatan'      => $this->put('id_kecamatan'),
                   'nama_biro'    => $this->put('nama_biro'),
                   'alamat'     => $this->put('alamat'),
                   'cp'     => $this->put('cp'),
                   'wisata'        => $this->put('wisata')
                   );
       if  (empty($data_biro['id_biro'])){
            $this->response(array('status'=>'fail',"message"=>"id_biro kosong"));
       }else{
           $getId = $this->db->query("Select id_biro from biro where id_biro='".$data_biro['id_biro']."'")->result();
           //jika id_biro harus ada dalam database
           if (empty($getId)){
             $this->response(array('status'=>'fail',"message"=>"id_biro tidak ada/salah")); 
           }else{
               //jika masuk disini maka dipastikan id_biro ada dalam database
                if (empty($data_biro['id_kecamatan'])){
                   $this->response(array('status'=>'fail',"message"=>"id_kecamatan kosong"));
                }
                else if(empty($data_biro['nama_biro'])){
                   $this->response(array('status'=>'fail',"message"=>"nama_inap kosong"));
                }else if(empty($data_biro['alamat'])){
                   $this->response(array('status'=>'fail',"message"=>"alamat kosong"));
                }else if(empty($data_biro['cp'])){
                   $this->response(array('status'=>'fail',"message"=>"cp kosong"));
                }else if(empty($data_biro['wisata'])){
                   $this->response(array('status'=>'fail',"message"=>"wisata kosong"));
                }
                else{
                   //jika masuk pada else atau kondisi ini maka dipastikan seluruh input telah di set
                   //jika akan melakukan edit penambahan wisata id_kecamatan harus dipastikan ada
                   $message="";
                   $getIdKecamatan = $this->db->query("Select id_kec from kecamatan Where id_kec='".$data_biro['id_kecamatan']."'")->result();
                   $getIdWisata = $this->db->query("Select id_wisata from wisata Where id_wisata='".$data_biro['wisata']."'")->result();

                   if (empty($getIdKecamatan)) $message.="id_kecamatan tidak ada/salah ";
                    if (empty($getIdWisata)) {
                       if (empty($message)) {
                           $message.="id_wisata tidak ada/salah";
                       }
                       else {
                           $message.="dan id_wisata tidak ada/salah";
                       }
                   }
                   if (empty($message)){
                       $this->db->where('id_biro',$data_biro['id_biro']);
                       $update= $this->db->update('biro',$data_biro);
                       if ($update){
                           $this->response(array('status'=>'success','result' => $data_biro,"message"=>$update));
                       }
                      
                   }else{
                       $this->response(array('status'=>'fail',"message"=>$message));   
                   }
                }
           }

       }
   }

   // delete biro
   function biro_delete() {
       $id_biro = $this->delete('id_biro');
       if (empty($id_biro)){
           $this->response(array('status' => 'fail', "message"=>"id_biro harus diisi"));
       } else {
           $this->db->where('id_biro', $id_biro);
           $delete = $this->db->delete('biro');  
           if ($this->db->affected_rows()) {
               $this->response(array('status' => 'success','message' =>"Berhasil delete dengan id_biro ".$id_biro));
           } else {
               $this->response(array('status' => 'fail', 'message' =>"id_biro tidak dalam database"));
           }
       }
   }
}  

?>