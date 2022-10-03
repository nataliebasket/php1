<tr class="tasks__item task <?= ($value['status'])? "task--completed": "" ?>
<?php if ($value['date']): ?><?php if (isDateImportant($value['date'])): ?>task--important<?php endif; ?><?php endif; ?>">
    <td class="task__select">
        <label class="checkbox task__checkbox">
            <input class="checkbox__input visually-hidden" type="checkbox" <?= ($value['status'])? "checked": "" ?>>
            <span class="checkbox__text"><?=htmlspecialchars($value['name']);?></span>
        </label>
    </td>

    <?php if ($value['date']): ?>
        <td class="task__date"><?=($value['date']);?></td>
    <?php else: ?>
        <td class="task__date"></td>
    <?php endif; ?>
    <td class="task__controls">
    </td>
</tr>
