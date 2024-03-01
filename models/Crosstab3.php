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
 * Table class for Crosstab3
 */
class Crosstab3 extends CrosstabTable
{
    protected $SqlFrom = "";
    protected $SqlSelect = null;
    protected $SqlSelectList = null;
    protected $SqlWhere = "";
    protected $SqlGroupBy = "";
    protected $SqlHaving = "";
    protected $SqlOrderBy = "";
    public $DbErrorMessage = "";
    public $UseSessionForListSql = true;

    // Column CSS classes
    public $LeftColumnClass = "col-sm-2 col-form-label ew-label";
    public $RightColumnClass = "col-sm-10";
    public $OffsetColumnClass = "col-sm-10 offset-sm-2";
    public $TableLeftColumnClass = "w-col-2";

    // Ajax / Modal
    public $UseAjaxActions = false;
    public $ModalSearch = false;
    public $ModalView = false;
    public $ModalAdd = false;
    public $ModalEdit = false;
    public $ModalUpdate = false;
    public $InlineDelete = false;
    public $ModalGridAdd = false;
    public $ModalGridEdit = false;
    public $ModalMultiEdit = false;
    public $YEAR__appealDate;

    // Fields
    public $AppealID;
    public $appealDate;
    public $mid;
    public $rank;
    public $name;
    public $deptName;
    public $halafinet;
    public $crimstate;
    public $Description;
    public $midib;
    public $appealask;
    public $AppealDescription;
    public $appealDecision;
    public $created_at;
    public $crimeDate;
    public $updated_at;
    public $updated_by;
    public $id;

    // Page ID
    public $PageID = ""; // To be overridden by subclass

