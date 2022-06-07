<?php

// 로그인 체크
include('./login_check.php');

include('./common.php');
include('./db_conn.php');

header('Content-Type: text/html; charset=UTF-8');

$seq = 0;
$is_access = false;
if ($_SERVER['QUERY_STRING'] != '') {
    $seq = $_GET['seq'];
    if (!isEmpty($seq) && is_numeric($seq)) {
        $is_access = true;
    }
}

if (!$is_access) {
    viewAlert('잘못된 접근 입니다.');
    mysqli_close($conn);
    flush();
    //historyBack();
    echo ('<meta http-equiv="refresh" content="0 url=./index.php" />');
    exit;
}

$seq = intval(mysqli_real_escape_string($conn, $seq));

$sql = "SELECT * FROM inquiries WHERE seq = $seq AND deleted_at IS NULL";
$result = mysqli_query($conn, $sql) or exit(mysqli_error($conn));
$info = $result->fetch_array();

$result->free();

$result_array['data'] = $info;
$result_array['result'] = true;

mysqli_close($conn);
flush();

echo json_encode($result_array, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);

?>