<?php if (!defined('BASEPATH'))exit('No direct script access allowed');


class Language_model extends CI_Model {

    function __construct() {
        parent::__construct();

    }




    function createNewLanguage (){

        $language = html_escape($this->input->post('language'));
        $this->load->dbforge();
        $fields = array(
            $language => array('type' => 'LONGTEXT')
        );
       if($this->dbforge->add_column('language', $fields))
       return true;
       else 
       return false;

    }


    function createNewLanguagePhrase(){

        $page_data['phrase'] = html_escape($this->input->post('phrase'));
        $sql = "select * from language order by phrase_id desc limit 1";
        $return_query = $this->db->query($sql)->row()->phrase_id + 1;
        $page_data['phrase_id'] = $return_query;
        
        if($this->db->insert('language', $page_data))
        return true;
        else
        return false;

    }



    function deleteAlreadyAddedLanguage($param2){

        $language = $param2;
        $this->load->dbforge();
       if( $this->dbforge->drop_column('language', $language))
       return true;
       else
       return false;

    }









}