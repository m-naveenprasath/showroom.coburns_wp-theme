const fetch = require("node-fetch");

const { NETLIFY_API_ACCESS_TOKEN } = process.env;
const NETLIFY_SITE_ID = "bf4ca933-2b8a-4582-a746-a7cc5078b796";

const NETLIFY_API_ENDPOINT = "https://api.netlify.com/api/v1/sites/" + NETLIFY_SITE_ID + "/deploys";

exports.handler = async (event) => {
	const response = await fetch(NETLIFY_API_ENDPOINT, {
		method: "GET",
		headers: {
			Authorization: "Bearer " + NETLIFY_API_ACCESS_TOKEN,
		},
	})
		.then((response) => response.json())
		.catch((error) => console.error(error));

	return {
		statusCode: 200,
		body: response.data,
	};
};
