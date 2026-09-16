<div class="row">
  <div class="portlet light bordered">
     <div class="portlet-title">
        <div class="caption font-dark">
            <span class="caption-subject bold uppercase"><?php echo $page_title; ?></span>
            <span class="caption-helper"></span>
        </div>
     </div>
     <div class="portlet-body">
         <div id="nestable-menu">
            <?php
            if ($this->laccess->otoritas('add')) {
                echo anchor($_modul . '/add', '<i class="glyphicon glyphicon-plus"></i> Add ' . $_title, array(
                    'id' => 'mybutton-add',
                    'class' => 'btn btn-labeled btn-primary',
                    'data-toggle' => "modal",
                    'data-target' => "#remoteModal",
                    'data-keyboard' => "false",
                    'data-backdrop' => "static"
                ));
            }
            ?>

            <div class="pull-right">
                <button type="button" class="btn btn-default" data-action="expand-all">Expand All</button>
                <button type="button" class="btn btn-default" data-action="collapse-all">Collapse All</button>
            </div>
            <!-- Dynamic Modal -->  
            <div class="modal" id="remoteModal" tabindex="-1" role="dialog" aria-labelledby="remoteModalLabel" aria-hidden="true">  
            </div>  
            <!-- /.modal -->
            <hr class="clearfix" style="margin-bottom:10px">
        </div>
        <div class="row">
            <div class="col-sm-12 ">
                <h6>Drag node to sort menu order.</h6>
                <div id="dload"></div>
            </div>
        </div>
     </div>
  </div>
</div>

<script type="text/javascript">
    pageSetUp();

    var pagefunction = function () {
        $('#dload').load('<?php echo base_url() . $_modul . '/load'; ?>');
    };

    loadScript("<?php echo hconfig::base_assets(); ?>/plugin/nestable/jquery.nestable.min.js", pagefunction);
</script>