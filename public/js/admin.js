var ADMIN = (function(){
    return function(){
        var results, loader, container, related, time, concluded;

        this.init = function(){
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            loader = $('span#loader');
            loader.hide();
            container = $('#related');
            results = $('tr.result');
            results.click(function(e){
                var current = $(e.target).parents('tr');
                if(!current.hasClass('selected')){
                    $('tr').removeClass('selected');
                    current.addClass('selected');
                    show_properties(e)
                }
            });
            time = $('input.time');
            time.dblclick(edit_time);
            time.focusout(save_time);
            concluded = $('select.concluded');
            concluded.change(concluded_changed);
        };

        var show_properties = function(e){
            container.html('');
            loader.show();
            var id = $(e.target).parents('tr').attr('id');
            $.get('/admin/related-properties', {'id':id}, function(data){
                container.html(data);
                loader.hide();
            })
        };

        var edit_time = function(e){
            var el = $(e.target);
            el.removeAttr('readonly')
        };

        var save_time = function(e){
            var el = $(e.target);
            el.attr('readonly', 'readonly');
            if(el.val() != el.data('value')){
                var n_val = parseInt(el.val());
                if(isNaN(n_val)){
                    el.val(el.data('value'))
                }
                else{
                    el.val(n_val);
                    var tr = el.parents('tr');
                    var id = tr.attr('id');
                    $.post('/admin/set-action-time', {'id':id, 'time':n_val}, function(data){
                        tr.find('td.date').html(data.created_at);
                        tr.find('td.remaining').html(data.time);
                        el.val(data.time);
                        el.data('value',data.time);
                    });
                }
            }
        };

        var concluded_changed = function(e){
            var el = $(e.target);
            var value = el.val();
            var id = el.parents('tr').attr('id');
            $.post('/admin/set-action-concluded', {'id':id, 'concluded':value}, function(data){
                el.val(data.concluded)
            });
        }
    }
})();
$(document).ready(function(){
    var admin = new ADMIN();
    admin.init();
});
