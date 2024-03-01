<?php

namespace PHPMaker2024\project2;

// Page object
$Report3Summary = &$Page;
?>
<?php if (!$Page->isExport() && !$Page->DrillDown && !$DashboardReport) { ?>
<script>
var currentTable = <?= JsonEncode($Page->toClientVar()) ?>;
ew.deepAssign(ew.vars, { tables: { Report3: currentTable } });
var currentPageID = ew.PAGE_ID = "summary";
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
<form name="fReport3srch" id="fReport3srch" class="ew-form ew-ext-search-form" action="<?= CurrentPageUrl(false) ?>" novalidate autocomplete="off">
<div id="fReport3srch_search_panel" class="mb-2 mb-sm-0 <?= $Page->SearchPanelClass ?>"><!-- .ew-search-panel -->
<script>
var currentTable = <?= JsonEncode($Page->toClientVar()) ?>;
ew.deepAssign(ew.vars, { tables: { Report3: currentTable } });
var currentPageID = ew.PAGE_ID = "summary";
var currentForm;
var fReport3srch, currentSearchForm, currentAdvancedSearchForm;
loadjs.ready(["wrapper", "head"], function () {
    let $ = jQuery,
        fields = currentTable.fields;

    // Form object for search
    let form = new ew.FormBuilder()
        .setId("fReport3srch")
        .setPageId("summary")
<?php if ($Page->UseAjaxActions) { ?>
        .setSubmitWithFetch(true)
<?php } ?>

        // Add fields
        .addFields([
            ["fileNumber", [], fields.fileNumber.isInvalid]
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
<?php if ($Page->fileNumber->Visible) { // fileNumber ?>
<?php
if (!$Page->fileNumber->UseFilter) {
    $Page->SearchColumnCount++;
}
?>
    <div id="xs_fileNumber" class="col-sm-auto d-sm-flex align-items-start mb-3 px-0 pe-sm-2<?= $Page->fileNumber->UseFilter ? " ew-filter-field" : "" ?>">
        <div class="d-flex my-1 my-sm-0">
            <label for="x_fileNumber" class="ew-search-caption ew-label"><?= $Page->fileNumber->caption() ?></label>
            <div class="ew-search-operator">
<?= $Language->phrase("=") ?>
<input type="hidden" name="z_fileNumber" id="z_fileNumber" value="=">
</div>
        </div>
        <div id="el_Report3_fileNumber" class="ew-search-field">
<input type="<?= $Page->fileNumber->getInputTextType() ?>" name="x_fileNumber" id="x_fileNumber" data-table="Report3" data-field="x_fileNumber" value="<?= $Page->fileNumber->EditValue ?>" size="30" maxlength="255" placeholder="<?= HtmlEncode($Page->fileNumber->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->fileNumber->formatPattern()) ?>"<?= $Page->fileNumber->editAttributes() ?>>
<div class="invalid-feedback"><?= $Page->fileNumber->getErrorMessage() ?></div>
</div>
        <div class="d-flex my-1 my-sm-0">
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
<!-- Summary report (begin) -->
<main class="report-summary<?= ($Page->TotalGroups == 0) ? " ew-no-record" : "" ?>">
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
<div id="gmp_Report3" class="card-body ew-grid-middle-panel <?= $Page->TableContainerClass ?>">
<table class="<?= $Page->TableClass ?>">
<thead>
	<!-- Table header -->
    <tr class="ew-table-header">
<?php if ($Page->fileNumber->Visible) { ?>
    <?php if ($Page->fileNumber->ShowGroupHeaderAsRow) { ?>
    <th data-name="fileNumber"<?= $Page->fileNumber->cellAttributes("ew-rpt-grp-caret") ?>><?= $Page->fileNumber->groupToggleIcon() ?></th>
    <?php } else { ?>
    <th data-name="fileNumber" class="<?= $Page->fileNumber->headerCellClass() ?>"><div class="Report3_fileNumber"><?= $Page->renderFieldHeader($Page->fileNumber) ?></div></th>
    <?php } ?>
<?php } ?>
<?php if ($Page->name->Visible) { ?>
    <th data-name="name" class="<?= $Page->name->headerCellClass() ?>"><div class="Report3_name"><?= $Page->renderFieldHeader($Page->name) ?></div></th>
<?php } ?>
<?php if ($Page->yekisaynet->Visible) { ?>
    <th data-name="yekisaynet" class="<?= $Page->yekisaynet->headerCellClass() ?>"><div class="Report3_yekisaynet"><?= $Page->renderFieldHeader($Page->yekisaynet) ?></div></th>
<?php } ?>
<?php if ($Page->ez->Visible) { ?>
    <th data-name="ez" class="<?= $Page->ez->headerCellClass() ?>"><div class="Report3_ez"><?= $Page->renderFieldHeader($Page->ez) ?></div></th>
<?php } ?>
<?php if ($Page->kirihidet->Visible) { ?>
    <th data-name="kirihidet" class="<?= $Page->kirihidet->headerCellClass() ?>"><div class="Report3_kirihidet"><?= $Page->renderFieldHeader($Page->kirihidet) ?></div></th>
<?php } ?>
<?php if ($Page->chilotname->Visible) { ?>
    <th data-name="chilotname" class="<?= $Page->chilotname->headerCellClass() ?>"><div class="Report3_chilotname"><?= $Page->renderFieldHeader($Page->chilotname) ?></div></th>
<?php } ?>
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
    $where = DetailFilterSql($Page->fileNumber, $Page->getSqlFirstGroupField(), $Page->fileNumber->groupValue(), $Page->Dbid);
    AddFilter($Page->PageFirstGroupFilter, $where, "OR");
    AddFilter($where, $Page->Filter);
    $sql = $Page->buildReportSql($Page->getSqlSelect(), $Page->getSqlFrom(), $Page->getSqlWhere(), $Page->getSqlGroupBy(), $Page->getSqlHaving(), $Page->getSqlOrderBy(), $where, $Page->Sort);
    $rs = $sql->executeQuery();
    $Page->DetailRecords = $rs?->fetchAll() ?? [];
    $Page->DetailRecordCount = count($Page->DetailRecords);
    $Page->setGroupCount($Page->DetailRecordCount, $Page->GroupCount);

    // Load detail records
    $Page->fileNumber->Records = &$Page->DetailRecords;
    $Page->fileNumber->LevelBreak = true; // Set field level break
        $Page->GroupCounter[1] = $Page->GroupCount;
        $Page->fileNumber->getCnt($Page->fileNumber->Records); // Get record count
        $Page->setGroupCount($Page->fileNumber->Count, $Page->GroupCounter[1]);
?>
<?php if ($Page->fileNumber->Visible && $Page->fileNumber->ShowGroupHeaderAsRow) { ?>
<?php
        // Render header row
        $Page->resetAttributes();
        $Page->RowType = RowType::TOTAL;
        $Page->RowTotalType = RowSummary::GROUP;
        $Page->RowTotalSubType = RowTotal::HEADER;
        $Page->RowGroupLevel = 1;
        $Page->renderRow();
?>
    <tr<?= $Page->rowAttributes(); ?>>
<?php if ($Page->fileNumber->Visible) { ?>
        <td data-field="fileNumber"<?= $Page->fileNumber->cellAttributes("ew-rpt-grp-caret") ?>><?= $Page->fileNumber->groupToggleIcon() ?></td>
<?php } ?>
        <td data-field="fileNumber" colspan="<?= ($Page->GroupColumnCount + $Page->DetailColumnCount - 1) ?>"<?= $Page->fileNumber->cellAttributes() ?>>
            <span class="ew-summary-caption Report3_fileNumber"><?= $Page->renderFieldHeader($Page->fileNumber) ?></span><?= $Language->phrase("SummaryColon") ?><span<?= $Page->fileNumber->viewAttributes() ?>><?= $Page->fileNumber->GroupViewValue ?></span>
            <span class="ew-summary-count">(<span class="ew-aggregate-caption"><?= $Language->phrase("RptCnt") ?></span><span class="ew-aggregate-equal"><?= $Language->phrase("AggregateEqual") ?></span><span class="ew-aggregate-value"><?= FormatNumber($Page->fileNumber->Count, Config("DEFAULT_NUMBER_FORMAT")) ?></span>)</span>
        </td>
    </tr>
<?php } ?>
<?php
        $Page->RecordCount = 0; // Reset record count
        foreach ($Page->fileNumber->Records as $record) {
            $Page->RecordCount++;
            $Page->RecordIndex++;
            $Page->loadRowValues($record);
?>
<?php
        // Render detail row
        $Page->resetAttributes();
        $Page->RowType = RowType::DETAIL;
        $Page->renderRow();
?>
    <tr<?= $Page->rowAttributes(); ?>>
<?php if ($Page->fileNumber->Visible) { ?>
    <?php if ($Page->fileNumber->ShowGroupHeaderAsRow) { ?>
        <td data-field="fileNumber"<?= $Page->fileNumber->cellAttributes() ?>></td>
    <?php } else { ?>
        <td data-field="fileNumber"<?= $Page->fileNumber->cellAttributes() ?>><span<?= $Page->fileNumber->viewAttributes() ?>><?= $Page->fileNumber->GroupViewValue ?></span></td>
    <?php } ?>
<?php } ?>
<?php if ($Page->name->Visible) { ?>
        <td data-field="name"<?= $Page->name->cellAttributes() ?>>
<span<?= $Page->name->viewAttributes() ?>>
<?= $Page->name->getViewValue() ?></span>
</td>
<?php } ?>
<?php if ($Page->yekisaynet->Visible) { ?>
        <td data-field="yekisaynet"<?= $Page->yekisaynet->cellAttributes() ?>>
<span<?= $Page->yekisaynet->viewAttributes() ?>>
<?= $Page->yekisaynet->getViewValue() ?></span>
</td>
<?php } ?>
<?php if ($Page->ez->Visible) { ?>
        <td data-field="ez"<?= $Page->ez->cellAttributes() ?>>
<span<?= $Page->ez->viewAttributes() ?>>
<?= $Page->ez->getViewValue() ?></span>
</td>
<?php } ?>
<?php if ($Page->kirihidet->Visible) { ?>
        <td data-field="kirihidet"<?= $Page->kirihidet->cellAttributes() ?>>
<span<?= $Page->kirihidet->viewAttributes() ?>>
<?= $Page->kirihidet->getViewValue() ?></span>
</td>
<?php } ?>
<?php if ($Page->chilotname->Visible) { ?>
        <td data-field="chilotname"<?= $Page->chilotname->cellAttributes() ?>>
<span<?= $Page->chilotname->viewAttributes() ?>>
<?= $Page->chilotname->getViewValue() ?></span>
</td>
<?php } ?>
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
<!-- /.report-summary -->
<!-- Summary report (end) -->
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
