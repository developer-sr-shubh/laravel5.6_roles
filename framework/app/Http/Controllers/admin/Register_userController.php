<?php

namespace App\Http\Controllers\admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Register_user;
use DB;
use Illuminate\Support\Facades\Input;
class Register_userController extends Controller
{
    public $v_fields=array('register_user.name', 'register_user.email', 'register_user.contact', 'register_user.status');
    public $allow_image = array('png', 'jpg', 'jpeg', 'gif');

    public function index(Request $request){
        $sortBy='';
        $order = '';
        $searchBy='';
        $searchValue='';

        // order
        if(isset($_GET['sortBy']) && in_array($_GET['sortBy'], $this->v_fields)){
            $sortBy=$_GET['sortBy'];
            $order = isset($_GET['order']) && $_GET['order']=='asc'?'asc':'desc';
            if(isset($_GET['order']) && $_GET['order']!=''){
                $_GET['order']=$_GET['order']=='asc'?'desc':'asc';
            } else{
                $_GET['order']='desc';
            }
        }

        // create links for field
        $get_q = $_GET;
        foreach ($this->v_fields as $key => $value) {
          $get_q['sortBy'] = $value;
          $get_q['page']=1;
          $query_result = http_build_query($get_q);
          $links[$value.'_link'] =url('/').'/admin/register_user?'.$query_result;
        }
        $links['csvlink'] = url('/').'/admin/register_user/export/csv?'.$_SERVER['QUERY_STRING'];
        $links['pdflink'] = url('/').'/admin/register_user/export/pdf?'.$_SERVER['QUERY_STRING'];

        // pagination per page
        $per_page = isset($_GET['per_page'])?$_GET['per_page']:10;

        // search value
        if(isset($_GET['searchBy']) && in_array($_GET['searchBy'], $this->v_fields) && $_GET['searchValue']!=''){
            $searchBy=$_GET['searchBy'];
            $searchValue = $_GET['searchValue'];
        }

        // get by modal
        $register_user = new \App\admin\Register_user;
        $data = $register_user->getRegister_userData($per_page, $searchBy, $searchValue, $sortBy, $order);

        return view('admin/register_user/index', ['data'=>$data->appends(Input::except('page')), 'per_page'=>$per_page, 'links'=>$links]);
    }



    public function getAdd(Request $request){
        $register_user = new \App\admin\Register_user;
        $data = array();
        
    	return view('admin/register_user/add', $data);
    }

    public function postEdit(Request $request){

        $this->validate($request, [
            
        ]);

        $register_user = new \App\admin\Register_user;
        if($register_user->updateRegister_user($request)){
            
            $request->session()->flash('message', 'Register_user Updated successfully!');
            return redirect()->action('admin\Register_userController@index');
        } else{
            $request->session()->flash('message', 'Error: Invalid record!');
            return redirect()->action('admin\Register_userController@index');
        }
    }

    public function postAdd(Request $request){

        $this->validate($request, [
            
        ]);

        $register_user = new \App\admin\Register_user;

        $insert_id = $register_user->addRegister_user($request);

        
             
       

        $request->session()->flash('message', 'Register_user added successfully!');
        return redirect()->action('admin\Register_userController@index');
    }

    public function getEdit($id=''){
        
        $register_user = new \App\admin\Register_user;
        $data = array();

        
        
        $data['data'] = $register_user->getRegister_user($id);
        if(count($data)){
            return view('admin/register_user/edit', $data);
        } else{
            return view('admin/register_user/edit');
        }
    }

    public function view($id){
        $register_user = new \App\admin\Register_user;
        $data['data'] = $register_user->getRegister_userView($id);
        
        
        if(count($data)){
            return view('admin/register_user/view', $data);
        } else{
            return view('admin/register_user/view');
        }
    }

