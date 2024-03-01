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
class Report2Summary extends Report2
{
    use MessagesTrait;

    // Page ID
    public $PageID = "summary";

    // Project ID
    public $ProjectID = PROJECT_ID;

    // Page object name
    public $PageObjName = "Report2Summary";

    // View file path
    public $View = null;

    // Title
    public $Title = null; // Title for <title> tag

    // Rendering View
    public $RenderingView = false;

    // CSS class/style
    public $ReportContainerClass = "ew-grid";
    public $CurrentPageName = "Report2";

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
        $this->TableVar = 'Report2';
        $this->TableName = 'Report2';

        // CSS class name as context
        $this->ContextClass = CheckClassName($this->TableVar);
        AppendClass($this->ReportContainerClass, $this->ContextClass);

        // Fixed header table
        if (!$this->UseCustomTemplate) {
            $this->setFixedHeaderTable(Config("USE_FIXED_HEADER_TABLE"), Config("FIXED_HEADER_TABLE_HEIGHT"));
        }

        // Initialize
        $GLOBALS["Page"] = &$this;

        // Language object
        $Language = Container("app.language");

        // Table object (Report2)
        if (!isset($GLOBALS["Report2"]) || $GLOBALS["Report2"]::class == PROJECT_NAMESPACE . "Report2") {
            $GLOBALS["Report2"] = &$this;
        }

        // Page URL
        $pageUrl = $this->pageUrl(false);

        // Initialize URLs

        // Table name (for backward compatibility only)
        if (!defined(PROJECT_NAMESPACE . "TABLE_NAME")) {
            define(PROJECT_NAMESPACE . "TABLE_NAME", 'Report2');
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
    public $GroupCounter = []; // Group counter
    public $DisplayGroups = 10; // Groups per page
    public $GroupRange = 10;
    public $PageSizes = "10,15,20,30,50,-1"; // Page sizes (comma separated)
    public $PageFirstGroupFilter = "";
    public $UserIDFilter = "";
    public $DefaultSearchWhere = ""; // Default search WHERE clause
    public $SearchWhere = "";
    public $SearchPanelClass = "ew-search-panel collapse show"; // Search Panel class
    public $SearchColumnCount = 0; // For extended search
    public $SearchFieldsPerRow = 1; // For extended search
    public $DrillDownList = "";
    public $DbMasterFilter = ""; // Master filter
    public $DbDetailFilter = ""; // Detail filter
    public $SearchCommand = false;
    public $ShowHeader = true;
    public $GroupColumnCount = 0;
    public $SubGroupColumnCount = 0;
    public $DetailColumnCount = 0;
    public $TotalCount;
    public $PageTotalCount;
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
        global $ExportType, $Language, $Security, $DrillDownInPanel, $Breadcrumb, $DashboardReport;

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

        // Set field visibility for detail fields
        $this->fileNumber->setVisibility();
        $this->name->setVisibility();
        $this->yekisaynet->setVisibility();
        $this->chilotname->setVisibility();
        $this->ez->setVisibility();
        $this->keteroreason->setVisibility();
        $this->created_at->setVisibility();
        $this->kirihidet->setVisibility();

        // Set up groups per page dynamically
        $this->setupDisplayGroups();

        // Set up Breadcrumb
        if (!$this->isExport() && !$DashboardReport) {
            $this->setupBreadcrumb();
        }

        // Check if search command
        $this->SearchCommand = (Get("cmd", "") == "search");

        // Load custom filters
        $this->pageFilterLoad();

        // Process filter list
        if ($this->processFilterList()) {
            $this->terminate();
            return;
        }

        // Extended filter
        $extendedFilter = "";

        // Restore filter list
        $this->restoreFilterList();

        // Build extended filter
        $extendedFilter = $this->getExtendedFilter();
        AddFilter($this->SearchWhere, $extendedFilter);

        // Call Page Selecting event
        $this->pageSelecting($this->SearchWhere);

        // Set up search panel class
        if ($this->SearchWhere != "") {
            AppendClass($this->SearchPanelClass, "show");
        }

        // Get sort
        $this->Sort = $this->getSort();

        // Search options
        $this->setupSearchOptions();

        // Update filter
        AddFilter($this->Filter, $this->SearchWhere);

        // Get total group count
        $sql = $this->buildReportSql($this->getSqlSelectGroup(), $this->getSqlFrom(), $this->getSqlWhere(), $this->getSqlGroupBy(), $this->getSqlHaving(), "", $this->Filter, "");
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
            $sql = $this->buildReportSql($this->getSqlSelectGroup(), $this->getSqlFrom(), $this->getSqlWhere(), $this->getSqlGroupBy(), $this->getSqlHaving(), $this->getSqlOrderByGroup(), $this->Filter, $grpSort);
            $grpRs = $sql->setFirstResult(max($this->StartGroup - 1, 0))->setMaxResults($this->DisplayGroups)->executeQuery();
            $this->GroupRecords = $grpRs->fetchAll(); // Get records of first grouping field
            $this->loadGroupRowValues();
            $this->GroupCount = 1;
        }

