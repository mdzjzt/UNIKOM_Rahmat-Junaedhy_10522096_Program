<div class="row">
  <div class="portlet light bordered">
    <div class="portlet-title">
        <div class="caption font-dark">
            <span class="caption-subject bold uppercase"><?php echo $page_title;?></span>
            <span class="caption-helper"></span>
        </div>
    </div>
    <div class="portlet-title">
        <form class="form-horizontal" id="filter_table">
            <div class="form-group form-group-sm">
               
                <div class="col-md-2 ">
                    <?php echo form_input('desccirption', NULL, 'class="form-control" placeholder="Description"'); ?>
                </div>
                <div class="col-md-2">
                    <?php echo form_input('size', NULL, 'class="form-control" placeholder="Size"'); ?>
                </div>
                <div class="col-md-2">
                    <?php echo form_input('qty', NULL, 'class="form-control" placeholder="QTY"'); ?>
                </div>
                <div class="col-md-2">
                    <?php echo form_input('unit', NULL, 'class="form-control" placeholder="Unit"'); ?>
                </div>
                <div class="col-md-4 desc_temp">
                    <?php echo form_input('specification', NULL, 'class="form-control" placeholder="Specification"'); ?>
                </div>
                <div class="col-md-2">
                    <?php echo form_input('vendor', NULL, 'class="form-control" placeholder="Vendor"'); ?>
                </div>
                <div class="col-md-2">
                    <?php echo form_input('origin', NULL, 'class="form-control" placeholder="Origin"'); ?>
                </div>
                 <div class="col-md-4">
                    <?php echo form_input('remarks', NULL, 'class="form-control" placeholder="Remarks"'); ?>
                </div>
                <div class="col-md-2">
                    <?php
                      echo form_button(array(
                                      'class' => 'btn btn-default btn-sm pull-left',
                                      'content' => '<i class="fa fa-search"></i> Search',
                                      'type'    => 'submit',
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
            if ($this->laccess->otoritas('add')) {
                echo anchor($_modul . '/add', '<i class="glyphicon glyphicon-plus"></i> Add Vendor Material', array(
              'id' => 'mybutton-add',
              'class' => 'btn btn-labeled btn-primary',
                ));
            }
           
            echo anchor(NULL, ' Import Excel', array(
              'id'          => 'mybutton-add',
              'class'       => 'btn btn-labeled btn-success',
              'data-toggle' => 'modal',
              'data-target' => '#modal-import'
            ));

             echo anchor(base_url().'uploads/template_excel/Template_material_vendor.xlsx', '<i class="fa fa-download"></i> Template Excel', array(
              'id'          => 'mybutton-add',
              'class'       => 'btn btn-labeled btn-success',
              
            ));


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
                    <th data-class="expand">DESCRIPTION</th>
                    <!-- <th data-class="expand">RADIUS</th>
                    <th data-hide="expand" style="width:75px">DEGREE</th> -->
                    <th data-hide="expand" style="width:50px">SIZE</th>
                    <th data-hide="expand" style="width:50px">QTY</th>
                    <th data-hide="expand" style="width:50px">UNIT</th>
                    <th data-hide="expand" style="">SPECIFICATION</th>
                    <th data-hide="expand" style="">VENDOR</th>
                    <th data-hide="expand" style="">ORIGIN</th>
                    <th data-hide="phone" class="text-align-center">UNIT PRICE</th>
                    <th data-hide="phone" class="text-align-center">TOTAL PRICE</th>
                    <th data-hide="phone" class="text-align-center">REMARKS</th>
                    <th> </th>
                </tr>
            </thead>
        </table>
    </div>
  </div>
</div>

 <!-- Dynamic Modal -->  
  
  <div class="modal container" id="remoteModalBar" data-backdrop="static"></div>
  
  
  <div class="modal" id="modal-import" data-backdrop="static">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">
              <i class="fa fa-times"></i>
          </button>
          <h4 class="modal-title">
            <span class="caption-subject bold uppercase"> 
                      IMPORT EXCEL
              </span>
        </h4>
      </div>

      <?php echo form_open_multipart($_modul .'/import', array('class' => 'form-horizontal', 'id' => 'form-import')) ?>

        <div class="modal-body">
          <div class="fileinput fileinput-new input-group" data-provides="fileinput">
            <div class="form-control" data-trigger="fileinput"><i class="glyphicon glyphicon-file fileinput-exists"></i> <span class="fileinput-filename"></span></div>
            <span class="input-group-addon btn btn-default btn-file"><span class="fileinput-new">Select file</span><span class="fileinput-exists">Change</span>
            <input type="file" name="file"></span>
            <a href="#" class="input-group-addon btn btn-default fileinput-exists" data-dismiss="fileinput">Remove</a>
          </div>
        </div>

      

      <div class="modal-footer">
          <?php echo form_button(array(
                  'content' => 'Batal',
                  'type' => 'button',
                  'class' => 'btn default',
                  'data-dismiss' => 'modal'
          )) ?>

          <?php echo form_button(array(
                  'content' => '<i class="fa fa-import"></i> Import',
                  'type' => 'submit',
                  'class' => 'btn green'
          )) ?>   
      </div>
      <?php echo form_close() ?>
  </div>
  <!-- /.modal -->

<script type="text/javascript">
    pageSetUp();
    my_data_table.init('#dt_basic');

    $("form#filter_table").bind('submit',function(){
       my_data_table.reload('#dt_basic');
       return false;
    });

    


    $('form#form-import').submit(function(event) {
          event.preventDefault();
          $(this).myForm({
            confirmMessage : 'Anda yakin akan mengimport file ke data vendor ?',
            success : function() {
                $('.modal').modal('hide');
                my_data_table.reload('#dt_basic');
            }
        }).submit();
    });

</script>

