jQuery(function ($) {
	$(".bio-card__bio-wrap").each(function () {
		var $wrap = $(this);
		var $content = $wrap.find("[data-bio-content]");
		var $toggle = $wrap.find("[data-bio-toggle]");
		var $toggleText = $toggle.find("[data-bio-toggle-text]");
		var seeMoreText = $toggleText.text();
		var seeLessText = $toggle.data("less-label") || "See less";

		if ($content[0].scrollHeight > $content[0].clientHeight + 1) {
			$toggle.removeAttr("hidden");
		}

		$toggle.on("click", function () {
			var isExpanded = $content.toggleClass("is-expanded").hasClass("is-expanded");
			$toggleText.text(isExpanded ? seeLessText : seeMoreText);
		});
	});
});
