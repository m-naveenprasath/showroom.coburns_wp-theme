jQuery(document).ready(function ($) {
	// these are now registered in the appropriate component for Showroom but may be needed for ecommerce
	if (typeof Vue === "function") {
		// new Vue({
		// 	components: { "ac-cart": AcCart },
		// }).$mount("#accart-app");
		// new Vue({
		// 	components: { featuredproducts: FeaturedProducts },
		// }).$mount("#main");
	}

	// Carousels
	$("#carouselProducts, #carouselLike, #carouselRelated").carousel({
		interval: 10000,
		touch:true,
	});



	$(".product-carousel .carousel-item").each(function () {
		var next = $(this).next();
		if (!next.length) {
			next = $(this).siblings(":first");
		}
		next.children(":first-child").clone().appendTo($(this));

		for (var i = 0; i < 2; i++) {
			next = next.next();
			if (!next.length) {
				next = $(this).siblings(":first");
			}
			next.children(":first-child").clone().appendTo($(this));
		}
	});

	$(".image-carousel .carousel-item, .rooms-inspire-container--carousel .carousel .carousel-item").each(function () {
		var next = $(this).next();
		if (!next.length) {
			next = $(this).siblings(":first");
		}
		next.children(":first-child").clone().appendTo($(this));

		for (var i = 0; i < 1; i++) {
			next = next.next();
			if (!next.length) {
				next = $(this).siblings(":first");
			}

			next.children(":first-child").clone().appendTo($(this));
		}
	});

	// Navigation
	$(".dropdown-toggle").dropdown();
	$(".btn-menu").click(function (e) {
		e.stopPropagation();
		e.preventDefault();
		document.body.classList.toggle("menu-open");
	});
	$(".return-top a").click(function (e) {
		e.stopPropagation();
		e.preventDefault();
		$("html").animate({ scrollTop: "0" }, 1000);
		return false;
	});

	// Building Mobile Nav
	var primary_nav = $("#mobile-header nav .mobile-nav-primary");
	if (primary_nav.is(":empty")) {
		$(".nav-primary > .nav > .nav-item").each(function () {
			$(this).clone().appendTo(primary_nav);
		});
	}
	var mega_nav = $("#mobile-header nav .mobile-nav-mega");
	if (mega_nav.is(":empty")) {
		$(".nav-mega > .nav > .nav-item").each(function () {
			$(this).clone().appendTo(mega_nav);
		});
	}
	var utility_nav = $("#mobile-header nav .mobile-nav-utility");
	if (utility_nav.is(":empty")) {
		$(".nav-utility > .nav > .nav-item").each(function () {
			$(this).clone().appendTo(utility_nav);
		});
	}

	//Change the ids and targets to be different for mobile.
	$("#mobile-header nav .mobile-nav-mega .nav-link").each(function () {
		$(this).each(function () {
			var datatarget = $(this).next("ul").attr("id");
			if (datatarget !== undefined) {
				var newdatatarget = "mobile_" + datatarget;
				//$(this).removeAttr("data-target");
				$(this).attr("data-target", "#" + newdatatarget);
				//$(this).removeAttr("aria-controls");
				$(this).attr("aria-controls", newdatatarget);
				$(this).next("ul").attr("id", newdatatarget);
			}
		});
	});

	$("#mobile-header nav .sub-menu").each(function () {
		//Add back buttons to mobile nav.
		var datatarget = $(this).attr("id");
		if (datatarget !== undefined) {
			var backstring =
				'<li class="nav-item nav-back"><a class="nav-link back" href="" data-toggle="collapse" data-target="#' +
				datatarget +
				'" aria-expanded="true" aria-controls="' +
				datatarget +
				'" role="button"><svg class="icon icon-arrow" width="7px" height="10px" viewBox="0 0 7 10" version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink"><polyline stroke="currentColor" stroke-width="2" fill="none" fill-rule="evenodd" stroke-linecap="round" stroke-linejoin="round" points="1 9 6 5 1 1"></polyline></svg> Back</a></li>';
			$(backstring).prependTo($(this));
		}
	});
	$(".nav-mega .questions-container").each(function () {
		var mobile_nav = $("#mobile-header nav .mobile-nav-mega");
		$(this).clone().appendTo($(mobile_nav));
	});
	$("#mobile-header nav .mobile-nav-mega .sub-menu .questions-container").each(function () {
		//Remove any extra question boxes.
		$(this).remove();
	});
	$("#mobile-header nav .mobile-nav-mega .nav-extended-left").each(function () {
		//Remove featured.
		$(this).remove();
	});
	$(".collapse, .menu-item-has-children .nav-link").collapse({ toggle: false });

	var mobilenavmega = 0;
	$(".mobile-nav-mega .menu-item-has-children .nav-link").click(function (e) {
		var target = $(this).data("target");
		var target_nav = $(target).parents(".mobile-nav-mega");

		if ($(this).hasClass("collapsed")) {
			mobilenavmega = mobilenavmega + -100;
			target_nav.css("left", mobilenavmega + "%");
			$("#mobile-header nav")
				.delay(200)
				.animate({ scrollTop: $(target).offset().top }, 400);
		}
		if ($(this).hasClass("back")) {
			mobilenavmega = mobilenavmega + 100;
			target_nav.css("left", mobilenavmega + "%");
			$("#mobile-header nav")
				.delay(200)
				.animate({ scrollTop: $(target).offset().top }, 400);
		}
	});

	//Add back button to mega nav.
	var backstring =
		'<div class="nav-extended-back"><li class="nav-item nav-back"><a class="nav-link back" href="" data-toggle="collapse" data-target="" aria-expanded="true" aria-controls="" role="button"><svg class="icon icon-arrow" width="7px" height="10px" viewBox="0 0 7 10" version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink"><polyline stroke="currentColor" stroke-width="2" fill="none" fill-rule="evenodd" stroke-linecap="round" stroke-linejoin="round" points="1 9 6 5 1 1"></polyline></svg> Back</a></li></div>';
	$(backstring).appendTo($(".nav-mega .nav-extended-left-inner"));
	var navmega = 0;
	$(
		".nav-mega .menu-item-has-extended-nav .sub-menu .menu-item-has-children .nav-link,.nav-mega .menu-item-has-extended-nav .sub-menu .back"
	).click(function (e) {
		var target = $(this).data("target");
		if ($(this).hasClass("collapsed")) {
			navmega = navmega + -100;
			$(".nav-mega .nav-extended-content-left-inner").css("left", navmega + "%");
			$(".nav-mega .nav-extended-left-inner").css("left", navmega + "%");
			$(".nav-mega .nav-extended-left-inner .nav-extended-back .nav-link.back").attr("data-target", target);
			$(".nav-mega .nav-extended-left-inner .nav-extended-back .nav-link.back").attr("aria-controls", target);
		}
		if ($(this).hasClass("back")) {
			navmega = navmega + 100;
			$(".nav-mega .nav-extended-content-left-inner").css("left", navmega + "%");
			$(".nav-mega .nav-extended-left-inner").css("left", navmega + "%");
		}
	});

	//Needed for eCommerce only.
	//Customer Pickup
	var shipping_method = document.getElementById("shipping_method");
	if (shipping_method) {
		shipping_method.onchange = function () {
			var customer_pickup = document.getElementById("customer_pickup");
			if (customer_pickup) {
				if (shipping_method.value == "customer_pickup") {
					customer_pickup.style.display = "block";
				} else {
					customer_pickup.style.display = "none";
				}
			}
		};
	}

	$(".menu-item-has-extended-nav .nav-link-extended").click(function (e) {
		e.preventDefault();
	});
	$(".menu-item-has-extended-nav .nav-link-extended").hover(function (e) {
		$(".menu-item-has-extended-nav .nav-link-extended,.menu-item-has-extended-nav .nav-extended-content").each(
			function () {
				this.classList.remove("active");
			}
		);
		var extended_content = this.getAttribute("href");
		extended_content = extended_content.replace("#", "");
		extended_content = document.getElementById(extended_content);
		this.classList.add("active");
		if (extended_content) {
			extended_content.classList.add("active");
		}
	});

	//Discount
	var discountsettings = document.querySelectorAll(".discount-settings");
	$(".btn-discount").click(function (e) {
		e.stopPropagation();
		e.preventDefault();
		for (var i = 0; i < discountsettings.length; i++) {
			discountsettings[i].classList.toggle("active");
		}
	});

	//Filter/Sort Mobile buttons
	var filtersettings = document.querySelectorAll(".filter-settings");
	var sortsettings = document.querySelectorAll(".sort-settings");
	$(".btn-filter").click(function (e) {
		e.stopPropagation();
		e.preventDefault();
		for (var i = 0; i < filtersettings.length; i++) {
			filtersettings[i].classList.toggle("active");
		}
	});
	$(".btn-sort").click(function (e) {
		e.stopPropagation();
		e.preventDefault();
		for (var i = 0; i < sortsettings.length; i++) {
			sortsettings[i].classList.toggle("active");
		}
	});

	//Filter/Sort
	$(".sort-settings a,.sort-settings label").click(function (e) {
		var sort_a = document.querySelectorAll(".sort-settings a");
		var sort_input = document.querySelectorAll(".sort-settings input");
		var selected = this.href;
		for (var i = 0; i < sort_a.length; i++) {
			if (sort_a[i].href == selected) {
				sort_a[i].classList.add("active");
			} else {
				sort_a[i].classList.remove("active");
			}
		}
		for (var i = 0; i < sort_input.length; i++) {
			if (sort_input[i].value == selected) {
				sort_input[i].checked = true;
			} else {
				sort_input[i].checked = false;
			}
		}
		var btnsort = document.querySelectorAll(".btn-sort");
		var sortcontent = this.innerHTML;
		for (var i = 0; i < btnsort.length; i++) {
			btnsort[i].querySelector("span").innerHTML = sortcontent;
		}
		for (var i = 0; i < sortsettings.length; i++) {
			sortsettings[i].classList.remove("active");
		}
	});

	$(".sort-brand a").click(function (e) {
		e.stopPropagation();
		e.preventDefault();
		var selected = this.hash.substr(1);
		var brands = document.querySelectorAll(".brand-filter--content-row");
		for (var i = 0; i < brands.length; i++) {
			if (brands[i].id == "brand-" + selected) {
				brands[i].classList.add("active");
			} else {
				brands[i].classList.remove("active");
			}
		}
		return false;
	});

	//Brands Category Listing
	$("#categories-search #categories").on("change", function () {
		var selected = $(this).val();
		$(".listing-table tbody tr").hide();
		$(".listing-table tbody tr:contains('" + selected + "')").show();
	});
	
	//Blog Teaser on Homepage
	$( ".home .hero--image img" ).after( $( ".blog-feature" ) );
});

