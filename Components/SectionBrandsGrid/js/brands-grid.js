document.addEventListener("DOMContentLoaded", function () {
	var grid = document.getElementById("sbg-grid");
	if (!grid) return;

	var select = document.getElementById("sbg-category-filter");
	var activeWrap = document.getElementById("sbg-filter-active");
	var countEl = document.getElementById("sbg-filter-count");
	var loadMoreWrap = document.getElementById("sbg-load-more-wrap");
	var loadMoreBtn = document.getElementById("sbg-load-more");
	var cards = Array.prototype.slice.call(grid.querySelectorAll(".sbg-grid--card"));
	var perPage = parseInt((loadMoreBtn && loadMoreBtn.getAttribute("data-per-page")) || "12", 10) || 12;
	var visibleCount = perPage;
	var currentCategory = "";

	function matchesCategory(card, category) {
		var cats = (card.getAttribute("data-categories") || "").split(",");
		return !category || cats.indexOf(category) !== -1;
	}

	function render() {
		var matched = cards.filter(function (card) {
			return matchesCategory(card, currentCategory);
		});

		var shown = 0;
		cards.forEach(function (card) {
			var isMatch = matchesCategory(card, currentCategory);
			var isWithinPage = isMatch && shown < visibleCount;
			if (isMatch) shown++;
			card.classList.toggle("is-hidden", !isWithinPage);
		});

		if (countEl) countEl.textContent = matched.length;

		if (loadMoreWrap) {
			loadMoreWrap.classList.toggle("is-hidden", visibleCount >= matched.length);
		}
	}

	function renderChip(category, label) {
		if (!activeWrap) return;
		activeWrap.innerHTML = "";
		if (!category) return;

		var chip = document.createElement("span");
		chip.className = "sbg-filter-bar--chip";

		var text = document.createElement("span");
		text.textContent = label;
		chip.appendChild(text);

		var button = document.createElement("button");
		button.type = "button";
		button.setAttribute("aria-label", "Remove filter");
		button.textContent = "×";
		button.addEventListener("click", function () {
			select.value = "";
			select.dispatchEvent(new Event("change"));
		});
		chip.appendChild(button);

		activeWrap.appendChild(chip);
	}

	if (select) {
		select.addEventListener("change", function () {
			currentCategory = this.value;
			visibleCount = perPage;
			renderChip(currentCategory, this.options[this.selectedIndex].text);
			render();
		});
	}

	if (loadMoreBtn) {
		loadMoreBtn.addEventListener("click", function () {
			visibleCount += perPage;
			render();
		});
	}

	render();
});
