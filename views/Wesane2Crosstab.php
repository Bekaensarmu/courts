<?php

namespace PHPMaker2024\project2;

// Page object
$Wesane2Crosstab = &$Page;
?>
<?php if (!$Page->isExport() && !$Page->DrillDown && !$DashboardReport) { ?>
<script>
var currentTable = <?= JsonEncode($Page->toClientVar()) ?>;
ew.deepAssign(ew.vars, { tables: { wesane2: currentTable } });
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
<div id="gmp_wesane2" class="card-body ew-grid-middle-panel <?= $Page->TableContainerClass ?>">
<table class="<?= $Page->TableClass ?>">
<thead>
	<!-- Table header -->
    <tr class="ew-table-header">
<?php if ($Page->GroupColumnCount > 0) { ?>
        <td class="ew-rpt-col-summary" colspan="<?= $Page->GroupColumnCount ?>"><div><?= $Page->renderSummaryCaptions() ?></div></td>
<?php } ?>
        <td class="ew-rpt-col-header" colspan="<?= @$Page->ColumnSpan ?>">
            <div class="ew-table-header-btn">
                <span class="ew-table-header-caption"><?= $Page->status->caption() ?></span>
            </div>
        </td>
    </tr>
    <tr class="ew-table-header">
<?php if ($Page->updated_at->Visible) { ?>
    <td data-field="updated_at"><div><?= $Page->renderFieldHeader($Page->updated_at) ?></div></td>
<?php } ?>
<!-- Dynamic columns begin -->
<?php
    $cntval = count($Page->Columns);
    for ($iy = 1; $iy < $cntval; $iy++) {
        if ($Page->Columns[$iy]->Visible) {
            $Page->SummaryCurrentValues[$iy - 1] = $Page->Columns[$iy]->Caption;
            $Page->SummaryViewValues[$iy - 1] = $Page->SummaryCurrentValues[$iy - 1];
?>
        <td class="ew-table-header"<?= $Page->status->cellAttributes() ?>><div<?= $Page->status->viewAttributes() ?>><?= $Page->SummaryViewValues[$iy-1]; ?></div></td>
<?php
        }
    }
?>
<!-- Dynamic columns end -->
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
    $where = DetailFilterSql($Page->updated_at, $Page->getSqlFirstGroupField(), $Page->updated_at->groupValue(), $Page->Dbid);
    AddFilter($Page->PageFirstGroupFilter, $where, "OR");
    AddFilter($where, $Page->Filter);
    $sql = $Page->buildReportSql($Page->getSqlSelect()->addSelect($Page->DistinctColumnFields), $Page->getSqlFrom(), $Page->getSqlWhere(), $Page->getSqlGroupBy(), "", $Page->getSqlOrderBy(), $where, $Page->Sort);
    $rs = $sql->executeQuery();
    $Page->DetailRecords = $rs?->fetchAll() ?? [];
    $Page->DetailRecordCount = count($Page->DetailRecords);

    // Load detail records
    $Page->updated_at->Records = &$Page->DetailRecords;
    $Page->updated_at->LevelBreak = true; // Set field level break
        foreach ($Page->updated_at->Records as $record) {
            $Page->RecordCount++;
            $Page->RecordIndex++;
            $Page->loadRowValues($record);

            // Render row
            $Page->resetAttributes();
            $Page->RowType = RowType::DETAIL;
            $Page->renderRow();
?>
	<tr<?= $Page->rowAttributes(); ?>>
<?php if ($Page->updated_at->Visible) { ?>
        <!-- updated_at -->
        <td data-field="updated_at"<?= $Page->updated_at->cellAttributes() ?>><span<?= $Page->updated_at->viewAttributes() ?>><?= $Page->updated_at->GroupViewValue ?></span></td>
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
