<?php
namespace PHPMaker2019\tpp;

/**
 * Page class
 */
class lokdaftar_delete extends lokdaftar
{

	// Page ID
	public $PageID = "delete";

	// Project ID
	public $ProjectID = "{888F026C-2D04-4F2F-A77C-CABDD56A9360}";

	// Table name
	public $TableName = 'lokdaftar';

	// Page object name
	public $PageObjName = "lokdaftar_delete";

	// Page headings
	public $Heading = "";
	public $Subheading = "";
	public $PageHeader;
	public $PageFooter;

	// Token
	public $Token = "";
	public $TokenTimeout = 0;
	public $CheckToken = CHECK_TOKEN;

	// Messages
	private $_message = "";
	private $_failureMessage = "";
	private $_successMessage = "";
	private $_warningMessage = "";

	// Page URL
	private $_pageUrl = "";

	// Page heading
	public function pageHeading()
	{
		global $Language;
		if ($this->Heading <> "")
			return $this->Heading;
		if (method_exists($this, "tableCaption"))
			return $this->tableCaption();
		return "";
	}

	// Page subheading
	public function pageSubheading()
	{
		global $Language;
		if ($this->Subheading <> "")
			return $this->Subheading;
		if ($this->TableName)
			return $Language->phrase($this->PageID);
		return "";
	}

	// Page name
	public function pageName()
	{
		return CurrentPageName();
	}

	// Page URL
	public function pageUrl()
	{
		if ($this->_pageUrl == "") {
			$this->_pageUrl = CurrentPageName() . "?";
			if ($this->UseTokenInUrl)
				$this->_pageUrl .= "t=" . $this->TableVar . "&"; // Add page token
		}
		return $this->_pageUrl;
	}

	// Get message
	public function getMessage()
	{
		return isset($_SESSION[SESSION_MESSAGE]) ? $_SESSION[SESSION_MESSAGE] : $this->_message;
	}

	// Set message
	public function setMessage($v)
	{
		AddMessage($this->_message, $v);
		$_SESSION[SESSION_MESSAGE] = $this->_message;
	}

	// Get failure message
	public function getFailureMessage()
	{
		return isset($_SESSION[SESSION_FAILURE_MESSAGE]) ? $_SESSION[SESSION_FAILURE_MESSAGE] : $this->_failureMessage;
	}

	// Set failure message
	public function setFailureMessage($v)
	{
		AddMessage($this->_failureMessage, $v);
		$_SESSION[SESSION_FAILURE_MESSAGE] = $this->_failureMessage;
	}

	// Get success message
	public function getSuccessMessage()
	{
		return isset($_SESSION[SESSION_SUCCESS_MESSAGE]) ? $_SESSION[SESSION_SUCCESS_MESSAGE] : $this->_successMessage;
	}

	// Set success message
	public function setSuccessMessage($v)
	{
		AddMessage($this->_successMessage, $v);
		$_SESSION[SESSION_SUCCESS_MESSAGE] = $this->_successMessage;
	}

	// Get warning message
	public function getWarningMessage()
	{
		return isset($_SESSION[SESSION_WARNING_MESSAGE]) ? $_SESSION[SESSION_WARNING_MESSAGE] : $this->_warningMessage;
	}

	// Set warning message
	public function setWarningMessage($v)
	{
		AddMessage($this->_warningMessage, $v);
		$_SESSION[SESSION_WARNING_MESSAGE] = $this->_warningMessage;
	}

	// Clear message
	public function clearMessage()
	{
		$this->_message = "";
		$_SESSION[SESSION_MESSAGE] = "";
	}

	// Clear failure message
	public function clearFailureMessage()
	{
		$this->_failureMessage = "";
		$_SESSION[SESSION_FAILURE_MESSAGE] = "";
	}

	// Clear success message
	public function clearSuccessMessage()
	{
		$this->_successMessage = "";
		$_SESSION[SESSION_SUCCESS_MESSAGE] = "";
	}

	// Clear warning message
	public function clearWarningMessage()
	{
		$this->_warningMessage = "";
		$_SESSION[SESSION_WARNING_MESSAGE] = "";
	}

	// Clear messages
	public function clearMessages()
	{
		$this->clearMessage();
		$this->clearFailureMessage();
		$this->clearSuccessMessage();
		$this->clearWarningMessage();
	}

