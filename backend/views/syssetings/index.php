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
                <label class="control-label col-md-3">Key / Name / Value / Description</label>
                <div class="col-md-5">
                    <?php echo form_input('keyword', NULL, 'class="form-control" placeholder="Pencarian"'); ?>
                </div>
                <div class="col-md-3">
                    <?php
                      echo anchor(NULL, '<i class="fa fa-search"></i> Search', array(
                          'class' => 'btn btn-default btn-sm pull-left margin-right-2',
                          'onclick' => 'my_data_table.reload(\'#dt_basic\')'
                      ));
                      echo anchor(NULL, '<i class="fa fa-refresh"></i> Reset', array(
                          'class' => 'btn btn-default btn-sm pull-left',
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
            echo anchor(NULL, '<i class="glyphicon glyphicon-plus"></i> Add Data ' . $_title, array(
                'id' => 'mybutton-add',
                'class' => 'btn btn-labeled btn-primary',
                'data-breadcrumb' => 'Add',
                'onclick' => 'my_form.open(this.id)',
                'data-module' => $_modul,
                'data-url' => $_modul . '/add'
            ));
            endif;
        ?>
    </div>
    <div class="portlet-body">
        <table id="dt_basic" 
               class="table table-striped table-bordered table-hover" 
               width="100%" style="margin-top: 0 !important;"
               data-source="<?php echo base_url() . $_modul . '/load'; ?>"
               data-filter="#filter_table">
            <thead>                         
                <tr>
                    <th data-hide="phone" class="text-align-center">NO</th>
                    <th data-class="expand" class="text-align-center">KEY</th>
                    <th data-hide="expand">NAME</th>
                    <th data-hide="expand">VALUE</th>
                    <th data-hide="expand">DESCRIPTIONS</th>
                    <th data-hide="phone" class="text-align-center">FUNCTION</th>
                </tr>
            </thead>
        </table>
    </div>
</div>

<script type="text/javascript">
    pageSetUp();
    my_data_table.init('#dt_basic');

    $("form#filter_table").bind('submit',function(){
       my_data_table.reload('#dt_basic');
       return false;
    });
</script>