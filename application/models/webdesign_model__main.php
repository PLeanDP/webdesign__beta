<?php
class Webdesign_model__main extends CI_Model {

	public function __construct()
		{
		parent::__construct();
		$this->load->database();
		}

	
	public function chosen_designer__sub()
		{
		$valid = $this->webdesign_model__main->chosen_designer__validate();

		if ($valid == 1)
			{
			$this->webdesign_model__main->chosen_designer__to_db();
			return 1;
			}
		else
			{
			return $valid;
			}
		}


	public function chosen_designer__to_db()
		{
		
		$data = array(
			'name' => $this->input->post('cl_name'),
			'location' => $this->input->post('cl_loc'),
			'contact_no' => $this->input->post('cl_num'),
			'email_add' => $this->input->post('cl_email'),
			'designer_id' => $this->input->post('des')
			);

		return $this->db->insert('request', $data);
		}


	public function	chosen_designer__validate()
		{
		$this->load->helper('form');
		$this->load->library('form_validation');

		$this->form_validation->set_rules('cl_name', 'Name', 'required');
		$this->form_validation->set_rules('cl_loc', 'City/Location', 'required');
		$this->form_validation->set_rules('cl_num', 'Contact number', 'required');
		$this->form_validation->set_rules('cl_email', 'Email address', 'required|valid_email');
		$this->form_validation->set_rules('des', 'Designers', 'required');
	
		if( $this->form_validation->run() == 1 )
			{
			return 1;
			} 
		else
			{
			$validation_errors = "";
			
			if (form_error('cl_name') !== "")
				{
				$validation_errors .=  "-" . form_error('cl_name') . "0";
				}
			if (form_error('cl_loc') !== "")
				{
				$validation_errors .=  "-" . form_error('cl_loc') . "0";
				}
			if (form_error('cl_num') !== "")
				{
				$validation_errors .=  "-" . form_error('cl_num') . "0";
				}
			if (form_error('cl_email') !== "")
				{
				$validation_errors .=  "-" . form_error('cl_email') . "0";
				}
			if (form_error('des') !== "")
				{
				$validation_errors .=  "-" . form_error('des') . "0";
				}
 
		
			$validation_errors = $this->webdesign_model__main->form_validation__string_convert("in",$validation_errors);

			return $validation_errors;

			}

		}



	public function	form_validation__string_convert($convert_to, $validation_string)
		{
		switch($convert_to)
			{
			case 'in':
				// converts <p> to NULL
				$validation_string = explode("<p>",$validation_string);
				$validation_string = implode("",$validation_string);
				// converts </p> to NULL
				$validation_string = explode("</p>",$validation_string);
				$validation_string = implode("",$validation_string);
				// converts / 
				$validation_string = explode("/",$validation_string);
				$validation_string = implode(" or ",$validation_string);	
				// converts spaces to _ 
				$validation_string = explode(" ",$validation_string);
				$validation_string = implode("_",$validation_string);	
				// converts %2 to _ 
				$validation_string = explode("%20",$validation_string);
				$validation_string = implode("_",$validation_string);	
				
				return $validation_string;
				break;
			case 'out':
				// converts - to <li>
				$validation_string = explode("-",$validation_string);
				$validation_string = implode("<li>",$validation_string);
				// converts 0 to </li>
				$validation_string = explode("0",$validation_string);
				$validation_string = implode("</li>",$validation_string);
				// converts _ to space
				$validation_string = explode("_",$validation_string);
				$validation_string = implode(" ",$validation_string);
				// converts %2 to space
				$validation_string = explode("%20",$validation_string);
				$validation_string = implode(" ",$validation_string);
				// converts %2 to space
				$validation_string = explode("%2",$validation_string);
				$validation_string = implode(" ",$validation_string);	
				return $validation_string;
				break;
			}
		}








	public function	new_designer__sub()
		{
		$valid = $this->webdesign_model__main->new_designer__validate();

		if ($valid == 1)
			{
			$id = $this->webdesign_model__main->new_designer__to_db__p1();
			$this->webdesign_model__main->new_designer__to_db__p2($id);
			$this->webdesign_model__main->new_designer__to_db__p3($id);
			return 1;
			}
		else
			{
			return $valid;
			}
		}




