<?php
/**
 *
 * This file is part of the phpBB Forum Software package.
 *
 * @copyright (c) phpBB Limited <https://www.phpbb.com>
 * @license GNU General Public License, version 2 (GPL-2.0)
 *
 * For full copyright and license information, please see
 * the docs/CREDITS.txt file.
 *
 */

namespace reactiv\customtopicfields\event;

use Symfony\Component\EventDispatcher\EventSubscriberInterface;
$phpbb_root_path = (defined('PHPBB_ROOT_PATH')) ? PHPBB_ROOT_PATH : './';
$phpEx = substr(strrchr(__FILE__, '.'), 1);
//include($phpbb_root_path . 'common.' . $phpEx);

/**
 * Event listener
 */
class main_listener implements EventSubscriberInterface
{
    static public function getSubscribedEvents()
    {
        return array(
            'core.user_setup' => 'load_language_on_setup',
			'core.posting_modify_template_vars'			=> 'core_posting_modify_template_vars',
        );
    }

    public function load_language_on_setup($event)
    {
        $lang_set_ext = $event['lang_set_ext'];
        $lang_set_ext[] = array(
            'ext_name' => 'reactiv/customtopicfields',
            'lang_set' => 'customtopicfields',
        );
        $event['lang_set_ext'] = $lang_set_ext;
    }
	
	public function core_posting_modify_template_vars($event)
	{
		global $phpbb_container, $user;
		$page_data = $event['page_data'];
		$post_data = $event['post_data'];
		$mode = $event['mode'];
		$submit = $event['submit'];
		$preview = $event['preview'];
		$load = $event['load'];
		$save = $event['save'];
		$refresh = $event['refresh'];
		$forum_id = $event['forum_id'];
		$topic_id = $event['topic_id'];
		$custom_fields = array();
		global $template;
		if ($mode == 'post'
			&& !$submit && !$preview && !$load && !$save && !$refresh
			&& empty($post_data['post_text']) && empty($post_data['post_subject']))
		{
			$custom_fields = get_profile_fields();
//			$user->get_profile_fields($user->data['user_id']);
			$cp = $phpbb_container->get('reactiv.customtopicfields.manager');
			$cp->generate_custom_fields($user->get_iso_lang_id());
			//foreach ($custom_fields as $row)
			//{
			//	$template->assign_block_vars('custom_fields', array('FIELD_ID' => $row['FIELD_ID'],'FIELD_NAME' => $row['FIELD_NAME'],'FIELD_TYPE' => $row['FIELD_TYPE'],));
			//}
			
			
			//$cp = $phpbb_container->get('reactiv.customtopicfields.manager');
			//$custom_fields = $cp->grab_custom_fields_data($topic_id);
			//print_r($custom_fields);
			//$custom_fields = (isset($custom_fields[$topic_id])) ? $cp->generate_custom_fields_template_data($custom_fields[$topic_id]) : array();
			//$custom_fields = !(isset($custom_fields[$topic_id])) ? $cp->generate_custom_fields_template_data($custom_fields) : array();
			//print_r($custom_fields);
			
		}
		$event['page_data'] = $page_data;
	}
}	
	function get_profile_fields()
	{
		global $db;

		if (isset($custom_fields))
		{
			return;
		}

		$sql = 'SELECT field_ident, field_name, field_type
			FROM ' . phpbb_cust_top_field;
		$result = $db->sql_query($sql);

		$custom_fields = array();
		while ($row = $db->sql_fetchrow($result))
		{
			$custom_fields[] = array ('FIELD_ID' => $row['field_ident'],
									'FIELD_NAME' => $row['field_name'],
									'FIELD_TYPE' => $row['field_type'],
									//$ident_ary['data']['field_type']
									
									
									);
		}
		$db->sql_freeresult($result);

		return $custom_fields;
	}
