<?php

namespace PHPMaker2024\project2;

// Page object
$Report2Summary = &$Page;
?>
<?php if (!$Page->isExport() && !$Page->DrillDown && !$DashboardReport) { ?>
<script>
var currentTable = <?= JsonEncode($Page->toClientVar()) ?>;
ew.deepAssign(ew.vars, { tables: { Report2: currentTable } });
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
<form name="fReport2srch" id="fReport2srch" class="ew-form ew-ext-search-form" action="<?= CurrentPageUrl(false) ?>" novalidate autocomplete="off">
<div id="fReport2srch_search_panel" class="mb-2 mb-sm-0 <?= $Page->SearchPanelClass ?>"><!-- .ew-search-panel -->
<script>
var currentTable = <?= JsonEncode($Page->toClientVar()) ?>;
ew.deepAssign(ew.vars, { tables: { Report2: currentTable } });
var currentPageID = ew.PAGE_ID = "summary";
var currentForm;
var fReport2srch, currentSearchForm, currentAdvancedSearchForm;
loadjs.ready(["wrapper", "head"], function () {
    let $ = jQuery,
        fields = currentTable.fields;

    // Form object for search
    let form = new ew.FormBuilder()
        .setId("fReport2srch")
        .setPageId("summary")
<?php if ($Page->UseAjaxActions) { ?>
        .setSubmitWithFetch(true)
<?php } ?>

        // Add fields
        .addFields([
            ["melequtir", [], fields.melequtir.isInvalid],
            ["fileNumber", [], fields.fileNumber.isInvalid],
            ["created_at", [ew.Validators.datetime(fields.created_at.clientFormatPattern)], fields.created_at.isInvalid],
            ["y_created_at", [ew.Validators.between], false]
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
<?php if ($Page->melequtir->Visible) { // melequtir ?>
<?php
if (!$Page->melequtir->UseFilter) {
    $Page->SearchColumnCount++;
}
?>
    <div id="xs_melequtir" class="col-sm-auto d-sm-flex align-items-start mb-3 px-0 pe-sm-2<?= $Page->melequtir->UseFilter ? " ew-filter-field" : "" ?>">
        <div class="d-flex my-1 my-sm-0">
            <label for="x_melequtir" class="ew-search-caption ew-label"><?= $Page->melequtir->caption() ?></label>
            <div class="ew-search-operator">
<?= $Language->phrase("=") ?>
<input type="hidden" name="z_melequtir" id="z_melequtir" value="=">
</div>
        </div>
        <div id="el_Report2_melequtir" class="ew-search-field">
<input type="<?= $Page->melequtir->getInputTextType() ?>" name="x_melequtir" id="x_melequtir" data-table="Report2" data-field="x_melequtir" value="<?= $Page->melequtir->EditValue ?>" size="30" maxlength="50" placeholder="<?= HtmlEncode($Page->melequtir->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->melequtir->formatPattern()) ?>"<?= $Page->melequtir->editAttributes() ?>>
<div class="invalid-feedback"><?= $Page->melequtir->getErrorMessage() ?></div>
</div>
        <div class="d-flex my-1 my-sm-0">
        </div><!-- /.ew-search-field -->
    </div><!-- /.col-sm-auto -->
<?php } ?>
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
        <div id="el_Report2_fileNumber" class="ew-search-field">
<input type="<?= $Page->fileNumber->getInputTextType() ?>" name="x_fileNumber" id="x_fileNumber" data-table="Report2" data-field="x_fileNumber" value="<?= $Page->fileNumber->EditValue ?>" size="30" maxlength="255" placeholder="<?= HtmlEncode($Page->fileNumber->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->fileNumber->formatPattern()) ?>"<?= $Page->fileNumber->editAttributes() ?>>
<div class="invalid-feedback"><?= $Page->fileNumber->getErrorMessage() ?></div>
</div>
        <div class="d-flex my-1 my-sm-0">
        </div><!-- /.ew-search-field -->
    </div><!-- /.col-sm-auto -->
<?php } ?>
<?php if ($Page->created_at->Visible) { // created_at ?>
<?php
if (!$Page->created_at->UseFilter) {
    $Page->SearchColumnCount++;
}
?>
    <div id="xs_created_at" class="col-sm-auto d-sm-flex align-items-start mb-3 px-0 pe-sm-2<?= $Page->created_at->UseFilter ? " ew-filter-field" : "" ?>">
        <div class="d-flex my-1 my-sm-0">
            <label for="x_created_at" class="ew-search-caption ew-label"><?= $Page->created_at->caption() ?></label>
            <div class="ew-search-operator">
<?= $Language->phrase("BETWEEN") ?>
<input type="hidden" name="z_created_at" id="z_created_at" value="BETWEEN">
</div>
        </div>
        <div id="el_Report2_created_at" class="ew-search-field">
<input type="<?= $Page->created_at->getInputTextType() ?>" name="x_created_at" id="x_created_at" data-table="Report2" data-field="x_created_at" value="<?= $Page->created_at->EditValue ?>" placeholder="<?= HtmlEncode($Page->created_at->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->created_at->formatPattern()) ?>"<?= $Page->created_at->editAttributes() ?>>
<div class="invalid-feedback"><?= $Page->created_at->getErrorMessage() ?></div>
<?php if (!$Page->created_at->ReadOnly && !$Page->created_at->Disabled && !isset($Page->created_at->EditAttrs["readonly"]) && !isset($Page->created_at->EditAttrs["disabled"])) { ?>
<script>
loadjs.ready(["fReport2srch", "datetimepicker"], function () {
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
    ew.createDateTimePicker("fReport2srch", "x_created_at", ew.deepAssign({"useCurrent":false,"display":{"sideBySide":false}}, options));
});
</script>
<?php } ?>
</div>
        <div class="d-flex my-1 my-sm-0">
            <div class="ew-search-and"><label><?= $Language->phrase("AND") ?></label></div>
        </div><!-- /.ew-search-field -->
        <div id="el2_Report2_created_at" class="ew-search-field2">
<input type="<?= $Page->created_at->getInputTextType() ?>" name="y_created_at" id="y_created_at" data-table="Report2" data-field="x_created_at" value="<?= $Page->created_at->EditValue2 ?>" placeholder="<?= HtmlEncode($Page->created_at->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->created_at->formatPattern()) ?>"<?= $Page->created_at->editAttributes() ?>>
<div class="invalid-feedback"><?= $Page->created_at->getErrorMessage() ?></div>
<?php if (!$Page->created_at->ReadOnly && !$Page->created_at->Disabled && !isset($Page->created_at->EditAttrs["readonly"]) && !isset($Page->created_at->EditAttrs["disabled"])) { ?>
<script>
loadjs.ready(["fReport2srch", "datetimepicker"], function () {
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
    ew.createDateTimePicker("fReport2srch", "y_created_at", ew.deepAssign({"useCurrent":false,"display":{"sideBySide":false}}, options));
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
<div id="gmp_Report2" class="card-body ew-grid-middle-panel <?= $Page->TableContainerClass ?>">
<table class="<?= $Page->TableClass ?>">
<thead>
	<!-- Table header -->
    <tr class="ew-table-header">
<?php if ($Page->melequtir->Visible) { ?>
    <?php if ($Page->melequtir->ShowGroupHeaderAsRow) { ?>
    <th data-name="melequtir"<?= $Page->melequtir->cellAttributes("ew-rpt-grp-caret") ?>><?= $Page->melequtir->groupToggleIcon() ?></th>
    <?php } else { ?>
    <th data-name="melequtir" class="<?= $Page->melequtir->headerCellClass() ?>"><div class="Report2_melequtir"><?= $Page->renderFieldHeader($Page->melequtir) ?></div></th>
    <?php } ?>
<?php } ?>
<?php if ($Page->fileNumber->Visible) { ?>
    <th data-name="fileNumber" class="<?= $Page->fileNumber->headerCellClass() ?>"><div class="Report2_fileNumber"><?= $Page->renderFieldHeader($Page->fileNumber) ?></div></th>
<?php } ?>
<?php if ($Page->name->Visible) { ?>
    <th data-name="name" class="<?= $Page->name->headerCellClass() ?>"><div class="Report2_name"><?= $Page->renderFieldHeader($Page->name) ?></div></th>
<?php } ?>
<?php if ($Page->yekisaynet->Visible) { ?>
    <th data-name="yekisaynet" class="<?= $Page->yekisaynet->headerCellClass() ?>"><div class="Report2_yekisaynet"><?= $Page->renderFieldHeader($Page->yekisaynet) ?></div></th>
<?php } ?>
<?php if ($Page->chilotname->Visible) { ?>
    <th data-name="chilotname" class="<?= $Page->chilotname->headerCellClass() ?>"><div class="Report2_chilotname"><?= $Page->renderFieldHeader($Page->chilotname) ?></div></th>
<?php } ?>
<?php if ($Page->ez->Visible) { ?>
    <th data-name="ez" class="<?= $Page->ez->headerCellClass() ?>"><div class="Report2_ez"><?= $Page->renderFieldHeader($Page->ez) ?></div></th>
<?php } ?>
<?php if ($Page->keteroreason->Visible) { ?>
    <th data-name="keteroreason" class="<?= $Page->keteroreason->headerCellClass() ?>"><div class="Report2_keteroreason"><?= $Page->renderFieldHeader($Page->keteroreason) ?></div></th>
<?php } ?>
<?php if ($Page->created_at->Visible) { ?>
    <th data-name="created_at" class="<?= $Page->created_at->headerCellClass() ?>"><div class="Report2_created_at"><?= $Page->renderFieldHeader($Page->created_at) ?></div></th>
<?php } ?>
<?php if ($Page->kirihidet->Visible) { ?>
    <th data-name="kirihidet" class="<?= $Page->kirihidet->headerCellClass() ?>"><div class="Report2_kirihidet"><?= $Page->renderFieldHeader($Page->kirihidet) ?></div></th>
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
    $where = DetailFilterSql($Page->melequtir, $Page->getSqlFirstGroupField(), $Page->melequtir->groupValue(), $Page->Dbid);
    AddFilter($Page->PageFirstGroupFilter, $where, "OR");
    AddFilter($where, $Page->Filter);
    $sql = $Page->buildReportSql($Page->getSqlSelect(), $Page->getSqlFrom(), $Page->getSqlWhere(), $Page->getSqlGroupBy(), $Page->getSqlHaving(), $Page->getSqlOrderBy(), $where, $Page->Sort);
    $rs = $sql->executeQuery();
    $Page->DetailRecords = $rs?->fetchAll() ?? [];
    $Page->DetailRecordCount = count($Page->DetailRecords);
    $Page->setGroupCount($Page->DetailRecordCount, $Page->GroupCount);

    // Load detail records
    $Page->melequtir->Records = &$Page->DetailRecords;
    $Page->melequtir->LevelBreak = true; // Set field level break
        $Page->GroupCounter[1] = $Page->GroupCount;
        $Page->melequtir->getCnt($Page->melequtir->Records); // Get record count
        $Page->setGroupCount($Page->melequtir->Count, $Page->GroupCounter[1]);
?>
<?php if ($Page->melequtir->Visible && $Page->melequtir->ShowGroupHeaderAsRow) { ?>
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
<?php if ($Page->melequtir->Visible) { ?>
        <td data-field="melequtir"<?= $Page->melequtir->cellAttributes("ew-rpt-grp-caret") ?>><?= $Page->melequtir->groupToggleIcon() ?></td>
<?php } ?>
        <td data-field="melequtir" colspan="<?= ($Page->GroupColumnCount + $Page->DetailColumnCount - 1) ?>"<?= $Page->melequtir->cellAttributes() ?>>
            <span class="ew-summary-caption Report2_melequtir"><?= $Page->renderFieldHeader($Page->melequtir) ?></span><?= $Language->phrase("SummaryColon") ?><span<?= $Page->melequtir->viewAttributes() ?>><?= $Page->melequtir->GroupViewValue ?></span>
            <span class="ew-summary-count">(<span class="ew-aggregate-caption"><?= $Language->phrase("RptCnt") ?></span><span class="ew-aggregate-equal"><?= $Language->phrase("AggregateEqual") ?></span><span class="ew-aggregate-value"><?= FormatNumber($Page->melequtir->Count, Config("DEFAULT_NUMBER_FORMAT")) ?></span>)</span>
        </td>
    </tr>
<?php } ?>
<?php
        $Page->RecordCount = 0; // Reset record count
        foreach ($Page->melequtir->Records as $record) {
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
<?php if ($Page->melequtir->Visible) { ?>
    <?php if ($Page->melequtir->ShowGroupHeaderAsRow) { ?>
        <td data-field="melequtir"<?= $Page->melequtir->cellAttributes() ?>></td>
    <?php } else { ?>
        <td data-field="melequtir"<?= $Page->melequtir->cellAttributes() ?>><span<?= $Page->melequtir->viewAttributes() ?>><?= $Page->melequtir->GroupViewValue ?></span></td>
    <?php } ?>
<?php } ?>
<?php if ($Page->fileNumber->Visible) { ?>
        <td data-field="fileNumber"<?= $Page->fileNumber->cellAttributes() ?>>
<span<?= $Page->fileNumber->viewAttributes() ?>>
<?= $Page->fileNumber->getViewValue() ?></span>
</td>
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
<?php if ($Page->chilotname->Visible) { ?>
        <td data-field="chilotname"<?= $Page->chilotname->cellAttributes() ?>>
<span<?= $Page->chilotname->viewAttributes() ?>>
<?= $Page->chilotname->getViewValue() ?></span>
</td>
<?php } ?>
<?php if ($Page->ez->Visible) { ?>
        <td data-field="ez"<?= $Page->ez->cellAttributes() ?>>
<span<?= $Page->ez->viewAttributes() ?>>
<?= $Page->ez->getViewValue() ?></span>
</td>
<?php } ?>
<?php if ($Page->keteroreason->Visible) { ?>
        <td data-field="keteroreason"<?= $Page->keteroreason->cellAttributes() ?>>
<span<?= $Page->keteroreason->viewAttributes() ?>>
<?= $Page->keteroreason->getViewValue() ?></span>
</td>
<?php } ?>
<?php if ($Page->created_at->Visible) { ?>
        <td data-field="created_at"<?= $Page->created_at->cellAttributes() ?>>
<span<?= $Page->created_at->viewAttributes() ?>>
<?= $Page->created_at->getViewValue() ?></span>
</td>
<?php } ?>
<?php if ($Page->kirihidet->Visible) { ?>
        <td data-field="kirihidet"<?= $Page->kirihidet->cellAttributes() ?>>
<span<?= $Page->kirihidet->viewAttributes() ?>>
<?= $Page->kirihidet->getViewValue() ?></span>
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
