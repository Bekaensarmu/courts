<?php

namespace PHPMaker2024\project2;

use Doctrine\DBAL\ParameterType;
use Doctrine\DBAL\Connection;
use Doctrine\DBAL\Query\QueryBuilder;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Container\ContainerInterface;
use Slim\Routing\RouteCollectorProxy;
use Slim\App;
use Closure;

/**
 * Page class
 */
class Crosstab1Crosstab extends Crosstab1
{
    use MessagesTrait;

    // Page ID
    public $PageID = "crosstab";

    // Project ID
    public $ProjectID = PROJECT_ID;

    // Page object name
    public $PageObjName = "Crosstab1Crosstab";

    // View file path
    public $View = null;

    // Title
    public $Title = null; // Title for <title> tag

    // Rendering View
    public $RenderingView = false;

    // CSS class/style
    public $ReportContainerClass = "ew-grid";
    public $CurrentPageName = "Crosstab1";

    // Page headings
    public $Heading = "";
    public $Subheading = "";
    public $PageHeader;
    public $PageFooter;

    // Page layout
    public $UseLayout = true;

    // Page terminated
    private $terminated = false;

    // Page heading
    public function pageHeading()
    {
        global $Language;
        if ($this->Heading != "") {
            return $this->Heading;
        }
        if (method_exists($this, "tableCaption")) {
            return $this->tableCaption();
        }
        return "";
    }

    // Page subheading
    public function pageSubheading()
    {
        global $Language;
        if ($this->Subheading != "") {
            return $this->Subheading;
        }
        return "";
    }

    // Page name
    public function pageName()
    {
        return CurrentPageName();
    }

    // Page URL
    public function pageUrl($withArgs = true)
    {
        $route = GetRoute();
        $args = RemoveXss($route->getArguments());
        if (!$withArgs) {
            foreach ($args as $key => &$val) {
                $val = "";
            }
            unset($val);
        }
        return rtrim(UrlFor($route->getName(), $args), "/") . "?";
    }

    // Show Page Header
    public function showPageHeader()
    {
        $header = $this->PageHeader;
        $this->pageDataRendering($header);
        if ($header != "") { // Header exists, display
            echo '<div id="ew-page-header">' . $header . '</div>';
        }
    }

    // Show Page Footer
    public function showPageFooter()
    {
        $footer = $this->PageFooter;
        $this->pageDataRendered($footer);
        if ($footer != "") { // Footer exists, display
            echo '<div id="ew-page-footer">' . $footer . '</div>';
        }
    }

    // Constructor
    public function __construct()
    {
        parent::__construct();
        global $Language, $DashboardReport, $DebugTimer, $UserTable;
        $this->TableVar = 'Crosstab1';
        $this->TableName = 'Crosstab1';

        // CSS class name as context
        $this->ContextClass = CheckClassName($this->TableVar);
        AppendClass($this->ReportContainerClass, $this->ContextClass);

        // Initialize
        $GLOBALS["Page"] = &$this;

        // Language object
        $Language = Container("app.language");

        // Table object (Crosstab1)
        if (!isset($GLOBALS["Crosstab1"]) || $GLOBALS["Crosstab1"]::class == PROJECT_NAMESPACE . "Crosstab1") {
            $GLOBALS["Crosstab1"] = &$this;
        }

        // Page URL
        $pageUrl = $this->pageUrl(false);

        // Initialize URLs

        // Table name (for backward compatibility only)
        if (!defined(PROJECT_NAMESPACE . "TABLE_NAME")) {
            define(PROJECT_NAMESPACE . "TABLE_NAME", 'Crosstab1');
        }

        // Start timer
        $DebugTimer = Container("debug.timer");

        // Debug message
        LoadDebugMessage();

        // Open connection
        $GLOBALS["Conn"] ??= $this->getConnection();

        // User table object
        $UserTable = Container("usertable");

        // Export options
        $this->ExportOptions = new ListOptions(TagClassName: "ew-export-option");

        // Filter options
        $this->FilterOptions = new ListOptions(TagClassName: "ew-filter-option");
    }

    // Get content from stream
    public function getContents(): string
    {
        global $Response;
        return $Response?->getBody() ?? ob_get_clean();
    }

    // Is lookup
    public function isLookup()
    {
        return SameText(Route(0), Config("API_LOOKUP_ACTION"));
    }

    // Is AutoFill
    public function isAutoFill()
    {
        return $this->isLookup() && SameText(Post("ajax"), "autofill");
    }

    // Is AutoSuggest
    public function isAutoSuggest()
    {
        return $this->isLookup() && SameText(Post("ajax"), "autosuggest");
    }

    // Is modal lookup
    public function isModalLookup()
    {
        return $this->isLookup() && SameText(Post("ajax"), "modal");
    }

    // Is terminated
    public function isTerminated()
    {
        return $this->terminated;
    }

    /**
     * Terminate page
     *
     * @param string $url URL for direction
     * @return void
     */
    public function terminate($url = "")
    {
        if ($this->terminated) {
            return;
        }
        global $TempImages, $DashboardReport, $Response;

        // Page is terminated
        $this->terminated = true;

        // Page Unload event
        if (method_exists($this, "pageUnload")) {
            $this->pageUnload();
        }
        DispatchEvent(new PageUnloadedEvent($this), PageUnloadedEvent::NAME);
        if (!IsApi() && method_exists($this, "pageRedirecting")) {
            $this->pageRedirecting($url);
        }

        // Close connection if not in dashboard
        if (!$DashboardReport) {
            CloseConnections();
        }

        // Return for API
        if (IsApi()) {
            $res = $url === true;
            if (!$res) { // Show response for API
                $ar = array_merge($this->getMessages(), $url ? ["url" => GetUrl($url)] : []);
                WriteJson($ar);
            }
            $this->clearMessages(); // Clear messages for API request
            return;
        } else { // Check if response is JSON
            if (WithJsonResponse()) { // With JSON response
                $this->clearMessages();
                return;
            }
        }

        // Go to URL if specified
        if ($url != "") {
            if (!Config("DEBUG") && ob_get_length()) {
                ob_end_clean();
            }
            SaveDebugMessage();
            Redirect(GetUrl($url));
        }
        return; // Return to controller
    }

