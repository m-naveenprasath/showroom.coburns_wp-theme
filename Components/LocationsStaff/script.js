jQuery(document).ready(function () {
	jQuery(".bio-details").on("shown.bs.collapse", function () {
		jQuery(this).parent(".accordion").addClass("active");
	});
	jQuery(".bio-details").on("hidden.bs.collapse", function () {
		jQuery(this).parent(".accordion").removeClass("active");
	});
});
