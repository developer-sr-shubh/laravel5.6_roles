@extends('master')

@section('content')
<!-- pet_types content -->
<div class="right_col" role="main">
  <div class="row x_panel">
    <div class="col-md-12 col-sm-12 col-xs-12">
    <h1>Pet_types</h1>
<?php if(isset($data)){ ?>
<form action="<?php echo url('/'); ?>/admin/pet_types/edit" id="" class="form-horizontal " method="post" enctype="multipart/form-data">
{{ csrf_field() }}
<input type="hidden" name="id" value="<?php echo $data->id; ?>">


<!-- Pet_type Start -->
<div class="form-group">
  <label for="pet_type" class="col-sm-3 control-label"> Pet_type </label>
  <div class="col-sm-4">
    <input type="text" class="form-control" id="pet_type" name="pet_type" 
    
    value="{{{ $data->pet_type }}}"
    >
  </div>
  <div class="col-sm-5">
         <div class="label label-danger">{{ $errors->first("pet_type") }}</div>
      </div>
</div> 
<!-- Pet_type End -->



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
<!-- /pet_types content -->
@endsection