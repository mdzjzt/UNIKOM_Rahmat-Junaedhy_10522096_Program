<html>
    <head>
        <script id="tinyhippos-injected">
            if (window.top.ripple) {
                window.top.ripple("bootstrap").inject(window, document);
            }
        </script>
        <meta http-equiv="Content-Type" content="text/html; charset=ISO-8859-1">
    </head>
    <body>
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
                    <label class="col-md-3 control-label">Key  <sup>*</sup></label>
                    <div class="col-md-9">
                        <?php echo form_input('key_setting', !empty($data_edit->key_setting) ? $data_edit->key_setting : '', 'class="form-control"'); ?>
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-md-3 control-label">Name  <sup>*</sup></label>
                    <div class="col-md-9">
                        <?php echo form_input('name_setting', !empty($data_edit->name_setting) ? $data_edit->name_setting : '', 'class="form-control"'); ?>
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-md-3 control-label">Value  <sup>*</sup></label>
                    <div class="col-md-9">
                        <?php echo form_input('value_setting', !empty($data_edit->value_setting) ? $data_edit->value_setting : '', 'class="form-control"'); ?>
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-md-3 control-label">Description</label>
                    <div class="col-md-9">
                        <?php echo form_textarea('description_setting', !empty($data_edit->description_setting) ? $data_edit->description_setting : '', 'class="form-control"'); ?>
                    </div>
                </div>

            </fieldset>
            <?php echo form_close(); ?>
        </div>
        <div class="modal-footer">
            <?php
            echo anchor(NULL, '<span class="btn-label"><i class="glyphicon glyphicon-chevron-left"></i></span> Back', array(
                'id' => 'mybutton-add',
                'class' => 'btn btn-labeled btn-default margin-right-2',
                'data-dismiss' => 'modal'
            ));
            echo anchor(NULL, '<span class="btn-label"><i class="glyphicon glyphicon-floppy-disk"></i></span> Save', array(
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
            };
        </script>
    </body>
</html>