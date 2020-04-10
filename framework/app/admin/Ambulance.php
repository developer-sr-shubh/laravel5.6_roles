<?php

namespace App\admin;
use DB;
use Illuminate\Database\Eloquent\Model;

class Ambulance extends Model
{
    protected $table = 'ambulance';
    protected $primaryKey = 'id';
    public $timestamps = false;
    public $allow_image = array('png', 'jpg', 'jpeg', 'gif');

    public function getAll($table){
      return DB::table($table)->get();
    }


    public function getAmbulance($id){
      $data =  Ambulance::where('id', $id)->get();
      if(count($data)){
        return $data[0];
      } else{
        return array();
      }
    }

    public function getAmbulanceView($id){
      $ambulance = Ambulance::select(array('ambulance.*'));
      $ambulance->where('ambulance.id', $id);
      
      return $ambulance->get()[0];

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
      $ambulance = $this->getAmbulance($id);
      if(count($ambulance)){
        
                    if($field=="status"){
                        $status = $ambulance->status;
                        if($status==1){
                            $status=0;
                        } else{
                            $status=1;
                        }
                        $ambulance->status=$status;
                        $ambulance->save();
                    }
                    
            return true;
      } else{
        return false;
      }
    }

    public function deleteOne($id){
      $ambulance = $this->getAmbulance($id);
      if(count($ambulance)){
        $img = public_path().'/uploads/'.$ambulance->featured_img;
            if($ambulance->featured_img!='' && file_exists($img)){
                unlink($img);
            }
            $ambulance->delete();
        return true;
      } else{
        return false;
      }
    }
    
    public function getAmbulanceData($per_page, $searchBy, $searchValue, $sortBy, $order){
      $ambulance = Ambulance::select(array('ambulance.*'));
      
      //join
        

        // where condition
        if($searchBy!='' && $searchValue!=''){
          $ambulance->where($searchBy, 'like', '%'.$searchValue.'%');
        }

        // sort option
        if($sortBy!='' && $order!=''){
          $ambulance->orderBy($sortBy, $order);
        } else{
          $ambulance->orderBy('ambulance.id', 'desc');
        }        

        return $ambulance->paginate($per_page);
    }

    public function getAmbulanceExport($searchBy='', $searchValue='', $sortBy='', $order=''){
      $ambulance = Ambulance::select(array('ambulance.*'));

      //join
        

        // where condition
        if($searchBy!='' && $searchValue!='') {
          $ambulance->where($searchBy, 'like', '%'.$searchValue.'%');
        }

        if (isset($rel_arr) && !empty($rel_arr)) {
            $products->where($rel_arr['rel_field'], '=', $rel_arr['rel_id']);
        }

        // sort option
        if($sortBy!='' && $order!=''){
          $ambulance->orderBy($sortBy, $order);
        } else{
          $ambulance->orderBy('ambulance.id', 'desc');
        }
        return $ambulance->get();
    }

    public function updateAmbulance($request){
      $id = $request->input('id');
      $ambulance = Ambulance::getAmbulance($id);
      if(count($ambulance)){

          $ambulance->ambulance_contact = $request->input('ambulance_contact')!="" ? $request->input('ambulance_contact') : "";
	$ambulance->status = $request->input('status')!="" ? $request->input('status') : "";

          $ambulance->save();
          return true;
      } else{
        return false;
      }
    }

    public function addAmbulance($request){
      $ambulance = new Ambulance;

        $ambulance->ambulance_contact = $request->input('ambulance_contact')!="" ? $request->input('ambulance_contact') : "";
  $ambulance->status = $request->input('status') ?? 0;
	$ambulance->created = date('Y-m-d H:i:s') ;

        $ambulance->save();
        return $ambulance->id;
    }
}
