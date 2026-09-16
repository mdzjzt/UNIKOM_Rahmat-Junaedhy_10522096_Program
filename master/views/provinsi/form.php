        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">
                <i class="fa fa-times"></i>
            </button>
            <h4 class="modal-title">
                <?php echo $page_title; ?>
            </h4>
        </div>
        
        <?php
            $hidden_form = array('edit_id' => !empty($edit_id) ? $edit_id : '');
            echo form_open_multipart($form_action, array('id' => 'finput', 'class' => 'form-horizontal'), $hidden_form);
        ?>

        <div class="modal-body">
            <fieldset>
                <div class="form-group">
                    <?php echo form_label('Kode <sup>*</sup>', 'Kode', ['class' => 'control-label col-md-3']) ?>
                    <div class="col-md-4">
                        <?php echo form_input('provinsi_id', !empty($data_edit->provinsi_id) ? $data_edit->provinsi_id : '', 'class="form-control" data-rule-required="true"'); ?>
                    </div>
                </div>

                <div class="form-group">
                    <?php echo form_label('Provinsi <sup>*</sup>', 'Provinsi', ['class' => 'control-label col-md-3']) ?>
                    <div class="col-md-8">
                        <?php echo form_input('provinsi_name', !empty($data_edit->provinsi_nama) ? $data_edit->provinsi_nama : '', 'class="form-control" data-rule-required="true"'); ?>
                    </div>
                </div>
            </fieldset>
        </div>

        <div class="modal-footer">
            <?php
                echo anchor(NULL, '<i class="glyphicon glyphicon-chevron-left"></i> Back', array(
                    'class' => 'btn btn-labeled btn-default margin-right-2',
                    'data-dismiss' => 'modal'
                ));

                echo form_button([  
                        'type'    => 'submit',
                        'content' => '<i class="glyphicon glyphicon-floppy-disk"></i> Save',
                        'class'   => 'btn btn-success',
                ]);
            ?>
        </div>
        <?php echo form_close() ?>

<script type="text/javascript">
    pageSetUp();

    var _afterSubmit = function(refresh) {
        $('.modal').modal('hide');
        mydatatable.reload(refresh);
    };

    var myform = $('form#finput').myForm();

    $('form#finput').submit(function(event) {
        event.preventDefault();
        myform.submit();
    });
</script>