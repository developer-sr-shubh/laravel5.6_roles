@extends('master')

@section('content')

<?php
$searchValue = isset($_GET['searchValue'])?$_GET['searchValue']:'';
$searchBy = isset($_GET['searchBy'])?$_GET['searchBy']:'';
$order_by = isset($_GET['order_by'])?$_GET['order_by']:'';
$order = isset($_GET['order'])?$_GET['order']:'';
$redirect = url('/').'/admin/pets?'.urlencode($_SERVER["QUERY_STRING"]);


?>
<!-- page content -->
<div class="right_col" role="main">
  <div class="row x_panel">
      @if(Session::has('message'))
          <div class="alert alert-success">
              <button type="button" class="close" data-close="alert"></button>
               {{ Session::get('message') }}
          </div>
    @endif
    <div class="pull-right">
      <a href="<?php echo $links['csvlink']; ?>" class="btn btn-success">CSV</a>
      <a href="<?php echo $links['pdflink']; ?>" class="btn btn-success">PDF</a>
    </div>
    <div class="pull-left">
      <a href="<?php echo url('/'); ?>/admin/pets/add" class="btn btn-success">Add Pets</a>
    </div>
    <br>
    <hr>

    <form method="GET" action="" class="form-inline ibox-content">
        <div class="form-group">
          <select name="searchBy" class="form-control">
           <option value="pet_types.pet_type" <?php echo $searchBy=="pet_types.pet_type"?'selected="selected"':""; ?>>Pet_type</option><option value="pets.name" <?php echo $searchBy=="pets.name"?'selected="selected"':""; ?>>Name</option><option value="pets.gender" <?php echo $searchBy=="pets.gender"?'selected="selected"':""; ?>>Gender</option><option value="pets.birth_date" <?php echo $searchBy=="pets.birth_date"?'selected="selected"':""; ?>>Birth_date</option><option value="pets.weight" <?php echo $searchBy=="pets.weight"?'selected="selected"':""; ?>>Weight</option><option value="blood_type.blood_group" <?php echo $searchBy=="blood_type.blood_group"?'selected="selected"':""; ?>>Blood_group</option><option value="pets.address" <?php echo $searchBy=="pets.address"?'selected="selected"':""; ?>>Address</option><option value="pets.ehr_document" <?php echo $searchBy=="pets.ehr_document"?'selected="selected"':""; ?>>Ehr_document</option><option value="pets.status" <?php echo $searchBy=="pets.status"?'selected="selected"':""; ?>>Status</option>
          </select>
        </div>
        <div class="form-group">
          <input type="text" name="searchValue" id="searchValue" class="form-control" value="<?php echo $searchValue; ?>">
        </div>
        <input type="submit" name="search" value="Search" class="btn btn-info">
        <div class="form-group pull-right">
          <select name="per_page" class="form-control" onchange="this.form.submit()">
            <option value="5" <?php echo $per_page=="5"?'selected="selected"':""; ?>>5</option>
            <option value="10" <?php echo $per_page=="10"?'selected="selected"':""; ?>>10</option>
            <option value="20" <?php echo $per_page=="20"?'selected="selected"':""; ?>>20</option>
            <option value="50" <?php echo $per_page=="50"?'selected="selected"':""; ?>>50</option>
            <option value="100" <?php echo $per_page=="100"?'selected="selected"':""; ?>>100</option>
          </select>
        </div>
      </form>

              <hr>

    <div class="col-md-12 col-sm-12 col-xs-12">
    <h1>Pets</h1>
    <br>
    <div class="table-responsive">
      <table class="table table-striped table-bordered table-hover Tax" >
      <thead>
      <th><input onclick="toggle(this,'cbgroup1')" id="foo[]" name="foo[]" type="checkbox" value="" /></th>
       <th> Sr No. </th>
          <?php $sortSym=isset($_GET["order"]) && $_GET["order"]=="asc" ? "up" : "down"; ?>
            <?php
             $symbol = isset($_GET["sortBy"]) && $_GET["sortBy"]=="pet_types.pet_type"?"<i class='fa fa-sort-$sortSym' aria-hidden='true'></i>": "<i class='fa fa-sort' aria-hidden='true'></i>"; ?>

            <th> 
            <a href="<?php echo $links["pet_types.pet_type_link"]; ?>" class="link_css"> Pet_type <?php echo $symbol ?></a>
            </th>
				
            <?php $symbol = isset($_GET["sortBy"]) && $_GET["sortBy"]=="pets.name"?"<i class='fa fa-sort-$sortSym' aria-hidden='true'></i>": "<i class='fa fa-sort' aria-hidden='true'></i>"; ?>
            <th>
            <a href="<?php echo $links["pets.name_link"]; ?>" class="link_css"> Name <?php echo $symbol ?></a>
            </th>
			
            <?php $symbol = isset($_GET["sortBy"]) && $_GET["sortBy"]=="pets.gender"?"<i class='fa fa-sort-$sortSym' aria-hidden='true'></i>": "<i class='fa fa-sort' aria-hidden='true'></i>"; ?>
            <th>
            <a href="<?php echo $links["pets.gender_link"]; ?>" class="link_css"> Gender <?php echo $symbol ?></a>
            </th>
			
            <?php $symbol = isset($_GET["sortBy"]) && $_GET["sortBy"]=="pets.birth_date"?"<i class='fa fa-sort-$sortSym' aria-hidden='true'></i>": "<i class='fa fa-sort' aria-hidden='true'></i>"; ?>
            <th>
            <a href="<?php echo $links["pets.birth_date_link"]; ?>" class="link_css"> Birth_date <?php echo $symbol ?></a>
            </th>
			
            <?php $symbol = isset($_GET["sortBy"]) && $_GET["sortBy"]=="pets.weight"?"<i class='fa fa-sort-$sortSym' aria-hidden='true'></i>": "<i class='fa fa-sort' aria-hidden='true'></i>"; ?>
            <th>
            <a href="<?php echo $links["pets.weight_link"]; ?>" class="link_css"> Weight <?php echo $symbol ?></a>
            </th>
			
            <?php
             $symbol = isset($_GET["sortBy"]) && $_GET["sortBy"]=="blood_type.blood_group"?"<i class='fa fa-sort-$sortSym' aria-hidden='true'></i>": "<i class='fa fa-sort' aria-hidden='true'></i>"; ?>

            <th> 
            <a href="<?php echo $links["blood_type.blood_group_link"]; ?>" class="link_css"> Blood_group <?php echo $symbol ?></a>
            </th>
				
            <?php $symbol = isset($_GET["sortBy"]) && $_GET["sortBy"]=="pets.address"?"<i class='fa fa-sort-$sortSym' aria-hidden='true'></i>": "<i class='fa fa-sort' aria-hidden='true'></i>"; ?>
            <th>
            <a href="<?php echo $links["pets.address_link"]; ?>" class="link_css"> Address <?php echo $symbol ?></a>
            </th>
			
            <?php $symbol = isset($_GET["sortBy"]) && $_GET["sortBy"]=="pets.ehr_document"?"<i class='fa fa-sort-$sortSym' aria-hidden='true'></i>": "<i class='fa fa-sort' aria-hidden='true'></i>"; ?>
            <th>
            <a href="<?php echo $links["pets.ehr_document_link"]; ?>" class="link_css"> Ehr_document <?php echo $symbol ?></a>
            </th>
			
            <?php $symbol = isset($_GET["sortBy"]) && $_GET["sortBy"]=="pets.status"?"<i class='fa fa-sort-$sortSym' aria-hidden='true'></i>": "<i class='fa fa-sort' aria-hidden='true'></i>"; ?>
            <th>
            <a href="<?php echo $links["pets.status_link"]; ?>" class="link_css"> Status <?php echo $symbol ?></a>
            </th>
			
          <th></th>
      </thead>
      <tbody>
      <?php $count=1;
            $img_path=url('/').'/uploads/';
          foreach($data as $value){
           ?>
          <tr id="hide<?php $value->id; ?>" >
            
            <th>
            <input name='input' id='del' onclick="callme('show')"  type='checkbox' class='del' value='<?php echo $value->id; ?>'/>
            </th>
            <th>
            <?php echo $count; $count++; ?>
            </th>
            <th>
            <?php if(!empty($value->pet_type)){ echo $value->pet_type; }?>
            </th>
                        
            <th>
            {{{ $value->name }}}
            </th>
                
            <th>
            {{{ $value->gender }}}
            </th>
                
            <th>
            {{{ $value->birth_date }}}
            </th>
                
            <th>
            {{{ $value->weight }}}
            </th>
                
            <th>
            <?php if(!empty($value->blood_group)){ echo $value->blood_group; }?>
            </th>
                        
            <th>
            {{{ $value->address }}}
            </th>
                
            <th>
            <?php if(!empty($value->ehr_document)){ echo '<img src="'.$img_path.$value->ehr_document.'" style="width:50px;">'; }?>
            </th>
                        
            <th>
            <a href="<?php echo url("/")?>/admin/pets/status/status/<?php echo $value->id; ?>">
            <?php if(!empty($value->status) and $value->status==1 )
            { echo "Active"; }else{ echo "Inactive";}?>
            </a>
            </th>
                
		   <th>
           <a href="<?php echo url("/"); ?>/admin/pets/view/<?php echo $value->id?>" title="View">
            <span class="btn btn-info " ><i class="fa fa-eye"></i></span>
           </a>
           <a href="<?php echo url("/"); ?>/admin/pets/edit/<?php echo $value->id; ?>" title="Edit">
            <span class="btn btn-info " ><i class="fa fa-edit"></i></span>
           </a>
           <a  title="Delete" data-toggle="modal" data-target="#commonDelete" onclick="$('#set_commondel_id').val('<?php echo $value->id; ?>');">
           <span class="btn btn-info " ><i class="fa fa-trash-o "></i></span>
           </a>
    
            </th>
                </tr>
                   <?php
                  }
                if($count<=1){
                  echo '<tr><td colspan="100"><h3 align="center" class="text-danger">No Record found!</center</td></tr>';
                } ?>
            </tbody>
            </table>
            {{ $data->links('vendor.pagination.default') }}
            </div>

    </div>
  </div>
