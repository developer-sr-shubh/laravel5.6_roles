<?php

namespace App\admin;
use DB;
use Illuminate\Database\Eloquent\Model;

class Vaccination extends Model
{
    protected $table = 'vaccination';
    protected $primaryKey = 'id';
    public $timestamps = false;
    public $allow_image = array('png', 'jpg', 'jpeg', 'gif');

    public function getAll($table){
      return DB::table($table)->get();
    }


    public function getVaccination($id){
      $data =  Vaccination::where('id', $id)->get();
      if(count($data)){
        return $data[0];
      } else{
        return array();
      }
    }

    public function getVaccinationView($id){
      $vaccination = Vaccination::select(array('vaccination.*'));
      $vaccination->where('vaccination.id', $id);
      
      return $vaccination->get()[0];

    }

    public function multiSelectInsert($r_table, $field1, $value1, $field2, $value2=array())
    {
      DB::table("$r_table")->where("$field1", $value1)->delete();
      if ($r_table!="" && $field1!="" && $value1!="" && $field2!="" && count($value2)>0) {
        for ($i=0; $i < count($value2); $i++) {
          $data[] = array(
            $field1 => $value1,
            $field2 => $value2[$i],
          );
        }
        DB::table("$r_table")->insert($data);
      }
    }

    public function getSelectedIds($table, $id, $where_field, $select_field)
    {
       $arr = array();
       $data = DB::table("$table")->select("$select_field")->where(array($where_field=>$id))->get();
       foreach ($data as $key => $value) {
            $arr[] = $value->$select_field;
        }
        return $arr;
    }


    function getSelectedData($table, $field, $idArr) {
        $arr = array();
        $data = DB::table("$table")->select("*")->whereIn("id",$idArr)->get();
        foreach ($data as $key => $value) {
            $arr[] = $value->$field;
        }
        return $arr;
    }


    public function changeStatus($field, $id){
      $vaccination = $this->getVaccination($id);
      if(count($vaccination)){
        
                    if($field=="status"){
                        $status = $vaccination->status;
                        if($status==1){
                            $status=0;
                        } else{
                            $status=1;
                        }
                        $vaccination->status=$status;
                        $vaccination->save();
                    }
                    
            return true;
      } else{
        return false;
      }
    }

    public function deleteOne($id){
      $vaccination = $this->getVaccination($id);
      if(count($vaccination)){
        $img = public_path().'/uploads/'.$vaccination->featured_img;
            if($vaccination->featured_img!='' && file_exists($img)){
                unlink($img);
            }
            $vaccination->delete();
        return true;
      } else{
        return false;
      }
    }
    
    public function getVaccinationData($per_page, $searchBy, $searchValue, $sortBy, $order){
      $vaccination = Vaccination::select(array('vaccination.*'));
      
      //join
        

        // where condition
        if($searchBy!='' && $searchValue!=''){
          $vaccination->where($searchBy, 'like', '%'.$searchValue.'%');
        }

        // sort option
        if($sortBy!='' && $order!=''){
          $vaccination->orderBy($sortBy, $order);
        } else{
          $vaccination->orderBy('vaccination.id', 'desc');
        }        

        return $vaccination->paginate($per_page);
    }

    public function getVaccinationExport($searchBy='', $searchValue='', $sortBy='', $order=''){
      $vaccination = Vaccination::select(array('vaccination.*'));

      //join
        

        // where condition
        if($searchBy!='' && $searchValue!='') {
          $vaccination->where($searchBy, 'like', '%'.$searchValue.'%');
        }

        if (isset($rel_arr) && !empty($rel_arr)) {
            $products->where($rel_arr['rel_field'], '=', $rel_arr['rel_id']);
        }

        // sort option
        if($sortBy!='' && $order!=''){
          $vaccination->orderBy($sortBy, $order);
        } else{
          $vaccination->orderBy('vaccination.id', 'desc');
        }
        return $vaccination->get();
    }

    public function updateVaccination($request){
      $id = $request->input('id');
      $vaccination = Vaccination::getVaccination($id);
      if(count($vaccination)){

          $vaccination->vaccination_name = $request->input('vaccination_name')!="" ? $request->input('vaccination_name') : "";
	$vaccination->vaccination_chart = $request->input('vaccination_chart')!="" ? $request->input('vaccination_chart') : "";
	$vaccination->vaccination_date = $request->input('vaccination_date')!="" ? $request->input('vaccination_date') : "";
	$vaccination->vaccination_banner = $request->input('vaccination_banner')=="" ? $request->input('old_vaccination_banner') : $request->input('vaccination_banner') ;
	
                    // image upload code
                    $vaccination_banner_name='';
                    $vaccination_banner_file = $request->file('vaccination_banner');
                    if(!is_null($vaccination_banner_file) && in_array($vaccination_banner_file->getClientOriginalExtension(), $this->allow_image)){
                        $vaccination_banner_name = time().'_'.$vaccination_banner_file->getClientOriginalName();
                        $vaccination_banner_file->move('uploads',$vaccination_banner_name);
                        $vaccination->vaccination_banner = $vaccination_banner_name;
                    }
                    
	$vaccination->status = $request->input('status')!="" ? $request->input('status') : "";

          $vaccination->save();
          return true;
      } else{
        return false;
      }
    }

    public function addVaccination($request){
      $vaccination = new Vaccination;

        $vaccination->vaccination_name = $request->input('vaccination_name')!="" ? $request->input('vaccination_name') : "";
	$vaccination->vaccination_chart = $request->input('vaccination_chart')!="" ? $request->input('vaccination_chart') : "";
	$vaccination->vaccination_date = $request->input('vaccination_date')!="" ? $request->input('vaccination_date') : "";
	$vaccination->vaccination_banner = $request->input('vaccination_banner')=="" ? $request->input('old_vaccination_banner') : $request->input('vaccination_banner') ;
	
                    // image upload code
                    $vaccination_banner_name='';
                    $vaccination_banner_file = $request->file('vaccination_banner');
                    if(!is_null($vaccination_banner_file) && in_array($vaccination_banner_file->getClientOriginalExtension(), $this->allow_image)){
                        $vaccination_banner_name = time().'_'.$vaccination_banner_file->getClientOriginalName();
                        $vaccination_banner_file->move('uploads',$vaccination_banner_name);
                        $vaccination->vaccination_banner = $vaccination_banner_name;
                    }
                    
	$vaccination->status = $request->input('status')!="" ? $request->input('status') : "";

        $vaccination->save();
        return $vaccination->id;
    }
}
