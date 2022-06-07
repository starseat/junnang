<?php

include('../admin/action/common.php');
include('../admin/action/db_conn.php');

header('Content-Type: text/html; charset=UTF-8');

$result_array = array();

$httpMethod = $_SERVER["REQUEST_METHOD"];
if ($httpMethod != 'POST') {
    $result_array['message'] = '잘못된 요청입니다.';
    $result_array['result'] = false;

    echo json_encode($result_array, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
    mysqli_close($conn);
    flush();
    exit;
}

$saveName = urldecode(strip_tags($_POST['name']));
$saveHp = strip_tags($_POST['hp']);
$saveContent = urldecode(strip_tags($_POST['content']));

// if (!function_exists('duplicationPostCheck')) {
//     function duplicationPostCheck($expireTime = 0)
//     { //초
//         if (isset($_POST)) {
//             $PostSerialize = serialize($_POST);
//             if (isset($_SESSION['postHistory']) && is_array($_SESSION['postHistory'])
//             ) {
//                 $sKey = array_search($PostSerialize, $_SESSION['postHistory']);
//                 if ($sKey !== FALSE
//                 ) {
//                     if ($sKey >= (time() - $expireTime)) {
//                         return true;
//                     }
//                 }
//             }
//             $_SESSION['postHistory'][time()] = $PostSerialize;
//         }
//         return false;
//     }
// }

function duplicationPostCheck($expireTime = 0) { //초
    if (isset($_POST)) {
        $PostSerialize = serialize($_POST);
        if (
            isset($_SESSION['postHistory']) && is_array($_SESSION['postHistory'])
        ) {
            $sKey = array_search($PostSerialize, $_SESSION['postHistory']);
            if (
                $sKey !== FALSE
            ) {
                if ($sKey >= (time() - $expireTime)) {
                    return true;
                }
            }
        }
        $_SESSION['postHistory'][time()] = $PostSerialize;
    }
    return false;
}

######################################################################################################################################################
## check - 이름
if (empty($saveName)) {
    $result_array['message'] = '정확한 이름을 입력해 주세요.';
    $result_array['result'] = false;

    echo json_encode($result_array, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
    mysqli_close($conn);
    flush();
    exit;
}

######################################################################################################################################################
## check - 연락처
$saveHp = str_replace('-', '', preg_replace('/\s+/', '', iconv("utf-8", "euc-kr", $saveHp)));
// $pattern = "/^(01[016789]{1}|02|0[3-9]{1}[0-9]{1})-?[0-9]{3,4}-?[0-9]{4}$/";
$pattern = "/^(01[016789]{1}|02|0[3-9]{1}[0-9]{1})?[0-9]{3,4}?[0-9]{4}$/";
$hp_check = (preg_match($pattern, $saveHp)) ? true : false;
if (!$hp_check) {
    $result_array['message'] = '정확한 전화번호를 입력해주세요.';
    $result_array['result'] = false;

    echo json_encode($result_array, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
    mysqli_close($conn);
    flush();
    exit;
}

######################################################################################################################################################
## check - 문의 내용
if (empty($saveContent)) {
    $result_array['message'] = '문의내용이 입력되지 않았습니다.';
    $result_array['result'] = false;

    echo json_encode($result_array, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
    mysqli_close($conn);
    flush();
    exit;
}

if (mb_strlen($saveContent, 'utf-8') > 100) {
    $result_array['message'] = '문의내용은 최대 100 글자 까지 입력 가능합니다.';
    $result_array['result'] = false;

    echo json_encode($result_array, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
    mysqli_close($conn);
    flush();
    exit;
}

######################################################################################################################################################
## check - 등록 시간
$postExpire = (60); //중복 처리 불가능한 시간(초)
if (duplicationPostCheck($postExpire)) {
    $result_array['message'] = '이미 처리된 요청 일 수 있습니다.\\n1분 뒤에 다시 시도해주세요.';
    $result_array['result'] = false;

    echo json_encode($result_array, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
    mysqli_close($conn);
    flush();
    exit;
}


$sql = "
    INSERT INTO inquiries (name, hp, content)
    VALUES ("
    . "'" . $saveName . "', "
    . "'" . $saveHp . "', "
    . "'" . $saveContent . "')";
// viewAlert($sql);
$result = mysqli_query($conn, $sql) or exit(mysqli_error($conn));

$result_array['message'] = '등록되었습니다.';
$result_array['result'] = true;

echo json_encode($result_array, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);

mysqli_close($conn);
flush();

?>
