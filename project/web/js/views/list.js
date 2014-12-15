app.views.list = Backbone.View.extend({
    mode: null,
    events: {},
    initialize: function() {
        var handler = _.bind(this.render, this);
    },
    render: function() {
        var html = '<ul class="book">',
            self = this;
        this.model.each(function(book, index) {
            var template = _.template($("#tpl-book-item").html());
            html += template({
            title: book.get("title"),
            index: index
                });
        });
        html += '</ul>';
        this.$el.html(html);
        this.delegateEvents();
        return this;

    }
});