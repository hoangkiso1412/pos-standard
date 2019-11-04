<!doctype html>
<html>
  <head>
      <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
      <title>Print Invoice #<?php echo $invoice['tid'] ?></title>
      <style>
          body {
              color: #2B2000;
              font-family: 'Helvetica';
          }

          .invoice-box {
              width: 210mm;
              height: 297mm;
              margin: auto;
              padding: 4mm;
              border: 0;
              font-size: 12pt;
              line-height: 14pt;
              color: #000;
          }

          table {
              width: 100%;
              line-height: 16pt;
              text-align: left;
              border-collapse: collapse;
          }

          .plist tr td {
              line-height: 12pt;
          }

          .subtotal {
              page-break-inside: avoid;
          }

          .subtotal tr td {
              line-height: 10pt;
              padding: 6pt;
          }

          .subtotal tr td {
              border: 1px solid #ddd;
          }

          .sign {
              text-align: right;
              font-size: 10pt;
              margin-right: 110pt;
          }

          .sign1 {
              text-align: right;
              font-size: 10pt;
              margin-right: 90pt;
          }

          .sign2 {
              text-align: right;
              font-size: 10pt;
              margin-right: 115pt;
          }

          .sign3 {
              text-align: right;
              font-size: 10pt;
              margin-right: 115pt;
          }

          .terms {
              font-size: 9pt;
              line-height: 16pt;
              margin-right: 20pt;
          }

          .invoice-box table td {
              padding: 10pt 4pt 8pt 4pt;
              vertical-align: top;
          }

          .invoice-box table.top_sum td {
              padding: 0;
              font-size: 12pt;
          }

          .party tr td:nth-child(3) {
              text-align: center;
          }

          .invoice-box table tr.top table td {
              padding-bottom: 20pt;
          }

          table tr.top table td.title {
              font-size: 45pt;
              line-height: 45pt;
              color: #555;
          }

          table tr.information table td {
              padding-bottom: 20pt;
          }

          table tr.heading td {
              background: #515151;
              color: #FFF;
              padding: 6pt;
          }

          table tr.details td {
              padding-bottom: 20pt;
          }

          .invoice-box table tr.item td {
              border: 1px solid #ddd;
          }

          table tr.b_class td {
              border-bottom: 1px solid #ddd;
          }

          table tr.b_class.last td {
              border-bottom: none;
          }

          table tr.total td:nth-child(4) {
              border-top: 2px solid #fff;
              font-weight: bold;
          }

          .myco {
              width: 400pt;
          }

          .myco2 {
              width: 200pt;
          }

          .myw {
              width: 300pt;
              font-size: 14pt;
              line-height: 14pt;
          }

          .mfill {
              background-color: #eee;
          }

          .descr {
              font-size: 10pt;
              color: #515151;
          }

          .tax {
              font-size: 10px;
              color: #515151;
          }

          .t_center {
              text-align: right;
          }

          .party {
              border: #ccc 1px solid;

          }

          .top_logo {
              max-height: 180px;
              max-width: 250px;
          <?php if(LTR=='rtl') echo 'margin-left: 200px;' ?>
          }
      </style>
  </head>
  <body dir="<?= LTR ?>">
    <div class="invoice-box">
        <br>
        <table>
          <tbody>
            <tr>
                <td colspan="2">
                  <?php 
                    echo 'ឈ្មោះអ្នកផ្គត់ផ្គង់(Supplier)<strong> ' . $invoice['name'] . '</strong> ';
                    if ($invoice['company']) 
                      echo $invoice['company'] . '<br>';
                      echo "អាស័យដ្ឋាន(Address) ".$invoice['address'] . 
                           'ក្រុងខេត្ត' . $invoice['city'] . ', ' .
                                      $invoice['region'] . ' ' . 
                                      $invoice['country'] . '-' . 
                                      $invoice['postbox'] . 
                            ' លេខទូរស័ព្ធ(Tel)' . $this->lang->line('Phone') . ': ' . $invoice['phone'] .
                            ' អ៊ីមែល(Email): ' . $invoice['email'];
                    if ($invoice['taxid']) 
                        echo '<br>' . $this->lang->line('Tax') . ' ID: ' . $invoice['taxid'];
                    if (is_array($c_custom_fields)) {
                      echo '<br>';
                      foreach ($c_custom_fields as $row) {
                        echo $row['name'] . ': ' . $row['data'] . '<br>';
                      }
                    }
                  ?>
                </td>
            </tr>
              <?php if (@$invoice['name_s']) { ?>
                <tr>
                  <td>
                    <?php echo '<strong>' . $this->lang->line('Shipping Address') . '</strong>:<br>';
                      echo $invoice['name_s'] . '<br>';
                      echo $invoice['address_s'] . '<br>' . 
                            $invoice['city_s'] . ', ' . 
                            $invoice['region_s'] . '<br>' . 
                            $invoice['country_s'] . '-' . 
                            $invoice['postbox_s'] . '<br> ' .
                            $this->lang->line('Phone') . ': ' . $invoice['phone_s'] . '<br> ' . 
                            $this->lang->line('Email') . ': ' . $invoice['email_s'];
                    ?>
                  </td>
                </tr>
            <?php } ?>
          </tbody>
        </table>
        <br>
        <table class="plist" style="font-size:12px" cellpadding="0" cellspacing="0">
            <tr class="heading">
                <td style="text-align:center">
                    ល.រ<br>No
                </td>
                <td style="text-align:center">
                    <?php echo "បានទិញទោចក្រយានយន្ត"//$this->lang->line('Description') ?><br>Bought Motocycle Model
                </td>
                <td style="text-align:center">
                    ចំនួន<br><?php echo "Qty"//$this->lang->line('Qty') ?>
                </td>
                <?php 
                if ($invoice['discount'] > 0) 
                  echo '<td style="text-align:center">ព៍ណ<br>Color</td>';
                if ($invoice['tax'] > 0) 
                  echo '<td style="text-align:center">ឆ្នាំផលិត<br>Year</td>';
                ?>
                <td style="text-align:center">
                    ព័ណ<br><?php echo "Colour"//$this->lang->line('SubTotal') ?>
                </td>
                <td style="text-align:center">
                    ឆ្នាំផលិត<br><?php echo "Pro. Year"//"Unit ".$this->lang->line('Price') ?>
                </td>
                <td style="text-align:center">
                    លេខតួ និង លេខម៉ាស៊ីន<br><?php echo "Engine and Frame No"//"Unit ".$this->lang->line('Price') ?>
                </td>
                <td style="text-align:center">
                    តំលៃ / ឯកតា<br><?php echo "Unit Price" ?>
                </td>
            </tr>
            <?php
              $fill       = true;
              $sub_t      = 0;
              $sub_t_col  = 5;
              $n          = 1;
              $paid_amount= 0;
              foreach ($products as $row) {
                  $cols = 4;
                  if ($fill == true) {
                      $flag = ' mfill';
                  } else {
                      $flag = '';
                  }
                  $paid_amount+=$row['purchase_paid_amount'];
                  $sub_t += $row['price'] * $row['qty'];


                  echo '<tr class="item' . $flag . '">
                          <td>' . $n . '</td>
                          <td>' . $row['product_name'] . '</td>
                          <td style="text-align:center" >' . +$row['qty'] . $row['unit'] . '</td> 
                          <td style="width:12%;">' . $row['color'] . '</td>';
                          echo '<td style="text-align:center">' . $row['year'] . '</td>';
                          echo '<td style="text-align:center">' . $row['body_number'] .'-'. $row['engine_number'] . '</td>';
                          echo '<td class="t_center">' . amountExchange($row['subtotal'], $invoice['multi'], $invoice['loc']) . '</td>
                        </tr>';
                  if ($row['product_des']) {
                      $cc = $cols++;
                    echo '<tr class="item' . $flag . ' descr">  
                            <td></td>
                            <td colspan="' . $cc . '">' . $row['product_des'] . '&nbsp;</td>		
                          </tr>';
                  }
                  if (CUSTOM) {
                      $p_custom_fields        = $this->custom->view_fields_data($row['pid'], 4, 1);
                      if (is_array($p_custom_fields[0])) {
                          $z_custom_fields    = '';
                          foreach ($p_custom_fields as $row) {
                            $z_custom_fields .= $row['name'] . ': ' . $row['data'] . '<br>';
                          }
                        echo '<tr class="item' . $flag . ' descr">  <td> </td>
                              <td colspan="' . $cc . '">' . $z_custom_fields . '&nbsp;</td>
                              </tr>';
                      }
                  }
                  $fill = !$fill;
                  $n++;
              }
              if ($invoice['shipping'] > 0) {
                  $sub_t_col++;
              }
              if ($invoice['tax'] > 0) {
                  $sub_t_col++;
              }
              if ($invoice['discount'] > 0) {
                  $sub_t_col++;
              }
            ?>
        </table>
        <br>
        <table class="subtotal">
            <tr>
                <td class="myco2" rowspan="<?php echo $sub_t_col ?>"><br>
                    <!-- <p>
                      <?php 
                        echo '<strong>' . 'ស្ថានភាព' . ': ' . $this->lang->line(ucwords($invoice['status'])) . '</strong></p>';
                        if (!$general['t_type']) {
                          echo '<br><p>' . 'សរុបរួម' . ': ' . amountExchange($invoice['total'], $invoice['multi'], $invoice['loc']) . '</p><br><p>';
                          if (@$round_off['other']) {
                            $final_amount = round($invoice['total'], $round_off['active'], constant($round_off['other']));
                            echo '<p>' . $this->lang->line('Round Off') . ' ' . 
                                         $this->lang->line('Amount') . ': ' . amountExchange($final_amount, $invoice['multi'], $invoice['loc']) . '</p><br>
                                  <p>';
                          }
                            echo 'ចំនួនដែលបានបង់' . ': ' . amountExchange($paid_amount, $invoice['multi'], $invoice['loc']);
                        }
                        if ($general['t_type']==1) {
                            echo '<hr>' . $this->lang->line('Proposal') . ': </br></br><small>' . $invoice['proposal'] . '</small>';
                        }
                        ?>
                    </p> -->
                </td>
                <td>
                  <strong><?php echo "សង្ខេប"//$this->lang->line('Summary') ?>:</strong></td>
                <td>&nbsp;</td>
            </tr>
            <tr class="f_summary">
                <td><?php echo សរុបបឋម//$this->lang->line('SubTotal') ?>:</td>
                <td><?php echo amountExchange($sub_t, $invoice['multi'], $invoice['loc']); ?></td>
            </tr>
            <?php if ($invoice['tax'] > 0) {
                echo '<tr>
                <td> ' . សរុបពន្ធ .':</td>
                <td>' . amountExchange($invoice['tax'], $invoice['multi'], $invoice['loc']) . '</td>
            </tr>';
            }
            if ($invoice['discount'] > 0) {
                echo '<tr>
                <td>' . សរុបបញ្ចុះតំលៃ . ':</td>
                <td>' . amountExchange($invoice['discount'], $invoice['multi'], $invoice['loc']) . '</td>
            </tr>';
            }
            if ($invoice['shipping'] > 0) {
              echo '<tr>
                  <td>' . $this->lang->line('Shipping') . ':</td>
                  <td>' . amountExchange($invoice['shipping'], $invoice['multi'], $invoice['loc']) . '</td>
              </tr>';
            }
            ?>
            <tr>
                <td><?php echo "តំលៃសរុប Total Price"//$this->lang->line('Balance Due') ?>:</td>
                <td><strong><?php $rming = $invoice['subtotal'];
              if ($rming < 0) {
                  $rming = 0;
              }
              if (@$round_off['other']) {
                  $rming = round($rming, $round_off['active'], constant($round_off['other']));
              }
            echo amountExchange($rming, $invoice['multi'], $invoice['loc']);
            echo '</strong></td>
            </tr>
            <tr>
                <td>' . 'កក់មុន Deposit' . ':</td>
                <td>' . amountExchange($invoice['pamnt'], $invoice['multi'], $invoice['loc']) . '</td>
            </tr>
            <tr>
                <td>' . 'នៅខ្វះ Balance' . ':</td>
                <td>' . amountExchange($invoice['subtotal']-$invoice['pamnt'], $invoice['multi'], $invoice['loc']) . '</td>
            </tr>
        </table>
        <br>
        <table>
            <tr>
                <td style="text-align:center"><div class="sign">' . 'ហត្ថលេខខាអ្នកទិញ<br>Customer signature' . '</div></td>
                <td style="width:40%"></td>
                <td style="text-align:center"><div class="sign">' . 'ហត្ថលេខខា រឺ ត្រាអ្នកលក់<br>Seller signature or Stamp' . '</div></td>
            </tr>
        </table>';
        ?></div>
    </div>
  </body>
</html>