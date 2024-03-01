<?php

namespace PHPMaker2024\project2;

// Page object
$DecisionsDelete = &$Page;
?>
<script>
var currentTable = <?= JsonEncode($Page->toClientVar()) ?>;
ew.deepAssign(ew.vars, { tables: { decisions: currentTable } });
var currentPageID = ew.PAGE_ID = "delete";
var currentForm;
var fdecisionsdelete;
loadjs.ready(["wrapper", "head"], function () {
    let $ = jQuery;
    let fields = currentTable.fields;

    // Form object
    let form = new ew.FormBuilder()
        .setId("fdecisionsdelete")
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
<form name="fdecisionsdelete" id="fdecisionsdelete" class="ew-form ew-delete-form" action="<?= CurrentPageUrl(false) ?>" method="post" novalidate autocomplete="off">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="decisions">
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
<?php if ($Page->decisionDate->Visible) { // decisionDate ?>
        <th class="<?= $Page->decisionDate->headerCellClass() ?>"><span id="elh_decisions_decisionDate" class="decisions_decisionDate"><?= $Page->decisionDate->caption() ?></span></th>
<?php } ?>
<?php if ($Page->Decisiontype->Visible) { // Decisiontype ?>
        <th class="<?= $Page->Decisiontype->headerCellClass() ?>"><span id="elh_decisions_Decisiontype" class="decisions_Decisiontype"><?= $Page->Decisiontype->caption() ?></span></th>
<?php } ?>
<?php if ($Page->kistype->Visible) { // kistype ?>
        <th class="<?= $Page->kistype->headerCellClass() ?>"><span id="elh_decisions_kistype" class="decisions_kistype"><?= $Page->kistype->caption() ?></span></th>
<?php } ?>
<?php if ($Page->ez->Visible) { // ez ?>
        <th class="<?= $Page->ez->headerCellClass() ?>"><span id="elh_decisions_ez" class="decisions_ez"><?= $Page->ez->caption() ?></span></th>
<?php } ?>
<?php if ($Page->chilot->Visible) { // chilot ?>
        <th class="<?= $Page->chilot->headerCellClass() ?>"><span id="elh_decisions_chilot" class="decisions_chilot"><?= $Page->chilot->caption() ?></span></th>
<?php } ?>
<?php if ($Page->Description->Visible) { // Description ?>
        <th class="<?= $Page->Description->headerCellClass() ?>"><span id="elh_decisions_Description" class="decisions_Description"><?= $Page->Description->caption() ?></span></th>
<?php } ?>
<?php if ($Page->created_at->Visible) { // created_at ?>
        <th class="<?= $Page->created_at->headerCellClass() ?>"><span id="elh_decisions_created_at" class="decisions_created_at"><?= $Page->created_at->caption() ?></span></th>
<?php } ?>
<?php if ($Page->updated_at->Visible) { // updated_at ?>
        <th class="<?= $Page->updated_at->headerCellClass() ?>"><span id="elh_decisions_updated_at" class="decisions_updated_at"><?= $Page->updated_at->caption() ?></span></th>
<?php } ?>
<?php if ($Page->updated_by->Visible) { // updated_by ?>
        <th class="<?= $Page->updated_by->headerCellClass() ?>"><span id="elh_decisions_updated_by" class="decisions_updated_by"><?= $Page->updated_by->caption() ?></span></th>
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
<?php if ($Page->decisionDate->Visible) { // decisionDate ?>
        <td<?= $Page->decisionDate->cellAttributes() ?>>
<span id="">
<span<?= $Page->decisionDate->viewAttributes() ?>>
<?= $Page->decisionDate->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->Decisiontype->Visible) { // Decisiontype ?>
        <td<?= $Page->Decisiontype->cellAttributes() ?>>
<span id="">
<span<?= $Page->Decisiontype->viewAttributes() ?>>
<?= $Page->Decisiontype->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->kistype->Visible) { // kistype ?>
        <td<?= $Page->kistype->cellAttributes() ?>>
<span id="">
<span<?= $Page->kistype->viewAttributes() ?>>
<?= $Page->kistype->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->ez->Visible) { // ez ?>
        <td<?= $Page->ez->cellAttributes() ?>>
<span id="">
<span<?= $Page->ez->viewAttributes() ?>>
<?= $Page->ez->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->chilot->Visible) { // chilot ?>
        <td<?= $Page->chilot->cellAttributes() ?>>
<span id="">
<span<?= $Page->chilot->viewAttributes() ?>>
<?= $Page->chilot->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->Description->Visible) { // Description ?>
        <td<?= $Page->Description->cellAttributes() ?>>
<span id="">
<span<?= $Page->Description->viewAttributes() ?>>
<?= $Page->Description->getViewValue() ?></span>
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
