<?php

namespace PHPMaker2024\project2;

// Page object
$Report5Summary = &$Page;
?>
<?php if (!$Page->isExport() && !$Page->DrillDown && !$DashboardReport) { ?>
<script>
var currentTable = <?= JsonEncode($Page->toClientVar()) ?>;
ew.deepAssign(ew.vars, { tables: { Report5: currentTable } });
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
<form name="fReport5srch" id="fReport5srch" class="ew-form ew-ext-search-form" action="<?= CurrentPageUrl(false) ?>" novalidate autocomplete="off">
<div id="fReport5srch_search_panel" class="mb-2 mb-sm-0 <?= $Page->SearchPanelClass ?>"><!-- .ew-search-panel -->
<script>
var currentTable = <?= JsonEncode($Page->toClientVar()) ?>;
ew.deepAssign(ew.vars, { tables: { Report5: currentTable } });
var currentPageID = ew.PAGE_ID = "summary";
var currentForm;
var fReport5srch, currentSearchForm, currentAdvancedSearchForm;
loadjs.ready(["wrapper", "head"], function () {
    let $ = jQuery,
        fields = currentTable.fields;

    // Form object for search
    let form = new ew.FormBuilder()
        .setId("fReport5srch")
        .setPageId("summary")
<?php if ($Page->UseAjaxActions) { ?>
        .setSubmitWithFetch(true)
<?php } ?>

        // Add fields
        .addFields([
            ["decisionDate", [ew.Validators.datetime(fields.decisionDate.clientFormatPattern)], fields.decisionDate.isInvalid],
            ["y_decisionDate", [ew.Validators.between], false]
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
<?php if ($Page->decisionDate->Visible) { // decisionDate ?>
<?php
if (!$Page->decisionDate->UseFilter) {
    $Page->SearchColumnCount++;
}
?>
    <div id="xs_decisionDate" class="col-sm-auto d-sm-flex align-items-start mb-3 px-0 pe-sm-2<?= $Page->decisionDate->UseFilter ? " ew-filter-field" : "" ?>">
        <div class="d-flex my-1 my-sm-0">
            <label for="x_decisionDate" class="ew-search-caption ew-label"><?= $Page->decisionDate->caption() ?></label>
            <div class="ew-search-operator">
<?= $Language->phrase("BETWEEN") ?>
<input type="hidden" name="z_decisionDate" id="z_decisionDate" value="BETWEEN">
</div>
        </div>
        <div id="el_Report5_decisionDate" class="ew-search-field">
<input type="<?= $Page->decisionDate->getInputTextType() ?>" name="x_decisionDate" id="x_decisionDate" data-table="Report5" data-field="x_decisionDate" value="<?= $Page->decisionDate->EditValue ?>" placeholder="<?= HtmlEncode($Page->decisionDate->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->decisionDate->formatPattern()) ?>"<?= $Page->decisionDate->editAttributes() ?>>
<div class="invalid-feedback"><?= $Page->decisionDate->getErrorMessage() ?></div>
<?php if (!$Page->decisionDate->ReadOnly && !$Page->decisionDate->Disabled && !isset($Page->decisionDate->EditAttrs["readonly"]) && !isset($Page->decisionDate->EditAttrs["disabled"])) { ?>
<script>
loadjs.ready(["fReport5srch", "datetimepicker"], function () {
    let format = "<?= DateFormat(0) ?>",
        options = {
            localization: {
                locale: ew.LANGUAGE_ID + "-u-nu-" + ew.getNumberingSystem(),
                hourCycle: format.match(/H/) ? "h24" : "h12",
                format,
                ...ew.language.phrase("datetimepicker")
            },
            display: {
                icons: {
                    previous: ew.IS_RTL ? "fa-solid fa-chevron-right" : "fa-solid fa-chevron-left",
                    next: ew.IS_RTL ? "fa-solid fa-chevron-left" : "fa-solid fa-chevron-right"
                },
                components: {
                    hours: !!format.match(/h/i),
                    minutes: !!format.match(/m/),
                    seconds: !!format.match(/s/i)
                },
                theme: ew.getPreferredTheme()
            }
        };
    ew.createDateTimePicker("fReport5srch", "x_decisionDate", ew.deepAssign({"useCurrent":false,"display":{"sideBySide":false}}, options));
});
</script>
<?php } ?>
</div>
        <div class="d-flex my-1 my-sm-0">
            <div class="ew-search-and"><label><?= $Language->phrase("AND") ?></label></div>
        </div><!-- /.ew-search-field -->
        <div id="el2_Report5_decisionDate" class="ew-search-field2">
<input type="<?= $Page->decisionDate->getInputTextType() ?>" name="y_decisionDate" id="y_decisionDate" data-table="Report5" data-field="x_decisionDate" value="<?= $Page->decisionDate->EditValue2 ?>" placeholder="<?= HtmlEncode($Page->decisionDate->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->decisionDate->formatPattern()) ?>"<?= $Page->decisionDate->editAttributes() ?>>
<div class="invalid-feedback"><?= $Page->decisionDate->getErrorMessage() ?></div>
<?php if (!$Page->decisionDate->ReadOnly && !$Page->decisionDate->Disabled && !isset($Page->decisionDate->EditAttrs["readonly"]) && !isset($Page->decisionDate->EditAttrs["disabled"])) { ?>
<script>
loadjs.ready(["fReport5srch", "datetimepicker"], function () {
    let format = "<?= DateFormat(0) ?>",
        options = {
            localization: {
                locale: ew.LANGUAGE_ID + "-u-nu-" + ew.getNumberingSystem(),
                hourCycle: format.match(/H/) ? "h24" : "h12",
                format,
                ...ew.language.phrase("datetimepicker")
            },
            display: {
                icons: {
                    previous: ew.IS_RTL ? "fa-solid fa-chevron-right" : "fa-solid fa-chevron-left",
                    next: ew.IS_RTL ? "fa-solid fa-chevron-left" : "fa-solid fa-chevron-right"
                },
                components: {
                    hours: !!format.match(/h/i),
                    minutes: !!format.match(/m/),
                    seconds: !!format.match(/s/i)
                },
                theme: ew.getPreferredTheme()
            }
        };
    ew.createDateTimePicker("fReport5srch", "y_decisionDate", ew.deepAssign({"useCurrent":false,"display":{"sideBySide":false}}, options));
});
</script>
<?php } ?>
</div>
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
<div id="gmp_Report5" class="card-body ew-grid-middle-panel <?= $Page->TableContainerClass ?>">
<table class="<?= $Page->TableClass ?>">
<thead>
	<!-- Table header -->
    <tr class="ew-table-header">
<?php if ($Page->decisionDate->Visible) { ?>
    <?php if ($Page->decisionDate->ShowGroupHeaderAsRow) { ?>
    <th data-name="decisionDate"<?= $Page->decisionDate->cellAttributes("ew-rpt-grp-caret") ?>><?= $Page->decisionDate->groupToggleIcon() ?></th>
    <?php } else { ?>
    <th data-name="decisionDate" class="<?= $Page->decisionDate->headerCellClass() ?>"><div class="Report5_decisionDate"><?= $Page->renderFieldHeader($Page->decisionDate) ?></div></th>
    <?php } ?>
<?php } ?>
<?php if ($Page->Decisiontype->Visible) { ?>
    <th data-name="Decisiontype" class="<?= $Page->Decisiontype->headerCellClass() ?>"><div class="Report5_Decisiontype"><?= $Page->renderFieldHeader($Page->Decisiontype) ?></div></th>
<?php } ?>
<?php if ($Page->Description->Visible) { ?>
    <th data-name="Description" class="<?= $Page->Description->headerCellClass() ?>"><div class="Report5_Description"><?= $Page->renderFieldHeader($Page->Description) ?></div></th>
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
    $where = DetailFilterSql($Page->decisionDate, $Page->getSqlFirstGroupField(), $Page->decisionDate->groupValue(), $Page->Dbid);
    AddFilter($Page->PageFirstGroupFilter, $where, "OR");
    AddFilter($where, $Page->Filter);
    $sql = $Page->buildReportSql($Page->getSqlSelect(), $Page->getSqlFrom(), $Page->getSqlWhere(), $Page->getSqlGroupBy(), $Page->getSqlHaving(), $Page->getSqlOrderBy(), $where, $Page->Sort);
    $rs = $sql->executeQuery();
    $Page->DetailRecords = $rs?->fetchAll() ?? [];
    $Page->DetailRecordCount = count($Page->DetailRecords);
    $Page->setGroupCount($Page->DetailRecordCount, $Page->GroupCount);

    // Load detail records
    $Page->decisionDate->Records = &$Page->DetailRecords;
    $Page->decisionDate->LevelBreak = true; // Set field level break
        $Page->GroupCounter[1] = $Page->GroupCount;
        $Page->decisionDate->getCnt($Page->decisionDate->Records); // Get record count
        $Page->setGroupCount($Page->decisionDate->Count, $Page->GroupCounter[1]);
?>
<?php if ($Page->decisionDate->Visible && $Page->decisionDate->ShowGroupHeaderAsRow) { ?>
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
<?php if ($Page->decisionDate->Visible) { ?>
        <td data-field="decisionDate"<?= $Page->decisionDate->cellAttributes("ew-rpt-grp-caret") ?>><?= $Page->decisionDate->groupToggleIcon() ?></td>
<?php } ?>
        <td data-field="decisionDate" colspan="<?= ($Page->GroupColumnCount + $Page->DetailColumnCount - 1) ?>"<?= $Page->decisionDate->cellAttributes() ?>>
            <span class="ew-summary-caption Report5_decisionDate"><?= $Page->renderFieldHeader($Page->decisionDate) ?></span><?= $Language->phrase("SummaryColon") ?><span<?= $Page->decisionDate->viewAttributes() ?>><?= $Page->decisionDate->GroupViewValue ?></span>
            <span class="ew-summary-count">(<span class="ew-aggregate-caption"><?= $Language->phrase("RptCnt") ?></span><span class="ew-aggregate-equal"><?= $Language->phrase("AggregateEqual") ?></span><span class="ew-aggregate-value"><?= FormatNumber($Page->decisionDate->Count, Config("DEFAULT_NUMBER_FORMAT")) ?></span>)</span>
        </td>
    </tr>
<?php } ?>
<?php
        $Page->RecordCount = 0; // Reset record count
        foreach ($Page->decisionDate->Records as $record) {
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
<?php if ($Page->decisionDate->Visible) { ?>
    <?php if ($Page->decisionDate->ShowGroupHeaderAsRow) { ?>
        <td data-field="decisionDate"<?= $Page->decisionDate->cellAttributes() ?>></td>
    <?php } else { ?>
        <td data-field="decisionDate"<?= $Page->decisionDate->cellAttributes() ?>><span<?= $Page->decisionDate->viewAttributes() ?>><?= $Page->decisionDate->GroupViewValue ?></span></td>
    <?php } ?>
<?php } ?>
<?php if ($Page->Decisiontype->Visible) { ?>
        <td data-field="Decisiontype"<?= $Page->Decisiontype->cellAttributes() ?>>
<span<?= $Page->Decisiontype->viewAttributes() ?>>
<?= $Page->Decisiontype->getViewValue() ?></span>
</td>
<?php } ?>
<?php if ($Page->Description->Visible) { ?>
        <td data-field="Description"<?= $Page->Description->cellAttributes() ?>>
<span<?= $Page->Description->viewAttributes() ?>>
<?= $Page->Description->getViewValue() ?></span>
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