	public function new_designer__validate()
		{
		$fname = $this->input->post('nd_fname');
		$mname = $this->input->post('nd_mname');
		$lname = $this->input->post('nd_lname');	
		$username = $this->input->post('nd_username');

		$def_string = "";		

		$valid_name = $this->webdesign_model__main->new_designer__validate__name();
		$valid_username = $this->webdesign_model__main->new_designer__validate__username();
		$valid_post = $this->webdesign_model__main->new_designer__validate__post();
		
		if ($valid_post == 1)
			{
			if ($valid_name == 0)
				{
				$def_string .= "-Name " . $fname ." ". $mname ." ". $lname . " already in use0";	
				}
			if ($valid_name == 0)
				{
				$def_string .= "-Username ". $username ." already in use0";	
				}

			if ( ($valid_name == 1) AND ($valid_username == 1) )
				{
				return 1;
				}
			else
				{
				return $def_string;
				}
			}
		else
			{
			$validation_errors = $this->webdesign_model__main->form_validation__string_convert("in",$def_string);
			return $valid_post;
			}

		


		
		}



	public function new_designer__validate__post()
		{
		$this->load->helper('form');
		$this->load->library('form_validation');

		$this->form_validation->set_rules('nd_fname', 'First name', 'required');
		$this->form_validation->set_rules('nd_mname', 'Middle name', 'required');
		$this->form_validation->set_rules('nd_lname', 'last name', 'required');

		$this->form_validation->set_rules('nd_loc', 'City/Location', 'required');
		$this->form_validation->set_rules('nd_num', 'Contact number', 'required');
		$this->form_validation->set_rules('nd_email', 'Email address', 'required|valid_email');
		
		$this->form_validation->set_rules('nd_username', 'Username', 'required');
		$this->form_validation->set_rules('nd_password', 'Password', 'required');

		//$this->form_validation->set_rules('nd_site_shot_1', 'site preview', 'required');

		if( $this->form_validation->run() == 1 )
			{
			return 1;
			} 
		else
			{
			$validation_errors = "";

			if (form_error('nd_fname') !== "")
				{
				$validation_errors .=  "-" . form_error('nd_fname') . "0";
				}
			if (form_error('nd_mname') !== "")
				{
				$validation_errors .=  "-" . form_error('nd_mname') . "0";
				}
			if (form_error('nd_lname') !== "")
				{
				$validation_errors .=  "-" . form_error('nd_lname') . "0";
				}
			if (form_error('nd_loc') !== "")
				{
				$validation_errors .=  "-" . form_error('nd_loc') . "0";
				}
			if (form_error('nd_num') !== "")
				{
				$validation_errors .=  "-" . form_error('nd_num') . "0";
				}
			if (form_error('nd_email') !== "")
				{
				$validation_errors .=  "-" . form_error('nd_email') . "0";
				}
			if (form_error('nd_username') !== "")
				{
				$validation_errors .=  "-" . form_error('nd_username') . "0";
				}
			if (form_error('nd_password') !== "")
				{
				$validation_errors .=  "-" . form_error('nd_password') . "0";
				}
 			/*if (form_error('nd_site_shot_1') !== "")
				{
				$validation_errors .=  "-" . form_error('nd_site_shot_1') . "0";
				}*/

			$validation_errors = $this->webdesign_model__main->form_validation__string_convert("in",$validation_errors);

			return $validation_errors;
			}
		}

	public function new_designer__validate__name()
		{
		$fname = $this->input->post('nd_fname');
		$mname = $this->input->post('nd_mname');
		$lname = $this->input->post('nd_lname');		

		$this -> db -> select('des_id');
		$this -> db -> from('DESIGNER');
		$this -> db -> where('des_fname', $fname);
		$this -> db -> where('des_lname', $mname);
		$this -> db -> where('des_lname', $lname);
		$this -> db -> limit(1);

		$query = $this -> db -> get();

		if($query -> num_rows() >= 1)
			{
			return 0;
			}
		else
			{
			return 1;
			}
		}
	public function new_designer__validate__username()
		{
		$username = $this->input->post('nd_username');	

		$this -> db -> select('des_id');
		$this -> db -> from('DESIGNER_ACCOUNT');
		$this -> db -> where('des_username', $username);
		$this -> db -> limit(1);

		$query = $this -> db -> get();

		if($query -> num_rows() >= 1)
			{
			return 0;
			}
		else
			{
			return 1;
			}
		}













	public function new_designer__to_db__p1()
		{
		$data = array(
			'des_fname' => $this->input->post('nd_fname'),
			'des_mname' => $this->input->post('nd_mname'),
			'des_lname' => $this->input->post('nd_lname'),
			'des_contact_no' => $this->input->post('nd_num'),
			'des_email_add' => $this->input->post('nd_email'),
			'des_location' => $this->input->post('nd_loc'),
			'des_status' => $this->input->post('0')
			);

		$this->db->insert('DESIGNER', $data);
		
		$the_new_id = $this->webdesign_model__main->new_designer__get_id();
		
		return $the_new_id;
		}

