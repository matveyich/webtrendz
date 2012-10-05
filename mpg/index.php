<?
require("config.php");
#$HTTP_POST_VARS;
$REMOTE_ADDR = $_SERVER['REMOTE_ADDR'];

if (isset($_GET['loc'])) {$loc = $_GET['loc'];} else $loc = "";

$link = mysql_connect($host, $user, $password);
mysql_select_db($DB, $link) or die('Не могу выбрать БД');

if (isset($_POST['pas'])) $pas = $_POST['pas'];
if (isset($_POST['login'])) $login = $_POST['login'];

function check_user() {
global $REMOTE_ADDR,$users,$avatars,$string,$cookie_name,$login,$pas,$quit,$link;
global $DB,$host,$user,$password;

if ($login and $pas) {
if (file_exists($users.$login.".dat")) {
$userfile = file($users.$login.".dat");
$password = explode("\n",$userfile[1]);
if ($pas==$password[0]) {
if (file_exists($avatars.$login.".gif")) {
$avatar = $avatars.$login.".gif";
}
else {$avatar = $avatars."default.gif";}

#$cookie = $login."^^".$pas."^^".$avatar;
#$for = time() + 24*3600;
#setcookie($cookie_name,$cookie,$for);

#--- DROPPING temporary base
$query = "truncate u_ips;";
mysql_query($query,$link);echo mysql_error();
#----
$query = "INSERT INTO u_ips VALUES('".$login."', '".$pas."','".$REMOTE_ADDR."')";
mysql_query($query,$link);


$string = "Вы авторизированы";
}
else {$string = "Неправильный пароль";};
}
else {$string = "Нет такого пользователя";}
}

$string = $string."<br><span class=\"name_black\"><a href=\"index.php?hrefrand=".rand(1,9999999)."\">Продолжить >></a></span>";
}
if (isset($_GET['quit'])) {
$query = "DELETE from u_ips where IP = '".$REMOTE_ADDR."';";
    mysql_query($query,$link);
#$cookie = "have_gone^^^^";
#setcookie($cookie_name,$cookie);$string = "Вы вышли";
}

if (isset($loc) && $loc == "register.php") {
check_user();
}

