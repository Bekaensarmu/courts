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
class AppealEdit extends Appeal
{
    use MessagesTrait;

    // Page ID
    public $PageID = "edit";

    // Project ID
    public $ProjectID = PROJECT_ID;

    // Page object name
    public $PageObjName = "AppealEdit";

    // View file path
    public $View = null;

    // Title
    public $Title = null; // Title for <title> tag

    // Rendering View
    public $RenderingView = false;

    // CSS class/style
    public $CurrentPageName = "AppealEdit";

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
        if ($this->TableName) {
            return $Language->phrase($this->PageID);
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

    // Set field visibility
    public function setVisibility()
    {
        $this->AppealID->setVisibility();
        $this->appealDate->setVisibility();
        $this->mid->setVisibility();
        $this->rank->setVisibility();
        $this->name->setVisibility();
        $this->deptName->setVisibility();
        $this->halafinet->setVisibility();
        $this->crimstate->setVisibility();
        $this->Description->setVisibility();
        $this->midib->setVisibility();
        $this->appealask->setVisibility();
        $this->AppealDescription->setVisibility();
        $this->appealDecision->setVisibility();
        $this->created_at->setVisibility();
        $this->crimeDate->setVisibility();
        $this->updated_at->setVisibility();
        $this->updated_by->setVisibility();
        $this->id->Visible = false;
    }

    // Constructor
    public function __construct()
    {
        parent::__construct();
        global $Language, $DashboardReport, $DebugTimer, $UserTable;
        $this->TableVar = 'appeal';
        $this->TableName = 'appeal';

        // Table CSS class
        $this->TableClass = "table table-striped table-bordered table-hover table-sm ew-desktop-table ew-edit-table";

        // Initialize
        $GLOBALS["Page"] = &$this;

        // Language object
        $Language = Container("app.language");

        // Table object (appeal)
        if (!isset($GLOBALS["appeal"]) || $GLOBALS["appeal"]::class == PROJECT_NAMESPACE . "appeal") {
            $GLOBALS["appeal"] = &$this;
        }

        // Table name (for backward compatibility only)
        if (!defined(PROJECT_NAMESPACE . "TABLE_NAME")) {
            define(PROJECT_NAMESPACE . "TABLE_NAME", 'appeal');
        }

        // Start timer
        $DebugTimer = Container("debug.timer");

        // Debug message
        LoadDebugMessage();

        // Open connection
        $GLOBALS["Conn"] ??= $this->getConnection();

        // User table object
        $UserTable = Container("usertable");
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

        // Close connection
        CloseConnections();

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

            // Handle modal response
            if ($this->IsModal) { // Show as modal
                $pageName = GetPageName($url);
                $result = ["url" => GetUrl($url), "modal" => "1"];  // Assume return to modal for simplicity
                if (
                    SameString($pageName, GetPageName($this->getListUrl())) ||
                    SameString($pageName, GetPageName($this->getViewUrl())) ||
                    SameString($pageName, GetPageName(CurrentMasterTable()?->getViewUrl() ?? ""))
                ) { // List / View / Master View page
                    if (!SameString($pageName, GetPageName($this->getListUrl()))) { // Not List page
                        $result["caption"] = $this->getModalCaption($pageName);
                        $result["view"] = SameString($pageName, "AppealView"); // If View page, no primary button
                    } else { // List page
                        $result["error"] = $this->getFailureMessage(); // List page should not be shown as modal => error
                        $this->clearFailureMessage();
                    }
                } else { // Other pages (add messages and then clear messages)
                    $result = array_merge($this->getMessages(), ["modal" => "1"]);
                    $this->clearMessages();
                }
                WriteJson($result);
            } else {
                SaveDebugMessage();
                Redirect(GetUrl($url));
            }
        }
        return; // Return to controller
    }

    // Get records from result set
    protected function getRecordsFromRecordset($rs, $current = false)
    {
        $rows = [];
        if (is_object($rs)) { // Result set
            while ($row = $rs->fetch()) {
                $this->loadRowValues($row); // Set up DbValue/CurrentValue
                $row = $this->getRecordFromArray($row);
                if ($current) {
                    return $row;
                } else {
                    $rows[] = $row;
                }
            }
        } elseif (is_array($rs)) {
            foreach ($rs as $ar) {
                $row = $this->getRecordFromArray($ar);
                if ($current) {
                    return $row;
                } else {
                    $rows[] = $row;
                }
            }
        }
        return $rows;
    }

    // Get record from array
    protected function getRecordFromArray($ar)
    {
        $row = [];
        if (is_array($ar)) {
            foreach ($ar as $fldname => $val) {
                if (array_key_exists($fldname, $this->Fields) && ($this->Fields[$fldname]->Visible || $this->Fields[$fldname]->IsPrimaryKey)) { // Primary key or Visible
                    $fld = &$this->Fields[$fldname];
                    if ($fld->HtmlTag == "FILE") { // Upload field
                        if (EmptyValue($val)) {
                            $row[$fldname] = null;
                        } else {
                            if ($fld->DataType == DataType::BLOB) {
                                $url = FullUrl(GetApiUrl(Config("API_FILE_ACTION") .
                                    "/" . $fld->TableVar . "/" . $fld->Param . "/" . rawurlencode($this->getRecordKeyValue($ar))));
                                $row[$fldname] = ["type" => ContentType($val), "url" => $url, "name" => $fld->Param . ContentExtension($val)];
                            } elseif (!$fld->UploadMultiple || !ContainsString($val, Config("MULTIPLE_UPLOAD_SEPARATOR"))) { // Single file
                                $url = FullUrl(GetApiUrl(Config("API_FILE_ACTION") .
                                    "/" . $fld->TableVar . "/" . Encrypt($fld->physicalUploadPath() . $val)));
                                $row[$fldname] = ["type" => MimeContentType($val), "url" => $url, "name" => $val];
                            } else { // Multiple files
                                $files = explode(Config("MULTIPLE_UPLOAD_SEPARATOR"), $val);
                                $ar = [];
                                foreach ($files as $file) {
                                    $url = FullUrl(GetApiUrl(Config("API_FILE_ACTION") .
                                        "/" . $fld->TableVar . "/" . Encrypt($fld->physicalUploadPath() . $file)));
                                    if (!EmptyValue($file)) {
                                        $ar[] = ["type" => MimeContentType($file), "url" => $url, "name" => $file];
                                    }
                                }
                                $row[$fldname] = $ar;
                            }
                        }
                    } else {
                        $row[$fldname] = $val;
                    }
                }
            }
        }
        return $row;
    }

    // Get record key value from array
    protected function getRecordKeyValue($ar)
    {
        $key = "";
        if (is_array($ar)) {
            $key .= @$ar['id'];
        }
        return $key;
    }