	public function	new_designer__get_id()
		{
		$fname = $this->input->post('nd_fname');
		$mname = $this->input->post('nd_mname');
		$lname = $this->input->post('nd_lname');		
		$contact_num = $this->input->post('nd_num');
		$e_add = $this->input->post('nd_email');
		$location = $this->input->post('nd_loc');

		$this -> db -> select('des_id');
		$this -> db -> from('DESIGNER');
		$this -> db -> where('des_fname', $fname);
		$this -> db -> where('des_mname', $mname);
		$this -> db -> where('des_lname', $lname);
		$this -> db -> where('des_contact_no', $contact_num);
		$this -> db -> where('des_email_add', $e_add);
		$this -> db -> where('des_location', $location);
		$this -> db -> limit(1);	

		$query = $this->db->get();
		
		$res = $query->result_array();

			foreach ($res as $res):
				$id =  $res['des_id'];
			endforeach;

		return $id;
		}

	public function new_designer__to_db__p2($id)
		{
		$data = array(
			'des_username' => $this->input->post('nd_username'),
			'des_password' => $this->input->post('nd_password'),
			'des_id' => $id
			);

		return $this->db->insert('DESIGNER_ACCOUNT', $data);
		}


	public function new_designer__to_db__p3($des_id)
		{
		//$user_name = $this->input->post('nd_username');
		$site_count = $this->input->post('nd_site_count');
			$site_count = $site_count * 1;			

		for($count = 1; $count <= $site_count; $count++)
			{			
			$site_shot = "nd_site_shot_" . $count;   //ito yung "name" sa browser
				//$new_site_shot = $this->webdesign_model__main->new_designer__to_db__p3__move_img($site_shot,$user_name);

			$new_image_id = $this->webdesign_model__main->new_designer__to_db__p3__insert__1($des_id,$count);
			
			$new_image = $this->webdesign_model__main->new_designer__to_db__p3__move_img($site_shot,$des_id,$new_image_id);
			$this->webdesign_model__main->new_designer__to_db__p3__insert__2($new_image_id,$new_image);
			}	
		}
			

	public function new_designer__to_db__p3__insert__1($des_id,$count)
		{
		$image_name = "nd_site_name_" . $count;
				$image_name = $this->input->post($image_name);

		$image_desc = "nd_site_desc_" . $count;
				$image_desc = $this->input->post($image_desc);
			
			$data = array(
				'image_name' => $image_name,
				'image_desc' => $image_desc,
				'des_id' => $des_id
				);

		$this->db->insert('DESIGNER_GALLERY', $data);

		$new_image_id = $this->webdesign_model__main->new_designer__to_db__p3__get_new_img_id($image_name,$image_desc,$des_id);
		return $new_image_id;
		}


	public function new_designer__to_db__p3__get_new_img_id($image_name,$image_desc,$des_id)
		{
		$this -> db -> select('image_id');
		$this -> db -> from('DESIGNER_GALLERY');
		$this -> db -> where('image_name', $image_name);
		$this -> db -> where('image_desc', $image_desc);
		$this -> db -> where('des_id', $des_id);
		$this->db->order_by("image_id", "desc"); 		
		$this -> db -> limit(1);	

		$query = $this->db->get();
		
		$res = $query->result_array();

			foreach ($res as $res):
				$image_id =  $res['image_id'];
			endforeach;
		return $image_id;
		}	




	public function new_designer__to_db__p3__move_img($file_post,$des_id,$new_image_id)
		{
		$config['file_name']  = " ";

		$new_file_name = $des_id . "_" . $new_image_id;

		$this->load->helper(array('form', 'url'));

		$config['upload_path'] = './designers_sites/';
		$config['allowed_types'] = 'gif|jpg|png';
		$config['remove_spaces'] = 'true';
		$config['overwrite']  = false;		
		$config['file_name']  = $new_file_name;
		

		$this->load->library('upload', $config);
	
		$this->upload->do_upload($file_post);

		$img_data = array('upload_data' => $this->upload->data());

			foreach ($img_data as $img_data):
				$name =  $img_data['raw_name'];
				$ext =  $img_data['file_ext'];
			endforeach;
		
		$file =  $name . $ext;
		$path = BASEPATH  . '../designers_sites/'  . $file;
		$new_path = BASEPATH  . '../designers_sites/'  . $new_file_name . $ext;
			rename( $path, $new_path );

		$new_file = $new_file_name . $ext;

		return $new_file;
		}
	

