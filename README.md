<h1>ToDoList</h1>
<a href="https://www.codacy.com/app/Thibok/TodoList?utm_source=github.com&amp;utm_medium=referral&amp;utm_content=Thibok/TodoList&amp;utm_campaign=Badge_Grade"><img src="https://api.codacy.com/project/badge/Grade/2e0a6b56f9604fa0a1c19370c1b5995d"/></a>
<p>Welcome on the ToDoList project ! This project was realized under <strong>Symfony 3.4</strong>.
This project is for my training at Openclassroom on the DA PHP/Symfony path.This is my eighth project, for which i must to improve an existing site under <strong>Symfony</strong></p>
<h2>Prerequisites</h2>
<ul>
  <li>7.3</li>
  <li>Mysql</li>
  <li>Apache</li>
  <li>Yarn or npm</li>
  <li>Node.js</li>
</ul>
<h2>Libraries</h2>
<ul>
  <li>Bootstrap</li>
  <li>JQuery</li>
  <li>Recaptcha</li>
</ul>
<h2>Framework</h2>
<ul>
  <li>Symfony</li>
</ul>
<h2>ORM</h2>
<ul>
  <li>Doctrine</li>
</ul>
<h2>Bundles</h2>
<ul>
  <li>Doctrine Fixtures Bundle</li>
  <li>Webpack Encore Bundle</li>
</ul>
<h2>Installation</h2>
<h4>Clone project :</h4>
<pre>git clone https://github.com/Thibok/TodoList.git</pre>
<h4>Install dependencies :</h4>
<p>For the captcha secret key required during composer install, you can pick up your keys at this <a href="https://www.google.com/recaptcha/intro/v3.html">address</p></a>
<p>To edit the captcha public key, go in app/Resources/views/macros/_form_elements.html.twig and set it in data-sitekey attribut</p>
<pre>composer install</pre>
<h4>Create database :</h4>
<pre>php bin/console doctrine:database:create</pre>
<h4>Update schema :</h4>
<pre>php bin/console doctrine:schema:update --force</pre>
<h4>Install assets</h4>
<p>Run yarn or npm install command</p>
<pre>yarn install</pre>
<p>Load assets</p>
<pre>yarn encore dev</pre>
<h4>Load fixtures :</h4>
<pre>php bin/console doctrine:fixture:load</pre>
<h4>Run It !</h4>
<p>Now you can start your server with this :</p>
<pre>php bin/console server:start</pre>
<strong>And go on the local address !</strong>
<h2>Tests</h2>
<p>If you need run tests :</p> 
<h4>Create test database :</h4>
<pre>php bin/console doctrine:database:create --env=test</pre>
<h4>Update schema :</h4>
<pre>php bin/console doctrine:schema:update --force --env=test</pre>
<h4>Load test fixtures :</h4>
<pre>php bin/console doctrine:fixture:load --env="test"</pre>
<h4>Run tests !</h4>
<pre>vendor/bin/phpunit</pre>
<h2>Production</h2>
<p>If you want to use production environment, don't forget :</p>
<h4>Clear cache :</h4>
<pre>php bin/console cache:clear --env="prod"</pre>
<h4>Dump assets</h4>
<pre>yarn encore production</pre>