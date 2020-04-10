<?php

namespace App\Http\Controllers\admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Blood_type;
use DB;
use Illuminate\Support\Facades\Input;
class Blood_typeController extends Controller
{
    public $v_fields=array('blood_type.blood_group', 'blood_type.status');
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
          $links[$value.'_link'] =url('/').'/admin/blood_type?'.$query_result;
        }
        $links['csvlink'] = url('/').'/admin/blood_type/export/csv?'.$_SERVER['QUERY_STRING'];
        $links['pdflink'] = url('/').'/admin/blood_type/export/pdf?'.$_SERVER['QUERY_STRING'];

        // pagination per page
        $per_page = isset($_GET['per_page'])?$_GET['per_page']:10;

        // search value
        if(isset($_GET['searchBy']) && in_array($_GET['searchBy'], $this->v_fields) && $_GET['searchValue']!=''){
            $searchBy=$_GET['searchBy'];
            $searchValue = $_GET['searchValue'];
        }

        // get by modal
        $blood_type = new \App\admin\Blood_type;
        $data = $blood_type->getBlood_typeData($per_page, $searchBy, $searchValue, $sortBy, $order);

        return view('admin/blood_type/index', ['data'=>$data->appends(Input::except('page')), 'per_page'=>$per_page, 'links'=>$links]);
    }



    public function getAdd(Request $request){
        $blood_type = new \App\admin\Blood_type;
        $data = array();
        
    	return view('admin/blood_type/add', $data);
    }

    public function postEdit(Request $request){

        $this->validate($request, [
            
        ]);

        $blood_type = new \App\admin\Blood_type;
        if($blood_type->updateBlood_type($request)){
            
            $request->session()->flash('message', 'Blood_type Updated successfully!');
            return redirect()->action('admin\Blood_typeController@index');
        } else{
            $request->session()->flash('message', 'Error: Invalid record!');
            return redirect()->action('admin\Blood_typeController@index');
        }
    }

    public function postAdd(Request $request){

        $this->validate($request, [
            
        ]);

        $blood_type = new \App\admin\Blood_type;

        $insert_id = $blood_type->addBlood_type($request);

        
             
       

        $request->session()->flash('message', 'Blood_type added successfully!');
        return redirect()->action('admin\Blood_typeController@index');
    }

    public function getEdit($id=''){
        
        $blood_type = new \App\admin\Blood_type;
        $data = array();

        
        
        $data['data'] = $blood_type->getBlood_type($id);
        if(count($data)){
            return view('admin/blood_type/edit', $data);
        } else{
            return view('admin/blood_type/edit');
        }
    }

    public function view($id){
        $blood_type = new \App\admin\Blood_type;
        $data['data'] = $blood_type->getBlood_typeView($id);
        
        
        if(count($data)){
            return view('admin/blood_type/view', $data);
        } else{
            return view('admin/blood_type/view');
        }
    }

    public function status(Request $request, $field, $id){
        $blood_type = new \App\admin\Blood_type;
        $flag = $blood_type->changeStatus($field, $id);
        // $redirect = $_GET["redirect"];
        if($flag){
            $request->session()->flash('message', 'Status changed successfully!');
            // return redirect($redirect);
            return redirect()->action('admin\Blood_typeController@index');
        } else{
            $request->session()->flash('message', 'Invalid id!');
            return redirect()->action('admin\Blood_typeController@index');
        }
    }

    public function delete(Request $request){
    	$id = $request->input('id');
        $blood_type = new \App\admin\Blood_type;
        $flag = $blood_type->deleteOne($id);
        if($flag){
            $request->session()->flash('message', 'Blood_type deleted successfully!');
            if($request->input('redirect')!=''){
                return redirect(urldecode($request->input('redirect')));
            } else{
                return redirect()->action('admin\Blood_typeController@index');
            }
        } else{
            $request->session()->flash('message', 'Invalid id!');
            return redirect()->action('admin\Blood_typeController@index');
        }
    }

    public function deleteAll(Request $request)
    {
        $allIds = $request->input('allIds');
        $flag = false;
        $blood_type = new \App\admin\Blood_type;
        for($i=0; $i<count($allIds); $i++)
        {
            if($allIds[$i]!="")
            {
                $id = $allIds[$i];
                $flag = $blood_type->deleteOne($id);                
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

        $blood_type = new \App\admin\Blood_type;
        $data = $blood_type->getBlood_typeExport($searchBy, $searchValue, $sortBy, $order);

        if($type=='csv'){
            header('Content-Type: application/csv');
            header('Content-Disposition: attachment; filename=blood_type.csv');
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
            <h1 align="center">blood_type</h1>
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
            $pdf->Output('blood_type.pdf', "D");
            exit;
        } else{
            echo 'Invalid option!';
        }
    }
}
