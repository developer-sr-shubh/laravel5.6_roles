@extends('master')

@section('content')
<!-- vaccination content -->
<div class="right_col" role="main">
  <div class="row x_panel">
    <div class="col-md-12 col-sm-12 col-xs-12">
    <h1>Vaccination</h1>
<?php if(isset($data)){ ?>
<form action="<?php echo url('/'); ?>/admin/vaccination/edit" id="" class="form-horizontal " method="post" enctype="multipart/form-data">
{{ csrf_field() }}
<input type="hidden" name="id" value="<?php echo $data->id; ?>">


<!-- Vaccination_name Start -->
<div class="form-group">
  <label for="vaccination_name" class="col-sm-3 control-label"> Vaccination_name </label>
  <div class="col-sm-4">
    <input type="text" class="form-control" id="vaccination_name" name="vaccination_name" 
    
    value="{{{ $data->vaccination_name }}}"
    >
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
    
    value="{{{ $data->vaccination_chart }}}"
    >
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
    <input type="text" class="form-control span2 date" id="vaccination_date" name="vaccination_date" value="{{{ $data->vaccination_date }}}">
  </div>
  <div class="col-sm-5">
         <div class="label label-danger">{{ $errors->first("vaccination_date") }}</div>
      </div>
</div> 
<!-- Vaccination_date End -->



    <!-- Vaccination_banner Start -->
    <div class="form-group">
      <label for="vaccination_banner" class="control-label col-md-3"> Vaccination_banner </label>
        <div class="col-md-4">
          <input type="file" id="vaccination_banner" name="vaccination_banner" /><br>
          <?php if($data->vaccination_banner!=''){
            echo '<img src="'.url('/')."/uploads/{$data->vaccination_banner}".'" style="width:100px;">'; 
            } ?>
            <input type="hidden" name="old_vaccination_banner" value="<?php echo $data->vaccination_banner; ?>">
      </div>
      <div class="col-sm-5">
          <div class="label label-danger">{{ $errors->first("vaccination_banner") }}</div>
      </div>
    </div>
    <!-- Vaccination_banner End -->

    

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
<!-- /vaccination content -->
@endsection