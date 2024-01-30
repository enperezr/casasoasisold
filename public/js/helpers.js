var HELPERS = {
        ajaxGet : function (url, args, f) {
            $.get(url, args || {}, f);
        },

        ajaxPost : function (url, args, success, fail, always) {
            $.post(url, args || {}, success).fail(fail).always(always)
        },

        spliceObject : function (obj, interval) {
            var i = 0, j = 0, r = {};
            for (index in obj) {
                if (obj.hasOwnProperty(index)) {
                    if (i >= interval[0]) {
                        if (j < interval[1]) {
                            r[index] = obj[index];
                            delete  obj[index];
                            j++;
                        }
                    }
                    i++;
                }
            }
            return r
        },

        countObjectArgs : function (obj) {
            var total = 0;
            for (index in obj) {
                if (obj.hasOwnProperty(index)) {
                    total++;
                }
            }
            return total;
        },

        setCookie : function(key, value){
            var encode = $.param(value, true);
            document.cookie = key + "=" + encode + ';' + 'path=/';
        },

        getCookie : function(key){
            var name, value;
            var beginning, middle, end;
            beginning = 0;  // start at beginning of cookie string
            while (beginning <= document.cookie.length)
            {
                middle = document.cookie.indexOf('=', beginning);  // find next =
                end = document.cookie.indexOf(';', beginning);  // find next ;

                if (end == -1)  // if no semicolon exists, it's the last cookie
                    end = document.cookie.length;
                if ( (middle >= end) || (middle == -1) )
                { // if the cookie has no value...
                    name = document.cookie.substring(beginning, end);
                    value = "";
                }
                else
                { // extract its value
                    name = document.cookie.substring(beginning, middle);
                    value = document.cookie.substring(middle + 1, end);
                }
                if(name == key)
                    return this.asObject(value);
                beginning = end + 2;  // step over space to beginning of next cookie
            }
            return false;
        },

        asObject: function(value){
            var decoded = decodeURIComponent(value);
            var data = {};
            var terms = decoded.split('&');
            for(var i = 0; i < terms.length; i++){
                var parts = terms[i].split('=');
                if(data[parts[0]] == undefined){
                    data[parts[0]] = parts[1];
                }
                else{
                    if(typeof data[parts[0]] == 'object'){
                        data[parts[0]].push(parts[1]);
                    }
                    else{
                        data[parts[0]] = [data[parts[0]], parts[1]];
                    }
                }
            }
            return data;
        },

        removeCookie: function(key){
            document.cookie = key + "=deleted; expires=Thu, 01-Jan-1970 00:00:01 GMT";
            document.cookie = key + "; expires=Thu, 01-Jan-1970 00:00:01 GMT";
        },

        getLocalizedURL: function(url){
            var languages = ['es', 'en'];
            var here = window.location.pathname.slice(1);
            var parts = here.split('/');
            var localized = false;
            for(var i = 0; i <languages.length; i++){
                if(parts[0] == languages[i]){
                    localized = true;
                    break;
                }
            }
            if(localized){
                return '/'+parts[0]+url;
            }
            return url;

        }    
    };
