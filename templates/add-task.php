<?= include_template('side.php', [
    'projects' => $projects,
    'project_id' => '',
]); ?>

<main class="content__main">
    <h2 class="content__main-heading">Добавление задачи</h2>

    <form class="form"  action="add-task.php" method="post" autocomplete="off" enctype="multipart/form-data">
        <div class="form__row">
            <label class="form__label" for="name">Название <sup>*</sup></label>
            <?php $error_name = isset($errors['name']) ? "form__input--error" : "" ?>
            <input class="form__input <?= $error_name; ?>" type="text" name="name" id="name" value="<?= $task_name ?>" placeholder="Введите название">
            <?php if (isset($errors['name'])) : ?>
                <p class="form__message"><?= $errors['name'] ?></p>
            <?php endif ?>
        </div>

        <div class="form__row">
            <label class="form__label" for="project">Проект <sup>*</sup></label>

            <?php $error_project = isset($errors['project_id']) ? "form__input--error" : "" ?>
            <select class="form__input form__input--select <?= $error_project; ?>" name="project_id" id="project">

                <?php foreach ($projects as $project): ?>
                    <option value="<?=htmlspecialchars($project["id"]);?>" <?= ($project_id == $project["id"]) ? 'selected' : '' ?>>
                        <?=htmlspecialchars($project["name"]);?>
                    </option>
                <?php endforeach; ?>
            </select>
            <?php if (isset($errors['project_id'])) : ?>
                <p class="form__message"><?= $errors['project_id'] ?></p>
            <?php endif ?>
<!--            --><?//= $errors['project_id'] = $errors['project_id'] ? '<p class="form__message">'. $errors['project_id'] . '</p>' : '' ?>
        </div>

        <div class="form__row">
            <label class="form__label" for="date">Дата выполнения</label>
            <?php $error_date = isset($errors['date_make']) ? "form__input--error" : "" ?>
            <input class="form__input form__input--date  <?= $error_date; ?>" type="text" name="date_make" id="date" value="" placeholder="Введите дату в формате ГГГГ-ММ-ДД">

            <?php if (isset($errors['date_make'])) : ?>
                <p class="form__message"><?= $errors['date_make'] ?></p>
            <?php endif ?>

        </div>

        <div class="form__row">
            <label class="form__label" for="file">Файл</label>

            <div class="form__input-file">
                <input class="visually-hidden" type="file" name="file" id="file" value="">

                <label class="button button--transparent" for="file">
                    <span>Выберите файл</span>
                </label>
            </div>
        </div>

        <div class="form__row form__row--controls">
            <input class="button" type="submit" name="" value="Добавить">
        </div>
    </form>
</main>
