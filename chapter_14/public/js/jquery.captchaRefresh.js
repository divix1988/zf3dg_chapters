jQuery.fn.captchaRefresh = function (conf) {
	var config = jQuery.extend({
		src:	'modules/helpers/captcha.php', 
		title:	'Click to refresh captcha'
	}, conf);

	return this.each(function (x) {
		jQuery('img[src^="' + config.src + '"]', this).attr('title', config.title);

		jQuery(this).click(function (event) {
			var clicked = jQuery(event.target);

			if (clicked.attr('src') && clicked.attr('src').indexOf(config.src) === 0) {
				var now			= new Date();
				var separator	= config.src.indexOf('?') == -1 ? '?' : '&';

				clicked.attr('src', config.src + separator + now.getTime());
			}
		});
	});
};
