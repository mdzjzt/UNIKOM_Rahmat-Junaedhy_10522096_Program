
<?php if($data->num_rows()): ?>
<p align="center">Detail Journal Voucher</p>
<table  class="table table-bordered" id="spesifikasi" width="80%">
  <thead>
    <tr>
      <th>ACCOUNT NO</th>
      <th>ACCOUNT NAME</th>
      <th>DEBIT</th>
      <th>CREDIT</th>
      <th>MEMO</th>
    </tr>
  </thead>
  <tbody>
  <?php
      $no = 1;
      foreach ($data->result() as $dt):
  ?>    
    <tr>
      <td><?php echo $dt->no_account_coa ?></td>
        <td><?php echo $dt->account_nama ?></td>
      <td><?php echo number_format($dt->debit_gl) ?></td>
      <td><?php echo number_format($dt->kredit_gl) ?></td>
      <td><?php echo $dt->memo_gl ?></td>
    </tr>
  <?php  endforeach; ?>

  </tbody>
</table>
<?php else: ?>
<p class="text-center"> PCO MASIH KOSONG / BELUM DI BUAT

<?php endif; ?>


<script type="text/javascript">


  var tbl_info = $('#tbl_info').DataTable({ 
 
        "ordering": false,
        "info":     false,
        "processing": true, //Feature control the processing indicator.
        "serverSide": true, //Feature control DataTables' server-side processing mode.
        "order": [], //Initial no order.
 
        // Load data for the table's content from an Ajax source
        "ajax": {
            "url": "order/order/detail_info/"+1,
            "type": "POST"
        },
 
        //Set column definition initialisation properties.
        "columnDefs": [
        { 
            "targets": [ -1 ], //last column
            "orderable": false, //set not orderable
        },
        ],
 
    });
  

function detail_info(id){

    $('#modalinfo').modal('show');
     tbl_info.ajax.url("order/pco/detail_info/"+id).load();

  }

  function close_modal_info(){
     $('#modalinfo').modal('hide');
    tbl_info.ajax.url("order/pco/detail_info/0").load();
    
  }

   function send_email(id_po,id_pco){
       swal({
        title: "Kirim Email ?",
        text: "Anda yakin akan mengirim email PCO ke Vendor ini.",
        type: "warning",
        showCancelButton: true,
        confirmButtonColor: '#DD6B55',
        confirmButtonText: 'Yes',
        cancelButtonText: "Cancel",
        closeOnConfirm: true,
        closeOnCancel: true
          },
          function(isConfirm) {
              if (isConfirm) {
                 $('.send_email_pco').css('display', 'block');
                     $.ajax({
                        type: "POST",
                        async: 'true',
                        cache: 'false',
                        url: '<?php echo base_url() ?>order/pco/send_pco/'+id_po+'/'+id_pco,
                        dataType: "JSON",
                        success: function (data) {
                           swal("Success", "Success Send Email PCO", "success");
                           $('.send_email_pco').css('display', 'none');

                        },
                         error: function (jqXHR, textStatus, errorThrown){

                          swal("Gagal", "Gagal Mengirim Email ! Periksa Koneksi Internet", "error");
                          $('.send_email_pco').css('display', 'none');

                        }

                      });

              }
          });

    }

      var tbl_info_list_approve = $('#tbl_info_list_approve').DataTable({ 
 
        "ordering": false,
        "info":     false,
        "processing": true, //Feature control the processing indicator.
        "serverSide": true, //Feature control DataTables' server-side processing mode.
        "order": [], //Initial no order.
 
        // Load data for the table's content from an Ajax source
        "ajax": {
            "url": "home/detail_info_list_approved/"+1+"/0/6",
            "type": "POST"
        },
 
        //Set column definition initialisation properties.
        "columnDefs": [
        { 
            "targets": [ -1 ], //last column
            "orderable": false, //set not orderable
        },
        ],
 
    });

       function list_approved(id_project,id_pco){

      $('#modallistapproved').modal('show');
      tbl_info_list_approve.ajax.url("home/detail_info_list_approved/"+id_project+"/"+id_pco+"/"+6).load();
    }

    function close_modal_info_list(){
     $('#modallistapproved').modal('hide');
    tbl_info_list_approve.ajax.url("home/detail_info_list_approved/0/0/6").load();
    
  }
</script>
