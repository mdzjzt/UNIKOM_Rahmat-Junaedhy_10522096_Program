<div class="container-fluid">
  <div class="portlet light">
      <div class="portlet-title">
          <div class="caption font-dark">
            <span class="caption-subject bold uppercase"><?php echo $page_title; ?></span>
            <span class="caption-helper"></span>
          </div>
      </div>
    <?php echo form_open_multipart($form_action, ['id' => 'finput', 'class' => 'form-horizontal'] ) ?>
      <div class="portlet-body">
        <fieldset>
          <!--   <div class="form-group">
                <label class="col-md-2 control-label">Username <sup>*</sup></label>
                <div class="col-md-3">
                    <?php //echo form_input('username_user', !empty($data_edit->username_user) ? $data_edit->username_user : '', 'class="form-control"'); ?>
                </div>
            </div> -->

            <div class="form-group">
                <label class="col-md-2 control-label">Pegawai <sup>*</sup></label>
                <div class="col-md-5"  id="participan_name">
                    <?php echo form_dropdown('id_user', $opt_user, !empty($data_edit->id_user) ? $data_edit->id_user : '', 'class="form-control select2" id="pegawai" '); ?>
                    <div class="note">
                        <table>
                            <tr>
                                <td><strong>Role</strong></td>
                                <td> : <span id="txt-nik"></span></td>
                            </tr>
                         <!--    <tr>
                                <td><strong>Cabang</strong></td>
                                <td> : <span id="txt-cabang"></span></td>
                            </tr> -->
                        <!--     <tr>
                                <td><strong>Jabatan</strong></td>
                                <td> : <span id="txt-jabatan"></span></td>
                            </tr> -->
                           <!--  <tr>
                                <td><strong>Unit Kerja</strong></td>
                                <td> : <span id="txt-unitkerja"></span></td>
                            </tr> -->
                        </table>
                        
                    </div>
                    <span id="error_employee_name"></span>
                </div>
            </div>
        

            <div class="form-group">
                <label class="col-md-2 control-label">Project <sup>*</sup></label>
                <div class="col-md-5">
                    <?php echo form_dropdown('id_project', $project, !empty($data_edit->id_project) ? $data_edit->id_project : '', 'class="form-control select2"'); ?>                    
                </div>
            </div>

       
        </fieldset>
      </div>
      <div class="portlet-title">
          <div class="modal-footer">
              <?php
                echo anchor(NULL, '<i class="glyphicon glyphicon-chevron-left"></i> Kembali', array(
                    'class' => 'btn btn-labeled btn-default margin-right-2',
                    'onclick' => 'my_global.go_back()'
                ));

                echo form_button([  
                        'type'    => 'submit',
                        'content' => '<i class="glyphicon glyphicon-floppy-disk"></i> Simpan',
                        'class'   => 'btn btn-success',
                ]);
              ?>
          </div>
      </div>
      <?php echo form_close(); ?>
  </div>
</div>


<script type="text/javascript">
    pageSetUp();

    var __afterSubmit = function(refresh) {
        my_global.go_back();
    };

    var myform = $('form#finput').myForm();

    $('form#finput').submit(function(event) {
        event.preventDefault();
        myform.submit();
    });

    var get_field = function (id) {
        $.post('<?php echo base_url().$_modul ?>/get_detail', {id: id}, function(data) {
            var response = $.parseJSON(data);
            $('#txt-nik').text(response.nama_role);
            // $('#txt-cabang').text(response.cabang);
            // $('#txt-jabatan').text(response.jabatan);
            // $('#txt-unitkerja').text(response.unitkerja);
        });
    };

    $('#pegawai').change(function(event) {
        var _this = $(this);
        var id    = _this.val();
        get_field(id);
    });

    if($('#pegawai').val()) get_field($('#pegawai').val());
</script>