<!-- =========================================================
     DEPARTMENTS / POSITIONS (Optimized, Fully Contained Layout)
========================================================= -->

<section
    id="dept-pos"
    class="card large hidden"
>

    <div class="department-position-wrapper">

        <!-- TOP SECTION: TWO CARDS FOR ADDITION PANELS / HEADERS -->
        <div class="dp-grid">

            <!-- DEPARTMENT CARD -->
            <div class="dp-card">

                <div style="display: flex; flex-direction: column; height: 100%;">
                    <div>
                        <div class="dp-card-header">
                            <h4>Departments</h4>
                            <span class="dp-badge">Management</span>
                        </div>

                        <!-- SEARCH BAR FOR DEPARTMENTS -->
                        <div style="margin-bottom: 12px; position: relative;">
                            <input
                                type="text"
                                id="dept-search"
                                placeholder="Search departments..."
                                onkeyup="filterDepartments()"
                                style="width: 100%; padding: 10px 14px; box-sizing: border-box; border: 1px solid var(--border-color, #e2e8f0); border-radius: 6px; font-size: 0.875rem; background-color: var(--input-bg, #f8fafc); outline: none; transition: border-color 0.2s, box-shadow 0.2s;"
                            >
                        </div>

                        <button
                            type="button"
                            class="btn secondary btn-add"
                            data-target="dept-form"
                            style="width: 100%; margin-bottom: 16px;"
                        >
                            + Add Department
                        </button>

                        <div
                            id="dept-form"
                            class="form-panel hidden"
                            style="margin-bottom: 16px; background: var(--panel-bg, #f1f5f9); padding: 12px; border-radius: 6px;"
                        >
                            <form
                                method="post"
                                action="actions.php"
                            >
                                <input
                                    type="hidden"
                                    name="action"
                                    value="add_department"
                                >

                                <label style="font-size: 0.85rem; font-weight: 500; display: block; margin-bottom: 4px;">
                                    Department name
                                    <input
                                        name="name"
                                        required
                                        placeholder="Enter department name..."
                                        style="margin-top: 4px; width: 100%; padding: 8px; border: 1px solid var(--border-color, #cbd5e1); border-radius: 4px;"
                                    >
                                </label>

                                <div style="margin-top: 10px; display: flex; gap: 8px;">
                                    <button
                                        class="btn primary small"
                                        type="submit"
                                    >
                                        Create
                                    </button>

                                    <button
                                        type="button"
                                        class="btn small secondary"
                                        data-action="cancel"
                                        data-target="dept-form"
                                    >
                                        Cancel
                                    </button>
                                </div>
                            </form>
                        </div>

                        <!-- EDIT DEPARTMENT FORM PANEL -->
                        <div
                            id="dept-edit-form"
                            class="form-panel hidden"
                            style="margin-bottom: 16px; background: var(--panel-bg, #f1f5f9); padding: 12px; border-radius: 6px;"
                        >
                            <form
                                method="post"
                                action="actions.php"
                            >
                                <input
                                    type="hidden"
                                    name="action"
                                    value="update_department"
                                >
                                <input
                                    type="hidden"
                                    name="id"
                                    id="edit-dept-id"
                                >

                                <label style="font-size: 0.85rem; font-weight: 500; display: block; margin-bottom: 4px;">
                                    Edit department name
                                    <input
                                        name="name"
                                        id="edit-dept-name"
                                        required
                                        placeholder="Enter department name..."
                                        style="margin-top: 4px; width: 100%; padding: 8px; border: 1px solid var(--border-color, #cbd5e1); border-radius: 4px;"
                                    >
                                </label>

                                <div style="margin-top: 10px; display: flex; gap: 8px;">
                                    <button
                                        class="btn primary small"
                                        type="submit"
                                    >
                                        Update
                                    </button>

                                    <button
                                        type="button"
                                        class="btn small secondary"
                                        data-action="cancel"
                                        data-target="dept-edit-form"
                                    >
                                        Cancel
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>

                    <!-- DEPARTMENT LIST VIEW (Contained with vertical scrolling) -->
                    <ul class="dp-list" id="dept-list-container" style="flex-grow: 1; overflow-y: auto; max-height: 320px; padding-right: 4px;">
                        <?php if (empty($depts)): ?>
                            <li class="dp-empty-state" style="text-align: center; color: var(--text-muted); padding: 20px 0;">No departments added yet.</li>
                        <?php else: ?>
                            <?php $i = 1; foreach ($depts as $d): ?>
                                <li class="dp-list-item" data-id="<?=$d['id']?>" data-name="<?=htmlspecialchars($d['name'], ENT_QUOTES)?>" data-search="<?=htmlspecialchars(strtolower($d['name']))?>" style="display: flex; justify-content: space-between; align-items: center; padding: 10px 12px; margin-bottom: 8px; background: var(--item-bg, #ffffff); border: 1px solid var(--border-color, #e2e8f0); border-radius: 6px;">
                                    <div class="dp-item-info">
                                        <span class="dp-item-title">
                                            <strong style="color: var(--text-muted); font-size: 0.8rem; margin-right: 6px;"><?=$i++?>.</strong>
                                            <?=htmlspecialchars($d['name'])?>
                                        </span>
                                    </div>

                                    <div class="dp-actions" style="display: flex; gap: 6px;">
                                        <button
                                            type="button"
                                            class="btn small secondary btn-edit-dept"
                                        >
                                            Edit
                                        </button>

                                        <form
                                            method="post"
                                            action="actions.php"
                                            class="inline-form"
                                            style="margin: 0;"
                                        >
                                            <input type="hidden" name="action" value="delete_department">
                                            <input type="hidden" name="id" value="<?=$d['id']?>">

                                            <button
                                                type="submit"
                                                class="btn small danger"
                                                onclick="return confirm('Delete department?')"
                                            >
                                                Delete
                                            </button>
                                        </form>
                                    </div>
                                </li>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </ul>

                    <div style="font-size: 0.75rem; color: var(--text-muted); text-align: right; border-top: 1px solid var(--border-color, #e2e8f0); padding-top: 10px; margin-top: 12px;">
                        Total: <?= count($depts) ?> department(s)
                    </div>
                </div>

            </div>


            <!-- POSITION CARD -->
            <div class="dp-card">

                <div style="display: flex; flex-direction: column; height: 100%;">
                    <div>
                        <div class="dp-card-header">
                            <h4>Positions</h4>
                            <span class="dp-badge">Hierarchy</span>
                        </div>

                        <!-- SEARCH BAR FOR POSITIONS -->
                        <div style="margin-bottom: 12px; position: relative;">
                            <input
                                type="text"
                                id="pos-search"
                                placeholder="Search positions..."
                                onkeyup="filterPositions()"
                                style="width: 100%; padding: 10px 14px; box-sizing: border-box; border: 1px solid var(--border-color, #e2e8f0); border-radius: 6px; font-size: 0.875rem; background-color: var(--input-bg, #f8fafc); outline: none; transition: border-color 0.2s, box-shadow 0.2s;"
                            >
                        </div>

                        <button
                            type="button"
                            class="btn secondary btn-add"
                            data-target="pos-form"
                            style="width: 100%; margin-bottom: 16px;"
                        >
                            + Add Position
                        </button>

                        <div
                            id="pos-form"
                            class="form-panel hidden"
                            style="margin-bottom: 16px; background: var(--panel-bg, #f1f5f9); padding: 12px; border-radius: 6px;"
                        >
                            <form
                                method="post"
                                action="actions.php"
                            >
                                <input
                                    type="hidden"
                                    name="action"
                                    value="add_position"
                                >

                                <label style="font-size: 0.85rem; font-weight: 500; display: block; margin-bottom: 4px;">
                                    Position name
                                    <input
                                        name="name"
                                        required
                                        placeholder="Enter position title..."
                                        style="margin-top: 4px; width: 100%; padding: 8px; border: 1px solid var(--border-color, #cbd5e1); border-radius: 4px;"
                                    >
                                </label>

                                <div style="margin-top: 10px; display: flex; gap: 8px;">
                                    <button
                                        class="btn primary small"
                                        type="submit"
                                    >
                                        Create
                                    </button>

                                    <button
                                        type="button"
                                        class="btn small secondary"
                                        data-action="cancel"
                                        data-target="pos-form"
                                    >
                                        Cancel
                                    </button>
                                </div>
                            </form>
                        </div>

                        <!-- EDIT POSITION FORM PANEL -->
                        <div
                            id="pos-edit-form"
                            class="form-panel hidden"
                            style="margin-bottom: 16px; background: var(--panel-bg, #f1f5f9); padding: 12px; border-radius: 6px;"
                        >
                            <form
                                method="post"
                                action="actions.php"
                            >
                                <input
                                    type="hidden"
                                    name="action"
                                    value="update_position"
                                >
                                <input
                                    type="hidden"
                                    name="id"
                                    id="edit-pos-id"
                                >

                                <label style="font-size: 0.85rem; font-weight: 500; display: block; margin-bottom: 4px;">
                                    Edit position name
                                    <input
                                        name="name"
                                        id="edit-pos-name"
                                        required
                                        placeholder="Enter position title..."
                                        style="margin-top: 4px; width: 100%; padding: 8px; border: 1px solid var(--border-color, #cbd5e1); border-radius: 4px;"
                                    >
                                </label>

                                <div style="margin-top: 10px; display: flex; gap: 8px;">
                                    <button
                                        class="btn primary small"
                                        type="submit"
                                    >
                                        Update
                                    </button>

                                    <button
                                        type="button"
                                        class="btn small secondary"
                                        data-action="cancel"
                                        data-target="pos-edit-form"
                                    >
                                        Cancel
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>

                    <!-- POSITION LIST VIEW (Contained with vertical scrolling) -->
                    <ul class="dp-list" id="pos-list-container" style="flex-grow: 1; overflow-y: auto; max-height: 320px; padding-right: 4px;">
                        <?php if (empty($positions)): ?>
                            <li class="dp-empty-state" style="text-align: center; color: var(--text-muted); padding: 20px 0;">No positions added yet.</li>
                        <?php else: ?>
                            <?php $j = 1; foreach ($positions as $p): ?>
                                <li class="dp-list-item" data-id="<?=$p['id']?>" data-name="<?=htmlspecialchars($p['name'], ENT_QUOTES)?>" data-search="<?=htmlspecialchars(strtolower($p['name']))?>" style="display: flex; justify-content: space-between; align-items: center; padding: 10px 12px; margin-bottom: 8px; background: var(--item-bg, #ffffff); border: 1px solid var(--border-color, #e2e8f0); border-radius: 6px;">
                                    <div class="dp-item-info">
                                        <span class="dp-item-title">
                                            <strong style="color: var(--text-muted); font-size: 0.8rem; margin-right: 6px;"><?=$j++?>.</strong>
                                            <?=htmlspecialchars($p['name'])?>
                                        </span>
                                    </div>

                                    <div class="dp-actions" style="display: flex; gap: 6px;">
                                        <button
                                            type="button"
                                            class="btn small secondary btn-edit-pos"
                                        >
                                            Edit
                                        </button>

                                        <form
                                            method="post"
                                            action="actions.php"
                                            class="inline-form"
                                            style="margin: 0;"
                                        >
                                            <input type="hidden" name="action" value="delete_position">
                                            <input type="hidden" name="id" value="<?=$p['id']?>">

                                            <button
                                                type="submit"
                                                class="btn small danger"
                                                onclick="return confirm('Delete position?')"
                                            >
                                                Delete
                                            </button>
                                        </form>
                                    </div>
                                </li>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </ul>

                    <div style="font-size: 0.75rem; color: var(--text-muted); text-align: right; border-top: 1px solid var(--border-color, #e2e8f0); padding-top: 10px; margin-top: 12px;">
                        Total: <?= count($positions) ?> position(s)
                    </div>
                </div>

            </div>

        </div>

    </div>