function info() {
global $address,$phone,$mobile,$mail,$head;
$contact = "<span class=text><b>КОНТАКТ: </b><b>тел.</b> - ".$phone." <b>мобильный тел.</b>- ".$mobile;
?>
<marquee direction=left BEHAVIOR="SLIDE" speed=1><? echo $contact;?></marquee>
<?
}
function my_bcmod( $x, $y )
{
    // how many numbers to take at once? carefull not to exceed (int)
    $take = 5;    
    $mod = '';

    do
    {
        $a = (int)$mod.substr( $x, 0, $take );
        $x = substr( $x, $take );
        $mod = $a % $y;   
    }
    while ( strlen($x) );

    return (int)$mod;
}
if( !function_exists( "bcdiv" ) )
{
    function bcdiv( $first, $second, $scale = 0 )
    {
        $res = $first / $second;
        return round( $res, $scale );
    }
} 
function rightmenu($voting) {
global $main_back,$dark_back,$light_back,$votesrc,$menu_border,$bg_color;
?>
<table width=150 cellpadding=0 cellspacing=0>
       <tr>
                        <td width=100%>
                <table width=100% cellpadding=0 cellspacing=0>
                       <tr>
                       <td></td>
                       <td width=100% class=name background=data/bggradient.gif height=17 bgcolor=<? echo $main_back; ?> width=100% style="border-top:1px solid;border-color:<?echo $menu_border;?>"><b><center>ОПРОС</td>
                       </td>
                       </tr>
                </table>
            </td>
       </tr>
       <tr>
                       <td bgcolor=<? echo $bg_color;?> style="border-left:1px solid;border-bottom:1px solid;border-color:<?echo $menu_border;?>" class=text>
<?
        global $vote,$names,$num,$header,$results;
    $f = file($vote);
    $f = explode("##", $f[0]);
    $n = file($names);
    $names = explode("##", $n[0]);
    $num = 0;
    $header = $names[0];
    for ($i = 1; $i <= (sizeof($f)-2); $i++) {
    $num = $num+$f[$i];
    }
    $results = "";
    echo "<center>".$header;
    ?>
    <table bgcolor=<? echo $bg_color;?> width=100% cellpadding=1 cellspacing=1>
    <?
    for ($i = 1; $i <= (sizeof($f)-2); $i++) {
    $votes = $f[$i];
    if (!$num==0){
    $proc = ($votes/$num)*100;
    }
    else $proc = 0;
    $proc = floor($proc);
    $title = "<input type=radio name=\"radio\" value=\"".$i."\">".$names[$i];
    $results = $results."<tr><td class=text>".$title."</td></tr><tr><td style='border-top:1px solid;border-bottom:1px solid;border-color:red' bgcolor=".$main_back."><img src='data/vt.gif' style=\"filter:alpha(opacity=90)\" width=".($proc)." height=8><font size=2>(".$proc."%)</td></tr>";
    }
?>
<form action="index.php?loc=voting" method=get>
<?
echo $results;
?>
<input type=hidden name=loc value="voting">
<tr><td class=text><input type=submit value=Голосовать onMouseover="this.style.backgroundColor = '<? echo $main_back; ?>'" onMouseout="this.style.backgroundColor = '<? echo $dark_back; ?>'" style="font-weight:normal;width:100%;color:black;border:0px;background-color:<? echo $dark_back; ?>;font-family:Verdana;font-size:12;cursor:hand"></td></tr>
</form>
<?
echo "<tr><td class=text style='border-top:1px solid;border-bottom:1px solid;border-color:white' bgcolor=".$bg_color.">Всего голосов: <b>".$num."</td></tr></table>";
?>
            </td>
       </tr>
</table>
<?
}
# for forum
function main_history() {
global $loc,$src,$themeid,$imgid,$head;
?>
<table border=0 width=100%>
<tr><td width=100% class=text bgcolor=<?echo $head;?> background="data/bggradient.gif">
<?
if ($loc == "forum"){
echo "<span class=text>Форум</span>";
}
if ($loc == "topics"){
$tpn = file("forum/".$src."name");
$history = "<a href=index.php?loc=forum&hrefrand=".rand(1,9999999999).">Форум</a></font> <b>&raquo</b> <span class=text>".$tpn[0]."</span>";
echo $history;
}
if ($loc == "messages"){
$tpn = file("forum/".$src."name");
$msn = file("forum/".$src.$themeid.".txt");
$history = "<a href=index.php?loc=forum&hrefrand=".rand(1,9999999999).">Форум</a></font> <b>&raquo</b> <font face=Arial size=2><a href=index.php?loc=topics&src=".$src."&hrefrand=".rand(1,9999999999)."&start=0>".$tpn[0]."</a></font> <b>&raquo</b> <font face=Arial size=2><span class=text>".$msn[0]."</span>";
echo $history;
}
?>
</td></tr></table>
<?
}
function get_title($id,$loc)
{
global $production_src,$articles_src;
if ($loc == "article") {
$production_src = $articles_src;
}
//echo $production_src;
//echo $id;
if (file_exists($production_src.$id.".txt")) {
# include($production_src.$id.".txt");
$file = $production_src.$id.".txt";
} else {# include($production_src.$id.".html");
 $file = $production_src.$id.".html";}
$file_text = file($file);
$text = "";
for ($i = 0;$i < 5;$i++) {
$text = $text.$file_text[$i]." ";
}
str_replace("\n","<br>&nbsp;&nbsp;",$text);
//echo $text;
preg_match_all('/<([Hh]{1})5>(.+)<\/([Hh]{1})5>/', $text, $matches);
//print_r($matches);
//echo $matches[2][0];
return $matches[2][0].' | ';
}
function title()
{
global $loc;
	switch ($loc) {
      case "":
                              $title = 'Новости сайта | ';break;

      case ("admin"):
                               $title = 'Панель управления| Главная';break;
      case ("view_log"):
                              $title = 'Панель управления | Log file';break;
      case ("contacts_edit"):
                              $title = 'Панель управления | Редактирование контактной информации';break;
      case "letters_viewer":
                              $title = 'Панель управления | Просмотр писем';break;
      case "view_letter":
                              $title = 'Панель управления | Просмотр письма';break;
      case "price":
                              $title = 'Прайс листы | ';break;
      case "voting":
                                $title = 'Опрос | ';break;
      case "article": 			
								$title = 'Статьи | ';
                                 if (isset($_GET['id'])) {
								
								 $title = get_title($_GET['id'],$loc).$title;
								 }
								
			break;
      case "trade":				
								$title = 'Товары | ';
                                 if (isset($_GET['id'])) {
								 
								 $title = get_title($_GET['id'],$loc).$title;
								 }
								
			break;
      case "offers":
                                $title = 'Акции и предложения | ';break;
      case "visitcard":
                                $title = 'Обратная связь | ';break;
	case "search":
                                $title = 'Шиномонтажный поиск | ';break;							
      }
echo $title;	  
}
?>
<HTML><HEAD><TITLE>
<?title();?>TIPTOP - ДОНЕЦК - Клей Тип Топ, Шиноремонт, шиномонтаж, вулканизация
</TITLE>
<meta http-equiv="Content-Type" Content="text/html; charset=Windows-1251">
<link rel="shortcut icon" href="favicon.ico">
<meta name="keywords" content="TIP TOP STAHLGRUBER, Клей ТИП ТОП ШТАЛЬГРУБЕР, шиноремонт, шиномонтаж, вулканизация">
<meta name="description" content="TIP TOP STAHLGRUBER, Клей ТИП ТОП ШТАЛЬГРУБЕР, шиноремонт, шиномонтаж, вулканизация">
<script languge="JavaScript">
function openWin(x) {
  myWin= open(x, "displayWindow",
    "width=400,height=300,status=no,toolbar=no,menubar=no,scrollbar=yes");
}
</script>
<script type="text/javascript" src="text_editors/nicEditor/nicEdit.js"></script>
<SCRIPT language=JavaScript src="scripts/scripting.js"></SCRIPT>

