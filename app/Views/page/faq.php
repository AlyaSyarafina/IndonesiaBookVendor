<?php
use yii\helpers\Html;
/* var $this yii\web\View */
?>

<h1>Frequently Asked Questions</h1>
<p>
	<strong>How do I search for books?</strong><br>
	You can search by entering a query in the top left quick search text box of the page. If you need more specific query such as the author, publisher, etc; use the "Search Book" menu item on the left. You can also browse for books by its subject, author, or publisher.
</p>
<p>
	<strong>Do I need to create an account to search for books?</strong><br>
	You do not need to create an account if you want to browse our collection. However, an account is needed should you like to order from us.
</p>
<p>
	<strong>I have registered, but I don't know the password to login to the page.</strong><br>
	When you register, a random password is generated and sent to your email for verification. You should check your email and login with that password. Then, we recommend you to change your password afterwards.
</p>
<p><strong>I'm still stuck</strong><br>Please <?= Html::a('Contact Us', ['page/contact-us']) ?>.</p>