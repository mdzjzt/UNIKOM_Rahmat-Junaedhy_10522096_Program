<div class="row">
  <div class="portlet light bordered">
    <div class="portlet-title">
        <div class="caption font-dark">
            <span class="caption-subject bold uppercase"><?php echo $pageTitle; ?></span>
            <span class="caption-helper"></span>
        </div>
        <div class="actions">
          <a class="btn btn-circle btn-icon-only btn-default fullscreen" href="#" rel="tooltip" data-placement="top" title="fullscreen"></a>
        </div>
    </div>
    <div class="portlet-title">
        <form class="form-horizontal" id="filter-table">
            <div class="form-group form-group-sm">
                <label class="control-label col-md-1"></label>
                <div class="col-md-5">
                    <?php echo form_input('keyword', NULL, 'class="form-control" placeholder="Pencarian"'); ?>
                </div>
                <div class="col-md-4">
                    <?php
                      echo anchor(NULL, '<i class="fa fa-search"></i> Search', array(
                          'class' => 'btn btn-default btn-sm pull-left margin-right-2',
                          'onclick' => 'my_data_table.reload(\'#dt-basic\')'
                      ));
                      echo anchor(NULL, '<i class="fa fa-refresh"></i> Reset', array(
                          'class' => 'btn btn-default btn-sm pull-left',
                          'onclick' => 'my_data_table.filter.reset(\'#dt-basic\')'
                      ));
                      ?>
                  </div>
            </div>
        </form>
    </div>
    <div class="portlet-title">
        <?php 
            if ($this->laccess->otoritas('add')):
              echo anchor("#", '<i class="fa fa-plus"></i> Add ' . $_title, array(
                  'class' => 'btn btn-sm btn-labeled btn-primary',
                  'data-toggle' => "modal",
                  'data-target' => "#modalAdd",
                  'data-keyboard' => "false",
                  'data-backdrop' => "static"
              ));
            endif;
        ?>
    </div>
    <div class="portlet-body">
        <table id="dt-basic" 
               class="table table-striped table-bordered table-hover" 
               width="100%" style="margin-top: 0 !important;"
               data-source="<?php echo base_url() . $_modul . '/load'; ?>"
               data-filter="#filter-table">
            <thead>                         
                <tr>
                    <th class="text-center">NO</th>
                    <th class="col-md-2">KODE</th>
                    <th class="col-md-4">NAMA</th>
                    <th class="text-align-center">FUNCTION</th>
                </tr>
            </thead>
        </table>
    </div>
  </div>
</div>

<!-- widget grid -->
<section id="widget-grid" class="">

    <!-- row -->
    <div class="row">

        <!-- NEW WIDGET START -->
        <article class="col-xs-11 col-sm-11 col-md-11 col-lg-11">

            <!-- Widget ID (each widget will need unique ID)-->
            <div class="jarviswidget jarviswidget-color-white" id="wid-id-0" 
                 data-widget-editbutton="false" 
                 data-widget-colorbutton="false"
                 data-widget-togglebutton="false"
                 data-widget-deletebutton="false"
                 data-widget-sortable="false">
                <header>
                    <span class="widget-icon"> <i class="fa fa-table"></i> </span>
                    <h2><?php echo $page_title; ?></h2>
                    <div class="widget-toolbar hidden-phone">
                        <div class="smart-form">
                            <label class="toggle">
                                <?php echo form_checkbox('checkbox-toggle', '#box_filter', true, 'id="demo-switch-to-pills" onclick="my_data_table.filter.toggle(this.id)"'); ?>
                                <i data-swchon-text="Show" data-swchoff-text="Hide"></i>Filtering
                            </label>
                        </div>
                    </div>
                </header>

                <!-- widget div-->
                <div>
                    <!-- widget content -->
                    <div class="widget-body no-padding">
                        <div id="box_filter" class="no-padding border-bottom-1">
                            <form id="filter-table" class="smart-form">
                                <fieldset>
                                    <div class="row">
                                        <section class="col col-sm-2">
                                            <label class="label">Kode / Keterangan:</label>
                                        </section>
                                        <section class="col col-5">
                                            <label class="input">
                                                <?php echo form_input('keyword', '', 'class="input-sm" placeholder=""'); ?>
                                            </label>
                                        </section>
                                        <section class="col col-4">
                                            <label class="input">
                                                <?php
                                                echo anchor(NULL, '<i class="fa fa-search"></i> Search', array(
                                                    'class' => 'btn btn-default btn-sm pull-left margin-right-2',
                                                    'onclick' => 'my_data_table.reload(\'#dt-basic\')'
                                                ));
                                                echo anchor(NULL, '<i class="fa fa-refresh"></i> Reset', array(
                                                    'class' => 'btn btn-default btn-sm pull-left',
                                                    'onclick' => 'my_data_table.filter.reset(\'#dt-basic\')'
                                                ));
                                                ?>
                                            </label>
                                        </section>
                                    </div>
                                </fieldset>
                            </form>
                        </div>

                        <?php if ($this->laccess->otoritas('add')) : ?>
                            <div class="padding-5 border-bottom-1">
                                <?php if ($this->laccess->otoritas('add')) {
                                    echo anchor($_modul . '/add', '<span class="btn-label"><i class="glyphicon glyphicon-plus"></i></span> Add ' . $_title, array(
                                        'id' => 'mybutton-add',
                                        'class' => 'btn btn-labeled btn-primary',
                                        'data-toggle' => "modal",
                                        'data-target' => "#remoteModal",
                                        'data-keyboard' => "false",
                                        'data-backdrop' => "static"
                                    ));
                                }
                                ?>
                        
                                <!-- Dynamic Modal -->  
                                <div class="modal" id="remoteModal" tabindex="-1" role="dialog" data-backdrop="static" aria-hidden="true">  
                                </div>  
                                <!-- /.modal -->
                                <div class="clearfix"></div>
                            </div>
                        <?php endif; ?>

                        <div class="overflow-x">
                            <table id="dt-basic" 
                                   class="table table-striped table-bordered table-hover" 
                                   width="100%" style="margin-top: 0 !important;"
                                   data-source="<?php echo base_url() . $_modul . '/load'; ?>"
                                   data-filter="#filter-table">
                                <thead>			                
                                    <tr>
                                        <th data-hide="phone" class="text-align-center">NO</th>
                                        <th data-class="expand" class="col-md-2">KODE</th>
                                        <th data-hide="expand" class="col-md-4">NAMA</th>
                                        <th data-hide="phone" class="text-align-center">FUNCTION</th>
                                    </tr>
                                </thead>
                            </table>
                        </div>
                    </div>
                    <!-- end widget content -->
                </div>
                <!-- end widget div -->
            </div>
            <!-- end widget -->
        </article>
        <!-- WIDGET END -->
    </div>
    <!-- end row -->

</section>
<!-- end widget grid -->


<script type="text/javascript">
    pageSetUp();
    my_data_table.init('#dt-basic');

    $("form#filter-table").bind('submit',function(){
       my_data_table.reload('#dt-basic');
       return false;
    });
</script>