<?php
defined('BASEPATH') OR exit('No direct script access allowed');

include("libraries/autoload.php");
use GroceryCrud\Core\GroceryCrud;
use GroceryCrud\Core\Model\whereModel;

class Master extends CI_Controller {
    
    public function __construct(){
        session_start();
        if(!isset($_SESSION['user_id'])){
            redirect("login");
        }
        
        parent::__construct();
        $this->gc_database = include('database.php'); //config database Grocery
        $this->gc_config = include('config.php'); //config library Grocery
        $this->crud = new GroceryCrud($this->gc_config, $this->gc_database); //initialize Grocery
        /* start Grocery global configuration */
        $this->crud->unsetDeleteMultiple();
        $this->crud->unsetPrint();
        $this->crud->unsetExport();
        $this->crud->unsetJquery();
        
        /* start Grocery global caption */
        $this->crud->displayAs('user_name','Kode');
        $this->crud->displayAs('user_fullname','Nama Unit Kerja');
        $this->crud->displayAs('user_role','Hak Akses');
        $this->crud->displayAs('user_password','Password Login');
        
        $this->crud->displayAs('penemu_nama','Nama Lembaga');
        $this->crud->displayAs('penemu_id','Nama Lembaga');
        
        $this->crud->displayAs('temuan_isi','Temuan');
        $this->crud->displayAs('temuan_komitmen','Komitmen');
        $this->crud->displayAs('temuan_target','Target Komitmen');
        $this->crud->displayAs('temuan_tanggal','Tanggal Temuan');
        $this->crud->displayAs('temuan_keterangan','Keterangan');
        $this->crud->displayAs('temuan_status','Status');
        $this->crud->setLanguage('Indonesian');
    }
    public function assets(){
        /*
        $remoteImage = base_url()."assets/temuan_bukti/".$this->uri->segment(4);
        $imginfo = getimagesize($remoteImage);
        header("Content-type: {$imginfo['mime']}");
        readfile($remoteImage);
        */
        $var = array();
        $var['gcrud'] = 0;
        $var['var_module'] = "view_file";
        $var['var_title'] = "Pemrosesan Temuan";
        $var['var_subtitle'] = "Bukti Pemrosesan Temuan";
        $var['var_custom_css'] = "none";
        $var['var_custom_js'] = "none";
        $var['var_breadcrumb'] = array(array("url" => "#","title" => "Pemrosesan Temuan"),
                                        array("url" => "#","title" => "Bukti Pemrosesan Temuan"));
        $var['var_other'] = array("file"=>$this->uri->segment(4));
       
        $this->load->view('main',$var);
    }
    public function temuan()
    {
        $this->crud->displayAs("user_name","Unit Kerja");
        $this->crud->setTable('temuan');
        $this->crud->setSubject('Temuan');
        $this->crud->setRelation("user_name","users","user_fullname");
        $this->crud->setRelation("penemu_id","penemu","penemu_nama");
        $this->crud->setRelation("sub_penemu_id","sub_penemu","sub_penemu");
        $this->crud->displayAs("sub_penemu_id","Bagian Lembaga");

        $this->crud->displayAs("temuan_tanggal","Tanggal Penemuan (d/m/y)");
        $this->crud->displayAs("temuan_target","Tanggal Target (d/m/y)");

        $this->crud->unsetColumns(["temuan_tanggal"]);
        $this->crud->setFieldUpload('file_bukti', 'assets/temuan_bukti', 'assets/temuan_bukti');


        if($_SESSION['user_role']!="admin"){
            $username=$_SESSION['user_name'];
            $this->crud->where(["user_name = '$username'"]);
            $this->crud->unsetAdd();
            $this->crud->unsetDelete();
            $this->crud->readOnlyFields(['user_name','temuan_status','penemu_id','temuan_komitmen','temuan_target','temuan_tanggal','temuan_keterangan','temuan_isi','']);
            $this->crud->fieldType('temuan_target', 'string');
            $this->crud->fieldType('temuan_tanggal', 'string');
            $this->crud->callbackBeforeUpload(function($stateParameters){
               return $stateParameters;
            });
            
            $this->crud->callbackBeforeUpdate(function ($stateParameters) {
                
                if($stateParameters->data['file_bukti']!=""){
                    $id=$stateParameters->primaryKeyValue;
                    $this->db->where("temuan_id",$id);
                    $q=$this->db->get("temuan");
                    $q=$q->row();
                    if(isset($q)){
                        $this->db->query("INSERT INTO timeline (id_temuan,user_name,`status`,tanggal_eksekusi,lihat) VALUES (?,?,?,NOW(),'0');",array($id,$q->user_name,$q->temuan_status));
                    }
                }
                return $stateParameters;
            });    
        }else{
            $this->crud->unsetAddFields(['file_bukti']);
            $this->crud->unsetEditFields(['file_bukti']);
        }

        $this->crud->callbackColumn('temuan_tanggal', function ($value, $row) {
            $value=explode("-",$value);
            if(sizeof($value)>0){$value=$value[2]."-".$value[1]."-".$value[0];}
            else{$value="00-00-0000";}    
            return $value;
        });
        $this->crud->callbackColumn('temuan_target', function ($value, $row) {
            $value=explode("-",$value);
            if(sizeof($value)>0){$value=$value[2]."-".$value[1]."-".$value[0];}
            else{$value="00-00-0000";}    
            return $value;
        });
        $output = $this->crud->render();
        if ($output->isJSONResponse) {
            header('Content-Type: application/json; charset=utf-8');
            echo $output->output;
            exit;
        }
        $var = array();
        $var['gcrud'] = 1;
        $var['module'] = "";
        $var['var_module'] = "";
        $var['var_title'] = "Temuan";
        $var['var_subtitle'] = "Daftar Seluruh Temuan";
        $var['var_custom_css'] = "none";
        $var['var_custom_js'] = "none";
        $var['var_breadcrumb'] = array(array("url" => "#","title" => "Temuan"),
                                        array("url" => "#","title" => "Semua Temuan"));
        $var['var_other'] = array();
        $var['css_files'] = $output->css_files;
        $var['js_files'] = $output->js_files;
        $var['output'] = $output->output;
        $this->load->view('main',$var);
    }
 
