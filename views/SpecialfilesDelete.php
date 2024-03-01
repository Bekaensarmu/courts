<?php

namespace PHPMaker2024\project2;

// Page object
$SpecialfilesDelete = &$Page;
?>
<script>
var currentTable = <?= JsonEncode($Page->toClientVar()) ?>;
ew.deepAssign(ew.vars, { tables: { specialfiles: currentTable } });
var currentPageID = ew.PAGE_ID = "delete";
var currentForm;
var fspecialfilesdelete;
loadjs.ready(["wrapper", "head"], function () {
    let $ = jQuery;
    let fields = currentTable.fields;

    // Form object
    let form = new ew.FormBuilder()
        .setId("fspecialfilesdelete")
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
<form name="fspecialfilesdelete" id="fspecialfilesdelete" class="ew-form ew-delete-form" action="<?= CurrentPageUrl(false) ?>" method="post" novalidate autocomplete="off">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="specialfiles">
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
<?php if ($Page->_12D512DD->Visible) { // ዕዝ ?>
        <th class="<?= $Page->_12D512DD->headerCellClass() ?>"><span id="elh_specialfiles__12D512DD" class="specialfiles__12D512DD"><?= $Page->_12D512DD->caption() ?></span></th>
<?php } ?>
<?php if ($Page->_12E8127D120E12751235121D->Visible) { // የችሎትስም ?>
        <th class="<?= $Page->_12E8127D120E12751235121D->headerCellClass() ?>"><span id="elh_specialfiles__12E8127D120E12751235121D" class="specialfiles__12E8127D120E12751235121D"><?= $Page->_12E8127D120E12751235121D->caption() ?></span></th>
<?php } ?>
<?php if ($Page->_12E812AD122D12AD1229120212F01275->Visible) { // የክርክሩሂደት ?>
        <th class="<?= $Page->_12E812AD122D12AD1229120212F01275->headerCellClass() ?>"><span id="elh_specialfiles__12E812AD122D12AD1229120212F01275" class="specialfiles__12E812AD122D12AD1229120212F01275"><?= $Page->_12E812AD122D12AD1229120212F01275->caption() ?></span></th>
<?php } ?>
<?php if ($Page->_12E812AD123512D312ED12901275->Visible) { // የክስዓይነት ?>
        <th class="<?= $Page->_12E812AD123512D312ED12901275->headerCellClass() ?>"><span id="elh_specialfiles__12E812AD123512D312ED12901275" class="specialfiles__12E812AD123512D312ED12901275"><?= $Page->_12E812AD123512D312ED12901275->caption() ?></span></th>
<?php } ?>
<?php if ($Page->_12E812401320122E121D12AD129512EB1275->Visible) { // የቀጠሮምክንያት ?>
        <th class="<?= $Page->_12E812401320122E121D12AD129512EB1275->headerCellClass() ?>"><span id="elh_specialfiles__12E812401320122E121D12AD129512EB1275" class="specialfiles__12E812401320122E121D12AD129512EB1275"><?= $Page->_12E812401320122E121D12AD129512EB1275->caption() ?></span></th>
<?php } ?>
<?php if ($Page->_12E812CD1233129412D312ED12901275->Visible) { // የውሳኔዓይነት ?>
        <th class="<?= $Page->_12E812CD1233129412D312ED12901275->headerCellClass() ?>"><span id="elh_specialfiles__12E812CD1233129412D312ED12901275" class="specialfiles__12E812CD1233129412D312ED12901275"><?= $Page->_12E812CD1233129412D312ED12901275->caption() ?></span></th>
<?php } ?>
<?php if ($Page->_121B12D51228130D->Visible) { // ማዕረግ ?>
        <th class="<?= $Page->_121B12D51228130D->headerCellClass() ?>"><span id="elh_specialfiles__121B12D51228130D" class="specialfiles__121B12D51228130D"><?= $Page->_121B12D51228130D->caption() ?></span></th>
<?php } ?>
<?php if ($Page->_121B1265122B122D12EB->Visible) { // ማብራርያ ?>
        <th class="<?= $Page->_121B1265122B122D12EB->headerCellClass() ?>"><span id="elh_specialfiles__121B1265122B122D12EB" class="specialfiles__121B1265122B122D12EB"><?= $Page->_121B1265122B122D12EB->caption() ?></span></th>
<?php } ?>
<?php if ($Page->_12E81270121812D8130812601260127512401295->Visible) { // የተመዘገበበትቀን ?>
        <th class="<?= $Page->_12E81270121812D8130812601260127512401295->headerCellClass() ?>"><span id="elh_specialfiles__12E81270121812D8130812601260127512401295" class="specialfiles__12E81270121812D8130812601260127512401295"><?= $Page->_12E81270121812D8130812601260127512401295->caption() ?></span></th>
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
<?php if ($Page->_12D512DD->Visible) { // ዕዝ ?>
        <td<?= $Page->_12D512DD->cellAttributes() ?>>
<span id="">
<span<?= $Page->_12D512DD->viewAttributes() ?>>
<?= $Page->_12D512DD->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->_12E8127D120E12751235121D->Visible) { // የችሎትስም ?>
        <td<?= $Page->_12E8127D120E12751235121D->cellAttributes() ?>>
<span id="">
<span<?= $Page->_12E8127D120E12751235121D->viewAttributes() ?>>
<?= $Page->_12E8127D120E12751235121D->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->_12E812AD122D12AD1229120212F01275->Visible) { // የክርክሩሂደት ?>
        <td<?= $Page->_12E812AD122D12AD1229120212F01275->cellAttributes() ?>>
<span id="">
<span<?= $Page->_12E812AD122D12AD1229120212F01275->viewAttributes() ?>>
<?= $Page->_12E812AD122D12AD1229120212F01275->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->_12E812AD123512D312ED12901275->Visible) { // የክስዓይነት ?>
        <td<?= $Page->_12E812AD123512D312ED12901275->cellAttributes() ?>>
<span id="">
<span<?= $Page->_12E812AD123512D312ED12901275->viewAttributes() ?>>
<?= $Page->_12E812AD123512D312ED12901275->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->_12E812401320122E121D12AD129512EB1275->Visible) { // የቀጠሮምክንያት ?>
        <td<?= $Page->_12E812401320122E121D12AD129512EB1275->cellAttributes() ?>>
<span id="">
<span<?= $Page->_12E812401320122E121D12AD129512EB1275->viewAttributes() ?>>
<?= $Page->_12E812401320122E121D12AD129512EB1275->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->_12E812CD1233129412D312ED12901275->Visible) { // የውሳኔዓይነት ?>
        <td<?= $Page->_12E812CD1233129412D312ED12901275->cellAttributes() ?>>
<span id="">
<span<?= $Page->_12E812CD1233129412D312ED12901275->viewAttributes() ?>>
<?= $Page->_12E812CD1233129412D312ED12901275->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->_121B12D51228130D->Visible) { // ማዕረግ ?>
        <td<?= $Page->_121B12D51228130D->cellAttributes() ?>>
<span id="">
<span<?= $Page->_121B12D51228130D->viewAttributes() ?>>
<?= $Page->_121B12D51228130D->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->_121B1265122B122D12EB->Visible) { // ማብራርያ ?>
        <td<?= $Page->_121B1265122B122D12EB->cellAttributes() ?>>
<span id="">
<span<?= $Page->_121B1265122B122D12EB->viewAttributes() ?>>
<?= $Page->_121B1265122B122D12EB->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->_12E81270121812D8130812601260127512401295->Visible) { // የተመዘገበበትቀን ?>
        <td<?= $Page->_12E81270121812D8130812601260127512401295->cellAttributes() ?>>
<span id="">
<span<?= $Page->_12E81270121812D8130812601260127512401295->viewAttributes() ?>>
<?= $Page->_12E81270121812D8130812601260127512401295->getViewValue() ?></span>
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
