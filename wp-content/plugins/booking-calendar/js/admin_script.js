/*
*ADMIN SCRIPT 
*/

var wpdevart_elements = {
    checkbox_enable : function(element){
		if (element.disable === "1") {
			if (jQuery('#' + element.id).prop('checked')) {
			  if (!jQuery('#' + element.id).closest('.wpdevart-item-container').next().next().hasClass("items_open")) {	
				  for (i = 0; i < element.enable.length; i++) { 
					 jQuery('#wpdevart_wrap_'+element.enable[i]).parent().parent().slideUp();
				  }
			  } else  {
					 jQuery('#' + element.id).closest('.wpdevart-item-container').next().next().slideUp();
			  }
			}
			else{
				if (!jQuery('#' + element.id).closest('.wpdevart-item-container').next().next().hasClass("items_open")) {
				  for (i = 0; i < element.enable.length; i++) {
					 jQuery('#wpdevart_wrap_'+element.enable[i]).parent().parent().slideDown();
				  }
				} else  {
					 jQuery('#' + element.id).closest('.wpdevart-item-container').next().next().slideDown();
				}
			}
		} else {
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

function quick_edit(el,id) {
	var options_pay_in_cash = ["pending","completed","partially","canceled","refunded"];
	var options = ["pending","completed","partially","canceled","failed","refunded","fraud"];
	if(jQuery("#id_"+id+" .payment_status.paypal").length && jQuery("#id_"+id+" .payment_status.paypal").text().trim() != ""){
		var value = jQuery("#id_"+id+" .payment_status.paypal").text();
		var select = "<select name='payment_status_"+id+"' id='payment_status_"+id+"'>";
		for(var i=0; i< options.length; i++){
			selected = "";
			if(options[i] == value)
				selected = "selected='selected'";
			select += "<option value='" + options[i] + "' " + selected + ">" + wpdevart_titleCase(options[i]) + "</option>";
		}
		select += "</select>";
		jQuery("#id_"+id+" .payment_status.paypal").html(select);
		jQuery(el).css("display","none");
		jQuery(el).next().css("display","inline-block");
		jQuery(el).next().next().css("display","inline-block");
	}
	if(jQuery("#id_"+id+" .payment_status.pay_in_cash").length && jQuery("#id_"+id+" .payment_status.pay_in_cash").text().trim() != ""){
		var value = jQuery("#id_"+id+" .payment_status.pay_in_cash").text();
		var select = "<select name='payment_status_"+id+"' id='payment_status_"+id+"'>";
		for(var i=0; i< options_pay_in_cash.length; i++){
			selected = "";
			if(options_pay_in_cash[i] == value)
				selected = "selected='selected'";
			select += "<option value='" + options_pay_in_cash[i] + "' " + selected + ">" + wpdevart_titleCase(options_pay_in_cash[i]) + "</option>";
		}
		select += "</select>";
		jQuery("#id_"+id+" .payment_status.pay_in_cash").html(select);
		jQuery(el).css("display","none");
		jQuery(el).next().css("display","inline-block");
		jQuery(el).next().next().css("display","inline-block");
	}
	return false;
}
function cancel_edit(el,id) {
	if(jQuery("#payment_status_"+id).length){
		var option = jQuery("#payment_status_"+id).val();
		jQuery("#id_"+id+" .payment_status").html(option);
		jQuery(el).css("display","none");
		jQuery(el).next().css("display","none");
		jQuery(el).prev().css("display","inline-block");
	}
	return false;
}

function quick_update(el,id) {
	if(jQuery("#payment_status_"+id).length){
		jQuery(el).next().addClass("is-active");
		var res_data = [];
		res_data = jQuery("#payment_status_"+id).val();
		/*res_data = JSON.stringify(res_data);*/
		jQuery.post(wpdevart_admin.ajaxUrl, {
				action: 'wpdevart_quick_update',
				wpdevart_data:res_data,
				wpdevart_id: id,
				wpdevart_nonce: wpdevart_admin.ajaxNonce
			}, function (data) {
				jQuery(el).next().removeClass("is-active");
				cancel_edit(jQuery(".cancel_" + id)[0],id);
			});
	}
	return false;
}

function wpdevart_titleCase(string) { 
	return string.charAt(0).toUpperCase() + string.slice(1); 
}

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

/*For month view*/
function for_month_view(){
	var res_id = new Array();
	var id = 0;
	jQuery(".wpdevart-calendar-container .reservation-month").each(function(i,el){
		id = parseInt(jQuery(el).attr("class").replace("reservation-month reservation-month-", ""));
		if(jQuery.inArray(id, res_id) === -1)
			res_id.push(id);
	});
	jQuery.each(res_id, function( index, value ) {
	    jQuery(".reservation-month-" + value).css("top",((index*19) + 19) + "px");
	});
	var height = 19*res_id.length + 19;
	//jQuery(".wpdevart-calendar-container td").css("height",19*res_id.length + 19);

	jQuery(".wpdevart-calendar-container tr").each(function(i,el){
		var res_top = new Array();
		jQuery(this).find(".reservation-month").each(function(){
			res_top.push(jQuery(this).position().top);
		});
		var min = 0;
		var max = 0;
		if(res_top.length){
			var min = Math.min.apply(Math,res_top);
			var max = Math.max.apply(Math,res_top);
		}
		var event_height = height-(height-(max - min)) + 40; 
		var st_top = height - (height - min + 20);
	    jQuery(this).find("td").css("height",event_height);
		if(min > 20){
			jQuery(this).find(".reservation-month").each(function(i,el){
				var thistop = jQuery(this).position().top;
				jQuery(this).css("top",(thistop-st_top) + "px");
			});
		}
	});

	jQuery(".wpdevart-calendar-container tr").each(function( index, element ) {
	    if(jQuery(element).find(".reservation-month").length == 0) {
			jQuery(element).find("td").css("height","70px");
		}
	});
}

function add_default(el,arg){
	var hours_default = ["00:00-01:00","01:00-02:00","02:00-03:00","03:00-04:00","04:00-05:00","05:00-06:00","06:00-07:00","07:00-08:00","08:00-09:00","09:00-10:00","10:00-11:00","11:00-12:00","12:00-13:00","13:00-14:00","14:00-15:00","15:00-16:00","16:00-17:00","17:00-18:00","18:00-19:00","19:00-20:00","20:00-21:00","21:00-22:00","22:00-23:00","23:00-00:00"];
	var hour_items = "";
	if(!jQuery(el).parent().find(".hours_default").length) {
		for(var i = 0; i < hours_default.length; i++) {
			hour_items += "<div class='hours_default hour_element div-for-clear'> <input type='text' class='hour_value short_input' value='" +hours_default[i] + "' name='"+arg+"[hour_value][]' placeholder='"+wpdevart_admin.hour+"'> <input type='text' class='hour_price short_input' value='' name='"+arg+"[hour_price][]' placeholder='"+wpdevart_admin.price+"'><input type='text' class='hours_marked_price short_input' value='' name='"+arg+"[hours_marked_price][]' placeholder='"+wpdevart_admin.marked_price+"'><select name='"+arg+"[hours_availability][]' class='half_input'><option value='available'>"+wpdevart_admin.available+"</option><option value='booked'>"+wpdevart_admin.booked+"</option><option value='unavailable'>"+wpdevart_admin.unavailable+"</option></select><input type='text' class='hours_number_availability half_input' value='' name='"+arg+"[hours_number_availability][]' placeholder='"+wpdevart_admin.number_availability+"'><input type='text' class='hour_info full_input' value='' name='"+arg+"[hour_info][]' placeholder='"+wpdevart_admin.h_info+"'> <span class='delete_hour_item'><i class='fa fa-close'></i></span> </div>";
		}
	}
	
	jQuery(el).parent().append(hour_items);
}
function add_hour(el,arg){
	var hour_item = "<div class='hour_element div-for-clear'> <input type='text' class='hour_value short_input' value='' name='"+arg+"[hour_value][]' placeholder='"+wpdevart_admin.hour+"'> <input type='text' class='hour_price short_input' value='' name='"+arg+"[hour_price][]' placeholder='"+wpdevart_admin.price+"'><input type='text' class='hours_marked_price short_input' value='' name='"+arg+"[hours_marked_price][]' placeholder='"+wpdevart_admin.marked_price+"'><select name='"+arg+"[hours_availability][]' class='half_input'><option value='available'>"+wpdevart_admin.available+"</option><option value='booked'>"+wpdevart_admin.booked+"</option><option value='unavailable'>"+wpdevart_admin.unavailable+"</option></select><input type='text' class='hours_number_availability half_input' value='' name='"+arg+"[hours_number_availability][]' placeholder='"+wpdevart_admin.number_availability+"'><input type='text' class='hour_info full_input' value='' name='"+arg+"[hour_info][]' placeholder='"+wpdevart_admin.h_info+"'> <span class='delete_hour_item'><i class='fa fa-close'></i></span> </div>";
	
	jQuery(el).parent().append(hour_item);
}

function add_conditions(el,arg,placeholder){
	if(!jQuery(el).hasClass("pro-field")){
		var conditions = "<div class='conditions_element div-for-clear'> <input type='text' class='short_input' value='' name='"+arg+"[count][]' placeholder='"+placeholder+"'> <select name='"+arg+"[type][]'>"+
		"<option value='percent' selected='selected'>Percent</option><option value='price'>Price</option></select><input type='text' class='short_input' value='' name='"+arg+"[percent][]' placeholder='"+wpdevart_admin.price+"'><span class='delete_hour_item'><i class='fa fa-close'></i></span> </div>";
		
		jQuery(el).parent().append(conditions);
	}
}

	/*mail content required*/
function content_required(button_action,el){	
    var required = true;
	jQuery("#notify_admin_on_book, #notify_admin_on_approved, #notify_user_on_book, #notify_user_on_approved, #notify_user_canceled,#notify_user_deleted").each(function(){
		if(jQuery(this).is(":checked")){
			var textarea_id = jQuery(this).closest(".wpdevart-item-container").next().next().find("textarea").attr("id");
			if(tinymce.get( textarea_id)!=null)
				tinymce.get( textarea_id).save();				
			if(jQuery('#'+textarea_id).val() == "")  {
				required = false;
				alert("Email content fields are required");
				return false;
			}
		}
	});
	if(required === true){
		jQuery("#button_action").val(button_action);
		jQuery(el).closest("form").submit();
	}
}



jQuery( document ).ready(function() {
    var $ = jQuery;
	$("body").on( "click", ".reserv-info-open-title", function(){
		$(this).closest(".reserv-info").next().slideToggle();
		$(this).find(".reserv-info-open").toggleClass("active");
		if($(this).find(".reserv-info-open i").hasClass("fa-chevron-up"))
			$(this).find(".reserv-info-open i").attr("class","fa fa-chevron-down");
	    else
			$(this).find(".reserv-info-open i").attr("class","fa fa-chevron-up");
	});
			
	$("body").on('mouseover', '.reservation-month', function (e) {
		if($(this).offset().top < 350){
			$(this).find('.month-view-content').css({"bottom":"auto","top":"20px"});
		} else {
			$(this).find('.month-view-content').css({"bottom":"20px"});
		}
	});	
	
	/*
	*EXTRA
	*/
	var extra_count = 0;
	$("body").on( "click", "#add_extra_field", function(e){
		e.preventDefault();
		$(this).addClass("is-busy");
        $.post(wpdevart_admin.ajaxUrl, {
            action: 'wpdevart_add_extra_field',
            wpdevart_extra_field_max: $(this).data('max'),
            wpdevart_extra_field_count: extra_count,
            wpdevart_form_nonce: wpdevart_admin.ajaxNonce
        }, function (data) {
            $('#new_extra_fields').append(data);
			$('#add_extra_field').removeClass("is-busy");
        });
		e.stopPropagation();
		extra_count += 1;
	});
	
	/*Export*/
	$("body").on( "click", "#wpdevart_export", function(e){	
	    var dataFilters = [];
        $('input[name="reserv_status[]"]:checked').each(function(i){
		  dataFilters[i] = $(this).val();
        });
		var all_pages = jQuery('input[name="all_pages"]:checked').length ? 1 : 0;
		dataFilters = JSON.stringify(dataFilters);
		window.location = wpdevart_admin.ajaxUrl + "?action=wpdevart_export&wpdevart_nonce=" + wpdevart_admin.ajaxNonce + "&calendar_id=" + jQuery('input[name="calendar_id"]').val() + "&wpdevart_page=" + jQuery('input[name="wpdevart_page"]').val() + "&reserv_period_start=" + jQuery('input[name="reserv_period_start"]').val()+ "&reserv_period_end=" + jQuery('input[name="reserv_period_end"]').val() + "&wpdevart_serch=" + jQuery('input[name="wpdevart_serch"]').val() + "&all_pages=" + all_pages + "&reserv_status=" + dataFilters;
		
		return false;
	});
	
	/*
	*Extra field items
	*/
	var extra_field_count = 0;
	$("body").on( "click",".add_extra_field_item", function(e){
		e.preventDefault();
		$(this).addClass("wait");
		var this_add = $(this);
		console.log(extra_count);
		var field_item = $(this).parent().next().find(".wpdevart-extra-item-container");
        $.post(wpdevart_admin.ajaxUrl, {
            action: 'wpdevart_add_extra_field_item',
            wpdevart_extra_field_item_max: $(this).data('max'),
            wpdevart_extra_field_item_count: extra_field_count,
            wpdevart_extra_field: $(this).data('field'),
            wpdevart_form_nonce: wpdevart_admin.ajaxNonce
        }, function (data) {
            field_item.append(data);
			this_add.removeClass("wait");
        });
		e.stopPropagation();
		extra_field_count += 1;
	});
	$("body").on( "click", ".delete-extra-fild", function(){
		$(this).closest(".wpdevart-extra-item").remove();
	});
		
	/*
	*FORM
	*/
	var count = 0;
	$("body").on( "click", "#form_field_type span", function(e){
		e.preventDefault();		
		if(!$(this).hasClass("pro-field")){
			$(this).parent().prev().addClass("is-busy");
			$.post(wpdevart_admin.ajaxUrl, {
				action: 'wpdevart_add_field',
				wpdevart_field_count: count,
				wpdevart_field_type: $(this).attr('id'),
				wpdevart_field_max: $(this).parent().data('max'),
				wpdevart_form_nonce: wpdevart_admin.ajaxNonce
			}, function (data) {
				$('#new_fieds').append(data);
				$('#add_field').removeClass("is-busy");
			});
			e.stopPropagation();
			$(this).parent().slideUp();
			count += 1;
		}
	});
	
	$("body").on( "click", "#wpdevart_forms .wpdevart-item-parent-container .wpdevart-fild-item-container,#wpdevart_extras .wpdevart-item-parent-container .wpdevart-fild-item-container", function(){
		$(this).closest(".wpdevart-item-container").find(".form-fild-options").slideToggle();
		$(this).find(".open-form-fild-options").toggleClass("active");
	});
	
	$("body").on( "click","#add_field", function(){
		$("#form_field_type").slideToggle();
	});

	$("body").on( "click",".delete-form-fild",function(){
		$(this).closest(".wpdevart-item-container").remove();
	});
	$("body").on( "click",".delete_hour_item", function(){
		$(this).parent().remove();
	});
	
	$("body").on( "keyup",".form_label",function(){
		jQuery(this).closest(".wpdevart-item-parent-container").find(".section-title-txt").html(jQuery(this).val());
	});
	$("body").on( "change",".form_req",function(el){
		if(jQuery(this).is(":checked")){
			jQuery(this).closest(".wpdevart-item-parent-container").find(".wpdevart-required").html('*');
		}
		else {
			jQuery(this).closest(".wpdevart-item-parent-container").find(".wpdevart-required").html('');
		}
	});
	
	/*
	*Reservations
	*/
	/*form tab*/
	if(typeof(localStorage.currentTab) !== "undefined") {
		var current_item_tab = localStorage.currentTab;
		$("#resrv_action_filters .wpdevart_tab").removeClass("show");
		$("#resrv_action_filters .wpdevart_container").removeClass("show");
		$('#resrv_action_filters #' + current_item_tab).addClass("show");
		$('#resrv_action_filters #' + current_item_tab + '_container').show();
	}	   
	$("#resrv_action_filters .wpdevart_tab").click(function(){
		if(typeof(Storage) !== "undefined") {
			localStorage.currentTab = $(this).attr("id");
		}
		$("#resrv_action_filters .wpdevart_tab").removeClass("show");
		$("#resrv_action_filters .wpdevart_container").removeClass("show").hide();
		$("#resrv_action_filters #" + $(this).attr("id") + "_container").show();
		$(this).addClass("show");
	});
	/*Theme tab*/
	if(typeof(localStorage.currentThemeTab) !== "undefined") {
		var current_item_tab = localStorage.currentThemeTab;
		$("#wpdevart_themes .wpdevart_tab").removeClass("show");
		$("#wpdevart_themes .wpdevart_container").removeClass("show");
		$('#wpdevart_themes #' + current_item_tab).addClass("show");
		$('#wpdevart_themes #' + current_item_tab + '_container').addClass("show");
	}	   
	$("#wpdevart_themes .wpdevart_tab").click(function(){
		if(typeof(Storage) !== "undefined") {
			localStorage.currentThemeTab = $(this).attr("id");
		}
		$("#wpdevart_themes .wpdevart_tab").removeClass("show");
		$("#wpdevart_themes .wpdevart_container").removeClass("show").hide();
		$("#wpdevart_themes #" + $(this).attr("id") + "_container").show();
		$(this).addClass("show");
	});
	
	$(".check_for_action").click(function(){
	  if (jQuery(this).context.checked == true) {
		jQuery(this).parent().parent().addClass("checked");  
		jQuery(this).parent().parent().next().addClass("checked");  
	  }
	  else {
		jQuery(this).parent().parent().removeClass("checked");  
		jQuery(this).parent().parent().next().removeClass("checked");  
	  }
	});
	
	$("#show_all_details").click(function(){
	  if (jQuery(this).hasClass("show")) { 
		jQuery(".wpdevart-reservations-table").removeClass("show");  
		jQuery(this).removeClass("show");
		jQuery(this).html("Show all details");
	  }
	  else {
		jQuery(".wpdevart-reservations-table").addClass("show");  
		jQuery(this).addClass("show");
		jQuery(this).html("Hide all details");
	  }
	});

	$(function() {
		$( ".admin_datepicker" ).datepicker({
		  dateFormat: "yy-mm-dd"
		});
	});
		/*PRO*/
	$('body').on("click", ".pro-field", function(e){
		var proText = $(this).closest(".wpdevart-fild-item-container").length ? $(this).closest(".wpdevart-fild-item-container").find(".pro_feature").html() : $(this).closest("#form_field_type").find(".pro_feature").html()
		alert("If you want to use this feature upgrade to Booking calendar " + proText);
		$(this).blur(); 
		e.preventDefault();
		e.stopPropagation();
		return false;
	});
	$('body').on("click", ".pro-field .wp-picker-container", function(e){
		var proText = $(this).closest(".wpdevart-fild-item-container").length ? $(this).closest(".wpdevart-fild-item-container").find(".pro_feature").html() : $(this).closest("#form_field_type").find(".pro_feature").html()
		alert("If you want to use this feature upgrade to Booking calendar " + proText);
		$(this).blur(); 
		e.preventDefault();
		e.stopPropagation();
		return false;
	});
	$('.pro-field').closest(".wp-picker-container").click(function(){
		var proText = $(this).closest(".wpdevart-fild-item-container").length ? $(this).closest(".wpdevart-fild-item-container").find(".pro_feature").html() : $(this).closest("#form_field_type").find(".pro_feature").html()
		alert("If you want to use this feature upgrade to Booking calendar " + proText);
		$(this).blur();
		return false;
	});
	
	/*Multi languages*/
	$('#multi_lng_button').on("click", function(){
		$('#multi_lng_popup').show();
	});
	$('#multi_lng_popup,#multi_lng_popup .fa-close').on("click", function(){
		$('#multi_lng_popup').hide();
	});
	$('#multi_lng_popup_container').on("click", function(e){
		e.stopPropagation();
	});
	$('#wpdevart_lang').on("change", function(){
		$('#lang_prefix').html($(this).find("option:selected").attr("lang"));
	});
	for_month_view();
	
	$( "#wpdevart_forms .wpdevart-item-section-cont,#wpdevart_extras .wpdevart-item-section-cont, ul.wpdevart-extra-item-container" ).sortable({
      placeholder: "ui-state-highlight"
    });
    $( "#wpdevart_forms .wpdevart-item-section-cont,#wpdevart_extras .wpdevart-item-section-cont, ul.wpdevart-extra-item-container" ).disableSelection();
});
jQuery( document ).ajaxComplete(function( event, xhr, settings ) {
  for_month_view();
});

