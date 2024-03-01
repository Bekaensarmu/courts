<?php

namespace PHPMaker2024\project2;

// Page object
$CourtsDelete = &$Page;
?>
<script>
var currentTable = <?= JsonEncode($Page->toClientVar()) ?>;
ew.deepAssign(ew.vars, { tables: { courts: currentTable } });
var currentPageID = ew.PAGE_ID = "delete";
var currentForm;
var fcourtsdelete;
loadjs.ready(["wrapper", "head"], function () {
    let $ = jQuery;
    let fields = currentTable.fields;

    // Form object
    let form = new ew.FormBuilder()
        .setId("fcourtsdelete")
        .setPageId("delete")
        .build();
    window[form.id] = form;
    currentForm = form;
    loadjs.done(form.id);
});
</script>
<script>
loadjs.ready("head", function () {
    // Write your table-specific client script here, no need to add script tags.
});
</script>
<?php $Page->showPageHeader(); ?>
<?php
$Page->showMessage();
?>
<form name="fcourtsdelete" id="fcourtsdelete" class="ew-form ew-delete-form" action="<?= CurrentPageUrl(false) ?>" method="post" novalidate autocomplete="off">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="courts">
<input type="hidden" name="action" id="action" value="delete">
<?php foreach ($Page->RecKeys as $key) { ?>
<?php $keyvalue = is_array($key) ? implode(Config("COMPOSITE_KEY_SEPARATOR"), $key) : $key; ?>
<input type="hidden" name="key_m[]" value="<?= HtmlEncode($keyvalue) ?>">
<?php } ?>
<div class="card ew-card ew-grid <?= $Page->TableGridClass ?>">
<div class="card-body ew-grid-middle-panel <?= $Page->TableContainerClass ?>" style="<?= $Page->TableContainerStyle ?>">
<table class="<?= $Page->TableClass ?>">
    <thead>
    <tr class="ew-table-header">
<?php if ($Page->courtID->Visible) { // courtID ?>
        <th class="<?= $Page->courtID->headerCellClass() ?>"><span id="elh_courts_courtID" class="courts_courtID"><?= $Page->courtID->caption() ?></span></th>
<?php } ?>
<?php if ($Page->name->Visible) { // name ?>
        <th class="<?= $Page->name->headerCellClass() ?>"><span id="elh_courts_name" class="courts_name"><?= $Page->name->caption() ?></span></th>
<?php } ?>
<?php if ($Page->workType->Visible) { // workType ?>
        <th class="<?= $Page->workType->headerCellClass() ?>"><span id="elh_courts_workType" class="courts_workType"><?= $Page->workType->caption() ?></span></th>
<?php } ?>
<?php if ($Page->yetefekedebizat->Visible) { // yetefekedebizat ?>
        <th class="<?= $Page->yetefekedebizat->headerCellClass() ?>"><span id="elh_courts_yetefekedebizat" class="courts_yetefekedebizat"><?= $Page->yetefekedebizat->caption() ?></span></th>
<?php } ?>
<?php if ($Page->yale->Visible) { // yale ?>
        <th class="<?= $Page->yale->headerCellClass() ?>"><span id="elh_courts_yale" class="courts_yale"><?= $Page->yale->caption() ?></span></th>
<?php } ?>
<?php if ($Page->yegodele->Visible) { // yegodele ?>
        <th class="<?= $Page->yegodele->headerCellClass() ?>"><span id="elh_courts_yegodele" class="courts_yegodele"><?= $Page->yegodele->caption() ?></span></th>
<?php } ?>
<?php if ($Page->created_at->Visible) { // created_at ?>
        <th class="<?= $Page->created_at->headerCellClass() ?>"><span id="elh_courts_created_at" class="courts_created_at"><?= $Page->created_at->caption() ?></span></th>
<?php } ?>
<?php if ($Page->updated_at->Visible) { // updated_at ?>
        <th class="<?= $Page->updated_at->headerCellClass() ?>"><span id="elh_courts_updated_at" class="courts_updated_at"><?= $Page->updated_at->caption() ?></span></th>
<?php } ?>
<?php if ($Page->updated_by->Visible) { // updated_by ?>
        <th class="<?= $Page->updated_by->headerCellClass() ?>"><span id="elh_courts_updated_by" class="courts_updated_by"><?= $Page->updated_by->caption() ?></span></th>
<?php } ?>
    </tr>
    </thead>
    <tbody>