<LINK href="files/script.css" type=text/css rel=stylesheet>
<style>
.white a:link,.white a:visited,.white a:active,.white {TEXT-DECORATION: none; FONT-SIZE: 12px; font-weight: normal; color:black; font-family:Arial}
.white a:hover {TEXT-DECORATION: underline; FONT-SIZE: 12px; color:red; font-family:Arial}
</style>

</HEAD>
<BODY leftMargin=0 topMargin=0 onload=start() bgColor="<?echo $bg_color;?>">
<center>

<TABLE width=100% borderColor=#ffffff cellSpacing=2 cellPadding=0 width=100% height=100% bgColor="<?echo $bg_color;?>"
border=0>
  <TBODY>
  <TR>
    <TD colSpan=3  class=text_black>
<table background="files/bg.gif" cellpadding=0 cellspacing=0 width=100%>
<tr background="files/bg.gif">
<td width=100% height=80><center>
<!-- banner -->
<OBJECT classid="clsid:D27CDB6E-AE6D-11cf-96B8-444553540000"
 codebase="http://download.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=5,0,0,0"
 WIDTH=550 HEIGHT=80>
 <PARAM NAME=movie VALUE="files/buttons_1.swf"> <PARAM NAME=menu VALUE=false> <PARAM NAME=quality VALUE=high> <PARAM NAME=bgcolor VALUE=#FFFFFF> <EMBED src="files/buttons_1.swf" menu=false quality=high bgcolor=#FFFFFF  WIDTH=550 HEIGHT=80 TYPE="application/x-shockwave-flash" PLUGINSPAGE="http://www.macromedia.com/shockwave/download/index.cgi?P1_Prod_Version=ShockwaveFlash"></EMBED>
