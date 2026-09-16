<div class="row">
  <div class="portlet light bordered">
    <div class="portlet-title">
        <div class="caption font-dark">
          <span class="caption-subject bold uppercase"><?php echo $pageTitle ?></span>
          <span class="caption-helper"></span>
        </div>
        <div class="actions">
          <a class="btn btn-circle btn-icon-only btn-info show-field" href="javascript:;" data-show-target="#div-filter">
                <i class="icon-magnifier"></i>
            </a>
            <a class="btn btn-circle btn-icon-only btn-default fullscreen" href="javascript:;" rel="tooltip" data-placement="top" title="fullscreen"></a>
        </div>
    </div>
    <div class="portlet-title" id="div-filter">
        <form class="form-horizontal" id="filter_table">
           
            
            <div class="form-group form-group-sm">
                <label class="control-label col-md-2">NAMA ITEM</label>
                <div class="col-md-5">
                    <?php echo form_input('acount_code', NULL, 'class="form-control" placeholder="Pencarian"'); ?>
                </div>
            </div>

            <div class="form-group form-group-sm">
              <label class="control-label col-md-2">CURRENCY</label>
              <div class="col-md-5">
                  <?php echo form_input('description', NULL, 'class="form-control" placeholder="Description"'); ?>
              </div>             
                 <div class="col-md-4">
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
            </div>

        </form>
    </div>
    <div class="portlet-title">
        <?php 
            if ($this->laccess->otoritas('add')) {           
               echo anchor(NULL, '<i class="glyphicon glyphicon-plus"></i> TAMBAH ITEM', array(
                                    'id'              => 'mybutton-add',
                                    'class'           => 'btn btn-labeled btn-primary',
                                    'data-module'     => $_modul,
                                    'data-href'       => $_modul.'/form'
                    ));
            }
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
                    <th data-sorting="false"> NO</th>
                    <th class="col-md-3">KODE ITEM</th>
                    <th class="col-md-3">NAMA ITEM</th>
                    <th class="col-md-3">QUANTITY</th>
                    <th class="col-md-3">UNIT PRICE</th>
                    <th class="col-md-3">TYPE</th>
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
            {orderable : false},
            {name : 'nama_customer'},
            {name: 'area_code_project'},
            {orderable : false},
            {orderable : false},
            {orderable : false},
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







