# Ansible Role for PHP Telegram Bot

<!-- [![Build Status][1]][2] -->

**This project is still a work in progress, use at your own risk! For now, you will most probably have to explore the code to understand what this role does exactly.**

Installs and configures [PHP Telegram Bots][php-telegram-bot] on Debian/Ubuntu servers.
This role uses the [PHP Telegram Bot Manager][php-telegram-bot-manager] project and makes use of [`vlucas/phpdotenv`][phpdotenv] for all configurable values.

**Note:** This role does not install any web or database server!
It assumes that you have a functioning web server with PHP and composer installed.

There are two different ways this role will work for you:
**A basic default bot**
This method installs a very basic bot into your defined working directory.
All parameters are passed directly using the `php_telegram_bot_bots` array.

**An existing project that exists in a git repository**
When you already have an existng project that makes use of the [PHP Telegram Bot Manager][php-telegram-bot-manager], you can simply define the path to your git repository using the `project_repo` (and `project_repo_branch`) parameters in the `php_telegram_bot_bots` array.

## Requirements

- git (can be installed using the [`geerlingguy.git`][geerlingguy.git] role)
- Composer (can be installed using the [`geerlingguy.composer`][geerlingguy.composer] role)

**Webserver**
You can use whatever you want. You just need to create a site/vhost that points to the correct root of the Telegram Bot directories.
I recommend using Nginx, which can be installed easily with the [`geerlingguy.nginx`][geerlingguy.nginx] role.

**Database**
To use the database for your bot(s), make sure you have a functioning connection to the database server.
If it's on the same machine, you can use the the [`geerlingguy.mysql`][geerlingguy.mysql] role.
For any external server, you just need to be able to access the database with your credentials.

## Role Variables

```
php_telegram_bot_composer_package: noplanman/telegram-bot-manager
php_telegram_bot_composer_version: ''
php_telegram_bot_mysql_structure: vendor/php-telegram-bot/structure.sql

php_telegram_bot_websrv_user: www-data
php_telegram_bot_websrv_group: www-data

php_telegram_bot_bots: []

# php_telegram_bot_bots:
#   # Simple bot (minimal)
#   - api_key: 12345:api_key
#     working_dir: /var/www/simplebot_minimal
#
#   # Simple bot (with db)
#   - api_key: 12345:api_key
#     bot_username: my_bot
#     working_dir: /var/www/simplebot_with_db
#     mysql:
#       host: localhost
#       user: root
#       password: root
#       database: db
#
#   # Simple bot (with webhook)
#   - api_key: 12345:api_key
#     bot_username: my_bot
#     working_dir: /var/www/simplebot_with_webhook
#     secret: super-secret
#     webhook:
#       url: my.webhook.url
#
#   # Project bot (with webhook)
#   - api_key: 12345:api_key
#     bot_username: my_bot
#     project_repo: https://projectrepo.git
#     project_dotenv: prod.env.j2
#     working_dir: /var/www/projectbot
#     secret: super-secret
#     webhook:
#       url: project.webhook.url
#     mysql:
#       host: db.server
#       user: root
#       password: root
#       database: db
#       structure: my-custom-db-structure.sql
```

Available fields for `php_telegram_bot_bots` entry are the ones available for the [PHP Telegram Bot Manager][php-telegram-bot-manager]. Simply use YAML format to define variables in the same structure as the [`manager.php`][manager.php-example] parameters array.

## Role Hooks

This role has hooks before and after each section.

```yaml
php_telegram_bot_hooks_before_install: my-hook.yml
php_telegram_bot_hooks_after_install: my-hook.yml
php_telegram_bot_hooks_before_database: my-hook.yml
php_telegram_bot_hooks_after_database: my-hook.yml
php_telegram_bot_hooks_before_webhook: my-hook.yml
php_telegram_bot_hooks_after_webhook: my-hook.yml
```

## Role Tags

Each part of the setup has a tag.

```
php_telegram_bot:install   # Installation of all bots.
php_telegram_bot:database  # Set up the databases.
php_telegram_bot:webhook   # Set the webhooks.
```

## Dependencies

None.

## Example Playbook

```
---
- hosts: www-server
  become: yes
  roles:
    - php-telegram-bot.php-telegram-bot
```

## License

MIT

[1]: https://travis-ci.org/php-telegram-bot/ansible-role-php-telegram-bot.svg?branch=master "Travis-CI Build Status"
[2]: https://travis-ci.org/php-telegram-bot/ansible-role-php-telegram-bot "Travis-CI Tests"
[php-telegram-bot]: https://github.com/php-telegram-bot/ "PHP Telegram Bot"
[php-telegram-bot-manager]: https://github.com/php-telegram-bot/telegram-bot-manager "PHP Telegram Bot Manager"
[manager.php-example]: https://github.com/php-telegram-bot/example-bot/blob/master/manager.php "manager.php example"
[phpdotenv]: https://github.com/vlucas/phpdotenv/ "phpdotenv"
[geerlingguy.git]: https://github.com/geerlingguy/ansible-role-git "Git Ansible role"
[geerlingguy.composer]: https://github.com/geerlingguy/ansible-role-composer "Composer Ansible role"
[geerlingguy.nginx]: https://github.com/geerlingguy/ansible-role-nginx "Nginx Ansible role"
[geerlingguy.mysql]: https://github.com/geerlingguy/ansible-role-mysql "MySQL Ansible role"
