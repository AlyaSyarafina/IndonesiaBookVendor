<?php

namespace PNDevworks\FlashMessages\Views;
// Flashmessage Prehead. This will checks default params given to this lib.

use PNDevworks\FlashMessages\Services\FlashMessages;

// Checks wether default messageChannel is provided.
$flashMsg = new FlashMessages();
if (isset($msgChannel)) {
    $flashMsg = new FlashMessages($msgChannel);
}


?>
<?php foreach ($flashMsg->getMessages() as $msg) : ?>
    <div class="alert alert-<?= $msg['type'] ?>">
        <?= $msg['message'] ?>
    </div>
<?php endforeach; ?>