    // Lookup data
    public function lookup(array $req = [], bool $response = true)
    {
        global $Language, $Security;

        // Get lookup object
        $fieldName = $req["field"] ?? null;
        if (!$fieldName) {
            return [];
        }
        $fld = $this->Fields[$fieldName];
        $lookup = $fld->Lookup;
        $name = $req["name"] ?? "";
        if (ContainsString($name, "query_builder_rule")) {
            $lookup->FilterFields = []; // Skip parent fields if any
        }
        if ($fld instanceof ReportField) {
            $lookup->RenderViewFunc = "renderLookup"; // Set up view renderer
        }
        $lookup->RenderEditFunc = ""; // Set up edit renderer

        // Get lookup parameters
        $lookupType = $req["ajax"] ?? "unknown";
        $pageSize = -1;
        $offset = -1;
        $searchValue = "";
        if (SameText($lookupType, "modal") || SameText($lookupType, "filter")) {
            $searchValue = $req["q"] ?? $req["sv"] ?? "";
            $pageSize = $req["n"] ?? $req["recperpage"] ?? 10;
        } elseif (SameText($lookupType, "autosuggest")) {
            $searchValue = $req["q"] ?? "";
            $pageSize = $req["n"] ?? -1;
            $pageSize = is_numeric($pageSize) ? (int)$pageSize : -1;
            if ($pageSize <= 0) {
                $pageSize = Config("AUTO_SUGGEST_MAX_ENTRIES");
            }
        }
        $start = $req["start"] ?? -1;
        $start = is_numeric($start) ? (int)$start : -1;
        $page = $req["page"] ?? -1;
        $page = is_numeric($page) ? (int)$page : -1;
        $offset = $start >= 0 ? $start : ($page > 0 && $pageSize > 0 ? ($page - 1) * $pageSize : 0);
        $userSelect = Decrypt($req["s"] ?? "");
        $userFilter = Decrypt($req["f"] ?? "");
        $userOrderBy = Decrypt($req["o"] ?? "");
        $keys = $req["keys"] ?? null;
        $lookup->LookupType = $lookupType; // Lookup type
        $lookup->FilterValues = []; // Clear filter values first
        if ($keys !== null) { // Selected records from modal
            if (is_array($keys)) {
                $keys = implode(Config("MULTIPLE_OPTION_SEPARATOR"), $keys);
            }
            $lookup->FilterFields = []; // Skip parent fields if any
            $lookup->FilterValues[] = $keys; // Lookup values
            $pageSize = -1; // Show all records
        } else { // Lookup values
            $lookup->FilterValues[] = $req["v0"] ?? $req["lookupValue"] ?? "";
        }
        $cnt = is_array($lookup->FilterFields) ? count($lookup->FilterFields) : 0;
        for ($i = 1; $i <= $cnt; $i++) {
            $lookup->FilterValues[] = $req["v" . $i] ?? "";
        }
        $lookup->SearchValue = $searchValue;
        $lookup->PageSize = $pageSize;
        $lookup->Offset = $offset;
        if ($userSelect != "") {
            $lookup->UserSelect = $userSelect;
        }
        if ($userFilter != "") {
            $lookup->UserFilter = $userFilter;
        }
        if ($userOrderBy != "") {
            $lookup->UserOrderBy = $userOrderBy;
        }
        return $lookup->toJson($this, $response); // Use settings from current page
    }

    // Options
    public $HideOptions = false;
    public $ExportOptions; // Export options
    public $SearchOptions; // Search options
    public $FilterOptions; // Filter options

    // Records
    public $GroupRecords = [];
    public $DetailRecords = [];
    public $DetailRecordCount = 0;

    // Paging variables
    public $RecordIndex = 0; // Record index
    public $RecordCount = 0; // Record count (start from 1 for each group)
    public $StartGroup = 0; // Start group
    public $StopGroup = 0; // Stop group
    public $TotalGroups = 0; // Total groups
    public $GroupCount = 0; // Group count
    public $DisplayGroups = 10; // Groups per page
    public $GroupRange = 10;
    public $PageSizes = "10,15,20,30,50,-1"; // Page sizes (comma separated)
    public $DefaultSearchWhere = ""; // Default search WHERE clause
    public $SearchWhere = "";
    public $SearchPanelClass = "ew-search-panel collapse show"; // Search Panel class
    public $SearchColumnCount = 0; // For extended search
    public $SearchFieldsPerRow = 1; // For extended search
    public $PageFirstGroupFilter = "";
    public $UserIDFilter = "";
    public $DrillDownList = "";
    public $DbMasterFilter = ""; // Master filter
    public $DbDetailFilter = ""; // Detail filter
    public $SearchCommand = false;
    public $ShowHeader = true;
    public $GroupColumnCount = 0;
    public $ColumnSpan;
    public $TopContentClass = "ew-top";
    public $MiddleContentClass = "ew-middle";
    public $BottomContentClass = "ew-bottom";

    /**
     * Page run
     *
     * @return void
     */
    public function run()
    {
        global $ExportType, $Language, $Security, $Security, $DrillDownInPanel, $Breadcrumb, $DashboardReport;

        // Set up dashboard report
        $DashboardReport ??= Param(Config("PAGE_DASHBOARD"));
        if ($DashboardReport) {
            $this->UseAjaxActions = true;
            AddFilter($this->Filter, $this->getDashboardFilter($DashboardReport, $this->TableVar)); // Set up Dashboard Filter
        }

        // Use layout
        $this->UseLayout = $this->UseLayout && ConvertToBool(Param(Config("PAGE_LAYOUT"), true));

        // View
        $this->View = Get(Config("VIEW"));

        // Load user profile
        if (IsLoggedIn()) {
            Profile()->setUserName(CurrentUserName())->loadFromStorage();
        }

        // Get export parameters
        $custom = "";
        if (Param("export") !== null) {
            $this->Export = Param("export");
            $custom = Param("custom", "");
        }
        $ExportType = $this->Export; // Get export parameter, used in header
        if ($ExportType != "") {
            global $SkipHeaderFooter;
            $SkipHeaderFooter = true;
        }
        $this->CurrentAction = Param("action"); // Set up current action

        // Setup export options
        $this->setupExportOptions();

        // Global Page Loading event (in userfn*.php)
        DispatchEvent(new PageLoadingEvent($this), PageLoadingEvent::NAME);

        // Page Load event
        if (method_exists($this, "pageLoad")) {
            $this->pageLoad();
        }

        // Setup other options
        $this->setupOtherOptions();

        // Set up table class
        if ($this->isExport("word") || $this->isExport("excel") || $this->isExport("pdf")) {
            $this->TableClass = "ew-table table-bordered table-sm";
        } else {
            PrependClass($this->TableClass, "table ew-table table-bordered table-sm");
        }

        // Set up report container class
        if (!$this->isExport("word") && !$this->isExport("excel")) {
            $this->ReportContainerClass .= " card ew-card";
        }

        // Set up groups per page dynamically
        $this->setupDisplayGroups();

        // Set up Breadcrumb
        if (!$this->isExport() && !$DashboardReport) {
            $this->setupBreadcrumb();
        }

        // Get sort
        $this->Sort = $this->getSort();

        // Check if search command
        $this->SearchCommand = Get("cmd") == "search";

        // Process filter list
        if ($this->processFilterList()) {
            $this->terminate();
            return;
        }

        // Load custom filters
        $this->pageFilterLoad();

        // Restore filter list
        $this->restoreFilterList();

        // Extended filter
        $extendedFilter = "";

        // Add year filter
        $year = $this->getYearSelection();
        if ($year != "") {
            AddFilter($this->SearchWhere, "YEAR(`created_at`) = " . QuotedValue($year, DataType::STRING, $this->Dbid));
        }

        // Build extended filter
        $extendedFilter = $this->getExtendedFilter();
        AddFilter($this->SearchWhere, $extendedFilter);

        // Call Page Selecting event
        $this->pageSelecting($this->SearchWhere);

        // Load columns to array
        $this->getColumns();

        // Search options
        $this->setupSearchOptions();

        // Set up search panel class
        if ($this->SearchWhere != "") {
            AppendClass($this->SearchPanelClass, "show");
        }

        // Update filter
        AddFilter($this->Filter, $this->SearchWhere);

        // Get total group count
        $sql = $this->buildReportSql($this->getSqlSelectGroup(), $this->getSqlFrom(), $this->getSqlWhere(), $this->getSqlGroupBy(), "", "", $this->Filter, "");
        $this->TotalGroups = $this->getRecordCount($sql);
        if ($this->DisplayGroups <= 0 || $this->DrillDown) { // Display all groups
            $this->DisplayGroups = $this->TotalGroups;
        }
        $this->StartGroup = 1;

        // Set up start position if not export all
        if ($this->ExportAll && $this->isExport()) {
            $this->DisplayGroups = $this->TotalGroups;
        } else {
            $this->setupStartGroup();
        }

        // Set no record found message
        if ($this->TotalGroups == 0) {
            $this->ShowHeader = false;
            if ($Security->canList()) {
                if ($this->SearchWhere == "0=101") {
                    $this->setWarningMessage($Language->phrase("EnterSearchCriteria"));
                } else {
                    $this->setWarningMessage($Language->phrase("NoRecord"));
                }
            } else {
                $this->setWarningMessage(DeniedMessage());
            }
        }

        // Hide export options if export/dashboard report/hide options
        if ($this->isExport() || $DashboardReport || $this->HideOptions) {
            $this->ExportOptions->hideAllOptions();
        }

        // Hide search/filter options if export/drilldown/dashboard report/hide options
        if ($this->isExport() || $this->DrillDown || $DashboardReport || $this->HideOptions) {
            $this->SearchOptions->hideAllOptions();
            $this->FilterOptions->hideAllOptions();
        }

        // Get group records
        if ($this->TotalGroups > 0) {
            $grpSort = UpdateSortFields($this->getSqlOrderByGroup(), $this->Sort, 2); // Get grouping field only
            $sql = $this->buildReportSql($this->getSqlSelectGroup(), $this->getSqlFrom(), $this->getSqlWhere(), $this->getSqlGroupBy(), "", $this->getSqlOrderByGroup(), $this->Filter, $grpSort);
            $grpRs = $sql->setFirstResult(max($this->StartGroup - 1, 0))->setMaxResults($this->DisplayGroups)->executeQuery();
            $this->GroupRecords = $grpRs->fetchAll(); // Get records of first groups
            $this->loadGroupRowValues();
            $this->GroupCount = 1;
        }

        // Init detail records
        $this->DetailRecords = [];

        // Set up column attributes
        $this->created_at->CssClass = "";
        $this->created_at->CellCssStyle = "";
        $this->setupFieldCount();

        // Set the last group to display if not export all
        if ($this->ExportAll && $this->isExport()) {
            $this->StopGroup = $this->TotalGroups;
        } else {
            $this->StopGroup = $this->StartGroup + $this->DisplayGroups - 1;
        }

        // Stop group <= total number of groups
        if (intval($this->StopGroup) > intval($this->TotalGroups)) {
            $this->StopGroup = $this->TotalGroups;
        }

        // Navigate
        $this->RecordCount = 0;
        $this->RecordIndex = 0;

        // Set up pager
        $this->Pager = new PrevNextPager($this, $this->StartGroup, $this->DisplayGroups, $this->TotalGroups, $this->PageSizes, $this->GroupRange, $this->AutoHidePager, $this->AutoHidePageSizeSelector);

        // Check if no records
        if ($this->TotalGroups == 0) {
            $this->ReportContainerClass .= " ew-no-record";
        }

        // Set LoginStatus / Page_Rendering / Page_Render
        if (!IsApi() && !$this->isTerminated()) {
            // Setup login status
            SetupLoginStatus();

            // Pass login status to client side
            SetClientVar("login", LoginStatus());

            // Global Page Rendering event (in userfn*.php)
            DispatchEvent(new PageRenderingEvent($this), PageRenderingEvent::NAME);

            // Page Render event
            if (method_exists($this, "pageRender")) {
                $this->pageRender();
            }

            // Render search option
            if (method_exists($this, "renderSearchOptions")) {
                $this->renderSearchOptions();
            }
        }
    }

