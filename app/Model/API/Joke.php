<?php

declare(strict_types=1);

namespace App\Model\API;

use Nette\SmartObject;

class Joke
{
	use SmartObject;

	public function __construct(
		private string $apiKey//v services.neon sa vklada
	) {
	}

	public function getJoke(string $lang)
	{
		bdump($this->apiKey,'testApiKey');
		$skPath = "https://v2.jokeapi.dev/joke/Any?lang=cs&type=single";
		$enPath = "https://v2.jokeapi.dev/joke/Programming?type=single";
		$path = $lang == 'sk' ? $skPath : $enPath;
		$joke = json_decode(file_get_contents($path))->joke;
		return $joke;
	}
}