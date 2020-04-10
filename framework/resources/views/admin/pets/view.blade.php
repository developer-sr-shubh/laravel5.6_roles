@extends('master')

@section('content')


<!-- page content -->
<div class="right_col" role="main">
  <div class="row x_panel">
    <div class="col-md-12 col-sm-12 col-xs-12">
    <h1>Pets</h1>
<?php if(isset($data)){ ?>
<form action="controller/pages_submit.php" id="" class="form-horizontal " method="post" enctype="multipart/form-data">
  <div class="table-responsive">
    <table class="table table-striped table-bordered table-hover" >
      
<table class='table table-bordered' style='width:70%;' align='center'>

    <!-- Pet_type Start -->
	<tr>
	 <td>
	  <label class="control-label col-md-3"> Pet_type </label>
	 </td>
	 <td>
     {{{ $data->pet_type }}}
	 </td>
	</tr>
    <!-- Pet_type End -->

	
	<tr>
	 <td>
	   <label for="name" class="col-sm-3 control-label"> Name </label>
	 </td>
	 <td> 
	   {{{ $data->name }}}
	 </td>
	</tr>
	

    <!-- Gender Start -->
	<tr>
	 <td>
	  <label class="col-sm-3 control-label">Select Gender</label>
	 </td>
	 <td> 
	   
	   <?php echo $data->gender=="Male"?'Male':""; ?>
	   <?php echo $data->gender=="Female"?'Female':""; ?>
	 </td>
	</tr>
    <!-- Gender End -->

	

    <!-- Birth_date Start -->
	<tr>
	 <td>
	  <label for="birth_date" class="col-sm-3 control-label"> Birth_date </label>
	 </td>
	 <td> 
	   {{{ $data->birth_date }}}
	 </td>
	</tr>
    <!-- Birth_date End -->

	
	<tr>
	 <td>
	   <label for="weight" class="col-sm-3 control-label"> Weight </label>
	 </td>
	 <td> 
	   {{{ $data->weight }}}
	 </td>
	</tr>
	

    <!-- Blood_group Start -->
	<tr>
	 <td>
	  <label class="control-label col-md-3"> Blood_group </label>
	 </td>
	 <td>
     {{{ $data->blood_group }}}
	 </td>
	</tr>
    <!-- Blood_group End -->

	

    <!-- Address Start -->
	<tr>
	 <td>
	  <label for="address" class="col-sm-3 control-label"> Address </label>
	 </td>
	 <td> 
	   {{{ $data->address }}}
	 </td>
	</tr>
    <!-- Address End -->

	

    <!-- Ehr_document Start -->
	<tr>
	 <td>
	  <label for="address" class="col-sm-3 control-label"> Ehr_document </label>
	 </td>
     <td>
      <?php if($data->ehr_document!='')  echo '<img src="'.url('/').'/uploads/'.$data->ehr_document.'" style="width:100px">'; ?></td>
	 </td>
	</tr>
    <!-- Ehr_document End -->

	

    <!-- Status Start -->
	<tr>
	 <td>
	  <label class="control-label col-md-3">status</label>
	 </td>
	 <td> 
	   <?php if($data->status == 1){echo "Active";}else{ echo "Inactive";}?>
	 </td>
	</tr>
    <!-- Status End -->

	<tr><td colspan="2"><a type="reset" class="btn btn-info pull-right" onclick="history.back()">Back</a></td></tr></table>
    </table>
  </div>

  
</form>
<?php } else{
    echo '<h2 align="center" class="text-danger">No record found!</h2>';
  } ?>


    </div>
  </div>
</div>
<!-- /page content -->


@endsection