<?php
$Page->RecordCount = 0;
$i = 0;
while ($Page->fetch()) {
    $Page->RecordCount++;
    $Page->RowCount++;

    // Set row properties
    $Page->resetAttributes();
    $Page->RowType = RowType::VIEW; // View

    // Get the field contents
    $Page->loadRowValues($Page->CurrentRow);

    // Render row
    $Page->renderRow();
?>
    <tr <?= $Page->rowAttributes() ?>>
<?php if ($Page->courtID->Visible) { // courtID ?>
        <td<?= $Page->courtID->cellAttributes() ?>>
<span id="">
<span<?= $Page->courtID->viewAttributes() ?>>
<?= $Page->courtID->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->name->Visible) { // name ?>
        <td<?= $Page->name->cellAttributes() ?>>
<span id="">
<span<?= $Page->name->viewAttributes() ?>>
<?= $Page->name->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->workType->Visible) { // workType ?>
        <td<?= $Page->workType->cellAttributes() ?>>
<span id="">
<span<?= $Page->workType->viewAttributes() ?>>
<?= $Page->workType->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->yetefekedebizat->Visible) { // yetefekedebizat ?>
        <td<?= $Page->yetefekedebizat->cellAttributes() ?>>
<span id="">
<span<?= $Page->yetefekedebizat->viewAttributes() ?>>
<?= $Page->yetefekedebizat->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->yale->Visible) { // yale ?>
        <td<?= $Page->yale->cellAttributes() ?>>
<span id="">
<span<?= $Page->yale->viewAttributes() ?>>
<?= $Page->yale->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->yegodele->Visible) { // yegodele ?>
        <td<?= $Page->yegodele->cellAttributes() ?>>
<span id="">
<span<?= $Page->yegodele->viewAttributes() ?>>
<?= $Page->yegodele->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->created_at->Visible) { // created_at ?>
        <td<?= $Page->created_at->cellAttributes() ?>>
<span id="">
<span<?= $Page->created_at->viewAttributes() ?>>
<?= $Page->created_at->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->updated_at->Visible) { // updated_at ?>
        <td<?= $Page->updated_at->cellAttributes() ?>>
<span id="">
<span<?= $Page->updated_at->viewAttributes() ?>>
<?= $Page->updated_at->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->updated_by->Visible) { // updated_by ?>
        <td<?= $Page->updated_by->cellAttributes() ?>>
<span id="">
<span<?= $Page->updated_by->viewAttributes() ?>>
<?= $Page->updated_by->getViewValue() ?></span>
</span>
</td>
<?php } ?>
    </tr>
<?php
}
$Page->Recordset?->free();
?>
</tbody>
</table>
</div>
</div>
<div class="ew-buttons ew-desktop-buttons">
<button class="btn btn-primary ew-btn" name="btn-action" id="btn-action" type="submit"><?= $Language->phrase("DeleteBtn") ?></button>
<button class="btn btn-default ew-btn" name="btn-cancel" id="btn-cancel" type="button" data-href="<?= HtmlEncode(GetUrl($Page->getReturnUrl())) ?>"><?= $Language->phrase("CancelBtn") ?></button>
</div>
</form>
<?php
$Page->showPageFooter();
echo GetDebugMessage();
?>
<script>
loadjs.ready("load", function () {
    // Write your table-specific startup script here, no need to add script tags.
});
</script>
