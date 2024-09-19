# Auto-Login-Admin
When debugging locally, I sometimes encounter issues where fatal errors from third-party code prevent me from creating a user via WP-CLI, or I experience frequent automatic logouts. To address this, I created this plugin that bypasses these problems.

- Simply copy the plugin file into your wp-content/mu-plugins directory on your local environment, and it will load automatically without the need for manual activation.
- If you're working with a Duplicator copy or similar, there's no need to create a user (via WP-CLI, database, etc.) or use the credentials provided.
- The plugin will automatically log you in using the first administrator account found.
- It checks if the environment is localhost and only runs its logic in local setups.
- It works also if the login endpoint has been renamed.

Additionally, the plugin is designed to prevent accidental use in a production environment:
- It programmatically disables itself if it detects it's not running in a local environment.
- When used in production, it doesn't perform any auto-login or login page redirection. Instead, it displays an admin notice alerting administrators to remove the plugin from the mu-plugins folder for security reasons.
