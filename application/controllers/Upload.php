<?php
defined('BASEPATH') OR exit('No direct script access allowed');

header('Access-Control-Allow-Origin: *');

class Upload extends CI_Controller {

	function __construct() {
        parent::__construct();
		$this->load->model('athletes_model', 'athm');
    }

	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 * 		http://example.com/index.php/welcome
	 *	- or -
	 * 		http://example.com/index.php/welcome/index
	 *	- or -
	 * Since this controller is set as the default controller in
	 * config/routes.php, it's displayed at http://example.com/
	 *
	 * So any other public methods not prefixed with an underscore will
	 * map to /index.php/welcome/<method_name>
	 * @see https://codeigniter.com/user_guide/general/urls.html
	 */
	public function index()
	{
		$target_dir = "/uploads/";
		$target_file = $target_dir.basename($_FILES["fileToUpload"]["name"]);
		$target_full_path = realpath(dirname(dirname(__FILE__))).$target_file;
		echo $target_full_path;

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

		$url = "http://localhost:3000/";
		$statusCode = 302;
		header('Location: ' . $url, true, $statusCode);
		die();
	}
}
