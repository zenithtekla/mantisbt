(function(){
  var content = document.getElementById('ui_data');
  var data = JSON.parse(localStorage.getItem("tpl_data"));
  
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

  var template = Handlebars.compile(document.getElementById('ui-template').innerHTML);
  content.innerHTML += template(data);

	$('#assembly .typeahead').prop( "disabled", true );
	$('#revision .typeahead').prop( "disabled", true );
	document.getElementById('customer').style.color="Red";
	document.getElementById('assembly').style.color="Red";
	document.getElementById('revision').style.color="Red";
	document.getElementById('sales_order').style.color="Red";
})();

var dnm_data = {
  sales_order:$('input[name="sales_order"]').val(),
  list_count: 0
};

(function(){
  var jqDeferred = $.ajax({
    type: "POST",
    dataType: "json",
    url: "plugin.php?page=Serials/json/customer.php"
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
  },
  function(jqXHR, textStatus, errorThrown){
    console.log('ERROR', textStatus, errorThrown);
  });
  // 	$('input[name="list_count"]').val("0");
})();

(function(){
	/*$("#sales_order").on("change",function(){
	    this.style.color = ( $('input[name="sales_order"]').val() == "" ) ? "red" : "black";
  });*/
  document.getElementById('sales_order').addEventListener("change",function(){
    this.style.color = (document.getElementsByName('sales_order')[0].value == "" ) ? "red" : "black";
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
  $("#log-verify").append(myData + "<br/>");
  dnm_data.customer_name = suggestion.value;
  dnm_data.customer_id = suggestion.eg;
  console.log(' ## customer selected');
  console.log(dnm_data);
  // $('input[name="customer_id"]').val(suggestion.eg);

  var jqDeferred = $.ajax({
    type:"POST",
    url: "plugin.php?page=Serials/json/assembly.php",
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
    $('#assembly .typeahead').focus();
    document.getElementById('customer').style.color="Black";
  },
  function(jqXHR, textStatus, errorThrown){
    console.log(jqXHR, textStatus, errorThrown);
  });
});
})();

(function(){
$('#assembly .typeahead').bind('typeahead:select', function(ev, suggestion) {
  ev.stopPropagation();
  ev.preventDefault();
  $('#assembly .typeahead').prop( "disabled", true );
  $('#revision .typeahead').prop( "disabled", false );

  console.log('Selection: ' + JSON.stringify(suggestion));
  var myData = JSON.stringify({"assembly_number": suggestion.value});
  dnm_data.assembly_number = suggestion.value;
  console.log(' ## assembly selected');
  console.log(dnm_data);
  $("#log-verify").append(myData + "<br/>");

  var jqDeferred = $.ajax({
    type:"POST",
    url: "plugin.php?page=Serials/json/revision.php",
    data: {"assembly_number": suggestion.value, "customer_id": suggestion.eg},
    dataType: 'json'
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
    $('#revision .typeahead').focus();
    document.getElementById('assembly').style.color="Black";
  },
  function(jqXHR, textStatus, errorThrown){
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
  dnm_data.revision = suggestion.value;
  dnm_data.assembly_id = suggestion.eg;
  // $('input[name="assembly_id"]').val(suggestion.eg);
  console.log('Selection: ' + JSON.stringify(suggestion));
  var myData = JSON.stringify({"assembly_id": suggestion.eg});
  console.log(' ## revision selected');
  console.log(dnm_data);
  $("#log-verify").append(myData + "<br/>");
  var jqDeferred = $.ajax({
    type:"POST",
    url: "plugin.php?page=Serials/json/format.php",
    data: {"assembly_id": suggestion.eg},
    dataType: 'json',
  });
  jqDeferred.then( function(data) {
    $.map(data, function(obj) {
      console.log(obj.format, obj.format_id);
      // $('input[name="format"]').val(obj.format);
      dnm_data.format = obj.format;
      dnm_data.format_id = obj.format_id;
      dnm_data.format_example = obj.format_example;
      // $('input[name="format_id"]').val(obj.format_id);
      // $('input[name="format_example"]').val(obj.format_example);
    });
  },
  function(jqXHR, textStatus, errorThrown){
    console.log(jqXHR, textStatus, errorThrown);
  });
  $('input[id="scan_result"]').focus();
});
})();

$(document).ready(function() {
  $("#tulostaa-painike").on('click', function() {
    $("#printable").print({
      globalStyles : false,
      deferred: $.Deferred(),
      timeout: 250
    });
  });
 	
 	$("#reset").on('click', function() {
		  location.reload();
  }); 
	
	$("#search").on({
		click: function(){
		  search_process();
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
  		  document.getElementById('sales_order').style.color= "red";
      else  {
  			document.getElementById('sales_order').style.color="Black";
  			$('#sales_order .typeahead').prop( "disabled", true );
      }

      switch (e.which) {
        case 13:
        scan_process($(this).val());
        break;
      }
    }
  });
});