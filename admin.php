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

use JFusion\Factory;
use JFusion\Framework;

use Joomla\Language\Text;

use Psr\Log\LogLevel;

use \Exception;
use \stdClass;

/**
 * JFusion Admin Class for Elgg
 * For detailed descriptions on these functions please check Plugin_Admin
 *
 * @category   Plugins
 * @package    JFusion\Plugins
 * @subpackage elgg
 * @author     JFusion Team <webmaster@jfusion.org>
 * @copyright  2008 JFusion. All rights reserved.
 * @license    http://www.gnu.org/copyleft/gpl.html GNU/GPL
 * @link       http://www.jfusion.org
 */
class Admin extends \JFusion\Plugin\Admin
{
	/**
	 * @var $helper Helper
	 */
	var $helper;

    /**
     * @return string
     */
    function getTablename()
    {
        return 'users_entity';
    }

    /**
     * @param $path
     * @return array|bool
     */
    function loadSetup($path)
    {
        //generate the destination file
	    $myfile = $path . 'engine/settings.php';

        $config = array();
        //check if the file exists
	    $lines = $this->readFile($myfile);
        if ($lines === false) {
            Framework::raise(LogLevel::WARNING, Text::_('WIZARD_FAILURE') . ': ' . $myfile. ' ' . Text::_('WIZARD_MANUAL'), $this->getJname());
	        return false;
        } else {
            //parse the file line by line to get only the config variables
	        foreach ($lines as $line) {
		        $parts = explode('=', $line);
		        if (isset($parts[0]) && isset($parts[1])) {
			        $key = trim(preg_replace('/[^\n]*\$CONFIG->/ ', '', $parts[0]));
			        $value = trim(str_replace(array('"', '\'', ';'), '', $parts[1]));
			        $config[$key] = $value;
		        }
	        }
        }
        return $config;
    }

    /**
     * @param string $softwarePath
     *
     * @return array
     */
    function setupFromPath($softwarePath)
    {
        $config = $this->loadSetup($softwarePath);
        $params = array();
        if (!empty($config)) {
            //save the parameters into array
            $params = array();
            $params['database_host'] = $config['dbhost'];
            $params['database_name'] = $config['dbname'];
            $params['database_user'] = $config['dbuser'];
            $params['database_password'] = $config['dbpass'];
            $params['database_prefix'] = $config['dbprefix'];
            $params['database_type'] = 'mysql';
            $params['source_path'] = $softwarePath;
        }
        return $params;
    }

    /**
     * Get a list of users
     *
     * @param int $limitstart
     * @param int $limit
     *
     * @return array
     */
    function getUserList($limitstart = 0, $limit = 0)
    {
	    try {
		    //getting the connection to the db
		    $db = Factory::getDatabase($this->getJname());

		    $query = $db->getQuery(true)
			    ->select('username, email')
			    ->from('#__users_entity');

		    $db->setQuery($query, $limitstart, $limit);
		    //getting the results
		    $userlist = $db->loadObjectList();
	    } catch (Exception $e) {
		    Framework::raise(LogLevel::ERROR, $e, $this->getJname());
		    $userlist = array();
	    }
        return $userlist;
    }

    /**
     * @return int
     */
    function getUserCount()
    {
	    try {
	        //getting the connection to the db
	        $db = Factory::getDatabase($this->getJname());

		    $query = $db->getQuery(true)
			    ->select('count(*)')
			    ->from('#__users_entity');

	        $db->setQuery($query);
	        //getting the results
	        return $db->loadResult();
	    } catch (Exception $e) {
		    Framework::raise(LogLevel::ERROR, $e, $this->getJname());
		    return 0;
	    }
    }

    /**
     * @return array
     */
    function getUsergroupList()
    {
        //NOT IMPLEMENTED YET!
        $default_group = new stdClass;
        $default_group->name = 'user';
        $default_group->id = '1';
        $UsergroupList[] = $default_group;
        return $UsergroupList;
    }

    /**
     * @return array
     */
    function getDefaultUsergroup()
    {
        //Only seems to be 2 usergroups in elgg (without any acl setup): Administrator, and user.  So just return 'user'
	    $usergroups = Framework::getUserGroups($this->getJname(), true);
	    if ($usergroups !== null) {
		    $group = 'user';
	    } else {
		    $group = '';
	    }
        return $group;
    }

    /**
     * @return bool
     */
    function allowRegistration()
    {
	    $this->helper->loadEngine();

        // Get variables
        global $CONFIG;
        $result = true;
	    if (isset($CONFIG->allow_registration) && $CONFIG->allow_registration == 'false') {
		    $result = false;
	    } else if (isset($CONFIG->disable_registration) && $CONFIG->disable_registration == 'true') {
			$result = false;
        }
        return $result;
    }

    /**
     * do plugin support multi usergroups
     *
     * @return string UNKNOWN or JNO or JYES or ??
     */
    function requireFileAccess()
	{
		return 'JYES';
	}

	/**
	 * @return bool do the plugin support multi instance
	 */
	function multiInstance()
	{
		return false;
	}

	/**
	 * do plugin support multi usergroups
	 *
	 * @return bool
	 */
	function isMultiGroup()
	{
		return false;
	}
}
