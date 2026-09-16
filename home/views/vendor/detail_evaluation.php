<div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">
        <i class="fa fa-times"></i>
    </button>
    <h6 class="modal-title" id="myModalLabel">
        <span class="widget-icon"> <i class="fa fa-edit"></i> </span> FORM EVALUATION 
    </h6>
</div>
<div class="modal-body">

    <div class="col-sm-12">
        <ul id="tab-menu" class="nav nav-tabs">
            <li  class="active">
                <a href="#tab2" data-toggle="tab">Evaluation Vendor</a>
            </li>
            <li>
                <a href="#tab1" data-toggle="tab">Profile Vendor</a>
            </li> 

            <li>
                <a href="#tab3" data-toggle="tab">Transaksi Vendor</a>
            </li> 
           
             
        </ul>

        <div class="tab-content">
            <div class="tab-pane " id="tab1">
                <br>
                <!-- Widget ID (each widget will need unique ID)-->
                <div class="jarviswidget jarviswidget-color-greenLight jarviswidget-sortable" id="wid-id-3" data-widget-editbutton="false" role="widget">

                    <!-- widget div-->
                    <div role="content">

                        <!-- widget content -->
                        <div class="widget-body no-padding">

                            <div class="table-responsive">

                                <table class="table table-striped">
                                    <tbody>
                                        <tr>
                                            <td class="col-md-3">Jenis</td>
                                            <td ><?php echo !empty($data_edit->jenis) ? $data_edit->jenis : '' ?></td>
                                        </tr>
                                        <tr>
                                            <td>Nama</td>
                                            <td><?php echo !empty($data_edit->nama_perusahaan) ? $data_edit->nama_perusahaan : '' ?></td>
                                        </tr>
                                        <tr>
                                            <td>Grade</td>
                                            <td><?php echo !empty($data_edit->ranking) ? $data_edit->ranking : '' ?></td>
                                        </tr>
                                        <tr>
                                            <td>Pimpinan</td>
                                            <td><?php echo !empty($data_edit->nama_pimpinan) ? $data_edit->nama_pimpinan : '' ?></td>
                                        </tr>
                                         <tr>
                                            <td>Contact Person</td>
                                            <td><?php echo !empty($data_edit->contact_person) ? $data_edit->contact_person : '' ?></td>
                                        </tr>
                                         <tr>
                                            <td>Telp</td>
                                            <td><?php echo !empty($data_edit->no_telpon) ? $data_edit->no_telpon : '' ?></td>
                                        </tr>
                                        <tr>
                                            <td>HP</td>
                                            <td><?php echo !empty($data_edit->hp) ? $data_edit->hp : '' ?></td>
                                        </tr>
                                        <tr>
                                            <td>Main Email</td>
                                            <td><?php echo !empty($data_edit->email) ? $data_edit->email : '' ?></td>
                                        </tr>
                                          <tr>
                                            <td>Second Email</td>
                                            <td><?php echo !empty($data_edit->second_email) ? $data_edit->second_email : '' ?></td>
                                        </tr>
                                         <tr>
                                            <td>Alamat</td>
                                            <td><?php echo !empty($data_edit->alamat) ? $data_edit->alamat : '' ?></td>
                                        </tr>
                                        <tr>
                                            <td>Provinsi</td>
                                            <td><?php echo !empty($data_edit->provinsi_name) ? $data_edit->provinsi_name : '' ?></td>
                                        </tr>
                                        <tr>
                                            <td>Kab./Kota</td>
                                            <td><?php echo !empty($data_edit->kotamadya_name) ? $data_edit->kotamadya_name : '' ?></td>
                                        </tr>
                                          <tr>
                                            <td>Sub Category</td>
                                            <td><?php echo !empty($data_edit->sub_category) ? $data_edit->sub_category : '' ?></td>
                                        </tr>
                                        <tr>
                                            <td>NPWP</td>
                                            <td><?php echo !empty($data_edit->npwp) ? $data_edit->npwp : '' ?></td>
                                        </tr>
                                        <tr>
                                            <td>No Rek</td>
                                            <td>
                                                   <?php echo !empty($data_edit->norek) ? $data_edit->norek : '' ?>                                         
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>Direksi</td>
                                            <td>
                                                <div class="table-responsive">
                                                    <table class="table table-striped">
                                                        <tbody>
                                                            <tr>
                                                                <td class="col-md-3">Nama</td>
                                                                <td >Jabatan</td>
                                                            </tr>
                                                            <?php
                                                            if (!empty($decode_direksi)) {
                                                                foreach ($decode_direksi as $row_dir) {
                                                                    $nama_direksi = $row_dir->nama_direksi;
                                                                    $jabatan_direksi = $row_dir->jabatan_direksi;
                                                                    ?>                                                    
                                                                    <tr>
                                                                        <td ><?php echo $nama_direksi ?></td>
                                                                        <td ><?php echo $jabatan_direksi ?></td>
                                                                    </tr>
                                                                <?php }
                                                            }
                                                            ?>
                                                        </tbody>
                                                    </table>

                                                </div>                                                
                                                
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>Pemilik saham</td>
                                            <td>
                                                <div class="table-responsive">
                                                    <table class="table table-striped">
                                                        <tbody>
                                                            <tr>
                                                                <td class="col-md-3">Nama</td>
                                                                <td >Saham (%)</td>
                                                            </tr>
                                                            <?php
                                                            if (!empty($decode_saham)) {
                                                                foreach ($decode_saham as $row_saham) {
                                                                    $nama_saham = $row_saham->nama_saham;
                                                                    $persen_saham = $row_saham->persen_saham;
                                                                    ?>                                                            
                                                            <tr>
                                                                <td ><?php echo $nama_saham ?></td>
                                                                <td ><?php echo $persen_saham ?></td>
                                                            </tr>
                                                            <?php } } ?>
                                                        </tbody>
                                                    </table>

                                                </div>                                                
                                            </td>
                                        </tr>

                                         <tr>
                                            <td>Penilaian</td>
                                           
                                            <td>
                                                <div class="table-responsive">
                                                    <table class="table table-striped">
                                                        <tbody>
                                                            <tr>
                                                                <td>Quality</td>
                                                                <td>On time delivery</td>
                                                                <td>Competitive Price</td>
                                                                <td>Term of payment</td>
                                                                <td>Communication</td>
                                                                <td>Documentation</td>
                                                                <td>SMK3L</td>
                                                                <td>Total Value</td>
                                                                <td>Ranking</td>
                                                            </tr>
                                                             <tr>
                                                                <td> <?php echo !empty($data_edit->specification) ? $data_edit->specification : '' ?></td>
                                                                <td><?php echo !empty($data_edit->on_time) ? $data_edit->on_time : '' ?></td>
                                                                <td><?php echo !empty($data_edit->competitive_price) ? $data_edit->competitive_price : '' ?></td>
                                                                <td><?php echo !empty($data_edit->term_pay) ? $data_edit->term_pay : '' ?></td>
                                                                <td><?php echo !empty($data_edit->communication) ? $data_edit->communication : '' ?></td>
                                                                <td><?php echo !empty($data_edit->documentation) ? $data_edit->documentation : '' ?></td>
                                                                <td><?php echo !empty($data_edit->smkl) ? $data_edit->smkl : '' ?></td>
                                                                <td><?php echo !empty($data_edit->hasil) ? $data_edit->hasil : '' ?></td>
                                                                <td><?php echo !empty($data_edit->ranking) ? $data_edit->ranking : '' ?></td>
                                                            </tr>
                                                        </tbody>
                                                    </table>

                                                </div>                                                
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>
                                                Vendor Create By,
                                            </td>
                                            <td><?php echo !empty($data_create->pegawai_nama) ? $data_create->pegawai_nama : '' ?></td>
                                        </tr>
                                        <tr>
                                            <td>
                                                Evaluate By,
                                            </td>
                                            <td><?php echo !empty($data_user->pegawai_nama) ? $data_user->pegawai_nama : '' ?></td>
                                        </tr>
                                    </tbody>
                                </table>

                            </div>
                        </div>
                        <!-- end widget content -->

                    </div>
                    <!-- end widget div -->

                </div>
                <!-- end widget -->
            </div>

            <div class="tab-pane active" id="tab2">
               <div class="step-pane" data-step="3">
                        <legend><b>Penilaian  <?php echo !empty($data_edit->nama_perusahaan) ? $data_edit->nama_perusahaan : '' ?></b></legend>
                        <?php
                                $hidden_form = array('edit_id' => !empty($edit_id) ? $edit_id : '', 'm_m_id_menu' => !empty($m_m_id_menu) ? $m_m_id_menu : '');
                                echo form_open_multipart($form_action, array('id' => 'finput', 'class' => 'form-horizontal'), $hidden_form);
                                ?>
                        <fieldset>
                        
                            <?php echo form_dropdown('no_proyek', $project, '', 'class="form-control select2" id="status"') ?>
                            <br>
                            <br>
                        <table class="table table-bordered table-striped">
                            <tr>
                                <td>
                                    <strong>1. Quality </strong>
                                </td>
                                <td>
                                    <div class="form-group">
                                        <div class="col-md-6">
                                            <?php echo form_input('specification',  NULL, 'class="form-control specification" onkeyup="penilaian()" data-rule-required="true"') ?>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <strong>2. On time delivery </strong>
                                </td>
                                <td>
                                    <div class="form-group">
                                        <div class="col-md-6">
                                            <?php echo form_input('on_time',  NULL, 'class="form-control on_time" onkeyup="penilaian()" data-rule-required="true"') ?>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <strong>3. Competitive Price </strong>
                                </td>
                                <td>
                                    <div class="form-group">
                                        <div class="col-md-6">
                                            <?php echo form_input('competitive_price', NULL, 'class="form-control competitive_price" onkeyup="penilaian()" data-rule-required="true"') ?>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <strong>4. Term of payment </strong>
                                </td>
                                <td>
                                    <div class="form-group">
                                        <div class="col-md-6">
                                            <?php echo form_input('term_pay',  NULL, 'class="form-control term_pay" onkeyup="penilaian()" data-rule-required="true"') ?>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <strong>5. Communication</strong>
                                </td>
                                <td>
                                    <div class="form-group">
                                        <div class="col-md-6">
                                            <?php echo form_input('communication', NULL, 'class="form-control communication" onkeyup="penilaian()" data-rule-required="true"') ?>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <strong>6. Documentation</strong>
                                </td>
                                <td>
                                    <div class="form-group">
                                        <div class="col-md-6">
                                            <?php echo form_input('documentation', NULL, 'class="form-control documentation" onkeyup="penilaian()" data-rule-required="true"') ?>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <strong>7. SMK3L</strong>
                                </td>
                                <td>
                                    <div class="form-group">
                                        <div class="col-md-6">
                                            <?php echo form_input('smkl', NULL, 'class="form-control smkl" onkeyup="penilaian()" data-rule-required="true"') ?>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <strong>Total Value</strong>
                                </td>
                                <td>
                                    <div class="form-group">
                                        <div class="col-md-6">
                                            <?php echo form_input('total', NULL, 'class="form-control total" data-rule-required="true" readonly=""') ?>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <strong>Ranking</strong>
                                </td>
                                <td>
                                    <div class="form-group">
                                        <div class="col-md-6">
                                            <?php echo form_input('ranking',  NULL, 'class="form-control ranking" data-rule-required="true" readonly="" ') ?>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                        </table>
                        <div class="col-md-12">
                            <table class="table table-bordered table-striped">
                                <thead>
                                    <tr><th>Score</th><th>Evaluation Rank</th></tr>
                                </thead>
                                <tbody>
                                     <tr><td>25 - 28</td><td>A =  Excellent ( Main priority for next Project )</td></tr>
                                    <tr><td>18 - 24</td><td>B =  Good ( Priority for next Project )</td></tr>
                                    <tr><td>11 - 17</td><td>C = Fair  (Need re-assessment for next Project )</td></tr>
                                    <tr><td>1 - 10</td><td>D = Poor ( Not recommended for next Project )</td></tr>
                                </tbody>
                            </table>
                        </div>
                        <div class="col-md-4">
                            <div class="col-md-12"><b>Evaluated By,</b></div>
                            <div class="col-md-12">
                               <?php if ($data_user == NULL) {
                                   
                                }else{

                               
                                  } 
                                ?>
                            </div>
                        </div>
                        <div class="col-md-8">
                            <div class="col-md-12"><b>NOTES</b></div>
                            <div class="col-md-12">
                         <!--        <?php echo form_textarea('notes', !empty($data_edit->notes) ? $data_edit->notes : NULL, 'class="form-control" cols="4" rows="4"   ') ?> -->
                            </div>
                        </div>
                       
                                    
                        </fieldset>
                         <?php echo form_close() ?>


                        <table class="">
                            <thead><tr><th>1. </th><th>Quality</th><th></th><th></th><th>5. </th><th>Communication</th><th></th></tr></thead><tbody>
                             <tr><td>&nbsp;</td><td>4: comply with all requirements</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>4: Responded and actioned very fastly</td><td>&nbsp;</td></tr>
                             <tr><td>&nbsp;</td><td>3: quite match with requirements</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>3: Responded and actioned fastly</td><td>&nbsp;</td></tr>
                             <tr><td>&nbsp;</td><td>2: Not comply to several requirements</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>2: Responded and actioned poorly</td><td>&nbsp;</td></tr>
                             <tr><td>&nbsp;</td><td>1: Not comply to all requirements</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>1: No response and action</td><td>&nbsp;</td></tr>
                             <tr><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td></tr>
                             <tr><td><b>2. </b></td><td><b>Delivery Time</b></td><td>&nbsp;</td><td>&nbsp;</td><td><b>6. </b></td><td><b>Documentation</b></td><td>&nbsp;</td></tr>
                             <tr><td>&nbsp;</td><td>4: On time, early on workhours</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>4: Complete and detail</td><td>&nbsp;</td></tr>
                             <tr><td>&nbsp;</td><td>3: On time, in the end of workhours</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>3: Complete but not detail</td><td>&nbsp;</td></tr>
                             <tr><td>&nbsp;</td><td>2: 5-day late</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>2: Not detail</td><td>&nbsp;</td></tr>
                             <tr><td>&nbsp;</td><td>1: Late more than 6 days</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>1: No documentation</td><td>&nbsp;</td></tr>
                             <tr><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td></tr>
                             <tr><td><b>3. </b></td><td><b>Price</b></td><td>&nbsp;</td><td>&nbsp;</td><td><b>7. </b></td><td><b>HSE</b></td><td>&nbsp;</td></tr>
                             <tr><td>&nbsp;</td><td>4: Best price and lower than market price</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>4: Provide OHSAS Certification</td><td>&nbsp;</td></tr>
                             <tr><td>&nbsp;</td><td>3: Equal with market price</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>3: Provide commitment and completed safety document</td><td>&nbsp;</td></tr>
                             <tr><td>&nbsp;</td><td>2: More expensive as maximum 10% higher than market price</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>2: Provide safety document only</td><td>&nbsp;</td></tr>
                             <tr><td>&nbsp;</td><td>1: More than 10% higher than market price</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>1: No HSE document</td><td>&nbsp;</td></tr>
                             <tr><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td></tr>
                             <tr><td><b>4. </b></td><td><b>Terms of payment</b></td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td></tr>
                             <tr><td>&nbsp;</td><td>4: Back to back with client</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td></tr>
                             <tr><td>&nbsp;</td><td>3: Progress payment & 30 days after receive invoice</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td></tr>
                             <tr><td>&nbsp;</td><td>2: With down payment </td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td></tr>
                             <tr><td>&nbsp;</td><td>1: Cash</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td></td></tr>
                            </tbody>
                        </table>       
                </div>
            </div>

            <div class="tab-pane " id="tab3">
                <table  class="table table-striped">
                <tr>
                    <th>No</th>
                    <th>No MR</th>
                    <th>No PO/SO</th>
                    <th>NAMA PO/SO</th>
                    <th>Tgl Transaksi</th> 
                    <th>Total Transaksi</th> 
                    <th>Kode Project</th>
                    <th>Nama Vendor</th>
                </tr>
                    <?php $no=1; foreach ($data_transaski->result() as $key => $value) { ?>
                       <tr>
                            <td><?php echo $no++;?></td>
                            <td><?php echo $value->kode_mr ?></td>
                            <td><?php echo $value->no_order ?></td>
                            <td><?php echo $value->nama_po ?></td>
                            <td><?php echo $value->tgl_purchase ?></td>
                            <td><?php echo ''.$value->currency.' '.number_format($value->total).'' ?></td>
                            <td><?php echo $value->kode_project ?></td>
                            <td><?php echo $value->nama_perusahaan ?></td>
                       </tr>
                   <?php } ?>
                </table>
            </div>

        </div>
    </div>
