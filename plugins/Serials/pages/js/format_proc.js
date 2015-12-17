(function () {
    "use strict";
    var dnm_data = {
        time: $('.login-info-middle :first-child').text(),
        list_count: 0
    };
    
    var xhr = {};
    var old;
    var oldh = {};
    // var deferred = $.Deferred();

    var fn1 = function(){
        return new Promise(function(suc, err){
            extTypeahead({
                slt: "#field1",
                url: "/plugin.php?page=Serials/json/customer.php",
                callback: function(item){
                    var hash = {};
                    console.log( " # pre-assign@fn1 $ print xhr");
                    console.log(localStorage.getItem("xhr"));
                    if (localStorage.getItem("xhr")) {
                        old = localStorage.getItem("xhr");
                        oldh = JSON.parse(localStorage.getItem("xhr"));
                        hash = oldh;
                    }
                    
                    hash.customer_name = item.nimi;
                    hash.customer_id = item.id;
                    hash.group = item.group;

                    localStorage.setItem("xhr", JSON.stringify(hash));
                    console.log(" # post-assign@fn1 $ print xhr ");
                    console.log(localStorage.getItem("xhr"));
                    console.log(" # post-assign@fn1 $ print old ");
                    console.log(old);
                    setTimeout(function(){
                        suc(hash);
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
                    var hash = JSON.parse(localStorage.getItem("xhr"));
                    o.assembly = item.nimi;
                    hash.assembly = item.nimi;
                    // console.log(dnm_data);
                    localStorage.setItem("xhr", JSON.stringify(hash));
                    console.log(" # post-async@fn2 $ ");
                    console.log(localStorage.getItem("xhr"));
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
                    var hash = JSON.parse(localStorage.getItem("xhr"));
                    hash.revision = item.nimi;
                    hash.assembly_id = item.id;
                    
                    o = {
                        revision: item.nimi,
                        assembly_id: item.id
                    };
                    
                    localStorage.setItem("xhr", JSON.stringify(hash));
                    console.log(" # post-async@fn3 $ print O and xhr ");
                    console.log(JSON.stringify(o));
                    console.log(localStorage.getItem("xhr"));
                    
                    ajaxPost({
                        url: "plugin.php?page=Serials/json/format.php",
                        d: { "assembly_id" : o.assembly_id },
                        callback: addformat
                    });
                    
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
    var exec = function(){
        fn1()
        .then(function(v){
                return fn2(v);
                $("#field2").focus();
            })
        .then(function(v){
                return fn3(v);
                // $("#field3").focus();
            })
        ;
    };
    exec();
    
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
            console.log(" # check if old is accessible inside ajax of fn3 " + old);
        });
    };
})();