    // Load group row values
    public function loadGroupRowValues()
    {
        $cnt = count($this->GroupRecords); // Get record count
        if ($this->GroupCount < $cnt) {
            $this->RANKe->setGroupValue(reset($this->GroupRecords[$this->GroupCount]));
        } else {
            $this->RANKe->setGroupValue("");
        }
    }

    // Load row values
    public function loadRowValues($record)
    {
        $this->RANKe->setDbValue($record['RANKe']);
        $cntbase = 2;
        $cnt = count($this->SummaryFields);
        $record = array_values($record);
        for ($is = 0; $is < $cnt; $is++) {
            $smry = &$this->SummaryFields[$is];
            $cntval = count($smry->SummaryValues);
            for ($ix = 1; $ix < $cntval; $ix++) {
                if ($smry->SummaryType == "AVG") {
                    $smry->SummaryValues[$ix] = $record[$ix * 2 + $cntbase - 2];
                    $smry->SummaryValueCounts[$ix] = $record[$ix * 2 + $cntbase - 1];
                } else {
                    $smry->SummaryValues[$ix] = $record[$ix + $cntbase - 1];
                }
            }
            $cntbase += ($smry->SummaryType == "AVG") ? 2 * ($cntval - 1) : ($cntval - 1);
        }
    }

    // Get summary values from records
    public function getSummaryValues($records)
    {
        $colcnt = $this->ColumnCount;
        $cnt = count($this->SummaryFields);
        for ($is = 0; $is < $cnt; $is++) {
            $smry = &$this->SummaryFields[$is];
            $smry->SummaryGroupValues = InitArray($colcnt, null);
            $smry->SummaryGroupValueCounts = InitArray($colcnt, null);
        }
        foreach ($records as $record) {
            $record = array_values($record);
            $cntbase = 2;
            for ($is = 0; $is < $cnt; $is++) {
                $smry = &$this->SummaryFields[$is];
                $cntval = count($smry->SummaryValues);
                for ($ix = 1; $ix < $cntval; $ix++) {
                    if ($smry->SummaryType == "AVG") {
                        $thisval = $record[$ix * 2 + $cntbase - 2];
                        $thiscnt = $record[$ix * 2 + $cntbase - 1];
                    } else {
                        $thisval = $record[$ix + $cntbase - 1];
                    }
                    $smry->SummaryGroupValues[$ix - 1] = SummaryValue($smry->SummaryGroupValues[$ix - 1], $thisval, $smry->SummaryType);
                    if ($smry->SummaryType == "AVG") {
                        $smry->SummaryGroupValueCounts[$ix - 1] += $thiscnt;
                    }
                }
                $cntbase += ($smry->SummaryType == "AVG") ? 2 * ($cntval - 1) : ($cntval - 1);
            }
        }
    }

