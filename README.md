Aplikacja delegacje pozwala rozliczyć delegacje pracowników oraz przesłać dane do pliku. Wkrótce dostępna będzie integracja z system SAP
Delegation system allows your company to calculate all delegations of employees. Soon we plan to provide integration with SAP system

<h1>Installation</h1>

Download files and copy to destination folder.</br>
Create empty database.</br>
Import tables:</br>
<pre><code>mysql -u user_name -p db_name &lt; delegations.sql</code></pre>
Create directory:</br>
<pre>
cd my_project_name/
mkdir app/cache
mkdir app/logs</pre>
if exist:</br>
<pre>
rm -rf app/cache/*
rm -rf app/logs/*</pre>
Setting up Permissions:</br>
See Setting up Permissions section on:</br>
http://symfony.com/doc/current/book/installation.html</br>
Then run a composer update on command line:
<pre>php composer.phar update</pre>
Then install the required assets:
<pre>
php app/console assets:install
php app/console assetic:dump
</pre>
Clear cache:
<pre>php app/console cache:clear --no-debug</pre>
Login to application:</br>
link: your_localhost/login</br>
login: admin</br>
passwd: admin</br>
