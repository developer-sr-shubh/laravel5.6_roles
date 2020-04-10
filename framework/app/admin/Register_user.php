<?php

namespace App\admin;
use DB;
use Illuminate\Database\Eloquent\Model;

class Register_user extends Model
{
    protected $table = 'register_user';
    protected $primaryKey = 'id';
    public $timestamps = false;
    public $allow_image = array('png', 'jpg', 'jpeg', 'gif');

    public function getAll($table){
      return DB::table($table)->get();
    }


    public function getRegister_user($id){
      $data =  Register_user::where('id', $id)->get();
      if(count($data)){
        return $data[0];
      } else{
        return array();
      }
    }

    public function getRegister_userView($id){
      $register_user = Register_user::select(array('register_user.*'));
      $register_user->where('register_user.id', $id);
      
      return $register_user->get()[0];

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
      $register_user = $this->getRegister_user($id);
      if(count($register_user)){
        
                    if($field=="status"){
                        $status = $register_user->status;
                        if($status==1){
                            $status=0;
                        } else{
                            $status=1;
                        }
                        $register_user->status=$status;
                        $register_user->save();
                    }
                    
            return true;
      } else{
        return false;
      }
    }

    public function deleteOne($id){
      $register_user = $this->getRegister_user($id);
      if(count($register_user)){
        $img = public_path().'/uploads/'.$register_user->featured_img;
            if($register_user->featured_img!='' && file_exists($img)){
                unlink($img);
            }
            $register_user->delete();
        return true;
      } else{
        return false;
      }
    }
    
    public function getRegister_userData($per_page, $searchBy, $searchValue, $sortBy, $order){
      $register_user = Register_user::select(array('register_user.*'));
      
      //join
        

        // where condition
        if($searchBy!='' && $searchValue!=''){
          $register_user->where($searchBy, 'like', '%'.$searchValue.'%');
        }

        // sort option
        if($sortBy!='' && $order!=''){
          $register_user->orderBy($sortBy, $order);
        } else{
          $register_user->orderBy('register_user.id', 'desc');
        }        

        return $register_user->paginate($per_page);
    }

    public function getRegister_userExport($searchBy='', $searchValue='', $sortBy='', $order=''){
      $register_user = Register_user::select(array('register_user.*'));

      //join
        

        // where condition
        if($searchBy!='' && $searchValue!='') {
          $register_user->where($searchBy, 'like', '%'.$searchValue.'%');
        }

        if (isset($rel_arr) && !empty($rel_arr)) {
            $products->where($rel_arr['rel_field'], '=', $rel_arr['rel_id']);
        }

        // sort option
        if($sortBy!='' && $order!=''){
          $register_user->orderBy($sortBy, $order);
        } else{
          $register_user->orderBy('register_user.id', 'desc');
        }
        return $register_user->get();
    }

    public function updateRegister_user($request){
      $id = $request->input('id');
      $register_user = Register_user::getRegister_user($id);
      if(count($register_user)){

          $register_user->name = $request->input('name')!="" ? $request->input('name') : "";
	$register_user->email = $request->input('email')!="" ? $request->input('email') : "";
	$register_user->contact = $request->input('contact')!="" ? $request->input('contact') : "";
	$register_user->status = $request->input('status')!="" ? $request->input('status') : "";

          $register_user->save();
          return true;
      } else{
        return false;
      }
    }

    public function addRegister_user($request){
      $register_user = new Register_user;

        $register_user->name = $request->input('name')!="" ? $request->input('name') : "";
	$register_user->email = $request->input('email')!="" ? $request->input('email') : "";
	$register_user->contact = $request->input('contact')!="" ? $request->input('contact') : "";
	$register_user->status = $request->input('status')!="" ? $request->input('status') : "";

        $register_user->save();
        return $register_user->id;
    }
}
