    <style type="text/css">

/* =========================================
   MODAL ACCOUNT TYPE
   ========================================= */

.account-type-modal {
    display: none;
    position: fixed !important;
    z-index: 99999 !important;
    left: 0 !important;
    top: 0 !important;
    width: 100% !important;
    height: 100% !important;
    background: rgba(0, 0, 0, 0.55) !important;
    overflow-y: auto !important;
}


/* BOX MODAL */

.account-type-modal-content {
    position: relative !important;
    width: 500px !important;
    max-width: 90% !important;
    margin: 80px auto !important;
    background: #ffffff !important;
    border-radius: 5px !important;
    box-shadow: 0 5px 20px rgba(0,0,0,0.3) !important;
}


/* HEADER */

.account-type-modal-header {
    display: flex !important;
    justify-content: space-between !important;
    align-items: center !important;
    padding: 15px 20px !important;
    border-bottom: 1px solid #e5e5e5 !important;
}


.account-type-modal-header h4 {
    margin: 0 !important;
    font-size: 18px !important;
    font-weight: 600 !important;
}


.account-type-close {
    border: none !important;
    background: transparent !important;
    font-size: 28px !important;
    line-height: 1 !important;
    color: #777 !important;
    cursor: pointer !important;
}


/* BODY */

.account-type-modal-body {
    padding: 25px 20px !important;
}


.account-type-modal-body .form-group {
    margin-bottom: 20px !important;
}


.account-type-modal-body label {
    display: block !important;
    margin-bottom: 7px !important;
    font-weight: 600 !important;
}


/* FOOTER */

.account-type-modal-footer {
    padding: 15px 20px !important;
    border-top: 1px solid #e5e5e5 !important;
    text-align: right !important;
}


.account-type-modal-footer .btn {
    margin-left: 5px !important;
}


/* ALERT */

#accountTypeAlert {
    margin-bottom: 20px !important;
}


/* RESPONSIVE */

@media (max-width: 600px) {

    .account-type-modal-content {
        width: 95% !important;
        margin: 30px auto !important;
    }

}

</style>
    
<div class="container-fluid">
	<div class="portlet light">

              <?php
                echo anchor(NULL, '<i class="glyphicon glyphicon-chevron-left"></i> Kembali', 
                [
                    'class'   => 'btn btn-default margin-right-2 pull-right',
                    'onclick' => 'my_form.go_back()'
                ]);
                
               ?>
	     <div class="portlet-body">
	          <?php
	              $hidden_form = array('id' => !empty($id) ? $id : '');
	              echo form_open_multipart($form_action, ['id' => 'finput', 'class' => 'form-horizontal'], $hidden_form);
	          ?>
	          	<div class="col-md-8" align="center"><h4><b>Form Chart Of Account (COA)</b></h4></div>
	        <div class="form-group">
	        
	           	<div class="col-md-8" >
	           		<table width="100%" class="table">
	           			<tr>
    <td>Account Type</td>
    <td>:</td>
    <td>
        <div class="row">
            
            <div class="col-md-9">
                <?php
                    echo form_dropdown(
                        'account_type',
                        $account_type,
                        !empty($data->account_type_id)
                            ? $data->account_type_id
                            : '',
                        'class="form-control select2" 
                         id="provinsi_id" 
                         onchange="ac_onchange(this)" 
                         target-options="kotamadya_id" 
                         data-rule-required="true"'
                    );
                ?>
            </div>

            <div class="col-md-3">
                <button
                    type="button"
                    class="btn btn-primary btn-block"
                    onclick="openAddAccountType()">
                    <i class="fa fa-plus"></i>
                    Tambah
                </button>
            </div>

        </div>
    </td>
