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
        if(isset($_POST['login'])&&sizeof($this->input->post())>0){
            $data = array(
                    "username" => $this->input->post("username"),
                    "password" => md5($this->input->post("password")),
                    "sebagai" => $this->input->post("sebagai")
                    );
            if($this->input->post("sebagai")=="admin"){
                $tmp = $this->db->get_where("users",$data);
                if($tmp->num_rows() > 0){
                    $tmp = $tmp->row_array();
                    $this->session->set_userdata('id',$tmp['id']);
                    $this->session->set_userdata('username',$tmp['username']);
                    $this->session->set_userdata('sebagai',$tmp['sebagai']);
                    $this->session->set_userdata('kategori_sekolah',array("mi","ma","mts"));
                    $this->session->set_userdata('is_login',true);
                    redirect("admin");
                }else{redirect("login");}        
            }else if($this->input->post("sebagai")=="petugas"){
                $tmp = $this->db->get_where("users",$data);
                if($tmp->num_rows() > 0){
                    $tmp = $tmp->row_array();
                    $this->session->set_userdata('id',$tmp['id']);
                    $this->session->set_userdata('username',$tmp['username']);
                    $this->session->set_userdata('sebagai',$tmp['sebagai']);
                    $kategori_sekolah=explode(",", $tmp['kategori_sekolah'])
                    $this->session->set_userdata('kategori_sekolah',$kategori_sekolah);
                    $this->session->set_userdata('is_login',true);
                    redirect("petugas");
                }else{redirect("login");}
            }else if($this->input->post("sebagai")=="guru"){
                $tmp = $this->db->get_where("users",$data);
                if($tmp->num_rows() > 0){
                    $tmp = $tmp->row_array();
                    $this->session->set_userdata('id',$tmp['id']);
                    $this->session->set_userdata('username',$tmp['username']);
                    $this->session->set_userdata('sebagai',$tmp['sebagai']);
                    $kategori_sekolah=explode(",", $tmp['kategori_sekolah'])
                    $this->session->set_userdata('kategori_sekolah',$kategori_sekolah);
                    $this->session->set_userdata('is_login',true);
                    redirect("guru");
                }else{redirect("login");}
            }else if($this->input->post("sebagai")=="siswa"){
                $tmp = $this->db->get_where("users",$data);
                if($tmp->num_rows() > 0){
                    $tmp = $tmp->row_array();
                    $this->session->set_userdata('id',$tmp['nis']);
                    $this->session->set_userdata('username',$tmp['username']);
                    $this->session->set_userdata('sebagai',$tmp['sebagai']);
                    $kategori_sekolah=explode(",", $tmp['kategori_sekolah'])
                    $this->session->set_userdata('kategori_sekolah',$kategori_sekolah);
                    $this->session->set_userdata('is_login',true);
                    redirect("siswa");
                }else{redirect("login");}
            }
        }else{
            redirect("login");
        }
	}
   
    public function logout(){
        session_destroy();
        redirect(base_url());
    }
    
}
