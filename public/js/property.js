var PROPERTY = (function(){
    return function(){
        var formError, formInformation, formComment, rateElement, resizeState = 0;

        this.init = function(){
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $(window).resize(orderResponsive);
            orderResponsive();
            lightbox.options.showImageNumberLabel = false;
            lightbox.enable();
            lightbox.init();
            initFormError();
            initFormInformation();
            initFormComment();
            initScrollHandler();
            initSMSCounter();

            $('.actual-comment').css('width', ($('.comment').width() - 90)+'px');
        };

        var orderResponsive = function(){
            if(window.innerWidth  < 1045 && resizeState == 0) {
                var data = $('.data').remove();
                $('.more-pictures').after(data);
                resizeState = 1;
            }
            if(window.innerWidth  > 1045 && resizeState == 1) {
                var data = $('.data').remove();
                $('.more-pictures').before(data);
                resizeState = 0;
            }
            $('.actual-comment').css('width', ($('.comment').width() - 90)+'px');
        };

        var initFormError = function(){
            formError = $('#form-error');
            formError.find('#form-enviar').click(function(e){
                e.preventDefault();
                if($('input[name=reporte]:checked').val()) {
                    $.post('/mail/send-error', formError.serialize(), function (data) {
                        $('#error-report').find('.contenido').html($('#thanks').html());
                    });
                }
            });
        };

        var initFormInformation = function(){
            formInformation = $('#form-information');
            formInformation.validator();
            formInformation.find('#form-contactar').click(function(e){
                e.preventDefault();
                if(formInformation.validate()){
                    $.post('/mail/send-message', formInformation.serialize(), function(data){
                        console.log(data)
                    })
                }
            });
        };

        var initFormComment = function(){
            $('#save-comment').click(function(e){
                $(this).attr('disabled', 'disabled');
                $('#form-comment').submit();
            });
        };

        var initRateElement = function(){
            rateElement = $('div#rate');
            rateElement.starbox({
                average: rateElement.data('value')/5,
                changeable: 'once',
                autoUpdateAverage: true,
                ghosting: true
            }).bind('starbox-value-changed', function(event, value) {
                $.post('/property/rate/'+rateElement.data('property')+'/'+Math.round(5*value), {} , function(data){
                    if(!isNaN(data))
                        rateElement.starbox('setValue', data/5)
                });
            });
            if(rateElement.data('rated'))
                rateElement.starbox('setOption', 'changeable', false);

        };

        var initScrollHandler = function(){
            var top = $('.images').offset().top;
            var reserve = $('.reserve');
            $(window).scroll(function(){
                if($(this).scrollTop() > top-50){
                    reserve.css("position","absolute");
                    reserve.css("top",top-50+"px");
                }
                else{
                    reserve.removeAttr('style');
                }
            });

        };

        var initSMSCounter = function(){
            var textarea = $('#smstext');
            var counter = $('#count');
            textarea.keyup(function(e){
                var l = textarea.val().length;
                counter.text(''+l);
                if(l > 145) {
                    counter.css('color', 'red');
                }
                else{
                    counter.removeAttr('style');
                }
            });
        };
    }

})();

$(document).ready(function(){
    var prop = new PROPERTY();
    prop.init();
    $("#gallery").unitegallery();

    var link_clicked = false;
    $('a').click(function(e){
        if($(this).attr('href') != '#')
            link_clicked = true
    });
    window.onunload = function(e){
        if(!link_clicked)
            HELPERS.setCookie('backing', 1);
    }
});