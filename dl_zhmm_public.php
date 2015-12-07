<?php if (!defined('SYSTEM_ROOT')) { die('Insufficient Permissions'); }
loadhead();
?>

<?php
global $m;
if(isset($_REQUEST['page']) && $_REQUEST['page']=='yz'){
$mail = !empty($_POST['mail']) ? ( checkMail($_POST['mail']) ? $_POST['mail'] : ReDirect('index.php?pub_plugin=dl_zhmm&error_msg=邮箱地址不合法，请重新输入') ) : ReDirect('index.php?pub_plugin=dl_zhmm&error_msg=邮箱地址为空，请重新输入');
$cx = $m->query("SELECT * FROM  `".DB_NAME."`.`".DB_PREFIX."users` WHERE email = '{$mail}' LIMIT 1");
$p = $m->fetch_array($cx);
if($p==""){ReDirect(SYSTEM_URL.'index.php?pub_plugin=dl_zhmm&error_msg=错误：未能在本站找到持有该邮箱的用户！');die();}
$pw=sha1(md5(EncodePwd($p['pw'] . date('Ymd') . SYSTEM_NAME . SYSTEM_VER . SYSTEM_URL)));
$title=strip_tags(SYSTEM_NAME) . " - 找回密码";
$text="请点击以下链接重置密码：".SYSTEM_URL."index.php?pub_plugin=dl_zhmm".'&page=yjqr'.'&email='.base64_encode($mail).'&key='.$pw;
$x=misc::mail($mail,$title,$text);
if($x != true){
	ReDirect(SYSTEM_URL.'index.php?pub_plugin=dl_zhmm&error_msg=错误：找回密码邮件发送失败，请检查邮件相关设置！');
	}
else{
	ReDirect(SYSTEM_URL.'index.php?pub_plugin=dl_zhmm&success_msg=成功：邮件发送成功，请登录邮箱按照提示操作！');
	}
}
?>
<?php
if(isset($_GET['xg'])){
	global $m;
$emailcc = !empty($_REQUEST['email']) ? base64_decode($_REQUEST['email']) : msg('警告：邮件地址无效');
$email   = checkMail($emailcc) ? sqladds($emailcc) : msg('警告：非法操作');
$key=$_REQUEST['key'];
$newpw=EncodePwd($_POST['pw']);
$cx = $m->query("SELECT * FROM  `".DB_NAME."`.`".DB_PREFIX."users` WHERE email = '{$email}' LIMIT 1");
$p = $m->fetch_array($cx);
if($p==""){ReDirect(SYSTEM_URL.'index.php?pub_plugin=dl_zhmm&error_msg=错误：未能在本站找到持有该邮箱的用户！');}
$pw=sha1(md5(EncodePwd($p['pw'] . date('Ymd') . SYSTEM_NAME . SYSTEM_VER . SYSTEM_URL)));
if($pw!=$key){
	ReDirect(SYSTEM_URL.'index.php?pub_plugin=dl_zhmm&error_msg=错误：该链接失效或者不归您所拥有，修改密码失败！');
	die();
	}else{	
	$m->query("UPDATE `".DB_NAME."`.`".DB_PREFIX."users` SET `pw` = '".$newpw."' WHERE email = '{$email}'");
	ReDirect(SYSTEM_URL.'index.php?mod=login&error_msg=由于你的密码已修改，无法再使用旧密码登录，请重新登录');
	}
	}
?>
<?php
global $m;
if(isset($_REQUEST['page']) && $_REQUEST['page']=='yjqr'){
$emailcc = !empty($_REQUEST['email']) ? base64_decode($_REQUEST['email']) : msg('警告：邮件地址无效');
$email   = checkMail($emailcc) ? sqladds($emailcc) : msg('警告：非法操作');
$key=$_REQUEST['key'];
$cx = $m->query("SELECT * FROM  `".DB_NAME."`.`".DB_PREFIX."users` WHERE email = '{$email}' LIMIT 1");
$p = $m->fetch_array($cx);
if($p==""){ReDirect(SYSTEM_URL.'index.php?pub_plugin=dl_zhmm&error_msg=错误：未能在本站找到持有该邮箱的用户！');}
$pw=sha1(md5(EncodePwd($p['pw'] . date('Ymd') . SYSTEM_NAME . SYSTEM_VER . SYSTEM_URL)));
if($pw!=$key){
	ReDirect(SYSTEM_URL.'index.php?pub_plugin=dl_zhmm&error_msg=错误：该链接失效或者不归您所拥有，修改密码失败！');
	}else{	
echo '<div class="panel panel-success" style="margin:5% 15% 5% 15%;">
	<div class="panel-heading">
          <h3 class="panel-title">设置新密码</h3>
    </div>
    <div style="margin:0% 5% 5% 5%;">
	<div class="login-top"></div><br/>
	<b>请输入您新密码</b><br/><br/>
  <form name="f" method="post" action="';echo 'index.php?pub_plugin=dl_zhmm&xg&email='.base64_encode($email).'&key='.$key.'">
<div class="input-group">
  <span class="input-group-addon">新密码</span>
  <input type="password" class="form-control" name="pw" id="pw" required>
</div>
	<div class="login-button"><br/>
  <button type="submit" class="btn btn-primary" style="width:100%;float:left;">确认修改</button>
	</div><br/><br/><br/>
	<p>插件作者：<a href="http://www.tbsign.cn" target="_blank">D丶L</a>&nbsp;&nbsp;\\&nbsp;&nbsp;程序作者：<a href="http://zhizhe8.net" target="_blank">无名智者</a></p>
	<div style=" clear:both;"></div>
	<div class="login-ext"></div>
	<div class="login-bottom"></div>
</div>';
die();
		}
	}
?>

<div class="panel panel-success" style="margin:1% 1% 1% 1%;">
	<div class="panel-heading">
          <h3 class="panel-title">找回密码</h3>
    </div>   
    <div style="margin:0% 5% 5% 5%;">
	<div class="login-top"></div><br/>
    <?php 
	if(isset($_GET['success_msg'])){
	  echo '';
	  }else{
		  echo '<b>请输入您的邮箱信息才能找回密码</b><br/><br/>';
		  }
	?>	
  <?php if (isset($_GET['error_msg'])): ?><div class="alert alert-danger alert-dismissable">
  <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
  <?php echo strip_tags($_GET['error_msg']); ?></div><?php endif;?>
  <?php if (isset($_GET['success_msg'])): ?><div class="alert alert-success alert-dismissable">
  <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
  <?php echo strip_tags($_GET['success_msg']); ?></div><?php endif;?>
  <form name="f" method="post" action="<?php echo SYSTEM_URL ?>index.php?pub_plugin=dl_zhmm&page=yz&zhmm">
  <?php 
  if(isset($_GET['success_msg'])){
	  echo '';
	  }
	  else{
		  echo '<div class="input-group">
  <span class="input-group-addon">邮箱</span>
  <input type="email" class="form-control" name="mail" id="mail" required>
</div>
	<div class="login-button"><br/>
  <button type="submit" class="btn btn-primary" style="width:100%;float:left;">立刻找回</button>
	</div><br/><br/><br/>';
	  }
  ?>
    <p>插件作者：<a href="http://www.tbsign.cn" target="_blank">D丶L</a>&nbsp;&nbsp;\\&nbsp;&nbsp;程序作者：<a href="http://zhizhe8.net" target="_blank">无名智者</a></p>
	<div style=" clear:both;"></div>
	<div class="login-ext"></div>
	<div class="login-bottom"></div>
    </div>