        // Init detail records
        $this->DetailRecords = [];
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
            $this->melequtir->setGroupValue(reset($this->GroupRecords[$this->GroupCount]));
        } else {
            $this->melequtir->setGroupValue("");
        }
    }

    // Load row values
    public function loadRowValues($record)
    {
        $data = [];
        $data["id"] = $record['id'];
        $data["melequtir"] = $record['melequtir'];
        $data["fileNumber"] = $record['fileNumber'];
        $data["name"] = $record['name'];
        $data["yekisaynet"] = $record['yekisaynet'];
        $data["chilotname"] = $record['chilotname'];
        $data["ez"] = $record['ez'];
        $data["keteroreason"] = $record['keteroreason'];
        $data["created_at"] = $record['created_at'];
        $data["kirihidet"] = $record['kirihidet'];
        $data["RANKe"] = $record['RANKe'];
        $data["firdbet"] = $record['firdbet'];
        $data["sex"] = $record['sex'];
        $data["tekesashbizat"] = $record['tekesashbizat'];
        $data["keterodate"] = $record['keterodate'];
        $data["keterodescription"] = $record['keterodescription'];
        $data["updated_at"] = $record['updated_at'];
        $data["updated_by"] = $record['updated_by'];
        $this->Rows[] = $data;
        $this->id->setDbValue($record['id']);
        $this->melequtir->setDbValue(GroupValue($this->melequtir, $record['melequtir']));
        $this->fileNumber->setDbValue($record['fileNumber']);
        $this->name->setDbValue($record['name']);
        $this->yekisaynet->setDbValue($record['yekisaynet']);
        $this->chilotname->setDbValue($record['chilotname']);
        $this->ez->setDbValue($record['ez']);
        $this->keteroreason->setDbValue($record['keteroreason']);
        $this->created_at->setDbValue($record['created_at']);
        $this->kirihidet->setDbValue($record['kirihidet']);
        $this->RANKe->setDbValue($record['RANKe']);
        $this->firdbet->setDbValue($record['firdbet']);
        $this->sex->setDbValue($record['sex']);
        $this->tekesashbizat->setDbValue($record['tekesashbizat']);
        $this->keterodate->setDbValue($record['keterodate']);
        $this->keterodescription->setDbValue($record['keterodescription']);
        $this->updated_at->setDbValue($record['updated_at']);
        $this->updated_by->setDbValue($record['updated_by']);
    }

    // Render row
    public function renderRow()
    {
        global $Security, $Language, $Language;
        $conn = $this->getConnection();
        if ($this->RowType == RowType::TOTAL && $this->RowTotalSubType == RowTotal::FOOTER && $this->RowTotalType == RowSummary::PAGE) {
            // Build detail SQL
            $firstGrpFld = &$this->melequtir;
            $firstGrpFld->getDistinctValues($this->GroupRecords);
            $where = DetailFilterSql($firstGrpFld, $this->getSqlFirstGroupField(), $firstGrpFld->DistinctValues, $this->Dbid);
            AddFilter($where, $this->Filter);
            $sql = $this->buildReportSql($this->getSqlSelect(), $this->getSqlFrom(), $this->getSqlWhere(), $this->getSqlGroupBy(), $this->getSqlHaving(), $this->getSqlOrderBy(), $where, $this->Sort);
            $rs = $sql->executeQuery();
            $records = $rs?->fetchAll() ?? [];
            $this->PageTotalCount = count($records);
        } elseif ($this->RowType == RowType::TOTAL && $this->RowTotalSubType == RowTotal::FOOTER && $this->RowTotalType == RowSummary::GRAND) { // Get Grand total
            $hasCount = false;
            $hasSummary = false;

            // Get total count from SQL directly
            $sql = $this->buildReportSql($this->getSqlSelectCount(), $this->getSqlFrom(), $this->getSqlWhere(), $this->getSqlGroupBy(), $this->getSqlHaving(), "", $this->Filter, "");
            $rstot = $conn->executeQuery($sql);
            if ($rstot && $cnt = $rstot->fetchOne()) {
                $hasCount = true;
            } else {
                $cnt = 0;
            }
            $this->TotalCount = $cnt;
            $hasSummary = true;

            // Accumulate grand summary from detail records
            if (!$hasCount || !$hasSummary) {
                $sql = $this->buildReportSql($this->getSqlSelect(), $this->getSqlFrom(), $this->getSqlWhere(), $this->getSqlGroupBy(), $this->getSqlHaving(), "", $this->Filter, "");
                $rs = $sql->executeQuery();
                $this->DetailRecords = $rs?->fetchAll() ?? [];
            }
        }

        // Call Row_Rendering event
        $this->rowRendering();

        // melequtir

        // fileNumber

        // name

        // yekisaynet

        // chilotname

        // ez

        // keteroreason

        // created_at

        // kirihidet
        if ($this->RowType == RowType::SEARCH) {
            // melequtir
            $this->melequtir->setupEditAttributes();
            if (!$this->melequtir->Raw) {
                $this->melequtir->AdvancedSearch->SearchValue = HtmlDecode($this->melequtir->AdvancedSearch->SearchValue);
            }
            $this->melequtir->EditValue = HtmlEncode($this->melequtir->AdvancedSearch->SearchValue);
            $this->melequtir->PlaceHolder = RemoveHtml($this->melequtir->caption());

            // fileNumber
            $this->fileNumber->setupEditAttributes();
            if (!$this->fileNumber->Raw) {
                $this->fileNumber->AdvancedSearch->SearchValue = HtmlDecode($this->fileNumber->AdvancedSearch->SearchValue);
            }
            $this->fileNumber->EditValue = HtmlEncode($this->fileNumber->AdvancedSearch->SearchValue);
            $this->fileNumber->PlaceHolder = RemoveHtml($this->fileNumber->caption());

            // created_at
            $this->created_at->setupEditAttributes();
            $this->created_at->EditValue = HtmlEncode(FormatDateTime(UnFormatDateTime($this->created_at->AdvancedSearch->SearchValue, $this->created_at->formatPattern()), $this->created_at->formatPattern()));
            $this->created_at->PlaceHolder = RemoveHtml($this->created_at->caption());
            $this->created_at->setupEditAttributes();
            $this->created_at->EditValue2 = HtmlEncode(FormatDateTime(UnFormatDateTime($this->created_at->AdvancedSearch->SearchValue2, $this->created_at->formatPattern()), $this->created_at->formatPattern()));
            $this->created_at->PlaceHolder = RemoveHtml($this->created_at->caption());
        } elseif ($this->RowType == RowType::TOTAL && !($this->RowTotalType == RowSummary::GROUP && $this->RowTotalSubType == RowTotal::HEADER)) { // Summary row
            $this->RowAttrs->prependClass(($this->RowTotalType == RowSummary::PAGE || $this->RowTotalType == RowSummary::GRAND) ? "ew-rpt-grp-aggregate" : ""); // Set up row class
            if ($this->RowTotalType == RowSummary::GROUP) {
                $this->RowAttrs["data-group"] = $this->melequtir->groupValue(); // Set up group attribute
            }

            // melequtir
            $this->melequtir->GroupViewValue = $this->melequtir->groupValue();
            $this->melequtir->CellCssClass = ($this->RowGroupLevel == 1 ? "ew-rpt-grp-summary-1" : "ew-rpt-grp-field-1");
            $this->melequtir->GroupViewValue = DisplayGroupValue($this->melequtir, $this->melequtir->GroupViewValue);

            // melequtir
            $this->melequtir->HrefValue = "";

            // fileNumber
            $this->fileNumber->HrefValue = "";

            // name
            $this->name->HrefValue = "";

            // yekisaynet
            $this->yekisaynet->HrefValue = "";

            // chilotname
            $this->chilotname->HrefValue = "";

            // ez
            $this->ez->HrefValue = "";

            // keteroreason
            $this->keteroreason->HrefValue = "";

            // created_at
            $this->created_at->HrefValue = "";

            // kirihidet
            $this->kirihidet->HrefValue = "";
        } else {
            if ($this->RowTotalType == RowSummary::GROUP && $this->RowTotalSubType == RowTotal::HEADER) {
                $this->RowAttrs["data-group"] = $this->melequtir->groupValue(); // Set up group attribute
            } else {
                $this->RowAttrs["data-group"] = $this->melequtir->groupValue(); // Set up group attribute
            }

            // melequtir
            $this->melequtir->GroupViewValue = $this->melequtir->groupValue();
            $this->melequtir->CellCssClass = "ew-rpt-grp-field-1";
            $this->melequtir->GroupViewValue = DisplayGroupValue($this->melequtir, $this->melequtir->GroupViewValue);
            if (!$this->melequtir->LevelBreak) {
                $this->melequtir->GroupViewValue = "";
            } else {
                $this->melequtir->LevelBreak = false;
            }

            // Increment RowCount
            if ($this->RowType == RowType::DETAIL) {
                $this->RowCount++;
            }

            // fileNumber
            $this->fileNumber->ViewValue = $this->fileNumber->CurrentValue;
            $this->fileNumber->CellCssClass = ($this->RecordCount % 2 != 1 ? "ew-table-alt-row" : "");

            // name
            $this->name->ViewValue = $this->name->CurrentValue;
            $this->name->CellCssClass = ($this->RecordCount % 2 != 1 ? "ew-table-alt-row" : "");

            // yekisaynet
            $curVal = strval($this->yekisaynet->CurrentValue);
            if ($curVal != "") {
                $this->yekisaynet->ViewValue = $this->yekisaynet->lookupCacheOption($curVal);
                if ($this->yekisaynet->ViewValue === null) { // Lookup from database
                    $filterWrk = SearchFilter($this->yekisaynet->Lookup->getTable()->Fields["ዕዝ"]->searchExpression(), "=", $curVal, $this->yekisaynet->Lookup->getTable()->Fields["ዕዝ"]->searchDataType(), "");
                    $sqlWrk = $this->yekisaynet->Lookup->getSql(false, $filterWrk, '', $this, true, true);
                    $conn = Conn();
                    $config = $conn->getConfiguration();
                    $config->setResultCache($this->Cache);
                    $rswrk = $conn->executeCacheQuery($sqlWrk, [], [], $this->CacheProfile)->fetchAll();
                    $ari = count($rswrk);
                    if ($ari > 0) { // Lookup values found
                        $arwrk = $this->yekisaynet->Lookup->renderViewRow($rswrk[0]);
                        $this->yekisaynet->ViewValue = $this->yekisaynet->displayValue($arwrk);
                    } else {
                        $this->yekisaynet->ViewValue = $this->yekisaynet->CurrentValue;
                    }
                }
            } else {
                $this->yekisaynet->ViewValue = null;
            }
            $this->yekisaynet->CellCssClass = ($this->RecordCount % 2 != 1 ? "ew-table-alt-row" : "");

            // chilotname
            $curVal = strval($this->chilotname->CurrentValue);
            if ($curVal != "") {
                $this->chilotname->ViewValue = $this->chilotname->lookupCacheOption($curVal);
                if ($this->chilotname->ViewValue === null) { // Lookup from database
                    $filterWrk = SearchFilter($this->chilotname->Lookup->getTable()->Fields["ዕዝ"]->searchExpression(), "=", $curVal, $this->chilotname->Lookup->getTable()->Fields["ዕዝ"]->searchDataType(), "");
                    $sqlWrk = $this->chilotname->Lookup->getSql(false, $filterWrk, '', $this, true, true);
                    $conn = Conn();
                    $config = $conn->getConfiguration();
                    $config->setResultCache($this->Cache);
                    $rswrk = $conn->executeCacheQuery($sqlWrk, [], [], $this->CacheProfile)->fetchAll();
                    $ari = count($rswrk);
                    if ($ari > 0) { // Lookup values found
                        $arwrk = $this->chilotname->Lookup->renderViewRow($rswrk[0]);
                        $this->chilotname->ViewValue = $this->chilotname->displayValue($arwrk);
                    } else {
                        $this->chilotname->ViewValue = $this->chilotname->CurrentValue;
                    }
                }
            } else {
                $this->chilotname->ViewValue = null;
            }
            $this->chilotname->CellCssClass = ($this->RecordCount % 2 != 1 ? "ew-table-alt-row" : "");

            // ez
            $curVal = strval($this->ez->CurrentValue);
            if ($curVal != "") {
                $this->ez->ViewValue = $this->ez->lookupCacheOption($curVal);
                if ($this->ez->ViewValue === null) { // Lookup from database
                    $filterWrk = SearchFilter($this->ez->Lookup->getTable()->Fields["ዕዝ"]->searchExpression(), "=", $curVal, $this->ez->Lookup->getTable()->Fields["ዕዝ"]->searchDataType(), "");
                    $sqlWrk = $this->ez->Lookup->getSql(false, $filterWrk, '', $this, true, true);
                    $conn = Conn();
                    $config = $conn->getConfiguration();
                    $config->setResultCache($this->Cache);
                    $rswrk = $conn->executeCacheQuery($sqlWrk, [], [], $this->CacheProfile)->fetchAll();
                    $ari = count($rswrk);
                    if ($ari > 0) { // Lookup values found
                        $arwrk = $this->ez->Lookup->renderViewRow($rswrk[0]);
                        $this->ez->ViewValue = $this->ez->displayValue($arwrk);
                    } else {
                        $this->ez->ViewValue = $this->ez->CurrentValue;
                    }
                }
            } else {
                $this->ez->ViewValue = null;
            }
            $this->ez->CellCssClass = ($this->RecordCount % 2 != 1 ? "ew-table-alt-row" : "");

            // keteroreason
            $curVal = strval($this->keteroreason->CurrentValue);
            if ($curVal != "") {
                $this->keteroreason->ViewValue = $this->keteroreason->lookupCacheOption($curVal);
                if ($this->keteroreason->ViewValue === null) { // Lookup from database
                    $filterWrk = SearchFilter($this->keteroreason->Lookup->getTable()->Fields["ዕዝ"]->searchExpression(), "=", $curVal, $this->keteroreason->Lookup->getTable()->Fields["ዕዝ"]->searchDataType(), "");
                    $sqlWrk = $this->keteroreason->Lookup->getSql(false, $filterWrk, '', $this, true, true);
                    $conn = Conn();
                    $config = $conn->getConfiguration();
                    $config->setResultCache($this->Cache);
                    $rswrk = $conn->executeCacheQuery($sqlWrk, [], [], $this->CacheProfile)->fetchAll();
                    $ari = count($rswrk);
                    if ($ari > 0) { // Lookup values found
                        $arwrk = $this->keteroreason->Lookup->renderViewRow($rswrk[0]);
                        $this->keteroreason->ViewValue = $this->keteroreason->displayValue($arwrk);
                    } else {
                        $this->keteroreason->ViewValue = $this->keteroreason->CurrentValue;
                    }
                }
            } else {
                $this->keteroreason->ViewValue = null;
            }
            $this->keteroreason->CellCssClass = ($this->RecordCount % 2 != 1 ? "ew-table-alt-row" : "");

            // created_at
            $this->created_at->ViewValue = $this->created_at->CurrentValue;
            $this->created_at->ViewValue = FormatDateTime($this->created_at->ViewValue, $this->created_at->formatPattern());
            $this->created_at->CellCssClass = ($this->RecordCount % 2 != 1 ? "ew-table-alt-row" : "");

            // kirihidet
            $curVal = strval($this->kirihidet->CurrentValue);
            if ($curVal != "") {
                $this->kirihidet->ViewValue = $this->kirihidet->lookupCacheOption($curVal);
                if ($this->kirihidet->ViewValue === null) { // Lookup from database
                    $filterWrk = SearchFilter($this->kirihidet->Lookup->getTable()->Fields["ዕዝ"]->searchExpression(), "=", $curVal, $this->kirihidet->Lookup->getTable()->Fields["ዕዝ"]->searchDataType(), "");
                    $sqlWrk = $this->kirihidet->Lookup->getSql(false, $filterWrk, '', $this, true, true);
                    $conn = Conn();
                    $config = $conn->getConfiguration();
                    $config->setResultCache($this->Cache);
                    $rswrk = $conn->executeCacheQuery($sqlWrk, [], [], $this->CacheProfile)->fetchAll();
                    $ari = count($rswrk);
                    if ($ari > 0) { // Lookup values found
                        $arwrk = $this->kirihidet->Lookup->renderViewRow($rswrk[0]);
                        $this->kirihidet->ViewValue = $this->kirihidet->displayValue($arwrk);
                    } else {
                        $this->kirihidet->ViewValue = $this->kirihidet->CurrentValue;
                    }
                }
            } else {
                $this->kirihidet->ViewValue = null;
            }
            $this->kirihidet->CellCssClass = ($this->RecordCount % 2 != 1 ? "ew-table-alt-row" : "");

            // melequtir
            $this->melequtir->HrefValue = "";
            $this->melequtir->TooltipValue = "";

            // fileNumber
            $this->fileNumber->HrefValue = "";
            $this->fileNumber->TooltipValue = "";

            // name
            $this->name->HrefValue = "";
            $this->name->TooltipValue = "";

            // yekisaynet
            $this->yekisaynet->HrefValue = "";
            $this->yekisaynet->TooltipValue = "";

            // chilotname
            $this->chilotname->HrefValue = "";
            $this->chilotname->TooltipValue = "";

            // ez
            $this->ez->HrefValue = "";
            $this->ez->TooltipValue = "";

            // keteroreason
            $this->keteroreason->HrefValue = "";
            $this->keteroreason->TooltipValue = "";

            // created_at
            $this->created_at->HrefValue = "";
            $this->created_at->TooltipValue = "";

            // kirihidet
            $this->kirihidet->HrefValue = "";
            $this->kirihidet->TooltipValue = "";
        }

        // Call Cell_Rendered event
        if ($this->RowType == RowType::TOTAL) {
            // melequtir
            $currentValue = $this->melequtir->GroupViewValue;
            $viewValue = &$this->melequtir->GroupViewValue;
            $viewAttrs = &$this->melequtir->ViewAttrs;
            $cellAttrs = &$this->melequtir->CellAttrs;
            $hrefValue = &$this->melequtir->HrefValue;
            $linkAttrs = &$this->melequtir->LinkAttrs;
            $this->cellRendered($this->melequtir, $currentValue, $viewValue, $viewAttrs, $cellAttrs, $hrefValue, $linkAttrs);
        } else {
            // melequtir
            $currentValue = $this->melequtir->groupValue();
            $viewValue = &$this->melequtir->GroupViewValue;
            $viewAttrs = &$this->melequtir->ViewAttrs;
            $cellAttrs = &$this->melequtir->CellAttrs;
            $hrefValue = &$this->melequtir->HrefValue;
            $linkAttrs = &$this->melequtir->LinkAttrs;
            $this->cellRendered($this->melequtir, $currentValue, $viewValue, $viewAttrs, $cellAttrs, $hrefValue, $linkAttrs);

            // fileNumber
            $currentValue = $this->fileNumber->CurrentValue;
            $viewValue = &$this->fileNumber->ViewValue;
            $viewAttrs = &$this->fileNumber->ViewAttrs;
            $cellAttrs = &$this->fileNumber->CellAttrs;
            $hrefValue = &$this->fileNumber->HrefValue;
            $linkAttrs = &$this->fileNumber->LinkAttrs;
            $this->cellRendered($this->fileNumber, $currentValue, $viewValue, $viewAttrs, $cellAttrs, $hrefValue, $linkAttrs);

            // name
            $currentValue = $this->name->CurrentValue;
            $viewValue = &$this->name->ViewValue;
            $viewAttrs = &$this->name->ViewAttrs;
            $cellAttrs = &$this->name->CellAttrs;
            $hrefValue = &$this->name->HrefValue;
            $linkAttrs = &$this->name->LinkAttrs;
            $this->cellRendered($this->name, $currentValue, $viewValue, $viewAttrs, $cellAttrs, $hrefValue, $linkAttrs);

            // yekisaynet
            $currentValue = $this->yekisaynet->CurrentValue;
            $viewValue = &$this->yekisaynet->ViewValue;
            $viewAttrs = &$this->yekisaynet->ViewAttrs;
            $cellAttrs = &$this->yekisaynet->CellAttrs;
            $hrefValue = &$this->yekisaynet->HrefValue;
            $linkAttrs = &$this->yekisaynet->LinkAttrs;
            $this->cellRendered($this->yekisaynet, $currentValue, $viewValue, $viewAttrs, $cellAttrs, $hrefValue, $linkAttrs);

            // chilotname
            $currentValue = $this->chilotname->CurrentValue;
            $viewValue = &$this->chilotname->ViewValue;
            $viewAttrs = &$this->chilotname->ViewAttrs;
            $cellAttrs = &$this->chilotname->CellAttrs;
            $hrefValue = &$this->chilotname->HrefValue;
            $linkAttrs = &$this->chilotname->LinkAttrs;
            $this->cellRendered($this->chilotname, $currentValue, $viewValue, $viewAttrs, $cellAttrs, $hrefValue, $linkAttrs);

            // ez
            $currentValue = $this->ez->CurrentValue;
            $viewValue = &$this->ez->ViewValue;
            $viewAttrs = &$this->ez->ViewAttrs;
            $cellAttrs = &$this->ez->CellAttrs;
            $hrefValue = &$this->ez->HrefValue;
            $linkAttrs = &$this->ez->LinkAttrs;
            $this->cellRendered($this->ez, $currentValue, $viewValue, $viewAttrs, $cellAttrs, $hrefValue, $linkAttrs);

            // keteroreason
            $currentValue = $this->keteroreason->CurrentValue;
            $viewValue = &$this->keteroreason->ViewValue;
            $viewAttrs = &$this->keteroreason->ViewAttrs;
            $cellAttrs = &$this->keteroreason->CellAttrs;
            $hrefValue = &$this->keteroreason->HrefValue;
            $linkAttrs = &$this->keteroreason->LinkAttrs;
            $this->cellRendered($this->keteroreason, $currentValue, $viewValue, $viewAttrs, $cellAttrs, $hrefValue, $linkAttrs);

            // created_at
            $currentValue = $this->created_at->CurrentValue;
            $viewValue = &$this->created_at->ViewValue;
            $viewAttrs = &$this->created_at->ViewAttrs;
            $cellAttrs = &$this->created_at->CellAttrs;
            $hrefValue = &$this->created_at->HrefValue;
            $linkAttrs = &$this->created_at->LinkAttrs;
            $this->cellRendered($this->created_at, $currentValue, $viewValue, $viewAttrs, $cellAttrs, $hrefValue, $linkAttrs);

            // kirihidet
            $currentValue = $this->kirihidet->CurrentValue;
            $viewValue = &$this->kirihidet->ViewValue;
            $viewAttrs = &$this->kirihidet->ViewAttrs;
            $cellAttrs = &$this->kirihidet->CellAttrs;
            $hrefValue = &$this->kirihidet->HrefValue;
            $linkAttrs = &$this->kirihidet->LinkAttrs;
            $this->cellRendered($this->kirihidet, $currentValue, $viewValue, $viewAttrs, $cellAttrs, $hrefValue, $linkAttrs);
        }

        // Call Row_Rendered event
        $this->rowRendered();
        $this->setupFieldCount();
    }
    private $groupCounts = [];

    // Get group count
    public function getGroupCount(...$args)
    {
        $key = "";
        foreach ($args as $arg) {
            if ($key != "") {
                $key .= "_";
            }
            $key .= strval($arg);
        }
        if ($key == "") {
            return -1;
        } elseif ($key == "0") { // Number of first level groups
            $i = 1;
            while (isset($this->groupCounts[strval($i)])) {
                $i++;
            }
            return $i - 1;
        }
        return isset($this->groupCounts[$key]) ? $this->groupCounts[$key] : -1;
    }

    // Set group count
    public function setGroupCount($value, ...$args)
    {
        $key = "";
        foreach ($args as $arg) {
            if ($key != "") {
                $key .= "_";
            }
            $key .= strval($arg);
        }
        if ($key == "") {
            return;
        }
        $this->groupCounts[$key] = $value;
    }

    // Setup field count
    protected function setupFieldCount()
    {
        $this->GroupColumnCount = 0;
        $this->SubGroupColumnCount = 0;
        $this->DetailColumnCount = 0;
        if ($this->melequtir->Visible) {
            $this->GroupColumnCount += 1;
        }
        if ($this->fileNumber->Visible) {
            $this->DetailColumnCount += 1;
        }
        if ($this->name->Visible) {
            $this->DetailColumnCount += 1;
        }
        if ($this->yekisaynet->Visible) {
            $this->DetailColumnCount += 1;
        }
        if ($this->chilotname->Visible) {
            $this->DetailColumnCount += 1;
        }
        if ($this->ez->Visible) {
            $this->DetailColumnCount += 1;
        }
        if ($this->keteroreason->Visible) {
            $this->DetailColumnCount += 1;
        }
        if ($this->created_at->Visible) {
            $this->DetailColumnCount += 1;
        }
        if ($this->kirihidet->Visible) {
            $this->DetailColumnCount += 1;
        }
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
        $item->Body = "<a class=\"btn btn-default ew-search-toggle" . $searchToggleClass . "\" role=\"button\" title=\"" . $Language->phrase("SearchPanel") . "\" data-caption=\"" . $Language->phrase("SearchPanel") . "\" data-ew-action=\"search-toggle\" data-form=\"fReport2srch\" aria-pressed=\"" . ($searchToggleClass == " active" ? "true" : "false") . "\">" . $Language->phrase("SearchLink") . "</a>";
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
        return $this->melequtir->Visible || $this->fileNumber->Visible || $this->created_at->Visible;
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
        $Breadcrumb->add("summary", $this->TableVar, $url, "", $this->TableVar, true);
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
                case "x_yekisaynet":
                    break;
                case "x_chilotname":
                    break;
                case "x_ez":
                    break;
                case "x_keteroreason":
                    break;
                case "x_kirihidet":
                    break;
                case "x_RANKe":
                    break;
                case "x_firdbet":
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
        $item->Body = "<a class=\"ew-save-filter\" data-form=\"fReport2srch\" data-ew-action=\"none\">" . $Language->phrase("SaveCurrentFilter") . "</a>";
        $item->Visible = true;
        $item = &$this->FilterOptions->add("deletefilter");
        $item->Body = "<a class=\"ew-delete-filter\" data-form=\"fReport2srch\" data-ew-action=\"none\">" . $Language->phrase("DeleteFilter") . "</a>";
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
            $this->melequtir->setSort("");
            $this->fileNumber->setSort("");
            $this->name->setSort("");
            $this->yekisaynet->setSort("");
            $this->chilotname->setSort("");
            $this->ez->setSort("");
            $this->keteroreason->setSort("");
            $this->created_at->setSort("");
            $this->kirihidet->setSort("");

        // Check for an Order parameter
        } elseif ($orderBy != "") {
            $this->CurrentOrder = $orderBy;
            $this->CurrentOrderType = $orderType;
            $this->updateSort($this->melequtir); // melequtir
            $this->updateSort($this->fileNumber); // fileNumber
            $this->updateSort($this->name); // name
            $this->updateSort($this->yekisaynet); // yekisaynet
            $this->updateSort($this->chilotname); // chilotname
            $this->updateSort($this->ez); // ez
            $this->updateSort($this->keteroreason); // keteroreason
            $this->updateSort($this->created_at); // created_at
            $this->updateSort($this->kirihidet); // kirihidet
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
            $this->melequtir->AdvancedSearch->unsetSession();
            $this->fileNumber->AdvancedSearch->unsetSession();
            $this->created_at->AdvancedSearch->unsetSession();
            $restoreDefault = true;
        } else {
            $restoreSession = !$this->SearchCommand;

            // Field melequtir
            if ($this->melequtir->AdvancedSearch->get()) {
            }

            // Field fileNumber
            if ($this->fileNumber->AdvancedSearch->get()) {
            }

            // Field created_at
            if ($this->created_at->AdvancedSearch->get()) {
            }
            if (!$this->validateForm()) {
                return $filter;
            }
        }

        // Restore session
        if ($restoreSession) {
            $restoreDefault = true;
            if ($this->melequtir->AdvancedSearch->issetSession()) { // Field melequtir
                $this->melequtir->AdvancedSearch->load();
                $restoreDefault = false;
            }
            if ($this->fileNumber->AdvancedSearch->issetSession()) { // Field fileNumber
                $this->fileNumber->AdvancedSearch->load();
                $restoreDefault = false;
            }
            if ($this->created_at->AdvancedSearch->issetSession()) { // Field created_at
                $this->created_at->AdvancedSearch->load();
                $restoreDefault = false;
            }
        }

        // Restore default
        if ($restoreDefault) {
            $this->loadDefaultFilters();
        }

        // Call page filter validated event
        $this->pageFilterValidated();

        // Build SQL and save to session
        $this->buildExtendedFilter($this->melequtir, $filter, false, true); // Field melequtir
        $this->melequtir->AdvancedSearch->save();
        $this->buildExtendedFilter($this->fileNumber, $filter, false, true); // Field fileNumber
        $this->fileNumber->AdvancedSearch->save();
        $this->buildExtendedFilter($this->created_at, $filter, false, true); // Field created_at
        $this->created_at->AdvancedSearch->save();
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
        // Field melequtir
        $this->melequtir->AdvancedSearch->loadDefault();

        // Field fileNumber
        $this->fileNumber->AdvancedSearch->loadDefault();

        // Field created_at
        $this->created_at->AdvancedSearch->loadDefault();
    }

    // Show list of filters
    public function showFilterList()
    {
        global $Language;

        // Initialize
        $filterList = "";
        $captionClass = $this->isExport("email") ? "ew-filter-caption-email" : "ew-filter-caption";
        $captionSuffix = $this->isExport("email") ? ": " : "";

        // Field melequtir
        $extWrk = "";
        $this->buildExtendedFilter($this->melequtir, $extWrk);
        $filter = "";
        if ($extWrk != "") {
            $filter .= "<span class=\"ew-filter-value\">$extWrk</span>";
        }
        if ($filter != "") {
            $filterList .= "<div><span class=\"" . $captionClass . "\">" . $this->melequtir->caption() . "</span>" . $captionSuffix . $filter . "</div>";
        }

        // Field fileNumber
        $extWrk = "";
        $this->buildExtendedFilter($this->fileNumber, $extWrk);
        $filter = "";
        if ($extWrk != "") {
            $filter .= "<span class=\"ew-filter-value\">$extWrk</span>";
        }
        if ($filter != "") {
            $filterList .= "<div><span class=\"" . $captionClass . "\">" . $this->fileNumber->caption() . "</span>" . $captionSuffix . $filter . "</div>";
        }

        // Field created_at
        $extWrk = "";
        $this->buildExtendedFilter($this->created_at, $extWrk);
        $filter = "";
        if ($extWrk != "") {
            $filter .= "<span class=\"ew-filter-value\">$extWrk</span>";
        }
        if ($filter != "") {
            $filterList .= "<div><span class=\"" . $captionClass . "\">" . $this->created_at->caption() . "</span>" . $captionSuffix . $filter . "</div>";
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
            $savedFilterList = Profile()->getSearchFilters("fReport2srch");
        }

        // Field melequtir
        $wrk = "";
        if ($this->melequtir->AdvancedSearch->SearchValue != "" || $this->melequtir->AdvancedSearch->SearchValue2 != "") {
            $wrk = "\"x_melequtir\":\"" . JsEncode($this->melequtir->AdvancedSearch->SearchValue) . "\"," .
                "\"z_melequtir\":\"" . JsEncode($this->melequtir->AdvancedSearch->SearchOperator) . "\"," .
                "\"v_melequtir\":\"" . JsEncode($this->melequtir->AdvancedSearch->SearchCondition) . "\"," .
                "\"y_melequtir\":\"" . JsEncode($this->melequtir->AdvancedSearch->SearchValue2) . "\"," .
                "\"w_melequtir\":\"" . JsEncode($this->melequtir->AdvancedSearch->SearchOperator2) . "\"";
        }
        if ($wrk != "") {
            if ($filterList != "") {
                $filterList .= ",";
            }
            $filterList .= $wrk;
        }

        // Field fileNumber
        $wrk = "";
        if ($this->fileNumber->AdvancedSearch->SearchValue != "" || $this->fileNumber->AdvancedSearch->SearchValue2 != "") {
            $wrk = "\"x_fileNumber\":\"" . JsEncode($this->fileNumber->AdvancedSearch->SearchValue) . "\"," .
                "\"z_fileNumber\":\"" . JsEncode($this->fileNumber->AdvancedSearch->SearchOperator) . "\"," .
                "\"v_fileNumber\":\"" . JsEncode($this->fileNumber->AdvancedSearch->SearchCondition) . "\"," .
                "\"y_fileNumber\":\"" . JsEncode($this->fileNumber->AdvancedSearch->SearchValue2) . "\"," .
                "\"w_fileNumber\":\"" . JsEncode($this->fileNumber->AdvancedSearch->SearchOperator2) . "\"";
        }
        if ($wrk != "") {
            if ($filterList != "") {
                $filterList .= ",";
            }
            $filterList .= $wrk;
        }

        // Field created_at
        $wrk = "";
        if ($this->created_at->AdvancedSearch->SearchValue != "" || $this->created_at->AdvancedSearch->SearchValue2 != "") {
            $wrk = "\"x_created_at\":\"" . JsEncode($this->created_at->AdvancedSearch->SearchValue) . "\"," .
                "\"z_created_at\":\"" . JsEncode($this->created_at->AdvancedSearch->SearchOperator) . "\"," .
                "\"v_created_at\":\"" . JsEncode($this->created_at->AdvancedSearch->SearchCondition) . "\"," .
                "\"y_created_at\":\"" . JsEncode($this->created_at->AdvancedSearch->SearchValue2) . "\"," .
                "\"w_created_at\":\"" . JsEncode($this->created_at->AdvancedSearch->SearchOperator2) . "\"";
        }
        if ($wrk != "") {
            if ($filterList != "") {
                $filterList .= ",";
            }
            $filterList .= $wrk;
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
            Profile()->setSearchFilters("fReport2srch", $filters);
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

        // Field melequtir
        if (!$this->melequtir->AdvancedSearch->get($filter)) {
            $this->melequtir->AdvancedSearch->loadDefault(); // Clear filter
        }
        $this->melequtir->AdvancedSearch->save();

        // Field fileNumber
        if (!$this->fileNumber->AdvancedSearch->get($filter)) {
            $this->fileNumber->AdvancedSearch->loadDefault(); // Clear filter
        }
        $this->fileNumber->AdvancedSearch->save();

        // Field created_at
        if (!$this->created_at->AdvancedSearch->get($filter)) {
            $this->created_at->AdvancedSearch->loadDefault(); // Clear filter
        }
        $this->created_at->AdvancedSearch->save();
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
