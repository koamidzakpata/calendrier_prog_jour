        <div class="row">
            <div class="col-sm-6">
                <div class="form-group">
                    <label for="nom">Titre</label>
                    <input id="nom" type="text" required class="form-control" name="nom" value="<?= isset($data['nom']) ? h($data['nom']) : ' '; ?>">
                    <?php if (isset($errors['nom'])): ?>
                        <p class="help-block"><?= $errors['nom']; ?></p>
                    <?php endif; ?>
                </div>
            </div>
            <div class="col-sm-6">
                <div class="form-group">
                    <label for="date">Date</label>
                    <input id="date" type="date" required class="form-control" name="date" value="<?= isset($data['date']) ? h($data['date']) : ' '; ?>">
                    <?php if (isset($errors['date'])): ?>
                        <p class="help-block"><?= $errors['date']; ?></p>
                    <?php endif; ?>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-6">
                <div class="form-group">
                    <label for="début">Démarage</label>
                    <input id="début" type="time" required class="form-control" name="début" placeholder="HH:MM " value="<?= isset($data['début']) ? h($data['début']) : ' '; ?>">
                    <?php if (isset($errors['début'])): ?>
                        <small class="form-text text-muted"><?= $errors['début']; ?></small>
                    <?php endif; ?>
                </div>
            </div>
            <div class="col-sm-6">
                <div class="form-group">
                    <label for="fin">Fin</label>
                    <input id="fin" type="time" required class="form-control" name="fin" placeholder="HH:MM " value="<?= isset($data['fin']) ? h($data['fin']) : ' '; ?>">
                </div>
            </div>
        </div>
        <div class="form-group">
            <label for="description">Description</label>
            <textarea id="description" class="form-control" name="description" <?= isset($data['description']) ? h($data['description']) : ' '; ?>></textarea>
        </div>