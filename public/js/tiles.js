var TILE = (function(){
    return function(){
        var tiles = $('.property');
        this.init = function(){
            tiles.hover(function(){
                $(this).find('.bottom-data').hide();
                $(this).find('.hover-menu').show();
            }, function(){
                $(this).find('.bottom-data').show();
                $(this).find('.hover-menu').hide();
            })
        };
    };
})();
$(function(){
    var index = new TILE();
    index.init();
});
