var USER_ADMIN = (function(){
    return function(){

        var data, modalElement, tmplModalElement, modal;

        this.init = function(){
            data = $('.data_local');
            data.dataTable();
            modalElement = $('#actions_container');
            tmplModalElement = modalElement.find('.container').html();
            modal = new Foundation.Reveal(modalElement, {
                closeOnClick: false,
                closeOnEsc: false,
                resetOnClose: true,
                vOffset:0
            });
            modalElement.on('close.zf.trigger', function(){
                modalElement.off('open.zf.reveal');
                modalElement.off('click');
                modalElement.find('.container').html(tmplModalElement);
            });
        }
    }
})();
$(document).ready(function(){
    var admin = new USER_ADMIN();
    admin.init();
});