    // Constructor
    public function __construct()
    {
        parent::__construct();
        global $Language, $CurrentLanguage, $CurrentLocale;

        // Language object
        $Language = Container("app.language");
        $this->TableVar = "Crosstab3";
        $this->TableName = 'Crosstab3';
        $this->TableType = "REPORT";
        $this->TableReportType = "crosstab"; // Report Type
        $this->ReportSourceTable = 'appeal'; // Report source table
        $this->Dbid = 'DB';
        $this->ExportAll = true;
        $this->ExportPageBreakCount = 0; // Page break per every n record (report only)

        // PDF
        $this->ExportPageOrientation = "portrait"; // Page orientation (PDF only)
        $this->ExportPageSize = "a4"; // Page size (PDF only)

        // PhpSpreadsheet
        $this->ExportExcelPageOrientation = null; // Page orientation (PhpSpreadsheet only)
        $this->ExportExcelPageSize = null; // Page size (PhpSpreadsheet only)

        // PHPWord
        $this->ExportWordPageOrientation = ""; // Page orientation (PHPWord only)
        $this->ExportWordPageSize = ""; // Page orientation (PHPWord only)
        $this->ExportWordColumnWidth = null; // Cell width (PHPWord only)
        $this->UserIDAllowSecurity = Config("DEFAULT_USER_ID_ALLOW_SECURITY"); // Default User ID allowed permissions

        // AppealID
        $this->AppealID = new ReportField(
            $this, // Table
            'x_AppealID', // Variable name
            'AppealID', // Name
            '`AppealID`', // Expression
            '`AppealID`', // Basic search expression
            200, // Type
            255, // Size
            -1, // Date/Time format
            false, // Is upload field
            '`AppealID`', // Virtual expression
            false, // Is virtual
            false, // Force selection
            false, // Is Virtual search
            'FORMATTED TEXT', // View Tag
            'SELECT' // Edit Tag
        );
        $this->AppealID->InputTextType = "text";
        $this->AppealID->Nullable = false; // NOT NULL field
        $this->AppealID->Required = true; // Required field
        $this->AppealID->setSelectMultiple(false); // Select one
        $this->AppealID->UsePleaseSelect = true; // Use PleaseSelect by default
        $this->AppealID->PleaseSelectText = $Language->phrase("PleaseSelect"); // "PleaseSelect" text
        $this->AppealID->Lookup = new Lookup($this->AppealID, 'courts', false, 'courtID', ["courtID","","",""], '', '', [], [], [], [], [], [], false, '', '', "`courtID`");
        $this->AppealID->SearchOperators = ["=", "<>"];
        $this->AppealID->SourceTableVar = 'appeal';
        $this->Fields['AppealID'] = &$this->AppealID;

        // appealDate
        $this->appealDate = new ReportField(
            $this, // Table
            'x_appealDate', // Variable name
            'appealDate', // Name
            '`appealDate`', // Expression
            CastDateFieldForLike("`appealDate`", 0, "DB"), // Basic search expression
            135, // Type
            19, // Size
            0, // Date/Time format
            false, // Is upload field
            '`appealDate`', // Virtual expression
            false, // Is virtual
            false, // Force selection
            false, // Is Virtual search
            'FORMATTED TEXT', // View Tag
            'TEXT' // Edit Tag
        );
        $this->appealDate->InputTextType = "text";
        $this->appealDate->Raw = true;
        $this->appealDate->Nullable = false; // NOT NULL field
        $this->appealDate->Required = true; // Required field
        $this->appealDate->LookupExpression = "YEAR(`appealDate`)";
        $this->appealDate->DefaultErrorMessage = str_replace("%s", $GLOBALS["DATE_FORMAT"], $Language->phrase("IncorrectDate"));
        $this->appealDate->SearchOperators = ["="];
        $this->appealDate->SourceTableVar = 'appeal';
        $this->Fields['appealDate'] = &$this->appealDate;

        // mid
        $this->mid = new ReportField(
            $this, // Table
            'x_mid', // Variable name
            'mid', // Name
            '`mid`', // Expression
            '`mid`', // Basic search expression
            200, // Type
            255, // Size
            -1, // Date/Time format
            false, // Is upload field
            '`mid`', // Virtual expression
            false, // Is virtual
            false, // Force selection
            false, // Is Virtual search
            'FORMATTED TEXT', // View Tag
            'SELECT' // Edit Tag
        );
        $this->mid->InputTextType = "text";
        $this->mid->Nullable = false; // NOT NULL field
        $this->mid->Required = true; // Required field
        $this->mid->setSelectMultiple(false); // Select one
        $this->mid->UsePleaseSelect = true; // Use PleaseSelect by default
        $this->mid->PleaseSelectText = $Language->phrase("PleaseSelect"); // "PleaseSelect" text
        $this->mid->Lookup = new Lookup($this->mid, 'case_hears', false, 'melequtir', ["melequtir","","",""], '', '', [], [], [], [], [], [], false, '', '', "`melequtir`");
        $this->mid->SearchOperators = ["=", "<>"];
        $this->mid->SourceTableVar = 'appeal';
        $this->Fields['mid'] = &$this->mid;

        // rank
        $this->rank = new ReportField(
            $this, // Table
            'x_rank', // Variable name
            'rank', // Name
            '`rank`', // Expression
            '`rank`', // Basic search expression
            200, // Type
            255, // Size
            -1, // Date/Time format
            false, // Is upload field
            '`rank`', // Virtual expression
            false, // Is virtual
            false, // Force selection
            false, // Is Virtual search
            'FORMATTED TEXT', // View Tag
            'SELECT' // Edit Tag
        );
        $this->rank->InputTextType = "text";
        $this->rank->GroupingFieldId = 1;
        $this->rank->Nullable = false; // NOT NULL field
        $this->rank->Required = true; // Required field
        $this->rank->setSelectMultiple(false); // Select one
        $this->rank->UsePleaseSelect = true; // Use PleaseSelect by default
        $this->rank->PleaseSelectText = $Language->phrase("PleaseSelect"); // "PleaseSelect" text
        $this->rank->Lookup = new Lookup($this->rank, 'specialfiles', false, 'ዕዝ', ["ማዕረግ","","",""], '', '', [], [], [], [], [], [], false, '', '', "`ማዕረግ`");
        $this->rank->SearchOperators = ["=", "<>"];
        $this->rank->SourceTableVar = 'appeal';
        $this->Fields['rank'] = &$this->rank;

        // name
        $this->name = new ReportField(
            $this, // Table
            'x_name', // Variable name
            'name', // Name
            '`name`', // Expression
            '`name`', // Basic search expression
            200, // Type
            255, // Size
            -1, // Date/Time format
            false, // Is upload field
            '`name`', // Virtual expression
            false, // Is virtual
            false, // Force selection
            false, // Is Virtual search
            'FORMATTED TEXT', // View Tag
            'TEXT' // Edit Tag
        );
        $this->name->InputTextType = "text";
        $this->name->Nullable = false; // NOT NULL field
        $this->name->Required = true; // Required field
        $this->name->SearchOperators = ["=", "<>", "IN", "NOT IN", "STARTS WITH", "NOT STARTS WITH", "LIKE", "NOT LIKE", "ENDS WITH", "NOT ENDS WITH", "IS EMPTY", "IS NOT EMPTY"];
        $this->name->SourceTableVar = 'appeal';
        $this->Fields['name'] = &$this->name;

        // deptName
        $this->deptName = new ReportField(
            $this, // Table
            'x_deptName', // Variable name
            'deptName', // Name
            '`deptName`', // Expression
            '`deptName`', // Basic search expression
            200, // Type
            255, // Size
            -1, // Date/Time format
            false, // Is upload field
            '`deptName`', // Virtual expression
            false, // Is virtual
            false, // Force selection
            false, // Is Virtual search
            'FORMATTED TEXT', // View Tag
            'SELECT' // Edit Tag
        );
        $this->deptName->InputTextType = "text";
        $this->deptName->Nullable = false; // NOT NULL field
        $this->deptName->Required = true; // Required field
        $this->deptName->setSelectMultiple(false); // Select one
        $this->deptName->UsePleaseSelect = true; // Use PleaseSelect by default
        $this->deptName->PleaseSelectText = $Language->phrase("PleaseSelect"); // "PleaseSelect" text
        $this->deptName->Lookup = new Lookup($this->deptName, 'specialfiles', false, 'ዕዝ', ["ዕዝ","","",""], '', '', [], [], [], [], [], [], false, '', '', "`ዕዝ`");
        $this->deptName->SearchOperators = ["=", "<>"];
        $this->deptName->SourceTableVar = 'appeal';
        $this->Fields['deptName'] = &$this->deptName;

        // halafinet
        $this->halafinet = new ReportField(
            $this, // Table
            'x_halafinet', // Variable name
            'halafinet', // Name
            '`halafinet`', // Expression
            '`halafinet`', // Basic search expression
            200, // Type
            255, // Size
            -1, // Date/Time format
            false, // Is upload field
            '`halafinet`', // Virtual expression
            false, // Is virtual
            false, // Force selection
            false, // Is Virtual search
            'FORMATTED TEXT', // View Tag
            'TEXT' // Edit Tag
        );
        $this->halafinet->InputTextType = "text";
        $this->halafinet->Nullable = false; // NOT NULL field
        $this->halafinet->Required = true; // Required field
        $this->halafinet->SearchOperators = ["=", "<>", "IN", "NOT IN", "STARTS WITH", "NOT STARTS WITH", "LIKE", "NOT LIKE", "ENDS WITH", "NOT ENDS WITH", "IS EMPTY", "IS NOT EMPTY"];
        $this->halafinet->SourceTableVar = 'appeal';
        $this->Fields['halafinet'] = &$this->halafinet;

        // crimstate
        $this->crimstate = new ReportField(
            $this, // Table
            'x_crimstate', // Variable name
            'crimstate', // Name
            '`crimstate`', // Expression
            '`crimstate`', // Basic search expression
            200, // Type
            255, // Size
            -1, // Date/Time format
            false, // Is upload field
            '`crimstate`', // Virtual expression
            false, // Is virtual
            false, // Force selection
            false, // Is Virtual search
            'FORMATTED TEXT', // View Tag
            'TEXT' // Edit Tag
        );
        $this->crimstate->InputTextType = "text";
        $this->crimstate->Nullable = false; // NOT NULL field
        $this->crimstate->Required = true; // Required field
        $this->crimstate->SearchOperators = ["=", "<>", "IN", "NOT IN", "STARTS WITH", "NOT STARTS WITH", "LIKE", "NOT LIKE", "ENDS WITH", "NOT ENDS WITH", "IS EMPTY", "IS NOT EMPTY"];
        $this->crimstate->SourceTableVar = 'appeal';
        $this->Fields['crimstate'] = &$this->crimstate;

        // Description
        $this->Description = new ReportField(
            $this, // Table
            'x_Description', // Variable name
            'Description', // Name
            '`Description`', // Expression
            '`Description`', // Basic search expression
            200, // Type
            65535, // Size
            -1, // Date/Time format
            false, // Is upload field
            '`Description`', // Virtual expression
            false, // Is virtual
            false, // Force selection
            false, // Is Virtual search
            'FORMATTED TEXT', // View Tag
            'TEXT' // Edit Tag
        );
        $this->Description->InputTextType = "text";
        $this->Description->Nullable = false; // NOT NULL field
        $this->Description->Required = true; // Required field
        $this->Description->SearchOperators = ["=", "<>", "IN", "NOT IN", "STARTS WITH", "NOT STARTS WITH", "LIKE", "NOT LIKE", "ENDS WITH", "NOT ENDS WITH", "IS EMPTY", "IS NOT EMPTY"];
        $this->Description->SourceTableVar = 'appeal';
        $this->Fields['Description'] = &$this->Description;

        // midib
        $this->midib = new ReportField(
            $this, // Table
            'x_midib', // Variable name
            'midib', // Name
            '`midib`', // Expression
            '`midib`', // Basic search expression
            200, // Type
            255, // Size
            -1, // Date/Time format
            false, // Is upload field
            '`midib`', // Virtual expression
            false, // Is virtual
            false, // Force selection
            false, // Is Virtual search
            'FORMATTED TEXT', // View Tag
            'SELECT' // Edit Tag
        );
        $this->midib->InputTextType = "text";
        $this->midib->Nullable = false; // NOT NULL field
        $this->midib->Required = true; // Required field
        $this->midib->setSelectMultiple(false); // Select one
        $this->midib->UsePleaseSelect = true; // Use PleaseSelect by default
        $this->midib->PleaseSelectText = $Language->phrase("PleaseSelect"); // "PleaseSelect" text
        $this->midib->Lookup = new Lookup($this->midib, 'specialfiles', false, 'ዕዝ', ["የችሎትስም","","",""], '', '', [], [], [], [], [], [], false, '', '', "`የችሎትስም`");
        $this->midib->SearchOperators = ["=", "<>"];
        $this->midib->SourceTableVar = 'appeal';
        $this->Fields['midib'] = &$this->midib;

        // appealask
        $this->appealask = new ReportField(
            $this, // Table
            'x_appealask', // Variable name
            'appealask', // Name
            '`appealask`', // Expression
            '`appealask`', // Basic search expression
            200, // Type
            255, // Size
            -1, // Date/Time format
            false, // Is upload field
            '`appealask`', // Virtual expression
            false, // Is virtual
            false, // Force selection
            false, // Is Virtual search
            'FORMATTED TEXT', // View Tag
            'SELECT' // Edit Tag
        );
        $this->appealask->InputTextType = "text";
        $this->appealask->Nullable = false; // NOT NULL field
        $this->appealask->Required = true; // Required field
        $this->appealask->setSelectMultiple(false); // Select one
        $this->appealask->UsePleaseSelect = true; // Use PleaseSelect by default
        $this->appealask->PleaseSelectText = $Language->phrase("PleaseSelect"); // "PleaseSelect" text
        $this->appealask->Lookup = new Lookup($this->appealask, 'Crosstab3', false, '', ["","","",""], '', '', [], [], [], [], [], [], false, '', '', "");
        $this->appealask->OptionCount = 4;
        $this->appealask->SearchOperators = ["=", "<>"];
        $this->appealask->SourceTableVar = 'appeal';
        $this->Fields['appealask'] = &$this->appealask;

        // AppealDescription
        $this->AppealDescription = new ReportField(
            $this, // Table
            'x_AppealDescription', // Variable name
            'AppealDescription', // Name
            '`AppealDescription`', // Expression
            '`AppealDescription`', // Basic search expression
            200, // Type
            65535, // Size
            -1, // Date/Time format
            false, // Is upload field
            '`AppealDescription`', // Virtual expression
            false, // Is virtual
            false, // Force selection
            false, // Is Virtual search
            'FORMATTED TEXT', // View Tag
            'SELECT' // Edit Tag
        );
        $this->AppealDescription->InputTextType = "text";
        $this->AppealDescription->Nullable = false; // NOT NULL field
        $this->AppealDescription->Required = true; // Required field
        $this->AppealDescription->setSelectMultiple(false); // Select one
        $this->AppealDescription->UsePleaseSelect = true; // Use PleaseSelect by default
        $this->AppealDescription->PleaseSelectText = $Language->phrase("PleaseSelect"); // "PleaseSelect" text
        $this->AppealDescription->Lookup = new Lookup($this->AppealDescription, 'Crosstab3', false, '', ["","","",""], '', '', [], [], [], [], [], [], false, '', '', "");
        $this->AppealDescription->OptionCount = 3;
        $this->AppealDescription->SearchOperators = ["=", "<>"];
        $this->AppealDescription->SourceTableVar = 'appeal';
        $this->Fields['AppealDescription'] = &$this->AppealDescription;

        // appealDecision
        $this->appealDecision = new ReportField(
            $this, // Table
            'x_appealDecision', // Variable name
            'appealDecision', // Name
            '`appealDecision`', // Expression
            '`appealDecision`', // Basic search expression
            200, // Type
            255, // Size
            -1, // Date/Time format
            false, // Is upload field
            '`appealDecision`', // Virtual expression
            false, // Is virtual
            false, // Force selection
            false, // Is Virtual search
            'FORMATTED TEXT', // View Tag
            'SELECT' // Edit Tag
        );
        $this->appealDecision->InputTextType = "text";
        $this->appealDecision->Nullable = false; // NOT NULL field
        $this->appealDecision->Required = true; // Required field
        $this->appealDecision->setSelectMultiple(false); // Select one
        $this->appealDecision->UsePleaseSelect = true; // Use PleaseSelect by default
        $this->appealDecision->PleaseSelectText = $Language->phrase("PleaseSelect"); // "PleaseSelect" text
        $this->appealDecision->Lookup = new Lookup($this->appealDecision, 'Crosstab3', false, '', ["","","",""], '', '', [], [], [], [], [], [], false, '', '', "");
        $this->appealDecision->OptionCount = 6;
        $this->appealDecision->SearchOperators = ["=", "<>"];
        $this->appealDecision->SourceTableVar = 'appeal';
        $this->Fields['appealDecision'] = &$this->appealDecision;

        // created_at
        $this->created_at = new ReportField(
            $this, // Table
            'x_created_at', // Variable name
            'created_at', // Name
            '`created_at`', // Expression
            CastDateFieldForLike("`created_at`", 0, "DB"), // Basic search expression
            135, // Type
            19, // Size
            0, // Date/Time format
            false, // Is upload field
            '`created_at`', // Virtual expression
            false, // Is virtual
            false, // Force selection
            false, // Is Virtual search
            'FORMATTED TEXT', // View Tag
            'TEXT' // Edit Tag
        );
        $this->created_at->InputTextType = "text";
        $this->created_at->Raw = true;
        $this->created_at->DefaultErrorMessage = str_replace("%s", $GLOBALS["DATE_FORMAT"], $Language->phrase("IncorrectDate"));
        $this->created_at->SearchOperators = ["=", "<>", "IN", "NOT IN", "<", "<=", ">", ">=", "BETWEEN", "NOT BETWEEN", "IS NULL", "IS NOT NULL"];
        $this->created_at->SourceTableVar = 'appeal';
        $this->Fields['created_at'] = &$this->created_at;

        // crimeDate
        $this->crimeDate = new ReportField(
            $this, // Table
            'x_crimeDate', // Variable name
            'crimeDate', // Name
            '`crimeDate`', // Expression
            CastDateFieldForLike("`crimeDate`", 0, "DB"), // Basic search expression
            135, // Type
            19, // Size
            0, // Date/Time format
            false, // Is upload field
            '`crimeDate`', // Virtual expression
            false, // Is virtual
            false, // Force selection
            false, // Is Virtual search
            'FORMATTED TEXT', // View Tag
            'TEXT' // Edit Tag
        );
        $this->crimeDate->InputTextType = "text";
        $this->crimeDate->Raw = true;
        $this->crimeDate->Nullable = false; // NOT NULL field
        $this->crimeDate->Required = true; // Required field
        $this->crimeDate->DefaultErrorMessage = str_replace("%s", $GLOBALS["DATE_FORMAT"], $Language->phrase("IncorrectDate"));
        $this->crimeDate->SearchOperators = ["=", "<>", "IN", "NOT IN", "<", "<=", ">", ">=", "BETWEEN", "NOT BETWEEN"];
        $this->crimeDate->SourceTableVar = 'appeal';
        $this->Fields['crimeDate'] = &$this->crimeDate;

        // updated_at
        $this->updated_at = new ReportField(
            $this, // Table
            'x_updated_at', // Variable name
            'updated_at', // Name
            '`updated_at`', // Expression
            CastDateFieldForLike("`updated_at`", 0, "DB"), // Basic search expression
            135, // Type
            19, // Size
            0, // Date/Time format
            false, // Is upload field
            '`updated_at`', // Virtual expression
            false, // Is virtual
            false, // Force selection
            false, // Is Virtual search
            'FORMATTED TEXT', // View Tag
            'TEXT' // Edit Tag
        );
        $this->updated_at->addMethod("getAutoUpdateValue", fn() => CurrentDate());
        $this->updated_at->InputTextType = "text";
        $this->updated_at->Raw = true;
        $this->updated_at->DefaultErrorMessage = str_replace("%s", $GLOBALS["DATE_FORMAT"], $Language->phrase("IncorrectDate"));
        $this->updated_at->SearchOperators = ["=", "<>", "IN", "NOT IN", "<", "<=", ">", ">=", "BETWEEN", "NOT BETWEEN", "IS NULL", "IS NOT NULL"];
        $this->updated_at->SourceTableVar = 'appeal';
        $this->Fields['updated_at'] = &$this->updated_at;

        // updated_by
        $this->updated_by = new ReportField(
            $this, // Table
            'x_updated_by', // Variable name
            'updated_by', // Name
            '`updated_by`', // Expression
            '`updated_by`', // Basic search expression
            3, // Type
            255, // Size
            -1, // Date/Time format
            false, // Is upload field
            '`updated_by`', // Virtual expression
            false, // Is virtual
            false, // Force selection
            false, // Is Virtual search
            'FORMATTED TEXT', // View Tag
            'TEXT' // Edit Tag
        );
        $this->updated_by->addMethod("getAutoUpdateValue", fn() => CurrentUserName());
        $this->updated_by->InputTextType = "text";
        $this->updated_by->Raw = true;
        $this->updated_by->Nullable = false; // NOT NULL field
        $this->updated_by->DefaultErrorMessage = $Language->phrase("IncorrectInteger");
        $this->updated_by->SearchOperators = ["=", "<>", "IN", "NOT IN", "<", "<=", ">", ">=", "BETWEEN", "NOT BETWEEN"];
        $this->updated_by->SourceTableVar = 'appeal';
        $this->Fields['updated_by'] = &$this->updated_by;

        // id
        $this->id = new ReportField(
            $this, // Table
            'x_id', // Variable name
            'id', // Name
            '`id`', // Expression
            '`id`', // Basic search expression
            21, // Type
            20, // Size
            -1, // Date/Time format
            false, // Is upload field
            '`id`', // Virtual expression
            false, // Is virtual
            false, // Force selection
            false, // Is Virtual search
            'FORMATTED TEXT', // View Tag
            'NO' // Edit Tag
        );
        $this->id->InputTextType = "text";
        $this->id->Raw = true;
        $this->id->IsAutoIncrement = true; // Autoincrement field
        $this->id->IsPrimaryKey = true; // Primary key field
        $this->id->Nullable = false; // NOT NULL field
        $this->id->Sortable = false; // Allow sort
        $this->id->DefaultErrorMessage = $Language->phrase("IncorrectInteger");
        $this->id->SearchOperators = ["=", "<>", "IN", "NOT IN", "<", "<=", ">", ">=", "BETWEEN", "NOT BETWEEN"];
        $this->id->SourceTableVar = 'appeal';
        $this->Fields['id'] = &$this->id;

        // YEAR__appealDate
        $this->YEAR__appealDate = new ReportField($this, 'x_YEAR__appealDate', 'YEAR__appealDate', 'YEAR(`appealDate`)', '', 3, -1, -1, false, '', false, false, false);
        $this->YEAR__appealDate->Sortable = false;
        $this->YEAR__appealDate->Caption = $Language->phrase("Year");
        $this->Fields['YEAR__appealDate'] = &$this->YEAR__appealDate;

        // Add Doctrine Cache
        $this->Cache = new \Symfony\Component\Cache\Adapter\ArrayAdapter();
        $this->CacheProfile = new \Doctrine\DBAL\Cache\QueryCacheProfile(0, $this->TableVar);

        // Call Table Load event
        $this->tableLoad();
    }

