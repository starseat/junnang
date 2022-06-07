<?php require_once('fragment/content_layout.php'); ?>

<?php

include('./action/common.php');
include('./action/db_conn.php');

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

?>

<style type="text/css">
    * {
        margin: 0;
        padding: 0;
        text-decoration: none;
        color: #000;
    }

    .qna_view_w {
        position: relative;
        padding-bottom: 70px;
    }

    .qna_view_inner {}

    .qna_info_w {
        overflow: hidden;
        position: relative;
        padding: 10px 15px 20px;
    }

    .qna_info_cont {
        float: left;
    }

    .qna_info_name,
    .qna_info_number {
        display: block;
    }

    .qna_info_number {
        margin-top: 10px;
    }

    .select_list_w {
        margin-top: 10px;
    }

    .select_list {
        border: 1px solid #000;
        font-size: 12px;
        padding: 5px 10px;
    }

    .qna_text_w {
        padding: 20px 0 15px;
        margin: 0 15px;
        position: relative;
        border-top: 3px solid #000;
    }

    .qna_text_w p {
        border: 1px solid #eee;
        padding: 15px;
    }

    .qna_title {
        display: block;
        margin-bottom: 10px;
        font-size: 20px;
        font-weight: 700;
    }

    .qna_date_w {
        display: block;
        position: Absolute;
        right: 15px;
        top: 10px;
        font-size: 12px;
    }

    .qna_date {
        display: inline-block;
        margin-right: 15px;
        color: #888;
    }

    .qna_date2 {
        display: inline-block;
        color: #888;
    }

    .qna_comment_w {
        padding: 15px;
        width: 100%;
        min-height: 300px;
        box-sizing: border-box;
    }

    .qna_comment {
        display: block;
        padding: 15px;
        resize: none;
        border: 1px solid #eee;
        width: 100%;
        height: 230px;
        box-sizing: border-box;
        font-size: 15px;
        line-height: 22px;
    }

    .qna_btn_w {
        position: Absolute;
        right: 15px;
        bottom: 20px;
    }

    .qna_btn {
        display: inline-block;
        margin-left: 10px;
        padding: 7px 10px;
        font-size: 15px;
        font-weight: 700;
        border: 1px solid #000;
        border-radius: 5px;
        text-decoration: none;
        background-color: #fff;
    }

    .qna_btn:hover {
        text-decoration: underline;
    }

    .qna_btn_del {
        border-color: #D61C33;
        color: #D61C33;
    }

    .qna_btn_save {
        border-color: #8cbe0a;
        color: #8cbe0a;
    }

    .select_list {}
</style>

<div class="mt-4 mb-4 container">
    <br><br>
    <div class="qna_view_w">
        <div class="qna_view_inner">
            <div class="qna_info_w">
                <div class="qna_date_w">
                    <span class="qna_date">등록일 : <?= $info['created_at']; ?></span>
                    <span class="qna_date2">수정일 : <?= $info['updated_at']; ?></span>
                </div>
                <div class="qna_info_cont">
                    <span class="qna_info_name">이름 : <?= $info['name']; ?></span>
                    <span class="qna_info_number">연락처 : <?= $info['hp']; ?></span>
                    <div class="select_list_w">
                        <label for="selectStatus">상태 :</label>
                        <input type="hidden" id="savedStatus" value="<?= $info['status']; ?>">
                        <select name="" id="selectStatus" class="select_list">
                            <option value="0">신규 등록</option>
                            <option value="1">처리 중</option>
                            <option value="9">처리 완료</option>
                        </select>
                    </div>
                </div>
            </div>
            <div class="qna_text_w">
                <strong class="qna_title">문의내용</strong>
                <p><?= $info['content']; ?></p>
            </div>
            <div class="qna_comment_w">
                <strong class="qna_title">메모</strong>
                <textarea name="memo" id="memo" class="qna_comment" placeholder="최대 2000자 까지 입력 가능합니다."><?php if(!empty($info['memo'])) { echo $info['memo']; }  ?></textarea>
            </div>
        </div>
        <input type="hidden" id="savedSeq" value="<?= $seq ?>">
        <div class="qna_btn_w">
            <button class="qna_btn qna_btn_del" onclick="doDelete()">삭제하기</button>
            <button class="qna_btn qna_btn_save" onclick="doSave()">저장하기</button>
            <button class="qna_btn qna_btn_list" onclick="doList()">목록으로</button>
        </div>
    </div>
</div>

<?php
// $result->free();
mysqli_close($conn);
flush();
?>

<?php require_once('fragment/footer.php'); ?>

<script src="./js/common.js"></script>
<script src="./js/view.js"></script>

<?php require_once('fragment/tail.php'); ?>