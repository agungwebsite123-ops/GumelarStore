<?php
function esc($s){ return htmlspecialchars($s,ENT_QUOTES|ENT_SUBSTITUTE,'UTF-8'); }
function base_url($p=''){ $s=dirname($_SERVER['SCRIPT_NAME']); $s=($s=='/'||$s=='\\')?'':$s; return rtrim((isset($_SERVER['HTTPS'])?'https':'http').'://'.$_SERVER['HTTP_HOST'].$s.'/'.$p,'/'); }
function is_admin_logged(){ return isset($_SESSION['admin_id']); }
?>