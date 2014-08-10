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

use JFusion\Plugin\Plugin_Front;

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
class Front extends Plugin_Front
{
    /**
     * @return string
     */
    function getRegistrationURL() {
        return 'account/register.php';
    }

    /**
     * @return string
     */
    function getLostPasswordURL() {
        return 'account/forgotten_password.php';
    }

    /**
     * @return string
     */
    function getLostUsernameURL() {
        return '';
    }
}
