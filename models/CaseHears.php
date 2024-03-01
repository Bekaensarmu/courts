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
 * Table class for case_hears
 */
class CaseHears extends DbTable
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

    // Fields
    public $id;
    public $melequtir;
    public $RANKe;
    public $name;
    public $ez;
    public $fileNumber;
    public $firdbet;
    public $chilotname;
    public $kirihidet;
    public $yekisaynet;
    public $keteroreason;
    public $sex;
    public $tekesashbizat;
    public $keterodate;
    public $keterodescription;
    public $created_at;
    public $updated_at;
    public $updated_by;

    // Page ID
    public $PageID = ""; // To be overridden by subclass

    // Constructor
    public function __construct()
    {
        parent::__construct();
        global $Language, $CurrentLanguage, $CurrentLocale;

        // Language object
        $Language = Container("app.language");
        $this->TableVar = "case_hears";
        $this->TableName = 'case_hears';
        $this->TableType = "TABLE";
        $this->ImportUseTransaction = $this->supportsTransaction() && Config("IMPORT_USE_TRANSACTION");
        $this->UseTransaction = $this->supportsTransaction() && Config("USE_TRANSACTION");

        // Update Table
        $this->UpdateTable = "case_hears";
        $this->Dbid = 'DB';
        $this->ExportAll = true;
        $this->ExportPageBreakCount = 0; // Page break per every n record (PDF only)

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
        $this->DetailAdd = false; // Allow detail add
        $this->DetailEdit = false; // Allow detail edit
        $this->DetailView = false; // Allow detail view
        $this->ShowMultipleDetails = false; // Show multiple details
        $this->GridAddRowCount = 5;
        $this->AllowAddDeleteRow = true; // Allow add/delete row
        $this->UseAjaxActions = $this->UseAjaxActions || Config("USE_AJAX_ACTIONS");
        $this->UserIDAllowSecurity = Config("DEFAULT_USER_ID_ALLOW_SECURITY"); // Default User ID allowed permissions
        $this->BasicSearch = new BasicSearch($this);

        // id
        $this->id = new DbField(
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
        $this->Fields['id'] = &$this->id;

        // melequtir
        $this->melequtir = new DbField(
            $this, // Table
            'x_melequtir', // Variable name
            'melequtir', // Name
            '`melequtir`', // Expression
            '`melequtir`', // Basic search expression
            200, // Type
            50, // Size
            -1, // Date/Time format
            false, // Is upload field
            '`melequtir`', // Virtual expression
            false, // Is virtual
            false, // Force selection
            false, // Is Virtual search
            'FORMATTED TEXT', // View Tag
            'TEXT' // Edit Tag
        );
        $this->melequtir->InputTextType = "text";
        $this->melequtir->Nullable = false; // NOT NULL field
        $this->melequtir->Required = true; // Required field
        $this->melequtir->SearchOperators = ["=", "<>", "IN", "NOT IN", "STARTS WITH", "NOT STARTS WITH", "LIKE", "NOT LIKE", "ENDS WITH", "NOT ENDS WITH", "IS EMPTY", "IS NOT EMPTY"];
        $this->Fields['melequtir'] = &$this->melequtir;

        // RANKe
        $this->RANKe = new DbField(
            $this, // Table
            'x_RANKe', // Variable name
            'RANKe', // Name
            '`RANKe`', // Expression
            '`RANKe`', // Basic search expression
            200, // Type
            255, // Size
            -1, // Date/Time format
            false, // Is upload field
            '`RANKe`', // Virtual expression
            false, // Is virtual
            false, // Force selection
            false, // Is Virtual search
            'FORMATTED TEXT', // View Tag
            'SELECT' // Edit Tag
        );
        $this->RANKe->InputTextType = "text";
        $this->RANKe->Nullable = false; // NOT NULL field
        $this->RANKe->Required = true; // Required field
        $this->RANKe->setSelectMultiple(false); // Select one
        $this->RANKe->UsePleaseSelect = true; // Use PleaseSelect by default
        $this->RANKe->PleaseSelectText = $Language->phrase("PleaseSelect"); // "PleaseSelect" text
        $this->RANKe->Lookup = new Lookup($this->RANKe, 'specialfiles', false, 'ዕዝ', ["ማዕረግ","","",""], '', '', [], [], [], [], [], [], false, '', '', "`ማዕረግ`");
        $this->RANKe->SearchOperators = ["=", "<>"];
        $this->Fields['RANKe'] = &$this->RANKe;

        // name
        $this->name = new DbField(
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
        $this->Fields['name'] = &$this->name;

        // ez
        $this->ez = new DbField(
            $this, // Table
            'x_ez', // Variable name
            'ez', // Name
            '`ez`', // Expression
            '`ez`', // Basic search expression
            200, // Type
            100, // Size
            -1, // Date/Time format
            false, // Is upload field
            '`ez`', // Virtual expression
            false, // Is virtual
            false, // Force selection
            false, // Is Virtual search
            'FORMATTED TEXT', // View Tag
            'SELECT' // Edit Tag
        );
        $this->ez->InputTextType = "text";
        $this->ez->Nullable = false; // NOT NULL field
        $this->ez->Required = true; // Required field
        $this->ez->setSelectMultiple(false); // Select one
        $this->ez->UsePleaseSelect = true; // Use PleaseSelect by default
        $this->ez->PleaseSelectText = $Language->phrase("PleaseSelect"); // "PleaseSelect" text
        $this->ez->Lookup = new Lookup($this->ez, 'specialfiles', false, 'ዕዝ', ["ዕዝ","","",""], '', '', [], [], [], [], [], [], false, '', '', "`ዕዝ`");
        $this->ez->SearchOperators = ["=", "<>"];
        $this->Fields['ez'] = &$this->ez;

        // fileNumber
        $this->fileNumber = new DbField(
            $this, // Table
            'x_fileNumber', // Variable name
            'fileNumber', // Name
            '`fileNumber`', // Expression
            '`fileNumber`', // Basic search expression
            200, // Type
            255, // Size
            -1, // Date/Time format
            false, // Is upload field
            '`fileNumber`', // Virtual expression
            false, // Is virtual
            false, // Force selection
            false, // Is Virtual search
            'FORMATTED TEXT', // View Tag
            'TEXT' // Edit Tag
        );
        $this->fileNumber->InputTextType = "text";
        $this->fileNumber->Nullable = false; // NOT NULL field
        $this->fileNumber->Required = true; // Required field
        $this->fileNumber->SearchOperators = ["=", "<>", "IN", "NOT IN", "STARTS WITH", "NOT STARTS WITH", "LIKE", "NOT LIKE", "ENDS WITH", "NOT ENDS WITH", "IS EMPTY", "IS NOT EMPTY"];
        $this->Fields['fileNumber'] = &$this->fileNumber;

        // firdbet
        $this->firdbet = new DbField(
            $this, // Table
            'x_firdbet', // Variable name
            'firdbet', // Name
            '`firdbet`', // Expression
            '`firdbet`', // Basic search expression
            200, // Type
            255, // Size
            0, // Date/Time format
            false, // Is upload field
            '`firdbet`', // Virtual expression
            false, // Is virtual
            false, // Force selection
            false, // Is Virtual search
            'FORMATTED TEXT', // View Tag
            'SELECT' // Edit Tag
        );
        $this->firdbet->InputTextType = "text";
        $this->firdbet->Nullable = false; // NOT NULL field
        $this->firdbet->Required = true; // Required field
        $this->firdbet->setSelectMultiple(false); // Select one
        $this->firdbet->UsePleaseSelect = true; // Use PleaseSelect by default
        $this->firdbet->PleaseSelectText = $Language->phrase("PleaseSelect"); // "PleaseSelect" text
        $this->firdbet->Lookup = new Lookup($this->firdbet, 'courts', false, 'courtID', ["name","","",""], '', '', [], [], [], [], [], [], false, '', '', "`name`");
        $this->firdbet->DefaultErrorMessage = str_replace("%s", $GLOBALS["DATE_FORMAT"], $Language->phrase("IncorrectDate"));
        $this->firdbet->SearchOperators = ["=", "<>"];
        $this->Fields['firdbet'] = &$this->firdbet;

        // chilotname
        $this->chilotname = new DbField(
            $this, // Table
            'x_chilotname', // Variable name
            'chilotname', // Name
            '`chilotname`', // Expression
            '`chilotname`', // Basic search expression
            200, // Type
            255, // Size
            -1, // Date/Time format
            false, // Is upload field
            '`chilotname`', // Virtual expression
            false, // Is virtual
            false, // Force selection
            false, // Is Virtual search
            'FORMATTED TEXT', // View Tag
            'SELECT' // Edit Tag
        );
        $this->chilotname->InputTextType = "text";
        $this->chilotname->Nullable = false; // NOT NULL field
        $this->chilotname->Required = true; // Required field
        $this->chilotname->setSelectMultiple(false); // Select one
        $this->chilotname->UsePleaseSelect = true; // Use PleaseSelect by default
        $this->chilotname->PleaseSelectText = $Language->phrase("PleaseSelect"); // "PleaseSelect" text
        $this->chilotname->Lookup = new Lookup($this->chilotname, 'specialfiles', false, 'ዕዝ', ["የችሎትስም","","",""], '', '', [], [], [], [], [], [], false, '', '', "`የችሎትስም`");
        $this->chilotname->SearchOperators = ["=", "<>"];
        $this->Fields['chilotname'] = &$this->chilotname;

        // kirihidet
        $this->kirihidet = new DbField(
            $this, // Table
            'x_kirihidet', // Variable name
            'kirihidet', // Name
            '`kirihidet`', // Expression
            '`kirihidet`', // Basic search expression
            200, // Type
            255, // Size
            -1, // Date/Time format
            false, // Is upload field
            '`kirihidet`', // Virtual expression
            false, // Is virtual
            false, // Force selection
            false, // Is Virtual search
            'FORMATTED TEXT', // View Tag
            'SELECT' // Edit Tag
        );
        $this->kirihidet->InputTextType = "text";
        $this->kirihidet->Nullable = false; // NOT NULL field
        $this->kirihidet->Required = true; // Required field
        $this->kirihidet->setSelectMultiple(false); // Select one
        $this->kirihidet->UsePleaseSelect = true; // Use PleaseSelect by default
        $this->kirihidet->PleaseSelectText = $Language->phrase("PleaseSelect"); // "PleaseSelect" text
        $this->kirihidet->Lookup = new Lookup($this->kirihidet, 'specialfiles', false, 'ዕዝ', ["የክርክሩሂደት","","",""], '', '', [], [], [], [], [], [], false, '', '', "`የክርክሩሂደት`");
        $this->kirihidet->SearchOperators = ["=", "<>"];
        $this->Fields['kirihidet'] = &$this->kirihidet;

        // yekisaynet
        $this->yekisaynet = new DbField(
            $this, // Table
            'x_yekisaynet', // Variable name
            'yekisaynet', // Name
            '`yekisaynet`', // Expression
            '`yekisaynet`', // Basic search expression
            200, // Type
            255, // Size
            -1, // Date/Time format
            false, // Is upload field
            '`yekisaynet`', // Virtual expression
            false, // Is virtual
            false, // Force selection
            false, // Is Virtual search
            'FORMATTED TEXT', // View Tag
            'SELECT' // Edit Tag
        );
        $this->yekisaynet->InputTextType = "text";
        $this->yekisaynet->Nullable = false; // NOT NULL field
        $this->yekisaynet->Required = true; // Required field
        $this->yekisaynet->setSelectMultiple(false); // Select one
        $this->yekisaynet->UsePleaseSelect = true; // Use PleaseSelect by default
        $this->yekisaynet->PleaseSelectText = $Language->phrase("PleaseSelect"); // "PleaseSelect" text
        $this->yekisaynet->Lookup = new Lookup($this->yekisaynet, 'specialfiles', false, 'ዕዝ', ["የክስዓይነት","","",""], '', '', [], [], [], [], [], [], false, '', '', "`የክስዓይነት`");
        $this->yekisaynet->SearchOperators = ["=", "<>"];
        $this->Fields['yekisaynet'] = &$this->yekisaynet;

        // keteroreason
        $this->keteroreason = new DbField(
            $this, // Table
            'x_keteroreason', // Variable name
            'keteroreason', // Name
            '`keteroreason`', // Expression
            '`keteroreason`', // Basic search expression
            200, // Type
            65535, // Size
            -1, // Date/Time format
            false, // Is upload field
            '`keteroreason`', // Virtual expression
            false, // Is virtual
            false, // Force selection
            false, // Is Virtual search
            'FORMATTED TEXT', // View Tag
            'SELECT' // Edit Tag
        );
        $this->keteroreason->InputTextType = "text";
        $this->keteroreason->Nullable = false; // NOT NULL field
        $this->keteroreason->Required = true; // Required field
        $this->keteroreason->setSelectMultiple(false); // Select one
        $this->keteroreason->UsePleaseSelect = true; // Use PleaseSelect by default
        $this->keteroreason->PleaseSelectText = $Language->phrase("PleaseSelect"); // "PleaseSelect" text
        $this->keteroreason->Lookup = new Lookup($this->keteroreason, 'specialfiles', false, 'ዕዝ', ["የቀጠሮምክንያት","","",""], '', '', [], [], [], [], [], [], false, '', '', "`የቀጠሮምክንያት`");
        $this->keteroreason->SearchOperators = ["=", "<>"];
        $this->Fields['keteroreason'] = &$this->keteroreason;

        // sex
        $this->sex = new DbField(
            $this, // Table
            'x_sex', // Variable name
            'sex', // Name
            '`sex`', // Expression
            '`sex`', // Basic search expression
            200, // Type
            20, // Size
            -1, // Date/Time format
            false, // Is upload field
            '`sex`', // Virtual expression
            false, // Is virtual
            false, // Force selection
            false, // Is Virtual search
            'FORMATTED TEXT', // View Tag
            'RADIO' // Edit Tag
        );
        $this->sex->InputTextType = "text";
        $this->sex->Nullable = false; // NOT NULL field
        $this->sex->Required = true; // Required field
        $this->sex->Lookup = new Lookup($this->sex, 'case_hears', false, '', ["","","",""], '', '', [], [], [], [], [], [], false, '', '', "");
        $this->sex->OptionCount = 2;
        $this->sex->SearchOperators = ["=", "<>"];
        $this->Fields['sex'] = &$this->sex;

        // tekesashbizat
        $this->tekesashbizat = new DbField(
            $this, // Table
            'x_tekesashbizat', // Variable name
            'tekesashbizat', // Name
            '`tekesashbizat`', // Expression
            '`tekesashbizat`', // Basic search expression
            3, // Type
            10, // Size
            -1, // Date/Time format
            false, // Is upload field
            '`tekesashbizat`', // Virtual expression
            false, // Is virtual
            false, // Force selection
            false, // Is Virtual search
            'FORMATTED TEXT', // View Tag
            'TEXT' // Edit Tag
        );
        $this->tekesashbizat->InputTextType = "text";
        $this->tekesashbizat->Raw = true;
        $this->tekesashbizat->Nullable = false; // NOT NULL field
        $this->tekesashbizat->Required = true; // Required field
        $this->tekesashbizat->DefaultErrorMessage = $Language->phrase("IncorrectInteger");
        $this->tekesashbizat->SearchOperators = ["=", "<>", "IN", "NOT IN", "<", "<=", ">", ">=", "BETWEEN", "NOT BETWEEN"];
        $this->Fields['tekesashbizat'] = &$this->tekesashbizat;

        // keterodate
        $this->keterodate = new DbField(
            $this, // Table
            'x_keterodate', // Variable name
            'keterodate', // Name
            '`keterodate`', // Expression
            CastDateFieldForLike("`keterodate`", 0, "DB"), // Basic search expression
            135, // Type
            19, // Size
            0, // Date/Time format
            false, // Is upload field
            '`keterodate`', // Virtual expression
            false, // Is virtual
            false, // Force selection
            false, // Is Virtual search
            'FORMATTED TEXT', // View Tag
            'TEXT' // Edit Tag
        );
        $this->keterodate->InputTextType = "text";
        $this->keterodate->Raw = true;
        $this->keterodate->Nullable = false; // NOT NULL field
        $this->keterodate->Required = true; // Required field
        $this->keterodate->DefaultErrorMessage = str_replace("%s", $GLOBALS["DATE_FORMAT"], $Language->phrase("IncorrectDate"));
        $this->keterodate->SearchOperators = ["=", "<>", "IN", "NOT IN", "<", "<=", ">", ">=", "BETWEEN", "NOT BETWEEN"];
        $this->Fields['keterodate'] = &$this->keterodate;

        // keterodescription
        $this->keterodescription = new DbField(
            $this, // Table
            'x_keterodescription', // Variable name
            'keterodescription', // Name
            '`keterodescription`', // Expression
            '`keterodescription`', // Basic search expression
            200, // Type
            65535, // Size
            -1, // Date/Time format
            false, // Is upload field
            '`keterodescription`', // Virtual expression
            false, // Is virtual
            false, // Force selection
            false, // Is Virtual search
            'FORMATTED TEXT', // View Tag
            'TEXT' // Edit Tag
        );
        $this->keterodescription->InputTextType = "text";
        $this->keterodescription->Nullable = false; // NOT NULL field
        $this->keterodescription->Required = true; // Required field
        $this->keterodescription->SearchOperators = ["=", "<>", "IN", "NOT IN", "STARTS WITH", "NOT STARTS WITH", "LIKE", "NOT LIKE", "ENDS WITH", "NOT ENDS WITH", "IS EMPTY", "IS NOT EMPTY"];
        $this->Fields['keterodescription'] = &$this->keterodescription;

        // created_at
        $this->created_at = new DbField(
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
        $this->Fields['created_at'] = &$this->created_at;

        // updated_at
        $this->updated_at = new DbField(
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
        $this->Fields['updated_at'] = &$this->updated_at;

        // updated_by
        $this->updated_by = new DbField(
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
        $this->Fields['updated_by'] = &$this->updated_by;

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

    // Set left column class (must be predefined col-*-* classes of Bootstrap grid system)
    public function setLeftColumnClass($class)
    {
        if (preg_match('/^col\-(\w+)\-(\d+)$/', $class, $match)) {
            $this->LeftColumnClass = $class . " col-form-label ew-label";
            $this->RightColumnClass = "col-" . $match[1] . "-" . strval(12 - (int)$match[2]);
            $this->OffsetColumnClass = $this->RightColumnClass . " " . str_replace("col-", "offset-", $class);
            $this->TableLeftColumnClass = preg_replace('/^col-\w+-(\d+)$/', "w-col-$1", $class); // Change to w-col-*
        }
    }

    // Single column sort
    public function updateSort(&$fld)
    {
        if ($this->CurrentOrder == $fld->Name) {
            $sortField = $fld->Expression;
            $lastSort = $fld->getSort();
            if (in_array($this->CurrentOrderType, ["ASC", "DESC", "NO"])) {
                $curSort = $this->CurrentOrderType;
            } else {
                $curSort = $lastSort;
            }
            $orderBy = in_array($curSort, ["ASC", "DESC"]) ? $sortField . " " . $curSort : "";
            $this->setSessionOrderBy($orderBy); // Save to Session
        }
    }

    // Update field sort
    public function updateFieldSort()
    {
        $orderBy = $this->getSessionOrderBy(); // Get ORDER BY from Session
        $flds = GetSortFields($orderBy);
        foreach ($this->Fields as $field) {
            $fldSort = "";
            foreach ($flds as $fld) {
                if ($fld[0] == $field->Expression || $fld[0] == $field->VirtualExpression) {
                    $fldSort = $fld[1];
                }
            }
            $field->setSort($fldSort);
        }
    }

    // Render X Axis for chart
    public function renderChartXAxis($chartVar, $chartRow)
    {
        return $chartRow;
    }

    // Get FROM clause
    public function getSqlFrom()
    {
        return ($this->SqlFrom != "") ? $this->SqlFrom : "case_hears";
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
        $useFieldNames = false;
        $fieldNames = [];
        $platform = $this->getConnection()->getDatabasePlatform();
        foreach ($this->Fields as $field) {
            $expr = $field->Expression;
            $customExpr = $field->CustomDataType?->convertToPHPValueSQL($expr, $platform) ?? $expr;
            if ($customExpr != $expr) {
                $fieldNames[] = $customExpr . " AS " . QuotedName($field->Name, $this->Dbid);
                $useFieldNames = true;
            } else {
                $fieldNames[] = $expr;
            }
        }
        return $useFieldNames ? implode(", ", $fieldNames) : "*";
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
        return $this->SqlGroupBy != "" ? $this->SqlGroupBy : "";
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

    // Get SQL
    public function getSql($where, $orderBy = "")
    {
        return $this->getSqlAsQueryBuilder($where, $orderBy)->getSQL();
    }

    // Get QueryBuilder
    public function getSqlAsQueryBuilder($where, $orderBy = "")
    {
        return $this->buildSelectSql(
            $this->getSqlSelect(),
            $this->getSqlFrom(),
            $this->getSqlWhere(),
            $this->getSqlGroupBy(),
            $this->getSqlHaving(),
            $this->getSqlOrderBy(),
            $where,
            $orderBy
        );
    }

    // Table SQL
    public function getCurrentSql()
    {
        $filter = $this->CurrentFilter;
        $filter = $this->applyUserIDFilters($filter);
        $sort = $this->getSessionOrderBy();
        return $this->getSql($filter, $sort);
    }

    /**
     * Table SQL with List page filter
     *
     * @return QueryBuilder
     */
    public function getListSql()
    {
        $filter = $this->UseSessionForListSql ? $this->getSessionWhere() : "";
        AddFilter($filter, $this->CurrentFilter);
        $filter = $this->applyUserIDFilters($filter);
        $this->recordsetSelecting($filter);
        $select = $this->getSqlSelect();
        $from = $this->getSqlFrom();
        $sort = $this->UseSessionForListSql ? $this->getSessionOrderBy() : "";
        $this->Sort = $sort;
        return $this->buildSelectSql(
            $select,
            $from,
            $this->getSqlWhere(),
            $this->getSqlGroupBy(),
            $this->getSqlHaving(),
            $this->getSqlOrderBy(),
            $filter,
            $sort
        );
    }

    // Get ORDER BY clause
    public function getOrderBy()
    {
        $orderBy = $this->getSqlOrderBy();
        $sort = $this->getSessionOrderBy();
        if ($orderBy != "" && $sort != "") {
            $orderBy .= ", " . $sort;
        } elseif ($sort != "") {
            $orderBy = $sort;
        }
        return $orderBy;
    }

    // Get record count based on filter (for detail record count in master table pages)
    public function loadRecordCount($filter)
    {
        $origFilter = $this->CurrentFilter;
        $this->CurrentFilter = $filter;
        $this->recordsetSelecting($this->CurrentFilter);
        $isCustomView = $this->TableType == "CUSTOMVIEW";
        $select = $isCustomView ? $this->getSqlSelect() : $this->getQueryBuilder()->select("*");
        $groupBy = $isCustomView ? $this->getSqlGroupBy() : "";
        $having = $isCustomView ? $this->getSqlHaving() : "";
        $sql = $this->buildSelectSql($select, $this->getSqlFrom(), $this->getSqlWhere(), $groupBy, $having, "", $this->CurrentFilter, "");
        $cnt = $this->getRecordCount($sql);
        $this->CurrentFilter = $origFilter;
        return $cnt;
    }

    // Get record count (for current List page)
    public function listRecordCount()
    {
        $filter = $this->getSessionWhere();
        AddFilter($filter, $this->CurrentFilter);
        $filter = $this->applyUserIDFilters($filter);
        $this->recordsetSelecting($filter);
        $isCustomView = $this->TableType == "CUSTOMVIEW";
        $select = $isCustomView ? $this->getSqlSelect() : $this->getQueryBuilder()->select("*");
        $groupBy = $isCustomView ? $this->getSqlGroupBy() : "";
        $having = $isCustomView ? $this->getSqlHaving() : "";
        $sql = $this->buildSelectSql($select, $this->getSqlFrom(), $this->getSqlWhere(), $groupBy, $having, "", $filter, "");
        $cnt = $this->getRecordCount($sql);
        return $cnt;
    }

    /**
     * INSERT statement
     *
     * @param mixed $rs
     * @return QueryBuilder
     */
    public function insertSql(&$rs)
    {
        $queryBuilder = $this->getQueryBuilder();
        $queryBuilder->insert($this->UpdateTable);
        $platform = $this->getConnection()->getDatabasePlatform();
        foreach ($rs as $name => $value) {
            if (!isset($this->Fields[$name]) || $this->Fields[$name]->IsCustom) {
                continue;
            }
            $field = $this->Fields[$name];
            $parm = $queryBuilder->createPositionalParameter($value, $field->getParameterType());
            $parm = $field->CustomDataType?->convertToDatabaseValueSQL($parm, $platform) ?? $parm; // Convert database SQL
            $queryBuilder->setValue($field->Expression, $parm);
        }
        return $queryBuilder;
    }

    // Insert
    public function insert(&$rs)
    {
        $conn = $this->getConnection();
        try {
            $queryBuilder = $this->insertSql($rs);
            $result = $queryBuilder->executeStatement();
            $this->DbErrorMessage = "";
        } catch (\Exception $e) {
            $result = false;
            $this->DbErrorMessage = $e->getMessage();
        }
        if ($result) {
            $this->id->setDbValue($conn->lastInsertId());
            $rs['id'] = $this->id->DbValue;
        }
        return $result;
    }

    /**
     * UPDATE statement
     *
     * @param array $rs Data to be updated
     * @param string|array $where WHERE clause
     * @param string $curfilter Filter
     * @return QueryBuilder
     */
    public function updateSql(&$rs, $where = "", $curfilter = true)
    {
        $queryBuilder = $this->getQueryBuilder();
        $queryBuilder->update($this->UpdateTable);
        $platform = $this->getConnection()->getDatabasePlatform();
        foreach ($rs as $name => $value) {
            if (!isset($this->Fields[$name]) || $this->Fields[$name]->IsCustom || $this->Fields[$name]->IsAutoIncrement) {
                continue;
            }
            $field = $this->Fields[$name];
            $parm = $queryBuilder->createPositionalParameter($value, $field->getParameterType());
            $parm = $field->CustomDataType?->convertToDatabaseValueSQL($parm, $platform) ?? $parm; // Convert database SQL
            $queryBuilder->set($field->Expression, $parm);
        }
        $filter = $curfilter ? $this->CurrentFilter : "";
        if (is_array($where)) {
            $where = $this->arrayToFilter($where);
        }
        AddFilter($filter, $where);
        if ($filter != "") {
            $queryBuilder->where($filter);
        }
        return $queryBuilder;
    }

    // Update
    public function update(&$rs, $where = "", $rsold = null, $curfilter = true)
    {
        // If no field is updated, execute may return 0. Treat as success
        try {
            $success = $this->updateSql($rs, $where, $curfilter)->executeStatement();
            $success = $success > 0 ? $success : true;
            $this->DbErrorMessage = "";
        } catch (\Exception $e) {
            $success = false;
            $this->DbErrorMessage = $e->getMessage();
        }

        // Return auto increment field
        if ($success) {
            if (!isset($rs['id']) && !EmptyValue($this->id->CurrentValue)) {
                $rs['id'] = $this->id->CurrentValue;
            }
        }
        return $success;
    }

    /**
     * DELETE statement
     *
     * @param array $rs Key values
     * @param string|array $where WHERE clause
     * @param string $curfilter Filter
     * @return QueryBuilder
     */
    public function deleteSql(&$rs, $where = "", $curfilter = true)
    {
        $queryBuilder = $this->getQueryBuilder();
        $queryBuilder->delete($this->UpdateTable);
        if (is_array($where)) {
            $where = $this->arrayToFilter($where);
        }
        if ($rs) {
            if (array_key_exists('id', $rs)) {
                AddFilter($where, QuotedName('id', $this->Dbid) . '=' . QuotedValue($rs['id'], $this->id->DataType, $this->Dbid));
            }
        }
        $filter = $curfilter ? $this->CurrentFilter : "";
        AddFilter($filter, $where);
        return $queryBuilder->where($filter != "" ? $filter : "0=1");
    }

    // Delete
    public function delete(&$rs, $where = "", $curfilter = false)
    {
        $success = true;
        if ($success) {
            try {
                $success = $this->deleteSql($rs, $where, $curfilter)->executeStatement();
                $this->DbErrorMessage = "";
            } catch (\Exception $e) {
                $success = false;
                $this->DbErrorMessage = $e->getMessage();
            }
        }
        return $success;
    }

    // Load DbValue from result set or array
    protected function loadDbValues($row)
    {
        if (!is_array($row)) {
            return;
        }
        $this->id->DbValue = $row['id'];
        $this->melequtir->DbValue = $row['melequtir'];
        $this->RANKe->DbValue = $row['RANKe'];
        $this->name->DbValue = $row['name'];
        $this->ez->DbValue = $row['ez'];
        $this->fileNumber->DbValue = $row['fileNumber'];
        $this->firdbet->DbValue = $row['firdbet'];
        $this->chilotname->DbValue = $row['chilotname'];
        $this->kirihidet->DbValue = $row['kirihidet'];
        $this->yekisaynet->DbValue = $row['yekisaynet'];
        $this->keteroreason->DbValue = $row['keteroreason'];
        $this->sex->DbValue = $row['sex'];
        $this->tekesashbizat->DbValue = $row['tekesashbizat'];
        $this->keterodate->DbValue = $row['keterodate'];
        $this->keterodescription->DbValue = $row['keterodescription'];
        $this->created_at->DbValue = $row['created_at'];
        $this->updated_at->DbValue = $row['updated_at'];
        $this->updated_by->DbValue = $row['updated_by'];
    }

    // Delete uploaded files
    public function deleteUploadedFiles($row)
    {
        $this->loadDbValues($row);
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
        return $_SESSION[$name] ?? GetUrl("CaseHearsList");
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
            "CaseHearsView" => $Language->phrase("View"),
            "CaseHearsEdit" => $Language->phrase("Edit"),
            "CaseHearsAdd" => $Language->phrase("Add"),
            default => ""
        };
    }

    // Default route URL
    public function getDefaultRouteUrl()
    {
        return "CaseHearsList";
    }

    // API page name
    public function getApiPageName($action)
    {
        return match (strtolower($action)) {
            Config("API_VIEW_ACTION") => "CaseHearsView",
            Config("API_ADD_ACTION") => "CaseHearsAdd",
            Config("API_EDIT_ACTION") => "CaseHearsEdit",
            Config("API_DELETE_ACTION") => "CaseHearsDelete",
            Config("API_LIST_ACTION") => "CaseHearsList",
            default => ""
        };
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
        return "CaseHearsList";
    }

    // View URL
    public function getViewUrl($parm = "")
    {
        if ($parm != "") {
            $url = $this->keyUrl("CaseHearsView", $parm);
        } else {
            $url = $this->keyUrl("CaseHearsView", Config("TABLE_SHOW_DETAIL") . "=");
        }
        return $this->addMasterUrl($url);
    }

    // Add URL
    public function getAddUrl($parm = "")
    {
        if ($parm != "") {
            $url = "CaseHearsAdd?" . $parm;
        } else {
            $url = "CaseHearsAdd";
        }
        return $this->addMasterUrl($url);
    }

    // Edit URL
    public function getEditUrl($parm = "")
    {
        $url = $this->keyUrl("CaseHearsEdit", $parm);
        return $this->addMasterUrl($url);
    }

    // Inline edit URL
    public function getInlineEditUrl()
    {
        $url = $this->keyUrl("CaseHearsList", "action=edit");
        return $this->addMasterUrl($url);
    }

    // Copy URL
    public function getCopyUrl($parm = "")
    {
        $url = $this->keyUrl("CaseHearsAdd", $parm);
        return $this->addMasterUrl($url);
    }

    // Inline copy URL
    public function getInlineCopyUrl()
    {
        $url = $this->keyUrl("CaseHearsList", "action=copy");
        return $this->addMasterUrl($url);
    }

    // Delete URL
    public function getDeleteUrl($parm = "")
    {
        if ($this->UseAjaxActions && ConvertToBool(Param("infinitescroll")) && CurrentPageID() == "list") {
            return $this->keyUrl(GetApiUrl(Config("API_DELETE_ACTION") . "/" . $this->TableVar));
        } else {
            return $this->keyUrl("CaseHearsDelete", $parm);
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

    // Load row values from record
    public function loadListRowValues(&$rs)
    {
        if (is_array($rs)) {
            $row = $rs;
        } elseif ($rs && property_exists($rs, "fields")) { // Recordset
            $row = $rs->fields;
        } else {
            return;
        }
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

    // Render list content
    public function renderListContent($filter)
    {
        global $Response;
        $listPage = "CaseHearsList";
        $listClass = PROJECT_NAMESPACE . $listPage;
        $page = new $listClass();
        $page->loadRecordsetFromFilter($filter);
        $view = Container("app.view");
        $template = $listPage . ".php"; // View
        $GLOBALS["Title"] ??= $page->Title; // Title
        try {
            $Response = $view->render($Response, $template, $GLOBALS);
        } finally {
            $page->terminate(); // Terminate page and clean up
        }
    }

    // Render list row values
    public function renderListRow()
    {
        global $Security, $CurrentLanguage, $Language;

        // Call Row Rendering event
        $this->rowRendering();

        // Common render codes

        // id
        $this->id->CellCssStyle = "white-space: nowrap;";

        // melequtir

        // RANKe

        // name

        // ez

        // fileNumber

        // firdbet

        // chilotname

        // kirihidet

        // yekisaynet

        // keteroreason

        // sex

        // tekesashbizat

        // keterodate

        // keterodescription

        // created_at

        // updated_at

        // updated_by

        // id
        $this->id->ViewValue = $this->id->CurrentValue;

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

        // id
        $this->id->HrefValue = "";
        $this->id->TooltipValue = "";

        // melequtir
        $this->melequtir->HrefValue = "";
        $this->melequtir->TooltipValue = "";

        // RANKe
        $this->RANKe->HrefValue = "";
        $this->RANKe->TooltipValue = "";

        // name
        $this->name->HrefValue = "";
        $this->name->TooltipValue = "";

        // ez
        $this->ez->HrefValue = "";
        $this->ez->TooltipValue = "";

        // fileNumber
        $this->fileNumber->HrefValue = "";
        $this->fileNumber->TooltipValue = "";

        // firdbet
        $this->firdbet->HrefValue = "";
        $this->firdbet->TooltipValue = "";

        // chilotname
        $this->chilotname->HrefValue = "";
        $this->chilotname->TooltipValue = "";

        // kirihidet
        $this->kirihidet->HrefValue = "";
        $this->kirihidet->TooltipValue = "";

        // yekisaynet
        $this->yekisaynet->HrefValue = "";
        $this->yekisaynet->TooltipValue = "";

        // keteroreason
        $this->keteroreason->HrefValue = "";
        $this->keteroreason->TooltipValue = "";

        // sex
        $this->sex->HrefValue = "";
        $this->sex->TooltipValue = "";

        // tekesashbizat
        $this->tekesashbizat->HrefValue = "";
        $this->tekesashbizat->TooltipValue = "";

        // keterodate
        $this->keterodate->HrefValue = "";
        $this->keterodate->TooltipValue = "";

        // keterodescription
        $this->keterodescription->HrefValue = "";
        $this->keterodescription->TooltipValue = "";

        // created_at
        $this->created_at->HrefValue = "";
        $this->created_at->TooltipValue = "";

        // updated_at
        $this->updated_at->HrefValue = "";
        $this->updated_at->TooltipValue = "";

        // updated_by
        $this->updated_by->HrefValue = "";
        $this->updated_by->TooltipValue = "";

        // Call Row Rendered event
        $this->rowRendered();

        // Save data for Custom Template
        $this->Rows[] = $this->customTemplateFieldValues();
    }

    // Render edit row values
    public function renderEditRow()
    {
        global $Security, $CurrentLanguage, $Language;

        // Call Row Rendering event
        $this->rowRendering();

        // id
        $this->id->setupEditAttributes();
        $this->id->EditValue = $this->id->CurrentValue;

        // melequtir
        $this->melequtir->setupEditAttributes();
        if (!$this->melequtir->Raw) {
            $this->melequtir->CurrentValue = HtmlDecode($this->melequtir->CurrentValue);
        }
        $this->melequtir->EditValue = $this->melequtir->CurrentValue;
        $this->melequtir->PlaceHolder = RemoveHtml($this->melequtir->caption());

        // RANKe
        $this->RANKe->setupEditAttributes();
        $this->RANKe->PlaceHolder = RemoveHtml($this->RANKe->caption());

        // name
        $this->name->setupEditAttributes();
        if (!$this->name->Raw) {
            $this->name->CurrentValue = HtmlDecode($this->name->CurrentValue);
        }
        $this->name->EditValue = $this->name->CurrentValue;
        $this->name->PlaceHolder = RemoveHtml($this->name->caption());

        // ez
        $this->ez->setupEditAttributes();
        $this->ez->PlaceHolder = RemoveHtml($this->ez->caption());

        // fileNumber
        $this->fileNumber->setupEditAttributes();
        if (!$this->fileNumber->Raw) {
            $this->fileNumber->CurrentValue = HtmlDecode($this->fileNumber->CurrentValue);
        }
        $this->fileNumber->EditValue = $this->fileNumber->CurrentValue;
        $this->fileNumber->PlaceHolder = RemoveHtml($this->fileNumber->caption());

        // firdbet
        $this->firdbet->setupEditAttributes();
        $this->firdbet->PlaceHolder = RemoveHtml($this->firdbet->caption());

        // chilotname
        $this->chilotname->setupEditAttributes();
        $this->chilotname->PlaceHolder = RemoveHtml($this->chilotname->caption());

        // kirihidet
        $this->kirihidet->setupEditAttributes();
        $this->kirihidet->PlaceHolder = RemoveHtml($this->kirihidet->caption());

        // yekisaynet
        $this->yekisaynet->setupEditAttributes();
        $this->yekisaynet->PlaceHolder = RemoveHtml($this->yekisaynet->caption());

        // keteroreason
        $this->keteroreason->setupEditAttributes();
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
        $this->keterodate->EditValue = FormatDateTime($this->keterodate->CurrentValue, $this->keterodate->formatPattern());
        $this->keterodate->PlaceHolder = RemoveHtml($this->keterodate->caption());

        // keterodescription
        $this->keterodescription->setupEditAttributes();
        if (!$this->keterodescription->Raw) {
            $this->keterodescription->CurrentValue = HtmlDecode($this->keterodescription->CurrentValue);
        }
        $this->keterodescription->EditValue = $this->keterodescription->CurrentValue;
        $this->keterodescription->PlaceHolder = RemoveHtml($this->keterodescription->caption());

        // created_at
        $this->created_at->setupEditAttributes();
        $this->created_at->EditValue = FormatDateTime($this->created_at->CurrentValue, $this->created_at->formatPattern());
        $this->created_at->PlaceHolder = RemoveHtml($this->created_at->caption());

        // updated_at

        // updated_by

        // Call Row Rendered event
        $this->rowRendered();
    }

    // Aggregate list row values
    public function aggregateListRowValues()
    {
    }

    // Aggregate list row (for rendering)
    public function aggregateListRow()
    {
        // Call Row Rendered event
        $this->rowRendered();
    }

    // Export data in HTML/CSV/Word/Excel/Email/PDF format
    public function exportDocument($doc, $result, $startRec = 1, $stopRec = 1, $exportPageType = "")
    {
        if (!$result || !$doc) {
            return;
        }
        if (!$doc->ExportCustom) {
            // Write header
            $doc->exportTableHeader();
            if ($doc->Horizontal) { // Horizontal format, write header
                $doc->beginExportRow();
                if ($exportPageType == "view") {
                    $doc->exportCaption($this->melequtir);
                    $doc->exportCaption($this->RANKe);
                    $doc->exportCaption($this->name);
                    $doc->exportCaption($this->ez);
                    $doc->exportCaption($this->fileNumber);
                    $doc->exportCaption($this->firdbet);
                    $doc->exportCaption($this->chilotname);
                    $doc->exportCaption($this->kirihidet);
                    $doc->exportCaption($this->yekisaynet);
                    $doc->exportCaption($this->keteroreason);
                    $doc->exportCaption($this->sex);
                    $doc->exportCaption($this->tekesashbizat);
                    $doc->exportCaption($this->keterodate);
                    $doc->exportCaption($this->keterodescription);
                    $doc->exportCaption($this->created_at);
                    $doc->exportCaption($this->updated_at);
                    $doc->exportCaption($this->updated_by);
                } else {
                    $doc->exportCaption($this->melequtir);
                    $doc->exportCaption($this->RANKe);
                    $doc->exportCaption($this->name);
                    $doc->exportCaption($this->ez);
                    $doc->exportCaption($this->fileNumber);
                    $doc->exportCaption($this->firdbet);
                    $doc->exportCaption($this->chilotname);
                    $doc->exportCaption($this->kirihidet);
                    $doc->exportCaption($this->yekisaynet);
                    $doc->exportCaption($this->keteroreason);
                    $doc->exportCaption($this->sex);
                    $doc->exportCaption($this->tekesashbizat);
                    $doc->exportCaption($this->keterodate);
                    $doc->exportCaption($this->keterodescription);
                    $doc->exportCaption($this->created_at);
                    $doc->exportCaption($this->updated_at);
                    $doc->exportCaption($this->updated_by);
                }
                $doc->endExportRow();
            }
        }
        $recCnt = $startRec - 1;
        $stopRec = $stopRec > 0 ? $stopRec : PHP_INT_MAX;
        while (($row = $result->fetch()) && $recCnt < $stopRec) {
            $recCnt++;
            if ($recCnt >= $startRec) {
                $rowCnt = $recCnt - $startRec + 1;

                // Page break
                if ($this->ExportPageBreakCount > 0) {
                    if ($rowCnt > 1 && ($rowCnt - 1) % $this->ExportPageBreakCount == 0) {
                        $doc->exportPageBreak();
                    }
                }
                $this->loadListRowValues($row);

                // Render row
                $this->RowType = RowType::VIEW; // Render view
                $this->resetAttributes();
                $this->renderListRow();
                if (!$doc->ExportCustom) {
                    $doc->beginExportRow($rowCnt); // Allow CSS styles if enabled
                    if ($exportPageType == "view") {
                        $doc->exportField($this->melequtir);
                        $doc->exportField($this->RANKe);
                        $doc->exportField($this->name);
                        $doc->exportField($this->ez);
                        $doc->exportField($this->fileNumber);
                        $doc->exportField($this->firdbet);
                        $doc->exportField($this->chilotname);
                        $doc->exportField($this->kirihidet);
                        $doc->exportField($this->yekisaynet);
                        $doc->exportField($this->keteroreason);
                        $doc->exportField($this->sex);
                        $doc->exportField($this->tekesashbizat);
                        $doc->exportField($this->keterodate);
                        $doc->exportField($this->keterodescription);
                        $doc->exportField($this->created_at);
                        $doc->exportField($this->updated_at);
                        $doc->exportField($this->updated_by);
                    } else {
                        $doc->exportField($this->melequtir);
                        $doc->exportField($this->RANKe);
                        $doc->exportField($this->name);
                        $doc->exportField($this->ez);
                        $doc->exportField($this->fileNumber);
                        $doc->exportField($this->firdbet);
                        $doc->exportField($this->chilotname);
                        $doc->exportField($this->kirihidet);
                        $doc->exportField($this->yekisaynet);
                        $doc->exportField($this->keteroreason);
                        $doc->exportField($this->sex);
                        $doc->exportField($this->tekesashbizat);
                        $doc->exportField($this->keterodate);
                        $doc->exportField($this->keterodescription);
                        $doc->exportField($this->created_at);
                        $doc->exportField($this->updated_at);
                        $doc->exportField($this->updated_by);
                    }
                    $doc->endExportRow($rowCnt);
                }
            }

            // Call Row Export server event
            if ($doc->ExportCustom) {
                $this->rowExport($doc, $row);
            }
        }
        if (!$doc->ExportCustom) {
            $doc->exportTableFooter();
        }
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

    // Recordset Selecting event
    public function recordsetSelecting(&$filter)
    {
        // Enter your code here
    }

    // Recordset Selected event
    public function recordsetSelected($rs)
    {
        //Log("Recordset Selected");
    }

    // Recordset Search Validated event
    public function recordsetSearchValidated()
    {
        // Example:
        //$this->MyField1->AdvancedSearch->SearchValue = "your search criteria"; // Search value
    }

    // Recordset Searching event
    public function recordsetSearching(&$filter)
    {
        // Enter your code here
    }

    // Row_Selecting event
    public function rowSelecting(&$filter)
    {
        // Enter your code here
    }

    // Row Selected event
    public function rowSelected(&$rs)
    {
        //Log("Row Selected");
    }

    // Row Inserting event
    public function rowInserting($rsold, &$rsnew)
    {
        // Enter your code here
        // To cancel, set return value to false
        return true;
    }

    // Row Inserted event
    public function rowInserted($rsold, $rsnew)
    {
        //Log("Row Inserted");
    }

    // Row Updating event
    public function rowUpdating($rsold, &$rsnew)
    {
        // Enter your code here
        // To cancel, set return value to false
        return true;
    }

    // Row Updated event
    public function rowUpdated($rsold, $rsnew)
    {
        //Log("Row Updated");
    }

    // Row Update Conflict event
    public function rowUpdateConflict($rsold, &$rsnew)
    {
        // Enter your code here
        // To ignore conflict, set return value to false
        return true;
    }

    // Grid Inserting event
    public function gridInserting()
    {
        // Enter your code here
        // To reject grid insert, set return value to false
        return true;
    }

    // Grid Inserted event
    public function gridInserted($rsnew)
    {
        //Log("Grid Inserted");
    }

    // Grid Updating event
    public function gridUpdating($rsold)
    {
        // Enter your code here
        // To reject grid update, set return value to false
        return true;
    }

    // Grid Updated event
    public function gridUpdated($rsold, $rsnew)
    {
        //Log("Grid Updated");
    }

    // Row Deleting event
    public function rowDeleting(&$rs)
    {
        // Enter your code here
        // To cancel, set return value to False
        return true;
    }

    // Row Deleted event
    public function rowDeleted($rs)
    {
        //Log("Row Deleted");
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