// Find Your Style mega menu (desktop). Kept in its own ready handler so an error
// elsewhere in this file (or from a plugin) can't stop it from binding.
jQuery(function ($) {
	// Find Your Style mega menu (desktop)
	$(".mega-fys").each(function () {
		var $mega = $(this);
		var $item = $mega.closest(".menu-item-has-mega");
		var $tabs = $mega.find(".mega-fys__tab");

		function selectTab($tab) {
			$tabs.removeClass("is-active").attr({ "aria-selected": "false", tabindex: "-1" });
			$tab.addClass("is-active").attr({ "aria-selected": "true", tabindex: "0" });
			$mega.find(".mega-fys__panel").attr("hidden", true);
			$("#" + $tab.attr("aria-controls")).removeAttr("hidden");
		}

		$tabs.on("click", function () {
			selectTab($(this));
		});
		$tabs.on("keydown", function (e) {
			var step = e.key === "ArrowRight" ? 1 : e.key === "ArrowLeft" ? -1 : 0;
			if (!step) {
				return;
			}
			e.preventDefault();
			var $next = $tabs.eq(($tabs.index(this) + step + $tabs.length) % $tabs.length);
			selectTab($next);
			$next.trigger("focus");
		});

		// Hovering or focusing a style/brand name swaps the preview beside it
		$mega.on("mouseenter focus", "[data-mega-preview]", function () {
			var $link = $(this);
			var $panel = $link.closest(".mega-fys__panel");
			$panel.find("[data-mega-preview]").removeClass("is-active");
			$link.addClass("is-active");
			$panel.find("[data-mega-preview-panel]").attr("hidden", true);
			$panel.find('[data-mega-preview-panel="' + $link.data("mega-preview") + '"]').removeAttr("hidden");
		});

		// Open/close on click of the top-level link
		var $toggle = $item.children(".nav-link");
		$toggle.attr({ "aria-controls": $mega.attr("id"), "aria-expanded": "false" });

		// Stretch the dimmed backdrop from the panel's bottom to the end of the page
		function sizeBackdrop() {
			if (!$item.hasClass("is-open")) {
				return;
			}
			// Measure without the backdrop itself so it never makes the page longer
			$mega[0].style.removeProperty("--mega-fys-backdrop");
			var panelBottom = $mega[0].getBoundingClientRect().bottom + window.pageYOffset;
			var pageBottom = Math.max(document.documentElement.scrollHeight, document.body.scrollHeight);
			$mega[0].style.setProperty("--mega-fys-backdrop", Math.max(pageBottom - panelBottom, 0) + "px");
		}

		function setOpen(open) {
			$item.toggleClass("is-open", open);
			$toggle.attr("aria-expanded", open ? "true" : "false");
			sizeBackdrop();
		}
		// Lazy-loaded content can grow the page, so re-measure (at most once per frame)
		var sizeQueued = false;
		$(window).on("resize scroll load", function () {
			if (sizeQueued || !$item.hasClass("is-open")) {
				return;
			}
			sizeQueued = true;
			window.requestAnimationFrame(function () {
				sizeQueued = false;
				sizeBackdrop();
			});
		});

		// Capture phase on document runs before Bootstrap's collapse toggle and any plugin
		// click handlers (e.g. Thrive on /style-finder/), so nothing else can navigate away
		document.addEventListener(
			"click",
			function (e) {
				if (!$toggle[0] || !$toggle[0].contains(e.target)) {
					return;
				}
				e.preventDefault();
				e.stopImmediatePropagation();
				setOpen(!$item.hasClass("is-open"));
			},
			true
		);

		// Close on click outside, on the dimmed backdrop below the panel, or on Escape
		$(document).on("click", function (e) {
			if ($item.hasClass("is-open") && !$.contains($item[0], e.target)) {
				setOpen(false);
			}
		});
		$mega.on("click", function (e) {
			if (e.target === this && e.offsetY > this.offsetHeight) {
				setOpen(false);
			}
		});
		$(document).on("keydown", function (e) {
			if (e.key === "Escape" && $item.hasClass("is-open")) {
				setOpen(false);
				$toggle.trigger("focus");
			}
		});
	});
});
