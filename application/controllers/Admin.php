<?php
defined('BASEPATH') OR exit('No direct script access allowed');

include("libraries/autoload.php");
use GroceryCrud\Core\GroceryCrud;
use GroceryCrud\Core\Model\whereModel;
class Admin extends CI_Controller {

    public function __construct(){
        parent::__construct();
        $database= include('database.php'); //config database Grocery
        $config = include('config.php'); //config library Grocery
        $this->crud = new GroceryCrud($config, $database); //initialize Grocery
        /* start Grocery global configuration */
        $this->crud->unsetDeleteMultiple();
        $this->crud->unsetDeleteMultiple();
        $this->crud->unsetPrint();
        $this->crud->unsetExport();
        $this->crud->unsetJquery();
        $this->crud->unsetAdd();
        $this->crud->setLanguage('Indonesian');
    }
    public function dashboard(){

    }
    public function add_barang(){
        $var = array();
        $var['gcrud'] = 0;
        $var['module'] = "";            
        $var['var_module'] = "add_barang";
        $var['var_title'] = "Dashboard";
        $var['var_subtitle'] = "Selamat Datang di ".APP_NAME." - Bank Jateng";
        $var['var_custom_css'] = "none";
        $var['var_custom_js'] = "none";
        $var['var_breadcrumb'] = array();
        $var['var_other'] = array();   
        $this->load->view('main',$var);
    }
    public function list_barang($role=NULL)
	{
        $var = array();
        $var['gcrud'] = 1;
        $var['module'] = "";            
        $var['var_module'] = "dashboard";
        $var['var_title'] = "Dashboard";
        $var['var_subtitle'] = "Selamat Datang di ".APP_NAME." - Bank Jateng";
        $var['var_custom_css'] = "none";
        $var['var_custom_js'] = "none";
        $var['var_breadcrumb'] = array();
        $var['var_other'] = array();
            $this->crud->setTable('barang');
            $this->crud->setSubject('Barang');
            $this->crud->columns(['id_barang','thumbnail','nama_brg','deskripsi','harga','status']);
            $this->crud->unsetDeleteMultiple();
            $this->crud->setActionButton('Avatar', 'fa fa-user', function ($row) {
                return '/view_avatar/'.$row->id_barang;
            }, true);
            $this->crud->displayAs("id_barang","id");
            $this->crud->displayAs("nama_brg","Nama Produk");
            $this->crud->displayAs("id_barang","id");
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
    
    
}
