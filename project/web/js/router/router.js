var app = app || {};
app.Router = Backbone.Router.extend({
    routes: {
        "books/:id": "loadBook",
        "*actions": "defaultRoute" // Backbone will try match the route above first
    }
});