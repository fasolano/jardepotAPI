$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
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
