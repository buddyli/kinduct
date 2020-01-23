<?php
use chriskacerguis\RestServer\RestController;

defined('BASEPATH') OR exit('No direct script access allowed');

header('Access-Control-Allow-Origin: *');

if($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
	header('Access-Control-Allow-Methods: GET, PUT, POST, DELETE, OPTIONS');
    header('Access-Control-Allow-Headers: Content-Type');
	exit;
}

class AthletesRestController extends RestController {
	
	function __construct() {
        parent::__construct();
		$this->load->model('athletes_model', 'athm');
    }
    
    // Grab all athletes and show in front end.
	function athletes_get() {
        $athletes = $this->athm->get_athlete_list();

        if ($athletes) {
            $this->response($athletes, 200);
        } else {
            $this->response(array(), 200);
        }
    }

    // Grab one record by id
    function athlete_get() {
        if (!$this->get('id')) { //query parameter, example, athletes?id=1
            $this->response(NULL, 400);
        }

        $athlete = $this->athm->get_athlete($this->get('id'));

        if ($athlete) {
            $this->response($athlete, 200); // 200 being the HTTP response code
        } else {
            $this->response(array(), 500);
        }
    }
	
	function add_athlete_post() {
        $athlete_name = $this->post('name');
        $athlete_age = $this->post('age');
        $athlete_city = $this->post('city');
        $athlete_province = $this->post('province');
        $athlete_country = $this->post('country');
        
        $result = $this->athm->add_athlete($athlete_name, $athlete_age, $athlete_city, $athlete_province, $athlete_country);

        if ($result === FALSE) {
            $this->response(array('status' => 'failed'), 500);
        } else {
            $this->response(array('status' => 'success'), 200);
        }
    }

    function update_athlete_put() {
        $athlete_id = $this->put('id');
        $athlete_name = $this->put('name');
        $athlete_age = $this->put('age');
        $athlete_city = $this->put('city');
        $athlete_province = $this->put('province');
        $athlete_country = $this->put('country');

        $result = $this->athm->update_athlete($athlete_id, $athlete_name, $athlete_age, $athlete_city, $athlete_province, $athlete_country);

        if ($result === FALSE) {
            $this->response(array('status' => 'failed'), 500);
        } else {
            $this->response(array('status' => 'success'), 200);
        }
    }

    function upload_athlete_post() {
        $target_dir = "/uploads/";
		$target_file = $target_dir.basename($_FILES["fileToUpload"]["name"]);
		$target_full_path = realpath(dirname(dirname(__FILE__))).$target_file;
		print($target_full_path);

		$uploadOk = 1;
		$imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));

		// Check if $uploadOk is set to 0 by an error
		if ($uploadOk == 0) {
			echo "Sorry, your file was not uploaded.";
		// if everything is ok, try to upload file
		} else {
			if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_full_path)) {
				$data = file_get_contents($target_full_path); 
				//Convert JSON string into PHP array format
				$data_array = json_decode($data, true);
				
				foreach($data_array["Players"] as $row){
					$athlete_name = $row["Name"];
					$athlete_age = $row["Age"];
					$athlete_city = $row["Location"]["City"];
					$athlete_province = $row["Location"]["Province"];
					$athlete_country = $row["Location"]["Country"];

        			$result = $this->athm->add_athlete($athlete_name, $athlete_age, $athlete_city, $athlete_province, $athlete_country);
				}
				echo "The file ". basename( $_FILES["fileToUpload"]["name"]). " has been uploaded.";
			} else {
				echo "Sorry, there was an error uploading your file.";
			}
		}

        $this->response(array('status' => 'success'), 200);
    }
	
	function delete_athlete_delete($athlete_id) { //path parameter, example, /delete/1
        $result = $this->athm->delete_athlete($athlete_id);
    
        if ($result === FALSE) {
            $this->response(array('status' => 'failed'), 500);
        } else {
            $this->response(array('status' => 'success'), 200);
        }
    }

}