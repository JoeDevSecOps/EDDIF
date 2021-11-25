var londresOptions = {
    separator: '|*|',
    dialogOpened: false,
    init: function (options) {
        londresOptions.setCheckboxClickHandlers();
        londresOptions.setHelpFunc();
        londresOptions.setOnOffFunc();
        londresOptions.setTextImageFunc();
        londresOptions.setLeftRightFunc();
        londresOptions.setLightDarkFunc();
        londresOptions.setColorpickFunc();
        londresOptions.setStyleSelectFunc();
        jQuery(".sortable").sortable();
        var mainNavOptions = {};
        if (options.cookie) {
            mainNavOptions = {
                cookie: {
                    name: 'tabs',
                    expires: 1
                }
            }
        }
        londresOptions.setTabs(options.cookie);
        jQuery(document).on('click', '#options-submit', function (event) {
            event.preventDefault();
            jQuery('#londres-options').submit()
        });
        jQuery('#londres-content-container').delegate('.hover', 'mouseover', function () {
            jQuery(this).css({
                cursor: 'pointer'
            })
        });
        jQuery('.sortable').delegate('input', 'focusin', function () {
            jQuery(this).addClass('selected')
        }).delegate('input', 'focusout', function () {
            jQuery(this).removeClass('selected')
        });
        jQuery('#londres-content-container').append('<input type="hidden" value="Upper Options Panel" />')
    },
    setTabs: function (enableCookies) {
        jQuery('.main-navigation-container').hide();
        var selectedClass = 'ui-tabs-selected',
            mainNavCookie = 'upper-main-navigation',
            subNavCookie = 'upper-sub-navigation',
            mainNotSel = (enableCookies && jQuery.cookie(mainNavCookie)) ? jQuery.cookie(mainNavCookie) : ':first',
            mainSel = mainNotSel === ':first' ? 'a:first' : 'a[href="' + mainNotSel + '"]';
        if (mainNotSel === ':first') {
            jQuery('.main-navigation-container:first').show()
        } else {
            jQuery(mainNotSel).show()
        }
        jQuery('#content').css({
            backgroundImage: 'none'
        });
        jQuery('#navigation ' + mainSel).closest('li').addClass(selectedClass);
        jQuery('.main-navigation-container').each(function () {
            var thisId = '#' + jQuery(this).attr('id'),
                notSel = (enableCookies && jQuery.cookie(thisId)) ? jQuery.cookie(thisId) : ':first',
                sel = notSel === ':first' ? 'a.tab:first' : 'a.tab[href="' + notSel + '"]';
            jQuery(this).find('.sub-navigation-container').not(notSel).hide();
            jQuery(this).find(sel).closest('li').addClass(selectedClass)
        });
        jQuery(document).on('click', '#navigation a', function (event) {
            event.preventDefault();
            var href = jQuery(this).attr('href');
            jQuery('.main-navigation-container').hide();
            jQuery(href).show();
            jQuery('#navigation li').removeClass(selectedClass);
            jQuery(this).closest('li').addClass(selectedClass);
            if (enableCookies) {
                jQuery.cookie(mainNavCookie, href)
            }
        });
        jQuery(document).on('click', 'a.tab', function (event) {
            event.preventDefault();
            var href = jQuery(this).attr('href');
            jQuery(href).show().siblings('.sub-navigation-container').hide();
            jQuery(this).closest('li').addClass(selectedClass).siblings('li').removeClass(selectedClass);
            if (enableCookies) {
                var parentId = '#' + jQuery(this).closest('div.main-navigation-container').attr('id');
                jQuery.cookie("options-subnav", href)
            }
        });
        
        if (jQuery.cookie('options-subnav') !== null ){
	        jQuery( 'a[href="'+ jQuery.cookie('options-subnav') +'"]' ).trigger('click');
        }
    },
    removeSavedMessage: function () {
        jQuery('#saved_box').slideUp('slow')
    },
    setStyleSelectFunc: function () {
        jQuery('.styles-holder').each(function () {
            jQuery(this).delegate('a.style-box', 'click', function (event) {
                event.preventDefault();
                var $that = jQuery(this),
                    $parent = jQuery(this).parent();
                $parent.addClass('selected-style').siblings('.selected-style').removeClass('selected-style');
                $parent.parent().siblings('input').attr("value", $that.attr('title'))
            })
        })
    },
    setHelpFunc: function () {
        jQuery('#londres-content-container').delegate('a.help-button', 'click', function (event) {
            event.preventDefault();
            if (!londresOptions.dialogOpened) {
                jQuery(this).find('.help-dialog:first').clone().dialog({
                    autoOpen: true,
                    title: jQuery(this).attr('title'),
                    closeText: '',
                    open: function () {
                        londresOptions.dialogOpened = true
                    },
                    close: function () {
                        londresOptions.dialogOpened = false
                    }
                })
            }
        })
    },
    setColorpickFunc: function () {
        jQuery('input.color').ColorPicker({
            onSubmit: function (hsb, hex, rgb, el) {
                jQuery(el).val(hex);
                jQuery(el).ColorPickerHide();
                jQuery(el).siblings('.color-preview').css({
                    backgroundColor: '#' + hex
                })
            },
            onBeforeShow: function () {
                jQuery(this).ColorPickerSetColor(this.value)
            }
        }).on('keyup', function () {
            var value = this.value;
            jQuery(this).ColorPickerSetColor(value);
            var bgColor = value === '' ? 'transparent' : '#' + value;
            jQuery(this).siblings('.color-preview').css({
                backgroundColor: bgColor
            })
        });
        jQuery('.color-preview').ColorPicker({
            onSubmit: function (hsb, hex, rgb, el) {
                jQuery(el).css({
                    backgroundColor: '#' + hex
                }).ColorPickerHide();
                jQuery(el).siblings('input.color').attr("value", hex)
            },
            onBeforeShow: function () {
                jQuery(this).ColorPickerSetColor(jQuery(this).siblings('input.color').attr('value'))
            }
        }).on({
            'keyup': function () {
                jQuery(this).ColorPickerSetColor(this.value)
            },
            'mouseover': function () {
                jQuery(this).css({
                    cursor: 'pointer'
                })
            }
        })
    },
    setOnOffFunc: function () {
		var londres_is_rtl = jQuery('body').hasClass('rtl');
        jQuery('div.on-off').each(function () {
            if (jQuery(this).siblings('input[type=hidden]:first').attr('value') === 'on') {
                if (londres_is_rtl){
					jQuery(this).find('span').css({
						marginRight: 2
					})
                } else {
	                jQuery(this).find('span').css({
	                    marginLeft: 49
	                })
                }
            } else {
	            if (londres_is_rtl){
					jQuery(this).find('span').css({
						marginRight: 49
					})
                }
            }
        });
        jQuery(document).on('click', 'div.on-off', function () {
            var hiddenInput = jQuery(this).siblings('input[type=hidden]:first');
            if (hiddenInput.attr('value') == 'on') {
	            if (londres_is_rtl){
		            jQuery(this).find('span').animate({
	                    marginRight: 49
	                });
	            } else {
		            jQuery(this).find('span').animate({
	                    marginLeft: 2
	                });
	            }
                hiddenInput.attr('value', 'off')
            } else {
	            if (londres_is_rtl){
		            jQuery(this).find('span').animate({
	                    marginRight: 2
	                });
	            } else {
		            jQuery(this).find('span').animate({
	                    marginLeft: 49
	                });
	            }
                hiddenInput.attr('value', 'on')
            }
        })
    },
    setTextImageFunc: function () {
        jQuery('div.text-image').each(function () {
            if (jQuery(this).siblings('input[type=hidden]:first').attr('value') === 'text') {
                jQuery(this).find('span').css({
                    marginLeft: 49
                })
            }
        });
        jQuery(document).on('click', 'div.text-image', function () {
            var hiddenInput = jQuery(this).siblings('input[type=hidden]:first');
            if (hiddenInput.attr('value') == 'text') {
                jQuery(this).find('span').animate({
                    marginLeft: 2
                });
                hiddenInput.attr('value', 'image')
            } else {
                jQuery(this).find('span').animate({
                    marginLeft: 49
                });
                hiddenInput.attr('value', 'text')
            }
        })
    },
    setLeftRightFunc: function () {
        jQuery('div.left-right').each(function () {
            if (jQuery(this).siblings('input[type=hidden]:first').attr('value') === 'right') {
                jQuery(this).find('span').css({
                    marginLeft: 49
                })
            }
        });
        jQuery(document).on('click', 'div.left-right', function () {
            var hiddenInput = jQuery(this).siblings('input[type=hidden]:first');
            if (hiddenInput.attr('value') == 'right') {
                jQuery(this).find('span').animate({
                    marginLeft: 2
                });
                hiddenInput.attr('value', 'left')
            } else {
                jQuery(this).find('span').animate({
                    marginLeft: 49
                });
                hiddenInput.attr('value', 'right')
            }
        })
    },
    setLightDarkFunc: function () {
        jQuery('div.light-dark').each(function () {
            if (jQuery(this).siblings('input[type=hidden]:first').attr('value') === 'light') {
                jQuery(this).find('span').css({
                    marginLeft: 49
                })
            }
        });
        jQuery(document).on('click', 'div.light-dark', function () {
            var hiddenInput = jQuery(this).siblings('input[type=hidden]:first');
            if (hiddenInput.attr('value') == 'light') {
                jQuery(this).find('span').animate({
                    marginLeft: 2
                });
                hiddenInput.attr('value', 'dark')
            } else {
                jQuery(this).find('span').animate({
                    marginLeft: 49
                });
                hiddenInput.attr('value', 'light')
            }
        })
    },
    loadUploader: function (element, pathToPhp, uploadsUrl, multi) {
		if (multi == null){
			multi = false;
		}
        var button = element,
            interval, buttonSpan, upperButtonSpan, upperButton, upperInterval;
        new AjaxUpload(button, {
            action: ajaxurl,
            name: "upperfile",
			type: "POST",
			dataType: "JSON",
			data: {
				action: "call_upper_upload_handler",
				security: jQuery('input#londres-theme-upload-handler').val()
			},
            onSubmit: function (file, ext) {
	            upperButton = button;
                buttonSpan = button.find('span');
                if (!buttonSpan.length) {
                    buttonSpan = button
                }
                buttonSpan.text('Upload');
                this.disable();
                interval = window.setInterval(function () {
                    var text = button.text();
                    if (text.length < 10) {
                        buttonSpan.text(text + '.')
                    } else {
                        buttonSpan.text('.')
                    }
                }, 200)
            },
            onComplete: function (file, response) {		
        		var auxResp = response;
				var upperButtonSpan = buttonSpan;
				var upperInterval = interval;
				var upperThisAux = this;
				
				if (auxResp == '') {
					var ifrmae = jQuery('iframe[rel="upperUploadHelper"]')[0];
					if (ifrmae){
						var ifrmaeInt = setInterval(function(){
							if ( ifrmae.contentDocument.body.innerHTML != "" ){
								auxResp = ifrmae.contentDocument.body.innerHTML;
								imgUrl = uploadsUrl + '/' + auxResp;
								var defVal = upperButton.siblings('input.upload:first').attr('value');
								if(multi && defVal != "")
									upperButton.siblings('input.upload:first').attr('value', defVal+'|*|'+imgUrl);
								else
								upperButton.siblings('input.upload:first').attr('value', imgUrl);

								upperButtonSpan.text('Upload');
								upperThisAux.enable();
								
								ifrmae.remove();
								
								window.clearInterval(upperInterval);
								clearInterval(ifrmaeInt);
							}
						}, 100);
					}
				} else { 
					imgUrl = uploadsUrl + '/' + auxResp;
					var defVal = button.siblings('input.upload:first').attr('value');
					if(multi && defVal != "")
						button.siblings('input.upload:first').attr('value', defVal+'|*|'+imgUrl);
					else
					button.siblings('input.upload:first').attr('value', imgUrl);

					buttonSpan.text('Upload');
					window.clearInterval(interval);
					
					this.enable()
				}
            }
        })
    },
    setCheckboxClickHandlers: function () {
        jQuery(document).on("click", ".check", function (event) {
            event.preventDefault();
            var that = jQuery(this),
                value = that.attr('title'),
                checked = false,
                selectedClass = 'selected-check',
                hiddenInput = jQuery(that.parents().get(1)).siblings(".hidden-value:first"),
                hiddenIds = hiddenInput.val(),
                idsArray = hiddenIds === '' ? [] : hiddenIds.split(',');
            that.toggleClass(selectedClass);
            checked = that.hasClass(selectedClass);
            if (checked) {
                idsArray.push(value)
            } else {
                idsArray = jQuery.grep(idsArray, function (val) {
                    return val != value
                })
            }
            hiddenIds = idsArray.join(',');
            hiddenInput.val(hiddenIds)
        })
    },
    showSavedImgData: function (optionsData) {
        var count = optionsData.inputIds.length;
        var data = [];
        if (optionsData.hiddenIds[i]){
		    for (var i = 0; i < count; i++) {
	            data[i] = jQuery(optionsData.hiddenIds[i]).val().split(londresOptions.separator)
	        } 
	        for (var i = 0; i < count; i++) {
	            data[i] = jQuery(optionsData.hiddenIds[i]).val().split(londresOptions.separator)
	        }
          	var entryCount = data[0].length;
	        for (var j = 0; j < entryCount - 1; j++) {
	            var html = '<li>';
	            for (var i = 0; i < count; i++) {
	                if (optionsData.preview && optionsData.inputIds[i] === '#' + optionsData.preview) {
	                    html += londresOptions.generatePreview(data[i][j])
	                }
	                var none = data[i][j] === '' ? '<i>---</i>' : '';
	                html += '<b>' + optionsData.labels[i] + ': </b><span class="' + optionsData.spanClasses[i] + '">' + data[i][j] + '</span>' + none + '<br/>'
	            }
	            html += '<div class="editButton hover"></div><div class="deleteButton hover"></div></li>';
	            jQuery(optionsData.ulId).append(html)
	        }
        }
        
    },
    generatePreview: function (imgUrl) {
        return '<img src="' + imgUrl + '" />'
    },
    setCustomFieldsFunc: function (mainId, fieldIds, labels, istextarea, preview) {
        inputIds = [];
        hiddenIds = [];
        spanClasses = [];
        for (var i = 0, length = fieldIds.length; i < length; i++) {
            inputIds[i] = '#' + fieldIds[i];
            hiddenIds[i] = '#' + fieldIds[i] + 's';
            spanClasses[i] = fieldIds[i] + '_span'
        }
        var ulId = '#' + mainId + '_list';
        var addButton = '#' + mainId + '_button';
        optionsData = {
            inputIds: inputIds,
            hiddenIds: hiddenIds,
            spanClasses: spanClasses,
            istextarea: istextarea,
            ulId: ulId,
            labels: labels,
            addButton: addButton,
            preview: preview
        };
        londresOptions.setCommonAddFunc(optionsData)
    },
    setCommonAddFunc: function (optionsData) {
        londresOptions.showSavedImgData(optionsData);
        jQuery(optionsData.addButton).on("click", function (event) {
            event.preventDefault();
            londresOptions.addItem(optionsData)
        });
        jQuery(optionsData.ulId).on('sortstop', function (event, ui) {
            londresOptions.setSliderImgChanges(optionsData)
        });
        londresOptions.setActionButtonHandlers(optionsData)
    },
    addItem: function (optionsData) {
        var length = optionsData.inputIds.length;
        var html = '<li>';
        for (var i = 0; i < length; i++) {
            if (optionsData.preview && optionsData.inputIds[i] === '#' + optionsData.preview) {
                html += londresOptions.generatePreview(jQuery(optionsData.inputIds[i]).attr("value"))
            }
            html += '<b>' + optionsData.labels[i] + ': </b><span class="' + optionsData.spanClasses[i] + '">' + jQuery(optionsData.inputIds[i]).val() + '</span><br/>'
        }
        html += '<div class="editButton hover"></div><div class="deleteButton hover"></li>';
        jQuery(optionsData.ulId).append(html);
        londresOptions.setSliderImgChanges(optionsData)
    },
    setSliderImgChanges: function (optionsData) {
        var count = optionsData.inputIds.length;
        var values = [];
        for (i = 0; i < count; i++) {
            values[i] = ''
        }
        jQuery(optionsData.ulId + ' li').each(function () {
            for (i = 0; i < count; i++) {
                values[i] += jQuery(this).find('span.' + optionsData.spanClasses[i]).html() + londresOptions.separator
            }
        });
        for (i = 0; i < count; i++) {
            jQuery(optionsData.hiddenIds[i]).val(values[i])
        }
    },
    setActionButtonHandlers: function (optionsData) {
        jQuery(optionsData.ulId).delegate('.deleteButton', 'click', function () {
            jQuery(this).parent("li").remove();
            londresOptions.setSliderImgChanges(optionsData)
        });
        jQuery(optionsData.ulId).delegate('.editButton', 'click', function () {
            var currentLi = jQuery(this).parent('li');
            currentLi.find('i').remove();
            currentLi.find('span').each(function (i) {
                var that = jQuery(this),
                    spanclass = that.attr('class'),
                    spanvalue = that.html();
                if (optionsData.istextarea[i]) {
                    that.replaceWith(jQuery('<textarea type="text" class="inputarea ' + spanclass + '" >' + spanvalue + '</textarea>'))
                } else {
                    that.replaceWith(jQuery('<input type="text" value="' + spanvalue + '" class="' + spanclass + '" />'))
                }
            });
            jQuery(this).replaceWith(jQuery('<div class="doneButton hover"></div>').on("click", function (e) {
                e.preventDefault();
                currentLi.find('input,textarea').each(function () {
                    var that = jQuery(this),
                        spanclass = that.attr('class'),
                        spanvalue = that.val();
                    var none = spanvalue === '' ? '<i>---</i>' : '';
                    that.replaceWith(jQuery('<span class="' + spanclass + '">' + spanvalue + '</span>' + none))
                });
                londresOptions.setSliderImgChanges(optionsData);
                jQuery(this).replaceWith('<div class="editButton hover"></div>')
            }))
        })
    },
    makeExportFile: function(optionsData) { 
    	/* create the file */
    }
};

