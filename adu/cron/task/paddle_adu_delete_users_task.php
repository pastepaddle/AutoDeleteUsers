<?php
/**
 *
 * @package phpBB Extension - paddle Auto Delete Users
 * @license http://opensource.org/licenses/gpl-2.0.php GNU General Public License
 * v2
 *
 */

namespace paddle\adu\cron\task;

class paddle_adu_delete_users_task extends \phpbb\cron\task\base
{

    protected $config;
    protected $log;
    protected $db;
    protected $user;

    /**
     * Constructor.
     *
     * @param \phpbb\config\config $config The config
     */
    public function __construct(\phpbb\config\config $config, \phpbb\log\log $log, \phpbb\db\driver\factory $db, \phpbb\user $user)
    {
        $this->config = $config;
        $this->log = $log;
        $this->db = $db;
        $this->user = $user;
    }

    /**
     * Runs this cron task.
     *
     * @return null
     */
    public function run()
    {
        //get config
        $max_posts = $this->config['ADU_max_posts'];
        $member_since = $this->config['ADU_member_since'];

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

        $result = $this->db->sql_query($sql);

        while ($row = $this->db->sql_fetchrow($result)) {
            $delete_list[$row['user_id']] = $row['username'];
        }

        $this->db->sql_freeresult($result);

        if (sizeof($delete_list)) {
            $sql = 'DELETE FROM ' . USERS_TABLE .
                ' WHERE ' . $this->db->sql_in_set('user_id', array_keys($delete_list));
            $this->db->sql_query($sql);

            $this->log->add('admin', $this->user->data['user_id'], $this->user->data['session_ip'], 'LOG_INACTIVE_DELETE', false, array(implode(', ', $delete_list)));
        }

        $this->config->set('paddle_adu_delete_users_task_last_gc', time());
    }

    /**
     * Returns whether this cron task should run now, because enough time
     * has passed since it was last run.
     *
     * @return bool
     */
    public function should_run()
    {
        if($this->config['ADU_auto_delete']) {
            return $this->config['paddle_adu_delete_users_task_last_gc'] < time() - $this->config['paddle_adu_delete_users_task_gc'];
        }
        return false;
    }

}