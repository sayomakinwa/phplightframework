<?php
class FileUpload
{
	private $allowed_types;
	private $max_size;#in bytes
	private $upload_dir;
	private $file_array;

	public function __construct() {
		$this->allowed_types = array('image/gif', 'image/jpeg', 'image/pjpeg', 'image/png');
		$this->max_size = 25 * 1024;#in bytes
		$this->upload_dir = "uploads";
		$this->file_array = array();
	}

	public function setAllowedTypes($types) {
		$this->allowed_types = array();
		foreach ($types as $type) {
			$this->allowed_types[] = $type;
		}
	}

	public function setMaxKbSize($size) {
		$this->max_size = $size * 1024;
	}

	public function setUploadDir($dir) {
		$this->upload_dir = $dir;
	}

	public function setFileField($file) {
		$this->file_array = $file;
	}

	public function fileOK() {
		if ($this->file_array['size'] > 0 && $this->file_array['size'] <= $this->max_size) {
			#sizeOK
			foreach ($this->allowed_types as $type) {
				if ($type == $this->file_array['type']) {
					#typeOK
					return array(true, "");
				}
			}
			return array(false, "Invalid file type (".$this->file_array['type'].")");
		}
		else {
			return array(false, "Invalid file size (".$this->file_array['size'].")");
		}
		
	}

	public function upload($new_name) {
		$file_ok = $this->fileOK();
		if ($file_ok[0]) {
			$ext = explode(".", $this->file_array["name"]);
			$ext = end($ext);
			$new_name = $new_name.".".$ext;
			switch($this->file_array['error']) {
				case 0:
					// move the file to the upload folder and rename it
					$success = move_uploaded_file($this->file_array['tmp_name'], $this->upload_dir.'/'.$new_name);
			
					if ($success)
						return array(true, $new_name);
					else {
						return array(false, "Error uploading file.1");
					}
						
					break;
				case 3:
					return array(false, "Error uploading file.2");
				default:
					return array(false, "System error uploading file. Contact webmaster.");
			}
		}
		else {
			return array(false, $file_ok[1]);
		}
		
	}

}

?>