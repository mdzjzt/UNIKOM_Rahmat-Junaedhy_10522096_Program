<?php
echo form_open_multipart($form_action, [
            'id'    => 'finput_ordering', 
            'class' => 'form-horizontal',
            'data-confirm-message' => 'Anda yakin akan menyimpan urutan ini ?'
    ]);
?>

<?php if ($this->laccess->otoritas('edit')) : ?>
    <div id="konfirmasi_ordering" class="alert alert-info alert-block" style="display: none;">
        <h4 class="alert-heading">Info!</h4>
        Menu order has been change, to save please click the following button:<br>
        <?php
        echo anchor(NULL, '<i class="glyphicon glyphicon-floppy-disk"></i> Save New Order', array(
            'class'   => 'btn btn-success',
            'onclick' => '$(\'#finput_ordering\').myForm().submit()'
        ));
        ?>
    </div>
<?php endif; ?>

<div class="row">
    <!-- Penampung Order -->
    <?php
    echo form_hidden('nestable_output', '', 'class="form-control font-md"');
    echo form_hidden('nestable_temp', '', 'class="form-control font-md"');
    ?>
</div>
<?php echo form_close(); ?>

<div class="dd" id="nestable3" style="max-width: none !important;">
    <?php echo $list_flow; ?>
</div>


<script type="text/javascript">

    var konfirmasi_ordering = function (status) {
        var _box = $('#konfirmasi_ordering');
        if (status) {
            _box.show();
        } else {
            _box.hide();
        }

    };

    var updateOutput = function (e) {
        var list = e.length ? e : $(e.target), _output = list.data('output');
        if (window.JSON) {

            var _serialize_order = list.nestable('serialize');
            var _temp = $('[name="nestable_temp"]');

            if (_temp.val() === '') {
                _temp.val(window.JSON.stringify(_serialize_order));
            }

            _output.val(window.JSON.stringify(_serialize_order));

            if (_temp.val() !== _output.val()) {
                konfirmasi_ordering(true);
            } else {
                konfirmasi_ordering(false);
            }
        } else {
            alert('JSON browser support required for this demo.');
        }
    };

    $('#nestable3').nestable().on('change', updateOutput);

    // output initial serialised data
    updateOutput($('#nestable3').data('output', $('[name="nestable_output"]')));

    $('#nestable-menu').on('click', function (e) {
        var target = $(e.target), action = target.data('action');
        if (action === 'expand-all') {
            $('.dd').nestable('expandAll');
        }
        if (action === 'collapse-all') {
            $('.dd').nestable('collapseAll');
        }
    });
</script>