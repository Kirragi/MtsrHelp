<?php
/**
 * Основные параметры WordPress.
 *
 * Скрипт для создания wp-config.php использует этот файл в процессе установки.
 * Необязательно использовать веб-интерфейс, можно скопировать файл в "wp-config.php"
 * и заполнить значения вручную.
 *
 * Этот файл содержит следующие параметры:
 *
 * * Настройки базы данных
 * * Секретные ключи
 * * Префикс таблиц базы данных
 * * ABSPATH
 *
 * @link https://ru.wordpress.org/support/article/editing-wp-config-php/
 *
 * @package WordPress
 */

// ** Параметры базы данных: Эту информацию можно получить у вашего хостинг-провайдера ** //
/** Имя базы данных для WordPress */
define( 'DB_NAME', 'MtsrHelp' );

/** Имя пользователя базы данных */
define( 'DB_USER', 'root' );

/** Пароль к базе данных */
define( 'DB_PASSWORD', '' );

/** Имя сервера базы данных */
define( 'DB_HOST', 'localhost' );

/** Кодировка базы данных для создания таблиц. */
define( 'DB_CHARSET', 'utf8mb4' );

/** Схема сопоставления. Не меняйте, если не уверены. */
define( 'DB_COLLATE', '' );

/**#@+
 * Уникальные ключи и соли для аутентификации.
 *
 * Смените значение каждой константы на уникальную фразу. Можно сгенерировать их с помощью
 * {@link https://api.wordpress.org/secret-key/1.1/salt/ сервиса ключей на WordPress.org}.
 *
 * Можно изменить их, чтобы сделать существующие файлы cookies недействительными.
 * Пользователям потребуется авторизоваться снова.
 *
 * @since 2.6.0
 */
define( 'AUTH_KEY',         'dT[H`G6Dkov9)R.:pG-Ym0ST:7{kP9^/#6v|pt/^`awDQsH9$bqX]~L|wtZX4om<' );
define( 'SECURE_AUTH_KEY',  'ps9:-bP3_8C#TC_4+ip6<5;B=O>wM` bT.&;dMTVWqZkvH_L^JjWK*+Krjv{KwxL' );
define( 'LOGGED_IN_KEY',    'av^Qs 6xc~m6w6Kp3H/%uJN/X;vfxe5qRpP@r-ZW,mJ<(GtIL+|H256{sKD0xRTb' );
define( 'NONCE_KEY',        '47m[YI%{;*h:aG9C](:$toxItPz4ayV*Gx6e?aMjEYcwMb61Fh}2-Ekh0+P_=#v:' );
define( 'AUTH_SALT',        'V~P&Q6YNr[[H6eHz=h@QnRM1UoP(ji2hZn*?!Dldn 2L{CD?R~sO9>.@K#yv7!Q(' );
define( 'SECURE_AUTH_SALT', 'j`/`pGxG*~)vXAlpu!4_EaP:x%Ocxof?moRQoy[B~#>Dj;DRaBv>s^.GZ[;|up6 ' );
define( 'LOGGED_IN_SALT',   '+%0sj)~lHL;+rAnAFQ5lOmH7CrncTBqqq;cue96y[:[c[;`/h$xtW/*7h99kcf>q' );
define( 'NONCE_SALT',       'x,f=kx~Yn.4nhGC#R7xC^Ly5Am>M lyF@~u8;B8{V4?2bZ4UB2xFYm)4`3U}me(o' );

/**#@-*/

/**
 * Префикс таблиц в базе данных WordPress.
 *
 * Можно установить несколько сайтов в одну базу данных, если использовать
 * разные префиксы. Пожалуйста, указывайте только цифры, буквы и знак подчеркивания.
 */
$table_prefix = 'wp_';

/**
 * Для разработчиков: Режим отладки WordPress.
 *
 * Измените это значение на true, чтобы включить отображение уведомлений при разработке.
 * Разработчикам плагинов и тем настоятельно рекомендуется использовать WP_DEBUG
 * в своём рабочем окружении.
 *
 * Информацию о других отладочных константах можно найти в документации.
 *
 * @link https://ru.wordpress.org/support/article/debugging-in-wordpress/
 */
define( 'WP_DEBUG', false );

/* Произвольные значения добавляйте между этой строкой и надписью "дальше не редактируем". */



/* Это всё, дальше не редактируем. Успехов! */

/** Абсолютный путь к директории WordPress. */
if ( ! defined( 'ABSPATH' ) ) {
	define( 'ABSPATH', __DIR__ . '/' );
}

/** Инициализирует переменные WordPress и подключает файлы. */
require_once ABSPATH . 'wp-settings.php';