    /**
     * Hide fields for add/edit
     *
     * @return void
     */
    protected function hideFieldsForAddEdit()
    {
        if ($this->isAdd() || $this->isCopy() || $this->isGridAdd()) {
            $this->id->Visible = false;
        }
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

    // Properties
    public $FormClassName = "ew-form ew-edit-form overlay-wrapper";
    public $IsModal = false;
    public $IsMobileOrModal = false;
    public $DbMasterFilter;
    public $DbDetailFilter;
    public $HashValue; // Hash Value
    public $DisplayRecords = 1;
    public $StartRecord;
    public $StopRecord;
    public $TotalRecords = 0;
    public $RecordRange = 10;
    public $RecordCount;

    /**
     * Page run
     *
     * @return void
     */
    public function run()
    {
        global $ExportType, $Language, $Security, $CurrentForm, $SkipHeaderFooter;

        // Is modal
        $this->IsModal = ConvertToBool(Param("modal"));
        $this->UseLayout = $this->UseLayout && !$this->IsModal;

        // Use layout
        $this->UseLayout = $this->UseLayout && ConvertToBool(Param(Config("PAGE_LAYOUT"), true));

        // View
        $this->View = Get(Config("VIEW"));

        // Load user profile
        if (IsLoggedIn()) {
            Profile()->setUserName(CurrentUserName())->loadFromStorage();

            // Force logout user
            if (!IsSysAdmin() && Profile()->isForceLogout(session_id())) {
                $this->terminate("logout");
                return;
            }

            // Check if valid user and update last accessed time
            if (!IsSysAdmin() && !IsPasswordExpired() && !Profile()->isValidUser(session_id(), false)) {
                $this->terminate("logout"); // Handle as session expired
                return;
            }
        }

        // Create form object
        $CurrentForm = new HttpForm();
        $this->CurrentAction = Param("action"); // Set up current action
        $this->setVisibility();

        // Set lookup cache
        if (!in_array($this->PageID, Config("LOOKUP_CACHE_PAGE_IDS"))) {
            $this->setUseLookupCache(false);
        }

        // Global Page Loading event (in userfn*.php)
        DispatchEvent(new PageLoadingEvent($this), PageLoadingEvent::NAME);

        // Page Load event
        if (method_exists($this, "pageLoad")) {
            $this->pageLoad();
        }

        // Hide fields for add/edit
        if (!$this->UseAjaxActions) {
            $this->hideFieldsForAddEdit();
        }
        // Use inline delete
        if ($this->UseAjaxActions) {
            $this->InlineDelete = true;
        }

        // Set up lookup cache
        $this->setupLookupOptions($this->AppealID);
        $this->setupLookupOptions($this->mid);
        $this->setupLookupOptions($this->rank);
        $this->setupLookupOptions($this->deptName);
        $this->setupLookupOptions($this->midib);
        $this->setupLookupOptions($this->appealask);
        $this->setupLookupOptions($this->AppealDescription);
        $this->setupLookupOptions($this->appealDecision);

        // Check modal
        if ($this->IsModal) {
            $SkipHeaderFooter = true;
        }
        $this->IsMobileOrModal = IsMobile() || $this->IsModal;

        // Load record by position
        $loadByPosition = false;
        $loaded = false;
        $postBack = false;

        // Set up current action and primary key
        if (IsApi()) {
            // Load key values
            $loaded = true;
            if (($keyValue = Get("id") ?? Key(0) ?? Route(2)) !== null) {
                $this->id->setQueryStringValue($keyValue);
                $this->id->setOldValue($this->id->QueryStringValue);
            } elseif (Post("id") !== null) {
                $this->id->setFormValue(Post("id"));
                $this->id->setOldValue($this->id->FormValue);
            } else {
                $loaded = false; // Unable to load key
            }

            // Load record
            if ($loaded) {
                $loaded = $this->loadRow();
            }
            if (!$loaded) {
                $this->setFailureMessage($Language->phrase("NoRecord")); // Set no record message
                $this->terminate();
                return;
            }
            $this->CurrentAction = "update"; // Update record directly
            $this->OldKey = $this->getKey(true); // Get from CurrentValue
            $postBack = true;
        } else {
            if (Post("action", "") !== "") {
                $this->CurrentAction = Post("action"); // Get action code
                if (!$this->isShow()) { // Not reload record, handle as postback
                    $postBack = true;
                }

                // Get key from Form
                $this->setKey(Post($this->OldKeyName), $this->isShow());
            } else {
                $this->CurrentAction = "show"; // Default action is display

                // Load key from QueryString
                $loadByQuery = false;
                if (($keyValue = Get("id") ?? Route("id")) !== null) {
                    $this->id->setQueryStringValue($keyValue);
                    $loadByQuery = true;
                } else {
                    $this->id->CurrentValue = null;
                }
                if (!$loadByQuery || Get(Config("TABLE_START_REC")) !== null || Get(Config("TABLE_PAGE_NUMBER")) !== null) {
                    $loadByPosition = true;
                }
            }

            // Load result set
            if ($this->isShow()) {
                if (!$this->IsModal) { // Normal edit page
                    $this->StartRecord = 1; // Initialize start position
                    $this->Recordset = $this->loadRecordset(); // Load records
                    if ($this->TotalRecords <= 0) { // No record found
                        if ($this->getSuccessMessage() == "" && $this->getFailureMessage() == "") {
                            $this->setFailureMessage($Language->phrase("NoRecord")); // Set no record message
                        }
                        $this->terminate("AppealList"); // Return to list page
                        return;
                    } elseif ($loadByPosition) { // Load record by position
                        $this->setupStartRecord(); // Set up start record position
                        // Point to current record
                        if ($this->StartRecord <= $this->TotalRecords) {
                            $this->fetch($this->StartRecord);
                            // Redirect to correct record
                            $this->loadRowValues($this->CurrentRow);
                            $url = $this->getCurrentUrl();
                            $this->terminate($url);
                            return;
                        }
                    } else { // Match key values
                        if ($this->id->CurrentValue != null) {
                            while ($this->fetch()) {
                                if (SameString($this->id->CurrentValue, $this->CurrentRow['id'])) {
                                    $this->setStartRecordNumber($this->StartRecord); // Save record position
                                    $loaded = true;
                                    break;
                                } else {
                                    $this->StartRecord++;
                                }
                            }
                        }
                    }

                    // Load current row values
                    if ($loaded) {
                        $this->loadRowValues($this->CurrentRow);
                    }
                } else {
                    // Load current record
                    $loaded = $this->loadRow();
                } // End modal checking
                $this->OldKey = $loaded ? $this->getKey(true) : ""; // Get from CurrentValue
            }
        }

        // Process form if post back
        if ($postBack) {
            $this->loadFormValues(); // Get form values
        }

        // Validate form if post back
        if ($postBack) {
            if (!$this->validateForm()) {
                $this->EventCancelled = true; // Event cancelled
                $this->restoreFormValues();
                if (IsApi()) {
                    $this->terminate();
                    return;
                } else {
                    $this->CurrentAction = ""; // Form error, reset action
                }
            }
        }

        // Perform current action
        switch ($this->CurrentAction) {
            case "show": // Get a record to display
                if (!$this->IsModal) { // Normal edit page
                    if (!$loaded) {
                        if ($this->getSuccessMessage() == "" && $this->getFailureMessage() == "") {
                            $this->setFailureMessage($Language->phrase("NoRecord")); // Set no record message
                        }
                        $this->terminate("AppealList"); // Return to list page
                        return;
                    } else {
                    }
                } else { // Modal edit page
                    if (!$loaded) { // Load record based on key
                        if ($this->getFailureMessage() == "") {
                            $this->setFailureMessage($Language->phrase("NoRecord")); // No record found
                        }
                        $this->terminate("AppealList"); // No matching record, return to list
                        return;
                    }
                } // End modal checking
                break;
            case "update": // Update
                $returnUrl = $this->getReturnUrl();
                if (GetPageName($returnUrl) == "AppealList") {
                    $returnUrl = $this->addMasterUrl($returnUrl); // List page, return to List page with correct master key if necessary
                }
                $this->SendEmail = true; // Send email on update success
                if ($this->editRow()) { // Update record based on key
                    if ($this->getSuccessMessage() == "") {
                        $this->setSuccessMessage($Language->phrase("UpdateSuccess")); // Update success
                    }

                    // Handle UseAjaxActions with return page
                    if ($this->IsModal && $this->UseAjaxActions) {
                        $this->IsModal = false;
                        if (GetPageName($returnUrl) != "AppealList") {
                            Container("app.flash")->addMessage("Return-Url", $returnUrl); // Save return URL
                            $returnUrl = "AppealList"; // Return list page content
                        }
                    }
                    if (IsJsonResponse()) {
                        $this->terminate(true);
                        return;
                    } else {
                        $this->terminate($returnUrl); // Return to caller
                        return;
                    }
                } elseif (IsApi()) { // API request, return
                    $this->terminate();
                    return;
                } elseif ($this->IsModal && $this->UseAjaxActions) { // Return JSON error message
                    WriteJson(["success" => false, "validation" => $this->getValidationErrors(), "error" => $this->getFailureMessage()]);
                    $this->clearFailureMessage();
                    $this->terminate();
                    return;
                } elseif ($this->getFailureMessage() == $Language->phrase("NoRecord")) {
                    $this->terminate($returnUrl); // Return to caller
                    return;
                } else {
                    $this->EventCancelled = true; // Event cancelled
                    $this->restoreFormValues(); // Restore form values if update failed
                }
        }

        // Set up Breadcrumb
        $this->setupBreadcrumb();

        // Render the record
        $this->RowType = RowType::EDIT; // Render as Edit
        $this->resetAttributes();
        $this->renderRow();
        if (!$this->IsModal) { // Normal view page
            $this->Pager = new PrevNextPager($this, $this->StartRecord, $this->DisplayRecords, $this->TotalRecords, "", $this->RecordRange, $this->AutoHidePager, false, false);
            $this->Pager->PageNumberName = Config("TABLE_PAGE_NUMBER");
            $this->Pager->PagePhraseId = "Record"; // Show as record
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

    // Get upload files
    protected function getUploadFiles()
    {
        global $CurrentForm, $Language;
    }

    // Load form values
    protected function loadFormValues()
    {
        // Load from form
        global $CurrentForm;
        $validate = !Config("SERVER_VALIDATE");

        // Check field name 'AppealID' first before field var 'x_AppealID'
        $val = $CurrentForm->hasValue("AppealID") ? $CurrentForm->getValue("AppealID") : $CurrentForm->getValue("x_AppealID");
        if (!$this->AppealID->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->AppealID->Visible = false; // Disable update for API request
            } else {
                $this->AppealID->setFormValue($val);
            }
        }

        // Check field name 'appealDate' first before field var 'x_appealDate'
        $val = $CurrentForm->hasValue("appealDate") ? $CurrentForm->getValue("appealDate") : $CurrentForm->getValue("x_appealDate");
        if (!$this->appealDate->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->appealDate->Visible = false; // Disable update for API request
            } else {
                $this->appealDate->setFormValue($val, true, $validate);
            }
            $this->appealDate->CurrentValue = UnFormatDateTime($this->appealDate->CurrentValue, $this->appealDate->formatPattern());
        }

        // Check field name 'mid' first before field var 'x_mid'
        $val = $CurrentForm->hasValue("mid") ? $CurrentForm->getValue("mid") : $CurrentForm->getValue("x_mid");
        if (!$this->mid->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->mid->Visible = false; // Disable update for API request
            } else {
                $this->mid->setFormValue($val);
            }
        }

        // Check field name 'rank' first before field var 'x_rank'
        $val = $CurrentForm->hasValue("rank") ? $CurrentForm->getValue("rank") : $CurrentForm->getValue("x_rank");
        if (!$this->rank->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->rank->Visible = false; // Disable update for API request
            } else {
                $this->rank->setFormValue($val);
            }
        }