	// Show message
	public function showMessage()
	{
		$hidden = FALSE;
		$html = "";

		// Message
		$message = $this->getMessage();
		if (method_exists($this, "Message_Showing"))
			$this->Message_Showing($message, "");
		if ($message <> "") { // Message in Session, display
			if (!$hidden)
				$message = '<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>' . $message;
			$html .= '<div class="alert alert-info alert-dismissible ew-info"><i class="icon fa fa-info"></i>' . $message . '</div>';
			$_SESSION[SESSION_MESSAGE] = ""; // Clear message in Session
		}

		// Warning message
		$warningMessage = $this->getWarningMessage();
		if (method_exists($this, "Message_Showing"))
			$this->Message_Showing($warningMessage, "warning");
		if ($warningMessage <> "") { // Message in Session, display
			if (!$hidden)
				$warningMessage = '<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>' . $warningMessage;
			$html .= '<div class="alert alert-warning alert-dismissible ew-warning"><i class="icon fa fa-warning"></i>' . $warningMessage . '</div>';
			$_SESSION[SESSION_WARNING_MESSAGE] = ""; // Clear message in Session
		}

		// Success message
		$successMessage = $this->getSuccessMessage();
		if (method_exists($this, "Message_Showing"))
			$this->Message_Showing($successMessage, "success");
		if ($successMessage <> "") { // Message in Session, display
			if (!$hidden)
				$successMessage = '<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>' . $successMessage;
			$html .= '<div class="alert alert-success alert-dismissible ew-success"><i class="icon fa fa-check"></i>' . $successMessage . '</div>';
			$_SESSION[SESSION_SUCCESS_MESSAGE] = ""; // Clear message in Session
		}

		// Failure message
		$errorMessage = $this->getFailureMessage();
		if (method_exists($this, "Message_Showing"))
			$this->Message_Showing($errorMessage, "failure");
		if ($errorMessage <> "") { // Message in Session, display
			if (!$hidden)
				$errorMessage = '<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>' . $errorMessage;
			$html .= '<div class="alert alert-danger alert-dismissible ew-error"><i class="icon fa fa-ban"></i>' . $errorMessage . '</div>';
			$_SESSION[SESSION_FAILURE_MESSAGE] = ""; // Clear message in Session
		}
		echo '<div class="ew-message-dialog' . (($hidden) ? ' d-none' : "") . '">' . $html . '</div>';
	}

	// Get message as array
	public function getMessages()
	{
		$ar = array();

		// Message
		$message = $this->getMessage();

		//if (method_exists($this, "Message_Showing"))
		//	$this->Message_Showing($message, "");

		if ($message <> "") { // Message in Session, display
			$ar["message"] = $message;
			$_SESSION[SESSION_MESSAGE] = ""; // Clear message in Session
		}

		// Warning message
		$warningMessage = $this->getWarningMessage();

		//if (method_exists($this, "Message_Showing"))
		//	$this->Message_Showing($warningMessage, "warning");

		if ($warningMessage <> "") { // Message in Session, display
			$ar["warningMessage"] = $warningMessage;
			$_SESSION[SESSION_WARNING_MESSAGE] = ""; // Clear message in Session
		}

		// Success message
		$successMessage = $this->getSuccessMessage();

		//if (method_exists($this, "Message_Showing"))
		//	$this->Message_Showing($successMessage, "success");

		if ($successMessage <> "") { // Message in Session, display
			$ar["successMessage"] = $successMessage;
			$_SESSION[SESSION_SUCCESS_MESSAGE] = ""; // Clear message in Session
		}

		// Failure message
		$failureMessage = $this->getFailureMessage();

		//if (method_exists($this, "Message_Showing"))
		//	$this->Message_Showing($failureMessage, "failure");

		if ($failureMessage <> "") { // Message in Session, display
			$ar["failureMessage"] = $failureMessage;
			$_SESSION[SESSION_FAILURE_MESSAGE] = ""; // Clear message in Session
		}
		return $ar;
	}

	// Show Page Header
	public function showPageHeader()
	{
		$header = $this->PageHeader;
		$this->Page_DataRendering($header);
		if ($header <> "") { // Header exists, display
			echo '<p id="ew-page-header">' . $header . '</p>';
		}
	}

