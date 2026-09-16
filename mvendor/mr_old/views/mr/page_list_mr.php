  <style type="text/css">
    .odd a {
    margin-left: 10px;
}
  </style>
  <div class="container-fluid">
  <div class="portlet light">
      <div class="">
          <div class="caption font-dark">
            <ul class="nav nav-tabs tab-child">
              <li class="active"><a data-toggle="tab" href="#listmr"><?php echo $page_title; ?></a></li>
              <li><a data-toggle="tab" href="#listapprove">List Approve MR</a></li>
            
            </ul>

          </div>
      </div>

    <div class="tab-content">

      <div id="listmr" class="tab-pane fade in active">
  			<div class="col-md-6 hidden-xs">
  			  <h4 style="margin-top:10px; "><i class="fa fa-list"></i> LIST MR <?php  echo $nama_project; ?> </h4>
  			</div>
  			<div class="col-md-6 hidden-xs" style="margin-bottom: 6px;text-align: right">

  			<?php
    			echo anchor(NULL, '<i class="glyphicon glyphicon-chevron-left"></i> Kembali', 
    			[
    			    'class'   => 'btn btn-default ',
    			    'onclick' => 'my_form.go_back()'
    			]);

  			?>
  			<?php 
  			  if ($this->laccess->otoritas('add')) {           
  			     echo anchor(NULL, '<i class="glyphicon glyphicon-plus "></i> Tambah MR', array(
  			                          'id'              => 'mybutton-add',
  			                          'class'           => 'btn btn-labeled btn-primary ',
  			                          'data-module'     => $_modul,
  			                          'data-href'       => $_modul.'/form_mr/'.$id_m_project.'/0'
  			          ));

               echo anchor(NULL, '<i class="fa fa-upload "></i> Import Excel MR', array(
                                  'id'              => 'mybutton-add',
                                  'class'           => 'btn btn-labeled btn-warning ',
                                  'data-toggle' => 'modal',
                                  'data-target' => '#modal-import'
                  ));

                echo anchor(base_url().'uploads/template_excel/Template_MR.xlsx', '<i class="fa fa-download"></i> Template Excel MR', array(
                'id'          => 'mybutton-add',
                'class'       => 'btn btn-labeled btn-success',
                
              ));
    			  }
    			?>
    			</div>
          <div class="col-md-6 visible-xs " >
          <div class="col-xs-6">
            <?php
            echo anchor(NULL, '<i class="glyphicon glyphicon-chevron-left"></i> Kembali', 
            [
                'class'   => 'btn btn-default ',
                'onclick' => 'my_form.go_back()'
            ]);

          ?>
          </div>
        
        <?php 
          if ($this->laccess->otoritas('add')) {   
            ?>
              <div class="col-xs-6">
            <?php

             echo anchor(NULL, '<i class="glyphicon glyphicon-plus "></i> Tambah MR', array(
                                  'id'              => 'mybutton-add',
                                  'class'           => 'btn btn-labeled btn-primary ',
                                  'data-module'     => $_modul,
                                  'data-href'       => $_modul.'/form_mr/'.$id_m_project.'/0'
                  ));
            ?>
          </div>
          <div class="clearfix" style="margin: 5px;"></div>
            <div class="col-xs-6">
          <?php

             echo anchor(NULL, '<i class="fa fa-upload "></i> Import Excel', array(
                                'id'              => 'mybutton-add',
                                'class'           => 'btn btn-labeled btn-warning ',
                                'data-toggle' => 'modal',
                                'data-target' => '#modal-import'
                ));
          ?>
          </div>
            <div class="col-xs-6">

          <?php

              echo anchor(base_url().'uploads/template_excel/Template_MR.xlsx', '<i class="fa fa-download"></i> Template Excel', array(
              'id'          => 'mybutton-add',
              'class'       => 'btn btn-labeled btn-success',
              
            ));
          ?>
          </div>
       <?php   
        }
        ?>
        </div>
		    <div class="clearfix"></div>
			   <hr class="line-down"></hr>
		    <div class="clearfix"></div>

		    <div class="portlet-title">
		      <form class="form-horizontal" id="filter-table-mr">
		        <div class="form-group form-group-sm">
					
					
						<div class="col-md-3">
							<?php echo form_input('kode_mr', NULL, 'class="form-control" placeholder="Kode MR"'); ?>
						</div>
					
						
						<div class="col-md-3">
							<?php echo form_input('nama_mr', NULL, 'class="form-control" placeholder="Nama MR"'); ?>
						</div>

            <div class="col-md-3" >
              <select class="form-control" name="status_search">
               <option value="">--Status Approve--</option>
                <option value="0">DI PROSES</option>
                <option value="1">DI TERIMA</option>
                <option value="2">DI REVISI</option>
                <option value="3">DI TOLAK</option> 
              </select>
            </div>
				
					<div class="col-md-3" style="text-align: right;">
						<?php
						echo form_button([  
						'type'    => 'submit',
						'content' => '<i class="fa fa-search"></i> Search',
						'class'   => 'btn btn-info btn-sm',
						]);

						echo anchor(NULL, '<i class="fa fa-refresh"></i> Reset', array(
						'class' => 'btn btn-default btn-sm',
						'onclick' => 'filterclsmr()'
						));
						?>
					</div>
		        </div>
		      </form>
		    </div>
            <div class="portlet-body">
              <div class="table-responsive">
                <table id="data_datatable_mr" 
                       class="table table-striped table-bordered table-hover" 
                       width="100%" style="margin-top: 0 !important;"
                       data-table-source="<?php echo base_url() . $_modul . '/load_mr/'.$id_m_project.''; ?>"
                       data-table-filter="#filter-table-mr">
                        <thead>                     
                            <tr>
                                <th data-sorting="false" style="width: 10px">NO</th>
                                <th style="width:100px" >KODE MR</th>
                                <th style="width:100px">NAMA MR</th>
                                <th style="width:100px">TGL MR</th>
                                <th style="width:100px">PEMBUAT MR</th>
                                <th style="width:50px">STATUS APPROVE</th>
                                <th style="width:50px">LAMPIRAN MR</th>
                                <th style="width:100px">ACTION</th>
                      
                            </tr>
                        </thead>
                  </table>
                </div>
            </div> 
      </div>

      <div id="listapprove" class="tab-pane fade">
		  <div class="col-md-6 hidden-xs">
        <h4 style="margin-top:10px; "><i class="fa fa-list"></i> LIST APPROVE MR <?php  echo $nama_project; ?> </h4>
      </div>
       <div class="col-md-6 visible-xs">
        <i class="fa fa-list"></i> LIST APPROVE MR 
      </div>
			<div class="col-md-2" style="margin-bottom: 6px;">

			<?php //
			// if ($this->laccess->otoritas('add')) {           
			//    echo anchor(NULL, '<i class="glyphicon glyphicon-plus"></i> Tambah MR', array(
			//                         'id'              => 'mybutton-add',
			//                         'class'           => 'btn btn-labeled btn-primary',
			//                         'data-module'     => $_modul,
			//                         'data-href'       => $_modul.'/form_mr/'.$id_m_project
			//         ));
			// }
			?>
			</div>
			<div class="clearfix"></div>
			<hr class="line-down"></hr>
		    <div class="clearfix"></div>

		    <div class="portlet-title">
		      <form class="form-horizontal" id="filter-table-appr">
		        <div class="form-group form-group-sm">
					<div class="col-md-5">
						<?php echo form_label('Kode MR', 'kode_appr', ['class' => 'control-label col-md-3']) ?>
						<div class="col-md-9">
							<?php echo form_input('kode_appr', NULL, 'class="form-control" placeholder="Pencarian"'); ?>
						</div>
					</div>
					<div class="col-md-4">
						<?php echo form_label('Nama MR', 'keyword', ['class' => 'control-label col-md-3']) ?>
						<div class="col-md-9">
							<?php echo form_input('nama_appr', NULL, 'class="form-control" placeholder="Pencarian"'); ?>
						</div>
					</div>
					<div class="col-md-3" style="text-align: right;">
						<?php
						echo form_button([  
						'type'    => 'submit',
						'content' => '<i class="fa fa-search"></i> Search',
						'class'   => 'btn btn-info btn-sm',
						]);

						echo anchor(NULL, '<i class="fa fa-refresh"></i> Reset', array(
						'class' => 'btn btn-default btn-sm',
						'onclick' => 'filterclsappr()'
						));
						?>
					</div>
		        </div>
		      </form>
		    </div>
            <div class="portlet-body">
              <div class="table-responsive">
                <table id="data_datatable_approve" 
                       class="table table-striped table-bordered table-hover" 
                       width="100%" style="margin-top: 0 !important;"
                       data-table-source="<?php echo base_url() . $_modul . '/load_list_approve/'.$id_m_project.''; ?>"
                       data-table-filter="#filter-table-appr">
                        <thead>                     
                            <tr>
                                <th data-sorting="false" style="width: 10px">NO</th>
                                <th style="width:100px" >KODE MR</th>
                                <th style="width:100px">NAMA MR</th>
                                <th style="width:100px">TGL MR</th>
                                <th style="width:100px">STATUS APPROVE</th>
                                <th style="width:10px">ACTION</th>
                      
                            </tr>
                        </thead>
                </table>
              </div>
            </div> 
          </div>

        </div>
      </div>
     
     
    
