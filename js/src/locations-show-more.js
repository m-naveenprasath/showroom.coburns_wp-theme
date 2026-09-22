document.addEventListener("DOMContentLoaded", function () {
	var table = document.getElementById("search-location-table");
	var showMoreBtn = document.getElementById("locations-show-more");
	if (!table || !showMoreBtn) return;

	var limit = parseInt(showMoreBtn.getAttribute("data-limit"), 10) || 6;
	var items = Array.prototype.slice.call(table.querySelectorAll(".listing-item"));

	function applyLimit() {
		items.forEach(function (item, index) {
			item.classList.toggle("is-hidden-more", index >= limit);
		});
		showMoreBtn.hidden = items.length <= limit;
	}

	function showAll() {
		items.forEach(function (item) {
			item.classList.remove("is-hidden-more");
		});
		showMoreBtn.hidden = true;
	}

	showMoreBtn.addEventListener("click", showAll);

	// The map script marks the table "data-sort-active" while a location search is
	// filtering the list. Show every match during a search instead of enforcing the
	// limit, then reapply the limit once the search is reset (attribute removed).
	var observer = new MutationObserver(function () {
		if (table.hasAttribute("data-sort-active")) {
			showAll();
		} else {
			applyLimit();
		}
	});
	observer.observe(table, { attributes: true, attributeFilter: ["data-sort-active"] });

	applyLimit();
});