    // Field Visibility
    public function getFieldVisibility($fldParm)
    {
        global $Security;
        return $this->$fldParm->Visible; // Returns original value
    }

    // Single column sort
    protected function updateSort(&$fld)
    {
        if ($this->CurrentOrder == $fld->Name) {
            $sortField = $fld->Expression;
            $lastSort = $fld->getSort();
            if (in_array($this->CurrentOrderType, ["ASC", "DESC", "NO"])) {
                $curSort = $this->CurrentOrderType;
            } else {
                $curSort = $lastSort;
            }
            $fld->setSort($curSort);
            $lastOrderBy = in_array($lastSort, ["ASC", "DESC"]) ? $sortField . " " . $lastSort : "";
            $curOrderBy = in_array($curSort, ["ASC", "DESC"]) ? $sortField . " " . $curSort : "";
            if ($fld->GroupingFieldId == 0) {
                $this->setDetailOrderBy($curOrderBy); // Save to Session
            }
        } else {
            if ($fld->GroupingFieldId == 0) {
                $fld->setSort("");
            }
        }
    }

    // Get Sort SQL
    protected function sortSql()
    {
        $dtlSortSql = $this->getDetailOrderBy(); // Get ORDER BY for detail fields from session
        $argrps = [];
        foreach ($this->Fields as $fld) {
            if (in_array($fld->getSort(), ["ASC", "DESC"])) {
                $fldsql = $fld->Expression;
                if ($fld->GroupingFieldId > 0) {
                    if ($fld->GroupSql != "") {
                        $argrps[$fld->GroupingFieldId] = str_replace("%s", $fldsql, $fld->GroupSql) . " " . $fld->getSort();
                    } else {
                        $argrps[$fld->GroupingFieldId] = $fldsql . " " . $fld->getSort();
                    }
                }
            }
        }
        $sortSql = "";
        foreach ($argrps as $grp) {
            if ($sortSql != "") {
                $sortSql .= ", ";
            }
            $sortSql .= $grp;
        }
        if ($dtlSortSql != "") {
            if ($sortSql != "") {
                $sortSql .= ", ";
            }
            $sortSql .= $dtlSortSql;
        }
        return $sortSql;
    }

