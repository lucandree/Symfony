<?php
// src/OC/PlatfromBundle/Beta/BetaHTMLAdder.php

namespace OC\PlatformBundle\Beta;

use Symfony\Component\HttpFoundation\Response;

class  BetaHTMLAdder
{
	// Méthode pour rajouter le "bêta" à une réponse
	public function addBeta(Response $response, $remaininDays)
	{
		$content = $response->getContent();

		// Insertion du code dans la page, au début de <body>
		$content = str_replace(
		  '<body>', 
		  '<body>',
		  $content
		);

		// Modification du contenu dans la réponse
		$response->setContent($content);

		return $response;
	}
}