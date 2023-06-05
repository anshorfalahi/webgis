<?php
class Home_model extends CI_Model
{
    public function get_faskes()
        {
            $query =$this->db->get('faskes');
            return $query->result();
        }
}

