Aplikacja delegacje pozwala rozliczyć delegacje pracowników oraz przesłać dane do systemu SAP

<h1>Installation</h1>

Download files and copy to destination folder.
Create empty database.
Import tables:
<pre>
mysql -u <user_name> -p <db_name> < delegations.sql
</pre>

Create directory:
<pre>
    cd my_project_name/
    mkdir app/cache
    mkdir app/logs
</pre>

if exist:

<pre>
    rm -rf app/cache/*
    rm -rf app/logs/*
</pre>

Setting up Permissions:
See Setting up Permissions section on http://symfony.com/doc/current/book/installation.html

Then run a composer update on command line:

<pre>php composer.phar update</pre>

Then install the required assets:
<pre>
 php app/console assets:install
 php app/console assetic:dump
</pre>

Clear cache:
<pre>
php app/console cache:clear --no-debug
</pre>

Login to application:
link: <your_localhost>/login
login: admin
passwd: admin