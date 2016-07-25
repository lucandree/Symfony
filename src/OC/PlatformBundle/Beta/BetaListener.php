<?php
// src/OC/PlatformBundle/Beta/BetaListener.php

namespace OC\PlatformBundle\Beta;


use Symfony\Component\HttpKernel\Event\FilterResponseEvent;

class  BetaListener
{
	/*// Notre processeur
	protected $betaHTML;

	// La date de fin de la version bêta :
	// - Avant cette date, on affichera un compte à rebours (J-3 par exemple)
	// - Après cette date, on n'affichera plus le "bêta"
	protected $endDate;*/

	public function __construct(BetaHTMLAdder $betaHTML, $endDate)
	{
		$this->betaHTML = $betaHTML;
		$this->endDate  = new \Datetime($endDate);
	}

	public function processBeta(FilterResponseEvent $event)
	{
		// On teste si la méthode est un FilterResponseEvent
		if (!$event->isMasterRequest()) {
			// Si la date est dépassé, in ne fait rien
			return;
		}

		$remainingDays = $this->endDate->diff(new \Datetime())->days;

		// Si la date est dépassé, on ne fait rien
		if ($remainingDays <= 0) {
			return;
		}

		// On récupère la réponse que le gestionnaire a inséré dans l'évènement
		$response = $this->betaHTML->addBeta($event->getResponse(), $remainingDays);

		// Ici on modifie comme on veut la réponse...

		// Puis on insère la réponse modofié dans l'évènement
		$event->setResponse($response);

		// On stoppe la propagation de l'évènement en cours
		$event->stopPropagation();
	}

	public function ignoreBeta()
	{
		$remainingDays = $this->endDate->diff(new \Datetime())->days;

		if ($remainingDays <= 0) {
			// Si la date est dépassé, in ne fait rien
			return;
		}
	}
}