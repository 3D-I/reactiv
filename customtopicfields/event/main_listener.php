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
		$page_data = $event['page_data'];
		$post_data = $event['post_data'];
		$mode = $event['mode'];
		$submit = $event['submit'];
		$preview = $event['preview'];
		$load = $event['load'];
		$save = $event['save'];
		$refresh = $event['refresh'];
		$forum_id = $event['forum_id'];
		$custom_fields = array();
		global $template;
		if ($mode == 'post'
			&& !$submit && !$preview && !$load && !$save && !$refresh
			&& empty($post_data['post_text']) && empty($post_data['post_subject']))
		{
			$custom_fields = get_profile_fields();
			foreach ($custom_fields as $row)
			{
				$template->assign_block_vars('custom_fields', array('FIELD_ID' => $row['FIELD_ID'],'FIELD_NAME' => $row['FIELD_NAME'],'FIELD_TYPE' => $row['FIELD_TYPE'],));
			}
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

		$sql = 'SELECT field_id, field_name, field_type
			FROM ' . phpbb_cust_top_field;
		$result = $db->sql_query($sql);

		$custom_fields = array();
		while ($row = $db->sql_fetchrow($result))
		{
			$custom_fields[] = array ('FIELD_ID' => $row['field_id'],
									'FIELD_NAME' => $row['field_name'],
									'FIELD_TYPE' => $row['field_type'],);
		}
		$db->sql_freeresult($result);

		return $custom_fields;

	
//		$custom_fields = (!($row = $db->sql_fetchrow($result))) ? array() : $row;
//		$db->sql_freeresult($result);
//		return $custom_fields;
	}
