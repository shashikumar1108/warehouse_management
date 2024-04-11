<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Settings extends CI_Controller {

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

    public function __construct() {
        parent::__construct();
        date_default_timezone_set("Asia/Kolkata");
        
        if(!$this->session->userdata('login') == true){
			redirect(base_url('/auth/login'));
        }
    }




	public function index()
	{			        
        $data['data'] = $this->db->select('*')->from('settings')->where('id',1)->get()->result_array();
        $this->load->view('settings', $data);
		
    }
    
   
    public function edit(){
        
        /* print_r($_FILES);
        exit(); */
        if(!empty($_FILES['logo']['name'])){
            $logo = md5(rand(-9999999999,9999999999)).date('d-m-Y').'.'.explode('.',$_FILES['logo']['name'])[1];
            
            $config['upload_path']          = './assets/images/';
            $config['allowed_types']        = 'gif|jpg|png|jpeg';
            $config['max_size']             = 10000;
            $config['max_width']            = 10000;
            $config['max_height']           = 10000;
            $config['file_name']            = $logo;

        $this->load->library('upload', $config);

                if ( ! $this->upload->do_upload('logo'))
                {
                        $error = array('error' => $this->upload->display_errors());

                        $this->session->set_flashdata('status','fail'); 
                        $this->session->set_flashdata('message',$error[error]);
                } else{
                    $Updated = $this->db->where('id',$_POST['id'])
                    ->update('settings', array(                       
                        'name'=>$_POST['name'],
                        'mobile'=>$_POST['mobile'],                     
                        'email'=>$_POST['email'],
                        'currency'=>$_POST['currency'], 
                        'address'=>$_POST['address'],
                        'description'=>$_POST['description'],
                        'logo'=>$logo                 
                ));

                    if($this->db->affected_rows() == 1){
                        $this->session->set_flashdata('status','success');
                        $this->session->set_flashdata('message','Settings Updated Successfully');            
                    }else{
                        $this->session->set_flashdata('status','fail'); 
                        $this->session->set_flashdata('message','Could not update, please try later');           
                    }

                }

        }else{
            $Updated = $this->db->where('id',$_POST['id'])
            ->update('settings', array(                       
                'name'=>$_POST['name'],
                'mobile'=>$_POST['mobile'],                     
                'email'=>$_POST['email'],
                'currency'=>$_POST['currency'], 
                'address'=>$_POST['address'],
                'description'=>$_POST['description'],
        ));

        if($this->db->affected_rows() == 1){
            $this->session->set_flashdata('status','success');
            $this->session->set_flashdata('message','Settings Updated Successfully');            
        }else{
            $this->session->set_flashdata('status','fail'); 
            $this->session->set_flashdata('message','Could not update, please try later');           
        }
        }




               
        
        redirect('settings');
    }

    
	}