    public function status(Request $request, $field, $id){
        $register_user = new \App\admin\Register_user;
        $flag = $register_user->changeStatus($field, $id);
        // $redirect = $_GET["redirect"];
        if($flag){
            $request->session()->flash('message', 'Status changed successfully!');
            // return redirect($redirect);
            return redirect()->action('admin\Register_userController@index');
        } else{
            $request->session()->flash('message', 'Invalid id!');
            return redirect()->action('admin\Register_userController@index');
        }
    }

    public function delete(Request $request){
    	$id = $request->input('id');
        $register_user = new \App\admin\Register_user;
        $flag = $register_user->deleteOne($id);
        if($flag){
            $request->session()->flash('message', 'Register_user deleted successfully!');
            if($request->input('redirect')!=''){
                return redirect(urldecode($request->input('redirect')));
            } else{
                return redirect()->action('admin\Register_userController@index');
            }
        } else{
            $request->session()->flash('message', 'Invalid id!');
            return redirect()->action('admin\Register_userController@index');
        }
    }

    public function deleteAll(Request $request)
    {
        $allIds = $request->input('allIds');
        $flag = false;
        $register_user = new \App\admin\Register_user;
        for($i=0; $i<count($allIds); $i++)
        {
            if($allIds[$i]!="")
            {
                $id = $allIds[$i];
                $flag = $register_user->deleteOne($id);                
            }
        }

        if($flag){
            $request->session()->flash('message', 'Demo deleted successfully!');
        }
    }

    public function getExport($type){
        $sortBy='';
        $order = '';
        $searchBy='';
        $searchValue='';

        // search query
        if(isset($_GET['searchBy']) && in_array($_GET['searchBy'], $this->v_fields) && $_GET['searchValue']!=''){
            $searchBy = $_GET['searchBy'];
            $searchValue = $_GET['searchValue'];
        }

        // sort by
        if(isset($_GET['sortBy']) && in_array($_GET['sortBy'], $this->v_fields)){
            $sortBy=$_GET['sortBy'];
            $order = isset($_GET['order']) && $_GET['order']=='asc'?'asc':'desc';
        }

        $register_user = new \App\admin\Register_user;
        $data = $register_user->getRegister_userExport($searchBy, $searchValue, $sortBy, $order);

        if($type=='csv'){
            header('Content-Type: application/csv');
            header('Content-Disposition: attachment; filename=register_user.csv');
            header('Pragma: no-cache');
            $csv='Sr. No,'.implode(',', $this->v_fields)."\n";
            foreach ($data as $key => $value) {
                $line=($key+1).',';
                foreach ($this->v_fields as $field) {
                    $field = explode('.', $field);
                    $field = end($field);
                    $line.='"'.$value->$field.'"'.',';
                }
                $csv.=ltrim($line,',')."\n";
            }
            echo $csv; exit;
        } elseif($type=='pdf'){
            require_once(app_path().'/libraries/mpdf60/mpdf.php');
            $table='
            <html>
            <head><title></title>
            <style>
            table{
                border:1px solid;
            }
            tr:nth-child(even)
            {
                background-color: rgba(158, 158, 158, 0.82);
            }
            </style>
            </head>
            <body>
            <h1 align="center">register_user</h1>
            <table><tr>';
            $table.='<th>Sr. No</th>';
            foreach ($this->v_fields as $value) {
                $table.='<th>'.$value.'</th>';
            }
            $table.='</tr>';
            foreach ($data as $key => $value) {
                $table.='<tr><td>'.($key+1).'</td>';
                foreach ($this->v_fields as $field) {
                    $field = explode('.', $field);
                    $field = end($field);
                    $table.='<td>'.$value->$field.'</td>';
                }
                $table.='</tr>';
            }
            $table.='</table></body></html>';
            $pdf = new \mPDF();
            $pdf->WriteHTML($table);
            $pdf->Output('register_user.pdf', "D");
            exit;
        } else{
            echo 'Invalid option!';
        }
    }
}
