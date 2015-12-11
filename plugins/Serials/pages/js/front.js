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
  time: $("#time").text(),
  sales_order: $('input[name="sales_order"]').val(),
  list_count: 0
};

// load customer
(function(){
  var d = {
    url : "plugin.php?page=Serials/json/customer.php",
    slt : '#customer .typeahead'
  };
  // obj.customer_name, obj.customer_id
  bloodhoundAjax(d);

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

// customer selected, load assembly
(function(){
$('#customer .typeahead').bind('typeahead:select', function(ev, suggestion) {
  ev.stopPropagation();
  ev.preventDefault();
  $('#customer .typeahead').prop( "disabled", true );
  $('#assembly .typeahead').prop( "disabled", false );

  console.log('Selection: ' + JSON.stringify(suggestion));
  var myData = JSON.stringify({"customer_id": suggestion.eg});
  $("#log-verify").append(myData + "<br/>");
  dnm_data.customer = suggestion.value;
  dnm_data.customer_id = suggestion.eg;
  console.log(' ## customer selected');
  console.log(dnm_data);
  // $('input[name="customer_id"]').val(suggestion.eg);

  var customer_styling = function(){
    $('#customer .typeahead').typeahead('close');
    $('#assembly .typeahead').focus();
    document.getElementById('customer').style.color="Black";
  }

  var d = {
    url : "plugin.php?page=Serials/json/assembly.php",
    data: {"customer_id": suggestion.eg},
    callback: customer_styling,
    slt : '#assembly .typeahead'
  };
  // obj.assembly_number, obj.revision
  bloodhoundAjax(d);
});
})();

// assembly selected, load revision
(function(){
$('#assembly .typeahead').bind('typeahead:select', function(ev, suggestion) {
  ev.stopPropagation();
  ev.preventDefault();
  $('#assembly .typeahead').prop( "disabled", true );
  $('#revision .typeahead').prop( "disabled", false );

  console.log('Selection: ' + JSON.stringify(suggestion));
  var myData = JSON.stringify({"assembly_number": suggestion.value});
  dnm_data.assembly = suggestion.value;
  console.log(' ## assembly selected');
  console.log(dnm_data);
  $("#log-verify").append(myData + "<br/>");

  var customer_styling = function(){
    $('#assembly .typeahead').typeahead('close');
    $('#revision .typeahead').focus();
    document.getElementById('assembly').style.color="Black";
  }

  var d = {
    url : "plugin.php?page=Serials/json/revision.php",
    data: {"assembly_number": suggestion.value, "customer_id": suggestion.eg},
    callback: customer_styling,
    slt : '#revision .typeahead'
  };
  // obj.assembly_number, obj.revision
  bloodhoundAjax(d);

});
})();

// revision selected, save the format
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

var print_r = function(){
  var $t_str = "<div class='txt-left'>SerialScan v1.1</div><div class='txt-right'>Extract on " + dnm_data.time + "</div><div class='col-xs-12'>";
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
  $t_str += "</div><hr><br/>";
  $("#log-verify").empty().html($t_str);
  return $t_str;
};

var print_html = function(){
  var x=window.open('','', 'height='+ (screen.height - 120) +', width='+screen.width);
  x.document.open().write('<head><title>Full-window display</title><link rel="stylesheet" type="text/css" href="plugins/Serials/pages/css/print.css"></head>'+ 
    '<body><div class="container-fluid">'
      + print_r() + $("#printable").html() +
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
    prepend: print_r()
  });
};

$(document).ready(function() {
  $(document).on('keyup',function(f){
    f.preventDefault;
    if (f.which == 120) // F9
    {
      console.log(f.which);
      print_dialog;
    }
  });
  
  $("#tulostaa-painike").on({
    click: print_dialog
  });
  
  $("#html-painike").on({
    click: print_html
  });

 	$("#reset").on('click', function(e) {
 	    e.preventDefault();
		  location.reload();
  });

	$("#search").on({
		click: function(e){
		  e.preventDefault();
		  search_process();
		}
	});

  $("#sales_order,#customer,#assembly,#revision")
    .on('keyup', function(e){
        e.preventDefault();
        if (e.which == 119) // F8
          search_process();
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
      switch (e.which) {
        case 119:
          search_process();
        break;
        case 13:
        if( $('input[name="sales_order"]').val() == "" )
            document.getElementById('sales_order').style.color= "red";
        else  {
                document.getElementById('sales_order').style.color="Black";
                $('#sales_order .typeahead').prop( "disabled", true );
        }
        scan_process($(this).val());
        break;
      }
    }
  });
});