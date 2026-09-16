    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">
            <i class="fa fa-times"></i>
        </button>
        <h4 class="modal-title"><?php echo $page_title; ?></h4>
    </div>
    <?php
        echo form_open_multipart($form_action, ['id' => 'finput', 'class' => 'form-horizontal']);
    ?>
    <div class="modal-body">
        <fieldset>
            <div class="form-group">
                <label class="col-md-2 control-label">Jenis Barang <sup>*</sup></label>
                <div class="col-md-8">
                    <?php echo form_input('nama_jenis_barang', !empty($data_edit->nama_jenis_barang) ? $data_edit->nama_jenis_barang : '', 'class="form-control" data-rule-required="true"'); ?>
                </div>
            </div>
        </fieldset>
        <br>
        <div class="row">
            <div class="col-md-12">
              <div class="panel panel-default">
                <div class="panel-heading"> 
                    <a href="javascript:;" class="btn btn-xs btn-info" id="add-ahay" onclick="my_table_awesome.append('table-ahay')"><i class="fa fa-plus"></i> Tambah Spek</a> 
                </div>
                <div class="panel-body">
                  <table id="table-ahay" class="table table-striped table-bordered  dataTable no-footer">
                    <head>
                      <tr>
                        <th style="width:50px">No</th>
                        <th style="width:300px">Label</th>
                        <th style="width:170px">Tipe</th>
                        <th colspan="2">Nilai</th>
                      </tr>
                    </head>
                    
                    <tbody class="data-row">
                       <?php 
                            if(isset($data_detail)):
                                $no = 1;
                                foreach($data_detail->result() as $key => $dt):
                                    
                        ?>
                             <tr class="row-clone" data-id="<?php echo $dt->id ?>">
                                <td class="no-urut"><?php echo $no++ ?></td>
                                <td>
                                    <?php echo form_hidden('urutan[]', NULL,'class="no-urut"') ?>
                                    <?php echo form_hidden('id_detail[]', $dt->id) ?>
                                    <?php // echo form_input('nilai[]', $dt->nilai,'class="attribute-combobox-value"') ?>
                                    <?php echo form_textarea('nilai[]', $dt->nilai,'class="attribute-combobox-value" style="display: none;"') ?>
                                    <?php echo form_input('label[]', $dt->label, 'class="form-control" data-rule-required="true"') ?>
                                </td>
                                <td>
                                   <?php echo form_dropdown('atribut[]',array('text' => 'Textfield', 'combobox' => 'Combobox'),$dt->atribut,'class="form-control input-sm type"') ?>
                                </td>
                                <td>
                                    <div class="div-textfield">
                                        <div class="col-md-10">
                                            <?php //echo form_input('nilai[]',NULL,'class="form-control input-sm"') ?>
                                        </div>
                                    </div>
                                    <div class="row div-combobox">
                                        <div class="col-md-10">
                                            <?php 
                                                $comvalue = array();
                                                if($dt->atribut == 'combobox' && !empty($dt->nilai)):
                                                    $nilai = json_decode($dt->nilai);
                                                    if(!empty($nilai)):
                                                        foreach ($nilai as $val):
                                                            $comvalue[$val] = $val;
                                                        endforeach;
                                                    endif;
                                                endif;
                                            ?>

                                            <?php echo form_dropdown(NULL,$comvalue,NULL,'class="form-control input-sm attribute-combobox"') ?>
                                        </div>
                                        <button type="button" class="btn btn-info btn-sm btn-show-list"><i class="fa fa-edit"></i></button> 
                                    </div>
                                </td>
                                <td><a class="action-del" onclick="my_table_awesome.del('table-ahay', this.id)"><i class="fa fa-remove"></i></a></td>
                            </tr>
                        <?php endforeach; ?>

                        <?php else: ?>
                            <tr class="row-clone">
                                <td class="no-urut"></td>
                                <td> 
                                     <?php echo form_hidden('id_detail[]', NULL) ?>
                                     <?php echo form_hidden('nilai[]', NULL,'class="attribute-combobox-value"') ?>
                                     <?php echo form_input('label[]', NULL, 'class="form-control input-sm"') ?>
                                </td>
                                <td>
                                   <?php echo form_dropdown('atribut[]',array('text' => 'Textfield', 'combobox' => 'Combobox'),NULL,'class="form-control input-sm type"') ?>
                                </td>
                                <td>
                                    <div class="div-textfield">
                                        <div class="col-md-10">
                                            <?php //echo form_input('nilai[]',NULL,'class="form-control input-sm"') ?>
                                        </div>
                                    </div>
                                    <div class="row div-combobox">
                                        <div class="col-md-10">
                                            <?php echo form_dropdown(NULL,  array(),NULL,'class="form-control input-sm attribute-combobox"') ?>
                                        </div>
                                        <button type="button" class="btn btn-info btn-sm btn-show-list"><i class="fa fa-edit"></i></button> 
                                    </div>
                                </td>
                                <td><a class="action-del" onclick="my_table_awesome.del('table-ahay', this.id)"><i class="fa fa-remove"></i></a></td>
                            </tr>
                        <?php endif; ?> 
                    </tbody>
                  </table>
                </div>
              </div>
            </div>
          </div>
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

 <table>
    <tbody class="data-clone-row" style="display: none;">
        <tr class="row-clone">
            <td class="no-urut"></td>
            <td> 
                 <?php echo form_hidden('id_detail[]', NULL) ?>
                 <?php echo form_hidden('urutan[]', NULL,'class="no-urut"') ?>
                 <?php echo form_hidden('nilai[]', NULL,'class="attribute-combobox-value"') ?>
                 <?php echo form_input('label[]', NULL, 'class="form-control input-sm"') ?>
            </td>
            <td>
               <?php echo form_dropdown('atribut[]',array('text' => 'Textfield', 'combobox' => 'Combobox'),NULL,'class="form-control input-sm type"') ?>
            </td>
            <td>
                <div class="div-textfield">
                    <div class="col-md-10">
                        <?php //echo form_input('nilai[]',NULL,'class="form-control input-sm"') ?>
                    </div>
                </div>
                <div class="row div-combobox">
                    <div class="col-md-10">
                        <?php echo form_dropdown('name',array(),NULL,'class="form-control input-sm attribute-combobox"') ?>
                    </div>
                    <button type="button" class="btn btn-info btn-sm btn-show-list"><i class="fa fa-edit"></i></button> 
                </div>
            </td>
            <td><a class="action-del" onclick="my_table_awesome.del('table-ahay', this.id)"><i class="fa fa-remove"></i></a></td>
        </tr>
    </tbody>
