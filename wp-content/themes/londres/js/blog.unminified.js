function initBlogs() {
	jQuery(".pbd-alp-placeholder").html(""), jQuery(".posts_category_filter").length && (jQuery(".posts_category_filter .showall .counter").text(" (" + jQuery("article").length + ")"), jQuery(".posts_category_filter li:not(.showall)").each(function() {
		var e = jQuery(this);
		e.find(".counter").text(" (" + jQuery("article." + e.attr("class").replace(" disable", "")).length + ")"), jQuery("article." + e.attr("class").replace(" disable", "")).length < 1 ? e.addClass("disable") : e.removeClass("disable")
	}));
	for (var e = 0; e < 17; e++) jQuery("li.depth-" + e).each(function() {
		jQuery(this).css({
			width: jQuery(this).parent().width() - 10 * (e - 1) + "px"
		})
	});
	jQuery(".post-listing .flexslider").length && jQuery(".post-listing .flexslider").each(function() {
		jQuery(this).parents(".single").length ? jQuery(this).flexslider({
			animation: "fade",
			controlNav: !0,
			directionNav: !0,
			touch: !0
		}) : jQuery(this).flexslider({
			animation: "fade",
			controlNav: !0,
			directionNav: !0,
			touch: !0,
			start: function(e) {
				jQuery(e).find(".flex-direction-nav li a").each(function() {
					jQuery(this).on("mouseenter", function() {
						jQuery(this).css("background-color", window.londresOptions.styleColor)
					}).on("mouseleave", function() {
						jQuery(this).css("background-color", "rgba(0, 0, 0, 0.5)")
					})
				})
			}
		})
	}), jQuery(".the_movies").length && jQuery(".the_movies").each(function() {
		var e = jQuery(this).attr("data-movie");
		if (e ? jQuery(this).html("<iframe src='" + jQuery(".v_links[data-movie=" + e + "]").eq(0).html() + "' width='100%' height='370' frameborder='0' webkitAllowFullScreen mozallowfullscreen allowFullScreen></iframe>") : jQuery(this).html("<iframe src='" + jQuery(".v_links").eq(0).html() + "' width='100%' height='370' frameborder='0' webkitAllowFullScreen mozallowfullscreen allowFullScreen></iframe>"), jQuery(".the_movies").siblings(".v_links").length > 1) {
			jQuery(this).find(".movies-nav").remove(), jQuery(this).append('<ul class="flex-direction-nav movies-nav"><li><a class="prev" href="javascript:;">Previous</a></li><li><a class="next" href="javascript:;">Next</a></li></ul>'), jQuery(this).siblings(".current_movie").remove(), jQuery(this).after('<div style="display:none;" class="current_movie">0</div>');
			var t = jQuery(this);
			jQuery(this).find(".movies-nav .prev").on("click", function(e) {
				e.preventDefault();
				var r = parseInt(t.siblings(".current_movie").html()),
					a = 0;
				a = 0 == r ? t.siblings(".v_links").length - 1 : r - 1, t.find("iframe").attr("src", t.siblings(".v_links").eq(a).html()), t.siblings(".current_movie").html(a)
			}), jQuery(this).find(".movies-nav .next").on("click", function(e) {
				e.preventDefault();
				var r = parseInt(t.siblings(".current_movie").html()),
					a = 0;
				a = r == t.siblings(".v_links").length - 1 ? 0 : r + 1, t.find("iframe").attr("src", t.siblings(".v_links").eq(a).html()), t.siblings(".current_movie").html(a)
			})
		}
	}), jQuery(".postcontent .flexslider.slider").length && jQuery(".postcontent .flexslider.slider .mask .more").each(function() {
		jQuery(this).attr("onclick", "jQuery(this).parents('.mask').siblings('ul.slides').find('li').eq(0).find('a').trigger('click');")
	}), jQuery("a.comment-reply-link").each(function() {
		-1 != jQuery(this).attr("href").indexOf("#") && jQuery(this).on("click", function() {
			jQuery("html,body").animate({
				scrollTop: jQuery(this).offset().top - 80
			}, 222, "jswing")
		})
	}), jQuery(".container .vendor").length && jQuery(".container .vendor").fitVids()
}