</section>

<script>
function filterDepartments() {
    let input = document.getElementById('dept-search').value.toLowerCase();
    let items = document.querySelectorAll('#dept-list-container .dp-list-item');
    items.forEach(item => {
        let name = item.getAttribute('data-search');
        if (name) {
            item.style.display = name.includes(input) ? 'flex' : 'none';
        }
    });
}

function filterPositions() {
    let input = document.getElementById('pos-search').value.toLowerCase();
    let items = document.querySelectorAll('#pos-list-container .dp-list-item');
    items.forEach(item => {
        let name = item.getAttribute('data-search');
        if (name) {
            item.style.display = name.includes(input) ? 'flex' : 'none';
        }
    });
}

document.addEventListener('click', function(e) {
    if (e.target.classList.contains('btn-edit-dept')) {
        let li = e.target.closest('.dp-list-item');
        document.getElementById('edit-dept-id').value = li.getAttribute('data-id');
        document.getElementById('edit-dept-name').value = li.getAttribute('data-name');
        document.getElementById('dept-edit-form').classList.remove('hidden');
        document.getElementById('dept-form').classList.add('hidden');
        document.getElementById('dept-edit-form').scrollIntoView({ behavior: 'smooth', block: 'nearest' });
    }

    if (e.target.classList.contains('btn-edit-pos')) {
        let li = e.target.closest('.dp-list-item');
        document.getElementById('edit-pos-id').value = li.getAttribute('data-id');
        document.getElementById('edit-pos-name').value = li.getAttribute('data-name');
        document.getElementById('pos-edit-form').classList.remove('hidden');
        document.getElementById('pos-form').classList.add('hidden');
        document.getElementById('pos-edit-form').scrollIntoView({ behavior: 'smooth', block: 'nearest' });
    }
});
</script>