/* **********
 * 퍼블리셔용 *
*********** */

var POPUP_COUNT = 4;

$(document).ready(function(){
    popupEvent();        
});
$(window).resize(function() {

});

// 메인팝업 이벤트
function popupEvent() {
    //gnb 메뉴선택했을때 이벤트
    $('.glist_link').on('click', function(){
        $('.glist_inner_cont').removeClass('current');
        $(this).parents('.glist_inner_cont').addClass('current');
    });

    // 팝업 닫을때 쿠키 설정
    $('.popup_btn_close').on('click', function(_event) {
        var popId = $(this).attr('id');
        var popIdx = (popId + '').slice(-1);
        couponClose(popIdx);
    });

    // 페이지 로드시 팝업 활성화 처리
    for(var i=1; i<=POPUP_COUNT; i++) {
        var cname = 'popup' + i;
        var isClose = getCookie('popup' + i);
        if(cname == '' || isClose != 'Y') {
            $('#pop' + i).show();
        }
        else {
            $('#pop' + i).hide();
        }
    }

}

// 쿠키가져오기
var getCookie = function (cname) {
    var name = cname + "=";
    var ca = document.cookie.split(';');
    for(var i=0; i<ca.length; i++) {
        var c = ca[i];
        while (c.charAt(0)==' ') c = c.substring(1);
        if (c.indexOf(name) != -1) return c.substring(name.length,c.length);
    }
    return "";
}

// 24시간 기준 쿠키 설정하기
var setCookie = function (cname, cvalue, exdays) {
    var todayDate = new Date();
    todayDate.setTime(todayDate.getTime() + (exdays*24*60*60*1000));
    var expires = "expires=" + todayDate.toUTCString();
    document.cookie = cname + "=" + cvalue + "; " + expires;
}

var couponClose = function(_popIdx){
    // if($("input[name='chkbox']").is(":checked") == true){
    //     setCookie("close","Y",1);   //기간( ex. 1은 하루, 7은 일주일)
    // }
    // $("#pop").hide();

    if( $('#chkday' + _popIdx).is(':checked')) {
        setCookie('popup' + _popIdx, 'Y', 1);   //기간( ex. 1은 하루, 7은 일주일)
    }
    $('#pop' + _popIdx).hide();
}


// 내가 클릭한거에 id값 가져와서 체크해서 실행하기!
/*
var couponClose = function(){
    if($("input[name='checkbox']").is("checked")==true) {
        setCookie("close", "Y", 1); //기간(ex.1은 하루, 7은 일주일)
    }
    $("#pop").hide();
}*/
