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
    'ACP_ADU_CONFIG'        => 'Auto delete users',
    'ACP_ADU_EXPLAIN'       => 'Auf dieser Seite kannst du einen Cron Job einrichten, der bestimmte Nutzer löscht. Bitte stelle sicher, dass du die Einstellungen passen, bevor du das Formular abschickst indem du auf "Vorschau" klickst',
    'USERS_AUTO_DELETE'     => 'Einstellungen',

    'MAX_USERPOSTS'         => 'Maximale Beiträge',
    'MAX_USERPOSTS_EXPLAIN' => 'Die maximale Anzahl an Beiträgen, für die zu löschenden Benutzer',
    'MIN_MEMBER_SINCE'      => 'Mitglied seit',
    'MIN_MEMBER_SINCE_EXPLAIN'  => 'Die Anzahl der Tage, die ein Nutzer mindestens Mitglied sein muss, um bei der Überprüfung berücksichtigt zu werden',
    'CHECK_SCHEDULE'        => 'Prüfungsintervall',
    'CHECK_SCHEDULE_EXPLAIN'    => 'Wie oft sollen die Nutzer gelöscht werden',
    'AUTODELETE'            => 'Automatische Löschung',
    'AUTODELETE_EXPLAIN'    => 'Ist die automatische Löschung von Nutzern aktiviert?',

    'SUBMIT_AND_DELETE'     => 'Schicke Daten ab und lösche Nutzer',
    'SUBMIT_ONLY'           => 'Nur Daten Abschicken',

    'ACP_ADU_TABLE_EXPLAIN' => 'Die Nutzer in der unten stehenden Tabelle, werden bei der nächsten Ausführung des Cronjobs gelöscht, oder bei einem Klick auf "Schicke Daten ab und lösche Nutzer"',
    'ADU_USER_ID'           => '#',
    'ADU_USER_NAME'         => 'Nutzer',
    'ADU_USER_REG_ON'       => 'Registriert am',
    'ADU_USER_REG_SINCE'    => 'Registriert seit',
    'ADU_USER_LAST_LOGIN'   => 'Letzter Login',
    'ADU_USER_POSTS'        => 'Posts',
    'ADU_NO_USER'           => 'keine Nutzer auf denen die obigen Bedingungen zutreffen',
    'NEVER'                 => 'nie',

    'DELETE_SUCCESS'        => 'Einstellungen erfolgreich gespeichert und Nutzer gelöscht',
    'UPDATE_SUCCESS'        => 'Einstellungen erfolgreich gespeichert',

    'CONFIRM_UPDATE'        => 'Möchtest du wirklich die Einstellungen speichern?',
    'CONFIRM_DELETE'        => 'Möchtest du wirklich die Einstellungen speichern und die folgen Nutzer löschen?',

    'RETURN'                => 'Zurück zu Auto Delete Users',
));
?>
