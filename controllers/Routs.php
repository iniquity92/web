<?php
    class Routs extends CI_Controller{
        public function __construct(){
            parent::__construct();
            $this->load->helper('url');
        }

        public function index(){
            echo "Welcome to routes <br />";
            echo "where would you like to go from here? <br />";
            echo anchor("routs/keygame","Keygame","title='my keygame'");
            echo "<br />";
            echo anchor("routs/clickgame","Clickgame","title='my clickgame'");
        }
        public function keygame(){
            $this->load->view('keygame');
        }
        public function clickgame(){
            $this->load->view('clickgame');
        }
    }
?>