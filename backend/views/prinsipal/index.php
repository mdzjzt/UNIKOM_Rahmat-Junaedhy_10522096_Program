<div class="row">
  <div class="portlet light bordered">
    <div class="portlet-title">
        <div class="caption font-dark">
            <span class="caption-subject bold uppercase"><?php echo $page_title; ?></span>
            <span class="caption-helper"></span>
        </div>
    </div>
    <div class="portlet-title">
        <form class="form-horizontal" id="filter-table">
           <!--  <div class="form-group form-group-sm">
                <label class="col-md-2 control-label">Cabang</label>
                <div class="col-md-4">
                    <?php // echo form_dropdown('cabang_id', $cabang, '' ,'class="form-control select2"') ?>
                </div>
            </div> -->

            <div class="form-group form-group-sm">
                <label class="col-md-2 control-label">Role</label>
                <div class="col-md-4">
                    <?php echo form_dropdown('role_id', $role, '' ,'class="form-control select2"') ?>
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
        <?php 
            if ($this->laccess->otoritas('add')):           
                echo anchor($_modul . '/form', '<i class="glyphicon glyphicon-plus"></i> Add ' . $_title, 
                [
                    'class' => 'btn btn-labeled btn-primary',
                    'data-toggle' => "modal",
                    'data-target' => "#remoteModal",
                    'data-keyboard' => "false",
                    'data-backdrop' => "static"
                ]);
            endif;
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
                    <th data-sorting="false"> NO</th>
                   <!--  <th class="col-md-2">CABANG</th> -->
                    <th class="col-md-4" style="min-width:500px">ROLE</th>
                    <th class="col-md-2">LIMIT</th>
                    <th class="text-align-center">FUNCTION</th>
                </tr>
            </thead>
        </table>
    </div>
</div>


 <!-- Dynamic Modal -->  
<div class="modal" id="remoteModal" tabindex="-1" role="dialog" data-backdrop="static" aria-hidden="true">  
</div>  

<script type="text/javascript">
    pageSetUp();
    var mydatatable = $('#dt-basic').myDataTable({
        columns: [
            {orderable : false},
            // {name: 'cabang_nama'},
            {name: 'role_nama'},
            {name: 'limit', orderable: false},
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