var app = app || {};
app.Book = Backbone.Model.extend({
    defaults: {
        id: '',
        book_id: '',
        cover: 'img/placeholder.png',
        title: 'No title',
        annotation: 'annotation text',
        authors: [],
        category:[],
        pages_count:0
//        releaseDate: 'Unknown',
//        keywords: 'None'
    },
    parse: function( response ) {
        response.id = response.book_id;
        return response;
    }

});