    // Render row
    public function renderRow()
    {
        global $Security, $Language;
        $conn = $this->getConnection();

        // Set up summary values
        if ($this->RowType != RowType::SEARCH) { // Skip for search row
            $colcnt = $this->ColumnCount + 1;
            $this->SummaryCellAttrs = InitArray($colcnt, null);
            $this->SummaryViewAttrs = InitArray($colcnt, null);
            $this->SummaryLinkAttrs = InitArray($colcnt, null);
            $this->SummaryCurrentValues = InitArray($colcnt, null);
            $this->SummaryViewValues = InitArray($colcnt, null);
            $cnt = count($this->SummaryFields);
            for ($is = 0; $is < $cnt; $is++) {
                $smry = &$this->SummaryFields[$is];
                $smry->SummaryViewAttrs = InitArray($colcnt, null);
                $smry->SummaryLinkAttrs = InitArray($colcnt, null);
                $smry->SummaryCurrentValues = InitArray($colcnt, null);
                $smry->SummaryViewValues = InitArray($colcnt, null);
                $smry->SummaryRowSummary = $smry->SummaryInitValue;
                $smry->SummaryRowCount = 0;
            }
        }
        if ($this->RowTotalType == RowSummary::PAGE) {
            // Aggregate SQL (filter by group values)
            $firstGrpFld = &$this->RANKe;
            $firstGrpFld->getDistinctValues($this->GroupRecords);
            $where = DetailFilterSql($firstGrpFld, $this->getSqlFirstGroupField(), $firstGrpFld->DistinctValues, $this->Dbid);
            AddFilter($where, $this->Filter);
            $qb = $this->buildReportSql($this->getSqlSelectAggregate()->addSelect($this->DistinctColumnFields), $this->getSqlFrom(), $this->getSqlWhere(), $this->getSqlGroupByAggregate(), "", "", $where, "");
            $rsagg = $qb->execute()->fetchNumeric();
        } else if ($this->RowTotalType == RowSummary::GRAND) {
            // Aggregate SQL
            $qb = $this->buildReportSql($this->getSqlSelectAggregate()->addSelect($this->DistinctColumnFields), $this->getSqlFrom(), $this->getSqlWhere(), $this->getSqlGroupByAggregate(), "", "", $this->Filter, "");
            $rsagg = $qb->execute()->fetchNumeric();
        }
        if ($this->RowType != RowType::SEARCH) { // Skip for search row
            for ($i = 1; $i <= $this->ColumnCount; $i++) {
                if ($this->Columns[$i]->Visible) {
                    $cntbaseagg = 1;
                    $cnt = count($this->SummaryFields);
                    for ($is = 0; $is < $cnt; $is++) {
                        $smry = &$this->SummaryFields[$is];
                        if ($this->RowType == RowType::DETAIL) { // Detail row
                            $thisval = $smry->SummaryValues[$i];
                            if ($smry->SummaryType == "AVG") {
                                $thiscnt = $smry->SummaryValueCounts[$i];
                            }
                        } elseif ($this->RowTotalType == RowSummary::GROUP) { // Group total
                            $thisval = $smry->SummaryGroupValues[$i - 1];
                            if ($smry->SummaryType == "AVG") {
                                $thiscnt = $smry->SummaryGroupValueCounts[$i - 1];
                            }
                        } elseif ($this->RowTotalType == RowSummary::PAGE || $this->RowTotalType == RowSummary::GRAND) { // Page Total / Grand total
                            if ($smry->SummaryType == "AVG") {
                                $thisval = $rsagg[$i * 2 + $cntbaseagg - 2] ?? 0;
                                $thiscnt = $rsagg[$i * 2 + $cntbaseagg - 1] ?? 0;
                                $cntbaseagg += $this->ColumnCount * 2;
                            } else {
                                $thisval = $rsagg[$i + $cntbaseagg - 1] ?? 0;
                                $cntbaseagg += $this->ColumnCount;
                            }
                        }
                        if ($smry->SummaryType == "AVG") {
                            $smry->SummaryCurrentValues[$i - 1] = ($thiscnt > 0) ? $thisval / $thiscnt : 0;
                        } else {
                            $smry->SummaryCurrentValues[$i - 1] = $thisval;
                        }
                        $smry->SummaryRowSummary = SummaryValue($smry->SummaryRowSummary, $thisval, $smry->SummaryType);
                        if ($smry->SummaryType == "AVG") {
                            $smry->SummaryRowCount += $thiscnt;
                        }
                    }
                }
            }
        }
        if ($this->RowType != RowType::SEARCH) { // Skip for search row
            $cnt = count($this->SummaryFields);
            for ($is = 0; $is < $cnt; $is++) {
                $smry = &$this->SummaryFields[$is];
                if ($smry->SummaryType == "AVG") {
                    $smry->SummaryCurrentValues[$this->ColumnCount] = ($smry->SummaryRowCount > 0) ? $smry->SummaryRowSummary / $smry->SummaryRowCount : 0;
                } else {
                    $smry->SummaryCurrentValues[$this->ColumnCount] = $smry->SummaryRowSummary;
                }
            }
        }

        // Call Row_Rendering event
        $this->rowRendering();
        if ($this->RowType == RowType::SEARCH) { // Search row
        } elseif ($this->RowType == RowType::TOTAL) {
            // RANKe
            $curVal = strval($this->RANKe->groupValue());
            if ($curVal != "") {
                $this->RANKe->GroupViewValue = $this->RANKe->lookupCacheOption($curVal);
                if ($this->RANKe->GroupViewValue === null) { // Lookup from database
                    $filterWrk = SearchFilter($this->RANKe->Lookup->getTable()->Fields["ዕዝ"]->searchExpression(), "=", $curVal, $this->RANKe->Lookup->getTable()->Fields["ዕዝ"]->searchDataType(), "");
                    $sqlWrk = $this->RANKe->Lookup->getSql(false, $filterWrk, '', $this, true, true);
                    $conn = Conn();
                    $config = $conn->getConfiguration();
                    $config->setResultCache($this->Cache);
                    $rswrk = $conn->executeCacheQuery($sqlWrk, [], [], $this->CacheProfile)->fetchAll();
                    $ari = count($rswrk);
                    if ($ari > 0) { // Lookup values found
                        $arwrk = $this->RANKe->Lookup->renderViewRow($rswrk[0]);
                        $this->RANKe->GroupViewValue = $this->RANKe->displayValue($arwrk);
                    } else {
                        $this->RANKe->GroupViewValue = $this->RANKe->groupValue();
                    }
                }
            } else {
                $this->RANKe->GroupViewValue = null;
            }
            $this->RANKe->CellCssClass = ($this->RowGroupLevel == 1 ? "ew-rpt-grp-summary-1" : "ew-rpt-grp-field-1");

            // Set up summary values
            $smry = &$this->SummaryFields[0];
            $scvcnt = count($smry->SummaryCurrentValues);
            for ($i = 0; $i < $scvcnt; $i++) {
                $smry->SummaryViewValues[$i] = $smry->SummaryCurrentValues[$i];
                $smry->SummaryViewAttrs[$i]["class"] = "";
                $this->SummaryCellAttrs[$i]["class"] = ($this->RowTotalType == RowSummary::GROUP) ? "ew-rpt-grp-summary-" . $this->RowGroupLevel : "";
            }

            // RANKe
            $this->RANKe->HrefValue = "";
        } else {
            // RANKe
            $curVal = strval($this->RANKe->groupValue());
            if ($curVal != "") {
                $this->RANKe->GroupViewValue = $this->RANKe->lookupCacheOption($curVal);
                if ($this->RANKe->GroupViewValue === null) { // Lookup from database
                    $filterWrk = SearchFilter($this->RANKe->Lookup->getTable()->Fields["ዕዝ"]->searchExpression(), "=", $curVal, $this->RANKe->Lookup->getTable()->Fields["ዕዝ"]->searchDataType(), "");
                    $sqlWrk = $this->RANKe->Lookup->getSql(false, $filterWrk, '', $this, true, true);
                    $conn = Conn();
                    $config = $conn->getConfiguration();
                    $config->setResultCache($this->Cache);
                    $rswrk = $conn->executeCacheQuery($sqlWrk, [], [], $this->CacheProfile)->fetchAll();
                    $ari = count($rswrk);
                    if ($ari > 0) { // Lookup values found
                        $arwrk = $this->RANKe->Lookup->renderViewRow($rswrk[0]);
                        $this->RANKe->GroupViewValue = $this->RANKe->displayValue($arwrk);
                    } else {
                        $this->RANKe->GroupViewValue = $this->RANKe->groupValue();
                    }
                }
            } else {
                $this->RANKe->GroupViewValue = null;
            }
            $this->RANKe->CellCssClass = "ew-rpt-grp-field-1";
            if (!$this->RANKe->LevelBreak) {
                $this->RANKe->GroupViewValue = "";
            } else {
                $this->RANKe->LevelBreak = false;
            }

            // Set up summary values
            $smry = &$this->SummaryFields[0];
            $scvcnt = count($smry->SummaryCurrentValues);
            for ($i = 0; $i < $scvcnt; $i++) {
                $smry->SummaryViewValues[$i] = $smry->SummaryCurrentValues[$i];
                $smry->SummaryViewAttrs[$i]["class"] = "";
                $this->SummaryCellAttrs[$i]["class"] = ($this->RecordCount % 2 != 1) ? "ew-table-alt-row" : "";
            }

            // RANKe
            $this->RANKe->HrefValue = "";
            $this->RANKe->TooltipValue = "";
        }

        // Call Cell_Rendered event
        if ($this->RowType == RowType::TOTAL) {
            // RANKe
            $this->CurrentIndex = 0; // Current index
            $currentValue = $this->RANKe->groupValue();
            $viewValue = &$this->RANKe->GroupViewValue;
            $viewAttrs = &$this->RANKe->ViewAttrs;
            $cellAttrs = &$this->RANKe->CellAttrs;
            $hrefValue = &$this->RANKe->HrefValue;
            $linkAttrs = &$this->RANKe->LinkAttrs;
            $this->cellRendered($this->RANKe, $currentValue, $viewValue, $viewAttrs, $cellAttrs, $hrefValue, $linkAttrs);

            // Call Cell_Rendered for Summary fields
            $cnt = count($this->SummaryFields);
            for ($is = 0; $is < $cnt; $is++) {
                $smry = &$this->SummaryFields[$is];
                $scvcnt = count($smry->SummaryCurrentValues);
                for ($i = 0; $i < $scvcnt; $i++) {
                    $this->CurrentIndex = $i;
                    $currentValue = $smry->SummaryCurrentValues[$i];
                    $viewValue = &$smry->SummaryViewValues[$i];
                    $viewAttrs = &$smry->SummaryViewAttrs[$i];
                    $cellAttrs = &$this->SummaryCellAttrs[$i];
                    $hrefValue = "";
                    $linkAttrs = &$smry->SummaryLinkAttrs[$i];
                    $this->cellRendered($smry, $currentValue, $viewValue, $viewAttrs, $cellAttrs, $hrefValue, $linkAttrs);
                }
            }
        } elseif ($this->RowType == RowType::DETAIL) {
            // RANKe
            $this->CurrentIndex = 0; // Group index
            $currentValue = $this->RANKe->groupValue();
            $viewValue = &$this->RANKe->GroupViewValue;
            $viewAttrs = &$this->RANKe->ViewAttrs;
            $cellAttrs = &$this->RANKe->CellAttrs;
            $hrefValue = &$this->RANKe->HrefValue;
            $linkAttrs = &$this->RANKe->LinkAttrs;
            $this->cellRendered($this->RANKe, $currentValue, $viewValue, $viewAttrs, $cellAttrs, $hrefValue, $linkAttrs);
            $cnt = count($this->SummaryFields);
            for ($is = 0; $is < $cnt; $is++) {
                $smry = &$this->SummaryFields[$is];
                $scvcnt = count($smry->SummaryCurrentValues);
                for ($i = 0; $i < $scvcnt; $i++) {
                    $this->CurrentIndex = $i;
                    $currentValue = $smry->SummaryCurrentValues[$i];
                    $viewValue = &$smry->SummaryViewValues[$i];
                    $viewAttrs = &$smry->SummaryViewAttrs[$i];
                    $cellAttrs = &$this->SummaryCellAttrs[$i];
                    $hrefValue = "";
                    $linkAttrs = &$smry->SummaryLinkAttrs[$i];
                    $this->cellRendered($smry, $currentValue, $viewValue, $viewAttrs, $cellAttrs, $hrefValue, $linkAttrs);
                }
            }
        }

        // Call Row_Rendered event
        $this->rowRendered();
        $this->setupFieldCount();
    }

