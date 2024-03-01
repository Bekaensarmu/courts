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
class SpecialfilesEdit extends Specialfiles
{
    use MessagesTrait;

    // Page ID
    public $PageID = "edit";

    // Project ID
    public $ProjectID = PROJECT_ID;

    // Page object name
    public $PageObjName = "SpecialfilesEdit";

    // View file path
    public $View = null;

    // Title
    public $Title = null; // Title for <title> tag

    // Rendering View
    public $RenderingView = false;

    // CSS class/style
    public $CurrentPageName = "SpecialfilesEdit";

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
        $this->_12D512DD->setVisibility();
        $this->_12E8127D120E12751235121D->setVisibility();
        $this->_12E812AD122D12AD1229120212F01275->setVisibility();
        $this->_12E812AD123512D312ED12901275->setVisibility();
        $this->_12E812401320122E121D12AD129512EB1275->setVisibility();
        $this->_12E812CD1233129412D312ED12901275->setVisibility();
        $this->_121B12D51228130D->setVisibility();
        $this->_121B1265122B122D12EB->setVisibility();
        $this->_12E81270121812D8130812601260127512401295->setVisibility();
        $this->_12E81270123B123B12081260127512401295->setVisibility();
        $this->_121812DD130B1262->setVisibility();
        $this->sid->setVisibility();
    }

    // Constructor
    public function __construct()
    {
        parent::__construct();
        global $Language, $DashboardReport, $DebugTimer, $UserTable;
        $this->TableVar = 'specialfiles';
        $this->TableName = 'specialfiles';

        // Table CSS class
        $this->TableClass = "table table-striped table-bordered table-hover table-sm ew-desktop-table ew-edit-table";

        // Initialize
        $GLOBALS["Page"] = &$this;

        // Language object
        $Language = Container("app.language");

        // Table object (specialfiles)
        if (!isset($GLOBALS["specialfiles"]) || $GLOBALS["specialfiles"]::class == PROJECT_NAMESPACE . "specialfiles") {
            $GLOBALS["specialfiles"] = &$this;
        }

        // Table name (for backward compatibility only)
        if (!defined(PROJECT_NAMESPACE . "TABLE_NAME")) {
            define(PROJECT_NAMESPACE . "TABLE_NAME", 'specialfiles');
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
                        $result["view"] = SameString($pageName, "SpecialfilesView"); // If View page, no primary button
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
            $key .= @$ar['sid'];
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
            $this->sid->Visible = false;
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
            if (($keyValue = Get("sid") ?? Key(0) ?? Route(2)) !== null) {
                $this->sid->setQueryStringValue($keyValue);
                $this->sid->setOldValue($this->sid->QueryStringValue);
            } elseif (Post("sid") !== null) {
                $this->sid->setFormValue(Post("sid"));
                $this->sid->setOldValue($this->sid->FormValue);
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
                if (($keyValue = Get("sid") ?? Route("sid")) !== null) {
                    $this->sid->setQueryStringValue($keyValue);
                    $loadByQuery = true;
                } else {
                    $this->sid->CurrentValue = null;
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
                        $this->terminate("SpecialfilesList"); // Return to list page
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
                        if ($this->sid->CurrentValue != null) {
                            while ($this->fetch()) {
                                if (SameString($this->sid->CurrentValue, $this->CurrentRow['sid'])) {
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
                        $this->terminate("SpecialfilesList"); // Return to list page
                        return;
                    } else {
                    }
                } else { // Modal edit page
                    if (!$loaded) { // Load record based on key
                        if ($this->getFailureMessage() == "") {
                            $this->setFailureMessage($Language->phrase("NoRecord")); // No record found
                        }
                        $this->terminate("SpecialfilesList"); // No matching record, return to list
                        return;
                    }
                } // End modal checking
                break;
            case "update": // Update
                $returnUrl = $this->getReturnUrl();
                if (GetPageName($returnUrl) == "SpecialfilesList") {
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
                        if (GetPageName($returnUrl) != "SpecialfilesList") {
                            Container("app.flash")->addMessage("Return-Url", $returnUrl); // Save return URL
                            $returnUrl = "SpecialfilesList"; // Return list page content
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

        // Check field name 'ዕዝ' first before field var 'x__12D512DD'
        $val = $CurrentForm->hasValue("ዕዝ") ? $CurrentForm->getValue("ዕዝ") : $CurrentForm->getValue("x__12D512DD");
        if (!$this->_12D512DD->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->_12D512DD->Visible = false; // Disable update for API request
            } else {
                $this->_12D512DD->setFormValue($val);
            }
        }

        // Check field name 'የችሎትስም' first before field var 'x__12E8127D120E12751235121D'
        $val = $CurrentForm->hasValue("የችሎትስም") ? $CurrentForm->getValue("የችሎትስም") : $CurrentForm->getValue("x__12E8127D120E12751235121D");
        if (!$this->_12E8127D120E12751235121D->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->_12E8127D120E12751235121D->Visible = false; // Disable update for API request
            } else {
                $this->_12E8127D120E12751235121D->setFormValue($val);
            }
        }

        // Check field name 'የክርክሩሂደት' first before field var 'x__12E812AD122D12AD1229120212F01275'
        $val = $CurrentForm->hasValue("የክርክሩሂደት") ? $CurrentForm->getValue("የክርክሩሂደት") : $CurrentForm->getValue("x__12E812AD122D12AD1229120212F01275");
        if (!$this->_12E812AD122D12AD1229120212F01275->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->_12E812AD122D12AD1229120212F01275->Visible = false; // Disable update for API request
            } else {
                $this->_12E812AD122D12AD1229120212F01275->setFormValue($val);
            }
        }

        // Check field name 'የክስዓይነት' first before field var 'x__12E812AD123512D312ED12901275'
        $val = $CurrentForm->hasValue("የክስዓይነት") ? $CurrentForm->getValue("የክስዓይነት") : $CurrentForm->getValue("x__12E812AD123512D312ED12901275");
        if (!$this->_12E812AD123512D312ED12901275->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->_12E812AD123512D312ED12901275->Visible = false; // Disable update for API request
            } else {
                $this->_12E812AD123512D312ED12901275->setFormValue($val);
            }
        }

        // Check field name 'የቀጠሮምክንያት' first before field var 'x__12E812401320122E121D12AD129512EB1275'
        $val = $CurrentForm->hasValue("የቀጠሮምክንያት") ? $CurrentForm->getValue("የቀጠሮምክንያት") : $CurrentForm->getValue("x__12E812401320122E121D12AD129512EB1275");
        if (!$this->_12E812401320122E121D12AD129512EB1275->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->_12E812401320122E121D12AD129512EB1275->Visible = false; // Disable update for API request
            } else {
                $this->_12E812401320122E121D12AD129512EB1275->setFormValue($val);
            }
        }

        // Check field name 'የውሳኔዓይነት' first before field var 'x__12E812CD1233129412D312ED12901275'
        $val = $CurrentForm->hasValue("የውሳኔዓይነት") ? $CurrentForm->getValue("የውሳኔዓይነት") : $CurrentForm->getValue("x__12E812CD1233129412D312ED12901275");
        if (!$this->_12E812CD1233129412D312ED12901275->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->_12E812CD1233129412D312ED12901275->Visible = false; // Disable update for API request
            } else {
                $this->_12E812CD1233129412D312ED12901275->setFormValue($val);
            }
        }

        // Check field name 'ማዕረግ' first before field var 'x__121B12D51228130D'
        $val = $CurrentForm->hasValue("ማዕረግ") ? $CurrentForm->getValue("ማዕረግ") : $CurrentForm->getValue("x__121B12D51228130D");
        if (!$this->_121B12D51228130D->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->_121B12D51228130D->Visible = false; // Disable update for API request
            } else {
                $this->_121B12D51228130D->setFormValue($val);
            }
        }

        // Check field name 'ማብራርያ' first before field var 'x__121B1265122B122D12EB'
        $val = $CurrentForm->hasValue("ማብራርያ") ? $CurrentForm->getValue("ማብራርያ") : $CurrentForm->getValue("x__121B1265122B122D12EB");
        if (!$this->_121B1265122B122D12EB->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->_121B1265122B122D12EB->Visible = false; // Disable update for API request
            } else {
                $this->_121B1265122B122D12EB->setFormValue($val);
            }
        }

        // Check field name 'የተመዘገበበትቀን' first before field var 'x__12E81270121812D8130812601260127512401295'
        $val = $CurrentForm->hasValue("የተመዘገበበትቀን") ? $CurrentForm->getValue("የተመዘገበበትቀን") : $CurrentForm->getValue("x__12E81270121812D8130812601260127512401295");
        if (!$this->_12E81270121812D8130812601260127512401295->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->_12E81270121812D8130812601260127512401295->Visible = false; // Disable update for API request
            } else {
                $this->_12E81270121812D8130812601260127512401295->setFormValue($val, true, $validate);
            }
            $this->_12E81270121812D8130812601260127512401295->CurrentValue = UnFormatDateTime($this->_12E81270121812D8130812601260127512401295->CurrentValue, $this->_12E81270121812D8130812601260127512401295->formatPattern());
        }

        // Check field name 'የተሻሻለበትቀን' first before field var 'x__12E81270123B123B12081260127512401295'
        $val = $CurrentForm->hasValue("የተሻሻለበትቀን") ? $CurrentForm->getValue("የተሻሻለበትቀን") : $CurrentForm->getValue("x__12E81270123B123B12081260127512401295");
        if (!$this->_12E81270123B123B12081260127512401295->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->_12E81270123B123B12081260127512401295->Visible = false; // Disable update for API request
            } else {
                $this->_12E81270123B123B12081260127512401295->setFormValue($val);
            }
            $this->_12E81270123B123B12081260127512401295->CurrentValue = UnFormatDateTime($this->_12E81270123B123B12081260127512401295->CurrentValue, $this->_12E81270123B123B12081260127512401295->formatPattern());
        }

        // Check field name 'መዝጋቢ' first before field var 'x__121812DD130B1262'
        $val = $CurrentForm->hasValue("መዝጋቢ") ? $CurrentForm->getValue("መዝጋቢ") : $CurrentForm->getValue("x__121812DD130B1262");
        if (!$this->_121812DD130B1262->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->_121812DD130B1262->Visible = false; // Disable update for API request
            } else {
                $this->_121812DD130B1262->setFormValue($val);
            }
        }

        // Check field name 'sid' first before field var 'x_sid'
        $val = $CurrentForm->hasValue("sid") ? $CurrentForm->getValue("sid") : $CurrentForm->getValue("x_sid");
        if (!$this->sid->IsDetailKey) {
            $this->sid->setFormValue($val);
        }
    }

    // Restore form values
    public function restoreFormValues()
    {
        global $CurrentForm;
        $this->_12D512DD->CurrentValue = $this->_12D512DD->FormValue;
        $this->_12E8127D120E12751235121D->CurrentValue = $this->_12E8127D120E12751235121D->FormValue;
        $this->_12E812AD122D12AD1229120212F01275->CurrentValue = $this->_12E812AD122D12AD1229120212F01275->FormValue;
        $this->_12E812AD123512D312ED12901275->CurrentValue = $this->_12E812AD123512D312ED12901275->FormValue;
        $this->_12E812401320122E121D12AD129512EB1275->CurrentValue = $this->_12E812401320122E121D12AD129512EB1275->FormValue;
        $this->_12E812CD1233129412D312ED12901275->CurrentValue = $this->_12E812CD1233129412D312ED12901275->FormValue;
        $this->_121B12D51228130D->CurrentValue = $this->_121B12D51228130D->FormValue;
        $this->_121B1265122B122D12EB->CurrentValue = $this->_121B1265122B122D12EB->FormValue;
        $this->_12E81270121812D8130812601260127512401295->CurrentValue = $this->_12E81270121812D8130812601260127512401295->FormValue;
        $this->_12E81270121812D8130812601260127512401295->CurrentValue = UnFormatDateTime($this->_12E81270121812D8130812601260127512401295->CurrentValue, $this->_12E81270121812D8130812601260127512401295->formatPattern());
        $this->_12E81270123B123B12081260127512401295->CurrentValue = $this->_12E81270123B123B12081260127512401295->FormValue;
        $this->_12E81270123B123B12081260127512401295->CurrentValue = UnFormatDateTime($this->_12E81270123B123B12081260127512401295->CurrentValue, $this->_12E81270123B123B12081260127512401295->formatPattern());
        $this->_121812DD130B1262->CurrentValue = $this->_121812DD130B1262->FormValue;
        $this->sid->CurrentValue = $this->sid->FormValue;
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
        $this->_12D512DD->setDbValue($row['ዕዝ']);
        $this->_12E8127D120E12751235121D->setDbValue($row['የችሎትስም']);
        $this->_12E812AD122D12AD1229120212F01275->setDbValue($row['የክርክሩሂደት']);
        $this->_12E812AD123512D312ED12901275->setDbValue($row['የክስዓይነት']);
        $this->_12E812401320122E121D12AD129512EB1275->setDbValue($row['የቀጠሮምክንያት']);
        $this->_12E812CD1233129412D312ED12901275->setDbValue($row['የውሳኔዓይነት']);
        $this->_121B12D51228130D->setDbValue($row['ማዕረግ']);
        $this->_121B1265122B122D12EB->setDbValue($row['ማብራርያ']);
        $this->_12E81270121812D8130812601260127512401295->setDbValue($row['የተመዘገበበትቀን']);
        $this->_12E81270123B123B12081260127512401295->setDbValue($row['የተሻሻለበትቀን']);
        $this->_121812DD130B1262->setDbValue($row['መዝጋቢ']);
        $this->sid->setDbValue($row['sid']);
    }

    // Return a row with default values
    protected function newRow()
    {
        $row = [];
        $row['ዕዝ'] = $this->_12D512DD->DefaultValue;
        $row['የችሎትስም'] = $this->_12E8127D120E12751235121D->DefaultValue;
        $row['የክርክሩሂደት'] = $this->_12E812AD122D12AD1229120212F01275->DefaultValue;
        $row['የክስዓይነት'] = $this->_12E812AD123512D312ED12901275->DefaultValue;
        $row['የቀጠሮምክንያት'] = $this->_12E812401320122E121D12AD129512EB1275->DefaultValue;
        $row['የውሳኔዓይነት'] = $this->_12E812CD1233129412D312ED12901275->DefaultValue;
        $row['ማዕረግ'] = $this->_121B12D51228130D->DefaultValue;
        $row['ማብራርያ'] = $this->_121B1265122B122D12EB->DefaultValue;
        $row['የተመዘገበበትቀን'] = $this->_12E81270121812D8130812601260127512401295->DefaultValue;
        $row['የተሻሻለበትቀን'] = $this->_12E81270123B123B12081260127512401295->DefaultValue;
        $row['መዝጋቢ'] = $this->_121812DD130B1262->DefaultValue;
        $row['sid'] = $this->sid->DefaultValue;
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

        // ዕዝ
        $this->_12D512DD->RowCssClass = "row";

        // የችሎትስም
        $this->_12E8127D120E12751235121D->RowCssClass = "row";

        // የክርክሩሂደት
        $this->_12E812AD122D12AD1229120212F01275->RowCssClass = "row";

        // የክስዓይነት
        $this->_12E812AD123512D312ED12901275->RowCssClass = "row";

        // የቀጠሮምክንያት
        $this->_12E812401320122E121D12AD129512EB1275->RowCssClass = "row";

        // የውሳኔዓይነት
        $this->_12E812CD1233129412D312ED12901275->RowCssClass = "row";

        // ማዕረግ
        $this->_121B12D51228130D->RowCssClass = "row";

        // ማብራርያ
        $this->_121B1265122B122D12EB->RowCssClass = "row";

        // የተመዘገበበትቀን
        $this->_12E81270121812D8130812601260127512401295->RowCssClass = "row";

        // የተሻሻለበትቀን
        $this->_12E81270123B123B12081260127512401295->RowCssClass = "row";

        // መዝጋቢ
        $this->_121812DD130B1262->RowCssClass = "row";

        // sid
        $this->sid->RowCssClass = "row";

        // View row
        if ($this->RowType == RowType::VIEW) {
            // ዕዝ
            $this->_12D512DD->ViewValue = $this->_12D512DD->CurrentValue;

            // የችሎትስም
            $this->_12E8127D120E12751235121D->ViewValue = $this->_12E8127D120E12751235121D->CurrentValue;

            // የክርክሩሂደት
            $this->_12E812AD122D12AD1229120212F01275->ViewValue = $this->_12E812AD122D12AD1229120212F01275->CurrentValue;

            // የክስዓይነት
            $this->_12E812AD123512D312ED12901275->ViewValue = $this->_12E812AD123512D312ED12901275->CurrentValue;

            // የቀጠሮምክንያት
            $this->_12E812401320122E121D12AD129512EB1275->ViewValue = $this->_12E812401320122E121D12AD129512EB1275->CurrentValue;

            // የውሳኔዓይነት
            $this->_12E812CD1233129412D312ED12901275->ViewValue = $this->_12E812CD1233129412D312ED12901275->CurrentValue;

            // ማዕረግ
            $this->_121B12D51228130D->ViewValue = $this->_121B12D51228130D->CurrentValue;

            // ማብራርያ
            $this->_121B1265122B122D12EB->ViewValue = $this->_121B1265122B122D12EB->CurrentValue;

            // የተመዘገበበትቀን
            $this->_12E81270121812D8130812601260127512401295->ViewValue = $this->_12E81270121812D8130812601260127512401295->CurrentValue;
            $this->_12E81270121812D8130812601260127512401295->ViewValue = FormatDateTime($this->_12E81270121812D8130812601260127512401295->ViewValue, $this->_12E81270121812D8130812601260127512401295->formatPattern());

            // የተሻሻለበትቀን
            $this->_12E81270123B123B12081260127512401295->ViewValue = $this->_12E81270123B123B12081260127512401295->CurrentValue;
            $this->_12E81270123B123B12081260127512401295->ViewValue = FormatDateTime($this->_12E81270123B123B12081260127512401295->ViewValue, $this->_12E81270123B123B12081260127512401295->formatPattern());

            // መዝጋቢ
            $this->_121812DD130B1262->ViewValue = $this->_121812DD130B1262->CurrentValue;

            // sid
            $this->sid->ViewValue = $this->sid->CurrentValue;

            // ዕዝ
            $this->_12D512DD->HrefValue = "";

            // የችሎትስም
            $this->_12E8127D120E12751235121D->HrefValue = "";

            // የክርክሩሂደት
            $this->_12E812AD122D12AD1229120212F01275->HrefValue = "";

            // የክስዓይነት
            $this->_12E812AD123512D312ED12901275->HrefValue = "";

            // የቀጠሮምክንያት
            $this->_12E812401320122E121D12AD129512EB1275->HrefValue = "";

            // የውሳኔዓይነት
            $this->_12E812CD1233129412D312ED12901275->HrefValue = "";

            // ማዕረግ
            $this->_121B12D51228130D->HrefValue = "";

            // ማብራርያ
            $this->_121B1265122B122D12EB->HrefValue = "";

            // የተመዘገበበትቀን
            $this->_12E81270121812D8130812601260127512401295->HrefValue = "";

            // የተሻሻለበትቀን
            $this->_12E81270123B123B12081260127512401295->HrefValue = "";

            // መዝጋቢ
            $this->_121812DD130B1262->HrefValue = "";

            // sid
            $this->sid->HrefValue = "";
        } elseif ($this->RowType == RowType::EDIT) {
            // ዕዝ
            $this->_12D512DD->setupEditAttributes();
            if (!$this->_12D512DD->Raw) {
                $this->_12D512DD->CurrentValue = HtmlDecode($this->_12D512DD->CurrentValue);
            }
            $this->_12D512DD->EditValue = HtmlEncode($this->_12D512DD->CurrentValue);
            $this->_12D512DD->PlaceHolder = RemoveHtml($this->_12D512DD->caption());

            // የችሎትስም
            $this->_12E8127D120E12751235121D->setupEditAttributes();
            if (!$this->_12E8127D120E12751235121D->Raw) {
                $this->_12E8127D120E12751235121D->CurrentValue = HtmlDecode($this->_12E8127D120E12751235121D->CurrentValue);
            }
            $this->_12E8127D120E12751235121D->EditValue = HtmlEncode($this->_12E8127D120E12751235121D->CurrentValue);
            $this->_12E8127D120E12751235121D->PlaceHolder = RemoveHtml($this->_12E8127D120E12751235121D->caption());

            // የክርክሩሂደት
            $this->_12E812AD122D12AD1229120212F01275->setupEditAttributes();
            if (!$this->_12E812AD122D12AD1229120212F01275->Raw) {
                $this->_12E812AD122D12AD1229120212F01275->CurrentValue = HtmlDecode($this->_12E812AD122D12AD1229120212F01275->CurrentValue);
            }
            $this->_12E812AD122D12AD1229120212F01275->EditValue = HtmlEncode($this->_12E812AD122D12AD1229120212F01275->CurrentValue);
            $this->_12E812AD122D12AD1229120212F01275->PlaceHolder = RemoveHtml($this->_12E812AD122D12AD1229120212F01275->caption());

            // የክስዓይነት
            $this->_12E812AD123512D312ED12901275->setupEditAttributes();
            if (!$this->_12E812AD123512D312ED12901275->Raw) {
                $this->_12E812AD123512D312ED12901275->CurrentValue = HtmlDecode($this->_12E812AD123512D312ED12901275->CurrentValue);
            }
            $this->_12E812AD123512D312ED12901275->EditValue = HtmlEncode($this->_12E812AD123512D312ED12901275->CurrentValue);
            $this->_12E812AD123512D312ED12901275->PlaceHolder = RemoveHtml($this->_12E812AD123512D312ED12901275->caption());

            // የቀጠሮምክንያት
            $this->_12E812401320122E121D12AD129512EB1275->setupEditAttributes();
            if (!$this->_12E812401320122E121D12AD129512EB1275->Raw) {
                $this->_12E812401320122E121D12AD129512EB1275->CurrentValue = HtmlDecode($this->_12E812401320122E121D12AD129512EB1275->CurrentValue);
            }
            $this->_12E812401320122E121D12AD129512EB1275->EditValue = HtmlEncode($this->_12E812401320122E121D12AD129512EB1275->CurrentValue);
            $this->_12E812401320122E121D12AD129512EB1275->PlaceHolder = RemoveHtml($this->_12E812401320122E121D12AD129512EB1275->caption());

            // የውሳኔዓይነት
            $this->_12E812CD1233129412D312ED12901275->setupEditAttributes();
            if (!$this->_12E812CD1233129412D312ED12901275->Raw) {
                $this->_12E812CD1233129412D312ED12901275->CurrentValue = HtmlDecode($this->_12E812CD1233129412D312ED12901275->CurrentValue);
            }
            $this->_12E812CD1233129412D312ED12901275->EditValue = HtmlEncode($this->_12E812CD1233129412D312ED12901275->CurrentValue);
            $this->_12E812CD1233129412D312ED12901275->PlaceHolder = RemoveHtml($this->_12E812CD1233129412D312ED12901275->caption());

            // ማዕረግ
            $this->_121B12D51228130D->setupEditAttributes();
            if (!$this->_121B12D51228130D->Raw) {
                $this->_121B12D51228130D->CurrentValue = HtmlDecode($this->_121B12D51228130D->CurrentValue);
            }
            $this->_121B12D51228130D->EditValue = HtmlEncode($this->_121B12D51228130D->CurrentValue);
            $this->_121B12D51228130D->PlaceHolder = RemoveHtml($this->_121B12D51228130D->caption());

            // ማብራርያ
            $this->_121B1265122B122D12EB->setupEditAttributes();
            if (!$this->_121B1265122B122D12EB->Raw) {
                $this->_121B1265122B122D12EB->CurrentValue = HtmlDecode($this->_121B1265122B122D12EB->CurrentValue);
            }
            $this->_121B1265122B122D12EB->EditValue = HtmlEncode($this->_121B1265122B122D12EB->CurrentValue);
            $this->_121B1265122B122D12EB->PlaceHolder = RemoveHtml($this->_121B1265122B122D12EB->caption());

            // የተመዘገበበትቀን
            $this->_12E81270121812D8130812601260127512401295->setupEditAttributes();
            $this->_12E81270121812D8130812601260127512401295->EditValue = HtmlEncode(FormatDateTime($this->_12E81270121812D8130812601260127512401295->CurrentValue, $this->_12E81270121812D8130812601260127512401295->formatPattern()));
            $this->_12E81270121812D8130812601260127512401295->PlaceHolder = RemoveHtml($this->_12E81270121812D8130812601260127512401295->caption());

            // የተሻሻለበትቀን

            // መዝጋቢ

            // sid
            $this->sid->setupEditAttributes();
            $this->sid->EditValue = $this->sid->CurrentValue;

            // Edit refer script

            // ዕዝ
            $this->_12D512DD->HrefValue = "";

            // የችሎትስም
            $this->_12E8127D120E12751235121D->HrefValue = "";

            // የክርክሩሂደት
            $this->_12E812AD122D12AD1229120212F01275->HrefValue = "";

            // የክስዓይነት
            $this->_12E812AD123512D312ED12901275->HrefValue = "";

            // የቀጠሮምክንያት
            $this->_12E812401320122E121D12AD129512EB1275->HrefValue = "";

            // የውሳኔዓይነት
            $this->_12E812CD1233129412D312ED12901275->HrefValue = "";

            // ማዕረግ
            $this->_121B12D51228130D->HrefValue = "";

            // ማብራርያ
            $this->_121B1265122B122D12EB->HrefValue = "";

            // የተመዘገበበትቀን
            $this->_12E81270121812D8130812601260127512401295->HrefValue = "";

            // የተሻሻለበትቀን
            $this->_12E81270123B123B12081260127512401295->HrefValue = "";

            // መዝጋቢ
            $this->_121812DD130B1262->HrefValue = "";

            // sid
            $this->sid->HrefValue = "";
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
            if ($this->_12D512DD->Visible && $this->_12D512DD->Required) {
                if (!$this->_12D512DD->IsDetailKey && EmptyValue($this->_12D512DD->FormValue)) {
                    $this->_12D512DD->addErrorMessage(str_replace("%s", $this->_12D512DD->caption(), $this->_12D512DD->RequiredErrorMessage));
                }
            }
            if ($this->_12E8127D120E12751235121D->Visible && $this->_12E8127D120E12751235121D->Required) {
                if (!$this->_12E8127D120E12751235121D->IsDetailKey && EmptyValue($this->_12E8127D120E12751235121D->FormValue)) {
                    $this->_12E8127D120E12751235121D->addErrorMessage(str_replace("%s", $this->_12E8127D120E12751235121D->caption(), $this->_12E8127D120E12751235121D->RequiredErrorMessage));
                }
            }
            if ($this->_12E812AD122D12AD1229120212F01275->Visible && $this->_12E812AD122D12AD1229120212F01275->Required) {
                if (!$this->_12E812AD122D12AD1229120212F01275->IsDetailKey && EmptyValue($this->_12E812AD122D12AD1229120212F01275->FormValue)) {
                    $this->_12E812AD122D12AD1229120212F01275->addErrorMessage(str_replace("%s", $this->_12E812AD122D12AD1229120212F01275->caption(), $this->_12E812AD122D12AD1229120212F01275->RequiredErrorMessage));
                }
            }
            if ($this->_12E812AD123512D312ED12901275->Visible && $this->_12E812AD123512D312ED12901275->Required) {
                if (!$this->_12E812AD123512D312ED12901275->IsDetailKey && EmptyValue($this->_12E812AD123512D312ED12901275->FormValue)) {
                    $this->_12E812AD123512D312ED12901275->addErrorMessage(str_replace("%s", $this->_12E812AD123512D312ED12901275->caption(), $this->_12E812AD123512D312ED12901275->RequiredErrorMessage));
                }
            }
            if ($this->_12E812401320122E121D12AD129512EB1275->Visible && $this->_12E812401320122E121D12AD129512EB1275->Required) {
                if (!$this->_12E812401320122E121D12AD129512EB1275->IsDetailKey && EmptyValue($this->_12E812401320122E121D12AD129512EB1275->FormValue)) {
                    $this->_12E812401320122E121D12AD129512EB1275->addErrorMessage(str_replace("%s", $this->_12E812401320122E121D12AD129512EB1275->caption(), $this->_12E812401320122E121D12AD129512EB1275->RequiredErrorMessage));
                }
            }
            if ($this->_12E812CD1233129412D312ED12901275->Visible && $this->_12E812CD1233129412D312ED12901275->Required) {
                if (!$this->_12E812CD1233129412D312ED12901275->IsDetailKey && EmptyValue($this->_12E812CD1233129412D312ED12901275->FormValue)) {
                    $this->_12E812CD1233129412D312ED12901275->addErrorMessage(str_replace("%s", $this->_12E812CD1233129412D312ED12901275->caption(), $this->_12E812CD1233129412D312ED12901275->RequiredErrorMessage));
                }
            }
            if ($this->_121B12D51228130D->Visible && $this->_121B12D51228130D->Required) {
                if (!$this->_121B12D51228130D->IsDetailKey && EmptyValue($this->_121B12D51228130D->FormValue)) {
                    $this->_121B12D51228130D->addErrorMessage(str_replace("%s", $this->_121B12D51228130D->caption(), $this->_121B12D51228130D->RequiredErrorMessage));
                }
            }
            if ($this->_121B1265122B122D12EB->Visible && $this->_121B1265122B122D12EB->Required) {
                if (!$this->_121B1265122B122D12EB->IsDetailKey && EmptyValue($this->_121B1265122B122D12EB->FormValue)) {
                    $this->_121B1265122B122D12EB->addErrorMessage(str_replace("%s", $this->_121B1265122B122D12EB->caption(), $this->_121B1265122B122D12EB->RequiredErrorMessage));
                }
            }
            if ($this->_12E81270121812D8130812601260127512401295->Visible && $this->_12E81270121812D8130812601260127512401295->Required) {
                if (!$this->_12E81270121812D8130812601260127512401295->IsDetailKey && EmptyValue($this->_12E81270121812D8130812601260127512401295->FormValue)) {
                    $this->_12E81270121812D8130812601260127512401295->addErrorMessage(str_replace("%s", $this->_12E81270121812D8130812601260127512401295->caption(), $this->_12E81270121812D8130812601260127512401295->RequiredErrorMessage));
                }
            }
            if (!CheckDate($this->_12E81270121812D8130812601260127512401295->FormValue, $this->_12E81270121812D8130812601260127512401295->formatPattern())) {
                $this->_12E81270121812D8130812601260127512401295->addErrorMessage($this->_12E81270121812D8130812601260127512401295->getErrorMessage(false));
            }
            if ($this->_12E81270123B123B12081260127512401295->Visible && $this->_12E81270123B123B12081260127512401295->Required) {
                if (!$this->_12E81270123B123B12081260127512401295->IsDetailKey && EmptyValue($this->_12E81270123B123B12081260127512401295->FormValue)) {
                    $this->_12E81270123B123B12081260127512401295->addErrorMessage(str_replace("%s", $this->_12E81270123B123B12081260127512401295->caption(), $this->_12E81270123B123B12081260127512401295->RequiredErrorMessage));
                }
            }
            if ($this->_121812DD130B1262->Visible && $this->_121812DD130B1262->Required) {
                if (!$this->_121812DD130B1262->IsDetailKey && EmptyValue($this->_121812DD130B1262->FormValue)) {
                    $this->_121812DD130B1262->addErrorMessage(str_replace("%s", $this->_121812DD130B1262->caption(), $this->_121812DD130B1262->RequiredErrorMessage));
                }
            }
            if ($this->sid->Visible && $this->sid->Required) {
                if (!$this->sid->IsDetailKey && EmptyValue($this->sid->FormValue)) {
                    $this->sid->addErrorMessage(str_replace("%s", $this->sid->caption(), $this->sid->RequiredErrorMessage));
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

        // ዕዝ
        $this->_12D512DD->setDbValueDef($rsnew, $this->_12D512DD->CurrentValue, $this->_12D512DD->ReadOnly);

        // የችሎትስም
        $this->_12E8127D120E12751235121D->setDbValueDef($rsnew, $this->_12E8127D120E12751235121D->CurrentValue, $this->_12E8127D120E12751235121D->ReadOnly);

        // የክርክሩሂደት
        $this->_12E812AD122D12AD1229120212F01275->setDbValueDef($rsnew, $this->_12E812AD122D12AD1229120212F01275->CurrentValue, $this->_12E812AD122D12AD1229120212F01275->ReadOnly);

        // የክስዓይነት
        $this->_12E812AD123512D312ED12901275->setDbValueDef($rsnew, $this->_12E812AD123512D312ED12901275->CurrentValue, $this->_12E812AD123512D312ED12901275->ReadOnly);

        // የቀጠሮምክንያት
        $this->_12E812401320122E121D12AD129512EB1275->setDbValueDef($rsnew, $this->_12E812401320122E121D12AD129512EB1275->CurrentValue, $this->_12E812401320122E121D12AD129512EB1275->ReadOnly);

        // የውሳኔዓይነት
        $this->_12E812CD1233129412D312ED12901275->setDbValueDef($rsnew, $this->_12E812CD1233129412D312ED12901275->CurrentValue, $this->_12E812CD1233129412D312ED12901275->ReadOnly);

        // ማዕረግ
        $this->_121B12D51228130D->setDbValueDef($rsnew, $this->_121B12D51228130D->CurrentValue, $this->_121B12D51228130D->ReadOnly);

        // ማብራርያ
        $this->_121B1265122B122D12EB->setDbValueDef($rsnew, $this->_121B1265122B122D12EB->CurrentValue, $this->_121B1265122B122D12EB->ReadOnly);

        // የተመዘገበበትቀን
        $this->_12E81270121812D8130812601260127512401295->setDbValueDef($rsnew, UnFormatDateTime($this->_12E81270121812D8130812601260127512401295->CurrentValue, $this->_12E81270121812D8130812601260127512401295->formatPattern()), $this->_12E81270121812D8130812601260127512401295->ReadOnly);

        // የተሻሻለበትቀን
        $this->_12E81270123B123B12081260127512401295->CurrentValue = $this->_12E81270123B123B12081260127512401295->getAutoUpdateValue(); // PHP
        $this->_12E81270123B123B12081260127512401295->setDbValueDef($rsnew, UnFormatDateTime($this->_12E81270123B123B12081260127512401295->CurrentValue, $this->_12E81270123B123B12081260127512401295->formatPattern()));

        // መዝጋቢ
        $this->_121812DD130B1262->CurrentValue = $this->_121812DD130B1262->getAutoUpdateValue(); // PHP
        $this->_121812DD130B1262->setDbValueDef($rsnew, $this->_121812DD130B1262->CurrentValue);
        return $rsnew;
    }

    /**
     * Restore edit form from row
     * @param array $row Row
     */
    protected function restoreEditFormFromRow($row)
    {
        if (isset($row['ዕዝ'])) { // ዕዝ
            $this->_12D512DD->CurrentValue = $row['ዕዝ'];
        }
        if (isset($row['የችሎትስም'])) { // የችሎትስም
            $this->_12E8127D120E12751235121D->CurrentValue = $row['የችሎትስም'];
        }
        if (isset($row['የክርክሩሂደት'])) { // የክርክሩሂደት
            $this->_12E812AD122D12AD1229120212F01275->CurrentValue = $row['የክርክሩሂደት'];
        }
        if (isset($row['የክስዓይነት'])) { // የክስዓይነት
            $this->_12E812AD123512D312ED12901275->CurrentValue = $row['የክስዓይነት'];
        }
        if (isset($row['የቀጠሮምክንያት'])) { // የቀጠሮምክንያት
            $this->_12E812401320122E121D12AD129512EB1275->CurrentValue = $row['የቀጠሮምክንያት'];
        }
        if (isset($row['የውሳኔዓይነት'])) { // የውሳኔዓይነት
            $this->_12E812CD1233129412D312ED12901275->CurrentValue = $row['የውሳኔዓይነት'];
        }
        if (isset($row['ማዕረግ'])) { // ማዕረግ
            $this->_121B12D51228130D->CurrentValue = $row['ማዕረግ'];
        }
        if (isset($row['ማብራርያ'])) { // ማብራርያ
            $this->_121B1265122B122D12EB->CurrentValue = $row['ማብራርያ'];
        }
        if (isset($row['የተመዘገበበትቀን'])) { // የተመዘገበበትቀን
            $this->_12E81270121812D8130812601260127512401295->CurrentValue = $row['የተመዘገበበትቀን'];
        }
        if (isset($row['የተሻሻለበትቀን'])) { // የተሻሻለበትቀን
            $this->_12E81270123B123B12081260127512401295->CurrentValue = $row['የተሻሻለበትቀን'];
        }
        if (isset($row['መዝጋቢ'])) { // መዝጋቢ
            $this->_121812DD130B1262->CurrentValue = $row['መዝጋቢ'];
        }
    }

    // Set up Breadcrumb
    protected function setupBreadcrumb()
    {
        global $Breadcrumb, $Language;
        $Breadcrumb = new Breadcrumb("index");
        $url = CurrentUrl();
        $Breadcrumb->add("list", $this->TableVar, $this->addMasterUrl("SpecialfilesList"), "", $this->TableVar, true);
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
