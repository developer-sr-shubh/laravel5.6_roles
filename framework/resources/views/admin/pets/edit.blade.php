@extends('master')

@section('content')
<!-- pets content -->
<div class="right_col" role="main">
  <div class="row x_panel">
    <div class="col-md-12 col-sm-12 col-xs-12">
    <h1>Pets</h1>
<?php if(isset($data)){ ?>
<form action="<?php echo url('/'); ?>/admin/pets/edit" id="" class="form-horizontal " method="post" enctype="multipart/form-data">
{{ csrf_field() }}
<input type="hidden" name="id" value="<?php echo $data->id; ?>">


	<!-- Pet_type Start -->
    <div class="form-group">
        <label for="user_id" class="control-label col-md-3"> Pet_type </label>
          <div class="col-md-4">
          <select id="pet_type" name="pet_type" class="form-control select2">
            <?php
              foreach ($pet_types as $value) {
                $selected = $data->pet_type==$value->id?'selected="selected"':'';
                echo '<option '.$selected.' value="'.$value->id.'"> '.$value->pet_type.'</option>';
              }
            ?>
          </select>
        </div>
        <div class="col-sm-5">
         <div class="label label-danger">{{ $errors->first("pet_type") }}</div>
      </div>
    </div>
      <!-- Pet_type End -->



<!-- Name Start -->
<div class="form-group">
  <label for="name" class="col-sm-3 control-label"> Name </label>
  <div class="col-sm-4">
    <input type="text" class="form-control" id="name" name="name" 
    
    value="{{{ $data->name }}}"
    >
  </div>
  <div class="col-sm-5">
         <div class="label label-danger">{{ $errors->first("name") }}</div>
      </div>
</div> 
<!-- Name End -->



	<!-- Gender Start -->
	<div class="form-group">
        <label class="col-sm-3 control-label">Select Gender</label>
        <div class="col-sm-4">
            <span style="margin-right:20px;"><input type="radio" style="width:20px; height:20px;" <?php echo $data->gender=="Male"?'checked="checked"':""; ?> name="gender" value="Male"> Male </span>
            <span style="margin-right:20px;"><input type="radio" style="width:20px; height:20px;" <?php echo $data->gender=="Female"?'checked="checked"':""; ?> name="gender" value="Female"> Female </span>
        </div>
	</div>
	<!-- Gender End -->

	

<!-- Birth_date Start -->
<div class="form-group">
  <label for="birth_date" class="col-sm-3 control-label"> Birth_date </label>
  <div class="col-sm-4">
    <input type="text" class="form-control span2 date" id="birth_date" name="birth_date" value="{{{ $data->birth_date }}}">
  </div>
  <div class="col-sm-5">
         <div class="label label-danger">{{ $errors->first("birth_date") }}</div>
      </div>
</div> 
<!-- Birth_date End -->



<!-- Weight Start -->
<div class="form-group">
  <label for="weight" class="col-sm-3 control-label"> Weight </label>
  <div class="col-sm-4">
    <input type="text" class="form-control" id="weight" name="weight" 
    
    value="{{{ $data->weight }}}"
    >
  </div>
  <div class="col-sm-5">
         <div class="label label-danger">{{ $errors->first("weight") }}</div>
      </div>
</div> 
<!-- Weight End -->



	<!-- Blood_group Start -->
    <div class="form-group">
        <label for="user_id" class="control-label col-md-3"> Blood_group </label>
          <div class="col-md-4">
          <select id="blood_group" name="blood_group" class="form-control select2">
            <?php
              foreach ($blood_type as $value) {
                $selected = $data->blood_group==$value->id?'selected="selected"':'';
                echo '<option '.$selected.' value="'.$value->id.'"> '.$value->blood_group.'</option>';
              }
            ?>
          </select>
        </div>
        <div class="col-sm-5">
         <div class="label label-danger">{{ $errors->first("blood_group") }}</div>
      </div>
    </div>
      <!-- Blood_group End -->


<!-- Address Start -->

<div class="form-group">
  <label for="address" class="col-sm-3 control-label"> Address </label>
  <div class="col-sm-4">
    <textarea class="form-control" id="address" name="address">{{{ $data->address }}}</textarea>
  </div>
  <div class="col-sm-5">
         <div class="label label-danger">{{ $errors->first("address") }}</div>
      </div>
</div> 

<!-- Address End -->


    <!-- Ehr_document Start -->
    <div class="form-group">
      <label for="ehr_document" class="control-label col-md-3"> Ehr_document </label>
        <div class="col-md-4">
          <input type="file" id="ehr_document" name="ehr_document" /><br>
          <?php if($data->ehr_document!=''){
            echo '<img src="'.url('/')."/uploads/{$data->ehr_document}".'" style="width:100px;">'; 
            } ?>
            <input type="hidden" name="old_ehr_document" value="<?php echo $data->ehr_document; ?>">
      </div>
      <div class="col-sm-5">
          <div class="label label-danger">{{ $errors->first("ehr_document") }}</div>
      </div>
    </div>
    <!-- Ehr_document End -->

    

	<!-- Status Start -->
	 <div class="form-group">
        <label class="control-label col-md-3">Status
             
        </label>                    
         <div class=" col-md-4 switch">
                    <div class="onoffswitch">
     <input type="checkbox" class="onoffswitch-checkbox"  data-on-label="Yes" data-off-label="No"  name="status" value="1" id="status" <?php if($data->status == 1){echo "checked=checked";}?> style="width:20px; height:20px;"/>
                    </div>
                </div>
      </div>
      <!-- Status End -->


  <div class="form-group">
  <div class="col-sm-3">
  </div>
   <div class="col-sm-6">
    <button type="reset" class="btn btn-default ">Reset</button>
    <button type="submit" class="btn btn-info ">Submit</button>
   </div>
  </div>
</form>
<?php } else{
    echo '<h2 align="center" class="text-danger">No record found!</h2>';
  } ?>
    </div>
  </div>
</div>
<!-- /pets content -->
@endsection