<?php
/**
 *
 * @package phpBB Extension - paddle Auto Delete Users
 * @license http://opensource.org/licenses/gpl-2.0.php GNU General Public License
 * v2
 *
 */

/**
 * DO NOT CHANGE
 */
if (!defined('IN_PHPBB')) {
    exit;
}

if (empty($lang) || !is_array($lang)) {
    $lang = array();
}

// DEVELOPERS PLEASE NOTE
//
// All language files should use UTF-8 as their encoding and the files must not contain a BOM.
//
// Placeholders can now contain order information, e.g. instead of
// 'Page %s of %s' you can (and should) write 'Page %1$s of %2$s', this allows
// translators to re-order the output of data while ensuring it remains correct
//
// You do not need this where single placeholders are used, e.g. 'Message %d' is fine
// equally where a string contains only two placeholders which are used to wrap text
// in a url you again do not need to specify an order e.g., 'Click %sHERE%s' is fine

$lang = array_merge($lang, array(
    'ACP_ADU_PAGETITLE'     => 'Auto Delete Users',
    'ACP_ADU_LIST'          => 'list all inactive users',
    'ACP_ADU_CONFIG'        => 'Auto delete users',
    'ACP_ADU_EXPLAIN'       => 'On this page, you can create a corn job, for deleting user with certain properties. Before submit data, you should check if you selecting the right users by clicking "Preview"',
    'USERS_AUTO_DELETE'     => 'Configuration',

    'MAX_USERPOSTS'         => 'Maximal posts',
    'MAX_USERPOSTS_EXPLAIN' => 'The maximal number of posts the user can have, to be deleted automatically',
    'MIN_MEMBER_SINCE'      => 'Member since',
    'MIN_MEMBER_SINCE_EXPLAIN'  => 'Number of days, the user have to be member to be deleted automatically',
    'CHECK_SCHEDULE'        => 'Cron schedule',
    'CHECK_SCHEDULE_EXPLAIN'    => 'How often do you want to delete users',
    'AUTODELETE'            => 'Auto delete users',
    'AUTODELETE_EXPLAIN'    => '(de)activate the automated user deletion',

    'SUBMIT_AND_DELETE'     => 'Submit data and delete users',
    'SUBMIT_ONLY'           => 'Submit data only',

    'ACP_ADU_TABLE_EXPLAIN' => 'The users in the table below, will be deleted with the next run of the cron task, or by clicking "Submit data and delete users"',
    'ADU_USER_ID'           => '#',
    'ADU_USER_NAME'         => 'User',
    'ADU_USER_REG_ON'       => 'Registered on',
    'ADU_USER_REG_SINCE'    => 'Registered since',
    'ADU_USER_LAST_LOGIN'   => 'Last login',
    'ADU_USER_POSTS'        => 'Posts',
    'ADU_USER_MARK'         => 'Mark',
    'ADU_NO_USER'           => 'No inactive users',
    'NEVER'                 => 'Not yet',
    'DELETE'                => 'delete',
    'ACTIVATE'              => 'activate',
    'ERROR_NO_USER'         => 'No user selected',
    'ACP_ADU_ERROR'         => 'Error:',

    'DELETE_SUCCESS'        => 'Config values updated successfull and users are deleted',
    'UPDATE_SUCCESS'        => 'Config values updated successfull',

    'CONFIRM_UPDATE'        => 'Do you really want to update the configuration?',
    'CONFIRM_DELETE'        => 'Do you really want to update the configuration and delete following users?',

    'RETURN'                => 'Return to Auto Delete Users',
));
?>
