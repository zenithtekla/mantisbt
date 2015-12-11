// plugin.php?page=Serials/json/customer.php
(function(){
$(function(){
    /*$('#field1').on('change', function(){
       console.log('changed') ;
    });*/
    $('#field1').typeahead({
        minLength: 0,
        maxItem: 15,
        order: "asc",
        hint: true,
        accent: true,
        searchOnFocus: true,
        backdrop: {
            "background-color": "#3879d9",
            "opacity": "0.1",
            "filter": "alpha(opacity=10)"
        },
        template: "{{display}} <small style='color:#999;'>{{group}}</small>",
        source: {
            customer_name:  {
                url: ["/plugin.php?page=Serials/json/customer.php", "data.customer_name"]
            }
        },
        callback: {
            onClickAfter: function (node, a, item, event) {
                $('#result-container').text('');
                console.log(item.display);
                console.log(node, a, item, event);
            },
            onResult: function (node, query, obj, objCount) {
                console.log(query);
                var text = "";
                if (query !== "") {
                    text = objCount + ' elements matching "' + query + '"';
                }
                $('#result-container').text(text);
            }
        },
        debug: true
    });
});
})();