</table>

<table>
    <tbody data-table="#table-combobox" style="display: none;">
        <tr class="row-clone">
            <td class="no-urut"></td>
            <td> 
                <span id="td-list"></span>
                <input type="text" class="form-control input-sm input-list-edit" style="display:none">
            </td>
            <td>
                <button type="button" class="btn btn-xs btn-info btn-edit" onclick="my_table_list.doedit(this.id)"><i class="fa fa-pencil"></i></button>
                <button type="button" class="btn btn-xs btn-danger btn-del" onclick="my_table_list.remove(this.id)"><i class="fa fa-remove"></i></button>

                <button type="button" class="btn btn-xs btn-success btn-save" onclick="my_table_list.save(this.id)"><i class="fa fa-save"></i></button>
                <button type="button" class="btn btn-xs btn-success btn-cancel" onclick="my_table_list.cancel(this.id)"><i class="fa fa-ban"></i></button>
            </td>
        </tr>
    </tbody>
</table>

<div class="modal" id="modalCombobox" data-backdrop="static">
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">
            <i class="fa fa-times"></i>
        </button>
        <h4 class="modal-title">Tambahkan List</h4>
    </div>
    <div class="modal-body">
        <form class="form" id="fcombobox">
            <div class="form-group">
                <div class="col-md-11">
                <?php echo form_input('combobox',NULL, 'class="form-control input-sm" id="input-combobox"') ?>
                </div>
                <button class="btn btn-sm btn-primary"><i class="fa fa-plus"></i></button>
            </div>
        </form>
        <table class="table table-consended" id="table-combobox">
            <thead>
                <tr>
                    <th>List</th>
                    <th></th>
                </tr>
            </thead>
            <tbody class="data-row">
                
            </tbody>
        </table>
    </div>
    <div class="modal-footer">
        <?php
        echo anchor(NULL, '<i class="glyphicon glyphicon-chevron-left"></i> Back', array(
            'class' => 'btn btn-labeled btn-default margin-right-2',
            'data-dismiss' => 'modal'
        ));
        echo anchor(NULL, '<i class="glyphicon glyphicon-floppy-disk"></i> Save', array(
            'class' => 'btn btn-success',
            'id' => 'my_button_submit_combobox',
            'data-dismiss' => 'modal'
        ));
        ?>
    </div>
