<?php if (!defined('SYSTEM_ROOT')) { die('Insufficient Permissions'); } 
/*
Plugin Name: 找回密码
Version: 1.1
Plugin URL: http://www.tbsign.cn
Description: 用户可以使用此插件找回密码
Author: D丶L
Author Email: wuyao@jt371.cn
Author URL: http://tbsign.cn
For: V3.8+
*/
function dl_zhmm_navi() {
	echo '<li ';
	if(isset($_GET['pub_plugin']) && $_GET['pub_plugin'] == 'dl_zhmm') { echo 'class="active"'; }
	echo '><a href="index.php?pub_plugin=dl_zhmm"><span class="glyphicon glyphicon-search"></span> 找回密码</a></li>';
}

addAction('navi_10','dl_zhmm_navi');
addAction('navi_11','dl_zhmm_navi');
?>