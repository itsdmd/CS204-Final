async function fetchFunFact() {
	const url = "https://random-quote-fact-joke-api.p.rapidapi.com/fact";
	const options = {
		method: "GET",
		headers: {
			"X-RapidAPI-Key": "c84e070f5bmshe0c2225f4b329fep19fc4fjsn8a259f4d45b4",
			"X-RapidAPI-Host": "random-quote-fact-joke-api.p.rapidapi.com",
		},
	};

	try {
		const response = await fetch(url, options);
		const result = await response.json();
		// console.log(result.fact);

		let funFactElement = document.querySelector("#fun-fact");
		funFactElement.innerHTML = result.fact;
	} catch (error) {
		console.error(error);
	}
}

fetchFunFact();