var londres_StyleOptionsManager = {
    separator: '|*|',
    dialogOpened: false,
    init: function (options) {
        londres_StyleOptionsManager.setCheckboxClickHandlers();
        londres_StyleOptionsManager.setHelpFunc();
        londres_StyleOptionsManager.setOnOffFunc();
        londres_StyleOptionsManager.setTextImageFunc();
        londres_StyleOptionsManager.setLeftRightFunc();
        londres_StyleOptionsManager.setLightDarkFunc();
        londres_StyleOptionsManager.setColorpickFunc();
        londres_StyleOptionsManager.setStyleSelectFunc();
        jQuery(".sortable").sortable();
        var mainNavOptions = {};
        if (options.cookie) {
            mainNavOptions = {
                cookie: {
                    name: 'tabs',
                    expires: 1
                }
            }
        }
        
        jQuery(document).on('click', '#options-submit', function (event) {
            event.preventDefault();
            jQuery('#londres-style-options').submit()
        });
        jQuery('#londres-content-container').delegate('.hover', 'mouseover', function () {
            jQuery(this).css({
                cursor: 'pointer'
            })
        });
        jQuery('.sortable').delegate('input', 'focusin', function () {
            jQuery(this).addClass('selected')
        }).delegate('input', 'focusout', function () {
            jQuery(this).removeClass('selected')
        });
        jQuery('#londres-content-container').append('<input type="hidden" value="Upper Options Panel" />')

		jQuery('#navigation ul').css({'border':'none'}).children('li').css({'height':'auto'}).find('a').css({'margin':'0 auto'}).children('span');
		
		londres_StyleOptionsManager.setTabs(options.cookie);
    },
    setTabs: function (enableCookies) {
		jQuery('.main-navigation-container').hide();
        var selectedClass = 'ui-tabs-selected',
            mainNavCookie_style = 'upper-style-main-navigation',
            subNavCookie_style = 'upper-style-sub-navigation',
            mainNotSel = (enableCookies && jQuery.cookie(mainNavCookie_style)) ? jQuery.cookie(mainNavCookie_style) : ':first',
            mainSel = mainNotSel === ':first' ? 'a:first' : 'a[href="' + mainNotSel + '"]';
        if (mainNotSel === ':first') {
            jQuery('.main-navigation-container:first').show()
        } else {
            jQuery(mainNotSel).show()
        }
        jQuery('#content').css({
            backgroundImage: 'none'
        });
        jQuery('#navigation ' + mainSel).closest('li').addClass(selectedClass);
        jQuery('.main-navigation-container').each(function () {
            var thisId = '#' + jQuery(this).attr('id'),
                notSel = (enableCookies && jQuery.cookie(thisId)) ? jQuery.cookie(thisId) : ':first',
                sel = notSel === ':first' ? 'a.tab:first' : 'a.tab[href="' + notSel + '"]';     
            jQuery(this).find('.sub-navigation-container').not(notSel).hide();
            jQuery(this).find(sel).closest('li').addClass(selectedClass)
        });
        jQuery(document).on('click', '#navigation a', function (event) {
            event.preventDefault();
            var href = jQuery(this).attr('href');
            jQuery('.main-navigation-container').hide();
            jQuery(href).show();
            jQuery('#navigation li').removeClass(selectedClass);
            jQuery(this).closest('li').addClass(selectedClass);
            if (enableCookies) {
                jQuery.cookie(mainNavCookie_style, href)
            }
        });
        jQuery(document).on('click', 'a.tab', function (event) {
            event.preventDefault();
            var href = jQuery(this).attr('href');
            jQuery(href).show().siblings('.sub-navigation-container').hide();
            jQuery(this).closest('li').addClass(selectedClass).siblings('li').removeClass(selectedClass);
            if (enableCookies) {
                var parentId = '#' + jQuery(this).closest('div.main-navigation-container').attr('id');
                jQuery.cookie("style-options-subnav", href)
            }
        });
        
        if ( jQuery.cookie('style-options-subnav') !== null ){
	        jQuery( 'a[href="'+jQuery.cookie('style-options-subnav')+'"]' ).trigger('click');
        }
    },
    removeSavedMessage: function () {
        jQuery('#saved_box').slideUp('slow')
    },
    setStyleSelectFunc: function () {
        jQuery('.styles-holder').each(function () {
            jQuery(this).delegate('a.style-box', 'click', function (event) {
                event.preventDefault();
                var $that = jQuery(this),
                    $parent = jQuery(this).parent();
                $parent.addClass('selected-style').siblings('.selected-style').removeClass('selected-style');
                $parent.parent().siblings('input').attr("value", $that.attr('title'))
            })
        })
    },
    setHelpFunc: function () {
        jQuery('#londres-content-container').delegate('a.help-button', 'click', function (event) {
            event.preventDefault();
            if (!londres_StyleOptionsManager.dialogOpened) {
                jQuery(this).find('.help-dialog:first').clone().dialog({
                    autoOpen: true,
                    title: jQuery(this).attr('title'),
                    closeText: '',
                    open: function () {
                        londres_StyleOptionsManager.dialogOpened = true
                    },
                    close: function () {
                        londres_StyleOptionsManager.dialogOpened = false
                    }
                })
            }
        })
    },
    setColorpickFunc: function () {
        jQuery('input.color').ColorPicker({
            onSubmit: function (hsb, hex, rgb, el) {
                jQuery(el).val(hex);
                jQuery(el).ColorPickerHide();
                jQuery(el).siblings('.color-preview').css({
                    backgroundColor: '#' + hex
                })
            },
            onBeforeShow: function () {
                jQuery(this).ColorPickerSetColor(this.value)
            }
        }).on('keyup', function () {
            var value = this.value;
            jQuery(this).ColorPickerSetColor(value);
            var bgColor = value === '' ? 'transparent' : '#' + value;
            jQuery(this).siblings('.color-preview').css({
                backgroundColor: bgColor
            })
        });
        jQuery('.color-preview').ColorPicker({
            onSubmit: function (hsb, hex, rgb, el) {
                jQuery(el).css({
                    backgroundColor: '#' + hex
                }).ColorPickerHide();
                jQuery(el).siblings('input.color').attr("value", hex)
            },
            onBeforeShow: function () {
                jQuery(this).ColorPickerSetColor(jQuery(this).siblings('input.color').attr('value'))
            }
        }).on({
            'keyup': function () {
                jQuery(this).ColorPickerSetColor(this.value)
            },
            'mouseover': function () {
                jQuery(this).css({
                    cursor: 'pointer'
                })
            }
        })
    },
    setOnOffFunc: function () {
        jQuery('div.on-off').each(function () {
            if (jQuery(this).siblings('input[type=hidden]:first').attr('value') === 'on') {
                jQuery(this).find('span').css({
                    marginLeft: 49
                })
            }
        });
        jQuery(document).on('click', 'div.on-off', function () {
            var hiddenInput = jQuery(this).siblings('input[type=hidden]:first');
            if (hiddenInput.attr('value') == 'on') {
                jQuery(this).find('span').animate({
                    marginLeft: 2
                });
                hiddenInput.attr('value', 'off')
            } else {
                jQuery(this).find('span').animate({
                    marginLeft: 49
                });
                hiddenInput.attr('value', 'on')
            }
        })
    },
    setTextImageFunc: function () {
        jQuery('div.text-image').each(function () {
            if (jQuery(this).siblings('input[type=hidden]:first').attr('value') === 'text') {
                jQuery(this).find('span').css({
                    marginLeft: 49
                })
            }
        });
        jQuery(document).on('click', 'div.text-image', function () {
            var hiddenInput = jQuery(this).siblings('input[type=hidden]:first');
            if (hiddenInput.attr('value') == 'text') {
                jQuery(this).find('span').animate({
                    marginLeft: 2
                });
                hiddenInput.attr('value', 'image')
            } else {
                jQuery(this).find('span').animate({
                    marginLeft: 49
                });
                hiddenInput.attr('value', 'text')
            }
        })
    },
    setLeftRightFunc: function () {
        jQuery('div.left-right').each(function () {
            if (jQuery(this).siblings('input[type=hidden]:first').attr('value') === 'right') {
                jQuery(this).find('span').css({
                    marginLeft: 49
                })
            }
        });
        jQuery(document).on('click', 'div.left-right', function () {
            var hiddenInput = jQuery(this).siblings('input[type=hidden]:first');
            if (hiddenInput.attr('value') == 'right') {
                jQuery(this).find('span').animate({
                    marginLeft: 2
                });
                hiddenInput.attr('value', 'left')
            } else {
                jQuery(this).find('span').animate({
                    marginLeft: 49
                });
                hiddenInput.attr('value', 'right')
            }
        })
    },
    setLightDarkFunc: function () {
        jQuery('div.light-dark').each(function () {
            if (jQuery(this).siblings('input[type=hidden]:first').attr('value') === 'light') {
                jQuery(this).find('span').css({
                    marginLeft: 49
                })
            }
        });
        jQuery(document).on('click', 'div.light-dark', function () {
            var hiddenInput = jQuery(this).siblings('input[type=hidden]:first');
            if (hiddenInput.attr('value') == 'light') {
                jQuery(this).find('span').animate({
                    marginLeft: 2
                });
                hiddenInput.attr('value', 'dark')
            } else {
                jQuery(this).find('span').animate({
                    marginLeft: 49
                });
                hiddenInput.attr('value', 'light')
            }
        })
    },
    loadUploader: function (element, pathToPhp, uploadsUrl, multi) {
		if (multi == null){
			multi = false;
		}
        var button = element,
            interval, buttonSpan, upperButtonSpan, upperButton, upperInterval;
        new AjaxUpload(button, {
            action: ajaxurl,
            name: "upperfile",
			type: "POST",
			dataType: "JSON",
			data: {
				action: "call_upper_upload_handler",
				security: jQuery('input#londres-theme-upload-handler').val()
			},
            onSubmit: function (file, ext) {
	            upperButton = button;
                buttonSpan = button.find('span');
                if (!buttonSpan.length) {
                    buttonSpan = button
                }
                buttonSpan.text('Upload');
                this.disable();
                interval = window.setInterval(function () {
                    var text = button.text();
                    if (text.length < 10) {
                        buttonSpan.text(text + '.')
                    } else {
                        buttonSpan.text('.')
                    }
                }, 200)
            },
            onComplete: function (file, response) {
            	var auxResp = response;
				var upperButtonSpan = buttonSpan;
				var upperInterval = interval;
				var upperThisAux = this;
				
				if (auxResp == '') {
					var ifrmae = jQuery('iframe[rel="upperUploadHelper"]')[0];
					if (ifrmae){
						var ifrmaeInt = setInterval(function(){
							if ( ifrmae.contentDocument.body.innerHTML != "" ){
								auxResp = ifrmae.contentDocument.body.innerHTML;
								imgUrl = uploadsUrl + '/' + auxResp;
								var defVal = upperButton.siblings('input.upload:first').attr('value');
								if(multi && defVal != "")
									upperButton.siblings('input.upload:first').attr('value', defVal+'|*|'+imgUrl);
								else
								upperButton.siblings('input.upload:first').attr('value', imgUrl);

								upperButtonSpan.text('Upload');
								upperThisAux.enable();
								
								ifrmae.remove();
								
								window.clearInterval(upperInterval);
								clearInterval(ifrmaeInt);
							}
						}, 100);
					}
				} else { 
					imgUrl = uploadsUrl + '/' + auxResp;
					var defVal = button.siblings('input.upload:first').attr('value');
					if(multi && defVal != "")
						button.siblings('input.upload:first').attr('value', defVal+'|*|'+imgUrl);
					else
					button.siblings('input.upload:first').attr('value', imgUrl);

					buttonSpan.text('Upload');
					window.clearInterval(interval);
					
					this.enable()
				}
            }
        })
    },
    setCheckboxClickHandlers: function () {
        jQuery(document).on("click", ".check", function (event) {
            event.preventDefault();
            var that = jQuery(this),
                value = that.attr('title'),
                checked = false,
                selectedClass = 'selected-check',
                hiddenInput = jQuery(that.parents().get(1)).siblings(".hidden-value:first"),
                hiddenIds = hiddenInput.val(),
                idsArray = hiddenIds === '' ? [] : hiddenIds.split(',');
            that.toggleClass(selectedClass);
            checked = that.hasClass(selectedClass);
            if (checked) {
                idsArray.push(value)
            } else {
                idsArray = jQuery.grep(idsArray, function (val) {
                    return val != value
                })
            }
            hiddenIds = idsArray.join(',');
            hiddenInput.val(hiddenIds)
        })
    },
    showSavedImgData: function (optionsData) {
        var count = optionsData.inputIds.length;
        var data = [];
        if (optionsData.hiddenIds[i]){
		    for (var i = 0; i < count; i++) {
	            data[i] = jQuery(optionsData.hiddenIds[i]).val().split(londres_StyleOptionsManager.separator)
	        } 
	        for (var i = 0; i < count; i++) {
	            data[i] = jQuery(optionsData.hiddenIds[i]).val().split(londres_StyleOptionsManager.separator)
	        }
          	var entryCount = data[0].length;
	        for (var j = 0; j < entryCount - 1; j++) {
	            var html = '<li>';
	            for (var i = 0; i < count; i++) {
	                if (optionsData.preview && optionsData.inputIds[i] === '#' + optionsData.preview) {
	                    html += londres_StyleOptionsManager.generatePreview(data[i][j])
	                }
	                var none = data[i][j] === '' ? '<i>---</i>' : '';
	                html += '<b>' + optionsData.labels[i] + ': </b><span class="' + optionsData.spanClasses[i] + '">' + data[i][j] + '</span>' + none + '<br/>'
	            }
	            html += '<div class="editButton hover"></div><div class="deleteButton hover"></div></li>';
	            jQuery(optionsData.ulId).append(html)
	        }
        }
        
    },
    generatePreview: function (imgUrl) {
        return '<img src="' + imgUrl + '" />'
    },
    setCustomFieldsFunc: function (mainId, fieldIds, labels, istextarea, preview) {
        inputIds = [];
        hiddenIds = [];
        spanClasses = [];
        for (var i = 0, length = fieldIds.length; i < length; i++) {
            inputIds[i] = '#' + fieldIds[i];
            hiddenIds[i] = '#' + fieldIds[i] + 's';
            spanClasses[i] = fieldIds[i] + '_span'
        }
        var ulId = '#' + mainId + '_list';
        var addButton = '#' + mainId + '_button';
        optionsData = {
            inputIds: inputIds,
            hiddenIds: hiddenIds,
            spanClasses: spanClasses,
            istextarea: istextarea,
            ulId: ulId,
            labels: labels,
            addButton: addButton,
            preview: preview
        };
        londres_StyleOptionsManager.setCommonAddFunc(optionsData)
    },
    setCommonAddFunc: function (optionsData) {
        londres_StyleOptionsManager.showSavedImgData(optionsData);
        jQuery(optionsData.addButton).on("click", function (event) {
            event.preventDefault();
            londres_StyleOptionsManager.addItem(optionsData)
        });
        jQuery(optionsData.ulId).on('sortstop', function (event, ui) {
            londres_StyleOptionsManager.setSliderImgChanges(optionsData)
        });
        londres_StyleOptionsManager.setActionButtonHandlers(optionsData)
    },
    addItem: function (optionsData) {
        var length = optionsData.inputIds.length;
        var html = '<li>';
        for (var i = 0; i < length; i++) {
            if (optionsData.preview && optionsData.inputIds[i] === '#' + optionsData.preview) {
                html += londres_StyleOptionsManager.generatePreview(jQuery(optionsData.inputIds[i]).attr("value"))
            }
            html += '<b>' + optionsData.labels[i] + ': </b><span class="' + optionsData.spanClasses[i] + '">' + jQuery(optionsData.inputIds[i]).val() + '</span><br/>'
        }
        html += '<div class="editButton hover"></div><div class="deleteButton hover"></li>';
        jQuery(optionsData.ulId).append(html);
        londres_StyleOptionsManager.setSliderImgChanges(optionsData)
    },
    setSliderImgChanges: function (optionsData) {
        var count = optionsData.inputIds.length;
        var values = [];
        for (i = 0; i < count; i++) {
            values[i] = ''
        }
        jQuery(optionsData.ulId + ' li').each(function () {
            for (i = 0; i < count; i++) {
                values[i] += jQuery(this).find('span.' + optionsData.spanClasses[i]).html() + londres_StyleOptionsManager.separator
            }
        });
        for (i = 0; i < count; i++) {
            jQuery(optionsData.hiddenIds[i]).val(values[i])
        }
    },
    setActionButtonHandlers: function (optionsData) {
        jQuery(optionsData.ulId).delegate('.deleteButton', 'click', function () {
            jQuery(this).parent("li").remove();
            londres_StyleOptionsManager.setSliderImgChanges(optionsData)
        });
        jQuery(optionsData.ulId).delegate('.editButton', 'click', function () {
            var currentLi = jQuery(this).parent('li');
            currentLi.find('i').remove();
            currentLi.find('span').each(function (i) {
                var that = jQuery(this),
                    spanclass = that.attr('class'),
                    spanvalue = that.html();
                if (optionsData.istextarea[i]) {
                    that.replaceWith(jQuery('<textarea type="text" class="inputarea ' + spanclass + '" >' + spanvalue + '</textarea>'))
                } else {
                    that.replaceWith(jQuery('<input type="text" value="' + spanvalue + '" class="' + spanclass + '" />'))
                }
            });
            jQuery(this).replaceWith(jQuery('<div class="doneButton hover"></div>').on("click", function (e) {
                e.preventDefault();
                currentLi.find('input,textarea').each(function () {
                    var that = jQuery(this),
                        spanclass = that.attr('class'),
                        spanvalue = that.val();
                    var none = spanvalue === '' ? '<i>---</i>' : '';
                    that.replaceWith(jQuery('<span class="' + spanclass + '">' + spanvalue + '</span>' + none))
                });
                londres_StyleOptionsManager.setSliderImgChanges(optionsData);
                jQuery(this).replaceWith('<div class="editButton hover"></div>')
            }))
        })
    },
    makeExportFile: function(optionsData) { 
    	/* create the file */
    }
};