</OBJECT>
</td>
<!--
<td width=0>
<img src="files/ban.gif"></td>
</td>
-->
<td background="files/ban_bg.gif" width=0>

</td>
</tr>
</table>
      <center>
        </center>
        </TD>
  </TR>
  <TR height=100%>
    <TD vAlign=top width=80>
    <table cellspacing=0 cellpadding=0 width=120>
    <tr>
       <td class=name background="data/bggradient.gif" style="border-right:1px solid;border-top:1px solid;border-color:<?echo $menu_border;?>" width=100%><center><b>МЕНЮ</td>
    </tr>
    <tr>
        <td class=menu style="border-right:1px solid;border-color:<?echo $menu_border;?>" width=100%><img src="data/1p_bg.gif" style="height:12px"></td>
    </tr>

    <tr>
        <td onMouseover="this.style.backgroundColor='<?echo $menu_border;?>'" onMouseout="this.style.backgroundColor='<?echo $bg_color;?>'" class=menu style="border:0px solid;border-right:1px solid;border-color:<?echo $menu_border;?>" width=100% ><center><a href="index.php">НОВОСТИ</a></td>
    </tr>

    <tr>
        <td class=menu style="border-right:1px solid;border-color:<?echo $menu_border;?>" width=100%><img src="data/1p_bg.gif" style="height:12px"></td>
    </tr>

    <tr>
        <td onMouseover="this.style.backgroundColor='<?echo $menu_border;?>'" onMouseout="this.style.backgroundColor='<?echo $bg_color;?>'" class=menu style="border:0px solid;border-right:1px solid;border-color:<?echo $menu_border;?>" width=100% ><center><a href="index.php?loc=price">ПРАЙС</a></td>
    </tr>

    <tr>
        <td class=menu style="border-right:1px solid;border-color:<?echo $menu_border;?>" width=100%><img src="data/1p_bg.gif" style="height:12px"></td>
    </tr>

    <tr>
       <td onMouseover="this.style.backgroundColor='<?echo $menu_border;?>'" onMouseout="this.style.backgroundColor='<?echo $bg_color;?>'" class=menu style="border:0px solid;border-right:1px solid;border-color:<?echo $menu_border;?>" width=100% ><center><a href="index.php?loc=trade&start=0">ТОВАРЫ</a></td>
    </tr>

    <tr>
        <td class=menu style="border-right:1px solid;border-color:<?echo $menu_border;?>" width=100%><img src="data/1p_bg.gif" style="height:12px"></td>
    </tr>

    <tr>
        <td onMouseover="this.style.backgroundColor='<?echo $menu_border;?>'" onMouseout="this.style.backgroundColor='<?echo $bg_color;?>'" class=menu style="border:0px solid;border-right:1px solid;border-color:<?echo $menu_border;?>" width=100% ><center><a href="index.php?loc=article&start=0">СТАТЬИ</a></td>
    </tr>

    <tr>
        <td class=menu style="border-right:1px solid;border-color:<?echo $menu_border;?>" width=100%><img src="data/1p_bg.gif" style="height:12px"></td>
    </tr>

    <tr>
       <td onMouseover="this.style.backgroundColor='<?echo $menu_border;?>'" onMouseout="this.style.backgroundColor='<?echo $bg_color;?>'" class=menu style="border:0px solid;border-right:1px solid;border-color:<?echo $menu_border;?>" width=100% ><center><a href="index.php?loc=offers&start=0">АКЦИИ</a></td>
    </tr>

    <tr>
        <td class=menu style="border-right:1px solid;border-color:<?echo $menu_border;?>" width=100%><img src="data/1p_bg.gif" style="height:12px"></td>
    </tr>

    <tr>
        <td onMouseover="this.style.backgroundColor='<?echo $menu_border;?>'" onMouseout="this.style.backgroundColor='<?echo $bg_color;?>'" class=menu style="border-bottom:0px solid;border-right:1px solid;border-color:<?echo $menu_border;?>" width=100% ><center><a href="index.php?loc=visitcard">ОБРАТНАЯ СВЯЗЬ</a></td>
    </tr>
    <tr>
        <td class=menu style="border-right:1px solid;border-color:<?echo $menu_border;?>" width=100%><img src="data/1p_bg.gif" style="height:12px"></td>
    </tr>
	<tr>
       
		<td align=center style="border-right:1px solid;border-top:1px solid;border-color:<?echo $menu_border;?>"><br>
