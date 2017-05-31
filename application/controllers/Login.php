<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Login extends CI_Controller {
    public function __construct(){
        parent::__construct();
       
    }
    
    public function index()
	{
        $var = array();
        $var['gcrud'] = 0;
        $var['module'] = "";
        $var['var_module'] = "login";
        $var['var_title'] = "Login";
        $var['var_subtitle'] = "";
        $var['var_custom_css'] = "none";
        $var['var_custom_js'] = "none";
        $var['var_breadcrumb'] = array();
        $var['var_other'] = array();

        $this->load->view('login',$var);   
	}
    
    public function login()
	{
        if(isset($_POST['login'])){
            $data = array("user_name" => $_POST['user_name'],
                            "user_password" => md5($_POST['user_password']));
                            
            $tmp = $this->db->get_where("users",$data);
            if($tmp->num_rows() > 0){
                $tmp = $tmp->row_array();
                $this->session->set_userdata('unit_kerja_id',$tmp['unit_kerja_id']);
                $this->session->set_userdata('user_name',$tmp['user_name']);
                $this->session->set_userdata('user_role',$tmp['user_role']);
                $this->session->set_userdata('user_fullname',$tmp['user_fullname']);
                $this->session->set_userdata('is_login',true);
                if($tmp['user_role']=="admin"){
                    redirect("admin");
                }else if($tmp['user_role']=="user"){
                    redirect("user");
                }else if($tmp['user_role']=="spv"){
                    redirect("supervisi");
                }else{

                }
                redirect(base_url());                    
            }
        }
	}
   
    public function logout(){
        session_destroy();
        redirect(base_url());
    }
    
}
