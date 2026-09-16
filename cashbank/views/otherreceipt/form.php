    <style type="text/css">
    
    

    </style>
    
<div class="container-fluid">
	<div class="portlet light">
    FORM TAMBAH / EDIT CASH BANK OTHER PAYMENT

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
	        <div class="">
	        	
	           	<div class="col-md-6" >
	           		<table width="100%" class="table">
	           			<tr>
	           				<td>Voucher NO</td>
	           				<td>:</td>
	           				<td>  
	           				    <?php echo form_input('no_other', !empty($data->no_other) ? $data->no_other : $no_voucher, 'class="form-control" style="width: 50%" id="no_voucher"'); ?>
                                 <label id="error_no" style="display: none;color:red;"><i>!!! No Voucher Belum di isi</i></label> 
                            </td>
	           			</tr>
                         <tr>
                            <td>MEMO</td>
                            <td>:</td>
                            <td>  
                                <?php echo form_textarea('memo_receipt',!empty($data->memo_receipt) ? $data->memo_receipt : '', 'class="form-control" id="memo_op"  cols="4" rows="4"'); ?>
                                 
                            </td>
                        </tr>
	           		</table>
	           	
	            </div>
                <div class="col-md-6">
                    <table width="100%" class="table">
                         <tr>
                            <td>DEPOSIT TO  </td>
                            <td>:</td>
                            <td>  
                                <?php echo form_dropdown('id_coa_receipt', $coa_account_cash, !empty($data->id_coa_receipt) ? $data->id_coa_receipt : '', 'class="form-control select2" id="coa_account_cash"  '); ?>

                                 <label id="error_coa_account_cash" style="display: none;color:red;"><i>!!! Paid From Voucher Belum di isi</i></label> 
                            </td>
                        </tr>
                        <tr>
                            <td>Date</td>
                            <td>:</td>
                            <td> <div class='input-group date' style="width: 50%">
                                    <?php echo form_input('date_receipt',!empty($data->date_receipt) ? $data->date_receipt : date('Y-m-d'), 'class="form-control " id="date_gl"') ?>
                                    <span class="input-group-addon"><span class="fa fa-calendar"></span></span>                 
                                </div>
                                <label id="errordate_gl" style="display: none;color:red;"><i>!!! Date Voucher Belum di isi</i></label> 
                             </td>
                        </tr>
                       
                          <tr>
                            <td>AMOUNT</td>
                            <td>:</td>
                            <td>  
                                <?php echo form_input('amount_receipt', !empty($data->amount_receipt) ? $data->amount_receipt : NULL, 'class="form-control number"  id="amount_op"'); ?>
                                 <label id="error_amount_op" style="display: none;color:red;"><i>!!! Ammount Belum di isi</i></label> 
                            </td>
                        </tr>

                    </table>
                </div>
              <div class="clearfix"></div>
	            <div class="col-md-12">
	            	  <?php echo anchor(null, '<i class="fa fa-plus"></i> Tambah', array('class' => 'btn blue pull-right', 'onclick' => 'add_equipment_form()')); ?>
	            </div>
                <div class="clearfix"></div>
	             <div class="col-md-12">
	              	<table class="table table-striped table-bordered " style="margin-top: 10px;">
                        <thead>
                            <tr>
                                <th class="span1">Account No</th>
                                <th class="span1">Ammount</th>
                                <th class="span1">Memo</th>
                                 <th class="span1">Action</th>
  							</tr>
                        </thead>
                        <tbody id="lk_temp" style="display: none;">
                             <tr class="lk_tr">
                                <td class="text-center no_lk" style="width: 30%">
                                    <?php echo form_dropdown('', $coa_account, '', 'class="form-control " id="account_type_"  '); ?>
                                </td>
                             
                                <td class="text-center" >
                                    <?php echo form_input('',NULL, 'class="form-control number"   id= "debit_" ') ?>
                                </td>
                              
                                <td class="text-center" >
                                    <?php echo form_textarea('',NULL, 'class="form-control"   id= "memo_" " ') ?>
                                </td>
                                <td>
                                    <?php echo anchor(null, '<i class="fa fa-minus"></i>', array('class' => 'btn red btn_lk')); ?>
                                </td>
                            </tr>
	         			</tbody>
	         			<tbody id="lk_list">
                        <?php if($id){ 
                                $nodt=0;$nodt1=0;$nodt2=0;$nodt3=0;$nodt4=0;$nodt5=0;
                                foreach($dtdetail->result() as $dt){ ?>

                                    <tr id="tr_lk_<?php echo $nodt++ ?>" class="lk_tr">
                                        <td class="text-center " style="width: 30%"> 
                                            <?php echo form_dropdown('coa_account[]', $coa_account, !empty($dt->id_coa_gl) ? $dt->id_coa_gl : '', 'class="form-control select2" id="account_type_'.$nodt++.'"  '); ?>

                                             <?php echo form_hidden('id_detail_jurnal_voucher[]',!empty($dt->id_detail_jurnal_voucher) ? $dt->id_detail_jurnal_voucher : NULL, 'class=""  '); ?>
                                        </td>
                                      
                                        <td class="text-center" >
                                            <?php echo form_input('ammount_detail[]',!empty($dt->kredit_gl) ? $dt->kredit_gl :NULL, 'class="form-control number debit" onkeyup="cekdebit(1)" id= "debit_'.$nodt1++.'" ') ?>
                                        </td>
                                        
                                        <td class="text-center" >
                                            <?php echo form_textarea('memo[]',!empty($dt->memo_gl) ? $dt->memo_gl :NULL, 'class="form-control"   id= "memo_'.$nodt3++.'" " ') ?>
                                        </td>
                                       
                                    </tr>

                                <?php } ?>

                        <?php }else{ ?>

                                <tr id="tr_lk_1" class="lk_tr">
                                <td class="text-center " style="width: 30%"> 
                                    <?php echo form_dropdown('coa_account[]', $coa_account, !empty($data->account_type_id) ? $data->account_type_id : '', 'class="form-control select2" id="account_type_1"  '); ?>
                                </td>
                              
                                <td class="text-center" >
                                    <?php echo form_input('ammount_detail[]',NULL, 'class="form-control number debit" onkeyup="cekdebit(1)" id= "debit_1" ') ?>
                                </td>
                               
                                <td class="text-center" >
                                    <?php echo form_textarea('memo[]',NULL, 'class="form-control"   id= "memo_1" " ') ?>
                                </td>
                               
                            </tr>
                               
                        <?php  } ?>
   							
	         		</table>	
				
	    </div>
        <div class="clearfix"></div>
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

