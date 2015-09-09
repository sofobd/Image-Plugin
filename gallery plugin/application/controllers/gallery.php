<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Gallery extends CI_Controller {

	/**
	 * Image gallery controller.
	 * Image upload, resize, crop, rotate functionality with listing and delete features
	 * Author A F M Salah Uddin Sumon
	 * Author email: tsumon@gmail.com
	 */ 
	 
	function __construct()
	{
		parent::__construct();	
		$this->load->library('image_lib');	 
	}
	 
	/**
	 * Initiate Image upload form
	 * Also have the Manipulation paremeter select option
	 */
	public function index()
	{
		$this->load->view('image_upload');
	}
	
	
	 /**
	  * Perform manipuation on image ("crop","resize","rotate","watermark".)
	  */
	 public function maniputation(){
		 
		 if ($this->input->post("submit")) {
			 // Use "upload" library to store the original image in the "uploads" folder.
			 $config = array(
			 'upload_path' => "uploads/",
			 'upload_url' => base_url() . "uploads/",
			 'allowed_types' => "gif|jpg|png|jpeg"
			 );
			 
			 $this->load->library('upload', $config);
			 
			 if ($this->upload->do_upload()) {
			 //If image upload in folder, set all image info in "$image_data".
			 $image_data = $this->upload->data();
			 }else{
				//$error = array('error' => $this->upload->display_errors());
				die($this->upload->display_errors()); 
			 }
			 
			 switch ($this->input->post("imgMode")) {
				 
				 case "resize":
				 	//to receive multiple size from user
				 	$width = explode( ',',$this->input->post('width')); 
					$height = explode( ',',$this->input->post('height'));
					
					for($i=0;$i < count($width);$i++){ //create multiple image for multiple inputed height-width
				 	$img = (int)$width[$i].'_'.(int)$height[$i].'_'.$image_data['file_name'];
					//define config parameters
			 		$config['image_library'] = 'gd2';
					$config['source_image'] = $image_data['full_path'];
					$config['new_image'] = './uploads/thumb_' . $img;
					$config['width'] = (int)$width[$i];
					$config['height'] = (int)$height[$i];
					
					//send config array to image_lib's to initiate function
					$this->image_lib->initialize($config);
					$src = $config['new_image'];
					$data['selectedOption'] = 'resize';
					$data['img_src'][$i] = base_url() . substr($src, 2);

					// Call resize function
					$this->image_lib->resize();
					}
			 	  break;
				  
				  case "rotate":
				  	$img = $image_data['file_name'];
					//define config parameters
					$config['image_library'] = 'gd2';
					$config['source_image'] = $image_data['full_path'];
					$config['rotation_angle'] = $this->input->post('degree');
					$config['new_image'] = './uploads/rot_'. $this->input->post('degree') . '_' . $img;
					
					//send config array to image_lib's to initiate function
					$this->image_lib->initialize($config);
					$src = $config['new_image'];
					$data['selectedOption'] = 'rotate';
					$data['img_src'][0] = base_url() . substr($src, 2);
					// Call rotate function
					$this->image_lib->rotate();
				  break;
				  
				  case "crop":
				  	$img = $image_data['file_name'];
					//define config parameters
					$config['image_library'] = 'gd2';
					$config['source_image'] = $image_data['full_path'];
					$config['x_axis'] = $this->input->post('x1');
					$config['y_axis'] = $this->input->post('y1');
					$config['width'] = $this->input->post('cwidth');
					$config['height'] = $this->input->post('cheight');
					$config['new_image'] = './uploads/crop_' . $img;
					
					//send config array to image_lib's  initialize function
					$this->image_lib->initialize($config);
					$src = $config['new_image'];
					$data['selectedOption'] = 'crop';
					$data['img_src'][0] = base_url() . substr($src, 2);
					// Call crop function in image library.
					$this->image_lib->crop();
				  break;
				  
				  case "waterMark":
				  	$img = $image_data['file_name'];
					//define config parameters
					$config['image_library'] = 'gd2';
					$config['source_image'] = $image_data['full_path'];
					$config['wm_text'] = $this->input->post('watermark_text');
					$config['wm_type'] = 'text';
					$config['wm_font_path'] = './system/fonts/texb.ttf';
					$config['wm_font_size'] = '50';
					$config['wm_font_color'] = '#CC0000';
					$config['wm_vrt_alignment'] = 'middle';
					$config['wm_hor_alignment'] = 'center';
					$config['new_image'] = './uploads/watermark_' . $img;
					
					//send config array to image_lib's  initialize function
					$this->image_lib->initialize($config);
					$src = $config['new_image'];
					$data['selectedOption'] = 'waterMark';
					$data['img_src'][0] = base_url() . substr($src, 2);
					// Call watermark function in image library.
					$this->image_lib->watermark();
				  break;
				  
				  default:
				  //default an warning message to select an option
				  $data["msg"] = "Please select an option for manipulation";
				  break;
			 }
			 
			 ///Display result
			$this->load->view('image_upload', $data);
		 }
		 
	 }
	
	/**
	  * List all Images of the given directory 
	  */
	public function image_list($msg = ''){
		//initiate directory helper
		$this->load->helper('directory');
		//retrive all the file names in a array of given directory
		$data['files'] = directory_map('./uploads/', 1); //only map the root directory not any sub folder
		$data["msg"] = $msg;
		//Display result
		$this->load->view('image_list',$data);
	}
	
	/**
	  * Delete selected images (multiple at a time) 
	  */
	public function img_delete(){
		//get the selected files name
		$img_files = $this->input->post('img_files');
		//initiate file helper
		$this->load->helper('file');
		
		foreach($img_files as $fileName){
			//delete files one after another
			if(unlink('./uploads/'.$fileName))
			$msg = 'Successfully deleted!';
			else
			$msg = 'Not deleted!';
		}
		//call a member function to Display result
		$this->image_list($msg);
	}
}

/* End of file gallery.php */
/* Location: ./application/controllers/gallery.php */