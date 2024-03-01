<?php

namespace PHPMaker2024\project2;

// Page object
$CaseChargesDelete = &$Page;
?>
<script>
var currentTable = <?= JsonEncode($Page->toClientVar()) ?>;
ew.deepAssign(ew.vars, { tables: { case_charges: currentTable } });
var currentPageID = ew.PAGE_ID = "delete";
var currentForm;
var fcase_chargesdelete;
loadjs.ready(["wrapper", "head"], function () {
    let $ = jQuery;
    let fields = currentTable.fields;

    // Form object
    let form = new ew.FormBuilder()
        .setId("fcase_chargesdelete")
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
<form name="fcase_chargesdelete" id="fcase_chargesdelete" class="ew-form ew-delete-form" action="<?= CurrentPageUrl(false) ?>" method="post" novalidate autocomplete="off">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="case_charges">
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
<?php if ($Page->deptName->Visible) { // deptName ?>
        <th class="<?= $Page->deptName->headerCellClass() ?>"><span id="elh_case_charges_deptName" class="case_charges_deptName"><?= $Page->deptName->caption() ?></span></th>
<?php } ?>
<?php if ($Page->mid->Visible) { // mid ?>
        <th class="<?= $Page->mid->headerCellClass() ?>"><span id="elh_case_charges_mid" class="case_charges_mid"><?= $Page->mid->caption() ?></span></th>
<?php } ?>
<?php if ($Page->rank->Visible) { // rank ?>
        <th class="<?= $Page->rank->headerCellClass() ?>"><span id="elh_case_charges_rank" class="case_charges_rank"><?= $Page->rank->caption() ?></span></th>
<?php } ?>
<?php if ($Page->name->Visible) { // name ?>
        <th class="<?= $Page->name->headerCellClass() ?>"><span id="elh_case_charges_name" class="case_charges_name"><?= $Page->name->caption() ?></span></th>
<?php } ?>
<?php if ($Page->address->Visible) { // address ?>
        <th class="<?= $Page->address->headerCellClass() ?>"><span id="elh_case_charges_address" class="case_charges_address"><?= $Page->address->caption() ?></span></th>
<?php } ?>
<?php if ($Page->state->Visible) { // state ?>
        <th class="<?= $Page->state->headerCellClass() ?>"><span id="elh_case_charges_state" class="case_charges_state"><?= $Page->state->caption() ?></span></th>
<?php } ?>
<?php if ($Page->crimeDate->Visible) { // crimeDate ?>
        <th class="<?= $Page->crimeDate->headerCellClass() ?>"><span id="elh_case_charges_crimeDate" class="case_charges_crimeDate"><?= $Page->crimeDate->caption() ?></span></th>
<?php } ?>
<?php if ($Page->ChargeDate->Visible) { // ChargeDate ?>
        <th class="<?= $Page->ChargeDate->headerCellClass() ?>"><span id="elh_case_charges_ChargeDate" class="case_charges_ChargeDate"><?= $Page->ChargeDate->caption() ?></span></th>
<?php } ?>
<?php if ($Page->created_at->Visible) { // created_at ?>
        <th class="<?= $Page->created_at->headerCellClass() ?>"><span id="elh_case_charges_created_at" class="case_charges_created_at"><?= $Page->created_at->caption() ?></span></th>
<?php } ?>
<?php if ($Page->updated_at->Visible) { // updated_at ?>
        <th class="<?= $Page->updated_at->headerCellClass() ?>"><span id="elh_case_charges_updated_at" class="case_charges_updated_at"><?= $Page->updated_at->caption() ?></span></th>
<?php } ?>
<?php if ($Page->updated_by->Visible) { // updated_by ?>
        <th class="<?= $Page->updated_by->headerCellClass() ?>"><span id="elh_case_charges_updated_by" class="case_charges_updated_by"><?= $Page->updated_by->caption() ?></span></th>
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
<?php if ($Page->deptName->Visible) { // deptName ?>
        <td<?= $Page->deptName->cellAttributes() ?>>
<span id="">
<span<?= $Page->deptName->viewAttributes() ?>>
<?= $Page->deptName->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->mid->Visible) { // mid ?>
        <td<?= $Page->mid->cellAttributes() ?>>
<span id="">
<span<?= $Page->mid->viewAttributes() ?>>
<?= $Page->mid->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->rank->Visible) { // rank ?>
        <td<?= $Page->rank->cellAttributes() ?>>
<span id="">
<span<?= $Page->rank->viewAttributes() ?>>
<?= $Page->rank->getViewValue() ?></span>
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
<?php if ($Page->address->Visible) { // address ?>
        <td<?= $Page->address->cellAttributes() ?>>
<span id="">
<span<?= $Page->address->viewAttributes() ?>>
<?= $Page->address->getViewValue() ?></span>
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
<?php if ($Page->crimeDate->Visible) { // crimeDate ?>
        <td<?= $Page->crimeDate->cellAttributes() ?>>
<span id="">
<span<?= $Page->crimeDate->viewAttributes() ?>>
<?= $Page->crimeDate->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->ChargeDate->Visible) { // ChargeDate ?>
        <td<?= $Page->ChargeDate->cellAttributes() ?>>
<span id="">
<span<?= $Page->ChargeDate->viewAttributes() ?>>
<?= $Page->ChargeDate->getViewValue() ?></span>
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
