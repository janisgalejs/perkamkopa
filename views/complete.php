<?php include views_path('layout/header') ?>

<!-- page content -->
<div class="text-center h-100 d-flex align-items-center justify-content-center">
    <div class="row">
        <div class="col">
            <h1 class="pb-3">Paldies, <?= $response['username'] ?>!</h1>
            <p>Tu atbildēji pareizi uz <?= $response['correct_answers'] ?> no <?= $response['number_of_questions'] ?> jautājumiem.</p>
        </div>
    </div>
</div>
<!-- END: page content -->

<?php include views_path('layout/footer') ?>