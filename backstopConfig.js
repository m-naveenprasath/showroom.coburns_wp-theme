//based on https://github.com/sturobson/SCL

var glob = require("glob");

var viewports = [
	{
		label: "xs",
		width: 320,
		height: 800,
	},
	{
		label: "sm",
		width: 576,
		height: 800,
	},
	{
		label: "md",
		width: 768,
		height: 1024,
	},
	{
		label: "lg",
		width: 992,
		height: 1024,
	},
	{
		label: "xl",
		width: 1200,
		height: 1200,
	},
	{
		label: "xxl",
		width: 1600,
		height: 1600,
	},
];

// Add visibility: hidden to selectors
var invisibleSelectors = ["iframe[src*='https://www.google.com/maps']"];

// Add display: none to selectors
var removedSelectors = [];

// Only search these selectors
var whitelistSelectors = [];

// Only search these files
var htmlFiles = glob.sync("public/patterns/**/*.rendered.html");

var scenariosArray = [];

// Loop through all *.html pages and push to scenariosArray
htmlFiles.forEach(function (file, i) {
	var filename = file;

	var label = filename.split("/").pop();
	label = label.replace(".rendered.html", "");
	label = label
		.split(/-?\d+-/)
		.filter((n) => n)
		.join(" / ");
	// .split gets rid of the ##- in the PL title structure (ex: 03-elements-10-buttons-01-primary-solid)
	// .filter gets rid of any empty array items

	scenariosArray.push({
		label: label,
		url: "/" + filename,
		hideSelectors: invisibleSelectors,
		removeSelectors: removedSelectors,
		selectors: whitelistSelectors,
		delay: 500,
		misMatchThreshold: 0.01,
	});
});

module.exports = {
	id: "coburns",
	viewports: viewports,
	scenarios: scenariosArray,
	paths: {
		bitmaps_reference: "backstop_data/bitmaps_reference",
		bitmaps_test: "backstop_data/bitmaps_test",
		casper_scripts: "backstop_data/casper_scripts",
		html_report: "backstop_data/html_report",
		ci_report: "backstop_data/ci_report",
	},
	casperFlags: [],
	engine: "puppeteer",
	engineOptions: {
		args: ["--no-sandbox"],
		headless: true,
	},
	report: ["browser", "json", "CI"],
	asyncCaptureLimit: 5,
	asyncCompareLimit: 50,
	debug: false,
	debugWindow: false,
};