    // Table Level Group SQL
    private $sqlFirstGroupField = "";
    private $sqlSelectGroup = null;
    private $sqlOrderByGroup = "";

    // First Group Field
    public function getSqlFirstGroupField($alias = false)
    {
        if ($this->sqlFirstGroupField != "") {
            return $this->sqlFirstGroupField;
        }
        $firstGroupField = &$this->rank;
        $expr = $firstGroupField->Expression;
        if ($firstGroupField->GroupSql != "") {
            $expr = str_replace("%s", $firstGroupField->Expression, $firstGroupField->GroupSql);
            if ($alias) {
                $expr .= " AS " . QuotedName($firstGroupField->getGroupName(), $this->Dbid);
            }
        }
        return $expr;
    }

    public function setSqlFirstGroupField($v)
    {
        $this->sqlFirstGroupField = $v;
    }

    // Select Group
    public function getSqlSelectGroup()
    {
        return $this->sqlSelectGroup ?? $this->getQueryBuilder()->select($this->getSqlFirstGroupField(true))->distinct();
    }

    public function setSqlSelectGroup($v)
    {
        $this->sqlSelectGroup = $v;
    }

    // Order By Group
    public function getSqlOrderByGroup()
    {
        if ($this->sqlOrderByGroup != "") {
            return $this->sqlOrderByGroup;
        }
        return $this->getSqlFirstGroupField() . " ASC";
    }