jQuery(window).on("load", function () {
    if (jQuery('#saved_box').length) {
        setTimeout('londresOptions.removeSavedMessage()', 3000);
		setTimeout('londres_StyleOptionsManager.removeSavedMessage()', 3000);
    }
});


jQuery(document).ready(function(){
	
	if (jQuery('#upper_single_metas_customtext').length){
		
		jQuery('#upper_single_metas_customtext').on("change", function(){
			if (jQuery(this).is(':checked')){
				jQuery('#upper_single_meta_custom_text_noncename').parent().css('display','block');
			} else {
				jQuery('#upper_single_meta_custom_text_noncename').parent().css('display','none');
			}
		});
		
		jQuery('#upper_single_display_metas_value').on("change",function(){
			if (jQuery(this).val() == "yes") {
				jQuery('.upper_single_metas').add( jQuery('#upper_single_meta_custom_text_noncename').parent() ).css('display','block'); 
				jQuery('#upper_single_metas_customtext').trigger('change');
			}
			else {
				jQuery('.upper_single_metas').add( jQuery('#upper_single_meta_custom_text_noncename').parent() ).css('display','none');
			}
		}).trigger('change');
		
	}
	
});

jQuery(document).on("click", "#londres_demos_container .theme-browser .theme-actions a", function(){
	var lo_demo = jQuery(this).closest(".theme").attr("data-theme-slug");
	var errors = false;
	var confirmdemo = confirm("Are you sure you want to continue?");
	if (confirmdemo == true){
		console.warn("Import initiated: "+new Date().toLocaleTimeString().replace("/.*(\d{2}:\d{2}:\d{2}).*/", "$1"));
		if (jQuery(".londres_demo_status").data("uiDialog")) jQuery(".londres_demo_status").dialog("destroy");
		jQuery(".londres_demo_status").attr("title","Applying the demo").html("<span class=\'spinner is-active\'></span>Installing the theme.<br/>Status:<ul class=\'londres_demo_progress\'></ul>").dialog({
			modal: true,
			closeOnEscape: false,
			autoOpen: false,
			draggable: false,
			buttons: [ { text: "Ok", click: function() {  } } ],
			open: function () {
				jQuery(this).closest(".ui-dialog")
					.find(".ui-button") // the first button
					.addClass("ui-state-disabled").blur();
			}
		}).css("text-align","left").find("button").addClass("ui-state-disabled");
		
		jQuery(".londres_demo_status").dialog("open");
		jQuery(".londres_demo_status").data("uiDialog").uiButtonSet.find("button").on("click", function(){
			var vlocal = window.location.toString();
			if (vlocal.indexOf("&demo") > 0){
				vlocal = vlocal.substr(0, vlocal.indexOf("&demo"));
			}
			window.location = vlocal + "&demo=" + lo_demo;
		});
		
		jQuery(".londres_demo_status").dialog("option", "title", "Applying the demo - 0%");
		
		var max_execution_time = typeof max_execution_time == 'object' ? parseInt(max_execution_time['max_execution_time'], 10) : 0;
		
		var aux, aux2, server_timeout = (aux2 = (aux = (max_execution_time < 30 ? 30 : max_execution_time) - 10) < 25 ? 25 : aux) > 120 ? 120 : aux2;
		// reset database & activate theme 
		jQuery.retryAjax({
			url: ajaxurl,
			dataType: "json",
			type: "POST",
			retryLimit : 100,
			timeout : server_timeout*1000,
			data: { 
				demo: lo_demo ,
				upper_action: "fake-dbreset",
				thepath: jQuery("#homePATH").html()!=""?jQuery("#homePATH").html():jQuery("#homePATH2").html(),
				action: "call_upper_demo_installer",
				security: jQuery("input#londres-theme-options").val()
			},
			success: function(response){
				
				jQuery(".londres_demo_progress").append("<li>Theme Reactivation [OK]</li>");
				jQuery(".londres_demo_status").dialog("option", "position", "center");
				
				jQuery(".londres_demo_status").dialog("option", "title", "Applying the demo - 15%");
				jQuery(".londres_demo_progress").append("<li class=\'des_step_plugins\'>Installing Plugins...</li>");

				// plugins installation 
				jQuery.retryAjax({
					url: ajaxurl,
					dataType: "json",
					type: "POST",
					retryLimit : 100,
					timeout : server_timeout*1000,
					data: { 
						demo : lo_demo ,
						upper_action: "install_plugins",
						thepath: jQuery("#homePATH").html()!=""?jQuery("#homePATH").html():jQuery("#homePATH2").html(),
						action: "call_upper_demo_installer",
						security: jQuery("input#londres-theme-options").val()
					},
					success: function(response){
						jQuery(".londres_demo_status").dialog("option", "title", "Applying the demo - 35%");
						jQuery(".londres_demo_progress .des_step_plugins").html("Plugins Installed [OK]");
						jQuery(".londres_demo_status").dialog("option", "position", "center");

						// set panel options
						jQuery(".londres_demo_progress").append("<li class=\'des_step_panels\'>Setting Panels Options...</li>");
						var xmlPath = "https://demos.upperthemes.com/demos/londres/"+lo_demo+"/options.xml";
						var xmlStylePath = "https://demos.upperthemes.com/demos/londres/"+lo_demo+"/style_options.xml";
					
						jQuery.retryAjax({
							url: ajaxurl,
							type: "POST",
							dataType: "json",
							retryLimit : 100,
							timeout : server_timeout*1000,
							data: {
								xmlPath: xmlPath,
								xmlStylePath: xmlStylePath,
								thepath: jQuery("#homePATH").html()!=""?jQuery("#homePATH").html():jQuery("#homePATH2").html(),
								action: "call_upper_demo_installer",
								security: jQuery("input#londres-theme-options").val(),
								upper_action: "load_settings"
							},
							success: function (response) {
								jQuery(".londres_demo_status").dialog("option", "title", "Applying the demo - 60%");
								jQuery(".londres_demo_progress .des_step_panels").html("Panels Options [OK]");
								jQuery(".londres_demo_status").dialog("option", "position", "center");
								jQuery(".londres_demo_progress").append("<li class=\'des_step_contents\'>Importing Contents...</li>");
								var desitimeout = Math.floor(Math.random() * 12) + 3;
								var incre = Math.floor(Math.random() * 2) + 1;
								var perc = 60;
								londres_import_percentage(desitimeout,incre,perc);
						
								// import contents and set homepage and menu
								jQuery.ajax({
									url: ajaxurl,
									dataType: "json",
									type: "POST",
									retryLimit : 100,
									retryCount: 0,
									data: { 
										demo: lo_demo,
										upper_action: "import_content_set_options",
										thepath: jQuery("#homePATH").html()!=""?jQuery("#homePATH").html():jQuery("#homePATH2").html(),
										action: "call_upper_demo_installer",
										security: jQuery("input#londres-theme-options").val()
									},
									success: function(response){
										
										if (desitimeout){
											desitimeout = false;
											clearInterval(window.desigtimeout);
										}
										jQuery(".londres_demo_status").dialog("option", "title", "Applying the demo - 90%");
										jQuery(".londres_demo_progress .des_step_contents").html("Import Contents [OK]");
										jQuery(".londres_demo_progress").append("<li>Set Menu [OK]</li>");
										jQuery(".londres_demo_status").dialog("option", "position", "center");
										jQuery(".londres_demo_progress").append("<li class=\'des_step_widgets\'>Importing Widgets...</li>");

										// Import Widgets
										jQuery.retryAjax({
											url: ajaxurl,
											dataType: "json",
											type: "POST",
											retryLimit : 100,
											timeout : server_timeout*1000,
											data: { 
												demo: lo_demo,
												upper_action: "import_widgets",
												thepath: jQuery("#homePATH").html()!=""?jQuery("#homePATH").html():jQuery("#homePATH2").html(),
												action: "call_upper_demo_installer",
												security: jQuery("input#londres-theme-options").val()
											},
											success: function(response){
												jQuery(".londres_demo_status .spinner").removeClass("is-active");
												jQuery(".londres_demo_progress .des_step_widgets").html("Import Widgets [OK]");
												jQuery(".londres_demo_status").dialog("option", "position", "center");
												// Reload to complete. 
												jQuery(".londres_demo_status").append("<p style=\'left:20px; line-height: 15px;\'>Process almost complete.<br/>Click OK to Continue.</p>");
												jQuery("button.ui-button.ui-state-disabled").removeClass("ui-state-disabled");
												jQuery(".londres_demo_status").dialog("option", "title", "Applying the demo - 100%");
									
												console.warn("COMPLETE: "+new Date().toLocaleTimeString().replace("/.*(\d{2}:\d{2}:\d{2}).*", "$1"));
											}
										});
									},
									error: function(a){
										console.warn(' Server Timeout. Retrying... please, be patient. If it fails completely, we will tell you!');
										this.retryCount++;
										if (this.retryCount < this.retryLimit){
											jQuery.ajax(this);
										} else {
											londres_ajax_error_handler();
										}
									}
								});
							}
						});
					}
				});	
			}
		});
	} else {
		console.log("Process aborted by user. Exit.");
	}	
});

