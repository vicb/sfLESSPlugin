<?php

/*
 * This file is part of the sfLESSPlugin.
 * (c) 2010 Konstantin Kudryashov <ever.zet@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

/**
 * Base actions for the lessCss module
 *
 * @package    sfLESSPlugin
 * @subpackage actions
 * @author     Victor Berchet <victor@suumit.com>
 * @version    1.0.0
 */

class BaselessCssActions extends sfActions
{
  public function preExecute()
  {
    // Do not allow execution in production environment even if the module is manually enabled
    $this->forward404Unless(sfConfig::get('sf_web_debug', true));
    $this->less = new sfLESS();
  }

  /**
   * Generate the page that trigger less files compilation
   *
   * @param sfRequest $request A request object
   */
  public function executeCompile(sfWebRequest $request)
  {
    $response = $this->getResponse();

    $this->files = array();
    foreach($this->less->findLessFiles() as $file)
    {
      $this->files[] = str_replace(sfConfig::get('sf_web_dir'), '', $file);
    }

    $form = new BaseForm();
    if ($form->isCSRFProtected())
    {
      $this->csrfName = $form->getCSRFFieldName();
      $this->csrfToken = $form->getCSRFToken();
    }
    else
    {
      $this->csrfName = "nocsrf";
      $this->csrfToken = "1";
    }

    sfConfig::set('sf_web_debug', false);
    $this->setLayout(false);
  }

  /**
   * Save the css content to a file
   *
   * @param sfRequest $request A request object
   */
  public function executeSaveCss(sfWebRequest $request)
  {
    $this->forward404Unless($request->isXmlHttpRequest());
    $request->checkCSRFProtection();
    $this->getResponse()->setStatusCode('404');
    if ($request->hasParameter('file') && $request->hasParameter('content'))
    {
      $less = sfConfig::get('sf_web_dir') . $request->getParameter('file');
      if (file_exists($less))
      {
        $css = $this->less->getCssPathOfLess($less);
        sfLESSUtils::createFolderIfNeeded($css);
        $this->less->writeCssFile($css, $request->getParameter('content'));
        $this->getResponse()->setStatusCode('200');
      }
    }
    return $this->renderText($css);
  }

}