    // Setup field count
    protected function setupFieldCount()
    {
        $this->GroupColumnCount = 0;
        if ($this->RANKe->Visible) {
            $this->GroupColumnCount += 1;
        }
    }

    // Get column values
    protected function getColumns()
    {
        global $Language;

        // Load column values
        $filter = "";
        AddFilter($filter, $this->Filter);
        AddFilter($filter, $this->SearchWhere);
        $this->loadColumnValues($filter);

        // Get active columns
        $this->ColumnSpan = $this->ColumnCount;
        $this->ColumnSpan++; // Add summary column
    }

    // Get year selection
    protected function getYearSelection()
    {
        // Process query string
        $year = "";
        if (Get("YEAR__created_at") !== null) {
            $this->YEAR__created_at->setQueryStringValue(Get("YEAR__created_at"));
            if (is_numeric($this->YEAR__created_at->QueryStringValue)) {
                $year = $this->YEAR__created_at->QueryStringValue;
                $this->resetPager();
            }
        }

        // Get distinct year
        $rsyear = $this->getConnection()->executeQuery($this->getSqlCrosstabYear())->fetchAllNumeric();
        foreach ($rsyear as $row) {
            if ($row[0] !== null) {
                $this->YEAR__created_at->DistinctValues[] = $row[0];
            }
        }

        // Restore from session
        if ($year == "" && $this->YEAR__created_at->AdvancedSearch->issetSession()) {
            $this->YEAR__created_at->AdvancedSearch->load();
            $year = $this->YEAR__created_at->AdvancedSearch->SearchValue;
        }

        // Use first record
        if ($year == "" && count($this->YEAR__created_at->DistinctValues) > 0) {
            $year = $this->YEAR__created_at->DistinctValues[0];
        }
        $this->YEAR__created_at->CurrentValue = $year; // Save to CurrentValue
        $this->YEAR__created_at->AdvancedSearch->SearchValue = $year;
        $this->YEAR__created_at->AdvancedSearch->save(); // Save to session
        return $year;
    }

    // Get export HTML tag
    protected function getExportTag($type, $custom = false)
    {
        global $Language;
        if ($type == "print" || $custom) { // Printer friendly / custom export
            $pageUrl = $this->pageUrl(false);
            $exportUrl = GetUrl($pageUrl . "export=" . $type . ($custom ? "&amp;custom=1" : ""));
        } else { // Export API URL
            $exportUrl = GetApiUrl(Config("API_EXPORT_ACTION") . "/" . $type . "/" . $this->TableVar);
        }
        if (SameText($type, "excel")) {
            return '<button type="button" class="btn btn-default ew-export-link ew-excel" title="' . HtmlEncode($Language->phrase("ExportToExcel", true)) . '" data-caption="' . HtmlEncode($Language->phrase("ExportToExcel", true)) . '" data-ew-action="export" data-export="excel" data-custom="false" data-export-selected="false" data-url="' . $exportUrl . '">' . $Language->phrase("ExportToExcel") . '</button>';
        } elseif (SameText($type, "word")) {
            return '<button type="button" class="btn btn-default ew-export-link ew-word" title="' . HtmlEncode($Language->phrase("ExportToWord", true)) . '" data-caption="' . HtmlEncode($Language->phrase("ExportToWord", true)) . '" data-ew-action="export" data-export="word" data-custom="false" data-export-selected="false" data-url="' . $exportUrl . '">' . $Language->phrase("ExportToWord") . '</button>';
        } elseif (SameText($type, "pdf")) {
            return '<button type="button" class="btn btn-default ew-export-link ew-pdf" title="' . HtmlEncode($Language->phrase("ExportToPdf", true)) . '" data-caption="' . HtmlEncode($Language->phrase("ExportToPdf", true)) . '" data-ew-action="export" data-export="pdf" data-custom="false" data-export-selected="false" data-url="' . $exportUrl . '">' . $Language->phrase("ExportToPdf") . '</button>';
        } elseif (SameText($type, "html")) {
            return '<button type="button" class="btn btn-default ew-export-link ew-html" title="' . HtmlEncode($Language->phrase("ExportToHtml", true)) . '" data-caption="' . HtmlEncode($Language->phrase("ExportToHtml", true)) . '" data-ew-action="export" data-export="html" data-custom="false" data-export-selected="false" data-url="' . $exportUrl . '">' . $Language->phrase("ExportToHtml") . '</button>';
        } elseif (SameText($type, "email")) {
            return '<button type="button" class="btn btn-default ew-export-link ew-email" title="' . HtmlEncode($Language->phrase("ExportToEmail", true)) . '" data-caption="' . HtmlEncode($Language->phrase("ExportToEmail", true)) . '" data-ew-action="email" data-custom="false" data-export-selected="false" data-hdr="' . HtmlEncode($Language->phrase("ExportToEmail", true)) . '" data-url="' . $exportUrl . '">' . $Language->phrase("ExportToEmail") . '</button>';
        } elseif (SameText($type, "print")) {
            return "<a href=\"$exportUrl\" class=\"btn btn-default ew-export-link ew-print\" title=\"" . HtmlEncode($Language->phrase("PrinterFriendly", true)) . "\" data-caption=\"" . HtmlEncode($Language->phrase("PrinterFriendly", true)) . "\">" . $Language->phrase("PrinterFriendly") . "</a>";
        }
    }

