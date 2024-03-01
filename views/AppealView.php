<?php

namespace PHPMaker2024\project2;

// Page object
$AppealView = &$Page;
?>
<?php if (!$Page->isExport()) { ?>
<div class="btn-toolbar ew-toolbar">
<?php $Page->ExportOptions->render("body") ?>
<?php $Page->OtherOptions->render("body") ?>
</div>
<?php } ?>
<?php $Page->showPageHeader(); ?>
<?php
$Page->showMessage();
?>
<main class="view">
<?php if (!$Page->IsModal) { ?>
<?php if (!$Page->isExport()) { ?>
<?= $Page->Pager->render() ?>
<?php } ?>
<?php } ?>
<form name="fappealview" id="fappealview" class="ew-form ew-view-form overlay-wrapper" action="<?= CurrentPageUrl(false) ?>" method="post" novalidate autocomplete="off">
<?php if (!$Page->isExport()) { ?>
<script>
var currentTable = <?= JsonEncode($Page->toClientVar()) ?>;
ew.deepAssign(ew.vars, { tables: { appeal: currentTable } });
var currentPageID = ew.PAGE_ID = "view";
var currentForm;
var fappealview;
loadjs.ready(["wrapper", "head"], function () {
    let $ = jQuery;
    let fields = currentTable.fields;

    // Form object
    let form = new ew.FormBuilder()
        .setId("fappealview")
        .setPageId("view")
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
<?php } ?>
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="appeal">
<input type="hidden" name="modal" value="<?= (int)$Page->IsModal ?>">
<table class="<?= $Page->TableClass ?>">
<?php if ($Page->appealDate->Visible) { // appealDate ?>
    <tr id="r_appealDate"<?= $Page->appealDate->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_appeal_appealDate"><?= $Page->appealDate->caption() ?></span></td>
        <td data-name="appealDate"<?= $Page->appealDate->cellAttributes() ?>>
<span id="el_appeal_appealDate">
<span<?= $Page->appealDate->viewAttributes() ?>>
<?= $Page->appealDate->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->mid->Visible) { // mid ?>
    <tr id="r_mid"<?= $Page->mid->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_appeal_mid"><?= $Page->mid->caption() ?></span></td>
        <td data-name="mid"<?= $Page->mid->cellAttributes() ?>>
<span id="el_appeal_mid">
<span<?= $Page->mid->viewAttributes() ?>>
<?= $Page->mid->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->rank->Visible) { // rank ?>
    <tr id="r_rank"<?= $Page->rank->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_appeal_rank"><?= $Page->rank->caption() ?></span></td>
        <td data-name="rank"<?= $Page->rank->cellAttributes() ?>>
<span id="el_appeal_rank">
<span<?= $Page->rank->viewAttributes() ?>>
<?= $Page->rank->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->name->Visible) { // name ?>
    <tr id="r_name"<?= $Page->name->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_appeal_name"><?= $Page->name->caption() ?></span></td>
        <td data-name="name"<?= $Page->name->cellAttributes() ?>>
<span id="el_appeal_name">
<span<?= $Page->name->viewAttributes() ?>>
<?= $Page->name->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->deptName->Visible) { // deptName ?>
    <tr id="r_deptName"<?= $Page->deptName->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_appeal_deptName"><?= $Page->deptName->caption() ?></span></td>
        <td data-name="deptName"<?= $Page->deptName->cellAttributes() ?>>
<span id="el_appeal_deptName">
<span<?= $Page->deptName->viewAttributes() ?>>
<?= $Page->deptName->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->halafinet->Visible) { // halafinet ?>
    <tr id="r_halafinet"<?= $Page->halafinet->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_appeal_halafinet"><?= $Page->halafinet->caption() ?></span></td>
        <td data-name="halafinet"<?= $Page->halafinet->cellAttributes() ?>>
<span id="el_appeal_halafinet">
<span<?= $Page->halafinet->viewAttributes() ?>>
<?= $Page->halafinet->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->crimstate->Visible) { // crimstate ?>
    <tr id="r_crimstate"<?= $Page->crimstate->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_appeal_crimstate"><?= $Page->crimstate->caption() ?></span></td>
        <td data-name="crimstate"<?= $Page->crimstate->cellAttributes() ?>>
<span id="el_appeal_crimstate">
<span<?= $Page->crimstate->viewAttributes() ?>>
<?= $Page->crimstate->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->Description->Visible) { // Description ?>
    <tr id="r_Description"<?= $Page->Description->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_appeal_Description"><?= $Page->Description->caption() ?></span></td>
        <td data-name="Description"<?= $Page->Description->cellAttributes() ?>>
<span id="el_appeal_Description">
<span<?= $Page->Description->viewAttributes() ?>>
<?= $Page->Description->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->midib->Visible) { // midib ?>
    <tr id="r_midib"<?= $Page->midib->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_appeal_midib"><?= $Page->midib->caption() ?></span></td>
        <td data-name="midib"<?= $Page->midib->cellAttributes() ?>>
<span id="el_appeal_midib">
<span<?= $Page->midib->viewAttributes() ?>>
<?= $Page->midib->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->appealask->Visible) { // appealask ?>
    <tr id="r_appealask"<?= $Page->appealask->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_appeal_appealask"><?= $Page->appealask->caption() ?></span></td>
        <td data-name="appealask"<?= $Page->appealask->cellAttributes() ?>>
<span id="el_appeal_appealask">
<span<?= $Page->appealask->viewAttributes() ?>>
<?= $Page->appealask->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->AppealDescription->Visible) { // AppealDescription ?>
    <tr id="r_AppealDescription"<?= $Page->AppealDescription->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_appeal_AppealDescription"><?= $Page->AppealDescription->caption() ?></span></td>
        <td data-name="AppealDescription"<?= $Page->AppealDescription->cellAttributes() ?>>
<span id="el_appeal_AppealDescription">
<span<?= $Page->AppealDescription->viewAttributes() ?>>
<?= $Page->AppealDescription->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->appealDecision->Visible) { // appealDecision ?>
    <tr id="r_appealDecision"<?= $Page->appealDecision->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_appeal_appealDecision"><?= $Page->appealDecision->caption() ?></span></td>
        <td data-name="appealDecision"<?= $Page->appealDecision->cellAttributes() ?>>
<span id="el_appeal_appealDecision">
<span<?= $Page->appealDecision->viewAttributes() ?>>
<?= $Page->appealDecision->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->created_at->Visible) { // created_at ?>
    <tr id="r_created_at"<?= $Page->created_at->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_appeal_created_at"><?= $Page->created_at->caption() ?></span></td>
        <td data-name="created_at"<?= $Page->created_at->cellAttributes() ?>>
<span id="el_appeal_created_at">
<span<?= $Page->created_at->viewAttributes() ?>>
<?= $Page->created_at->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->crimeDate->Visible) { // crimeDate ?>
    <tr id="r_crimeDate"<?= $Page->crimeDate->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_appeal_crimeDate"><?= $Page->crimeDate->caption() ?></span></td>
        <td data-name="crimeDate"<?= $Page->crimeDate->cellAttributes() ?>>
<span id="el_appeal_crimeDate">
<span<?= $Page->crimeDate->viewAttributes() ?>>
<?= $Page->crimeDate->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->updated_at->Visible) { // updated_at ?>
    <tr id="r_updated_at"<?= $Page->updated_at->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_appeal_updated_at"><?= $Page->updated_at->caption() ?></span></td>
        <td data-name="updated_at"<?= $Page->updated_at->cellAttributes() ?>>
<span id="el_appeal_updated_at">
<span<?= $Page->updated_at->viewAttributes() ?>>
<?= $Page->updated_at->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->updated_by->Visible) { // updated_by ?>
    <tr id="r_updated_by"<?= $Page->updated_by->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_appeal_updated_by"><?= $Page->updated_by->caption() ?></span></td>
        <td data-name="updated_by"<?= $Page->updated_by->cellAttributes() ?>>
<span id="el_appeal_updated_by">
<span<?= $Page->updated_by->viewAttributes() ?>>
<?= $Page->updated_by->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
</table>
</form>
<?php if (!$Page->IsModal) { ?>
<?php if (!$Page->isExport()) { ?>
<?= $Page->Pager->render() ?>
<?php } ?>
<?php } ?>
</main>
<?php
$Page->showPageFooter();
echo GetDebugMessage();
?>
<?php if (!$Page->isExport()) { ?>
<script>
loadjs.ready("load", function () {
    // Write your table-specific startup script here, no need to add script tags.
});
</script>
<?php } ?>
