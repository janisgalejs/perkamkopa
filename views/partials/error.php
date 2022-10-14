<?php if (isset($response['error'])): ?>
    <div class="alert alert-danger" role="alert">
        <?= $response['error'] ?>
    </div>
<?php endif ?>