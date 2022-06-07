<?php

include('./common.php');

header('Content-Type: text/html; charset=UTF-8');

$input_pwd = '1234';

$enc_pwd = password_encrypt($input_pwd);

echo 'input_pwd: ' . $input_pwd;
echo '<br>';
echo 'enc_pwd: ' . $enc_pwd;

flush();

?>
