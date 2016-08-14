<?php
    defined('BASEPATH') OR exit('No direct script access allowed');

    class Editor extends CI_Controller{
        public function __construct(){
            parent::__construct();
            $this->load->helper('url');
            $this->load->database();
        }
        public function image_browser($editorInstance,$callbackFuncRef,$langCode){
            $this->load->library('parser');
            
            $this->db->select('url, name');
            $this->db->from('images');
            $query = $this->db->get();
            
            $gallery = array();
            foreach($query->result_array() as $row){
                $gallery[] = array(
                    'class'=>'col-sm-2',
                    'img_url' => $row['url'],
                    'name' => $row['name'],
                    'thumb_img_url' => preg_replace("/(.*img)\/([\w\d]+)\.(\w+)/","$1/thumb/$2_thumb.$3",$row['url'])
                );               
            }
            $query->free_result();
            
            $data = array('gallery'=>$gallery); 
            
            
            $this->parser->parse('browser',$data);
            
            //echo $editorInstance,$callbackFuncRef,$langCode;
            
        }
        public function image_upload($editorInstance,$callbackFuncRef,$lagCode){
            
            $data = array(
                        'url'=>base_url('/static/img')."/".$_FILES['upload']['name'],
                        'name'=>$_FILES['upload']['name'],
                        'type'=>$_FILES['upload']['type'],
                        'added_on'=> date('Y-m-d H:i:s'),
                        'modified_on'=>date('Y-m-d H:i:s'),
                        'size'=>$_FILES['upload']['size']
            );
            
            $config['upload_path'] = './static/img/';
            $config['allowed_types'] = 'jpeg|jpg|gif|png';
            $config['max_size']='1024';
            /*$config['max_height']='300';
            $config['max_width']='300';*/
            
            $this->load->library('upload',$config);
            
            if(!$this->upload->do_upload('upload')){
                $error = array('error'=>$this->upload->display_error());
            }
            else{
                
                $this->db->insert('images',$data);
                
                $img_resize_config = array(
                    'image_library' => 'gd2',
                    'source_image' => './static/img/'.$_FILES['upload']['name'],
                    'new_image' => './static/img/thumb',
                    'create_thumb' => TRUE,
                    'maintain_ratio' => TRUE,
                    'width' => 125,
                    'height'=>125
                );
                $this->load->library('image_lib',$img_resize_config);
                $this->image_lib->resize();
            }
            
            echo "<script type='text/javascript'>window.parent.CKEDITOR.tools.callFunction($callbackFuncRef,".$data['url'].");</script>";
                    
            
            
            //print_r($_FILES);
            //echo "<script type='text/javascript'>window.parent.CKEDITOR.tools.callFunction($callbackFuncRef, '$url',);</script>";
        
       }
    }

/* This controller was created to implement a browser and uploader for ckedit.*/
?>
