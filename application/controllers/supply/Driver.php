<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Driver extends CI_Controller {

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
        $data['data'] = $this->db->select('*')->from('drivers')->where('delete_status',0)->get()->result_array();
        $this->load->view('supply/list_drivers', $data);
		
    }
    
    public function add(){

        $image = md5(rand(-9999999999,9999999999)).date('d-m-Y').'.'.explode('.',$_FILES['image']['name'])[1];

        $config['upload_path']          = './assets/images/';
        $config['allowed_types']        = 'gif|jpg|png|jpeg';
        $config['max_size']             = 10000;
        $config['max_width']            = 10000;
        $config['max_height']           = 10000;
        $config['file_name']            = $image;

        $this->load->library('upload', $config);

        if ( ! $this->upload->do_upload('image'))
        {
                $error = array('error' => $this->upload->display_errors());

                /* print_r($error);
                exit(); */

                $this->session->set_flashdata('status','fail'); 
                $this->session->set_flashdata('message',$error[error]);
        }
        else
        {
                $data = array('upload_data' => $this->upload->data());

                $Added = $this->db->insert('drivers', array( 
                    'name'=>$_POST['name'],
                    'contact_number'=>$_POST['contact_number'],                     
                    'license_number'=>$_POST['license_number'],
                    'reference'=>$_POST['reference'], 
                    'date'=>$_POST['date'],
                    'image'=>$image,
                    'address'=>$_POST['address']                   
                ));

                if($Added){
                    $this->session->set_flashdata('status','success');
                    $this->session->set_flashdata('message','Driver Added Successfully');            
                }else{
                    $this->session->set_flashdata('status','fail'); 
                    $this->session->set_flashdata('message','Could not add, please try later');           
                }
        }        

        redirect('supply/driver'); 

    }

    public function delete(){
        $Deleted = $this->db->where('id',$_GET['id'])->update('drivers', array('delete_status'=>1));
        if($this->db->affected_rows() == 1){
            $this->session->set_flashdata('status','success');
            $this->session->set_flashdata('message','Driver Deleted Successfully');            
        }else{
            $this->session->set_flashdata('status','fail'); 
            $this->session->set_flashdata('message','Could not delete, please try later');           
        }       
        
        redirect('supply/driver');       
    }



    public function edit(){        

        if(!empty($_FILES['image']['name'])){
            $image = md5(rand(-9999999999,9999999999)).date('d-m-Y').'.'.explode('.',$_FILES['image']['name'])[1];

            $config['upload_path']          = './assets/images/';
            $config['allowed_types']        = 'gif|jpg|png|jpeg';
            $config['max_size']             = 10000;
            $config['max_width']            = 10000;
            $config['max_height']           = 10000;
            $config['file_name']            = $image;

        $this->load->library('upload', $config);

        if ( ! $this->upload->do_upload('image'))
        {
                $error = array('error' => $this->upload->display_errors());

                $this->session->set_flashdata('status','fail'); 
                $this->session->set_flashdata('message',$error[error]);
        } else{
            $Updated = $this->db->where('id',$_POST['id'])
            ->update('drivers', array(                       
                'name'=>$_POST['name'],
                    'contact_number'=>$_POST['contact_number'],                     
                    'license_number'=>$_POST['license_number'],
                    'reference'=>$_POST['reference'], 
                    'date'=>$_POST['date'],
                    'image'=>$image,
                    'address'=>$_POST['address']                 
        ));

            if($this->db->affected_rows() == 1){
                $this->session->set_flashdata('status','success');
                $this->session->set_flashdata('message','Driver Updated Successfully');            
            }else{
                $this->session->set_flashdata('status','fail'); 
                $this->session->set_flashdata('message','Could not update, please try later');           
            } 

        } 

        }else{
            $Updated = $this->db->where('id',$_POST['id'])
            ->update('drivers', array(                       
                'name'=>$_POST['name'],
                    'contact_number'=>$_POST['contact_number'],                     
                    'license_number'=>$_POST['license_number'],
                    'reference'=>$_POST['reference'], 
                    'date'=>$_POST['date'],
                    'address'=>$_POST['address']
            )); 
            
            if($this->db->affected_rows() == 1){
                $this->session->set_flashdata('status','success');
                $this->session->set_flashdata('message','Driver Updated Successfully');            
            }else{
                $this->session->set_flashdata('status','fail'); 
                $this->session->set_flashdata('message','Could not update, please try later');           
            }
        }
   
        redirect('supply/driver');
    }

    
	}
