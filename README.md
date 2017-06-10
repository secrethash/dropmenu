DropMenu - Drop Down Menu
=======

[![GitHub license](https://img.shields.io/badge/license-MIT-blue.svg?style=flat-square)](https://raw.githubusercontent.com/secrethash/dropmenu/master/LICENSE) [![Travis](https://img.shields.io/travis/secrethash/dropmenu.svg?style=flat-square)](https://github.com/secrethash/dropmenu) [![Packagist](https://img.shields.io/packagist/dt/secrethash/dropmenu.svg?style=flat-square)](https://packagist.org/packages/secrethash/dropmenu) [![Packagist](https://img.shields.io/packagist/v/secrethash/dropmenu.svg?style=flat-square)](https://packagist.org/packages/secrethash/dropmenu) [![GitHub release](https://img.shields.io/github/release/secrethash/dropmenu.svg?style=flat-square)](https://packagist.org/packages/secrethash/dropmenu)

***Socialize:***

[![Twitter Follow](https://img.shields.io/twitter/follow/secrethash.svg?style=social&label=Follow&style=flat-square)](https://twitter.com/secrethash) [![Twitter](https://img.shields.io/twitter/url/https/github.com/secrethash/dropmenu.svg?style=social&style=flat-square)](https://twitter.com/intent/tweet?text=Wow:&url=%5Bobject%20Object%5D)

**DropMenu** is a Database driven, Dynamic Drop Down Menu Package for ***Laravel 5+*** . DropMenu is Currently under development so it would be greatful of you to co-operate with it. But as it's an opensource project you are free to contribute.

We are working on it constantly to make things right and get things on the right track. Bear with us just for some time. :)

> *FEEL FREE TO CONTRIBUTE TO THIS PROJECT BY  **FORKING, CREATING A PULL REQUEST, CREATING AN ISSUE, ETC.**. I'll be glad to answer them.*

---

# Installation
For a Stable Release:
```
composer require secrethash/dropmenu
```
For the Development Version:
```
composer require secrethash/dropmenu:dev-master
```

---

# Configurations
You will need to update you `config\app.php` file to make it work.

### Service Provider
Add the below line in your `providers` array

```php
        Secrethash\Dropmenu\DropmenuServiceProvider::class,
```

### Facade
To access Dropmenu using `Dropmenu` facade instead of `Secrethash\Dropmenu`, you will need to update the `aliases` array.
Add the below line in the `aliases` array:

```php
        'Dropmenu' => Secrethash\Dropmenu\DropmenuFacade::class,
```

---

# Migration
### Generation
You can generate migration to migrate the database. The migration will create a ***'menus'*** database following the structure requirements of `secrethash/dropmenu`. The command for creating the migration file is:
```haskell
php artisan dropmenu:migrate
```
### Migrate
The above command creates the migration file in `database\migrations` directory. From there you will need to migrate using the `migrate` command.
```haskell
php artisan migrate
```
Once the migration is completed, you are ready to seed your database with the menu data. Create menus and play around with it. Let me know if something goes wrong.

---

**AGAIN:**
> *FEEL FREE TO CONTRIBUTE TO THIS PROJECT BY  **FORKING, CREATING A PULL REQUEST, CREATING AN ISSUE, ETC.**. I'll be glad to answer them.*

# Clearing Some Basics
Some basics needs to be cleared out before you work on/with this package.

- It Creates Bootstarp menus.
- Dynamic Drop Down Menus can be created using it.
- Database Table `menus`:
	- `ID` The unique identifier.
	- `parent_id`It will be defined if a sub-menu is created. `ID` of the parent menu item will be the value here.
	- `name` Name to display.
	- `order_by` Comes handy when creating multiple menu items of same hierarchy level.
	- `link` Value supplied to the `<a href="">` of the menu item.
	- `link_attr` Any extra Attributes of the Link. Like `target="_blank"`.
	- `icon` Icon Class Code supplied to the `<i class="">`. If using font-awesome, use full class code that is to be provided in `<i>`, like `fa fa-code`.
	- `type` It is used to distinguish multiple menus. For example there is a Main nav menu and Sidebar Nav Menu. So different names can be alloted to both.
	- `auth`Authentication Level can be defined here. Here `1=Authenticated Users Only, 2=Unauthenticated Users Only, 0=Both User Groups`

# Displaying the Menu
The menu can be displayed by using the following function:
```php
Dropmenu::display($type);
```
The `$type` is the value provided in the `type` column in the database table. For Example: main:nav or sidebar or sidebar:nav or main:foot, etc.
