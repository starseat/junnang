
String.prototype.replaceAll = function(org, dest) {
	return this.split(org).join(dest);
}
// function replaceAll(str, org, dest) {
//     return str.split(org).join(dest);
// }

$(document).ready(function(){
    $('#wr_form').submit(function(e) {
        e.preventDefault();
        e.stopPropagation();

        const name = $('#wr_name').val();
        if(name === '') {
            $('#wr_name').focus();
            alert('이름을 입력해주세요');
            return false;
        }
        if(name.indexOf(' ') !== -1) {
            $('#wr_name').val('');
            $('#wr_name').focus();
            alert("이름에는 공백문자를 포함할 수 없습니다.");
            return false;
        } 
        if(name.length < 2) {
            $('#wr_name').focus();
            alert("이름은 두 글자 이상 입력하셔야 합니다.");
            return false;
        }
        if(name.length > 8) {
            $('#wr_name').focus();
            alert("이름은 최대 8글자까지 입력 가능합니다.");
            return false;
        }

        const hp = $('#wr_hp').val().replaceAll('-', '');
        // hp = hp.replaceAll('-', '');
        // hp = replaceAll(hp, '-', '');
        if(hp === '') {
            $('#wr_hp').focus();
            alert('연락처를 입력해주세요');
            return false;
        }
        // if(/^(01[016789]{1}|02|0[3-9]{1}[0-9]{1})-?[0-9]{3,4}-?[0-9]{4}$/.test(hp) === false) {
        if(/^(01[016789]{1}|02|0[3-9]{1}[0-9]{1})?[0-9]{3,4}?[0-9]{4}$/.test(hp) === false) {
            $('#wr_hp').val('');
            $('#wr_hp').focus();
            alert('올바른 전화번호가 아닙니다.');
            return false;
        }

        const content = $('#wr_content').val();
        if(content === '') {
            $('#wr_content').focus();
            alert('내용을 입력해주세요.');
            return false;
        }
        if(content.length > 100) {
            $('#wr_content').focus();
            alert('최대 100글자까지 입력 가능합니다.');
            return false;
        }

        const isCheck = $('#wr_personal_check').is(':checked');
        if(!isCheck) {            
            alert('"개인정보 수집 및 이용에 동의"를 확인해주세요.');
            return false;
        }

        const param = {
            name: name,
            hp: hp,
            content: content
        };

        sendSmsRequest(param);
    });
});

function sendSmsRequest(param) {
    param.temp_mode = '92';

    const _url = './api/regist.php';
    // const _url = 'http://junnang.co.kr/api/regist.php';

    // $.post('http://www.meatexpress.co.kr/sms/sms_trans.php', param, function(jqXHR) { console.log('ajax post request jqXHR: ', jqXHR);} /*, 'json' /* xml, text, script, html */)
    // .done(function(result) { console.log('ajax post success: ', result); alert( '문의사항이 접수되었습니다.' );})
    // .fail(function(error) { console.log('ajax post fail: ', error);  alert( '문의사항 전송에 실패하였습니다.' );})
    // .always(function(response) { console.log('ajax post always: ', response); });
    
    $.ajax({		
		type : 'post',
		url : _url,
        data : param,
		dataType: 'json',
		success : function(resultData) {
			console.log('ajax post success: ', resultData); 
            alert( '문의사항이 접수되었습니다.' );
		}, 
		error: function (jqXHR, textStatus, errorThrown) {
			console.log('ajax post fail: ', textStatus + ' ' + errorThrown);
            alert( '문의사항 전송에 실패하였습니다.' );
		},
		complete: function (response) {
			console.log('ajax post always: ', response);

            clearSendRequest();
		}
	});
}

function clearSendRequest() {
    $('#wr_name').val('');
    $('#wr_hp').val('');
    $('#wr_content').val('');

    $('#wr_personal_check').prop('checked', false);
}

