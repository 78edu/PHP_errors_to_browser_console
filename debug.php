<?php
/*
PHP_errors_to_browser_console v3 

No more mess in your HTML output when you have errors or want to watch some variables.
This is used only for development, disable it on deploy.

dprint($string)  - works like print, but in your browser console.
dvar_dump($var) - works like var_dump, but in your browser console.

Please note: dprint and dvar_dump output isn't sent to error_log!
This functions is only for display in browser with your exact request.

This script is registering an error handler, it will capture all php errors after script include.

How to use:
1.define("DEBUG",true);
2.require_once(this script) in begining of your index.php
3.Insert in your HTML output <script>$debug_output</script> before </body></html>
4.Use dprint and dvar_dump to send messages to console.
5.If DEBUG constant is not defined, there will be no debug messages.
6.In production replace dprint and dvar_dump with no operation functions and use display_errors(false)
to ensure that you will not get any errors on client side.
*/

$debug_out="";

if ((defined('DEBUG'))===true)
{
//Регистрация собственного обработчика ошибок
register_shutdown_function(function() {
   $last_error = error_get_last();
   if(!is_null($last_error) && $last_error['type'] === E_ERROR) {
       global $debug_out;
//$debug_out.=PHP_EOL.var_export($last_error,true).PHP_EOL ;
derror([$errno,$errstr,$errfile,$errline]);
   }
});
function myErrorHandler($errno, $errstr, $errfile, $errline)
{
	
	//global $debug_out;
	
    if (!(error_reporting() & $errno)) {
        // Этот код ошибки не включён в error_reporting,
        // так что пусть обрабатываются стандартным обработчиком ошибок PHP
        return false;
    }

    // может потребоваться экранирование $errstr:
    $errstr = htmlspecialchars($errstr);
derror([$errno,$errstr,$errfile,$errline]);
}
$old_error_handler = set_error_handler("myErrorHandler");
}
//Конец регистрации обработчика ошибок^^


function dprint($str){
if ((defined('DEBUG'))===true)
{
global $debug_out;

//backtrace блок:
{
$class="";$file="";$func="";$line="";
$origin=debug_backtrace();
$or1=current($origin);
//var_dump($class.$func);
//if (!isset($class))
//{$func=}
//$class="";$func="";$file="";$line="";
$file=basename($or1["file"]);
$line=$or1["line"];
$or2=end($origin);
if (isset($or2["class"]))
{$class=$or2["class"];}
$func=$or2["function"];
//var_dump($origin);
$origin=$file.'('.$line.') '.$class.'::'.$func;
//echo($file.'('.$line.') '.$class.'::'.$func);
//echo('<hr>');
}
//backtrace блок^^

$msg="%c".$origin.':'.PHP_EOL."%c".$str;

$msg=str_replace("\\",'/',$msg);
$msg=str_replace("\/","f/",$msg);
//$msg=str_replace(",","",$msg);

$msg=str_replace("'","\'",$msg);
$msg=str_replace('"','\"',$msg);
$msg=str_replace("\n",'\\n',$msg);
$msg=str_replace("\r","\\r",$msg);

$debug_out.="console.log('".$msg."','font-size:0.9em;','background:black;color:white;font-weight:bold;font-size:1.2em');".PHP_EOL;
}

}

function dvar_dump($var){

if ((defined('DEBUG'))===true)
{
global $debug_out;
$str=var_export($var,true);

//backtrace блок:
{
$class="";$file="";$func="";$line="";
$origin=debug_backtrace();
$or1=current($origin);
//var_dump($class.$func);
//if (!isset($class))
//{$func=}
//$class="";$func="";$file="";$line="";
$file=basename($or1["file"]);
$line=$or1["line"];
$or2=end($origin);
if (isset($or2["class"]))
{$class=$or2["class"];}
$func=$or2["function"];
//var_dump($origin);
$origin=$file.'('.$line.') '.$class.'::'.$func;
//echo($file.'('.$line.') '.$class.'::'.$func);
//echo('<hr>');
}
//backtrace блок^^

$msg="%c".$origin.':'.PHP_EOL."%c".$str;

$msg=str_replace("\\",'/',$msg);
$msg=str_replace("\/","f/",$msg);
//$msg=str_replace(",","",$msg);

$msg=str_replace("'","\'",$msg);
$msg=str_replace('"','\"',$msg);
$msg=str_replace("\n",'\\n',$msg);
$msg=str_replace("\r","\\r",$msg);
//$msg=addcslashes($msg,'\n','\r','\"',"\'");

$debug_out.="console.log('".$msg."','font-size:0.9em;','background:black;color:white;font-weight:bold;font-size:1.2em');".PHP_EOL;

}

}

function derror($var){

if ((defined('DEBUG'))===true)
{
$code='';
$mesg='';
$file='';
$line='';
global $debug_out;
$str=var_export($var,true);

$code=$var[0];
$mask=$code;
switch ($code){
	
case 1:
$code='E_ERROR';
break;	
case 2:
$code='E_WARNING';
break;
case 4:
$code='E_PARSE';
break;	
case 8:
$code='E_NOTICE';
break;	
case 16:
$code='E_CORE_ERROR';
break;	
case 32:
$code='E_CORE_WARNING';
break;	
case 64:
$code='E_COMPILE_ERROR';
break;	
case 128:
$code='E_COMPILE_WARNING';
break;
case 256:
$code='E_USER_ERROR';
break;	
case 512:
$code='E_USER_WARNING';
break;	
case 1024:
$code='E_USER_NOTICE';
break;	
case 2048:
$code='E_STRICT';
break;	
case 4096:
$code='E_RECOVERABLE_ERROR';
break;	
case 8192:
$code='E_DEPRECATED';
break;
case 16384:
$code='E_USER_DEPRECATED';
break;	
case 32767:
$code='E_ALL';
break;	

}

$mesg=$var[1];
$file=$var[2];
$line=$var[3];


//$msg="***PHP ERROR".':'.PHP_EOL.'%c'.$str;
$msg="***PHP ERROR, CODE".':'.$mask.PHP_EOL.'%c'.$code.' '.$mesg.' in:'.$file.' line:'.$line;


$msg=str_replace("\\",'/',$msg);
$msg=str_replace("\/","f/",$msg);
//$msg=str_replace(",","",$msg);

$msg=str_replace("'","\'",$msg);
$msg=str_replace('"','\"',$msg);
$msg=str_replace("\n",'\\n',$msg);
$msg=str_replace("\r","\\r",$msg);
//$msg=addcslashes($msg,'\n','\r','\"',"\'");

$debug_out.="console.error('".$msg."','color:red;font-weight:bold;font-size:1.2em');".PHP_EOL;
}

}
?>
