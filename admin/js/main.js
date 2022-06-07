$(document).ready(function(){
    $('.inquiries-row-item').on('click', function(e) {
        const seq = $(this).find('.inquiries-row-item-seq').text();
        getItem(seq);
    });
});

function printExcel() {
    $.ajax({
        type: 'get',
        url: './action/get_inquiries.php',
        success: function(result) {
            // console.log('[printExcel] result:: ', result);
            const resultObj = JSON.parse(result);
            // console.log('[printExcel] resultObj:: ', resultObj);
            outputExcel(resultObj.data);
        },
        error: function(xhr, status, error) {
            console.error('[printExcel] ajax error:: ', error);
        },
    });
}

function outputExcel(data) {
    if (data.length > 0) {
        JwExcel.exportExcel(data, '전설의 냉면 문의하기');
    } else {
        alert('엑셀로 출력할 데이터가 없습니다.');
    }
}

function getItem(seq) {
    location.href = './view.php?seq=' + seq;
}