    public function temuan_bytahun($tahun)
    {
        if($this->uri->segment(3)=="assets"){redirect("master/assets/".$this->uri->segment(3)."/".$this->uri->segment(5));}
        $this->crud->setTable('temuan');
        $this->crud->setSubject('Temuan');
        $this->crud->setRelation('user_name', 'users', 'user_fullname');
        $this->crud->setRelation("penemu_id","penemu","penemu_nama");
        $this->crud->setRelation("sub_penemu_id","sub_penemu","sub_penemu");

        $this->crud->displayAs("temuan_tanggal","Tanggal Penemuan (d/m/y)");
        $this->crud->displayAs("temuan_target","Tanggal Target (d/m/y)");

        $this->crud->displayAs("sub_penemu_id","Bagian Lembaga");
        $this->crud->unsetColumns(["temuan_tanggal"]);
        $this->crud->setFieldUpload('file_bukti', 'assets/temuan_bukti', 'assets/temuan_bukti');
        if($_SESSION['user_role']!="admin"){
            $username=$_SESSION['user_name'];
            $this->crud->where(["user_name = '$username' and YEAR(temuan_tanggal) = $tahun"]);
            $this->crud->unsetAdd();
            $this->crud->unsetDelete();
            $this->crud->readOnlyFields(['user_name','temuan_status','penemu_id','temuan_komitmen','temuan_target','temuan_tanggal','temuan_keterangan','temuan_isi','']);
            $this->crud->fieldType('temuan_target', 'string');
            $this->crud->fieldType('temuan_tanggal', 'string');
            $this->crud->callbackBeforeUpload(function($stateParameters){

                return $stateParameters;
            });
            
            $this->crud->callbackBeforeUpdate(function ($stateParameters) {
                return $stateParameters;
            });
        }else{
            $this->crud->where(["YEAR(temuan_tanggal) = $tahun"]);    
            $this->crud->unsetAddFields(['file_bukti']);
            $this->crud->unsetEditFields(['file_bukti']);
        }    
        $this->crud->callbackColumn('temuan_tanggal', function ($value, $row) {
            $value=explode("-",$value);
            if(sizeof($value)>0){$value=$value[2]."-".$value[1]."-".$value[0];}
            else{$value="00-00-0000";}    
            return $value;
        });
        $this->crud->callbackColumn('temuan_target', function ($value, $row) {
            $value=explode("-",$value);
            if(sizeof($value)>0){$value=$value[2]."-".$value[1]."-".$value[0];}
            else{$value="00-00-0000";}    
            return $value;
        });
        $output = $this->crud->render();
        if ($output->isJSONResponse) {
            header('Content-Type: application/json; charset=utf-8');
            echo $output->output;
            exit;
        }
        $var = array();
        $var['gcrud'] = 1;
        $var['module'] = "";
        $var['var_module'] = "";
        $var['var_title'] = "Temuan";
        $var['var_subtitle'] = "Daftar Temuan Tahun ".$tahun;
        $var['var_custom_css'] = "none";
        $var['var_custom_js'] = "none";
        $var['var_breadcrumb'] = array(array("url" => "#","title" => "Temuan"),
                                        array("url" => "#","title" => "Berdasarkan Tahun"));
        $var['var_other'] = array();
        $var['css_files'] = $output->css_files;
        $var['js_files'] = $output->js_files;
        $var['output'] = $output->output;
        $this->load->view('main',$var);
    }
    
