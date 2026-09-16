<div class="row">
  <div class="portlet light bordered">
    <div class="portlet-title">
        <div class="caption font-dark">
            <span class="caption-subject bold uppercase"><?php echo $page_title; ?></span>
            <span class="caption-helper"></span>
        </div>
      <div class="actions">
          <a class="btn btn-circle btn-icon-only btn-info show-field" href="javascript:;" data-show-target="#div-filter">
                <i class="icon-magnifier"></i>
            </a>
            <a class="btn btn-circle btn-icon-only btn-default fullscreen" href="javascript:;" rel="tooltip" data-placement="top" title="fullscreen"></a>
        </div>
    </div>
    <div class="portlet-title" id="div-filter">
        <form class="form-horizontal" id="filter_table">
            <div class="form-group form-group-sm">
                
                <div class="col-md-12">
                    <div class="col-md-2">
                    <?php echo form_dropdown('column', array(
                                                '' => '-- semua --',
                                                'gl_kode' => 'Kode',
                                                'gl_nama' => 'Golongan',
                                                'gl_rekening' => 'Nama Rekening',
                                ), '','class="form-control"'); ?>
                    </div>
                    <div class="col-md-5">
                        <?php echo form_input('keyword', NULL, 'class="form-control" placeholder="Pencarian"'); ?>
                    </div>
                    <div class="col-md-4">
                        <?php
                          echo anchor(NULL, '<i class="fa fa-search"></i> Search', array(
                              'class' => 'btn btn-default btn-sm pull-left margin-right-2',
                              'onclick' => 'my_data_table.reload(\'#dt_basic\')'
                          ));
                          echo anchor(NULL, '<i class="fa fa-refresh"></i> Reset', array(
                              'class' => 'btn btn-default btn-sm pull-left',
                              'onclick' => 'my_data_table.filter.reset(\'#dt_basic\')'
                          ));
                          ?>
                      </div>
                </div>
            </div>
        </form>
    </div>
    <div class="portlet-title">
        
        <?php if ($this->laccess->otoritas('add')) {
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
    </div>
    <div class="portlet-body">
        <table id="dt_basic" 
               class="table table-striped table-bordered table-hover" 
               width="100%" style="margin-top: 0 !important;"
               data-source="<?php echo base_url() . $_modul . '/load'; ?>"
               data-filter="#filter_table">
            <thead>                         
                <tr>
                    <th class="text-align-center">NO</th>
                    <th class="col-sm-1 text-center">KODE GL KONVEN</th>
                    <th class="col-sm-1 text-center">KODE GL SYARIAH</th>
                    <th class="text-center">KODE GOLONGAN</th>
                    <th class="col-sm-3">NAMA REKENING</th>   
                    <th class="col-sm-3">DESKRIPSI</th>
                    <th class="col-sm-2">KATEGORI</th>
                     
                    
                    <th class="text-align-center">FUNCTION</th>
                </tr>
            </thead>
        </table>
    </div>
  </div>
</div>

 <!-- Dynamic Modal -->  
  <div class="modal" id="remoteModal" data-backdrop="static" tabindex="-1" role="dialog" aria-hidden="true" data-width="700">  
  </div>  
  <!-- /.modal -->

<script type="text/javascript">
    pageSetUp();
    my_data_table.init('#dt_basic');

    $("form#filter_table").bind('submit',function(){
       my_data_table.reload('#dt_basic');
       return false;
    });
</script>




