app.collections.Books = Backbone.Collection.extend({
    initialize: function(){
        this.add({ title: "Learn JavaScript basics" });
        this.add({ title: "Go to backbonejs.org" });
        this.add({ title: "Develop a Backbone application" });
    },
    model: app.models.Book
});