    // Set up export options
    protected function setupExportOptions()
    {
        global $Language, $Security;

        // Printer friendly
        $item = &$this->ExportOptions->add("print");
        $item->Body = $this->getExportTag("print");
        $item->Visible = true;

        // Export to Excel
        $item = &$this->ExportOptions->add("excel");
        $item->Body = $this->getExportTag("excel");
        $item->Visible = true;

        // Export to Word
        $item = &$this->ExportOptions->add("word");
        $item->Body = $this->getExportTag("word");
        $item->Visible = true;

        // Export to HTML
        $item = &$this->ExportOptions->add("html");
        $item->Body = $this->getExportTag("html");
        $item->Visible = true;

        // Export to PDF
        $item = &$this->ExportOptions->add("pdf");
        $item->Body = $this->getExportTag("pdf");
        $item->Visible = false;

        // Export to Email
        $item = &$this->ExportOptions->add("email");
        $item->Body = $this->getExportTag("email");
        $item->Visible = false;

        // Drop down button for export
        $this->ExportOptions->UseButtonGroup = true;
        $this->ExportOptions->UseDropDownButton = true;
        if ($this->ExportOptions->UseButtonGroup && IsMobile()) {
            $this->ExportOptions->UseDropDownButton = true;
        }
        $this->ExportOptions->DropDownButtonPhrase = $Language->phrase("ButtonExport");

        // Add group option item
        $item = &$this->ExportOptions->addGroupOption();
        $item->Body = "";
        $item->Visible = false;

        // Hide options for export
        if ($this->isExport()) {
            $this->ExportOptions->hideAllOptions();
        }
        if (!$Security->canExport()) { // Export not allowed
            $this->ExportOptions->hideAllOptions();
        }
    }

    // Set up search options
    protected function setupSearchOptions()
    {
        global $Language, $Security;
        $pageUrl = $this->pageUrl(false);
        $this->SearchOptions = new ListOptions(TagClassName: "ew-search-option");

        // Search button
        $item = &$this->SearchOptions->add("searchtoggle");
        $searchToggleClass = ($this->SearchWhere != "") ? " active" : " active";
        $item->Body = "<a class=\"btn btn-default ew-search-toggle" . $searchToggleClass . "\" role=\"button\" title=\"" . $Language->phrase("SearchPanel") . "\" data-caption=\"" . $Language->phrase("SearchPanel") . "\" data-ew-action=\"search-toggle\" data-form=\"fCrosstab1srch\" aria-pressed=\"" . ($searchToggleClass == " active" ? "true" : "false") . "\">" . $Language->phrase("SearchLink") . "</a>";
        $item->Visible = true;

        // Show all button
        $item = &$this->SearchOptions->add("showall");
        if ($this->UseCustomTemplate || !$this->UseAjaxActions) {
            $item->Body = "<a class=\"btn btn-default ew-show-all\" role=\"button\" title=\"" . $Language->phrase("ShowAll") . "\" data-caption=\"" . $Language->phrase("ShowAll") . "\" href=\"" . $pageUrl . "cmd=reset\">" . $Language->phrase("ShowAllBtn") . "</a>";
        } else {
            $item->Body = "<a class=\"btn btn-default ew-show-all\" role=\"button\" title=\"" . $Language->phrase("ShowAll") . "\" data-caption=\"" . $Language->phrase("ShowAll") . "\" data-ew-action=\"refresh\" data-url=\"" . $pageUrl . "cmd=reset\">" . $Language->phrase("ShowAllBtn") . "</a>";
        }
        $item->Visible = ($this->SearchWhere != $this->DefaultSearchWhere && $this->SearchWhere != "0=101");

        // Button group for search
        $this->SearchOptions->UseDropDownButton = false;
        $this->SearchOptions->UseButtonGroup = true;
        $this->SearchOptions->DropDownButtonPhrase = $Language->phrase("ButtonSearch");

        // Add group option item
        $item = &$this->SearchOptions->addGroupOption();
        $item->Body = "";
        $item->Visible = false;

        // Hide search options
        if ($this->isExport() || $this->CurrentAction && $this->CurrentAction != "search") {
            $this->SearchOptions->hideAllOptions();
        }
        if (!$Security->canSearch()) {
            $this->SearchOptions->hideAllOptions();
            $this->FilterOptions->hideAllOptions();
        }
    }

    // Check if any search fields
    public function hasSearchFields()
    {
        return $this->created_at->Visible;
    }

    // Render search options
    protected function renderSearchOptions()
    {
        if (!$this->hasSearchFields() && $this->SearchOptions["searchtoggle"]) {
            $this->SearchOptions["searchtoggle"]->Visible = false;
        }
    }

    // Set up Breadcrumb
    protected function setupBreadcrumb()
    {
        global $Breadcrumb, $Language;
        $Breadcrumb = new Breadcrumb("index");
        $url = CurrentUrl();
        $url = preg_replace('/\?cmd=reset(all){0,1}$/i', '', $url); // Remove cmd=reset(all)
        $Breadcrumb->add("crosstab", $this->TableVar, $url, "", $this->TableVar, true);
    }

    // Setup lookup options
    public function setupLookupOptions($fld)
    {
        if ($fld->Lookup && $fld->Lookup->Options === null) {
            // Get default connection and filter
            $conn = $this->getConnection();
            $lookupFilter = "";

            // No need to check any more
            $fld->Lookup->Options = [];

            // Set up lookup SQL and connection
            switch ($fld->FieldVar) {
                case "x_RANKe":
                    break;
                case "x_ez":
                    break;
                case "x_firdbet":
                    break;
                case "x_chilotname":
                    break;
                case "x_kirihidet":
                    break;
                case "x_yekisaynet":
                    break;
                case "x_keteroreason":
                    break;
                case "x_sex":
                    break;
                default:
                    $lookupFilter = "";
                    break;
            }

            // Always call to Lookup->getSql so that user can setup Lookup->Options in Lookup_Selecting server event
            $sql = $fld->Lookup->getSql(false, "", $lookupFilter, $this);

            // Set up lookup cache
            if (!$fld->hasLookupOptions() && $fld->UseLookupCache && $sql != "" && count($fld->Lookup->Options) == 0 && count($fld->Lookup->FilterFields) == 0) {
                $totalCnt = $this->getRecordCount($sql, $conn);
                if ($totalCnt > $fld->LookupCacheCount) { // Total count > cache count, do not cache
                    return;
                }
                $rows = $conn->executeQuery($sql)->fetchAll();
                $ar = [];
                foreach ($rows as $row) {
                    $row = $fld->Lookup->renderViewRow($row, Container($fld->Lookup->LinkTable));
                    $key = $row["lf"];
                    if (IsFloatType($fld->Type)) { // Handle float field
                        $key = (float)$key;
                    }
                    $ar[strval($key)] = $row;
                }
                $fld->Lookup->Options = $ar;
            }
        }
    }

    // Set up other options
    protected function setupOtherOptions()
    {
        global $Language, $Security;

        // Filter button
        $item = &$this->FilterOptions->add("savecurrentfilter");
        $item->Body = "<a class=\"ew-save-filter\" data-form=\"fCrosstab1srch\" data-ew-action=\"none\">" . $Language->phrase("SaveCurrentFilter") . "</a>";
        $item->Visible = true;
        $item = &$this->FilterOptions->add("deletefilter");
        $item->Body = "<a class=\"ew-delete-filter\" data-form=\"fCrosstab1srch\" data-ew-action=\"none\">" . $Language->phrase("DeleteFilter") . "</a>";
        $item->Visible = true;
        $this->FilterOptions->UseDropDownButton = true;
        $this->FilterOptions->UseButtonGroup = !$this->FilterOptions->UseDropDownButton;
        $this->FilterOptions->DropDownButtonPhrase = $Language->phrase("Filters");

        // Add group option item
        $item = &$this->FilterOptions->addGroupOption();
        $item->Body = "";
        $item->Visible = false;
    }