    public function temuan_byunitkerja($unit_kerja_id)
    {
        if($this->uri->segment(3)=="assets"){redirect("master/assets/".$this->uri->segment(3)."/".$this->uri->segment(5));}
        if($_SESSION['user_role']=="admin"){
            $this->db->where("user_name",$unit_kerja_id);
            $this->db->update("timeline",array("lihat"=>"1"));
        }
        $unit_kerja = $this->db->get_where("users",array("user_name" => $unit_kerja_id))->row_array();

        $this->crud->setTable('temuan');
        $this->crud->setSubject('Temuan '.$unit_kerja['user_fullname']);
        $this->crud->fieldType("user_name","hidden",$unit_kerja_id);
        $this->crud->setRelation("penemu_id","penemu","penemu_nama");
        $this->crud->setRelation("sub_penemu_id","sub_penemu","sub_penemu");

        $this->crud->displayAs("temuan_tanggal","Tanggal Penemuan (d/m/y)");
        $this->crud->displayAs("temuan_target","Tanggal Target (d/m/y)");

        $this->crud->displayAs("sub_penemu_id","Bagian Lembaga");
        $this->crud->unsetColumns(["temuan_tanggal","user_name"]);
        $this->crud->setFieldUpload('file_bukti', 'assets/temuan_bukti', 'assets/temuan_bukti');
        if($_SESSION['user_role']!="admin"){
            $username=$_SESSION['user_name'];
            $this->crud->where(["user_name = '$username' and user_name = '$unit_kerja_id'"]);
            $this->crud->unsetAdd();
            $this->crud->unsetDelete();
            $this->crud->readOnlyFields(['user_name','temuan_status','penemu_id','temuan_komitmen','temuan_target','temuan_tanggal','temuan_keterangan','temuan_isi','']);
            $this->crud->fieldType('temuan_target', 'string');
            $this->crud->fieldType('temuan_tanggal', 'string');
            $this->crud->callbackBeforeUpload(function($stateParameters){
                
                return $stateParameters;
            });
            
            $this->crud->callbackBeforeUpdate(function ($stateParameters) {
                return $stateParameters;
            });

        }else{
            $this->crud->where(["user_name = '$unit_kerja_id'"]);
            $this->crud->unsetAddFields(['file_bukti']);
            $this->crud->unsetEditFields(['file_bukti']);
        }
        $this->crud->callbackColumn('temuan_tanggal', function ($value, $row) {
            $value=explode("-",$value);
            if(sizeof($value)>0){$value=$value[2]."-".$value[1]."-".$value[0];}
            else{$value="00-00-0000";}    
            return $value;
        });
        $this->crud->callbackColumn('temuan_target', function ($value, $row) {
            $value=explode("-",$value);
            if(sizeof($value)>0){$value=$value[2]."-".$value[1]."-".$value[0];}
            else{$value="00-00-0000";}    
            return $value;
        });
        $output = $this->crud->render();
        if ($output->isJSONResponse) {
            header('Content-Type: application/json; charset=utf-8');
            echo $output->output;
            exit;
        }
        $var = array();
        $var['gcrud'] = 1;
        $var['module'] = "";
        $var['var_module'] = "";
        $var['var_title'] = "Temuan";
        $var['var_subtitle'] = "Daftar Temuan ".$unit_kerja['user_fullname'];
        $var['var_custom_css'] = "none";
        $var['var_custom_js'] = "none";
        $var['var_breadcrumb'] = array(array("url" => "#","title" => "Temuan"),
                                        array("url" => "#","title" => "Berdasarkan Unit Kerja"));
        $var['var_other'] = array();
        $var['css_files'] = $output->css_files;
        $var['js_files'] = $output->js_files;
        $var['output'] = $output->output;
        $this->load->view('main',$var);
    }
    public function temuan_bystatus($status)
    {
        if($this->uri->segment(3)=="assets"){redirect("master/assets/".$this->uri->segment(3)."/".$this->uri->segment(5));}
        $this->crud->setTable('temuan');
        $this->crud->setSubject('Temuan '.$status);
        $this->crud->setRelation('user_name', 'users', 'user_fullname');
        $this->crud->setRelation("penemu_id","penemu","penemu_nama");
        $this->crud->setRelation("sub_penemu_id","sub_penemu","sub_penemu");

        $this->crud->displayAs("temuan_tanggal","Tanggal Penemuan (d/m/y)");
        $this->crud->displayAs("temuan_target","Tanggal Target (d/m/y)");

        $this->crud->displayAs("sub_penemu_id","Bagian Lembaga");
        $this->crud->unsetColumns(["temuan_tanggal","temuan_status"]);
        $this->crud->setFieldUpload('file_bukti', 'assets/temuan_bukti', 'assets/temuan_bukti');
        if($_SESSION['user_role']!="admin"){
            $username=$_SESSION['user_name'];
            $this->crud->where(["user_name = '$username' and temuan_status = '$status'"]);
            $this->crud->unsetAdd();
            $this->crud->unsetDelete();
            $this->crud->readOnlyFields(['user_name','temuan_status','penemu_id','temuan_komitmen','temuan_target','temuan_tanggal','temuan_keterangan','temuan_isi','']);
            $this->crud->fieldType('temuan_target', 'string');
            $this->crud->fieldType('temuan_tanggal', 'string');
            $this->crud->callbackBeforeUpload(function($stateParameters){
               
                return $stateParameters;
            });
            
            $this->crud->callbackBeforeUpdate(function ($stateParameters) {
                return $stateParameters;
            });
        }else{
            $this->crud->where(["temuan_status = '$status'"]);
            $this->crud->unsetAddFields(['file_bukti']);
            $this->crud->unsetEditFields(['file_bukti']);
        }
        $this->crud->callbackColumn('temuan_tanggal', function ($value, $row) {
            $value=explode("-",$value);
            if(sizeof($value)>0){$value=$value[2]."-".$value[1]."-".$value[0];}
            else{$value="00-00-0000";}    
            return $value;
        });
        $this->crud->callbackColumn('temuan_target', function ($value, $row) {
            $value=explode("-",$value);
            if(sizeof($value)>0){$value=$value[2]."-".$value[1]."-".$value[0];}
            else{$value="00-00-0000";}    
            return $value;
        });
        $output = $this->crud->render();
        if ($output->isJSONResponse) {
            header('Content-Type: application/json; charset=utf-8');
            echo $output->output;
            exit;
        }
        $var = array();
        $var['gcrud'] = 1;
        $var['module'] = "";
        $var['var_module'] = "";
        $var['var_title'] = "Temuan";
        $var['var_subtitle'] = "Daftar Temuan Status: ".$status;
        $var['var_custom_css'] = "none";
        $var['var_custom_js'] = "none";
        $var['var_breadcrumb'] = array(array("url" => "#","title" => "Temuan"),
                                        array("url" => "#","title" => "Berdasarkan Status"));
        $var['var_other'] = array();
        $var['css_files'] = $output->css_files;
        $var['js_files'] = $output->js_files;
        $var['output'] = $output->output;
        $this->load->view('main',$var);
    }
    
