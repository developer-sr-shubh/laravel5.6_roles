<?php

namespace App\admin;
use DB;
use Illuminate\Database\Eloquent\Model;

class Pet_types extends Model
{
    protected $table = 'pet_types';
    protected $primaryKey = 'id';
    public $timestamps = false;
    public $allow_image = array('png', 'jpg', 'jpeg', 'gif');

    public function getAll($table){
      return DB::table($table)->get();
    }


    public function getPet_types($id){
      $data =  Pet_types::where('id', $id)->get();
      if(count($data)){
        return $data[0];
      } else{
        return array();
      }
    }

    public function getPet_typesView($id){
      $pet_types = Pet_types::select(array('pet_types.*'));
      $pet_types->where('pet_types.id', $id);
      
      return $pet_types->get()[0];

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
      $pet_types = $this->getPet_types($id);
      if(count($pet_types)){
        
                    if($field=="status"){
                        $status = $pet_types->status;
                        if($status==1){
                            $status=0;
                        } else{
                            $status=1;
                        }
                        $pet_types->status=$status;
                        $pet_types->save();
                    }
                    
            return true;
      } else{
        return false;
      }
    }

    public function deleteOne($id){
      $pet_types = $this->getPet_types($id);
      if(count($pet_types)){
        $img = public_path().'/uploads/'.$pet_types->featured_img;
            if($pet_types->featured_img!='' && file_exists($img)){
                unlink($img);
            }
            $pet_types->delete();
        return true;
      } else{
        return false;
      }
    }
    
    public function getPet_typesData($per_page, $searchBy, $searchValue, $sortBy, $order){
      $pet_types = Pet_types::select(array('pet_types.*'));
      
      //join
        

        // where condition
        if($searchBy!='' && $searchValue!=''){
          $pet_types->where($searchBy, 'like', '%'.$searchValue.'%');
        }

        // sort option
        if($sortBy!='' && $order!=''){
          $pet_types->orderBy($sortBy, $order);
        } else{
          $pet_types->orderBy('pet_types.id', 'desc');
        }        

        return $pet_types->paginate($per_page);
    }

    public function getPet_typesExport($searchBy='', $searchValue='', $sortBy='', $order=''){
      $pet_types = Pet_types::select(array('pet_types.*'));

      //join
        

        // where condition
        if($searchBy!='' && $searchValue!='') {
          $pet_types->where($searchBy, 'like', '%'.$searchValue.'%');
        }

        if (isset($rel_arr) && !empty($rel_arr)) {
            $products->where($rel_arr['rel_field'], '=', $rel_arr['rel_id']);
        }

        // sort option
        if($sortBy!='' && $order!=''){
          $pet_types->orderBy($sortBy, $order);
        } else{
          $pet_types->orderBy('pet_types.id', 'desc');
        }
        return $pet_types->get();
    }

    public function updatePet_types($request){
      $id = $request->input('id');
      $pet_types = Pet_types::getPet_types($id);
      if(count($pet_types)){

          $pet_types->pet_type = $request->input('pet_type')!="" ? $request->input('pet_type') : "";
	$pet_types->status = $request->input('status')!="" ? $request->input('status') : "";

          $pet_types->save();
          return true;
      } else{
        return false;
      }
    }

    public function addPet_types($request){
      $pet_types = new Pet_types;

        $pet_types->pet_type = $request->input('pet_type')!="" ? $request->input('pet_type') : "";
	$pet_types->status = $request->input('status')!="" ? $request->input('status') : "";

        $pet_types->save();
        return $pet_types->id;
    }
}