</div>

<!-- modal detal -->
<div class="modal container" id="modalDetail" data-backdrop="static" tabindex="-1" aria-hidden="true" >
  <div class="modal-header">
            <button type="button" class="close" onclick="close_modal()" aria-hidden="true">
                <i class="fa fa-times"></i>
            </button>
            <h4 class="modal-title title-detail" style="font-weight: bold;">
                <i class="fa fa-file"></i> Detail  
            </h4>
        </div>
        <div class="modal-body">          
        <div class="table-responsive">
           <table class="table  table-striped table-bordered table-hover" style="margin-top: 0 !important;width:100%;" id="tbl_detail">
             <thead>
               <tr>
                  <th>No</th>
                  <th>Type MR </th>
                  <th>Description </th>
                 <th>Size</th>
                 <th>Quantity</th>
                 <th>Unit</th>
                 <th>Part Number</th>
               <!--   <th>Reference Price </th> -->
               <th>unit Cost</th> 
                 <th>Total Cost</th> 
                 <th>Lokasi (station)</th>
                 <th>TGL Kebutuhan</th>
                 <th>Remarks</th>
                 <th>Lampiran</th>
                <th>PO/SO</th>
               </tr>
             </thead>
           </table>
          </div>
        </div>
         <div class="modal-footer">
            <?php 
              echo anchor(NULL, '<i class="glyphicon glyphicon-chevron-left"></i> Close',
              [
                  'class' => 'btn btn-default margin-right-2',
                  'data-dismiss' => 'modal',
                  'onclick' => 'close_modal()',
              ]);
            ?>

           
        </div>