    public function unit_kerja()
    {
        $this->crud->setTable('users');
        $this->crud->setSubject('Unit Kerja');
        $this->crud->columns(['user_name', 'user_fullname','user_role']);
        $this->crud->addFields(['user_name', 'user_fullname', 'user_role','user_password']);
        $this->crud->editFields(['user_name', 'user_fullname', 'user_role','user_password']);
        $this->crud->displayAs('user_password','Password Baru, kosongi jika tidak');
        $this->crud->callbackEditForm(function ($stateParameters){
            $stateParameters['user_password']="";
            return $stateParameters;
        });
        $this->crud->callbackBeforeUpdate(function ($stateParameters) {
            if(trim($stateParameters->data['user_password']," ")!=""){
                $newpassword=md5($stateParameters->data['user_password']);
                $stateParameters = (object)[
                    'primaryKeyValue' => $stateParameters->primaryKeyValue,
                    'data' => [ 
                        'user_name'=>$stateParameters->data['user_name'],
                        'user_fullname'=>$stateParameters->data['user_fullname'],
                        'user_role'=>$stateParameters->data['user_role'],
                        'user_password' => $newpassword
                    ]
                ];
            }else{
                $stateParameters = (object)[
                    'primaryKeyValue' => $stateParameters->primaryKeyValue,
                    'data' => [ 
                        'user_name'=>$stateParameters->data['user_name'],
                        'user_fullname'=>$stateParameters->data['user_fullname'],
                        'user_role'=>$stateParameters->data['user_role']
                    ]
                ];
            }
            return $stateParameters;
        });

        $output = $this->crud->render();
        if ($output->isJSONResponse) {
            header('Content-Type: application/json; charset=utf-8');
            echo $output->output;
            exit;
        }
        $var = array();
        $var['gcrud'] = 1;
        $var['module'] = "";
        $var['var_module'] = "";
        $var['var_title'] = "Unit Kerja";
        $var['var_subtitle'] = "Daftar Unit Kerja";
        $var['var_custom_css'] = "none";
        $var['var_custom_js'] = "none";
        $var['var_breadcrumb'] = array(array("url" => "#","title" => "Pengaturan"),
                                        array("url" => "#","title" => "Unit Kerja"));
        $var['var_other'] = array();
        $var['css_files'] = $output->css_files;
        $var['js_files'] = $output->js_files;
        $var['output'] = $output->output;
        $this->load->view('main',$var);
    }
    public function subpenemu(){
        $this->crud->setTable('sub_penemu');
        $this->crud->setRelation("penemu_id","penemu","penemu_nama");
        $this->crud->setSubject('Sub Lembaga');
        $output = $this->crud->render();
        if ($output->isJSONResponse) {
            header('Content-Type: application/json; charset=utf-8');
            echo $output->output;
            exit;
        }
        $var = array();
        $var['gcrud'] = 1;
        $var['module'] = "";
        $var['var_module'] = "";
        $var['var_title'] = "Sub Lembaga Audit";
        $var['var_subtitle'] = "Daftar Lembaga Audit";
        $var['var_custom_css'] = "none";
        $var['var_custom_js'] = "none";
        $var['var_breadcrumb'] = array(array("url" => "#","title" => "Pengaturan"),
                                        array("url" => "#","title" => "Lembaga Audit"));
        $var['var_other'] = array();
        $var['css_files'] = $output->css_files;
        $var['js_files'] = $output->js_files;
        $var['output'] = $output->output;
        $this->load->view('main',$var);   
    }
    public function penemu()
    {
        $this->crud->setTable('penemu');
        $this->crud->setSubject('Lembaga');
        $output = $this->crud->render();
        if ($output->isJSONResponse) {
            header('Content-Type: application/json; charset=utf-8');
            echo $output->output;
            exit;
        }
        $var = array();
        $var['gcrud'] = 1;
        $var['module'] = "";
        $var['var_module'] = "";
        $var['var_title'] = "Lembaga Audit";
        $var['var_subtitle'] = "Daftar Lembaga Audit";
        $var['var_custom_css'] = "none";
        $var['var_custom_js'] = "none";
        $var['var_breadcrumb'] = array(array("url" => "#","title" => "Pengaturan"),
                                        array("url" => "#","title" => "Lembaga Audit"));
        $var['var_other'] = array();
        $var['css_files'] = $output->css_files;
        $var['js_files'] = $output->js_files;
        $var['output'] = $output->output;
        $this->load->view('main',$var);
    }
}
