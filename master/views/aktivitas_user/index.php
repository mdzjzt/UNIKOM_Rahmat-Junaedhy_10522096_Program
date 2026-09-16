<div class="row">
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
        <form class="form-horizontal" id="filter_table">
            <div class="form-group form-group-sm">
                <label class="control-label col-md-2">Laporan Tanggal</label>
                <div class="col-md-3">
                    <div class='input-group date' id='event_start1'>
                        <input name="tgl_laporan" id="tgl_laporan" type='text' class="form-control" />
                        <span class="input-group-addon"><span class="fa fa-calendar"></span>
                        </span>
                    </div>
                </div>
            </div>
            <div class="form-group form-group-sm">
                <label class="control-label col-md-2">Sampai Tanggal</label>
                <div class="col-md-3">
                    <div class='input-group date' id='event_start2'>
                        <input name="sampai_tgl_laporan" id="sampai_tgl_laporan" type='text' class="form-control" />
                        <span class="input-group-addon"><span class="fa fa-calendar"></span>
                        </span>
                    </div>
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
        </form>
    </div>
    
    <div class="portlet-body">
        <table id="dt_basic" 
               class="table table-striped table-bordered table-hover" 
               width="100%" style="margin-top: 0 !important;"
               data-source="<?php echo base_url() . 'log/aktivitas_user/load'; ?>"
               data-filter="#filter_table">
            <thead>                         
                <tr>
                    <th data-hide="phone" class="text-align-center">NO</th>
                    <th data-class="expand" class="text-align-center">USER</th>
                    <th data-hide="expand">TANGGAL AKTIVITAS</th>
                    <th data-hide="expand" class="text-align-center">AKTIVITAS</th>
                </tr>
            </thead>
        </table>
    </div>
  </div>
</div>

 <!-- Dynamic Modal -->  
  <div class="modal" id="remoteModal" data-backdrop="static" tabindex="-1" role="dialog" aria-hidden="true">  
  </div>  
  <!-- /.modal -->

<script type="text/javascript">
    pageSetUp();
    my_data_table.init('#dt_basic');

    $(document).ready(function () {
        $('ul').sortable({
            axis: 'y',
            stop: function (event, ui) {
                var data = $(this).sortable('serialize');
                $('span').text(data);
                /*$.ajax({
                        data: oData,
                    type: 'POST',
                    url: '/your/url/here'
                });*/
        }
        });
    });

    $("form#filter_table").bind('submit',function(){
       my_data_table.reload('#dt_basic');
       return false;
    });
    $('#event_start').datetimepicker({pickTime: false, format: 'YYYY-MM-DD'});
    $('#event_start2').datetimepicker({pickTime: false, format: 'YYYY-MM-DD'});
    $('#wait').hide();
    $('#download').hide();
    $('#tgl_laporan').datetimepicker({ 
        minViewMode: 'months',
        viewMode: 'months',
        pickTime: false,
        format: 'YYYY-MM-DD'
    });   
    $('#sampai_tgl_laporan').datetimepicker({ 
        minViewMode: 'months',
        viewMode: 'months',
        pickTime: false,
        format: 'YYYY-MM-DD'
    });   
    $("#toexcel").click(function () {
        $.ajax({
            url: "<?php echo base_url(); ?>report/permintaan/toexcel",
            beforeSend: function () {
                $('#wait').show();
            },
            complete: function () {
                $('#wait').hide();
                $('#download').show();
            }
        });
        return false;
    });
    $("#wait").html("<img src='<?PHP echo base_url() ?>assets/img/loading.gif' />");
</script>


