<!DOCTYPE html>
<html>
<head>

<style type="text/css">

body{
  font-size: 9px;
}
  
  .content {
/*    margin-left: 1cm;         
    margin-right: 1cm;   */      
  }
   .col-md-4 {
    width: 33.3333%;
    float: left;
    padding: 0px;
}
p{
    font-size: 10px;
}
.tbl_ttd{
    border-spacing: 0px
    padding:0px;
    margin: 0px;
    width: 100%;
    margin: 10px;
    
  }
  .tbl_ttd tr td{
    border: 1px solid #000000;
    font-size: 10px;
  }

  .data {
    margin-left: 1cm;   
  }

  .content p {
    line-height: 6px;
  }

  .pull-right {
    float: right !important;
  }
  .pull-left {
    float: left !important;
  }

  .table {

    font-family: verdana,arial,sans-serif;
    font-size:10px;

    border-collapse: collapse;
      border: 1px solid black;
    
    -moz-border-radius-bottomleft:0px;
    -webkit-border-bottom-left-radius:0px;
    border-bottom-left-radius:0px;
    
    -moz-border-radius-bottomright:0px;
    -webkit-border-bottom-right-radius:0px;
    border-bottom-right-radius:0px;
    
    -moz-border-radius-topright:0px;
    -webkit-border-top-right-radius:0px;
    border-top-right-radius:0px;
    
    -moz-border-radius-topleft:0px;
    -webkit-border-top-left-radius:0px;
    border-top-left-radius:0px;
  }

  .table td, th{
      border: 1px solid black;
      padding: 5px 5px;
  }

  .body {
    padding: 12px 20px 15px 20px;
    background-color: #fff;
  }
  .image-header{
    height: 60px;
  }
  .header{
    padding-left:40px;
  }
  .header-name{
    font-size: 18px !important;
    font-weight: bold;
  }
  p span {
    display: block;
  }
  table {
      border-collapse: collapse;
  }

  </style>
