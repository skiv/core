<p align=justify>This section displays statistics on sales to the customers attracted by partners. The statistics can be sorted by affiliates and by referrer-addresses from which the customers came to your store.</p>

<br>

<form name=search_sales_form action="admin.php" method=GET>
<input type="hidden" foreach="dialog.allparams,param,v" name="{param}" value="{v}"/>

<table border=0 cellpadding=3>
<tr>
    <td>Period from:</td>
    <td><widget class="XLite_View_Date" field="startDate"></td>
</tr>
<tr>
    <td>Period to:</td>
    <td><widget class="XLite_View_Date" field="endDate"></td>
</tr>
<tr>
    <td>Report by:</td>
    <td>
    <table border=0>
    <tr>
        <td><input type=radio name=report_by value=affiliate checked="report_by=#affiliate#"></td>
        <td>Affiliate</td>
        <td>&nbsp;<input type=radio name=report_by value=referrer checked="report_by=#referrer#"></td>
        <td>Referrer</td>
    </tr>
    </table>
    </td>
</tr>
<tr>
    <td>Sort by:</td>
    <td>
    <table border=0>
    <tr>
        <td><input type=radio name=sort_by value=clicks checked="sort_by=#clicks#"></td>
        <td>Clicks</td>
        <td>&nbsp;<input type=radio name=sort_by value=sales checked="sort_by=#sales#"></td>
        <td>Sales</td>
    </tr>
    </table>
    </td>
</tr>
<tr>
    <td>&nbsp;</td>
    <td><input type=submit name=search value=Search></td>
</tr>
</table>

<br><br>

<table IF="search&stats" border=0 cellpadding=5 cellspacing=1>
<tr class=TableHead>
    <td>{if:report_by=#affiliate#}
        <b>Partner</b>
        {else:}
        <b>Referrer</b>
        {end:}
    </td>    
    <td><b>Clicks</b></td>
    <td><b>Sales number</b></td>
    <td><b>Sales total</b></td>
</tr>
<tr FOREACH="stats,stat">
    <td>{if:report_by=#affiliate#}
        {stat.partner.login:h}
        {else:}
        <a href="{stat.referrer}" target="_blank"><u>{stat.referrer:h}</u></a>
        {end:}
    </td>
    <td align=center>{stat.clicks}</td>
    <td align=center>{stat.sales}</td>
    <td align=right>{price_format(stat.total):h}</td>
</tr>
</table>
