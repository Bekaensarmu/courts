<?php

namespace PHPMaker2024\project2;

// Page object
$CaseHearsDelete = &$Page;
?>
<script>
var currentTable = <?= JsonEncode($Page->toClientVar()) ?>;
ew.deepAssign(ew.vars, { tables: { case_hears: currentTable } });
var currentPageID = ew.PAGE_ID = "delete";
var currentForm;
var fcase_hearsdelete;
loadjs.ready(["wrapper", "head"], function () {
    let $ = jQuery;
    let fields = currentTable.fields;

    // Form object
    let form = new ew.FormBuilder()
        .setId("fcase_hearsdelete")
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
<form name="fcase_hearsdelete" id="fcase_hearsdelete" class="ew-form ew-delete-form" action="<?= CurrentPageUrl(false) ?>" method="post" novalidate autocomplete="off">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="case_hears">
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
<?php if ($Page->melequtir->Visible) { // melequtir ?>
        <th class="<?= $Page->melequtir->headerCellClass() ?>"><span id="elh_case_hears_melequtir" class="case_hears_melequtir"><?= $Page->melequtir->caption() ?></span></th>
<?php } ?>
<?php if ($Page->RANKe->Visible) { // RANKe ?>
        <th class="<?= $Page->RANKe->headerCellClass() ?>"><span id="elh_case_hears_RANKe" class="case_hears_RANKe"><?= $Page->RANKe->caption() ?></span></th>
<?php } ?>
<?php if ($Page->name->Visible) { // name ?>
        <th class="<?= $Page->name->headerCellClass() ?>"><span id="elh_case_hears_name" class="case_hears_name"><?= $Page->name->caption() ?></span></th>
<?php } ?>
<?php if ($Page->ez->Visible) { // ez ?>
        <th class="<?= $Page->ez->headerCellClass() ?>"><span id="elh_case_hears_ez" class="case_hears_ez"><?= $Page->ez->caption() ?></span></th>
<?php } ?>
<?php if ($Page->fileNumber->Visible) { // fileNumber ?>
        <th class="<?= $Page->fileNumber->headerCellClass() ?>"><span id="elh_case_hears_fileNumber" class="case_hears_fileNumber"><?= $Page->fileNumber->caption() ?></span></th>
<?php } ?>
<?php if ($Page->firdbet->Visible) { // firdbet ?>
        <th class="<?= $Page->firdbet->headerCellClass() ?>"><span id="elh_case_hears_firdbet" class="case_hears_firdbet"><?= $Page->firdbet->caption() ?></span></th>
<?php } ?>
<?php if ($Page->chilotname->Visible) { // chilotname ?>
        <th class="<?= $Page->chilotname->headerCellClass() ?>"><span id="elh_case_hears_chilotname" class="case_hears_chilotname"><?= $Page->chilotname->caption() ?></span></th>
<?php } ?>
<?php if ($Page->kirihidet->Visible) { // kirihidet ?>
        <th class="<?= $Page->kirihidet->headerCellClass() ?>"><span id="elh_case_hears_kirihidet" class="case_hears_kirihidet"><?= $Page->kirihidet->caption() ?></span></th>
<?php } ?>
<?php if ($Page->yekisaynet->Visible) { // yekisaynet ?>
        <th class="<?= $Page->yekisaynet->headerCellClass() ?>"><span id="elh_case_hears_yekisaynet" class="case_hears_yekisaynet"><?= $Page->yekisaynet->caption() ?></span></th>
<?php } ?>
<?php if ($Page->keteroreason->Visible) { // keteroreason ?>
        <th class="<?= $Page->keteroreason->headerCellClass() ?>"><span id="elh_case_hears_keteroreason" class="case_hears_keteroreason"><?= $Page->keteroreason->caption() ?></span></th>
<?php } ?>
<?php if ($Page->sex->Visible) { // sex ?>
        <th class="<?= $Page->sex->headerCellClass() ?>"><span id="elh_case_hears_sex" class="case_hears_sex"><?= $Page->sex->caption() ?></span></th>
<?php } ?>
<?php if ($Page->tekesashbizat->Visible) { // tekesashbizat ?>
        <th class="<?= $Page->tekesashbizat->headerCellClass() ?>"><span id="elh_case_hears_tekesashbizat" class="case_hears_tekesashbizat"><?= $Page->tekesashbizat->caption() ?></span></th>
<?php } ?>
<?php if ($Page->keterodate->Visible) { // keterodate ?>
        <th class="<?= $Page->keterodate->headerCellClass() ?>"><span id="elh_case_hears_keterodate" class="case_hears_keterodate"><?= $Page->keterodate->caption() ?></span></th>
<?php } ?>
<?php if ($Page->keterodescription->Visible) { // keterodescription ?>
        <th class="<?= $Page->keterodescription->headerCellClass() ?>"><span id="elh_case_hears_keterodescription" class="case_hears_keterodescription"><?= $Page->keterodescription->caption() ?></span></th>
<?php } ?>
<?php if ($Page->created_at->Visible) { // created_at ?>
        <th class="<?= $Page->created_at->headerCellClass() ?>"><span id="elh_case_hears_created_at" class="case_hears_created_at"><?= $Page->created_at->caption() ?></span></th>
<?php } ?>
<?php if ($Page->updated_at->Visible) { // updated_at ?>
        <th class="<?= $Page->updated_at->headerCellClass() ?>"><span id="elh_case_hears_updated_at" class="case_hears_updated_at"><?= $Page->updated_at->caption() ?></span></th>
<?php } ?>
<?php if ($Page->updated_by->Visible) { // updated_by ?>
        <th class="<?= $Page->updated_by->headerCellClass() ?>"><span id="elh_case_hears_updated_by" class="case_hears_updated_by"><?= $Page->updated_by->caption() ?></span></th>
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
<?php if ($Page->melequtir->Visible) { // melequtir ?>
        <td<?= $Page->melequtir->cellAttributes() ?>>
<span id="">
<span<?= $Page->melequtir->viewAttributes() ?>>
<?= $Page->melequtir->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->RANKe->Visible) { // RANKe ?>
        <td<?= $Page->RANKe->cellAttributes() ?>>
<span id="">
<span<?= $Page->RANKe->viewAttributes() ?>>
<?= $Page->RANKe->getViewValue() ?></span>
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
<?php if ($Page->ez->Visible) { // ez ?>
        <td<?= $Page->ez->cellAttributes() ?>>
<span id="">
<span<?= $Page->ez->viewAttributes() ?>>
<?= $Page->ez->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->fileNumber->Visible) { // fileNumber ?>
        <td<?= $Page->fileNumber->cellAttributes() ?>>
<span id="">
<span<?= $Page->fileNumber->viewAttributes() ?>>
<?= $Page->fileNumber->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->firdbet->Visible) { // firdbet ?>
        <td<?= $Page->firdbet->cellAttributes() ?>>
<span id="">
<span<?= $Page->firdbet->viewAttributes() ?>>
<?= $Page->firdbet->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->chilotname->Visible) { // chilotname ?>
        <td<?= $Page->chilotname->cellAttributes() ?>>
<span id="">
<span<?= $Page->chilotname->viewAttributes() ?>>
<?= $Page->chilotname->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->kirihidet->Visible) { // kirihidet ?>
        <td<?= $Page->kirihidet->cellAttributes() ?>>
<span id="">
<span<?= $Page->kirihidet->viewAttributes() ?>>
<?= $Page->kirihidet->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->yekisaynet->Visible) { // yekisaynet ?>
        <td<?= $Page->yekisaynet->cellAttributes() ?>>
<span id="">
<span<?= $Page->yekisaynet->viewAttributes() ?>>
<?= $Page->yekisaynet->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->keteroreason->Visible) { // keteroreason ?>
        <td<?= $Page->keteroreason->cellAttributes() ?>>
<span id="">
<span<?= $Page->keteroreason->viewAttributes() ?>>
<?= $Page->keteroreason->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->sex->Visible) { // sex ?>
        <td<?= $Page->sex->cellAttributes() ?>>
<span id="">
<span<?= $Page->sex->viewAttributes() ?>>
<?= $Page->sex->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->tekesashbizat->Visible) { // tekesashbizat ?>
        <td<?= $Page->tekesashbizat->cellAttributes() ?>>
<span id="">
<span<?= $Page->tekesashbizat->viewAttributes() ?>>
<?= $Page->tekesashbizat->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->keterodate->Visible) { // keterodate ?>
        <td<?= $Page->keterodate->cellAttributes() ?>>
<span id="">
<span<?= $Page->keterodate->viewAttributes() ?>>
<?= $Page->keterodate->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->keterodescription->Visible) { // keterodescription ?>
        <td<?= $Page->keterodescription->cellAttributes() ?>>
<span id="">
<span<?= $Page->keterodescription->viewAttributes() ?>>
<?= $Page->keterodescription->getViewValue() ?></span>
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
