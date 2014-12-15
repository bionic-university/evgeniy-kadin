var app = app || {};
$(function() {
    var library  = new app.LibraryView();
    var router = new app.Router();

    router.on('route:loadBook', function(id){
        var collection = library.getCollection();
        if(collection.length != 0){
            var bookPresentation = new app.BookPresentation({model:collection.get(id)});
            console.log(bookPresentation.render().el);
            $('#popup').html(bookPresentation.render().el);
            $('#myModal').modal()

        }
    });
    Backbone.history.start();


});
