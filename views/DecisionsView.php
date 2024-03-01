<?php

namespace PHPMaker2024\project2;

// Page object
$DecisionsView = &$Page;
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
<form name="fdecisionsview" id="fdecisionsview" class="ew-form ew-view-form overlay-wrapper" action="<?= CurrentPageUrl(false) ?>" method="post" novalidate autocomplete="off">
<?php if (!$Page->isExport()) { ?>
<script>
var currentTable = <?= JsonEncode($Page->toClientVar()) ?>;
ew.deepAssign(ew.vars, { tables: { decisions: currentTable } });
var currentPageID = ew.PAGE_ID = "view";
var currentForm;
var fdecisionsview;
loadjs.ready(["wrapper", "head"], function () {
    let $ = jQuery;
    let fields = currentTable.fields;

    // Form object
    let form = new ew.FormBuilder()
        .setId("fdecisionsview")
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
<input type="hidden" name="t" value="decisions">
<input type="hidden" name="modal" value="<?= (int)$Page->IsModal ?>">
<table class="<?= $Page->TableClass ?>">
<?php if ($Page->decisionDate->Visible) { // decisionDate ?>
    <tr id="r_decisionDate"<?= $Page->decisionDate->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_decisions_decisionDate"><?= $Page->decisionDate->caption() ?></span></td>
        <td data-name="decisionDate"<?= $Page->decisionDate->cellAttributes() ?>>
<span id="el_decisions_decisionDate">
<span<?= $Page->decisionDate->viewAttributes() ?>>
<?= $Page->decisionDate->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->Decisiontype->Visible) { // Decisiontype ?>
    <tr id="r_Decisiontype"<?= $Page->Decisiontype->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_decisions_Decisiontype"><?= $Page->Decisiontype->caption() ?></span></td>
        <td data-name="Decisiontype"<?= $Page->Decisiontype->cellAttributes() ?>>
<span id="el_decisions_Decisiontype">
<span<?= $Page->Decisiontype->viewAttributes() ?>>
<?= $Page->Decisiontype->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->kistype->Visible) { // kistype ?>
    <tr id="r_kistype"<?= $Page->kistype->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_decisions_kistype"><?= $Page->kistype->caption() ?></span></td>
        <td data-name="kistype"<?= $Page->kistype->cellAttributes() ?>>
<span id="el_decisions_kistype">
<span<?= $Page->kistype->viewAttributes() ?>>
<?= $Page->kistype->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->ez->Visible) { // ez ?>
    <tr id="r_ez"<?= $Page->ez->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_decisions_ez"><?= $Page->ez->caption() ?></span></td>
        <td data-name="ez"<?= $Page->ez->cellAttributes() ?>>
<span id="el_decisions_ez">
<span<?= $Page->ez->viewAttributes() ?>>
<?= $Page->ez->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->chilot->Visible) { // chilot ?>
    <tr id="r_chilot"<?= $Page->chilot->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_decisions_chilot"><?= $Page->chilot->caption() ?></span></td>
        <td data-name="chilot"<?= $Page->chilot->cellAttributes() ?>>
<span id="el_decisions_chilot">
<span<?= $Page->chilot->viewAttributes() ?>>
<?= $Page->chilot->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->Description->Visible) { // Description ?>
    <tr id="r_Description"<?= $Page->Description->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_decisions_Description"><?= $Page->Description->caption() ?></span></td>
        <td data-name="Description"<?= $Page->Description->cellAttributes() ?>>
<span id="el_decisions_Description">
<span<?= $Page->Description->viewAttributes() ?>>
<?= $Page->Description->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->created_at->Visible) { // created_at ?>
    <tr id="r_created_at"<?= $Page->created_at->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_decisions_created_at"><?= $Page->created_at->caption() ?></span></td>
        <td data-name="created_at"<?= $Page->created_at->cellAttributes() ?>>
<span id="el_decisions_created_at">
<span<?= $Page->created_at->viewAttributes() ?>>
<?= $Page->created_at->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->updated_at->Visible) { // updated_at ?>
    <tr id="r_updated_at"<?= $Page->updated_at->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_decisions_updated_at"><?= $Page->updated_at->caption() ?></span></td>
        <td data-name="updated_at"<?= $Page->updated_at->cellAttributes() ?>>
<span id="el_decisions_updated_at">
<span<?= $Page->updated_at->viewAttributes() ?>>
<?= $Page->updated_at->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->updated_by->Visible) { // updated_by ?>
    <tr id="r_updated_by"<?= $Page->updated_by->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_decisions_updated_by"><?= $Page->updated_by->caption() ?></span></td>
        <td data-name="updated_by"<?= $Page->updated_by->cellAttributes() ?>>
<span id="el_decisions_updated_by">
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
