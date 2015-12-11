// plugin.php?page=Serials/json/customer.php
/*(function(){
    $.typeahead({
        input: "#field1",
        minLength: 0,
        maxItem: 15,
        order: "asc",
        hint: true,
        searchOnFocus: true,
        backdrop: {
            "background-color": "#3879d9",
            "opacity": "0.1",
            "filter": "alpha(opacity=10)"
        },
        template: '<span class="row">' +
            '<span class="nimi">{{nimi}}</span>' +
            '<span class="id">({{id}})</span>' +
        "</span>",
        source: {
            customer:  {
                display:"nimi",
                data: [{
                  "id": "007",
                  "nimi": "James Bond"
                }],
                url: [{
                    type:"POST",
                    url: "/plugin.php?page=Serials/json/customer.php",
                    data: {
                        q: "{{query}}"
                    }
                }, "data.kayttaja"]
            }
        },
        callback: {
            onClickAfter: function (node, a, item, event) {
                // $('#result-container').text('');
                console.log(item.display);
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

$.typeahead({
    input: "#field1",
    minLength: 0,
    maxItem: 8,
    maxItemPerGroup: 6,
    order: "asc",
    hint: true,
    cache: true,
    searchOnFocus: true,
    group: ["division", "{{group}} division"],
    display: ["name", "id"],
    dropdownFilter: [
        {
            key: 'conference',
            value: 'Western',
            display: '<strong>Western</strong> Conference'
        },
        {
            key: 'conference',
            value: 'Eastern',
            display: '<strong>Eastern</strong> Conference'
        },
        {
            value: '*',
            display: 'All Teams'
        }
    ],
    template: '<span>' +
        '<span class="name">{{nimi}}</span>' +
        '<span class="division">       <small style="color:#999;">{{id}}</small></span>' +
    '</span>',
    correlativeTemplate: true,
    source: {
        teams: {
            url: "/plugin.php?page=Serials/json/customer.php"
        }
    }
});