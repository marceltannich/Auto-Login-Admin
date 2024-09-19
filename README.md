# Auto-Login Plugin for Local Development

This WordPress plugin is designed to simplify local debugging by automatically logging in users and bypassing issues like fatal errors from third-party code or frequent logouts. It ensures a seamless experience when working with local environments, especially when using copies of websites created with tools like Duplicator.

## Features
- Automatically logs in the first administrator account found on your local environment.
- Avoids fatal errors or interruptions caused by third-party code when creating users via WP-CLI etc.
- Bypasses frequent automatic logouts.
- Works even if the login endpoint has been renamed.
- Only runs in local environments (e.g., `localhost`).
- Automatically deactivates itself in production environments, displaying an admin notice to remove the plugin for security.

## How to Use
1. Copy the plugin file to your `wp-content/mu-plugins` directory in your local WordPress installation.
2. No need for manual activation—the plugin will load automatically.
3. If you're using a Duplicator copy or similar, there's no need to create a user via WP-CLI, the database, or use existing credentials. The plugin will log you in as the first administrator account found.

## Safeguards for Production Environments
- The plugin automatically disables itself if it detects it's running outside a local environment.
- In production environments, it does not perform any auto-login or login page redirection.
- Instead, it shows an admin notice to alert administrators to remove the plugin from the `mu-plugins` folder to maintain security.

## Installation
1. Download or clone this repository.
2. Copy the plugin file to the `wp-content/mu-plugins` folder of your WordPress local installation.
3. That's it! The plugin will activate automatically on local environments via /mu-plugins

## License
This plugin is licensed under the [GNU General Public License v2.0](https://www.gnu.org/licenses/old-licenses/gpl-2.0.html) or later.

## Disclaimer
**Important:** This plugin is for **local development only**. It is not intended for use on production environments.
