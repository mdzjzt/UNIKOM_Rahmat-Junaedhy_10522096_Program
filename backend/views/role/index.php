<div class="row">
  <div class="portlet light bordered">
     <div class="portlet-title">
        <div class="caption font-dark">
            <span class="caption-subject bold uppercase"><?php echo $page_title; ?></span>
            <span class="caption-helper"></span>
        </div>
        <div class="actions">
          <a class="btn btn-circle btn-icon-only btn-default fullscreen" href="#" rel="tooltip" data-placement="top" title="fullscreen"></a>
        </div>
     </div>
     <div class="portlet-title">
      <form class="form-horizontal" id="filter-table">
        <div class="form-group form-group-sm">
          <?php echo form_label('Role', 'keyword', ['class' => 'control-label col-md-1']) ?>
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
        <?php if ($this->laccess->otoritas('add')) : ?>
            <?php
                echo anchor(NULL, '<i class="glyphicon glyphicon-plus"></i> Tambah ' . $_title, array(
                    'id' => 'mybutton-add',
                    'class' => 'btn btn-labeled btn-primary',
                    'data-breadcrumb' => 'Add',
                    'onclick' => 'my_form.open(this.id)',
                    'data-module' => $_modul,
                    'data-url' => $_modul . '/add'
                ));
            ?>
        <?php endif; ?>
    </div>
     <div class="portlet-body">
        <table id="dt-basic" 
               class="table table-striped table-bordered table-hover" 
               width="100%" style="margin-top: 0 !important;"
               data-table-source="<?php echo base_url() . $_modul . '/load'; ?>"
               data-table-filter="#filter-table">
            <thead>                         
                <tr>
                    <th data-sorting="false" class="col-sm-1">NO</th>
                    <th class="col-sm-5"> ROLE NAME </th>
                    <th>DESCRIPTION</th>
                    <th class="col-sm-1">FUNCTION</th>
                </tr>
            </thead>
        </table>
     </div>
  </div>
</div>


<script type="text/javascript">
    pageSetUp();
    var mydatatable = $('#dt-basic').myDataTable({
        columns: [
            {orderable : false},
            {name: 'nama_role'},
            {name: 'descript_role'},
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