        // Check field name 'name' first before field var 'x_name'
        $val = $CurrentForm->hasValue("name") ? $CurrentForm->getValue("name") : $CurrentForm->getValue("x_name");
        if (!$this->name->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->name->Visible = false; // Disable update for API request
            } else {
                $this->name->setFormValue($val);
            }
        }

        // Check field name 'deptName' first before field var 'x_deptName'
        $val = $CurrentForm->hasValue("deptName") ? $CurrentForm->getValue("deptName") : $CurrentForm->getValue("x_deptName");
        if (!$this->deptName->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->deptName->Visible = false; // Disable update for API request
            } else {
                $this->deptName->setFormValue($val);
            }
        }

        // Check field name 'halafinet' first before field var 'x_halafinet'
        $val = $CurrentForm->hasValue("halafinet") ? $CurrentForm->getValue("halafinet") : $CurrentForm->getValue("x_halafinet");
        if (!$this->halafinet->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->halafinet->Visible = false; // Disable update for API request
            } else {
                $this->halafinet->setFormValue($val);
            }
        }

        // Check field name 'crimstate' first before field var 'x_crimstate'
        $val = $CurrentForm->hasValue("crimstate") ? $CurrentForm->getValue("crimstate") : $CurrentForm->getValue("x_crimstate");
        if (!$this->crimstate->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->crimstate->Visible = false; // Disable update for API request
            } else {
                $this->crimstate->setFormValue($val);
            }
        }

        // Check field name 'Description' first before field var 'x_Description'
        $val = $CurrentForm->hasValue("Description") ? $CurrentForm->getValue("Description") : $CurrentForm->getValue("x_Description");
        if (!$this->Description->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->Description->Visible = false; // Disable update for API request
            } else {
                $this->Description->setFormValue($val);
            }
        }

        // Check field name 'midib' first before field var 'x_midib'
        $val = $CurrentForm->hasValue("midib") ? $CurrentForm->getValue("midib") : $CurrentForm->getValue("x_midib");
        if (!$this->midib->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->midib->Visible = false; // Disable update for API request
            } else {
                $this->midib->setFormValue($val);
            }
        }

        // Check field name 'appealask' first before field var 'x_appealask'
        $val = $CurrentForm->hasValue("appealask") ? $CurrentForm->getValue("appealask") : $CurrentForm->getValue("x_appealask");
        if (!$this->appealask->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->appealask->Visible = false; // Disable update for API request
            } else {
                $this->appealask->setFormValue($val);
            }
        }

        // Check field name 'AppealDescription' first before field var 'x_AppealDescription'
        $val = $CurrentForm->hasValue("AppealDescription") ? $CurrentForm->getValue("AppealDescription") : $CurrentForm->getValue("x_AppealDescription");
        if (!$this->AppealDescription->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->AppealDescription->Visible = false; // Disable update for API request
            } else {
                $this->AppealDescription->setFormValue($val);
            }
        }

        // Check field name 'appealDecision' first before field var 'x_appealDecision'
        $val = $CurrentForm->hasValue("appealDecision") ? $CurrentForm->getValue("appealDecision") : $CurrentForm->getValue("x_appealDecision");
        if (!$this->appealDecision->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->appealDecision->Visible = false; // Disable update for API request
            } else {
                $this->appealDecision->setFormValue($val);
            }
        }

        // Check field name 'created_at' first before field var 'x_created_at'
        $val = $CurrentForm->hasValue("created_at") ? $CurrentForm->getValue("created_at") : $CurrentForm->getValue("x_created_at");
        if (!$this->created_at->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->created_at->Visible = false; // Disable update for API request
            } else {
                $this->created_at->setFormValue($val, true, $validate);
            }
            $this->created_at->CurrentValue = UnFormatDateTime($this->created_at->CurrentValue, $this->created_at->formatPattern());
        }

        // Check field name 'crimeDate' first before field var 'x_crimeDate'
        $val = $CurrentForm->hasValue("crimeDate") ? $CurrentForm->getValue("crimeDate") : $CurrentForm->getValue("x_crimeDate");
        if (!$this->crimeDate->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->crimeDate->Visible = false; // Disable update for API request
            } else {
                $this->crimeDate->setFormValue($val, true, $validate);
            }
            $this->crimeDate->CurrentValue = UnFormatDateTime($this->crimeDate->CurrentValue, $this->crimeDate->formatPattern());
        }

        // Check field name 'updated_at' first before field var 'x_updated_at'
        $val = $CurrentForm->hasValue("updated_at") ? $CurrentForm->getValue("updated_at") : $CurrentForm->getValue("x_updated_at");
        if (!$this->updated_at->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->updated_at->Visible = false; // Disable update for API request
            } else {
                $this->updated_at->setFormValue($val);
            }
            $this->updated_at->CurrentValue = UnFormatDateTime($this->updated_at->CurrentValue, $this->updated_at->formatPattern());
        }

        // Check field name 'updated_by' first before field var 'x_updated_by'
        $val = $CurrentForm->hasValue("updated_by") ? $CurrentForm->getValue("updated_by") : $CurrentForm->getValue("x_updated_by");
        if (!$this->updated_by->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->updated_by->Visible = false; // Disable update for API request
            } else {
                $this->updated_by->setFormValue($val);
            }
        }

        // Check field name 'id' first before field var 'x_id'
        $val = $CurrentForm->hasValue("id") ? $CurrentForm->getValue("id") : $CurrentForm->getValue("x_id");
        if (!$this->id->IsDetailKey) {
            $this->id->setFormValue($val);
        }
    }

    // Restore form values
    public function restoreFormValues()
    {
        global $CurrentForm;
        $this->id->CurrentValue = $this->id->FormValue;
        $this->AppealID->CurrentValue = $this->AppealID->FormValue;
        $this->appealDate->CurrentValue = $this->appealDate->FormValue;
        $this->appealDate->CurrentValue = UnFormatDateTime($this->appealDate->CurrentValue, $this->appealDate->formatPattern());
        $this->mid->CurrentValue = $this->mid->FormValue;
        $this->rank->CurrentValue = $this->rank->FormValue;
        $this->name->CurrentValue = $this->name->FormValue;
        $this->deptName->CurrentValue = $this->deptName->FormValue;
        $this->halafinet->CurrentValue = $this->halafinet->FormValue;
        $this->crimstate->CurrentValue = $this->crimstate->FormValue;
        $this->Description->CurrentValue = $this->Description->FormValue;
        $this->midib->CurrentValue = $this->midib->FormValue;
        $this->appealask->CurrentValue = $this->appealask->FormValue;
        $this->AppealDescription->CurrentValue = $this->AppealDescription->FormValue;
        $this->appealDecision->CurrentValue = $this->appealDecision->FormValue;
        $this->created_at->CurrentValue = $this->created_at->FormValue;
        $this->created_at->CurrentValue = UnFormatDateTime($this->created_at->CurrentValue, $this->created_at->formatPattern());
        $this->crimeDate->CurrentValue = $this->crimeDate->FormValue;
        $this->crimeDate->CurrentValue = UnFormatDateTime($this->crimeDate->CurrentValue, $this->crimeDate->formatPattern());
        $this->updated_at->CurrentValue = $this->updated_at->FormValue;
        $this->updated_at->CurrentValue = UnFormatDateTime($this->updated_at->CurrentValue, $this->updated_at->formatPattern());
        $this->updated_by->CurrentValue = $this->updated_by->FormValue;
    }

    /**
     * Load result set
     *
     * @param int $offset Offset
     * @param int $rowcnt Maximum number of rows
     * @return Doctrine\DBAL\Result Result
     */
    public function loadRecordset($offset = -1, $rowcnt = -1)
    {
        // Load List page SQL (QueryBuilder)
        $sql = $this->getListSql();

        // Load result set
        if ($offset > -1) {
            $sql->setFirstResult($offset);
        }
        if ($rowcnt > 0) {
            $sql->setMaxResults($rowcnt);
        }
        $result = $sql->executeQuery();
        if (property_exists($this, "TotalRecords") && $rowcnt < 0) {
            $this->TotalRecords = $result->rowCount();
            if ($this->TotalRecords <= 0) { // Handle database drivers that does not return rowCount()
                $this->TotalRecords = $this->getRecordCount($this->getListSql());
            }
        }

        // Call Recordset Selected event
        $this->recordsetSelected($result);
        return $result;
    }

    /**
     * Load records as associative array
     *
     * @param int $offset Offset
     * @param int $rowcnt Maximum number of rows
     * @return void
     */
    public function loadRows($offset = -1, $rowcnt = -1)
    {
        // Load List page SQL (QueryBuilder)
        $sql = $this->getListSql();

        // Load result set
        if ($offset > -1) {
            $sql->setFirstResult($offset);
        }
        if ($rowcnt > 0) {
            $sql->setMaxResults($rowcnt);
        }
        $result = $sql->executeQuery();
        return $result->fetchAllAssociative();
    }

    /**
     * Load row based on key values
     *
     * @return void
     */
    public function loadRow()
    {
        global $Security, $Language;
        $filter = $this->getRecordFilter();

        // Call Row Selecting event
        $this->rowSelecting($filter);

        // Load SQL based on filter
        $this->CurrentFilter = $filter;
        $sql = $this->getCurrentSql();
        $conn = $this->getConnection();
        $res = false;
        $row = $conn->fetchAssociative($sql);
        if ($row) {
            $res = true;
            $this->loadRowValues($row); // Load row values
        }
        return $res;
    }

    /**
     * Load row values from result set or record
     *
     * @param array $row Record
     * @return void
     */
    public function loadRowValues($row = null)
    {
        $row = is_array($row) ? $row : $this->newRow();

        // Call Row Selected event
        $this->rowSelected($row);
        $this->AppealID->setDbValue($row['AppealID']);
        $this->appealDate->setDbValue($row['appealDate']);
        $this->mid->setDbValue($row['mid']);
        $this->rank->setDbValue($row['rank']);
        $this->name->setDbValue($row['name']);
        $this->deptName->setDbValue($row['deptName']);
        $this->halafinet->setDbValue($row['halafinet']);
        $this->crimstate->setDbValue($row['crimstate']);
        $this->Description->setDbValue($row['Description']);
        $this->midib->setDbValue($row['midib']);
        $this->appealask->setDbValue($row['appealask']);
        $this->AppealDescription->setDbValue($row['AppealDescription']);
        $this->appealDecision->setDbValue($row['appealDecision']);
        $this->created_at->setDbValue($row['created_at']);
        $this->crimeDate->setDbValue($row['crimeDate']);
        $this->updated_at->setDbValue($row['updated_at']);
        $this->updated_by->setDbValue($row['updated_by']);
        $this->id->setDbValue($row['id']);
    }

    // Return a row with default values
    protected function newRow()
    {
        $row = [];
        $row['AppealID'] = $this->AppealID->DefaultValue;
        $row['appealDate'] = $this->appealDate->DefaultValue;
        $row['mid'] = $this->mid->DefaultValue;
        $row['rank'] = $this->rank->DefaultValue;
        $row['name'] = $this->name->DefaultValue;
        $row['deptName'] = $this->deptName->DefaultValue;
        $row['halafinet'] = $this->halafinet->DefaultValue;
        $row['crimstate'] = $this->crimstate->DefaultValue;
        $row['Description'] = $this->Description->DefaultValue;
        $row['midib'] = $this->midib->DefaultValue;
        $row['appealask'] = $this->appealask->DefaultValue;
        $row['AppealDescription'] = $this->AppealDescription->DefaultValue;
        $row['appealDecision'] = $this->appealDecision->DefaultValue;
        $row['created_at'] = $this->created_at->DefaultValue;
        $row['crimeDate'] = $this->crimeDate->DefaultValue;
        $row['updated_at'] = $this->updated_at->DefaultValue;
        $row['updated_by'] = $this->updated_by->DefaultValue;
        $row['id'] = $this->id->DefaultValue;
        return $row;
    }

    // Load old record
    protected function loadOldRecord()
    {
        // Load old record
        if ($this->OldKey != "") {
            $this->setKey($this->OldKey);
            $this->CurrentFilter = $this->getRecordFilter();
            $sql = $this->getCurrentSql();
            $conn = $this->getConnection();
            $rs = ExecuteQuery($sql, $conn);
            if ($row = $rs->fetch()) {
                $this->loadRowValues($row); // Load row values
                return $row;
            }
        }
        $this->loadRowValues(); // Load default row values
        return null;
    }

    // Render row values based on field settings
    public function renderRow()
    {
        global $Security, $Language, $CurrentLanguage;

        // Initialize URLs

        // Call Row_Rendering event
        $this->rowRendering();

        // Common render codes for all row types

        // AppealID
        $this->AppealID->RowCssClass = "row";

        // appealDate
        $this->appealDate->RowCssClass = "row";

        // mid
        $this->mid->RowCssClass = "row";

        // rank
        $this->rank->RowCssClass = "row";

        // name
        $this->name->RowCssClass = "row";

        // deptName
        $this->deptName->RowCssClass = "row";

        // halafinet
        $this->halafinet->RowCssClass = "row";

        // crimstate
        $this->crimstate->RowCssClass = "row";

        // Description
        $this->Description->RowCssClass = "row";

        // midib
        $this->midib->RowCssClass = "row";

        // appealask
        $this->appealask->RowCssClass = "row";

        // AppealDescription
        $this->AppealDescription->RowCssClass = "row";

        // appealDecision
        $this->appealDecision->RowCssClass = "row";

        // created_at
        $this->created_at->RowCssClass = "row";

        // crimeDate
        $this->crimeDate->RowCssClass = "row";

        // updated_at
        $this->updated_at->RowCssClass = "row";

        // updated_by
        $this->updated_by->RowCssClass = "row";

        // id
        $this->id->RowCssClass = "row";

        // View row
        if ($this->RowType == RowType::VIEW) {
            // AppealID
            $curVal = strval($this->AppealID->CurrentValue);
            if ($curVal != "") {
                $this->AppealID->ViewValue = $this->AppealID->lookupCacheOption($curVal);
                if ($this->AppealID->ViewValue === null) { // Lookup from database
                    $filterWrk = SearchFilter($this->AppealID->Lookup->getTable()->Fields["courtID"]->searchExpression(), "=", $curVal, $this->AppealID->Lookup->getTable()->Fields["courtID"]->searchDataType(), "");
                    $sqlWrk = $this->AppealID->Lookup->getSql(false, $filterWrk, '', $this, true, true);
                    $conn = Conn();
                    $config = $conn->getConfiguration();
                    $config->setResultCache($this->Cache);
                    $rswrk = $conn->executeCacheQuery($sqlWrk, [], [], $this->CacheProfile)->fetchAll();
                    $ari = count($rswrk);
                    if ($ari > 0) { // Lookup values found
                        $arwrk = $this->AppealID->Lookup->renderViewRow($rswrk[0]);
                        $this->AppealID->ViewValue = $this->AppealID->displayValue($arwrk);
                    } else {
                        $this->AppealID->ViewValue = $this->AppealID->CurrentValue;
                    }
                }
            } else {
                $this->AppealID->ViewValue = null;
            }

            // appealDate
            $this->appealDate->ViewValue = $this->appealDate->CurrentValue;
            $this->appealDate->ViewValue = FormatDateTime($this->appealDate->ViewValue, $this->appealDate->formatPattern());

            // mid
            $curVal = strval($this->mid->CurrentValue);
            if ($curVal != "") {
                $this->mid->ViewValue = $this->mid->lookupCacheOption($curVal);
                if ($this->mid->ViewValue === null) { // Lookup from database
                    $filterWrk = SearchFilter($this->mid->Lookup->getTable()->Fields["melequtir"]->searchExpression(), "=", $curVal, $this->mid->Lookup->getTable()->Fields["melequtir"]->searchDataType(), "");
                    $sqlWrk = $this->mid->Lookup->getSql(false, $filterWrk, '', $this, true, true);
                    $conn = Conn();
                    $config = $conn->getConfiguration();
                    $config->setResultCache($this->Cache);
                    $rswrk = $conn->executeCacheQuery($sqlWrk, [], [], $this->CacheProfile)->fetchAll();
                    $ari = count($rswrk);
                    if ($ari > 0) { // Lookup values found
                        $arwrk = $this->mid->Lookup->renderViewRow($rswrk[0]);
                        $this->mid->ViewValue = $this->mid->displayValue($arwrk);
                    } else {
                        $this->mid->ViewValue = $this->mid->CurrentValue;
                    }
                }
            } else {
                $this->mid->ViewValue = null;
            }

            // rank
            $curVal = strval($this->rank->CurrentValue);
            if ($curVal != "") {
                $this->rank->ViewValue = $this->rank->lookupCacheOption($curVal);
                if ($this->rank->ViewValue === null) { // Lookup from database
                    $filterWrk = SearchFilter($this->rank->Lookup->getTable()->Fields["ዕዝ"]->searchExpression(), "=", $curVal, $this->rank->Lookup->getTable()->Fields["ዕዝ"]->searchDataType(), "");
                    $sqlWrk = $this->rank->Lookup->getSql(false, $filterWrk, '', $this, true, true);
                    $conn = Conn();
                    $config = $conn->getConfiguration();
                    $config->setResultCache($this->Cache);
                    $rswrk = $conn->executeCacheQuery($sqlWrk, [], [], $this->CacheProfile)->fetchAll();
                    $ari = count($rswrk);
                    if ($ari > 0) { // Lookup values found
                        $arwrk = $this->rank->Lookup->renderViewRow($rswrk[0]);
                        $this->rank->ViewValue = $this->rank->displayValue($arwrk);
                    } else {
                        $this->rank->ViewValue = $this->rank->CurrentValue;
                    }
                }
            } else {
                $this->rank->ViewValue = null;
            }

            // name
            $this->name->ViewValue = $this->name->CurrentValue;

            // deptName
            $curVal = strval($this->deptName->CurrentValue);
            if ($curVal != "") {
                $this->deptName->ViewValue = $this->deptName->lookupCacheOption($curVal);
                if ($this->deptName->ViewValue === null) { // Lookup from database
                    $filterWrk = SearchFilter($this->deptName->Lookup->getTable()->Fields["ዕዝ"]->searchExpression(), "=", $curVal, $this->deptName->Lookup->getTable()->Fields["ዕዝ"]->searchDataType(), "");
                    $sqlWrk = $this->deptName->Lookup->getSql(false, $filterWrk, '', $this, true, true);
                    $conn = Conn();
                    $config = $conn->getConfiguration();
                    $config->setResultCache($this->Cache);
                    $rswrk = $conn->executeCacheQuery($sqlWrk, [], [], $this->CacheProfile)->fetchAll();
                    $ari = count($rswrk);
                    if ($ari > 0) { // Lookup values found
                        $arwrk = $this->deptName->Lookup->renderViewRow($rswrk[0]);
                        $this->deptName->ViewValue = $this->deptName->displayValue($arwrk);
                    } else {
                        $this->deptName->ViewValue = $this->deptName->CurrentValue;
                    }
                }
            } else {
                $this->deptName->ViewValue = null;
            }

            // halafinet
            $this->halafinet->ViewValue = $this->halafinet->CurrentValue;

            // crimstate
            $this->crimstate->ViewValue = $this->crimstate->CurrentValue;

            // Description
            $this->Description->ViewValue = $this->Description->CurrentValue;

            // midib
            $curVal = strval($this->midib->CurrentValue);
            if ($curVal != "") {
                $this->midib->ViewValue = $this->midib->lookupCacheOption($curVal);
                if ($this->midib->ViewValue === null) { // Lookup from database
                    $filterWrk = SearchFilter($this->midib->Lookup->getTable()->Fields["ዕዝ"]->searchExpression(), "=", $curVal, $this->midib->Lookup->getTable()->Fields["ዕዝ"]->searchDataType(), "");
                    $sqlWrk = $this->midib->Lookup->getSql(false, $filterWrk, '', $this, true, true);
                    $conn = Conn();
                    $config = $conn->getConfiguration();
                    $config->setResultCache($this->Cache);
                    $rswrk = $conn->executeCacheQuery($sqlWrk, [], [], $this->CacheProfile)->fetchAll();
                    $ari = count($rswrk);
                    if ($ari > 0) { // Lookup values found
                        $arwrk = $this->midib->Lookup->renderViewRow($rswrk[0]);
                        $this->midib->ViewValue = $this->midib->displayValue($arwrk);
                    } else {
                        $this->midib->ViewValue = $this->midib->CurrentValue;
                    }
                }
            } else {
                $this->midib->ViewValue = null;
            }

            // appealask
            if (strval($this->appealask->CurrentValue) != "") {
                $this->appealask->ViewValue = $this->appealask->optionCaption($this->appealask->CurrentValue);
            } else {
                $this->appealask->ViewValue = null;
            }

            // AppealDescription
            if (strval($this->AppealDescription->CurrentValue) != "") {
                $this->AppealDescription->ViewValue = $this->AppealDescription->optionCaption($this->AppealDescription->CurrentValue);
            } else {
                $this->AppealDescription->ViewValue = null;
            }

            // appealDecision
            if (strval($this->appealDecision->CurrentValue) != "") {
                $this->appealDecision->ViewValue = $this->appealDecision->optionCaption($this->appealDecision->CurrentValue);
            } else {
                $this->appealDecision->ViewValue = null;
            }

            // created_at
            $this->created_at->ViewValue = $this->created_at->CurrentValue;
            $this->created_at->ViewValue = FormatDateTime($this->created_at->ViewValue, $this->created_at->formatPattern());

            // crimeDate
            $this->crimeDate->ViewValue = $this->crimeDate->CurrentValue;
            $this->crimeDate->ViewValue = FormatDateTime($this->crimeDate->ViewValue, $this->crimeDate->formatPattern());

            // updated_at
            $this->updated_at->ViewValue = $this->updated_at->CurrentValue;
            $this->updated_at->ViewValue = FormatDateTime($this->updated_at->ViewValue, $this->updated_at->formatPattern());

            // updated_by
            $this->updated_by->ViewValue = $this->updated_by->CurrentValue;
            $this->updated_by->ViewValue = FormatNumber($this->updated_by->ViewValue, $this->updated_by->formatPattern());

            // AppealID
            $this->AppealID->HrefValue = "";

            // appealDate
            $this->appealDate->HrefValue = "";

            // mid
            $this->mid->HrefValue = "";

            // rank
            $this->rank->HrefValue = "";

            // name
            $this->name->HrefValue = "";

            // deptName
            $this->deptName->HrefValue = "";

            // halafinet
            $this->halafinet->HrefValue = "";

            // crimstate
            $this->crimstate->HrefValue = "";

            // Description
            $this->Description->HrefValue = "";

            // midib
            $this->midib->HrefValue = "";

            // appealask
            $this->appealask->HrefValue = "";

            // AppealDescription
            $this->AppealDescription->HrefValue = "";

            // appealDecision
            $this->appealDecision->HrefValue = "";

            // created_at
            $this->created_at->HrefValue = "";

            // crimeDate
            $this->crimeDate->HrefValue = "";

            // updated_at
            $this->updated_at->HrefValue = "";

            // updated_by
            $this->updated_by->HrefValue = "";
        } elseif ($this->RowType == RowType::EDIT) {
            // AppealID
            $this->AppealID->setupEditAttributes();
            $curVal = trim(strval($this->AppealID->CurrentValue));
            if ($curVal != "") {
                $this->AppealID->ViewValue = $this->AppealID->lookupCacheOption($curVal);
            } else {
                $this->AppealID->ViewValue = $this->AppealID->Lookup !== null && is_array($this->AppealID->lookupOptions()) && count($this->AppealID->lookupOptions()) > 0 ? $curVal : null;
            }
            if ($this->AppealID->ViewValue !== null) { // Load from cache
                $this->AppealID->EditValue = array_values($this->AppealID->lookupOptions());
            } else { // Lookup from database
                if ($curVal == "") {
                    $filterWrk = "0=1";
                } else {
                    $filterWrk = SearchFilter($this->AppealID->Lookup->getTable()->Fields["courtID"]->searchExpression(), "=", $this->AppealID->CurrentValue, $this->AppealID->Lookup->getTable()->Fields["courtID"]->searchDataType(), "");
                }
                $sqlWrk = $this->AppealID->Lookup->getSql(true, $filterWrk, '', $this, false, true);
                $conn = Conn();
                $config = $conn->getConfiguration();
                $config->setResultCache($this->Cache);
                $rswrk = $conn->executeCacheQuery($sqlWrk, [], [], $this->CacheProfile)->fetchAll();
                $ari = count($rswrk);
                $arwrk = $rswrk;
                $this->AppealID->EditValue = $arwrk;
            }
            $this->AppealID->PlaceHolder = RemoveHtml($this->AppealID->caption());

            // appealDate
            $this->appealDate->setupEditAttributes();
            $this->appealDate->EditValue = HtmlEncode(FormatDateTime($this->appealDate->CurrentValue, $this->appealDate->formatPattern()));
            $this->appealDate->PlaceHolder = RemoveHtml($this->appealDate->caption());

            // mid
            $this->mid->setupEditAttributes();
            $curVal = trim(strval($this->mid->CurrentValue));
            if ($curVal != "") {
                $this->mid->ViewValue = $this->mid->lookupCacheOption($curVal);
            } else {
                $this->mid->ViewValue = $this->mid->Lookup !== null && is_array($this->mid->lookupOptions()) && count($this->mid->lookupOptions()) > 0 ? $curVal : null;
            }
            if ($this->mid->ViewValue !== null) { // Load from cache
                $this->mid->EditValue = array_values($this->mid->lookupOptions());
            } else { // Lookup from database
                if ($curVal == "") {
                    $filterWrk = "0=1";
                } else {
                    $filterWrk = SearchFilter($this->mid->Lookup->getTable()->Fields["melequtir"]->searchExpression(), "=", $this->mid->CurrentValue, $this->mid->Lookup->getTable()->Fields["melequtir"]->searchDataType(), "");
                }
                $sqlWrk = $this->mid->Lookup->getSql(true, $filterWrk, '', $this, false, true);
                $conn = Conn();
                $config = $conn->getConfiguration();
                $config->setResultCache($this->Cache);
                $rswrk = $conn->executeCacheQuery($sqlWrk, [], [], $this->CacheProfile)->fetchAll();
                $ari = count($rswrk);
                $arwrk = $rswrk;
                $this->mid->EditValue = $arwrk;
            }
            $this->mid->PlaceHolder = RemoveHtml($this->mid->caption());

            // rank
            $this->rank->setupEditAttributes();
            $curVal = trim(strval($this->rank->CurrentValue));
            if ($curVal != "") {
                $this->rank->ViewValue = $this->rank->lookupCacheOption($curVal);
            } else {
                $this->rank->ViewValue = $this->rank->Lookup !== null && is_array($this->rank->lookupOptions()) && count($this->rank->lookupOptions()) > 0 ? $curVal : null;
            }
            if ($this->rank->ViewValue !== null) { // Load from cache
                $this->rank->EditValue = array_values($this->rank->lookupOptions());
            } else { // Lookup from database
                if ($curVal == "") {
                    $filterWrk = "0=1";
                } else {
                    $filterWrk = SearchFilter($this->rank->Lookup->getTable()->Fields["ዕዝ"]->searchExpression(), "=", $this->rank->CurrentValue, $this->rank->Lookup->getTable()->Fields["ዕዝ"]->searchDataType(), "");
                }
                $sqlWrk = $this->rank->Lookup->getSql(true, $filterWrk, '', $this, false, true);
                $conn = Conn();
                $config = $conn->getConfiguration();
                $config->setResultCache($this->Cache);
                $rswrk = $conn->executeCacheQuery($sqlWrk, [], [], $this->CacheProfile)->fetchAll();
                $ari = count($rswrk);
                $arwrk = $rswrk;
                $this->rank->EditValue = $arwrk;
            }
            $this->rank->PlaceHolder = RemoveHtml($this->rank->caption());

            // name
            $this->name->setupEditAttributes();
            if (!$this->name->Raw) {
                $this->name->CurrentValue = HtmlDecode($this->name->CurrentValue);
            }
            $this->name->EditValue = HtmlEncode($this->name->CurrentValue);
            $this->name->PlaceHolder = RemoveHtml($this->name->caption());

            // deptName
            $this->deptName->setupEditAttributes();
            $curVal = trim(strval($this->deptName->CurrentValue));
            if ($curVal != "") {
                $this->deptName->ViewValue = $this->deptName->lookupCacheOption($curVal);
            } else {
                $this->deptName->ViewValue = $this->deptName->Lookup !== null && is_array($this->deptName->lookupOptions()) && count($this->deptName->lookupOptions()) > 0 ? $curVal : null;
            }
            if ($this->deptName->ViewValue !== null) { // Load from cache
                $this->deptName->EditValue = array_values($this->deptName->lookupOptions());
            } else { // Lookup from database
                if ($curVal == "") {
                    $filterWrk = "0=1";
                } else {
                    $filterWrk = SearchFilter($this->deptName->Lookup->getTable()->Fields["ዕዝ"]->searchExpression(), "=", $this->deptName->CurrentValue, $this->deptName->Lookup->getTable()->Fields["ዕዝ"]->searchDataType(), "");
                }
                $sqlWrk = $this->deptName->Lookup->getSql(true, $filterWrk, '', $this, false, true);
                $conn = Conn();
                $config = $conn->getConfiguration();
                $config->setResultCache($this->Cache);
                $rswrk = $conn->executeCacheQuery($sqlWrk, [], [], $this->CacheProfile)->fetchAll();
                $ari = count($rswrk);
                $arwrk = $rswrk;
                $this->deptName->EditValue = $arwrk;
            }
            $this->deptName->PlaceHolder = RemoveHtml($this->deptName->caption());

            // halafinet
            $this->halafinet->setupEditAttributes();
            if (!$this->halafinet->Raw) {
                $this->halafinet->CurrentValue = HtmlDecode($this->halafinet->CurrentValue);
            }
            $this->halafinet->EditValue = HtmlEncode($this->halafinet->CurrentValue);
            $this->halafinet->PlaceHolder = RemoveHtml($this->halafinet->caption());

            // crimstate
            $this->crimstate->setupEditAttributes();
            if (!$this->crimstate->Raw) {
                $this->crimstate->CurrentValue = HtmlDecode($this->crimstate->CurrentValue);
            }
            $this->crimstate->EditValue = HtmlEncode($this->crimstate->CurrentValue);
            $this->crimstate->PlaceHolder = RemoveHtml($this->crimstate->caption());

            // Description
            $this->Description->setupEditAttributes();
            if (!$this->Description->Raw) {
                $this->Description->CurrentValue = HtmlDecode($this->Description->CurrentValue);
            }
            $this->Description->EditValue = HtmlEncode($this->Description->CurrentValue);
            $this->Description->PlaceHolder = RemoveHtml($this->Description->caption());

            // midib
            $this->midib->setupEditAttributes();
            $curVal = trim(strval($this->midib->CurrentValue));
            if ($curVal != "") {
                $this->midib->ViewValue = $this->midib->lookupCacheOption($curVal);
            } else {
                $this->midib->ViewValue = $this->midib->Lookup !== null && is_array($this->midib->lookupOptions()) && count($this->midib->lookupOptions()) > 0 ? $curVal : null;
            }
            if ($this->midib->ViewValue !== null) { // Load from cache
                $this->midib->EditValue = array_values($this->midib->lookupOptions());
            } else { // Lookup from database
                if ($curVal == "") {
                    $filterWrk = "0=1";
                } else {
                    $filterWrk = SearchFilter($this->midib->Lookup->getTable()->Fields["ዕዝ"]->searchExpression(), "=", $this->midib->CurrentValue, $this->midib->Lookup->getTable()->Fields["ዕዝ"]->searchDataType(), "");
                }
                $sqlWrk = $this->midib->Lookup->getSql(true, $filterWrk, '', $this, false, true);
                $conn = Conn();
                $config = $conn->getConfiguration();
                $config->setResultCache($this->Cache);
                $rswrk = $conn->executeCacheQuery($sqlWrk, [], [], $this->CacheProfile)->fetchAll();
                $ari = count($rswrk);
                $arwrk = $rswrk;
                $this->midib->EditValue = $arwrk;
            }
            $this->midib->PlaceHolder = RemoveHtml($this->midib->caption());

            // appealask
            $this->appealask->setupEditAttributes();
            $this->appealask->EditValue = $this->appealask->options(true);
            $this->appealask->PlaceHolder = RemoveHtml($this->appealask->caption());

            // AppealDescription
            $this->AppealDescription->setupEditAttributes();
            $this->AppealDescription->EditValue = $this->AppealDescription->options(true);
            $this->AppealDescription->PlaceHolder = RemoveHtml($this->AppealDescription->caption());

            // appealDecision
            $this->appealDecision->setupEditAttributes();
            $this->appealDecision->EditValue = $this->appealDecision->options(true);
            $this->appealDecision->PlaceHolder = RemoveHtml($this->appealDecision->caption());

            // created_at
            $this->created_at->setupEditAttributes();
            $this->created_at->EditValue = HtmlEncode(FormatDateTime($this->created_at->CurrentValue, $this->created_at->formatPattern()));
            $this->created_at->PlaceHolder = RemoveHtml($this->created_at->caption());

            // crimeDate
            $this->crimeDate->setupEditAttributes();
            $this->crimeDate->EditValue = HtmlEncode(FormatDateTime($this->crimeDate->CurrentValue, $this->crimeDate->formatPattern()));
            $this->crimeDate->PlaceHolder = RemoveHtml($this->crimeDate->caption());

            // updated_at

            // updated_by

            // Edit refer script

            // AppealID
            $this->AppealID->HrefValue = "";

            // appealDate
            $this->appealDate->HrefValue = "";

            // mid
            $this->mid->HrefValue = "";

            // rank
            $this->rank->HrefValue = "";

            // name
            $this->name->HrefValue = "";

            // deptName
            $this->deptName->HrefValue = "";

            // halafinet
            $this->halafinet->HrefValue = "";

            // crimstate
            $this->crimstate->HrefValue = "";

            // Description
            $this->Description->HrefValue = "";

            // midib
            $this->midib->HrefValue = "";

            // appealask
            $this->appealask->HrefValue = "";

            // AppealDescription
            $this->AppealDescription->HrefValue = "";

            // appealDecision
            $this->appealDecision->HrefValue = "";

            // created_at
            $this->created_at->HrefValue = "";

            // crimeDate
            $this->crimeDate->HrefValue = "";

            // updated_at
            $this->updated_at->HrefValue = "";

            // updated_by
            $this->updated_by->HrefValue = "";
        }
        if ($this->RowType == RowType::ADD || $this->RowType == RowType::EDIT || $this->RowType == RowType::SEARCH) { // Add/Edit/Search row
            $this->setupFieldTitles();
        }

        // Call Row Rendered event
        if ($this->RowType != RowType::AGGREGATEINIT) {
            $this->rowRendered();
        }
    }

    // Validate form
    protected function validateForm()
    {
        global $Language, $Security;

        // Check if validation required
        if (!Config("SERVER_VALIDATE")) {
            return true;
        }
        $validateForm = true;
            if ($this->AppealID->Visible && $this->AppealID->Required) {
                if (!$this->AppealID->IsDetailKey && EmptyValue($this->AppealID->FormValue)) {
                    $this->AppealID->addErrorMessage(str_replace("%s", $this->AppealID->caption(), $this->AppealID->RequiredErrorMessage));
                }
            }
            if ($this->appealDate->Visible && $this->appealDate->Required) {
                if (!$this->appealDate->IsDetailKey && EmptyValue($this->appealDate->FormValue)) {
                    $this->appealDate->addErrorMessage(str_replace("%s", $this->appealDate->caption(), $this->appealDate->RequiredErrorMessage));
                }
            }
            if (!CheckDate($this->appealDate->FormValue, $this->appealDate->formatPattern())) {
                $this->appealDate->addErrorMessage($this->appealDate->getErrorMessage(false));
            }
            if ($this->mid->Visible && $this->mid->Required) {
                if (!$this->mid->IsDetailKey && EmptyValue($this->mid->FormValue)) {
                    $this->mid->addErrorMessage(str_replace("%s", $this->mid->caption(), $this->mid->RequiredErrorMessage));
                }
            }
            if ($this->rank->Visible && $this->rank->Required) {
                if (!$this->rank->IsDetailKey && EmptyValue($this->rank->FormValue)) {
                    $this->rank->addErrorMessage(str_replace("%s", $this->rank->caption(), $this->rank->RequiredErrorMessage));
                }
            }
            if ($this->name->Visible && $this->name->Required) {
                if (!$this->name->IsDetailKey && EmptyValue($this->name->FormValue)) {
                    $this->name->addErrorMessage(str_replace("%s", $this->name->caption(), $this->name->RequiredErrorMessage));
                }
            }
            if ($this->deptName->Visible && $this->deptName->Required) {
                if (!$this->deptName->IsDetailKey && EmptyValue($this->deptName->FormValue)) {
                    $this->deptName->addErrorMessage(str_replace("%s", $this->deptName->caption(), $this->deptName->RequiredErrorMessage));
                }
            }
            if ($this->halafinet->Visible && $this->halafinet->Required) {
                if (!$this->halafinet->IsDetailKey && EmptyValue($this->halafinet->FormValue)) {
                    $this->halafinet->addErrorMessage(str_replace("%s", $this->halafinet->caption(), $this->halafinet->RequiredErrorMessage));
                }
            }
            if ($this->crimstate->Visible && $this->crimstate->Required) {
                if (!$this->crimstate->IsDetailKey && EmptyValue($this->crimstate->FormValue)) {
                    $this->crimstate->addErrorMessage(str_replace("%s", $this->crimstate->caption(), $this->crimstate->RequiredErrorMessage));
                }
            }
            if ($this->Description->Visible && $this->Description->Required) {
                if (!$this->Description->IsDetailKey && EmptyValue($this->Description->FormValue)) {
                    $this->Description->addErrorMessage(str_replace("%s", $this->Description->caption(), $this->Description->RequiredErrorMessage));
                }
            }
            if ($this->midib->Visible && $this->midib->Required) {
                if (!$this->midib->IsDetailKey && EmptyValue($this->midib->FormValue)) {
                    $this->midib->addErrorMessage(str_replace("%s", $this->midib->caption(), $this->midib->RequiredErrorMessage));
                }
            }
            if ($this->appealask->Visible && $this->appealask->Required) {
                if (!$this->appealask->IsDetailKey && EmptyValue($this->appealask->FormValue)) {
                    $this->appealask->addErrorMessage(str_replace("%s", $this->appealask->caption(), $this->appealask->RequiredErrorMessage));
                }
            }
            if ($this->AppealDescription->Visible && $this->AppealDescription->Required) {
                if (!$this->AppealDescription->IsDetailKey && EmptyValue($this->AppealDescription->FormValue)) {
                    $this->AppealDescription->addErrorMessage(str_replace("%s", $this->AppealDescription->caption(), $this->AppealDescription->RequiredErrorMessage));
                }
            }
            if ($this->appealDecision->Visible && $this->appealDecision->Required) {
                if (!$this->appealDecision->IsDetailKey && EmptyValue($this->appealDecision->FormValue)) {
                    $this->appealDecision->addErrorMessage(str_replace("%s", $this->appealDecision->caption(), $this->appealDecision->RequiredErrorMessage));
                }
            }
            if ($this->created_at->Visible && $this->created_at->Required) {
                if (!$this->created_at->IsDetailKey && EmptyValue($this->created_at->FormValue)) {
                    $this->created_at->addErrorMessage(str_replace("%s", $this->created_at->caption(), $this->created_at->RequiredErrorMessage));
                }
            }
            if (!CheckDate($this->created_at->FormValue, $this->created_at->formatPattern())) {
                $this->created_at->addErrorMessage($this->created_at->getErrorMessage(false));
            }
            if ($this->crimeDate->Visible && $this->crimeDate->Required) {
                if (!$this->crimeDate->IsDetailKey && EmptyValue($this->crimeDate->FormValue)) {
                    $this->crimeDate->addErrorMessage(str_replace("%s", $this->crimeDate->caption(), $this->crimeDate->RequiredErrorMessage));
                }
            }
            if (!CheckDate($this->crimeDate->FormValue, $this->crimeDate->formatPattern())) {
                $this->crimeDate->addErrorMessage($this->crimeDate->getErrorMessage(false));
            }
            if ($this->updated_at->Visible && $this->updated_at->Required) {
                if (!$this->updated_at->IsDetailKey && EmptyValue($this->updated_at->FormValue)) {
                    $this->updated_at->addErrorMessage(str_replace("%s", $this->updated_at->caption(), $this->updated_at->RequiredErrorMessage));
                }
            }
            if ($this->updated_by->Visible && $this->updated_by->Required) {
                if (!$this->updated_by->IsDetailKey && EmptyValue($this->updated_by->FormValue)) {
                    $this->updated_by->addErrorMessage(str_replace("%s", $this->updated_by->caption(), $this->updated_by->RequiredErrorMessage));
                }
            }

        // Return validate result
        $validateForm = $validateForm && !$this->hasInvalidFields();

        // Call Form_CustomValidate event
        $formCustomError = "";
        $validateForm = $validateForm && $this->formCustomValidate($formCustomError);
        if ($formCustomError != "") {
            $this->setFailureMessage($formCustomError);
        }
        return $validateForm;
    }

    // Update record based on key values
    protected function editRow()
    {
        global $Security, $Language;
        $oldKeyFilter = $this->getRecordFilter();
        $filter = $this->applyUserIDFilters($oldKeyFilter);
        $conn = $this->getConnection();

        // Load old row
        $this->CurrentFilter = $filter;
        $sql = $this->getCurrentSql();
        $rsold = $conn->fetchAssociative($sql);
        if (!$rsold) {
            $this->setFailureMessage($Language->phrase("NoRecord")); // Set no record message
            return false; // Update Failed
        } else {
            // Load old values
            $this->loadDbValues($rsold);
        }

        // Get new row
        $rsnew = $this->getEditRow($rsold);

        // Update current values
        $this->setCurrentValues($rsnew);

        // Call Row Updating event
        $updateRow = $this->rowUpdating($rsold, $rsnew);
        if ($updateRow) {
            if (count($rsnew) > 0) {
                $this->CurrentFilter = $filter; // Set up current filter
                $editRow = $this->update($rsnew, "", $rsold);
                if (!$editRow && !EmptyValue($this->DbErrorMessage)) { // Show database error
                    $this->setFailureMessage($this->DbErrorMessage);
                }
            } else {
                $editRow = true; // No field to update
            }
            if ($editRow) {
            }
        } else {
            if ($this->getSuccessMessage() != "" || $this->getFailureMessage() != "") {
                // Use the message, do nothing
            } elseif ($this->CancelMessage != "") {
                $this->setFailureMessage($this->CancelMessage);
                $this->CancelMessage = "";
            } else {
                $this->setFailureMessage($Language->phrase("UpdateCancelled"));
            }
            $editRow = false;
        }

        // Call Row_Updated event
        if ($editRow) {
            $this->rowUpdated($rsold, $rsnew);
        }

        // Write JSON response
        if (IsJsonResponse() && $editRow) {
            $row = $this->getRecordsFromRecordset([$rsnew], true);
            $table = $this->TableVar;
            WriteJson(["success" => true, "action" => Config("API_EDIT_ACTION"), $table => $row]);
        }
        return $editRow;
    }

    /**
     * Get edit row
     *
     * @return array
     */
    protected function getEditRow($rsold)
    {
        global $Security;
        $rsnew = [];

        // AppealID
        $this->AppealID->setDbValueDef($rsnew, $this->AppealID->CurrentValue, $this->AppealID->ReadOnly);

        // appealDate
        $this->appealDate->setDbValueDef($rsnew, UnFormatDateTime($this->appealDate->CurrentValue, $this->appealDate->formatPattern()), $this->appealDate->ReadOnly);

        // mid
        $this->mid->setDbValueDef($rsnew, $this->mid->CurrentValue, $this->mid->ReadOnly);

        // rank
        $this->rank->setDbValueDef($rsnew, $this->rank->CurrentValue, $this->rank->ReadOnly);

        // name
        $this->name->setDbValueDef($rsnew, $this->name->CurrentValue, $this->name->ReadOnly);

        // deptName
        $this->deptName->setDbValueDef($rsnew, $this->deptName->CurrentValue, $this->deptName->ReadOnly);

        // halafinet
        $this->halafinet->setDbValueDef($rsnew, $this->halafinet->CurrentValue, $this->halafinet->ReadOnly);

        // crimstate
        $this->crimstate->setDbValueDef($rsnew, $this->crimstate->CurrentValue, $this->crimstate->ReadOnly);

        // Description
        $this->Description->setDbValueDef($rsnew, $this->Description->CurrentValue, $this->Description->ReadOnly);

        // midib
        $this->midib->setDbValueDef($rsnew, $this->midib->CurrentValue, $this->midib->ReadOnly);

        // appealask
        $this->appealask->setDbValueDef($rsnew, $this->appealask->CurrentValue, $this->appealask->ReadOnly);

        // AppealDescription
        $this->AppealDescription->setDbValueDef($rsnew, $this->AppealDescription->CurrentValue, $this->AppealDescription->ReadOnly);

        // appealDecision
        $this->appealDecision->setDbValueDef($rsnew, $this->appealDecision->CurrentValue, $this->appealDecision->ReadOnly);

        // created_at
        $this->created_at->setDbValueDef($rsnew, UnFormatDateTime($this->created_at->CurrentValue, $this->created_at->formatPattern()), $this->created_at->ReadOnly);

        // crimeDate
        $this->crimeDate->setDbValueDef($rsnew, UnFormatDateTime($this->crimeDate->CurrentValue, $this->crimeDate->formatPattern()), $this->crimeDate->ReadOnly);

        // updated_at
        $this->updated_at->CurrentValue = $this->updated_at->getAutoUpdateValue(); // PHP
        $this->updated_at->setDbValueDef($rsnew, UnFormatDateTime($this->updated_at->CurrentValue, $this->updated_at->formatPattern()));

        // updated_by
        $this->updated_by->CurrentValue = $this->updated_by->getAutoUpdateValue(); // PHP
        $this->updated_by->setDbValueDef($rsnew, $this->updated_by->CurrentValue);
        return $rsnew;
    }

    /**
     * Restore edit form from row
     * @param array $row Row
     */
    protected function restoreEditFormFromRow($row)
    {
        if (isset($row['AppealID'])) { // AppealID
            $this->AppealID->CurrentValue = $row['AppealID'];
        }
        if (isset($row['appealDate'])) { // appealDate
            $this->appealDate->CurrentValue = $row['appealDate'];
        }
        if (isset($row['mid'])) { // mid
            $this->mid->CurrentValue = $row['mid'];
        }
        if (isset($row['rank'])) { // rank
            $this->rank->CurrentValue = $row['rank'];
        }
        if (isset($row['name'])) { // name
            $this->name->CurrentValue = $row['name'];
        }
        if (isset($row['deptName'])) { // deptName
            $this->deptName->CurrentValue = $row['deptName'];
        }
        if (isset($row['halafinet'])) { // halafinet
            $this->halafinet->CurrentValue = $row['halafinet'];
        }
        if (isset($row['crimstate'])) { // crimstate
            $this->crimstate->CurrentValue = $row['crimstate'];
        }
        if (isset($row['Description'])) { // Description
            $this->Description->CurrentValue = $row['Description'];
        }
        if (isset($row['midib'])) { // midib
            $this->midib->CurrentValue = $row['midib'];
        }
        if (isset($row['appealask'])) { // appealask
            $this->appealask->CurrentValue = $row['appealask'];
        }
        if (isset($row['AppealDescription'])) { // AppealDescription
            $this->AppealDescription->CurrentValue = $row['AppealDescription'];
        }
        if (isset($row['appealDecision'])) { // appealDecision
            $this->appealDecision->CurrentValue = $row['appealDecision'];
        }
        if (isset($row['created_at'])) { // created_at
            $this->created_at->CurrentValue = $row['created_at'];
        }
        if (isset($row['crimeDate'])) { // crimeDate
            $this->crimeDate->CurrentValue = $row['crimeDate'];
        }
        if (isset($row['updated_at'])) { // updated_at
            $this->updated_at->CurrentValue = $row['updated_at'];
        }
        if (isset($row['updated_by'])) { // updated_by
            $this->updated_by->CurrentValue = $row['updated_by'];
        }
    }

    // Set up Breadcrumb
    protected function setupBreadcrumb()
    {
        global $Breadcrumb, $Language;
        $Breadcrumb = new Breadcrumb("index");
        $url = CurrentUrl();
        $Breadcrumb->add("list", $this->TableVar, $this->addMasterUrl("AppealList"), "", $this->TableVar, true);
        $pageId = "edit";
        $Breadcrumb->add("edit", $pageId, $url);
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
                case "x_AppealID":
                    break;
                case "x_mid":
                    break;
                case "x_rank":
                    break;
                case "x_deptName":
                    break;
                case "x_midib":
                    break;
                case "x_appealask":
                    break;
                case "x_AppealDescription":
                    break;
                case "x_appealDecision":
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

    // Set up starting record parameters
    public function setupStartRecord()
    {
        if ($this->DisplayRecords == 0) {
            return;
        }
        $pageNo = Get(Config("TABLE_PAGE_NUMBER"));
        $startRec = Get(Config("TABLE_START_REC"));
        $infiniteScroll = false;
        $recordNo = $pageNo ?? $startRec; // Record number = page number or start record
        if ($recordNo !== null && is_numeric($recordNo)) {
            $this->StartRecord = $recordNo;
        } else {
            $this->StartRecord = $this->getStartRecordNumber();
        }

        // Check if correct start record counter
        if (!is_numeric($this->StartRecord) || intval($this->StartRecord) <= 0) { // Avoid invalid start record counter
            $this->StartRecord = 1; // Reset start record counter
        } elseif ($this->StartRecord > $this->TotalRecords) { // Avoid starting record > total records
            $this->StartRecord = (int)(($this->TotalRecords - 1) / $this->DisplayRecords) * $this->DisplayRecords + 1; // Point to last page first record
        } elseif (($this->StartRecord - 1) % $this->DisplayRecords != 0) {
            $this->StartRecord = (int)(($this->StartRecord - 1) / $this->DisplayRecords) * $this->DisplayRecords + 1; // Point to page boundary
        }
        if (!$infiniteScroll) {
            $this->setStartRecordNumber($this->StartRecord);
        }
    }

    // Get page count
    public function pageCount() {
        return ceil($this->TotalRecords / $this->DisplayRecords);
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

    // Form Custom Validate event
    public function formCustomValidate(&$customError)
    {
        // Return error message in $customError
        return true;
    }
}