    // Set up starting group
    protected function setupStartGroup()
    {
        // Exit if no groups
        if ($this->DisplayGroups == 0) {
            return;
        }
        $startGrp = Param(Config("TABLE_START_GROUP"));
        $pageNo = Param(Config("TABLE_PAGE_NUMBER"));

        // Check for a 'start' parameter
        if ($startGrp !== null) {
            $this->StartGroup = $startGrp;
            $this->setStartGroup($this->StartGroup);
        } elseif ($pageNo !== null) {
            $pageNo = ParseInteger($pageNo);
            if (is_numeric($pageNo)) {
                $this->StartGroup = ($pageNo - 1) * $this->DisplayGroups + 1;
                if ($this->StartGroup <= 0) {
                    $this->StartGroup = 1;
                } elseif ($this->StartGroup >= intval(($this->TotalGroups - 1) / $this->DisplayGroups) * $this->DisplayGroups + 1) {
                    $this->StartGroup = intval(($this->TotalGroups - 1) / $this->DisplayGroups) * $this->DisplayGroups + 1;
                }
                $this->setStartGroup($this->StartGroup);
            } else {
                $this->StartGroup = $this->getStartGroup();
            }
        } else {
            $this->StartGroup = $this->getStartGroup();
        }

        // Check if correct start group counter
        if (!is_numeric($this->StartGroup) || intval($this->StartGroup) <= 0) { // Avoid invalid start group counter
            $this->StartGroup = 1; // Reset start group counter
            $this->setStartGroup($this->StartGroup);
        } elseif (intval($this->StartGroup) > intval($this->TotalGroups)) { // Avoid starting group > total groups
            $this->StartGroup = intval(($this->TotalGroups - 1) / $this->DisplayGroups) * $this->DisplayGroups + 1; // Point to last page first group
            $this->setStartGroup($this->StartGroup);
        } elseif (($this->StartGroup - 1) % $this->DisplayGroups != 0) {
            $this->StartGroup = intval(($this->StartGroup - 1) / $this->DisplayGroups) * $this->DisplayGroups + 1; // Point to page boundary
            $this->setStartGroup($this->StartGroup);
        }
    }

    // Reset pager
    protected function resetPager()
    {
        // Reset start position (reset command)
        $this->StartGroup = 1;
        $this->setStartGroup($this->StartGroup);
    }

    // Set up number of groups displayed per page
    protected function setupDisplayGroups()
    {
        if (Param(Config("TABLE_GROUP_PER_PAGE")) !== null) {
            $wrk = Param(Config("TABLE_GROUP_PER_PAGE"));
            if (is_numeric($wrk)) {
                $this->DisplayGroups = intval($wrk);
            } else {
                if (SameText($wrk, "ALL")) { // Display all groups
                    $this->DisplayGroups = -1;
                } else {
                    $this->DisplayGroups = 10; // Non-numeric, load default
                }
            }
            $this->setGroupPerPage($this->DisplayGroups); // Save to session

            // Reset start position (reset command)
            $this->StartGroup = 1;
            $this->setStartGroup($this->StartGroup);
        } else {
            if ($this->getGroupPerPage() != "") {
                $this->DisplayGroups = $this->getGroupPerPage(); // Restore from session
            } else {
                $this->DisplayGroups = 10; // Load default
            }
        }
    }

    // Get sort parameters based on sort links clicked
    protected function getSort()
    {
        if ($this->DrillDown) {
            return "";
        }
        $resetSort = Param("cmd") === "resetsort";
        $orderBy = Param("order", "");
        $orderType = Param("ordertype", "");

        // Check for a resetsort command
        if ($resetSort) {
            $this->setOrderBy("");
            $this->setStartGroup(1);
            $this->RANKe->setSort("");

        // Check for an Order parameter
        } elseif ($orderBy != "") {
            $this->CurrentOrder = $orderBy;
            $this->CurrentOrderType = $orderType;
            $this->updateSort($this->RANKe); // RANKe
            $sortSql = $this->sortSql();
            $this->setOrderBy($sortSql);
            $this->setStartGroup(1);
        }
        return $this->getOrderBy();
    }

    // Return extended filter
    protected function getExtendedFilter()
    {
        $filter = "";
        if ($this->DrillDown) {
            return "";
        }
        $restoreSession = false;
        $restoreDefault = false;
        // Reset search command
        if (Get("cmd") == "reset") {
            // Set default values
            $restoreDefault = true;
        } else {
            $restoreSession = !$this->SearchCommand;
            if (!$this->validateForm()) {
                return $filter;
            }
        }

        // Restore session
        if ($restoreSession) {
            $restoreDefault = true;
        }

        // Restore default
        if ($restoreDefault) {
            $this->loadDefaultFilters();
        }

        // Call page filter validated event
        $this->pageFilterValidated();

        // Build SQL and save to session
        return $filter;
    }

    // Build dropdown filter
    protected function buildDropDownFilter(&$fld, &$filterClause, $default = false, $saveFilter = false)
    {
        $fldVal = $default ? $fld->AdvancedSearch->SearchValueDefault : $fld->AdvancedSearch->SearchValue;
        $fldOpr = $default ? $fld->AdvancedSearch->SearchOperatorDefault : $fld->AdvancedSearch->SearchOperator;
        $fldVal2 = $default ? $fld->AdvancedSearch->SearchValue2Default : $fld->AdvancedSearch->SearchValue2;
        if (!EmptyValue($fld->DateFilter)) {
            $fldVal2 = "";
        } elseif ($fld->UseFilter) {
            $fldOpr = "";
            $fldVal2 = "";
        }
        $sql = "";
        if (is_array($fldVal)) {
            foreach ($fldVal as $val) {
                $wrk = DropDownFilter($fld, $val, $fldOpr, $this->Dbid);

                // Call Page Filtering event
                if (StartsString("@@", $val)) {
                    $this->pageFiltering($fld, $wrk, "custom", substr($val, 2));
                } else {
                    $this->pageFiltering($fld, $wrk, "dropdown", $fldOpr, $val);
                }
                AddFilter($sql, $wrk, "OR");
            }
        } else {
            $sql = DropDownFilter($fld, $fldVal, $fldOpr, $this->Dbid, $fldVal2);

            // Call Page Filtering event
            if (StartsString("@@", $fldVal)) {
                $this->pageFiltering($fld, $sql, "custom", substr($fldVal, 2));
            } else {
                $this->pageFiltering($fld, $sql, "dropdown", $fldOpr, $fldVal, "", "", $fldVal2);
            }
        }
        if ($sql != "") {
            $cond = SameText($this->SearchOption, "OR") ? "OR" : "AND";
            AddFilter($filterClause, $sql, $cond);
            if ($saveFilter) {
                $fld->CurrentFilter = $sql;
            }
        }
    }

    // Build extended filter
    protected function buildExtendedFilter(&$fld, &$filterClause, $default = false, $saveFilter = false)
    {
        $wrk = GetReportFilter($fld, $default, $this->Dbid);
        if (!$default) {
            $this->pageFiltering($fld, $wrk, "extended", $fld->AdvancedSearch->SearchOperator, $fld->AdvancedSearch->SearchValue, $fld->AdvancedSearch->SearchCondition, $fld->AdvancedSearch->SearchOperator2, $fld->AdvancedSearch->SearchValue2);
        }
        if ($wrk != "") {
            $cond = SameText($this->SearchOption, "OR") ? "OR" : "AND";
            AddFilter($filterClause, $wrk, $cond);
            if ($saveFilter) {
                $fld->CurrentFilter = $wrk;
            }
        }
    }

