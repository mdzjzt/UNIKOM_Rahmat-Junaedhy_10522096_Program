<style type="text/css">
  p.intro {
    color: #777;
    font-size: 125%;
    margin: 0 0 2em;
    text-align: center;
}
b, strong {
    font-weight: bold;
}
</style>
<div class="row">
  <div class="portlet light bordered">
    <div class="portlet-title">
        <div class="caption font-dark">
          <span class="caption-subject bold uppercase"><?php echo $pageTitle ?></span>
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
        <?php
              $hidden_form = array('id' => !empty($id) ? $id : '');
              echo form_open_multipart($form_action, ['id' => 'finput', 'class' => 'form-horizontal'], $hidden_form);
          ?>
 <div class="portlet-title" style="border-bottom: 1px solid #ccc;margin-bottom: 10px;">
        <div class="caption font-dark">
          <span class="caption-subject bold uppercase">GENERAL SETTINGS</span>
          <span class="caption-helper"></span>
        </div>
      
    </div>
          <div class="form-group form-group-sm">
                <label class="control-label col-md-2">SYSTEM EMAIL</label>
                <div class="col-md-5">
                    <?php echo form_input('email', $data->email, 'class="form-control" placeholder="Pencarian"'); ?>
                </div>
                <div class="clearfix"></div>
               <label class="control-label col-md-6" style="color: #ccc;font-size: 12px;">The email that all system-generated emails are sent from.</label>
            </div>
         
              <div class="form-group form-group-sm">
              <label class="control-label col-md-2">MAIL TYPE</label>
              <div class="col-md-5">
                  <?php $mailtype=array('text' => 'text', 'html' => 'html'); echo form_dropdown('mailtype', $mailtype,$data->mailtype,'class="form-control" '); ?>
              </div>      
            </div>


            <div class="form-group form-group-sm">
              <label class="control-label col-md-2">MAIL SERVER</label>
              <div class="col-md-5">
                  <?php $mailserver=array('mail' => 'mail', 'sendmail' => 'sendmail','smtp' => 'smtp'); echo form_dropdown('protocol', $mailserver,$data->protocol,'class="form-control chose_server" '); ?>
              </div>      
            </div>
           

           
 <div class="portlet-title" style="border-bottom: 1px solid #ccc;margin-bottom: 10px;">
        <div class="caption font-dark">
          <span class="caption-subject bold uppercase">EMAIL SETTINGS</span>
          <span class="caption-helper"></span>
        </div>
      
    </div>

        <div class="col-md-12 uses">
         <p class="intro">
          <b>Mail</b>
          uses the standard PHP mail function, so no settings are necessary.
          </p>
        </div>
             <div class="form-group form-group-sm path">
                <label class="control-label col-md-2">SENDMAIL PATH</label>
                <div class="col-md-5">
                    <?php echo form_input('sendmail_path', '/usr/sbin/sendmail', 'class="form-control password" placeholder="Pencarian"'); ?>
                </div>
            </div>
             <div class="form-group form-group-sm smtp">
                <label class="control-label col-md-2">SMTP USER </label>
                <div class="col-md-5">
                    <?php echo form_input('smtp_user', $data->smtp_user, 'class="form-control" placeholder="Pencarian"'); ?>
                </div>
            </div>


             <div class="form-group form-group-sm smtp">
                <label class="control-label col-md-2">SMTP PASSWORD</label>
                <div class="col-md-5">
                <input type="password" name="smtp_password" class="form-control" value="">
                </div>
            </div>
            
             <div class="form-group form-group-sm smtp">
                <label class="control-label col-md-2">SMTP HOST</label>
                <div class="col-md-5">
                    <?php echo form_input('smtp_host', $data->smtp_host, 'class="form-control"'); ?>
                </div>
            </div>
             <div class="form-group form-group-sm smtp">
                <label class="control-label col-md-2">SMTP PORT </label>
                <div class="col-md-5">
                    <?php echo form_input('smtp_port', $data->smtp_port, 'class="form-control" placeholder="Pencarian"'); ?>
                </div>
            </div>

            <div class="form-group form-group-sm smtp">
              <label class="control-label col-md-2">CHARSET</label>
              <div class="col-md-5">
                  <?php echo form_input('charset', $data->charset, 'class="form-control" placeholder="Description"'); ?>
              </div>      
            </div>

          

        
            <div class="col-md-4">
                    <?php
                      echo form_button([
                                      'class' => 'btn btn-info btn-sm pull-left',
                                      'content' => '<i class="fa fa-flopy-disk"></i> Save Settings',
                                      'type'    => 'submit',
                      ]);
                      
                      ?>
                  </div>
            </div>
        <?php echo form_close() ?>
