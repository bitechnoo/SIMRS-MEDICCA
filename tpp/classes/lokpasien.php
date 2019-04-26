<?php
namespace PHPMaker2019\tpp;

/**
 * Table class for lokpasien
 */
class lokpasien extends DbTable
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
	public $Id_Pasien;
	public $No_RM;
	public $Nama_Pasien;
	public $No_BPJS;
	public $No_KTP;
	public $Tempat_Lahir;
	public $Tgl_Lahir;
	public $Jenis_Kelamin;
	public $Alamat;
	public $Id_Kelurahan;
	public $Agama;
	public $Lama_Baru;
	public $sortNo_RM;

	// Constructor
	public function __construct()
	{
		global $Language, $CurrentLanguage;

		// Language object
		if (!isset($Language))
			$Language = new Language();
		$this->TableVar = 'lokpasien';
		$this->TableName = 'lokpasien';
		$this->TableType = 'TABLE';

		// Update Table
		$this->UpdateTable = "`lokpasien`";
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

		// Id_Pasien
		$this->Id_Pasien = new DbField('lokpasien', 'lokpasien', 'x_Id_Pasien', 'Id_Pasien', '`Id_Pasien`', '`Id_Pasien`', 200, -1, FALSE, '`Id_Pasien`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->Id_Pasien->IsPrimaryKey = TRUE; // Primary key field
		$this->Id_Pasien->Nullable = FALSE; // NOT NULL field
		$this->Id_Pasien->Sortable = FALSE; // Allow sort
		$this->fields['Id_Pasien'] = &$this->Id_Pasien;

		// No_RM
		$this->No_RM = new DbField('lokpasien', 'lokpasien', 'x_No_RM', 'No_RM', '`No_RM`', '`No_RM`', 200, -1, FALSE, '`No_RM`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->No_RM->Nullable = FALSE; // NOT NULL field
		$this->No_RM->Sortable = TRUE; // Allow sort
		$this->No_RM->DefaultErrorMessage = $Language->phrase("IncorrectInteger");
		$this->fields['No_RM'] = &$this->No_RM;

		// Nama_Pasien
		$this->Nama_Pasien = new DbField('lokpasien', 'lokpasien', 'x_Nama_Pasien', 'Nama_Pasien', '`Nama_Pasien`', '`Nama_Pasien`', 200, -1, FALSE, '`Nama_Pasien`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->Nama_Pasien->Nullable = FALSE; // NOT NULL field
		$this->Nama_Pasien->Required = TRUE; // Required field
		$this->Nama_Pasien->Sortable = TRUE; // Allow sort
		$this->fields['Nama_Pasien'] = &$this->Nama_Pasien;

		// No_BPJS
		$this->No_BPJS = new DbField('lokpasien', 'lokpasien', 'x_No_BPJS', 'No_BPJS', '`No_BPJS`', '`No_BPJS`', 200, -1, FALSE, '`No_BPJS`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->No_BPJS->Sortable = TRUE; // Allow sort
		$this->fields['No_BPJS'] = &$this->No_BPJS;

		// No_KTP
		$this->No_KTP = new DbField('lokpasien', 'lokpasien', 'x_No_KTP', 'No_KTP', '`No_KTP`', '`No_KTP`', 200, -1, FALSE, '`No_KTP`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->No_KTP->Sortable = TRUE; // Allow sort
		$this->fields['No_KTP'] = &$this->No_KTP;

		// Tempat_Lahir
		$this->Tempat_Lahir = new DbField('lokpasien', 'lokpasien', 'x_Tempat_Lahir', 'Tempat_Lahir', '`Tempat_Lahir`', '`Tempat_Lahir`', 200, -1, FALSE, '`Tempat_Lahir`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->Tempat_Lahir->Nullable = FALSE; // NOT NULL field
		$this->Tempat_Lahir->Required = TRUE; // Required field
		$this->Tempat_Lahir->Sortable = TRUE; // Allow sort
		$this->fields['Tempat_Lahir'] = &$this->Tempat_Lahir;

		// Tgl_Lahir
		$this->Tgl_Lahir = new DbField('lokpasien', 'lokpasien', 'x_Tgl_Lahir', 'Tgl_Lahir', '`Tgl_Lahir`', CastDateFieldForLike('`Tgl_Lahir`', 7, "DB"), 133, 7, FALSE, '`Tgl_Lahir`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->Tgl_Lahir->Nullable = FALSE; // NOT NULL field
		$this->Tgl_Lahir->Required = TRUE; // Required field
		$this->Tgl_Lahir->Sortable = TRUE; // Allow sort
		$this->Tgl_Lahir->DefaultErrorMessage = str_replace("%s", $GLOBALS["DATE_SEPARATOR"], $Language->phrase("IncorrectDateDMY"));
		$this->Tgl_Lahir->AdvancedSearch->SearchValueDefault = CurrentDate();
		$this->Tgl_Lahir->AdvancedSearch->SearchOperatorDefault = "=";
		$this->Tgl_Lahir->AdvancedSearch->SearchOperatorDefault2 = "";
		$this->Tgl_Lahir->AdvancedSearch->SearchConditionDefault = "AND";
		$this->fields['Tgl_Lahir'] = &$this->Tgl_Lahir;

		// Jenis_Kelamin
		$this->Jenis_Kelamin = new DbField('lokpasien', 'lokpasien', 'x_Jenis_Kelamin', 'Jenis_Kelamin', '`Jenis_Kelamin`', '`Jenis_Kelamin`', 200, -1, FALSE, '`Jenis_Kelamin`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'RADIO');
		$this->Jenis_Kelamin->Nullable = FALSE; // NOT NULL field
		$this->Jenis_Kelamin->Required = TRUE; // Required field
		$this->Jenis_Kelamin->Sortable = TRUE; // Allow sort
		$this->Jenis_Kelamin->Lookup = new Lookup('Jenis_Kelamin', 'lokpasien', FALSE, '', ["","","",""], [], [], [], [], [], [], '', '');
		$this->Jenis_Kelamin->OptionCount = 2;
		$this->Jenis_Kelamin->DefaultErrorMessage = $Language->phrase("IncorrectInteger");
		$this->fields['Jenis_Kelamin'] = &$this->Jenis_Kelamin;

		// Alamat
		$this->Alamat = new DbField('lokpasien', 'lokpasien', 'x_Alamat', 'Alamat', '`Alamat`', '`Alamat`', 200, -1, FALSE, '`Alamat`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXTAREA');
		$this->Alamat->Nullable = FALSE; // NOT NULL field
		$this->Alamat->Required = TRUE; // Required field
		$this->Alamat->Sortable = TRUE; // Allow sort
		$this->fields['Alamat'] = &$this->Alamat;

		// Id_Kelurahan
		$this->Id_Kelurahan = new DbField('lokpasien', 'lokpasien', 'x_Id_Kelurahan', 'Id_Kelurahan', '`Id_Kelurahan`', '`Id_Kelurahan`', 200, -1, FALSE, '`Id_Kelurahan`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'SELECT');
		$this->Id_Kelurahan->Nullable = FALSE; // NOT NULL field
		$this->Id_Kelurahan->Required = TRUE; // Required field
		$this->Id_Kelurahan->Sortable = TRUE; // Allow sort
		$this->Id_Kelurahan->UsePleaseSelect = TRUE; // Use PleaseSelect by default
		$this->Id_Kelurahan->PleaseSelectText = $Language->phrase("PleaseSelect"); // PleaseSelect text
		$this->Id_Kelurahan->Lookup = new Lookup('Id_Kelurahan', 'lokkelurahan', FALSE, 'Id_Kelurahan', ["Kelurahan","","",""], [], [], [], [], [], [], '', '');
		$this->fields['Id_Kelurahan'] = &$this->Id_Kelurahan;

		// Agama
		$this->Agama = new DbField('lokpasien', 'lokpasien', 'x_Agama', 'Agama', '`Agama`', '`Agama`', 200, -1, FALSE, '`Agama`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'RADIO');
		$this->Agama->Nullable = FALSE; // NOT NULL field
		$this->Agama->Required = TRUE; // Required field
		$this->Agama->Sortable = TRUE; // Allow sort
		$this->Agama->Lookup = new Lookup('Agama', 'lokpasien', FALSE, '', ["","","",""], [], [], [], [], [], [], '', '');
		$this->Agama->OptionCount = 5;
		$this->Agama->DefaultErrorMessage = $Language->phrase("IncorrectInteger");
		$this->fields['Agama'] = &$this->Agama;

		// Lama_Baru
		$this->Lama_Baru = new DbField('lokpasien', 'lokpasien', 'x_Lama_Baru', 'Lama_Baru', '`Lama_Baru`', '`Lama_Baru`', 200, -1, FALSE, '`Lama_Baru`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'HIDDEN');
		$this->Lama_Baru->Nullable = FALSE; // NOT NULL field
		$this->Lama_Baru->Sortable = FALSE; // Allow sort
		$this->Lama_Baru->DefaultErrorMessage = $Language->phrase("IncorrectInteger");
		$this->fields['Lama_Baru'] = &$this->Lama_Baru;

		// sortNo_RM
		$this->sortNo_RM = new DbField('lokpasien', 'lokpasien', 'x_sortNo_RM', 'sortNo_RM', 'CONVERT(No_RM,UNSIGNED INT)', 'CONVERT(No_RM,UNSIGNED INT)', 21, -1, FALSE, 'CONVERT(No_RM,UNSIGNED INT)', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->sortNo_RM->IsCustom = TRUE; // Custom field
		$this->sortNo_RM->Sortable = FALSE; // Allow sort
		$this->sortNo_RM->DefaultErrorMessage = $Language->phrase("IncorrectInteger");
		$this->fields['sortNo_RM'] = &$this->sortNo_RM;
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
		return ($this->SqlFrom <> "") ? $this->SqlFrom : "`lokpasien`";
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
		return ($this->SqlSelect <> "") ? $this->SqlSelect : "SELECT *, CONVERT(No_RM,UNSIGNED INT) AS `sortNo_RM` FROM " . $this->getSqlFrom();
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
		$this->TableFilter = "";
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
		return ($this->SqlOrderBy <> "") ? $this->SqlOrderBy : "`sortNo_RM` DESC";
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
			if (array_key_exists('Id_Pasien', $rs))
				AddFilter($where, QuotedName('Id_Pasien', $this->Dbid) . '=' . QuotedValue($rs['Id_Pasien'], $this->Id_Pasien->DataType, $this->Dbid));
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
		$this->Id_Pasien->DbValue = $row['Id_Pasien'];
		$this->No_RM->DbValue = $row['No_RM'];
		$this->Nama_Pasien->DbValue = $row['Nama_Pasien'];
		$this->No_BPJS->DbValue = $row['No_BPJS'];
		$this->No_KTP->DbValue = $row['No_KTP'];
		$this->Tempat_Lahir->DbValue = $row['Tempat_Lahir'];
		$this->Tgl_Lahir->DbValue = $row['Tgl_Lahir'];
		$this->Jenis_Kelamin->DbValue = $row['Jenis_Kelamin'];
		$this->Alamat->DbValue = $row['Alamat'];
		$this->Id_Kelurahan->DbValue = $row['Id_Kelurahan'];
		$this->Agama->DbValue = $row['Agama'];
		$this->Lama_Baru->DbValue = $row['Lama_Baru'];
		$this->sortNo_RM->DbValue = $row['sortNo_RM'];
	}

	// Delete uploaded files
	public function deleteUploadedFiles($row)
	{
		$this->loadDbValues($row);
	}

	// Record filter WHERE clause
	protected function sqlKeyFilter()
	{
		return "`Id_Pasien` = '@Id_Pasien@'";
	}

	// Get record filter
	public function getRecordFilter($row = NULL)
	{
		$keyFilter = $this->sqlKeyFilter();
		$val = is_array($row) ? (array_key_exists('Id_Pasien', $row) ? $row['Id_Pasien'] : NULL) : $this->Id_Pasien->CurrentValue;
		if ($val == NULL)
			return "0=1"; // Invalid key
		else
			$keyFilter = str_replace("@Id_Pasien@", AdjustSql($val, $this->Dbid), $keyFilter); // Replace key value
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
			return "lokpasienlist.php";
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
		if ($pageName == "lokpasienview.php")
			return $Language->phrase("View");
		elseif ($pageName == "lokpasienedit.php")
			return $Language->phrase("Edit");
		elseif ($pageName == "lokpasienadd.php")
			return $Language->phrase("Add");
		else
			return "";
	}

	// List URL
	public function getListUrl()
	{
		return "lokpasienlist.php";
	}

	// View URL
	public function getViewUrl($parm = "")
	{
		if ($parm <> "")
			$url = $this->keyUrl("lokpasienview.php", $this->getUrlParm($parm));
		else
			$url = $this->keyUrl("lokpasienview.php", $this->getUrlParm(TABLE_SHOW_DETAIL . "="));
		return $this->addMasterUrl($url);
	}

	// Add URL
	public function getAddUrl($parm = "")
	{
		if ($parm <> "")
			$url = "lokpasienadd.php?" . $this->getUrlParm($parm);
		else
			$url = "lokpasienadd.php";
		return $this->addMasterUrl($url);
	}

	// Edit URL
	public function getEditUrl($parm = "")
	{
		$url = $this->keyUrl("lokpasienedit.php", $this->getUrlParm($parm));
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
		$url = $this->keyUrl("lokpasienadd.php", $this->getUrlParm($parm));
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
		return $this->keyUrl("lokpasiendelete.php", $this->getUrlParm());
	}

	// Add master url
	public function addMasterUrl($url)
	{
		return $url;
	}
	public function keyToJson($htmlEncode = FALSE)
	{
		$json = "";
		$json .= "Id_Pasien:" . JsonEncode($this->Id_Pasien->CurrentValue, "string");
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
		if ($this->Id_Pasien->CurrentValue != NULL) {
			$url .= "Id_Pasien=" . urlencode($this->Id_Pasien->CurrentValue);
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
			if (Param("Id_Pasien") !== NULL)
				$arKeys[] = Param("Id_Pasien");
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
			$this->Id_Pasien->CurrentValue = $key;
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
		$this->Id_Pasien->setDbValue($rs->fields('Id_Pasien'));
		$this->No_RM->setDbValue($rs->fields('No_RM'));
		$this->Nama_Pasien->setDbValue($rs->fields('Nama_Pasien'));
		$this->No_BPJS->setDbValue($rs->fields('No_BPJS'));
		$this->No_KTP->setDbValue($rs->fields('No_KTP'));
		$this->Tempat_Lahir->setDbValue($rs->fields('Tempat_Lahir'));
		$this->Tgl_Lahir->setDbValue($rs->fields('Tgl_Lahir'));
		$this->Jenis_Kelamin->setDbValue($rs->fields('Jenis_Kelamin'));
		$this->Alamat->setDbValue($rs->fields('Alamat'));
		$this->Id_Kelurahan->setDbValue($rs->fields('Id_Kelurahan'));
		$this->Agama->setDbValue($rs->fields('Agama'));
		$this->Lama_Baru->setDbValue($rs->fields('Lama_Baru'));
		$this->sortNo_RM->setDbValue($rs->fields('sortNo_RM'));
	}

	// Render list row values
	public function renderListRow()
	{
		global $Security, $CurrentLanguage, $Language;

		// Call Row Rendering event
		$this->Row_Rendering();

		// Common render codes
		// Id_Pasien

		$this->Id_Pasien->CellCssStyle = "white-space: nowrap;";

		// No_RM
		// Nama_Pasien
		// No_BPJS
		// No_KTP
		// Tempat_Lahir
		// Tgl_Lahir
		// Jenis_Kelamin
		// Alamat
		// Id_Kelurahan
		// Agama
		// Lama_Baru

		$this->Lama_Baru->CellCssStyle = "white-space: nowrap;";

		// sortNo_RM
		$this->sortNo_RM->CellCssStyle = "white-space: nowrap;";

		// Id_Pasien
		$this->Id_Pasien->ViewValue = $this->Id_Pasien->CurrentValue;
		$this->Id_Pasien->ViewCustomAttributes = "";

		// No_RM
		$this->No_RM->ViewValue = $this->No_RM->CurrentValue;
		$this->No_RM->ViewCustomAttributes = "";

		// Nama_Pasien
		$this->Nama_Pasien->ViewValue = $this->Nama_Pasien->CurrentValue;
		$this->Nama_Pasien->ViewValue = strtoupper($this->Nama_Pasien->ViewValue);
		$this->Nama_Pasien->ViewCustomAttributes = "";

		// No_BPJS
		$this->No_BPJS->ViewValue = $this->No_BPJS->CurrentValue;
		$this->No_BPJS->ViewCustomAttributes = "";

		// No_KTP
		$this->No_KTP->ViewValue = $this->No_KTP->CurrentValue;
		$this->No_KTP->ViewCustomAttributes = "";

		// Tempat_Lahir
		$this->Tempat_Lahir->ViewValue = $this->Tempat_Lahir->CurrentValue;
		$this->Tempat_Lahir->ViewCustomAttributes = "";

		// Tgl_Lahir
		$this->Tgl_Lahir->ViewValue = $this->Tgl_Lahir->CurrentValue;
		$this->Tgl_Lahir->ViewValue = FormatDateTime($this->Tgl_Lahir->ViewValue, 7);
		$this->Tgl_Lahir->ViewCustomAttributes = "";

		// Jenis_Kelamin
		if (strval($this->Jenis_Kelamin->CurrentValue) <> "") {
			$this->Jenis_Kelamin->ViewValue = $this->Jenis_Kelamin->optionCaption($this->Jenis_Kelamin->CurrentValue);
		} else {
			$this->Jenis_Kelamin->ViewValue = NULL;
		}
		$this->Jenis_Kelamin->ViewCustomAttributes = "";

		// Alamat
		$this->Alamat->ViewValue = $this->Alamat->CurrentValue;
		$this->Alamat->ViewCustomAttributes = "";

		// Id_Kelurahan
		$curVal = strval($this->Id_Kelurahan->CurrentValue);
		if ($curVal <> "") {
			$this->Id_Kelurahan->ViewValue = $this->Id_Kelurahan->lookupCacheOption($curVal);
			if ($this->Id_Kelurahan->ViewValue === NULL) { // Lookup from database
				$filterWrk = "`Id_Kelurahan`" . SearchString("=", $curVal, DATATYPE_STRING, "");
				$sqlWrk = $this->Id_Kelurahan->Lookup->getSql(FALSE, $filterWrk, '', $this);
				$rswrk = Conn()->execute($sqlWrk);
				if ($rswrk && !$rswrk->EOF) { // Lookup values found
					$arwrk = array();
					$arwrk[1] = $rswrk->fields('df');
					$this->Id_Kelurahan->ViewValue = $this->Id_Kelurahan->displayValue($arwrk);
					$rswrk->Close();
				} else {
					$this->Id_Kelurahan->ViewValue = $this->Id_Kelurahan->CurrentValue;
				}
			}
		} else {
			$this->Id_Kelurahan->ViewValue = NULL;
		}
		$this->Id_Kelurahan->ViewCustomAttributes = "";

		// Agama
		if (strval($this->Agama->CurrentValue) <> "") {
			$this->Agama->ViewValue = $this->Agama->optionCaption($this->Agama->CurrentValue);
		} else {
			$this->Agama->ViewValue = NULL;
		}
		$this->Agama->ViewCustomAttributes = "";

		// Lama_Baru
		$this->Lama_Baru->ViewValue = $this->Lama_Baru->CurrentValue;
		$this->Lama_Baru->ViewCustomAttributes = "";

		// sortNo_RM
		$this->sortNo_RM->ViewValue = $this->sortNo_RM->CurrentValue;
		$this->sortNo_RM->ViewValue = FormatNumber($this->sortNo_RM->ViewValue, 0, -2, -2, -2);
		$this->sortNo_RM->ViewCustomAttributes = "";

		// Id_Pasien
		$this->Id_Pasien->LinkCustomAttributes = "";
		$this->Id_Pasien->HrefValue = "";
		$this->Id_Pasien->TooltipValue = "";

		// No_RM
		$this->No_RM->LinkCustomAttributes = "";
		$this->No_RM->HrefValue = "";
		$this->No_RM->TooltipValue = "";

		// Nama_Pasien
		$this->Nama_Pasien->LinkCustomAttributes = "";
		$this->Nama_Pasien->HrefValue = "";
		$this->Nama_Pasien->TooltipValue = "";

		// No_BPJS
		$this->No_BPJS->LinkCustomAttributes = "";
		$this->No_BPJS->HrefValue = "";
		$this->No_BPJS->TooltipValue = "";

		// No_KTP
		$this->No_KTP->LinkCustomAttributes = "";
		$this->No_KTP->HrefValue = "";
		$this->No_KTP->TooltipValue = "";

		// Tempat_Lahir
		$this->Tempat_Lahir->LinkCustomAttributes = "";
		$this->Tempat_Lahir->HrefValue = "";
		$this->Tempat_Lahir->TooltipValue = "";

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

		// Id_Kelurahan
		$this->Id_Kelurahan->LinkCustomAttributes = "";
		$this->Id_Kelurahan->HrefValue = "";
		$this->Id_Kelurahan->TooltipValue = "";

		// Agama
		$this->Agama->LinkCustomAttributes = "";
		$this->Agama->HrefValue = "";
		$this->Agama->TooltipValue = "";

		// Lama_Baru
		$this->Lama_Baru->LinkCustomAttributes = "";
		$this->Lama_Baru->HrefValue = "";
		$this->Lama_Baru->TooltipValue = "";

		// sortNo_RM
		$this->sortNo_RM->LinkCustomAttributes = "";
		$this->sortNo_RM->HrefValue = "";
		$this->sortNo_RM->TooltipValue = "";

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

		// Id_Pasien
		// No_RM
		// Nama_Pasien

		$this->Nama_Pasien->EditAttrs["class"] = "form-control";
		$this->Nama_Pasien->EditCustomAttributes = 'autocomplete="off"';
		if (REMOVE_XSS)
			$this->Nama_Pasien->CurrentValue = HtmlDecode($this->Nama_Pasien->CurrentValue);
		$this->Nama_Pasien->EditValue = $this->Nama_Pasien->CurrentValue;

		// No_BPJS
		$this->No_BPJS->EditAttrs["class"] = "form-control";
		$this->No_BPJS->EditCustomAttributes = 'autocomplete="off"';
		if (REMOVE_XSS)
			$this->No_BPJS->CurrentValue = HtmlDecode($this->No_BPJS->CurrentValue);
		$this->No_BPJS->EditValue = $this->No_BPJS->CurrentValue;

		// No_KTP
		$this->No_KTP->EditAttrs["class"] = "form-control";
		$this->No_KTP->EditCustomAttributes = 'autocomplete="off"';
		if (REMOVE_XSS)
			$this->No_KTP->CurrentValue = HtmlDecode($this->No_KTP->CurrentValue);
		$this->No_KTP->EditValue = $this->No_KTP->CurrentValue;

		// Tempat_Lahir
		$this->Tempat_Lahir->EditAttrs["class"] = "form-control";
		$this->Tempat_Lahir->EditCustomAttributes = 'autocomplete="off"';
		if (REMOVE_XSS)
			$this->Tempat_Lahir->CurrentValue = HtmlDecode($this->Tempat_Lahir->CurrentValue);
		$this->Tempat_Lahir->EditValue = $this->Tempat_Lahir->CurrentValue;

		// Tgl_Lahir
		$this->Tgl_Lahir->EditAttrs["class"] = "form-control";
		$this->Tgl_Lahir->EditCustomAttributes = 'autocomplete="off"';
		$this->Tgl_Lahir->EditValue = FormatDateTime($this->Tgl_Lahir->CurrentValue, 7);

		// Jenis_Kelamin
		$this->Jenis_Kelamin->EditCustomAttributes = "";
		$this->Jenis_Kelamin->EditValue = $this->Jenis_Kelamin->options(FALSE);

		// Alamat
		$this->Alamat->EditAttrs["class"] = "form-control";
		$this->Alamat->EditCustomAttributes = 'autocomplete="off"';
		$this->Alamat->EditValue = $this->Alamat->CurrentValue;

		// Id_Kelurahan
		$this->Id_Kelurahan->EditAttrs["class"] = "form-control";
		$this->Id_Kelurahan->EditCustomAttributes = "";

		// Agama
		$this->Agama->EditCustomAttributes = "";
		$this->Agama->EditValue = $this->Agama->options(FALSE);

		// Lama_Baru
		$this->Lama_Baru->EditAttrs["class"] = "form-control";
		$this->Lama_Baru->EditCustomAttributes = "";

		// sortNo_RM
		$this->sortNo_RM->EditAttrs["class"] = "form-control";
		$this->sortNo_RM->EditCustomAttributes = "";
		$this->sortNo_RM->EditValue = $this->sortNo_RM->CurrentValue;

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
					$doc->exportCaption($this->No_RM);
					$doc->exportCaption($this->Nama_Pasien);
					$doc->exportCaption($this->No_BPJS);
					$doc->exportCaption($this->No_KTP);
					$doc->exportCaption($this->Tempat_Lahir);
					$doc->exportCaption($this->Tgl_Lahir);
					$doc->exportCaption($this->Jenis_Kelamin);
					$doc->exportCaption($this->Alamat);
					$doc->exportCaption($this->Id_Kelurahan);
					$doc->exportCaption($this->Agama);
				} else {
					$doc->exportCaption($this->No_RM);
					$doc->exportCaption($this->Nama_Pasien);
					$doc->exportCaption($this->No_BPJS);
					$doc->exportCaption($this->No_KTP);
					$doc->exportCaption($this->Tempat_Lahir);
					$doc->exportCaption($this->Tgl_Lahir);
					$doc->exportCaption($this->Jenis_Kelamin);
					$doc->exportCaption($this->Alamat);
					$doc->exportCaption($this->Id_Kelurahan);
					$doc->exportCaption($this->Agama);
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
						$doc->exportField($this->No_RM);
						$doc->exportField($this->Nama_Pasien);
						$doc->exportField($this->No_BPJS);
						$doc->exportField($this->No_KTP);
						$doc->exportField($this->Tempat_Lahir);
						$doc->exportField($this->Tgl_Lahir);
						$doc->exportField($this->Jenis_Kelamin);
						$doc->exportField($this->Alamat);
						$doc->exportField($this->Id_Kelurahan);
						$doc->exportField($this->Agama);
					} else {
						$doc->exportField($this->No_RM);
						$doc->exportField($this->Nama_Pasien);
						$doc->exportField($this->No_BPJS);
						$doc->exportField($this->No_KTP);
						$doc->exportField($this->Tempat_Lahir);
						$doc->exportField($this->Tgl_Lahir);
						$doc->exportField($this->Jenis_Kelamin);
						$doc->exportField($this->Alamat);
						$doc->exportField($this->Id_Kelurahan);
						$doc->exportField($this->Agama);
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