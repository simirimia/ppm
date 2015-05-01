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
    ]:
        ensure => present
    }

    # composer
    exec { 'composer-install-self':
        command      => '/usr/bin/curl -sS https://getcomposer.org/installer | /usr/bin/php -- --install-dir=/usr/local/bin --filename=composer',
        require => Package["php5-cli","curl","git"],
        creates => '/usr/local/bin/composer'
    }
    exec { 'composer-install-packages':
        command => "/usr/local/bin/composer install",
        cwd => "/vagrant",
        user => "vagrant",
        environment => [ "COMPOSER_HOME=/usr/local/bin" ],
        require => Exec["composer-install-self"],
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
        require => Exec["bower-install-self"]
    }

    # nginx configuration

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
        ',
        notify => Service["nginx"]
    }

    file { "/etc/nginx/sites-enabled/ppm":
        require => File["/etc/nginx/sites-available/ppm"],
        ensure => "link",
        target => "/etc/nginx/sites-available/ppm",
        notify => Service["nginx"]
    }