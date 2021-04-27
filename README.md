# nova-launch

[![Latest Stable Version](https://poser.pugx.org/dnwjn/nova-launch/v)](//packagist.org/packages/dnwjn/nova-launch) [![Total Downloads](https://poser.pugx.org/dnwjn/nova-launch/downloads)](//packagist.org/packages/dnwjn/nova-launch) [![Latest Unstable Version](https://poser.pugx.org/dnwjn/nova-launch/v/unstable)](//packagist.org/packages/dnwjn/nova-launch) [![License](https://poser.pugx.org/dnwjn/nova-launch/license)](//packagist.org/packages/dnwjn/nova-launch)

**nova-launch** is a Laravel Nova tool for the pre-launch and launch phases of your website.
It redirects visitors, allows bypasses and launches your website whenever you say the word.

## ℹ️ Introduction

I was working on a project with a friend when I took on the task of implementing some sort of
functionality for disabling the website for visitors while allowing admins to still access it.
Furthermore, the site had to be launchable from within Nova.

Well, I created that functionality and kept refining it until I thought: *maybe I should extract this from
the project and wrap it in its own package?*

So, I give you: **nova-launch**. It does the following:
* Disable the website for visitors by redirecting them to a single page (which is completely
  configurable by the developer). By default this page shows some basic information and a
  sign up form (table, model and store functionality are also included by default, because to me
  this seemed to be the most interesting functionality).
* Allow admins or people that know the secret (if enabled) full access to the website.
* Launch the website via Nova or the `php artisan nova-launch:launch` command.
* Dispatch an event after launch, because you might want to do more after that!
* Completely disable itself after launch to lower the impact from multiple checks on each request.

> *This is my very first package, so suggestions and tips for me to improve this or future packages
> are welcome!*

## 🖥 Requirements

| What     | Version |
| -------- | ------- |
| PHP      | \>=7.2  |
| Laravel  | \>=6.0  |
| Nova     | \>=2.0  |

## 🚀 Installation

1. Install the package via Composer:
    ```
   composer require dnwjn/nova-launch
    ```
   The service provider will automatically be registered.

1. Publish the resources:
    ```
   php artisan vendor:publish --provider="Dnwjn\NovaLaunch\NovaLaunchServiceProvider" --tag="minimal"
   ```
   The `minimal` tag only publishes the elements required by the package to work.
   See the table [below](#publishing) for an overview of what can be published.
1. Run the migrations:
   ```
   php artisan migrate
   ```
1. Edit the configuration file `config/nova-launch.php` to your likings. The most important parts here are:
   1. the `routes` configuration;
   1. the `models.user` configuration.

## 📢 Publishing

The following tags can be used during publishing. This is done in the same way as in step 1 of the
installation process:

```
php artisan vendor:publish --provider="Dnwjn\NovaLaunch\NovaLaunchServiceProvider" --tag="<tag>"
```

| Tag            | Publishes                       |
| -------------- | ------------------------------- |
| `minimal`      | config file and public files    |
| `public`       | public files                    |
| `translations` | translations (for visitor view) |
| `styles`       | stylesheets (for visitor view)  |
| `views`        | views (for visitor view)        |

## 🛠 Testing

You can run tests with the following command:
```
composer run test
```

**Note:** tests are now very basic but more will be added in the future.

## 🔄 Changelog

Please see [CHANGELOG.md](CHANGELOG.md) for information on what has changed.

## 📜 License

This package uses the MIT License (MIT). Please see [LICENSE.md](LICENSE.md) for more information.