function londres_ajax_error_handler(){ jQuery(".londres_demo_progress").after("<div class=\'error\'>An unexpected error has occurred. Please <a href=\'#\' onclick=\'javascript:window.location=window.location;\'>refresh</a> the page and try again. If the problem persists, please <a href=\'https://upperthemes.com/support/\'>contact us</a>.</div>"); }
function londres_import_percentage(t,o,i){window.desigtimeout=setTimeout(function(){i<90?(i+o>89&&(o=89-i),i+=o,jQuery(".londres_demo_status").dialog("option","title","Applying the demo - "+i+"%"),t=Math.floor(12*Math.random())+5,o=Math.floor(2*Math.random())+1,londres_import_percentage(t,o,i)):(clearTimeout(window.desigtimeout),t=!1)},1e3*t)}
function upperRemoveParam(i,r){var t=r.split("?")[0],e=[],l=-1!==r.indexOf("?")?r.split("?")[1]:"";if(""!==l){for(var n=(e=l.split("&")).length-1;n>=0;n-=1)e[n].split("=")[0]===i&&e.splice(n,1);t=t+"?"+e.join("&")}return t}

(function(jQuery){jQuery.retryAjax=function(ajaxParams){var errorCallback;ajaxParams.tryCount=(!ajaxParams.tryCount)?0:ajaxParams.tryCount;ajaxParams.retryLimit=(!ajaxParams.retryLimit)?2:ajaxParams.retryLimit;ajaxParams.suppressErrors=true;if(ajaxParams.error){errorCallback=ajaxParams.error;delete ajaxParams.error;londres_ajax_error_handler()}else{errorCallback=function(){console.warn('ERROR CALLBACK. Please Refresh');};}
ajaxParams.complete=function(jqXHR,textStatus){if(textStatus!="success"){this.tryCount++;if(this.tryCount<=this.retryLimit){if(this.tryCount===this.retryLimit){this.error=errorCallback;delete this.suppressErrors;}
jQuery.ajax(this);return true;}
return true;}};jQuery.ajax(ajaxParams);};}(jQuery));