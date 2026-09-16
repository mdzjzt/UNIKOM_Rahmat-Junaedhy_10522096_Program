<div class="row">
  <div class="portlet light bordered">
    <div class="portlet-title">
        <div class="caption font-dark">
            <span class="caption-subject bold uppercase"><?php echo $pageTitle; ?></span>
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
        <form class="form-horizontal" id="filter-table">

            <div class="form-group form-group-sm">
                <label class="control-label col-md-1">Golongan</label>
                <div class="col-md-4">
                    <?php echo form_dropdown('lbu_id', $golongan, '' ,'class="form-control select2"') ?>
                </div>
            </div>
            <div class="form-group form-group-sm">
                <label class="control-label col-md-1">Bidang</label>
                <div class="col-md-5">
                    <?php echo form_input('keyword', NULL, 'class="form-control" placeholder="Pencarian"'); ?>
                </div>
                <div class="col-md-4">
                    <?php
                      echo form_button([  
                            'type'    => 'submit',
                            'content' => '<i class="fa fa-search"></i> Search',
                            'class'   => 'btn btn-info btn-sm',
                      ]);

                      echo anchor(NULL, '<i class="fa fa-refresh"></i> Reset', 
                        [
                          'class' => 'btn btn-default btn-sm',
                          'onclick' => 'mydatatable.filterReset()'
                        ]);
                    ?>
                  </div>
            </div>
        </form>
    </div>
    <div class="portlet-title">
        
        <?php if ($this->laccess->otoritas('add')) {
            echo anchor($_modul . '/add', '<i class="glyphicon glyphicon-plus"></i> Add ' . $_title, 
              [
                'class' => 'btn btn-labeled btn-primary',
                'data-toggle' => "modal",
                'data-target' => "#remoteModal",
                'data-keyboard' => "false",
                'data-backdrop' => "static"
            ]);
        }
        ?>
    </div>
    <div class="portlet-body">
        <table id="dt-basic" 
               class="table table-striped table-bordered table-hover" 
               width="100%" style="margin-top: 0 !important;"
               data-table-source="<?php echo base_url() . $_modul . '/load'; ?>"
               data-table-filter="#filter-table">
            <thead>                         
                <tr>
                    <th data-sorting="false">NO</th>
                    <th>KODE</th>
                    <th>GOLONGAN</th>
                    <th>BIDANG</th>
                    <th>FUNCTION</th>
                </tr>
            </thead>
        </table>
    </div>
  </div>
</div>

 <!-- Dynamic Modal -->  
  <div class="modal" id="remoteModal" data-backdrop="static" tabindex="-1" role="dialog" aria-hidden="true" data-width="800">  
  </div>  
  <!-- /.modal -->

<script type="text/javascript">
    pageSetUp();
    var mydatatable = $('#dt-basic').myDataTable({
        columns: [
            {orderable : false},
            {name: 'bidang_lbu_kode'},
            {name: 'lbu_nama'},
            {name: 'bidang_lbu_nama'},
            {orderable: false},
        ],
    });

    $("form#filter-table").bind('submit',function(){
       __reloadTable();
       return false;
    });

    var __reloadTable = function(refresh) {
        mydatatable.reload(refresh);
    };
</script>