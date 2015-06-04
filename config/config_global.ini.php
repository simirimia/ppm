;<?php
;die()
;?>

; repository type
repository_type     = redbean

; database configuration
picture_db_dsn              = "mysql:host=<DBHOST>;dbname=<DBNAME>"
picture_db_user             = <USER>
picture_db_password         = <PASSWORD>

user_db_dsn              = "mysql:host=<DBHOST>;dbname=<DBNAME>"
user_db_user             = <USER>
user_db_password         = <PASSWORD>

; storage folders
; webserver user needs write permission here
thumbnail_path      = /srv/www/ppm/thumbnails
log_path            = /var/log/ppm

; sorce folders
; webserver user nees read permission here
picture_source_path = /media/Pictures
