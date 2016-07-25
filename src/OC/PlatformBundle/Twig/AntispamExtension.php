<?php 
// src/OC/PlatformBundle/Twig/AntispamExtension.php

namespace OC\PlatformBundle\Antispam\OCAntispam;

use OC\PlatformBundle\Antispam\OCAntispam;

class AntispamExtension extends \Twig_Extension
{
  public function getFunctions()
  {
  	return array(
  		new \Twig_SimpleFunction('checkIfSpam', array($this, 'checkIfArgumentIsSpam')),
  	);
  }

  public function getName()
  {
  	return 'OCAntispam';
  }
}