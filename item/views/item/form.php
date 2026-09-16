  <div class="container-fluid">
  <div class="portlet light">
      <div class="portlet-title">
          <div class="caption font-dark">
            <span class="caption-subject bold uppercase"><?php echo $page_title; ?></span>
            <span class="caption-helper"></span>
          </div>
      </div>
     
              <?php
                echo anchor(NULL, '<i class="glyphicon glyphicon-chevron-left"></i> Kembali', 
                [
                    'class'   => 'btn btn-default margin-right-2 pull-right',
                    'onclick' => 'my_form.go_back()'
                ]);
                
               ?>
      <ul id="tab-menu" class="nav nav-tabs tab-pegawai">
            <li class="active">
                <a href="#tab111" data-toggle="tab">ITEM <sup>*</sup></a>
            </li> 
            <li>
                <a href="#tab444" data-toggle="tab">GL ACCOUNTS <sup>*</sup></a>
            </li>
        </ul>
      <div class="portlet-body">
        
          <?php
              $hidden_form = array('id' => !empty($id) ? $id : '');
              echo form_open_multipart($form_action, ['id' => 'finput', 'class' => 'form-horizontal'], $hidden_form);
          ?>
          <div class="tab-content">
            <div class="tab-pane active" id="tab111">
                <fieldset>
                  <div class="form-group form-group-sm">
                    <label class="col-md-2 control-label">TYPE ITEM<sup>*</sup></label>
                    <div class="col-md-3">
                      <?php echo form_dropdown('id_type', $typeoption, !empty($data->id_type) ? $data->id_type : '', 'class="form-control select2" data-rule-required="true"'); ?>
                       
                    </div>
                     <label class="col-md-2 control-label">QUANTITY <sup>*</sup></label>
                    <div class="col-md-3">
                        <?php  echo form_input('qty_item',!empty($data->qty_item) ? $data->qty_item : NULL, 'class="form-control numeric" placeholder="1"  ') ?>
                    </div>
                  </div>
                   <div class="form-group form-group-sm">
                    <label class="col-md-2 control-label">CODE ITEM NO. <sup>*</sup></label>
                    <div class="col-md-3">
                       <?php  echo form_input('code_item_number',!empty($data->code_item_number) ? $data->code_item_number : $kodeitem, 'class="form-control " placeholder="$"  ') ?>
                    </div>
                      <label class="col-md-2 control-label">UNIT PRICE<sup>*</sup></label>
                    <div class="col-md-3">
                       <?php  echo form_input('unit_price_item',!empty($data->unit_price_item) ? $data->unit_price_item : NULL, 'class="form-control number" placeholder="100.000"  ') ?>
                    </div>
                  </div>
                  <div class="form-group form-group-sm">
                    <label class="col-md-2 control-label">NAMA ITEM <sup>*</sup></label>
                    <div class="col-md-3">
                        <?php  echo form_textarea('nama_item',!empty($data->nama_item) ? $data->nama_item : NULL, 'class="form-control" rows="4" placeholder="" ') ?>
                    </div>
                      <label class="col-md-2 control-label">UNIT <sup>*</sup></label>
                    <div class="col-md-3">
                       <?php  echo form_input('nama_unit',!empty($data->nama_unit) ? $data->nama_unit : NULL, 'class="form-control " placeholder="Unit"  ') ?>
                    </div>
                  </div>
                 
                   <div class="form-group form-group-sm">
                    <label class="col-md-2 control-label">AS OF <sup>*</sup></label>
                    <div class="col-md-3">
                     <div class='input-group date'>
                          <?php echo form_input('as_of_item', !empty($data->as_of_item) ? $data->as_of_item : date('Y-m-d'), 'class="form-control date" data-rule-required="true"') ?>
                            <span class="input-group-addon"><span class="fa fa-calendar"></span></span>                    
                      </div>
                    </div>
                  </div>
              </fieldset>
            </div>
            <div class="tab-pane " id="tab444">
                <fieldset>
                  <div class="form-group form-group-sm">
                    <label class="col-md-2 control-label">Inventory Account<sup>*</sup></label>
                    <div class="col-md-3">
                      <?php echo form_dropdown('id_inventory_account', $account_type_receipe, !empty($data->id_inventory_account) ? $data->id_inventory_account : '', 'class="form-control select2" data-rule-required="true"'); ?>
                    </div>
                  </div>
                    <div class="form-group form-group-sm">
                    <label class="col-md-2 control-label">Sales Account<sup>*</sup></label>
                    <div class="col-md-3">
                      <?php echo form_dropdown('id_sales_account', $account_type_other_income, !empty($data->id_sales_account) ? $data->id_sales_account : '', 'class="form-control select2" data-rule-required="true"'); ?>
                    </div>
                  </div>
                  <div class="form-group form-group-sm">
                    <label class="col-md-2 control-label">Sales Return Account<sup>*</sup></label>
                    <div class="col-md-3">
                      <?php echo form_dropdown('id_sales_return', $account_type_other_income, !empty($data->id_sales_return) ? $data->id_sales_return : '', 'class="form-control select2" data-rule-required="true"'); ?>
                    </div>
                  </div>
                  <div class="form-group form-group-sm">
                    <label class="col-md-2 control-label">Sales Item Disc Account<sup>*</sup></label>
                    <div class="col-md-3">
                      <?php echo form_dropdown('id_sales_item_discount', $account_type_other_income, !empty($data->id_sales_item_discount) ? $data->id_sales_item_discount : '', 'class="form-control select2" data-rule-required="true"'); ?>
                    </div>
                  </div>
                  <div class="form-group form-group-sm">
                    <label class="col-md-2 control-label">COGS Account<sup>*</sup></label>
                    <div class="col-md-3">
                      <?php echo form_dropdown('id_cogs', $account_type_cogs, !empty($data->id_cogs) ? $data->id_cogs : '', 'class="form-control select2" data-rule-required="true"'); ?>
                    </div>
                  </div>
                  <div class="form-group form-group-sm">
                    <label class="col-md-2 control-label">Purchase Ret Account<sup>*</sup></label>
                    <div class="col-md-3">
                      <?php echo form_dropdown('id_retention_account', $account_type_receipe, !empty($data->id_retention_account) ? $data->id_retention_account : '', 'class="form-control select2" data-rule-required="true"'); ?>
                    </div>
                  </div>
                  <div class="form-group form-group-sm">
                    <label class="col-md-2 control-label">Unbilled Goods Account<sup>*</sup></label>
                    <div class="col-md-3">
                      <?php echo form_dropdown('id_unbilled', $account_type_liabilty, !empty($data->id_unbilled) ? $data->id_unbilled : '', 'class="form-control select2" data-rule-required="true"'); ?>
                    </div>
                  </div>
                 <!--  <div class="form-group form-group-sm">
                    <label class="col-md-2 control-label">Inventory Control Account</label>
                    <div class="col-md-3">
                      <?php //echo form_dropdown('id_control_account', $account_type, !empty($data->id_type) ? $data->id_type : '', 'class="form-control select2" data-rule-required="true"'); ?>
                    </div>
                  </div> -->
              </fieldset>
            </div>
          </div>
        
      </div>
      <div class="portlet-footer">
          <div class="modal-footer">
              <?php
                echo anchor(NULL, '<i class="glyphicon glyphicon-chevron-left"></i> Kembali', array(
                    'id' => 'mybutton-add',
                    'class' => 'btn btn-default margin-right-2',
                    'onclick' => 'my_form.go_back()'
                ));
                echo anchor(NULL, '<i class="glyphicon glyphicon-floppy-disk"></i> Simpan', array(
                    'id' => 'mybutton-add',
                    'class' => 'btn btn-success',
                    'onclick' => '$(\'form#finput\').submit()'
                ));
               ?>
          </div>
      </div>
      <?php echo form_close() ?>
  </div>
</div>


<div class="modal container" id="modalPegawai" data-backdrop="static" tabindex="-1"> </div>
<!-- /.modal -->

<script type="text/javascript">
    pageSetUp();

    var formBasic = $('form#finput');
    $('form#finput').submit(function(event) {
        event.preventDefault();
        formBasic.myForm().submit();
    });

    $("form#filter_table").bind('submit',function(){
       my_data_table.reload('#dt_akun');
       return false;
    });

   var __afterSubmit = function() {
        setTimeout(function(){
          my_form.go_back();
        },200);
      };


    
</script>