</div> 

<div class="modal container" id="modalinfo" data-backdrop="static" tabindex="-1" aria-hidden="true" >
  <div class="modal-header">
            <button type="button" class="close" onclick="close_modal_info()" aria-hidden="true">
                <i class="fa fa-times"></i>
            </button>
            <h4 class="modal-title title-detail" style="font-weight: bold;">
                <i class="fa fa-file"></i> Info Approve  
            </h4>
        </div>
        <div class="modal-body">        
          <div class="table-responsive">
           <table class="table  table-striped table-bordered table-hover" style="margin-top: 0 !important;width:100%;" id="tbl_info">
             <thead>
               <tr>
                 <th>No</th>
                 <th>Date Approve </th>
                 <th>Keterangan</th>
                 <th>User Approve</th>
                 <th>Role</th>
                 <th>Status</th>
               </tr>
             </thead>
           </table>
          </div>
        </div>
         <div class="modal-footer">
            <?php 
              echo anchor(NULL, '<i class="glyphicon glyphicon-chevron-left"></i> Close',
              [
                  'class' => 'btn btn-default margin-right-2',
                  'data-dismiss' => 'modal',
                  'onclick' => 'close_modal()',
              ]);
            ?>

           
        </div>
</div> 

<div class="modal container" id="modallistapproved" data-backdrop="static" tabindex="-1" aria-hidden="true" data-width="700">
  <div class="modal-header">
            <button type="button" class="close" onclick="close_modal_info_list()" aria-hidden="true">
                <i class="fa fa-times"></i>
            </button>
            <h4 class="modal-title title-detail" style="font-weight: bold;">
                <i class="fa fa-file"></i> Info List Urutan Approve  
            </h4>
        </div>
        <div class="modal-body">
           <table class="table  table-striped table-bordered table-hover" style="margin-top: 0 !important;width:100%;" id="tbl_info_list_approve">
             <thead>
               <tr>
                <th>No Urutan</th>
                <th>Nama Approval</th>
                <th>Role Name</th>
               <th>Ket. Approval</th> 
               </tr>
             </thead>
            
           </table>
        </div>
         <div class="modal-footer">
            <?php 
              echo anchor(NULL, '<i class="glyphicon glyphicon-chevron-left"></i> Close',
              [
                  'class' => 'btn btn-default margin-right-2',
                  'data-dismiss' => 'modal',
                  'onclick' => 'close_modal_info_list()',
              ]);
            ?>

           
        </div>
