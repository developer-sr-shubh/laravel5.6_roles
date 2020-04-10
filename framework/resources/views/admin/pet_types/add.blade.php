@extends('master')

@section('content')
  <!-- page content -->
<div class="right_col" role="main">
  <div class="row x_panel">
    <div class="col-md-12 col-sm-12 col-xs-12">
    <h1>Pet_types</h1>

<form action="<?php echo url('/'); ?>/admin/pet_types/add" id="" class="form-horizontal " method="post" enctype="multipart/form-data">
{{ csrf_field() }}

    


	<!-- Pet_type Start -->
	<div class="form-group">
	  <label for="pet_type" class="col-sm-3 control-label"> Pet_type </label>
	  <div class="col-sm-4">
	    <input type="text" class="form-control" id="pet_type" name="pet_type" 
	    value="{{ old('pet_type') }}">
	  </div>
	  <div class="col-sm-5">
      <div class="label label-danger">{{ $errors->first("pet_type") }}</div>
      </div>
	</div> 
	<!-- Pet_type End -->


	

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

