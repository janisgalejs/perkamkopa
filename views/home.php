<?php include views_path('layout/header') ?>

<!-- page content -->
<div class="text-center h-100 d-flex align-items-center justify-content-center">
    <div class="row">
        <div class="col">
            <h1 class="pb-3">Testa uzdevums</h1>

            <?php include views_path('partials/error') ?>

            <form method="post" action="" class="align-items-center">
                <div class="row mb-3">
                    <div class="col">
                        <input type="text" name="name" class="form-control" placeholder="Ievadiet savu vārdu" required="required" value="<?= $response['name'] ?? '' ?>">
                    </div>
                </div>

                <div class="row mb-3">
                    <div class="col">
                        <select name="test_id" class="form-select" required="required">
                            <option selected disabled="disabled">Izvēlieties testu</option>
                            <?php if (isset($response['tests'])): ?>
                                <?php foreach ($response['tests'] as $test): ?>
                                    <option value="<?= $test['id'] ?>" <?= (isset($response['test']) && $response['test'] == $test['id']) ? 'selected' : '' ?>><?= $test['title'] ?></option>
                                <?php endforeach ?>
                            <?php endif ?>
                        </select>
                    </div>
                </div>

                <div class="row mb-3">
                    <div class="col">
                        <button type="submit" class="btn btn-primary">Sākt</button>
                    </div>
                </div>

            </form>
        </div>
    </div>
</div>
<!-- END: page content -->

<?php include views_path('layout/footer') ?>