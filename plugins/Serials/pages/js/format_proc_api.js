// plugin.php?page=Serials/json/customer.php
/*
(function(){
    $.typeahead({
        input: "#field1",
        minLength: 0,
        maxItem: 10,
        order: "asc",
        hint: true,
        cache: true,
        searchOnFocus: true,
        template: '<span class="row">' +
                '<span class="nimi">{{nimi}}</span>' +
        '</span>',
        correlativeTemplate: true,
        source: {
            joukko1: {
                url: "/plugin.php?page=Serials/json/customer.php"
            }
        },
        callback: {
            onClickAfter: function (node, a, item, event) {
                $('#result-container').text('');
                console.log(JSON.stringify(item));
            },
            onResult: function (node, query, obj, objCount) {
                var text = "";
                if (query !== "") {
                    text = objCount + ' elements matching "' + query + '"';
                }
                $('#result-container').text(text);
            }
        },
        debug: true
    });
})();*/
var extTypeahead = function( _ ){
    $.typeahead({
        input: _.slt,
        minLength: 0,
        maxItem: 10,
        order: "asc",
        hint: true,
        cache: true,
        searchOnFocus: true,
        template: '<span class="row">' +
                '<span class="nimi">{{nimi}}</span>' +
        '</span>',
        correlativeTemplate: true,
        source: {
            joukko1: {
                url: _.url
            }
        },
        callback: {
            onClickAfter: function (node, a, item, event) {
                console.log(JSON.stringify(item));
                setTimeout(function(){
                    $('#result-container').empty();
                },3000);
            },
            onResult: function (node, query, obj, objCount) {
                var text = "";
                if (query !== "") {
                    text = objCount + ' elements matching <b>"' + query + '"</b>';
                }
                $('#result-container').html(text);
            }
        },
        debug: true
    });
};