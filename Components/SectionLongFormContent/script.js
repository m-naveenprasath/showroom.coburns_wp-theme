jQuery(function ($) {
	$(".section-long-form-content__content-wrap").each(function () {
		var $wrap = $(this);
		var $content = $wrap.find("[data-longform-content]");
		var $toggle = $wrap.find("[data-longform-toggle]");
		var $toggleText = $toggle.find("[data-longform-toggle-text]");
		var seeMoreText = $toggleText.text();
		var seeLessText = $toggle.data("less-label") || "See less";

		if ($content[0].scrollHeight > $content[0].clientHeight + 1) {
			$toggle.removeAttr("hidden");
		}

		$toggle.on("click", function () {
			var isExpanded = $content.toggleClass("is-expanded").hasClass("is-expanded");
			$content.css("max-height", isExpanded ? $content[0].scrollHeight + "px" : "");
			$toggle.attr("aria-expanded", isExpanded);
			$toggleText.text(isExpanded ? seeLessText : seeMoreText);
		});
	});
});
