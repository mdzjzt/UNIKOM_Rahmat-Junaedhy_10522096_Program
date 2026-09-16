<div class="row">
  <div class="portlet light bordered">
    <div class="portlet-title">
        <form class="form-horizontal" id="filter_table">
           <div class="col-md-2">
                    <?php echo form_dropdown('date_by', [
                                            
                                                '' => ' --Search Date--', 
                                                // '1' => 'Tahun',
                                                '2' => 'Bulan',
                                                '3' => 'Tanggal',
                                            
                                            ], NULL,'class="form-control" id="date-by"') ?>
                </div> 

                <div class="filter-date" id="filter-date">
                    <div class="col-md-2 fdate" style="display:none" id="ftahun">
                        <?php echo form_dropdown('tahun', hgenerator::getListYear(), NULL,'class="form-control"') ?>
                    </div>
                    <div class="col-md-3 fdate" style="display:none" id="fbulan">
                        <div class="col-md-5 ">
                            <?php echo form_dropdown('tahun', hgenerator::getListYear(), NULL,'class="form-control"') ?>
                        </div>
                         <div class="col-md-7 ">
                            <?php echo form_dropdown('bulan', hgenerator::getListMonth(), NULL,'class="form-control"') ?>
                        </div>
                    </div>
                    
                    <div class="col-md-4 fdate" style="display:none" id="ftanggal">
                        
                          <div class="col-md-6">
                             <div class='input-group input-group-sm date'>
                                <?php echo form_input('tanggal_awal', date('d-m-Y'), 'class="form-control date"') ?>
                                <span class="input-group-addon"><span class="fa fa-calendar"></span></span>                    
                            </div>
                          </div>

                          <div class="col-md-6">
                             <div class='input-group input-group-sm date'>
                                <?php echo form_input('tanggal_akhir', date('d-m-Y'), 'class="form-control date"') ?>
                                <span class="input-group-addon"><span class="fa fa-calendar"></span></span>                    
                            </div>
                          </div>
                       
                    </div>

                </div>
             
           <div class="col-md-2">
            <?php echo form_input('no_gl', NULL, 'class="form-control" placeholder="No Voucher"'); ?>
          </div>
          <div class="col-md-3">
            <?php echo form_input('description', NULL, 'class="form-control" placeholder="Description"'); ?>
          </div>             
          <div class="col-md-2">
                    <?php
                      echo form_button([
                                      'class' => 'btn btn-info btn-sm pull-left',
                                      'content' => '<i class="fa fa-search"></i> Search',
                                      'type'    => 'submit',
                      ]);
                      echo anchor(NULL, '<i class="fa fa-refresh"></i> Reset', 
                        [
                          'class' => 'btn btn-default btn-sm pull-left',
                          'onclick' => 'mydatatable.filterReset()'
                        ]);
                      ?>
          </div>
        </form>
    </div> 
    <div class="portlet-title">
        <?php 
            
               echo anchor(NULL, '<i class="glyphicon glyphicon-plus"></i> JOURNAL VOUCHER', array(
                                    'id'              => 'mybutton-add',
                                    'class'           => 'btn btn-labeled btn-primary',
                                    'data-module'     => $_modul,
                                    'data-href'       => $_modul.'/form'
                    ));
           
        ?>
    </div>
    <div class="portlet-body">
        <table id="dt_basic" 
               class="table table-striped table-bordered table-hover" 
               width="100%" style="margin-top: 0 !important;"
               data-table-source="<?php echo base_url() . $_modul . '/load'; ?>"
               data-table-filter="#filter_table">
            <thead>                         
                <tr>
                    <th>NO</th>
                    <th>NO VOUCHER</th>
                    <th>DATE</th>
                    <th>TYPE</th>
                    <th>AMMOUNT</th>
                    <th>DESCRIPTION</th>
                    <th class="text-center">FUNCTION</th>
                </tr>
            </thead>
        </table>
    </div>
</div>


 <!-- Dynamic Modal -->  
<div class="modal" id="modalDetail" data-backdrop="static" tabindex="-1" aria-hidden="true" data-width="1200"></div>  

<script type="text/javascript">
    pageSetUp();
    var mydatatable = $('#dt_basic').myDataTable({
        columns: [
            {orderable: false},
            {orderable : 'no_account_coa'},
            {name : 'account_nama'},
            {name: 'nama_type'},
            {name: 'opening_balance'},
            {orderable: false},
            {orderable: false},
        ],
    });

    $("form#filter_table").bind('submit',function(){
       __reloadTable();
       return false;
    });

    var __reloadTable = function(refresh) {
        mydatatable.reload(refresh);
    };

    function showFieldDate() {
        var by = $('#date-by').val();

        $('#ftahun, #fbulan, #ftanggal').hide();
        $(':input', $('#filter-date')).attr('disabled','disabled');

        if(by) {
            switch(by) {
                case '1':
                    $('#ftahun').show();
                    $(':input', $('#ftahun')).removeAttr('disabled');
                    break;
                case '2':
                    $('#fbulan').show();
                    $(':input', $('#fbulan')).removeAttr('disabled');
                    break;
                case '3':
                    $('#ftanggal').show();
                    $(':input', $('#ftanggal')).removeAttr('disabled');
                    break;

                default:

                    break;
            }
        }
    }
    
    $(':input#date-by').on('change', function() {
          showFieldDate();
    });
</script>







