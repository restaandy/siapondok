<?php
defined('BASEPATH') OR exit('No direct script access allowed');

include("libraries/autoload.php");
use GroceryCrud\Core\GroceryCrud;
use GroceryCrud\Core\Model\whereModel;
class User extends CI_Controller {
    
    public function __construct(){
        parent::__construct();
        if($this->session->userdata("is_login")!=true&&$this->session->userdata("user_role")!="user"){
            redirect("login");
        }
        $database= include('database.php'); //config database Grocery
        $config = include('config.php'); //config library Grocery
        $this->crud = new GroceryCrud($config, $database); //initialize Grocery
        /* start Grocery global configuration */
        $this->crud->unsetDeleteMultiple();
        $this->crud->unsetDeleteMultiple();
        $this->crud->unsetPrint();
        $this->crud->unsetExport();
        $this->crud->unsetJquery();
    }
    public function index()
    {
        $var = array();
        $var['gcrud'] = 0;
        $var['module'] = "";            
        $var['var_module'] = "dashboard";
        $var['var_title'] = "Dashboard";
        $var['var_subtitle'] = "Selamat Datang di ".APP_NAME." - Bank Jateng";
        $var['var_custom_css'] = "none";
        $var['var_custom_js'] = "none";
        $var['var_breadcrumb'] = array();
        
        $var['var_other'] = array();
        
        $this->load->view('main',$var);
    }
    public function semua_saham()
    {
        $var = array();
        $var['gcrud'] = 1;
        $var['module'] = "";            
        $var['var_module'] = "dashboard";
        $var['var_title'] = "Semua Data Pemegang Saham ".$this->session->userdata("user_fullname");
        $var['var_subtitle'] = "";
        $var['var_custom_css'] = "none";
        $var['var_custom_js'] = "none";
        $var['var_breadcrumb'] = array();
        $var['var_other'] = array();
        $this->crud->setTable('pemegang_saham');
        $this->crud->where(["unit_kerja_id = '".$this->session->userdata("unit_kerja_id")."'"]);
        $this->crud->unsetAdd();
        $this->crud->unsetEdit();
        $this->crud->unsetDelete();
        $this->crud->callbackColumn('ps_logo', function ($value, $row) {
            return "<a href='".base_url()."uploads/files/".$value."' target='_blank' align='center'><img src='".base_url()."uploads/files/".$value."' height='60' width='60'></a>";
        });
        $this->crud->setSubject('Pemegang Saham');
        $this->crud->setRelation('unit_kerja_id','unit_kerja','unit_kerja_nama');
        $this->crud->setFieldUpload('ps_logo', '/perencanaan/uploads/files', '/perencanaan/uploads/files');
        $this->crud->displayAs("ps_nama","Pemegang Saham");
        $this->crud->displayAs("ps_singkatan","Singkatan");
        $this->crud->displayAs("ps_alamat","Alamat");
        $this->crud->displayAs("ps_kota","Kota / kabupaten");
        $this->crud->displayAs("ps_logo","Logo (Click to view)");
        $this->crud->displayAs("unit_kerja_id","Unit Kerja");
        $output = $this->crud->render();
        if ($output->isJSONResponse) {
            header('Content-Type: application/json; charset=utf-8');
            echo $output->output;
            exit;
        }
        $var['css_files'] = $output->css_files;
        $var['js_files'] = $output->js_files;
        $var['output'] = $output->output;
        $this->load->view('main',$var);
    }
    public function sumber_modal()
    {
        $var = array();
        $var['gcrud'] = 1;
        $var['module'] = "";            
        $var['var_module'] = "dashboard";
        $var['var_title'] = "Sumber Pemenuhan Modal";
        $var['var_subtitle'] = "";
        $var['var_custom_css'] = "none";
        $var['var_custom_js'] = "none";
        $var['var_breadcrumb'] = array();
        $var['var_other'] = array();
        $this->crud->setTable('sumber_pemenuhan_modal');
        $this->crud->setSubject('Sumber pemenuhan Modal');
        $output = $this->crud->render();
        if ($output->isJSONResponse) {
            header('Content-Type: application/json; charset=utf-8');
            echo $output->output;
            exit;
        }
        $var['css_files'] = $output->css_files;
        $var['js_files'] = $output->js_files;
        $var['output'] = $output->output;
        $this->load->view('main',$var);
    }
    public function periode()
    {
        $var = array();
        $var['gcrud'] = 1;
        $var['module'] = "";            
        $var['var_module'] = "dashboard";
        $var['var_title'] = "Periode RUPS";
        $var['var_subtitle'] = "";
        $var['var_custom_css'] = "none";
        $var['var_custom_js'] = "none";
        $var['var_breadcrumb'] = array();
        $var['var_other'] = array();
        $this->crud->setTable('periode_rups');
        $this->crud->setSubject('Periode RUPS');
        $output = $this->crud->render();
        if ($output->isJSONResponse) {
            header('Content-Type: application/json; charset=utf-8');
            echo $output->output;
            exit;
        }
        $var['css_files'] = $output->css_files;
        $var['js_files'] = $output->js_files;
        $var['output'] = $output->output;
        $this->load->view('main',$var);
    }
    public function realisasi()
    {
        $var = array();
        $var['gcrud'] = 1;
        $var['module'] = "";            
        $var['var_module'] = "dashboard";
        $var['var_title'] = "Realisasi";
        $var['var_subtitle'] = "";
        $var['var_custom_css'] = "none";
        $var['var_custom_js'] = "none";
        $var['var_breadcrumb'] = array();
        $var['var_other'] = array();
        $this->crud->setTable('realisasi');
        $this->crud->setSubject('Realisasi Permodalan');
        $this->crud->setRelation('ps_id','pemegang_saham','ps_nama');
        $this->crud->setRelation('id_sumber','sumber_pemenuhan_modal','nama_sumber');
        $this->crud->displayAs("tgl_realisasi","Tgl Realisasi (m/d/y)");
        $this->crud->displayAs("ps_id","Pemegang Saham");
        $this->crud->displayAs("ps_nama","Pemegang Saham");
        $output = $this->crud->render();
        if ($output->isJSONResponse) {
            header('Content-Type: application/json; charset=utf-8');
            echo $output->output;
            exit;
        }
        $var['css_files'] = $output->css_files;
        $var['js_files'] = $output->js_files;
        $var['output'] = $output->output;
        $this->load->view('main',$var);
    }
    public function simulasi(){
        
    }
    
}
 