    public function setSqlOrderByGroup($v)
    {
        $this->sqlOrderByGroup = $v;
    }

    // Crosstab properties
    private $sqlSelectAggregate = null;
    private $sqlGroupByAggregate = "";

    // Select Aggregate
    public function getSqlSelectAggregate()
    {
        return $this->sqlSelectAggregate ?? $this->getQueryBuilder()->select("YEAR(`appealDate`) AS YEAR__appealDate");
    }

    public function setSqlSelectAggregate($v)
    {
        $this->sqlSelectAggregate = $v;
    }

    // Group By Aggregate
    public function getSqlGroupByAggregate()
    {
        return ($this->sqlGroupByAggregate != "") ? $this->sqlGroupByAggregate : "YEAR(`appealDate`)";
    }

    public function setSqlGroupByAggregate($v)
    {
        $this->sqlGroupByAggregate = $v;
    }

    // Table level SQL
    private $columnField = "";
    private $columnDateType = "";
    private $columnValues = "";
    private $sqlCrosstabYear = "";
    public $Columns;
    public $ColumnCount;
    public $Col;
    public $DistinctColumnFields = "";
    private $columnLoaded = false;

    // Column field
    public function getColumnField()
    {
        return ($this->columnField != "") ? $this->columnField : "`appealDate`";
    }

    public function setColumnField($v)
    {
        $this->columnField = $v;
    }

    // Column date type
    public function getColumnDateType()
    {
        return ($this->columnDateType != "") ? $this->columnDateType : "m";
    }

    public function setColumnDateType($v)
    {
        $this->columnDateType = $v;
    }

    // Column values
    public function getColumnValues()
    {
        return ($this->columnValues != "") ? $this->columnValues : "1,2,3,4,5,6,7,8,9,10,11,12";
    }

    public function setColumnValues($v)
    {
        $this->columnValues = $v;
    }

    // Crosstab Year
    public function getSqlCrosstabYear()
    {
        return ($this->sqlCrosstabYear != "") ? $this->sqlCrosstabYear : "SELECT DISTINCT YEAR(`appealDate`) AS YEAR__appealDate FROM appeal ORDER BY YEAR(`appealDate`)";
    }

    public function setSqlCrosstabYear($v)
    {
        $this->sqlCrosstabYear = $v;
    }

