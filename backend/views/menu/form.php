        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">
                <i class="fa fa-times"></i>
            </button>
            <h6 class="modal-title" id="myModalLabel">
                <span class="widget-icon"> <i class="fa fa-edit"></i> </span> <?php echo $page_title; ?>
            </h6>
        </div>
        <div class="modal-body">
            <?php
            $hidden_form = array('edit_id' => !empty($edit_id) ? $edit_id : '', 'm_m_id_menu' => !empty($m_m_id_menu) ? $m_m_id_menu : '');
            echo form_open_multipart($form_action, array('id' => 'finput', 'class' => 'form-horizontal'), $hidden_form);
            ?>
            <fieldset>
                <div class="form-group">
                    <label class="col-md-3 control-label">Menu Name  <sup>*</sup></label>
                    <div class="col-md-8">
                        <?php echo form_input('menu_name', !empty($data_edit->nama_menu) ? $data_edit->nama_menu : '', 'class="form-control"'); ?>
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-md-3 control-label">URL <sup>*</sup></label>
                    <div class="col-md-7">
                        <div class="input-group">
                            <span class="input-group-addon"><i class="fa fa-link"></i></span>
                            <?php echo form_input('menu_url', !empty($data_edit->url_menu) ? $data_edit->url_menu : '', 'class="form-control"'); ?>
                        </div>
                        <span id="error_menu_url"></span>
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-md-3 control-label">Icon</label>
                    <div class="col-md-3">
                        <?php echo form_input('menu_icon', !empty($data_edit->icon_menu) ? $data_edit->icon_menu : '', 'class="form-control"'); ?>
                    </div>
                </div>

            </fieldset>
            <?php echo form_close(); ?>
        </div>
        <div class="modal-footer">
            <?php
            echo anchor(NULL, '<i class="glyphicon glyphicon-chevron-left"></i> Back', array(
                'id' => 'mybutton-add',
                'class' => 'btn btn-labeled btn-default margin-right-2',
                'data-dismiss' => 'modal'
            ));
            echo anchor(NULL, '<i class="glyphicon glyphicon-floppy-disk"></i> Save', array(
                'id' => 'mybutton-add',
                'class' => 'btn btn-labeled btn-success',
                'onclick' => 'my_form.submit(\'#finput\')'
            ));
            ?>
        </div>

        <script type="text/javascript">
            pageSetUp();
            my_form.init();

            var load_and_reset_form = function () {
                pagefunction();
                my_form.reset('#finput');
                $('#remoteModal').modal('hide');
            };
        </script>
