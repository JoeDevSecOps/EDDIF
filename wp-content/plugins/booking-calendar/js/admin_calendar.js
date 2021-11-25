var wpdevart_elements = {
    checkbox_enable : function(element){
		if (jQuery('#' + element.id).prop('checked')) {
			if (!jQuery('#' + element.id).closest('.wpdevart-item-container').next().next().hasClass("items_open")) {
			  for (i = 0; i < element.enable.length; i++) {
				 jQuery('#wpdevart_wrap_'+element.enable[i]).parent().parent().slideDown();
			  }
			} else  {
				 jQuery('#' + element.id).closest('.wpdevart-item-container').next().next().slideDown();
			}
		}
		else{
		  if (!jQuery('#' + element.id).closest('.wpdevart-item-container').next().next().hasClass("items_open")) {	
			  for (i = 0; i < element.enable.length; i++) { 
				 jQuery('#wpdevart_wrap_'+element.enable[i]).parent().parent().slideUp();
			  }
		  } else  {
				 jQuery('#' + element.id).closest('.wpdevart-item-container').next().next().slideUp();
			}
		}
    },
    radio_enable : function(element){
		var sel = jQuery('input[type=radio][name="' + element.id + '"]:checked').val();
		for (i = 0; i < element.enable.length; i++) {
		  for (j = 0; j < element.enable[i].val.length; j++) {
			jQuery('#wpdevart_wrap_'+element.enable[i].val[j]).parent().parent().slideUp();
		 }
		}
		for (i = 0; i < element.enable.length; i++) {
		  if(element.enable[i].key == sel){
		    for (j = 0; j < element.enable[i].val.length; j++) {
			  jQuery('#wpdevart_wrap_'+element.enable[i].val[j]).parent().parent().slideDown();
			}
		  }
		}
	}
};


function wpdevart_set_value(id,value) {
	jQuery("#"+id).val(value);
}
function wpdevart_form_submit(event, form_id) {
  if (jQuery("#"+form_id)) {
    jQuery("#"+form_id).submit();
  }
  if (event.preventDefault) {
    event.preventDefault();
  }
  else {
    event.returnValue = false;
  }
}


function check_all_checkboxes(el,el_class) {
  if (jQuery(el).context.checked == true) {
	jQuery( "."+el_class ).each(function(){
		jQuery(this).context.checked = true;
	});  
  }
  else {
	jQuery( "."+el_class ).each(function(){
		jQuery(this).context.checked = false;
	});
  }
}

function submit_form(id){
	jQuery("#"+id).trigger("click");
}
function add_default(el,arg){
	var hours_default = ["00:00-01:00","01:00-02:00","02:00-03:00","03:00-04:00","04:00-05:00","05:00-06:00","06:00-07:00","07:00-08:00","08:00-09:00","09:00-10:00","10:00-11:00","11:00-12:00","12:00-13:00","13:00-14:00","14:00-15:00","15:00-16:00","16:00-17:00","17:00-18:00","18:00-19:00","19:00-20:00","20:00-21:00","21:00-22:00","22:00-23:00","23:00-24:00"];
	var hour_items = "";
	if(!jQuery(el).parent().find(".hours_default").length) {
		for(var i = 0; i < hours_default.length; i++) {
			hour_items += "<div class='hours_default hour_element div-for-clear'> <input type='text' class='hour_value short_input' value='" +hours_default[i] + "' name='"+arg+"[hour_value][]' placeholder='"+wpdevart.hour+"'> <input type='text' class='hour_price short_input' value='' name='"+arg+"[hour_price][]' placeholder='"+wpdevart.price+"'><input type='text' class='hours_marked_price short_input' value='' name='"+arg+"[hours_marked_price][]' placeholder='"+wpdevart.marked_price+"'><select name='"+arg+"[hours_availability][]' class='half_input'><option value='available'>"+wpdevart.available+"</option><option value='booked'>"+wpdevart.booked+"</option><option value='unavailable'>"+wpdevart.unavailable+"</option></select><input type='text' class='hours_number_availability half_input' value='' name='"+arg+"[hours_number_availability][]' placeholder='"+wpdevart.number_availability+"'><input type='text' class='hour_info full_input' value='' name='"+arg+"[hour_info][]' placeholder='"+wpdevart.h_info+"'> <span class='delete_hour_item'><i class='fa fa-close'></i></span> </div>";
		}
	}
	
	jQuery(el).parent().append(hour_items);
}
function add_hour(el,arg){
	var hour_item = "<div class='hour_element div-for-clear'> <input type='text' class='hour_value short_input' value='' name='"+arg+"[hour_value][]' placeholder='"+wpdevart.hour+"'> <input type='text' class='hour_price short_input' value='' name='"+arg+"[hour_price][]' placeholder='"+wpdevart.price+"'><input type='text' class='hours_marked_price short_input' value='' name='"+arg+"[hours_marked_price][]' placeholder='"+wpdevart.marked_price+"'><select name='"+arg+"[hours_availability][]' class='half_input'><option value='available'>"+wpdevart.available+"</option><option value='booked'>"+wpdevart.booked+"</option><option value='unavailable'>"+wpdevart.unavailable+"</option></select><input type='text' class='hours_number_availability half_input' value='' name='"+arg+"[hours_number_availability][]' placeholder='"+wpdevart.number_availability+"'><input type='text' class='hour_info full_input' value='' name='"+arg+"[hour_info][]' placeholder='"+wpdevart.h_info+"'> <span class='delete_hour_item'><i class='fa fa-close'></i></span> </div>";
	
	jQuery(el).parent().append(hour_item);
}
/*
*Calendar
*/

