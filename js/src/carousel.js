//@ref: https://keen-slider.io/api/#api

//For IE11
if (window.NodeList && !NodeList.prototype.forEach) {
	NodeList.prototype.forEach = Array.prototype.forEach;
}
if (window.HTMLCollection && !HTMLCollection.prototype.forEach) {
	HTMLCollection.prototype.forEach = Array.prototype.forEach;
}

function createSlider(wrapper) {
	var wrapper = document.getElementById(wrapper);
	var sliderElement = wrapper.getElementsByClassName("keen-slider")[0];
	var slider = new KeenSlider(sliderElement, {
		slidesPerView: 1,
		centered: false,
		loop: true,
		mode: "snap",
		breakpoints: {
			"(min-width: 576px)": {
				slidesPerView: 2,
			},
			"(min-width: 992px)": {
				slidesPerView: 2,
			},
			"(min-width: 1200px)": {
				slidesPerView: 3,
			},
			"(min-width: 1500px)": {
				slidesPerView: 4,
			},
		},
		created: function (instance) {
			var control_left = wrapper.getElementsByClassName("arrow--left")[0];
			if (typeof control_left != "undefined" && control_left != null) {
				control_left.addEventListener("click", function () {
					instance.prev();
				});
			}

			var control_right = wrapper.getElementsByClassName("arrow--right")[0];
			if (typeof control_right != "undefined" && control_right != null) {
				control_right.addEventListener("click", function () {
					instance.prev();
				});
			}

			var nav = wrapper.getElementsByClassName("keen-slider-nav")[0];
			if (typeof nav != "undefined" && nav != null) {
				var slides = wrapper.querySelectorAll(".keen-slider__slide");
				slides.forEach(function (t, idx) {
					var nav_item = document.createElement("button");
					nav_item.classList.add("slider-nav__item");
					nav_item.classList.add("keen-slider-nav__item");
					nav.appendChild(nav_item);
					nav_item.addEventListener("click", function () {
						instance.moveToSlide(idx);
					});
				});

				updateClasses(instance);
			}
		},
		slideChanged: function (instance) {
			updateClasses(instance);
		},
	});

	function updateClasses(instance) {
		var slide = instance.details().relativeSlide;

		var control_left = wrapper.getElementsByClassName("arrow--left")[0];
		if (typeof control_left != "undefined" && control_left != null) {
			slide === 0 ? arrowLeft.classList.add("arrow--disabled") : arrowLeft.classList.remove("arrow--disabled");
		}

		var control_right = wrapper.getElementsByClassName("arrow--right")[0];
		if (typeof control_right != "undefined" && control_right != null) {
			slide === instance.details().size - 1
				? arrowRight.classList.add("arrow--disabled")
				: arrowRight.classList.remove("arrow--disabled");
		}

		var nav_items = wrapper.querySelectorAll(".keen-slider-nav__item");
		nav_items.forEach(function (nav_item, idx) {
			idx === slide ? nav_item.classList.add("active") : nav_item.classList.remove("active");
		});
	}
}

document.addEventListener("DOMContentLoaded", function () {
	document.querySelectorAll(".keen-slider-wrapper").forEach(function (wrapper) {
		if ("id" in wrapper) {
			createSlider(wrapper.id);
		}
	});
});
