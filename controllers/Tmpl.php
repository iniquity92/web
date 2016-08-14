<?php
    class Tmpl extends CI_Controller{
        public function __construct(){
            parent::__construct();
            $this->load->library('parser');
            $this->load->database();
        }

        public function index(){
           
            $tag_ar = array();
            $this->db->select('word');
            $this->db->from('words');
            $this->db->limit(4);
            $query = $this->db->get();
            
            $cat_ar = array();
            $this->db->select('category');
            $this->db->from('categories');
            $cat_query = $this->db->get();

            $i = 0;
            $j=0;
            foreach ($query->result_array() as $row) {
                $tag_ar[$i] = "<strong class='frequent-tags'>".$row['word']."</strong>";
                $i++;
            }
            foreach($cat_query->result_array() as $row){
                $cat_ar[$j]=$row['category'];
                $j++;
            }
            $query->free_result();
            $cat_query->free_result();
            $data['frequently_used_tags'] = $tag_ar;
            $data['frequently_used_categories'] = $cat_ar;
            $body = $this->load->view('editor',$data,TRUE);
            $data = array(
                'title' => 'Pages-Dashboard',
                'header_title'=>'Pages-Dashboard',
                'body_block' => $body
            );
            $this->parser->parse('tmpl',$data);
        }

        public function fetch(){
            $arg = $this->input->get('tags');
            $tag_ar = array();
            $i = 0; 
            $this->db->select('word');
            $this->db->from('words');
            $this->db->like('word',$arg);
            $query = $this->db->get();

            foreach($query->result_array() as $row){
                $tag_ar[$i] = $row['word'];
                $i++;
            }

            echo json_encode($tag_ar);
        }

        public function new_tag(){
            $arg = $this->input->get('tags');
            $values = array(
                'word'=>$arg,
                'frequency'=>1
            );
            $this->db->insert('words',$values);
        }
        
        // have to complete the editordb function //
        //function commented out because some of the components needed to work with this//
        //are still not created//
        public function editordb(){
            $title = $this->input->post('title');
            $mytext = $this->input->post('mytext');
            $keywords = $this->input->post('keywords');
            $description = $this->input->post('description');
            $tags = $this->input->post('tags');
            $categories = $this->input->post('categories');
            
            
        }
    }
?>