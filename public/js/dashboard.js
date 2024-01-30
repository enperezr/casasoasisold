var DASHBOARD = (function(){
    return function(){
        var actions, properties, contacts, props, conts, props_trigger, conts_trigger, plus_show,
            props_container, conts_container;

        this.init = function(){
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            actions = $('.user-action');
            properties = $('.user-property');
            contacts = $('.user-contact');
            conts = $('.conts');
            conts_trigger = $('.conts-trigger');
            props_trigger = $('.props-trigger');
            props = $('.props');
            props_container = $('.props-container');
            conts_container = $('.conts-container');
            plus_show = $('.plus-show');
            actions.find('.delete').click(delete_action);
            properties.find('.delete').click(delete_property);
            contacts.find('.delete').click(delete_contact);
            conts.hide();
            conts_trigger.hide();
            props.hide();
            props_trigger.hide();
            plus_show.click(show_form);
            conts_trigger.click(add_contact);
            props_trigger.click(add_property);

            props_container.on('click', '.trash-p', remove_property_from_action);
            conts_container.on('click', '.trash-c', remove_contact_from_action);
        };

        var disable_ui = function(){

        };

        var enable_ui = function(){

        };

        var delete_action = function(e){
            e.preventDefault();
            var element = $(e.target).parents('.user-action');
            var id = element.data('id');
            disable_ui();
            $.post('/user/delete-action', {'id':id}, function(data){
                enable_ui();
                if(data){
                    element.remove();
                }
            });
        };
        var delete_property = function(e){
            e.preventDefault();
            var element = $(e.target).parents('.user-property');
            var id = element.data('id');
            disable_ui();
            $.post('/user/delete-property', {'id':id}, function(data){
                enable_ui();
                if(data){
                    element.remove();
                }
            });
        };
        var delete_contact = function(e){
            e.preventDefault();
            var element = $(e.target).parents('.user-contact');
            var id = element.data('id');
            disable_ui();
            $.post('/user/delete-contact', {'id':id}, function(data){
                enable_ui();
                if(data){
                    element.remove();
                }
            });
        };

        var show_form = function(e){
            e.preventDefault();
            $(this).siblings('.conts-trigger').show();
            $(this).siblings('.conts').show();
            $(this).siblings('.props-trigger').show();
            $(this).siblings('.props').show();
            $(this).hide();
        };
        var hide_form = function(elem){
            var parent = elem.parents('.action-properties, .action-contact');
            parent.find('.conts-trigger').hide();
            parent.find('.conts').hide();
            parent.find('.props-trigger').hide();
            parent.find('.props').hide();
            parent.find('.plus-show').show();
        };

        var add_contact = function(e){
            e.preventDefault();
            var action_id = $(this).parents('.user-action').data('id');
            var select = $(this).siblings('.conts').find('select');
            var v = select.val();
            if(v){
                var that = $(this);
                $.post('/user/attach-contact', {contact:v, action:action_id}, function(data) {
                    if(data){
                        select.find('option[value="' + v + '"]').remove();
                        that.parents('.operations').find('.conts-container ul').append('<li><span class="bullet blue">' + v + '<i class="fa fa-trash trash-c"></i></span></li>');
                    }
                });
            }
            hide_form($(this));
        };
        var add_property = function(e){
            e.preventDefault();
            var action_id = $(this).parents('.user-action').data('id');
            var select = $(this).siblings('.props').find('select');
            var v = select.val();
            if(v){
                var that = $(this);
                $.post('/user/attach-property', {property:v, action:action_id}, function(data){
                    if(data){
                        select.find('option[value="'+v+'"]').remove();
                        that.parents('.operations').find('.props-container ul').append('<li><span class="bullet orange">'+v+'<i class="fa fa-trash trash-p"></i></span></li>');
                    }

                });
            }
            hide_form($(this));
        };

        var remove_property_from_action = function(e){
            var bullet = $(this).parents('.bullet');
            var property_id =bullet.text();
            var action_id = $(this).parents('.user-action').data('id');
            var container = $(this).parents('.operations').find('.props-container ul');
            var select = $(this).parents('.user-action').find('.props select');
            $.post('/user/detach-property', {property:property_id, action:action_id}, function(data){
                if(data){
                    bullet.remove();
                    select.append('<option value="'+property_id+'">'+property_id+'</option>');
                }
            });
        };
        var remove_contact_from_action = function(e){
            var bullet = $(this).parents('.bullet');
            var contact_id = bullet.text();
            var action_id = $(this).parents('.user-action').data('id');
            var container = $(this).parents('.operations').find('.conts-container ul');
            var select = $(this).parents('.user-action').find('.conts select');
            $.post('/user/detach-contact', {contact:contact_id, action:action_id}, function(data){
                if(data){
                    bullet.remove();
                    select.append('<option value="'+contact_id+'">'+contact_id+'</option>');

                }
            });
        };
    };
})();
$(document).ready(function(){
    var dashboard = new DASHBOARD();
    dashboard.init();
});
