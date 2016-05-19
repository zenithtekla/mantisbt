var dnm_data = {
  user: $('.login-info-left :first-child').text(),
  time: $('.login-info-middle :first-child').text(),
  list_count: 0
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
 	    localStorage.clear();
		  location.reload();
  });

	$("#search").on({
		click: function(e){
		  e.preventDefault();
		  search_process();
		}
	});

  $("#field1,#field2,#field3,#field7")
  .on('keyup', function(e){
    // e.preventDefault();
    if (e.which == 118) // F7
    {
      console.log($(this).attr("id"), " F7 key pressed");
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
      switch (e.which) {
        case 118:
          search_process();
        break;
        case 13:
        if( $("#field7").val() == "" )
            document.getElementById('typeahead-field7').style.color= "red";
        else  {
          document.getElementById('typeahead-field7').style.color="black";
  				document.getElementById('field1').disabled=true;
  				document.getElementById('field2').disabled=true;
  				document.getElementById('field3').disabled=true;
  				document.getElementById('field7').disabled=true;
        }
        scan_process($(this).val());
        break;
      }
    }
  });
});