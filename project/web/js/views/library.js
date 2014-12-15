var app = app || {};
app.LibraryView = Backbone.View.extend({
    el: '#books',
    initialize: function() {
        this.collection = new app.Library();
        this.collection.bind('reset', function() {
        });
        this.collection.fetch({reset: true, success: function() {
            //console.log(this.collection);
        }}); // НОВОЕ
        //console.log(this.collection.toJSON());

        this.render();

        this.listenTo( this.collection, 'reset', this.render );

    },
// отображение библиотеки посредством вывода каждой книги из коллекции
    render: function() {
        this.collection.each(function( item ) {
           // console.log(item);
            this.renderBook( item );
        }, this );
    },
    renderBook: function( item ) {
        var bookView = new app.BookView({
            model: item
        });
        this.$el.append( bookView.render().el );
    },
    getCollection: function(){
        return this.collection;
    }
});
