<?php

namespace PHPMaker2024\project2;

// Page object
$Report1Summary = &$Page;
?>
<?php if (!$Page->isExport() && !$Page->DrillDown && !$DashboardReport) { ?>
<script>
var currentTable = <?= JsonEncode($Page->toClientVar()) ?>;
ew.deepAssign(ew.vars, { tables: { Report1: currentTable } });
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
<div id="gmp_Report1" class="card-body ew-grid-middle-panel <?= $Page->TableContainerClass ?>">
<table class="<?= $Page->TableClass ?>">
<thead>
	<!-- Table header -->
    <tr class="ew-table-header">
<?php if ($Page->melequtir->Visible) { ?>
    <?php if ($Page->melequtir->ShowGroupHeaderAsRow) { ?>
    <th data-name="melequtir"<?= $Page->melequtir->cellAttributes("ew-rpt-grp-caret") ?>><?= $Page->melequtir->groupToggleIcon() ?></th>
    <?php } else { ?>
    <th data-name="melequtir" class="<?= $Page->melequtir->headerCellClass() ?>"><div class="Report1_melequtir"><?= $Page->renderFieldHeader($Page->melequtir) ?></div></th>
    <?php } ?>
<?php } ?>
<?php if ($Page->fileNumber->Visible) { ?>
    <th data-name="fileNumber" class="<?= $Page->fileNumber->headerCellClass() ?>"><div class="Report1_fileNumber"><?= $Page->renderFieldHeader($Page->fileNumber) ?></div></th>
<?php } ?>
<?php if ($Page->name->Visible) { ?>
    <th data-name="name" class="<?= $Page->name->headerCellClass() ?>"><div class="Report1_name"><?= $Page->renderFieldHeader($Page->name) ?></div></th>
<?php } ?>
<?php if ($Page->yekisaynet->Visible) { ?>
    <th data-name="yekisaynet" class="<?= $Page->yekisaynet->headerCellClass() ?>"><div class="Report1_yekisaynet"><?= $Page->renderFieldHeader($Page->yekisaynet) ?></div></th>
<?php } ?>
<?php if ($Page->chilotname->Visible) { ?>
    <th data-name="chilotname" class="<?= $Page->chilotname->headerCellClass() ?>"><div class="Report1_chilotname"><?= $Page->renderFieldHeader($Page->chilotname) ?></div></th>
<?php } ?>
<?php if ($Page->ez->Visible) { ?>
    <th data-name="ez" class="<?= $Page->ez->headerCellClass() ?>"><div class="Report1_ez"><?= $Page->renderFieldHeader($Page->ez) ?></div></th>
<?php } ?>
<?php if ($Page->keteroreason->Visible) { ?>
    <th data-name="keteroreason" class="<?= $Page->keteroreason->headerCellClass() ?>"><div class="Report1_keteroreason"><?= $Page->renderFieldHeader($Page->keteroreason) ?></div></th>
<?php } ?>
<?php if ($Page->created_at->Visible) { ?>
    <th data-name="created_at" class="<?= $Page->created_at->headerCellClass() ?>"><div class="Report1_created_at"><?= $Page->renderFieldHeader($Page->created_at) ?></div></th>
<?php } ?>
<?php if ($Page->kirihidet->Visible) { ?>
    <th data-name="kirihidet" class="<?= $Page->kirihidet->headerCellClass() ?>"><div class="Report1_kirihidet"><?= $Page->renderFieldHeader($Page->kirihidet) ?></div></th>
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
            <span class="ew-summary-caption Report1_melequtir"><?= $Page->renderFieldHeader($Page->melequtir) ?></span><?= $Language->phrase("SummaryColon") ?><span<?= $Page->melequtir->viewAttributes() ?>><?= $Page->melequtir->GroupViewValue ?></span>
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
<?php
    $Page->resetAttributes();
    $Page->RowType = RowType::TOTAL;
    $Page->RowTotalType = RowSummary::GRAND;
    $Page->RowTotalSubType = RowTotal::FOOTER;
    $Page->RowAttrs["class"] = "ew-rpt-grand-summary";
    $Page->renderRow();
?>
<?php if ($Page->melequtir->ShowCompactSummaryFooter) { ?>
    <tr<?= $Page->rowAttributes() ?>><td colspan="<?= ($Page->GroupColumnCount + $Page->DetailColumnCount) ?>"><?= $Language->phrase("RptGrandSummary") ?> <span class="ew-summary-count">(<span class="ew-aggregate-caption"><?= $Language->phrase("RptCnt") ?></span><span class="ew-aggregate-equal"><?= $Language->phrase("AggregateEqual") ?></span><span class="ew-aggregate-value"><?= FormatNumber($Page->TotalCount, Config("DEFAULT_NUMBER_FORMAT")) ?></span>)</span></td></tr>
<?php } else { ?>
    <tr<?= $Page->rowAttributes() ?>><td colspan="<?= ($Page->GroupColumnCount + $Page->DetailColumnCount) ?>"><?= $Language->phrase("RptGrandSummary") ?> <span class="ew-summary-count">(<?= FormatNumber($Page->TotalCount, Config("DEFAULT_NUMBER_FORMAT")) ?><?= $Language->phrase("RptDtlRec") ?>)</span></td></tr>
<?php } ?>
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
