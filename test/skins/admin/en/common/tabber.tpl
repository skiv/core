<table border=0 width="100%" cellpadding=0 cellspacing=0 valign=top>
<tr><td height=15>
<table border=0 cellspacing=0 cellpadding=0 height=100%>
	<tbody FOREACH="widget.getSplittedPages(#90#),row_idx,row">
	<tr><td>
		<table border="0" cellpadding="0" cellspacing="0" {if:widget.isHeaderWider(row_idx,#45#)} width="100%"{end:}>
            <tr height=17>
            {foreach:row,tabPage}
            {if:tabPage}
            <td width="1"></td>
            {if:tabPage.selected}
            <td width="3" background="images/tab_a1.gif"></td>
            <td nowrap align=center valign=center background="images/tab_bg_a.gif">&nbsp;&nbsp;&nbsp;<a class=PageLink href="{tabPage.url:h}"><FONT class="tabSelected">{tabPage.header}</FONT></a>&nbsp;&nbsp;&nbsp;</td>
            <td width="4" background="images/tab_a2.gif">&nbsp;</td>
            {else:}
            <td width="3" background="images/tab_p1.gif"></td>
            <td nowrap align=center valign=center background="images/tab_bg_p.gif">&nbsp;&nbsp;&nbsp;<a class=PageLinkDefault href="{tabPage.url:h}"><FONT class="tabDefault">{tabPage.header}</FONT></a>&nbsp;&nbsp;&nbsp;</td>
            <td width="4" background="images/tab_p2.gif">&nbsp;</td>
            {end:}
            <td width="1"></td>
            {end:}
            {end:}
            </tr>
            <tr height=1 class=CenterBorder IF="!rowArrayPointer=rowArraySize"><td class=CenterBorder></td></tr>
		</table>
	</td></tr>
	</tbody>
</table>
</tr>
<tr>
<td align=center class=CenterBorder>
<table border=0 cellspacing=2 cellpadding=0 width="100%">
<tr>
<td class=CenterBorder>
<table border=0 cellspacing=1 cellpadding=20 width="100%" class=Center>
<tr>
<td class=Center>
<widget template="{widget.body}">
</td>
</tr>
</table>
</td>
</tr>
</table>
</td>
</tr>
</table>
<br>
<br>
