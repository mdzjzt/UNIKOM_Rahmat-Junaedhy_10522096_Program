<div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">
        <i class="fa fa-times"></i>
    </button>
    <h4 class="modal-title" id="myModalLabel">
        <?php echo $page_title; ?>
    </h4>
</div>
<?php
    echo form_open_multipart($form_action, ['id' => 'finput', 'class' => 'form-horizontal']);
?>
<div class="modal-body">
    <fieldset>
       <!--  <div class="form-group">
            <label class="col-md-3 control-label">Cabang<sup>*</sup></label>
            <div class="col-md-8">
                <?php // echo form_dropdown('cabang_id', $cabang, !empty($data->cabang_id) ? $data->cabang_id : NULL, 'class="form-control select2"') ?>
            </div>
        </div> -->

        <div class="form-group">
            <label class="col-md-3 control-label">Role</label>
            <div class="col-md-8">
                 <?php echo form_dropdown('role_id', $role, !empty($data->role_id) ? $data->role_id : NULL, 'class="form-control select2"') ?>
            </div>
        </div>

        <div class="form-group">
            <label class="col-md-3 control-label">Limit</label>
            <div class="col-md-8">
                 <?php echo form_input('limit', !empty($data->limit) ? $data->limit : NULL, 'class="form-control number"') ?>
            </div>
        </div>

    </fieldset>
</div>
<div class="modal-footer">
    <?php
        echo anchor(NULL, '<i class="glyphicon glyphicon-chevron-left"></i> Batal', array(
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
<?php echo form_close(); ?>


<script type="text/javascript">
    pageSetUp();
    var myform = $('form#finput').myForm();
    
    var __afterSubmit = function(refresh) {
        $('.modal').modal('hide');
        __reloadTable(refresh);
    
    };

    $('form#finput').submit(function(event) {
        event.preventDefault();
        myform.submit();
    });
</script>
