<div class="row">
  <div class="portlet light bordered">
    <div class="portlet-title">
        <form class="form-horizontal" id="filter_table">
           <div class="col-md-3">
            <?php echo form_dropdown('account_no', $sub_coa, '', 'class="form-control select2" '); ?>
          </div>
          <div class="col-md-3">
            <?php echo form_input('account_nama', NULL, 'class="form-control" placeholder="Name"'); ?>
          </div>  
          <div class="col-md-3">
            <?php echo form_dropdown('account_type', $account_type, '', 'class="form-control select2" '); ?>
          </div>     
         
             
          <div class="col-md-2">
                    <?php
                      echo form_button([
                                      'class' => 'btn btn-info btn-sm pull-left',
                                      'content' => '<i class="fa fa-search"></i> Search',
                                      'type'    => 'submit',
                      ]);
                      echo anchor(NULL, '<i class="fa fa-refresh"></i> Reset', 
                        [
                          'class' => 'btn btn-default btn-sm pull-left',
                          'onclick' => 'mydatatable.filterReset()'
                        ]);
                      ?>
          </div>
        </form>
    </div> 
    <div class="portlet-title">
        <?php 
            
               echo anchor(NULL, '<i class="glyphicon glyphicon-plus"></i> NEW COA', array(
                                    'id'              => 'mybutton-add',
                                    'class'           => 'btn btn-labeled btn-primary',
                                    'data-module'     => $_modul,
                                    'data-href'       => $_modul.'/form'
                    ));
           
        ?>
    </div>
    <div class="portlet-body">
        <table id="dt_basic" 
               class="table table-striped table-bordered table-hover" 
               width="100%" style="margin-top: 0 !important;"
               data-table-source="<?php echo base_url() . $_modul . '/load'; ?>"
               data-table-filter="#filter_table">
            <thead>                         
                <tr>
                
                    <th >ACCOUNT NO</th>
                    <th>NAME</th>
                    <th>TYPE</th>
                    <th>BALANCE</th>
                   
                    <th class="text-center">FUNCTION</th>
                </tr>
            </thead>
        </table>
    </div>
</div>


 <!-- Dynamic Modal -->  
<div class="modal" id="modalDetail" data-backdrop="static" tabindex="-1" aria-hidden="true" data-width="1200"></div>  

<script type="text/javascript">
    pageSetUp();
    var mydatatable = $('#dt_basic').myDataTable({
        columns: [
            {orderable : 'no_account_coa'},
            {name : 'account_nama'},
            {name: 'nama_type'},
            {name: 'balance'},
            {orderable: false},
        ],
    });

    $("form#filter_table").bind('submit',function(){
       __reloadTable();
       return false;
    });

    var __reloadTable = function(refresh) {
        mydatatable.reload(refresh);
    };
</script>







