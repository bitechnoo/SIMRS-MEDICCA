<?php
namespace PHPMaker2019\tpp;

/**
 * Table class for lokbiayadaftar
 */
class lokbiayadaftar extends DbTable
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
	public $Id_Biayadaftar;
	public $Nama_Biaya;
	public $Jasa_Dokter;
	public $Jasa_Layanan;
	public $Jasa_Sarana;
	public $Total_Biaya;

	// Constructor
	public function __construct()
	{
		global $Language, $CurrentLanguage;

		// Language object
		if (!isset($Language))
			$Language = new Language();
		$this->TableVar = 'lokbiayadaftar';
		$this->TableName = 'lokbiayadaftar';
		$this->TableType = 'TABLE';

		// Update Table
		$this->UpdateTable = "`lokbiayadaftar`";
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

		// Id_Biayadaftar
		$this->Id_Biayadaftar = new DbField('lokbiayadaftar', 'lokbiayadaftar', 'x_Id_Biayadaftar', 'Id_Biayadaftar', '`Id_Biayadaftar`', '`Id_Biayadaftar`', 200, -1, FALSE, '`Id_Biayadaftar`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->Id_Biayadaftar->IsPrimaryKey = TRUE; // Primary key field
		$this->Id_Biayadaftar->Nullable = FALSE; // NOT NULL field
		$this->Id_Biayadaftar->Sortable = FALSE; // Allow sort
		$this->fields['Id_Biayadaftar'] = &$this->Id_Biayadaftar;

		// Nama_Biaya
		$this->Nama_Biaya = new DbField('lokbiayadaftar', 'lokbiayadaftar', 'x_Nama_Biaya', 'Nama_Biaya', '`Nama_Biaya`', '`Nama_Biaya`', 200, -1, FALSE, '`Nama_Biaya`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->Nama_Biaya->Nullable = FALSE; // NOT NULL field
		$this->Nama_Biaya->Required = TRUE; // Required field
		$this->Nama_Biaya->Sortable = TRUE; // Allow sort
		$this->fields['Nama_Biaya'] = &$this->Nama_Biaya;

		// Jasa_Dokter
		$this->Jasa_Dokter = new DbField('lokbiayadaftar', 'lokbiayadaftar', 'x_Jasa_Dokter', 'Jasa_Dokter', '`Jasa_Dokter`', '`Jasa_Dokter`', 131, -1, FALSE, '`Jasa_Dokter`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->Jasa_Dokter->Nullable = FALSE; // NOT NULL field
		$this->Jasa_Dokter->Required = TRUE; // Required field
		$this->Jasa_Dokter->Sortable = TRUE; // Allow sort
		$this->Jasa_Dokter->DefaultErrorMessage = $Language->phrase("IncorrectFloat");
		$this->fields['Jasa_Dokter'] = &$this->Jasa_Dokter;

		// Jasa_Layanan
		$this->Jasa_Layanan = new DbField('lokbiayadaftar', 'lokbiayadaftar', 'x_Jasa_Layanan', 'Jasa_Layanan', '`Jasa_Layanan`', '`Jasa_Layanan`', 131, -1, FALSE, '`Jasa_Layanan`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->Jasa_Layanan->Nullable = FALSE; // NOT NULL field
		$this->Jasa_Layanan->Required = TRUE; // Required field
		$this->Jasa_Layanan->Sortable = TRUE; // Allow sort
		$this->Jasa_Layanan->DefaultErrorMessage = $Language->phrase("IncorrectFloat");
		$this->fields['Jasa_Layanan'] = &$this->Jasa_Layanan;

		// Jasa_Sarana
		$this->Jasa_Sarana = new DbField('lokbiayadaftar', 'lokbiayadaftar', 'x_Jasa_Sarana', 'Jasa_Sarana', '`Jasa_Sarana`', '`Jasa_Sarana`', 131, -1, FALSE, '`Jasa_Sarana`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->Jasa_Sarana->Nullable = FALSE; // NOT NULL field
		$this->Jasa_Sarana->Required = TRUE; // Required field
		$this->Jasa_Sarana->Sortable = TRUE; // Allow sort
		$this->Jasa_Sarana->DefaultErrorMessage = $Language->phrase("IncorrectFloat");
		$this->fields['Jasa_Sarana'] = &$this->Jasa_Sarana;

		// Total_Biaya
		$this->Total_Biaya = new DbField('lokbiayadaftar', 'lokbiayadaftar', 'x_Total_Biaya', 'Total_Biaya', '(jasa_dokter + jasa_layanan + jasa_sarana)', '(jasa_dokter + jasa_layanan + jasa_sarana)', 131, -1, FALSE, '(jasa_dokter + jasa_layanan + jasa_sarana)', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->Total_Biaya->IsCustom = TRUE; // Custom field
		$this->Total_Biaya->Sortable = TRUE; // Allow sort
		$this->Total_Biaya->DefaultErrorMessage = $Language->phrase("IncorrectFloat");
		$this->fields['Total_Biaya'] = &$this->Total_Biaya;
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
		return ($this->SqlFrom <> "") ? $this->SqlFrom : "`lokbiayadaftar`";
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
		return ($this->SqlSelect <> "") ? $this->SqlSelect : "SELECT *, (jasa_dokter + jasa_layanan + jasa_sarana) AS `Total_Biaya` FROM " . $this->getSqlFrom();
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
		return ($this->SqlOrderBy <> "") ? $this->SqlOrderBy : "`Id_Biayadaftar` DESC";
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
			if (array_key_exists('Id_Biayadaftar', $rs))
				AddFilter($where, QuotedName('Id_Biayadaftar', $this->Dbid) . '=' . QuotedValue($rs['Id_Biayadaftar'], $this->Id_Biayadaftar->DataType, $this->Dbid));
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
		$this->Id_Biayadaftar->DbValue = $row['Id_Biayadaftar'];
		$this->Nama_Biaya->DbValue = $row['Nama_Biaya'];
		$this->Jasa_Dokter->DbValue = $row['Jasa_Dokter'];
		$this->Jasa_Layanan->DbValue = $row['Jasa_Layanan'];
		$this->Jasa_Sarana->DbValue = $row['Jasa_Sarana'];
		$this->Total_Biaya->DbValue = $row['Total_Biaya'];
	}

	// Delete uploaded files
	public function deleteUploadedFiles($row)
	{
		$this->loadDbValues($row);
	}

	// Record filter WHERE clause
	protected function sqlKeyFilter()
	{
		return "`Id_Biayadaftar` = '@Id_Biayadaftar@'";
	}

	// Get record filter
	public function getRecordFilter($row = NULL)
	{
		$keyFilter = $this->sqlKeyFilter();
		$val = is_array($row) ? (array_key_exists('Id_Biayadaftar', $row) ? $row['Id_Biayadaftar'] : NULL) : $this->Id_Biayadaftar->CurrentValue;
		if ($val == NULL)
			return "0=1"; // Invalid key
		else
			$keyFilter = str_replace("@Id_Biayadaftar@", AdjustSql($val, $this->Dbid), $keyFilter); // Replace key value
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
			return "lokbiayadaftarlist.php";
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
		if ($pageName == "lokbiayadaftarview.php")
			return $Language->phrase("View");
		elseif ($pageName == "lokbiayadaftaredit.php")
			return $Language->phrase("Edit");
		elseif ($pageName == "lokbiayadaftaradd.php")
			return $Language->phrase("Add");
		else
			return "";
	}

	// List URL
	public function getListUrl()
	{
		return "lokbiayadaftarlist.php";
	}

	// View URL
	public function getViewUrl($parm = "")
	{
		if ($parm <> "")
			$url = $this->keyUrl("lokbiayadaftarview.php", $this->getUrlParm($parm));
		else
			$url = $this->keyUrl("lokbiayadaftarview.php", $this->getUrlParm(TABLE_SHOW_DETAIL . "="));
		return $this->addMasterUrl($url);
	}

	// Add URL
	public function getAddUrl($parm = "")
	{
		if ($parm <> "")
			$url = "lokbiayadaftaradd.php?" . $this->getUrlParm($parm);
		else
			$url = "lokbiayadaftaradd.php";
		return $this->addMasterUrl($url);
	}

	// Edit URL
	public function getEditUrl($parm = "")
	{
		$url = $this->keyUrl("lokbiayadaftaredit.php", $this->getUrlParm($parm));
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
		$url = $this->keyUrl("lokbiayadaftaradd.php", $this->getUrlParm($parm));
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
		return $this->keyUrl("lokbiayadaftardelete.php", $this->getUrlParm());
	}

	// Add master url
	public function addMasterUrl($url)
	{
		return $url;
	}
	public function keyToJson($htmlEncode = FALSE)
	{
		$json = "";
		$json .= "Id_Biayadaftar:" . JsonEncode($this->Id_Biayadaftar->CurrentValue, "string");
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
		if ($this->Id_Biayadaftar->CurrentValue != NULL) {
			$url .= "Id_Biayadaftar=" . urlencode($this->Id_Biayadaftar->CurrentValue);
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
			if (Param("Id_Biayadaftar") !== NULL)
				$arKeys[] = Param("Id_Biayadaftar");
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
			$this->Id_Biayadaftar->CurrentValue = $key;
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
		$this->Id_Biayadaftar->setDbValue($rs->fields('Id_Biayadaftar'));
		$this->Nama_Biaya->setDbValue($rs->fields('Nama_Biaya'));
		$this->Jasa_Dokter->setDbValue($rs->fields('Jasa_Dokter'));
		$this->Jasa_Layanan->setDbValue($rs->fields('Jasa_Layanan'));
		$this->Jasa_Sarana->setDbValue($rs->fields('Jasa_Sarana'));
		$this->Total_Biaya->setDbValue($rs->fields('Total_Biaya'));
	}

	// Render list row values
	public function renderListRow()
	{
		global $Security, $CurrentLanguage, $Language;

		// Call Row Rendering event
		$this->Row_Rendering();

		// Common render codes
		// Id_Biayadaftar

		$this->Id_Biayadaftar->CellCssStyle = "white-space: nowrap;";

		// Nama_Biaya
		// Jasa_Dokter
		// Jasa_Layanan
		// Jasa_Sarana
		// Total_Biaya
		// Id_Biayadaftar

		$this->Id_Biayadaftar->ViewValue = $this->Id_Biayadaftar->CurrentValue;
		$this->Id_Biayadaftar->ViewCustomAttributes = "";

		// Nama_Biaya
		$this->Nama_Biaya->ViewValue = $this->Nama_Biaya->CurrentValue;
		$this->Nama_Biaya->ViewCustomAttributes = "";

		// Jasa_Dokter
		$this->Jasa_Dokter->ViewValue = $this->Jasa_Dokter->CurrentValue;
		$this->Jasa_Dokter->ViewCustomAttributes = "";

		// Jasa_Layanan
		$this->Jasa_Layanan->ViewValue = $this->Jasa_Layanan->CurrentValue;
		$this->Jasa_Layanan->ViewCustomAttributes = "";

		// Jasa_Sarana
		$this->Jasa_Sarana->ViewValue = $this->Jasa_Sarana->CurrentValue;
		$this->Jasa_Sarana->ViewCustomAttributes = "";

		// Total_Biaya
		$this->Total_Biaya->ViewValue = $this->Total_Biaya->CurrentValue;
		$this->Total_Biaya->ViewCustomAttributes = "";

		// Id_Biayadaftar
		$this->Id_Biayadaftar->LinkCustomAttributes = "";
		$this->Id_Biayadaftar->HrefValue = "";
		$this->Id_Biayadaftar->TooltipValue = "";

		// Nama_Biaya
		$this->Nama_Biaya->LinkCustomAttributes = "";
		$this->Nama_Biaya->HrefValue = "";
		$this->Nama_Biaya->TooltipValue = "";

		// Jasa_Dokter
		$this->Jasa_Dokter->LinkCustomAttributes = "";
		$this->Jasa_Dokter->HrefValue = "";
		$this->Jasa_Dokter->TooltipValue = "";

		// Jasa_Layanan
		$this->Jasa_Layanan->LinkCustomAttributes = "";
		$this->Jasa_Layanan->HrefValue = "";
		$this->Jasa_Layanan->TooltipValue = "";

		// Jasa_Sarana
		$this->Jasa_Sarana->LinkCustomAttributes = "";
		$this->Jasa_Sarana->HrefValue = "";
		$this->Jasa_Sarana->TooltipValue = "";

		// Total_Biaya
		$this->Total_Biaya->LinkCustomAttributes = "";
		$this->Total_Biaya->HrefValue = "";
		$this->Total_Biaya->TooltipValue = "";

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

		// Id_Biayadaftar
		// Nama_Biaya

		$this->Nama_Biaya->EditAttrs["class"] = "form-control";
		$this->Nama_Biaya->EditCustomAttributes = 'autocomplete="off"';
		if (REMOVE_XSS)
			$this->Nama_Biaya->CurrentValue = HtmlDecode($this->Nama_Biaya->CurrentValue);
		$this->Nama_Biaya->EditValue = $this->Nama_Biaya->CurrentValue;

		// Jasa_Dokter
		$this->Jasa_Dokter->EditAttrs["class"] = "form-control";
		$this->Jasa_Dokter->EditCustomAttributes = 'autocomplete="off"';
		$this->Jasa_Dokter->EditValue = $this->Jasa_Dokter->CurrentValue;
		if (strval($this->Jasa_Dokter->EditValue) <> "" && is_numeric($this->Jasa_Dokter->EditValue))
			$this->Jasa_Dokter->EditValue = FormatNumber($this->Jasa_Dokter->EditValue, -2, -1, -2, 0);

		// Jasa_Layanan
		$this->Jasa_Layanan->EditAttrs["class"] = "form-control";
		$this->Jasa_Layanan->EditCustomAttributes = 'autocomplete="off"';
		$this->Jasa_Layanan->EditValue = $this->Jasa_Layanan->CurrentValue;
		if (strval($this->Jasa_Layanan->EditValue) <> "" && is_numeric($this->Jasa_Layanan->EditValue))
			$this->Jasa_Layanan->EditValue = FormatNumber($this->Jasa_Layanan->EditValue, -2, -1, -2, 0);

		// Jasa_Sarana
		$this->Jasa_Sarana->EditAttrs["class"] = "form-control";
		$this->Jasa_Sarana->EditCustomAttributes = 'autocomplete="off"';
		$this->Jasa_Sarana->EditValue = $this->Jasa_Sarana->CurrentValue;
		if (strval($this->Jasa_Sarana->EditValue) <> "" && is_numeric($this->Jasa_Sarana->EditValue))
			$this->Jasa_Sarana->EditValue = FormatNumber($this->Jasa_Sarana->EditValue, -2, -1, -2, 0);

		// Total_Biaya
		$this->Total_Biaya->EditAttrs["class"] = "form-control";
		$this->Total_Biaya->EditCustomAttributes = 'autocomplete="off"';
		$this->Total_Biaya->EditValue = $this->Total_Biaya->CurrentValue;
		if (strval($this->Total_Biaya->EditValue) <> "" && is_numeric($this->Total_Biaya->EditValue))
			$this->Total_Biaya->EditValue = FormatNumber($this->Total_Biaya->EditValue, -2, -1, -2, 0);

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
					$doc->exportCaption($this->Nama_Biaya);
					$doc->exportCaption($this->Jasa_Dokter);
					$doc->exportCaption($this->Jasa_Layanan);
					$doc->exportCaption($this->Jasa_Sarana);
					$doc->exportCaption($this->Total_Biaya);
				} else {
					$doc->exportCaption($this->Nama_Biaya);
					$doc->exportCaption($this->Jasa_Dokter);
					$doc->exportCaption($this->Jasa_Layanan);
					$doc->exportCaption($this->Jasa_Sarana);
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
						$doc->exportField($this->Nama_Biaya);
						$doc->exportField($this->Jasa_Dokter);
						$doc->exportField($this->Jasa_Layanan);
						$doc->exportField($this->Jasa_Sarana);
						$doc->exportField($this->Total_Biaya);
					} else {
						$doc->exportField($this->Nama_Biaya);
						$doc->exportField($this->Jasa_Dokter);
						$doc->exportField($this->Jasa_Layanan);
						$doc->exportField($this->Jasa_Sarana);
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

		$this->Total_Biaya->ReadOnly = TRUE; 
	}

	// User ID Filtering event
	function UserID_Filtering(&$filter) {

		// Enter your code here
	}
}
?>