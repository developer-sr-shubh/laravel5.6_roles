@extends('master')

@section('content')
<!-- register_user content -->
<div class="right_col" role="main">
  <div class="row x_panel">
    <div class="col-md-12 col-sm-12 col-xs-12">
    <h1>Register_user</h1>
<?php if(isset($data)){ ?>
<form action="<?php echo url('/'); ?>/admin/register_user/edit" id="" class="form-horizontal " method="post" enctype="multipart/form-data">
{{ csrf_field() }}
<input type="hidden" name="id" value="<?php echo $data->id; ?>">


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



<!-- Email Start -->
<div class="form-group">
  <label for="email" class="col-sm-3 control-label"> Email </label>
  <div class="col-sm-4">
    <input type="text" class="form-control" id="email" name="email" 
    
    value="{{{ $data->email }}}"
    >
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
    
    value="{{{ $data->contact }}}"
    >
  </div>
  <div class="col-sm-5">
         <div class="label label-danger">{{ $errors->first("contact") }}</div>
      </div>
</div> 
<!-- Contact End -->



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
<!-- /register_user content -->
@endsection