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
                padding: 3pt;
                vertical-align: top;
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
        </style>
    </head>
    <body dir="<?= LTR ?>">
        <?php
        $loc = location($invoice['loc']);
        $customer_info = explode('*:*', $invoice['customer_info']);
        ?>
        <div>
            <span class="bold"><?php echo $loc['cname']; ?></span><br>
            <span><?php echo $this->lang->line('Address') . ": " . $loc['address'] . "," . $loc['city'] ?></span><br>
            <span><?php echo $this->lang->line('Phone') . ": " . $loc['phone'] ?></span><br>
            <span><?php echo $this->lang->line('TAX ID') . ": " . $loc['taxid'] ?></span><br>
        </div>
        <br><br>
        <table class="font9" cellspacing="0" cellpadding="0" style="padding:0 !important; margin:0 !important">
            <tbody>
                <tr>
                    <td class="font12" align="center" colspan="3">វិក្កយបត្រ INVOICE</td>
                </tr>
                <tr class="font9">
                    <td></td>
                    <td>លេខរៀងវិក្កយបត្រ: </td>
                    <td><?php echo $invoice["tid"] ?></td>
                </tr>
                <tr class="font9">
                    <td></td>
                    <td>Invoice No</td>
                    <td></td>
                </tr>
                <tr class="font9">
                    <td></td>
                    <td>កាលបរិច្ឆេទ: </td>
                    <td><?php echo dateformat($invoice["invoicedate"]) ?></td>
                </tr>
                <tr >
                    <td></td>
                    <td>Date</td>
                    <td>DD-MM-YYYY</td>
                </tr>
                <tr class="font9">
                    <td width="65%">ឈ្មោះក្រុមហ៊ុនឫអតិថិជន: <?php echo $customer_info[0] ?></td>
                    <td>ឯកសារយោង: </td>
                    <td><?php echo $invoice['refer'] ?></td>
                </tr>
                <tr class="font9">
                    <td>Company Name / Customer</td>
                    <td>Ref No.</td>
                    <td></td>
                </tr>
            </tbody>
        </table>
        <table class="font9" width="100%">
            <tr>
                <td>អាសយដ្ឋានផ្ទះលេខ <?php echo $customer_info[5] ?><br>Address House No.</td>
                <td>ផ្លូវ <?php echo $customer_info[6] ?><br>Street</td>
                <td>ឃុំ/សង្កាត់ <?php echo $customer_info[9] ?><br>Commune/Sangkat</td>
                <td>ក្រុង/ស្រុក/ខ័ណ្ឌ <?php echo $customer_info[10] ?><br>Town/District/Khan</td>
                <td>ខេត្ត/រាជធានី <?php echo $customer_info[11] ?><br>Province/City</td>
            </tr>
            <tr>
                <td>ទូរស័ព្ទលេខ: <?php echo $customer_info[4] ?><br>Telephone No.</td>
                <td colspan="3"></td>
            </tr>
        </table>
        <table class="font9" width="100%">
            <tr>
                <td>ល័ក្ខខ័ណ្ឌនៃការទូទាត់: <br>Payment Terms and Condition:</td>
                <td><span class="box">aa</span> សាច់ប្រាក់<br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;by Cash</td>
                <td><span class="box">aa</span> មូលប្បទានប័ត្រ<br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;by Cheque</td>
                <td><span class="box">aa</span> មូលប្បទានប័ត្រលេខ...............................<br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Cheque No.</td>
                <td><span class="box">aa</span> ធនាគារ<br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;by Bank</td>
            </tr>
        </table>
        <div class="invoice-box">
            <table class="party font9" cellpadding="0" cellspacing="0" style="padding:0 !important; margin:0 !important">
                <tr>
                    <td class="text-center b-right b-bottom"​ width="9%">
                        លេខរៀង<br>#
                    </td>
                    <td class="text-center b-right b-bottom">
                        បរិយាមុខទំនិញ<br>Description of Goods
                    </td>
                    <td class="text-center b-right b-bottom" width="12%">
                        ចំនួន<br>Quantity
                    </td>
                    <td class="text-center b-right b-bottom" width="15%">
                        តម្លៃឯកតា<br>Unit Price
                    </td>
                    <td class="text-center b-right b-bottom" width="15%">
                        សរុប<br>Amount
                    </td>
                </tr>
                <?php
                $no = 0;
                $discount = 0;
                $subtotal = 0;
                foreach ($products as $row) {
                    $no++;
                    $discount += $row['totaldiscount'];
                    $subtotal += $row['subtotal'];
                    ?>
                    <tr>
                        <td class="text-center b-right">
                            <?php echo $no ?>
                        </td>
                        <td class="b-right">
                            <?php
                            echo $row["product"];
                            if ($row["body_number"] || $row["engine_number"] || $row["plate_number"]) {
                                echo "<br>";
                                echo $row["body_number"] ? $row["body_number"] : "";
                                echo $row["engine_number"] ? " | " . $row["engine_number"] : "";
                                echo $row["plate_number"] ? " | " . $row["plate_number"] : "";
                            }
                            ?>
                        </td>
                        <td class="b-right text-right">
                            1 UN
                        </td>
                        <td class="b-right text-right">
                            <?php echo amountExchange($row['subtotal']+$row['totaldiscount'], $invoice['multi'], $invoice['loc']) ?>
                        </td>
                        <td class=" text-right">
                            <?php echo amountExchange($row['subtotal']+$row['totaldiscount'], $invoice['multi'], $invoice['loc']) ?>
                        </td>
                    </tr>
                    <tr>
                        <td class="text-center b-right">
                        </td>
                        <td class="b-right">
                        </td>
                        <td class="b-right text-right">
                        </td>
                        <td class="b-right text-right">
                        </td>
                        <td class=" text-right">
                        </td>
                    </tr>
                    <tr>
                        <td class="text-center b-right">
                        </td>
                        <td class="b-right">
                        </td>
                        <td class="b-right text-right">
                        </td>
                        <td class="b-right text-right">
                        </td>
                        <td class=" text-right">
                        </td>
                    </tr>
                    <?php
                }
                ?>
                    <tr>
                        <td rowspan="2" class="b-top b-right"><u>ជាអក្សរ</u><br>In Word</td>
                        <td rowspan="2" class="b-top b-right"><?php echo $this->invocies->convertNumberToKhWord($subtotal); ?></td>
                        <td colspan="2" class="b-top b-right">បញ្ចុះតម្លៃ<br>Discount</td>
                        <td class="text-right b-top v-middle"><?php echo amountExchange($discount, $invoice['multi'], $invoice['loc']) ?></td>
                    </tr>
                    <tr>
                        <td colspan="2" class="b-top b-right">សរុប(បូកបញ្ចូលទាំងអារករ)<br>Total(VAT Included)</td>
                        <td class="text-right b-top v-middle"><?php echo amountExchange($subtotal, $invoice['multi'], $invoice['loc']) ?></td>
                    </tr>
            </table>
            <br>
        </div>
    </div>
</body>
</html>