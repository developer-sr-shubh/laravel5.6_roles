@extends('master')

@section('content')
  <!-- page content -->
<div class="right_col" role="main">
  <div class="row x_panel">
    <div class="col-md-12 col-sm-12 col-xs-12">
    <h1>Register_user</h1>

<form action="<?php echo url('/'); ?>/admin/register_user/add" id="" class="form-horizontal " method="post" enctype="multipart/form-data">
{{ csrf_field() }}

    


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


	


	<!-- Email Start -->
	<div class="form-group">
	  <label for="email" class="col-sm-3 control-label"> Email </label>
	  <div class="col-sm-4">
	    <input type="text" class="form-control" id="email" name="email" 
	    value="{{ old('email') }}">
	  </div>
	  <div class="col-sm-5">
      <div class="label label-danger">{{ $errors->first("email") }}</div>
      </div>
	</div> 
	<!-- Email End -->


	


	<!-- Contact Start -->
	<div class="form-group">
	  <label for="contact" class="col-sm-3 control-label"> Contact </label>
	  <div class="col-sm-4">
	    <input type="text" class="form-control" id="contact" name="contact" 
	    value="{{ old('contact') }}">
	  </div>
	  <div class="col-sm-5">
      <div class="label label-danger">{{ $errors->first("contact") }}</div>
      </div>
	</div> 
	<!-- Contact End -->


	

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

