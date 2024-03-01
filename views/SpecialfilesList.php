<?php

namespace PHPMaker2024\project2;

// Page object
$SpecialfilesList = &$Page;
?>
<?php if (!$Page->isExport()) { ?>
<script>
var currentTable = <?= JsonEncode($Page->toClientVar()) ?>;
ew.deepAssign(ew.vars, { tables: { specialfiles: currentTable } });
var currentPageID = ew.PAGE_ID = "list";
var currentForm;
var <?= $Page->FormName ?>;
loadjs.ready(["wrapper", "head"], function () {
    let $ = jQuery;
    let fields = currentTable.fields;

    // Form object
    let form = new ew.FormBuilder()
        .setId("<?= $Page->FormName ?>")
        .setPageId("list")
        .setSubmitWithFetch(<?= $Page->UseAjaxActions ? "true" : "false" ?>)
        .setFormKeyCountName("<?= $Page->FormKeyCountName ?>")
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
<?php if (!$Page->isExport()) { ?>
<div class="btn-toolbar ew-toolbar">
<?php if ($Page->TotalRecords > 0 && $Page->ExportOptions->visible()) { ?>
<?php $Page->ExportOptions->render("body") ?>
<?php } ?>
<?php if ($Page->ImportOptions->visible()) { ?>
<?php $Page->ImportOptions->render("body") ?>
<?php } ?>
<?php if ($Page->SearchOptions->visible()) { ?>
<?php $Page->SearchOptions->render("body") ?>
<?php } ?>
<?php if ($Page->FilterOptions->visible()) { ?>
<?php $Page->FilterOptions->render("body") ?>
<?php } ?>
</div>
<?php } ?>
<?php if (!$Page->IsModal) { ?>
<form name="fspecialfilessrch" id="fspecialfilessrch" class="ew-form ew-ext-search-form" action="<?= CurrentPageUrl(false) ?>" novalidate autocomplete="off">
<div id="fspecialfilessrch_search_panel" class="mb-2 mb-sm-0 <?= $Page->SearchPanelClass ?>"><!-- .ew-search-panel -->
<script>
var currentTable = <?= JsonEncode($Page->toClientVar()) ?>;
ew.deepAssign(ew.vars, { tables: { specialfiles: currentTable } });
var currentForm;
var fspecialfilessrch, currentSearchForm, currentAdvancedSearchForm;
loadjs.ready(["wrapper", "head"], function () {
    let $ = jQuery,
        fields = currentTable.fields;

    // Form object for search
    let form = new ew.FormBuilder()
        .setId("fspecialfilessrch")
        .setPageId("list")
<?php if ($Page->UseAjaxActions) { ?>
        .setSubmitWithFetch(true)
<?php } ?>

        // Dynamic selection lists
        .setLists({
        })

        // Filters
        .setFilterList(<?= $Page->getFilterList() ?>)
        .build();
    window[form.id] = form;
    currentSearchForm = form;
    loadjs.done(form.id);
});
</script>
<input type="hidden" name="cmd" value="search">
<?php if ($Security->canSearch()) { ?>
<?php if (!$Page->isExport() && !($Page->CurrentAction && $Page->CurrentAction != "search") && $Page->hasSearchFields()) { ?>
<div class="ew-extended-search container-fluid ps-2">
<div class="row mb-0">
    <div class="col-sm-auto px-0 pe-sm-2">
        <div class="ew-basic-search input-group">
            <input type="search" name="<?= Config("TABLE_BASIC_SEARCH") ?>" id="<?= Config("TABLE_BASIC_SEARCH") ?>" class="form-control ew-basic-search-keyword" value="<?= HtmlEncode($Page->BasicSearch->getKeyword()) ?>" placeholder="<?= HtmlEncode($Language->phrase("Search")) ?>" aria-label="<?= HtmlEncode($Language->phrase("Search")) ?>">
            <input type="hidden" name="<?= Config("TABLE_BASIC_SEARCH_TYPE") ?>" id="<?= Config("TABLE_BASIC_SEARCH_TYPE") ?>" class="ew-basic-search-type" value="<?= HtmlEncode($Page->BasicSearch->getType()) ?>">
            <button type="button" data-bs-toggle="dropdown" class="btn btn-outline-secondary dropdown-toggle dropdown-toggle-split" aria-haspopup="true" aria-expanded="false">
                <span id="searchtype"><?= $Page->BasicSearch->getTypeNameShort() ?></span>
            </button>
            <div class="dropdown-menu dropdown-menu-end">
                <button type="button" class="dropdown-item<?= $Page->BasicSearch->getType() == "" ? " active" : "" ?>" form="fspecialfilessrch" data-ew-action="search-type"><?= $Language->phrase("QuickSearchAuto") ?></button>
                <button type="button" class="dropdown-item<?= $Page->BasicSearch->getType() == "=" ? " active" : "" ?>" form="fspecialfilessrch" data-ew-action="search-type" data-search-type="="><?= $Language->phrase("QuickSearchExact") ?></button>
                <button type="button" class="dropdown-item<?= $Page->BasicSearch->getType() == "AND" ? " active" : "" ?>" form="fspecialfilessrch" data-ew-action="search-type" data-search-type="AND"><?= $Language->phrase("QuickSearchAll") ?></button>
                <button type="button" class="dropdown-item<?= $Page->BasicSearch->getType() == "OR" ? " active" : "" ?>" form="fspecialfilessrch" data-ew-action="search-type" data-search-type="OR"><?= $Language->phrase("QuickSearchAny") ?></button>
            </div>
        </div>
    </div>
    <div class="col-sm-auto mb-3">
        <button class="btn btn-primary" name="btn-submit" id="btn-submit" type="submit"><?= $Language->phrase("SearchBtn") ?></button>
    </div>
</div>
</div><!-- /.ew-extended-search -->
<?php } ?>
<?php } ?>
</div><!-- /.ew-search-panel -->
</form>
<?php } ?>
<?php $Page->showPageHeader(); ?>
<?php
$Page->showMessage();
?>
<main class="list<?= ($Page->TotalRecords == 0 && !$Page->isAdd()) ? " ew-no-record" : "" ?>">
<div id="ew-header-options">
<?php $Page->HeaderOptions?->render("body") ?>
</div>
<div id="ew-list">
<?php if ($Page->TotalRecords > 0 || $Page->CurrentAction) { ?>
<div class="card ew-card ew-grid<?= $Page->isAddOrEdit() ? " ew-grid-add-edit" : "" ?> <?= $Page->TableGridClass ?>">
<?php if (!$Page->isExport()) { ?>
<div class="card-header ew-grid-upper-panel">
<?php if (!$Page->isGridAdd() && !($Page->isGridEdit() && $Page->ModalGridEdit) && !$Page->isMultiEdit()) { ?>
<?= $Page->Pager->render() ?>
<?php } ?>
<div class="ew-list-other-options">
<?php $Page->OtherOptions->render("body") ?>
</div>
</div>
<?php } ?>
<form name="<?= $Page->FormName ?>" id="<?= $Page->FormName ?>" class="ew-form ew-list-form" action="<?= $Page->PageAction ?>" method="post" novalidate autocomplete="off">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="specialfiles">
<?php if ($Page->IsModal) { ?>
<input type="hidden" name="modal" value="1">
<?php } ?>
<div id="gmp_specialfiles" class="card-body ew-grid-middle-panel <?= $Page->TableContainerClass ?>" style="<?= $Page->TableContainerStyle ?>">
<?php if ($Page->TotalRecords > 0 || $Page->isGridEdit() || $Page->isMultiEdit()) { ?>
<table id="tbl_specialfileslist" class="<?= $Page->TableClass ?>"><!-- .ew-table -->
<thead>
    <tr class="ew-table-header">
<?php
// Header row
$Page->RowType = RowType::HEADER;

// Render list options
$Page->renderListOptions();

// Render list options (header, left)
$Page->ListOptions->render("header", "left");
?>
<?php if ($Page->_12D512DD->Visible) { // ዕዝ ?>
        <th data-name="_12D512DD" class="<?= $Page->_12D512DD->headerCellClass() ?>"><div id="elh_specialfiles__12D512DD" class="specialfiles__12D512DD"><?= $Page->renderFieldHeader($Page->_12D512DD) ?></div></th>
<?php } ?>
<?php if ($Page->_12E8127D120E12751235121D->Visible) { // የችሎትስም ?>
        <th data-name="_12E8127D120E12751235121D" class="<?= $Page->_12E8127D120E12751235121D->headerCellClass() ?>"><div id="elh_specialfiles__12E8127D120E12751235121D" class="specialfiles__12E8127D120E12751235121D"><?= $Page->renderFieldHeader($Page->_12E8127D120E12751235121D) ?></div></th>
<?php } ?>
<?php if ($Page->_12E812AD122D12AD1229120212F01275->Visible) { // የክርክሩሂደት ?>
        <th data-name="_12E812AD122D12AD1229120212F01275" class="<?= $Page->_12E812AD122D12AD1229120212F01275->headerCellClass() ?>"><div id="elh_specialfiles__12E812AD122D12AD1229120212F01275" class="specialfiles__12E812AD122D12AD1229120212F01275"><?= $Page->renderFieldHeader($Page->_12E812AD122D12AD1229120212F01275) ?></div></th>
<?php } ?>
<?php if ($Page->_12E812AD123512D312ED12901275->Visible) { // የክስዓይነት ?>
        <th data-name="_12E812AD123512D312ED12901275" class="<?= $Page->_12E812AD123512D312ED12901275->headerCellClass() ?>"><div id="elh_specialfiles__12E812AD123512D312ED12901275" class="specialfiles__12E812AD123512D312ED12901275"><?= $Page->renderFieldHeader($Page->_12E812AD123512D312ED12901275) ?></div></th>
<?php } ?>
<?php if ($Page->_12E812401320122E121D12AD129512EB1275->Visible) { // የቀጠሮምክንያት ?>
        <th data-name="_12E812401320122E121D12AD129512EB1275" class="<?= $Page->_12E812401320122E121D12AD129512EB1275->headerCellClass() ?>"><div id="elh_specialfiles__12E812401320122E121D12AD129512EB1275" class="specialfiles__12E812401320122E121D12AD129512EB1275"><?= $Page->renderFieldHeader($Page->_12E812401320122E121D12AD129512EB1275) ?></div></th>
<?php } ?>
<?php if ($Page->_12E812CD1233129412D312ED12901275->Visible) { // የውሳኔዓይነት ?>
        <th data-name="_12E812CD1233129412D312ED12901275" class="<?= $Page->_12E812CD1233129412D312ED12901275->headerCellClass() ?>"><div id="elh_specialfiles__12E812CD1233129412D312ED12901275" class="specialfiles__12E812CD1233129412D312ED12901275"><?= $Page->renderFieldHeader($Page->_12E812CD1233129412D312ED12901275) ?></div></th>
<?php } ?>
<?php if ($Page->_121B12D51228130D->Visible) { // ማዕረግ ?>
        <th data-name="_121B12D51228130D" class="<?= $Page->_121B12D51228130D->headerCellClass() ?>"><div id="elh_specialfiles__121B12D51228130D" class="specialfiles__121B12D51228130D"><?= $Page->renderFieldHeader($Page->_121B12D51228130D) ?></div></th>
<?php } ?>
<?php if ($Page->_121B1265122B122D12EB->Visible) { // ማብራርያ ?>
        <th data-name="_121B1265122B122D12EB" class="<?= $Page->_121B1265122B122D12EB->headerCellClass() ?>"><div id="elh_specialfiles__121B1265122B122D12EB" class="specialfiles__121B1265122B122D12EB"><?= $Page->renderFieldHeader($Page->_121B1265122B122D12EB) ?></div></th>
<?php } ?>
<?php if ($Page->_12E81270121812D8130812601260127512401295->Visible) { // የተመዘገበበትቀን ?>
        <th data-name="_12E81270121812D8130812601260127512401295" class="<?= $Page->_12E81270121812D8130812601260127512401295->headerCellClass() ?>"><div id="elh_specialfiles__12E81270121812D8130812601260127512401295" class="specialfiles__12E81270121812D8130812601260127512401295"><?= $Page->renderFieldHeader($Page->_12E81270121812D8130812601260127512401295) ?></div></th>
<?php } ?>
<?php
// Render list options (header, right)
$Page->ListOptions->render("header", "right");
?>
    </tr>
</thead>
<tbody data-page="<?= $Page->getPageNumber() ?>">
<?php
$Page->setupGrid();
while ($Page->RecordCount < $Page->StopRecord || $Page->RowIndex === '$rowindex$') {
    if (
        $Page->CurrentRow !== false &&
        $Page->RowIndex !== '$rowindex$' &&
        (!$Page->isGridAdd() || $Page->CurrentMode == "copy") &&
        (!(($Page->isCopy() || $Page->isAdd()) && $Page->RowIndex == 0))
    ) {
        $Page->fetch();
    }
    $Page->RecordCount++;
    if ($Page->RecordCount >= $Page->StartRecord) {
        $Page->setupRow();
?>
    <tr <?= $Page->rowAttributes() ?>>
<?php
// Render list options (body, left)
$Page->ListOptions->render("body", "left", $Page->RowCount);
?>
    <?php if ($Page->_12D512DD->Visible) { // ዕዝ ?>
        <td data-name="_12D512DD"<?= $Page->_12D512DD->cellAttributes() ?>>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_specialfiles__12D512DD" class="el_specialfiles__12D512DD">
<span<?= $Page->_12D512DD->viewAttributes() ?>>
<?= $Page->_12D512DD->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->_12E8127D120E12751235121D->Visible) { // የችሎትስም ?>
        <td data-name="_12E8127D120E12751235121D"<?= $Page->_12E8127D120E12751235121D->cellAttributes() ?>>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_specialfiles__12E8127D120E12751235121D" class="el_specialfiles__12E8127D120E12751235121D">
<span<?= $Page->_12E8127D120E12751235121D->viewAttributes() ?>>
<?= $Page->_12E8127D120E12751235121D->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->_12E812AD122D12AD1229120212F01275->Visible) { // የክርክሩሂደት ?>
        <td data-name="_12E812AD122D12AD1229120212F01275"<?= $Page->_12E812AD122D12AD1229120212F01275->cellAttributes() ?>>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_specialfiles__12E812AD122D12AD1229120212F01275" class="el_specialfiles__12E812AD122D12AD1229120212F01275">
<span<?= $Page->_12E812AD122D12AD1229120212F01275->viewAttributes() ?>>
<?= $Page->_12E812AD122D12AD1229120212F01275->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->_12E812AD123512D312ED12901275->Visible) { // የክስዓይነት ?>
        <td data-name="_12E812AD123512D312ED12901275"<?= $Page->_12E812AD123512D312ED12901275->cellAttributes() ?>>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_specialfiles__12E812AD123512D312ED12901275" class="el_specialfiles__12E812AD123512D312ED12901275">
<span<?= $Page->_12E812AD123512D312ED12901275->viewAttributes() ?>>
<?= $Page->_12E812AD123512D312ED12901275->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->_12E812401320122E121D12AD129512EB1275->Visible) { // የቀጠሮምክንያት ?>
        <td data-name="_12E812401320122E121D12AD129512EB1275"<?= $Page->_12E812401320122E121D12AD129512EB1275->cellAttributes() ?>>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_specialfiles__12E812401320122E121D12AD129512EB1275" class="el_specialfiles__12E812401320122E121D12AD129512EB1275">
<span<?= $Page->_12E812401320122E121D12AD129512EB1275->viewAttributes() ?>>
<?= $Page->_12E812401320122E121D12AD129512EB1275->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->_12E812CD1233129412D312ED12901275->Visible) { // የውሳኔዓይነት ?>
        <td data-name="_12E812CD1233129412D312ED12901275"<?= $Page->_12E812CD1233129412D312ED12901275->cellAttributes() ?>>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_specialfiles__12E812CD1233129412D312ED12901275" class="el_specialfiles__12E812CD1233129412D312ED12901275">
<span<?= $Page->_12E812CD1233129412D312ED12901275->viewAttributes() ?>>
<?= $Page->_12E812CD1233129412D312ED12901275->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->_121B12D51228130D->Visible) { // ማዕረግ ?>
        <td data-name="_121B12D51228130D"<?= $Page->_121B12D51228130D->cellAttributes() ?>>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_specialfiles__121B12D51228130D" class="el_specialfiles__121B12D51228130D">
<span<?= $Page->_121B12D51228130D->viewAttributes() ?>>
<?= $Page->_121B12D51228130D->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->_121B1265122B122D12EB->Visible) { // ማብራርያ ?>
        <td data-name="_121B1265122B122D12EB"<?= $Page->_121B1265122B122D12EB->cellAttributes() ?>>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_specialfiles__121B1265122B122D12EB" class="el_specialfiles__121B1265122B122D12EB">
<span<?= $Page->_121B1265122B122D12EB->viewAttributes() ?>>
<?= $Page->_121B1265122B122D12EB->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->_12E81270121812D8130812601260127512401295->Visible) { // የተመዘገበበትቀን ?>
        <td data-name="_12E81270121812D8130812601260127512401295"<?= $Page->_12E81270121812D8130812601260127512401295->cellAttributes() ?>>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_specialfiles__12E81270121812D8130812601260127512401295" class="el_specialfiles__12E81270121812D8130812601260127512401295">
<span<?= $Page->_12E81270121812D8130812601260127512401295->viewAttributes() ?>>
<?= $Page->_12E81270121812D8130812601260127512401295->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
<?php
// Render list options (body, right)
$Page->ListOptions->render("body", "right", $Page->RowCount);
?>
    </tr>
<?php
    }

    // Reset for template row
    if ($Page->RowIndex === '$rowindex$') {
        $Page->RowIndex = 0;
    }
    // Reset inline add/copy row
    if (($Page->isCopy() || $Page->isAdd()) && $Page->RowIndex == 0) {
        $Page->RowIndex = 1;
    }
}
?>
</tbody>
</table><!-- /.ew-table -->
<?php } ?>
</div><!-- /.ew-grid-middle-panel -->
<?php if (!$Page->CurrentAction && !$Page->UseAjaxActions) { ?>
<input type="hidden" name="action" id="action" value="">
<?php } ?>
</form><!-- /.ew-list-form -->
<?php
// Close result set
$Page->Recordset?->free();
?>
<?php if (!$Page->isExport()) { ?>
<div class="card-footer ew-grid-lower-panel">
<?php if (!$Page->isGridAdd() && !($Page->isGridEdit() && $Page->ModalGridEdit) && !$Page->isMultiEdit()) { ?>
<?= $Page->Pager->render() ?>
<?php } ?>
<div class="ew-list-other-options">
<?php $Page->OtherOptions->render("body", "bottom") ?>
</div>
</div>
<?php } ?>
</div><!-- /.ew-grid -->
<?php } else { ?>
<div class="ew-list-other-options">
<?php $Page->OtherOptions->render("body") ?>
</div>
<?php } ?>
</div>
<div id="ew-footer-options">
<?php $Page->FooterOptions?->render("body") ?>
</div>
</main>
<?php
$Page->showPageFooter();
echo GetDebugMessage();
?>
<?php if (!$Page->isExport()) { ?>
<script>
// Field event handlers
loadjs.ready("head", function() {
    ew.addEventHandlers("specialfiles");
});
</script>
<script>
loadjs.ready("load", function () {
    // Write your table-specific startup script here, no need to add script tags.
});
</script>
<?php } ?>
