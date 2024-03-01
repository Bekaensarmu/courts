<?php

namespace PHPMaker2024\project2;

// Page object
$CaseHearsList = &$Page;
?>
<?php if (!$Page->isExport()) { ?>
<script>
var currentTable = <?= JsonEncode($Page->toClientVar()) ?>;
ew.deepAssign(ew.vars, { tables: { case_hears: currentTable } });
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
<form name="fcase_hearssrch" id="fcase_hearssrch" class="ew-form ew-ext-search-form" action="<?= CurrentPageUrl(false) ?>" novalidate autocomplete="off">
<div id="fcase_hearssrch_search_panel" class="mb-2 mb-sm-0 <?= $Page->SearchPanelClass ?>"><!-- .ew-search-panel -->
<script>
var currentTable = <?= JsonEncode($Page->toClientVar()) ?>;
ew.deepAssign(ew.vars, { tables: { case_hears: currentTable } });
var currentForm;
var fcase_hearssrch, currentSearchForm, currentAdvancedSearchForm;
loadjs.ready(["wrapper", "head"], function () {
    let $ = jQuery,
        fields = currentTable.fields;

    // Form object for search
    let form = new ew.FormBuilder()
        .setId("fcase_hearssrch")
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
                <button type="button" class="dropdown-item<?= $Page->BasicSearch->getType() == "" ? " active" : "" ?>" form="fcase_hearssrch" data-ew-action="search-type"><?= $Language->phrase("QuickSearchAuto") ?></button>
                <button type="button" class="dropdown-item<?= $Page->BasicSearch->getType() == "=" ? " active" : "" ?>" form="fcase_hearssrch" data-ew-action="search-type" data-search-type="="><?= $Language->phrase("QuickSearchExact") ?></button>
                <button type="button" class="dropdown-item<?= $Page->BasicSearch->getType() == "AND" ? " active" : "" ?>" form="fcase_hearssrch" data-ew-action="search-type" data-search-type="AND"><?= $Language->phrase("QuickSearchAll") ?></button>
                <button type="button" class="dropdown-item<?= $Page->BasicSearch->getType() == "OR" ? " active" : "" ?>" form="fcase_hearssrch" data-ew-action="search-type" data-search-type="OR"><?= $Language->phrase("QuickSearchAny") ?></button>
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
<input type="hidden" name="t" value="case_hears">
<?php if ($Page->IsModal) { ?>
<input type="hidden" name="modal" value="1">
<?php } ?>
<div id="gmp_case_hears" class="card-body ew-grid-middle-panel <?= $Page->TableContainerClass ?>" style="<?= $Page->TableContainerStyle ?>">
<?php if ($Page->TotalRecords > 0 || $Page->isGridEdit() || $Page->isMultiEdit()) { ?>
<table id="tbl_case_hearslist" class="<?= $Page->TableClass ?>"><!-- .ew-table -->
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
<?php if ($Page->melequtir->Visible) { // melequtir ?>
        <th data-name="melequtir" class="<?= $Page->melequtir->headerCellClass() ?>"><div id="elh_case_hears_melequtir" class="case_hears_melequtir"><?= $Page->renderFieldHeader($Page->melequtir) ?></div></th>
<?php } ?>
<?php if ($Page->RANKe->Visible) { // RANKe ?>
        <th data-name="RANKe" class="<?= $Page->RANKe->headerCellClass() ?>"><div id="elh_case_hears_RANKe" class="case_hears_RANKe"><?= $Page->renderFieldHeader($Page->RANKe) ?></div></th>
<?php } ?>
<?php if ($Page->name->Visible) { // name ?>
        <th data-name="name" class="<?= $Page->name->headerCellClass() ?>"><div id="elh_case_hears_name" class="case_hears_name"><?= $Page->renderFieldHeader($Page->name) ?></div></th>
<?php } ?>
<?php if ($Page->ez->Visible) { // ez ?>
        <th data-name="ez" class="<?= $Page->ez->headerCellClass() ?>"><div id="elh_case_hears_ez" class="case_hears_ez"><?= $Page->renderFieldHeader($Page->ez) ?></div></th>
<?php } ?>
<?php if ($Page->fileNumber->Visible) { // fileNumber ?>
        <th data-name="fileNumber" class="<?= $Page->fileNumber->headerCellClass() ?>"><div id="elh_case_hears_fileNumber" class="case_hears_fileNumber"><?= $Page->renderFieldHeader($Page->fileNumber) ?></div></th>
<?php } ?>
<?php if ($Page->firdbet->Visible) { // firdbet ?>
        <th data-name="firdbet" class="<?= $Page->firdbet->headerCellClass() ?>"><div id="elh_case_hears_firdbet" class="case_hears_firdbet"><?= $Page->renderFieldHeader($Page->firdbet) ?></div></th>
<?php } ?>
<?php if ($Page->chilotname->Visible) { // chilotname ?>
        <th data-name="chilotname" class="<?= $Page->chilotname->headerCellClass() ?>"><div id="elh_case_hears_chilotname" class="case_hears_chilotname"><?= $Page->renderFieldHeader($Page->chilotname) ?></div></th>
<?php } ?>
<?php if ($Page->kirihidet->Visible) { // kirihidet ?>
        <th data-name="kirihidet" class="<?= $Page->kirihidet->headerCellClass() ?>"><div id="elh_case_hears_kirihidet" class="case_hears_kirihidet"><?= $Page->renderFieldHeader($Page->kirihidet) ?></div></th>
<?php } ?>
<?php if ($Page->yekisaynet->Visible) { // yekisaynet ?>
        <th data-name="yekisaynet" class="<?= $Page->yekisaynet->headerCellClass() ?>"><div id="elh_case_hears_yekisaynet" class="case_hears_yekisaynet"><?= $Page->renderFieldHeader($Page->yekisaynet) ?></div></th>
<?php } ?>
<?php if ($Page->keteroreason->Visible) { // keteroreason ?>
        <th data-name="keteroreason" class="<?= $Page->keteroreason->headerCellClass() ?>"><div id="elh_case_hears_keteroreason" class="case_hears_keteroreason"><?= $Page->renderFieldHeader($Page->keteroreason) ?></div></th>
<?php } ?>
<?php if ($Page->sex->Visible) { // sex ?>
        <th data-name="sex" class="<?= $Page->sex->headerCellClass() ?>"><div id="elh_case_hears_sex" class="case_hears_sex"><?= $Page->renderFieldHeader($Page->sex) ?></div></th>
<?php } ?>
<?php if ($Page->tekesashbizat->Visible) { // tekesashbizat ?>
        <th data-name="tekesashbizat" class="<?= $Page->tekesashbizat->headerCellClass() ?>"><div id="elh_case_hears_tekesashbizat" class="case_hears_tekesashbizat"><?= $Page->renderFieldHeader($Page->tekesashbizat) ?></div></th>
<?php } ?>
<?php if ($Page->keterodate->Visible) { // keterodate ?>
        <th data-name="keterodate" class="<?= $Page->keterodate->headerCellClass() ?>"><div id="elh_case_hears_keterodate" class="case_hears_keterodate"><?= $Page->renderFieldHeader($Page->keterodate) ?></div></th>
<?php } ?>
<?php if ($Page->keterodescription->Visible) { // keterodescription ?>
        <th data-name="keterodescription" class="<?= $Page->keterodescription->headerCellClass() ?>"><div id="elh_case_hears_keterodescription" class="case_hears_keterodescription"><?= $Page->renderFieldHeader($Page->keterodescription) ?></div></th>
<?php } ?>
<?php if ($Page->created_at->Visible) { // created_at ?>
        <th data-name="created_at" class="<?= $Page->created_at->headerCellClass() ?>"><div id="elh_case_hears_created_at" class="case_hears_created_at"><?= $Page->renderFieldHeader($Page->created_at) ?></div></th>
<?php } ?>
<?php if ($Page->updated_at->Visible) { // updated_at ?>
        <th data-name="updated_at" class="<?= $Page->updated_at->headerCellClass() ?>"><div id="elh_case_hears_updated_at" class="case_hears_updated_at"><?= $Page->renderFieldHeader($Page->updated_at) ?></div></th>
<?php } ?>
<?php if ($Page->updated_by->Visible) { // updated_by ?>
        <th data-name="updated_by" class="<?= $Page->updated_by->headerCellClass() ?>"><div id="elh_case_hears_updated_by" class="case_hears_updated_by"><?= $Page->renderFieldHeader($Page->updated_by) ?></div></th>
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
    <?php if ($Page->melequtir->Visible) { // melequtir ?>
        <td data-name="melequtir"<?= $Page->melequtir->cellAttributes() ?>>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_case_hears_melequtir" class="el_case_hears_melequtir">
<span<?= $Page->melequtir->viewAttributes() ?>>
<?= $Page->melequtir->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->RANKe->Visible) { // RANKe ?>
        <td data-name="RANKe"<?= $Page->RANKe->cellAttributes() ?>>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_case_hears_RANKe" class="el_case_hears_RANKe">
<span<?= $Page->RANKe->viewAttributes() ?>>
<?= $Page->RANKe->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->name->Visible) { // name ?>
        <td data-name="name"<?= $Page->name->cellAttributes() ?>>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_case_hears_name" class="el_case_hears_name">
<span<?= $Page->name->viewAttributes() ?>>
<?= $Page->name->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->ez->Visible) { // ez ?>
        <td data-name="ez"<?= $Page->ez->cellAttributes() ?>>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_case_hears_ez" class="el_case_hears_ez">
<span<?= $Page->ez->viewAttributes() ?>>
<?= $Page->ez->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->fileNumber->Visible) { // fileNumber ?>
        <td data-name="fileNumber"<?= $Page->fileNumber->cellAttributes() ?>>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_case_hears_fileNumber" class="el_case_hears_fileNumber">
<span<?= $Page->fileNumber->viewAttributes() ?>>
<?= $Page->fileNumber->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->firdbet->Visible) { // firdbet ?>
        <td data-name="firdbet"<?= $Page->firdbet->cellAttributes() ?>>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_case_hears_firdbet" class="el_case_hears_firdbet">
<span<?= $Page->firdbet->viewAttributes() ?>>
<?= $Page->firdbet->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->chilotname->Visible) { // chilotname ?>
        <td data-name="chilotname"<?= $Page->chilotname->cellAttributes() ?>>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_case_hears_chilotname" class="el_case_hears_chilotname">
<span<?= $Page->chilotname->viewAttributes() ?>>
<?= $Page->chilotname->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->kirihidet->Visible) { // kirihidet ?>
        <td data-name="kirihidet"<?= $Page->kirihidet->cellAttributes() ?>>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_case_hears_kirihidet" class="el_case_hears_kirihidet">
<span<?= $Page->kirihidet->viewAttributes() ?>>
<?= $Page->kirihidet->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->yekisaynet->Visible) { // yekisaynet ?>
        <td data-name="yekisaynet"<?= $Page->yekisaynet->cellAttributes() ?>>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_case_hears_yekisaynet" class="el_case_hears_yekisaynet">
<span<?= $Page->yekisaynet->viewAttributes() ?>>
<?= $Page->yekisaynet->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->keteroreason->Visible) { // keteroreason ?>
        <td data-name="keteroreason"<?= $Page->keteroreason->cellAttributes() ?>>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_case_hears_keteroreason" class="el_case_hears_keteroreason">
<span<?= $Page->keteroreason->viewAttributes() ?>>
<?= $Page->keteroreason->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->sex->Visible) { // sex ?>
        <td data-name="sex"<?= $Page->sex->cellAttributes() ?>>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_case_hears_sex" class="el_case_hears_sex">
<span<?= $Page->sex->viewAttributes() ?>>
<?= $Page->sex->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->tekesashbizat->Visible) { // tekesashbizat ?>
        <td data-name="tekesashbizat"<?= $Page->tekesashbizat->cellAttributes() ?>>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_case_hears_tekesashbizat" class="el_case_hears_tekesashbizat">
<span<?= $Page->tekesashbizat->viewAttributes() ?>>
<?= $Page->tekesashbizat->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->keterodate->Visible) { // keterodate ?>
        <td data-name="keterodate"<?= $Page->keterodate->cellAttributes() ?>>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_case_hears_keterodate" class="el_case_hears_keterodate">
<span<?= $Page->keterodate->viewAttributes() ?>>
<?= $Page->keterodate->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->keterodescription->Visible) { // keterodescription ?>
        <td data-name="keterodescription"<?= $Page->keterodescription->cellAttributes() ?>>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_case_hears_keterodescription" class="el_case_hears_keterodescription">
<span<?= $Page->keterodescription->viewAttributes() ?>>
<?= $Page->keterodescription->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->created_at->Visible) { // created_at ?>
        <td data-name="created_at"<?= $Page->created_at->cellAttributes() ?>>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_case_hears_created_at" class="el_case_hears_created_at">
<span<?= $Page->created_at->viewAttributes() ?>>
<?= $Page->created_at->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->updated_at->Visible) { // updated_at ?>
        <td data-name="updated_at"<?= $Page->updated_at->cellAttributes() ?>>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_case_hears_updated_at" class="el_case_hears_updated_at">
<span<?= $Page->updated_at->viewAttributes() ?>>
<?= $Page->updated_at->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->updated_by->Visible) { // updated_by ?>
        <td data-name="updated_by"<?= $Page->updated_by->cellAttributes() ?>>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_case_hears_updated_by" class="el_case_hears_updated_by">
<span<?= $Page->updated_by->viewAttributes() ?>>
<?= $Page->updated_by->getViewValue() ?></span>
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
    ew.addEventHandlers("case_hears");
});
</script>
<script>
loadjs.ready("load", function () {
    // Write your table-specific startup script here, no need to add script tags.
});
</script>
<?php } ?>