</tr>
	           			<tr>
	           				<td>Account No </td>
	           				<td>:</td>
	           				<td> <?php echo form_input('no_account_coa', !empty($data->no_account_coa) ? $data->no_account_coa : '','class="form-control" id="no_account_coa"') ?></td>
	           			</tr>
	           			<tr>
	           				<td>Name </td>
	           				<td>:</td>
	           				<td> <?php echo form_input('account_nama', !empty($data->account_nama) ? $data->account_nama : '','class="form-control" placeholder=""') ?></td>
	           			</tr>
	           			<tr>
	           				<td>Currency </td>	           			
	           				<td>:</td>
	           				<td> <?php echo form_dropdown('currency',$currency, !empty($data->currency_coa) ? $data->currency_coa : '','class="form-control" placeholder=""') ?></td>
	           			</tr>
	           			<tr>
	           				<td><input type="checkbox" class="form-control" id="myCheck" name="check_sub" onclick="checkState()"  value="1"> Sub Account OF </td>
	           				<td></td>
	           				<td> 
	           					<?php echo form_dropdown('sub_account_off', $sub_coa, !empty($data->sub_account_off) ? $data->sub_account_off : '', 'class="form-control select2" style="display:none"  id="kotamadya_id" data-source="' . base_url('coa/coa') . '/load_regency" data-rule-required="true"'); ?>
	           				</td>
	           			</tr>

	           			<tr id="opening_balance">
	           				<td>Opening Balance </td>
	           				<td>:</td>
	           				<td>
	           					<div class="col-md-6"> <?php echo form_input('opening_balance', !empty($data->opening_balance) ? $data->opening_balance : '','class="form-control number"  placeholder=""') ?>
	           					</div>

	           					<div class="col-md-6"> 
	           						<div class="col-md-2" style="padding: 0px;">As Of</div>
	           						<div class="col-md-10">
	           							<div class='input-group date'>
                                    		<?php echo form_input('tgl_opening_balance',!empty($data->tgl_opening_balance) ? $data->tgl_opening_balance : date('d-m-Y'), 'class="form-control " id=""') ?>
                                    		<span class="input-group-addon"><span class="fa fa-calendar"></span></span>                 
                                		</div>
	           						</div> 
	           						
                                </div>
                            </td>
						</tr>
						
	           		</table>
	           	
	            </div>
	         
				
	    </div>
	    <div class="portlet-footer">
	         <div class="modal-footer">
              <?php
                echo anchor(NULL, '<i class="glyphicon glyphicon-chevron-left"></i> Kembali', array(
                    'id' => 'mybutton-add',
                    'class' => 'btn btn-default margin-right-2',
                    'onclick' => 'my_form.go_back()'
                ));
                echo anchor(NULL, '<i class="glyphicon glyphicon-floppy-disk"></i> Simpan', array(
                    'id' => 'mybutton-add',
                    'class' => 'btn btn-success',
                    'onclick' => '$(\'form#finput\').submit()'
                ));
               ?>
          </div>
	    </div>
	      <?php echo form_close() ?>
  	</div>
</div>



<div class="modal container" id="modalPegawai" data-backdrop="static" tabindex="-1"> </div>
<!-- /.modal -->

<!-- MODAL TAMBAH ACCOUNT TYPE -->
<div id="modalAccountType" class="account-type-modal">

    <div class="account-type-modal-content">

        <!-- HEADER -->
        <div class="account-type-modal-header">

            <h4>
                <i class="fa fa-plus"></i>
                Tambah Account Type
            </h4>

            <button
                type="button"
                class="account-type-close"
                onclick="closeAddAccountType();">
                &times;
            </button>

        </div>


        <!-- BODY -->
        <div class="account-type-modal-body">

            <div
                id="accountTypeAlert"
                style="display:none;"
                class="alert">
            </div>


            <!-- NAMA ACCOUNT TYPE -->
            <div class="form-group">

                <label>
                    Nama Account Type
                    <span class="text-danger">*</span>
                </label>

                <input
                    type="text"
                    class="form-control"
                    id="nama_type"
                    name="nama_type"
                    placeholder="Contoh: Current Asset">

            </div>


          <div class="form-group">

    <label>
        Head COA
        <span class="text-danger">*</span>
    </label>

    <?php
        echo form_dropdown(
            'id_head_coa',
            $head_coa,
            '',
            'class="form-control" id="id_head_coa"'
        );
    ?>

</div>


        <!-- FOOTER -->
        <div class="account-type-modal-footer">

            <button
                type="button"
                class="btn btn-default"
                onclick="closeAddAccountType();">

                <i class="fa fa-times"></i>
                Batal

            </button>


            <button
                type="button"
                class="btn btn-success"
                id="btnSaveAccountType"
                onclick="saveAccountType();">

                <i class="fa fa-save"></i>
                Simpan

            </button>

        </div>

    </div>

</div>


            