	// Show Page Footer
	public function showPageFooter()
	{
		$footer = $this->PageFooter;
		$this->Page_DataRendered($footer);
		if ($footer <> "") { // Footer exists, display
			echo '<p id="ew-page-footer">' . $footer . '</p>';
		}
	}

	// Validate page request
	protected function isPageRequest()
	{
		global $CurrentForm;
		if ($this->UseTokenInUrl) {
			if ($CurrentForm)
				return ($this->TableVar == $CurrentForm->getValue("t"));
			if (Get("t") !== NULL)
				return ($this->TableVar == Get("t"));
		}
		return TRUE;
	}

	// Valid Post
	protected function validPost()
	{
		if (!$this->CheckToken || !IsPost() || IsApi())
			return TRUE;
		if (Post(TOKEN_NAME) === NULL)
			return FALSE;
		$fn = PROJECT_NAMESPACE . CHECK_TOKEN_FUNC;
		if (is_callable($fn))
			return $fn(Post(TOKEN_NAME), $this->TokenTimeout);
		return FALSE;
	}

	// Create Token
	public function createToken()
	{
		global $CurrentToken;
		$fn = PROJECT_NAMESPACE . CREATE_TOKEN_FUNC; // Always create token, required by API file/lookup request
		if ($this->Token == "" && is_callable($fn)) // Create token
			$this->Token = $fn();
		$CurrentToken = $this->Token; // Save to global variable
	}

	// Constructor
	public function __construct()
	{
		global $Language, $COMPOSITE_KEY_SEPARATOR;
		global $UserTable, $UserTableConn;

		// Initialize
		$GLOBALS["Page"] = &$this;
		$this->TokenTimeout = SessionTimeoutTime();

		// Language object
		if (!isset($Language))
			$Language = new Language();

		// Parent constuctor
		parent::__construct();

		// Table object (lokdaftar)
		if (!isset($GLOBALS["lokdaftar"]) || get_class($GLOBALS["lokdaftar"]) == PROJECT_NAMESPACE . "lokdaftar") {
			$GLOBALS["lokdaftar"] = &$this;
			$GLOBALS["Table"] = &$GLOBALS["lokdaftar"];
		}
		$this->CancelUrl = $this->pageUrl() . "action=cancel";

		// Table object (vlokpetugas)
		if (!isset($GLOBALS['vlokpetugas']))
			$GLOBALS['vlokpetugas'] = new vlokpetugas();

		// Page ID
		if (!defined(PROJECT_NAMESPACE . "PAGE_ID"))
			define(PROJECT_NAMESPACE . "PAGE_ID", 'delete');

		// Table name (for backward compatibility)
		if (!defined(PROJECT_NAMESPACE . "TABLE_NAME"))
			define(PROJECT_NAMESPACE . "TABLE_NAME", 'lokdaftar');

		// Start timer
		if (!isset($GLOBALS["DebugTimer"]))
			$GLOBALS["DebugTimer"] = new Timer();

		// Debug message
		LoadDebugMessage();

		// Open connection
		if (!isset($GLOBALS["Conn"]))
			$GLOBALS["Conn"] = &$this->getConnection();

		// User table object (vlokpetugas)
		if (!isset($UserTable)) {
			$UserTable = new vlokpetugas();
			$UserTableConn = Conn($UserTable->Dbid);
		}
	}

	// Terminate page
	public function terminate($url = "")
	{
		global $ExportFileName, $TempImages;

		// Page Unload event
		$this->Page_Unload();

		// Global Page Unloaded event (in userfn*.php)
		Page_Unloaded();

		// Export
		global $EXPORT, $lokdaftar;
		if ($this->CustomExport && $this->CustomExport == $this->Export && array_key_exists($this->CustomExport, $EXPORT)) {
				$content = ob_get_contents();
			if ($ExportFileName == "")
				$ExportFileName = $this->TableVar;
			$class = PROJECT_NAMESPACE . $EXPORT[$this->CustomExport];
			if (class_exists($class)) {
				$doc = new $class($lokdaftar);
				$doc->Text = @$content;
				if ($this->isExport("email"))
					echo $this->exportEmail($doc->Text);
				else
					$doc->export();
				DeleteTempImages(); // Delete temp images
				exit();
			}
		}
		if (!IsApi())
			$this->Page_Redirecting($url);

		// Close connection
		CloseConnections();

		// Return for API
		if (IsApi()) {
			$res = $url === TRUE;
			if (!$res) // Show error
				WriteJson(array_merge(["success" => FALSE], $this->getMessages()));
			return;
		}

		// Go to URL if specified
		if ($url <> "") {
			if (!DEBUG_ENABLED && ob_get_length())
				ob_end_clean();
			SaveDebugMessage();
			AddHeader("Location", $url);
		}
		exit();
	}

