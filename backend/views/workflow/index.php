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
    <div class="portlet-body">
        <table id="dt_basic" 
               class="table table-striped table-bordered table-hover" 
               width="100%" style="margin-top: 0 !important;"
               data-table-source="<?php echo base_url() . $_module . '/load'; ?>"
               data-table-filter="#filter_table">
            <thead>                         
                <tr>
                    <th class="col-md-1" data-sorting="false">NO</th>
                    <th class="col-md-8" data-sorting="false">NAMA</th>
                    <th class="text-align-center" data-sorting="false">FUNCTION</th>
                </tr>
            </thead>
        </table>
    </div>
  </div>
</div>

<script type="text/javascript">
    pageSetUp();
    var mydatatable = $('#dt_basic').myDataTable();
</script>
