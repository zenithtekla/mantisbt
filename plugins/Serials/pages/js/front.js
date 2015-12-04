(function(){
    var content = document.getElementById('myData');
    var html = '';
    var data = {
        sales_order: 'Sales Order',
        customer: 'Customer',
        assembly: 'Assembly',
        revision: 'Revision',
		lang_013:"new serial number (auto-submit)",
		list_count: 'List Count',
		printbtn: 'Print',
		searchbtn: 'Search',
		resetbtn: 'Reset',
    };
    Handlebars.registerHelper('heading',function(text){
        text = Handlebars.escapeExpression(text);
       return new Handlebars.SafeString('<h2>'+text+'</h2>');
    });
    Handlebars.registerHelper('bold',function(text){
        text = Handlebars.escapeExpression(text);
       return new Handlebars.SafeString('<b>'+text+'</b>');
    });
    Handlebars.registerHelper('italic',function(text){
        text = Handlebars.escapeExpression(text);
       return new Handlebars.SafeString('<i>'+text+'</i>');
    });
    Handlebars.registerHelper("required", function(){
			return new Handlebars.SafeString('<span class="required"> * </span>');
	});
	Handlebars.registerHelper("notGreater", function(num1, num2, options){
		if (num2 > num1){
			return options.fn(this);
		} else {
			return options.inverse(this);
		}
	});		

    var template = Handlebars.compile(document.getElementById('url-template').innerHTML);
    content.innerHTML += template(data);
	$('#assembly .typeahead').prop( "disabled", true );
	$('#revision .typeahead').prop( "disabled", true );
	document.getElementById('customer').style.color="Red";
	document.getElementById('assembly').style.color="Red";
	document.getElementById('revision').style.color="Red";
	document.getElementById('sales_order').style.color="Red";
})();

(function(){
var jqDeferred = $.ajax({
  type: "POST",
  dataType: "json",
  url: "/mantislive/plugin.php?page=Serials/json/customer.php"});
  jqDeferred.then( function(data) {
    /*    $.each(data,function(i,v){
            console.log(v.format);
            $.each(v,function(i,va){
                console.log(va);
            })
        });
      $.map(data, function(obj) {
        console.log(obj.format + "example" + obj.format_example);
      }); http://forum.jquery.com/topic/jquery-and-json-troubles */
      // constructs the suggestion engine
      var engine = new Bloodhound({
        datumTokenizer: function (datum) {
          return Bloodhound.tokenizers.whitespace(datum.value);
        },
        queryTokenizer: Bloodhound.tokenizers.whitespace,
        // `data` is an array of country names defined in "The Basics"
        local: $.map(data, function(obj) {
            return { value : obj.customer_name, eg: obj.customer_id };
        }),
        limit: 10
      });

      // kicks off the loading/processing of `local` and `prefetch`
      engine.initialize();

      // Instantiate the Typeahead UI
      $('#customer .typeahead').typeahead(null, {
          name: 'data',
          displayKey: 'value',
          hint: true,
          highlight: true,
          minLength: 1,
          source: engine.ttAdapter(),
          templates: {
              empty: [
                '<div class="empty-message">',
                  'Result not found',
                '</div>'
              ].join('\n'),
              suggestion: Handlebars.compile("<div style='padding:6px'>{{value}}</div>"),
              footer: function (data) {
                return Handlebars.compile("<div>Searched for <strong> {{{data.query}}} </strong></div>");
                // return '<div>Searched for <strong>' + data.query + '</strong></div>';
              }
          }
      });
  })
  .fail(function(jqXHR, textStatus, errorThrown){
    console.log('ERROR', textStatus, errorThrown);
  });
  	$('#sales_order .typeahead').focus();
	$('input[name="list_count"]').val("0");
})();

(function(){
	document.getElementById('sales_order').addEventListener("change",function(){
            if( $('input[name="sales_order"]').val() == "" )
            {
                this.style.color = "red";
            }
            else
            {
               this.style.color = "black"; 
            }
        });
})();

