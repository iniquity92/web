<?php
    defined('BASEPATH') or exit('No Direct script access allowed');
    
    class Thumb_stand_alone extends CI_controller{
        public function __construct(){
            parent::__construct();
        }
        public function index(){
            echo "here!";
            $image_list = array('sexy-monkey_o_900085.jpg');
        
            $img_resize_config = array(
                'image_library' => 'gd2',
                'new_image' => './static/img/thumb',
                'create_thumb' => TRUE,
                'maintain_ratio' => TRUE,
                'width' => 125,
                'height'=>125
            );
            $img_arr_len = count($image_list);
            $i=0;
            while($i < $img_arr_len){
                $img_resize_config['source_image'] = './static/img/'.$image_list[$i];
                $this->load->library('image_lib',$img_resize_config);
                //$this->image_lib->resize();
                if(!$this->image_lib->resize()){
                    echo $this->image_lib->display_errors();
                }
                $i++;
            }
        }
    }
?>