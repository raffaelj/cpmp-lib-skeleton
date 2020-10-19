# CPMP lib skeleton

If you want to keep your docs root clean while using [CpMultiplane][2] with [Cockpit][1], you can use this skeleton to rearrange the file structure and to include them as a library. You can use cockpit like before - with some advantages:

* Add your own favicon to the root folder.
* Add your own files to the root without messing up the cockpit installation.
* You can use your root as an own git repository.

If you look for a Cockpit skeleton without CpMultiplane, have a look at the [cockpit-lib-skeleton][3], that I wrote a while ago.

## Intended use

This is a skeleton to start your own project. Don't clone this repository. Just download it, modify it and than run `git init` to create a version controlled project.

## Relevant files

Keep `index.php`, `bootstrap.php`, `defines.php` and `.htaccess.dist`. Also `cpdata/storage/data` must exist before you can run Cockpit or cli commands. You can remove the other files, if you don't need them for your workflow.

## File structure

After doing all steps described under [Installation](#installation), your file structure should look like this:

```text
.
├── cpdata
│   ├── addons
│   |   ├── CpMultiplaneGUI
│   |   ├── FormValidation
│   |   └── UniqueSlugs
│   ├── config
│   └── storage
│       ├── cache
│       ├── data
│       ├── thumbs
│       ├── tmp
│       └── uploads
├── lib
│   ├── cockpit
│   ├── CpMultiplane
│   └── vendor --> if installed via composer
├── themes
│   └── my-child-theme
│   .htaccess
│   bootstrap.php
│   cp
│   defines.php
│   index.php
│   mp
│   ...
```

## Installation

### manually

* Use this repository as a base or copy `index.php`, `bootstrap.php`, `defines.php`, `.htaccess.dist` and `cpdata/` to your project folder.
* Copy `.htaccess.dist` to `.htaccess`
* Download CpMultiplane and extract it to `lib/CpMultiplane`.
* Download Cockpit and extract it to `lib/cockpit`.
* Copy `lib/cockpit/cp` to `cp` and to `mp` so the cli commands from Cockpit and from CpMultiplane work from your root directory.
* Use the cli to create an admin user `./mp account/create --user admin --password admin --email admin@example.com`
* Install addons [CpMultiplaneGUI][4], [UniqueSlugs][5], [FormValidation][6].

### via git

I expect, that you use this repo as a base or that you copy `index.php`, `bootstrap.php`, `defines.php`, `.htaccess.dist` and `cpdata/` to your project folder.

```bash
cd ~/html
git clone https://github.com/agentejo/cockpit.git lib/cockpit
git clone https://github.com/raffaelj/CpMultiplane.git lib/CpMultiplane
git clone https://github.com/raffaelj/cockpit_CpMultiplaneGUI.git cpdata/addons/CpMultiplaneGUI
git clone https://github.com/raffaelj/cockpit_FormValidation.git cpdata/addons/FormValidation
git clone https://github.com/raffaelj/cockpit_UniqueSlugs.git cpdata/addons/UniqueSlugs
cp .htaccess.dist .htaccess
cp lib/cockpit/cp ./cp
cp ./cp ./mp
./mp account/create --user admin --password admin --email admin@example.com
```

### via composer and docker

#### from a bare directory

```bash
mkdir my-project
cd my-project
# composer create-project --ignore-platform-reqs raffaelj/cpmp-lib-skeleton .
composer create-project raffaelj/cpmp-lib-skeleton .

# create default admin user
./mp account/create --user admin --password admin --email admin@example.com
```

#### from this repository

This is for local development. I expect, that composer and docker are installed.

```bash
composer install --no-dev --ignore-platform-reqs
```

Create a `.env` file and change the user/group id to your needs.

```bash
docker-compose up -d
docker exec -it cpmp bash

# create default admin user
./mp account/create --user admin --password admin --email admin@example.com

# or run quickstart routine with dummy data
./mp multiplane/quickstart --template basic
./mp multiplane/create-dummy-data
```

## build

install dependencies:

`composer install` or `composer install --no-dev --ignore-platform-reqs`

update dependencies:

`composer update` or `composer update --no-dev --ignore-platform-reqs`

## Credits/License

Some files and snippets are copied from the core Cockpit CMS, author: Artur Heinze, www.agentejo.com, MIT License

Everything else: Raffael Jesche, www.rlj.me, MIT License

[1]: https://github.com/agentejo/cockpit/
[2]: https://github.com/raffaelj/CpMultiplane
[3]: https://github.com/raffaelj/cockpit-lib-skeleton
[4]: https://github.com/raffaelj/cockpit_CpMultiplaneGUI
[5]: https://github.com/raffaelj/cockpit_UniqueSlugs
[6]: https://github.com/raffaelj/cockpit_FormValidation
