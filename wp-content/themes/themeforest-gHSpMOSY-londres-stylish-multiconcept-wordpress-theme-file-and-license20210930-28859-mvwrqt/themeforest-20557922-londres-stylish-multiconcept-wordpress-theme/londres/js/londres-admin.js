jQuery(document).ready(function(){
	"use strict";
	if (typeof window.BrowserDetect == "undefined")
	window.BrowserDetect={init:function(){this.browser=this.searchString(this.dataBrowser)||"An unknown browser",this.version=this.searchVersion(navigator.userAgent)||this.searchVersion(navigator.appVersion)||"an unknown version",this.OS=this.searchString(this.dataOS)||"an unknown OS",this.isEdge=window.navigator.userAgent.indexOf("Edge")>-1?true:false,this.isModernIE=window.navigator.userAgent.indexOf("Trident")>-1&&!this.isEdge?true:false},searchString:function(i){for(var n=0;n<i.length;n++){var r=i[n].string,t=i[n].prop;if(this.versionSearchString=i[n].versionSearch||i[n].identity,r){if(-1!=r.indexOf(i[n].subString))return i[n].identity}else if(t)return i[n].identity}},searchVersion:function(i){var n=i.indexOf(this.versionSearchString);if(-1!=n)return parseFloat(i.substring(n+this.versionSearchString.length+1))},dataBrowser:[{string:navigator.userAgent,subString:"Chrome",identity:"Chrome"},{string:navigator.userAgent,subString:"OmniWeb",versionSearch:"OmniWeb/",identity:"OmniWeb"},{string:navigator.vendor,subString:"Apple",identity:"Safari",versionSearch:"Version"},{prop:window.opera,identity:"Opera",versionSearch:"Version"},{string:navigator.vendor,subString:"iCab",identity:"iCab"},{string:navigator.vendor,subString:"KDE",identity:"Konqueror"},{string:navigator.userAgent,subString:"Firefox",identity:"Firefox"},{string:navigator.vendor,subString:"Camino",identity:"Camino"},{string:navigator.userAgent,subString:"Netscape",identity:"Netscape"},{string:navigator.userAgent,subString:"MSIE",identity:"Explorer",versionSearch:"MSIE"},{string:navigator.userAgent,subString:"Gecko",identity:"Mozilla",versionSearch:"rv"},{string:navigator.userAgent,subString:"Mozilla",identity:"Netscape",versionSearch:"Mozilla"}],dataOS:[{string:navigator.platform,subString:"Win",identity:"Windows"},{string:navigator.platform,subString:"Mac",identity:"Mac"},{string:navigator.userAgent,subString:"iPhone",identity:"iPhone/iPod"},{string:navigator.platform,subString:"Linux",identity:"Linux"}]};BrowserDetect.init();
	
	/* mega menu - all previously on inc/theme-menu */
	if (jQuery('.submit-add-to-menu').length){
		londres_override_class_options();
		
		jQuery(document).on('click', '.londres_icon_container a.button_ok', function(e){
			e.preventDefault(); e.stopPropagation();
			var thisButton = jQuery(e.currentTarget);
			if (jQuery('#'+thisButton.closest('.ui-dialog').attr('data-rel')+ ' .des_remove_icon').length) jQuery('#'+thisButton.closest('.ui-dialog').attr('data-rel')+ ' .des_remove_icon').trigger('click'); jQuery('#'+thisButton.closest('.ui-dialog').attr('data-rel')+ ' .edit-menu-item-classes').val( jQuery('#'+thisButton.closest('.ui-dialog').attr('data-rel')+ ' .edit-menu-item-classes').val() + ' ' + thisButton.siblings('i.selected').attr('data-rel')); jQuery('#'+thisButton.closest('.ui-dialog').attr('data-rel')+ ' .londres_select_icon.button').after('<a class=\'des_remove_icon\' href=\'javascript:;\' onclick=\'londres_removeIcon(thisButton);\'>Remove Icon</a>').after( '<i class=\''+thisButton.siblings('i.selected').attr('data-rel')+'\' style=\'position:relative;top:2px;margin-left:10px;margin-right:10px;width: 30px;height: 30px;font-size: 25px;border: 1px solid;text-align: center;line-height: 30px;\'></i>' );   jQuery('.londres_icon_container').dialog('close');
		});
		
		jQuery(document).on('click', '.londres_icon_container a.button_cancel', function(e){
			e.preventDefault(); e.stopPropagation();
			jQuery('.londres_icon_container').dialog('close');
		});
		
		jQuery(document).on('click', '.londres_icon_container i.fa', function(e){
			e.preventDefault(); e.stopPropagation();
			jQuery(e.currentTarget).addClass("selected").siblings().removeClass("selected");
		});
		
		jQuery(document).on("click", ".submit-add-to-menu", function(){ 
			var new_item = false;
			if (jQuery(this).attr("id") === "submit-posttype-page" && jQuery("#posttype-page input:checked").length > 0) new_item = true;
			if (jQuery(this).attr("id") === "submit-customlinkdiv" && jQuery("#custom-menu-item-name").val() != "" && !jQuery("#custom-menu-item-name").hasClass("input-with-default-title") && jQuery("#custom-menu-item-url").val() != "" && jQuery("#custom-menu-item-url").val() != "http://") nav_item = true;
			if (jQuery(this).attr("id") === "submit-taxonomy-category" && jQuery("#add-category input:checked").length > 0) new_item = true;
			if (new_item){
				var check_for_new_item = setInterval(function(){
					if (jQuery(".menu-item-settings p.field-css-classes label").not(".des").not(".londres_input").length){
						clearInterval(check_for_new_item);
						londres_override_class_options();
					}
				}, 100);
			}
		});
	}
	
});

