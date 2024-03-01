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
class CaseHearsAdd extends CaseHears
{
    use MessagesTrait;

    // Page ID
    public $PageID = "add";

    // Project ID
    public $ProjectID = PROJECT_ID;

    // Page object name
    public $PageObjName = "CaseHearsAdd";

    // View file path
    public $View = null;

    // Title
    public $Title = null; // Title for <title> tag

    // Rendering View
    public $RenderingView = false;

    // CSS class/style
    public $CurrentPageName = "CaseHearsAdd";

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
        $this->id->Visible = false;
        $this->melequtir->setVisibility();
        $this->RANKe->setVisibility();
        $this->name->setVisibility();
        $this->ez->setVisibility();
        $this->fileNumber->setVisibility();
        $this->firdbet->setVisibility();
        $this->chilotname->setVisibility();
        $this->kirihidet->setVisibility();
        $this->yekisaynet->setVisibility();
        $this->keteroreason->setVisibility();
        $this->sex->setVisibility();
        $this->tekesashbizat->setVisibility();
        $this->keterodate->setVisibility();
        $this->keterodescription->setVisibility();
        $this->created_at->setVisibility();
        $this->updated_at->setVisibility();
        $this->updated_by->setVisibility();
    }

    // Constructor
    public function __construct()
    {
        parent::__construct();
        global $Language, $DashboardReport, $DebugTimer, $UserTable;
        $this->TableVar = 'case_hears';
        $this->TableName = 'case_hears';

        // Table CSS class
        $this->TableClass = "table table-striped table-bordered table-hover table-sm ew-desktop-table ew-add-table";

        // Initialize
        $GLOBALS["Page"] = &$this;

        // Language object
        $Language = Container("app.language");

        // Table object (case_hears)
        if (!isset($GLOBALS["case_hears"]) || $GLOBALS["case_hears"]::class == PROJECT_NAMESPACE . "case_hears") {
            $GLOBALS["case_hears"] = &$this;
        }

        // Table name (for backward compatibility only)
        if (!defined(PROJECT_NAMESPACE . "TABLE_NAME")) {
            define(PROJECT_NAMESPACE . "TABLE_NAME", 'case_hears');
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
                        $result["view"] = SameString($pageName, "CaseHearsView"); // If View page, no primary button
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
    public $FormClassName = "ew-form ew-add-form";
    public $IsModal = false;
    public $IsMobileOrModal = false;
    public $DbMasterFilter = "";
    public $DbDetailFilter = "";
    public $StartRecord;
    public $Priv = 0;
    public $CopyRecord;

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
        $this->setupLookupOptions($this->RANKe);
        $this->setupLookupOptions($this->ez);
        $this->setupLookupOptions($this->firdbet);
        $this->setupLookupOptions($this->chilotname);
        $this->setupLookupOptions($this->kirihidet);
        $this->setupLookupOptions($this->yekisaynet);
        $this->setupLookupOptions($this->keteroreason);
        $this->setupLookupOptions($this->sex);

        // Load default values for add
        $this->loadDefaultValues();

        // Check modal
        if ($this->IsModal) {
            $SkipHeaderFooter = true;
        }
        $this->IsMobileOrModal = IsMobile() || $this->IsModal;
        $postBack = false;

        // Set up current action
        if (IsApi()) {
            $this->CurrentAction = "insert"; // Add record directly
            $postBack = true;
        } elseif (Post("action", "") !== "") {
            $this->CurrentAction = Post("action"); // Get form action
            $this->setKey(Post($this->OldKeyName));
            $postBack = true;
        } else {
            // Load key values from QueryString
            if (($keyValue = Get("id") ?? Route("id")) !== null) {
                $this->id->setQueryStringValue($keyValue);
            }
            $this->OldKey = $this->getKey(true); // Get from CurrentValue
            $this->CopyRecord = !EmptyValue($this->OldKey);
            if ($this->CopyRecord) {
                $this->CurrentAction = "copy"; // Copy record
                $this->setKey($this->OldKey); // Set up record key
            } else {
                $this->CurrentAction = "show"; // Display blank record
            }
        }

        // Load old record or default values
        $rsold = $this->loadOldRecord();

        // Load form values
        if ($postBack) {
            $this->loadFormValues(); // Load form values
        }

        // Validate form if post back
        if ($postBack) {
            if (!$this->validateForm()) {
                $this->EventCancelled = true; // Event cancelled
                $this->restoreFormValues(); // Restore form values
                if (IsApi()) {
                    $this->terminate();
                    return;
                } else {
                    $this->CurrentAction = "show"; // Form error, reset action
                }
            }
        }

        // Perform current action
        switch ($this->CurrentAction) {
            case "copy": // Copy an existing record
                if (!$rsold) { // Record not loaded
                    if ($this->getFailureMessage() == "") {
                        $this->setFailureMessage($Language->phrase("NoRecord")); // No record found
                    }
                    $this->terminate("CaseHearsList"); // No matching record, return to list
                    return;
                }
                break;
            case "insert": // Add new record
                $this->SendEmail = true; // Send email on add success
                if ($this->addRow($rsold)) { // Add successful
                    if ($this->getSuccessMessage() == "" && Post("addopt") != "1") { // Skip success message for addopt (done in JavaScript)
                        $this->setSuccessMessage($Language->phrase("AddSuccess")); // Set up success message
                    }
                    $returnUrl = $this->getReturnUrl();
                    if (GetPageName($returnUrl) == "CaseHearsList") {
                        $returnUrl = $this->addMasterUrl($returnUrl); // List page, return to List page with correct master key if necessary
                    } elseif (GetPageName($returnUrl) == "CaseHearsView") {
                        $returnUrl = $this->getViewUrl(); // View page, return to View page with keyurl directly
                    }

                    // Handle UseAjaxActions
                    if ($this->IsModal && $this->UseAjaxActions) {
                        $this->IsModal = false;
                        if (GetPageName($returnUrl) != "CaseHearsList") {
                            Container("app.flash")->addMessage("Return-Url", $returnUrl); // Save return URL
                            $returnUrl = "CaseHearsList"; // Return list page content
                        }
                    }
                    if (IsJsonResponse()) { // Return to caller
                        $this->terminate(true);
                        return;
                    } else {
                        $this->terminate($returnUrl);
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
                } else {
                    $this->EventCancelled = true; // Event cancelled
                    $this->restoreFormValues(); // Add failed, restore form values
                }
        }

        // Set up Breadcrumb
        $this->setupBreadcrumb();

        // Render row based on row type
        $this->RowType = RowType::ADD; // Render add type

        // Render row
        $this->resetAttributes();
        $this->renderRow();

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

    // Load default values
    protected function loadDefaultValues()
    {
    }

    // Load form values
    protected function loadFormValues()
    {
        // Load from form
        global $CurrentForm;
        $validate = !Config("SERVER_VALIDATE");

        // Check field name 'melequtir' first before field var 'x_melequtir'
        $val = $CurrentForm->hasValue("melequtir") ? $CurrentForm->getValue("melequtir") : $CurrentForm->getValue("x_melequtir");
        if (!$this->melequtir->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->melequtir->Visible = false; // Disable update for API request
            } else {
                $this->melequtir->setFormValue($val);
            }
        }

        // Check field name 'RANKe' first before field var 'x_RANKe'
        $val = $CurrentForm->hasValue("RANKe") ? $CurrentForm->getValue("RANKe") : $CurrentForm->getValue("x_RANKe");
        if (!$this->RANKe->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->RANKe->Visible = false; // Disable update for API request
            } else {
                $this->RANKe->setFormValue($val);
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

        // Check field name 'ez' first before field var 'x_ez'
        $val = $CurrentForm->hasValue("ez") ? $CurrentForm->getValue("ez") : $CurrentForm->getValue("x_ez");
        if (!$this->ez->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->ez->Visible = false; // Disable update for API request
            } else {
                $this->ez->setFormValue($val);
            }
        }

        // Check field name 'fileNumber' first before field var 'x_fileNumber'
        $val = $CurrentForm->hasValue("fileNumber") ? $CurrentForm->getValue("fileNumber") : $CurrentForm->getValue("x_fileNumber");
        if (!$this->fileNumber->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->fileNumber->Visible = false; // Disable update for API request
            } else {
                $this->fileNumber->setFormValue($val);
            }
        }

        // Check field name 'firdbet' first before field var 'x_firdbet'
        $val = $CurrentForm->hasValue("firdbet") ? $CurrentForm->getValue("firdbet") : $CurrentForm->getValue("x_firdbet");
        if (!$this->firdbet->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->firdbet->Visible = false; // Disable update for API request
            } else {
                $this->firdbet->setFormValue($val);
            }
        }

        // Check field name 'chilotname' first before field var 'x_chilotname'
        $val = $CurrentForm->hasValue("chilotname") ? $CurrentForm->getValue("chilotname") : $CurrentForm->getValue("x_chilotname");
        if (!$this->chilotname->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->chilotname->Visible = false; // Disable update for API request
            } else {
                $this->chilotname->setFormValue($val);
            }
        }

        // Check field name 'kirihidet' first before field var 'x_kirihidet'
        $val = $CurrentForm->hasValue("kirihidet") ? $CurrentForm->getValue("kirihidet") : $CurrentForm->getValue("x_kirihidet");
        if (!$this->kirihidet->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->kirihidet->Visible = false; // Disable update for API request
            } else {
                $this->kirihidet->setFormValue($val);
            }
        }

        // Check field name 'yekisaynet' first before field var 'x_yekisaynet'
        $val = $CurrentForm->hasValue("yekisaynet") ? $CurrentForm->getValue("yekisaynet") : $CurrentForm->getValue("x_yekisaynet");
        if (!$this->yekisaynet->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->yekisaynet->Visible = false; // Disable update for API request
            } else {
                $this->yekisaynet->setFormValue($val);
            }
        }

        // Check field name 'keteroreason' first before field var 'x_keteroreason'
        $val = $CurrentForm->hasValue("keteroreason") ? $CurrentForm->getValue("keteroreason") : $CurrentForm->getValue("x_keteroreason");
        if (!$this->keteroreason->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->keteroreason->Visible = false; // Disable update for API request
            } else {
                $this->keteroreason->setFormValue($val);
            }
        }

        // Check field name 'sex' first before field var 'x_sex'
        $val = $CurrentForm->hasValue("sex") ? $CurrentForm->getValue("sex") : $CurrentForm->getValue("x_sex");
        if (!$this->sex->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->sex->Visible = false; // Disable update for API request
            } else {
                $this->sex->setFormValue($val);
            }
        }

        // Check field name 'tekesashbizat' first before field var 'x_tekesashbizat'
        $val = $CurrentForm->hasValue("tekesashbizat") ? $CurrentForm->getValue("tekesashbizat") : $CurrentForm->getValue("x_tekesashbizat");
        if (!$this->tekesashbizat->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->tekesashbizat->Visible = false; // Disable update for API request
            } else {
                $this->tekesashbizat->setFormValue($val, true, $validate);
            }
        }

        // Check field name 'keterodate' first before field var 'x_keterodate'
        $val = $CurrentForm->hasValue("keterodate") ? $CurrentForm->getValue("keterodate") : $CurrentForm->getValue("x_keterodate");
        if (!$this->keterodate->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->keterodate->Visible = false; // Disable update for API request
            } else {
                $this->keterodate->setFormValue($val, true, $validate);
            }
            $this->keterodate->CurrentValue = UnFormatDateTime($this->keterodate->CurrentValue, $this->keterodate->formatPattern());
        }

        // Check field name 'keterodescription' first before field var 'x_keterodescription'
        $val = $CurrentForm->hasValue("keterodescription") ? $CurrentForm->getValue("keterodescription") : $CurrentForm->getValue("x_keterodescription");
        if (!$this->keterodescription->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->keterodescription->Visible = false; // Disable update for API request
            } else {
                $this->keterodescription->setFormValue($val);
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
    }

    // Restore form values
    public function restoreFormValues()
    {
        global $CurrentForm;
        $this->melequtir->CurrentValue = $this->melequtir->FormValue;
        $this->RANKe->CurrentValue = $this->RANKe->FormValue;
        $this->name->CurrentValue = $this->name->FormValue;
        $this->ez->CurrentValue = $this->ez->FormValue;
        $this->fileNumber->CurrentValue = $this->fileNumber->FormValue;
        $this->firdbet->CurrentValue = $this->firdbet->FormValue;
        $this->chilotname->CurrentValue = $this->chilotname->FormValue;
        $this->kirihidet->CurrentValue = $this->kirihidet->FormValue;
        $this->yekisaynet->CurrentValue = $this->yekisaynet->FormValue;
        $this->keteroreason->CurrentValue = $this->keteroreason->FormValue;
        $this->sex->CurrentValue = $this->sex->FormValue;
        $this->tekesashbizat->CurrentValue = $this->tekesashbizat->FormValue;
        $this->keterodate->CurrentValue = $this->keterodate->FormValue;
        $this->keterodate->CurrentValue = UnFormatDateTime($this->keterodate->CurrentValue, $this->keterodate->formatPattern());
        $this->keterodescription->CurrentValue = $this->keterodescription->FormValue;
        $this->created_at->CurrentValue = $this->created_at->FormValue;
        $this->created_at->CurrentValue = UnFormatDateTime($this->created_at->CurrentValue, $this->created_at->formatPattern());
        $this->updated_at->CurrentValue = $this->updated_at->FormValue;
        $this->updated_at->CurrentValue = UnFormatDateTime($this->updated_at->CurrentValue, $this->updated_at->formatPattern());
        $this->updated_by->CurrentValue = $this->updated_by->FormValue;
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
        $this->id->setDbValue($row['id']);
        $this->melequtir->setDbValue($row['melequtir']);
        $this->RANKe->setDbValue($row['RANKe']);
        $this->name->setDbValue($row['name']);
        $this->ez->setDbValue($row['ez']);
        $this->fileNumber->setDbValue($row['fileNumber']);
        $this->firdbet->setDbValue($row['firdbet']);
        $this->chilotname->setDbValue($row['chilotname']);
        $this->kirihidet->setDbValue($row['kirihidet']);
        $this->yekisaynet->setDbValue($row['yekisaynet']);
        $this->keteroreason->setDbValue($row['keteroreason']);
        $this->sex->setDbValue($row['sex']);
        $this->tekesashbizat->setDbValue($row['tekesashbizat']);
        $this->keterodate->setDbValue($row['keterodate']);
        $this->keterodescription->setDbValue($row['keterodescription']);
        $this->created_at->setDbValue($row['created_at']);
        $this->updated_at->setDbValue($row['updated_at']);
        $this->updated_by->setDbValue($row['updated_by']);
    }

    // Return a row with default values
    protected function newRow()
    {
        $row = [];
        $row['id'] = $this->id->DefaultValue;
        $row['melequtir'] = $this->melequtir->DefaultValue;
        $row['RANKe'] = $this->RANKe->DefaultValue;
        $row['name'] = $this->name->DefaultValue;
        $row['ez'] = $this->ez->DefaultValue;
        $row['fileNumber'] = $this->fileNumber->DefaultValue;
        $row['firdbet'] = $this->firdbet->DefaultValue;
        $row['chilotname'] = $this->chilotname->DefaultValue;
        $row['kirihidet'] = $this->kirihidet->DefaultValue;
        $row['yekisaynet'] = $this->yekisaynet->DefaultValue;
        $row['keteroreason'] = $this->keteroreason->DefaultValue;
        $row['sex'] = $this->sex->DefaultValue;
        $row['tekesashbizat'] = $this->tekesashbizat->DefaultValue;
        $row['keterodate'] = $this->keterodate->DefaultValue;
        $row['keterodescription'] = $this->keterodescription->DefaultValue;
        $row['created_at'] = $this->created_at->DefaultValue;
        $row['updated_at'] = $this->updated_at->DefaultValue;
        $row['updated_by'] = $this->updated_by->DefaultValue;
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

        // id
        $this->id->RowCssClass = "row";

        // melequtir
        $this->melequtir->RowCssClass = "row";

        // RANKe
        $this->RANKe->RowCssClass = "row";

        // name
        $this->name->RowCssClass = "row";

        // ez
        $this->ez->RowCssClass = "row";

        // fileNumber
        $this->fileNumber->RowCssClass = "row";

        // firdbet
        $this->firdbet->RowCssClass = "row";

        // chilotname
        $this->chilotname->RowCssClass = "row";

        // kirihidet
        $this->kirihidet->RowCssClass = "row";

        // yekisaynet
        $this->yekisaynet->RowCssClass = "row";

        // keteroreason
        $this->keteroreason->RowCssClass = "row";

        // sex
        $this->sex->RowCssClass = "row";

        // tekesashbizat
        $this->tekesashbizat->RowCssClass = "row";

        // keterodate
        $this->keterodate->RowCssClass = "row";

        // keterodescription
        $this->keterodescription->RowCssClass = "row";

        // created_at
        $this->created_at->RowCssClass = "row";

        // updated_at
        $this->updated_at->RowCssClass = "row";

        // updated_by
        $this->updated_by->RowCssClass = "row";

        // View row
        if ($this->RowType == RowType::VIEW) {
            // melequtir
            $this->melequtir->ViewValue = $this->melequtir->CurrentValue;

            // RANKe
            $curVal = strval($this->RANKe->CurrentValue);
            if ($curVal != "") {
                $this->RANKe->ViewValue = $this->RANKe->lookupCacheOption($curVal);
                if ($this->RANKe->ViewValue === null) { // Lookup from database
                    $filterWrk = SearchFilter($this->RANKe->Lookup->getTable()->Fields["ዕዝ"]->searchExpression(), "=", $curVal, $this->RANKe->Lookup->getTable()->Fields["ዕዝ"]->searchDataType(), "");
                    $sqlWrk = $this->RANKe->Lookup->getSql(false, $filterWrk, '', $this, true, true);
                    $conn = Conn();
                    $config = $conn->getConfiguration();
                    $config->setResultCache($this->Cache);
                    $rswrk = $conn->executeCacheQuery($sqlWrk, [], [], $this->CacheProfile)->fetchAll();
                    $ari = count($rswrk);
                    if ($ari > 0) { // Lookup values found
                        $arwrk = $this->RANKe->Lookup->renderViewRow($rswrk[0]);
                        $this->RANKe->ViewValue = $this->RANKe->displayValue($arwrk);
                    } else {
                        $this->RANKe->ViewValue = $this->RANKe->CurrentValue;
                    }
                }
            } else {
                $this->RANKe->ViewValue = null;
            }

            // name
            $this->name->ViewValue = $this->name->CurrentValue;

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

            // fileNumber
            $this->fileNumber->ViewValue = $this->fileNumber->CurrentValue;

            // firdbet
            $curVal = strval($this->firdbet->CurrentValue);
            if ($curVal != "") {
                $this->firdbet->ViewValue = $this->firdbet->lookupCacheOption($curVal);
                if ($this->firdbet->ViewValue === null) { // Lookup from database
                    $filterWrk = SearchFilter($this->firdbet->Lookup->getTable()->Fields["courtID"]->searchExpression(), "=", $curVal, $this->firdbet->Lookup->getTable()->Fields["courtID"]->searchDataType(), "");
                    $sqlWrk = $this->firdbet->Lookup->getSql(false, $filterWrk, '', $this, true, true);
                    $conn = Conn();
                    $config = $conn->getConfiguration();
                    $config->setResultCache($this->Cache);
                    $rswrk = $conn->executeCacheQuery($sqlWrk, [], [], $this->CacheProfile)->fetchAll();
                    $ari = count($rswrk);
                    if ($ari > 0) { // Lookup values found
                        $arwrk = $this->firdbet->Lookup->renderViewRow($rswrk[0]);
                        $this->firdbet->ViewValue = $this->firdbet->displayValue($arwrk);
                    } else {
                        $this->firdbet->ViewValue = $this->firdbet->CurrentValue;
                    }
                }
            } else {
                $this->firdbet->ViewValue = null;
            }

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

            // sex
            if (strval($this->sex->CurrentValue) != "") {
                $this->sex->ViewValue = $this->sex->optionCaption($this->sex->CurrentValue);
            } else {
                $this->sex->ViewValue = null;
            }

            // tekesashbizat
            $this->tekesashbizat->ViewValue = $this->tekesashbizat->CurrentValue;
            $this->tekesashbizat->ViewValue = FormatNumber($this->tekesashbizat->ViewValue, $this->tekesashbizat->formatPattern());

            // keterodate
            $this->keterodate->ViewValue = $this->keterodate->CurrentValue;
            $this->keterodate->ViewValue = FormatDateTime($this->keterodate->ViewValue, $this->keterodate->formatPattern());

            // keterodescription
            $this->keterodescription->ViewValue = $this->keterodescription->CurrentValue;

            // created_at
            $this->created_at->ViewValue = $this->created_at->CurrentValue;
            $this->created_at->ViewValue = FormatDateTime($this->created_at->ViewValue, $this->created_at->formatPattern());

            // updated_at
            $this->updated_at->ViewValue = $this->updated_at->CurrentValue;
            $this->updated_at->ViewValue = FormatDateTime($this->updated_at->ViewValue, $this->updated_at->formatPattern());

            // updated_by
            $this->updated_by->ViewValue = $this->updated_by->CurrentValue;
            $this->updated_by->ViewValue = FormatNumber($this->updated_by->ViewValue, $this->updated_by->formatPattern());

            // melequtir
            $this->melequtir->HrefValue = "";

            // RANKe
            $this->RANKe->HrefValue = "";

            // name
            $this->name->HrefValue = "";

            // ez
            $this->ez->HrefValue = "";

            // fileNumber
            $this->fileNumber->HrefValue = "";

            // firdbet
            $this->firdbet->HrefValue = "";

            // chilotname
            $this->chilotname->HrefValue = "";

            // kirihidet
            $this->kirihidet->HrefValue = "";

            // yekisaynet
            $this->yekisaynet->HrefValue = "";

            // keteroreason
            $this->keteroreason->HrefValue = "";

            // sex
            $this->sex->HrefValue = "";

            // tekesashbizat
            $this->tekesashbizat->HrefValue = "";

            // keterodate
            $this->keterodate->HrefValue = "";

            // keterodescription
            $this->keterodescription->HrefValue = "";

            // created_at
            $this->created_at->HrefValue = "";

            // updated_at
            $this->updated_at->HrefValue = "";

            // updated_by
            $this->updated_by->HrefValue = "";
        } elseif ($this->RowType == RowType::ADD) {
            // melequtir
            $this->melequtir->setupEditAttributes();
            if (!$this->melequtir->Raw) {
                $this->melequtir->CurrentValue = HtmlDecode($this->melequtir->CurrentValue);
            }
            $this->melequtir->EditValue = HtmlEncode($this->melequtir->CurrentValue);
            $this->melequtir->PlaceHolder = RemoveHtml($this->melequtir->caption());

            // RANKe
            $this->RANKe->setupEditAttributes();
            $curVal = trim(strval($this->RANKe->CurrentValue));
            if ($curVal != "") {
                $this->RANKe->ViewValue = $this->RANKe->lookupCacheOption($curVal);
            } else {
                $this->RANKe->ViewValue = $this->RANKe->Lookup !== null && is_array($this->RANKe->lookupOptions()) && count($this->RANKe->lookupOptions()) > 0 ? $curVal : null;
            }
            if ($this->RANKe->ViewValue !== null) { // Load from cache
                $this->RANKe->EditValue = array_values($this->RANKe->lookupOptions());
            } else { // Lookup from database
                if ($curVal == "") {
                    $filterWrk = "0=1";
                } else {
                    $filterWrk = SearchFilter($this->RANKe->Lookup->getTable()->Fields["ዕዝ"]->searchExpression(), "=", $this->RANKe->CurrentValue, $this->RANKe->Lookup->getTable()->Fields["ዕዝ"]->searchDataType(), "");
                }
                $sqlWrk = $this->RANKe->Lookup->getSql(true, $filterWrk, '', $this, false, true);
                $conn = Conn();
                $config = $conn->getConfiguration();
                $config->setResultCache($this->Cache);
                $rswrk = $conn->executeCacheQuery($sqlWrk, [], [], $this->CacheProfile)->fetchAll();
                $ari = count($rswrk);
                $arwrk = $rswrk;
                $this->RANKe->EditValue = $arwrk;
            }
            $this->RANKe->PlaceHolder = RemoveHtml($this->RANKe->caption());

            // name
            $this->name->setupEditAttributes();
            if (!$this->name->Raw) {
                $this->name->CurrentValue = HtmlDecode($this->name->CurrentValue);
            }
            $this->name->EditValue = HtmlEncode($this->name->CurrentValue);
            $this->name->PlaceHolder = RemoveHtml($this->name->caption());

            // ez
            $this->ez->setupEditAttributes();
            $curVal = trim(strval($this->ez->CurrentValue));
            if ($curVal != "") {
                $this->ez->ViewValue = $this->ez->lookupCacheOption($curVal);
            } else {
                $this->ez->ViewValue = $this->ez->Lookup !== null && is_array($this->ez->lookupOptions()) && count($this->ez->lookupOptions()) > 0 ? $curVal : null;
            }
            if ($this->ez->ViewValue !== null) { // Load from cache
                $this->ez->EditValue = array_values($this->ez->lookupOptions());
            } else { // Lookup from database
                if ($curVal == "") {
                    $filterWrk = "0=1";
                } else {
                    $filterWrk = SearchFilter($this->ez->Lookup->getTable()->Fields["ዕዝ"]->searchExpression(), "=", $this->ez->CurrentValue, $this->ez->Lookup->getTable()->Fields["ዕዝ"]->searchDataType(), "");
                }
                $sqlWrk = $this->ez->Lookup->getSql(true, $filterWrk, '', $this, false, true);
                $conn = Conn();
                $config = $conn->getConfiguration();
                $config->setResultCache($this->Cache);
                $rswrk = $conn->executeCacheQuery($sqlWrk, [], [], $this->CacheProfile)->fetchAll();
                $ari = count($rswrk);
                $arwrk = $rswrk;
                $this->ez->EditValue = $arwrk;
            }
            $this->ez->PlaceHolder = RemoveHtml($this->ez->caption());

            // fileNumber
            $this->fileNumber->setupEditAttributes();
            if (!$this->fileNumber->Raw) {
                $this->fileNumber->CurrentValue = HtmlDecode($this->fileNumber->CurrentValue);
            }
            $this->fileNumber->EditValue = HtmlEncode($this->fileNumber->CurrentValue);
            $this->fileNumber->PlaceHolder = RemoveHtml($this->fileNumber->caption());

            // firdbet
            $this->firdbet->setupEditAttributes();
            $curVal = trim(strval($this->firdbet->CurrentValue));
            if ($curVal != "") {
                $this->firdbet->ViewValue = $this->firdbet->lookupCacheOption($curVal);
            } else {
                $this->firdbet->ViewValue = $this->firdbet->Lookup !== null && is_array($this->firdbet->lookupOptions()) && count($this->firdbet->lookupOptions()) > 0 ? $curVal : null;
            }
            if ($this->firdbet->ViewValue !== null) { // Load from cache
                $this->firdbet->EditValue = array_values($this->firdbet->lookupOptions());
            } else { // Lookup from database
                if ($curVal == "") {
                    $filterWrk = "0=1";
                } else {
                    $filterWrk = SearchFilter($this->firdbet->Lookup->getTable()->Fields["courtID"]->searchExpression(), "=", $this->firdbet->CurrentValue, $this->firdbet->Lookup->getTable()->Fields["courtID"]->searchDataType(), "");
                }
                $sqlWrk = $this->firdbet->Lookup->getSql(true, $filterWrk, '', $this, false, true);
                $conn = Conn();
                $config = $conn->getConfiguration();
                $config->setResultCache($this->Cache);
                $rswrk = $conn->executeCacheQuery($sqlWrk, [], [], $this->CacheProfile)->fetchAll();
                $ari = count($rswrk);
                $arwrk = $rswrk;
                $this->firdbet->EditValue = $arwrk;
            }
            $this->firdbet->PlaceHolder = RemoveHtml($this->firdbet->caption());

            // chilotname
            $this->chilotname->setupEditAttributes();
            $curVal = trim(strval($this->chilotname->CurrentValue));
            if ($curVal != "") {
                $this->chilotname->ViewValue = $this->chilotname->lookupCacheOption($curVal);
            } else {
                $this->chilotname->ViewValue = $this->chilotname->Lookup !== null && is_array($this->chilotname->lookupOptions()) && count($this->chilotname->lookupOptions()) > 0 ? $curVal : null;
            }
            if ($this->chilotname->ViewValue !== null) { // Load from cache
                $this->chilotname->EditValue = array_values($this->chilotname->lookupOptions());
            } else { // Lookup from database
                if ($curVal == "") {
                    $filterWrk = "0=1";
                } else {
                    $filterWrk = SearchFilter($this->chilotname->Lookup->getTable()->Fields["ዕዝ"]->searchExpression(), "=", $this->chilotname->CurrentValue, $this->chilotname->Lookup->getTable()->Fields["ዕዝ"]->searchDataType(), "");
                }
                $sqlWrk = $this->chilotname->Lookup->getSql(true, $filterWrk, '', $this, false, true);
                $conn = Conn();
                $config = $conn->getConfiguration();
                $config->setResultCache($this->Cache);
                $rswrk = $conn->executeCacheQuery($sqlWrk, [], [], $this->CacheProfile)->fetchAll();
                $ari = count($rswrk);
                $arwrk = $rswrk;
                $this->chilotname->EditValue = $arwrk;
            }
            $this->chilotname->PlaceHolder = RemoveHtml($this->chilotname->caption());

            // kirihidet
            $this->kirihidet->setupEditAttributes();
            $curVal = trim(strval($this->kirihidet->CurrentValue));
            if ($curVal != "") {
                $this->kirihidet->ViewValue = $this->kirihidet->lookupCacheOption($curVal);
            } else {
                $this->kirihidet->ViewValue = $this->kirihidet->Lookup !== null && is_array($this->kirihidet->lookupOptions()) && count($this->kirihidet->lookupOptions()) > 0 ? $curVal : null;
            }
            if ($this->kirihidet->ViewValue !== null) { // Load from cache
                $this->kirihidet->EditValue = array_values($this->kirihidet->lookupOptions());
            } else { // Lookup from database
                if ($curVal == "") {
                    $filterWrk = "0=1";
                } else {
                    $filterWrk = SearchFilter($this->kirihidet->Lookup->getTable()->Fields["ዕዝ"]->searchExpression(), "=", $this->kirihidet->CurrentValue, $this->kirihidet->Lookup->getTable()->Fields["ዕዝ"]->searchDataType(), "");
                }
                $sqlWrk = $this->kirihidet->Lookup->getSql(true, $filterWrk, '', $this, false, true);
                $conn = Conn();
                $config = $conn->getConfiguration();
                $config->setResultCache($this->Cache);
                $rswrk = $conn->executeCacheQuery($sqlWrk, [], [], $this->CacheProfile)->fetchAll();
                $ari = count($rswrk);
                $arwrk = $rswrk;
                $this->kirihidet->EditValue = $arwrk;
            }
            $this->kirihidet->PlaceHolder = RemoveHtml($this->kirihidet->caption());

            // yekisaynet
            $this->yekisaynet->setupEditAttributes();
            $curVal = trim(strval($this->yekisaynet->CurrentValue));
            if ($curVal != "") {
                $this->yekisaynet->ViewValue = $this->yekisaynet->lookupCacheOption($curVal);
            } else {
                $this->yekisaynet->ViewValue = $this->yekisaynet->Lookup !== null && is_array($this->yekisaynet->lookupOptions()) && count($this->yekisaynet->lookupOptions()) > 0 ? $curVal : null;
            }
            if ($this->yekisaynet->ViewValue !== null) { // Load from cache
                $this->yekisaynet->EditValue = array_values($this->yekisaynet->lookupOptions());
            } else { // Lookup from database
                if ($curVal == "") {
                    $filterWrk = "0=1";
                } else {
                    $filterWrk = SearchFilter($this->yekisaynet->Lookup->getTable()->Fields["ዕዝ"]->searchExpression(), "=", $this->yekisaynet->CurrentValue, $this->yekisaynet->Lookup->getTable()->Fields["ዕዝ"]->searchDataType(), "");
                }
                $sqlWrk = $this->yekisaynet->Lookup->getSql(true, $filterWrk, '', $this, false, true);
                $conn = Conn();
                $config = $conn->getConfiguration();
                $config->setResultCache($this->Cache);
                $rswrk = $conn->executeCacheQuery($sqlWrk, [], [], $this->CacheProfile)->fetchAll();
                $ari = count($rswrk);
                $arwrk = $rswrk;
                $this->yekisaynet->EditValue = $arwrk;
            }
            $this->yekisaynet->PlaceHolder = RemoveHtml($this->yekisaynet->caption());

            // keteroreason
            $this->keteroreason->setupEditAttributes();
            $curVal = trim(strval($this->keteroreason->CurrentValue));
            if ($curVal != "") {
                $this->keteroreason->ViewValue = $this->keteroreason->lookupCacheOption($curVal);
            } else {
                $this->keteroreason->ViewValue = $this->keteroreason->Lookup !== null && is_array($this->keteroreason->lookupOptions()) && count($this->keteroreason->lookupOptions()) > 0 ? $curVal : null;
            }
            if ($this->keteroreason->ViewValue !== null) { // Load from cache
                $this->keteroreason->EditValue = array_values($this->keteroreason->lookupOptions());
            } else { // Lookup from database
                if ($curVal == "") {
                    $filterWrk = "0=1";
                } else {
                    $filterWrk = SearchFilter($this->keteroreason->Lookup->getTable()->Fields["ዕዝ"]->searchExpression(), "=", $this->keteroreason->CurrentValue, $this->keteroreason->Lookup->getTable()->Fields["ዕዝ"]->searchDataType(), "");
                }
                $sqlWrk = $this->keteroreason->Lookup->getSql(true, $filterWrk, '', $this, false, true);
                $conn = Conn();
                $config = $conn->getConfiguration();
                $config->setResultCache($this->Cache);
                $rswrk = $conn->executeCacheQuery($sqlWrk, [], [], $this->CacheProfile)->fetchAll();
                $ari = count($rswrk);
                $arwrk = $rswrk;
                $this->keteroreason->EditValue = $arwrk;
            }
            $this->keteroreason->PlaceHolder = RemoveHtml($this->keteroreason->caption());

            // sex
            $this->sex->EditValue = $this->sex->options(false);
            $this->sex->PlaceHolder = RemoveHtml($this->sex->caption());

            // tekesashbizat
            $this->tekesashbizat->setupEditAttributes();
            $this->tekesashbizat->EditValue = $this->tekesashbizat->CurrentValue;
            $this->tekesashbizat->PlaceHolder = RemoveHtml($this->tekesashbizat->caption());
            if (strval($this->tekesashbizat->EditValue) != "" && is_numeric($this->tekesashbizat->EditValue)) {
                $this->tekesashbizat->EditValue = FormatNumber($this->tekesashbizat->EditValue, null);
            }

            // keterodate
            $this->keterodate->setupEditAttributes();
            $this->keterodate->EditValue = HtmlEncode(FormatDateTime($this->keterodate->CurrentValue, $this->keterodate->formatPattern()));
            $this->keterodate->PlaceHolder = RemoveHtml($this->keterodate->caption());

            // keterodescription
            $this->keterodescription->setupEditAttributes();
            if (!$this->keterodescription->Raw) {
                $this->keterodescription->CurrentValue = HtmlDecode($this->keterodescription->CurrentValue);
            }
            $this->keterodescription->EditValue = HtmlEncode($this->keterodescription->CurrentValue);
            $this->keterodescription->PlaceHolder = RemoveHtml($this->keterodescription->caption());

            // created_at
            $this->created_at->setupEditAttributes();
            $this->created_at->EditValue = HtmlEncode(FormatDateTime($this->created_at->CurrentValue, $this->created_at->formatPattern()));
            $this->created_at->PlaceHolder = RemoveHtml($this->created_at->caption());

            // updated_at

            // updated_by

            // Add refer script

            // melequtir
            $this->melequtir->HrefValue = "";

            // RANKe
            $this->RANKe->HrefValue = "";

            // name
            $this->name->HrefValue = "";

            // ez
            $this->ez->HrefValue = "";

            // fileNumber
            $this->fileNumber->HrefValue = "";

            // firdbet
            $this->firdbet->HrefValue = "";

            // chilotname
            $this->chilotname->HrefValue = "";

            // kirihidet
            $this->kirihidet->HrefValue = "";

            // yekisaynet
            $this->yekisaynet->HrefValue = "";

            // keteroreason
            $this->keteroreason->HrefValue = "";

            // sex
            $this->sex->HrefValue = "";

            // tekesashbizat
            $this->tekesashbizat->HrefValue = "";

            // keterodate
            $this->keterodate->HrefValue = "";

            // keterodescription
            $this->keterodescription->HrefValue = "";

            // created_at
            $this->created_at->HrefValue = "";

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
            if ($this->melequtir->Visible && $this->melequtir->Required) {
                if (!$this->melequtir->IsDetailKey && EmptyValue($this->melequtir->FormValue)) {
                    $this->melequtir->addErrorMessage(str_replace("%s", $this->melequtir->caption(), $this->melequtir->RequiredErrorMessage));
                }
            }
            if ($this->RANKe->Visible && $this->RANKe->Required) {
                if (!$this->RANKe->IsDetailKey && EmptyValue($this->RANKe->FormValue)) {
                    $this->RANKe->addErrorMessage(str_replace("%s", $this->RANKe->caption(), $this->RANKe->RequiredErrorMessage));
                }
            }
            if ($this->name->Visible && $this->name->Required) {
                if (!$this->name->IsDetailKey && EmptyValue($this->name->FormValue)) {
                    $this->name->addErrorMessage(str_replace("%s", $this->name->caption(), $this->name->RequiredErrorMessage));
                }
            }
            if ($this->ez->Visible && $this->ez->Required) {
                if (!$this->ez->IsDetailKey && EmptyValue($this->ez->FormValue)) {
                    $this->ez->addErrorMessage(str_replace("%s", $this->ez->caption(), $this->ez->RequiredErrorMessage));
                }
            }
            if ($this->fileNumber->Visible && $this->fileNumber->Required) {
                if (!$this->fileNumber->IsDetailKey && EmptyValue($this->fileNumber->FormValue)) {
                    $this->fileNumber->addErrorMessage(str_replace("%s", $this->fileNumber->caption(), $this->fileNumber->RequiredErrorMessage));
                }
            }
            if ($this->firdbet->Visible && $this->firdbet->Required) {
                if (!$this->firdbet->IsDetailKey && EmptyValue($this->firdbet->FormValue)) {
                    $this->firdbet->addErrorMessage(str_replace("%s", $this->firdbet->caption(), $this->firdbet->RequiredErrorMessage));
                }
            }
            if ($this->chilotname->Visible && $this->chilotname->Required) {
                if (!$this->chilotname->IsDetailKey && EmptyValue($this->chilotname->FormValue)) {
                    $this->chilotname->addErrorMessage(str_replace("%s", $this->chilotname->caption(), $this->chilotname->RequiredErrorMessage));
                }
            }
            if ($this->kirihidet->Visible && $this->kirihidet->Required) {
                if (!$this->kirihidet->IsDetailKey && EmptyValue($this->kirihidet->FormValue)) {
                    $this->kirihidet->addErrorMessage(str_replace("%s", $this->kirihidet->caption(), $this->kirihidet->RequiredErrorMessage));
                }
            }
            if ($this->yekisaynet->Visible && $this->yekisaynet->Required) {
                if (!$this->yekisaynet->IsDetailKey && EmptyValue($this->yekisaynet->FormValue)) {
                    $this->yekisaynet->addErrorMessage(str_replace("%s", $this->yekisaynet->caption(), $this->yekisaynet->RequiredErrorMessage));
                }
            }
            if ($this->keteroreason->Visible && $this->keteroreason->Required) {
                if (!$this->keteroreason->IsDetailKey && EmptyValue($this->keteroreason->FormValue)) {
                    $this->keteroreason->addErrorMessage(str_replace("%s", $this->keteroreason->caption(), $this->keteroreason->RequiredErrorMessage));
                }
            }
            if ($this->sex->Visible && $this->sex->Required) {
                if ($this->sex->FormValue == "") {
                    $this->sex->addErrorMessage(str_replace("%s", $this->sex->caption(), $this->sex->RequiredErrorMessage));
                }
            }
            if ($this->tekesashbizat->Visible && $this->tekesashbizat->Required) {
                if (!$this->tekesashbizat->IsDetailKey && EmptyValue($this->tekesashbizat->FormValue)) {
                    $this->tekesashbizat->addErrorMessage(str_replace("%s", $this->tekesashbizat->caption(), $this->tekesashbizat->RequiredErrorMessage));
                }
            }
            if (!CheckInteger($this->tekesashbizat->FormValue)) {
                $this->tekesashbizat->addErrorMessage($this->tekesashbizat->getErrorMessage(false));
            }
            if ($this->keterodate->Visible && $this->keterodate->Required) {
                if (!$this->keterodate->IsDetailKey && EmptyValue($this->keterodate->FormValue)) {
                    $this->keterodate->addErrorMessage(str_replace("%s", $this->keterodate->caption(), $this->keterodate->RequiredErrorMessage));
                }
            }
            if (!CheckDate($this->keterodate->FormValue, $this->keterodate->formatPattern())) {
                $this->keterodate->addErrorMessage($this->keterodate->getErrorMessage(false));
            }
            if ($this->keterodescription->Visible && $this->keterodescription->Required) {
                if (!$this->keterodescription->IsDetailKey && EmptyValue($this->keterodescription->FormValue)) {
                    $this->keterodescription->addErrorMessage(str_replace("%s", $this->keterodescription->caption(), $this->keterodescription->RequiredErrorMessage));
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

    // Add record
    protected function addRow($rsold = null)
    {
        global $Language, $Security;

        // Get new row
        $rsnew = $this->getAddRow();

        // Update current values
        $this->setCurrentValues($rsnew);
        $conn = $this->getConnection();

        // Load db values from old row
        $this->loadDbValues($rsold);

        // Call Row Inserting event
        $insertRow = $this->rowInserting($rsold, $rsnew);
        if ($insertRow) {
            $addRow = $this->insert($rsnew);
            if ($addRow) {
            } elseif (!EmptyValue($this->DbErrorMessage)) { // Show database error
                $this->setFailureMessage($this->DbErrorMessage);
            }
        } else {
            if ($this->getSuccessMessage() != "" || $this->getFailureMessage() != "") {
                // Use the message, do nothing
            } elseif ($this->CancelMessage != "") {
                $this->setFailureMessage($this->CancelMessage);
                $this->CancelMessage = "";
            } else {
                $this->setFailureMessage($Language->phrase("InsertCancelled"));
            }
            $addRow = false;
        }
        if ($addRow) {
            // Call Row Inserted event
            $this->rowInserted($rsold, $rsnew);
        }

        // Write JSON response
        if (IsJsonResponse() && $addRow) {
            $row = $this->getRecordsFromRecordset([$rsnew], true);
            $table = $this->TableVar;
            WriteJson(["success" => true, "action" => Config("API_ADD_ACTION"), $table => $row]);
        }
        return $addRow;
    }

    /**
     * Get add row
     *
     * @return array
     */
    protected function getAddRow()
    {
        global $Security;
        $rsnew = [];

        // melequtir
        $this->melequtir->setDbValueDef($rsnew, $this->melequtir->CurrentValue, false);

        // RANKe
        $this->RANKe->setDbValueDef($rsnew, $this->RANKe->CurrentValue, false);

        // name
        $this->name->setDbValueDef($rsnew, $this->name->CurrentValue, false);

        // ez
        $this->ez->setDbValueDef($rsnew, $this->ez->CurrentValue, false);

        // fileNumber
        $this->fileNumber->setDbValueDef($rsnew, $this->fileNumber->CurrentValue, false);

        // firdbet
        $this->firdbet->setDbValueDef($rsnew, $this->firdbet->CurrentValue, false);

        // chilotname
        $this->chilotname->setDbValueDef($rsnew, $this->chilotname->CurrentValue, false);

        // kirihidet
        $this->kirihidet->setDbValueDef($rsnew, $this->kirihidet->CurrentValue, false);

        // yekisaynet
        $this->yekisaynet->setDbValueDef($rsnew, $this->yekisaynet->CurrentValue, false);

        // keteroreason
        $this->keteroreason->setDbValueDef($rsnew, $this->keteroreason->CurrentValue, false);

        // sex
        $this->sex->setDbValueDef($rsnew, $this->sex->CurrentValue, false);

        // tekesashbizat
        $this->tekesashbizat->setDbValueDef($rsnew, $this->tekesashbizat->CurrentValue, false);

        // keterodate
        $this->keterodate->setDbValueDef($rsnew, UnFormatDateTime($this->keterodate->CurrentValue, $this->keterodate->formatPattern()), false);

        // keterodescription
        $this->keterodescription->setDbValueDef($rsnew, $this->keterodescription->CurrentValue, false);

        // created_at
        $this->created_at->setDbValueDef($rsnew, UnFormatDateTime($this->created_at->CurrentValue, $this->created_at->formatPattern()), false);

        // updated_at
        $this->updated_at->CurrentValue = $this->updated_at->getAutoUpdateValue(); // PHP
        $this->updated_at->setDbValueDef($rsnew, UnFormatDateTime($this->updated_at->CurrentValue, $this->updated_at->formatPattern()));

        // updated_by
        $this->updated_by->CurrentValue = $this->updated_by->getAutoUpdateValue(); // PHP
        $this->updated_by->setDbValueDef($rsnew, $this->updated_by->CurrentValue);
        return $rsnew;
    }

    /**
     * Restore add form from row
     * @param array $row Row
     */
    protected function restoreAddFormFromRow($row)
    {
        if (isset($row['melequtir'])) { // melequtir
            $this->melequtir->setFormValue($row['melequtir']);
        }
        if (isset($row['RANKe'])) { // RANKe
            $this->RANKe->setFormValue($row['RANKe']);
        }
        if (isset($row['name'])) { // name
            $this->name->setFormValue($row['name']);
        }
        if (isset($row['ez'])) { // ez
            $this->ez->setFormValue($row['ez']);
        }
        if (isset($row['fileNumber'])) { // fileNumber
            $this->fileNumber->setFormValue($row['fileNumber']);
        }
        if (isset($row['firdbet'])) { // firdbet
            $this->firdbet->setFormValue($row['firdbet']);
        }
        if (isset($row['chilotname'])) { // chilotname
            $this->chilotname->setFormValue($row['chilotname']);
        }
        if (isset($row['kirihidet'])) { // kirihidet
            $this->kirihidet->setFormValue($row['kirihidet']);
        }
        if (isset($row['yekisaynet'])) { // yekisaynet
            $this->yekisaynet->setFormValue($row['yekisaynet']);
        }
        if (isset($row['keteroreason'])) { // keteroreason
            $this->keteroreason->setFormValue($row['keteroreason']);
        }
        if (isset($row['sex'])) { // sex
            $this->sex->setFormValue($row['sex']);
        }
        if (isset($row['tekesashbizat'])) { // tekesashbizat
            $this->tekesashbizat->setFormValue($row['tekesashbizat']);
        }
        if (isset($row['keterodate'])) { // keterodate
            $this->keterodate->setFormValue($row['keterodate']);
        }
        if (isset($row['keterodescription'])) { // keterodescription
            $this->keterodescription->setFormValue($row['keterodescription']);
        }
        if (isset($row['created_at'])) { // created_at
            $this->created_at->setFormValue($row['created_at']);
        }
        if (isset($row['updated_at'])) { // updated_at
            $this->updated_at->setFormValue($row['updated_at']);
        }
        if (isset($row['updated_by'])) { // updated_by
            $this->updated_by->setFormValue($row['updated_by']);
        }
    }

    // Set up Breadcrumb
    protected function setupBreadcrumb()
    {
        global $Breadcrumb, $Language;
        $Breadcrumb = new Breadcrumb("index");
        $url = CurrentUrl();
        $Breadcrumb->add("list", $this->TableVar, $this->addMasterUrl("CaseHearsList"), "", $this->TableVar, true);
        $pageId = ($this->isCopy()) ? "Copy" : "Add";
        $Breadcrumb->add("add", $pageId, $url);
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
