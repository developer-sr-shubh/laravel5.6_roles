@extends('master')

@section('content')


<!-- page content -->
<div class="right_col" role="main">
  <div class="row x_panel">
    <div class="col-md-12 col-sm-12 col-xs-12">
    <h1>Register_user</h1>
<?php if(isset($data)){ ?>
<form action="controller/pages_submit.php" id="" class="form-horizontal " method="post" enctype="multipart/form-data">
  <div class="table-responsive">
    <table class="table table-striped table-bordered table-hover" >
      
<table class='table table-bordered' style='width:70%;' align='center'>
	<tr>
	 <td>
	   <label for="name" class="col-sm-3 control-label"> Name </label>
	 </td>
	 <td> 
	   {{{ $data->name }}}
	 </td>
	</tr>
	
	<tr>
	 <td>
	   <label for="email" class="col-sm-3 control-label"> Email </label>
	 </td>
	 <td> 
	   {{{ $data->email }}}
	 </td>
	</tr>
	
	<tr>
	 <td>
	   <label for="contact" class="col-sm-3 control-label"> Contact </label>
	 </td>
	 <td> 
	   {{{ $data->contact }}}
	 </td>
	</tr>
	

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
