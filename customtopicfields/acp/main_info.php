<?php
/**
*
* @package phpBB Extension - Acme Demo
* @copyright (c) 2013 phpBB Group
* @license http://opensource.org/licenses/gpl-2.0.php GNU General Public License v2
*
*/

namespace reactiv\customtopicfields\acp;

class main_info
{
	function module()
	{
		return array(
			'filename'	=> '\reactiv\customtopicfields\acp\main_module',
			'title'		=> 'ACP_CUSTOMTOPIC_TITLE',
			'version'	=> '1.0.0',
			'modes'		=> array(
				'settings'	=> array('title' => 'ACP_CUSTOMTOPIC_TITLE', 'auth' => 'acl_a_forum', 'cat' => array('ACP_MANAGE_FORUMS')),
			),
		);
	}
}
