<div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">
        <i class="fa fa-times"></i>
    </button>
    <h4 class="modal-title">
        <?php echo $pageTitle; ?>
    </h4>
</div>
    <?php
        echo form_open_multipart($formAction, ['id' => 'finput', 'class' => 'form-horizontal']);
    ?>
<div class="modal-body">
    <fieldset>
        <div class="form-group">
            <label class="col-md-3 control-label">Kode<sup>*</sup></label>
            <div class="col-md-6">
                <?php echo form_input('cabang_id', !empty($data->cabang_id) ? $data->cabang_id : '', 'class="form-control" data-rule-required="true"'); ?>
            </div>
        </div>

        <div class="form-group">
            <label class="col-md-3 control-label">Cabang<sup>*</sup></label>
            <div class="col-md-8">
                    <?php echo form_input('cabang_nama', !empty($data->cabang_nama) ? $data->cabang_nama : '', 'class="form-control" data-rule-required="true"'); ?>
                <span id="error_menu_url"></span>
            </div>
        </div>

    </fieldset>
</div>
<div class="modal-footer">
    <?php
        echo anchor(NULL, '<i class="glyphicon glyphicon-chevron-left"></i> Back', 
        [
            'class' => 'btn btn-labeled btn-default margin-right-2',
            'data-dismiss' => 'modal'
        ]);

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
    var myform = $('form#finput').myForm();
    
    var __afterSubmit = function(refresh) {
        $('.modal').modal('hide');
        mydatatable.reload(refresh);
    
    };

    $('form#finput').submit(function(event) {
        event.preventDefault();
        myform.submit();
    });
</script>