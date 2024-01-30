var CONTACT = (function(){
    return function(){

        var submit, formulario, that, gestor;

        this.init = function(){
            submit = $('#submit');
            formulario = $('#contact-form');
            gestor = $('#gestor');
            gestor.change(updateGestorData);
            submit.click(saveContact);
            formulario.validator({acceptEmpty:true});
            that = this;
        };

        var updateGestorData = function (e) {
            if(gestor.val()){
                $('#names').val($(e.target.selectedOptions[0]).data('names')).attr('disabled', 'disabled');
                $('#phones').val($(e.target.selectedOptions[0]).data('phones')).attr('disabled', 'disabled');
                $('#mail').val($(e.target.selectedOptions[0]).data('email')).attr('disabled', 'disabled');
            }
            else{
                $('#names').val('').removeAttr('disabled');
                $('#phones').val('').removeAttr('disabled');
                $('#mail').val('').removeAttr('disabled');
            }
        };

        var saveContact = function(e){
            e.preventDefault();
            if(that.isValid())
                formulario.submit();
        };

        this.isValid = function(){
            return formulario.validate();
        };

        this.getData = function(){
            return formulario.serialize()
        };

        this.reset = function(){
            formulario[0].reset();
        }

    }
})();
var formContact = new CONTACT();
$(document).ready(function(){
    formContact.init();
});
