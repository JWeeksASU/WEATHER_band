=== Facebook wall and social integration ===
Contributors: mitsol
Tags: Facebook, Facebook posts, Facebook wall, Facebook page, Feed, Events, Shortcode, Social, Status, Posts, Facebook wall, Plugin, Custom, Facebook group, Social media, Seo, Responsive 
Requires at least: 3.1
Tested up to: 4.0
Stable tag: 1.4
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html

Facebook wall and social integration allows you to display customized Facebook feed of any public Facebook page or group or profile.

== Description == 
Facebook wall and social integration shows **facebook page/group/profile feed/wall posts** in your website.You will only have to put facebook id of page or group or profile and access token in the plugin settings. Graph API is used to get page/group/profile feed content from facebook efficiently. If you face any problems in running it just read [doc](http://extensions.techhelpsource.com/facebook_wall_documentation_wordpress.htm) & contact us.

It's easy to handle and not dependant on javascript. There are a lot of settings to customize display including font & color settings, showing guest entries, show/hide each individual items of post, set cache duration to cache FB content to database to retrieve content from database without making another Api request to facebook until cache duration expires, set date time zone to display post date according to your timezone, crawlable by search engines and it's responsive, others.

A perfect display of your Facebook page/group/profile content in your business/personal websites, view customer reviews to know what our customer says. Post ideas about the plugin in [pro version website](http://extensions.techhelpsource.com/forum "pro version website forum") & [follow me](https://twitter.com/mridulcs "follow me") on twitter for update of changes.

= Features =

* **Graph API usage** for profile/page/group feeds
* All you need to run is **facebook id and access token**
* Manage height and width of feed display container
* You can set **number of posts** to display
* Have the ability to show guest entries too
* **Color settings** for post items
* Set background color of wall display
* Cool editable css and loads fast
* Use the shortcode to set different page/group id and others settings
* All settings can be set via short code [atttributes](http://extensions.techhelpsource.com/fbwall_wordpress_shortcodes.htm "short code attributes")
* Select from date formats to display date your own way
* Also select different **time zones** to display date according to your time zone
* **Multiple feed display per page**
* It's **responsive** and adjusts within the width of container
* Feed data can be **cached** in database using wp transient api to load fast
* Show/hide **individual items in post** 
* Write your own text for post link which opens the post in Facebook
* Includes setting page tab to see if system requirements are met
* Read **Faq** for embedding feed in template
* Others & more required stunning features in pro version

To display photo post, video post, link post, event post, choose type of posts, show/hide items in post, different picture sizes, the number of likes, all comments per post using ajax call, filter posts by any custom strings and post id, header bar and like button at top, language settings, scrolling plugin, responsiveness, make text urls & hashtags linkable and more features then [upgrade to the Pro version](http://extensions.techhelpsource.com/wordpress/facebook-wall-pro "facebook wall pro"). Try out the [Pro demo](http://wordpress.techhelpsource.com/facebook-wall-pro/ "facebook wall Demo").

== Installation ==

1. Install the facebook wall and social integration either via the WordPress plugin directory, or by uploading the files to your web server (in the `/wp-content/plugins/` directory).
2. Activate the plugin through the 'Plugins' menu in WordPress.
3. Navigate to the 'Facebook wall & social integration' settings page to configure your feed.
4. Use the shortcode `[mitsol_fbwall_feed_short_code]` in your page, post or widget to display your feed.
5. You can display feeds of different Facebook groups/pages by specifying a Page/group ID directly in the shortcode: `[mitsol_fbwall_feed_short_code id=wordpress num=20]`.
6. if there is any confusion in running/installing the plugin, contact immediately and view doc, problems will be solved

== Frequently Asked Questions ==

For a full documentation with FAQs and help with troubleshooting please visit the **[Documentation and FAQs](http://extensions.techhelpsource.com/facebook_wall_documentation_wordpress.htm)** section of the mitsol extensions website 

Furhermore, if there is any confusion in running the plugin, contact immediately and view doc, problems will be solved

= How do I find the ID of my Facebook page or group or profile? =

If you have a Facebook **page** with a URL like this: `https://www.facebook.com/misol12` then the Page ID is just `misol12`. If your page URL is look like this: `https://www.facebook.com/pages/pagename/123654123654123` then the Page ID is the numbers - `123654123654123`.

If you have a Facebook **group/profile** then use [this tool](http://lookup-id.com/ "Look Up my ID") to find your Group ID or view our documentaion link above.

= What is Access Token and how to get it? =

Access Token is required by Facebook in order to access their feeds. It's easy to get one.  Just follow the step-by-step instructions [here in the doc](http://extensions.techhelpsource.com/facebook_wall_documentation_wordpress.htm "Getting an Access Token"). 

= Why isn't the feed from my group/page displaying? =

Make sure system requirements are met(look for the tab in settings page), facebook id and access token are right. Also, increase the  **Show number of posts** value from settings becuase 
non-pro version only shows status/textual posts of page/group/profile so there may not be status posts in the number of posts value specified. Finally, make sure if there are no restrictions set in facebook page/group settings comparing with other page/groups for which feed works, mainly remove country and age restrictions in page/group settings.

= Why my facebook profile feed not displaying properly? =

If you created facebook application after 30th April 2014 and using it's token then profile feed may not be displayed for new facebook Graph API(you may require profile id in a different way, contact for that). Actually Displaying feed for profile shows only public and selected posts because of various restrictions.So it's not good to show profile feed.

= Can I show photos and videos in my Facebook feed? =

This free plugin only allows you to display textual updates from your Facebook feed. To display photos,videos,formatted links in your feed you need to upgrade to the Pro version of the plugin. View demo of the Pro version on the [mitsol wp demo website](http://wordpress.techhelpsource.com/facebook-wall-pro/ "facebook wall feed Demo"), and find out more about Pro version [here](http://extensions.techhelpsource.com/wordpress/facebook-wall-pro "Facebook Wall Feed Pro").

= Can I choose to show certain types of posts? =

Yes you can choose type of posts to display.For this feature please upgrade to the [Pro version of the plugin](http://extensions.techhelpsource.com/wordpress/facebook-wall-pro "Facebook Wall Feed Pro").

= Can I show the comments associated with each Facebook post? =

For this feature please upgrade to the [Pro version of the plugin](http://extensions.techhelpsource.com/wordpress/facebook-wall-pro "Facebook Wall Feed Pro"). From pro version 1.2 getting comments directly from facebook using ajax has been added.

= How do I embed the Facebook Feed directly into a WordPress page template? =

You can embed your Facebook feed directly into a template file by using the WordPress do_shortcode function: `do_shortcode('[mitsol_fbwall_feed_short_code]');`.

= How do i use short code and inlcude attributes for specifying different settings for the feed display? =

Read info about it at the bottom of plugin setting page in wp dashboard. From version 1.3 you can set all settings in shortcode, [click here](http://extensions.techhelpsource.com/fbwall_wordpress_shortcodes.htm "shortcode attributes") to see all shortcode attribute names.


== Screenshots ==

1. This pic shows how feed look like by default settings and colors
2. Configuring the facebook wall and social integration plugin
3. Colors - Facebook wall color settings
4. Post Layout - Facebook wall post layout settings

== Changelog ==

= 1.0 =
* Launch!
= 1.1 =
* Plugin now uses server side call to show feed to have non-expired access token requested by many users. Some new features added like choosing post types, defining different picture sizes...
= 1.2 =
* Feed data caching has been added to load faster.Some new pro version features like getting all comments directly from facebook by ajax call, and more improvements.
= 1.3 =
* Show/hide each individual items of post like author avatar, photos, comments ....
* Font size(pro) and color for each items of the post
* All settings now can be set in short code attributes 
* embed youtube videos in feed display(pro)
* other fixes
= 1.4 =
* added post filters : show posts which contain specified string in settings, also hide posts which contain that string
* filter by post id is possible to show specific post only.
* other minor fixes and improvements

   