(function(){
$('#customer .typeahead').bind('typeahead:select', function(ev, suggestion) {
  ev.stopPropagation();
  ev.preventDefault();
  $('#customer .typeahead').prop( "disabled", true );
  $('#assembly .typeahead').prop( "disabled", false );

  console.log('Selection: ' + JSON.stringify(suggestion));
  var myData = JSON.stringify({"customer_id": suggestion.eg});
  $("#result").append(myData + "<br/>");
  console.log('myData output :' + myData );
  $('input[name="customer_id"]').val(suggestion.eg);
  
  var jqDeferred = $.ajax({
    type:"POST",
    url: "/mantislive/plugin.php?page=Serials/json/assembly.php",
    data: {"customer_id": suggestion.eg},
    dataType: 'json',
  });
  jqDeferred.then( function(data) {

    // constructs the suggestion engine
    var engine = new Bloodhound({
      datumTokenizer: function (datum) {
        return Bloodhound.tokenizers.whitespace(datum.value);
      },
      queryTokenizer: Bloodhound.tokenizers.whitespace,
      // `data` is an array of country names defined in "The Basics"
      local: $.map(data, function(obj) {
          return { value : obj.assembly_number, eg: obj.customer_id };
      }),
      limit: 10
    });

    // kicks off the loading/processing of `local` and `prefetch`
    engine.initialize();

    // Instantiate the Typeahead UI
    $('#assembly .typeahead').typeahead(null, {
        name: 'data',
        displayKey: 'value',
        hint: true,
        highlight: true,
        minLength: 1,
        source: engine.ttAdapter(),
        templates: {
            empty: [
              '<div class="empty-message">',
                'Result not found',
              '</div>'
            ].join('\n'),
            suggestion: Handlebars.compile("<div style='padding:6px'>{{value}}</div>"),
            footer: function (data) {
              // return Handlebars.compile("<div>Searched for <strong> {{data.query}} </strong></div>");
              return '<div>Searched for <strong>' + data.query + '</strong></div>';
            }
        }
    });
    $('#customer .typeahead').typeahead('close');
	document.getElementById('customer').style.color="Black";
    $('#assembly .typeahead').focus();
  })
  .fail(function(jqXHR, textStatus, errorThrown){
    console.log(jqXHR, textStatus, errorThrown);
  });
});
})();

(function(){
/*$('#assembly .typeahead').on('blur', function(event) {
  event.stopPropagation();
  $('#assembly .typeahead').typeahead('close');
});  */
$('#assembly .typeahead').bind('typeahead:select', function(ev, suggestion) {
  ev.stopPropagation();
  ev.preventDefault();
  $('#assembly .typeahead').prop( "disabled", true );
  $('#revision .typeahead').prop( "disabled", false );

  console.log('Selection: ' + JSON.stringify(suggestion));
  var myData = JSON.stringify({"assembly_number": suggestion.value});
  $("#result").append(myData + "<br/>");

  var jqDeferred = $.ajax({
    type:"POST",
    url: "/mantislive/plugin.php?page=Serials/json/revision.php",
    data: {"assembly_number": suggestion.value, "customer_id": suggestion.eg},
    dataType: 'json',
  });
  jqDeferred.then( function(data) {
      // constructs the suggestion engine
      var engine = new Bloodhound({
        datumTokenizer: function (datum) {
          return Bloodhound.tokenizers.whitespace(datum.value);
        },
        queryTokenizer: Bloodhound.tokenizers.whitespace,
        // `data` is an array of country names defined in "The Basics"
        local: $.map(data, function(obj) {
            return { value : obj.revision, eg: obj.assembly_id };
        }),
        limit: 10
      });

      // kicks off the loading/processing of `local` and `prefetch`
      engine.initialize();

      // Instantiate the Typeahead UI
      $('#revision .typeahead').typeahead(null, {
          name: 'data',
          displayKey: 'value',
          hint: true,
          highlight: true,
          minLength: 1,
          source: engine.ttAdapter(),
          templates: {
              empty: [
                '<div class="empty-message">',
                  'Result not found',
                '</div>'
              ].join('\n'),
              suggestion: Handlebars.compile("<div style='padding:6px'>{{value}}</div>"),
              footer: function (data) {
                // return Handlebars.compile("<div>Searched for <strong> {{data.query}} </strong></div>");
                return '<div>Searched for <strong>' + data.query + '</strong></div>';
              }
          }
      });
      $('#assembly .typeahead').typeahead('close');
	  document.getElementById('assembly').style.color="Black";
      $('#revision .typeahead').focus();
  })
  .fail(function(jqXHR, textStatus, errorThrown){
    console.log(jqXHR, textStatus, errorThrown);
  });
});
})();

(function(){
$('#revision .typeahead').bind('typeahead:select', function(ev, suggestion) {
  ev.stopPropagation();
  ev.preventDefault();
  $('#revision .typeahead').prop( "disabled", true );
  document.getElementById('revision').style.color="Black";
  $('input[name="assembly_id"]').val(suggestion.eg);
  console.log('Selection: ' + JSON.stringify(suggestion));
  var myData = JSON.stringify({"assembly_id": suggestion.eg});
  $("#result").append(myData + "<br/>");
  var jqDeferred = $.ajax({
    type:"POST",
    url: "/mantislive/plugin.php?page=Serials/json/format.php",
    data: {"assembly_id": suggestion.eg},
    dataType: 'json',
  });
  jqDeferred.then( function(data) { 
	$.map(data, function(obj) {
	  console.log(obj.format, obj.format_id);
	  $('input[name="format"]').val(obj.format);
	  $('input[name="format_id"]').val(obj.format_id);
	  $('input[name="format_example"]').val(obj.format_example);
	}); 
  })
  .fail(function(jqXHR, textStatus, errorThrown){
    console.log(jqXHR, textStatus, errorThrown);
  });
  $('input[id="scan_result"]').focus();
});
})();

