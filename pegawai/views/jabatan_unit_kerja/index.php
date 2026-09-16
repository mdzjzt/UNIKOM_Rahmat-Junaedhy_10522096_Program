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
                <label class="col-md-2 control-label">Jabatan</label>
                <div class="col-md-3">
                     <?php echo form_dropdown('posisi_index', $posisi_options, '' ,'class="select2"'); ?>
                </div>
            </div>
            <div class="form-group form-group-sm">
                <label class="col-md-2 control-label">Cabang</label>
                <div class="col-md-3">
                     <?php echo form_dropdown('cabang_index', $lokasi_options, '' ,'class="select2"'); ?>
                </div>
            </div>
            <div class="form-group form-group-sm">
                <label class="col-md-2 control-label">Unit Kerja</label>
                <div class="col-md-3">
                     <?php echo form_dropdown('unit_index', $unit_options, '' ,'class="select2"'); ?>
                </div>
            </div>
	    
            
            <div class="form-group form-group-sm">
                <label class="control-label col-md-2">Status</label>
                <div class="col-md-5">
                      <?php echo form_dropdown('status', array(''=>'Semua Status','ya'=>'Masih Berlaku','tidak'=>'Tidak Berlaku'), '', 'id="tahun" class="select2"') ?>
                </div>
                <div class="col-md-4">
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
        <table id="dt_basic" 
               class="table table-striped table-bordered table-hover" 
               width="100%" style="margin-top: 0 !important;"
               data-source="<?php echo base_url() . $_modul . '/load'; ?>"
               data-filter="#filter_table">
            <thead>
                <tr>
                    <th class="text-align-center">NO</th>
                    <th>AREA</th>
                    <th>NAMA UNIT KERJA</th>
                    <th>NAMA JABATAN</th>
                    <th>MASA BERLAKU</th>
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
    my_data_table.init('#dt_basic');

    $("form#filter_table").bind('submit',function(){
       my_data_table.reload('#dt_basic');
       return false;
    });
</script>






