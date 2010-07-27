<?php

/*
 * This file is part of the sfLESSPlugin.
 * (c) 2010 Konstantin Kudryashov <ever.zet@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

/**
 * sfWebDebugPanelLESSjs implements LESS web debug panel when using client side compilation.
 *
 * @package    sfLESSPlugin
 * @subpackage debug
 * @author     Victor Berchet <victor@suumit.com>
 * @version    1.0.0
 */
class sfWebDebugPanelLESSjs extends sfWebDebugPanel
{
  /**
   * Listens to LoadDebugWebPanel event & adds this panel to the Web Debug toolbar
   *
   * @param   sfEvent $event
   */
  public static function listenToLoadDebugWebPanelEvent(sfEvent $event)
  {
    $event->getSubject()->setPanel(
      'documentation',
      new self($event->getSubject())
    );
  }

  /**
   * @see sfWebDebugPanel
   */
  public function getTitle()
  {
    return '<img src="/sfLESSPlugin/images/css_go.png" alt="LESS helper" height="16" width="16" /> less';
  }

  /**
   * @see sfWebDebugPanel
   */
  public function getPanelTitle()
  {
    return 'LESS Stylesheets';
  }

  /**
   * @see sfWebDebugPanel
   */
  public function getPanelContent()
  {
    $this->setStatus(sfLogger::INFO);
    $url = sfContext::getInstance()->getRouting()->generate('less_css_compile', array(), true);
    return "<a href='$url'>Compile all LESS stylesheets</href><br/>";
  }
}
