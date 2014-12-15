var app = app || {};
app.BookPresentation = Backbone.View.extend({
    tagName: 'div',
    className: 'bookPresentationContainer',
    template: _.template( $('#bookPresentationTemplate').html() ),
    render: function() {
        console.log(this.model);
        this.$el.html( this.template( this.model.toJSON() ));
        return this;
    }
});