/*var $t_format_example = $( this ).find( 'input:hidden' );
  var foo = $('input.typeahead.tt-input').val();
  console.log(foo);
  $( this ).find( 'input:hidden' ).val(foo); */
  
$(document).ready(function() {
/*     $("#tulostaa-painike").on('click', function() {
      $("#printable").print({
        deferred: $.Deferred(),
        timeout: 250
      });
    }); */
/* 	$("#reset").on('click', function() {
		location.reload();
    }); */
	$("#search").on({
		// $(#log-wrapper).val();
		// $(#log-wrapper).text();
		// $(#log-wrapper).html(); 		
		click: function(){		
		var postdata ={
			sales_order: $('input[name="sales_order"]').val(),
			scan_input: $('input[name="scan_input"]').val(),
			customer_id: $('input[name="customer_id"]').val(),
			assembly_id: $('input[name="assembly_id"]').val(),
			assembly_number: $('input[name="assembly"]').val(),
		};
		 console.log($('input[name="sales_order"]').val());
		 console.log($('input[name="assembly"]').val());
		// console.log(q);
		$.ajax({
			type:'POST',
			url: '/mantislive/plugin.php?page=Serials/search.php',
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
		}		
	});
    $("#scan_result").on({
        mouseenter: function(){
            $(this).css("background-color", "lightgray");
        },
        mouseleave: function(){
            $(this).css("background-color", "lightblue");
        },
        click: function(){
            $(this).css("background-color", "yellow");
        },
        keyup: function(e){
            e.preventDefault();
			if( $('input[name="sales_order"]').val() == "" )
            {
                document.getElementById('sales_order').style.color= "red";
            }
            else
            {
				document.getElementById('sales_order').style.color="Black";
				$('#sales_order .typeahead').prop( "disabled", true );
            }
			
            switch (e.which) {
                case 13:
                    var postdata ={
						new_scan: $(this).val(),
						customer_id: $('input[name="customer_id"]').val(),
						assembly_id: $('input[name="assembly_id"]').val(),
						sales_order: $('input[name="sales_order"]').val(),
						format: $('input[name="format"]').val(),
						format_example: $('input[name="format_example"]').val(),
						list_count: $('input[name="list_count"]').val(),
						revision: $('input[name="revision"]').val(),
					};
					 console.log($('input[name="list_count"]').val());
                    // console.log(q);
                    $.ajax({
                        type:'POST',
                        url: '/mantislive/plugin.php?page=Serials/scan_proc.php',
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
						var newcount = Number($('input[name="list_count"]').val()) + Number(1);			
						$('input[name="list_count"]').val(newcount);
						document.getElementById('scan_result').select();
                        $("#virhe").empty().append("last scan: " + data);
                        $("#log-wrapper")  .append( data )
                                            .addClass("bg-success")
                                            .css({  "max-height":"300px",
                                                    "overflow-y" : "auto" })
                        .animate({"scrollTop": $("#log-wrapper")[0].scrollHeight}, "slow");							
                        }
                    }).fail(function(jqXHR,textStatus, errorThrown){
                        $("#virhe") .removeClass("alert-success")
                                    .addClass("alert-danger")
                                    .empty().append('!ERROR: ' + textStatus + ", " + errorThrown);
                        console.log('ERROR', textStatus, errorThrown);
                    });
                    break;

            }
        }
    });
    // autofocus on scan field
/*    $('#scan_result').focus();

    $('#scan_result').scannerDetection({
      timeBeforeScanTest: 200, // wait for the next character for upto 200ms
      startChar: [120], // Prefix character for the cabled scanner (OPL6845R)
      endChar: [13], // be sure the scan is complete if key 13 (enter) is detected
      avgTimeByChar: 40, // it's not a barcode if a character takes longer than 40ms
      onKeyDetect: function(event){console.log(event.which); return false;}
      onComplete: function(barcode){
       // alert("# : ", barcode);
        $(this).parent().submit();
      } // main callback function
    }); */
/* 
    $('#is_logout').on('click',function(e){
        e.preventDefault();
        $.post("../controller/core/is_logout.php", {"is_logout": true}, function(data){
          if (data.is_logout) window.location = "../controller/core/logout.php";
        },"json");
    }); */ /*

    $('#is_logout').on('click',function(){
            $.post("../controller/core/is_logout.php", {is_logout : true}, function(data){
                console.log(data);
                var arr = $.parseJSON(data);
                console.log(arr);
                if (arr.is_logout)
                    window.location = "../controller/core/logout.php";
            });
    }); */
});  