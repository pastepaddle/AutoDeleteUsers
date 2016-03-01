<?php
/**
 *
 * @package phpBB Extension - paddle Auto Delete Users
 * @license http://opensource.org/licenses/gpl-2.0.php GNU General Public License
 * v2
 *
 */

namespace paddle\adu\migrations;

class release_0_5_0 extends \phpbb\db\migration\migration
{

	static public function depends_on()
	{
		return array('\phpbb\db\migration\data\v310\alpha2');
	}

	public function effectively_installed()
	{
		return isset($this->config['paddle_adu_delete_users_task_gc']);
	}

	public function update_data()
	{
		return array(
			array(
				'module.add',
				array(
					'acp',
					'ACP_CAT_USERS',
					array(
						'module_basename' => '\paddle\adu\acp\main_module',
						'modes' => array(
							'config'
						),
					),
				)
			),
			array(
				'config.add',
				array(
					'ADU_max_posts',
					0
				)
			),
			array(
				'config.add',
				array(
					'ADU_member_since',
					30
				)
			),
			array(
				'config.add',
				array(
					'paddle_adu_delete_users_task_gc',
					(60*60*24)
				)
			),
			array(
				'config.add',
				array(
					'ADU_auto_delete',
					0
				)
			),
			array(
				'config.add',
				array(
					'paddle_adu_delete_users_task_last_gc',
					0
				)
			),
		);
	}

}
