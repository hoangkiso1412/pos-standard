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
                
            .bold{
                font-weight: bold;
            }
                
            .invoice-box {
                width: 210mm;
                height: 297mm;
                margin: auto;
                border: 0;
                font-size: 12pt;
                line-height: 16pt;
                color: #000;
            }
                
            table {
                width: 100%;
                /*line-height: 16pt;*/
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
                padding: 6pt 5pt;
                vertical-align: top;
                border:1px solid black;
            }
                
            .invoice-box table.top_sum td {
                padding: 0;
                font-size: 12pt;
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
                border: #2B2000 1px solid;
            }
            .text-center{
                text-align:center;
            }
            .text-right{
                text-align:right;
            }
                
                
            .top_logo {
                max-height: 180px;
                max-width: 250px;
                <?php if (LTR == 'rtl') echo 'margin-left: 200px;' ?>
            }
            .box-text{
                border:1px solid #2B2000;
                padding:5px;
                margin:5px;
            }
            .font10{
                font-size:10pt;
            }
            .font9{
                font-size:9.8pt;
            }
            .font12{
                font-size:12pt;
            }
            .box{
                color:white;
                border:1px solid #2B2000;
                margin:5pt;
                width:10pt;
            }
            .b-left{
                border-left:1px solid #2B2000;
            }
            .b-right{
                border-right:1px solid #2B2000;
            }
            .b-top{
                border-top:1px solid #2B2000;
            }
            .b-bottom{
                border-bottom:1px solid #2B2000;
            }
            .padding-bottom{
                padding-bottom: 5pt !important;
            }
            .v-middle{
                vertical-align: middle !important;
            }
            .table-box{
                
            }
            .table-box td{
                font-size:14pt;
                padding:4px 5px;
            }
            .table-box .padding-table td{
                font-size:14pt;
                padding:2px 5px;
            }
            .table-box .invoice-row td{
                font-size:13pt;
                padding:5px 4px;
            }
        </style>
    </head>
    <body dir="<?= LTR ?>">
        <?php
        $loc = location($invoice['loc']);
        $customer_info = explode('*:*', $invoice['customer_info']);
        ?>
        <br><br><br><br><br><br><br><br><br><br><br>
        <div class="table-box">
            <table>
                <tr>
                    <td width="82%"></td>
                    <td>
                        <?php echo $invoice["tid"] ?>
                    </td>
                </tr>
            </table>
            <table>
                <tr>
                    <td width="80%"></td>
                    <td>
                        <?php echo dateformat($invoice["invoicedate"]) ?>
                    </td>
                </tr>
            </table>
            <table>
                <tr>
                    <td width="80%" style=""></td>
                    <td>
                        <?php echo $loc['taxid'] ?>
                    </td>
                </tr>
            </table>
            <table>
                <tr>
                    <td style="padding:2px !important"></td>
                    <td style="color:white;padding:2px !important">
                        .
                    </td>
                </tr>
            </table>
            <table class="padding-table">
                <tr>
                    <td width="31%"></td>
                    <td width="26%"><?php echo $customer_info[0] ?></td>
                    <td width="8.5%"></td>
                    <td width="8.5%"><?php echo $customer_info[1] ?></td>
                    <td width="8.5%"></td>
                    <td width="8.5%"><?php echo $customer_info[2] ?></td>
                    <td width="9%"></td>
                </tr>
            </table>
            <table class="padding-table">
                <tr>
                    <td width="37%"></td>
                    <td width="21%"><?php echo $customer_info[3] ?></td>
                    <td width="13%"></td>
                    <td width="29%"><?php echo $customer_info[4] ?></td>
                </tr>
            </table>
            <table class="padding-table">
                <tr>
                    <td width="30%"></td>
                    <td width="10%"><?php echo $customer_info[5] ?></td>
                    <td width="3%"></td>
                    <td width="17%"><?php echo $customer_info[6] ?></td>
                    <td width="3%"></td>
                    <td width="6%"><?php echo $customer_info[7] ?></td>
                    <td width="5%"></td>
                    <td width="29%"><?php echo $customer_info[8] ?></td>
                </tr>
            </table>
            <table class="padding-table">
                <tr>
                    <td width="12%"></td>
                    <td width="24%"><?php echo $customer_info[9] ?></td>
                    <td width="9%"></td>
                    <td width="25%"><?php echo $customer_info[10] ?></td>
                    <td width="6%"></td>
                    <td width="24%"><?php echo $customer_info[11] ?></td>
                </tr>
            </table>
            <br><br><br>
            <table class="invoice-row">
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
                ?>
                <tr>
                    <td width="7%" class="text-center"><?php echo $no ?></td>
                    <td width="25%"><?php echo $pro_name ?></td>
                    <td width="10%" class="text-right"><?php echo 1 ?></td>
                    <td width="10%"><?php echo $color ?></td>
                    <td width="10%"><?php echo $year ?></td>
                    <td width="25%"><?php echo $row["engine_number"]." | ".$row["body_number"] ?></td>
                    <td width="13%" class="text-right"><?php echo amountExchange($row['subtotal'], $invoice['multi'], $invoice['loc']) ?></td>
                </tr>
            <?php
            }
            for($i=0;$i<8-$no;$i++){
            ?>
                <tr>
                    <td class="text-center" style="color: white">.</td>
                    <td></td>
                    <td class="text-right"></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td class="text-right"></td>
                </tr>
            <?php
            }
            ?>
                <tr>
                    <td colspan="6"></td>
                    <td class="text-right"><?php echo amountExchange($subtotal, $invoice['multi'], $invoice['loc']) ?></td>
                </tr>
                <tr>
                    <td colspan="6"></td>
                    <td class="text-right"><?php echo amountExchange($invoice["pamnt"], $invoice['multi'], $invoice['loc']) ?></td>
                </tr>
                <tr>
                    <td colspan="6"></td>
                    <td class="text-right"><?php echo amountExchange($subtotal-$invoice["pamnt"], $invoice['multi'], $invoice['loc']) ?></td>
                </tr>
            </table>
        </div>
    </body>
</html>