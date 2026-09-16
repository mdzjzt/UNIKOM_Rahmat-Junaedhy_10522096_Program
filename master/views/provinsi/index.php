<div class="row">
  <div class="portlet light bordered">
    <div class="portlet-title">
        <div class="caption font-dark">
            <span class="caption-subject bold uppercase"><?php echo $page_title; ?></span>
            <span class="caption-helper"></span>
        </div>
    </div>
    <div class="portlet-title">
        <form class="form-horizontal" id="filter_table">
            <div class="form-group form-group-sm">
                <label class="control-label col-md-2">Provinsi</label>
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

                      echo anchor(NULL, '<i class="fa fa-refresh"></i> Reset', array(
                          'class' => 'btn btn-default btn-sm',
                          'onclick' => 'mydatatable.filterReset()'
                      ));
                      ?>
                  </div>
            </div>
        </form>
    </div>
    <div class="portlet-title">
        
        <?php if ($this->laccess->otoritas('add')) {
            echo anchor($_modul . '/add', '<i class="glyphicon glyphicon-plus"></i> Add ' . $_title, array(
                'id' => 'mybutton-add',
                'class' => 'btn btn-labeled btn-primary',
                'data-toggle' => "modal",
                'data-target' => "#remoteModal",
                'data-keyboard' => "false",
                'data-backdrop' => "static"
            ));
        }
        ?>

      <div class="actions">
        <a class="btn btn-circle btn-icon-only btn-default fullscreen" href="#" rel="tooltip" data-placement="top" title="fullscreen"></a>
      </div>
    </div>
    <div class="portlet-body">
        <table id="dt_basic" 
               class="table table-striped table-bordered table-hover" 
               width="100%" style="margin-top: 0 !important;"
               data-table-source="<?php echo base_url() . $_modul . '/load'; ?>"
               data-table-filter="#filter_table">
            <thead>                         
                <tr>
                    <th class="text-align-center" style="min-width:50px" data-sorting="false">NO</th>
                    <th class="col-md-2">KODE</th>
                    <th class="col-md-4">Provinsi</th>
                    <th class="text-align-center">FUNCTION</th>
                </tr>
            </thead>
        </table>
    </div>
  </div>
</div>

 <!-- Dynamic Modal -->  
  <div class="modal" id="remoteModal" tabindex="-1" role="dialog" data-backdrop="static" aria-hidden="true">  
  </div>  
  <!-- /.modal -->

<script type="text/javascript">
    pageSetUp();
    
    var mydatatable = $('#dt_basic').myDataTable({
        columns: [
            {orderable : false},
            {name: 'provinsi_id'},
            {name: 'provinsi_name'},
            {orderable: false},
        ],
    });

    $("form#filter_table").bind('submit',function(){
       mydatatable.reload();
       return false;
    });

    var _afterDelete = function(refresh) {
        $('.modal').modal('hide');
        mydatatable.reload(refresh);
    };
    
</script>



