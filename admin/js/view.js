$(document).ready(function(){
    const savedStatus = $("#savedStatus").val();
    $('#selectList').val(savedStatus);
});

function doDelete() {
    if(!confirm('정말 삭제하시겠습니까?')) {
        return false;
    }

    $.ajax({		
		type : 'post',
		url : './action/del_inquiry.php',
        data : {seq: $('#savedSeq').val()},
		dataType: 'json',
		success : function(resultData) {
			console.log('ajax post success: ', resultData); 
            alert( '문의사항이 삭제되었습니다.' );
		}, 
		error: function (jqXHR, textStatus, errorThrown) {
			console.log('ajax post fail: ', textStatus + ' ' + errorThrown);
            alert( '문의사항 삭제에 실패하였습니다.' );
		},
		complete: function (response) {
			console.log('ajax post always: ', response);
            doList();
		}
	});
    
}

function doSave() {
    const param = {
        seq: $('#savedSeq').val(),
        status: $('#selectStatus').val(),
        memo: $('#memo').val(),
    }

    $.ajax({		
		type : 'post',
		url : './action/upd_inquiry.php',
        data : param,
		dataType: 'json',
		success : function(resultData) {
			console.log('ajax post success: ', resultData); 
            alert( '문의사항이 수정되었습니다.' );
		}, 
		error: function (jqXHR, textStatus, errorThrown) {
			console.log('ajax post fail: ', textStatus + ' ' + errorThrown);
            alert( '문의사항 수정에 실패하였습니다.' );
		},
		complete: function (response) {
			console.log('ajax post always: ', response);
		}
	});
}

function doList() {
    location.href = './index.php';
}