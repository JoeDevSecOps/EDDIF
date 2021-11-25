<?php
/**
 * La configuration de base de votre installation WordPress.
 *
 * Ce fichier est utilisé par le script de création de wp-config.php pendant
 * le processus d’installation. Vous n’avez pas à utiliser le site web, vous
 * pouvez simplement renommer ce fichier en « wp-config.php » et remplir les
 * valeurs.
 *
 * Ce fichier contient les réglages de configuration suivants :
 *
 * Réglages MySQL
 * Préfixe de table
 * Clés secrètes
 * Langue utilisée
 * ABSPATH
 *
 * @link https://fr.wordpress.org/support/article/editing-wp-config-php/.
 *
 * @package WordPress
 */

// ** Réglages MySQL - Votre hébergeur doit vous fournir ces informations. ** //
/** Nom de la base de données de WordPress. */
define( 'DB_NAME', 'EDDIF' );

/** Utilisateur de la base de données MySQL. */
define( 'DB_USER', 'root' );

/** Mot de passe de la base de données MySQL. */
define( 'DB_PASSWORD', 'root' );

/** Adresse de l’hébergement MySQL. */
define( 'DB_HOST', 'localhost' );

/** Jeu de caractères à utiliser par la base de données lors de la création des tables. */
define( 'DB_CHARSET', 'utf8mb4' );

/**
 * Type de collation de la base de données.
 * N’y touchez que si vous savez ce que vous faites.
 */
define( 'DB_COLLATE', '' );

/**#@+
 * Clés uniques d’authentification et salage.
 *
 * Remplacez les valeurs par défaut par des phrases uniques !
 * Vous pouvez générer des phrases aléatoires en utilisant
 * {@link https://api.wordpress.org/secret-key/1.1/salt/ le service de clés secrètes de WordPress.org}.
 * Vous pouvez modifier ces phrases à n’importe quel moment, afin d’invalider tous les cookies existants.
 * Cela forcera également tous les utilisateurs à se reconnecter.
 *
 * @since 2.6.0
 */
define( 'AUTH_KEY',         'E|LY9i.]`Rn[:=)n?F]-k79,[!JT1JQO!7GJxH0LF~MJ%JX%f9U_#q]V39jWSExJ' );
define( 'SECURE_AUTH_KEY',  '`QbU!Kr|is%m-%496uW:do#O_]0J}{U82Y{/ZrL)?@0~Ru01(Zd]F=:!2>Qv6=+[' );
define( 'LOGGED_IN_KEY',    'D]`lHyvi>3qPGHiWPgX+infV<[~h 9mMd]K^9e_]6h8*gP J8<yXybEZU?k]amxK' );
define( 'NONCE_KEY',        'j{B{-eX8D0*<C @n,OEVjLy$zDB9V/?rV@m+JPO0][z~.Yy=^W<ke9?~w%sLk`ZA' );
define( 'AUTH_SALT',        'XP)qV.lmSh-V 22v!$8!RHE=(uB-lxYi8F0*Woy?R|h`?%rvN-I$lJ76S9N95KIP' );
define( 'SECURE_AUTH_SALT', 'WkhhcKu:WJNrfnj/}C=XAEr(4R-M9[&v#ON!cN<xIPle+I*bem*bXEQ?<I~(fKF|' );
define( 'LOGGED_IN_SALT',   'E}t;~8N{giu6<VA#r;yrunKusLngL&B*_h_:UDp]LxS=2Plz1nk$1N!8WA6G0QS}' );
define( 'NONCE_SALT',       'X7wCt+!GGUOS6$e*8uGfsy7*tE8n93;3)w1dMsPK<yj}$$g<ChhtbAdf7@e u/CR' );
/**#@-*/

/**
 * Préfixe de base de données pour les tables de WordPress.
 *
 * Vous pouvez installer plusieurs WordPress sur une seule base de données
 * si vous leur donnez chacune un préfixe unique.
 * N’utilisez que des chiffres, des lettres non-accentuées, et des caractères soulignés !
 */
$table_prefix = 'wp_';

/**
 * Pour les développeurs : le mode déboguage de WordPress.
 *
 * En passant la valeur suivante à "true", vous activez l’affichage des
 * notifications d’erreurs pendant vos essais.
 * Il est fortement recommandé que les développeurs d’extensions et
 * de thèmes se servent de WP_DEBUG dans leur environnement de
 * développement.
 *
 * Pour plus d’information sur les autres constantes qui peuvent être utilisées
 * pour le déboguage, rendez-vous sur le Codex.
 *
 * @link https://fr.wordpress.org/support/article/debugging-in-wordpress/
 */
define( 'WP_DEBUG', false );

/* C’est tout, ne touchez pas à ce qui suit ! Bonne publication. */

/** Chemin absolu vers le dossier de WordPress. */
if ( ! defined( 'ABSPATH' ) )
  define( 'ABSPATH', dirname( __FILE__ ) . '/' );

/** Réglage des variables de WordPress et de ses fichiers inclus. */
require_once( ABSPATH . 'wp-settings.php' );
