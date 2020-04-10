@extends('master')

@section('content')
  <!-- page content -->
<div class="right_col" role="main">
  <div class="row x_panel">
    <div class="col-md-12 col-sm-12 col-xs-12">
    <h1>Vaccination</h1>

<form action="<?php echo url('/'); ?>/admin/vaccination/add" id="" class="form-horizontal " method="post" enctype="multipart/form-data">
{{ csrf_field() }}

    


	<!-- Vaccination_name Start -->
	<div class="form-group">
	  <label for="vaccination_name" class="col-sm-3 control-label"> Vaccination_name </label>
	  <div class="col-sm-4">
	    <input type="text" class="form-control" id="vaccination_name" name="vaccination_name" 
	    value="{{ old('vaccination_name') }}">
	  </div>
	  <div class="col-sm-5">
      <div class="label label-danger">{{ $errors->first("vaccination_name") }}</div>
      </div>
	</div> 
	<!-- Vaccination_name End -->


	


	<!-- Vaccination_chart Start -->
	<div class="form-group">
	  <label for="vaccination_chart" class="col-sm-3 control-label"> Vaccination_chart </label>
	  <div class="col-sm-4">
	    <input type="text" class="form-control" id="vaccination_chart" name="vaccination_chart" 
	    value="{{ old('vaccination_chart') }}">
	  </div>
	  <div class="col-sm-5">
      <div class="label label-danger">{{ $errors->first("vaccination_chart") }}</div>
      </div>
	</div> 
	<!-- Vaccination_chart End -->


	

	<!-- Vaccination_date Start -->
	<div class="form-group">
	  <label for="vaccination_date" class="col-sm-3 control-label"> Vaccination_date </label>
	  <div class="col-sm-4">
	    <input type="text" class="form-control span2 date" id="vaccination_date" name="vaccination_date" value="{{ old('vaccination_date') }}">
	  </div>
	  <div class="col-sm-5">
         <div class="label label-danger">{{ $errors->first("vaccination_date") }}</div>
      </div>
	</div> 
	<!-- Vaccination_date End -->

	

    <!-- Vaccination_banner Start -->
    <div class="form-group">
      <label for="address" class="col-sm-3 control-label"> Vaccination_banner </label>
      <div class="col-sm-6">
      <input type="file" name="vaccination_banner" />
      <input type="hidden" name="old_vaccination_banner" value="<?php if (isset($vaccination_banner) && $vaccination_banner!=""){echo $vaccination_banner; } ?>" />
        <?php if(isset($vaccination_banner_err) && !empty($vaccination_banner_err)) 
        { foreach($vaccination_banner_err as $key => $error)
        { echo "<div class=\"error-msg\"></div>"; } }?>
      </div>
        <div class="col-sm-3" >
      </div>
      <div class="col-sm-5">
        <div class="label label-danger">{{ $errors->first("vaccination_banner") }}</div>
      </div>
    </div>
    <!-- Vaccination_banner End -->

    

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

