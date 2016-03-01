<?php
/**
 *
 * @package phpBB Extension - paddle Auto Delete Users
 * @license http://opensource.org/licenses/gpl-2.0.php GNU General Public License
 * v2
 *
 */

namespace paddle\adu\acp;

if (!defined('IN_PHPBB')) {
    exit;
}

class main_module
{
    var $p_master;

    function main_module(&$p_master)
    {
        $this->p_master = &$p_master;
    }

    function main($id, $mode)
    {
        $this->configure();
        return;
    }

    //  For the "configure" mode of this module
    function configure()
    {
        global $db, $user, $log, $template, $config, $request, $phpbb_container;
        global $phpbb_admin_path, $phpEx;

        $error_message = "";
        $debug_message = "";

        //get settings from config table
        $check_schedule = (int)$config['paddle_adu_delete_users_task_gc'];
        $max_posts = (int)$config['ADU_max_posts'];
        $member_since = (int)$config['ADU_member_since'];
        $autodelete = (bool)$config['ADU_auto_delete'];


        //do we update the config, update the config and delete users, or just preview the users.
        $is_update = $request->is_set_post('update');
        $is_delete = $request->is_set_post('delete');
        $is_preview = $request->is_set_post('preview');

        $log = $phpbb_container->get('log');

        $delete_list = array();

        if ($is_preview || $is_delete || $is_update) {
            $max_posts = $request->variable('max_userposts', (int)$max_posts);
            $member_since = $request->variable('member_since', (int)$member_since);
            $check_schedule_post = $request->variable('check_schedule', (int)$check_schedule);

            if($check_schedule_post != $check_schedule) {
                $check_schedule = $check_schedule_post * (60*60*24);
            }

            $autodelete = $request->variable('autodelete', 'off') == 'on' ? true : false;
        }

        //Select all users which follows the preconditions $max_posts and $member_since.
        //But do not select Bots or the Anonymous user.
        $sql = 'SELECT u.user_id, u.username, u.user_regdate, u.user_lastvisit, u.user_posts ' .
            'FROM ' . USERS_TABLE . ' AS u ' .
            'LEFT JOIN ' . BOTS_TABLE . ' AS b ' .
            'ON u.user_id = b.user_id ' .
            'WHERE b.user_id IS NULL ' .
            'AND u.user_id > 1 ' .
            'AND u.user_posts <= ' . $max_posts . ' ' .
            'AND u.user_regdate <= ' . (time() - ($member_since * (24 * 60 * 60)));

        $result = $db->sql_query($sql);

        while ($row = $db->sql_fetchrow($result)) {
            $template->assign_block_vars('users', array(
                'USER_ID' => $row['user_id'],
                'USER_NAME' => $row['username'],
                'REG_ON' => $user->format_date($row['user_regdate']),
                'REG_SINCE' => round((time() - $row['user_regdate']) / (60 * 60 * 24)) . '
                                ' . $user->lang['DAYS'],
                'POSTS' => $row['user_posts'],
                'LAST_LOGIN' => $row['user_lastvisit'] != 0 ? $user->format_date($row['user_lastvisit']) : $user->lang['NEVER'],
            ));

            $delete_list[$row['user_id']] = $row['username'];
        }

        $db->sql_freeresult($result);


        $max_posts = $request->variable('max_userposts', (int)$max_posts);
        $member_since = $request->variable('member_since', (int)$member_since);
        $check_schedule_post = $request->variable('check_schedule', (int)$check_schedule);

        if($check_schedule_post != $check_schedule) {
            $check_schedule = $check_schedule_post * (60*60*24);
        }

        $autodelete = $request->variable('autodelete', 'off') == 'on' ? true : false;


        if ($is_update || $is_delete) {
            $backlink = append_sid ( "{$phpbb_admin_path}index.$phpEx", "i=-paddle-adu-acp-main_module" );
            $backlink_html =  '<br /><br /><p><a href="' . $backlink . '">'.$user->lang['RETURN'].'</a></p>';
            // check mode
            if (confirm_box(true)) {
                $config->set('ADU_max_posts', $max_posts);
                $config->set('ADU_member_since', $member_since);
                $config->set('paddle_adu_delete_users_task_gc', $check_schedule);
                $config->set('ADU_auto_delete', (int)$autodelete);

                //delete the users instantly
                if ($is_delete && sizeof($delete_list)) {
                    $sql = 'DELETE FROM ' . USERS_TABLE .
                        ' WHERE ' . $db->sql_in_set('user_id', array_keys($delete_list));
                    $db->sql_query($sql);
                    $log->add('admin', $user->data['user_id'], $user->data['session_ip'], 'LOG_INACTIVE_DELETE', false, array(implode(', ', $delete_list)));
                    trigger_error($user->lang['DELETE_SUCCESS'] . $backlink_html , E_USER_NOTICE);
                } else {
                    trigger_error($user->lang['UPDATE_SUCCESS'] . $backlink_html , E_USER_NOTICE);
                }
                redirect($backlink);
            } else {
                $hidden_fields = array(
                    'max_userposts' => $max_posts,
                    'member_since' => $member_since,
                    'check_shedule' => $check_schedule_post,
                    'autodelete' => $autodelete ? 'on' : 'off',
                );
                if($is_delete) {
                    $hidden_fields['delete'] = 'delete';
                }
                if($is_update) {
                    $hidden_fields['update'] = 'update';
                }
                $s_hidden_fields = build_hidden_fields($hidden_fields);

                //display mode
                if($is_delete && sizeof($delete_list)) {
                    confirm_box(false, $user->lang['CONFIRM_DELETE'] . join(',', $delete_list) , $s_hidden_fields);
                } else {
                    confirm_box(false, $user->lang['CONFIRM_UPDATE'] , $s_hidden_fields);
                }
                redirect($backlink);
            }
        }

        $template->assign_vars(array(
            'ERROR_MESSAGE' => "$error_message",
            'DEBUG_MESSAGE' => "$debug_message",
            'CHECK_SCHEDULE' => ($check_schedule / (60*60*24)),
            'MAX_POSTS' => $max_posts,
            'MEMBER_SINCE' => $member_since,
            'AUTODELETE' => $autodelete ? 'checked="checked"' : '',
        ));

        //  Specify the page template name
        $this->tpl_name = 'adu_config';
        $this->page_title = $user->lang['ACP_ADU_PAGETITLE'];
    }

}
