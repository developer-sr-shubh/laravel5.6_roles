@extends('master')

@section('content')
  <!-- page content -->
<div class="right_col" role="main">
  <div class="row x_panel">
    <div class="col-md-12 col-sm-12 col-xs-12">
    <h1>Pets</h1>

<form action="<?php echo url('/'); ?>/admin/pets/add" id="" class="form-horizontal " method="post" enctype="multipart/form-data">
{{ csrf_field() }}

    
	<!-- Pet_type Start -->
    <div class="form-group">
        <label for="pet_type" class="control-label col-md-3"> Pet_type </label>
          <div class="col-md-4">
          <select id="pet_type" name="pet_type" class="form-control select2">
            <?php
              foreach ($pet_types as $value) {
                echo '<option value="'.$value->id.'"> '.$value->pet_type.'</option>';
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
	    value="{{ old('name') }}">
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
            <span style="margin-right:20px;"><input type="radio" style="width:20px; height:20px;" name="gender" value="Male"   @if(old('gender')=='Male') checked @endif > Male </span>
            <span style="margin-right:20px;"><input type="radio" style="width:20px; height:20px;" name="gender" value="Female"   @if(old('gender')=='Female') checked @endif > Female </span>
        </div>
        <div class="col-sm-5">
        <div class="label label-danger">{{ $errors->first("gender") }}</div>
      </div>
    </div>
      <!-- Gender End -->



	<!-- Birth_date Start -->
	<div class="form-group">
	  <label for="birth_date" class="col-sm-3 control-label"> Birth_date </label>
	  <div class="col-sm-4">
	    <input type="text" class="form-control span2 date" id="birth_date" name="birth_date" value="{{ old('birth_date') }}">
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
	    value="{{ old('weight') }}">
	  </div>
	  <div class="col-sm-5">
      <div class="label label-danger">{{ $errors->first("weight") }}</div>
      </div>
	</div> 
	<!-- Weight End -->


	
	<!-- Blood_group Start -->
    <div class="form-group">
        <label for="blood_group" class="control-label col-md-3"> Blood_group </label>
          <div class="col-md-4">
          <select id="blood_group" name="blood_group" class="form-control select2">
            <?php
              foreach ($blood_type as $value) {
                echo '<option value="'.$value->id.'"> '.$value->blood_group.'</option>';
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
			    <textarea class="form-control" id="address" name="address">{{ old('address') }}</textarea>
			  </div>
			  <div class="col-sm-5">
         <div class="label label-danger">{{ $errors->first("address") }}</div>
      </div>
			</div> 
			<!-- Address End -->

			

    <!-- Ehr_document Start -->
    <div class="form-group">
      <label for="address" class="col-sm-3 control-label"> Ehr_document </label>
      <div class="col-sm-6">
      <input type="file" name="ehr_document" />
      <input type="hidden" name="old_ehr_document" value="<?php if (isset($ehr_document) && $ehr_document!=""){echo $ehr_document; } ?>" />
        <?php if(isset($ehr_document_err) && !empty($ehr_document_err)) 
        { foreach($ehr_document_err as $key => $error)
        { echo "<div class=\"error-msg\"></div>"; } }?>
      </div>
        <div class="col-sm-3" >
      </div>
      <div class="col-sm-5">
        <div class="label label-danger">{{ $errors->first("ehr_document") }}</div>
      </div>
    </div>
    <!-- Ehr_document End -->

    

	<!-- Status Start -->
	<div class="form-group">
        <label class="control-label col-md-3">Status</label>
         <div class=" col-md-4 switch">
                    <div class="onoffswitch">
     <input type="checkbox" class="onoffswitch-checkbox"  data-on-label="Yes" data-off-label="No"  name="status" value="0" id="status"  style="width:20px; height:20px;"/>
    {{ $errors->first("status") }}
                        <label class="onoffswitch-label" for="status">
                            <span class="onoffswitch-switch"></span>
                            <span class="onoffswitch-inner"></span>
                        </label>
                    </div>
                </div>

      </div>
      <!-- Status End -->



  <div class="form-group">
    <div class="col-sm-3" >
      </div>
      <div class="col-sm-6">
    <button type="reset" class="btn btn-default ">Reset</button>
    <button type="submit" class="btn btn-info ">Submit</button>
      </div>
        <div class="col-sm-3" >
      </div>
  </div>
</form>



    </div>
  </div>
</div>
<!-- /page content -->
@endsection

