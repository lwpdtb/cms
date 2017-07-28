<?php
$z[0]=Array("global","",236,264);
$z[0][4]['name']="cfg_soft_lang";
$z[1]=Array("field","",277,296);
$z[1][4]['name']="title";
$z[2]=Array("global","",297,323);
$z[2][4]['name']="cfg_webname";
$z[3]=Array("field","",364,393);
$z[3][4]['name']="keywords";
$z[4]=Array("field","",433,491);
$z[4][4]['name']="description";
$z[4][4]['function']="html2text(@me)";
$z[5]=Array("global","",509,541);
$z[5][4]['name']="cfg_templets_skin";
$z[6]=Array("include","",650,685);
$z[6][4]['filename']="head.htm";
$z[7]=Array("field","",823,852);
$z[7][4]['name']="position";
$z[8]=Array("list","\r\n    <li> [field:array runphp='yes']@me = (empty(@me['litpic']) ? \"\" : \"<a href='{@me['arcurl']}' class='preview'><img src='{@me['litpic']}'/></a>\"); [/field:array]\r\n     [<b>[field:typelink/]</b>] <a href=\"[field:arcurl/]\" class=\"title\">[field:title/]</a> <span class=\"info\"> <small>日期：</small>[field:pubdate function=\"GetDateTimeMK(@me)\"/] <small>点击：</small>[field:click/] <small>好评：</small>[field:scores/] </span>\r\n     <p class=\"intro\"> [field:description/]... </p>\r\n    </li>\r\n    ",929,1471);
$z[8][4]['pagesize']="10";
$z[9]=Array("pagelist","",1572,1650);
$z[9][4]['listitem']="info,index,end,pre,next,pageno,option";
$z[9][4]['listsize']="5";
$z[10]=Array("include","",1742,1779);
$z[10][4]['filename']="footer.htm";

?>