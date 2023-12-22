$(function() {
    var panel;
    $('path').mouseover(function(e){
        panel = $('<div class="info_panel">'+ $(e.target).data('name') + '</div>').appendTo('body');
    })
        .mouseleave(function(){
            panel.remove();
        })
        .mousemove(function(e) {
            var mouseX = e.pageX, //X coordinates of mouse
                mouseY = e.pageY; //Y coordinates of mouse

            panel.css({
                top: mouseY-50,
                left: mouseX - ($('.info_panel').width()/2)
            });
        });
});