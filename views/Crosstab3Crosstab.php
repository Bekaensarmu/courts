<?php

namespace PHPMaker2024\project2;

// Page object
$Crosstab3Crosstab = &$Page;
?>
<?php if (!$Page->isExport() && !$Page->DrillDown && !$DashboardReport) { ?>
<script>
var currentTable = <?= JsonEncode($Page->toClientVar()) ?>;
ew.deepAssign(ew.vars, { tables: { Crosstab3: currentTable } });
var currentPageID = ew.PAGE_ID = "crosstab";
var currentForm;
</script>
<script>
loadjs.ready("head", function () {
    // Write your table-specific client script here, no need to add script tags.
});
</script>
<?php } ?>
<a id="top"></a>
<!-- Content Container -->
<div id="ew-report" class="ew-report container-fluid">
<?php if ($Page->ShowCurrentFilter) { ?>
<?php $Page->showFilterList() ?>
<?php } ?>
<div class="btn-toolbar ew-toolbar">
<?php
if (!$Page->DrillDownInPanel) {
    $Page->ExportOptions->render("body");
    $Page->SearchOptions->render("body");
    $Page->FilterOptions->render("body");
}
?>
</div>
<?php if (!$Page->isExport() && !$Page->DrillDown && !$DashboardReport) { ?>
<form name="fCrosstab3srch" id="fCrosstab3srch" class="ew-form ew-ext-search-form" action="<?= CurrentPageUrl(false) ?>" novalidate autocomplete="off">
<div id="fCrosstab3srch_search_panel" class="mb-2 mb-sm-0 <?= $Page->SearchPanelClass ?>"><!-- .ew-search-panel -->
<script>
var currentTable = <?= JsonEncode($Page->toClientVar()) ?>;
ew.deepAssign(ew.vars, { tables: { Crosstab3: currentTable } });
var currentPageID = ew.PAGE_ID = "crosstab";
var currentForm;
var fCrosstab3srch, currentSearchForm, currentAdvancedSearchForm;
loadjs.ready(["wrapper", "head"], function () {
    let $ = jQuery,
        fields = currentTable.fields;

    // Form object for search
    let form = new ew.FormBuilder()
        .setId("fCrosstab3srch")
        .setPageId("crosstab")
<?php if ($Page->UseAjaxActions) { ?>
        .setSubmitWithFetch(true)
<?php } ?>

        // Add fields
        .addFields([
        ])
        // Validate form
        .setValidate(
            async function () {
                if (!this.validateRequired)
                    return true; // Ignore validation
                let fobj = this.getForm();

                // Validate fields
                if (!this.validateFields())
                    return false;

                // Call Form_CustomValidate event
                if (!(await this.customValidate?.(fobj) ?? true)) {
                    this.focus();
                    return false;
                }
                return true;
            }
        )

        // Form_CustomValidate
        .setCustomValidate(
            function (fobj) { // DO NOT CHANGE THIS LINE! (except for adding "async" keyword)!
                    // Your custom validation code here, return false if invalid.
                    return true;
                }
        )

        // Use JavaScript validation or not
        .setValidateRequired(ew.CLIENT_VALIDATE)

        // Dynamic selection lists
        .setLists({
        })

        // Filters
        .setFilterList(<?= $Page->getFilterList() ?>)
        .build();
    window[form.id] = form;
    loadjs.done(form.id);
});
</script>
<input type="hidden" name="cmd" value="search">
<?php if ($Security->canSearch()) { ?>
<?php if (!$Page->isExport() && !($Page->CurrentAction && $Page->CurrentAction != "search") && $Page->hasSearchFields()) { ?>
<div class="ew-extended-search container-fluid ps-2">
<div class="row mb-0<?= ($Page->SearchFieldsPerRow > 0) ? " row-cols-sm-" . $Page->SearchFieldsPerRow : "" ?>">
<?php
// Render search row
$Page->RowType = RowType::SEARCH;
$Page->resetAttributes();
$Page->renderRow();
?>
<?php if ($Page->appealDate->Visible) { // appealDate ?>
<?php
if (!$Page->appealDate->UseFilter) {
    $Page->SearchColumnCount++;
}
?>
    <div id="xs_appealDate" class="col-sm-auto d-sm-flex align-items-start mb-3 px-0 pe-sm-2<?= $Page->appealDate->UseFilter ? " ew-filter-field" : "" ?>">
        <label for="YEAR__appealDate" class="ew-search-caption ew-label"><?= $Language->phrase("Year") ?></label>
        <div class="ew-search-field">
            <select id="YEAR__appealDate" class="form-select" name="YEAR__appealDate">
            <?php
                // Set up year selector
                if (is_array($Page->YEAR__appealDate->DistinctValues)) {
                    $yearCount = count($Page->YEAR__appealDate->DistinctValues);
                    for ($yi = 0; $yi < $yearCount; $yi++) {
                        $yearValue = $Page->YEAR__appealDate->DistinctValues[$yi];
                        $yearSelected = SameString($yearValue, $Page->YEAR__appealDate->CurrentValue) ? " selected" : "";
            ?>
                <option value="<?= HtmlEncode($yearValue) ?>"<?= $yearSelected ?>><?= $yearValue ?></option>
            <?php
                    }
                }
            ?>
            </select>
        </div><!-- /.ew-search-field -->
    </div><!-- /.col-sm-auto -->
<?php } ?>
<?php if ($Page->SearchColumnCount > 0) { ?>
   <div class="col-sm-auto mb-3">
       <button class="btn btn-primary" name="btn-submit" id="btn-submit" type="submit"><?= $Language->phrase("SearchBtn") ?></button>
   </div>
<?php } ?>
</div><!-- /.row -->
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
<?php if ($Page->ShowReport) { ?>
<!-- Crosstab report (begin) -->
<main class="report-crosstab<?= ($Page->TotalGroups == 0) ? " ew-no-record" : "" ?>">
<?php
while ($Page->GroupCount <= count($Page->GroupRecords) && $Page->GroupCount <= $Page->DisplayGroups) {
?>
<?php
    // Show header
    if ($Page->ShowHeader) {
?>
<?php if ($Page->GroupCount > 1) { ?>
</tbody>
</table>
</div>
<!-- /.ew-grid-middle-panel -->
<!-- Report grid (end) -->
<?php if ($Page->TotalGroups > 0) { ?>
<?php if (!$Page->isExport() && !($Page->DrillDown && $Page->TotalGroups > 0) && $Page->Pager->Visible) { ?>
<!-- Bottom pager -->
<div class="card-footer ew-grid-lower-panel">
<?= $Page->Pager->render() ?>
</div>
<?php } ?>
<?php } ?>
</div>
<!-- /.ew-grid -->
<?= $Page->PageBreakHtml ?>
<?php } ?>
<div class="<?= $Page->ReportContainerClass ?>">
<?php if (!$Page->isExport() && !($Page->DrillDown && $Page->TotalGroups > 0) && $Page->Pager->Visible) { ?>
<!-- Top pager -->
<div class="card-header ew-grid-upper-panel">
<?= $Page->Pager->render() ?>
</div>
<?php } ?>
<!-- Report grid (begin) -->
<div id="gmp_Crosstab3" class="card-body ew-grid-middle-panel <?= $Page->TableContainerClass ?>">
<table class="<?= $Page->TableClass ?>">
<thead>
	<!-- Table header -->
    <tr class="ew-table-header">
<?php if ($Page->GroupColumnCount > 0) { ?>
        <td class="ew-rpt-col-summary" colspan="<?= $Page->GroupColumnCount ?>"><div><?= $Page->renderSummaryCaptions() ?></div></td>
<?php } ?>
        <td class="ew-rpt-col-header" colspan="<?= @$Page->ColumnSpan ?>">
            <div class="ew-table-header-btn">
                <span class="ew-table-header-caption"><?= $Page->appealDate->caption() ?></span>
            </div>
        </td>
    </tr>
    <tr class="ew-table-header">
<?php if ($Page->rank->Visible) { ?>
    <td data-field="rank"><div><?= $Page->renderFieldHeader($Page->rank) ?></div></td>
<?php } ?>
<!-- Dynamic columns begin -->
<?php
    $cntval = count($Page->Columns);
    for ($iy = 1; $iy < $cntval; $iy++) {
        if ($Page->Columns[$iy]->Visible) {
            $Page->SummaryCurrentValues[$iy - 1] = $Page->Columns[$iy]->Caption;
            $Page->SummaryViewValues[$iy - 1] = $Page->SummaryCurrentValues[$iy - 1];
?>
        <td class="ew-table-header"<?= $Page->appealDate->cellAttributes() ?>><div<?= $Page->appealDate->viewAttributes() ?>><?= $Page->SummaryViewValues[$iy-1]; ?></div></td>
<?php
        }
    }
?>
<!-- Dynamic columns end -->
        <td class="ew-table-header"<?= $Page->appealDate->cellAttributes() ?>><div<?= $Page->appealDate->viewAttributes() ?>><?= $Page->renderSummaryCaptions() ?></div></td>
    </tr>
</thead>
<tbody>
<?php
        if ($Page->TotalGroups == 0) {
            break; // Show header only
        }
        $Page->ShowHeader = false;
    } // End show header
?>
<?php

    // Build detail SQL
    $where = DetailFilterSql($Page->rank, $Page->getSqlFirstGroupField(), $Page->rank->groupValue(), $Page->Dbid);
    AddFilter($Page->PageFirstGroupFilter, $where, "OR");
    AddFilter($where, $Page->Filter);
    $sql = $Page->buildReportSql($Page->getSqlSelect()->addSelect($Page->DistinctColumnFields), $Page->getSqlFrom(), $Page->getSqlWhere(), $Page->getSqlGroupBy(), "", $Page->getSqlOrderBy(), $where, $Page->Sort);
    $rs = $sql->executeQuery();
    $Page->DetailRecords = $rs?->fetchAll() ?? [];
    $Page->DetailRecordCount = count($Page->DetailRecords);

    // Load detail records
    $Page->rank->Records = &$Page->DetailRecords;
    $Page->rank->LevelBreak = true; // Set field level break
        foreach ($Page->rank->Records as $record) {
            $Page->RecordCount++;
            $Page->RecordIndex++;
            $Page->loadRowValues($record);

            // Render row
            $Page->resetAttributes();
            $Page->RowType = RowType::DETAIL;
            $Page->renderRow();
?>
	<tr<?= $Page->rowAttributes(); ?>>
<?php if ($Page->rank->Visible) { ?>
        <!-- rank -->
        <td data-field="rank"<?= $Page->rank->cellAttributes() ?>><span<?= $Page->rank->viewAttributes() ?>><?= $Page->rank->GroupViewValue ?></span></td>
<?php } ?>
<!-- Dynamic columns begin -->
<?php
        $cntcol = count($Page->SummaryViewValues);
        for ($iy = 1; $iy <= $cntcol; $iy++) {
            $colShow = ($iy <= $Page->ColumnCount) ? $Page->Columns[$iy]->Visible : true;
            $colDesc = ($iy <= $Page->ColumnCount) ? $Page->Columns[$iy]->Caption : $Language->phrase("Summary");
            if ($colShow) {
?>
        <!-- <?= $colDesc; ?> -->
        <td<?= $Page->summaryCellAttributes($iy-1) ?>><?= $Page->renderSummaryFields($iy-1) ?></td>
<?php
            }
        }
?>
<!-- Dynamic columns end -->
    </tr>
<?php
    }
?>
<?php

    // Next group
    $Page->loadGroupRowValues();

    // Show header if page break
    if ($Page->isExport()) {
        $Page->ShowHeader = ($Page->ExportPageBreakCount == 0) ? false : ($Page->GroupCount % $Page->ExportPageBreakCount == 0);
    }

    // Page_Breaking server event
    if ($Page->ShowHeader) {
        $Page->pageBreaking($Page->ShowHeader, $Page->PageBreakHtml);
    }
    $Page->GroupCount++;
} // End while
?>
<?php if ($Page->TotalGroups > 0) { ?>
</tbody>
<tfoot>
<?php
    $Page->resetAttributes();
    $Page->RowType = RowType::TOTAL;
    $Page->RowTotalType = RowSummary::GRAND;
    $Page->RowAttrs["class"] = "ew-rpt-grand-summary";
    $Page->renderRow();
?>
    <!-- Grand Total -->
    <tr<?= $Page->rowAttributes(); ?>>
<?php if ($Page->GroupColumnCount > 0) { ?>
    <td colspan="<?= $Page->GroupColumnCount ?>"><?= $Page->renderSummaryCaptions("grand") ?></td>
<?php } ?>
<!-- Dynamic columns begin -->
<?php
    $cntcol = count($Page->SummaryViewValues);
    for ($iy = 1; $iy <= $cntcol; $iy++) {
        $colShow = ($iy <= $Page->ColumnCount) ? $Page->Columns[$iy]->Visible : true;
        $colDesc = ($iy <= $Page->ColumnCount) ? $Page->Columns[$iy]->Caption : $Language->phrase("Summary");
        if ($colShow) {
?>
        <!-- <?= $colDesc; ?> -->
        <td<?= $Page->summaryCellAttributes($iy-1) ?>><?= $Page->renderSummaryFields($iy-1) ?></td>
<?php
        }
    }
?>
<!-- Dynamic columns end -->
    </tr>
</tfoot>
</table>
</div>
<!-- /.ew-grid-middle-panel -->
<!-- Report grid (end) -->
<?php if ($Page->TotalGroups > 0) { ?>
<?php if (!$Page->isExport() && !($Page->DrillDown && $Page->TotalGroups > 0) && $Page->Pager->Visible) { ?>
<!-- Bottom pager -->
<div class="card-footer ew-grid-lower-panel">
<?= $Page->Pager->render() ?>
</div>
<?php } ?>
<?php } ?>
</div>
<!-- /.ew-grid -->
<?php } ?>
</main>
<!-- /.report-crosstab -->
<!-- Crosstab report (end) -->
<?php } ?>
</div>
<!-- /.ew-report -->
<?php
$Page->showPageFooter();
echo GetDebugMessage();
?>
<?php if (!$Page->isExport() && !$Page->DrillDown && !$DashboardReport) { ?>
<script>
loadjs.ready("load", function () {
    // Write your table-specific startup script here, no need to add script tags.
});
</script>
<?php } ?>