</div>
<img onclick="callme('','item','')" src="<?php echo url('/')?>/accets/img/mac-trashcan_full-new.png" id="recycle" style="width:90px;  display:none; position:fixed; bottom: 50px; right: 50px;"/>
<!-- /page content -->

<!-- Common Delete Popup  -->
<div class="modal fade" id="commonDelete" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
 <form action="<?php echo url('/'); ?>/admin/pets/delete" method="post">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
        <h4 class="modal-title" id="frm_title">Delete</h4>
      </div>
      <div class="modal-body" id="frm_body">
   Do you really want to delete?
    <input type="hidden" id="set_commondel_id" name="id">
    <input type="hidden" name="redirect" value="<?php echo $redirect; ?>">
    {{ csrf_field() }}
    </div>
      <div class="modal-footer">
        <button style='margin-left:10px;' type="submit" class="btn btn-primary col-sm-2 pull-right" id="frm_submit">Yes</button>
        <button type="button" class="btn btn-danger col-sm-2 pull-right" data-dismiss="modal" id="frm_cancel">No</button>
      </div>
    </div>
  </div>
</form>
</div>
<!-- ./ Common Delete Popup /. -->

<script type="text/javascript">
   function delRow()
   {var confrm = confirm("Are you sure you want to delete?");
     if(confrm)
     {
       ids = values();
       $.ajax({
         type:"POST",
         url:'<?php echo url("/")."/admin/pets/deleteAll"; ?>',
         data:{
          allIds:ids,
          _token:"{{ csrf_token() }}",
         },
         success:function(res){
           location.reload();
           },
       });
     }
   }
</script>

@endsection