</head>
<body class="body">
   
    <!-- <htmlpageheader name="MyHeader"> -->
      <table width="100%" style="border:hidden;">
        <tr>
          <td width="20%" align="left"><img class="image-header" src="<?php echo base_url() ?>assets/img/theme/logo-kaltim-white.png"></td>
          <td width="60%" align="center">
            <!-- <p><span style="font-size: 10px">RENDER INVOICE IN THE THREE COPIES TO</span></p></br> -->
            <p><span style="font-size: 17px; font-weight: bold;">PT. CITRA PANJI MANUNGGAL</span></p></br>
          <!--  <p><span style="font-size: 10px">Pondok Pinang Center Blok A 08-12</span></p></br> -->
           <p><span style="font-size: 10px">Jl Ciputat Raya No. 16, Kebayoran Lama, Jakarta Selatan 12240, Indonesia</span></p>
             <p><span style="font-size: 10px">Ph. 021-7653723, Fax. 021-7658806, Email : contact@cpmgroup.co.id</span></p>
          </td>

          <td width="20%" align="right"> <img src="<?php echo $image[0]->file ?>" alt="..." width="80px;"> </td>
        </tr>
      </table>
    <!-- </htmlpageheader> -->
    <br>
    <br>
  <div class="content">
    <table width="100%">
        <tr>
          <td width="50%">
            <table width="100%">
              <tr>
                <td style="text-align: center;border: 1px solid;background-color: #9ea2a6">SERVICE ORDER</td>
                <td style="text-align: center;border: 1px solid;background-color: #9ea2a6">SERVICES TYPE</td>
              </tr>
              <tr>
                <td style="text-align: center;border: 1px solid;">
                  <p><span style="font-size: 9px">Number</span></p></br>
                  <p><span style="font-size: 10px;font-weight: bold"><?php echo $data->no_so; ?></span></p></br>
                </td>
                <td style="font-size: 10px;text-align: center;border: 1px solid;"><?php echo $data->service_type?></td>
              </tr>
              <tr>
                <td style="text-align: center;border: 1px solid; border-bottom: hidden"></td>
                <td style="text-align: center;border: 1px solid;background-color: #9ea2a6">LOCATION</td>
              </tr>
              <tr>
                <td style="text-align: center;border: 1px solid;">
                  <p><span style="font-size: 9px">Date</span></p></br>
                  <p><span style="font-size: 10px;font-weight: bold"><?php echo date("d-M-Y", strtotime($data->tgl_so)) ; ?></span></p></br>
                </td>               
                <td style="font-size: 10px;text-align: center;border: 1px solid;"><?php echo $data->location; ?></td>
              </tr>
              <tr>
                <td style="text-align: center;border: 1px solid;"> </td>
                <td style="text-align: center;border: 1px solid;background-color: #9ea2a6">REQUIRMENT NO</td>
              </tr>
              <tr>
                <td style="text-align: center;border: 1px solid;">
                  <p><span style="font-size: 9px">AREA CODE</span></p></br>
                  <p><span style="font-size: 10px;font-weight: bold"><?php echo $data->area; ?></span></p></br>
                </td>               
                <td style="font-size: 10px;font-weight: bold;text-align: center;border: 1px solid;"><?php echo $data->no_mr; ?></td>
              </tr>
            </table>
          </td>
          <td width="50%">
            <table width="100%">
              <tr>
                <td style="text-align: center;font-size: 12px" colspan="2"><b>To Service Provider :</b></td>
                
              </tr>
              <tr>
                <td style="text-align: left;border: 1px solid;padding: 5px;" colspan="2">
                  <p><span style="font-size: 10px;font-weight: bold"><?php echo $data->nama_vendor; ?></span></p></br>
                  <p><span style="font-size: 10px;"><?php echo $data->alamat; ?></span></p></br>
                  <p><span style="font-size: 10px;"></span></p></br>
                  <p><span style="font-size: 10px;"></span></p></br>
                  <p><span style="font-size: 10px;">Ph  : <?php echo $data->ph; ?></span></p></br>
                  <p><span style="font-size: 10px;">Fax : <?php echo $data->fax; ?></span></p></br>
                  <p><span style="font-size: 10px;">Att : <?php echo $data->attn; ?></span></p></br>
                </td>
                
              </tr>
            </table>
          </td>
        </tr>
      </table>
      <br>
      <table width="100%" style="border: 1px solid black;font-size: 10px !important" >
        <tr>
          <td width="15%" style="background-color: #9ea2a6">Project Name</td>
          <td width="3%">:</td>
          <td ><?php echo $data->nama_project; ?></td>
        <!--  <td width="40%" align="right"><?php echo $data->no_so; ?></td> -->
          <!-- <td width="10%" align="center" style="background-color: #9ea2a6">No. Of Page</td> -->
        </tr>
        
      </table>

      <br>
      <table width="100%" style="border: 1px solid black;font-size: 10px !important" >
        <thead style="border: 1px solid black;background-color: #9ea2a6">
          <tr style="border: 1px solid black;background-color: #9ea2a6">
            <td width="5%" style="border: 1px solid black;">No</td>
            <td width="40%" style="border: 1px solid black;">Description</td>
            <td width="10%" align="center" style="border: 1px solid black;">Vol</td>
            <td width="10%" align="center" style="border: 1px solid black;">Unit</td>
            <td width="15%" align="center" style="border: 1px solid black;">Unit Price</td>
            <td width="15%" align="center" style="border: 1px solid black;">Amount</td>
            <td width="15%" align="center" style="border: 1px solid black;">Account Code</td>
          </tr>
        </thead>
        <tbody>
        <?php 
        $no = 1 ; foreach ($data_item->result() as $value) {?>
          <tr style="border: 1px solid black;">
            <td width="5%" style="border: 1px solid black;"><?php echo $no++; ?></td>
            <td width="40%" style="border: 1px solid black;"><?php echo $value->description; ?></td>
            <td width="10%" align="center" style="border: 1px solid black;"><?php echo $value->vol; ?></td>
            <td width="10%" align="center" style="border: 1px solid black;"><?php echo $value->unit; ?></td>
            <td width="15%" align="right" style="border: 1px solid black;"><?php echo number_format($value->unit_price, 2,',','.'); ?></td>
            <td width="15%" align="right" style="border: 1px solid black;"><?php echo number_format($value->total_price, 2,',','.'); ?></td>
            <td width="15%" align="center" style="border: 1px solid black;"><?php echo $value->account_code; ?></td>
          </tr>
        <?php 
        $total += $value->total_price;
        } ?> 

                                <tr>
                                  <td></td>
                                  <td colspan="5"> 
                                      Terms And Conditions : <br>
                                      <?php echo $data->term_conditions; ?>
                                  </td>
                                </tr>
                           

             <?php if (!empty($data->notes)) { ?>
                                <tr>
                                  <td></td>
                                  <td colspan="5"> 
                                      Note : <br>
                                      <?php echo $data->notes ;?>
                                  </td>
                                </tr>
                            <?php } ?>
               
          <tr style="border: 1px solid black;">
            <td style="border: 1px solid black;font-size: 10px;font-weight: bold;" colspan="5" align="right">Sub Total</td>
            <td width="15%" align="right" style="border: 1px solid black;"><b><?php echo number_format($total, 2,',','.'); ?></b></td>
            <td width="15%" align="right" style="border: 1px solid black;"></td>
          </tr>   
          <tr style="border: 1px solid black;">
            <td style="border: 1px solid black;font-size: 10px;font-weight: bold;" colspan="5" align="right"> Discount</td>
            <td width="15%" align="right" style="border: 1px solid black;"><b><?php echo number_format($data->diskon, 2,',','.'); ?></b></td>
            <td width="15%" align="right" style="border: 1px solid black;"></td>
          </tr>
          <tr style="border: 1px solid black;">
            <td style="border: 1px solid black;font-size: 10px;font-weight: bold;" colspan="5" align="right">Gross Total </td>
            <td width="15%" align="right" style="border: 1px solid black;"><b><?php echo number_format($total - $data->diskon , 2,',','.'); ?></b></td>
            <td width="15%" align="right" style="border: 1px solid black;"></td>
          </tr>
               <!--  <tr style="border: 1px solid black;">
                    <td style="border: 1px solid black;font-size: 12px;font-weight: bold;" colspan="4" align="right">PPN (%)</td>
                    <td width="15%" align="right" style="border: 1px solid black;"><?php// echo number_format($data->ppn); ?></td>
                    <td width="15%" align="right" style="border: 1px solid black;"></td>
                </tr> -->
                <tr style="border: 1px solid black;">
                    <td style="border: 1px solid black;font-size: 10px;font-weight: bold;" colspan="5" align="right">VAT <?php echo !empty($data->vat) ? $data->vat.'%' : NULL; ?></td>
                    <td width="15%" align="right" style="border: 1px solid black;"><b><?php $discount_amount = $data->diskon  ;
                              $grandtotal = $total - $discount_amount ;  $vat_nilai = $grandtotal * ($data->vat/100); echo !empty($vat_nilai)? number_format($vat_nilai, 2,',','.'):'0,00'; ?></b></td>
                    <td width="15%" align="right" style="border: 1px solid black;"></td>
                </tr>
                 
                <tr style="border: 1px solid black;">
                    <td style="border: 1px solid black;font-size: 10px;font-weight: bold;" colspan="4" align="left"></td>
                    <td style="border: 1px solid black;font-size: 10px;font-weight: bold;" align="right">Net Total</td>
                    <td width="15%" align="right" style="border: 1px solid black;"><b>
                    <!--   <?php //  $discount_amount = $data->discount + $data->ppn + $data->vat ;
                        //$grandtotal =$total + ($total * ($discount_amount/100)); //echo number_format($grandtotal + $total_kualifikasi, 2,',','.'); ?> -->

                        <?php $discount_amount = $data->diskon  ;
                              $grandtotal = $total - $discount_amount ; 
                              $vat_nilai = $grandtotal * ($data->vat/100);
                              $total_nilai = $grandtotal +  $vat_nilai ;
                              echo number_format($total_nilai , 2,',','.'); ?>
                                
                              </b>
                    </td>
                    <td width="15%" align="right" style="border: 1px solid black;"><?php echo $data->currency ;?></td>
                </tr>       
  

        </tbody>
      </table>
      <br>
      
      <table width="100%" style="border: 1px solid black;font-size: 10px !important">
        <tr>
          <td width="20%" style="border: 1px solid black;font-size: 10px;font-weight: bold;">Time Schedule</td>
          <td><?php echo $data->time_schedule?></td>
        </tr>
        <tr>
          <td style="border: 1px solid black;font-size: 10px;font-weight: bold;">Term of Payment</td>
          <td>  
           <?php echo $data->term_of_payment  ?>
          </td>
        </tr>
        <tr>
          <td style="border: 1px solid black;font-size: 10px;font-weight: bold;">Liquidated Demaged</td>
          <td><?php echo $data->liquidated_damaged?></td>
          
        </tr>
      </table>
        <p>FOR FURTHER INFORMATION CONTACT:</p>

            <?php foreach ($data_approve->result() as $key => $dt) { ?>
             <div class="col-md-4">
                      <table class="tbl_ttd">
                      <tr>
                        <td width="80%"><?php if ($dt->type_approve == 1) {
                            echo "Prepared by,";
                          }else{
                            echo "Approved by,";
                            } ?>
                        
                        </td>
                        <td rowspan='3'><img class="image-check" width="40px" src="<?php echo base_url() ?>assets/img/check-print.png"></td>
                      </tr>
                    
                      <tr>
                        <td width="80%">  <?php echo $dt->pegawai_nama ?><br>
                        <?php echo $dt->nama_role ?></td>
                      </tr>
                      <tr>
                        <td width="80%"><?php echo  date('d-M-Y',strtotime( $dt->date_approve)) ?> <?php echo  $dt->jam?></td>
                      </tr>
                        
                      </table>
                    </div>
        <?php } ?>               
  </div>
    
     
  <htmlpagefooter name="MyFooter">
        <table width="100%" style="vertical-align: bottom; font-family: serif; font-size: 8pt; 
            color: #000000; font-weight: bold; font-style: italic;" border="0"><tr>
             <td width="33%" align="left"><span style="font-weight: bold; font-style: italic;font-size: 9px;"><?php echo 'Page {PAGENO} Of {nbpg}' ?></span></td>
             <td  align="right" style="font-weight: bold; font-style: italic;font-size: 9px"> This Document is Original And Approved By System E-PROC PT. CPM</td>
            </tr></table>
    </htmlpagefooter>

  <sethtmlpagefooter name="MyFooter" value="on"/>
  <setpageheader name="MyHeader" show-this-page="1"/>
  
</body>
</html>


