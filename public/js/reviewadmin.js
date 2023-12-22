var REVIEW_ADMIN = (function(){
    return function(){

        var data;

        this.init = function(){
            data = $('.data_local');
            data.dataTable();
        }
    }
})();
$(document).ready(function(){
    var admin = new REVIEW_ADMIN();
    admin.init();
});