<!-- cityhost -->
<a target="_blank" href="http://www.cityhost.com.ua"><img width="88" height="31" border="0" src="http://www.cityhost.com.ua/imgs/buttons/2.gif" alt="Хостинг CityHost.com.ua"></a>
<!-- citycatalog -->
		</td>
		
    </tr>
    <tr>
        <td class=menu style="border-right:1px solid;border-top:0px solid;border-color:<?echo $menu_border;?>" width=100%><img src="data/1p_bg.gif" style="height:12px"></td>
    </tr>
   	<tr>
        
		<td class=name style="border-top:1px solid;border-bottom:1px solid;border-right:1px solid;border-color:<?echo $menu_border;?>" >
	<br>
    <form name=aut method=post action="index.php?loc=register.php">
    <input type=text name=login class=input style="width:100px">
    <br><input type=password name=pas class=input style="width:100px">
    <br><input type=submit value="Вход" class=input style="width:100px">
    </form>
		</td>
		
    </tr>
	
    <tr bgcolor=<?echo $head;?>>
		
        <td class=white style="border-bottom:1px solid;border-color:<? echo $menu_border;?>">
		<p><p><!-- Ukrainian Banner Network 100х200 START -->
<center><script>
//<!--
user = "33224";
page = "1";
pid = Math.round((Math.random() * (10000000 - 1)));
document.write("<iframe src='http://banner.kiev.ua/cgi-bin/bi.cgi?h" +
user + "&amp;"+ pid + "&amp;" + page + "&amp;7' frameborder=0 vspace=0 hspace=0 " +
" width=100 height=200 marginwidth=0 marginheight=0 scrolling=no>");
document.write("<a href='http://banner.kiev.ua/cgi-bin/bg.cgi?" +
user + "&amp;"+ pid + "&amp;" + page + "' target=_top>");
document.write("<img border=0 src='http://banner.kiev.ua/" +
"cgi-bin/bi.cgi?i" + user + "&amp;" + pid + "&amp;" + page +
"&amp;7' width=100 height=200 alt='Ukrainian Banner Network'></a>");
document.write("</iframe>");
//-->
</script><br><br>
</center>
<!-- Ukrainian Banner Network 100х200 END -->

		</td>
		
    </tr>
	
    <tr bgcolor=<?echo $head;?>>
        
		<td class=white align=center style="border-bottom:0px solid;border-color:<? echo $menu_border;?>">
<a href=http://banner.kiev.ua/ target=_top>Украинская Баннерная Сеть</a>
		</td>
		
    </tr>
	
    </table>
	
        </TD>
    <TD vAlign=top cellspacing="10" width=100%>

    <TABLE cellSpacing=0 cellPadding=0 width=100% border=0>
        <TBODY>
        <TR>
          <td>
          <table width=100% cellpadding=0 cellspacing=0>
          <tr>
          <td>
		  
		  </td>
          <TD width=100% class=name style="border-top:2px solid;border-color:<?echo $menu_border;?>" background="data/bggradient.gif" align=middle bgcolor=<? echo $head;?>>
          
          <?
