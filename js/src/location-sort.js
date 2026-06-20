// The map script adds the attribute "data-sortable" to #search-location-table when a marker refresh is complete.
// This observes that element and updates the sort whenever it detects the addition of that attribute
var config = {
	attributes: true,
};

var target = document.getElementById("search-location-table");
var sort;

function callback(mutationRecord, observer) {
	mutationRecord.forEach(function (mutation, i) {
		if (!mutation.target.hasAttribute("data-sort-init")) {
			sort = new Tablesort(mutation.target);
			mutation.target.setAttribute("data-sort-init", "");
		} else if (mutation.target.hasAttribute("data-sort-active")) {
			sort.refresh();
		}
	});
}

if (typeof target !== undefined && target !== null) {
	var observer = new MutationObserver(callback);
	observer.observe(target, config);
}
