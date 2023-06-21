<?php
if ( basename( $_SERVER['PHP_SELF'] ) == basename(__FILE__) ) { die ("403 Forbidden"); }

define('E_FATAL',  E_ERROR | E_USER_ERROR | E_PARSE | E_CORE_ERROR | E_COMPILE_ERROR | E_RECOVERABLE_ERROR);

register_shutdown_function('shut');
set_error_handler("handler");

ini_set('error_log', DIR_LOGS . "paymee.log");
ini_set('log_errors', 1);
ini_set('display_errors', 1);
ini_set("date.timezone", "America/Sao_Paulo");

function shut() {
    $error = error_get_last();
    if ($error && ($error['type'] & E_FATAL)) {
        handler($error['type'], $error['message'], $error['file'], $error['line']);
    }
}

function handler($errtype, $errmessage, $errfile, $errline) {
    $errors = array(
        E_ERROR => 'ERROR',
        E_WARNING => 'WARNING',
        E_PARSE => 'PARSING ERROR',
        E_NOTICE => 'RUNTIME NOTICE',
        E_CORE_ERROR => 'CORE ERROR',
        E_CORE_WARNING => 'CORE WARNING',
        E_COMPILE_ERROR => 'COMPILE ERROR',
        E_COMPILE_WARNING => 'COMPILE WARNING',
        E_USER_ERROR => 'USER ERROR',
        E_USER_WARNING => 'USER WARNING',
        E_USER_NOTICE => 'USER NOTICE',
        E_STRICT => 'RUNTIME NOTICE',
        E_RECOVERABLE_ERROR => 'CATCHABLE FATAL ERROR'
    );

    $message = "Erro: " . $errtype . " " . $errors[$errtype] . "\n";
    $message .= "Registrado em: " . date("d/m/Y H:i:s (T)") . "\n";
    $message .= "No arquivo: " . $errfile . " (Linha: " . $errline .")\n";
    $message .= "Com a mensagem: " . "\n" . $errmessage . "\n\n";

    error_log($message, 3, DIR_LOGS . "paymee.log");
    exit();
}