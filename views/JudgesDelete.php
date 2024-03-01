<?php

namespace PHPMaker2024\project2;

// Page object
$JudgesDelete = &$Page;
?>
<script>
var currentTable = <?= JsonEncode($Page->toClientVar()) ?>;
ew.deepAssign(ew.vars, { tables: { judges: currentTable } });
var currentPageID = ew.PAGE_ID = "delete";
var currentForm;
var fjudgesdelete;
loadjs.ready(["wrapper", "head"], function () {
    let $ = jQuery;
    let fields = currentTable.fields;

    // Form object
    let form = new ew.FormBuilder()
        .setId("fjudgesdelete")
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
<form name="fjudgesdelete" id="fjudgesdelete" class="ew-form ew-delete-form" action="<?= CurrentPageUrl(false) ?>" method="post" novalidate autocomplete="off">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="judges">
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
<?php if ($Page->judgeID->Visible) { // judgeID ?>
        <th class="<?= $Page->judgeID->headerCellClass() ?>"><span id="elh_judges_judgeID" class="judges_judgeID"><?= $Page->judgeID->caption() ?></span></th>
<?php } ?>
<?php if ($Page->name->Visible) { // name ?>
        <th class="<?= $Page->name->headerCellClass() ?>"><span id="elh_judges_name" class="judges_name"><?= $Page->name->caption() ?></span></th>
<?php } ?>
<?php if ($Page->courtTyep->Visible) { // courtTyep ?>
        <th class="<?= $Page->courtTyep->headerCellClass() ?>"><span id="elh_judges_courtTyep" class="judges_courtTyep"><?= $Page->courtTyep->caption() ?></span></th>
<?php } ?>
<?php if ($Page->Address->Visible) { // Address ?>
        <th class="<?= $Page->Address->headerCellClass() ?>"><span id="elh_judges_Address" class="judges_Address"><?= $Page->Address->caption() ?></span></th>
<?php } ?>
<?php if ($Page->state->Visible) { // state ?>
        <th class="<?= $Page->state->headerCellClass() ?>"><span id="elh_judges_state" class="judges_state"><?= $Page->state->caption() ?></span></th>
<?php } ?>
<?php if ($Page->Emptype->Visible) { // Emptype ?>
        <th class="<?= $Page->Emptype->headerCellClass() ?>"><span id="elh_judges_Emptype" class="judges_Emptype"><?= $Page->Emptype->caption() ?></span></th>
<?php } ?>
<?php if ($Page->created_at->Visible) { // created_at ?>
        <th class="<?= $Page->created_at->headerCellClass() ?>"><span id="elh_judges_created_at" class="judges_created_at"><?= $Page->created_at->caption() ?></span></th>
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
<?php if ($Page->judgeID->Visible) { // judgeID ?>
        <td<?= $Page->judgeID->cellAttributes() ?>>
<span id="">
<span<?= $Page->judgeID->viewAttributes() ?>>
<?= $Page->judgeID->getViewValue() ?></span>
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
<?php if ($Page->courtTyep->Visible) { // courtTyep ?>
        <td<?= $Page->courtTyep->cellAttributes() ?>>
<span id="">
<span<?= $Page->courtTyep->viewAttributes() ?>>
<?= $Page->courtTyep->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->Address->Visible) { // Address ?>
        <td<?= $Page->Address->cellAttributes() ?>>
<span id="">
<span<?= $Page->Address->viewAttributes() ?>>
<?= $Page->Address->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->state->Visible) { // state ?>
        <td<?= $Page->state->cellAttributes() ?>>
<span id="">
<span<?= $Page->state->viewAttributes() ?>>
<?= $Page->state->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->Emptype->Visible) { // Emptype ?>
        <td<?= $Page->Emptype->cellAttributes() ?>>
<span id="">
<span<?= $Page->Emptype->viewAttributes() ?>>
<?= $Page->Emptype->getViewValue() ?></span>
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
