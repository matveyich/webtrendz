<?php

if(!headers_sent())
session_start();


if($_GET['task']=='join') { $_SESSION['chatuser'] = null; session_unregister('chatuser'); include('join.php'); die(); }

if($_GET['userid']!='') $_SESSION['chatuser'] = $_GET['userid'];


$userid = $_SESSION['chatuser'];
$chatwith = 'all';

if($_GET['action']){
        
        //if(!file_exists('history/'.md5($_GET['chatwith']."***---***".$_GET['userid'])))
        //$file = 'history/'.md5($_GET['userid']."***---***".$_GET['chatwith']);
        //else 
        $file = 'history/'.date('Ymd');//.md5($_GET['chatwith']."***---***".$_GET['userid']);
        
        if(!file_exists($file))
        file_put_contents($file,serialize(Array()));

if($userid==''&&$_GET['action']!='')    die('logoff');
switch($_GET['action']){
    
    
    case  'sendmsg':
       $data = @unserialize(@file_get_contents($file));
       $data[] = Array('sender'=>$_GET['userid'],'to'=>$_GET['chatwith'],'msg'=>$_POST['msg']);
       if(count($data)>200) $data = array_slice($data,count($data)-200);
       @file_put_contents($file, serialize($data));
    break;
    
    case  'reload':
       $data = @unserialize(@file_get_contents($file));        
       foreach($data as $d){
           echo '<fieldset><legend>'.$d['sender'].'</legend> '. $d['msg'].'</fieldset>';
       }
       echo '<span id="end"></span>';
    break;
    
    case "chatwith":
       //$_SESSION[''] 
    break;
    
    case  'logout':
    break;
    
}

die();
}
 
?>
 
<script language="JavaScript" src="wp-content/plugins/wordpress-shout-box-chat/jquery.js"></script>
<script language="JavaScript" src="wp-content/plugins/wordpress-shout-box-chat/jScrollPane-1.2.3.min.js"></script>
<script language="JavaScript">
<!--
  var ahm = jQuery.noConflict();
 ahm(function()
            {
                // this initialises the demo scollpanes on the page.
                ahm('#msgs').jScrollPane();
            });
               

//-->
</script>
<div id="chatmain">
<div id="chatboard">
<?php if($userid){ ?>
<div id="ctitle">Logged in as <b><?php echo $userid; ?></b> <a href="#"  onclick="Join();return false;"><img align="right" src="wp-content/plugins/wordpress-shout-box-chat/images/exit.png" id="btn" value="x" title="Logout"/></div>
<?php } ?>
<div id="carea">
<?php
if($userid==''){
    include("join.php");
}

else {
    
?>
  



<table width="100%" border="0" cellpadding="0" cellspacing="0" id="cw">
<tr><td align="center" valign="middle">
<div id="msgs" style="overflow:auto;text-align:left;height:200px">



</div>
</td>
</tr>
<tr><td align="left" valign="middle" style="border-top:1px solid #444444">
<form method="post" onsubmit="return frmSubmit()">
<input style="width:80%;font-size:8pt;border:0px;background:url(wp-content/plugins/wordpress-shout-box-chat/images/write.png) left center no-repeat;padding-left:20px;" id="msg" type="text" name="chat_nick" />
<!--<input type="image" src="wp-content/plugins/wordpress-shout-box-chat/images/go.png" id="btn" value="&#187;"/>-->
</form>
</td></tr>
</table>

<script language="JavaScript">
<!--
  var reload = 1;
  function frmSubmit(){
      msg = ahm('#msg').val();
      ahm('#msg').val('please wait...');
      ahm('#msgs').html(ahm('#msgs').html()+'<fieldset><legend><?php echo $userid?></legend> '+msg+'</fieldset>');        
      ahm.post('wp-content/plugins/wordpress-shout-box-chat/chat.php?action=sendmsg&userid=<?php echo $userid?>&chatwith=<?php echo $chatwith; ?>',{msg:msg},function(data){         
          //ahm('#msgs').html(data);     
          if(data=='logoff') return Join();   
          var objDiv = document.getElementById("msgs");
           objDiv.scrollTop = objDiv.scrollHeight;
          ahm('#msg').val('');
      });
      return false;
  }
  
  function reloadchat(){
      if(reload==0) return;
      ahm.get('wp-content/plugins/wordpress-shout-box-chat/chat.php?action=reload&userid=<?php echo $userid?>&chatwith=<?php echo $chatwith; ?>',function(data){         
          if(data=='logoff') return Join();
          ahm('#msgs').html(data);                  
          ahm('#uc').html(data);            
          ahm('#msgs').jScrollPane();
          jQuery("#msgs")[0].scrollTo('#end');
          
      });
      //var objDiv = document.getElementById("msgs");
      //objDiv.scrollTop = objDiv.scrollHeight;
      setTimeout("reloadchat()",3000);
  }
  
   
  
  function ChatWith(user){
     ahm.get('wp-content/plugins/wordpress-shout-box-chat/chat.php?action=chatwith&userid=<?php echo $userid?>&chatwith='+user,function(data){         
          ahm('#title').html(data);                            
      }); 
  }
  
  function Join(){
      reload = 0;
      ahm.get('wp-content/plugins/wordpress-shout-box-chat/chat.php?task=join',function(res){
          ahm('#chatboard').html(res);
      });
  }
  
  reloadchat();
//-->
</script>

<?php } ?> 

 </div>
 </div>
 </div>

