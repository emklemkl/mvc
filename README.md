MVC course repoo
=====

## About this repo
This repo is my solution to the problems presented in the MVC course from the program "Webbprogrammering" at Blekinge Tekniska Högskola. The main idea is to learn about web related object oriented programming using the Model View Controller design. This repo contains the result ive produced while doing the tasks the course required. My Examination project is a short web based game where the goal is to escape capture from an enchanted cave.

## To use this repo
Assuming you have set up SSH-keys (otherwise, just do it!), run:
```
    git clone git@github.com:emklemkl/mvcreport.git
```
To run it locally you might have to update wepack.config.js by setting .setPublicPath to:
```
    .setPublicPath('/build')
```
To run it on a student server set it to:
```
    .setPublicPath('/~emkl21/dbwebb-kurser/mvc/me/report/public/build')
```
To start the program locally run:
```
    npm start
```

## Testing and CI
[![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/emklemkl/mvcreport/badges/quality-score.png?b=main)](https://scrutinizer-ci.com/g/emklemkl/mvcreport/?branch=main)
[![Code Coverage](https://scrutinizer-ci.com/g/emklemkl/mvcreport/badges/coverage.png?b=main)](https://scrutinizer-ci.com/g/emklemkl/mvcreport/?branch=main)
[![Build Status](https://scrutinizer-ci.com/g/emklemkl/mvcreport/badges/build.png?b=main)](https://scrutinizer-ci.com/g/emklemkl/mvcreport/build-status/main)
[![Code Intelligence Status](https://scrutinizer-ci.com/g/emklemkl/mvcreport/badges/code-intelligence.svg?b=main)](https://scrutinizer-ci.com/code-intelligence)    