<table>
    <tr>
        <td class="myw">
            <table class="top_sum">
                <tr>
                    <td colspan="3" style="text-align:center"><h2>វិក័យប័ត្រ <?= $general['title'] ?></h2><br><br></td>
                </tr>
                <tr>
                    <td style="width:60%"></td>
                    <td><?= 'វិក័យប័ត្រលេខ'?></td>
                    <td><?= $general['prefix'] . ' ' . $invoice['tid'] ?></td>
                </tr>
                <tr>
                    <td></td>
                    <td><?= 'ថ្ងៃទី'. ' ' . $this->lang->line('Date') ?></td>
                    <td><?php echo dateformat($invoice['invoicedate']) ?></td>
                </tr>
                <tr style="visibility: hidden;">
                    <td></td>
                    <td><?php echo "ថ្ងៃផុតកំណត់"//$this->lang->line('Due Date') ?></td>
                    <td><?php echo dateformat($invoice['invoiceduedate']) ?></td>
                </tr>
                <?php if ($invoice['refer']) { ?>
                    <tr>
                        <td></td>
                        <td><?php echo $this->lang->line('Reference') ?></td>
                        <td><?php echo $invoice['refer'] ?></td>
                    </tr>
                <?php } ?>
            </table>


        </td>
    </tr>
</table>
<br>