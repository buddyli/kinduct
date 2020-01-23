<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Athletes_model extends CI_Model {

    private $athlete = 'athlete';
	
    function get_athlete_list() {
        $query = $this->db->get($this->athlete);
        if ($query) {
            return $query->result();
        }
        return NULL;
    }

    function get_athlete($id) {
        $query = $this->db->get_where($this->athlete, array("id" => $id));
        if ($query) {
            return $query->row();
        }
        return NULL;
    }
	
    function add_athlete($athlete_name, $athlete_age, $athlete_city, $athlete_province, $athlete_country) {
        $data = array('name' => $athlete_name, 'age' => $athlete_age, 'city' => $athlete_city, 'province' => $athlete_province, 'country' => $athlete_country);
        $this->db->insert($this->athlete, $data);
    }

    function update_athlete($athlete_name, $athlete_age, $athlete_city, $athlete_province, $athlete_country) {
        $data = array('name' => $athlete_name, 'age' => $athlete_age, 'city' => $athlete_city, 'province' => $athlete_province, 'country' => $athlete_country);
        $this->db->where('id', $athlete_id);
        $this->db->update($this->athlete, $data);
    }
	
    function delete_athlete($athlete_id) {
        $this->db->where('id', $athlete_id);
        $this->db->delete($this->athlete);
    }

}