<?php namespace JFusion\Plugins\elgg;
/**
 * @category   Plugins
 * @package    JFusion\Plugins
 * @subpackage elgg
 * @author     JFusion Team <webmaster@jfusion.org>
 * @copyright  2008 JFusion. All rights reserved.
 * @license    http://www.gnu.org/copyleft/gpl.html GNU/GPL
 * @link       http://www.jfusion.org
 */
use JFusion\Plugin\Plugin;

/**
 * JFusion Front Class for Elgg
 * For detailed descriptions on these functions please check Plugin_Front
 *
 * @category   Plugins
 * @package    JFusion\Plugins
 * @subpackage elgg
 * @author     JFusion Team <webmaster@jfusion.org>
 * @copyright  2008 JFusion. All rights reserved.
 * @license    http://www.gnu.org/copyleft/gpl.html GNU/GPL
 * @link       http://www.jfusion.org
 */
class Helper extends Plugin
{
    function loadEngine() {
	    if (defined('externalpage')) {
		    define('externalpage', true);
	    }
	    require_once $this->params->get('source_path') . 'engine/start.php';
    }
}
