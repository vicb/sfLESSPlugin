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
    $response = $this->getResponse();

    $this->files = array();
    foreach(sfLESS::findLessFiles() as $file)
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
   * Executes SaveCss action
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
      // todo: check real path, permissions
      $file = preg_replace('/^\/less/', '/css', $request->getParameter('file'));
      $file = preg_replace('/\.less$/', '.css-ajax', $file);
      $file = sfConfig::get('sf_web_dir') . $file;
      file_put_contents($file, $request->getParameter('content'));
      $this->getResponse()->setStatusCode('200');
    }
    return $this->renderText($file);
  }

}