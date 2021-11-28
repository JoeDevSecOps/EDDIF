=== Cookies and Content Security Policy ===
Contributors: jonkastonka
Donate link: https://www.paypal.com/donate/?hosted_button_id=86UYSXNUA2LHY
Tags: cookie, cookies, cookie bar, cookie compliance, third-party cookies, gdpr, ccpa, csp, content security policy, modal, security, translatable
Requires at least: 5.0
Tested up to: 5.8
Requires PHP: 7.0
Stable tag: 1.96
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html

== Description ==

**Be fully GDPR and CCPA compliant through Content Security Policy.**
 
Block cookies and unwanted external content by setting Content Security Policy. A modal will be shown on the front end to let the visitor choose what kind of resources to accept. It also adds a layer of security for your site since iframes, scripts and images from unknown domains are blocked.

**Multilingual** support through [WPML](https://wpml.org/), [Polylang](https://polylang.pro/) or probably any multilingual plugin out there since this plugin follows WordPress Coding Standards. See FAQ below on how to translate with WPML or Polylang.

== New: Quickstart ==
 
**New since version 1.57:** Quickstart, choose common resources from a list that are automatically added to your Domains list. So, it's even easier to set it up! Check, check, check and check!
Updated regularly.

== Installation ==
 
Search for `Cookies and Content Security Policy` under Plugins on your WordPress install or download and:

1. Upload `cookies-and-content-security-policy` to the `/wp-content/plugins/` directory
2. Activate the plugin through the 'Plugins' menu in WordPress
3. Go to Settings > Cookies and Content Security Policy
 
== Frequently Asked Questions ==
 
= Does this make my site GDPR compliant? =
 
Yes, if you set it up right.

= Does this make my site CCPA compliant? =
 
Yes, if you set it up right.

= How do I know what resources are used on my site? =
 
After install, open a console (see screenshot 13) and see what is blocked by Content Security Policy. Then just go to the settings and white list all domains you want to accept.

= The settings does not seem to have an effect. What do I do? =

There are three scenarios where this can happen:

* In some cases cookies are cached. It could be your hosting (for example WP Engine does this), then just contact them and ask them to uncache the cookies_and_content_security_policy cookie.
* In other cases it could be your cache plugin (for example Litespeed cache does this), then just review your settings. In the case of Litespeed cache, go to Cache/Excludes and exclude cookies_and_content_security_policy.
* If you're using static page cache that doesn't go through php, go to Settings > Cookies and Content Security Policy > Settings and check Use meta under Advanced settings.

= Can you show me some examples of sites using this plugin? =

In English

* https://oddoneout.se/en/ - Transladed strings in Polylang, works in the same way with WPML
* https://draftitprivacy.com/ - Transladed strings in Polylang, works in the same way with WPML

In Swedish

* https://oddoneout.se/ - Transladed strings in Polylang, works in the same way with WPML
* https://draftitprivacy.se/ - Transladed strings in Polylang, works in the same way with WPML
* https://draftit.se/ - Multisite, also https://draftitskola.se/
* https://expolon.se/ - Multisite, also https://expohr.se/
* https://studiocanalis.se/
* https://yogajona.se/
* https://handelskammaren.com/
* https://sydsvenskan.minibladet.se/ - Multisite https://minibladet.se/ for all sites

In Norwegian

* https://draftitprivacy.no/ - Transladed strings in Polylang, works in the same way with WPML

= Is the plugin responsive? =

Yes.

= Is the plugin translatable? =

Yes, all texts are translatable. There are 10+ languages already translated. And if you want to contribute with a translation of your own language, please do! <3 All texts on the front end can be changed directly in the admin. And if you are using WPML, Polylang, or some other multilanguage plugin, there is also support for multilanguage translations.

= How do I translate in WPML? =

1. Make sure you have "WPML String Translation" installed.
2. Go to Settings > Cookies and Content Security Policy > Texts and save your texts. 
3. Go to WPML > String Translation.
4. Search for "cacsp_" (without quotes).
5. Click the plus sign to add translation.
6. If you have a string named "cacsp_option_settings_policy_link", the value is a number. It is the ID of the Cookie policy page. Translate this by entering the ID of the cookie policy page in the language you are translating to.

= How do I translate in Polylang? =

1. Go to Settings > Cookies and Content Security Policy > Texts and save your texts. 
2. In the WordPress admin bar, choose "Show all languages".
3. Go to Languages > Strings translations.
4. In the "View all groups" dropdown, choose cookies-and-content-security-policy, and click "Filter".
5. Translate your texts in the form.
6. If you have a string named "cacsp_option_settings_policy_link", the value is a number. It is the ID of the Cookie policy page. Translate this by entering the ID of the cookie policy page in the language you are translating to.

= Can I change the look of it? =

Yes, there are settings for using a modal or a banner. Also you can choose if the site should be locked behind the modal or if the site should be usable without setting your preferences. You can also change the colors of everything. And if you want you can disable the css entirely and use your own. 

= Does it include a cookie policy page? =

No, but you can make your own, and in the settings you can select it and the modal won't show there so that the user can read it without accepting first.

= What if the user wants to change their settings? =

You can add a link anywhere on your site that links to `#cookiesAndContentPolicySettings` and clicking that will open the settings.

= Are the css and js files minified? =

Yes, but you also get them unminified and the css also comes as SASS so you can change anything.

= Can I bypass the plugin for testing purposes? =

Yes, just add the querystring ?cacsp_bypass=true to your url, when running speedtest in Gmetrix for instance. It will set a session cookie that accepts all Domains you've set.

= Does it work with page builders? =

Yes! Not all are tested, but all tested works!

These have been tested:

* Divi
* Beaver Builder
* WPBakery Page Builder

= I'm using a custom path in my WordPress setup and now the plugin doesn't work. What do I do? =

This happens if you are using for example Bedrock by Roots.

Go to the plugins folder, and in the folder *cookies-and-content-security-policy*, rename the file *cookies-and-content-security-policy-vars-sample.php* to *cookies-and-content-security-policy-vars.php* and save it to your plugins folder. After that, change this line:
*$wp_load_path = '/your/custom/path/to/wp-load.php';* so that the path reflects your server path to wp-load.php. The value can also be relative, like *../../../../wp-load.php*.

== Screenshots ==
 
1. First modal, when using default colors.

2. Second modal, when using default colors.

3. Banner, when using default colors. Replaces First modal, when the setting "Do not use a modal, I want a banner." is used.

4. First modal, example of customized colors.

5. Second modal, example of customized colors.

6. Banner, example of customized colors.

7. Activate, by default when installing, the plugin is deactivated, choose admin to test your settings before going live just to check out if everything works.

8. Quickstart, choose from a long list of common resources to get started super quick.

9. Domains, this is where you white list all the domains where you allow content to be served from.

10. Texts, use the default texts or write your own. This is also fully multi language supported.

11. Settings, cusomize it how you like it.

12. Colors, without knowing css or anything, customize the colors to fit your site.

13. Look in console to see what is blocked. In this case you'd probably like to add https://platform.twitter.com/ to Experience > Script. Or just use Quickstart and choose Twitter.
 
== Changelog ==

= 1.96 =

* Vars file moved to make sure it's not deleted on update
* Bug fix for embedded PDFs in Gutenberg block

= 1.95 =

* Better Quickstart for LinkedIn
* Wildcard for Doubleclick when setting up Google Ads with Quickstart

= 1.94 =

* Vars file added for all of you weird path people out there, I'm looking at you Bedrock ;)
* Hubspot iframe for posting forms added to Quickstart
* Googleapis domain for Google Maps added to Quickstart

= 1.93 =

* Mime type specified for error message file
* Wildcard domain for YouTube images in Quickstart

= 1.92 =

* Fix for keeping cookie settings across sessions in iOS

= 1.91 =

* Add file for allowed domains

= 1.90 =

* Allowed domains for error message moved to separate file for better support for cache plugins
* Fix for cookie message appearing in WordPress 5.8 block widgets

= 1.89 =

* Deep link to #cookiesAndContentPolicySettings
* Better readability in debug
* Possibility to disable unsafe-inline
* Possibility to disable unsafe-eval

= 1.88 =

* Domain Path
* Mailchimp added to Quickstart

= 1.87 =

* maps.google.com added to Quickstart for Google Maps frame.

= 1.86 =

* Quickstart for Jetpack
* Body position for CLS
* Better flex for scroll in settings modal

= 1.85 =

* Google in Quickstart checkboxes

= 1.84 =

* Patch: Bug found in "Only reload page when accepting" from 1.83

= 1.83 =

* Bust cache for js and css when new version of the plugin gets installed
* Faster enqueue of js and css, millisecond(s) faster, but on big sites ...
* Compact custom css
* Only reload page when accepting if there are visible blocked elements, like iframes and images. Otherwise just hide the modal and save the settings.
* Added Calendly to Quickstart
* Categorized resources in Quickstart
* Domains for all Google resources updated in Quickstart
* Better description on how to work with translation plugins

= 1.82 =

* Text domain
* Improvement of Google Analytics in Quickstart

= 1.81 =

* Tested up to 5.7.
* Patch bug that appeared in 1.80 when saving Settings in admin. Where Cookie policy target gave a warning when saving if it was not checked.
* Better check for double domains in Quickstart, no more double new lines.
* Added posibility to allow blob:. Found under Settings > Advanced settings.
* maps.google.com and maps.gstatic.com added to Quickstart for Google Maps.

= 1.80 =

* Added posibility to add worker. Found under Settings > Advanced settings. Then just add your worker-domains under Domains.
* Alternative link to cookie policy for those of you who have the policy on a different domain, in a PDF or something else.
* Option to open your cookie policy in a new tab.
* Accept cookies cookie has now SameSite set to strict.
* Accept cookies cookie set to secure for SSL sites.

= 1.79 =

* Patch bug in Quickstart for Twitter
* Added youtube-nocookie.com and youtu.be to Quickstart for YouTube
* Added googletagmanager.com to Quickstart for Google Analytics
* Updated text about static cache
* Descriptions for settings moved to own row, to make settings easier to skim through

= 1.78 =

* Google Translate without the extra t
* Tested up to 5.6.1
* Helpful tip on static cache
* Screenshot of console

= 1.77 =

* Update of Quickstart for reCAPTCHA v3

= 1.76 =

* Possibility to hide unused sections in Settings. Example: If you don't have any domains specified for Marketing, that setting won't show for the visitor. Found under Settings > Basic settings

= 1.75 =

* Patch bug found by @stafca in possibility to disable X-Content-Security-Policy. Thanks!

= 1.74 =

* Capitalise company names correctly
* Possibility to disable X-Content-Security-Policy. Found under Settings > Advanced settings
* New optional button for refusing all cookies. Found under Settings > Basic settings

= 1.73 =

* Minor translation fixes
* Update of Quickstart for reCAPTCHA v3

= 1.72 =

* Individual height of warning messages for blocked iframes and objects improved

= 1.71 =

* Button width not based on flex basis on small screens
* New Quickstart: Twitter

= 1.70 =

* Updated Quickstart for Google Maps

= 1.69 =

* Custom color for Save button border was used for background too.

= 1.68 =

* Translations and spelling
* We have Finnish translation!

= 1.67 =

* Minor typos
* Added to Quickstart: Google Translate
* Hubspot in Quickstart is out of beta

= 1.66 =

* Better string translation in WPML 
* Support for multiple cookie policy pages, one for each language, on multi language sites
* Bypass querystring added to make testing easier, when testing speed in Gmetrix for instance, you don't want anything blocked. Just add ?cacsp_bypass=true to your url when testing.

= 1.65 =

* Grandma mode

= 1.64 =

* Tested for CCPA compliance
* Changed the expiry of consent to 1 year, so this can be stated in the cookie policy page for CCPA compliance, the default "Settings text" has been updated to show this
* New icon and banner, cookie and grandma drawn by Hedda Fager
* New screenshots
* Fixed typo in WPML FAQ
* Disable scroll on page when settings modal is shown, gave double scrolbars when unsing "Allow user to access site without saving settings"

= 1.63 =

* Added to Quickstart: SoundCloud
* No outline on clicked setting in modal

= 1.62 =

* Better support for WPML thanks to [mediopirzel](https://wordpress.org/support/topic/translate-content-with-wpml/)

= 1.61 =

* Quickstart, out of beta
* Quickstart, more resources added: Google Optimize, Google Ads conversions, Google Ads remarketing, Hubspot and reCAPTCHA v3
* Bugfix for iframes and objects without src attribute

= 1.60 =

* Translations

= 1.59 =

* Translations

= 1.58 =

* Adding refactored files

= 1.57 =

* Refactoring of settings
* Quickstart, choose common resources from a list that are automatically added to your Domains list

= 1.56 =

* Make site clickable when using "Allow user to access site without saving settings"

= 1.55 =

* googleoff: index added for modal and banner to be absolutely sure that the content of these doen't get indexed by google
* Fix for Safari on iOS 13 and the setting "Allow user to access site without saving settings"

= 1.54 =

* Disable UI warning messages for hidden iframes, like Hotjar and so on

= 1.53 =

* Rogue c

= 1.52 =

* Spelling Marketing can be tricky ;)

= 1.51 =

* Version number for automatic updating

= 1.5 =

* Blocking object with the same rules as for iframe, to secure old style flash embeds, like for example old YouTube embeds
* Support tab
* Better support for // urls

= 1.44 =

* Tested up to WordPress 5.5

= 1.43 =

* Fix for "Only use CSP" option. Don't try to show UI error message.

= 1.42 =

* WordPress 5.5 ready

= 1.41 =

* Translations and spelling

= 1.40 =

* By popular demand: Plugin is now deactivated on install. You can also activate the plugin only for administrators to test your settings without disturbing your visitors.

= 1.39 =

* Since translations is only available in API through Polylang Pro, I rewrote the error messages for blocked iframes in oldschool js to make error messages appear translated in the free version of Polylang.

= 1.38 =

* Admin css
* Translations

= 1.37 =

* Tested up to 5.4.1
* Translations

= 1.36 =

* Bug fix, allow scroll on html element when option "Allow user to access site without saving settings. Only works with banner." is checked.

= 1.35 =

* IE11 support

= 1.34 =

* Css for accepted type

= 1.33 =

* Check for blank iframes

= 1.32 =

* Uninstall for new values

= 1.31 =

* Encode js mail link subject

= 1.3 =

* Support for X-Content-Security-Policy
* Better debug placement
* Advanced settings
* Visible warning for blocked iframes
* Saving bug in mobile Safari fixed
* More help texts
* No texts must be edited, everything has default values

= 1.21 =

* Versioning, SVN is not my friend

= 1.2 =

* Added possibility to use the settings as a meta tag instead, if the host does not accept setting php header()

= 1.13 =

* Translations

= 1.12 =

* Coding standards

= 1.11 =

* WP_DEBUG, clean

= 1.1 =

* Added support for forms

= 1.03 =

* Screenshot text, and active settings value

= 1.02 =

* Assets

= 1.01 =

* Assets and Contributors

= 1.0 =

* Ready for the world!

= 0.999 =

* List width

= 0.998 =

* Minor fixes

= 0.997 =

* Securing

= 0.996 =

* Sanitize

= 0.995 =

* Nonce

= 0.994 =

* Uninstall

= 0.993 =

* WPML config for Cookie policy page id

= 0.992 =

* Admin referrer
 
= 0.991 =

* Initial release
