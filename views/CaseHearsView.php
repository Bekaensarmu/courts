<?php

namespace PHPMaker2024\project2;

// Page object
$CaseHearsView = &$Page;
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
<form name="fcase_hearsview" id="fcase_hearsview" class="ew-form ew-view-form overlay-wrapper" action="<?= CurrentPageUrl(false) ?>" method="post" novalidate autocomplete="off">
<?php if (!$Page->isExport()) { ?>
<script>
var currentTable = <?= JsonEncode($Page->toClientVar()) ?>;
ew.deepAssign(ew.vars, { tables: { case_hears: currentTable } });
var currentPageID = ew.PAGE_ID = "view";
var currentForm;
var fcase_hearsview;
loadjs.ready(["wrapper", "head"], function () {
    let $ = jQuery;
    let fields = currentTable.fields;

    // Form object
    let form = new ew.FormBuilder()
        .setId("fcase_hearsview")
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
<input type="hidden" name="t" value="case_hears">
<input type="hidden" name="modal" value="<?= (int)$Page->IsModal ?>">
<table class="<?= $Page->TableClass ?>">
<?php if ($Page->melequtir->Visible) { // melequtir ?>
    <tr id="r_melequtir"<?= $Page->melequtir->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_case_hears_melequtir"><?= $Page->melequtir->caption() ?></span></td>
        <td data-name="melequtir"<?= $Page->melequtir->cellAttributes() ?>>
<span id="el_case_hears_melequtir">
<span<?= $Page->melequtir->viewAttributes() ?>>
<?= $Page->melequtir->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->RANKe->Visible) { // RANKe ?>
    <tr id="r_RANKe"<?= $Page->RANKe->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_case_hears_RANKe"><?= $Page->RANKe->caption() ?></span></td>
        <td data-name="RANKe"<?= $Page->RANKe->cellAttributes() ?>>
<span id="el_case_hears_RANKe">
<span<?= $Page->RANKe->viewAttributes() ?>>
<?= $Page->RANKe->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->name->Visible) { // name ?>
    <tr id="r_name"<?= $Page->name->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_case_hears_name"><?= $Page->name->caption() ?></span></td>
        <td data-name="name"<?= $Page->name->cellAttributes() ?>>
<span id="el_case_hears_name">
<span<?= $Page->name->viewAttributes() ?>>
<?= $Page->name->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->ez->Visible) { // ez ?>
    <tr id="r_ez"<?= $Page->ez->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_case_hears_ez"><?= $Page->ez->caption() ?></span></td>
        <td data-name="ez"<?= $Page->ez->cellAttributes() ?>>
<span id="el_case_hears_ez">
<span<?= $Page->ez->viewAttributes() ?>>
<?= $Page->ez->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->fileNumber->Visible) { // fileNumber ?>
    <tr id="r_fileNumber"<?= $Page->fileNumber->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_case_hears_fileNumber"><?= $Page->fileNumber->caption() ?></span></td>
        <td data-name="fileNumber"<?= $Page->fileNumber->cellAttributes() ?>>
<span id="el_case_hears_fileNumber">
<span<?= $Page->fileNumber->viewAttributes() ?>>
<?= $Page->fileNumber->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->firdbet->Visible) { // firdbet ?>
    <tr id="r_firdbet"<?= $Page->firdbet->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_case_hears_firdbet"><?= $Page->firdbet->caption() ?></span></td>
        <td data-name="firdbet"<?= $Page->firdbet->cellAttributes() ?>>
<span id="el_case_hears_firdbet">
<span<?= $Page->firdbet->viewAttributes() ?>>
<?= $Page->firdbet->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->chilotname->Visible) { // chilotname ?>
    <tr id="r_chilotname"<?= $Page->chilotname->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_case_hears_chilotname"><?= $Page->chilotname->caption() ?></span></td>
        <td data-name="chilotname"<?= $Page->chilotname->cellAttributes() ?>>
<span id="el_case_hears_chilotname">
<span<?= $Page->chilotname->viewAttributes() ?>>
<?= $Page->chilotname->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->kirihidet->Visible) { // kirihidet ?>
    <tr id="r_kirihidet"<?= $Page->kirihidet->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_case_hears_kirihidet"><?= $Page->kirihidet->caption() ?></span></td>
        <td data-name="kirihidet"<?= $Page->kirihidet->cellAttributes() ?>>
<span id="el_case_hears_kirihidet">
<span<?= $Page->kirihidet->viewAttributes() ?>>
<?= $Page->kirihidet->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->yekisaynet->Visible) { // yekisaynet ?>
    <tr id="r_yekisaynet"<?= $Page->yekisaynet->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_case_hears_yekisaynet"><?= $Page->yekisaynet->caption() ?></span></td>
        <td data-name="yekisaynet"<?= $Page->yekisaynet->cellAttributes() ?>>
<span id="el_case_hears_yekisaynet">
<span<?= $Page->yekisaynet->viewAttributes() ?>>
<?= $Page->yekisaynet->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->keteroreason->Visible) { // keteroreason ?>
    <tr id="r_keteroreason"<?= $Page->keteroreason->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_case_hears_keteroreason"><?= $Page->keteroreason->caption() ?></span></td>
        <td data-name="keteroreason"<?= $Page->keteroreason->cellAttributes() ?>>
<span id="el_case_hears_keteroreason">
<span<?= $Page->keteroreason->viewAttributes() ?>>
<?= $Page->keteroreason->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->sex->Visible) { // sex ?>
    <tr id="r_sex"<?= $Page->sex->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_case_hears_sex"><?= $Page->sex->caption() ?></span></td>
        <td data-name="sex"<?= $Page->sex->cellAttributes() ?>>
<span id="el_case_hears_sex">
<span<?= $Page->sex->viewAttributes() ?>>
<?= $Page->sex->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->tekesashbizat->Visible) { // tekesashbizat ?>
    <tr id="r_tekesashbizat"<?= $Page->tekesashbizat->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_case_hears_tekesashbizat"><?= $Page->tekesashbizat->caption() ?></span></td>
        <td data-name="tekesashbizat"<?= $Page->tekesashbizat->cellAttributes() ?>>
<span id="el_case_hears_tekesashbizat">
<span<?= $Page->tekesashbizat->viewAttributes() ?>>
<?= $Page->tekesashbizat->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->keterodate->Visible) { // keterodate ?>
    <tr id="r_keterodate"<?= $Page->keterodate->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_case_hears_keterodate"><?= $Page->keterodate->caption() ?></span></td>
        <td data-name="keterodate"<?= $Page->keterodate->cellAttributes() ?>>
<span id="el_case_hears_keterodate">
<span<?= $Page->keterodate->viewAttributes() ?>>
<?= $Page->keterodate->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->keterodescription->Visible) { // keterodescription ?>
    <tr id="r_keterodescription"<?= $Page->keterodescription->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_case_hears_keterodescription"><?= $Page->keterodescription->caption() ?></span></td>
        <td data-name="keterodescription"<?= $Page->keterodescription->cellAttributes() ?>>
<span id="el_case_hears_keterodescription">
<span<?= $Page->keterodescription->viewAttributes() ?>>
<?= $Page->keterodescription->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->created_at->Visible) { // created_at ?>
    <tr id="r_created_at"<?= $Page->created_at->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_case_hears_created_at"><?= $Page->created_at->caption() ?></span></td>
        <td data-name="created_at"<?= $Page->created_at->cellAttributes() ?>>
<span id="el_case_hears_created_at">
<span<?= $Page->created_at->viewAttributes() ?>>
<?= $Page->created_at->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->updated_at->Visible) { // updated_at ?>
    <tr id="r_updated_at"<?= $Page->updated_at->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_case_hears_updated_at"><?= $Page->updated_at->caption() ?></span></td>
        <td data-name="updated_at"<?= $Page->updated_at->cellAttributes() ?>>
<span id="el_case_hears_updated_at">
<span<?= $Page->updated_at->viewAttributes() ?>>
<?= $Page->updated_at->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->updated_by->Visible) { // updated_by ?>
    <tr id="r_updated_by"<?= $Page->updated_by->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_case_hears_updated_by"><?= $Page->updated_by->caption() ?></span></td>
        <td data-name="updated_by"<?= $Page->updated_by->cellAttributes() ?>>
<span id="el_case_hears_updated_by">
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
