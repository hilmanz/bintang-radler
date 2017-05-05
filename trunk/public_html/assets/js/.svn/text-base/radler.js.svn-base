$(document).ready(function() { 
	$("body").addClass(BrowserDetect.browser); 
/*	$( ".btnicon,.arrowBack2" ).click(function() {
		var targetID = jQuery(this).attr('href');
		$(targetID).toggleClass('playanim');
 	    return false;
	});
	$( ".occasion" ).click(function() {
		$(this).toggleClass('playanim');
 	    return false;
	});
	;*/
	$( ".arrowBack" ).click(function() {
		var targetID = jQuery(this).attr('href');
		$(".icon_beer").removeClass("active_beer");
		$(".icon_lemon").removeClass("active_lemon");
		$(targetID).toggleClass( "fadeInDowns" );
 	    return false;
	})
  $(function() {
	$( ".icon_beer" ).click(function() {
		$( "#beer-desc" ).toggleClass( "fadeInDowns" );
		$(this).toggleClass( "active_beer" );
		 return false;
	});
  });
  $(function() {
	$( ".icon_lemon" ).click(function() {
	    $( "#lemon-desc" ).toggleClass( "fadeInDowns" );
	    $(this).toggleClass( "active_lemon" );
	    return false;
	});
  });
	  
});
function handleChange(div,max){
		if(max){
			if ($(div).val() < 0) $(div).val(0);
			if ($(div).val() > max) $(div).val(max);
		}
	}
	function isNumberKey(evt,type){
		var charCode = (evt.which) ? evt.which : evt.keyCode
		if (charCode > 31 && (charCode < 48 || charCode > 57)){
			return false;
		}else{
			if(type=='day'){
				var dd = parseInt($("input[name='dday']").val());
				if(dd<=31&&dd!=0) return true;
				else console.log('foo');
			}else if(type=='month'){
				var mm = parseInt($("input[name='dmonth']").val());
				if(mm<=12&&mm!=0) return true;
			}else{
				return true;
			}
		}
	}