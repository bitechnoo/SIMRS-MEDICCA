<?php
namespace PHPMaker2019\tpp;

/**
 * Table class for lokdaftar
 */
class lokdaftar extends DbTable
{
	protected $SqlFrom = "";
	protected $SqlSelect = "";
	protected $SqlSelectList = "";
	protected $SqlWhere = "";
	protected $SqlGroupBy = "";
	protected $SqlHaving = "";
	protected $SqlOrderBy = "";
	public $UseSessionForListSql = TRUE;

	// Column CSS classes
	public $LeftColumnClass = "col-sm-2 col-form-label ew-label";
	public $RightColumnClass = "col-sm-10";
	public $OffsetColumnClass = "col-sm-10 offset-sm-2";
	public $TableLeftColumnClass = "w-col-2";

	// Export
	public $ExportDoc;

	// Fields
	public $Id_Daftar;
	public $Tgl_Daftar;
	public $Waktu;
	public $Id_Pasien;
	public $Nama_Pasien;
	public $No_RM;
	public $Tgl_Lahir;
	public $Jenis_Kelamin;
	public $Alamat;
	public $Id_Poliklinik;
	public $Poliklinik;
	public $Rawat;
	public $Id_Rujukan;
	public $Id_JenisPasien;
	public $Lama_Baru;
	public $Id_BiayaDaftar;
	public $Total_Biaya;
	public $Petugas;
	public $Status;