</div> 

<div class="modal" id="modal-import" data-backdrop="static">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">
              <i class="fa fa-times"></i>
          </button>
          <h4 class="modal-title">
            <span class="caption-subject bold uppercase"> 
                      IMPORT EXCEL
              </span>
        </h4>
      </div>

      <?php echo form_open_multipart($_modul .'/import/'.$id_m_project.'/', array('class' => 'form-horizontal', 'id' => 'form-import')) ?>

        <div class="modal-body">
          <div class="fileinput fileinput-new input-group" data-provides="fileinput">
            <div class="form-control" data-trigger="fileinput"><i class="glyphicon glyphicon-file fileinput-exists"></i> <span class="fileinput-filename"></span></div>
            <span class="input-group-addon btn btn-default btn-file"><span class="fileinput-new">Select file</span><span class="fileinput-exists">Change</span>
            <input type="file" name="file"></span>
            <a href="#" class="input-group-addon btn btn-default fileinput-exists" data-dismiss="fileinput">Remove</a>
          </div>
        </div>

      

      <div class="modal-footer">
          <?php echo form_button(array(
                  'content' => 'Batal',
                  'type' => 'button',
                  'class' => 'btn default',
                  'data-dismiss' => 'modal'
          )) ?>

          <?php echo form_button(array(
                  'content' => '<i class="fa fa-import"></i> Import',
                  'type' => 'submit',
                  'class' => 'btn green',

          )) ?>   
      </div>
      <?php echo form_close() ?>
  </div>
  <!-- /.modal -->

