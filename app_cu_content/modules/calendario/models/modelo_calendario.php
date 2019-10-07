<?php
class modelo_calendario extends CI_Model 
{
    public $table = 'events';
    public $table_id = 'id';
    function __construct(){
        $this->load->helper(array('url','array'));
        $this->load->database();
    }
    /********FULL CALENDAR*********/
    private $evento = 'events';
    function get_event_list(){
        $this->db->select('id,title,start_date, end_date');
        $this->db->from('events');
        $query = $this->db->get();
        if($query){
            return $query->result();
        }
        return NULL;
    }
    function insert($data){
        $this->db->insert('events', $data);
        return $this->db->insert_id();
    }
    function list_all($limit, $offset){
        $id = $this->session->userdata('id');
        $query = $this->db->select()
        ->from('events')
        ->limit($limit, $offset)
        ->get();
        return $query->result();
    }
    function delete_data(){
        $this->db->empty_table('events');
    }
    function num_rows(){
        $query = $this->db->select()
        ->from('events')
        ->get();
        return $query->num_rows();
    }

    
}
