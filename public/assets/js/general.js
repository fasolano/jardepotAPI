$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
});

$(document).ready(function (){
    console.log(Cookie.get('name'));
    if(Cookie.get('session') === undefined){
        var parameters = [];
        parameters['url'] = "api/session";
        parameters['type'] = "GET";
        parameters['dataType'] = "json";
        parameters['data'] = {};
        parameters['success'] = function (result) {
            console.log(result);
            Cookie.set('session', result, { expires: 7 })

        };
        ajaxCall(parameters);
    }
});

$('#search-form').on('keypress',function(e) {
    if(e.which == 13) {
        $('#search-form').submit();
    }
});

$('#search-form').submit(function (e) {
    e.preventDefault();
    var search = $('#inputSearch').val();
    window.location = "/jardepotAPI/public/busqueda/"+search;
})

var bussy = false;

function ajaxCall(parameters){
    if(! bussy){
        $('#overlay-bussy').addClass('active');
        parameters["data"]._token = $('meta[name="csrf-token"]').attr('content');
        bussy = true;
        parameters["dataType"] = (typeof parameters["dataType"] == "undefined" || parameters["dataType"] == null)?"text":parameters["dataType"];
        $.ajax({
            url: parameters["url"],
            type: parameters["type"],
            dataType: parameters["dataType"],
            data: parameters["data"],
            success: parameters["success"],
            error: function (err) {
                $('#overlay-bussy').removeClass('active');
                console.log(err);
                alert("Ocurrio un error "+parameters["url"], "Error");
            },
            complete: function(){
                $('#overlay-bussy').removeClass('active');
                if(!typeof parameters["complete"] === "undefined" && !parameters["complete"] == null){
                    parameters["complete"]();
                }
                bussy = false;
            }
        });
    }else{
        setTimeout(function(){
            ajaxCall(parameters);
        }, 500);
    }

}

function releaseAjaxQueue(){
    bussy = false;
}

function blockAjaxQueue(){
    bussy = true;
}

function executeAfterAjaxRelease(functionToExecute){
    if(! bussy){
        functionToExecute();
    }else{
        setTimeout(function(){
            executeAfterAjaxRelease(functionToExecute);
        }, 500);
    }
}

function getCookie(name) {
    let documento = (typeof document !== "undefined") ? document : null;
    if(documento){
        let ca = documento.cookie.split(';');
        let caLen = ca.length;
        let cookieName = `${name}=`;
        let c;

        for (let i = 0; i < caLen; i += 1) {
            c = ca[i].replace(/^\s+/g, '');
            if (c.indexOf(cookieName) == 0) {
                return c.substring(cookieName.length, c.length);
            }
        }
        return '';
    }
    return '';
}

function deleteCookie(name) {
    this.setCookie(name, '', -1);
}

function setCookie(name, value, expireDays, path = '') {
    let documento = (typeof document !== "undefined") ? document : null;
    if(documento){
        let d = new Date();
        d.setTime(d.getTime() + expireDays * 24 * 60 * 60 * 1000);
        let expires = `expires=${d.toUTCString()}`;
        let cpath = path ? `; path=${path}` : '';
        documento.cookie = `${name}=${value}; ${expires}${cpath}`;
    }

}
