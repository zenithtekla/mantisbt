var search_process = function(){
  /*global localStorage*/
	var addUserData = function(data){
    dnm_data.user_id        = data.id;
    dnm_data.user_password  = data.password;
    dnm_data.user_email     = data.email;
    dnm_data.user_lastvisit = data.last_visit;
  };

	ajaxPost({
      url: "plugin.php?page=Serials/model/json/userAuth.php",
      data: "",
      callback: addUserData
  });

  var hash = JSON.parse(localStorage.getItem("xhr"));
  /*global dnm_data*/
  if (hash){
    dnm_data.customer_id      = hash.customer_id;
    dnm_data.assembly_id      = hash.assembly_id;
    dnm_data.assembly_number  = hash.assembly;
  }

  dnm_data.sales_order  = $('input[name="sales_order"]').val();
	dnm_data.scan_input   = $("#scan_result").val();
	/*dnm_data.customer = $("#field1").val();
  dnm_data.assembly = $("#field2").val();
  dnm_data.revision = $("#field3").val();*/

	var postdata ={
		sales_order:        dnm_data.sales_order,
		scan_input:         dnm_data.scan_input,
		customer_id:        dnm_data.customer_id,
		assembly_id:        dnm_data.assembly_id,
		assembly_number:    dnm_data.assembly_number,
	};
	console.log(dnm_data);

	$.ajax({
		type:'POST',
		url: 'plugin.php?page=Serials/controllers/search.php',
		data: postdata,
		//contentType: "application/json",
		// dataType: 'json'
	}).done(function(data){
		$("#search-wrapper") .empty()
        .append( data + "<br/>")
        .addClass("bg-success")
        .css({  "max-height":"300px", "overflow-y" : "auto" })
        .animate({"scrollTop": $("#search-wrapper")[0].scrollHeight}, "slow");

	});

	$.ajax({
		type:'POST',
		url: '/plugin.php?page=Serials/controllers/search-list.php',
		data: postdata,
		//contentType: "application/json",
		// dataType: 'json'
	}).done(function(data){
		$("#log-wrapper").empty()
        .append( data + "<br/>")
        .addClass("bg-success")
        .css({  "max-height":"300px", "overflow-y" : "auto" })
		    .animate({"scrollTop": $("#log-wrapper")[0].scrollHeight}, "slow");
    //console.log($("#log-wrapper").html());
	});
};

var scan_process = function(v){
  dnm_data.sales_order  = $('input[name="sales_order"]').val();
  dnm_data.revision     = $("#field3").val();

  var hash = JSON.parse(localStorage.getItem("xhr"));
    dnm_data.customer_id    = hash.customer_id;
    dnm_data.assembly_id    = hash.assembly_id;
    dnm_data.format         = hash.format;
    dnm_data.format_example = hash.format_example;

var postdata ={
	new_scan: v,
	customer_id:       dnm_data.customer_id,
	assembly_id:       dnm_data.assembly_id,
	sales_order:       dnm_data.sales_order,
	format:            dnm_data.format,
	format_example:    dnm_data.format_example,
	revision:          dnm_data.revision,
};

console.log(postdata);

$.ajax({
    type:'POST',
    url: 'plugin.php?page=Serials/controllers/scan_proc.php',
    data: postdata,
    //contentType: "application/json",
    // dataType: 'json'
}).done(function(data){
    if (data.indexOf('ERROR')>-1){
        $("#virhe") .removeClass("alert-success")
                    .addClass("alert-danger");
        $("#virhe").empty().append("Attention: " + data)
                    .css({  "max-height":"300px",
                                "overflow-y" : "auto" });
    } else {
        $("#virhe") .removeClass("alert-danger")
                    .addClass("alert-success");
    		dnm_data.list_count += 1;
    		document.getElementById('scan_result').select();
    		var data_output =  "<b>" + dnm_data.list_count + ".</b> " + data;
        $("#virhe").empty().append("<div class='text-center'>last scan: " + data_output + "</div>");

        if (dnm_data.list_count % 3 === 0)
            data_output  = "<div class='col-xs-4'>" + data_output + "</div><div class='clearfix'></div>";
        else data_output = "<div class='col-xs-4'>" + data_output + "</div>";

        $("#log-wrapper")  .append( data_output )
                            .addClass("bg-success")
                            .css({  "max-height":"300px",
                                    "overflow-y" : "auto" })
        .animate({"scrollTop": $("#log-wrapper")[0].scrollHeight}, "slow");
    }
}).fail(function(jqXHR,textStatus, errorThrown){
        $("#virhe") .removeClass("alert-success")
                  .addClass("alert-danger")
                  .empty().append('!ERROR: ' + textStatus + ", " + errorThrown);
        console.log(jqXHR, textStatus, errorThrown);
    });
};

var p_idx = function(n) {
    return this[ Object.keys(this)[n] ];
};

var print_top = function(){
  var $t_str = print_bot();
  $t_str += "<hr><br/>";
  $("#log-verify").empty().html($t_str);
  return $t_str;
};

var print_bot = function(){
  var $t_str = "<div class='txt-left'>SerialScan v1.1</div><div class='txt-right'>Extract on " + dnm_data.time + " by " + dnm_data.user + " </div><div class='col-xs-12'>";
  var o = ['sales_order','customer','assembly','revision'];
  for (var i in o){
    var k = o[i];
    if (dnm_data.hasOwnProperty(k)){
      if (dnm_data[k].length)
        $t_str +=  "<div class='col-xs-3'>" + k + ": " + dnm_data[k] + "</div>";
    } else {
      var v = $('input[name="'+k+'"]').val();
      $t_str += "<div class='col-xs-3'>" + k + ": " + v + "</div>";
    }
  }
  $t_str += "</div>";
  return $t_str;
};

var print_html = function(){
  var x=window.open('','', 'height='+ (screen.height - 120) +', width='+screen.width);
  x.document.open().write('<head><title>Full-window display</title><link rel="stylesheet" type="text/css" href="plugins/Serials/pages/css/print.css"></head>'+
    '<body><div class="container-fluid">'
      + print_top() + $("#printable").html() +
    '</div></body>');
  // x.close();
};

var print_dialog = function(e){
  e.preventDefault;
  $("#printable").print({
    deferred: $.Deferred(),
    globalStyles : false,
    mediaPrint : false,
    stylesheet: "plugins/Serials/pages/css/print.css",
    timeout: 400,
    prepend: print_top()
  });
};