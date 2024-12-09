# Flash Messages!
It's not just ordinary flash messages you usually see. It... flashes... and..
OH! you can control it!

It's much better because you can:
- Add multiple messages, each with their own state. \
  Eg. `error`, `warning`, then add `warning` again.

- Scoped. \
  You can now scope the message itself!

- Custom placement.

## Usage

To use this package, all you need to do is `use`  `FlashMessages` from
`PNDevworks\Deps\Services`, and initialize the class. If you have specific
scope/namespace/channel for this particular instance, you can provide it from
the contructor.

```php
use PNDevworks\FlashMessages\Services\FlashMessages;
$flashMessage = new FlashMessages();
$flashMessage->addMessage("warning", "A wild Exception appeared!");
$flashMessage->addMessage("info", "DEV used RUBBER-DUCK.");
$flashMessage->addMessage("success", "It's super effective!");
$flashMessage->addMessage("info", "EXP +100");

// for specific channel:
$flashMsgSQL = new FlashMessages("SQLRunner");
$flashMsgSQL->addMessage("info", sprintf(
    "SQL runs for %.2f seconds, %d rows affected.", 
    $timeDiff, 
    $rows->count()
  )
);
```

Then to show it on your page, you can use the [view function with Namespaced
Views](https://codeigniter4.github.io/userguide/outgoing/views.html#namespaced-views).

```php
<?= view('PNDevworks\FlashMessages\Views\ShowMessage') ?>
// Will show this in order, all in Bootstrap 4 alert component:
// - (Warning)  A wild Exception appeared!
// - (info)  DEV used RUBBER-DUCK.
// - (success)  It's super effective!
// - (info)  EXP +100

// Or, by specifying the channel name
<?= view('PNDevworks\FlashMessages\Views\ShowMessage', ['msgChannel'=>'SQLRunner']) ?>
// Will show this in order, all in Bootstrap 4 alert component:
// SQL runs for 17.03 seconds, 109824803287 rows affected.
```

## Install

First you need to follow the GitLab's Guide to authenticate with this group's
Composer registry.

Ref:
- https://docs.gitlab.com/ee/user/packages/composer_repository/#install-a-composer-package
- https://getcomposer.org/doc/articles/authentication-for-private-packages.md#gitlab-token

Then you can install this package by following the guide from the package
registry:

https://gl.dnartworks.co.id/PNDevworks/deps/flash-messages/-/packages

## Documentation
_TBD_.