</div>
<div class="clearfix"></div>

<div class="modal-footer">
    <?php
    echo anchor(NULL, '<span class="btn-label"><i class="glyphicon glyphicon-chevron-left"></i></span> Back', array(
        'id' => 'mybutton-add',
        'class' => 'btn btn-labeled btn-default margin-right-2',
        'data-dismiss' => 'modal'
    ));

    echo anchor(NULL, '<span class="btn-label"><i class="glyphicon glyphicon-floppy-disk"></i></span> Save', array(
                'id' => 'mybutton-add',
                'class' => 'btn btn-labeled btn-success',
                'onclick' => 'my_form.submit(\'#finput\')'
            ));
           
    ?>
</div>
<script type="text/javascript">
	pageSetUp();
    my_data_table.init('#dt_basic');

    my_form.init();

    var load_and_reset_form = function () {
                pagefunction();
                my_form.reset('#finput');
    };

    var __after_process = function(ket) {
          location.reload();
    if(ket == 2)
        
        $('#modalDetail').modal('hide');
       location.reload();
         __reloadTable(refresh);
    };

     var __reloadTable = function(refresh) {
        mydatatable.reload(refresh);
        renderField()
    };

    function penilaian(){
        var specification =  $('.specification').val();
        if (specification == '') {
            specification = 0;
        }

        var on_time =  $('.on_time').val();
        if (on_time == '') {
            on_time = 0;
        }
        var competitive_price =  $('.competitive_price').val();
        if (competitive_price == '') {
            competitive_price = 0;
        }
        var term_pay =  $('.term_pay').val();
        if (term_pay == '') {
            term_pay = 0;
        }
        var communication =  $('.communication').val();
        if (communication == '') {
            communication = 0;
        }
        var documentation =  $('.documentation').val();
        if (documentation == '') {
            documentation = 0;
        }
        var smkl =  $('.smkl').val();
        if (smkl == '') {
            smkl = 0;
        }

        var hasil  =  parseFloat(specification) +  parseFloat(on_time) +  parseFloat(competitive_price) +  parseFloat(term_pay) +  parseFloat(communication) +  parseFloat(documentation) +  parseFloat(smkl) ;

        var hasill = Math.round(hasil * 100) / 100;
        if (hasill <= 10 ) {
            var ranking = 'D';
        }else if(hasill <= 17 ){
            var ranking = 'C';
        }else if(hasill <= 24 ){
            var ranking = 'B';
        }else if(hasill <= 28 ){
            var ranking = 'A';
        }

        $('.total').val(hasill);
        $('.ranking').val(ranking);



    }


    
	
    // pageSetUp();
    // my_form.init();
    // my_data_table.init('#dt_detail');
</script>