<script type="text/javascript">
    pageSetUp();
  
    // $('#datetimepicker1').datetimepicker();
    var el = document.getElementById("myInputID");
    $("#myInputID").on("keypress", function (event) {
            console.log("aaya");
            
            if (event.key === "Enter") {
                alert("You pressed the Enter key!!");
                event.preventDefault();
                return false;
            }
    });

    var formBasic = $('form#finput');
    $('form#finput').submit(function(event) {
        event.preventDefault();
        formBasic.myForm().submit();
    });


  	var modalDataUser = $('#modal-data-user');

 	loadScript("<?php echo hconfig::base_assets(); ?>/libs/tinymce/js/tinymce/tinymce.min.js",loadTinymce);
	function loadTinymce() {
	        tinymce.remove();
	        tinymce.init({
	              selector: '.tinymce',
	              height: 300,
	              nonbreaking_force_tab: true,
	              entity_encoding: 'named',         
	              plugins: [
	                'nonbreaking advlist autolink lists link image charmap print preview anchor',
	                'searchreplace visualblocks code fullscreen',
	                'insertdatetime media table contextmenu paste code'
	              ],
	              fontsize_formats: '8pt 10pt 11pt 12pt 14pt 18pt 24pt 36pt',
	              toolbar: 'fontselect | fontsizeselect | insertfile undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image',
	              setup: function (editor) {
	                editor.on('change', function () {
	                    tinymce.triggerSave();
	                });
	              },
	        });
	};


   var __afterSubmit = function() {
        setTimeout(function(){
          my_form.go_back();
        },200);
      };

   
   $(function () {
        my_form.ajax.options("provinsi_id", 'select2');
        my_form.ajax.options("kotamadya_id", 'select2', $('#kotamadya_id').data('selected'));

        $('#provinsi_id').change(function () {
            my_form.ajax.options("provinsi_id", 'select2');
            $.ajax({
                      url : "<?php echo base_url() ?>coa/coa/get_kode_unik/"+this.value,
                            type: "POST",
                            dataType: "JSON",
                            success: function(data)
                            {
                              
                              $('#no_account_coa').val(data.kode_unik);
                              
                            },
                            error: function (jqXHR, textStatus, errorThrown)
                            {
                                // alert('Error refresh lagi form pegawai');
                            }
            });
      
        });
        $('#kotamadya_id').change(function () {
            my_form.ajax.options("kotamadya_id");
        });
     });   

   	function ac_onchange(selectElement){
	   	const selectedValue = selectElement.value;
	   	if (selectedValue == '7' || selectedValue == '2') {
	   		$("#opening_balance").css("display","none");
	   	}else{
	   		$("#opening_balance").css("display","table-row");
	   	}
   	}
    
    function checkState() {

    var checkBox = document.getElementById("myCheck");

    if (checkBox.checked == true) {

        $("#kotamadya_id").css("display", "table-row");

    } else {

        $("#kotamadya_id").css("display", "none");
        $("#kotamadya_id").val("");

    }

}


/*
 * Buka Modal Tambah Account Type
 */
function openAddAccountType()
{
    $('#nama_type').val('');

    $('#id_head_coa').val('');

    $('#accountTypeAlert')
        .hide()
        .removeClass('alert-danger alert-success')
        .html('');

    $('#modalAccountType').css('display', 'block');

    $('#nama_type').focus();
}

function closeAddAccountType()
{
    $('#modalAccountType').css('display', 'none');
}


/*
 * Simpan Account Type
 */
function saveAccountType()
{
    var nama_type = $.trim($('#nama_type').val());
    var id_head_coa = $('#id_head_coa').val();
    
    // Validasi Nama
    if (nama_type == '') {

        showAccountTypeAlert(
            'danger',
            'Nama Account Type wajib diisi.'
        );

        $('#nama_type').focus();

        return false;
    }
    
if (id_head_coa == '') {

        showAccountTypeAlert(
            'danger',
            'Head COA wajib dipilih.'
        );

        $('#id_head_coa').focus();

        return false;
    }

    var button = $('#btnSaveAccountType');

    button.prop('disabled', true);

    button.html(
        '<i class="fa fa-spinner fa-spin"></i> Menyimpan...'
    );


    $.ajax({

        url: "<?php echo base_url() ?>coa/coa/add_account_type",

        type: "POST",

        dataType: "JSON",

        data: {
            nama_type: nama_type,
            id_head_coa: id_head_coa
        },

        success: function(data)
        {

            if (data.success) {

                // Buat option baru
                var newOption = new Option(
                    data.nama_type,
                    data.account_type_id,
                    true,
                    true
                );


                // Masukkan ke dropdown Account Type
                $('#provinsi_id')
                    .append(newOption)
                    .trigger('change');


                // Tutup modal
                closeAddAccountType();


                // Reset button
                button.prop('disabled', false);

                button.html(
                    '<i class="fa fa-save"></i> Simpan'
                );


                // Notifikasi
                if (typeof $.smallBox === 'function') {

                    $.smallBox({
                        title: "Berhasil",
                        content: data.message,
                        color: "#659265",
                        iconSmall: "fa fa-check",
                        timeout: 3000
                    });

                } else {

                    alert(data.message);

                }

            } else {

                showAccountTypeAlert(
                    'danger',
                    data.message
                );

                button.prop('disabled', false);

                button.html(
                    '<i class="fa fa-save"></i> Simpan'
                );

            }

        },

        error: function(
            jqXHR,
            textStatus,
            errorThrown
        ) {

            console.log(jqXHR.responseText);

            showAccountTypeAlert(
                'danger',
                'Terjadi kesalahan saat menyimpan Account Type.'
            );

            button.prop('disabled', false);

            button.html(
                '<i class="fa fa-save"></i> Simpan'
            );

        }

    });

}


/*
 * Alert Modal
 */
function showAccountTypeAlert(type, message)
{
    $('#accountTypeAlert')
        .removeClass('alert-danger alert-success')
        .addClass('alert-' + type)
        .html(message)
        .show();
}
</script>