<?= include_template('side.php', [
    'projects' => $projects,
    'project_id' => $project_id,
]); ?>

<main class="content__main">
    <h2 class="content__main-heading">Список задач</h2>

    <form class="search-form" action="index.php" method="get" autocomplete="off">
        <input class="search-form__input" type="text" name="text_search" value="<?= isset($user_search)? $user_search: "" ?>" placeholder="Поиск по задачам">

        <input class="search-form__submit" type="submit" name="" value="Искать">
    </form>

    <div class="tasks-controls">
        <nav class="tasks-switch">
            <a href="/index.php" class="tasks-switch__item <?= (!$task_filter) ? 'tasks-switch__item--active' : '' ?>">Все задачи</a>
            <a href="/index.php?task_filter=today" class="tasks-switch__item <?= $task_filter === 'today' ? 'tasks-switch__item--active' : '' ?>">Повестка дня</a>
            <a href="/index.php?task_filter=tomorrow" class="tasks-switch__item <?= $task_filter === 'tomorrow' ? 'tasks-switch__item--active' : '' ?>">Завтра</a>
            <a href="/index.php?task_filter=overdue" class="tasks-switch__item <?= $task_filter === 'overdue' ? 'tasks-switch__item--active' : '' ?>">Просроченные</a>
        </nav>

        <label class="checkbox">
            <input class="checkbox__input visually-hidden show_completed" type="checkbox" <?= $show_complete_tasks ? 'checked' : '' ?> >
            <span class="checkbox__text">Показывать выполненные</span>
        </label>
    </div>

    <table class="tasks">
        <?php foreach ($tasks as $key => $value): ?>
            <?php if (($value['name']) && !($value['is_done'])) : ?>
                <tr class="tasks__item task <?= ($value['is_done'])? "task--completed": "" ?>
                    <?= ($value['date_make']) && (isDateImportant($value['date_make'])) ? 'task--important' : '' ?>">
                    <td class="task__select">
                        <label class="checkbox task__checkbox">
                            <input class="checkbox__input visually-hidden task__checkbox" type="checkbox" <?= ($value['is_done'])? 'checked': '' ?> value="<?= $value['id'] ?>">
                            <span class="checkbox__text"><?= htmlspecialchars($value['name']); ?></span>
                        </label>
                    </td>

                    <?php if ($value['date_make']): ?>
                        <td class="task__date"><?= date( "Y-m-d", strtotime($value['date_make'])); ?></td>
                    <?php else: ?>
                        <td class="task__date"></td>
                    <?php endif; ?>

                    <td class="task__controls">
                    </td>
                </tr>
            <?php endif ?>

            <?php if (($value['name']) && ($show_complete_tasks) && $value['is_done']) : ?>
                <tr class="tasks__item task <?= $value['is_done'] ? "task--completed": "" ?>
                    ">
                    <td class="task__select">
                        <label class="checkbox task__checkbox">
                            <input class="checkbox__input visually-hidden task__checkbox" type="checkbox" <?= ($value['is_done']) ? "checked" : "" ?> value="<?= $value['id'] ?>">
                            <span class="checkbox__text"><?=htmlspecialchars($value['name']);?></span>
                        </label>
                    </td>

                    <?php if ($value['date_make']): ?>
                        <td class="task__date"><?=date( "Y-m-d", strtotime($value['date_make']));?></td>
                    <?php else: ?>
                        <td class="task__date"></td>
                    <?php endif; ?>
                    <td class="task__controls">
                    </td>
                </tr>
            <?php endif ?>

        <?php endforeach; ?>
    </table>
</main>
