<?php
/**
*
* @package phpBB Extension - Acme Demo
* @copyright (c) 2013 phpBB Group
* @license http://opensource.org/licenses/gpl-2.0.php GNU General Public License v2
*
*/

namespace reactiv\customtopicfields\migrations;

class release_1_0_0 extends \phpbb\db\migration\migration
{
//	public function effectively_installed()
//	{
//		return $this->db_tools->sql_column_exists($this->table_prefix . 'users', 'user_acme');
//	}

//	static public function depends_on()
//	{
//		return array('\acme\demo\migrations\release_1_0_0');
//	}

	public function update_schema()
	{
		return array(
			'add_tables'		=> array(
				$this->table_prefix . 'cust_top_field'	=> array(
				'COLUMNS'	=> array(
					'field_id'	=> array('UINT', NULL, 'auto_increment'),
					'field_name'	=> array('VCHAR_UNI', ''),
					'field_type'	=> array('VCHAR:200', 0),
					'field_ident'	=> array('VCHAR:20', ''),
					'field_length'	=> array('VCHAR:20', ''),
					'field_minlen'	=> array('VCHAR', ''),
					'field_maxlen'	=> array('VCHAR', ''),
					'field_novalue'	=> array('VCHAR_UNI', ''),
					'field_default_value'	=> array('VCHAR_UNI', ''),
					'field_validation'	=> array('VCHAR_UNI:20', ''),
					'field_required'	=> array('BOOL', 0),
					'field_show_on_post'	=> array('BOOL', 0),
					'field_hide'	=> array('BOOL', 0),
					'field_no_view'	=> array('BOOL', 0),
					'field_active'	=> array('BOOL', 0),
					'field_order'	=> array('UINT', 0),
				),
				'PRIMARY_KEY'	=> 'field_id',
				'KEYS'	=> array(
					'fld_type'	=> array('INDEX', 'field_type'),
					'fld_ordr'	=> array('INDEX', 'field_order'),
				),
				),

				$this->table_prefix . 'cust_top_field_data'	=> array(
					'COLUMNS'	=> array(
						'topic_id'	=> array('UINT', 0),
					),
					'PRIMARY_KEY'	=> 'topic_id',
				),

				$this->table_prefix . 'cust_top_field_lang'	=> array(
					'COLUMNS'	=> array(
						'field_id'	=> array('UINT', 0),
						'lang_id'	=> array('UINT', 0),
						'option_id'	=> array('UINT', 0),
						'field_type'	=> array('VCHAR:100', 0),
						'lang_value'	=> array('VCHAR_UNI', ''),
					),
					'PRIMARY_KEY'	=> array('field_id', 'lang_id', 'option_id'),
				),

				$this->table_prefix . 'cust_top_lang'	=> array(
					'COLUMNS'	=> array(
						'field_id'	=> array('UINT', 0),
						'lang_id'	=> array('UINT', 0),
						'lang_name'	=> array('VCHAR_UNI', ''),
						'lang_explain'	=> array('TEXT_UNI', ''),
						'lang_default_value'	=> array('VCHAR_UNI', ''),
					),
					'PRIMARY_KEY'	=> array('field_id', 'lang_id'),
				),
			),
		);
	}

	public function revert_schema()
	{
		return array(
			'drop_tables'    => array(
				$this->table_prefix . 'cust_top_field',
				$this->table_prefix . 'cust_top_field_data',
				$this->table_prefix . 'cust_top_field_lang',
				$this->table_prefix . 'cust_top_lang',
			),
		);
	}
	
	public function update_data()
	{
		return array(
			array('module.add', array(
            'acp',
            'ACP_CAT_FORUMS',
            'ACP_CUSTOMTOPIC_TITLE'
			)),
			array('module.add', array(
				'acp',
				'ACP_CUSTOMTOPIC_TITLE',
				array(
					'module_basename'	=> '\reactiv\customtopicfields\acp\main_module',
					'auth'				=> 'acl_a_forum',
					'modes'				=> array('settings'),
				),
			)),
		);
	}

	public function revert_data()
	{
		return array(
			array('module.remove', array(
				'acp',
				'ACP_MANAGE_FORUMS',
				array(
					'module_basename'	=> '\reactiv\customtopicfields\acp\main_module',
				),
			)),
		);
	}
}

