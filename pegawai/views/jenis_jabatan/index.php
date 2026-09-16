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
                <label class="control-label col-md-2">Kode / Keterangan</label>
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
                          'onclick' => 'my_data_table.filter.reset(\'#dt_basic\')'
                      ));
                      ?>
                  </div>
            </div>
        </form>
    </div>
    <div class="portlet-title">
        <?php 
            if ($this->laccess->otoritas('add')):           
                echo anchor($_modul . '/add', '<i class="glyphicon glyphicon-plus"></i> Add ' . $_title, array(
                    'id' => 'mybutton-add',
                    'class' => 'btn btn-labeled btn-primary',
                    'data-toggle' => "modal",
                    'data-target' => "#remoteModal",
                    'data-keyboard' => "false",
                    'data-backdrop' => "static"
                ));
            endif;
        ?>
    </div>
    <div class="portlet-body">
               <!--data-source="<?php// echo base_url() . $_modul . '/load'; ?>"-->
        <table id="dt-basic" 
               class="table table-striped table-bordered table-hover" 
               width="100%" style="margin-top: 0 !important;"
               data-table-source="<?php echo base_url() . $_modul . '/load'; ?>"
               data-table-filter="#filter-table">
            <thead>                         
                <tr>
                    <th class="text-align-center">NO</th>
                    <th class="col-md-4">NAMA</th>
                    <th class="text-align-center">FUNCTION</th>
                </tr>
            </thead>
        </table>
    </div>
</div>


 <!-- Dynamic Modal -->  
<div class="modal" id="remoteModal" tabindex="-1" data-backdrop="static" aria-hidden="true">  
</div>  

<script type="text/javascript">
     pageSetUp();
        var mydatatable = $('#dt-basic').myDataTable({
        columns: [
            {orderable : false},
            {name: 'cabang_id'},
            // {name: 'cabang_nama'},
            {orderable: false},
            // {orderable: false},
            // {orderable: false},
            // {orderable: false},
        ],
    });
    // my_data_table.init('#dt_basic');

    $("form#filter_table").bind('submit',function(){
       mydatatable.reload('#dt_basic');
       return false;
    });

  
  var __reloadTable = function(refresh) {
          mydatatable.reload(refresh);
      };
</script>