    // Load column values
    public function loadColumnValues($filter = "")
    {
        global $Language;

        // Data already loaded, return
        if ($this->columnLoaded) {
            return;
        }
        $conn = $this->getConnection();
        $arColumnValues = explode(",", $this->getColumnValues());

        // Get distinct column count
        $this->ColumnCount = count($arColumnValues);
        $this->Columns = Init2DArray($this->ColumnCount + 1, 2, null);
        for ($colcnt = 1; $colcnt <= $this->ColumnCount; $colcnt++)
            $this->Columns[$colcnt] = new CrosstabColumn(MonthName($arColumnValues[$colcnt - 1]), $arColumnValues[$colcnt - 1], true);

        // 1st dimension = no of groups (level 0 used for grand total)
        // 2nd dimension = no of distinct values
        $groupCount = 1;
        $this->SummaryFields[0] = new SummaryField('x_name', 'name', '`name`', 'COUNT');
        $this->SummaryFields[0]->SummaryCaption = $Language->phrase("RptCnt");
        $this->SummaryFields[0]->SummaryValues = InitArray($this->ColumnCount + 1, null);
        $this->SummaryFields[0]->SummaryValueCounts = InitArray($this->ColumnCount + 1, null);
        $this->SummaryFields[0]->SummaryInitValue = 0;

        // Update crosstab SQL
        $sqlFlds = "";
        $cnt = count($this->SummaryFields);
        for ($is = 0; $is < $cnt; $is++) {
            $smry = &$this->SummaryFields[$is];
            for ($i = 0; $i < $this->ColumnCount; $i++) {
                $fld = CrosstabFieldExpression($smry->SummaryType, $smry->Expression,
                    $this->getColumnField(), $this->getColumnDateType(), $arColumnValues[$i], "", "C" . $arColumnValues[$i] . "F" . $is, $this->Dbid);
                if ($sqlFlds != "") {
                    $sqlFlds .= ", ";
                }
                $sqlFlds .= $fld;
            }
        }
        $this->DistinctColumnFields = $sqlFlds ?: "NULL"; // In case ColumnCount = 0
        $this->columnLoaded = true;
    }

    // Render for lookup
    public function renderLookup()
    {
    }

    // Render X Axis for chart
    public function renderChartXAxis($chartVar, $chartRow)
    {
        return $chartRow;
    }

    // Get FROM clause
    public function getSqlFrom()
    {
        return ($this->SqlFrom != "") ? $this->SqlFrom : "appeal";
    }

    // Get FROM clause (for backward compatibility)
    public function sqlFrom()
    {
        return $this->getSqlFrom();
    }

    // Set FROM clause
    public function setSqlFrom($v)
    {
        $this->SqlFrom = $v;
    }

    // Get SELECT clause
    public function getSqlSelect() // Select
    {
        return $this->SqlSelect ?? $this->getQueryBuilder()->select($this->sqlSelectFields());
    }

    // Get list of fields
    private function sqlSelectFields()
    {
        return "`rank`, YEAR(`appealDate`) AS YEAR__appealDate";
    }

    // Get SELECT clause (for backward compatibility)
    public function sqlSelect()
    {
        return $this->getSqlSelect();
    }

    // Set SELECT clause
    public function setSqlSelect($v)
    {
        $this->SqlSelect = $v;
    }

    // Get WHERE clause
    public function getSqlWhere()
    {
        $where = ($this->SqlWhere != "") ? $this->SqlWhere : "";
        $this->DefaultFilter = "";
        AddFilter($where, $this->DefaultFilter);
        return $where;
    }

    // Get WHERE clause (for backward compatibility)
    public function sqlWhere()
    {
        return $this->getSqlWhere();
    }

    // Set WHERE clause
    public function setSqlWhere($v)
    {
        $this->SqlWhere = $v;
    }

    // Get GROUP BY clause
    public function getSqlGroupBy()
    {
        return $this->SqlGroupBy != "" ? $this->SqlGroupBy : "`rank`, YEAR(`appealDate`)";
    }

    // Get GROUP BY clause (for backward compatibility)
    public function sqlGroupBy()
    {
        return $this->getSqlGroupBy();
    }

    // set GROUP BY clause
    public function setSqlGroupBy($v)
    {
        $this->SqlGroupBy = $v;
    }

    // Get HAVING clause
    public function getSqlHaving() // Having
    {
        return ($this->SqlHaving != "") ? $this->SqlHaving : "";
    }

    // Get HAVING clause (for backward compatibility)
    public function sqlHaving()
    {
        return $this->getSqlHaving();
    }

    // Set HAVING clause
    public function setSqlHaving($v)
    {
        $this->SqlHaving = $v;
    }

    // Get ORDER BY clause
    public function getSqlOrderBy()
    {
        return ($this->SqlOrderBy != "") ? $this->SqlOrderBy : "";
    }

    // Get ORDER BY clause (for backward compatibility)
    public function sqlOrderBy()
    {
        return $this->getSqlOrderBy();
    }

    // set ORDER BY clause
    public function setSqlOrderBy($v)
    {
        $this->SqlOrderBy = $v;
    }

    // Apply User ID filters
    public function applyUserIDFilters($filter, $id = "")
    {
        return $filter;
    }

    // Check if User ID security allows view all
    public function userIDAllow($id = "")
    {
        $allow = $this->UserIDAllowSecurity;
        switch ($id) {
            case "add":
            case "copy":
            case "gridadd":
            case "register":
            case "addopt":
                return ($allow & Allow::ADD->value) == Allow::ADD->value;
            case "edit":
            case "gridedit":
            case "update":
            case "changepassword":
            case "resetpassword":
                return ($allow & Allow::EDIT->value) == Allow::EDIT->value;
            case "delete":
                return ($allow & Allow::DELETE->value) == Allow::DELETE->value;
            case "view":
                return ($allow & Allow::VIEW->value) == Allow::VIEW->value;
            case "search":
                return ($allow & Allow::SEARCH->value) == Allow::SEARCH->value;
            case "lookup":
                return ($allow & Allow::LOOKUP->value) == Allow::LOOKUP->value;
            default:
                return ($allow & Allow::LIST->value) == Allow::LIST->value;
        }
    }

