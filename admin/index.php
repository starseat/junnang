<?php require_once('fragment/content_layout.php'); ?>

<?php

include('./action/common.php');
include('./action/db_conn.php');

// 게시굴 수
$item_row_count = 10;
// 하단 페이지 block 수 (1, 2, 3, 4, ...  이런거)
$page_block_count = 10;

$sql = "SELECT COUNT(*) FROM inquiries WHERE deleted_at IS NULL ORDER BY created_at DESC";
$result = mysqli_query($conn, $sql) or exit(mysqli_error($conn));
$total_count = mysqli_fetch_array($result);
$total_count = intval($total_count[0]);
$result->free();

// 현재 페이지
$page = isset($_GET['page']) ? trim($_GET['page']) : 1;

$paging_info = getPagingInfo($page, $total_count, $item_row_count, $page_block_count);

?>

<style>
    .table-hover-pointer tbody tr:hover {
        cursor: pointer;
    }

    .page-link-dark {
        color: #343a40;
    }

    .page-item.active-dark .page-link {
        z-index: 3;
        color: white;
        background-color: #343a40;
        border-color: #343a40
    }

    .table-hover-pointer th,
    .table-hover-pointer td {
        text-align: center;
    }
</style>

<h1 class="mt-4">문의 목록</h1>

<div class="mt-4 mb-4 container">
    <!-- <div class="m-4 d-flex justify-content-end">
        <div class="row"><button type="button" class="btn btn-secondary" onclick="printExcel()">엑셀 출력</button></div>
    </div> -->

    <table class="table table-hover table-hover-pointer">
        <colgroup>
            <col width="12%" />
            <col width="26%" />
            <col width="26%" />
            <col width="14%" />
            <col width="22%" />
        </colgroup>
        <thead class="thead-dark">
            <tr>
                <th scope="col">no</th>
                <th scope="col">이름</th>
                <th scope="col">연락처</th>
                <th scope="col">문의 상태</th>
                <th scope="col">등록일시</th>
            </tr>
        </thead>
        <tbody>
            <?php

            $sql  = "SELECT seq, name, hp, status, created_at FROM inquiries WHERE deleted_at IS NULL ORDER BY created_at DESC LIMIT " . $paging_info['page_db'] . ", $item_row_count";
            $result = mysqli_query($conn, $sql) or exit(mysqli_error($conn));
            $booking_length = $result->num_rows;

            if ($booking_length > 0) {                
                while ($row = $result->fetch_array()) {
            ?>
                <tr class="inquiries-row-item">
                    <th scope="row" class="inquiries-row-item-seq"><?= RemoveXSS($row['seq']); ?></th>
                    <td><?= RemoveXSS($row['name']); ?></td>
                    <td><?= RemoveXSS($row['hp']); ?></td>
                    <td><?= toStatusStr(RemoveXSS($row['status'])); ?></td>
                    <td><?= RemoveXSS($row['created_at']); ?></td>
                </tr>
            <?php } ?>
            <?php } else { ?>
                <tr><td colspan="6">등록된 정보가 없습니다.</tr>
            <?php } ?>

            
        </tbody>
    </table>

    <div class="mt-4 d-flex justify-content-center">
        <nav aria-label="Page navigation example">
            <ul class="pagination">
                <?php if ($paging_info['page_prev'] > 0) { ?>

                    <li class="page-item">
                        <a class="page-link page-link-dark" href="./index.php?page=<?= $paging_info['page_prev']; ?> aria-label="Previous">
                            <span aria-hidden="true">&laquo;</span>
                        </a>
                    </li>
                <?php }?>
                <?php
                for ($i = $paging_info['page_start']; $i <= $paging_info['page_end']; $i++) {
                    if ($i == $page) {
                ?>
                    <li class="page-item active-dark"><a class="page-link page-link-dark" href="#"><?= $i ?></a></li>
                <?php } else { ?>
                    <li class="page-item"><a class="page-link page-link-dark" href="./index.php?page=<?= $i; ?>"><?= $i; ?></a></li>
                <?php } ?>
                <?php } ?>

                <?php if ($paging_info['page_next'] < $paging_info['page_total']) { ?>
                    <li class="page-item">
                        <a class="page-link page-link-dark" href="./index.php?page=<?= $paging_info['page_next']; ?>" aria-label="Next">
                            <span aria-hidden="true">&raquo;</span>
                        </a>
                    </li>
                <?php } ?>
            </ul>
        </nav>
    </div>

</div>

<?php
$result->free();
mysqli_close($conn);
flush();
?>

<?php require_once('fragment/footer.php'); ?>

<script src="./vendor/jw-excel/sheetjs/xlsx.full.min.js"></script>
<script src="./vendor/jw-excel/FileSaver/FileSaver.min.js"></script>
<script src="./vendor/jw-excel/jw.excel.js"></script>

<script src="./js/common.js"></script>
<script src="./js/main.js"></script>

<?php require_once('fragment/tail.php'); ?>
