<?php
/**
 *
 * @package phpBB Extension - paddle Auto Delete Users
 * @license http://opensource.org/licenses/gpl-2.0.php GNU General Public License
 * v2
 *
 */

namespace paddle\adu\acp;

class main_info
{
	function module()
	{
		return array(
			'filename' => '\paddle\adu\acp\main_module',
			'title' => 'ACP_ADU_PAGETITLE',
			'version' => '0.6.0',
			'modes' => array(
				'config' => array(
					'title' => 'ACP_ADU_CONFIG',
					'auth' => 'ext_paddle/adu && acl_a_board',
					'cat' => array('ACP_CAT_USERS')
				),
			),
		);
	}

}