<script type="text/javascript">
  pageSetUp();



  var dataTableMr = $('#data_datatable_mr').myDataTable({
          columns: [
              {orderable : false},
              {name: 'kode_mr'},
              {name: 'nama_mr'},
              {name: 'status',orderable : false},
              {name: 'status',orderable : false},
              {name: 'status',orderable : false},
              {name: 'status',orderable : false},
              {name: 'role',orderable : false},
              
          ],
      });

   var datatableApprove = $('#data_datatable_approve').myDataTable({
          columns: [
              {orderable : false},
              {name: 'kode_mr'},
              {name: 'nama_mr'},
                {name: 'nama_mr'},
              {name: 'status',orderable : false},
              {name: 'role',orderable : false},
              
          ],
      });

   $('form#form-import').submit(function(event) {
          event.preventDefault();
          $(this).myForm({
            confirmMessage : 'Anda yakin akan mengimport file ke data vendor ?',
            success : function() {
                $('#modal-import').modal('hide');
                dataTableMr.reload();
               datatableApprove.reload();
            }
        }).submit();
           $('#modal-import').modal('hide');
    });

  // var tbl_detail = $('#tbl_detail').DataTable({ 
 
  //       "ordering": false,
  //       "info":     false,
  //       "processing": true, //Feature control the processing indicator.
  //       "serverSide": true, //Feature control DataTables' server-side processing mode.
  //       "order": [], //Initial no order.
 
  //       // Load data for the table's content from an Ajax source
  //       "ajax": {
  //           "url": "mr/mr/detail/"+1,
  //           "type": "POST"
  //       },
 
  //       //Set column definition initialisation properties.
  //       "columnDefs": [
  //       { 
  //           "targets": [ -1 ], //last column
  //           "orderable": false, //set not orderable
  //       },
  //       ],
 
  //   });

  var tbl_detail = $('#tbl_detail').DataTable({ 
    "bProcessing": true,
    "bServerSide": true,
    "sPaginationType": "full_numbers",
    "paging" : true,
    "iDisplayLength": 10,
    "sAjaxSource": "mr/mr/detail/"+1,
    "aaSorting": [[ 2, "asc" ]],
    "fnServerParams": function ( aoData ){
      var param_thn = $("#year_of_parttime").val();
      var param_bln = $("#month_of_parttime").val();
      // var employee_id = id;
      aoData.push( 
        { "name": "param_thn", "value": param_thn }, 
        { "name": "param_bln", "value": param_bln },
        // { "name": "employee_id", "value": employee_id }
      );
    },
    "fnRowCallback": function( nRow, aData, iDisplayIndex, iDisplayIndexFull ) {
      $(nRow).html("<td align='center'>"+aData[0]+"</td><td align='center'>"+aData[1]+"</td><td align='center'>"+aData[2]+"</td><td align='center'>"+aData[3]+"</td><td align='center'>"+aData[4]+"</td><td align='center'>"+aData[5]+"</td><td align='center'>"+aData[6]+"</td><td align='center'>"+aData[7]+"</td><td align='center'>"+aData[8]+"</td><td align='center'>"+aData[9]+"</td><td align='center'>"+aData[10]+"</td><td align='center'>"+aData[11]+"</td><td align='center'>"+aData[12]+"</td><td align='center'>"+aData[13]+"</td>");
      return nRow;
    },
    });

   var tbl_info = $('#tbl_info').DataTable({ 
 
        "ordering": false,
        "info":     false,
        "processing": true, //Feature control the processing indicator.
        "serverSide": true, //Feature control DataTables' server-side processing mode.
        "order": [], //Initial no order.
 
        // Load data for the table's content from an Ajax source
        "ajax": {
            "url": "mr/mr/detail_info/"+1,
            "type": "POST"
        },
 
        //Set column definition initialisation properties.
        "columnDefs": [
        { 
            "targets": [ -1 ], //last column
            "orderable": false, //set not orderable
        },
        ],
 
    });

      var tbl_info_list_approve = $('#tbl_info_list_approve').DataTable({ 
 
        "ordering": false,
        "info":     false,
        "processing": true, //Feature control the processing indicator.
        "serverSide": true, //Feature control DataTables' server-side processing mode.
        "order": [], //Initial no order.
 
        // Load data for the table's content from an Ajax source
        "ajax": {
            "url": "mr/mr/detail_info_list_approved/"+1+"/"+0,
            "type": "POST"
        },
 
        //Set column definition initialisation properties.
        "columnDefs": [
        { 
            "targets": [ -1 ], //last column
            "orderable": false, //set not orderable
        },
        ],
 
    });
  
  

  function detail_mr(id){

    $('#modalDetail').modal('show');
    tbl_detail.ajax.url("mr/mr/detail/"+id).load();

  }

   function detail_info(id){

    $('#modalinfo').modal('show');
     tbl_info.ajax.url("mr/mr/detail_info/"+id).load();

  }

  function close_modal(){
     $('#modalDetail').modal('hide');
    tbl_detail.ajax.url("mr/mr/detail/0").load();

  }

  function close_modal_info(){
     $('#modalinfo').modal('hide');
    tbl_info.ajax.url("mr/mr/detail_info/0").load();
    
  }

   var __reloadTable = function(refresh) {
     $('.loading-save-form').css('display', 'none');
        dataTableMr.reload(refresh);
        datatableApprove.reload(refresh);
    };

    $("form#filter-table-mr").bind('submit',function(){
		__reloadTable_mr();
		return false;
	});
	var __reloadTable_mr = function(refresh) {
     $('.loading-save-form').css('display', 'none');
		dataTableMr.reload(refresh);
	};
	$("form#filter-table-appr").bind('submit',function(){
		__reloadTable_app();
		return false;
	});
	var __reloadTable_app = function(refresh) {
     $('.loading-save-form').css('display', 'none');
		datatableApprove.reload(refresh);
	};
function filterclsmr(){
	$("#filter-table-mr")[0].reset();
	dataTableMr.reload();
}
function filterclsappr(){
	$("#filter-table-appr")[0].reset();
	datatableApprove.reload();
}

function list_approved(id_project,id_mr){

  $('#modallistapproved').modal('show');
  tbl_info_list_approve.ajax.url("mr/mr/detail_info_list_approved/"+id_project+"/"+id_mr).load();
}

function close_modal_info_list(){
     $('#modallistapproved').modal('hide');
    tbl_info_list_approve.ajax.url("mr/mr/detail_info_list_approved/0/0").load();
    
  }

   $('.144').addClass('active');


</script>