</div>

<script type="text/javascript">

    pageSetUp();
    var myform = $('form#finput').myForm();

    var __afterSubmit = function(refresh) {
        $('.modal').modal('hide');
        mydatatable.reload(refresh);
    };

    $("#finput").validate({
        errorElement : 'span',
        errorClass : 'help-block',

        invalidHandler: function (event, validator) { 
            command: toastr["error"]('Terjadi kesalahan ! <br>Periksa kembali data input');
        },

        highlight : function(element) {
            $(element).closest('.form-group').removeClass('has-success').addClass('has-error');
        },

        unhighlight : function(element) {
            $(element).closest('.form-group').removeClass('has-error').addClass('has-success');
        },
        
        errorPlacement : function(error, element) {
            
            if (element.parent('.input-group').length) {
                error.insertAfter(element.parent());
            } else {
                error.insertAfter(element);
            }
        },
        submitHandler: function (form) {
           myform.submit();
        }
    });    

    var my_table_awesome = {
        append: function (id_table) {
            var $init      = $('#' + id_table);
            var $row_count = $('.data-row', $init).children('tr.row-clone').length;
            var $clone     = $('.data-clone-row').children('.row-clone').clone();
            if ($row_count < 12) {
                $('.data-row',$init).append($clone);
            }
            my_table_awesome.render_row_id(id_table);
            my_table_awesome.render_remove(id_table);
        },
        render_remove:function(id_table) {
            var $init = $('#' + id_table);
            var $row_count = $('.data-row', $init).children('tr.row-clone').length;
            if($row_count == 1) {
                $('.action-del',$init).hide();
            } else {
                $('.action-del',$init).show();
            }
        },

        render_row_id: function (id_table) {
            var $init = $('#' + id_table);
            var no = 0;
            $.each($('.data-row', $init).children('tr.row-clone'), function () {
                no++;
                $('.no-urut', this).html(no).val(no);
                $('.action-del', this).attr('data-row', no);
                $('.action-del', this).attr('id', 'act-del-' + id_table + '-' + no);

                $('.attribute-combobox',this).attr('id','attribute-combobox-'+no);
                $('.attribute-combobox-value',this).attr('id','attribute-combobox-'+no);
                $('.btn-show-list', this).attr('data-select', '#attribute-combobox-' + no);
            });
        },
        del: function (id_table, act_id) {
            var $init = $('#' + id_table);
            var id    = $('#' + act_id, $init).closest('.row-clone').data('id');
            
            $('#' + act_id, $init).closest('.row-clone').remove();
            
            if(id)
                $('#finput').append('<input type="hidden" name="remove_detail[]" value="'+id+'"/> ');

            my_table_awesome.render_row_id(id_table);
            my_table_awesome.render_remove(id_table);
        }
    };

    var my_table_list = {
        append : function() {
            var $init = '#table-combobox';
            var $clone = $('[data-table="'+$init+'"]').children('.row-clone').clone();
            $('.data-row',$init).append($clone);
            my_table_list.render();
        },
        render : function () {
            var $init = '#table-combobox';
            var no = 0;
            $.each($('.data-row',$($init)).children('.row-clone'), function() {
                no++;
                $('.btn-del',this).attr('id','del-combo-'+ no).show();
                $('.btn-edit',this).attr('id','edit-combo-'+ no).show();
                $('.btn-save',this).attr('id','save-combo-'+no).hide();
                $('.btn-cancel',this).attr('id','cancel-combo-'+no).hide();

                $('#td-list',this).show();
                $('.input-list-edit',this).hide();
            });
        },
        doedit : function (index) {
            var $init = '#table-combobox';
            $index = $('#' + index, $($init)).closest('.row-clone');
            $index.find('#td-list').hide();
            $index.find('.btn-edit').hide();
            $index.find('.btn-del').hide();
            $index.find('.btn-save').show();
            $index.find('.btn-cancel').show();
            $index.find('.input-list-edit').show().val($index.find('#td-list').text());
        },

        remove : function(index) {
            var $init = '#table-combobox';
            $('#' + index, $($init)).closest('.row-clone').remove();
            my_table_list.render();
        },

        save : function(index) {
            var $init = '#table-combobox';
            $index = $('#' + index, $($init)).closest('.row-clone');
            var value = $index.find('.input-list-edit').val();
            $index.find('#td-list').text(value);

            my_table_list.render();
        },

        cancel : function(index) {
            my_table_list.render();
        }
    };

    

    function render_type() {
        $.each($('.type'), function() {
            if(this.value == 'combobox') {
                $(this).parents('tr').find('.div-combobox').show();
                $(this).parents('tr').find('.div-textfield').hide();
            } else {
                $(this).parents('tr').find('.div-combobox').hide();
                $(this).parents('tr').find('.div-textfield').show();
            }
        });
    };

    $('.type').livequery('change',function(){
        render_type();
    });

    $('.btn-show-list').livequery('click',function(){
        var id   = $(this).data('select');
        var list = $(this).parents('tr').find('.attribute-combobox-value').val();
        $('.data-row',$('#table-combobox')).empty();
//        if(list) { //original
//        if(list && list != '[') { //1st change
        if(list && isJson(list)) { //2nd change
            var data = $.parseJSON(list);
            $.each(data, function(index, value) {
                $('#td-list').text(value);
                my_table_list.append();
                
            });
        } 

        $('#modalCombobox').data('select',id).modal('show');
    });

    $('#fcombobox').livequery('submit',function(e){
        e.preventDefault();
        var value = $('#input-combobox').val();
        if(value) {
            $('#td-list').text(value);
            my_table_list.append();
            $(this)[0].reset();
            $('#input-combobox').parents('.form-group').removeClass('has-error');
        } else {
            $('#input-combobox').parents('.form-group').addClass('has-error');
        }
    });

    $('#my_button_submit_combobox').click(function(event) {
        var list = [];
        var select = $('#modalCombobox').data('select');
        $('.attribute-combobox'+ select).empty();
        $.each($('.data-row',$('#table-combobox')).children('.row-clone'), function() {
             value = $(this).find('#td-list').text();
             list.push(value);

             $('.attribute-combobox'+ select).append($("<option></option>").attr("value",value).text(value));
        });
       $('.attribute-combobox-value'+ select).val(JSON.stringify(list));
    });

    $('td, th', '#table-ahay').each(function () {
        var cell = $(this);
        cell.width(cell.width());
    });

    $('#table-ahay tbody').sortable({
        axis: 'y',
        stop: function (event, ui) {
            var data = $(this).sortable('serialize');
             my_table_awesome.render_row_id('table-ahay');
        }
    });

    $('#table-combobox tbody').sortable({
        axis: 'y',
        stop: function (event, ui) {
            var data = $(this).sortable('serialize');
            my_table_list.render();
        },

        helper : function(event, ui) {
            ui.children().each(function() {
                $(this).width($(this).width());
            });
        }
    });

    my_table_awesome.render_row_id('table-ahay');
    render_type();
    
    //isJson?
    function isJson(str) {
        try {
            JSON.parse(str);
        } catch (e) {
            return false;
        }
        return true;
    }
</script>

    