    /**
     * Get record count
     *
     * @param string|QueryBuilder $sql SQL or QueryBuilder
     * @param mixed $c Connection
     * @return int
     */
    public function getRecordCount($sql, $c = null)
    {
        $cnt = -1;
        $sqlwrk = $sql instanceof QueryBuilder // Query builder
            ? (clone $sql)->resetQueryPart("orderBy")->getSQL()
            : $sql;
        $pattern = '/^SELECT\s([\s\S]+)\sFROM\s/i';
        // Skip Custom View / SubQuery / SELECT DISTINCT / ORDER BY
        if (
            in_array($this->TableType, ["TABLE", "VIEW", "LINKTABLE"]) &&
            preg_match($pattern, $sqlwrk) &&
            !preg_match('/\(\s*(SELECT[^)]+)\)/i', $sqlwrk) &&
            !preg_match('/^\s*SELECT\s+DISTINCT\s+/i', $sqlwrk) &&
            !preg_match('/\s+ORDER\s+BY\s+/i', $sqlwrk)
        ) {
            $sqlcnt = "SELECT COUNT(*) FROM " . preg_replace($pattern, "", $sqlwrk);
        } else {
            $sqlcnt = "SELECT COUNT(*) FROM (" . $sqlwrk . ") COUNT_TABLE";
        }
        $conn = $c ?? $this->getConnection();
        $cnt = $conn->fetchOne($sqlcnt);
        if ($cnt !== false) {
            return (int)$cnt;
        }
        // Unable to get count by SELECT COUNT(*), execute the SQL to get record count directly
        $result = $conn->executeQuery($sqlwrk);
        $cnt = $result->rowCount();
        if ($cnt == 0) { // Unable to get record count, count directly
            while ($result->fetch()) {
                $cnt++;
            }
        }
        return $cnt;
    }

    // Record filter WHERE clause
    protected function sqlKeyFilter()
    {
        return "`id` = @id@";
    }

    // Get Key
    public function getKey($current = false, $keySeparator = null)
    {
        $keys = [];
        $val = $current ? $this->id->CurrentValue : $this->id->OldValue;
        if (EmptyValue($val)) {
            return "";
        } else {
            $keys[] = $val;
        }
        $keySeparator ??= Config("COMPOSITE_KEY_SEPARATOR");
        return implode($keySeparator, $keys);
    }

    // Set Key
    public function setKey($key, $current = false, $keySeparator = null)
    {
        $keySeparator ??= Config("COMPOSITE_KEY_SEPARATOR");
        $this->OldKey = strval($key);
        $keys = explode($keySeparator, $this->OldKey);
        if (count($keys) == 1) {
            if ($current) {
                $this->id->CurrentValue = $keys[0];
            } else {
                $this->id->OldValue = $keys[0];
            }
        }
    }

    // Get record filter
    public function getRecordFilter($row = null, $current = false)
    {
        $keyFilter = $this->sqlKeyFilter();
        if (is_array($row)) {
            $val = array_key_exists('id', $row) ? $row['id'] : null;
        } else {
            $val = !EmptyValue($this->id->OldValue) && !$current ? $this->id->OldValue : $this->id->CurrentValue;
        }
        if (!is_numeric($val)) {
            return "0=1"; // Invalid key
        }
        if ($val === null) {
            return "0=1"; // Invalid key
        } else {
            $keyFilter = str_replace("@id@", AdjustSql($val, $this->Dbid), $keyFilter); // Replace key value
        }
        return $keyFilter;
    }

    // Return page URL
    public function getReturnUrl()
    {
        $referUrl = ReferUrl();
        $referPageName = ReferPageName();
        $name = PROJECT_NAME . "_" . $this->TableVar . "_" . Config("TABLE_RETURN_URL");
        // Get referer URL automatically
        if ($referUrl != "" && $referPageName != CurrentPageName() && $referPageName != "login") { // Referer not same page or login page
            $_SESSION[$name] = $referUrl; // Save to Session
        }
        return $_SESSION[$name] ?? GetUrl("");
    }

    // Set return page URL
    public function setReturnUrl($v)
    {
        $_SESSION[PROJECT_NAME . "_" . $this->TableVar . "_" . Config("TABLE_RETURN_URL")] = $v;
    }

    // Get modal caption
    public function getModalCaption($pageName)
    {
        global $Language;
        return match ($pageName) {
            "" => $Language->phrase("View"),
            "" => $Language->phrase("Edit"),
            "" => $Language->phrase("Add"),
            default => ""
        };
    }

    // Default route URL
    public function getDefaultRouteUrl()
    {
        return "Crosstab3";
    }

    // API page name
    public function getApiPageName($action)
    {
        return "Crosstab3Crosstab";
    }

    // Current URL
    public function getCurrentUrl($parm = "")
    {
        $url = CurrentPageUrl(false);
        if ($parm != "") {
            $url = $this->keyUrl($url, $parm);
        } else {
            $url = $this->keyUrl($url, Config("TABLE_SHOW_DETAIL") . "=");
        }
        return $this->addMasterUrl($url);
    }

    // List URL
    public function getListUrl()
    {
        return "";
    }

    // View URL
    public function getViewUrl($parm = "")
    {
        if ($parm != "") {
            $url = $this->keyUrl("", $parm);
        } else {
            $url = $this->keyUrl("", Config("TABLE_SHOW_DETAIL") . "=");
        }
        return $this->addMasterUrl($url);
    }

    // Add URL
    public function getAddUrl($parm = "")
    {
        if ($parm != "") {
            $url = "?" . $parm;
        } else {
            $url = "";
        }
        return $this->addMasterUrl($url);
    }

    // Edit URL
    public function getEditUrl($parm = "")
    {
        $url = $this->keyUrl("", $parm);
        return $this->addMasterUrl($url);
    }

    // Inline edit URL
    public function getInlineEditUrl()
    {
        $url = $this->keyUrl("", "action=edit");
        return $this->addMasterUrl($url);
    }

    // Copy URL
    public function getCopyUrl($parm = "")
    {
        $url = $this->keyUrl("", $parm);
        return $this->addMasterUrl($url);
    }

    // Inline copy URL
    public function getInlineCopyUrl()
    {
        $url = $this->keyUrl("", "action=copy");
        return $this->addMasterUrl($url);
    }

    // Delete URL
    public function getDeleteUrl($parm = "")
    {
        if ($this->UseAjaxActions && ConvertToBool(Param("infinitescroll")) && CurrentPageID() == "list") {
            return $this->keyUrl(GetApiUrl(Config("API_DELETE_ACTION") . "/" . $this->TableVar));
        } else {
            return $this->keyUrl("", $parm);
        }
    }

    // Add master url
    public function addMasterUrl($url)
    {
        return $url;
    }

