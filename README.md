[![Build Status](https://travis-ci.org/afpa-stbrieuc/silex-angular-bootstrap.svg?branch=master)](https://travis-ci.org/afpa-stbrieuc/silex-angular-bootstrap)



# silex-angular-bootstrap
Sample init TODO project, built with:
  - PHP Silex as the backend. ( use routing with yml config files )
  - AngularJs. for client side
  - Sqlite for the database.
  - Grunt for livereloading, build and tests tasks
  - Travis configuration for continuous integration

This app is inspired by `yeoman` angular generator and several projects i don't remember of ( sorry ).

##pre-requisite for development
  - [npm](https://www.npmjs.com/) for grunt dependencies
  - [bower](http://bower.io/) ( `npm install -g bower` ) for assets management
  - [php composer](https://getcomposer.org/) for server side php api
  - `grunt-cli` ( `npm install -g grunt-cli`) as the tasks runner
  - `sqlite` driver and enabled in php.ini


##install

```shell
  git clone https://github.com/afpa-stbrieuc/silex-angular-bootstrap
  cd silex-angular-bootstrap
  npm install
  bower install
  composer install -d app/api
```


##development

You can use grunt (`npm install -g grunt-cli`) for live-reloading

```shell
  grunt serve
```

##build
```shell
  grunt
```

##launch from release
  - download the latest [Release](/releases/latest)
  in the project directory launch the php embedded http server
```shell
  php -S localhost:8000 -t . api/app.php
```