<script type="text/javascript">
    pageSetUp();
  

    var formBasic = $('form#finput');
    $('form#finput').submit(function(event) {

        var no_voucher_gl = $('#no_voucher').val();
       
        if (no_voucher_gl == null || no_voucher_gl == '') {
            $('#no_voucher').css('border','1px solid red' );
            $('#error_no').css('display', 'block');
            return false;
        }else{
            $('#no_voucher').css('border','1px solid #e5e5e5' );
            $('#error_no').css('display', 'none');
        }

         var coa_account_cash = $('#coa_account_cash').val();
       
        if (coa_account_cash == null || coa_account_cash == '') {
            $('#coa_account_cash').css('border','1px solid red' );
            $('#error_coa_account_cash').css('display', 'block');
            return false;
        }else{
            $('#date_gl').css('border','1px solid #e5e5e5' );
            $('#error_coa_account_cash').css('display', 'none');
        }

        var date_gl = $('#date_gl').val();
       
        if (date_gl == null || date_gl == '') {
            $('#date_gl').css('border','1px solid red' );
            $('#errordate_gl').css('display', 'block');
            return false;
        }else{
             $('#date_gl').css('border','1px solid #e5e5e5' );
            $('#errordate_gl').css('display', 'none');
        }

        var amount_op = $('#amount_op').val();
       
        if (amount_op == null || amount_op == '') {
            $('#amount_op').css('border','1px solid red' );
            $('#error_amount_op').css('display', 'block');
            return false;
        }else{
             $('#amount_op').css('border','1px solid #e5e5e5' );
            $('#error_amount_op').css('display', 'none');
        }


        var nooo = 0;
        var kosong = 0;
        $.each($('#lk_list tr.lk_tr'), function () {
            nooo++;

            // alert($("#account_type_"+nooo).val());

            if($("#account_type_"+nooo).val() == '' || $("#account_type_"+nooo).val() == null){

                $('#s2id_account_type_'+nooo).css('border','1px solid red' );
                 kosong = 1;
            }else{
                $('#s2id_account_type_'+nooo).css('border','1px solid #e5e5e5' );
            }
             
            if($("#debit_"+nooo).val() == '' ){

                $('#debit_'+nooo).css('border','1px solid red' );
                // $('#errordebit_'+nooo).css('display', 'block');

              
                 kosong = 1;
            }else if($("#debit_"+nooo).val() !== ''){
                $('#debit_'+nooo).css('border','1px solid #e5e5e5' );
              
                 kosong = 2;
            }
            
            
        });

        // alert(kosong)

        if (kosong == 1) {

            return false;
        }

       

         var totaldebit = null;
        
           $.each($('#lk_list tr.lk_tr'), function () {
                nooo++;
                var debit = $('input.debit',this).val();
                if(debit){
                  totaldebit  += parseFloat(debit);
                }

                
            });

       var amount =  $('#amount_op').val();

        var totaldbit = totaldebit ;

        var totalall = amount - totaldbit  ;

        if(totalall !== 0){
            swal({
                                      icon: "error",
                                      html:true,
                                      title: "!!! Oops...Total Belum Balance",
                                      text: " Nilai Balance : "+parseFloat(totalall)+"  ",

                                    });
            return false;
        }

        event.preventDefault();
        formBasic.myForm().submit();
    });


    var __afterSubmit = function() {
        setTimeout(function(){
          my_form.go_back();
        },200);
      };

    function add_equipment_form() {
        var temp_equipment_form = $('#lk_temp').html();
        $('#lk_list').append(temp_equipment_form );
        render_equipment_form();
    }

    function render_equipment_form() {
        var no = 0;
       
        $.each($('#lk_list tr.lk_tr'), function () {
       
            no++;
          
            $(this).attr('id', 'tr_lk_' + no);
          
              
            $('#account_type_', this).attr('name', 'coa_account[]' );
            $('#account_type_', this).attr('id', 'account_type_' + no);
            
        

            $('#debit_', this).attr('class', 'form-control  debit');
            $('#debit_', this).number(true, 2).val();
            $('#debit_', this).attr('onkeyup', 'cekdebit(' + no + ')' );
            $('#debit_', this).attr('name', 'ammount_detail[]' );
            $('#debit_', this).attr('id', 'debit_' + no);
         
           
          

            $('#memo_', this).attr('name', 'memo[]' );
            $('#memo_', this).attr('id', 'memo_' + no);

            // $('.total_cost', this).attr('name', 'total_cost[]' );
            // $('#total_cost_', this).attr('id', 'total_cost_' + no);
            // $('.total_cost', this).attr('onkeyup', 'hitung_cost('+ no +')');
            // $('.total_cost', this).number(true, 2).val();

            $('.btn_lk', this).attr('onclick', 'remove_equipment_form(' + no + ')');
        });

    }

    function cekdebit(no){
        
      
        $('#debit_'+no).css('border','1px solid #e5e5e5' );
      
    }

     function cekkredit(no){
        
        $('#debit_'+no).val('');
        $('#debit_'+no).css('border','1px solid #e5e5e5' );
       
        
    }

    function remove_equipment_form(id, id_equipment) {



        bootbox.setBtnClasses({
            CANCEL: 'red',
            CONFIRM: 'blue'
        });


        bootbox.confirm("Anda yakin akan menghapus Field ini?", "Tidak", "Ya", function (e) {
            if (e) {

                  
                    $('#tr_lk_' + id).remove();

                  
                    if ($('#lk_list tr.lk_tr').length === 0) {
                        add_equipment_form();
                    }
                  
               
            }
        });
    }

   
    
</script>