    public function keyToJson($htmlEncode = false)
    {
        $json = "";
        $json .= "\"id\":" . VarToJson($this->id->CurrentValue, "number");
        $json = "{" . $json . "}";
        if ($htmlEncode) {
            $json = HtmlEncode($json);
        }
        return $json;
    }

    // Add key value to URL
    public function keyUrl($url, $parm = "")
    {
        if ($this->id->CurrentValue !== null) {
            $url .= "/" . $this->encodeKeyValue($this->id->CurrentValue);
        } else {
            return "javascript:ew.alert(ew.language.phrase('InvalidRecord'));";
        }
        if ($parm != "") {
            $url .= "?" . $parm;
        }
        return $url;
    }

    // Render sort
    public function renderFieldHeader($fld)
    {
        global $Security, $Language;
        $sortUrl = "";
        $attrs = "";
        if ($this->PageID != "grid" && $fld->Sortable) {
            $sortUrl = $this->sortUrl($fld);
            $attrs = ' role="button" data-ew-action="sort" data-ajax="' . ($this->UseAjaxActions ? "true" : "false") . '" data-sort-url="' . $sortUrl . '" data-sort-type="1"';
            if ($this->ContextClass) { // Add context
                $attrs .= ' data-context="' . HtmlEncode($this->ContextClass) . '"';
            }
        }
        $html = '<div class="ew-table-header-caption"' . $attrs . '>' . $fld->caption() . '</div>';
        if ($sortUrl) {
            $html .= '<div class="ew-table-header-sort">' . $fld->getSortIcon() . '</div>';
        }
        if ($this->PageID != "grid" && !$this->isExport() && $fld->UseFilter && $Security->canSearch()) {
            $html .= '<div class="ew-filter-dropdown-btn" data-ew-action="filter" data-table="' . $fld->TableVar . '" data-field="' . $fld->FieldVar .
                '"><div class="ew-table-header-filter" role="button" aria-haspopup="true">' . $Language->phrase("Filter") .
                (is_array($fld->EditValue) ? str_replace("%c", count($fld->EditValue), $Language->phrase("FilterCount")) : '') .
                '</div></div>';
        }
        $html = '<div class="ew-table-header-btn">' . $html . '</div>';
        if ($this->UseCustomTemplate) {
            $scriptId = str_replace("{id}", $fld->TableVar . "_" . $fld->Param, "tpc_{id}");
            $html = '<template id="' . $scriptId . '">' . $html . '</template>';
        }
        return $html;
    }

    // Sort URL
    public function sortUrl($fld)
    {
        global $DashboardReport;
        if (
            $this->CurrentAction || $this->isExport() ||
            $this->DrillDown ||
            in_array($fld->Type, [128, 204, 205])
        ) { // Unsortable data type
                return "";
        } elseif ($fld->Sortable) {
            $urlParm = "order=" . urlencode($fld->Name) . "&amp;ordertype=" . $fld->getNextSort();
            if ($DashboardReport) {
                $urlParm .= "&amp;" . Config("PAGE_DASHBOARD") . "=" . $DashboardReport;
            }
            return $this->addMasterUrl($this->CurrentPageName . "?" . $urlParm);
        } else {
            return "";
        }
    }

    // Get record keys from Post/Get/Session
    public function getRecordKeys()
    {
        $arKeys = [];
        $arKey = [];
        if (Param("key_m") !== null) {
            $arKeys = Param("key_m");
            $cnt = count($arKeys);
        } else {
            $isApi = IsApi();
            $keyValues = $isApi
                ? (Route(0) == "export"
                    ? array_map(fn ($i) => Route($i + 3), range(0, 0))  // Export API
                    : array_map(fn ($i) => Route($i + 2), range(0, 0))) // Other API
                : []; // Non-API
            if (($keyValue = Param("id") ?? Route("id")) !== null) {
                $arKeys[] = $keyValue;
            } elseif ($isApi && (($keyValue = Key(0) ?? $keyValues[0] ?? null) !== null)) {
                $arKeys[] = $keyValue;
            } else {
                $arKeys = null; // Do not setup
            }
        }
        // Check keys
        $ar = [];
        if (is_array($arKeys)) {
            foreach ($arKeys as $key) {
                if (!is_numeric($key)) {
                    continue;
                }
                $ar[] = $key;
            }
        }
        return $ar;
    }

    // Get filter from records
    public function getFilterFromRecords($rows)
    {
        $keyFilter = "";
        foreach ($rows as $row) {
            if ($keyFilter != "") {
                $keyFilter .= " OR ";
            }
            $keyFilter .= "(" . $this->getRecordFilter($row) . ")";
        }
        return $keyFilter;
    }

    // Get filter from record keys
    public function getFilterFromRecordKeys($setCurrent = true)
    {
        $arKeys = $this->getRecordKeys();
        $keyFilter = "";
        foreach ($arKeys as $key) {
            if ($keyFilter != "") {
                $keyFilter .= " OR ";
            }
            if ($setCurrent) {
                $this->id->CurrentValue = $key;
            } else {
                $this->id->OldValue = $key;
            }
            $keyFilter .= "(" . $this->getRecordFilter() . ")";
        }
        return $keyFilter;
    }

    // Load result set based on filter/sort
    public function loadRs($filter, $sort = "")
    {
        $sql = $this->getSql($filter, $sort); // Set up filter (WHERE Clause) / sort (ORDER BY Clause)
        $conn = $this->getConnection();
        return $conn->executeQuery($sql);
    }

    // Get file data
    public function getFileData($fldparm, $key, $resize, $width = 0, $height = 0, $plugins = [])
    {
        global $DownloadFileName;

        // No binary fields
        return false;
    }

    // Table level events

    // Table Load event
    public function tableLoad()
    {
        // Enter your code here
    }

    // Email Sending event
    public function emailSending($email, $args)
    {
        //var_dump($email, $args); exit();
        return true;
    }

    // Lookup Selecting event
    public function lookupSelecting($fld, &$filter)
    {
        //var_dump($fld->Name, $fld->Lookup, $filter); // Uncomment to view the filter
        // Enter your code here
    }

    // Row Rendering event
    public function rowRendering()
    {
        // Enter your code here
    }

    // Row Rendered event
    public function rowRendered()
    {
        // To view properties of field class, use:
        //var_dump($this-><FieldName>);
    }

    // User ID Filtering event
    public function userIdFiltering(&$filter)
    {
        // Enter your code here
    }
}
