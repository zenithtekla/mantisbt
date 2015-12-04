var search_process = function(){
dnm_data.sales_order = $('input[name="sales_order"]').val();
	dnm_data.scan_input = $('input[name="scan_input"]').val();
	var postdata ={
		sales_order: dnm_data.sales_order,
		scan_input: dnm_data.scan_input,
		customer_id: dnm_data.customer_id,
		assembly_id: dnm_data.assembly_id,
		assembly_number: dnm_data.assembly_number,
	};
	
	$.ajax({
		type:'POST',
		url: 'plugin.php?page=Serials/search.php',
		data: postdata,
		//contentType: "application/json",
		// dataType: 'json'
	}).done(function(data){
		$("#log-wrapper").empty().append( data + "<br/>")
                                        .addClass("bg-success")
                                        .css({"overflow-y" : "auto" })
                    .animate({"scrollTop": $("#log-wrapper")[0].scrollHeight}, "slow");
		//console.log($("#log-wrapper").html());
	});
};

var scan_process = function(v){
dnm_data.sales_order = $('input[name="sales_order"]').val();
var postdata ={
	new_scan: v,
	customer_id: dnm_data.customer_id,
	assembly_id: dnm_data.assembly_id,
	sales_order: dnm_data.sales_order,
	format: dnm_data.format,
	format_example: dnm_data.format_example,
	revision: dnm_data.revision,
};

console.log(postdata);
// console.log(q);

$.ajax({
    type:'POST',
    url: 'plugin.php?page=Serials/scan_proc.php',
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
    		data_output =  "<b>" + dnm_data.list_count + ".</b> " + data;
        $("#virhe").empty().append("<div class='text-center'>last scan: " + data_output + "</div>");
        $("#log-wrapper")  .append( "<div class='col-md-4'>" + data_output + "</div>" )
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