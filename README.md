Aplikacja delegacje pozwala rozliczyć delegacje pracowników oraz przesłać dane do pliku. Wkrótce dostępna będzie integracja z system SAP<br />
Delegation system allows your company to calculate all delegations of employees. Soon we plan to provide integration with SAP system

<h1>Installation</h1>

Download files and copy to destination folder.<br>
Create empty database.<br>
Open your command console and execute the following commands.<br>
Create directory:<br>
<pre>
$ cd my_project_name/<br>
$ mkdir app/cache<br>
$ mkdir app/logs</pre>
or if exist:<br>
<pre>
$ rm -rf app/cache/*<br>
$ rm -rf app/logs/*</pre>
Setting up Permissions:<br>
See: <a href="http://symfony.com/doc/current/book/installation.html#checking-symfony-application-configuration-and-setup">Setting up Permissions section</a><br>
Then run a composer update on command line:
<pre>$ php composer.phar update</pre>
Import tables:<br>
<pre><code>$ mysql -u user_name -p db_name &lt; delegations.sql</code></pre>
or you can also create the database tables schema from entities:<br>
<pre><code>
$ php app/console doctrine:schema:update --force<br>
$ php app/console delegation:db:add-data<br>
</code></pre>
More on: <a href="http://symfony.com/doc/current/book/doctrine.html#creating-the-database-tables-schema">Creating the Database Tables/Schema</a><br>
Then install the required assets:
<pre>
$ php app/console assets:install<br>
$ php app/console assetic:dump
</pre>
Clear cache:<br>
<pre>$ php app/console cache:clear --no-debug</pre>
Login to application:<br>
link: your_localhost/login<br>
login: admin<br>
passwd: admin<br>

Below screenshots from application<br>
<br>![alt text](http://www.tercom.pl/delegacje/delegation_create_screen.png "Create new delegation")<br>
<br>![alt text](http://www.tercom.pl/delegacje/add_user.png "Add user")<br>
<br>![alt text](http://www.tercom.pl/delegacje/delegation_list.png "Delegation list")<br>
<br>![alt text](http://www.tercom.pl/delegacje/delegation_type_list.png "Delegation type list")<br>
<br>![alt text](http://www.tercom.pl/delegacje/expenditure_list.png "Expenditure type list")<br>
<br>![alt text](http://www.tercom.pl/delegacje/users_list.png "Users list")<br>
