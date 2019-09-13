=== WP Shopify ===
Contributors: andrewmrobbins
Donate link: https://wpshop.io/purchase/
Tags: shopify, ecommerce, store, sell, products, shop, purchase, buy, wpshopify
Requires at least: 4.7
Requires PHP: 5.6
Tested up to: 5.2.3
Stable tag: trunk
License: GPLv2 or later
License URI: https://www.gnu.org/licenses/gpl-2.0.html

Sell and build custom Shopify experiences on WordPress.

== Description ==

WP Shopify allows you to sell your [Shopify](https://www.shopify.com/?ref=wps&utm_content=links&utm_medium=website&utm_source=wpshopify) products on any WordPress site. Your store data is synced as custom post types giving you the ability to utilize the full power of native WordPress functionality. On the front-end we use the [Shopify Buy Button](https://www.shopify.com/?ref=wps&utm_content=links&utm_medium=website&utm_source=wpshopify) to create an easy to use cart experience without the use of any iFrames.

= Features =
* Sync your products and collections as native WordPress post
* Templates
* No iFrames
* Over 100+ actions and filters allowing you to customize any part of the storefront
* Display your products using custom pages and shortcodes
* Built-in cart experience using [Shopify's Buy Button](https://www.shopify.com/?ref=wps&utm_content=links&utm_medium=website&utm_source=wpshopify)
* SEO optimized
* Advanced access to your Shopify data saved in custom database tables

See the [full list of features here](https://wpshop.io/how/)

https://www.youtube.com/watch?v=v3AC2SPK40o

= WP Shopify Pro =
WP Shopify is also available in a Pro version which includes 80+ Templates, Automatic Syncing, Order and Customer Data, Cross-domain Tracking, Live Support, and much more functionality! [Learn more](https://wpshop.io/purchase)

= We want to hear from you! (Get 10% off WP Shopify Pro) =
Our next short-term goal is to clearly define the [WP Shopify roadmap](https://www.surveymonkey.com/r/3P55HXX). A crucial part of this process is learning from you! We'd love to get your feedback in a [short three question survey](https://www.surveymonkey.com/r/3P55HXX).

The questions are surrounding: 
- How you're using WP Shopify
- What problems you're solving by using the plugin
- What you like the most about the plugin

To show our appreciation, we'll send you a 10% off discount code that will work for any new purchases or renewals of WP Shopify Pro. Just add your email toward the bottom. Thanks! 🙏

[Take the WP Shopify user survey](https://www.surveymonkey.com/r/3P55HXX)

= Links =
* [Website](https://wpshop.io/)
* [Documentation](https://docs.wpshop.io)
* [WP Shopify Pro](https://wpshop.io/purchase)


== Installation ==
From your WordPress dashboard

1. Visit Plugins > Add New
2. Search for *WP Shopify*
3. Activate WP Shopify from your Plugins page
4. Create a [Shopify private app](https://docs.wpshop.io). More [info here](https://help.shopify.com/manual/apps/private-apps)
5. Back in WordPress, click on the menu item __WP Shopify__ and begin syncing your Shopify store to WordPress.
6. We've created a [guide](https://docs.wpshop.io) if you need help during the syncing process

== Screenshots ==
[https://wpshop.io/screenshots/1-syncing-cropped.jpg  Easy and fast syncing process]
[https://wpshop.io/screenshots/2-settings-cropped.jpg  Many settings and options to choose from]
[https://wpshop.io/screenshots/3-posts-cropped.jpg  Sync your store as native WordPress posts]


== Frequently Asked Questions ==

Read the [full list of FAQ](https://wpshop.io/faq/)

= How does this work? =
You can think of WordPress as the frontend and [Shopify](https://www.shopify.com/?ref=wps&utm_content=links&utm_medium=website&utm_source=wpshopify) as the backend. You manage your store (add products, change prices, etc) from within Shopify and those changes sync into WordPress. WP Shopify also allows you to sell your products and is bundled with a cart experience using the [Shopify Buy Button SDK](https://www.shopify.com/?ref=wps&utm_content=links&utm_medium=website&utm_source=wpshopify).

After installing the plugin you connect your Shopify store to WordPress by filling in your Shopify API keys. After syncing, you can display / sell your products in various ways such as:

1. Using the default pages “yoursite.com/products” and “yoursite.com/collections“
2. Shortcodes [wps_products] and [wps_collections]

We also save your Shopify products as Custom Post Types enabling you to harness the native power of WordPress.

= Doesn’t Shopify already have a WordPress plugin? =
Technically yes but it [has been discontinued](https://wptavern.com/shopify-discontinues-its-official-plugin-for-wordpress).

Shopify has instead moved attention to their [Buy Button](https://www.shopify.ca/buy-button) which is an open-source library that allows you to embed products with snippets of HTML and JavaScript. The main drawback to this is that Shopify uses iFrames for the embeds which limit the ability for layout customizations.

WP Shopify instead uses a combination of the Buy Button and Shopify API to create an iFrame-free experience. This gives allows you to sync Shopify data directly into WordPress. We also save the products and collections as Custom Post Types which unlocks the native power of WordPress.

= Is this SEO friendly? =
We’ve gone to great lengths to ensure we’ve conformed to all the SEO best practices including semantic alt text, Structured Data, and indexable content.

= Does this work with third party Shopify apps? =
Unfortunately no. We rely on the main Shopify API which doesn’t expose third-party app data. However the functionality found in many of the Shopify apps can be reproduced by other WordPress plugins.

= How do I display my products? =
Documentation on how to display your products can be [found here](https://docs.wpshop.io/#/getting-started/displaying).

= How does the checkout process work? =
WP Shopify does not handle any portion of the checkout process. When a customer clicks the checkout button within the cart, they’re redirected to the default Shopify checkout page to finish the process. The checkout page is opened in a new tab.

More information on the Shopify checkout process can be [found here](https://help.shopify.com/manual/sell-online/checkout-settings).

= Does this work with Shopify's Lite plan? =
Absolutely! In fact this is our recommendation if you intend to only sell on WordPress. More information on Shopify's [Lite plan](https://www.shopify.com/lite)


== Changelog ==
Our full changelog can be [found here](https://wpshop.io/changelog/)

= 2.0.14 =
Bug fixes and WordPress 5.2.3 support. Have a great weekend everyone!

* 🛠 Fixed: Layout spacing issues caused by empty HTML elements
* 📦 Added: Ability to fully customize the page URL for collections and products
* 📦 Added: New JavaScript filter: default.cart.notes.label
* 💻 Dev: Added instagram link to Help tab

= 2.0.13 =
Bug fixes and WordPress 5.2.3 support. Have a great weekend everyone!

* 🛠 Fixed: Incorrectly loading <Customers> component in free version
* 🛠 Fixed: Removed hardcoded shopify domain for customer requests
* 🛠 Fixed: Bug in Pro version causing blank modal screen when clicking: View version details 
* 🛠 Fixed: ABSPATH error when plugin is activated on a subdirectory WP installation
* 📦 Added: Support for WordPress 5.2.3
* 📦 Added: A new 'wpshopify' namespace to all get_footer() and get_header() calls
* 💻 Dev: Removed unused Customers code
* 💻 Dev: No longer caching the Shopify JS SDK client in localStorage
* 💻 Dev: Removed localForage library in favor of store library

= 2.0.12 =
Greetings! Lots of a good bug fixes today. Also for Pro users, the new Customer Accounts is available as a beta! Just turn it on under the plugin settings. Over the coming weeks we'll be adding more stability and features. Stay tuned.

* 🛠 Fixed: Bug preventing free version uninstall when Pro version was activated 
* 🛠 Fixed: Function name collisions within autoloader when both free and pro version are installed
* 🛠 Fixed: Issue causing duplicates to appear on product and collection single pages
* 📦 Added: New JavaScript filter hook: 'product.title.before'
* 📦 Added: New JavaScript filter hook: 'product.title.after'
* 📦 Added: Cart state data to both the 'cart.checkout.before' and 'cart.checkout.after' hooks
* 📦 Added: Set limit to one on product and collection single pages to prevent duplicates 
* 📦 Added: Customer Accounts beta
* 📣 Updated: Changed various links within the readme.txt of free version
* 💻 Dev: Replaced wp.hooks conditional checks with a single consistent function

= 2.0.11 =

* 🛠 Fixed: version issue

= 2.0.10 =
Hello! A couple of important bug fixes today. Customer accounts coming soon!

* 📦 Added: New JS filter hook: 'cart.checkout.before'
* 📦 Added: New JS filter hook: 'cart.checkout.after'
* 🛠 Fixed: Storefront filter not taking more than one value on initial load
* 🛠 Fixed: Unable to reverse products order when using the [wps_collections] shortcode
* 💻 Dev: Foundation for Customer Accounts integration
* 💻 Dev: Updated npm dependencies

= 2.0.9 =

* 📣 Add: Cache clearing after plugin update to prevent JavaScript errors
* 💻 Dev: Added unit tests for after_upgrader_process_complete method
* 💻 Dev: Added unit tests for wps_collections shortcode

= 2.0.8 =

* 🛠 Fixed: Bug in the [wps_collections] shortcode where the `products_` attributes fail to work properly
* 🛠 Fixed: The plugin setting "Show fixed cart icon" was not working
* 🛠 Fixed: Bug inside class-attributes->attr() causing default values to override user values
* 📣 Updated: Removed extra whitespace on the product single template
* 💻 Dev: Added type checking for capitalizeFirstLetter()
* 💻 Dev: Added unit tests for [wps_collections] shortcode 

= 2.0.7 =

Hey folks,

Today's update contains another round of bug fixes. If you're having trouble with products not linking to Shopify, custom domains not working, or issues the Storefront shortcode please update!

* 📦 Added: Animation for Storefront products
* 🛠 Fixed: Bug causing product and collection single pages to not properly use all shortcode attributes
* 🛠 Fixed: Broken slider styles
* 🛠 Fixed: Bug causing "Products link to Shopify" to not work
* 🛠 Fixed: Bug causing enable custom domain not to work
* 🛠 Fixed: Bug causing product variant dropdowns to show beneath the image of the product below it
* 💻 Dev: Added ESLint with React Hooks plugin
* 💻 Dev: Improved performance of Storefront component by implementing an in-memory caching

= 2.0.6 =

Hey everyone,

This release contains important updates for overall plugin stability. Please upgrade as soon as you can.

* 🛠 Fixed missing "checkbox" in the cart terms
* 🛠 Fixed bug causing incorrect error message(s) to display during syncing process
* 📦 Added default value for getPageSizeFromComponentOptions
* 📦 Added empty data validation checks to update_shop()
* 📦 Added new filter hook for the loading text: wps_loading_text
* 📦 Added better sanitization and validation of REST endpoints
* 📦 Added unregister_post_type during plugin deactivation
* 📣 Updated WPS_ namespace to WP_Shopify throughout plugin
* 📣 Updated webhooks URL to webhooks domain to more accurately describe what it is
* 📣 Updated loading element from span to div 
* 📣 Updated "Reconnect Automatic Syncing" to "Reconnect Automatic Post Syncing"
* 📣 Updated the way we're determining plugin paths and directories
* 📣 Updated WP_SHOPIFY_PLUGIN_FILE_RELATIVE_TO_PLUGINS_DIR to WP_SHOPIFY_BASENAME
* 📣 Removed unused REST endpoints
* 📣 Removed unused constants
* 📣 Removed externally loaded jquery-ui css 

= 2.0.5 =

⚠️ Important security patch. Please update ASAP!

* 🛠 Fixed: Bug causing cart notes not to work after typing.
* 🛠 Fixed: Major XSS security vulnerability.
* 🛠 Fixed: 500 error caused by improper wp_shopify_cache_cleared checks.
* 🛠 Fixed: When products have more than one image, links to product single pages were not working.
* 🛠 Fixed: Bug with dirname() when not using PHP 7+.
* 💻 Dev: Added proper permission_callbacks to REST API endpoints.