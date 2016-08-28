<?php 
    defined("BASEPATH") or exit("No direct script access required!");
    
    class Admin extends CI_Controller{
        public function __construct(){
            parent::__construct();
            $this->load->library('session');
            $this->load->library('parser');
            $this->load->database();
            $this->load->helper('url');
        }
        public function index(){
            $this->load->view('admin/admin_signin');
        }
        public function signin(){
           // if($this->session->userdata('email')){
                $email = $this->input->post('email');
                $password = $this->input->post('password');
                $this->db->select('admin.admin_id,admin.username,admin.email,admin_passwords.password_admin,admin.role_id');
                $this->db->from('admin');
                $this->db->join('admin_passwords','admin.admin_id=admin_passwords.admin_id');
                $this->db->where('email',$email);
                $query = $this->db->get();
            
                if($query->num_rows()==1){
                    $admin_details = $query->row_array();
                    if(($admin_details['email']==$email)&&($admin_details['password_admin']==$password)){
                        $data = array(
                            'email'=>$email,
                            'admin_id'=>$admin_details['admin_id'],
                            'admin_role'=>$admin_details['role_id'],
                            'admin_username'=>$admin_details['username']
                        );
                        $this->session->set_userdata($data);
                        redirect('/admin/dashboard/');
                    }
                    else{
                        echo "Wrong Username or password. Try <a href='".site_url('admin/index')."'>logging in</a> again";
                    }
                }
                else{
                    echo "Wrong Username or password. Try <a href='".site_url('admin/index')."'>logging in</a> again";
                }
            //}
            //else{
              //  echo "You seem to be in a hurry, go <a href='".site_url('admin/index')."'>here</a> and try login in using an email and password";
            //}
        }
        public function dashboard($arg="dashboard"){
            if($this->session->userdata('email')){
                $ul1 = array('dashboard','reports','analytics','export');
                $ul2 = array('pages','categories','tags','images');
                
                $nav1 = array();
                //$nav2 = array[];
                
                foreach($ul1 as $x){
                    if($arg == $x){
                        $nav1[]=array(
                            "class"=>"active",
                            "uri"=>site_url("admin/dashboard/".$arg),
                            "link_title"=>ucwords($arg),
                        );
                    }
                    else{
                        $nav1[]=array(
                            "class"=>"inactive",
                            "uri"=>site_url("admin/dashboard/".$x),
                            "link_title"=>ucwords($arg),
                        );
                    }
                }
                /*foreach($ul2 as $x){
                    if($arg == $x){
                        nav2[]=array(
                            "class"=>"active",
                            "uri"=>"admin/dashboard/".ucwords($arg),
                        );
                    }
                    else{
                        nav2[]=array(
                            "class"=>"inactive",
                            "uri"=>"admin/dashboard/".ucwords($x),
                        );
                    }
                }*/
                
                $data_view['name']=$this->session->userdata('admin_username');
                $body = $this->load->view("admin/".$arg,$data_view,TRUE);
                $data_parser = array(
                    'title'=>'Admin-Dashboard',
                    'header_title'=>'Dashboard',
                    'body_block'=>$body,
                    'nav1'=>$nav1,
                );
                $this->parser->parse('admin/dashboard_template',$data_parser);
                
                
            }
            else{
                redirect('/admin/index');
            }
        }
    }
?>