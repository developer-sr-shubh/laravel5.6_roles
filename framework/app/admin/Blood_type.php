<?php

namespace App\admin;
use DB;
use Illuminate\Database\Eloquent\Model;

class Blood_type extends Model
{
    protected $table = 'blood_type';
    protected $primaryKey = 'id';
    public $timestamps = false;
    public $allow_image = array('png', 'jpg', 'jpeg', 'gif');

    public function getAll($table){
      return DB::table($table)->get();
    }


    public function getBlood_type($id){
      $data =  Blood_type::where('id', $id)->get();
      if(count($data)){
        return $data[0];
      } else{
        return array();
      }
    }

    public function getBlood_typeView($id){
      $blood_type = Blood_type::select(array('blood_type.*'));
      $blood_type->where('blood_type.id', $id);
      
      return $blood_type->get()[0];

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
      $blood_type = $this->getBlood_type($id);
      if(count($blood_type)){
        
                    if($field=="status"){
                        $status = $blood_type->status;
                        if($status==1){
                            $status=0;
                        } else{
                            $status=1;
                        }
                        $blood_type->status=$status;
                        $blood_type->save();
                    }
                    
            return true;
      } else{
        return false;
      }
    }

    public function deleteOne($id){
      $blood_type = $this->getBlood_type($id);
      if(count($blood_type)){
        $img = public_path().'/uploads/'.$blood_type->featured_img;
            if($blood_type->featured_img!='' && file_exists($img)){
                unlink($img);
            }
            $blood_type->delete();
        return true;
      } else{
        return false;
      }
    }
    
    public function getBlood_typeData($per_page, $searchBy, $searchValue, $sortBy, $order){
      $blood_type = Blood_type::select(array('blood_type.*'));
      
      //join
        

        // where condition
        if($searchBy!='' && $searchValue!=''){
          $blood_type->where($searchBy, 'like', '%'.$searchValue.'%');
        }

        // sort option
        if($sortBy!='' && $order!=''){
          $blood_type->orderBy($sortBy, $order);
        } else{
          $blood_type->orderBy('blood_type.id', 'desc');
        }        

        return $blood_type->paginate($per_page);
    }

    public function getBlood_typeExport($searchBy='', $searchValue='', $sortBy='', $order=''){
      $blood_type = Blood_type::select(array('blood_type.*'));

      //join
        

        // where condition
        if($searchBy!='' && $searchValue!='') {
          $blood_type->where($searchBy, 'like', '%'.$searchValue.'%');
        }

        if (isset($rel_arr) && !empty($rel_arr)) {
            $products->where($rel_arr['rel_field'], '=', $rel_arr['rel_id']);
        }

        // sort option
        if($sortBy!='' && $order!=''){
          $blood_type->orderBy($sortBy, $order);
        } else{
          $blood_type->orderBy('blood_type.id', 'desc');
        }
        return $blood_type->get();
    }

    public function updateBlood_type($request){
      $id = $request->input('id');
      $blood_type = Blood_type::getBlood_type($id);
      if(count($blood_type)){

          $blood_type->blood_group = $request->input('blood_group')!="" ? $request->input('blood_group') : "";
	$blood_type->status = $request->input('status')!="" ? $request->input('status') : "";

          $blood_type->save();
          return true;
      } else{
        return false;
      }
    }

    public function addBlood_type($request){
      $blood_type = new Blood_type;

        $blood_type->blood_group = $request->input('blood_group')!="" ? $request->input('blood_group') : "";
	$blood_type->status = $request->input('status')!="" ? $request->input('status') : "";

        $blood_type->save();
        return $blood_type->id;
    }
}