	// Get records from recordset
	protected function getRecordsFromRecordset($rs, $current = FALSE)
	{
		$rows = array();
		if (is_object($rs)) { // Recordset
			while ($rs && !$rs->EOF) {
				$this->loadRowValues($rs); // Set up DbValue/CurrentValue
				$row = $this->getRecordFromArray($rs->fields);
				if ($current)
					return $row;
				else
					$rows[] = $row;
				$rs->moveNext();
			}
		} elseif (is_array($rs)) {
			foreach ($rs as $ar) {
				$row = $this->getRecordFromArray($ar);
				if ($current)
					return $row;
				else
					$rows[] = $row;
			}
		}
		return $rows;
	}

	// Get record from array
	protected function getRecordFromArray($ar)
	{
		$row = array();
		if (is_array($ar)) {
			foreach ($ar as $fldname => $val) {
				if (array_key_exists($fldname, $this->fields) && ($this->fields[$fldname]->Visible || $this->fields[$fldname]->IsPrimaryKey)) { // Primary key or Visible
					$fld = &$this->fields[$fldname];
					if ($fld->HtmlTag == "FILE") { // Upload field
						if (EmptyValue($val)) {
							$row[$fldname] = NULL;
						} else {
							if ($fld->DataType == DATATYPE_BLOB) {

								//$url = FullUrl($fld->TableVar . "/" . API_FILE_ACTION . "/" . $fld->Param . "/" . rawurlencode($this->getRecordKeyValue($ar))); // URL rewrite format
								$url = FullUrl(GetPageName(API_URL) . "?" . API_OBJECT_NAME . "=" . $fld->TableVar . "&" . API_ACTION_NAME . "=" . API_FILE_ACTION . "&" . API_FIELD_NAME . "=" . $fld->Param . "&" . API_KEY_NAME . "=" . rawurlencode($this->getRecordKeyValue($ar))); // Query string format
								$row[$fldname] = ["mimeType" => ContentType($val), "url" => $url];
							} elseif (!$fld->UploadMultiple || !ContainsString($val, MULTIPLE_UPLOAD_SEPARATOR)) { // Single file
								$row[$fldname] = ["mimeType" => MimeContentType($val), "url" => FullUrl($fld->hrefPath() . $val)];
							} else { // Multiple files
								$files = explode(MULTIPLE_UPLOAD_SEPARATOR, $val);
								$ar = [];
								foreach ($files as $file) {
									if (!EmptyValue($file))
										$ar[] = ["type" => MimeContentType($file), "url" => FullUrl($fld->hrefPath() . $file)];
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
		global $COMPOSITE_KEY_SEPARATOR;
		$key = "";
		if (is_array($ar)) {
			$key .= @$ar['Id_Daftar'];
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
	}
	public $DbMasterFilter = "";
	public $DbDetailFilter = "";
	public $StartRec;
	public $TotalRecs = 0;
	public $RecCnt;
	public $RecKeys = array();
	public $StartRowCnt = 1;
	public $RowCnt = 0;

	//
	// Page run
	//

	public function run()
	{
		global $ExportType, $CustomExportType, $ExportFileName, $UserProfile, $Language, $Security, $RequestSecurity, $CurrentForm;

		// Init Session data for API request if token found
		if (IsApi() && session_status() !== PHP_SESSION_ACTIVE) {
			$func = PROJECT_NAMESPACE . CHECK_TOKEN_FUNC;
			if (is_callable($func) && Param(TOKEN_NAME) !== NULL && $func(Param(TOKEN_NAME), SessionTimeoutTime()))
				session_start();
		}

		// User profile
		$UserProfile = new UserProfile();

		// Security
		$Security = new AdvancedSecurity();
		$validRequest = FALSE;

		// Check security for API request
		If (IsApi()) {

			// Check token first
			$func = PROJECT_NAMESPACE . CHECK_TOKEN_FUNC;
			if (is_callable($func) && Post(TOKEN_NAME) !== NULL)
				$validRequest = $func(Post(TOKEN_NAME), SessionTimeoutTime());
			elseif (is_array($RequestSecurity) && @$RequestSecurity["username"] <> "") // Login user for API request
				$Security->loginUser(@$RequestSecurity["username"], @$RequestSecurity["userid"], @$RequestSecurity["parentuserid"], @$RequestSecurity["userlevelid"]);
		}
		if (!$validRequest) {
			if (!$Security->isLoggedIn())
				$Security->autoLogin();
			if ($Security->isLoggedIn())
				$Security->TablePermission_Loading();
			$Security->loadCurrentUserLevel($this->ProjectID . $this->TableName);
			if ($Security->isLoggedIn())
				$Security->TablePermission_Loaded();
			if (!$Security->canDelete()) {
				$Security->saveLastUrl();
				$this->setFailureMessage(DeniedMessage()); // Set no permission
				if ($Security->canList())
					$this->terminate(GetUrl("lokdaftarlist.php"));
				else
					$this->terminate(GetUrl("login.php"));
				return;
			}
		}
		$this->CurrentAction = Param("action"); // Set up current action
		$this->Id_Daftar->Visible = FALSE;
		$this->Tgl_Daftar->setVisibility();
		$this->Waktu->setVisibility();
		$this->Id_Pasien->Visible = FALSE;
		$this->Nama_Pasien->setVisibility();
		$this->No_RM->setVisibility();
		$this->Tgl_Lahir->setVisibility();
		$this->Jenis_Kelamin->setVisibility();
		$this->Alamat->setVisibility();
		$this->Id_Poliklinik->Visible = FALSE;
		$this->Poliklinik->setVisibility();
		$this->Rawat->setVisibility();
		$this->Id_Rujukan->setVisibility();
		$this->Id_JenisPasien->setVisibility();
		$this->Lama_Baru->setVisibility();
		$this->Id_BiayaDaftar->Visible = FALSE;
		$this->Total_Biaya->setVisibility();
		$this->Petugas->setVisibility();
		$this->Status->Visible = FALSE;
		$this->hideFieldsForAddEdit();

		// Do not use lookup cache
		$this->setUseLookupCache(FALSE);

		// Global Page Loading event (in userfn*.php)
		Page_Loading();

		// Page Load event
		$this->Page_Load();

		// Check token
		if (!$this->validPost()) {
			Write($Language->phrase("InvalidPostRequest"));
			$this->terminate();
		}

		// Create Token
		$this->createToken();

		// Set up lookup cache
		$this->setupLookupOptions($this->Id_Poliklinik);
		$this->setupLookupOptions($this->Id_Rujukan);
		$this->setupLookupOptions($this->Id_JenisPasien);
		$this->setupLookupOptions($this->Id_BiayaDaftar);

		// Set up Breadcrumb
		$this->setupBreadcrumb();

		// Load key parameters
		$this->RecKeys = $this->getRecordKeys(); // Load record keys
		$filter = $this->getFilterFromRecordKeys();
		if ($filter == "") {
			$this->terminate("lokdaftarlist.php"); // Prevent SQL injection, return to list
			return;
		}

		// Set up filter (WHERE Clause)
		$this->CurrentFilter = $filter;

		// Get action
		if (IsApi()) {
			$this->CurrentAction = "delete"; // Delete record directly
		} elseif (Post("action") !== NULL) {
			$this->CurrentAction = Post("action");
		} elseif (Get("action") == "1") {
			$this->CurrentAction = "delete"; // Delete record directly
		} else {
			$this->CurrentAction = "delete"; // Delete record directly
		}
		if ($this->isDelete()) {
			$this->SendEmail = TRUE; // Send email on delete success
			if ($this->deleteRows()) { // Delete rows
				if ($this->getSuccessMessage() == "")
					$this->setSuccessMessage($Language->phrase("DeleteSuccess")); // Set up success message
				if (IsApi()) {
					$this->terminate(TRUE);
					return;
				} else {
					$this->terminate($this->getReturnUrl()); // Return to caller
				}
			} else { // Delete failed
				if (IsApi()) {
					$this->terminate();
					return;
				}
				$this->terminate($this->getReturnUrl()); // Return to caller
			}
		}
		if ($this->isShow()) { // Load records for display
			if ($this->Recordset = $this->loadRecordset())
				$this->TotalRecs = $this->Recordset->RecordCount(); // Get record count
			if ($this->TotalRecs <= 0) { // No record found, exit
				if ($this->Recordset)
					$this->Recordset->close();
				$this->terminate("lokdaftarlist.php"); // Return to list
			}
		}
	}

	// Load recordset
	public function loadRecordset($offset = -1, $rowcnt = -1)
	{

		// Load List page SQL
		$sql = $this->getListSql();
		$conn = &$this->getConnection();

		// Load recordset
		$dbtype = GetConnectionType($this->Dbid);
		if ($this->UseSelectLimit) {
			$conn->raiseErrorFn = $GLOBALS["ERROR_FUNC"];
			if ($dbtype == "MSSQL") {
				$rs = $conn->selectLimit($sql, $rowcnt, $offset, ["_hasOrderBy" => trim($this->getOrderBy()) || trim($this->getSessionOrderBy())]);
			} else {
				$rs = $conn->selectLimit($sql, $rowcnt, $offset);
			}
			$conn->raiseErrorFn = '';
		} else {
			$rs = LoadRecordset($sql, $conn);
		}

		// Call Recordset Selected event
		$this->Recordset_Selected($rs);
		return $rs;
	}

	// Load row based on key values
	public function loadRow()
	{
		global $Security, $Language;
		$filter = $this->getRecordFilter();

		// Call Row Selecting event
		$this->Row_Selecting($filter);

		// Load SQL based on filter
		$this->CurrentFilter = $filter;
		$sql = $this->getCurrentSql();
		$conn = &$this->getConnection();
		$res = FALSE;
		$rs = LoadRecordset($sql, $conn);
		if ($rs && !$rs->EOF) {
			$res = TRUE;
			$this->loadRowValues($rs); // Load row values
			$rs->close();
		}
		return $res;
	}

	// Load row values from recordset
	public function loadRowValues($rs = NULL)
	{
		if ($rs && !$rs->EOF)
			$row = $rs->fields;
		else
			$row = $this->newRow();

		// Call Row Selected event
		$this->Row_Selected($row);
		if (!$rs || $rs->EOF)
			return;
		$this->Id_Daftar->setDbValue($row['Id_Daftar']);
		$this->Tgl_Daftar->setDbValue($row['Tgl_Daftar']);
		$this->Waktu->setDbValue($row['Waktu']);
		$this->Id_Pasien->setDbValue($row['Id_Pasien']);
		$this->Nama_Pasien->setDbValue($row['Nama_Pasien']);
		$this->No_RM->setDbValue($row['No_RM']);
		$this->Tgl_Lahir->setDbValue($row['Tgl_Lahir']);
		$this->Jenis_Kelamin->setDbValue($row['Jenis_Kelamin']);
		$this->Alamat->setDbValue($row['Alamat']);
		$this->Id_Poliklinik->setDbValue($row['Id_Poliklinik']);
		$this->Poliklinik->setDbValue($row['Poliklinik']);
		$this->Rawat->setDbValue($row['Rawat']);
		$this->Id_Rujukan->setDbValue($row['Id_Rujukan']);
		$this->Id_JenisPasien->setDbValue($row['Id_JenisPasien']);
		$this->Lama_Baru->setDbValue($row['Lama_Baru']);
		$this->Id_BiayaDaftar->setDbValue($row['Id_BiayaDaftar']);
		$this->Total_Biaya->setDbValue($row['Total_Biaya']);
		$this->Petugas->setDbValue($row['Petugas']);
		$this->Status->setDbValue($row['Status']);
	}

	// Return a row with default values
	protected function newRow()
	{
		$row = [];
		$row['Id_Daftar'] = NULL;
		$row['Tgl_Daftar'] = NULL;
		$row['Waktu'] = NULL;
		$row['Id_Pasien'] = NULL;
		$row['Nama_Pasien'] = NULL;
		$row['No_RM'] = NULL;
		$row['Tgl_Lahir'] = NULL;
		$row['Jenis_Kelamin'] = NULL;
		$row['Alamat'] = NULL;
		$row['Id_Poliklinik'] = NULL;
		$row['Poliklinik'] = NULL;
		$row['Rawat'] = NULL;
		$row['Id_Rujukan'] = NULL;
		$row['Id_JenisPasien'] = NULL;
		$row['Lama_Baru'] = NULL;
		$row['Id_BiayaDaftar'] = NULL;
		$row['Total_Biaya'] = NULL;
		$row['Petugas'] = NULL;
		$row['Status'] = NULL;
		return $row;
	}

	// Render row values based on field settings
	public function renderRow()
	{
		global $Security, $Language, $CurrentLanguage;

		// Initialize URLs
		// Convert decimal values if posted back

		if ($this->Total_Biaya->FormValue == $this->Total_Biaya->CurrentValue && is_numeric(ConvertToFloatString($this->Total_Biaya->CurrentValue)))
			$this->Total_Biaya->CurrentValue = ConvertToFloatString($this->Total_Biaya->CurrentValue);

		// Call Row_Rendering event
		$this->Row_Rendering();

		// Common render codes for all row types
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

		if ($this->RowType == ROWTYPE_VIEW) { // View row

			// Tgl_Daftar
			$this->Tgl_Daftar->ViewValue = $this->Tgl_Daftar->CurrentValue;
			$this->Tgl_Daftar->ViewValue = FormatDateTime($this->Tgl_Daftar->ViewValue, 7);
			$this->Tgl_Daftar->ViewCustomAttributes = "";

			// Waktu
			$this->Waktu->ViewValue = $this->Waktu->CurrentValue;
			$this->Waktu->ViewValue = FormatDateTime($this->Waktu->ViewValue, 4);
			$this->Waktu->ViewCustomAttributes = "";

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

			// Tgl_Daftar
			$this->Tgl_Daftar->LinkCustomAttributes = "";
			$this->Tgl_Daftar->HrefValue = "";
			$this->Tgl_Daftar->TooltipValue = "";

			// Waktu
			$this->Waktu->LinkCustomAttributes = "";
			$this->Waktu->HrefValue = "";
			$this->Waktu->TooltipValue = "";

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

			// Total_Biaya
			$this->Total_Biaya->LinkCustomAttributes = "";
			$this->Total_Biaya->HrefValue = "";
			$this->Total_Biaya->TooltipValue = "";

			// Petugas
			$this->Petugas->LinkCustomAttributes = "";
			$this->Petugas->HrefValue = "";
			$this->Petugas->TooltipValue = "";
		}

		// Call Row Rendered event
		if ($this->RowType <> ROWTYPE_AGGREGATEINIT)
			$this->Row_Rendered();
	}

	// Delete records based on current filter
	protected function deleteRows()
	{
		global $Language, $Security;
		if (!$Security->canDelete()) {
			$this->setFailureMessage($Language->phrase("NoDeletePermission")); // No delete permission
			return FALSE;
		}
		$deleteRows = TRUE;
		$sql = $this->getCurrentSql();
		$conn = &$this->getConnection();
		$conn->raiseErrorFn = $GLOBALS["ERROR_FUNC"];
		$rs = $conn->execute($sql);
		$conn->raiseErrorFn = '';
		if ($rs === FALSE) {
			return FALSE;
		} elseif ($rs->EOF) {
			$this->setFailureMessage($Language->phrase("NoRecord")); // No record found
			$rs->close();
			return FALSE;
		}
		$rows = ($rs) ? $rs->getRows() : [];
		$conn->beginTrans();

		// Clone old rows
		$rsold = $rows;
		if ($rs)
			$rs->close();

		// Call row deleting event
		if ($deleteRows) {
			foreach ($rsold as $row) {
				$deleteRows = $this->Row_Deleting($row);
				if (!$deleteRows)
					break;
			}
		}
		if ($deleteRows) {
			$key = "";
			foreach ($rsold as $row) {
				$thisKey = "";
				if ($thisKey <> "")
					$thisKey .= $GLOBALS["COMPOSITE_KEY_SEPARATOR"];
				$thisKey .= $row['Id_Daftar'];
				if (DELETE_UPLOADED_FILES) // Delete old files
					$this->deleteUploadedFiles($row);
				$conn->raiseErrorFn = $GLOBALS["ERROR_FUNC"];
				$deleteRows = $this->delete($row); // Delete
				$conn->raiseErrorFn = '';
				if ($deleteRows === FALSE)
					break;
				if ($key <> "")
					$key .= ", ";
				$key .= $thisKey;
			}
		}
		if (!$deleteRows) {

			// Set up error message
			if ($this->getSuccessMessage() <> "" || $this->getFailureMessage() <> "") {

				// Use the message, do nothing
			} elseif ($this->CancelMessage <> "") {
				$this->setFailureMessage($this->CancelMessage);
				$this->CancelMessage = "";
			} else {
				$this->setFailureMessage($Language->phrase("DeleteCancelled"));
			}
		}
		if ($deleteRows) {
			$conn->commitTrans(); // Commit the changes
		} else {
			$conn->rollbackTrans(); // Rollback changes
		}

		// Call Row Deleted event
		if ($deleteRows) {
			foreach ($rsold as $row) {
				$this->Row_Deleted($row);
			}
		}

		// Write JSON for API request (Support single row only)
		if (IsApi() && $deleteRows) {
			$row = $this->getRecordsFromRecordset($rsold, TRUE);
			WriteJson(["success" => TRUE, $this->TableVar => $row]);
		}
		return $deleteRows;
	}

	// Set up Breadcrumb
	protected function setupBreadcrumb()
	{
		global $Breadcrumb, $Language;
		$Breadcrumb = new Breadcrumb();
		$url = substr(CurrentUrl(), strrpos(CurrentUrl(), "/")+1);
		$Breadcrumb->add("list", $this->TableVar, $this->addMasterUrl("lokdaftarlist.php"), "", $this->TableVar, TRUE);
		$pageId = "delete";
		$Breadcrumb->add("delete", $pageId, $url);
	}

	// Setup lookup options
	public function setupLookupOptions($fld)
	{
		if ($fld->Lookup !== NULL && $fld->Lookup->Options === NULL) {

			// No need to check any more
			$fld->Lookup->Options = [];

			// Set up lookup SQL
			switch ($fld->FieldVar) {
				case "x_Id_Poliklinik":
					$lookupFilter = function() {
						return "`Id_Poliklinik`!='{290320191250308A243FA9DF67A28BD1C5722022B148EE}'";
					};
					$lookupFilter = $lookupFilter->bindTo($this);
					break;
				default:
					$lookupFilter = "";
					break;
			}

			// Always call to Lookup->getSql so that user can setup Lookup->Options in Lookup_Selecting server event
			$sql = $fld->Lookup->getSql(FALSE, "", $lookupFilter, $this);

			// Set up lookup cache
			if ($fld->UseLookupCache && $sql <> "" && count($fld->Lookup->ParentFields) == 0 && count($fld->Lookup->Options) == 0) {
				$conn = &$this->getConnection();
				$totalCnt = $this->getRecordCount($sql);
				if ($totalCnt > $fld->LookupCacheCount) // Total count > cache count, do not cache
					return;
				$rs = $conn->execute($sql);
				$ar = [];
				while ($rs && !$rs->EOF) {
					$row = &$rs->fields;

					// Format the field values
					switch ($fld->FieldVar) {
						case "x_Id_Poliklinik":
							break;
						case "x_Id_Rujukan":
							break;
						case "x_Id_JenisPasien":
							break;
						case "x_Id_BiayaDaftar":
							break;
					}
					$ar[strval($row[0])] = $row;
					$rs->moveNext();
				}
				if ($rs)
					$rs->close();
				$fld->Lookup->Options = $ar;
			}
		}
	}

	// Page Load event
	function Page_Load() {

		//echo "Page Load";
	}

	// Page Unload event
	function Page_Unload() {

		//echo "Page Unload";
	}

	// Page Redirecting event
	function Page_Redirecting(&$url) {

		// Example:
		//$url = "your URL";

	}

	// Message Showing event
	// $type = ''|'success'|'failure'|'warning'
	function Message_Showing(&$msg, $type) {
		if ($type == 'success') {

			//$msg = "your success message";
		} elseif ($type == 'failure') {

			//$msg = "your failure message";
		} elseif ($type == 'warning') {

			//$msg = "your warning message";
		} else {

			//$msg = "your message";
		}
	}

	// Page Render event
	function Page_Render() {

		//echo "Page Render";
	}

	// Page Data Rendering event
	function Page_DataRendering(&$header) {

		// Example:
		//$header = "your header";

	}

	// Page Data Rendered event
	function Page_DataRendered(&$footer) {

		// Example:
		//$footer = "your footer";

	}
}
?>