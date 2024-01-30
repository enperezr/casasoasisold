/**
 * Adapted from metro-ui-css: http://metroui.org.ua
 */

(function( $ ){
    $.fn.validator = function(user_options) {

        var options = {
            acceptEmpty:false
        };
        var inputs = [];
        var that = this;
        var hintTemplate = "<div class=\"hint2 validator-hint top\" style=\"min-width: 0; color: rgb(0, 0, 0); display: block; background-color: rgb(255, 252, 192);\">|hint|</div>";
        var validators =  {

            required: function(val){
                return val.trim() !== "";
            },
            minlength: function(val, args){
                var len = args[0];
                if (len == undefined || isNaN(len) || len <= 0) {
                    return false;
                }
                return val.trim().length >= len;
            },
            maxlength: function(val, args){
                var len = args[0];
                if (len == undefined || isNaN(len) || len <= 0) {
                    return false;
                }
                return val.trim().length <= len;
            },
            min: function(val, args){
                var min_value = args[0];
                if (min_value == undefined || isNaN(min_value)) {
                    return false;
                }
                if (val.trim() === "") {
                    return false;
                }
                if (isNaN(val)) {
                    return false;
                }
                return val >= min_value;
            },
            max: function(val, args){
                var max_value = args[0];
                if (max_value == undefined || isNaN(max_value)) {
                    return false;
                }
                if (val.trim() === "") {
                    return false;
                }
                if (isNaN(val)) {
                    return false;
                }
                return val <= max_value;
            },
            email: function(val){
                val = val.trim();
                return /^([\w-]+(?:\.[\w-]+)*)@((?:[\w-]+\.)*\w[\w-]{0,66})\.([a-z]{2,6}(?:\.[a-z]{2})?)$/i.test(val);
            },
            url: function(val){
                return /^(?:[a-z]+:)?\/\//i.test(val);
            },
            date: function(val){
                return !!(new Date(val) !== "Invalid Date" && !isNaN(new Date(val)));
            },

            dateFuture:function(val){
                if(!!(new Date(val) !== "Invalid Date" && !isNaN(new Date(val)))){
                    return (new Date() < new Date(val))
                }
                return false;
            },

            number: function(val){
                return (val - 0) == val && (''+val).trim().length > 0;
            },
            alpha: function(val){
                return /^[A-Záéíóúñ ]+$/i.test(val);
            },
            alphaEnumerator: function(val){
                return /^[A-Z,áéíóúñ ]+$/i.test(val);
            },
            digits: function(val){
                return /^\d+$/.test(val);
            },
            digitsEnumerator: function(val){
                return /^[0-9, ]+$/.test(val);
            },
            digits_between: function(val, args){
                var min = args[0];
                var max = args[1];
                return /^\d+$/.test(val) && min <= val.trim().length && val.trim().length <= max;
            },

            hexcolor: function(val){
                return /(^#[0-9A-F]{6}$)|(^#[0-9A-F]{3}$)/i.test(val);
            },
            pattern: function(val, args){
                var pat = args[0];
                if (pat == undefined) {
                    return false;
                }
                var reg = new RegExp(pat);
                return reg.test(val);
            },
            required_if: function(val, args){
                var another_id = args[0];
                var another_values = args.splice(1);
                for(var i in another_values){
                    if($('#'+another_id).val() == another_values[i]){
                        return val.trim() !== "";
                    }
                }
                return true;
            },
            required_ifnot: function(val, args){
                var another_id = args[0];
                var another_values = args.splice(1);
                var diff = true;
                for(var i in another_values){
                    if($('#'+another_id).val() == another_values[i]){
                        diff = false;
                    }
                }
                if(diff)
                    return val.trim() !== "";
                return true;
            }
        };

        /**
         * Validates a field and add error/success class to it
         * @param input :  jQuery wrapped input
         * @return {boolean}
         */
        var validateField = function(input){
            input.removeClass('error').removeClass('success');
            var value = input.val();
            var funcs = input.data('validateFunc').split('|');
            var requireds = [];
            var valid = true;
            for(var i in funcs){
                if(funcs[i].substring(0, 'required'.length) == 'required'){
                    requireds.push(funcs[i]);
                    continue;
                }
                var args = funcs[i].split(',');
                if(!validators[args[0]](value, args.splice(1))){
                    valid = false;
                }
            }
            if(!valid && input.val().trim() == "" && options.acceptEmpty){
                valid = true;
            }
            for(var r in requireds){
                args = requireds[r].split(',');
                if(!validators[args[0]](value, args.splice(1))){
                    valid = false;
                }
            }
            if(!valid){
                input.addClass('error').removeClass('success');
                input.focus()
            }
            else{
                input.addClass('success').removeClass('error');
                $('div.hint2').remove();
            }
            return valid;
        };

        var init = function(user_options){
            if(user_options)
                $.extend(options, user_options);
            inputs = that.find("[data-validate-func]");
            inputs.keyup(function(){
                validateField($(this))
            });

            inputs.hover(
                function(){
                    if($(this).hasClass('error') && $(this).data('validateHint')){
                        showHint($(this));
                    }
                }, function(){
                    $('div.hint2').remove();
                }
            );
        };

        /**
         * Show the hint included with the field
         * @param input
         */
        var showHint = function(input){
            var message = input.data('validateHint');
            var parts = hintTemplate.split('|hint|');
            var hint = $(parts[0]+message+parts[1]).appendTo('body');
            var left = input.offset().left + input.outerWidth()/2 - hint.outerWidth()/2  - $(window).scrollLeft();
            var top = input.offset().top - 60;
            hint.addClass('top');
            hint.css({top: top, left: left}).show();
        };

        init(user_options);

        this.validate = function(){
            var final = true;
            var firstInvalid = undefined;
            inputs.each(function(index, input){
                if(!validateField($(input))){
                    if(!firstInvalid)
                        firstInvalid = $(input);
                    final = false;
                }

            });
            if(firstInvalid)
                firstInvalid.focus();
            return final;
        };

        return this;

    };
})( jQuery );