function londres_removeIcon(el){
    el.siblings(".edit-menu-item-classes").val( " "+el.siblings(".edit-menu-item-classes").val().replace(el.siblings("i").attr("class"), ""));
    el.siblings("i").remove();
    el.remove();
}

function londres_override_class_options(){
    var holders = jQuery(".menu-item-settings p.field-css-classes > label").not(".des");
    holders.each(function(){
	    var theid = jQuery(this).closest(".menu-item-settings").attr("id");
	    jQuery(this).addClass("des");
	    jQuery(this).removeClass("hidden-field").css("display","block");
		    jQuery(this).contents().filter(function () { return this.nodeType === 3; }).remove();
	    jQuery(this).prepend("<label class=\'londres_input\' for=\'londres_mega_menu\'>Mega Menu?  </label><input type=\'checkbox\' name=\'londres_mega_menu\'><label class=\'londres_input\' for=\'londres_mega_hide_title\'>Hide Title?  </label><input type=\'checkbox\' name=\'londres_mega_hide_title\'><br/><label class=\'londres_input\' for=\'londres_mega_hide_link\'>Just Label (Without Link) ?  </label><input type=\'checkbox\' name=\'londres_mega_hide_link\'><br/><a href=\'#\' class=\'londres_select_icon button\' >Select Icon</a><br/><br/>");
	    
	    /* check if menu item has already an icon and present it. also check the boxes if the class exists. */
	    if (jQuery(this).find("input.edit-menu-item-classes").val()){
		    var itemClasses = jQuery(this).find("input.edit-menu-item-classes").val().split(" ");
		    var found = "false";
		    for (var i=0; i<itemClasses.length; i++){
			    if (itemClasses[i].indexOf("fa-") > -1) {
				    found = itemClasses[i];
			    }
			    if (itemClasses[i].indexOf("londres_mega_hide_link") > -1) jQuery(this).find("input[name=\'londres_mega_hide_link\']").attr("checked","checked");
			    if (itemClasses[i].indexOf("londres_mega_hide_title") > -1) jQuery(this).find("input[name=\'londres_mega_hide_title\']").attr("checked","checked");
			    if (itemClasses[i].indexOf("londres_mega_menu") > -1) jQuery(this).find("input[name=\'londres_mega_menu\']").attr("checked","checked");
		    }
		    if (found != "false"){
			    jQuery(this).find(".londres_select_icon.button").after( "<i class=\'fa "+found+"\' style=\'position:relative;top:2px;margin-left:10px;margin-right:10px;width: 30px;height: 30px;font-size: 25px;border: 1px solid;text-align: center;line-height: 30px;\'></i><a class=\'des_remove_icon\' href=\'javascript:;\' onclick=\'londres_removeIcon(jQuery(this));\'>Remove Icon</a>" );
		    }
	    }
	    
		jQuery(this).find("input").each(function(){
			jQuery(this).on("change", function(){
				if (jQuery(this).is(":checked")) jQuery(this).siblings(".edit-menu-item-classes").val( jQuery(this).siblings(".edit-menu-item-classes").val() + " " + jQuery(this).attr("name") );
				else jQuery(this).siblings(".edit-menu-item-classes").val( jQuery(this).siblings(".edit-menu-item-classes").val().replace(" " + jQuery(this).attr("name"),"") );
			});
		});
		jQuery(this).find(".londres_select_icon").on("click", function(){
			jQuery(".londres_icon_container").dialog({modal:true, height: parseInt(jQuery(window).height()*.8, 10), width: parseInt(jQuery(window).width()*.8, 10), autoOpen: false});
			jQuery(".londres_icon_container").parent().attr("data-rel",theid).css({position : "fixed"}).end().dialog("open");
		});
    });			
}