	public function new_designer__to_db__p3__insert__2($new_image_id,$new_image)
		{
		$data = array(
               'file_name' => $new_image
            );

		$this->db->where('image_id', $new_image_id);
		$this->db->update('DESIGNER_GALLERY', $data); 
		}






	public function get_designers_for_main_listing()
		{
		$query = $this->db->query("select des_id as the_id,des_location as location,(select des_username from DESIGNER_ACCOUNT where des_id = the_id limit 1) as alias, (select file_name from DESIGNER_GALLERY where des_id = the_id limit 1) as thumbnail from DESIGNER WHERE des_status = 1 order by alias");
		return $query->result_array();
			// produces the_id, des_location, alias, thumbnail
		}






	



	function  set_fancybox_for_designers($designer_id)
		{
		//input: id of specific name
		
		echo "<script>";			
		echo "$(document).ready(function() {";
		echo "$('.fancy_$designer_id').click(function() {";
		echo " $.fancybox.open([";

		$image = $this->webdesign_model__main->get_designer_sites_images($designer_id);

		foreach ($image as $image)
			{
			echo "{";			
			echo "href : '" . base_url() . "designers_sites/"  . $image['file_name'] .  "',"; 
			echo "title : '" .	$image['image_name'] . "'";
			echo 	"},";		  
			}

		echo "], {";
		echo " padding : 5";
		echo " });";
		echo "return false;";
		echo "});";
		echo "});";
		echo "</script>	";		
	
		}

	public function get_designer_sites_images($designer_id)
		{
		$this -> db -> select('file_name,image_name,image_desc');
		$this -> db -> from('DESIGNER_GALLERY');
		$this -> db -> where('des_id', $designer_id);

		$query = $this -> db -> get();
		
		return $query->result_array();
		}

}



/*
	

*/
/*







			views

				webdesigner's page
				webdesigner's login
					change personal details
					change password
					edit sites
						site name
						site details
						site image				
				admin log-in
					view webdesigner's details
					approve/disapprove designers




admin page
	V = admin page (main)
			F = nakahiwalay yung designer status 0, 1
				= lalabas lang yung 0 kung my 0
				= laging present ang 1

			F = designer's site thumbnail 
					on click direct to admin page(designer's profile)
			
			F = links to
					admin page (settings)
	V = admin page (settings)
			F = change password and username
				email notification

	V = admin page(designer's profile)
			F = shows all information submitted by the designer
					// pwedeng tabbed..pero parang mas gusto kong hindi, isang diretso lang talaga	
					// pati yung mga sites hiwahiwalay
			F = may 2 tab na nasa bridge, "delete account" "Re-evaluate"
					// delete account, delete na talaga, all files and data
					// re-evaluate, status to 0
					// kung 0, ang lalabas "activate"
					// kung 1, ang lalabas "re-evaluate"






			{
			upon denial of application (or delete account)
				send msg to applicant stating na nadeny siya, sorry, ek ek, please send another application ek ek
				if yung application mukang loko-loko lang, wag ng magsend ng msg				

				delete all files and records of the applicant
			}












webdesigner's page
	V  = view
	F = functionality
	


		V = Webdesigners page (log in)
			F = redirect to Webdesigners page (main) if session active
			F = if(username == existing)
					{
					check password
						if (username && password correct combination)
							{
							create session for the designer
							redirect to webdesigner's page
							}
					}
			
			F = links to	
					Webdesigners page (make new account) // pagnagkaoras nalang
					

		
		V = Webdesigners page (main)
			F = redirect to login page if session not active
			F = links to
					webdesigner's page (edit details)
			F = shows details
					Alias			
					Fname Mname Lname
					location
					contact number
					email address
				shows sites thumbnail
					upon hover
						my lalabas na menu
							Webdesigners page (edit site detail) 
				shows add new site button
				if (site thumbnail == empty){clickable yung site thumbnail header, add site thumbnail / pick from sites} else {upload new / pick from sites}
				if (designer's thumbnail == empty){clickable yung designer's thumbnail holder, add designer's thumbnail} else {upload new}
				
		V = 	webdesigner's page (edit details)
			F = redirect to login page if session not active
			F = editing
					personal details	
						Fname Mname Lname
						location
						contact number
						email address
					account details
						alias
						password
			F = deleting of account
		
		V = Webdesigners page (edit site detail)
				F = edit site detail
						site shot
						site name
						site desc
		
		

		{
			pag nag edit ng alias check if alias is still available
		}
		{
			pag nag edit ng name, kahit anung part ng name
			check if whole name is still available
		}
			//pag nagedit ng alias || name automatic to 0 yung status
				//comment muna yan :p
		}

*/
/*



*/
