<?
if (isset($_GET['start'])) $start = $_GET['start'];
if (isset($_GET['id'])) $id = $_GET['id'];
if ($loc == "article") {
$products_on_page = $articles_on_page;
$production_src = $articles_src;
$head_name = "СТАТЬИ";
} else $head_name = "ТОВАРЫ";
function page_count() {
        global $string,$products_on_page,$production1,$count,$start,$dark_back,$main_back,$loc;
        $count = sizeof($production1);
        $c = 0;
        $w = 0;
        $z = 0;
        $string = "<table style='border:1px solid;border-color:".$main_back."' border=0 cellpadding=0 cellspacing=0><tr class=text><td bgcolor=".$dark_back.">Страницы: </td>";
        if(sizeof($production1) > $products_on_page) {
                $z = sizeof($production1)-1;
                while ($z >= 0) {
                $w = $w+1;
                $c = ($w-1)*$products_on_page;
                if ($c == $start) {
                $string = $string."<td width=20 bgcolor=".$main_back." style='border:1px solid' class=text><center><b>".$w."</font></td>";
                $z = $z-$products_on_page;
                }
                else {
                $string = $string."<td width=20 bgcolor=".$dark_back." class=text><center><a href='index.php?loc=".$loc."&start=".$c."&hrefrand=".rand(1,9999999999)."'>".$w."</a></td>";
                $z = $z-$products_on_page;
                }
                }
        }
        else $string = "<table style='border:1px solid;border-color:".$main_back."' border=0 cellpadding=0 cellspacing=0><tr class=text><td bgcolor=".$dark_back."><font face='Arial' size=2>Страницы: </td><td width=20 bgcolor=".$main_back."><center><font face=Arial size=2><b>1</td>";
        if ($loc == "article") {
        $inpart = "статей";
        } else $inpart = "товаров";
        $string = $string."<td bgcolor=".$dark_back." class=text>Всего ".$inpart.": </td><td width=20 bgcolor=".$main_back." class=text><center><b>".$count."</td></tr></table>";
}
function show_article() {
global $production_src,$id,$text,$loc,$start;
?>
<table cellpadding=2 cellspacing=1 width=100%>
<tr>
        <td width=100% class=text bgcolor=<? echo $text;?>><span class=white><a href='index.php?loc=<? echo $loc;?>&start=<?echo $start;?>'>[ << Назад ]</a></span>&nbsp;&nbsp;
<?
if (file_exists($production_src.$id.".jpg")) {
echo "<center><img src='".$production_src.$id.".jpg'></center>";
}
if (file_exists($production_src.$id.".gif")) {
echo "<center><img src='".$production_src.$id.".gif'></center>";
}
if (file_exists($production_src.$id.".png")) {
echo "<center><img src='".$production_src.$id.".png'></center>";
}
if (file_exists($production_src.$id.".zip")) {
echo "<div align=center class=white> <a href=".$production_src.$id.".zip> <img src='data/download.gif' border=0 height=15 width=15> [ Скачать ]</a>";
$size = filesize($production_src.$id.".zip")/1000;
echo "(".$size." Kb)</div>";
}
if (file_exists($production_src.$id.".rar")) {
echo "<div align=center class=white> <a href=".$production_src.$id.".rar> <img src='data/download.gif' border=0 height=15 width=15> [ Скачать ]</a>";
$size = filesize($production_src.$id.".rar")/1000;
echo "(".$size." Kb)</div>";
}
if (file_exists($production_src.$id.".txt")) {
# include($production_src.$id.".txt");
$file = $production_src.$id.".txt";
} else {# include($production_src.$id.".html");
 $file = $production_src.$id.".html";}
$file_text = file($file);
$text = "";
for ($i = 0;$i < sizeof($file_text);$i++) {
$text = $text.$file_text[$i]." ";
}
$text = str_replace("\n","<br>&nbsp;&nbsp;",$text);
		$text = preg_replace('/<\/([Hh]{1})5>/','</H1>', $text);
		$text = preg_replace('/<([Hh]{1})>/', '<H1>',$text);
echo $text;
?>

<br><br><span class=white><a href='index.php?loc=<? echo $loc;?>&start=<?echo $start;?>'>[ << Назад ]</a></span>
        </td>
</tr>
</table>
<?
}
function sort_by_date($production) {
        global $production_src,$production1,$imgs;
    for ($i = 0; $i < sizeof($production); $i++) {
    $date = filemtime($production_src.$production[$i]);
        for ($z = $i+1; $z < sizeof($production); $z++) {
    $traildate = filemtime($production_src.$production[$z]);
    if ($traildate > $date) {
    $t = $production[$z];
    $production[$z] = $production[$i];
    $production[$i] = $t;
    }
    }
    }
    for ($i = 0; $i < sizeof($production); $i++) {
    $production1[$i] = $production[$i];$img = explode(".",$production[$i]);
    if (file_exists($production_src.$img[0].".jpg")) {
$imgs[$i] = "<img src=".$production_src.$img[0].".jpg style=\"border:1px solid;border-color:white\">";
} elseif (file_exists($production_src.$img[0].".gif")) {
$imgs[$i] = "<img src=".$production_src.$img[0].".gif style=\"border:1px solid;border-color:white\">";
} elseif (file_exists($production_src.$img[0].".png")) {
$imgs[$i] = "<img src=".$production_src.$img[0].".png style=\"border:1px solid;border-color:white\">";
} else $imgs[$i] = "";
    }
}
function production() {
global $production_src,$head,$bg_color,$main,$text,$production1,$imgs,$string,$products_on_page,$start,$loc,$delivery_conditions;
$i = 0;
$handle = opendir($production_src);
while($file = readdir($handle))
{
  if ($file != '.' && $file != '..')
  {
    $file = explode(".",$file);
    if (isset($file[1]) && ($file[1] == "rar" || $file[1] == "zip" || $file[1] == "html"  || $file[1] == "htm")){
    $prod[$i] = $file[0].".".$file[1];
    $i++;
  }
  }
}
sort_by_date($prod);
page_count();
echo "<div style='margin:3px' align=right>".$string."</div>";
?>
<table cellspacing=0 cellpadding=2 width=100%>
<?
if (sizeof($prod)-$start < $products_on_page) $products_on_page = sizeof($prod)-$start;
for ($i = $start; $i < $products_on_page+$start; $i++) {
$file = explode(".",$production1[$i]);
if ($file[1] != "zip") {
$article = file($production_src.$production1[$i]);$zip = 0;
} else {$article = file($production_src.$file[0].".txt"); $zip = 1;}
$inf = "";
if (sizeof($article) < 4) {
        $stop = sizeof($article);
        }
        else $stop = 4;
for ($z = 0;$z < $stop;$z++){
$inf = $inf." ".$article[$z];
}
$l_mes = explode(" ", $inf);
        $l_mes_str = "";
        if (sizeof($l_mes) < 35) {
        $stop = sizeof($l_mes);
        }
        else $stop = 35;
        $l_mess_str = "";
        for ($g = 0; $g <= $stop-1; $g++) {
        $l_mess_str = $l_mess_str." ".$l_mes[$g];
        }
        $last = explode(".",$production1[$i]);
//$l_mess_str = $l_mess_str."... <div align=right class=white><a href=index.php?loc=".$loc."&id=".$last[0]."&start=".$start.">[ Подробнее ]</a></div>";

?>
<tr>
        <td width=80% class=text bgcolor=<? echo $bg_color;?> style="padding:10px;border-right:1px solid; border-color:<?echo $head;?>"><P class="intro">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
        <? 
		$l_mess_str = preg_replace('/<\/([Hh]{1})5>/','</a></H2>', $l_mess_str);
		$l_mess_str = preg_replace('/<([Hh]{1})5>/', "<H2><a href=index.php?loc=$loc&id=$last[0]&start=$start>",$l_mess_str);
		echo "$l_mess_str";
		if ($zip!=0) {
		echo "<div align=right class=white> <a href=".$production_src.$production1[$i]."> <img src='data/download.gif' border=0 height=15 width=15> [ Загрузить подробное описание ]</a>";
        $size = filesize($production_src.$production1[$i])/1000;
		echo "(".$size." Kb)</div>";
        }
		?></P>
        </td>
        <td vAlign=midst bgcolor=<? echo $text;?>><center>
        <? echo "<a href=index.php?loc=$loc&id=$last[0]&start=$start>$imgs[$i]</a>";?>
        </td>
</tr>
<?
}
?>
</table>
<?
echo "<div style='margin:3px' align=right>".$string."</div>";
}

if (isset($id)) {
show_article();
} else production();
?>
