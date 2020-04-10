<?php

namespace App\Http\Controllers\admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Vaccination;
use DB;
use Illuminate\Support\Facades\Input;
class VaccinationController extends Controller
{
    public $v_fields=array('vaccination.vaccination_name', 'vaccination.vaccination_chart', 'vaccination.vaccination_date', 'vaccination.vaccination_banner', 'vaccination.status');
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
          $links[$value.'_link'] =url('/').'/admin/vaccination?'.$query_result;
        }
        $links['csvlink'] = url('/').'/admin/vaccination/export/csv?'.$_SERVER['QUERY_STRING'];
        $links['pdflink'] = url('/').'/admin/vaccination/export/pdf?'.$_SERVER['QUERY_STRING'];

        // pagination per page
        $per_page = isset($_GET['per_page'])?$_GET['per_page']:10;

        // search value
        if(isset($_GET['searchBy']) && in_array($_GET['searchBy'], $this->v_fields) && $_GET['searchValue']!=''){
            $searchBy=$_GET['searchBy'];
            $searchValue = $_GET['searchValue'];
        }

        // get by modal
        $vaccination = new \App\admin\Vaccination;
        $data = $vaccination->getVaccinationData($per_page, $searchBy, $searchValue, $sortBy, $order);

        return view('admin/vaccination/index', ['data'=>$data->appends(Input::except('page')), 'per_page'=>$per_page, 'links'=>$links]);
    }



    public function getAdd(Request $request){
        $vaccination = new \App\admin\Vaccination;
        $data = array();
        
    	return view('admin/vaccination/add', $data);
    }

    public function postEdit(Request $request){

        $this->validate($request, [
            
        ]);

        $vaccination = new \App\admin\Vaccination;
        if($vaccination->updateVaccination($request)){
            
            $request->session()->flash('message', 'Vaccination Updated successfully!');
            return redirect()->action('admin\VaccinationController@index');
        } else{
            $request->session()->flash('message', 'Error: Invalid record!');
            return redirect()->action('admin\VaccinationController@index');
        }
    }

    public function postAdd(Request $request){

        $this->validate($request, [
            
        ]);

        $vaccination = new \App\admin\Vaccination;

        $insert_id = $vaccination->addVaccination($request);

        
             
       

        $request->session()->flash('message', 'Vaccination added successfully!');
        return redirect()->action('admin\VaccinationController@index');
    }

    public function getEdit($id=''){
        
        $vaccination = new \App\admin\Vaccination;
        $data = array();

        
        
        $data['data'] = $vaccination->getVaccination($id);
        if(count($data)){
            return view('admin/vaccination/edit', $data);
        } else{
            return view('admin/vaccination/edit');
        }
    }

    public function view($id){
        $vaccination = new \App\admin\Vaccination;
        $data['data'] = $vaccination->getVaccinationView($id);
        
        
        if(count($data)){
            return view('admin/vaccination/view', $data);
        } else{
            return view('admin/vaccination/view');
        }
    }

    public function status(Request $request, $field, $id){
        $vaccination = new \App\admin\Vaccination;
        $flag = $vaccination->changeStatus($field, $id);
        // $redirect = $_GET["redirect"];
        if($flag){
            $request->session()->flash('message', 'Status changed successfully!');
            // return redirect($redirect);
            return redirect()->action('admin\VaccinationController@index');
        } else{
            $request->session()->flash('message', 'Invalid id!');
            return redirect()->action('admin\VaccinationController@index');
        }
    }

    public function delete(Request $request){
    	$id = $request->input('id');
        $vaccination = new \App\admin\Vaccination;
        $flag = $vaccination->deleteOne($id);
        if($flag){
            $request->session()->flash('message', 'Vaccination deleted successfully!');
            if($request->input('redirect')!=''){
                return redirect(urldecode($request->input('redirect')));
            } else{
                return redirect()->action('admin\VaccinationController@index');
            }
        } else{
            $request->session()->flash('message', 'Invalid id!');
            return redirect()->action('admin\VaccinationController@index');
        }
    }

    public function deleteAll(Request $request)
    {
        $allIds = $request->input('allIds');
        $flag = false;
        $vaccination = new \App\admin\Vaccination;
        for($i=0; $i<count($allIds); $i++)
        {
            if($allIds[$i]!="")
            {
                $id = $allIds[$i];
                $flag = $vaccination->deleteOne($id);                
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

        $vaccination = new \App\admin\Vaccination;
        $data = $vaccination->getVaccinationExport($searchBy, $searchValue, $sortBy, $order);

        if($type=='csv'){
            header('Content-Type: application/csv');
            header('Content-Disposition: attachment; filename=vaccination.csv');
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
            <h1 align="center">vaccination</h1>
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
            $pdf->Output('vaccination.pdf', "D");
            exit;
        } else{
            echo 'Invalid option!';
        }
    }
}