switch ($loc) {
      case "":
                              ?><h1>НОВОСТИ САЙТА</h1><?;break;

      case ("admin"):
                              ?><B>ПАНЕЛЬ УПРАВЛЕНИЯ | Главная</B><?;break;
      case ("view_log"):
                              ?><B>ПАНЕЛЬ УПРАВЛЕНИЯ | Log file</B><?;break;
      case ("contacts_edit"):
                              ?><B>ПАНЕЛЬ УПРАВЛЕНИЯ | Редактирование контактной информации</B><?;break;
      case "letters_viewer":
                              ?><B>ПАНЕЛЬ УПРАВЛЕНИЯ | Просмотр писем</B><?;break;
      case "view_letter":
                              ?><B>ПАНЕЛЬ УПРАВЛЕНИЯ | Просмотр письма</B><?;break;
      case "price":
                              ?><h2>ПРАЙС</h2><?;break;
      case "voting":
                                ?><h1>ОПРОС</h1><?;break;
      case "article":
                                 if (!(isset($_GET['id']))) {?><h1>СТАТЬИ</h1><?;}
									else {?><h2>СТАТЬИ</h2><?};
			break;
      case "trade":
                                 if (!(isset($_GET['id']))) {?><h1>ТОВАРЫ</h1><?;}
									else {?><h2>ТОВАРЫ</h2><?};
			break;
      case "offers":
                                ?><h1>АКЦИИ И СПЕЦ. ПРЕДЛОЖЕНИЯ</h1><?;break;
      case "visitcard":
                                ?><h1>ОБРАТНАЯ СВЯЗЬ</h1><?;break;      
	case "search":
                                ?><h1>ШИНОМОНТАЖНЫЙ ПОИСК</h1><?;break;
      }
      ?>
          
          </TD>
          <td></td>
          </tr>
          </table>
          </td>
        </TR>
<tr>
        <td style="border:1px solid;border-top:0px;border-color:<?echo $menu_border;?>">
<?
if ($loc == "trade") {
echo $delivery_conditions;
}
info();
?>
        </td>
        </tr>
</table>  
<?
if ($loc == 'search')
{
?>  
<script type="text/javascript">
  google.load('search', '1');
  google.setOnLoadCallback(function() {
    google.search.CustomSearchControl.attachAutoCompletion(
      'partner-pub-2376196472925865:17qnj7915o3',
      document.getElementById('q'),
      'cse-search-box');
  });
</script>
<form action="http://tiptop.dn.ua/?loc=search" id="cse-search-box">
  <p>Поиск по сайту и его партнерам</p>
  <div>
    <input type="hidden" name="cx" value="partner-pub-2376196472925865:17qnj7915o3" />
    <input type="hidden" name="cof" value="FORID:9" />
    <input type="hidden" name="ie" value="windows-1251" />
	<input type="hidden" name="loc" value="search" />
    <input type="text" class="wide" name="q" id="q" autocomplete="off" size="45" value="<?echo $_GET['q']?>"/>
    <input type="submit" class="submit" name="sa" value="&#x041f;&#x043e;&#x0438;&#x0441;&#x043a;" />
  </div>
</form>
<script type="text/javascript" src="http://www.google.com.ua/cse/brand?form=cse-search-box&amp;lang=ru"></script> 		
<?
}
?>
    <!-- news-->

      <?
      #if ($$cookie_name and $$cookie_name!="have_gone^^^^") {include("aut.php");}
      include("aut.php");
      if (!$loc) {
      $loc = "";
      }
      switch ($loc) {
      case "":
                              include("news.php");break;
      case "view_log":
                              include("view_log.php");break;
      case "contacts_edit":
                              if(isset($_POST['address_n'])) $address_n = $_POST['address_n'];
							  if(isset($_POST['phone_n'])) $phone_n = $_POST['phone_n'];
							  if(isset($_POST['mobile_n'])) $mobile_n = $_POST['mobile_n'];
							  if(isset($_POST['mail_n'])) $mail_n = $_POST['mail_n'];
							  include("contacts_edit.php");break;
      case "search":
							include('search.php');
							break;
	  case "admin":

                              include("admin.php");break;
      case "price":
                              include("price.php");break;
      case "register.php":      ?>
                <center>
                                <span class="text_black">
                                <BIG><B><? echo $string;?></b><BIG>
                                <br><span class=red>
                                        <!-- <a href="index.php?loc=forum&hrefrand=<? echo rand(1,9999999999);?>">
                                        <a href="browser.history.go(-1)">
                                        Назад
                                        </a></span> -->
                                <?;break;
      case "messages":
                              #include("aut.php");
                              main_history();include("forum/messages.php");break;
      case "forum":
                              include("partners.php");#include("aut.php");
                              main_history();include("forum/index.php");break;
      case "topics":
                              #include("aut.php");
                              main_history();include("forum/theme.php");break;
      case "voting":
                                include("voting.php");break;
      case "article":
                                 include("production.php");break;
      case "trade":
                                 include("production.php");break;
      case "offers":
                                include("offer.php");break;
      case "visitcard":
                                include("visitcard.php");break;
      case "letters_viewer":
                                include("letters_viewer.php");break;
      case "view_letter":
                                include("view_letter.php");break;
      }
      ?>
