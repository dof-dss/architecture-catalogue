# NICS Architecture Catalogue

## Installation

### Pre-requisites (Mac)

#### Install [Homebrew](https://brew.sh/)

#### Install php

brew install php

#### Install mysql

brew install mysql

#### Install Laravel Installer

composer global require laravel/installer

Make sure to place Composer's system-wide vendor bin directory in your $PATH so the laravel executable can be located by your system.

macOS and GNU / Linux Distributions: $HOME/.composer/vendor/bin

#### Install Valet

composer global require laravel/valet

valet install

### Install project

git clone https://github.com/dof-dss/architecture-catalogue.git

npm install

## Deployment

### Local build

npm run dev

### Register the directory with Valet

Change into the architecture-catalogue directory.

valet park

### Local browser

https://catalogue.test
