<!doctype html>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
        <title>Print Invoice #<?php echo $invoice['tid'] ?></title>
        <style>
            body {
                color: #2B2000;
                font-family: 'Khmer OS Content';
                width: 210mm;
                margin:0;
            }
            .kh-bokor{
                font-family:'Khmer OS Bokor';
            }.kh-muol{
                font-family:'Khmer OS Muol';
            }
            .font-bold{
                font-weight: bold;
            }
            .font-9{
                font-size:9.5pt;
            }
            .font-10{
                font-size:10pt;
            }
            .font-11{
                font-size:11pt;
            }
            .font-12{
                font-size:12pt;
            }
            .font-14{
                font-size:14pt;
            }
            .font-16{
                font-size:16pt;
            }
            .font-18{
                font-size:18pt;
            }
            table{
                width:100%;
                padding:10px;
            }
            table td{
                vertical-align: middle;
            }
            .no-padding table{
                padding:0px;
            }
            .red{
                color:#fe2929;
            }
            .blue{
                color:#104691;
            }
            .b-bottom-dot{
                border-bottom:1px dashed #104691 !important;
            }
            .b-bottom-solid{
                border-bottom:1px solid #104691 !important;
            }
            .no-top-border{
                border-top:0px solid white !important;
            }
            .invoice-row td{
                border:1px solid #104691;
                padding: 2px;
            }
            .invoice-row{
                margin:10px;
                padding:0;
                border:1px solid #104691;
                width:771px !important;
            }
            .footer-row{
                margin:0 10px;
                padding:0;
                width:771px !important;
            }
            .footer-row td{
                padding: 2px;
            }
            .text-center{
                text-align:center;
            }
            .text-right{
                text-align: right;
            }
            .no-top-margin{
                margin-top:0px;
            }
            .no-bottom-margin{
                margin-bottom:0px;
            }
            .full-solid-border{
                border:1px solid #104691;
            }
            .b-left-solid{
                border-left:1px solid #104691;
            }
            .b-right-solid{
                border-right:1px solid #104691;
            }
            .b-2bottom-border{
                border-bottom:2px solid #104691;
            }
            .v-align-top{
                vertical-align: top;
            }
        </style>
    </head>
    <body dir="<?= LTR ?>">
        <?php
        $loc = location($invoice['loc']);
        $customer_info = explode('*:*', $invoice['customer_info']);
        $cname =  explode("/",$loc['cname']);
        $address =  explode("/",$loc['address']);
        ?>
        <img width="100%" src="<?php echo base_url("userfiles/company/hih.jpg") ?>">
    <center class='kh-bokor font-16 font-bold blue'>វិក័យប័ត្រ INVOICE</center>
    <center class='kh-muol font-16 font-bold blue'>ហាងលក់ម៉ូតូ ហុងដា <span class='red'><?php echo $cname[0]?></span><br><span class='red'><?php echo $cname[1]?></span> HONDA MOTORCYCLE SHOP</center>
    <table>
        <tr>
            <td class='font-11 font-bold blue v-align-top'>
                   <?php echo $address[0];?><br>
                    <?php echo $address[1]?><br>
                ទូរស័ព្ទ <?php echo $loc['phone'] ?>
            </td>
            <td class='font-10 font-bold blue no-padding'>
                <table cellpadding='0'>
                    <tr>
                        <td width='95px'>
                            វិក័យប័ត្រលេខ:
                        </td>
                        <td class='red b-bottom-dot'>
                                <?php echo $invoice["tid"] ?>
                        </td>
                    </tr>
                </table>
                <table cellpadding='0'>
                    <tr>
                        <td width='30px'>
                            ថ្ងៃទី:
                        </td>
                        <td class='red b-bottom-dot'>
                                <?php echo dateformat($invoice["invoicedate"]) ?>
                        </td>
                    </tr>
                </table>
                <table cellpadding='0'>
                    <tr>
                        <td width='77px'>
                            បង្កាន់ដៃពន្ធ:
                        </td>
                        <td class='red b-bottom-dot'>
                                <?php echo $loc['taxid'] ?>
                        </td>
                    </tr>
                </table>
                <table cellpadding='0'>
                    <tr>
                        <td width='60px'>
                            ផ្លាកលេខ:
                        </td>
                        <td class='red b-bottom-dot'>
                        </td>
                    </tr>
                </table>
                    
            </td>
        </tr>
    </table>
    <table class='font-10'>
        <tr>
            <td class='no-padding'>
                <table>
                    <tr>
                        <td width="210px" class='blue'>ឈ្មោះអតិថិជន(Customer's name)</td>
                        <td width="" class='red b-bottom-dot'><?php echo $customer_info[0] ?></td>
                        <td width="60px" class='blue'>ភេទ(Sex)</td>
                        <td width="" class='red b-bottom-dot'><?php echo $customer_info[1] ?></td>
                        <td width="60px" class='blue'>អាយុ(Old)</td>
                        <td width="" class='red b-bottom-dot'><?php echo $customer_info[2] ?></td>
                        <td width="60px" class='blue'>ឆ្នាំ(Year)</td>
                    </tr>
                </table>
                <table>
                    <tr>
                        <td width="250px" class='blue'>លេខអត្តសញ្ញាណប័ណ្ណ(Identify Card Nº)</td>
                        <td width="" class='red b-bottom-dot'><?php echo $customer_info[3] ?></td>
                        <td width="100px" class='blue'>លេខទូរស័ព្ទ(Tel)</td>
                        <td width="" class='red b-bottom-dot'><?php echo $customer_info[4] ?></td>
                    </tr>
                </table>
                <table>
                    <tr>
                        <td width="185px" class='blue'>អាស័យដ្ឋាន(Address):ផ្ទះលេខ</td>
                        <td width="" class='red b-bottom-dot'><?php echo $customer_info[5] ?></td>
                        <td width="10px" class='blue'>ផ្លូវ</td>
                        <td width="" class='red b-bottom-dot'><?php echo $customer_info[6] ?></td>
                        <td width="10px" class='blue'>ក្រុម</td>
                        <td width="" class='red b-bottom-dot'><?php echo $customer_info[7] ?></td>
                        <td width="10px" class='blue'>ភូមិ</td>
                        <td width="" class='red b-bottom-dot'><?php echo $customer_info[8] ?></td>
                    </tr>
                </table>
                <table class="padding-table">
                    <tr>
                        <td width="63px" class='blue'>សង្កាត់-ឃុំ</td>
                        <td width="" class='red b-bottom-dot'><?php echo $customer_info[9] ?></td>
                        <td width="65px" class='blue'>ស្រុក-ខណ្ឌ</td>
                        <td width="" class='red b-bottom-dot'><?php echo $customer_info[10] ?></td>
                        <td width="75px" class='blue'>រាជធានី-ខេត្ត</td>
                        <td width="" class='red b-bottom-dot'><?php echo $customer_info[11] ?></td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
    <table class="invoice-row no-bottom-margin no-top-margin font-10" cellpadding='0' cellspacing='0'>
        <tr>
            <td width="7%" class="text-center blue">ល.រ<br>Nº</td>
            <td width="25%" class="text-center blue">បានទិញទោចក្រយានយន្ត<br>Bought Motorcycle Model</td>
            <td width="10%" class="text-center blue">ចំនួន<br>Quantity</td>
            <td width="10%" class="text-center blue">ពណ៌<br>Colour</td>
            <td width="10%" class="text-center blue">ឆ្នាំផលិត<br>Pro.Year</td>
            <td width="25%" class="text-center blue">លេខតួ និង លេខម៉ាស៊ីន<br>Engine and Frame Nº</td>
            <td width="13%" class="text-center blue">តំលៃ/ឯកតា<br>Unit Price</td>
        </tr>
        <?php
        $no = 0;
        $discount = 0;
        $subtotal = 0;
        foreach ($products as $row) {
            $no++;
            $discount += $row['totaldiscount'];
            $subtotal += $row['subtotal'];
            $pname = explode(" ស៊េរី",$row["product"]);
            if(!$pname[1]){
                $pname = explode(" Year ",$row["product"]);
            }
            $pro_name = $pname[0];
            $year = "";
            $color = "";
            if($pname[1]){
                $yc = explode(" ពណ៌",$pname[1]);
                if(!$yc[1]){
                    $yc = explode(" Color ",$pname[1]);
                }
                $year = $yc[0];
                $color = $yc[1];
            }
            $bottom_border = " b-bottom-dot ";
            $top_boder = " ";
            if($no==1){
                $bottom_border = " b-bottom-dot ";
                $top_boder = " ";
            }
            elseif($no==8){
                $top_boder = " no-top-border ";
                $bottom_border = " b-bottom-solid ";
            }
            elseif($no>1){
                $top_boder = " no-top-border ";
                $bottom_border = " b-bottom-dot ";
            }
            ?>
        <tr>
            <td width="7%" class="text-center <?php echo $bottom_border.$top_boder ?>"><?php echo $no ?></td>
            <td width="25%" class='<?php echo $bottom_border.$top_boder ?>'><?php echo $pro_name ?></td>
            <td width="10%" class="text-right <?php echo $bottom_border.$top_boder ?>"><?php echo 1 ?></td>
            <td width="10%" class='<?php echo $bottom_border.$top_boder ?>'><?php echo $color ?></td>
            <td width="10%" class='<?php echo $bottom_border.$top_boder ?>'><?php echo $year ?></td>
            <td width="25%" class='<?php echo $bottom_border.$top_boder ?>'><?php echo $row["engine_number"]." | ".$row["body_number"] ?></td>
            <td width="13%" class="text-right <?php echo $bottom_border.$top_boder ?>"><?php echo amountExchange($row['subtotal'], $invoice['multi'], $invoice['loc']) ?></td>
        </tr>
            <?php
            }
            $rm = 8-$no;
            for($i=1;$i<=$rm;$i++){
                $bottom_border = " b-bottom-dot ";
            $top_boder = " ";
            if($i==1){
                $bottom_border = " b-bottom-dot ";
                $top_boder = " no-top-border ";
            }
            elseif($i==$rm){
                $top_boder = " no-top-border ";
                $bottom_border = " b-bottom-solid ";
            }
            elseif($i>1){
                $top_boder = " no-top-border ";
                $bottom_border = " b-bottom-dot ";
            }
            ?>
        <tr>
            <td class="text-center <?php echo $bottom_border.$top_boder ?>" style="color: white">.</td>
            <td class='<?php echo $bottom_border.$top_boder ?>'></td>
            <td class="text-right <?php echo $bottom_border.$top_boder ?>"></td>
            <td class='<?php echo $bottom_border.$top_boder ?>'></td>
            <td class='<?php echo $bottom_border.$top_boder ?>'></td>
            <td class='<?php echo $bottom_border.$top_boder ?>'></td>
            <td class="text-right <?php echo $bottom_border.$top_boder ?>"></td>
        </tr>
            <?php
            }
            ?>
    </table>
    <table width='771' class='b-right-solid footer-row font-10' cellspacing='0'>
        <tr>
            <td colspan="5" rowspan='3' class='no-top-border b-right-solid' width='315px'>
                <table class='font-9 v-align-top'>
                    <tr>
                        <td class='kh-muol v-align-top' width='60px'>បញ្ជាក់ :</td>
                        <td>
                            - ទំនិញទិញហើយមិនអាចប្ដូរយកប្រាក់បានទេ ប្រគល់ទំនិញក្រោយពេលប្រគល់ប្រាក់រួច។<br>
                            - វិក័យប័ត្រនេះទទួលខុសត្រូវចំពោះអ្នកទិញផ្ទាល់ពីហាងយើងខ្ញុំតែប៉ុណ្ណោះ<br>មិនទទួលខុសត្រូវចំពោះអ្នកទិញបន្តឡើយ
                        </td>
                    </tr>
                </table>
            </td>
            <td class='b-left-solid b-right-solid b-2bottom-border'>
                តំលៃសរុប Total Price
            </td>
            <td class="text-right no-top-border b-right-solid b-left-solid b-2bottom-border" width='13%'><?php echo amountExchange($subtotal, $invoice['multi'], $invoice['loc']) ?></td>
        </tr>
        <tr>
            <td class='b-left-solid b-right-solid b-2bottom-border'>
                កក់មុន Deposit
            </td>
            <td class="text-right b-right-solid b-left-solid b-2bottom-border"><?php echo amountExchange($invoice["pamnt"], $invoice['multi'], $invoice['loc']) ?></td>
        </tr>
        <tr>
            <td class='b-left-solid b-right-solid b-2bottom-border'>
                នៅខ្វះ Balance
            </td>
            <td class="text-right b-right-solid b-left-solid b-2bottom-border"><?php echo amountExchange($subtotal-$invoice["pamnt"], $invoice['multi'], $invoice['loc']) ?></td>
        </tr>
    </table>
    <table align='center' class='font-10'>
        <tr>
            <td width='50%' class='text-center'>
                ហត្ថលេខាអ្នកទិញ<br>Customer's signature
            </td>
            <td width='50%' class='text-center'>
                ហត្ថលេខា ឬ ត្រាអ្នកលក់<br>Seller's signature or Stamp
            </td>
        </tr>
    </table>
</body>
</html>
<script>
    window.onload = function(){
        window.print();
    }
</script>