jQuery( document ).ready(function() {
    var $ = jQuery;
	var ajax_next = "";
	$("body").on( "click", ".wpda-booking-calendar-head .wpdevart_link", function(e){
		if(typeof(start_index) == "undefined") {
			start_index = "";
			selected_date = "";
		}
		if($("input[name='current_date']").length){
			var current_date = $(this).attr("href");
			$("input[name='current_date']").val(current_date.replace("?date=",""));
		}
		
		e.preventDefault();
		var bc_main_div = $(this).closest('.booking_calendar_container');
		$(bc_main_div).find('.wpdevart-load-overlay').show();
        $.post(wpdevart.ajaxUrl, {
            action: 'wpdevart_ajax',
            wpdevart_selected: start_index,
            wpdevart_selected_date: selected_date,
            wpdevart_link: $(this).attr('href'),
			wpdevart_id: $(this).closest(".booking_calendar_main_container").data('id'),
            wpdevart_nonce: wpdevart.ajaxNonce
        }, function (data) {
            $(bc_main_div).find('div.booking_calendar_main').replaceWith(data);
            $(bc_main_div).find('.wpdevart-load-overlay').hide();
			if($(data).find(".wpdevart-day.selected").length == 1) {
				select_index = $(data).find(".wpdevart-day.selected").index() - 7;
			} else if($(data).find(".wpdevart-day.selected").length == 0){
				select_index = 0;
			}
        });
		//e.stopPropagation();
	});
	$("body").on( "click", ".wpda-booking-calendar-head .wpda-next", function(e){
		 ajax_next = "next";
	});
	$("body").on( "click", ".wpda-booking-calendar-head .wpda-previous", function(e){
		 ajax_next = "prev";
	});
	
	/*
	*CALENDAR
	*/
	
	var select_ex = false;
	var select_ex_single = false;
	var count_item = jQuery(".wpdevart-day").length;
	var start_index;
	$("body").on("click",".wpdevart-day", function(){
		var el = this,
		div_container = $(el).closest(".booking_calendar_main_container");
		id = $(div_container).attr("id").replace("booking_calendar_main_container_", "");
		if(select_ex == true){
			$(".wpdevart-day").each(function(){
				$(this).removeClass("selected");
			});
			select_ex = false;
		}
		if($(".wpdevart-calendar-container .selected").length != 0 ){
			select_ex = true;
		} 
		else {
			ajax_next = "";
			$(el).addClass("selected");
			start_index =$(".wpdevart-day").index(el);
			selected_date = $(".wpdevart-day").eq(start_index).data("date");
		}
		if(select_ex == true){
			$(".wpdevart-item-section.form-section").fadeIn(100);
			if(ajax_next == "") {
				if(start_index>=$(".wpdevart-day").index(el)){
					$("#start_date").val($(el).data("date"));
					$("#end_date").val(selected_date);
				}
				else {
					$("#start_date").val(selected_date);
					$("#end_date").val($(el).data("date"));
				}
			} else if(ajax_next == "next"){
				$("#start_date").val(selected_date);
				$("#end_date").val($(el).data("date"));
			} else if(ajax_next == "prev"){
				$("#start_date").val($(el).data("date"));
				$("#end_date").val(selected_date);
			}
		}
	});
	
	$("body").on("mouseenter mouseleave",".wpdevart-day", function(){
		if(($(".wpdevart-calendar-container .selected").length != 0 || typeof(start_index) != "undefined") && select_ex == false && start_index != ""){
			end_index = $(".wpdevart-day").index(this);			
			if(ajax_next == "") { 
				if(start_index <= end_index) {
					for(var j = 0; j < start_index; j++) {
						$(".wpdevart-day").eq(j).removeClass("selected");
					}
					for(var n = end_index; n < count_item; n++) {
						$(".wpdevart-day").eq(n).removeClass("selected");
					}
					for (var i = start_index; i < end_index; i++) {
						$(".wpdevart-day").eq(i).addClass("selected");
					}
				}
				else if(start_index >= end_index){
					for(var k = start_index+1; k < count_item; k++) {
						$(".wpdevart-day").eq(k).removeClass("selected");
					}
					for(var p = 0; p < end_index; p++) {
						$(".wpdevart-day").eq(p).removeClass("selected");
					}
					for (var m = end_index; m < start_index; m++) {
						$(".wpdevart-day").eq(m).addClass("selected");
					}
				}
			} else if(ajax_next == "next") {
				if(select_index <= end_index) {
					for(var j = 0; j < select_index; j++) {
						$(".wpdevart-day").eq(j).removeClass("selected");
					}
					for(var n = end_index; n < count_item; n++) {
						$(".wpdevart-day").eq(n).removeClass("selected");
					}
					for (var i = select_index; i < end_index; i++) {
						$(".wpdevart-day").eq(i).addClass("selected");
					}
				}
				else if(select_index >= end_index){
					for(var k = select_index+1; k < count_item; k++) {
						$(".wpdevart-day").eq(k).removeClass("selected");
					}
					for(var p = select_index; p < end_index; p++) {
						$(".wpdevart-day").eq(p).removeClass("selected");
					}
					for (var m = end_index; m < select_index; m++) {
						$(".wpdevart-day").eq(m).addClass("selected");
					}
				}
			} else if(ajax_next == "prev") {
				if(select_index == 0) {
					select_index = count_item;
				}
				if(select_index <= end_index) {
					for(var j = 0; j < select_index; j++) {
						$(".wpdevart-day").eq(j).removeClass("selected");
					}
					for(var n = end_index; n < count_item; n++) {
						$(".wpdevart-day").eq(n).removeClass("selected");
					}
					for (var i = select_index; i < end_index; i++) {
						$(".wpdevart-day").eq(i).addClass("selected");
					}
				}
				else if(select_index >= end_index){
					for(var k = select_index+1; k < count_item; k++) {
						$(".wpdevart-day").eq(k).removeClass("selected");
					}
					for(var p = 0; p < end_index; p++) {
						$(".wpdevart-day").eq(p).removeClass("selected");
					}
					for (var m = end_index; m < select_index; m++) {
						$(".wpdevart-day").eq(m).addClass("selected");
					}
				}
			}
			$(this).addClass("selected");
		}
	});
	
	$("body").on( "click",".delete_hour_item",function(){
		$(this).parent().remove();
	});
			/*PRO*/
	$('body').on("click", ".pro-field", function(){
		var proText = $(this).closest(".wpdevart-fild-item-container").length ? $(this).closest(".wpdevart-fild-item-container").find(".pro_feature").html() : $(this).closest("#form_field_type").find(".pro_feature").html()
		alert("If you want to use this feature upgrade to Booking calendar " + proText);
		$(this).blur(); 
		return false;
	});
	$('.pro-field').closest(".wp-picker-container").click(function(){
		var proText = $(this).closest(".wpdevart-fild-item-container").length ? $(this).closest(".wpdevart-fild-item-container").find(".pro_feature").html() : $(this).closest("#form_field_type").find(".pro_feature").html()
		alert("If you want to use this feature upgrade to Booking calendar " + proText);
		$(this).blur();
		return false;
	});
});
