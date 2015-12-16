(function () {
    "use strict";
    var dnm_data = {
        time: $('.login-info-middle :first-child').text(),
        list_count: 0
    };
    
    var xhr = {};
    var deferred = $.Deferred();

    var fn1 = function(){
        return new Promise(function(suc, err){
            extTypeahead({
                slt: "#field1",
                url: "/plugin.php?page=Serials/json/customer.php",
                callback: function(item){
                    xhr = {
                        customer_name: item.nimi,
                        customer_id: item.id
                    };
                    localStorage.setItem("xhr", localStorage.getItem("xhr") + JSON.stringify(item));
                    setTimeout(function(){
                        suc(xhr);
                    },10);
                }
            });
        });
    };
    
    /*dnm_data.customer_name = xhr.nimi;
    dnm_data.customer_id = xhr.id;*/
    var fn2 = function (o){
        return new Promise(function(suc, err){
            extTypeahead({
                slt: "#field2",
                url: "/plugin.php?page=Serials/json/assembly.php&d="+o.customer_id,
                callback: function(item){
                    o.assembly = item.nimi;
                    // console.log(dnm_data);
                    localStorage.setItem("xhr", localStorage.getItem("xhr") + JSON.stringify(item));
                    setTimeout(function(){
                        suc(o);
                    },10);
                }
            });
        });
    };
    
    var fn3 = function (o){
        return new Promise(function(suc,err){
            extTypeahead({
                slt: "#field3",
                url: {
                    type: "GET",
                    url: "/plugin.php?page=Serials/json/revision.php&d1="
                    +o.customer_id+"&d2="
                    +o.assembly
                },   
                callback: function(item){
                    o = {
                        revision: item.nimi,
                        assembly_id: item.id
                    };
                    ajaxPost({
                        url: "plugin.php?page=Serials/json/format.php",
                        d: { "assembly_id" : o.assembly_id },
                        callback: addformat
                    });
                    localStorage.setItem("xhr", localStorage.getItem("xhr") + JSON.stringify(item));
                    setTimeout(function(){
                        suc(o);
                    },10);
                    // $("#field4").focus();
                    // console.log(dnm_data);
                }
            });
        });
    };
    // A().then(B).then(C).then(D);
    
    fn1()
    .then(function(v){
            return fn2(v);
            // $("#field2").focus();
        })
    .then(function(v){
            return fn3(v);
            // $("#field3").focus();
        })
    ;
    
/*    extTypeahead({
        slt: "#field4",
        url: "/plugin.php?page=Serials/json/format_helper.php"
    });*/
    /*extTypeahead({
        slt: "#field6",
        url: "/plugin.php?page=Serials/json/format.php",
        callback: function(item){
            dnm_data.format = item.nimi;
            dnm_data.format_id = item.id;
            dnm_data.format_example = item.sample;
            $("#field6").focus();
            console.log(dnm_data);
        }
    });*/
    
    var addformat = function(data){
        $.map(data, function(obj) {
            /*console.log(obj.format, obj.format_id);
            dnm_data.format = obj.format;
            dnm_data.format_id = obj.format_id;
            dnm_data.format_example = obj.format_example;*/
            $("#field5").val(obj.sample);
            $("#field6").val(obj.nimi);
        });
    };
})();