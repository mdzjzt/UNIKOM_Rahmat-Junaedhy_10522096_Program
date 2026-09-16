<div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">
        <i class="fa fa-times"></i>
    </button>
    <h4 class="modal-title" id="myModalLabel">
        <?php echo $page_title; ?>
    </h4>
</div>
<div class="modal-body">
    <?php
    $hidden_form = array('edit_id' => !empty($edit_id) ? $edit_id : '');
    echo form_open_multipart($form_action, array('id' => 'finput', 'class' => 'form-horizontal'), $hidden_form);
    ?>
    <fieldset>
        <div class="form-group">
            <label class="col-md-3 control-label">Nama<sup>*</sup></label>   
            <div class="col-md-8">
                <?php echo form_input('bidang', !empty($data->bidang) ? $data->bidang : '', 'class="form-control" data-rule-required="true"'); ?>
            </div>
        </div> 
        <div class="form-group">
            <label class="col-md-3 control-label">Parent </label>   
            <div class="col-md-8">
                <?php echo form_dropdown('parent_id', $bidang, !empty($data->parent_id) ? $data->parent_id : '', 'class="select2 form-control" data-rule-required="true"'); ?>
            </div>
        </div> 
    </fieldset>
    <?php echo form_close(); ?>
</div>
<div class="modal-footer">
    <?php
    echo anchor(NULL, '<i class="glyphicon glyphicon-chevron-left"></i> Back', array(
        'id'           => 'mybutton-add',
        'class'        => 'btn btn-default margin-right-2',
        'data-dismiss' => 'modal'
    ));
    echo anchor(NULL, '<i class="glyphicon glyphicon-floppy-disk"></i> Save', array(
        'id'      => 'mybutton-add',
        'class'   => 'btn btn-success',
        'onclick' => '$(\'#finput\').submit()'
    ));
    ?>
</div>

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