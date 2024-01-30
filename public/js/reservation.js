var RESERVATION = (function(){
    return function(){

        var fecha, form;

        this.init = function(){

            fecha = $('#fecha');

            lightbox.options.showImageNumberLabel = false;
            lightbox.enable();
            lightbox.init();

            initDatePicker();
            initFormInformation();
        };

        var initDatePicker = function(){
            fecha.css('cursor', 'pointer');
            fecha.attr('readonly', 'readonly');
            fecha.datepicker({
                minDate:1
            });
        };

        var initFormInformation = function(){
            form = $('#form-information');
            form.validator();
            form.find('#form-contactar').click(function(e){
                e.preventDefault();
                if(form.validate()){
                    form.submit();
                }
            });
        };

    }
})();
$(document).ready(function(){
    var reserv = new RESERVATION();
    reserv.init();
});