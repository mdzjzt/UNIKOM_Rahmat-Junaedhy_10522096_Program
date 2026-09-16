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
           <!--  <div class="form-group gorm-group-sm">
                <label class="control-label col-md-2">Cabang</label>
                <div class="col-md-3">
                    <?php  //echo form_dropdown('cabang_id', $cabang, '', 'class="form-control select2"') ?>
                </div>
            </div> -->
            <div class="form-group gorm-group-sm">
                <label class="control-label col-md-1">Role</label>
               <!--  <div class="col-md-3">
                    <?php echo form_dropdown('role_id', $opt_role, '', 'class="form-control select2"') ?>
                </div>
                  <label class="control-label col-md-1">Status</label>
                <div class="col-md-2">
                    <?php echo form_dropdown('status', $opt_st, '', 'class="form-control"'); ?>
                </div> -->
                  <label class="control-label col-md-2">Nama / Username</label>
                <div class="col-md-3">
                    <?php echo form_input('keyword', NULL, 'class="form-control" placeholder="Pencarian"'); ?>
                </div>
            </div>
          <!--   <div class="form-group gorm-group-sm">
              
            </div> -->
            <!-- <div class="form-group form-group-sm">
              
             
            </div> -->
             <div class="col-md-4 pull-right sr-user">
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
         </form>
          <?php 
            if ($this->laccess->otoritas('add')):           
            echo anchor(NULL, '<i class="glyphicon glyphicon-plus"></i> Add Data ' . $_title, array(
                'id' => 'mybutton-add',
                'class' => 'btn btn-labeled btn-primary bt-ser',
                'data-breadcrumb' => 'Add',
                'onclick' => 'my_form.open(this.id)',
                'data-module' => $_modul,
                'data-url' => $_modul . '/add'
            ));
            endif;
        ?>

       
    </div>
  <!--   <div class="portlet-title">
       
    </div> -->
    <div class="portlet-body">
        <table id="dt_basic" 
               class="table table-striped table-bordered table-hover" 
               width="100%" style="margin-top: 0 !important;"
               data-table-source="<?php echo base_url() . $_modul . '/load'; ?>"
               data-table-filter="#filter_table">
            <thead>                         
                <tr>
                    <th data-sorting="false" class="text-align-center">NO</th>
                   <!--  <th>NAMA PEGAWAI</th> -->
                    <th class="col-md-1">USERNAME</th>
                    <th>PROJECT</th>
                    <th class="text-align-center">FUNCTION</th>
                </tr>
            </thead>
        </table>
    </div>
</div>


<script type="text/javascript">
    pageSetUp();
    var mydatatable = $('#dt_basic').myDataTable({
        columns: [
            {orderable : false},
            // {name: 'pegawai_nama'},
            {name: 'username_user'},
            // {name: 'nama_role'},
            // {name: 'cabang_nama'},
            {name: 'active_user'},
            {orderable: false},
        ],
    });

    $("form#filter_table").bind('submit',function(){
       _reloadTable()
       return false;
    });

    var _reloadTable = function(refresh) {
        mydatatable.reload(refresh);
    };
    
</script>