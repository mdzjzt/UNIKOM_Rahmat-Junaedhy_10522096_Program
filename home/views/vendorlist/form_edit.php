        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">
                <i class="fa fa-times"></i>
            </button>
            <h4 class="modal-title" id="myModalLabel">
                <span class="widget-icon"> <i class="fa fa-edit"></i> </span> <?php echo $page_title; ?>
            </h4>
        </div>
        <div class="modal-body">
            <?php
            $hidden_form = array('edit_id' => !empty($edit_id) ? $edit_id : '');
            echo form_open_multipart($form_action, array('id' => 'finputt', 'class' => 'form-horizontal'), $hidden_form);
            ?>
           
                <div class="form-group">

                    <label class="col-md-1 control-label">Description </label>
                    <div class="col-md-2">
                      <?php echo form_input('description',!empty($data_edit->description) ? $data_edit->description : NULL, 'class="form-control"') ?>
                    </div>

                     <label class="col-md-1 control-label">Size </label>
                    <div class="col-md-2">
                        <?php echo form_input('size',!empty($data_edit->size) ? $data_edit->size : NULL, 'class="form-control"') ?>
                    </div>
                    <label class="col-md-1 control-label">Qty </label>
                    <div class="col-md-2">
                        <?php echo form_input('qty',!empty($data_edit->qty) ? $data_edit->qty : NULL, 'class="form-control"') ?>
                    </div>
                      <label class="col-md-1 control-label">Unit </label>
                     <div class="col-md-2">
                        <?php echo form_input('unit',!empty($data_edit->unit) ? $data_edit->unit : NULL, 'class="form-control"') ?>
                    </div>
                   
                   
                  
                   
                    
                </div>

                <div class="form-group">
                     <label class="col-md-1 control-label">Vendor </label>
                    <div class="col-md-2">
                        <?php echo form_input('vendor',!empty($data_edit->vendor) ? $data_edit->vendor : NULL, 'class="form-control"') ?>
                    </div>

                      <label class="col-md-1 control-label">Origin </label>
                    <div class="col-md-2">
                        <?php echo form_input('origin',!empty($data_edit->origin) ? $data_edit->origin : NULL, 'class="form-control"') ?>
                    </div>
                
                    <label class="col-md-1 control-label">Unit Price </label>
                    <div class="col-md-2">
                        <?php echo form_input('unit_price',!empty($data_edit->unit_price) ? $data_edit->unit_price : NULL, 'class="form-control"') ?>
                    </div>
                    <label class="col-md-1 control-label">Total Price </label>
                    <div class="col-md-2">
                        <?php echo form_input('total_price',!empty($data_edit->total_price) ? $data_edit->total_price : NULL, 'class="form-control"') ?>
                    </div>
                </div>
                    
                <div class="form-group">

                     <label class="col-md-1 control-label">Currency</label>
                    <div class="col-md-2">
                    <?php if ($data_edit->currency == 'IDR') {
                       $select = 'selected';
                    }else if($data_edit->currency == 'USD'){
                        $select = 'selected';
                    }else{
                         $select = '';   
                    } ?>
                        <select class="form-control" style="padding: 0px;" id="" name="simbolcurrency"  onchange="">
                            <option <?php echo $select ?> value="IDR">IDR</option>
                            <option  <?php echo $select ?> value="USD">USD</option>
                        </select>
                    </div>

                    <label class="col-md-1 control-label">Spesification </label>
                    <div class="col-md-3">
                      <?php echo form_textarea('specification',!empty($data_edit->spesicification) ? $data_edit->spesicification : NULL, 'class="form-control" cols="4" rows="4"') ?>
                    </div>
                    
                    <label class="col-md-1 control-label">Remarks </label>
                    <div class="col-md-4">
                      <?php echo form_textarea('remarks',!empty($data_edit->remarks) ? $data_edit->remarks : NULL, 'class="form-control" cols="4" rows="4"') ?>
                    </div>
                    
                   
                </div>


                </div>

            <?php echo form_close() ?>
        </form>
    </div>
    <div class="modal-footer">
        <?php
        echo anchor(NULL, '<i class="glyphicon glyphicon-chevron-left"></i> Back', array(
            'id' => 'mybutton-add',
            'class' => 'btn btn-default margin-right-2',
            'data-dismiss' => 'modal'
        ));
        echo anchor(NULL, '<i class="glyphicon glyphicon-floppy-disk"></i> Save', array(
            'id' => 'mybutton-add',
            'class' => 'btn btn-success',
            'onclick' => 'myform.submit(\'#finputt\')'
        ));
        ?>
    </div>

    <script type="text/javascript">
      pageSetUp();
      var myform = $('form#finputt').myForm();

        $('form#finputt').submit(function(event) {
            event.preventDefault();
            myform.submit();
        });

        var __afterSubmit = function() {
            $('#remoteModalBar').modal('hide');
              my_data_table.reload('#dt_basic');
      };
      
    </script>
