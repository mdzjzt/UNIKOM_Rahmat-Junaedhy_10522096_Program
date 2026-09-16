<div class="container-fluid">
  <div class="portlet light bordered">
    <div class="portlet-title">
        <div class="caption font-dark">
            <span class="caption-subject bold uppercase"><?php echo $page_title; ?></span>
            <span class="caption-helper"></span>
        </div>
        <div class="actions">
        <a class="btn btn-circle btn-icon-only btn-default fullscreen" href="#" rel="tooltip" data-placement="top" title="fullscreen"></a>
      </div>
    </div>
    <div class="portlet-title">
    
      <?php echo form_open($_module . '/load_flow/'.$id, 'class="form-horizontal" id="form-filter"') ?>
      <fieldset>
        <div class="form-group">
          <label class="control-label col-md-1">Cabang</label>
          <div class="col-md-4">
            <?php echo form_dropdown('cabang_id', $cabang, $this->session->userdata('cabang_id'), 'class="form-control select2" placeholder="" onchange="__pageFunction()"'); ?>
          </div>
        </div>
      </fieldset>
      <?php echo form_close() ?>

    </div>
    <div class="portlet-title">
      <?php if ($this->laccess->otoritas('edit')) {
          echo anchor($_module . '/add_role/'.$id.'/'.$flag, '<i class="glyphicon glyphicon-plus"></i> Add ' . $_title, [
                'id'            => 'btn-add-role',
                'class'         => 'btn btn-labeled btn-primary',
                'data-toggle'   => "modal",
                'data-target'   => "#remoteModal",
                'data-keyboard' => "false",
                'data-backdrop' => "static"
            ]);
          }
        ?>
    </div>
    <div class="portlet-body">
       <h6>Drag node to sort flow order.</h6>
        <div id="dload"></div>
    </div>
  </div>
</div>

<div class="modal" id="remoteModal" data-backdrop="static"></div>

<script type="text/javascript">
    pageSetUp();
    
    var __pageFunction = function () {
        
        $.post('<?php echo base_url() . $_module. '/load_flow/'.$id.'/'.$flag; ?>',$('#form-filter').serialize(), function(data) {
          $('#dload').html(data);
          $('#remoteModal').modal('hide');
          $('#btn-add-role').attr('href','<?php echo base_url().$_module . '/add_role/'.$id.'/'.$flag ?>?' + $('#form-filter').serialize())
        });
        
    };
    loadScript("<?php echo hconfig::base_assets(); ?>/plugin/nestable/jquery.nestable.min.js", __pageFunction);
</script>