<!-- end of news -->
    </TD>
    <TD  vAlign=top>
<?
#rightmenu(1);
?>
<table width=100% cellspacing=0 cellpadding=0 style="border-bottom:1px solid;border-color:<? echo $head;?>">
<tr>
        <td width=100%>
        <table cellpadding=0 cellspacing=0 width=100%>
        <tr>
                <td></td><td width=100% style="border-top:1px solid;border-color:<?echo $menu_border;?>" background="data/bggradient.gif" class=name><b><center>ПАРТНЕРЫ</td>
        </tr>
        </table>
        </td>
</tr>

<! -- special offer -->
<?
/*
 $i = 0;
$handle = opendir("data/");
while($file = readdir($handle))
{
  if ($file != '.' && $file != '..')
  {
    $file = explode(".",$file);
    if ($file[1] == "swf"){
    $offer[$i] = $file[0].".".$file[1];#echo $offer[$i]."<br>";
# увелич. частоту повторений последнего предлож.
    if ($file[0] == "clip3") {
    $i++;
    $offer[$i] = $file[0].".".$file[1];#echo $offer[$i]."<br>";
    }
    $i++;
  }
  }
}
$clip = rand(0,sizeof($offer)-1);
#echo $clip; echo sizeof($offer);echo $offer[0];
*/

?>
<tr>
	<td width=100% vAlign=center style="border-left:1px solid;border-bottom:1px solid;border-color:<?echo $menu_border;?>"><center>
<?
if ($loc != 'search')
{
?>		
		<!-- google search -->
<script type="text/javascript" src="http://www.google.com/jsapi"></script>
<script type="text/javascript">
  google.load('search', '1');
  google.setOnLoadCallback(function() {
    google.search.CustomSearchControl.attachAutoCompletion(
      'partner-pub-2376196472925865:17qnj7915o3',
      document.getElementById('q'),
      'cse-search-box');
  });
</script>
<form action="http://tiptop.dn.ua/?loc=search" id="cse-search-box">
  <div>
    <input type="hidden" name="cx" value="partner-pub-2376196472925865:17qnj7915o3" />
    <input type="hidden" name="cof" value="FORID:9" />
    <input type="hidden" name="ie" value="windows-1251" />
	<input type="hidden" name="loc" value="search" />
    <input type="text" name="q" id="q" autocomplete="off" size="17" />
    <input type="submit" name="sa" value="&#x041f;&#x043e;&#x0438;&#x0441;&#x043a;" />
  </div>
</form>
<script type="text/javascript" src="http://www.google.com.ua/cse/brand?form=cse-search-box&amp;lang=ru"></script> 		
<?
}
?>
<?
include("banners.php");// ipm.dn.ua
?>
    </td>
