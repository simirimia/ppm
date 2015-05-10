    package {
      [
      "joe",
      "curl",
      "git",
      "nodejs",
      "npm",
      "nginx",
      "php5-fpm",
      "php5",
      "php5-mysql",
      "php5-gd",
      "php5-cli",
      "php5-xdebug",
      "mysql-server"
    ]:
        ensure => present
    }

    # PPM setup
    exec { 'ppm-setup-marker-create':
        command      => '/usr/bin/touch /vagrant/config/setup_in_progress___remove_me',
        require => File['/vagrant/log/ppm.log']
    }

    file { '/vagrant/config/setup_in_progress___remove_me':
        ensure => 'absent',
        require => [ Exec["ppm-example-user"],
                     Exec['ppm-example-data-import']
                     ]
    }

    exec { 'ppm-example-data':
        command      => '/usr/bin/git clone https://github.com/simirimia/ppm-example-pictures.git /vagrant/media/examples; /usr/bin/touch /vagrant/media/examples/ppm-example-created',
        creates      => '/vagrant/media/examples/ppm-example-created',
        require => Package["git"]
    }

    exec { 'ppm-example-data-import':
        command => '/usr/bin/php /vagrant/public/rest/index.php POST /rest/pictures/scan; /usr/bin/php /vagrant/public/rest/index.php POST /rest/pictures/extract-exif; /usr/bin/php /vagrant/public/rest/index.php POST /rest/pictures/thumbnails/create;',
        require => [  Exec['ppm-example-data'],
                      File["/vagrant/config/config_local.ini.php"],
                      Exec["database-init"],
                      Exec["ppm-setup-marker-create"],
                      Exec["composer-install-packages"],
                      File["/vagrant/log/ppm.log"],
                      Package["php5-cli"]
                    ]
    }

    exec { 'ppm-example-user':
        command      => '/usr/bin/php /vagrant/public/rest/index.php POST /rest/users \'{"email":"user@ppm.local","password":"user","firstName":"Example","lastName":"User"}\'; /usr/bin/touch /vagrant/config/ppm-example-user-created ',
        require => [    File["/vagrant/config/config_local.ini.php"],
                        Exec["database-init"],
                        Exec["ppm-setup-marker-create"],
                        Exec["composer-install-packages"],
                        File["/vagrant/log/ppm.log"],
                        Package["php5-cli"]
         ],
        creates => '/vagrant/config/ppm-example-user-created'
    }

    file { '/vagrant/config/config_local.ini.php':
        ensure => file,
        content => '
;<?php
;die()
;?>

; database configuration
db_dsn              = "mysql:host=localhost;dbname=ppm"
db_user             = ppm
db_password         = ppm-dev-only-pw

; storage folders
; webserver user needs write permission here
thumbnail_path      = /vagrant/thumbnails
log_path            = /vagrant/log

; sorce folders
; webserver user needs read permission here
picture_source_path = "/vagrant/media"
        ',
    }


    file { '/vagrant/log':
        ensure => directory,
        owner => 'vagrant',
        group => 'www-data',
        mode => '770',
    }

    file { '/vagrant/log/ppm.log':
      ensure => file,
      owner => 'vagrant',
      group => 'www-data',
      mode => '660',
      require => File['/vagrant/log']
    }

    file { '/vagrant/media':
        ensure => directory,
        owner => 'vagrant',
        group => 'www-data',
        mode => '750',
    }

    file { '/vagrant/thumbnails':
        ensure => directory,
        owner => 'vagrant',
        group => 'www-data',
        mode => '770',
    }

    # composer
    exec { 'composer-install-self':
        command      => '/usr/bin/curl -sS https://getcomposer.org/installer | /usr/bin/php -- --install-dir=/usr/local/bin --filename=composer',
        require => Package["php5-cli","curl"],
        creates => '/usr/local/bin/composer'
    }
    exec { 'composer-install-packages':
        command => "/usr/local/bin/composer install",
        cwd => "/vagrant",
        user => "vagrant",
        environment => [ "COMPOSER_HOME=/usr/local/bin" ],
        require => [ Exec["composer-install-self"],
                     Package["git"]
                     ]
    }

    # bower
    exec { 'bower-install-self':
        command => "/usr/bin/npm install -g bower",
        require => Package["npm","nodejs"],
        creates => "/usr/local/bin/bower"
    }
    exec { 'bower-install-packages':
        command      => '/usr/local/bin/bower --allow-root install',
        cwd => "/vagrant/public",
        #user => "vagrant", 
        require => File["/usr/bin/node"]
    }
    file { '/usr/bin/node':
        ensure => "Link",
        target => "/usr/bin/nodejs",
        require => Package["nodejs"]
    }

    # mysql
    service { 'mysql':
        require => Package["mysql-server"],
        enable      => true,
        ensure      => running,
    }
    exec { 'database-init':
        command      => "/usr/bin/mysql -u root -e \"CREATE DATABASE IF NOT EXISTS ppm;\";
                         /usr/bin/mysql -u root -e \"GRANT ALL ON ppm.* to 'ppm'@'localhost' IDENTIFIED BY 'ppm-dev-only-pw';\";
                         /usr/bin/touch /root/ppm-database-initialized",
        path => "/root",
        creates => '/root/ppm-database-initialized',
        require => Service["mysql"]
    }

    # nginx
    service { "nginx":
        require => Package["nginx"],
        ensure => running,
        enable => true
    }

    file { "/etc/nginx/sites-enabled/default":
    	require => [
    		Package["nginx"]
    	],
    	ensure => "absent",
    	notify => Service["nginx"]
    }

    file { "/etc/nginx/sites-available/ppm":
        require => [
            Package["nginx"]
        ],
        ensure => "file",
        content => '
server {
    listen 80 default_server;

    root /vagrant/public;

    index index.html;

    server_name localhost;

    location / {
        try_files $uri $uri/ =404;
    }

    location /rest {
        try_files $uri $uri/ /rest/index.php?$query_string;
    }

    location /thumbnail {
        try_files $uri $uri/ /thumbnail/index.php?$query_string;
    }

    location /original {
        try_files $uri $uri/ /original/index.php?$query_string;
    }

    location ~ \.php$ {
        fastcgi_split_path_info ^(.+\.php)(/.+)$;
        fastcgi_pass unix:/var/run/php5-fpm.sock;
        fastcgi_index index.php;
        include fastcgi.conf;
    }
}
        '
    }

    file { "/etc/nginx/sites-enabled/ppm":
        require => File["/etc/nginx/sites-available/ppm"],
        ensure => "link",
        target => "/etc/nginx/sites-available/ppm",
        notify => Service["nginx"]
    }

    # PHP
    file { '/etc/php5/mods-available/xdebug.ini':
        ensure => 'file',
        content => '
[XDEBUG]
zend_extension=xdebug.so
xdebug.remote_port=9000
xdebug.default_enable=1
xdebug.remote_connect_back=1
xdebug.remote_enable=1
xdebug.remote_handler=dbgp
xdebug.remote_port=9000
xdebug.remote_autostart=1
        ',
        notify => Service["php5-fpm"]
    }

    service { "php5-fpm":
      require => Package["php5-fpm"],
      ensure => running,
      enable => true
    }
