$(document).ready(function(){
    $('#login').click(function(e){
        e.preventDefault();
        $('form#logon').submit();
    })
});