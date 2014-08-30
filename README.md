vo-tee
======

Project consists of two pages
* application form for submitting an image of type JPEG, PSD, AI, EPS and PDF
* overview page collecting and showing all submitted images in an endless scroll mode

* Created for [http://gli.tc/h/](http://gli.tc/h/)
* Running (but submission is closed) on [http://votee.vincentbruijn.nl](http://votee.vincentbruijn.nl)

## Prerequisites
* PHP Imagick extension
* Folders uploads and data should be chmod 777
* Create a database using the SQL file in the data directory. Change the database name to your liking.
* Change db credentials in conf.php
* The data directory might also be used by the program for logging to a system.log file.


![](https://raw.github.com/y-a-v-a/vo-tee/master/votee-screenshot.jpg)