	// Constructor
	public function __construct()
	{
		global $Language, $CurrentLanguage;

		// Language object
		if (!isset($Language))
			$Language = new Language();
		$this->TableVar = 'lokdaftar';
		$this->TableName = 'lokdaftar';
		$this->TableType = 'TABLE';

		// Update Table
		$this->UpdateTable = "`lokdaftar`";
		$this->Dbid = 'DB';
		$this->ExportAll = TRUE;
		$this->ExportPageBreakCount = 0; // Page break per every n record (PDF only)
		$this->ExportPageOrientation = "portrait"; // Page orientation (PDF only)
		$this->ExportPageSize = "a4"; // Page size (PDF only)
		$this->ExportExcelPageOrientation = ""; // Page orientation (PhpSpreadsheet only)
		$this->ExportExcelPageSize = ""; // Page size (PhpSpreadsheet only)
		$this->ExportWordPageOrientation = "portrait"; // Page orientation (PHPWord only)
		$this->ExportWordColumnWidth = NULL; // Cell width (PHPWord only)
		$this->DetailAdd = FALSE; // Allow detail add
		$this->DetailEdit = FALSE; // Allow detail edit
		$this->DetailView = FALSE; // Allow detail view
		$this->ShowMultipleDetails = FALSE; // Show multiple details
		$this->GridAddRowCount = 5;
		$this->AllowAddDeleteRow = TRUE; // Allow add/delete row
		$this->UserIDAllowSecurity = 0; // User ID Allow
		$this->BasicSearch = new BasicSearch($this->TableVar);
		$this->BasicSearch->TypeDefault = "OR";

		// Id_Daftar
		$this->Id_Daftar = new DbField('lokdaftar', 'lokdaftar', 'x_Id_Daftar', 'Id_Daftar', '`Id_Daftar`', '`Id_Daftar`', 200, -1, FALSE, '`Id_Daftar`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->Id_Daftar->IsPrimaryKey = TRUE; // Primary key field
		$this->Id_Daftar->Nullable = FALSE; // NOT NULL field
		$this->Id_Daftar->Sortable = FALSE; // Allow sort
		$this->fields['Id_Daftar'] = &$this->Id_Daftar;

		// Tgl_Daftar
		$this->Tgl_Daftar = new DbField('lokdaftar', 'lokdaftar', 'x_Tgl_Daftar', 'Tgl_Daftar', '`Tgl_Daftar`', CastDateFieldForLike('`Tgl_Daftar`', 7, "DB"), 133, 7, FALSE, '`Tgl_Daftar`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->Tgl_Daftar->Nullable = FALSE; // NOT NULL field
		$this->Tgl_Daftar->Required = TRUE; // Required field
		$this->Tgl_Daftar->Sortable = TRUE; // Allow sort
		$this->Tgl_Daftar->DefaultErrorMessage = str_replace("%s", $GLOBALS["DATE_SEPARATOR"], $Language->phrase("IncorrectDateDMY"));
		$this->fields['Tgl_Daftar'] = &$this->Tgl_Daftar;

		// Waktu
		$this->Waktu = new DbField('lokdaftar', 'lokdaftar', 'x_Waktu', 'Waktu', '`Waktu`', CastDateFieldForLike('`Waktu`', 4, "DB"), 134, 4, FALSE, '`Waktu`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->Waktu->Nullable = FALSE; // NOT NULL field
		$this->Waktu->Sortable = TRUE; // Allow sort
		$this->Waktu->DefaultErrorMessage = str_replace("%s", $GLOBALS["TIME_SEPARATOR"], $Language->phrase("IncorrectTime"));
		$this->fields['Waktu'] = &$this->Waktu;

		// Id_Pasien
		$this->Id_Pasien = new DbField('lokdaftar', 'lokdaftar', 'x_Id_Pasien', 'Id_Pasien', '`Id_Pasien`', '`Id_Pasien`', 200, -1, FALSE, '`Id_Pasien`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->Id_Pasien->Nullable = FALSE; // NOT NULL field
		$this->Id_Pasien->Required = TRUE; // Required field
		$this->Id_Pasien->Sortable = FALSE; // Allow sort
		$this->fields['Id_Pasien'] = &$this->Id_Pasien;

		// Nama_Pasien
		$this->Nama_Pasien = new DbField('lokdaftar', 'lokdaftar', 'x_Nama_Pasien', 'Nama_Pasien', '(SELECT lokpasien.nama_pasien FROM lokpasien WHERE lokdaftar.Id_Pasien = lokpasien.Id_Pasien)', '(SELECT lokpasien.nama_pasien FROM lokpasien WHERE lokdaftar.Id_Pasien = lokpasien.Id_Pasien)', 200, -1, FALSE, '(SELECT lokpasien.nama_pasien FROM lokpasien WHERE lokdaftar.Id_Pasien = lokpasien.Id_Pasien)', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->Nama_Pasien->IsCustom = TRUE; // Custom field
		$this->Nama_Pasien->Sortable = TRUE; // Allow sort
		$this->fields['Nama_Pasien'] = &$this->Nama_Pasien;

		// No_RM
		$this->No_RM = new DbField('lokdaftar', 'lokdaftar', 'x_No_RM', 'No_RM', '(SELECT lokpasien.no_rm FROM lokpasien WHERE lokdaftar.Id_Pasien = lokpasien.Id_Pasien)', '(SELECT lokpasien.no_rm FROM lokpasien WHERE lokdaftar.Id_Pasien = lokpasien.Id_Pasien)', 200, -1, FALSE, '(SELECT lokpasien.no_rm FROM lokpasien WHERE lokdaftar.Id_Pasien = lokpasien.Id_Pasien)', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->No_RM->IsCustom = TRUE; // Custom field
		$this->No_RM->Sortable = TRUE; // Allow sort
		$this->fields['No_RM'] = &$this->No_RM;

		// Tgl_Lahir
		$this->Tgl_Lahir = new DbField('lokdaftar', 'lokdaftar', 'x_Tgl_Lahir', 'Tgl_Lahir', '(SELECT lokpasien.tgl_lahir FROM lokpasien WHERE lokdaftar.Id_Pasien = lokpasien.Id_Pasien)', CastDateFieldForLike('(SELECT lokpasien.tgl_lahir FROM lokpasien WHERE lokdaftar.Id_Pasien = lokpasien.Id_Pasien)', 7, "DB"), 133, 7, FALSE, '(SELECT lokpasien.tgl_lahir FROM lokpasien WHERE lokdaftar.Id_Pasien = lokpasien.Id_Pasien)', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->Tgl_Lahir->IsCustom = TRUE; // Custom field
		$this->Tgl_Lahir->Sortable = TRUE; // Allow sort
		$this->Tgl_Lahir->DefaultErrorMessage = str_replace("%s", $GLOBALS["DATE_SEPARATOR"], $Language->phrase("IncorrectDateDMY"));
		$this->fields['Tgl_Lahir'] = &$this->Tgl_Lahir;

		// Jenis_Kelamin
		$this->Jenis_Kelamin = new DbField('lokdaftar', 'lokdaftar', 'x_Jenis_Kelamin', 'Jenis_Kelamin', '(SELECT lokpasien.Jenis_Kelamin FROM lokpasien WHERE lokdaftar.Id_Pasien = lokpasien.Id_Pasien)', '(SELECT lokpasien.Jenis_Kelamin FROM lokpasien WHERE lokdaftar.Id_Pasien = lokpasien.Id_Pasien)', 200, -1, FALSE, '(SELECT lokpasien.Jenis_Kelamin FROM lokpasien WHERE lokdaftar.Id_Pasien = lokpasien.Id_Pasien)', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->Jenis_Kelamin->IsCustom = TRUE; // Custom field
		$this->Jenis_Kelamin->Sortable = TRUE; // Allow sort
		$this->fields['Jenis_Kelamin'] = &$this->Jenis_Kelamin;

		// Alamat
		$this->Alamat = new DbField('lokdaftar', 'lokdaftar', 'x_Alamat', 'Alamat', '(SELECT lokpasien.alamat FROM lokpasien WHERE lokdaftar.Id_Pasien = lokpasien.Id_Pasien)', '(SELECT lokpasien.alamat FROM lokpasien WHERE lokdaftar.Id_Pasien = lokpasien.Id_Pasien)', 200, -1, FALSE, '(SELECT lokpasien.alamat FROM lokpasien WHERE lokdaftar.Id_Pasien = lokpasien.Id_Pasien)', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXTAREA');
		$this->Alamat->IsCustom = TRUE; // Custom field
		$this->Alamat->Sortable = TRUE; // Allow sort
		$this->fields['Alamat'] = &$this->Alamat;

		// Id_Poliklinik
		$this->Id_Poliklinik = new DbField('lokdaftar', 'lokdaftar', 'x_Id_Poliklinik', 'Id_Poliklinik', '`Id_Poliklinik`', '`Id_Poliklinik`', 200, -1, FALSE, '`Id_Poliklinik`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'RADIO');
		$this->Id_Poliklinik->Nullable = FALSE; // NOT NULL field
		$this->Id_Poliklinik->Required = TRUE; // Required field
		$this->Id_Poliklinik->Sortable = TRUE; // Allow sort
		$this->Id_Poliklinik->Lookup = new Lookup('Id_Poliklinik', 'lokpoliklinik', FALSE, 'Id_Poliklinik', ["Nama_Poliklinik","","",""], [], [], [], [], [], [], '', '');
		$this->Id_Poliklinik->DefaultErrorMessage = $Language->phrase("IncorrectInteger");
		$this->fields['Id_Poliklinik'] = &$this->Id_Poliklinik;

		// Poliklinik
		$this->Poliklinik = new DbField('lokdaftar', 'lokdaftar', 'x_Poliklinik', 'Poliklinik', '(SELECT Nama_Poliklinik FROM lokpoliklinik WHERE lokdaftar.Id_Poliklinik = lokpoliklinik.Id_Poliklinik)', '(SELECT Nama_Poliklinik FROM lokpoliklinik WHERE lokdaftar.Id_Poliklinik = lokpoliklinik.Id_Poliklinik)', 200, -1, FALSE, '(SELECT Nama_Poliklinik FROM lokpoliklinik WHERE lokdaftar.Id_Poliklinik = lokpoliklinik.Id_Poliklinik)', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->Poliklinik->IsCustom = TRUE; // Custom field
		$this->Poliklinik->Sortable = TRUE; // Allow sort
		$this->fields['Poliklinik'] = &$this->Poliklinik;

		// Rawat
		$this->Rawat = new DbField('lokdaftar', 'lokdaftar', 'x_Rawat', 'Rawat', '`Rawat`', '`Rawat`', 200, -1, FALSE, '`Rawat`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'HIDDEN');
		$this->Rawat->Nullable = FALSE; // NOT NULL field
		$this->Rawat->Sortable = FALSE; // Allow sort
		$this->fields['Rawat'] = &$this->Rawat;

		// Id_Rujukan
		$this->Id_Rujukan = new DbField('lokdaftar', 'lokdaftar', 'x_Id_Rujukan', 'Id_Rujukan', '`Id_Rujukan`', '`Id_Rujukan`', 200, -1, FALSE, '`Id_Rujukan`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'RADIO');
		$this->Id_Rujukan->Nullable = FALSE; // NOT NULL field
		$this->Id_Rujukan->Required = TRUE; // Required field
		$this->Id_Rujukan->Sortable = TRUE; // Allow sort
		$this->Id_Rujukan->Lookup = new Lookup('Id_Rujukan', 'lokasalrujukan', FALSE, 'Id_Rujukan', ["Rujukan","","",""], [], [], [], [], [], [], '', '');
		$this->Id_Rujukan->DefaultErrorMessage = $Language->phrase("IncorrectInteger");
		$this->fields['Id_Rujukan'] = &$this->Id_Rujukan;

		// Id_JenisPasien
		$this->Id_JenisPasien = new DbField('lokdaftar', 'lokdaftar', 'x_Id_JenisPasien', 'Id_JenisPasien', '`Id_JenisPasien`', '`Id_JenisPasien`', 200, -1, FALSE, '`Id_JenisPasien`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'RADIO');
		$this->Id_JenisPasien->Nullable = FALSE; // NOT NULL field
		$this->Id_JenisPasien->Required = TRUE; // Required field
		$this->Id_JenisPasien->Sortable = TRUE; // Allow sort
		$this->Id_JenisPasien->Lookup = new Lookup('Id_JenisPasien', 'lokjenispasien', FALSE, 'Id_JenisPasien', ["Jenis_Pasien","","",""], [], [], [], [], [], [], '', '');
		$this->Id_JenisPasien->DefaultErrorMessage = $Language->phrase("IncorrectInteger");
		$this->fields['Id_JenisPasien'] = &$this->Id_JenisPasien;

		// Lama_Baru
		$this->Lama_Baru = new DbField('lokdaftar', 'lokdaftar', 'x_Lama_Baru', 'Lama_Baru', '`Lama_Baru`', '`Lama_Baru`', 200, -1, FALSE, '`Lama_Baru`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->Lama_Baru->Nullable = FALSE; // NOT NULL field
		$this->Lama_Baru->Required = TRUE; // Required field
		$this->Lama_Baru->Sortable = TRUE; // Allow sort
		$this->fields['Lama_Baru'] = &$this->Lama_Baru;

		// Id_BiayaDaftar
		$this->Id_BiayaDaftar = new DbField('lokdaftar', 'lokdaftar', 'x_Id_BiayaDaftar', 'Id_BiayaDaftar', '`Id_BiayaDaftar`', '`Id_BiayaDaftar`', 200, -1, FALSE, '`Id_BiayaDaftar`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'RADIO');
		$this->Id_BiayaDaftar->Nullable = FALSE; // NOT NULL field
		$this->Id_BiayaDaftar->Required = TRUE; // Required field
		$this->Id_BiayaDaftar->Sortable = TRUE; // Allow sort
		$this->Id_BiayaDaftar->Lookup = new Lookup('Id_BiayaDaftar', 'lokbiayadaftar', FALSE, 'Id_Biayadaftar', ["Nama_Biaya","","",""], [], [], [], [], ["Total_Biaya"], ["x_Total_Biaya"], '', '');
		$this->fields['Id_BiayaDaftar'] = &$this->Id_BiayaDaftar;

		// Total_Biaya
		$this->Total_Biaya = new DbField('lokdaftar', 'lokdaftar', 'x_Total_Biaya', 'Total_Biaya', '`Total_Biaya`', '`Total_Biaya`', 131, -1, FALSE, '`Total_Biaya`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->Total_Biaya->Nullable = FALSE; // NOT NULL field
		$this->Total_Biaya->Sortable = TRUE; // Allow sort
		$this->fields['Total_Biaya'] = &$this->Total_Biaya;

		// Petugas
		$this->Petugas = new DbField('lokdaftar', 'lokdaftar', 'x_Petugas', 'Petugas', '`Petugas`', '`Petugas`', 200, -1, FALSE, '`Petugas`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'HIDDEN');
		$this->Petugas->Nullable = FALSE; // NOT NULL field
		$this->Petugas->Sortable = TRUE; // Allow sort
		$this->fields['Petugas'] = &$this->Petugas;

		// Status
		$this->Status = new DbField('lokdaftar', 'lokdaftar', 'x_Status', 'Status', '`Status`', '`Status`', 200, -1, FALSE, '`Status`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'HIDDEN');
		$this->Status->Nullable = FALSE; // NOT NULL field
		$this->Status->Sortable = TRUE; // Allow sort
		$this->fields['Status'] = &$this->Status;
	}

	// Field Visibility
	public function getFieldVisibility($fldParm)
	{
		global $Security;
		return $this->$fldParm->Visible; // Returns original value
	}

	// Set left column class (must be predefined col-*-* classes of Bootstrap grid system)
	function setLeftColumnClass($class)
	{
		if (preg_match('/^col\-(\w+)\-(\d+)$/', $class, $match)) {
			$this->LeftColumnClass = $class . " col-form-label ew-label";
			$this->RightColumnClass = "col-" . $match[1] . "-" . strval(12 - (int)$match[2]);
			$this->OffsetColumnClass = $this->RightColumnClass . " " . str_replace("col-", "offset-", $class);
			$this->TableLeftColumnClass = preg_replace('/^col-\w+-(\d+)$/', "w-col-$1", $class); // Change to w-col-*
		}
	}

	// Multiple column sort
	public function updateSort(&$fld, $ctrl)
	{
		if ($this->CurrentOrder == $fld->Name) {
			$sortField = $fld->Expression;
			$lastSort = $fld->getSort();
			if ($this->CurrentOrderType == "ASC" || $this->CurrentOrderType == "DESC") {
				$thisSort = $this->CurrentOrderType;
			} else {
				$thisSort = ($lastSort == "ASC") ? "DESC" : "ASC";
			}
			$fld->setSort($thisSort);
			if ($ctrl) {
				$orderBy = $this->getSessionOrderBy();
				if (ContainsString($orderBy, $sortField . " " . $lastSort)) {
					$orderBy = str_replace($sortField . " " . $lastSort, $sortField . " " . $thisSort, $orderBy);
				} else {
					if ($orderBy <> "")
						$orderBy .= ", ";
					$orderBy .= $sortField . " " . $thisSort;
				}
				$this->setSessionOrderBy($orderBy); // Save to Session
			} else {
				$this->setSessionOrderBy($sortField . " " . $thisSort); // Save to Session
			}
		} else {
			if (!$ctrl)
				$fld->setSort("");
		}
	}

	// Table level SQL
	public function getSqlFrom() // From
	{
		return ($this->SqlFrom <> "") ? $this->SqlFrom : "`lokdaftar`";
	}
	public function sqlFrom() // For backward compatibility
	{
		return $this->getSqlFrom();
	}
	public function setSqlFrom($v)
	{
		$this->SqlFrom = $v;
	}
	public function getSqlSelect() // Select
	{
		return ($this->SqlSelect <> "") ? $this->SqlSelect : "SELECT *, (SELECT lokpasien.nama_pasien FROM lokpasien WHERE lokdaftar.Id_Pasien = lokpasien.Id_Pasien) AS `Nama_Pasien`, (SELECT lokpasien.no_rm FROM lokpasien WHERE lokdaftar.Id_Pasien = lokpasien.Id_Pasien) AS `No_RM`, (SELECT lokpasien.tgl_lahir FROM lokpasien WHERE lokdaftar.Id_Pasien = lokpasien.Id_Pasien) AS `Tgl_Lahir`, (SELECT lokpasien.Jenis_Kelamin FROM lokpasien WHERE lokdaftar.Id_Pasien = lokpasien.Id_Pasien) AS `Jenis_Kelamin`, (SELECT lokpasien.alamat FROM lokpasien WHERE lokdaftar.Id_Pasien = lokpasien.Id_Pasien) AS `Alamat`, (SELECT Nama_Poliklinik FROM lokpoliklinik WHERE lokdaftar.Id_Poliklinik = lokpoliklinik.Id_Poliklinik) AS `Poliklinik` FROM " . $this->getSqlFrom();
	}
	public function sqlSelect() // For backward compatibility
	{
		return $this->getSqlSelect();
	}
	public function setSqlSelect($v)
	{
		$this->SqlSelect = $v;
	}
	public function getSqlWhere() // Where
	{
		$where = ($this->SqlWhere <> "") ? $this->SqlWhere : "";
		$this->TableFilter = "`Rawat`='RAWAT JALAN POLIKLINIK'";
		AddFilter($where, $this->TableFilter);
		return $where;
	}
	public function sqlWhere() // For backward compatibility
	{
		return $this->getSqlWhere();
	}
	public function setSqlWhere($v)
	{
		$this->SqlWhere = $v;
	}
	public function getSqlGroupBy() // Group By
	{
		return ($this->SqlGroupBy <> "") ? $this->SqlGroupBy : "";
	}
	public function sqlGroupBy() // For backward compatibility
	{
		return $this->getSqlGroupBy();
	}
	public function setSqlGroupBy($v)
	{
		$this->SqlGroupBy = $v;
	}
	public function getSqlHaving() // Having
	{
		return ($this->SqlHaving <> "") ? $this->SqlHaving : "";
	}
	public function sqlHaving() // For backward compatibility
	{
		return $this->getSqlHaving();
	}
	public function setSqlHaving($v)
	{
		$this->SqlHaving = $v;
	}
	public function getSqlOrderBy() // Order By
	{
		return ($this->SqlOrderBy <> "") ? $this->SqlOrderBy : "`Tgl_Daftar` DESC,`Waktu` DESC";
	}
	public function sqlOrderBy() // For backward compatibility
	{
		return $this->getSqlOrderBy();
	}
	public function setSqlOrderBy($v)
	{
		$this->SqlOrderBy = $v;
	}

	// Apply User ID filters
	public function applyUserIDFilters($filter)
	{
		return $filter;
	}

	// Check if User ID security allows view all
	public function userIDAllow($id = "")
	{
		$allow = USER_ID_ALLOW;
		switch ($id) {
			case "add":
			case "copy":
			case "gridadd":
			case "register":
			case "addopt":
				return (($allow & 1) == 1);
			case "edit":
			case "gridedit":
			case "update":
			case "changepwd":
			case "forgotpwd":
				return (($allow & 4) == 4);
			case "delete":
				return (($allow & 2) == 2);
			case "view":
				return (($allow & 32) == 32);
			case "search":
				return (($allow & 64) == 64);
			default:
				return (($allow & 8) == 8);
		}
	}

	// Get SQL
	public function getSql($where, $orderBy = "")
	{
		return BuildSelectSql($this->getSqlSelect(), $this->getSqlWhere(),
			$this->getSqlGroupBy(), $this->getSqlHaving(), $this->getSqlOrderBy(),
			$where, $orderBy);
	}

	// Table SQL
	public function getCurrentSql()
	{
		$filter = $this->CurrentFilter;
		$filter = $this->applyUserIDFilters($filter);
		$sort = $this->getSessionOrderBy();
		return $this->getSql($filter, $sort);
	}

	// Table SQL with List page filter
	public function getListSql()
	{
		$filter = $this->UseSessionForListSql ? $this->getSessionWhere() : "";
		AddFilter($filter, $this->CurrentFilter);
		$filter = $this->applyUserIDFilters($filter);
		$this->Recordset_Selecting($filter);
		$select = $this->getSqlSelect();
		$sort = $this->UseSessionForListSql ? $this->getSessionOrderBy() : "";
		return BuildSelectSql($select, $this->getSqlWhere(), $this->getSqlGroupBy(),
			$this->getSqlHaving(), $this->getSqlOrderBy(), $filter, $sort);
	}

	// Get ORDER BY clause
	public function getOrderBy()
	{
		$sort = $this->getSessionOrderBy();
		return BuildSelectSql("", "", "", "", $this->getSqlOrderBy(), "", $sort);
	}

	// Get record count
	public function getRecordCount($sql)
	{
		$cnt = -1;
		$rs = NULL;
		$sql = preg_replace('/\/\*BeginOrderBy\*\/[\s\S]+\/\*EndOrderBy\*\//', "", $sql); // Remove ORDER BY clause (MSSQL)
		$pattern = '/^SELECT\s([\s\S]+)\sFROM\s/i';

		// Skip Custom View / SubQuery and SELECT DISTINCT
		if (($this->TableType == 'TABLE' || $this->TableType == 'VIEW' || $this->TableType == 'LINKTABLE') &&
			preg_match($pattern, $sql) && !preg_match('/\(\s*(SELECT[^)]+)\)/i', $sql) && !preg_match('/^\s*select\s+distinct\s+/i', $sql)) {
			$sqlwrk = "SELECT COUNT(*) FROM " . preg_replace($pattern, "", $sql);
		} else {
			$sqlwrk = "SELECT COUNT(*) FROM (" . $sql . ") COUNT_TABLE";
		}
		$conn = &$this->getConnection();
		if ($rs = $conn->execute($sqlwrk)) {
			if (!$rs->EOF && $rs->FieldCount() > 0) {
				$cnt = $rs->fields[0];
				$rs->close();
			}
			return (int)$cnt;
		}

		// Unable to get count, get record count directly
		if ($rs = $conn->execute($sql)) {
			$cnt = $rs->RecordCount();
			$rs->close();
			return (int)$cnt;
		}
		return $cnt;
	}

	// Get record count based on filter (for detail record count in master table pages)
	public function loadRecordCount($filter)
	{
		$origFilter = $this->CurrentFilter;
		$this->CurrentFilter = $filter;
		$this->Recordset_Selecting($this->CurrentFilter);
		$select = $this->TableType == 'CUSTOMVIEW' ? $this->getSqlSelect() : "SELECT * FROM " . $this->getSqlFrom();
		$groupBy = $this->TableType == 'CUSTOMVIEW' ? $this->getSqlGroupBy() : "";
		$having = $this->TableType == 'CUSTOMVIEW' ? $this->getSqlHaving() : "";
		$sql = BuildSelectSql($select, $this->getSqlWhere(), $groupBy, $having, "", $this->CurrentFilter, "");
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
		$this->Recordset_Selecting($filter);
		$select = $this->TableType == 'CUSTOMVIEW' ? $this->getSqlSelect() : "SELECT * FROM " . $this->getSqlFrom();
		$groupBy = $this->TableType == 'CUSTOMVIEW' ? $this->getSqlGroupBy() : "";
		$having = $this->TableType == 'CUSTOMVIEW' ? $this->getSqlHaving() : "";
		$sql = BuildSelectSql($select, $this->getSqlWhere(), $groupBy, $having, "", $filter, "");
		$cnt = $this->getRecordCount($sql);
		return $cnt;
	}

	// INSERT statement
	protected function insertSql(&$rs)
	{
		$names = "";
		$values = "";
		foreach ($rs as $name => $value) {
			if (!isset($this->fields[$name]) || $this->fields[$name]->IsCustom)
				continue;
			$names .= $this->fields[$name]->Expression . ",";
			$values .= QuotedValue($value, $this->fields[$name]->DataType, $this->Dbid) . ",";
		}
		$names = preg_replace('/,+$/', "", $names);
		$values = preg_replace('/,+$/', "", $values);
		return "INSERT INTO " . $this->UpdateTable . " ($names) VALUES ($values)";
	}

	// Insert
	public function insert(&$rs)
	{
		$conn = &$this->getConnection();
		$success = $conn->execute($this->insertSql($rs));
		if ($success) {
		}
		return $success;
	}

	// UPDATE statement
	protected function updateSql(&$rs, $where = "", $curfilter = TRUE)
	{
		$sql = "UPDATE " . $this->UpdateTable . " SET ";
		foreach ($rs as $name => $value) {
			if (!isset($this->fields[$name]) || $this->fields[$name]->IsCustom || $this->fields[$name]->IsPrimaryKey)
				continue;
			$sql .= $this->fields[$name]->Expression . "=";
			$sql .= QuotedValue($value, $this->fields[$name]->DataType, $this->Dbid) . ",";
		}
		$sql = preg_replace('/,+$/', "", $sql);
		$filter = ($curfilter) ? $this->CurrentFilter : "";
		if (is_array($where))
			$where = $this->arrayToFilter($where);
		AddFilter($filter, $where);
		if ($filter <> "")
			$sql .= " WHERE " . $filter;
		return $sql;
	}

	// Update
	public function update(&$rs, $where = "", $rsold = NULL, $curfilter = TRUE)
	{
		$conn = &$this->getConnection();
		$success = $conn->execute($this->updateSql($rs, $where, $curfilter));
		return $success;
	}

	// DELETE statement
	protected function deleteSql(&$rs, $where = "", $curfilter = TRUE)
	{
		$sql = "DELETE FROM " . $this->UpdateTable . " WHERE ";
		if (is_array($where))
			$where = $this->arrayToFilter($where);
		if ($rs) {
			if (array_key_exists('Id_Daftar', $rs))
				AddFilter($where, QuotedName('Id_Daftar', $this->Dbid) . '=' . QuotedValue($rs['Id_Daftar'], $this->Id_Daftar->DataType, $this->Dbid));
		}
		$filter = ($curfilter) ? $this->CurrentFilter : "";
		AddFilter($filter, $where);
		if ($filter <> "")
			$sql .= $filter;
		else
			$sql .= "0=1"; // Avoid delete
		return $sql;
	}

	// Delete
	public function delete(&$rs, $where = "", $curfilter = FALSE)
	{
		$success = TRUE;
		$conn = &$this->getConnection();
		if ($success)
			$success = $conn->execute($this->deleteSql($rs, $where, $curfilter));
		return $success;
	}

	// Load DbValue from recordset or array
	protected function loadDbValues(&$rs)
	{
		if (!$rs || !is_array($rs) && $rs->EOF)
			return;
		$row = is_array($rs) ? $rs : $rs->fields;
		$this->Id_Daftar->DbValue = $row['Id_Daftar'];
		$this->Tgl_Daftar->DbValue = $row['Tgl_Daftar'];
		$this->Waktu->DbValue = $row['Waktu'];
		$this->Id_Pasien->DbValue = $row['Id_Pasien'];
		$this->Nama_Pasien->DbValue = $row['Nama_Pasien'];
		$this->No_RM->DbValue = $row['No_RM'];
		$this->Tgl_Lahir->DbValue = $row['Tgl_Lahir'];
		$this->Jenis_Kelamin->DbValue = $row['Jenis_Kelamin'];
		$this->Alamat->DbValue = $row['Alamat'];
		$this->Id_Poliklinik->DbValue = $row['Id_Poliklinik'];
		$this->Poliklinik->DbValue = $row['Poliklinik'];
		$this->Rawat->DbValue = $row['Rawat'];
		$this->Id_Rujukan->DbValue = $row['Id_Rujukan'];
		$this->Id_JenisPasien->DbValue = $row['Id_JenisPasien'];
		$this->Lama_Baru->DbValue = $row['Lama_Baru'];
		$this->Id_BiayaDaftar->DbValue = $row['Id_BiayaDaftar'];
		$this->Total_Biaya->DbValue = $row['Total_Biaya'];
		$this->Petugas->DbValue = $row['Petugas'];
		$this->Status->DbValue = $row['Status'];
	}

	// Delete uploaded files
	public function deleteUploadedFiles($row)
	{
		$this->loadDbValues($row);
	}

	// Record filter WHERE clause
	protected function sqlKeyFilter()
	{
		return "`Id_Daftar` = '@Id_Daftar@'";
	}

	// Get record filter
	public function getRecordFilter($row = NULL)
	{
		$keyFilter = $this->sqlKeyFilter();
		$val = is_array($row) ? (array_key_exists('Id_Daftar', $row) ? $row['Id_Daftar'] : NULL) : $this->Id_Daftar->CurrentValue;
		if ($val == NULL)
			return "0=1"; // Invalid key
		else
			$keyFilter = str_replace("@Id_Daftar@", AdjustSql($val, $this->Dbid), $keyFilter); // Replace key value
		return $keyFilter;
	}

	// Return page URL
	public function getReturnUrl()
	{
		$name = PROJECT_NAME . "_" . $this->TableVar . "_" . TABLE_RETURN_URL;

		// Get referer URL automatically
		if (ServerVar("HTTP_REFERER") <> "" && ReferPageName() <> CurrentPageName() && ReferPageName() <> "login.php") // Referer not same page or login page
			$_SESSION[$name] = ServerVar("HTTP_REFERER"); // Save to Session
		if (@$_SESSION[$name] <> "") {
			return $_SESSION[$name];
		} else {
			return "lokdaftarlist.php";
		}
	}
	public function setReturnUrl($v)
	{
		$_SESSION[PROJECT_NAME . "_" . $this->TableVar . "_" . TABLE_RETURN_URL] = $v;
	}

	// Get modal caption
	public function getModalCaption($pageName)
	{
		global $Language;
		if ($pageName == "lokdaftarview.php")
			return $Language->phrase("View");
		elseif ($pageName == "lokdaftaredit.php")
			return $Language->phrase("Edit");
		elseif ($pageName == "lokdaftaradd.php")
			return $Language->phrase("Add");
		else
			return "";
	}

	// List URL
	public function getListUrl()
	{
		return "lokdaftarlist.php";
	}

	// View URL
	public function getViewUrl($parm = "")
	{
		if ($parm <> "")
			$url = $this->keyUrl("lokdaftarview.php", $this->getUrlParm($parm));
		else
			$url = $this->keyUrl("lokdaftarview.php", $this->getUrlParm(TABLE_SHOW_DETAIL . "="));
		return $this->addMasterUrl($url);
	}

	// Add URL
	public function getAddUrl($parm = "")
	{
		if ($parm <> "")
			$url = "lokdaftaradd.php?" . $this->getUrlParm($parm);
		else
			$url = "lokdaftaradd.php";
		return $this->addMasterUrl($url);
	}

	// Edit URL
	public function getEditUrl($parm = "")
	{
		$url = $this->keyUrl("lokdaftaredit.php", $this->getUrlParm($parm));
		return $this->addMasterUrl($url);
	}

	// Inline edit URL
	public function getInlineEditUrl()
	{
		$url = $this->keyUrl(CurrentPageName(), $this->getUrlParm("action=edit"));
		return $this->addMasterUrl($url);
	}

	// Copy URL
	public function getCopyUrl($parm = "")
	{
		$url = $this->keyUrl("lokdaftaradd.php", $this->getUrlParm($parm));
		return $this->addMasterUrl($url);
	}

	// Inline copy URL
	public function getInlineCopyUrl()
	{
		$url = $this->keyUrl(CurrentPageName(), $this->getUrlParm("action=copy"));
		return $this->addMasterUrl($url);
	}

	// Delete URL
	public function getDeleteUrl()
	{
		return $this->keyUrl("lokdaftardelete.php", $this->getUrlParm());
	}

	// Add master url
	public function addMasterUrl($url)
	{
		return $url;
	}
	public function keyToJson($htmlEncode = FALSE)
	{
		$json = "";
		$json .= "Id_Daftar:" . JsonEncode($this->Id_Daftar->CurrentValue, "string");
		$json = "{" . $json . "}";
		if ($htmlEncode)
			$json = HtmlEncode($json);
		return $json;
	}

	// Add key value to URL
	public function keyUrl($url, $parm = "")
	{
		$url = $url . "?";
		if ($parm <> "")
			$url .= $parm . "&";
		if ($this->Id_Daftar->CurrentValue != NULL) {
			$url .= "Id_Daftar=" . urlencode($this->Id_Daftar->CurrentValue);
		} else {
			return "javascript:ew.alert(ew.language.phrase('InvalidRecord'));";
		}
		return $url;
	}

	// Sort URL
	public function sortUrl(&$fld)
	{
		if ($this->CurrentAction || $this->isExport() ||
			in_array($fld->Type, array(128, 204, 205))) { // Unsortable data type
				return "";
		} elseif ($fld->Sortable) {
			$urlParm = $this->getUrlParm("order=" . urlencode($fld->Name) . "&amp;ordertype=" . $fld->reverseSort());
			return $this->addMasterUrl(CurrentPageName() . "?" . $urlParm);
		} else {
			return "";
		}
	}

	// Get record keys from Post/Get/Session
	public function getRecordKeys()
	{
		global $COMPOSITE_KEY_SEPARATOR;
		$arKeys = array();
		$arKey = array();
		if (Param("key_m") !== NULL) {
			$arKeys = Param("key_m");
			$cnt = count($arKeys);
		} else {
			if (Param("Id_Daftar") !== NULL)
				$arKeys[] = Param("Id_Daftar");
			elseif (IsApi() && Key(0) !== NULL)
				$arKeys[] = Key(0);
			elseif (IsApi() && Route(2) !== NULL)
				$arKeys[] = Route(2);
			else
				$arKeys = NULL; // Do not setup

			//return $arKeys; // Do not return yet, so the values will also be checked by the following code
		}

		// Check keys
		$ar = array();
		if (is_array($arKeys)) {
			foreach ($arKeys as $key) {
				$ar[] = $key;
			}
		}
		return $ar;
	}

	// Get filter from record keys
	public function getFilterFromRecordKeys()
	{
		$arKeys = $this->getRecordKeys();
		$keyFilter = "";
		foreach ($arKeys as $key) {
			if ($keyFilter <> "") $keyFilter .= " OR ";
			$this->Id_Daftar->CurrentValue = $key;
			$keyFilter .= "(" . $this->getRecordFilter() . ")";
		}
		return $keyFilter;
	}

	// Load rows based on filter
	public function &loadRs($filter)
	{

		// Set up filter (WHERE Clause)
		$sql = $this->getSql($filter);
		$conn = &$this->getConnection();
		$rs = $conn->execute($sql);
		return $rs;
	}

	// Load row values from recordset
	public function loadListRowValues(&$rs)
	{
		$this->Id_Daftar->setDbValue($rs->fields('Id_Daftar'));
		$this->Tgl_Daftar->setDbValue($rs->fields('Tgl_Daftar'));
		$this->Waktu->setDbValue($rs->fields('Waktu'));
		$this->Id_Pasien->setDbValue($rs->fields('Id_Pasien'));
		$this->Nama_Pasien->setDbValue($rs->fields('Nama_Pasien'));
		$this->No_RM->setDbValue($rs->fields('No_RM'));
		$this->Tgl_Lahir->setDbValue($rs->fields('Tgl_Lahir'));
		$this->Jenis_Kelamin->setDbValue($rs->fields('Jenis_Kelamin'));
		$this->Alamat->setDbValue($rs->fields('Alamat'));
		$this->Id_Poliklinik->setDbValue($rs->fields('Id_Poliklinik'));
		$this->Poliklinik->setDbValue($rs->fields('Poliklinik'));
		$this->Rawat->setDbValue($rs->fields('Rawat'));
		$this->Id_Rujukan->setDbValue($rs->fields('Id_Rujukan'));
		$this->Id_JenisPasien->setDbValue($rs->fields('Id_JenisPasien'));
		$this->Lama_Baru->setDbValue($rs->fields('Lama_Baru'));
		$this->Id_BiayaDaftar->setDbValue($rs->fields('Id_BiayaDaftar'));
		$this->Total_Biaya->setDbValue($rs->fields('Total_Biaya'));
		$this->Petugas->setDbValue($rs->fields('Petugas'));
		$this->Status->setDbValue($rs->fields('Status'));
	}

	// Render list row values
	public function renderListRow()
	{
		global $Security, $CurrentLanguage, $Language;

		// Call Row Rendering event
		$this->Row_Rendering();

		// Common render codes
		// Id_Daftar

		$this->Id_Daftar->CellCssStyle = "white-space: nowrap;";

		// Tgl_Daftar
		$this->Tgl_Daftar->CellCssStyle = "white-space: nowrap;";

		// Waktu
		// Id_Pasien
		// Nama_Pasien
		// No_RM
		// Tgl_Lahir

		$this->Tgl_Lahir->CellCssStyle = "white-space: nowrap;";

		// Jenis_Kelamin
		// Alamat
		// Id_Poliklinik
		// Poliklinik
		// Rawat

		$this->Rawat->CellCssStyle = "white-space: nowrap;";

		// Id_Rujukan
		// Id_JenisPasien
		// Lama_Baru
		// Id_BiayaDaftar
		// Total_Biaya

		$this->Total_Biaya->CellCssStyle = "white-space: nowrap;";

		// Petugas
		// Status
		// Id_Daftar

		$this->Id_Daftar->ViewValue = $this->Id_Daftar->CurrentValue;
		$this->Id_Daftar->ViewCustomAttributes = "";

		// Tgl_Daftar
		$this->Tgl_Daftar->ViewValue = $this->Tgl_Daftar->CurrentValue;
		$this->Tgl_Daftar->ViewValue = FormatDateTime($this->Tgl_Daftar->ViewValue, 7);
		$this->Tgl_Daftar->ViewCustomAttributes = "";

		// Waktu
		$this->Waktu->ViewValue = $this->Waktu->CurrentValue;
		$this->Waktu->ViewValue = FormatDateTime($this->Waktu->ViewValue, 4);
		$this->Waktu->ViewCustomAttributes = "";

		// Id_Pasien
		$this->Id_Pasien->ViewValue = $this->Id_Pasien->CurrentValue;
		$this->Id_Pasien->ViewCustomAttributes = "";

		// Nama_Pasien
		$this->Nama_Pasien->ViewValue = $this->Nama_Pasien->CurrentValue;
		$this->Nama_Pasien->ViewValue = strtoupper($this->Nama_Pasien->ViewValue);
		$this->Nama_Pasien->ViewCustomAttributes = "";

		// No_RM
		$this->No_RM->ViewValue = $this->No_RM->CurrentValue;
		$this->No_RM->ViewCustomAttributes = "";

		// Tgl_Lahir
		$this->Tgl_Lahir->ViewValue = $this->Tgl_Lahir->CurrentValue;
		$this->Tgl_Lahir->ViewValue = FormatDateTime($this->Tgl_Lahir->ViewValue, 7);
		$this->Tgl_Lahir->ViewCustomAttributes = "";

		// Jenis_Kelamin
		$this->Jenis_Kelamin->ViewValue = $this->Jenis_Kelamin->CurrentValue;
		$this->Jenis_Kelamin->ViewCustomAttributes = "";

		// Alamat
		$this->Alamat->ViewValue = $this->Alamat->CurrentValue;
		$this->Alamat->ViewCustomAttributes = "";

		// Id_Poliklinik
		$curVal = strval($this->Id_Poliklinik->CurrentValue);
		if ($curVal <> "") {
			$this->Id_Poliklinik->ViewValue = $this->Id_Poliklinik->lookupCacheOption($curVal);
			if ($this->Id_Poliklinik->ViewValue === NULL) { // Lookup from database
				$filterWrk = "`Id_Poliklinik`" . SearchString("=", $curVal, DATATYPE_STRING, "");
				$lookupFilter = function() {
					return "`Id_Poliklinik`!='{290320191250308A243FA9DF67A28BD1C5722022B148EE}'";
				};
				$lookupFilter = $lookupFilter->bindTo($this);
				$sqlWrk = $this->Id_Poliklinik->Lookup->getSql(FALSE, $filterWrk, $lookupFilter, $this);
				$rswrk = Conn()->execute($sqlWrk);
				if ($rswrk && !$rswrk->EOF) { // Lookup values found
					$arwrk = array();
					$arwrk[1] = $rswrk->fields('df');
					$this->Id_Poliklinik->ViewValue = $this->Id_Poliklinik->displayValue($arwrk);
					$rswrk->Close();
				} else {
					$this->Id_Poliklinik->ViewValue = $this->Id_Poliklinik->CurrentValue;
				}
			}
		} else {
			$this->Id_Poliklinik->ViewValue = NULL;
		}
		$this->Id_Poliklinik->ViewCustomAttributes = "";

		// Poliklinik
		$this->Poliklinik->ViewValue = $this->Poliklinik->CurrentValue;
		$this->Poliklinik->ViewCustomAttributes = "";

		// Rawat
		$this->Rawat->ViewValue = $this->Rawat->CurrentValue;
		$this->Rawat->ViewCustomAttributes = "";

		// Id_Rujukan
		$curVal = strval($this->Id_Rujukan->CurrentValue);
		if ($curVal <> "") {
			$this->Id_Rujukan->ViewValue = $this->Id_Rujukan->lookupCacheOption($curVal);
			if ($this->Id_Rujukan->ViewValue === NULL) { // Lookup from database
				$filterWrk = "`Id_Rujukan`" . SearchString("=", $curVal, DATATYPE_STRING, "");
				$sqlWrk = $this->Id_Rujukan->Lookup->getSql(FALSE, $filterWrk, '', $this);
				$rswrk = Conn()->execute($sqlWrk);
				if ($rswrk && !$rswrk->EOF) { // Lookup values found
					$arwrk = array();
					$arwrk[1] = $rswrk->fields('df');
					$this->Id_Rujukan->ViewValue = $this->Id_Rujukan->displayValue($arwrk);
					$rswrk->Close();
				} else {
					$this->Id_Rujukan->ViewValue = $this->Id_Rujukan->CurrentValue;
				}
			}
		} else {
			$this->Id_Rujukan->ViewValue = NULL;
		}
		$this->Id_Rujukan->ViewCustomAttributes = "";

		// Id_JenisPasien
		$curVal = strval($this->Id_JenisPasien->CurrentValue);
		if ($curVal <> "") {
			$this->Id_JenisPasien->ViewValue = $this->Id_JenisPasien->lookupCacheOption($curVal);
			if ($this->Id_JenisPasien->ViewValue === NULL) { // Lookup from database
				$filterWrk = "`Id_JenisPasien`" . SearchString("=", $curVal, DATATYPE_STRING, "");
				$sqlWrk = $this->Id_JenisPasien->Lookup->getSql(FALSE, $filterWrk, '', $this);
				$rswrk = Conn()->execute($sqlWrk);
				if ($rswrk && !$rswrk->EOF) { // Lookup values found
					$arwrk = array();
					$arwrk[1] = $rswrk->fields('df');
					$this->Id_JenisPasien->ViewValue = $this->Id_JenisPasien->displayValue($arwrk);
					$rswrk->Close();
				} else {
					$this->Id_JenisPasien->ViewValue = $this->Id_JenisPasien->CurrentValue;
				}
			}
		} else {
			$this->Id_JenisPasien->ViewValue = NULL;
		}
		$this->Id_JenisPasien->ViewCustomAttributes = "";

		// Lama_Baru
		$this->Lama_Baru->ViewValue = $this->Lama_Baru->CurrentValue;
		$this->Lama_Baru->ViewCustomAttributes = "";

		// Id_BiayaDaftar
		$curVal = strval($this->Id_BiayaDaftar->CurrentValue);
		if ($curVal <> "") {
			$this->Id_BiayaDaftar->ViewValue = $this->Id_BiayaDaftar->lookupCacheOption($curVal);
			if ($this->Id_BiayaDaftar->ViewValue === NULL) { // Lookup from database
				$filterWrk = "`Id_Biayadaftar`" . SearchString("=", $curVal, DATATYPE_STRING, "");
				$sqlWrk = $this->Id_BiayaDaftar->Lookup->getSql(FALSE, $filterWrk, '', $this);
				$rswrk = Conn()->execute($sqlWrk);
				if ($rswrk && !$rswrk->EOF) { // Lookup values found
					$arwrk = array();
					$arwrk[1] = $rswrk->fields('df');
					$this->Id_BiayaDaftar->ViewValue = $this->Id_BiayaDaftar->displayValue($arwrk);
					$rswrk->Close();
				} else {
					$this->Id_BiayaDaftar->ViewValue = $this->Id_BiayaDaftar->CurrentValue;
				}
			}
		} else {
			$this->Id_BiayaDaftar->ViewValue = NULL;
		}
		$this->Id_BiayaDaftar->ViewCustomAttributes = "";

		// Total_Biaya
		$this->Total_Biaya->ViewValue = $this->Total_Biaya->CurrentValue;
		$this->Total_Biaya->ViewCustomAttributes = "";

		// Petugas
		$this->Petugas->ViewValue = $this->Petugas->CurrentValue;
		$this->Petugas->ViewCustomAttributes = "";

		// Status
		$this->Status->ViewValue = $this->Status->CurrentValue;
		$this->Status->ViewCustomAttributes = "";

		// Id_Daftar
		$this->Id_Daftar->LinkCustomAttributes = "";
		$this->Id_Daftar->HrefValue = "";
		$this->Id_Daftar->TooltipValue = "";

		// Tgl_Daftar
		$this->Tgl_Daftar->LinkCustomAttributes = "";
		$this->Tgl_Daftar->HrefValue = "";
		$this->Tgl_Daftar->TooltipValue = "";

		// Waktu
		$this->Waktu->LinkCustomAttributes = "";
		$this->Waktu->HrefValue = "";
		$this->Waktu->TooltipValue = "";

		// Id_Pasien
		$this->Id_Pasien->LinkCustomAttributes = "";
		$this->Id_Pasien->HrefValue = "";
		$this->Id_Pasien->TooltipValue = "";

		// Nama_Pasien
		$this->Nama_Pasien->LinkCustomAttributes = "";
		$this->Nama_Pasien->HrefValue = "";
		$this->Nama_Pasien->TooltipValue = "";

		// No_RM
		$this->No_RM->LinkCustomAttributes = "";
		$this->No_RM->HrefValue = "";
		$this->No_RM->TooltipValue = "";

		// Tgl_Lahir
		$this->Tgl_Lahir->LinkCustomAttributes = "";
		$this->Tgl_Lahir->HrefValue = "";
		$this->Tgl_Lahir->TooltipValue = "";

		// Jenis_Kelamin
		$this->Jenis_Kelamin->LinkCustomAttributes = "";
		$this->Jenis_Kelamin->HrefValue = "";
		$this->Jenis_Kelamin->TooltipValue = "";

		// Alamat
		$this->Alamat->LinkCustomAttributes = "";
		$this->Alamat->HrefValue = "";
		$this->Alamat->TooltipValue = "";

		// Id_Poliklinik
		$this->Id_Poliklinik->LinkCustomAttributes = "";
		$this->Id_Poliklinik->HrefValue = "";
		$this->Id_Poliklinik->TooltipValue = "";

		// Poliklinik
		$this->Poliklinik->LinkCustomAttributes = "";
		$this->Poliklinik->HrefValue = "";
		$this->Poliklinik->TooltipValue = "";

		// Rawat
		$this->Rawat->LinkCustomAttributes = "";
		$this->Rawat->HrefValue = "";
		$this->Rawat->TooltipValue = "";

		// Id_Rujukan
		$this->Id_Rujukan->LinkCustomAttributes = "";
		$this->Id_Rujukan->HrefValue = "";
		$this->Id_Rujukan->TooltipValue = "";

		// Id_JenisPasien
		$this->Id_JenisPasien->LinkCustomAttributes = "";
		$this->Id_JenisPasien->HrefValue = "";
		$this->Id_JenisPasien->TooltipValue = "";

		// Lama_Baru
		$this->Lama_Baru->LinkCustomAttributes = "";
		$this->Lama_Baru->HrefValue = "";
		$this->Lama_Baru->TooltipValue = "";

		// Id_BiayaDaftar
		$this->Id_BiayaDaftar->LinkCustomAttributes = "";
		$this->Id_BiayaDaftar->HrefValue = "";
		$this->Id_BiayaDaftar->TooltipValue = "";

		// Total_Biaya
		$this->Total_Biaya->LinkCustomAttributes = "";
		$this->Total_Biaya->HrefValue = "";
		$this->Total_Biaya->TooltipValue = "";

		// Petugas
		$this->Petugas->LinkCustomAttributes = "";
		$this->Petugas->HrefValue = "";
		$this->Petugas->TooltipValue = "";

		// Status
		$this->Status->LinkCustomAttributes = "";
		$this->Status->HrefValue = "";
		$this->Status->TooltipValue = "";

		// Call Row Rendered event
		$this->Row_Rendered();

		// Save data for Custom Template
		$this->Rows[] = $this->customTemplateFieldValues();
	}

	// Render edit row values
	public function renderEditRow()
	{
		global $Security, $CurrentLanguage, $Language;

		// Call Row Rendering event
		$this->Row_Rendering();

		// Id_Daftar
		// Tgl_Daftar

		$this->Tgl_Daftar->EditAttrs["class"] = "form-control";
		$this->Tgl_Daftar->EditCustomAttributes = 'autocomplete="off"';
		$this->Tgl_Daftar->EditValue = FormatDateTime($this->Tgl_Daftar->CurrentValue, 7);

		// Waktu
		$this->Waktu->EditAttrs["class"] = "form-control";
		$this->Waktu->EditCustomAttributes = "";
		$this->Waktu->EditValue = $this->Waktu->CurrentValue;

		// Id_Pasien
		$this->Id_Pasien->EditAttrs["class"] = "form-control";
		$this->Id_Pasien->EditCustomAttributes = "";
		if (REMOVE_XSS)
			$this->Id_Pasien->CurrentValue = HtmlDecode($this->Id_Pasien->CurrentValue);
		$this->Id_Pasien->EditValue = $this->Id_Pasien->CurrentValue;

		// Nama_Pasien
		$this->Nama_Pasien->EditAttrs["class"] = "form-control";
		$this->Nama_Pasien->EditCustomAttributes = 'autocomplete="off"';
		if (REMOVE_XSS)
			$this->Nama_Pasien->CurrentValue = HtmlDecode($this->Nama_Pasien->CurrentValue);
		$this->Nama_Pasien->EditValue = $this->Nama_Pasien->CurrentValue;

		// No_RM
		$this->No_RM->EditAttrs["class"] = "form-control";
		$this->No_RM->EditCustomAttributes = "";
		if (REMOVE_XSS)
			$this->No_RM->CurrentValue = HtmlDecode($this->No_RM->CurrentValue);
		$this->No_RM->EditValue = $this->No_RM->CurrentValue;

		// Tgl_Lahir
		$this->Tgl_Lahir->EditAttrs["class"] = "form-control";
		$this->Tgl_Lahir->EditCustomAttributes = "";
		$this->Tgl_Lahir->EditValue = FormatDateTime($this->Tgl_Lahir->CurrentValue, 7);

		// Jenis_Kelamin
		$this->Jenis_Kelamin->EditAttrs["class"] = "form-control";
		$this->Jenis_Kelamin->EditCustomAttributes = "";
		if (REMOVE_XSS)
			$this->Jenis_Kelamin->CurrentValue = HtmlDecode($this->Jenis_Kelamin->CurrentValue);
		$this->Jenis_Kelamin->EditValue = $this->Jenis_Kelamin->CurrentValue;

		// Alamat
		$this->Alamat->EditAttrs["class"] = "form-control";
		$this->Alamat->EditCustomAttributes = "";
		$this->Alamat->EditValue = $this->Alamat->CurrentValue;

		// Id_Poliklinik
		$this->Id_Poliklinik->EditCustomAttributes = "";

		// Poliklinik
		$this->Poliklinik->EditAttrs["class"] = "form-control";
		$this->Poliklinik->EditCustomAttributes = "";
		if (REMOVE_XSS)
			$this->Poliklinik->CurrentValue = HtmlDecode($this->Poliklinik->CurrentValue);
		$this->Poliklinik->EditValue = $this->Poliklinik->CurrentValue;

		// Rawat
		$this->Rawat->EditAttrs["class"] = "form-control";
		$this->Rawat->EditCustomAttributes = "";

		// Id_Rujukan
		$this->Id_Rujukan->EditCustomAttributes = "";

		// Id_JenisPasien
		$this->Id_JenisPasien->EditCustomAttributes = "";

		// Lama_Baru
		$this->Lama_Baru->EditAttrs["class"] = "form-control";
		$this->Lama_Baru->EditCustomAttributes = "";
		if (REMOVE_XSS)
			$this->Lama_Baru->CurrentValue = HtmlDecode($this->Lama_Baru->CurrentValue);
		$this->Lama_Baru->EditValue = $this->Lama_Baru->CurrentValue;

		// Id_BiayaDaftar
		$this->Id_BiayaDaftar->EditCustomAttributes = "";

		// Total_Biaya
		$this->Total_Biaya->EditAttrs["class"] = "form-control";
		$this->Total_Biaya->EditCustomAttributes = 'autocomplete="off"';
		$this->Total_Biaya->EditValue = $this->Total_Biaya->CurrentValue;
		if (strval($this->Total_Biaya->EditValue) <> "" && is_numeric($this->Total_Biaya->EditValue))
			$this->Total_Biaya->EditValue = FormatNumber($this->Total_Biaya->EditValue, -2, -1, -2, 0);

		// Petugas
		$this->Petugas->EditAttrs["class"] = "form-control";
		$this->Petugas->EditCustomAttributes = "";

		// Status
		$this->Status->EditAttrs["class"] = "form-control";
		$this->Status->EditCustomAttributes = "";

		// Call Row Rendered event
		$this->Row_Rendered();
	}

	// Aggregate list row values
	public function aggregateListRowValues()
	{
	}

	// Aggregate list row (for rendering)
	public function aggregateListRow()
	{

		// Call Row Rendered event
		$this->Row_Rendered();
	}

	// Export data in HTML/CSV/Word/Excel/Email/PDF format
	public function exportDocument($doc, $recordset, $startRec = 1, $stopRec = 1, $exportPageType = "")
	{
		if (!$recordset || !$doc)
			return;
		if (!$doc->ExportCustom) {

			// Write header
			$doc->exportTableHeader();
			if ($doc->Horizontal) { // Horizontal format, write header
				$doc->beginExportRow();
				if ($exportPageType == "view") {
					$doc->exportCaption($this->Tgl_Daftar);
					$doc->exportCaption($this->Waktu);
					$doc->exportCaption($this->Nama_Pasien);
					$doc->exportCaption($this->No_RM);
					$doc->exportCaption($this->Tgl_Lahir);
					$doc->exportCaption($this->Jenis_Kelamin);
					$doc->exportCaption($this->Alamat);
					$doc->exportCaption($this->Id_Poliklinik);
					$doc->exportCaption($this->Poliklinik);
					$doc->exportCaption($this->Id_Rujukan);
					$doc->exportCaption($this->Id_JenisPasien);
					$doc->exportCaption($this->Lama_Baru);
					$doc->exportCaption($this->Id_BiayaDaftar);
					$doc->exportCaption($this->Total_Biaya);
					$doc->exportCaption($this->Petugas);
					$doc->exportCaption($this->Status);
				} else {
					$doc->exportCaption($this->Tgl_Daftar);
					$doc->exportCaption($this->Waktu);
					$doc->exportCaption($this->Nama_Pasien);
					$doc->exportCaption($this->No_RM);
					$doc->exportCaption($this->Tgl_Lahir);
					$doc->exportCaption($this->Jenis_Kelamin);
					$doc->exportCaption($this->Alamat);
					$doc->exportCaption($this->Id_Poliklinik);
					$doc->exportCaption($this->Poliklinik);
					$doc->exportCaption($this->Rawat);
					$doc->exportCaption($this->Id_Rujukan);
					$doc->exportCaption($this->Id_JenisPasien);
					$doc->exportCaption($this->Lama_Baru);
					$doc->exportCaption($this->Id_BiayaDaftar);
					$doc->exportCaption($this->Total_Biaya);
				}
				$doc->endExportRow();
			}
		}

		// Move to first record
		$recCnt = $startRec - 1;
		if (!$recordset->EOF) {
			$recordset->moveFirst();
			if ($startRec > 1)
				$recordset->move($startRec - 1);
		}
		while (!$recordset->EOF && $recCnt < $stopRec) {
			$recCnt++;
			if ($recCnt >= $startRec) {
				$rowCnt = $recCnt - $startRec + 1;

				// Page break
				if ($this->ExportPageBreakCount > 0) {
					if ($rowCnt > 1 && ($rowCnt - 1) % $this->ExportPageBreakCount == 0)
						$doc->exportPageBreak();
				}
				$this->loadListRowValues($recordset);

				// Render row
				$this->RowType = ROWTYPE_VIEW; // Render view
				$this->resetAttributes();
				$this->renderListRow();
				if (!$doc->ExportCustom) {
					$doc->beginExportRow($rowCnt); // Allow CSS styles if enabled
					if ($exportPageType == "view") {
						$doc->exportField($this->Tgl_Daftar);
						$doc->exportField($this->Waktu);
						$doc->exportField($this->Nama_Pasien);
						$doc->exportField($this->No_RM);
						$doc->exportField($this->Tgl_Lahir);
						$doc->exportField($this->Jenis_Kelamin);
						$doc->exportField($this->Alamat);
						$doc->exportField($this->Id_Poliklinik);
						$doc->exportField($this->Poliklinik);
						$doc->exportField($this->Id_Rujukan);
						$doc->exportField($this->Id_JenisPasien);
						$doc->exportField($this->Lama_Baru);
						$doc->exportField($this->Id_BiayaDaftar);
						$doc->exportField($this->Total_Biaya);
						$doc->exportField($this->Petugas);
						$doc->exportField($this->Status);
					} else {
						$doc->exportField($this->Tgl_Daftar);
						$doc->exportField($this->Waktu);
						$doc->exportField($this->Nama_Pasien);
						$doc->exportField($this->No_RM);
						$doc->exportField($this->Tgl_Lahir);
						$doc->exportField($this->Jenis_Kelamin);
						$doc->exportField($this->Alamat);
						$doc->exportField($this->Id_Poliklinik);
						$doc->exportField($this->Poliklinik);
						$doc->exportField($this->Rawat);
						$doc->exportField($this->Id_Rujukan);
						$doc->exportField($this->Id_JenisPasien);
						$doc->exportField($this->Lama_Baru);
						$doc->exportField($this->Id_BiayaDaftar);
						$doc->exportField($this->Total_Biaya);
					}
					$doc->endExportRow($rowCnt);
				}
			}

			// Call Row Export server event
			if ($doc->ExportCustom)
				$this->Row_Export($recordset->fields);
			$recordset->moveNext();
		}
		if (!$doc->ExportCustom) {
			$doc->exportTableFooter();
		}
	}

	// Lookup data from table
	public function lookup()
	{
		global $Language, $LANGUAGE_FOLDER, $PROJECT_ID;
		if (!isset($Language))
			$Language = new Language($LANGUAGE_FOLDER, Post("language", ""));
		global $Security, $RequestSecurity;

		// Check token first
		$func = PROJECT_NAMESPACE . "CheckToken";
		$validRequest = FALSE;
		if (is_callable($func) && Post(TOKEN_NAME) !== NULL) {
			$validRequest = $func(Post(TOKEN_NAME), SessionTimeoutTime());
			if ($validRequest) {
				if (!isset($Security)) {
					if (session_status() !== PHP_SESSION_ACTIVE)
						session_start(); // Init session data
					$Security = new AdvancedSecurity();
					if ($Security->isLoggedIn()) $Security->TablePermission_Loading();
					$Security->loadCurrentUserLevel($PROJECT_ID . $this->TableName);
					if ($Security->isLoggedIn()) $Security->TablePermission_Loaded();
					$validRequest = $Security->canList(); // List permission
				}
			}
		} else {

			// User profile
			$UserProfile = new UserProfile();

			// Security
			$Security = new AdvancedSecurity();
			if (is_array($RequestSecurity)) // Login user for API request
				$Security->loginUser(@$RequestSecurity["username"], @$RequestSecurity["userid"], @$RequestSecurity["parentuserid"], @$RequestSecurity["userlevelid"]);
			$Security->TablePermission_Loading();
			$Security->loadCurrentUserLevel(CurrentProjectID() . $this->TableName);
			$Security->TablePermission_Loaded();
			$validRequest = $Security->canList(); // List permission
		}

		// Reject invalid request
		if (!$validRequest)
			return FALSE;

		// Load lookup parameters
		$distinct = ConvertToBool(Post("distinct"));
		$linkField = Post("linkField");
		$displayFields = Post("displayFields");
		$parentFields = Post("parentFields");
		if (!is_array($parentFields))
			$parentFields = [];
		$childFields = Post("childFields");
		if (!is_array($childFields))
			$childFields = [];
		$filterFields = Post("filterFields");
		if (!is_array($filterFields))
			$filterFields = [];
		$filterFieldVars = Post("filterFieldVars");
		if (!is_array($filterFieldVars))
			$filterFieldVars = [];
		$filterOperators = Post("filterOperators");
		if (!is_array($filterOperators))
			$filterOperators = [];
		$autoFillSourceFields = Post("autoFillSourceFields");
		if (!is_array($autoFillSourceFields))
			$autoFillSourceFields = [];
		$formatAutoFill = FALSE;
		$lookupType = Post("ajax", "unknown");
		$pageSize = -1;
		$offset = -1;
		$searchValue = "";
		if (SameText($lookupType, "modal")) {
			$searchValue = Post("sv", "");
			$pageSize = Post("recperpage", 10);
			$offset = Post("start", 0);
		} elseif (SameText($lookupType, "autosuggest")) {
			$searchValue = Get("q", "");
			$pageSize = Param("n", -1);
			$pageSize = is_numeric($pageSize) ? (int)$pageSize : -1;
			if ($pageSize <= 0)
				$pageSize = AUTO_SUGGEST_MAX_ENTRIES;
			$start = Param("start", -1);
			$start = is_numeric($start) ? (int)$start : -1;
			$page = Param("page", -1);
			$page = is_numeric($page) ? (int)$page : -1;
			$offset = $start >= 0 ? $start : ($page > 0 && $pageSize > 0 ? ($page - 1) * $pageSize : 0);
		}
		$userSelect = Decrypt(Post("s", ""));
		$userFilter = Decrypt(Post("f", ""));
		$userOrderBy = Decrypt(Post("o", ""));
		$keys = Post("keys");

		// Selected records from modal, skip parent/filter fields and show all records
		if ($keys !== NULL) {
			$parentFields = [];
			$filterFields = [];
			$filterFieldVars = [];
			$offset = 0;
			$pageSize = 0;
		}

		// Create lookup object and output JSON
		$lookup = new Lookup($linkField, $this->TableVar, $distinct, $linkField, $displayFields, $parentFields, $childFields, $filterFields, $filterFieldVars, $autoFillSourceFields);
		foreach ($filterFields as $i => $filterField) { // Set up filter operators
			if (@$filterOperators[$i] <> "")
				$lookup->setFilterOperator($filterField, $filterOperators[$i]);
		}
		$lookup->LookupType = $lookupType; // Lookup type
		if ($keys !== NULL) { // Selected records from modal
			if (is_array($keys))
				$keys = implode(LOOKUP_FILTER_VALUE_SEPARATOR, $keys);
			$lookup->FilterValues[] = $keys; // Lookup values
		} else { // Lookup values
			$lookup->FilterValues[] = Post("v0", Post("lookupValue", ""));
		}
		$cnt = is_array($filterFields) ? count($filterFields) : 0;
		for ($i = 1; $i <= $cnt; $i++)
			$lookup->FilterValues[] = Post("v" . $i, "");
		$lookup->SearchValue = $searchValue;
		$lookup->PageSize = $pageSize;
		$lookup->Offset = $offset;
		if ($userSelect <> "")
			$lookup->UserSelect = $userSelect;
		if ($userFilter <> "")
			$lookup->UserFilter = $userFilter;
		if ($userOrderBy <> "")
			$lookup->UserOrderBy = $userOrderBy;
		$lookup->toJson();
	}

	// Get file data
	public function getFileData($fldparm, $key, $resize, $width = THUMBNAIL_DEFAULT_WIDTH, $height = THUMBNAIL_DEFAULT_HEIGHT)
	{

		// No binary fields
		return FALSE;
	}

	// Table level events
	// Recordset Selecting event
	function Recordset_Selecting(&$filter) {

		// Enter your code here
	}

	// Recordset Selected event
	function Recordset_Selected(&$rs) {

		//echo "Recordset Selected";
	}

	// Recordset Search Validated event
	function Recordset_SearchValidated() {

		// Example:
		//$this->MyField1->AdvancedSearch->SearchValue = "your search criteria"; // Search value

	}

	// Recordset Searching event
	function Recordset_Searching(&$filter) {

		// Enter your code here
	}

	// Row_Selecting event
	function Row_Selecting(&$filter) {

		// Enter your code here
	}

	// Row Selected event
	function Row_Selected(&$rs) {

		//echo "Row Selected";
	}

	// Row Inserting event
	function Row_Inserting($rsold, &$rsnew) {

		// Enter your code here
		// To cancel, set return value to FALSE

		return TRUE;
	}

	// Row Inserted event
	function Row_Inserted($rsold, &$rsnew) {

		//echo "Row Inserted"
		Execute("UPDATE lokpasien SET lama_baru = 'PASIEN LAMA' WHERE id_pasien = '" . $rsnew["Id_Pasien"]. "'");
		Execute("UPDATE lokpasien SET no_rm = '".$rsnew["No_RM"]."' WHERE id_pasien = '" . $rsnew["Id_Pasien"]. "'");

	//	Execute("UPDATE lokdaftar SET lokdaftar.Status = 'SUDAH' WHERE lokdaftar.Id_Pasien = '".$rsnew["Id_Pasien"]."' AND lokdaftar.Tgl_Daftar < '".$rsnew["Tgl_Daftar"]-7."'");
	}

	// Row Updating event
	function Row_Updating($rsold, &$rsnew) {

		// Enter your code here
		// To cancel, set return value to FALSE

		return TRUE;
	}

	// Row Updated event
	function Row_Updated($rsold, &$rsnew) {

		//echo "Row Updated";
		Execute("UPDATE lokpasien SET no_rm = '".$rsnew["No_RM"]."' WHERE id_pasien = '" . $rsnew["Id_Pasien"]. "'");
	}

	// Row Update Conflict event
	function Row_UpdateConflict($rsold, &$rsnew) {

		// Enter your code here
		// To ignore conflict, set return value to FALSE

		return TRUE;
	}

	// Grid Inserting event
	function Grid_Inserting() {

		// Enter your code here
		// To reject grid insert, set return value to FALSE

		return TRUE;
	}

	// Grid Inserted event
	function Grid_Inserted($rsnew) {

		//echo "Grid Inserted";
	}

	// Grid Updating event
	function Grid_Updating($rsold) {

		// Enter your code here
		// To reject grid update, set return value to FALSE

		return TRUE;
	}

	// Grid Updated event
	function Grid_Updated($rsold, $rsnew) {

		//echo "Grid Updated";
	}

	// Row Deleting event
	function Row_Deleting(&$rs) {

		// Enter your code here
		// To cancel, set return value to False

		return TRUE;
	}

	// Row Deleted event
	function Row_Deleted(&$rs) {

		//echo "Row Deleted";
	}

	// Email Sending event
	function Email_Sending($email, &$args) {

		//var_dump($email); var_dump($args); exit();
		return TRUE;
	}

	// Lookup Selecting event
	function Lookup_Selecting($fld, &$filter) {

		//var_dump($fld->Name, $fld->Lookup, $filter); // Uncomment to view the filter
		// Enter your code here

	}

	// Row Rendering event
	function Row_Rendering() {

		// Enter your code here
		$this->Total_Biaya->ReadOnly = TRUE;
		if (CurrentPageID() == "add") {
			date_default_timezone_set("Asia/Jakarta");
			$this->Tgl_Daftar->CurrentValue = date("d-m-Y");
			$this->Waktu->CurrentValue = date("H:i:s");
		}
		if (CurrentPageID() == "list") {
			$this->No_RM->ReadOnly = FALSE;
			$this->Nama_Pasien->ReadOnly = FALSE;
			$this->Tgl_Lahir->ReadOnly = FALSE;
			$this->Alamat->ReadOnly = FALSE;
			$this->Lama_Baru->ReadOnly = FALSE;
		} else {
			$this->No_RM->ReadOnly = TRUE;
			$this->Nama_Pasien->ReadOnly = TRUE;
			$this->Tgl_Lahir->ReadOnly = TRUE;
			$this->Jenis_Kelamin->ReadOnly = TRUE;
			$this->Alamat->ReadOnly = TRUE;
			$this->Lama_Baru->ReadOnly = TRUE;
		}
	}

	// Row Rendered event
	function Row_Rendered() {

		// To view properties of field class, use:
		//var_dump($this-><FieldName>);

	}

	// User ID Filtering event
	function UserID_Filtering(&$filter) {

		// Enter your code here
	}
}
?>