    // Get drop down value from querystring
    protected function getDropDownValue(&$fld)
    {
        if (IsPost()) {
            return false; // Skip post back
        }
        $res = false;
        $parm = $fld->Param;
        $sep = $fld->UseFilter ? Config("FILTER_OPTION_SEPARATOR") : Config("MULTIPLE_OPTION_SEPARATOR");
        $opr = Get("z_$parm");
        if ($opr !== null) {
            $fld->AdvancedSearch->SearchOperator = $opr;
        }
        $val = Get("x_$parm");
        if ($val !== null) {
            if (is_array($val)) {
                $val = implode($sep, $val);
            }
            $fld->AdvancedSearch->setSearchValue($val);
            $res = true;
        }
        $val2 = Get("y_$parm");
        if ($val2 !== null) {
            if (is_array($val2)) {
                $val2 = implode($sep, $val2);
            }
            $fld->AdvancedSearch->setSearchValue2($val2);
            $res = true;
        }
        return $res;
    }

    // Dropdown filter exist
    protected function dropDownFilterExist(&$fld)
    {
        $wrk = "";
        $this->buildDropDownFilter($fld, $wrk);
        return ($wrk != "");
    }

    // Extended filter exist
    protected function extendedFilterExist(&$fld)
    {
        $extWrk = "";
        $this->buildExtendedFilter($fld, $extWrk);
        return ($extWrk != "");
    }

    // Validate form
    protected function validateForm()
    {
        global $Language;

        // Check if validation required
        if (!Config("SERVER_VALIDATE")) {
            return true;
        }

        // Return validate result
        $validateForm = !$this->hasInvalidFields();

        // Call Form_CustomValidate event
        $formCustomError = "";
        $validateForm = $validateForm && $this->formCustomValidate($formCustomError);
        if ($formCustomError != "") {
            $this->setFailureMessage($formCustomError);
        }
        return $validateForm;
    }

    // Load default value for filters
    protected function loadDefaultFilters()
    {
        // Set up default values for extended filters
    }

    // Show list of filters
    public function showFilterList()
    {
        global $Language;

        // Initialize
        $filterList = "";
        $captionClass = $this->isExport("email") ? "ew-filter-caption-email" : "ew-filter-caption";
        $captionSuffix = $this->isExport("email") ? ": " : "";

        // Year Filter
        if (strval($this->YEAR__created_at->CurrentValue) != "") {
            $filterList .= "<div><span class=\"" . $captionClass . "\">" . $Language->phrase("Year") . "</span>" . $captionSuffix;
            $filterList .= "<span class=\"ew-filter-value\">" . $this->YEAR__created_at->CurrentValue . "</span></div>";
        }

        // Show Filters
        if ($filterList != "") {
            $message = "<div id=\"ew-filter-list\" class=\"callout callout-info d-table\"><div id=\"ew-current-filters\">" .
                $Language->phrase("CurrentFilters") . "</div>" . $filterList . "</div>";
            $this->messageShowing($message, "");
            Write($message);
        } else { // Output empty tag
            Write("<div id=\"ew-filter-list\"></div>");
        }
    }

    // Get list of filters
    public function getFilterList()
    {
        // Initialize
        $filterList = "";
        $savedFilterList = "";

        // Load server side filters
        if (Config("SEARCH_FILTER_OPTION") == "Server") {
            $savedFilterList = Profile()->getSearchFilters("fCrosstab1srch");
        }

        // Year Filter
        if (strval($this->YEAR__created_at->CurrentValue) != "") {
            if ($filterList != "") {
                $filterList .= ",";
            }
            $filterList .= "\"YEAR__created_at\":\"" . JsEncode($this->YEAR__created_at->CurrentValue) . "\"";
        }

        // Return filter list in json
        if ($filterList != "") {
            $filterList = "\"data\":{" . $filterList . "}";
        }
        if ($savedFilterList != "") {
            $filterList = Concat($filterList, "\"filters\":" . $savedFilterList, ",");
        }
        return ($filterList != "") ? "{" . $filterList . "}" : "null";
    }

    // Process filter list
    protected function processFilterList()
    {
        if (Post("ajax") == "savefilters") { // Save filter request (Ajax)
            $filters = Post("filters");
            Profile()->setSearchFilters("fCrosstab1srch", $filters);
            WriteJson([["success" => true]]); // Success
            return true;
        } elseif (Post("cmd") == "resetfilter") {
            $this->restoreFilterList();
        }
        return false;
    }

    // Restore list of filters
    protected function restoreFilterList()
    {
        // Return if not reset filter
        if (Post("cmd", "") != "resetfilter") {
            return false;
        }
        $filter = json_decode(Post("filter", ""), true);
        return $this->setupFilterList($filter);
    }

    // Setup list of filters
    protected function setupFilterList($filter)
    {
        if (!is_array($filter)) {
            return false;
        }
        return true;
    }

    // Page Load event
    public function pageLoad()
    {
        //Log("Page Load");
    }

    // Page Unload event
    public function pageUnload()
    {
        //Log("Page Unload");
    }

    // Page Redirecting event
    public function pageRedirecting(&$url)
    {
        // Example:
        //$url = "your URL";
    }

    // Message Showing event
    // $type = ''|'success'|'failure'|'warning'
    public function messageShowing(&$msg, $type)
    {
        if ($type == "success") {
            //$msg = "your success message";
        } elseif ($type == "failure") {
            //$msg = "your failure message";
        } elseif ($type == "warning") {
            //$msg = "your warning message";
        } else {
            //$msg = "your message";
        }
    }

    // Page Render event
    public function pageRender()
    {
        //Log("Page Render");
    }

    // Page Data Rendering event
    public function pageDataRendering(&$header)
    {
        // Example:
        //$header = "your header";
    }

    // Page Data Rendered event
    public function pageDataRendered(&$footer)
    {
        // Example:
        //$footer = "your footer";
    }

    // Page Breaking event
    public function pageBreaking(&$break, &$content)
    {
        // Example:
        //$break = false; // Skip page break, or
        //$content = "<div style=\"break-after:page;\"></div>"; // Modify page break content
    }

    // Page Selecting event
    public function pageSelecting(&$filter)
    {
        // Enter your code here
    }

    // Load Filters event
    public function pageFilterLoad()
    {
        // Enter your code here
        // Example: Register/Unregister Custom Extended Filter
        //RegisterFilter($this-><Field>, 'StartsWithA', 'Starts With A', 'GetStartsWithAFilter'); // With function, or
        //RegisterFilter($this-><Field>, 'StartsWithA', 'Starts With A'); // No function, use Page_Filtering event
        //UnregisterFilter($this-><Field>, 'StartsWithA');
    }

    // Page Filter Validated event
    public function pageFilterValidated()
    {
        // Example:
        //$this->MyField1->AdvancedSearch->SearchValue = "your search criteria"; // Search value
    }

    // Page Filtering event
    public function pageFiltering(&$fld, &$filter, $typ, $opr = "", $val = "", $cond = "", $opr2 = "", $val2 = "")
    {
        // Note: ALWAYS CHECK THE FILTER TYPE ($typ)! Example:
        //if ($typ == "dropdown" && $fld->Name == "MyField") // Dropdown filter
        //    $filter = "..."; // Modify the filter
        //if ($typ == "extended" && $fld->Name == "MyField") // Extended filter
        //    $filter = "..."; // Modify the filter
        //if ($typ == "custom" && $opr == "..." && $fld->Name == "MyField") // Custom filter, $opr is the custom filter ID
        //    $filter = "..."; // Modify the filter
    }

    // Cell Rendered event
    public function cellRendered(&$Field, $CurrentValue, &$ViewValue, &$ViewAttrs, &$CellAttrs, &$HrefValue, &$LinkAttrs)
    {
        //$ViewValue = "xxx";
        //$ViewAttrs["class"] = "xxx";
    }

    // Form Custom Validate event
    public function formCustomValidate(&$customError)
    {
        // Return error message in $customError
        return true;
    }
}
