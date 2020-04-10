<?php

namespace App\admin;
use DB;
use Illuminate\Database\Eloquent\Model;

class Pets extends Model
{
    protected $table = 'pets';
    protected $primaryKey = 'id';
    public $timestamps = false;
    public $allow_image = array('png', 'jpg', 'jpeg', 'gif');

    public function getAll($table){
      return DB::table($table)->get();
    }


    public function getPets($id){
      $data =  Pets::where('id', $id)->get();
      if(count($data)){
        return $data[0];
      } else{
        return array();
      }
    }

    public function getPetsView($id){
      $pets = Pets::select(array('pets.*' , 'pet_types.pet_type' , 'blood_type.blood_group'));
      $pets->where('pets.id', $id);
      $pets->leftJoin('pet_types', 'pets.pet_type', '=','pet_types.id');$pets->leftJoin('blood_type', 'pets.blood_group', '=','blood_type.id');
      return $pets->get()[0];

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
      $pets = $this->getPets($id);
      if(count($pets)){
        
                    if($field=="status"){
                        $status = $pets->status;
                        if($status==1){
                            $status=0;
                        } else{
                            $status=1;
                        }
                        $pets->status=$status;
                        $pets->save();
                    }
                    
            return true;
      } else{
        return false;
      }
    }

    public function deleteOne($id){
      $pets = $this->getPets($id);
      if(count($pets)){
        $img = public_path().'/uploads/'.$pets->featured_img;
            if($pets->featured_img!='' && file_exists($img)){
                unlink($img);
            }
            $pets->delete();
        return true;
      } else{
        return false;
      }
    }
    
    public function getPetsData($per_page, $searchBy, $searchValue, $sortBy, $order){
      $pets = Pets::select(array('pets.*' , 'pet_types.pet_type' , 'blood_type.blood_group'));
      
      //join
        $pets->leftJoin('pet_types', 'pets.pet_type', '=','pet_types.id');$pets->leftJoin('blood_type', 'pets.blood_group', '=','blood_type.id');

        // where condition
        if($searchBy!='' && $searchValue!=''){
          $pets->where($searchBy, 'like', '%'.$searchValue.'%');
        }

        // sort option
        if($sortBy!='' && $order!=''){
          $pets->orderBy($sortBy, $order);
        } else{
          $pets->orderBy('pets.id', 'desc');
        }        

        return $pets->paginate($per_page);
    }

    public function getPetsExport($searchBy='', $searchValue='', $sortBy='', $order=''){
      $pets = Pets::select(array('pets.*' , 'pet_types.pet_type' , 'blood_type.blood_group'));

      //join
        $pets->leftJoin('pet_types', 'pets.pet_type', '=','pet_types.id');$pets->leftJoin('blood_type', 'pets.blood_group', '=','blood_type.id');

        // where condition
        if($searchBy!='' && $searchValue!='') {
          $pets->where($searchBy, 'like', '%'.$searchValue.'%');
        }

        if (isset($rel_arr) && !empty($rel_arr)) {
            $products->where($rel_arr['rel_field'], '=', $rel_arr['rel_id']);
        }

        // sort option
        if($sortBy!='' && $order!=''){
          $pets->orderBy($sortBy, $order);
        } else{
          $pets->orderBy('pets.id', 'desc');
        }
        return $pets->get();
    }

    public function updatePets($request){
      $id = $request->input('id');
      $pets = Pets::getPets($id);
      if(count($pets)){

          $pets->pet_type = $request->input('pet_type')!="" ? $request->input('pet_type') : "";
	$pets->name = $request->input('name')!="" ? $request->input('name') : "";
	$pets->gender = $request->input('gender')!="" ? $request->input('gender') : "";
	$pets->birth_date = $request->input('birth_date')!="" ? $request->input('birth_date') : "";
	$pets->weight = $request->input('weight')!="" ? $request->input('weight') : "";
	$pets->blood_group = $request->input('blood_group')!="" ? $request->input('blood_group') : "";
	$pets->address = $request->input('address')!="" ? $request->input('address') : "";
	$pets->ehr_document = $request->input('ehr_document')=="" ? $request->input('old_ehr_document') : $request->input('ehr_document') ;
	
                    // image upload code
                    $ehr_document_name='';
                    $ehr_document_file = $request->file('ehr_document');
                    if(!is_null($ehr_document_file) && in_array($ehr_document_file->getClientOriginalExtension(), $this->allow_image)){
                        $ehr_document_name = time().'_'.$ehr_document_file->getClientOriginalName();
                        $ehr_document_file->move('uploads',$ehr_document_name);
                        $pets->ehr_document = $ehr_document_name;
                    }
                    
	$pets->status = $request->input('status')!="" ? $request->input('status') : "";

          $pets->save();
          return true;
      } else{
        return false;
      }
    }

    public function addPets($request){
      $pets = new Pets;

        $pets->pet_type = $request->input('pet_type')!="" ? $request->input('pet_type') : "";
	$pets->name = $request->input('name')!="" ? $request->input('name') : "";
	$pets->gender = $request->input('gender')!="" ? $request->input('gender') : "";
	$pets->birth_date = $request->input('birth_date')!="" ? $request->input('birth_date') : "";
	$pets->weight = $request->input('weight')!="" ? $request->input('weight') : "";
	$pets->blood_group = $request->input('blood_group')!="" ? $request->input('blood_group') : "";
	$pets->address = $request->input('address')!="" ? $request->input('address') : "";
	$pets->ehr_document = $request->input('ehr_document')=="" ? $request->input('old_ehr_document') : $request->input('ehr_document') ;
	
                    // image upload code
                    $ehr_document_name='';
                    $ehr_document_file = $request->file('ehr_document');
                    if(!is_null($ehr_document_file) && in_array($ehr_document_file->getClientOriginalExtension(), $this->allow_image)){
                        $ehr_document_name = time().'_'.$ehr_document_file->getClientOriginalName();
                        $ehr_document_file->move('uploads',$ehr_document_name);
                        $pets->ehr_document = $ehr_document_name;
                    }
                    
	$pets->status = $request->input('status')!="" ? $request->input('status') : "";

        $pets->save();
        return $pets->id;
    }
}
