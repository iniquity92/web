<?php 
    defined('BASEPATH') OR exit('No direct script access allowed');

    class Queries extends CI_Controller{
        public function __construct(){
            parent::__construct();
            $this->load->database();
            
        }
        
        public function livesearch(){
            $arg = $this->input->get('word');
            $this->db->select('word');
            $this->db->from('words');
            $this->db->like('word',$arg);
            $query=$this->db->get();
            $i = 0;
            $data = array();
            foreach($query->result_array() as $row){
                $data[$i] = $row['word'];
                $i++;
            }
            echo json_encode($data);
        }

        public function submit(){
            $arg = $this->input->get('word');
            $values = array(
                'word'=>$arg,
                'frequency'=>1
            );
            $this->db->insert('words',$values);
        }

        public function plusOne(){
            $arg = $this->input->get('word');
            $this->db->set('frequency','frequency+1',FALSE);
            $this->db->where('word',$arg);
            $this->db->update('words');
        }
    }
?>