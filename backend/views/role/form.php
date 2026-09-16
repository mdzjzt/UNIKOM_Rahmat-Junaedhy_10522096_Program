<div class="container-fluid">
  <div class="portlet light bordered">
      <div class="portlet-title">
          <div class="caption font-dark">
            <span class="caption-subject bold uppercase"><?php echo $page_title; ?></span>
            <span class="caption-helper"></span>
          </div>
      </div>
    <div class="portlet-body">
        <?php
            $hidden_form = array('edit_id' => !empty($edit_id) ? $edit_id : '');
            echo form_open_multipart($form_action, array('id' => 'finput', 'class' => 'form-horizontal'), $hidden_form);
        ?>

        <fieldset>
            <div class="form-group">
                <label class="col-md-2 control-label">Role Name  <sup>*</sup></label>
                <div class="col-md-3">
                    <?php echo form_input('nama_role', !empty($data_edit->nama_role) ? $data_edit->nama_role : '', 'class="form-control"'); ?>
                </div>
            </div>

            <div class="form-group">
                <label class="col-md-2 control-label">Description</label>
                <div class="col-md-7">
                    <?php echo form_textarea('descript_role', !empty($data_edit->descript_role) ? $data_edit->descript_role : '', 'class="form-control" rows="2"'); ?>
                </div>
            </div>
           <!--  <div class="form-group">
                <label class="col-md-2 control-label">Modifying Account Code</label>
                <div class="col-md-7">
                    <div class="col-md-1">
                      <div class="checkbox">
                        <label><input type="radio" name="is_modify_account_code" value="1" <?php// echo !empty($data_edit->is_modify_account_code=='1') ?   ?  'checked="checked"':'';?>>YES</label>
                      </div>
                    </div>
                    <div class="col-md-1">
                      <div class="checkbox">
                        <label><input type="radio"  name="is_modify_account_code"  value="0" <?php// echo (empty($data_edit->is_modify_account_code)or($data_edit->is_modify_account_code=='0')) ? 'checked="checked"' : '';?>>NO</label>
                      </div>
                    </div>
                    
                </div>
            </div> -->
        </fieldset>

        <fieldset>
            <legend>
                Otoritas Modul
                <span class="pull-right font-sm">
                    <i class="fa fa-eye"></i> View,
                    <i class="fa fa-plus"></i> Add,
                    <i class="fa fa-edit"></i> Edit,
                    <i class="fa fa-trash-o"></i> Delete,
                    <i class="fa fa-legal"></i> Approve,
                    <i class="fa fa-download"></i> Export,
                    <i class="fa fa-upload"></i> Import
                </span>
            </legend>

            <div id="nestable-menu-role">
                <div class="pull-left">
                    <button type="button" class="btn btn-default" data-action="expand-all">Expand All</button>
                    <button type="button" class="btn btn-default" data-action="collapse-all">Collapse All</button>
                </div>

                <div class="col-md-2 no-padding pull-right">
                    <?php echo form_dropdown(NULL, $opt_otoritas_data, '', 'class="form-control" id="opt_otoritas_data" target-selected="dd_roles" onchange="my_global.set_value_selected(this.id)"'); ?>
                </div>
                <div class="col-md-3  no-padding pull-right">
                    <span style="display: none">
                        <?php echo form_checkbox('cb_select_menu', '', false, 'id="cb_select_menu" target-selected="cb_select"'); ?>
                    </span>
                    <?php
                    echo anchor(null, '<i class="fa fa-check-square-o"></i> Select All', array(
                        'class' => 'btn btn-labeled btn-default margin-right-5',
                        'onclick' => '_do_change_select(true)'
                    ));
                    echo anchor(null, '<i class="fa fa-square-o "></i> Diselect All', array(
                        'class' => 'btn btn-labeled btn-default margin-right-5',
                        'onclick' => '_do_change_select(false)'
                    ));
                    ?>
                </div>
            </div>
        </fieldset>
        <hr>
        <div style="max-width: none !important;" id="nestable3" class="dd">
            <?php echo $data_menu; ?>
        </div>
    </div>
      <div class="portlet-footer">
        <div class="modal-footer">
         <?php
            echo anchor(NULL, '<i class="glyphicon glyphicon-chevron-left"></i> Back', array(
                'id' => 'mybutton-add',
                'class' => 'btn btn-labeled btn-default margin-right-2',
                'onclick' => 'my_form.go_back()'
            ));
            echo anchor(NULL, '<i class="glyphicon glyphicon-floppy-disk"></i> Save', array(
                'id' => 'mybutton-add',
                'class' => 'btn btn-labeled btn-success',
                'onclick' => 'my_form.submit(\'#finput\')'
            ));
        ?>
        </div>
        <?php echo form_close() ?>
      </div>
  </div>
</div>

<script type="text/javascript">
    pageSetUp();
    my_form.init();

    var _nestable_setting = function () {
        $('#nestable3').nestable();

        $('#nestable-menu-role').on('click', function (e) {
            var target = $(e.target), action = target.data('action');
            if (action === 'expand-all') {
                $('.dd').nestable('expandAll');
            }
            if (action === 'collapse-all') {
                $('.dd').nestable('collapseAll');
            }
        });

        $(".dd-nodrag").on("mousedown", function (event) { // mousedown prevent nestable click
            event.preventDefault();
            return false;
        });

        $(".dd-nodrag").on("click", function (event) { // click event
            event.preventDefault();
            return false;
        });
    };

    var _do_change_select = function (status) {
        $('#cb_select_menu').prop('checked', status);
        my_global.select_all('cb_select_menu');
    };

    var _set_all_otoritas_data = function (val) {
        $('.dropdown_roles').val(val);
    };


    loadScript("<?php echo hconfig::base_assets(); ?>/plugin/nestable/jquery.nestable.min.js", _nestable_setting);
</script>
