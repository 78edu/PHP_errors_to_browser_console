# PHP_errors_to_browser_console
Adds console.log for your PHP error messages and user debug messages.
<br>
No conflicts with XDebug - you can use both (even when this script looks incomplete and primitive).
But it can show wrong data about dvar_dump( PDO object), seems var_dump works different with var_export in this case.
<br>
No more mess in your HTML output when you have errors or want to watch some variables.
![screenshot](/phpconsolelog.jpg)
<br>
<br>
<br>
This is used only for development, disable it on deploy.

dprint($string)  - works like print, but in your browser console.
<br>
dvar_dump($var) - works like var_dump, but in your browser console.

Please note: dprint and dvar_dump output isn't sent to error_log!
<br>
This functions is only for display in browser with your exact request.

This script is registering an error handler, it will capture all php errors after script include.

How to use:
1.define("DEBUG",true);
<br>
2.require_once(this script) in begining of your index.php
<br>
3.Insert in your HTML output <script>$debug_output</script> before </body></html>
<br>
4.Use dprint and dvar_dump to send messages to console.
<br>
5.If DEBUG constant is not defined, there will be no debug messages.
<br>
6.In production replace dprint and dvar_dump with no operation functions and use display_errors(false)
to ensure that you will not get any errors on client side.