</tr>
<?

?>
<tr>
	<td width=100% bgcolor=<?echo $head;?> style="border-left:0px solid;border-bottom:1px solid;border-color:<?echo $menu_border;?>">
<?
include("price_download.php");
?>
    </td>
</tr>

<tr>
	<td width=100% bgcolor=<?echo $head;?> style="border-left:0px solid;border-bottom:0px solid;border-color:<?echo $menu_border;?>">
<?
include("Adsense.html");
?>
    </td>
</tr>

<tr>
        <td bgcolor=<?echo $head;?> style="border-top:1px solid;border-bottom:0px solid;border-color:<?echo $menu_border;?>">
		<center>
<span class=white><a href="index.php?loc=visitcard">Реклама на сайте</a></span>
        </td>
</tr>

<tr>
        <td>
		<!-- yandex search 
<div class="yandexform" onclick="return {type: 3, logo: 'rb', arrow: true, webopt: false, websearch: false, bg: '#F3F1F1', fg: '#FFFF00', fontsize: 11, suggest: true, encoding: ''}"><form action="http://yandex.ru/sitesearch" method="get"><input type="hidden" name="searchid" value="148907"/><input name="text"/><input type="submit" value="Найти"/></form></div><script type="text/javascript" src="http://site.yandex.net/load/form/1/form.js" charset="utf-8"></script>
-->		

		</td>
</tr>

</table>
    </TD>
  </TR>
  <TR>
    <TD colSpan=3 valign=center><!-- sponsors -->
    <table cellspacing=0 cellpadding=0 width=100%>
    <tr>
        <td background="files/ban_bg.gif" width=170>
<!-- BEGIN OF MyTOP CODE v5.3 -->
<script language="javascript">//<!--
mtI="020405145315";mtG="45";mtT="8";mtS='http://c.mystat-in.net/';mtD=document;
mtN=navigator.appName;mtR=escape(mtD.referrer);mtW="";mtC="";mtV="0";mtJ="1";
//--></script><script language="javascript1.1">//<!--
mtV="1";mtJ = (navigator.javaEnabled()?"1":"0");
//--></script><script language="javascript1.2">//<!--
mtC=screen;mtW=mtC.width;mtN!="Netscape"?mtC=mtC.colorDepth:mtC=mtM.pixelDepth;mtV="2";
//--></script><script language="javascript1.3">//<!--
mtV="3";
//--></script><script language="javascript">//<!--
mtUrl="";mtUrl+="\""+mtS+"i"+mtI+"&t"+mtT+"&g"+mtG+"&w"+mtW+"&c"+mtC+"&r"+mtR+"&v"+mtV+"&j"+mtJ+"\"";
mtUrl="<a href=http://mytop-in.net/ target=_blank><img src="+mtUrl+" width=81 height=63 border=0 alt=\"Rated by MyTOP\"></a>";
mtD.write(mtUrl);
//--></script>
<!--begin of Top100-->
<a href="http://top100.rambler.ru/top100/">
<img src="http://counter.rambler.ru/top100.cnt?702358" alt="Rambler's Top100" width=81 height=63 border=0></a>
<!--end of Top100 code-->
<!-- COUNTER -->
        </td>
        <td width=1>
<img src="files/ban_1.gif">
        </td>
        <td class=text_black valign=bottom background="files/bg.gif">
        <center>

        <? include("text_menu.php");?>
        </center>

        </td>
		<td width=0 class=text_black valign=middle background="files/bg.gif">

		<?
		#include("partners.php");
		?>
		</td>
</tr>
</table><!-- sponsors -->
        </TD>
    </TR></TBODY>
</TABLE>
</CENTER>

</BODY>
</HTML>
