<?php
require_once (dirname(__file__).'/include/common.inc.php');
//利用解析式模板所需的文件
require_once (dirname(__file__).'/include/dedetag.class.php');
$id=intval($_GET['id']);
$arcQuery="SELECT imgurls FROM dede_addonimages WHERE aid=$id";
$arcRow = $dsql->GetOne($arcQuery);
//var_dump($arcQuery);
$imgurls=$arcRow['imgurls'];

$arcQuery="SELECT title FROM dede_archives WHERE id=$id";
$arcRow = $dsql->GetOne($arcQuery);
//var_dump($arcQuery);
$title=$arcRow['title'];
$j = 1;
$data=array();
if($imgurls!=""){
    $dtp = new DedeTagParse();
    $dtp->LoadSource($imgurls);
    if(is_array($dtp->CTags))
    {
        foreach($dtp->CTags as $ctag)
        {
            if($ctag->GetName()=="img")
            {
                $bigimg = trim($ctag->GetInnerText());
                if($ctag->GetAtt('ddimg') != $bigimg && $ctag->GetAtt('ddimg')!='')
                {
                    $litimg = $ctag->GetAtt('ddimg');
                }
                else
                {
                    $litimg = 'swfupload.php?dopost=ddimg&img='.$bigimg;
                }
                $text=$ctag->GetAtt('text');
                $width=$ctag->GetAtt('width');
                $height=$ctag->GetAtt('height');
                $imgurl=$ctag->GetAtt('ddimg');
                $data[$j-1]=array($text,$width,$height,$imgurl,$title);
                $fhtml = '';
//                $fhtml .= "<div class='albCt albEdit' id='albold{$j}'>\r\n";
//                $fhtml .= "	<input type='hidden' name='imgurl{$j}' value='{$bigimg}' />\r\n";
//                $fhtml .= "	<input type='hidden' name='imgddurl{$j}' value='{$litimg}' />\r\n";
//                $fhtml .= "	<img src='{$litimg}' width='120' /><a href=\"javascript:delAlbPicOld('$bigimg', $j)\">[删除]</a>\r\n";
//                $fhtml .= "	<div style='margin-top:10px'>注释：<input type='text' name='imgmsg{$j}' value='".$ctag->GetAtt('text')."' style='width:190px;' /></div>\r\n";
//                $fhtml .= "	<div style='margin-top:10px'>更换：<input type='file' name='imgfile{$j}' size='18' style='width:190px' /></div>\r\n";
//                $fhtml .= "</div>\r\n";
//                echo $fhtml;
                $j++;
            }
        }
    }

    $dtp->Clear();
    echo json_encode($data);
}
?>
