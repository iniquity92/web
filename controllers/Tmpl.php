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
            $this->db->select('id,category');
            $this->db->from('categories');
            $cat_query = $this->db->get();

            $i = 0;
            $j=0;
            foreach ($query->result_array() as $row) {
                $tag_ar[$i] = "<strong class='frequent-tags'>".$row['word']."</strong>";
                $i++;
            }
            foreach($cat_query->result_array() as $row){
                $cat_ar[$row['id']]=$row['category'];
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
            $article_id;
            $title = $this->input->post('title');
            $mytext = $this->input->post('mytext');
            $keywords = $this->input->post('keywords');
            $description = $this->input->post('description');
            $tags = $this->input->post('tags');
            $category = $this->input->post('categories');
            /* check if a row already exists for the given title */
            $this->db->select('article_id,title');
            $this->db->from('articles');
            $this->db->where('title',$title);
            $query = $this->db->get();
            /* if there's no row in the db that has the current title add the article to the db.*/
            if(!$query->num_rows()){
                /* inserting the article in the db */
                $data_articles = array('title'=>$title,'mytext'=>$mytext,'description'=>$description,'category'=>$category);
                $this->db->insert('articles',$data);
                /* retrieving the article_id for the recently added article */
                $this->db->select('article_id');
                $this->db->from('articles');
                $this->db->where('title',$title);
                $get_article_id = $this->db->get();
                
                if(isset($row = $get_article_id->row())){
                    $article_id = $row['article_id'];
                }
                /*passing the tags array to the function get_tag_or_keyword_id() because returning an array is faster than returning ids for individual elements of the tags array*/
                $tag_id_arr = get_tag_or_keyword_id($tags,'words'); 
                /*adding the tags to the tags to articles relation using foreach */
                $data_tags_to_articles['article_id']=$article_id;
                
                foreach($tag_id_arr as $word=>$id){
                    
                        $data_tags_to_articles['tag_id']=$id;
                        $this->db->insert('tags_to_articles',$data_tags_to_articles);
                }
                /*#1 we are getting the ids of all the words in the keywords array
                  #2 we initialized the array that will contain the data for the insert command.
                  #3 we use the foreach loop to iterate through every keyword=>id pair.
                  #4 we insert the keyword_id and article_id references in the keywords_to_articles table
                */
                $keywords_id_arr = get_tag_or_keyword_id($keywords,'keywords'); //#1
                $data_keywords_to_articles['article_id']=$article_id;//#2
                foreach($keywords_id_arr as $word=>$id){ //#3
                    $data_keywords_to_articles['keyword_id']=$id;
                    $this->db->insert('keywords_to_articles',$data_keywords_to_articles); //#4
                }
            }
            else{
                
            }
        }
        public function get_tag_or_keyword_id($words_arr,$table){
            $object = ($table=='words')?'id':'keyword_id'; /* to specify what do we have to select from the specified table, if the table is words we are going to select id, else we are going to select keyword_id*/
            
            $id_arr = array(); /* initializing the array that is going to get all the ids*/
            
            foreach($words_arr as $word){
                $this->db->select($object);
                $this->db->from($table);
                $this->db->where('word',$word); 
                $query = $this->db->get();
                /* the above four lines are equivalent to 
                    $query = SELECT id/keyword_id FROM words/keywords WHERE word='$word';
                    
                    columns in words table : id, word, frequency;
                    columns in keywords table : keyword_id, word, frequency;
                */
                /*if the above query returns a row containing the id of the word just supplied it will be added to the id_arr indexed by the word itself as the key, else insert the word for which no id was found, in the table, and initialize the frequency with 1. Thenw we call the get_tag_or_keyword_id() function recurssively with the word passed as an array; array($word). */
                if(isset($row=$query->row())){
                    $id_arr[$word]=$row[$object]; 
                }
                else{
                    $data = array('word'=>$word,'frequency'=>1);
                    $this->db->insert($table,$data);
                    $id_temp = get_tag_or_keyword_id(array($word),$table); /*id_temp gets the assoc array ($word=>$id) */
                    $id_arr[$word] = $id_temp[$word]; /*assigning the content of $id_temp to $id_arr indexed by the $word*/
                    
                }
                //freeing the query variable
                $query->free_result();
            }
            return $id_arr;
        }
    }
?>