<div class="portlet-title" style="border-bottom: 1px solid #ccc;margin-bottom: 10px;">
        <div class="caption font-dark">
          <span class="caption-subject bold uppercase">EMAIL TEST</span>
          <span class="caption-helper"></span>
        </div>
      
    </div>
           <div class="form-group form-group-sm " style="margin-bottom: 50px;">
              <form id="form-email"  method="post" >
                <label class="control-label col-md-2">Email test</label>
                 <div class="col-md-5">
                     <input type="text" name="email_test" class="form-control" placeholder="test_email@gmail.com">
                 </div> 
                 <div class="col-md-3">
                     <?php
                      echo form_button([
                                      'class' => 'btn green btn-sm pull-left',
                                      'content' => '<i class="fa fa-send"></i> Send',
                                      'type'    => 'button',
                                      'onclick' => 'send_test()',
                                      'id' => 'btn-email',
                      ]);
                      ?>
                 </div>
              </form>
          </div>
    </div>

   
   

 <!-- Dynamic Modal -->  
<div class="modal" id="modalDetail" data-backdrop="static" tabindex="-1" aria-hidden="true" data-width="1200"></div>  

<script type="text/javascript">
    pageSetUp();
    <?php if ($data->protocol == 'mail') { ?>
        $('.uses').css('display', 'block');
        $('.smtp').css('display', 'none');
        $('.path').css('display', 'none');
    <?php } ?>
     
     <?php if ($data->protocol == 'sendmail') { ?>
        $('.uses').css('display', 'none');
        $('.smtp').css('display', 'none');
        $('.path').css('display', 'block');
    <?php } ?>
     
     <?php if ($data->protocol == 'smtp') { ?>
        $('.uses').css('display', 'none');
        $('.smtp').css('display', 'block');
        $('.path').css('display', 'none');
    <?php } ?>
     
  

     var formBasic = $('form#finput');
      $('form#finput').submit(function(event) {
          event.preventDefault();
          formBasic.myForm().submit();
      });

      var __afterSubmit = function() {
           location.reload();
          };


    $('.chose_server').on('change', function() {
        var id = this.value ;
        if (id == 'mail') {
          $('.uses').css('display', 'block');
          $('.smtp').css('display', 'none');
          $('.path').css('display', 'none');
        }

        if (id == 'sendmail') {
          $('.uses').css('display', 'none');
          $('.smtp').css('display', 'none');
          $('.path').css('display', 'block');
        }
        
         if (id == 'smtp') {
          $('.uses').css('display', 'none');
          $('.smtp').css('display', 'block');
          $('.path').css('display', 'none');
        }



    })

    function send_test(){
       $("#btn-email").html('<img src="http://localhost/cpm/assets/img/Flickr.gif"> loading... ');
       $.ajax({
          
            url: 'email/email/send_email',
            data: $("#form-email").serialize(),
            async: 'true',
            cache: 'false',
            type: 'post',
            success: function (data) {
              if (data.ok == 1) {
              swal('sukses Menigirim Email')
              }
              if (data.ok == 2) {
              swal('Gagal Menigirim Email')
              }
              $("#btn-email").html('<i class="fa fa-send"></i>Send');
             
            },
             error: function (jqXHR, textStatus, errorThrown){
               swal('Gagal Mengirim Email') 
                 $("#btn-email").html('<i class="fa fa-send"></i>Send');
            }
          
          });
    }
</script>







