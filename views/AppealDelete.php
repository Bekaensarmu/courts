<?php

namespace PHPMaker2024\project2;

// Page object
$AppealDelete = &$Page;
?>
<script>
var currentTable = <?= JsonEncode($Page->toClientVar()) ?>;
ew.deepAssign(ew.vars, { tables: { appeal: currentTable } });
var currentPageID = ew.PAGE_ID = "delete";
var currentForm;
var fappealdelete;
loadjs.ready(["wrapper", "head"], function () {
    let $ = jQuery;
    let fields = currentTable.fields;

    // Form object
    let form = new ew.FormBuilder()
        .setId("fappealdelete")
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
<form name="fappealdelete" id="fappealdelete" class="ew-form ew-delete-form" action="<?= CurrentPageUrl(false) ?>" method="post" novalidate autocomplete="off">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="appeal">
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
<?php if ($Page->appealDate->Visible) { // appealDate ?>
        <th class="<?= $Page->appealDate->headerCellClass() ?>"><span id="elh_appeal_appealDate" class="appeal_appealDate"><?= $Page->appealDate->caption() ?></span></th>
<?php } ?>
<?php if ($Page->mid->Visible) { // mid ?>
        <th class="<?= $Page->mid->headerCellClass() ?>"><span id="elh_appeal_mid" class="appeal_mid"><?= $Page->mid->caption() ?></span></th>
<?php } ?>
<?php if ($Page->rank->Visible) { // rank ?>
        <th class="<?= $Page->rank->headerCellClass() ?>"><span id="elh_appeal_rank" class="appeal_rank"><?= $Page->rank->caption() ?></span></th>
<?php } ?>
<?php if ($Page->name->Visible) { // name ?>
        <th class="<?= $Page->name->headerCellClass() ?>"><span id="elh_appeal_name" class="appeal_name"><?= $Page->name->caption() ?></span></th>
<?php } ?>
<?php if ($Page->deptName->Visible) { // deptName ?>
        <th class="<?= $Page->deptName->headerCellClass() ?>"><span id="elh_appeal_deptName" class="appeal_deptName"><?= $Page->deptName->caption() ?></span></th>
<?php } ?>
<?php if ($Page->halafinet->Visible) { // halafinet ?>
        <th class="<?= $Page->halafinet->headerCellClass() ?>"><span id="elh_appeal_halafinet" class="appeal_halafinet"><?= $Page->halafinet->caption() ?></span></th>
<?php } ?>
<?php if ($Page->crimstate->Visible) { // crimstate ?>
        <th class="<?= $Page->crimstate->headerCellClass() ?>"><span id="elh_appeal_crimstate" class="appeal_crimstate"><?= $Page->crimstate->caption() ?></span></th>
<?php } ?>
<?php if ($Page->Description->Visible) { // Description ?>
        <th class="<?= $Page->Description->headerCellClass() ?>"><span id="elh_appeal_Description" class="appeal_Description"><?= $Page->Description->caption() ?></span></th>
<?php } ?>
<?php if ($Page->midib->Visible) { // midib ?>
        <th class="<?= $Page->midib->headerCellClass() ?>"><span id="elh_appeal_midib" class="appeal_midib"><?= $Page->midib->caption() ?></span></th>
<?php } ?>
<?php if ($Page->appealask->Visible) { // appealask ?>
        <th class="<?= $Page->appealask->headerCellClass() ?>"><span id="elh_appeal_appealask" class="appeal_appealask"><?= $Page->appealask->caption() ?></span></th>
<?php } ?>
<?php if ($Page->AppealDescription->Visible) { // AppealDescription ?>
        <th class="<?= $Page->AppealDescription->headerCellClass() ?>"><span id="elh_appeal_AppealDescription" class="appeal_AppealDescription"><?= $Page->AppealDescription->caption() ?></span></th>
<?php } ?>
<?php if ($Page->appealDecision->Visible) { // appealDecision ?>
        <th class="<?= $Page->appealDecision->headerCellClass() ?>"><span id="elh_appeal_appealDecision" class="appeal_appealDecision"><?= $Page->appealDecision->caption() ?></span></th>
<?php } ?>
<?php if ($Page->created_at->Visible) { // created_at ?>
        <th class="<?= $Page->created_at->headerCellClass() ?>"><span id="elh_appeal_created_at" class="appeal_created_at"><?= $Page->created_at->caption() ?></span></th>
<?php } ?>
<?php if ($Page->crimeDate->Visible) { // crimeDate ?>
        <th class="<?= $Page->crimeDate->headerCellClass() ?>"><span id="elh_appeal_crimeDate" class="appeal_crimeDate"><?= $Page->crimeDate->caption() ?></span></th>
<?php } ?>
<?php if ($Page->updated_at->Visible) { // updated_at ?>
        <th class="<?= $Page->updated_at->headerCellClass() ?>"><span id="elh_appeal_updated_at" class="appeal_updated_at"><?= $Page->updated_at->caption() ?></span></th>
<?php } ?>
<?php if ($Page->updated_by->Visible) { // updated_by ?>
        <th class="<?= $Page->updated_by->headerCellClass() ?>"><span id="elh_appeal_updated_by" class="appeal_updated_by"><?= $Page->updated_by->caption() ?></span></th>
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
<?php if ($Page->appealDate->Visible) { // appealDate ?>
        <td<?= $Page->appealDate->cellAttributes() ?>>
<span id="">
<span<?= $Page->appealDate->viewAttributes() ?>>
<?= $Page->appealDate->getViewValue() ?></span>
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
<?php if ($Page->deptName->Visible) { // deptName ?>
        <td<?= $Page->deptName->cellAttributes() ?>>
<span id="">
<span<?= $Page->deptName->viewAttributes() ?>>
<?= $Page->deptName->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->halafinet->Visible) { // halafinet ?>
        <td<?= $Page->halafinet->cellAttributes() ?>>
<span id="">
<span<?= $Page->halafinet->viewAttributes() ?>>
<?= $Page->halafinet->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->crimstate->Visible) { // crimstate ?>
        <td<?= $Page->crimstate->cellAttributes() ?>>
<span id="">
<span<?= $Page->crimstate->viewAttributes() ?>>
<?= $Page->crimstate->getViewValue() ?></span>
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
<?php if ($Page->midib->Visible) { // midib ?>
        <td<?= $Page->midib->cellAttributes() ?>>
<span id="">
<span<?= $Page->midib->viewAttributes() ?>>
<?= $Page->midib->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->appealask->Visible) { // appealask ?>
        <td<?= $Page->appealask->cellAttributes() ?>>
<span id="">
<span<?= $Page->appealask->viewAttributes() ?>>
<?= $Page->appealask->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->AppealDescription->Visible) { // AppealDescription ?>
        <td<?= $Page->AppealDescription->cellAttributes() ?>>
<span id="">
<span<?= $Page->AppealDescription->viewAttributes() ?>>
<?= $Page->AppealDescription->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->appealDecision->Visible) { // appealDecision ?>
        <td<?= $Page->appealDecision->cellAttributes() ?>>
<span id="">
<span<?= $Page->appealDecision->viewAttributes() ?>>
<?= $Page->appealDecision->getViewValue() ?></span>
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
<?php if ($Page->crimeDate->Visible) { // crimeDate ?>
        <td<?= $Page->crimeDate->cellAttributes() ?>>
<span id="">
<span<?= $Page->crimeDate->viewAttributes() ?>>
<?= $Page->crimeDate->getViewValue() ?></span>
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
