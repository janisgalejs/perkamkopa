<?php include views_path('layout/header') ?>

<!-- page content -->
<div class="text-center h-100 d-flex align-items-center justify-content-center">
    <div class="row">
        <div class="col">
            <h1 class="pb-3"><?= $response['question']['title'] ?></h1>

            <?php include views_path('partials/error') ?>

            <form method="post" action="" class="align-items-center">

                <div class="row mb-3 text-start">
                    <?php foreach ($response['answers'] as $answer): ?>
                        <div class="form-check">
                            <input name="answer" class="form-check-input" type="radio" value="<?= $answer['id'] ?>" id="answer<?= $answer['id'] ?>">
                            <label class="form-check-label" for="answer<?= $answer['id'] ?>">
                                <?= $answer['title'] ?>
                            </label>
                        </div>
                    <?php endforeach ?>
                </div>

                <div class="row mb-3">
                    <div class="col">
                        <div class="progress">
                            <div class="progress-bar" role="progressbar" aria-label="Progress" style="width: <?= $response['progress'] ?>%" aria-valuenow="<?= $response['progress'] ?>" aria-valuemin="0" aria-valuemax="100"></div>
                        </div>
                    </div>
                </div>

                <div class="row mb-3">
                    <div class="col">
                        <input type="hidden" name="continue" value="true">
                        <button type="submit" class="btn btn-primary">Nākamais</button>
                    </div>
                </div>

            </form>
        </div>
    </div>
</div>
<!-- END: page content -->

<?php include views_path('layout/footer') ?>