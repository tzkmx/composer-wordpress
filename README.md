# WordPress Composer Installation

Base configuration for install and deploy WordPress sites using composer

The structure for your WordPress instalation will be:

    /.env             -> edit in this file the most common config constants
    /vendor           -> You shouldn't touch anything here, 3rd party libraries
    /public
    /public/cms       -> the WordPress installation dir (managed by composer)
    /public/index.php -> custom WordPress bootstrap file
    /public/media -> the WordPress wp-content directory
    /app/config/environments/{development,production,...}.php extra configuration

It uses [WordPress Packagist](https://wpackagist.org/) in order to manage your plugins, themes and other php dependencies

## How to start

### Step1: Instalation

**Requirements:**
* PHP5.6 or greater

**Create your project:**

```bash
composer create-project jefrancomix/wordpress-composed your_directory_name "dev-master"
```

**Set the WordPress permissions:**
```bash
# Configure the wp-content/uploads permissions
# https://codex.wordpress.org/Changing_File_Permissions
chmod -R 755 public/wp-content/uploads
```
 
### Step2: Configuration
 
Copy .env.example to .env and customize your parameters

### Configure the rest of conventional wp-config parameters

By default a file in ``app/config/environments/development.php`` is customizable,
  if you need to customize extra vars, you can create other files in that dir,
  and load it setting the WP_ENV in your custom ``.env`` file to the given name.
