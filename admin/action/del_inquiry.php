<?php

// 로그인 체크
include('./login_check.php');

include('./common.php');
include('./db_conn.php');

header('Content-Type: text/html; charset=UTF-8');

$seq = intval(mysqli_real_escape_string($conn, $_POST['seq']));
$sql  = "UPDATE inquiries SET deleted_at = now() WHERE seq = " . $seq;

$message = '문의내용이 삭제되었습니다.';

$result = mysqli_query($conn, $sql) or exit(mysqli_error($conn));

$result_array['message'] = $message;
$result_array['result'] = true;

mysqli_close($conn);
flush();

echo json_encode($result_array, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);

?>