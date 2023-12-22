var ACTION = (function() {
    return function() {

        var permutaElements, rentaElements, ventaElements, actionForm, that;

        this.init = function() {
            permutaElements = $('.permutas');
            rentaElements = $('.rentas');
            ventaElements = $('.ventas');
            actionForm = $('#action-form');
            permutaElements.hide();
            rentaElements.hide();
            ventaElements.hide();
            that = this;
            var actionElement = $('#action');
            $('.editor').summernote({
                height: 175,
                tabsize: 2,
                toolbar: [
                    ['style', ['style']],
                    ['font', ['bold', 'clear']],
                    ['para', ['ul', 'ol']]
                ]
            });
            update_layout(actionElement.val());
            actionElement.change(function(e) {
                update_layout(e.target.value);
            });
            $('#end').click(submit_form);
            actionForm.validator({ acceptEmpty: true });
        };

        var update_layout = function(action) {
            switch (action) {
                case "1":
                    permutaElements.hide();
                    rentaElements.hide();
                    ventaElements.show();
                    break;
                case "2":
                    rentaElements.hide();
                    ventaElements.hide();
                    permutaElements.show();
                    break;
                case "3":
                    permutaElements.hide();
                    ventaElements.hide();
                    rentaElements.show();
                    break;
                default:
                    rentaElements.hide();
                    ventaElements.show();
                    permutaElements.show();
            }
        };

        var submit_form = function(e) {
            e.preventDefault();
            if (that.isValid())
                actionForm.submit();
        };

        this.isValid = function() {
            return actionForm.validate();
        };

        this.getValue = function(selector) {
            if ($(selector).size() != 1)
                return false;
            return $(selector).val();
        };

        this.getData = function() {
            return actionForm.serialize()
        };

        this.reset = function() {
            actionForm[0].reset();
        }
    };
})();
var formAction = new ACTION();
$(document).ready(function() {
    formAction.init();
});