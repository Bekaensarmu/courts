<?php

namespace PHPMaker2024\project2;

// Page object
$SpecialfilesView = &$Page;
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
<form name="fspecialfilesview" id="fspecialfilesview" class="ew-form ew-view-form overlay-wrapper" action="<?= CurrentPageUrl(false) ?>" method="post" novalidate autocomplete="off">
<?php if (!$Page->isExport()) { ?>
<script>
var currentTable = <?= JsonEncode($Page->toClientVar()) ?>;
ew.deepAssign(ew.vars, { tables: { specialfiles: currentTable } });
var currentPageID = ew.PAGE_ID = "view";
var currentForm;
var fspecialfilesview;
loadjs.ready(["wrapper", "head"], function () {
    let $ = jQuery;
    let fields = currentTable.fields;

    // Form object
    let form = new ew.FormBuilder()
        .setId("fspecialfilesview")
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
<input type="hidden" name="t" value="specialfiles">
<input type="hidden" name="modal" value="<?= (int)$Page->IsModal ?>">
<table class="<?= $Page->TableClass ?>">
<?php if ($Page->_12D512DD->Visible) { // ዕዝ ?>
    <tr id="r__12D512DD"<?= $Page->_12D512DD->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_specialfiles__12D512DD"><?= $Page->_12D512DD->caption() ?></span></td>
        <td data-name="_12D512DD"<?= $Page->_12D512DD->cellAttributes() ?>>
<span id="el_specialfiles__12D512DD">
<span<?= $Page->_12D512DD->viewAttributes() ?>>
<?= $Page->_12D512DD->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->_12E8127D120E12751235121D->Visible) { // የችሎትስም ?>
    <tr id="r__12E8127D120E12751235121D"<?= $Page->_12E8127D120E12751235121D->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_specialfiles__12E8127D120E12751235121D"><?= $Page->_12E8127D120E12751235121D->caption() ?></span></td>
        <td data-name="_12E8127D120E12751235121D"<?= $Page->_12E8127D120E12751235121D->cellAttributes() ?>>
<span id="el_specialfiles__12E8127D120E12751235121D">
<span<?= $Page->_12E8127D120E12751235121D->viewAttributes() ?>>
<?= $Page->_12E8127D120E12751235121D->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->_12E812AD122D12AD1229120212F01275->Visible) { // የክርክሩሂደት ?>
    <tr id="r__12E812AD122D12AD1229120212F01275"<?= $Page->_12E812AD122D12AD1229120212F01275->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_specialfiles__12E812AD122D12AD1229120212F01275"><?= $Page->_12E812AD122D12AD1229120212F01275->caption() ?></span></td>
        <td data-name="_12E812AD122D12AD1229120212F01275"<?= $Page->_12E812AD122D12AD1229120212F01275->cellAttributes() ?>>
<span id="el_specialfiles__12E812AD122D12AD1229120212F01275">
<span<?= $Page->_12E812AD122D12AD1229120212F01275->viewAttributes() ?>>
<?= $Page->_12E812AD122D12AD1229120212F01275->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->_12E812AD123512D312ED12901275->Visible) { // የክስዓይነት ?>
    <tr id="r__12E812AD123512D312ED12901275"<?= $Page->_12E812AD123512D312ED12901275->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_specialfiles__12E812AD123512D312ED12901275"><?= $Page->_12E812AD123512D312ED12901275->caption() ?></span></td>
        <td data-name="_12E812AD123512D312ED12901275"<?= $Page->_12E812AD123512D312ED12901275->cellAttributes() ?>>
<span id="el_specialfiles__12E812AD123512D312ED12901275">
<span<?= $Page->_12E812AD123512D312ED12901275->viewAttributes() ?>>
<?= $Page->_12E812AD123512D312ED12901275->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->_12E812401320122E121D12AD129512EB1275->Visible) { // የቀጠሮምክንያት ?>
    <tr id="r__12E812401320122E121D12AD129512EB1275"<?= $Page->_12E812401320122E121D12AD129512EB1275->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_specialfiles__12E812401320122E121D12AD129512EB1275"><?= $Page->_12E812401320122E121D12AD129512EB1275->caption() ?></span></td>
        <td data-name="_12E812401320122E121D12AD129512EB1275"<?= $Page->_12E812401320122E121D12AD129512EB1275->cellAttributes() ?>>
<span id="el_specialfiles__12E812401320122E121D12AD129512EB1275">
<span<?= $Page->_12E812401320122E121D12AD129512EB1275->viewAttributes() ?>>
<?= $Page->_12E812401320122E121D12AD129512EB1275->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->_12E812CD1233129412D312ED12901275->Visible) { // የውሳኔዓይነት ?>
    <tr id="r__12E812CD1233129412D312ED12901275"<?= $Page->_12E812CD1233129412D312ED12901275->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_specialfiles__12E812CD1233129412D312ED12901275"><?= $Page->_12E812CD1233129412D312ED12901275->caption() ?></span></td>
        <td data-name="_12E812CD1233129412D312ED12901275"<?= $Page->_12E812CD1233129412D312ED12901275->cellAttributes() ?>>
<span id="el_specialfiles__12E812CD1233129412D312ED12901275">
<span<?= $Page->_12E812CD1233129412D312ED12901275->viewAttributes() ?>>
<?= $Page->_12E812CD1233129412D312ED12901275->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->_121B12D51228130D->Visible) { // ማዕረግ ?>
    <tr id="r__121B12D51228130D"<?= $Page->_121B12D51228130D->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_specialfiles__121B12D51228130D"><?= $Page->_121B12D51228130D->caption() ?></span></td>
        <td data-name="_121B12D51228130D"<?= $Page->_121B12D51228130D->cellAttributes() ?>>
<span id="el_specialfiles__121B12D51228130D">
<span<?= $Page->_121B12D51228130D->viewAttributes() ?>>
<?= $Page->_121B12D51228130D->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->_121B1265122B122D12EB->Visible) { // ማብራርያ ?>
    <tr id="r__121B1265122B122D12EB"<?= $Page->_121B1265122B122D12EB->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_specialfiles__121B1265122B122D12EB"><?= $Page->_121B1265122B122D12EB->caption() ?></span></td>
        <td data-name="_121B1265122B122D12EB"<?= $Page->_121B1265122B122D12EB->cellAttributes() ?>>
<span id="el_specialfiles__121B1265122B122D12EB">
<span<?= $Page->_121B1265122B122D12EB->viewAttributes() ?>>
<?= $Page->_121B1265122B122D12EB->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->_12E81270121812D8130812601260127512401295->Visible) { // የተመዘገበበትቀን ?>
    <tr id="r__12E81270121812D8130812601260127512401295"<?= $Page->_12E81270121812D8130812601260127512401295->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_specialfiles__12E81270121812D8130812601260127512401295"><?= $Page->_12E81270121812D8130812601260127512401295->caption() ?></span></td>
        <td data-name="_12E81270121812D8130812601260127512401295"<?= $Page->_12E81270121812D8130812601260127512401295->cellAttributes() ?>>
<span id="el_specialfiles__12E81270121812D8130812601260127512401295">
<span<?= $Page->_12E81270121812D8130812601260127512401295->viewAttributes() ?>>
<?= $Page->_12E81270121812D8130812601260127512401295->getViewValue() ?></span>
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
