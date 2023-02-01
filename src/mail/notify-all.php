<?php

/* @var $preparedData array */
/* @var $devices array */

?>
<!--[if (gte mso 9)|(IE)]>
<table width='800' align='center'>
    <tr>
        <td><![endif]-->
<table border='0' cellpadding='0' cellspacing='0' width='100%'
       style='max-width:800px;font-family:Arial,Helvetica Neue,Helvetica,sans-serif; Margin:25px auto;'>
    <tr>
        <td>
            <table cellpadding='0' cellspacing='0' class="storehouse-table">
                <thead class="header">
                <tr>
                    <th colspan="4" class="px-4" style="text-align: left">
                        Spotreba za posledných 24 hodín
                    </th>
                </tr>
                </thead>
                <tbody>
                <?php foreach ($preparedData as $deviceID => $deviceChannels) { ?>
                    <tr>
                        <td class="row">&nbsp;</td>
                        <td class="row">&nbsp;</td>
                    </tr>
                    <tr>
                        <td class="row"
                            style="color: #1b1e24;font-weight: bold;font-size: 20px;"><?= $devices[$deviceID] ?></td>
                        <td class="row">&nbsp;</td>
                    </tr>
                    <?php foreach ($deviceChannels as $channelAlias => $value) { ?>
                        <tr>
                            <td class="row" style='font-weight: bold;'>Kanal: <span
                                    style="background-color: lightcoral;color: #1b1e24"><?= $channelAlias ?></span></td>
                            <td class="row"><?= round($value / 1000, 3) ?>&nbsp;kW</td>
                        </tr>
                    <?php } ?>

                <?php } ?>
                </tbody>
            </table>
        </td>
    </tr>
</table>
<!--[if (gte mso 9)|(IE)]></td></tr></table><![endif]-->