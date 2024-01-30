$('document').ready(function(){
    $.ajax({
        url: "https://query.yahooapis.com/v1/public/yql",

        // The name of the callback parameter, as specified by the YQL service
        jsonp: "yqlCallback",

        // Tell jQuery we're expecting JSONP
        dataType: "jsonp",

        // Tell YQL what we want and that we want JSON
        data: {
            q: "select * from flickr.photos.search where has_geo='true' and tags='New York City' and api_key='92ee000090936a872bfed249609f3ca5'",
            format: "json"
        },

        // Work with the response
        success: function( response ) {
            console.log( response ); // server response
        }
    });
});

var yqlCallback = function(data) {
    console.log(data);
    var photo = data.query.results.photo[0];
    alert(photo.title);
};