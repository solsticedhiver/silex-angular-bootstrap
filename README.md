[![Build Status](https://travis-ci.org/afpa-stbrieuc/silex-angular-bootstrap.svg?branch=master)](https://travis-ci.org/afpa-stbrieuc/silex-angular-bootstrap)

[Release](/releases/latest)

# silex-angular-bootstrap
Sample init TODO project, built with:
  - PHP Silex as the backend. 
  - AngularJs. for client side
  - Sqlite for the database.
  - Grunt for livereloading, build and tests tasks
  - Travis configuration for continuous integration



##pre-requisite
npm, bower, grunt-cli, php composer, sqlite, php, sqlite pdo extension enabled


##install dev environment

```shell
  cd silex-angular-bootstrap
  npm install
  bower install
  composer install -d app/api
```


##development

```shell
  grunt serve
```

##build
```shell
  grunt
```
