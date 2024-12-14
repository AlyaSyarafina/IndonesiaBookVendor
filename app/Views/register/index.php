<?php echo form_open('register'); ?>

<h1>Register</h1>

<div class="form-group">
    <?= form_label('Username', 'username') ?>
    <?= form_input('username', set_value('username'), ['class' => 'form-control']) ?>
    <?= isset($errors['username']) ? "<div class='alert alert-danger'>{$errors['username']}</div>" : '' ?>
</div>

<div class="form-group">
    <?= form_label('Password', 'password') ?>
    <?= form_password('password', '', ['class' => 'form-control']) ?>
    <?= isset($errors['password']) ? "<div class='alert alert-danger'>{$errors['password']}</div>" : '' ?>
</div>

<div class="form-group">
    <?= form_label('Repeat Password', 'password_repeat') ?>
    <?= form_password('password_repeat', '', ['class' => 'form-control']) ?>
    <?= isset($errors['password_repeat']) ? "<div class='alert alert-danger'>{$errors['password_repeat']}</div>" : '' ?>
</div>

<div class="form-group">
    <?= form_label('Email', 'email') ?>
    <?= form_input('email', set_value('email'), ['class' => 'form-control']) ?>
    <?= isset($errors['email']) ? "<div class='alert alert-danger'>{$errors['email']}</div>" : '' ?>
</div>

<div class="form-group">
    <?= form_label('First Name', 'first_name') ?>
    <?= form_input('first_name', set_value('first_name'), ['class' => 'form-control']) ?>
    <?= isset($errors['first_name']) ? "<div class='alert alert-danger'>{$errors['first_name']}</div>" : '' ?>
</div>

<div class="form-group">
    <?= form_label('Last Name', 'last_name') ?>
    <?= form_input('last_name', set_value('last_name'), ['class' => 'form-control']) ?>
    <?= isset($errors['last_name']) ? "<div class='alert alert-danger'>{$errors['last_name']}</div>" : '' ?>
</div>

<div class="form-group">
    <?= form_label('Country', 'country') ?>
    <?= form_dropdown('country', $countries, set_value('country'), ['class' => 'form-control']) ?>
    <?= isset($errors['country']) ? "<div class='alert alert-danger'>{$errors['country']}</div>" : '' ?>
</div>

<div class="form-group">
    <?= form_submit('submit', 'Register', ['class' => 'btn btn-primary']) ?>
</div>

<?php echo form_close(); ?>