function londres_monitorScrollTop() {
	if (jQuery("#pbd-alp-load-posts").length) {
		var e = getScrollTop();
		window.loadingPoint = parseInt(jQuery("#pbd-alp-load-posts").offset().top - jQuery(window).height() + 50, 10), e >= window.loadingPoint && (clearInterval(window.interval), jQuery("#pbd-alp-load-posts a").trigger("click"))
	} else clearInterval(window.interval)
}

function getScrollTop() {
	if ("undefined" != typeof pageYOffset) return pageYOffset;
	var e = document.body,
		t = document.documentElement;
	return (t = t.clientHeight ? t : e).scrollTop
}
jQuery(document).ready(function(e) {
	"use strict";
	initBlogs()
}), jQuery(document).ready(function(e) {
	"use strict";
	window.londres_pageNum = 0 != parseInt(window.londresOptions.loader_startPage, 10) ? parseInt(window.londresOptions.loader_startPage, 10) : 1, window.londres_totalForward = 1, window.londres_totalBackward = -1;
	var t = parseInt(window.londresOptions.loader_maxPages),
		r = "empty";
	jQuery(".navigation .next-posts").parent().attr("href") && (r = jQuery(".navigation .next-posts").parent().attr("href"));
	var a = "empty";
	jQuery(".navigation .prev-posts").parent().attr("href") && (a = jQuery(".navigation .prev-posts").parent().attr("href")), "empty" == r && "empty" == a || "scroll" !== window.londresOptions.reading_option && "scrollauto" !== window.londresOptions.reading_option || (parseInt(window.londres_pageNum, 10) + 1 <= t && jQuery(".post-listing").each(function() {
		if (0 == jQuery(this).parents(".recentPosts_widget").length && 0 == jQuery(this).parents(".single").length) {
			var e = '<p id="pbd-alp-load-posts"><a href="javascript:;">' + window.londresOptions.londres_load_more_posts_text + "</a></p>";
			jQuery(this).parent().append('<div style="position:relative;float:left;display:inline-block;width:100%;" class="pbd-alp-placeholder pbd-alp-placeholder-' + (parseInt(window.londres_pageNum, 10) + 1) + '"></div>').append(e)
		}
		0 == jQuery(this).parents(".single").length && jQuery(".navigation").css("display", "none")
	}), parseInt(window.londres_pageNum, 10) > 1 && jQuery(".post-listing").each(function() {
		if (0 == jQuery(this).parents(".recentPosts_widget").length && 0 == jQuery(this).parents(".single").length) {
			var e = '<p id="pbd-alp-load-newer-posts" style="position: relative; height:50px;width:100%;text-align:center;"><a style=" position: relative; display:inline-block;" href="javascript:;">' + window.londresOptions.londres_load_more_posts_text + "</a></p>";
			jQuery(this).parent().prepend('<div class="pbd-alp-placeholder-newer-' + (parseInt(window.londres_pageNum, 10) - 1) + '"></div>').prepend(e)
		}
		0 == jQuery(this).parents(".single").length && jQuery(".navigation").css("display", "none")
	}), jQuery("#pbd-alp-load-posts a").length && jQuery("#pbd-alp-load-posts a").on("click", function(e) {
		return window.londres_pageNum + window.londres_totalForward <= t ? (jQuery(this).html(window.londresOptions.londres_loading_posts_text + '<img style="width:16px; height: 16px; margin-left: 5px; position: relative;" src="' + window.londresOptions.templatepath + '/images/ajx_loading.gif">'), jQuery(".pbd-alp-placeholder-" + parseInt(window.londres_pageNum + window.londres_totalForward, 10)).load(r + " article", function() {
			if (jQuery(".pbd-alp-placeholder-" + parseInt(window.londres_pageNum + window.londres_totalForward, 10) + " article").each(function() {
					jQuery(".post-listing").hasClass("journal") ? (window.iso.isotope("insert", jQuery(this)), jQuery(window).trigger("resize")) : jQuery(this).appendTo(jQuery(".post-listing")), jQuery(this).hasClass("recent") && jQuery(this).remove()
				}), window.londres_totalForward = parseInt(window.londres_totalForward + 1), r = r.indexOf("paged") < 0 ? r.replace(/\/page\/[0-9]?/, "/page/" + parseInt(window.londres_pageNum + window.londres_totalForward, 10)) : r.replace(/paged=[0-9]?/, "paged=" + parseInt(window.londres_pageNum + window.londres_totalForward, 10)), jQuery("#pbd-alp-load-posts").before('<div style="position:relative;float:left;width:100%;display:inline-block;" class="pbd-alp-placeholder pbd-alp-placeholder-' + parseInt(window.londres_pageNum + window.londres_totalForward, 10) + '"></div>'), window.londres_pageNum + window.londres_totalForward <= t) jQuery("#pbd-alp-load-posts a").text(window.londresOptions.londres_load_more_posts_text), "scrollauto" !== window.londresOptions.reading_option || jQuery("body").hasClass("single") || (window.clearInterval(window.londres_interval), window.londres_interval = setInterval("londres_monitorScrollTop()", 1e3));
			else {
				jQuery("#pbd-alp-load-posts a").text(window.londresOptions.londres_no_more_posts_text);
				setTimeout(function() {
					jQuery("#pbd-alp-load-posts").slideUp(500).fadeOut(500)
				}, 5e3);
				window.clearInterval(window.londres_interval)
			}
			jQuery(".post-listing").next(".pbd-alp-placeholder").remove(), initBlogs()
		}).fadeIn(5e3)) : window.clearInterval(window.londres_interval), !1
	}), jQuery("#pbd-alp-load-newer-posts a").length && jQuery("#pbd-alp-load-newer-posts a").on("click", function(e) {
		return window.londres_pageNum + window.londres_totalBackward > 0 ? (jQuery(this).html(window.londresOptions.londres_loading_posts_text + '<img style="width:16px; height: 16px; margin-left: 5px; position: relative;" src="' + window.londresOptions.templatepath + '/images/ajx_loading.gif">'), jQuery(".pbd-alp-placeholder-newer-" + (window.londres_pageNum + window.londres_totalBackward)).load(a + " article", function() {
			if (jQuery(".pbd-alp-placeholder-newer-" + (window.londres_pageNum + window.londres_totalBackward) + " article").each(function() {
					jQuery(this).hasClass("recent") && jQuery(this).remove(), jQuery(".post-listing").hasClass("journal") ? (jQuery(this).prependTo(jQuery(".journal")), window.iso.isotope("reloadItems").isotope({
						sortBy: "original-order"
					}), jQuery(window).trigger("resize")) : jQuery(this).prependTo(jQuery(".post-listing"))
				}), window.londres_totalBackward = window.londres_totalBackward - 1, a = a.indexOf("paged") < 0 ? a.replace(/\/page\/[0-9]?/, "/page/" + (window.londres_pageNum + window.londres_totalBackward)) : a.replace(/paged=[0-9]?/, "paged=" + (window.londres_pageNum + window.londres_totalBackward)), jQuery("#pbd-alp-load-newer-posts").after('<div class="pbd-alp-placeholder-newer-' + parseInt(window.londres_pageNum + window.londres_totalBackward) + '"></div>'), window.londres_pageNum + window.londres_totalBackward + 1 > 1) jQuery("#pbd-alp-load-newer-posts a").text(window.londresOptions.londres_load_more_posts_text);
			else {
				jQuery("#pbd-alp-load-newer-posts a").text(window.londresOptions.londres_no_more_posts_text);
				setTimeout(function() {
					jQuery("#pbd-alp-load-newer-posts").slideUp(500).fadeOut(500)
				}, 5e3)
			}
			jQuery(".post-listing").hasClass("journal") && jQuery(".pbd-alp-placeholder-newer-" + (window.londres_pageNum + window.londres_totalBackward)).remove(), initBlogs()
		}).fadeIn(5e3)) : window.clearInterval(window.londres_interval), !1
	}))
});
