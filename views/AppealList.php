<?php

namespace PHPMaker2024\project2;

// Page object
$AppealList = &$Page;
?>
<?php if (!$Page->isExport()) { ?>
<script>
var currentTable = <?= JsonEncode($Page->toClientVar()) ?>;
ew.deepAssign(ew.vars, { tables: { appeal: currentTable } });
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
<form name="fappealsrch" id="fappealsrch" class="ew-form ew-ext-search-form" action="<?= CurrentPageUrl(false) ?>" novalidate autocomplete="off">
<div id="fappealsrch_search_panel" class="mb-2 mb-sm-0 <?= $Page->SearchPanelClass ?>"><!-- .ew-search-panel -->
<script>
var currentTable = <?= JsonEncode($Page->toClientVar()) ?>;
ew.deepAssign(ew.vars, { tables: { appeal: currentTable } });
var currentForm;
var fappealsrch, currentSearchForm, currentAdvancedSearchForm;
loadjs.ready(["wrapper", "head"], function () {
    let $ = jQuery,
        fields = currentTable.fields;

    // Form object for search
    let form = new ew.FormBuilder()
        .setId("fappealsrch")
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
                <button type="button" class="dropdown-item<?= $Page->BasicSearch->getType() == "" ? " active" : "" ?>" form="fappealsrch" data-ew-action="search-type"><?= $Language->phrase("QuickSearchAuto") ?></button>
                <button type="button" class="dropdown-item<?= $Page->BasicSearch->getType() == "=" ? " active" : "" ?>" form="fappealsrch" data-ew-action="search-type" data-search-type="="><?= $Language->phrase("QuickSearchExact") ?></button>
                <button type="button" class="dropdown-item<?= $Page->BasicSearch->getType() == "AND" ? " active" : "" ?>" form="fappealsrch" data-ew-action="search-type" data-search-type="AND"><?= $Language->phrase("QuickSearchAll") ?></button>
                <button type="button" class="dropdown-item<?= $Page->BasicSearch->getType() == "OR" ? " active" : "" ?>" form="fappealsrch" data-ew-action="search-type" data-search-type="OR"><?= $Language->phrase("QuickSearchAny") ?></button>
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
<input type="hidden" name="t" value="appeal">
<?php if ($Page->IsModal) { ?>
<input type="hidden" name="modal" value="1">
<?php } ?>
<div id="gmp_appeal" class="card-body ew-grid-middle-panel <?= $Page->TableContainerClass ?>" style="<?= $Page->TableContainerStyle ?>">
<?php if ($Page->TotalRecords > 0 || $Page->isGridEdit() || $Page->isMultiEdit()) { ?>
<table id="tbl_appeallist" class="<?= $Page->TableClass ?>"><!-- .ew-table -->
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
<?php if ($Page->appealDate->Visible) { // appealDate ?>
        <th data-name="appealDate" class="<?= $Page->appealDate->headerCellClass() ?>"><div id="elh_appeal_appealDate" class="appeal_appealDate"><?= $Page->renderFieldHeader($Page->appealDate) ?></div></th>
<?php } ?>
<?php if ($Page->mid->Visible) { // mid ?>
        <th data-name="mid" class="<?= $Page->mid->headerCellClass() ?>"><div id="elh_appeal_mid" class="appeal_mid"><?= $Page->renderFieldHeader($Page->mid) ?></div></th>
<?php } ?>
<?php if ($Page->rank->Visible) { // rank ?>
        <th data-name="rank" class="<?= $Page->rank->headerCellClass() ?>"><div id="elh_appeal_rank" class="appeal_rank"><?= $Page->renderFieldHeader($Page->rank) ?></div></th>
<?php } ?>
<?php if ($Page->name->Visible) { // name ?>
        <th data-name="name" class="<?= $Page->name->headerCellClass() ?>"><div id="elh_appeal_name" class="appeal_name"><?= $Page->renderFieldHeader($Page->name) ?></div></th>
<?php } ?>
<?php if ($Page->deptName->Visible) { // deptName ?>
        <th data-name="deptName" class="<?= $Page->deptName->headerCellClass() ?>"><div id="elh_appeal_deptName" class="appeal_deptName"><?= $Page->renderFieldHeader($Page->deptName) ?></div></th>
<?php } ?>
<?php if ($Page->halafinet->Visible) { // halafinet ?>
        <th data-name="halafinet" class="<?= $Page->halafinet->headerCellClass() ?>"><div id="elh_appeal_halafinet" class="appeal_halafinet"><?= $Page->renderFieldHeader($Page->halafinet) ?></div></th>
<?php } ?>
<?php if ($Page->crimstate->Visible) { // crimstate ?>
        <th data-name="crimstate" class="<?= $Page->crimstate->headerCellClass() ?>"><div id="elh_appeal_crimstate" class="appeal_crimstate"><?= $Page->renderFieldHeader($Page->crimstate) ?></div></th>
<?php } ?>
<?php if ($Page->Description->Visible) { // Description ?>
        <th data-name="Description" class="<?= $Page->Description->headerCellClass() ?>"><div id="elh_appeal_Description" class="appeal_Description"><?= $Page->renderFieldHeader($Page->Description) ?></div></th>
<?php } ?>
<?php if ($Page->midib->Visible) { // midib ?>
        <th data-name="midib" class="<?= $Page->midib->headerCellClass() ?>"><div id="elh_appeal_midib" class="appeal_midib"><?= $Page->renderFieldHeader($Page->midib) ?></div></th>
<?php } ?>
<?php if ($Page->appealask->Visible) { // appealask ?>
        <th data-name="appealask" class="<?= $Page->appealask->headerCellClass() ?>"><div id="elh_appeal_appealask" class="appeal_appealask"><?= $Page->renderFieldHeader($Page->appealask) ?></div></th>
<?php } ?>
<?php if ($Page->AppealDescription->Visible) { // AppealDescription ?>
        <th data-name="AppealDescription" class="<?= $Page->AppealDescription->headerCellClass() ?>"><div id="elh_appeal_AppealDescription" class="appeal_AppealDescription"><?= $Page->renderFieldHeader($Page->AppealDescription) ?></div></th>
<?php } ?>
<?php if ($Page->appealDecision->Visible) { // appealDecision ?>
        <th data-name="appealDecision" class="<?= $Page->appealDecision->headerCellClass() ?>"><div id="elh_appeal_appealDecision" class="appeal_appealDecision"><?= $Page->renderFieldHeader($Page->appealDecision) ?></div></th>
<?php } ?>
<?php if ($Page->created_at->Visible) { // created_at ?>
        <th data-name="created_at" class="<?= $Page->created_at->headerCellClass() ?>"><div id="elh_appeal_created_at" class="appeal_created_at"><?= $Page->renderFieldHeader($Page->created_at) ?></div></th>
<?php } ?>
<?php if ($Page->crimeDate->Visible) { // crimeDate ?>
        <th data-name="crimeDate" class="<?= $Page->crimeDate->headerCellClass() ?>"><div id="elh_appeal_crimeDate" class="appeal_crimeDate"><?= $Page->renderFieldHeader($Page->crimeDate) ?></div></th>
<?php } ?>
<?php if ($Page->updated_at->Visible) { // updated_at ?>
        <th data-name="updated_at" class="<?= $Page->updated_at->headerCellClass() ?>"><div id="elh_appeal_updated_at" class="appeal_updated_at"><?= $Page->renderFieldHeader($Page->updated_at) ?></div></th>
<?php } ?>
<?php if ($Page->updated_by->Visible) { // updated_by ?>
        <th data-name="updated_by" class="<?= $Page->updated_by->headerCellClass() ?>"><div id="elh_appeal_updated_by" class="appeal_updated_by"><?= $Page->renderFieldHeader($Page->updated_by) ?></div></th>
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
    <?php if ($Page->appealDate->Visible) { // appealDate ?>
        <td data-name="appealDate"<?= $Page->appealDate->cellAttributes() ?>>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_appeal_appealDate" class="el_appeal_appealDate">
<span<?= $Page->appealDate->viewAttributes() ?>>
<?= $Page->appealDate->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->mid->Visible) { // mid ?>
        <td data-name="mid"<?= $Page->mid->cellAttributes() ?>>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_appeal_mid" class="el_appeal_mid">
<span<?= $Page->mid->viewAttributes() ?>>
<?= $Page->mid->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->rank->Visible) { // rank ?>
        <td data-name="rank"<?= $Page->rank->cellAttributes() ?>>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_appeal_rank" class="el_appeal_rank">
<span<?= $Page->rank->viewAttributes() ?>>
<?= $Page->rank->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->name->Visible) { // name ?>
        <td data-name="name"<?= $Page->name->cellAttributes() ?>>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_appeal_name" class="el_appeal_name">
<span<?= $Page->name->viewAttributes() ?>>
<?= $Page->name->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->deptName->Visible) { // deptName ?>
        <td data-name="deptName"<?= $Page->deptName->cellAttributes() ?>>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_appeal_deptName" class="el_appeal_deptName">
<span<?= $Page->deptName->viewAttributes() ?>>
<?= $Page->deptName->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->halafinet->Visible) { // halafinet ?>
        <td data-name="halafinet"<?= $Page->halafinet->cellAttributes() ?>>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_appeal_halafinet" class="el_appeal_halafinet">
<span<?= $Page->halafinet->viewAttributes() ?>>
<?= $Page->halafinet->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->crimstate->Visible) { // crimstate ?>
        <td data-name="crimstate"<?= $Page->crimstate->cellAttributes() ?>>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_appeal_crimstate" class="el_appeal_crimstate">
<span<?= $Page->crimstate->viewAttributes() ?>>
<?= $Page->crimstate->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->Description->Visible) { // Description ?>
        <td data-name="Description"<?= $Page->Description->cellAttributes() ?>>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_appeal_Description" class="el_appeal_Description">
<span<?= $Page->Description->viewAttributes() ?>>
<?= $Page->Description->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->midib->Visible) { // midib ?>
        <td data-name="midib"<?= $Page->midib->cellAttributes() ?>>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_appeal_midib" class="el_appeal_midib">
<span<?= $Page->midib->viewAttributes() ?>>
<?= $Page->midib->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->appealask->Visible) { // appealask ?>
        <td data-name="appealask"<?= $Page->appealask->cellAttributes() ?>>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_appeal_appealask" class="el_appeal_appealask">
<span<?= $Page->appealask->viewAttributes() ?>>
<?= $Page->appealask->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->AppealDescription->Visible) { // AppealDescription ?>
        <td data-name="AppealDescription"<?= $Page->AppealDescription->cellAttributes() ?>>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_appeal_AppealDescription" class="el_appeal_AppealDescription">
<span<?= $Page->AppealDescription->viewAttributes() ?>>
<?= $Page->AppealDescription->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->appealDecision->Visible) { // appealDecision ?>
        <td data-name="appealDecision"<?= $Page->appealDecision->cellAttributes() ?>>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_appeal_appealDecision" class="el_appeal_appealDecision">
<span<?= $Page->appealDecision->viewAttributes() ?>>
<?= $Page->appealDecision->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->created_at->Visible) { // created_at ?>
        <td data-name="created_at"<?= $Page->created_at->cellAttributes() ?>>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_appeal_created_at" class="el_appeal_created_at">
<span<?= $Page->created_at->viewAttributes() ?>>
<?= $Page->created_at->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->crimeDate->Visible) { // crimeDate ?>
        <td data-name="crimeDate"<?= $Page->crimeDate->cellAttributes() ?>>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_appeal_crimeDate" class="el_appeal_crimeDate">
<span<?= $Page->crimeDate->viewAttributes() ?>>
<?= $Page->crimeDate->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->updated_at->Visible) { // updated_at ?>
        <td data-name="updated_at"<?= $Page->updated_at->cellAttributes() ?>>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_appeal_updated_at" class="el_appeal_updated_at">
<span<?= $Page->updated_at->viewAttributes() ?>>
<?= $Page->updated_at->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->updated_by->Visible) { // updated_by ?>
        <td data-name="updated_by"<?= $Page->updated_by->cellAttributes() ?>>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_appeal_updated_by" class="el_appeal_updated_by">
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
    ew.addEventHandlers("appeal");
});
</script>
<script>
loadjs.ready("load", function () {
    // Write your table-specific startup script here, no need to add script tags.
});
</script>
<?php } ?>
