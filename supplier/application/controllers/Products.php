<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Products extends CI_Controller {

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
        $this->load->helper('utility');
        if(!$this->session->userdata('login') == true){
			redirect(base_url('/auth/login'));
        }
        $db2 = $this->load->database('database2', TRUE);
    }


	public function index()
	{			        
        $products = $this->db->select('p.*, u.first_name, u.last_name')
                ->from('products p')
                ->join('users u', 'u.id = p.user_added')
                ->where('p.delete_status',0)
                ->get()->result_array();
        
        foreach($products as $key=>$p){
            $brand = $this->db->select('*')->from('brand')->where('id', $p['brand'])->get()->result_array();            
            $products[$key]['brand_name'] = empty($brand) ? '-' : $brand[0]['name'];            
            $category = $this->db->select('*')->from('category')->where('id', $p['category'])->get()->result_array();            
            $products[$key]['category_name'] = empty($category) ? '-' : $category[0]['name'];                        
            $sub_category_one = $this->db->select('*')->from('sub_categories_one')->where('id', $p['sub_category_one'])->get()->result_array();            
            $products[$key]['sub_category_one_name'] = empty($sub_category_one) ? '-' : $sub_category_one[0]['name'];                        
            $sub_category_two = $this->db->select('*')->from('sub_categories_two')->where('id', $p['sub_category_two'])->get()->result_array();            
            $products[$key]['sub_category_two_name'] = empty($sub_category_two) ? '-' : $sub_category_two[0]['name'];
        }
        
        $data['products'] = $products;        
        $this->load->view('products', $data);
    }

    public function getProductTableList(){
        // echo '<pre>';print_r($_POST);exit;
        $products = $this->productTableData($_POST);
        $data = array();
        $i = 1;
        if( isset($_POST['start']) && intval($_POST['start']) > 0 ){
            $i = $_POST['start'] + 1;
        }
        foreach ($products['data'] as $row) {
            $rowData = array();
            $rowData[] = $i;
            $rowData[] = $row['name'];
            $rowData[] = $row['category_name'];
            $rowData[] = $row['sub_category_one_name'];
            $rowData[] = $row['sub_category_two_name'];
            $rowData[] = $row['description'];
            $i++;
            $data[] = $rowData;
        }

        $result = array(
            // 'draw'  =>  $_POST['draw'],
            'data'  =>  $data,
            'recordsFiltered' => $products['total'],
            'recordsTotal' => $products['total'],
        );
        echo json_encode($result);
    }

    public function productTableData($payload = array()){

        $order_column = array("p.id","p.name","c.name","s1.name","s2.name","p.description");
        $result = array('data'=>array(),'total'=>0);
        $start = 0;
        $limit = 10;
        if( isset($payload['start']) ){
            $start = (int)$payload['start'];
        }

        if( isset($payload['length']) ){
            $limit = (int)$payload['length'];
        }

        $select = 'p.*, u.first_name, u.last_name, b.name as brand_name, c.name as category_name';
        $select .= ', s1.name as sub_category_one_name, s2.name as sub_category_two_name';
        $this->db->select($select)
            ->from('products p')
            ->join('users u', 'u.id = p.user_added')
            ->join('brand b', 'b.id = p.brand')
            ->join('category c', 'c.id = p.category')
            ->join('sub_categories_one s1', 's1.id = p.sub_category_one')
            ->join('sub_categories_two s2', 's2.id = p.sub_category_two')
            ->where('p.delete_status',0);

        if( isset($payload['search']['value']) ){
            $this->db->like('p.name', trim($payload['search']['value']));
        }
        
        if( isset($payload['order'][0]['column']) && $payload['order'][0]['column'] == 0 ){
            $this->db->order_by('p.id', 'desc');
        }else if( isset($payload['order'][0]['column']) && $payload['order'][0]['column'] > 0 ){
            $this->db->order_by($order_column[$payload['order'][0]['column']], $payload['order'][0]['dir']);
        }
        

        $result['data'] = $this->db->limit($limit,$start)->get()->result_array();
        $this->db->select("p.id")
            ->from('products p')
            ->join('users u', 'u.id = p.user_added')
            ->join('brand b', 'b.id = p.brand')
            ->join('category c', 'c.id = p.category')
            ->join('sub_categories_one s1', 's1.id = p.sub_category_one')
            ->join('sub_categories_two s2', 's2.id = p.sub_category_two')
            ->where('p.delete_status',0);

        if( isset($payload['search']['value']) ){
            $this->db->like('p.name', trim($payload['search']['value']));
        }

        $result['total'] = $this->db->get()->num_rows();
        return $result;
    }
}

