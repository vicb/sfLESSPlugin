<?php

/*
 * This file is part of the sfLESSPlugin.
 * (c) 2010 Konstantin Kudryashov <ever.zet@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

/**
 * TODO
 *
 * @package    sfLESSPlugin
 * @subpackage actions
 * @author     Victor Berchet <victor@suumit.com>
 * @version    1.0.0
 */

class BaselessCssActions extends sfActions
{
  /**
   * Executes Compile action
   *
   * @param sfRequest $request A request object
   */
  public function executeCompile(sfWebRequest $request)
  {
    $less = new sfLESS(false);
    $less->doFindAndCompile();
    $this->files = sfLESS::getCompileResults();
    $this->errors = sfLESS::getCompileErrors();
   
    $this->getResponse()->setContentType('text/plain');
    $this->setLayout(false);
  }

}