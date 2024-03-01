<?php

namespace PHPMaker2024\project2;

// Page object
$AttorneysDelete = &$Page;
?>
<script>
var currentTable = <?= JsonEncode($Page->toClientVar()) ?>;
ew.deepAssign(ew.vars, { tables: { attorneys: currentTable } });
var currentPageID = ew.PAGE_ID = "delete";
var currentForm;
var fattorneysdelete;
loadjs.ready(["wrapper", "head"], function () {
    let $ = jQuery;
    let fields = currentTable.fields;

    // Form object
    let form = new ew.FormBuilder()
        .setId("fattorneysdelete")
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
<form name="fattorneysdelete" id="fattorneysdelete" class="ew-form ew-delete-form" action="<?= CurrentPageUrl(false) ?>" method="post" novalidate autocomplete="off">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="attorneys">
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
<?php if ($Page->attorneyID->Visible) { // attorneyID ?>
        <th class="<?= $Page->attorneyID->headerCellClass() ?>"><span id="elh_attorneys_attorneyID" class="attorneys_attorneyID"><?= $Page->attorneyID->caption() ?></span></th>
<?php } ?>
<?php if ($Page->Name->Visible) { // Name ?>
        <th class="<?= $Page->Name->headerCellClass() ?>"><span id="elh_attorneys_Name" class="attorneys_Name"><?= $Page->Name->caption() ?></span></th>
<?php } ?>
<?php if ($Page->courtType->Visible) { // courtType ?>
        <th class="<?= $Page->courtType->headerCellClass() ?>"><span id="elh_attorneys_courtType" class="attorneys_courtType"><?= $Page->courtType->caption() ?></span></th>
<?php } ?>
<?php if ($Page->Address->Visible) { // Address ?>
        <th class="<?= $Page->Address->headerCellClass() ?>"><span id="elh_attorneys_Address" class="attorneys_Address"><?= $Page->Address->caption() ?></span></th>
<?php } ?>
<?php if ($Page->State->Visible) { // State ?>
        <th class="<?= $Page->State->headerCellClass() ?>"><span id="elh_attorneys_State" class="attorneys_State"><?= $Page->State->caption() ?></span></th>
<?php } ?>
<?php if ($Page->EmpType->Visible) { // EmpType ?>
        <th class="<?= $Page->EmpType->headerCellClass() ?>"><span id="elh_attorneys_EmpType" class="attorneys_EmpType"><?= $Page->EmpType->caption() ?></span></th>
<?php } ?>
<?php if ($Page->court_id->Visible) { // court_id ?>
        <th class="<?= $Page->court_id->headerCellClass() ?>"><span id="elh_attorneys_court_id" class="attorneys_court_id"><?= $Page->court_id->caption() ?></span></th>
<?php } ?>
<?php if ($Page->created_at->Visible) { // created_at ?>
        <th class="<?= $Page->created_at->headerCellClass() ?>"><span id="elh_attorneys_created_at" class="attorneys_created_at"><?= $Page->created_at->caption() ?></span></th>
<?php } ?>
<?php if ($Page->updated_at->Visible) { // updated_at ?>
        <th class="<?= $Page->updated_at->headerCellClass() ?>"><span id="elh_attorneys_updated_at" class="attorneys_updated_at"><?= $Page->updated_at->caption() ?></span></th>
<?php } ?>
<?php if ($Page->updated_by->Visible) { // updated_by ?>
        <th class="<?= $Page->updated_by->headerCellClass() ?>"><span id="elh_attorneys_updated_by" class="attorneys_updated_by"><?= $Page->updated_by->caption() ?></span></th>
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
<?php if ($Page->attorneyID->Visible) { // attorneyID ?>
        <td<?= $Page->attorneyID->cellAttributes() ?>>
<span id="">
<span<?= $Page->attorneyID->viewAttributes() ?>>
<?= $Page->attorneyID->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->Name->Visible) { // Name ?>
        <td<?= $Page->Name->cellAttributes() ?>>
<span id="">
<span<?= $Page->Name->viewAttributes() ?>>
<?= $Page->Name->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->courtType->Visible) { // courtType ?>
        <td<?= $Page->courtType->cellAttributes() ?>>
<span id="">
<span<?= $Page->courtType->viewAttributes() ?>>
<?= $Page->courtType->getViewValue() ?></span>
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
<?php if ($Page->State->Visible) { // State ?>
        <td<?= $Page->State->cellAttributes() ?>>
<span id="">
<span<?= $Page->State->viewAttributes() ?>>
<?= $Page->State->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->EmpType->Visible) { // EmpType ?>
        <td<?= $Page->EmpType->cellAttributes() ?>>
<span id="">
<span<?= $Page->EmpType->viewAttributes() ?>>
<?= $Page->EmpType->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->court_id->Visible) { // court_id ?>
        <td<?= $Page->court_id->cellAttributes() ?>>
<span id="">
<span<?= $Page->court_id->viewAttributes() ?>>
<?= $Page->court_id->getViewValue() ?></span>
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
