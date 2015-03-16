Aplikacja delegacje pozwala rozliczyć delegacje pracowników oraz przesłać dane do pliku.<br />
1. Rozliczanie delegacji na podstawie realnych kosztów (brak diet)<br />
2. Rozliczanie "kilometrówki"<br />
3. Możliwość definiowania własnych rodzajów kosztów<br />
4. Definiowanie oddziałów firmy<br />
5. Eksport do pliku<br />
6. Całkowicie za darmo<br />

Delegation system allows your company to calculate all delegations of employees.

<h1>Installation</h1>

Download files and copy to destination folder.<br>
Create empty database.<br>
Open your command console and execute the following commands.<br>
Create directory:<br>
<pre>
$ cd my_project_name/<br>
$ mkdir app/cache<br>
$ mkdir app/logs<br>
$ mkdir web/logo</pre>
or if exist:<br>
<pre>
$ rm -rf app/cache/*<br>
$ rm -rf app/logs/*</pre>
Setting up Permissions based on Symfony documentation:<br>
See: <a href="http://symfony.com/doc/current/book/installation.html#checking-symfony-application-configuration-and-setup">Setting up Permissions section</a><br>
Set permission for logo directory:<br><br>
<pre>
$ chmod 777 web/logo
</pre>
<br>

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
<br>
___
<h5>Below screenshots from application</h5><br />
![Create new delegation](http://www.tercom.pl/delegacje/delegation_create_screen.png)<br>
<br>![Add user](http://www.tercom.pl/delegacje/add_user.png)<br>
<br>![Delegation list](http://www.tercom.pl/delegacje/delegation_list.png)<br>
<br>![Delegation type list](http://www.tercom.pl/delegacje/delegation_type_list.png)<br>
<br>![Expenditure type list](http://www.tercom.pl/delegacje/expenditure_list.png)<br>
<br>![Users list](http://www.tercom.pl/delegacje/users_list.png)<br>

***
<h4>Enterprise version</h4>
There is also enterprise version available with more features:<br>
1. SAP integration.<br> 
2. Workflow which allows to set validator users who need to validate user delegations.<br>
3. Show delegations of other users. You can select which user delegation you want to see. Option only available for users with special access right added by admin.<br>
4. Reports and charts.<br>
<br>
If you are interested in enterprise version please contact us at<br>
```
Usługi Informatyczne TER-ART Wojciech Terpiłowski
Dekoracyjna 3
65-155 Zielona Góra
Polska
VAT ID PL9730454764
terart@terart.pl
tel. 0048 501437601
```
