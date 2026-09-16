<div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">
        <i class="fa fa-times"></i>
    </button>
    <h4 class="modal-title">
        <?php echo $page_title; ?>
    </h4>
</div>
<?php
    
    echo form_open_multipart($form_action, ['id' => 'finput', 'class' => 'form-horizontal']);
    echo form_hidden('workflow_id', $workflow_id);
    echo form_hidden('flag', !empty($flag) ? $flag : NULL);
?>
<div class="modal-body">
    <fieldset>
        <div class="form-group">
            <label class="col-md-2 control-label">Role<sup>*</sup></label>
            <div class="col-md-3">
                <?php echo form_dropdown('role_id[]',$role,!empty($data_edit->role_id) ? $data_edit->role_id : NULL,'class="form-control select2"') ?>
            </div>
            <div class="col-md-3"> 
                <?php echo form_dropdown('range', $range, !empty($data->range_id) ? $data->range_id : NULL, 'class="form-control select2" id="range"') ?>
            </div>
            <div class="col-md-3">
                    <?php echo form_dropdown('deparment', $department_project, '', 'class="form-control select2"') ?>
            </div>
        </div>

         <div class="form-group">
            <label class="col-md-2 control-label" style="color:red">OR</label>
            <div class="col-md-8">
                <?php echo form_dropdown('role_id[]',$role,!empty($data_edit->role_id) ? $data_edit->role_id : NULL,'class="form-control select2" ') ?>
            </div>
        </div>

         <!--  <div class="form-group">
            <label class="col-md-2 control-label" style="color:red">OR</label>
            <div class="col-md-8">
                <?php //echo form_dropdown('role_id[]',$role,!empty($data_edit->role_id) ? $data_edit->role_id : NULL,'class="form-control select2" ') ?>
            </div>
        </div> -->
      <!--   <div class="form-group">
            <label class="control-label col-md-3">Cabang<sup>*</sup></label>
            <div class="col-md-8">
                <?php 
                   // $cabangId = !empty($data->cabang_id) ? $data->cabang_id : $this->input->get('cabang_id');
                   // $cabangNama = $this->cabang_model->data($cabangId)->get()->row()->cabang_nama;
                ?>
                <?php //echo form_dropdown('cabang_id', $cabang,!empty($data->cabang_id) ? $data->cabang_id : $this->input->get('cabang_id'), 'class="form-control select2"'); ?>
                <?php// echo form_input(NULL, $cabangNama, 'class="form-control" readonly') ?>
                <?php// echo form_hidden('cabang_id', $cabangId); ?>
            </div>
        </div>
 -->
         <div class="form-group">
            <label class="control-label col-md-2">Project<sup>*</sup></label>
            <div class="col-md-8">
                <?php 
                    $projectid = !empty($data->id_m_project) ? $data->id_m_project : $this->input->get('project_id');
                    $projectNama = $this->project_all_model->data($projectid)->get()->row()->nama_project;
                ?>
                <?php echo form_input(NULL, $projectNama, 'class="form-control" readonly') ?>
                <?php echo form_hidden('project_id', $projectid); ?>
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
            'content' => '<i class="glyphicon glyphicon-floppy-disk"></i> Simpan',
            'class'   => 'btn btn-success',
        ]);
    ?>
</div>
<?php echo form_close(); ?>

<script type="text/javascript">

    pageSetUp();
    
    var myform = $('form#finput').myForm();

    $('form#finput').submit(function(event) {
        event.preventDefault();
        myform.submit();
    });
   
</script>
