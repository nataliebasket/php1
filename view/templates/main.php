<?= include_template('side.php', [
    'projects' => $projects,
    'project_id' => $project_id,
]); ?>

<main class="content__main">
    <h2 class="content__main-heading">Список задач</h2>

    <form class="search-form" action="index.php" method="post" autocomplete="off">
        <input class="search-form__input" type="text" name="" value="" placeholder="Поиск по задачам">

        <input class="search-form__submit" type="submit" name="" value="Искать">
    </form>

    <div class="tasks-controls">
        <nav class="tasks-switch">
            <a href="/" class="tasks-switch__item tasks-switch__item--active">Все задачи</a>
            <a href="/" class="tasks-switch__item">Повестка дня</a>
            <a href="/" class="tasks-switch__item">Завтра</a>
            <a href="/" class="tasks-switch__item">Просроченные</a>
        </nav>

        <label class="checkbox">
            <!--добавить сюда атрибут "checked", если переменная $show_complete_tasks равна единице-->
            <input class="checkbox__input visually-hidden show_completed" type="checkbox" <?php if ($show_complete_tasks): ?> checked <?php endif; ?>>
            <span class="checkbox__text">Показывать выполненные</span>
        </label>
    </div>

    <table class="tasks">
        <?php foreach ($tasks as $key => $value): ?>
            <?php if ($value['name']): ?>
                <tr class="tasks__item task <?= ($value['is_done'])? "task--completed": "" ?>
                    <?php if ($value['date_make']): ?><?php if (isDateImportant($value['date_make'])): ?>task--important<?php endif; ?><?php endif; ?>">
                    <td class="task__select">
                        <label class="checkbox task__checkbox">
                            <input class="checkbox__input visually-hidden" type="checkbox" <?= ($value['is_done'])? "checked": "" ?>>
                            <span class="checkbox__text"><?=htmlspecialchars($value['name']);?><?= isDateImportant($value['date_make']);?></span>
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
