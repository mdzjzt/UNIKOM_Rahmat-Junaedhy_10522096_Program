<!DOCTYPE html>
<html>
<head>

<style type="text/css">
  
  .content {
/*    margin-left: 1cm;         
    margin-right: 1cm;   */      
  }

  .data {
    margin-left: 1cm;   
  }
  body{
    font-size: 9px;
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
  .col-md-4 {
    width: 33.3333%;
    float: left;
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
    padding: 10px 20px 15px 20px;
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

  /*tr, td {
      border: 1px solid black;
  }*/
  .tg tr td{
      border: 1px solid black;
  }
  </style>
</head>
<body class="body">
   
    <!-- <htmlpageheader name="MyHeader"> -->
      <table width="100%" style="border:hidden;">
        <tr>
          <td width="20%" align="left"><img class="image-header" src="<?php echo base_url() ?>assets/img/theme/logo-kaltim-white.png"></td>
          <td width="60%" align="center">
          <!--   <p><span style="font-size: 10px">RENDER INVOICE IN THE THREE COPIES TO</span></p></br> -->
            <p><span style="font-size: 17px; font-weight: bold;">PT. CITRA PANJI MANUNGGAL</span></p></br>
          <!--  <p><span style="font-size: 10px">Pondok Pinang Center Blok A 08-12</span></p></br> -->
            <p><span style="font-size: 10px">Jl Ciputat Raya No. 16, Kebayoran Lama, Jakarta Selatan 12240, Indonesia</span></p>
             <p><span style="font-size: 10px">Ph. 021-7653723, Fax. 021-7658806, Email : contact@cpmgroup.co.id</span></p>
          </td>

          <td width="20%" align="right"><img src="<?php echo $image[0]->file ?>" alt="..." width="80px;"> </td>
        </tr>
      </table>
    <!-- </htmlpageheader> -->
    <br>
    <br>
  <div class="content">
 <!--  <table  width="100%" class="tg">
    <tr >
      <td class="tg-xldj" colspan="2">1</td>
      <td class="tg-xldj">2</td>
    </tr>
    <tr>
      <td class="tg-0pky" colspan="2" rowspan="3">3</td>
      <td class="tg-0pky">4</td>
    </tr>
    <tr>
      <td class="tg-xldj">5</td>
    </tr>
    <tr>
      <td class="tg-xldj">6</td>
    </tr>
  </table> -->
    <table width="100%">
        <tr>
          <td width="37%">
            <table width="100%">
              <tr>
                <td style="text-align: left;font-size: 10px" colspan="2">VENDOR :</td>
                
              </tr>
              <tr>
                <td  colspan="2">
                  <p><span style="font-size: 10px;font-weight: bold"><?php echo $data->vendor; ?> </span></p></br>
                  <p><span style="font-size: 10px;"><?php echo $data->alamat; ?></span></p></br>
                  <p><span style="font-size: 10px;"></span></p></br>
                  <p><span style="font-size: 10px;"></span></p></br>
                  <p><span style="font-size: 10px;">Ph  : <?php echo $data->ph; ?>  </span></p></br>
                  <p><span style="font-size: 10px;">Fax : <?php echo $data->fax; ?></span></p></br>
                  <p><span style="font-size: 10px;">Attn : <?php echo $data->attn; ?></span></p></br>
                </td>
              </tr>
            </table>
          </td>
          <td width="37%">
            <table width="100%">
              <tr>
                <td style="text-align: left;font-size: 10px; padding-left:10px;" colspan="2">ORDER BY :</td>
                
              </tr>
              <tr>
                <td colspan="2" style="padding-left:10px;">
                  <p><span style="font-size: 10px;font-weight: bold">PT. CITRA PANJI MANUNGGAL</span></p></br>
                  <p><span style="font-size: 10px;">Jl Ciputat Raya No 16 Kebayoran Lama </span></p></br>
                  <p><span style="font-size: 10px;">Jakarta Selatan 12440 Indonesia </span></p></br>
                  <p><span style="font-size: 10px;"></span></p></br>
                  <p><span style="font-size: 10px;"></span></p></br>
                  <p><span style="font-size: 10px;">Ph  : 021-7653-723</span></p></br>
                  <p><span style="font-size: 10px;">Fax : 021-7658-806</span></p></br>
                  <p><span style="font-size: 10px;">Mail: contact@cpmgroup.co.id </span></p></br>
                </td>
                
              </tr>
            </table>
          </td>
          <td width="25%">
            <table width="100%">
              <tr>
                <td style="text-align: center;border: 1px solid;background-color: #9ea2a6;font-size: 12px;">PURCHASE ORDER</td>
              </tr>
              <tr>
                <td style="text-align: center;border: 1px solid;">
                  <p><span style="font-size: 9px">Number</span></p></br>
                  <p><span style="font-size: 10px;font-weight: bold"><?php echo $data->no_po; ?> </span></p></br>
                </td>
                
              </tr>
              <tr>
                <td style="text-align: center;border: 1px solid;">
                  <p><span style="font-size: 9px">Date</span></p></br>
                  <p><span style="font-size: 10px;font-weight: bold"><?php echo date("d-M-Y", strtotime($data->tgl_po)); ?></span></p></br>
                
              </tr>
              <tr>
                <td style="text-align: center;border: 1px solid;"></td>
              </tr>
              <tr>
                <td style="text-align: center;border: 1px solid;">
                  <p><span style="font-size: 9px">Material Requisition</span></p></br>
                  <p><span style="font-size: 10px;font-weight: bold"><?php echo $data->no_mr; ?></span></p></br>
                </td>               
                
              </tr>
            </table>
          </td>
        </tr>
      </table>
      <br>
      <table width="100%" style="border: 1px solid black;font-size: 11px !important" >
        <tr style="border: 1px solid black;background-color: white">
        <th  width="18%" style="border: 1px solid black;background-color: white" rowspan="3">Material Description</th>
        <th  width="57%" style="border: 1px solid black;background-color: white" rowspan="3"><?php echo $data->judul_po; ?></th>
        <th  width="25%"  style="border: 1px solid black;background-color: white;text-align: center" colspan="2"> Cost Account</th>
        </tr>
        <tr style="">
          <td style="border: 1px solid black;background-color: white" class="tg-s268">Area</td>
          <td style="border: 1px solid black;background-color: white" class="tg-s268"><b><?php echo $data->area; ?></b></td>
        </tr>
        <tr style="">
           <td style="border: 1px solid black;background-color: white" class="tg-s268">Currency</td>
          <td style="border: 1px solid black;background-color: white" class="tg-s268"><b><?php echo $data->currency; ?></b></td>

        </tr>
      </table>
     
      <br>
      <table width="100%" style="border: 1px solid black;font-size: 10px !important" >
        <tr>
          <td width="18%" style="border: 1px solid black;">Project Name</td>
          <td width=""><?php echo $data->nama_project; ?></td>
        </tr>
      
      </table>
      <br>

      <table width="100%" style="border: 1px solid black;font-size: 10px !important" >
        <thead style="border: 1px solid black;background-color: #9ea2a6">
          <tr style="border: 1px solid black;background-color: #9ea2a6">
            <td width="5%" style="border: 1px solid black;" align="center">No</td>
            <td width="10%" style="border: 1px solid black;" align="center">Qty</td>
            <td width="15%" align="center" style="border: 1px solid black;">Unit</td>
            <td width="35%" align="center" style="border: 1px solid black;">Description</td>
            <td width="15%" align="center" style="border: 1px solid black;">Account Code</td>
            <td width="15%" align="center" style="border: 1px solid black;">Unit Price</td>
            <td width="15%" align="center" style="border: 1px solid black;">Total</td>
          </tr>
        </thead>
        <tbody>
        <?php 
        $no = 1 ; foreach ($data_item->result() as $value) {?>
          <tr style="border: 1px solid black;">
            <td width="5%" style="border: 1px solid black;" align="center"><?php echo $no++; ?></td>
            <td width="10%" align="center" style="border: 1px solid black;"><?php echo !empty($value->qty)  ? $value->qty: 0; ?></td>
            <td width="15%" align="center" style="border: 1px solid black;"><?php echo $value->unit; ?></td>
            <td width="35%" style="border: 1px solid black;">
              <?php echo $value->description;?>
            </td>
            <td width="15%" align="center" style="border: 1px solid black;"><?php echo $value->account_code; ?></td>
            <td width="15%" align="right" style="border: 1px solid black;"></td>
            <td width="15%" align="right" style="border: 1px solid black;"></td>
          </tr>
        <?php  } ?>
            <tr>
              <td></td>
              <td colspan="6"> 
               <b>Terms And Conditions :</b> <br>
              <?php echo  $data->term_conditions ?>
              </td>
            </tr>
          <?php if (!empty($data->notes)) { ?>
            <tr>
                <td></td>
                <td colspan="6"> 
                <p>Note : </p>
                    <?php echo  $data->notes ?>
                </td>
            </tr>
          <?php } ?>
          <tr style="border: 1px solid black;">
            <td style="border: 1px solid black;font-size: 10px;font-weight: bold;" colspan="6" align="right">Sub Total</td>
            <td width="15%" align="right" style="border: 1px solid black;"></td>
          </tr>   
          <tr style="border: 1px solid black;">
            <td style="border: 1px solid black;font-size: 10px;font-weight: bold;" colspan="6" align="right">
              
              Discount
            </td>
            <td width="15%" align="right" style="border: 1px solid black;">
              <?php
                $discont = $data->diskon;  
               
              ?>
            </td>
          <tr style="border: 1px solid black;">
            <td style="border: 1px solid black;font-size: 10px;font-weight: bold;" colspan="6" align="right">Gross Total</td>
            <td width="15%" align="right" style="border: 1px solid black;">
             
            </td>
          </tr>
          <tr style="border: 1px solid black;">
            <td style="border: 1px solid black;font-size: 10px;font-weight: bold;" colspan="6" align="right">VAT <?php echo $data->vat; ?>%</td>
            <td width="15%" align="right" style="border: 1px solid black;">

            </td>
          </tr>
          <tr style="border: 1px solid black;">
            <td style="border: 1px solid black;font-size: 10px;font-weight: bold;" colspan="5" align="left"></td>
            <td style="border: 1px solid black;font-size: 10px;font-weight: bold;" align="right">Net Total</td>
            <td width="15%" align="right" style="border: 1px solid black;"></td>
          </tr>   
         <!--  <?php if( !empty($total_kualifikasi)){ ?>
                  <tr style="border: 1px solid black;">
                  <td style="border: 1px solid black;font-size: 10px;font-weight: bold;" colspan="5" align="left"></td>
                  <td style="border: 1px solid black;font-size: 10px;font-weight: bold;" align="right">Total Exc/Inc</td>
                  <td width="15%" align="right" style="border: 1px solid black;"><?php echo number_format($total_kualifikasi, 2,',','.'); ?>
                  </td>
                </tr>   
          <?php  } ?> -->
          <tr style="border: 1px solid black;">
            <td style="border: 1px solid black;font-size: 10px" colspan="5" align="left">
          
            Purchase/Service Order must be quoted on all packages, invoices, delivery dockets and correspondence.

            </td>
            <td style="border: 1px solid black;font-size: 10px;font-weight: bold;" align="right">TOTAL</td>
            <td width="15%" align="right" style="border: 1px solid black;font-size: 10px;font-weight: bold;"></td>
          </tr>     
        </tbody>
      </table>
      <br>
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


