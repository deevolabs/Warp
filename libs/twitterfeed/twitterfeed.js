//**************************************************************************************
//CREATED BY           	:   ABHIJITH BABU
//EMAIL ID             	:   ABHIJITHBABU@GMAIL.COM
//DATE                  :   23 MARCH 2011
//DESCRIPTION 			: 	TWITTER FEED JQUERY PLUGIN
//**************************************************************************************
(function($) {
	$.fn.twitterfeed = function(term, options) {

		var defaultSettings = {
			count : 10,
			timer : 5000,
			type : "query",
			autoplay : 1,
			multiple : false
		};
		var twitterArr = {};
		var FadeArr = {};
		var flagstart = 0;
		var settings = $.extend(defaultSettings, options);
		if (settings.type == "query") {
			if (settings.multiple == false || settings.multiple == '') {
				var url = "http://search.twitter.com/search.json?q="
						+ escape(term) + "&rpp=" + settings.count
						+ "&callback=?";
			} else {
				var url = "http://search.twitter.com/search.json?ors="
						+ escape(term) + "&rpp=" + settings.count
						+ "&callback=?";
			}
		} else {
			term = term.replace(/\s+/g, '+OR+from:');
			var url = "http://search.twitter.com/search.json?q=from%3A"
					+ escape(term) + "&rpp=" + settings.count + "&callback=?";

		}
		if (this) {
			var holder = this;
		}
		searchtwitter();
		function searchtwitter() {
			jQuery
					.getJSON(
							url,
							function(response) {

								var result_container = response.results;

								if (result_container) {
									var i = -1;
									var result;
									var tweets = [];
									while ((result = result_container[++i])
											&& !twitterArr[result.id]) {

										twitterArr[result.id] = result.id;
										name = result.from_user;
										prof_img = result['profile_image_url'];
										username = result.from_user;

										tweets.push('<li id="TwitterId');
										tweets.push(result.id);
										tweets
												.push('"><a class="avatar" href="http://www.twitter.com/');
										tweets.push(name);
										tweets
												.push('" title="Visit profile" target="_blank"><img  src="');
										tweets.push(prof_img);
										tweets
												.push('" alt="Profile Image"  class="userImg"/></a><div class="body"><a class="username"  href="http://www.twitter.com/');
										tweets.push(name);
										tweets
												.push('" title="Visit profile" target="_blank">');
										tweets.push(username);
										tweets.push('</a><div class="message"> ');
										tweets.push(result.text.makeLink());
										tweets
												.push('</div><div class="feedInfo">');
										tweets
												.push(get_time(result.created_at));
										tweets.push('</div></div></li>');
										idgot = result.id;
										if (flagstart != 0) {
											break;
										}
									}
									var html_output = tweets.join("");
									flagstart = 1;
									if (html_output !== '')
										holder.prepend(html_output).find(
												'li:hidden')
												.slideToggle('slow');
									if (!FadeArr[idgot]) {
										element = jQuery("#TwitterId" + idgot);
										animatebackground(element, 5, 0);
										FadeArr[idgot] = idgot;
									}
									holder.children(
											"li:gt(" + settings.count + ")")
											.remove();
								}
							})

		}

		$.fn.start = function() {
			timerInst = setInterval(function() {
				searchtwitter()
			}, settings.timer);
		};
		$.fn.pause = function() {
			clearInterval(timerInst);
		};
		if (typeof String.prototype.makeLink === "undefined") {
			String.prototype.makeLink = function() {
				return this
						.replace(
								/[A-Za-z]+:\/\/[A-Za-z0-9-_]+\.[A-Za-z0-9-_:%&\?\/~.=]+/,
								function(m) {
									return m.link(m);
								});
			};
		}
		function get_time(time_value) {
			var valArr = time_value.split(" ");
			time_value = valArr[2] + " " + valArr[1] + ", " + valArr[3] + " "
					+ valArr[4];
			var parsedDt = Date.parse(time_value);
			var relTo = (arguments.length > 1) ? arguments[1] : new Date();
			var secs = parseInt((relTo.getTime() - parsedDt) / 1000, 10);
			secs = secs + (relTo.getTimezoneOffset() * 60);
			var r = '';
			if (secs < 60) {
				r = 'a minute ago';
				r = 'um minuto atrás';
			} else if (secs < 120) {
				r = 'couple of minutes ago';
				r = 'alguns minutos atrás';
			} else if (secs < (45 * 60)) {
				r = parseInt((secs / 60), 10).toString() + ' minutes ago';
				r = parseInt((secs / 60), 10).toString() + ' minutos atrás';				
			} else if (secs < (90 * 60)) {
				r = 'an hour ago';
			} else if (secs < (24 * 60 * 60)) {
				r = '' + parseInt((secs / 3600), 10).toString() + ' hours ago';
				r = '' + parseInt((secs / 3600), 10).toString() + ' horas atrás';				
			} else if (secs < (48 * 60 * 60)) {
				r = '1 day ago';
			} else {
				r = parseInt((secs / 86400), 10).toString() + ' days ago';
				r = parseInt((secs / 86400), 10).toString() + ' dias atrás';

			}
			return r;
		}
		function animatebackground(element, fromcolor, tocolor) {
			fromcolor += fromcolor > tocolor ? -1 : 1;
			if (!jQuery.support.opacity) {
				if (fromcolor != tocolor) {
					var opStr = (Math.round(fromcolor * 25.5)).toString(16);

					element
							.css( {
								background : 'transparent',
								filter : "progid:DXImageTransform.Microsoft.gradient(startColorstr=#"
										+ opStr
										+ "FFFF00, endColorstr=#"
										+ opStr + "FFFF00)"
							});
				} else {
					element.css( {
						background : 'transparent',
						filter : "none"
					});
				}
			} else {
				element.css("backgroundColor", "rgba(255, 255, 255, "
						+ (fromcolor) / 10 + ")");
			}

			if (fromcolor != tocolor) {
				setTimeout(function() {
					animatebackground(element, fromcolor, tocolor)
				}, 200);
			}
		}
		if (settings.autoplay == 1) {
			timerInst = setInterval(function() {
				searchtwitter()
			}, settings.timer);
		}

	};
})(jQuery);