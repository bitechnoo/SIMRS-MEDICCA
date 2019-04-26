<?php
namespace PHPMaker2019\tpp;

/**
 * Page class
 */
class lokdaftar_edit extends lokdaftar
{

	// Page ID
	public $PageID = "edit";

	// Project ID
	public $ProjectID = "{888F026C-2D04-4F2F-A77C-CABDD56A9360}";

	// Table name
	public $TableName = 'lokdaftar';

	// Page object name
	public $PageObjName = "lokdaftar_edit";

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
			define(PROJECT_NAMESPACE . "PAGE_ID", 'edit');

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
		if (Post("customexport") === NULL) {

		// Page Unload event
		$this->Page_Unload();

		// Global Page Unloaded event (in userfn*.php)
		Page_Unloaded();
		}

		// Export
		global $EXPORT, $lokdaftar;
		if ($this->CustomExport && $this->CustomExport == $this->Export && array_key_exists($this->CustomExport, $EXPORT)) {
			if (is_array(@$_SESSION[SESSION_TEMP_IMAGES])) // Restore temp images
				$TempImages = @$_SESSION[SESSION_TEMP_IMAGES];
			if (Post("data") !== NULL)
				$content = Post("data");
			$ExportFileName = Post("filename", "");
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
	if ($this->CustomExport) { // Save temp images array for custom export
		if (is_array($TempImages))
			$_SESSION[SESSION_TEMP_IMAGES] = $TempImages;
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

			// Handle modal response
			if ($this->IsModal) { // Show as modal
				$row = array("url" => $url, "modal" => "1");
				$pageName = GetPageName($url);
				if ($pageName != $this->getListUrl()) { // Not List page
					$row["caption"] = $this->getModalCaption($pageName);
					if ($pageName == "lokdaftarview.php")
						$row["view"] = "1";
				} else { // List page should not be shown as modal => error
					$row["error"] = $this->getFailureMessage();
					$this->clearFailureMessage();
				}
				WriteJson($row);
			} else {
				SaveDebugMessage();
				AddHeader("Location", $url);
			}
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
	public $FormClassName = "ew-horizontal ew-form ew-edit-form";
	public $IsModal = FALSE;
	public $IsMobileOrModal = FALSE;
	public $DbMasterFilter;
	public $DbDetailFilter;

	//
	// Page run
	//

	public function run()
	{
		global $ExportType, $CustomExportType, $ExportFileName, $UserProfile, $Language, $Security, $RequestSecurity, $CurrentForm,
			$FormError, $SkipHeaderFooter;

		// Init Session data for API request if token found
		if (IsApi() && session_status() !== PHP_SESSION_ACTIVE) {
			$func = PROJECT_NAMESPACE . CHECK_TOKEN_FUNC;
			if (is_callable($func) && Param(TOKEN_NAME) !== NULL && $func(Param(TOKEN_NAME), SessionTimeoutTime()))
				session_start();
		}

		// Is modal
		$this->IsModal = (Param("modal") == "1");

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
			if (!$Security->canEdit()) {
				$Security->saveLastUrl();
				$this->setFailureMessage(DeniedMessage()); // Set no permission
				if ($Security->canList())
					$this->terminate(GetUrl("lokdaftarlist.php"));
				else
					$this->terminate(GetUrl("login.php"));
				return;
			}
		}

		// Create form object
		$CurrentForm = new HttpForm();
		$this->CurrentAction = Param("action"); // Set up current action
		$this->Id_Daftar->Visible = FALSE;
		$this->Tgl_Daftar->setVisibility();
		$this->Waktu->Visible = FALSE;
		$this->Id_Pasien->setVisibility();
		$this->Nama_Pasien->setVisibility();
		$this->No_RM->setVisibility();
		$this->Tgl_Lahir->setVisibility();
		$this->Jenis_Kelamin->setVisibility();
		$this->Alamat->setVisibility();
		$this->Id_Poliklinik->setVisibility();
		$this->Poliklinik->setVisibility();
		$this->Rawat->setVisibility();
		$this->Id_Rujukan->setVisibility();
		$this->Id_JenisPasien->setVisibility();
		$this->Lama_Baru->setVisibility();
		$this->Id_BiayaDaftar->setVisibility();
		$this->Total_Biaya->setVisibility();
		$this->Petugas->setVisibility();
		$this->Status->setVisibility();
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

		// Check modal
		if ($this->IsModal)
			$SkipHeaderFooter = TRUE;
		$this->IsMobileOrModal = IsMobile() || $this->IsModal;
		$this->FormClassName = "ew-form ew-edit-form ew-horizontal";
		$loaded = FALSE;
		$postBack = FALSE;

		// Set up current action and primary key
		if (IsApi()) {
			$this->CurrentAction = "update"; // Update record directly
			$postBack = TRUE;
		} elseif (Post("action") !== NULL) {
			$this->CurrentAction = Post("action"); // Get action code
			if (!$this->isShow()) // Not reload record, handle as postback
				$postBack = TRUE;

			// Load key from Form
			if ($CurrentForm->hasValue("x_Id_Daftar")) {
				$this->Id_Daftar->setFormValue($CurrentForm->getValue("x_Id_Daftar"));
			}
		} else {
			$this->CurrentAction = "show"; // Default action is display

			// Load key from QueryString
			$loadByQuery = FALSE;
			if (Get("Id_Daftar") !== NULL) {
				$this->Id_Daftar->setQueryStringValue(Get("Id_Daftar"));
				$loadByQuery = TRUE;
			} else {
				$this->Id_Daftar->CurrentValue = NULL;
			}
		}

		// Load current record
		$loaded = $this->loadRow();

		// Process form if post back
		if ($postBack) {
			$this->loadFormValues(); // Get form values
		}

		// Validate form if post back
		if ($postBack) {
			if (!$this->validateForm()) {
				$this->setFailureMessage($FormError);
				$this->EventCancelled = TRUE; // Event cancelled
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
				if (!$loaded) { // Load record based on key
					if ($this->getFailureMessage() == "")
						$this->setFailureMessage($Language->phrase("NoRecord")); // No record found
					$this->terminate("lokdaftarlist.php"); // No matching record, return to list
				}
				break;
			case "update": // Update
				$returnUrl = $this->getReturnUrl();
				if (GetPageName($returnUrl) == "lokdaftarlist.php")
					$returnUrl = $this->addMasterUrl($returnUrl); // List page, return to List page with correct master key if necessary
				$this->SendEmail = TRUE; // Send email on update success
				if ($this->editRow()) { // Update record based on key
					if ($this->getSuccessMessage() == "")
						$this->setSuccessMessage($Language->phrase("UpdateSuccess")); // Update success
					if (IsApi()) {
						$this->terminate(TRUE);
						return;
					} else {
						$this->terminate($returnUrl); // Return to caller
					}
				} elseif (IsApi()) { // API request, return
					$this->terminate();
					return;
				} elseif ($this->getFailureMessage() == $Language->phrase("NoRecord")) {
					$this->terminate($returnUrl); // Return to caller
				} else {
					$this->EventCancelled = TRUE; // Event cancelled
					$this->restoreFormValues(); // Restore form values if update failed
				}
		}

		// Set up Breadcrumb
		$this->setupBreadcrumb();

		// Render the record
		$this->RowType = ROWTYPE_EDIT; // Render as Edit
		$this->resetAttributes();
		$this->renderRow();
	}

	// Set up starting record parameters
	public function setupStartRec()
	{
		if ($this->DisplayRecs == 0)
			return;
		if ($this->isPageRequest()) { // Validate request
			if (Get(TABLE_START_REC) !== NULL) { // Check for "start" parameter
				$this->StartRec = Get(TABLE_START_REC);
				$this->setStartRecordNumber($this->StartRec);
			} elseif (Get(TABLE_PAGE_NO) !== NULL) {
				$pageNo = Get(TABLE_PAGE_NO);
				if (is_numeric($pageNo)) {
					$this->StartRec = ($pageNo - 1) * $this->DisplayRecs + 1;
					if ($this->StartRec <= 0) {
						$this->StartRec = 1;
					} elseif ($this->StartRec >= (int)(($this->TotalRecs - 1)/$this->DisplayRecs) * $this->DisplayRecs + 1) {
						$this->StartRec = (int)(($this->TotalRecs - 1)/$this->DisplayRecs) * $this->DisplayRecs + 1;
					}
					$this->setStartRecordNumber($this->StartRec);
				}
			}
		}
		$this->StartRec = $this->getStartRecordNumber();

		// Check if correct start record counter
		if (!is_numeric($this->StartRec) || $this->StartRec == "") { // Avoid invalid start record counter
			$this->StartRec = 1; // Reset start record counter
			$this->setStartRecordNumber($this->StartRec);
		} elseif ($this->StartRec > $this->TotalRecs) { // Avoid starting record > total records
			$this->StartRec = (int)(($this->TotalRecs - 1)/$this->DisplayRecs) * $this->DisplayRecs + 1; // Point to last page first record
			$this->setStartRecordNumber($this->StartRec);
		} elseif (($this->StartRec - 1) % $this->DisplayRecs <> 0) {
			$this->StartRec = (int)(($this->StartRec - 1)/$this->DisplayRecs) * $this->DisplayRecs + 1; // Point to page boundary
			$this->setStartRecordNumber($this->StartRec);
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

		// Check field name 'Tgl_Daftar' first before field var 'x_Tgl_Daftar'
		$val = $CurrentForm->hasValue("Tgl_Daftar") ? $CurrentForm->getValue("Tgl_Daftar") : $CurrentForm->getValue("x_Tgl_Daftar");
		if (!$this->Tgl_Daftar->IsDetailKey) {
			if (IsApi() && $val == NULL)
				$this->Tgl_Daftar->Visible = FALSE; // Disable update for API request
			else
				$this->Tgl_Daftar->setFormValue($val);
			$this->Tgl_Daftar->CurrentValue = UnFormatDateTime($this->Tgl_Daftar->CurrentValue, 7);
		}

		// Check field name 'Id_Pasien' first before field var 'x_Id_Pasien'
		$val = $CurrentForm->hasValue("Id_Pasien") ? $CurrentForm->getValue("Id_Pasien") : $CurrentForm->getValue("x_Id_Pasien");
		if (!$this->Id_Pasien->IsDetailKey) {
			if (IsApi() && $val == NULL)
				$this->Id_Pasien->Visible = FALSE; // Disable update for API request
			else
				$this->Id_Pasien->setFormValue($val);
		}

		// Check field name 'Nama_Pasien' first before field var 'x_Nama_Pasien'
		$val = $CurrentForm->hasValue("Nama_Pasien") ? $CurrentForm->getValue("Nama_Pasien") : $CurrentForm->getValue("x_Nama_Pasien");
		if (!$this->Nama_Pasien->IsDetailKey) {
			if (IsApi() && $val == NULL)
				$this->Nama_Pasien->Visible = FALSE; // Disable update for API request
			else
				$this->Nama_Pasien->setFormValue($val);
		}

		// Check field name 'No_RM' first before field var 'x_No_RM'
		$val = $CurrentForm->hasValue("No_RM") ? $CurrentForm->getValue("No_RM") : $CurrentForm->getValue("x_No_RM");
		if (!$this->No_RM->IsDetailKey) {
			if (IsApi() && $val == NULL)
				$this->No_RM->Visible = FALSE; // Disable update for API request
			else
				$this->No_RM->setFormValue($val);
		}

		// Check field name 'Tgl_Lahir' first before field var 'x_Tgl_Lahir'
		$val = $CurrentForm->hasValue("Tgl_Lahir") ? $CurrentForm->getValue("Tgl_Lahir") : $CurrentForm->getValue("x_Tgl_Lahir");
		if (!$this->Tgl_Lahir->IsDetailKey) {
			if (IsApi() && $val == NULL)
				$this->Tgl_Lahir->Visible = FALSE; // Disable update for API request
			else
				$this->Tgl_Lahir->setFormValue($val);
			$this->Tgl_Lahir->CurrentValue = UnFormatDateTime($this->Tgl_Lahir->CurrentValue, 7);
		}

		// Check field name 'Jenis_Kelamin' first before field var 'x_Jenis_Kelamin'
		$val = $CurrentForm->hasValue("Jenis_Kelamin") ? $CurrentForm->getValue("Jenis_Kelamin") : $CurrentForm->getValue("x_Jenis_Kelamin");
		if (!$this->Jenis_Kelamin->IsDetailKey) {
			if (IsApi() && $val == NULL)
				$this->Jenis_Kelamin->Visible = FALSE; // Disable update for API request
			else
				$this->Jenis_Kelamin->setFormValue($val);
		}

		// Check field name 'Alamat' first before field var 'x_Alamat'
		$val = $CurrentForm->hasValue("Alamat") ? $CurrentForm->getValue("Alamat") : $CurrentForm->getValue("x_Alamat");
		if (!$this->Alamat->IsDetailKey) {
			if (IsApi() && $val == NULL)
				$this->Alamat->Visible = FALSE; // Disable update for API request
			else
				$this->Alamat->setFormValue($val);
		}

		// Check field name 'Id_Poliklinik' first before field var 'x_Id_Poliklinik'
		$val = $CurrentForm->hasValue("Id_Poliklinik") ? $CurrentForm->getValue("Id_Poliklinik") : $CurrentForm->getValue("x_Id_Poliklinik");
		if (!$this->Id_Poliklinik->IsDetailKey) {
			if (IsApi() && $val == NULL)
				$this->Id_Poliklinik->Visible = FALSE; // Disable update for API request
			else
				$this->Id_Poliklinik->setFormValue($val);
		}

		// Check field name 'Poliklinik' first before field var 'x_Poliklinik'
		$val = $CurrentForm->hasValue("Poliklinik") ? $CurrentForm->getValue("Poliklinik") : $CurrentForm->getValue("x_Poliklinik");
		if (!$this->Poliklinik->IsDetailKey) {
			if (IsApi() && $val == NULL)
				$this->Poliklinik->Visible = FALSE; // Disable update for API request
			else
				$this->Poliklinik->setFormValue($val);
		}

		// Check field name 'Rawat' first before field var 'x_Rawat'
		$val = $CurrentForm->hasValue("Rawat") ? $CurrentForm->getValue("Rawat") : $CurrentForm->getValue("x_Rawat");
		if (!$this->Rawat->IsDetailKey) {
			if (IsApi() && $val == NULL)
				$this->Rawat->Visible = FALSE; // Disable update for API request
			else
				$this->Rawat->setFormValue($val);
		}

		// Check field name 'Id_Rujukan' first before field var 'x_Id_Rujukan'
		$val = $CurrentForm->hasValue("Id_Rujukan") ? $CurrentForm->getValue("Id_Rujukan") : $CurrentForm->getValue("x_Id_Rujukan");
		if (!$this->Id_Rujukan->IsDetailKey) {
			if (IsApi() && $val == NULL)
				$this->Id_Rujukan->Visible = FALSE; // Disable update for API request
			else
				$this->Id_Rujukan->setFormValue($val);
		}

		// Check field name 'Id_JenisPasien' first before field var 'x_Id_JenisPasien'
		$val = $CurrentForm->hasValue("Id_JenisPasien") ? $CurrentForm->getValue("Id_JenisPasien") : $CurrentForm->getValue("x_Id_JenisPasien");
		if (!$this->Id_JenisPasien->IsDetailKey) {
			if (IsApi() && $val == NULL)
				$this->Id_JenisPasien->Visible = FALSE; // Disable update for API request
			else
				$this->Id_JenisPasien->setFormValue($val);
		}

		// Check field name 'Lama_Baru' first before field var 'x_Lama_Baru'
		$val = $CurrentForm->hasValue("Lama_Baru") ? $CurrentForm->getValue("Lama_Baru") : $CurrentForm->getValue("x_Lama_Baru");
		if (!$this->Lama_Baru->IsDetailKey) {
			if (IsApi() && $val == NULL)
				$this->Lama_Baru->Visible = FALSE; // Disable update for API request
			else
				$this->Lama_Baru->setFormValue($val);
		}

		// Check field name 'Id_BiayaDaftar' first before field var 'x_Id_BiayaDaftar'
		$val = $CurrentForm->hasValue("Id_BiayaDaftar") ? $CurrentForm->getValue("Id_BiayaDaftar") : $CurrentForm->getValue("x_Id_BiayaDaftar");
		if (!$this->Id_BiayaDaftar->IsDetailKey) {
			if (IsApi() && $val == NULL)
				$this->Id_BiayaDaftar->Visible = FALSE; // Disable update for API request
			else
				$this->Id_BiayaDaftar->setFormValue($val);
		}

		// Check field name 'Total_Biaya' first before field var 'x_Total_Biaya'
		$val = $CurrentForm->hasValue("Total_Biaya") ? $CurrentForm->getValue("Total_Biaya") : $CurrentForm->getValue("x_Total_Biaya");
		if (!$this->Total_Biaya->IsDetailKey) {
			if (IsApi() && $val == NULL)
				$this->Total_Biaya->Visible = FALSE; // Disable update for API request
			else
				$this->Total_Biaya->setFormValue($val);
		}

		// Check field name 'Petugas' first before field var 'x_Petugas'
		$val = $CurrentForm->hasValue("Petugas") ? $CurrentForm->getValue("Petugas") : $CurrentForm->getValue("x_Petugas");
		if (!$this->Petugas->IsDetailKey) {
			if (IsApi() && $val == NULL)
				$this->Petugas->Visible = FALSE; // Disable update for API request
			else
				$this->Petugas->setFormValue($val);
		}

		// Check field name 'Status' first before field var 'x_Status'
		$val = $CurrentForm->hasValue("Status") ? $CurrentForm->getValue("Status") : $CurrentForm->getValue("x_Status");
		if (!$this->Status->IsDetailKey) {
			if (IsApi() && $val == NULL)
				$this->Status->Visible = FALSE; // Disable update for API request
			else
				$this->Status->setFormValue($val);
		}

		// Check field name 'Id_Daftar' first before field var 'x_Id_Daftar'
		$val = $CurrentForm->hasValue("Id_Daftar") ? $CurrentForm->getValue("Id_Daftar") : $CurrentForm->getValue("x_Id_Daftar");
		if (!$this->Id_Daftar->IsDetailKey)
			$this->Id_Daftar->setFormValue($val);
	}

	// Restore form values
	public function restoreFormValues()
	{
		global $CurrentForm;
		$this->Id_Daftar->CurrentValue = $this->Id_Daftar->FormValue;
		$this->Tgl_Daftar->CurrentValue = $this->Tgl_Daftar->FormValue;
		$this->Tgl_Daftar->CurrentValue = UnFormatDateTime($this->Tgl_Daftar->CurrentValue, 7);
		$this->Id_Pasien->CurrentValue = $this->Id_Pasien->FormValue;
		$this->Nama_Pasien->CurrentValue = $this->Nama_Pasien->FormValue;
		$this->No_RM->CurrentValue = $this->No_RM->FormValue;
		$this->Tgl_Lahir->CurrentValue = $this->Tgl_Lahir->FormValue;
		$this->Tgl_Lahir->CurrentValue = UnFormatDateTime($this->Tgl_Lahir->CurrentValue, 7);
		$this->Jenis_Kelamin->CurrentValue = $this->Jenis_Kelamin->FormValue;
		$this->Alamat->CurrentValue = $this->Alamat->FormValue;
		$this->Id_Poliklinik->CurrentValue = $this->Id_Poliklinik->FormValue;
		$this->Poliklinik->CurrentValue = $this->Poliklinik->FormValue;
		$this->Rawat->CurrentValue = $this->Rawat->FormValue;
		$this->Id_Rujukan->CurrentValue = $this->Id_Rujukan->FormValue;
		$this->Id_JenisPasien->CurrentValue = $this->Id_JenisPasien->FormValue;
		$this->Lama_Baru->CurrentValue = $this->Lama_Baru->FormValue;
		$this->Id_BiayaDaftar->CurrentValue = $this->Id_BiayaDaftar->FormValue;
		$this->Total_Biaya->CurrentValue = $this->Total_Biaya->FormValue;
		$this->Petugas->CurrentValue = $this->Petugas->FormValue;
		$this->Status->CurrentValue = $this->Status->FormValue;
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

	// Load old record
	protected function loadOldRecord()
	{

		// Load key values from Session
		$validKey = TRUE;
		if (strval($this->getKey("Id_Daftar")) <> "")
			$this->Id_Daftar->CurrentValue = $this->getKey("Id_Daftar"); // Id_Daftar
		else
			$validKey = FALSE;

		// Load old record
		$this->OldRecordset = NULL;
		if ($validKey) {
			$this->CurrentFilter = $this->getRecordFilter();
			$sql = $this->getCurrentSql();
			$conn = &$this->getConnection();
			$this->OldRecordset = LoadRecordset($sql, $conn);
		}
		$this->loadRowValues($this->OldRecordset); // Load row values
		return $validKey;
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
		// Tgl_Daftar
		// Waktu
		// Id_Pasien
		// Nama_Pasien
		// No_RM
		// Tgl_Lahir
		// Jenis_Kelamin
		// Alamat
		// Id_Poliklinik
		// Poliklinik
		// Rawat
		// Id_Rujukan
		// Id_JenisPasien
		// Lama_Baru
		// Id_BiayaDaftar
		// Total_Biaya
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

			// Tgl_Daftar
			$this->Tgl_Daftar->LinkCustomAttributes = "";
			$this->Tgl_Daftar->HrefValue = "";
			$this->Tgl_Daftar->TooltipValue = "";

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
		} elseif ($this->RowType == ROWTYPE_EDIT) { // Edit row

			// Tgl_Daftar
			$this->Tgl_Daftar->EditAttrs["class"] = "form-control";
			$this->Tgl_Daftar->EditCustomAttributes = 'autocomplete="off"';
			$this->Tgl_Daftar->EditValue = HtmlEncode(FormatDateTime($this->Tgl_Daftar->CurrentValue, 7));

			// Id_Pasien
			$this->Id_Pasien->EditAttrs["class"] = "form-control";
			$this->Id_Pasien->EditCustomAttributes = "";
			if (REMOVE_XSS)
				$this->Id_Pasien->CurrentValue = HtmlDecode($this->Id_Pasien->CurrentValue);
			$this->Id_Pasien->EditValue = HtmlEncode($this->Id_Pasien->CurrentValue);

			// Nama_Pasien
			$this->Nama_Pasien->EditAttrs["class"] = "form-control";
			$this->Nama_Pasien->EditCustomAttributes = 'autocomplete="off"';
			if (REMOVE_XSS)
				$this->Nama_Pasien->CurrentValue = HtmlDecode($this->Nama_Pasien->CurrentValue);
			$this->Nama_Pasien->EditValue = HtmlEncode($this->Nama_Pasien->CurrentValue);

			// No_RM
			$this->No_RM->EditAttrs["class"] = "form-control";
			$this->No_RM->EditCustomAttributes = "";
			if (REMOVE_XSS)
				$this->No_RM->CurrentValue = HtmlDecode($this->No_RM->CurrentValue);
			$this->No_RM->EditValue = HtmlEncode($this->No_RM->CurrentValue);

			// Tgl_Lahir
			$this->Tgl_Lahir->EditAttrs["class"] = "form-control";
			$this->Tgl_Lahir->EditCustomAttributes = "";
			$this->Tgl_Lahir->EditValue = HtmlEncode(FormatDateTime($this->Tgl_Lahir->CurrentValue, 7));

			// Jenis_Kelamin
			$this->Jenis_Kelamin->EditAttrs["class"] = "form-control";
			$this->Jenis_Kelamin->EditCustomAttributes = "";
			if (REMOVE_XSS)
				$this->Jenis_Kelamin->CurrentValue = HtmlDecode($this->Jenis_Kelamin->CurrentValue);
			$this->Jenis_Kelamin->EditValue = HtmlEncode($this->Jenis_Kelamin->CurrentValue);

			// Alamat
			$this->Alamat->EditAttrs["class"] = "form-control";
			$this->Alamat->EditCustomAttributes = "";
			$this->Alamat->EditValue = HtmlEncode($this->Alamat->CurrentValue);

			// Id_Poliklinik
			$this->Id_Poliklinik->EditCustomAttributes = "";
			$curVal = trim(strval($this->Id_Poliklinik->CurrentValue));
			if ($curVal <> "")
				$this->Id_Poliklinik->ViewValue = $this->Id_Poliklinik->lookupCacheOption($curVal);
			else
				$this->Id_Poliklinik->ViewValue = $this->Id_Poliklinik->Lookup !== NULL && is_array($this->Id_Poliklinik->Lookup->Options) ? $curVal : NULL;
			if ($this->Id_Poliklinik->ViewValue !== NULL) { // Load from cache
				$this->Id_Poliklinik->EditValue = array_values($this->Id_Poliklinik->Lookup->Options);
			} else { // Lookup from database
				if ($curVal == "") {
					$filterWrk = "0=1";
				} else {
					$filterWrk = "`Id_Poliklinik`" . SearchString("=", $this->Id_Poliklinik->CurrentValue, DATATYPE_STRING, "");
				}
				$lookupFilter = function() {
					return "`Id_Poliklinik`!='{290320191250308A243FA9DF67A28BD1C5722022B148EE}'";
				};
				$lookupFilter = $lookupFilter->bindTo($this);
				$sqlWrk = $this->Id_Poliklinik->Lookup->getSql(TRUE, $filterWrk, $lookupFilter, $this);
				$rswrk = Conn()->execute($sqlWrk);
				$arwrk = ($rswrk) ? $rswrk->GetRows() : array();
				if ($rswrk) $rswrk->Close();
				$this->Id_Poliklinik->EditValue = $arwrk;
			}

			// Poliklinik
			$this->Poliklinik->EditAttrs["class"] = "form-control";
			$this->Poliklinik->EditCustomAttributes = "";
			if (REMOVE_XSS)
				$this->Poliklinik->CurrentValue = HtmlDecode($this->Poliklinik->CurrentValue);
			$this->Poliklinik->EditValue = HtmlEncode($this->Poliklinik->CurrentValue);

			// Rawat
			$this->Rawat->EditAttrs["class"] = "form-control";
			$this->Rawat->EditCustomAttributes = "";

			// Id_Rujukan
			$this->Id_Rujukan->EditCustomAttributes = "";
			$curVal = trim(strval($this->Id_Rujukan->CurrentValue));
			if ($curVal <> "")
				$this->Id_Rujukan->ViewValue = $this->Id_Rujukan->lookupCacheOption($curVal);
			else
				$this->Id_Rujukan->ViewValue = $this->Id_Rujukan->Lookup !== NULL && is_array($this->Id_Rujukan->Lookup->Options) ? $curVal : NULL;
			if ($this->Id_Rujukan->ViewValue !== NULL) { // Load from cache
				$this->Id_Rujukan->EditValue = array_values($this->Id_Rujukan->Lookup->Options);
			} else { // Lookup from database
				if ($curVal == "") {
					$filterWrk = "0=1";
				} else {
					$filterWrk = "`Id_Rujukan`" . SearchString("=", $this->Id_Rujukan->CurrentValue, DATATYPE_STRING, "");
				}
				$sqlWrk = $this->Id_Rujukan->Lookup->getSql(TRUE, $filterWrk, '', $this);
				$rswrk = Conn()->execute($sqlWrk);
				$arwrk = ($rswrk) ? $rswrk->GetRows() : array();
				if ($rswrk) $rswrk->Close();
				$this->Id_Rujukan->EditValue = $arwrk;
			}

			// Id_JenisPasien
			$this->Id_JenisPasien->EditCustomAttributes = "";
			$curVal = trim(strval($this->Id_JenisPasien->CurrentValue));
			if ($curVal <> "")
				$this->Id_JenisPasien->ViewValue = $this->Id_JenisPasien->lookupCacheOption($curVal);
			else
				$this->Id_JenisPasien->ViewValue = $this->Id_JenisPasien->Lookup !== NULL && is_array($this->Id_JenisPasien->Lookup->Options) ? $curVal : NULL;
			if ($this->Id_JenisPasien->ViewValue !== NULL) { // Load from cache
				$this->Id_JenisPasien->EditValue = array_values($this->Id_JenisPasien->Lookup->Options);
			} else { // Lookup from database
				if ($curVal == "") {
					$filterWrk = "0=1";
				} else {
					$filterWrk = "`Id_JenisPasien`" . SearchString("=", $this->Id_JenisPasien->CurrentValue, DATATYPE_STRING, "");
				}
				$sqlWrk = $this->Id_JenisPasien->Lookup->getSql(TRUE, $filterWrk, '', $this);
				$rswrk = Conn()->execute($sqlWrk);
				$arwrk = ($rswrk) ? $rswrk->GetRows() : array();
				if ($rswrk) $rswrk->Close();
				$this->Id_JenisPasien->EditValue = $arwrk;
			}

			// Lama_Baru
			$this->Lama_Baru->EditAttrs["class"] = "form-control";
			$this->Lama_Baru->EditCustomAttributes = "";
			if (REMOVE_XSS)
				$this->Lama_Baru->CurrentValue = HtmlDecode($this->Lama_Baru->CurrentValue);
			$this->Lama_Baru->EditValue = HtmlEncode($this->Lama_Baru->CurrentValue);

			// Id_BiayaDaftar
			$this->Id_BiayaDaftar->EditCustomAttributes = "";
			$curVal = trim(strval($this->Id_BiayaDaftar->CurrentValue));
			if ($curVal <> "")
				$this->Id_BiayaDaftar->ViewValue = $this->Id_BiayaDaftar->lookupCacheOption($curVal);
			else
				$this->Id_BiayaDaftar->ViewValue = $this->Id_BiayaDaftar->Lookup !== NULL && is_array($this->Id_BiayaDaftar->Lookup->Options) ? $curVal : NULL;
			if ($this->Id_BiayaDaftar->ViewValue !== NULL) { // Load from cache
				$this->Id_BiayaDaftar->EditValue = array_values($this->Id_BiayaDaftar->Lookup->Options);
			} else { // Lookup from database
				if ($curVal == "") {
					$filterWrk = "0=1";
				} else {
					$filterWrk = "`Id_Biayadaftar`" . SearchString("=", $this->Id_BiayaDaftar->CurrentValue, DATATYPE_STRING, "");
				}
				$sqlWrk = $this->Id_BiayaDaftar->Lookup->getSql(TRUE, $filterWrk, '', $this);
				$rswrk = Conn()->execute($sqlWrk);
				$arwrk = ($rswrk) ? $rswrk->GetRows() : array();
				if ($rswrk) $rswrk->Close();
				$this->Id_BiayaDaftar->EditValue = $arwrk;
			}

			// Total_Biaya
			$this->Total_Biaya->EditAttrs["class"] = "form-control";
			$this->Total_Biaya->EditCustomAttributes = 'autocomplete="off"';
			$this->Total_Biaya->EditValue = HtmlEncode($this->Total_Biaya->CurrentValue);
			if (strval($this->Total_Biaya->EditValue) <> "" && is_numeric($this->Total_Biaya->EditValue))
				$this->Total_Biaya->EditValue = FormatNumber($this->Total_Biaya->EditValue, -2, -1, -2, 0);

			// Petugas
			$this->Petugas->EditAttrs["class"] = "form-control";
			$this->Petugas->EditCustomAttributes = "";

			// Status
			$this->Status->EditAttrs["class"] = "form-control";
			$this->Status->EditCustomAttributes = "";

			// Edit refer script
			// Tgl_Daftar

			$this->Tgl_Daftar->LinkCustomAttributes = "";
			$this->Tgl_Daftar->HrefValue = "";

			// Id_Pasien
			$this->Id_Pasien->LinkCustomAttributes = "";
			$this->Id_Pasien->HrefValue = "";

			// Nama_Pasien
			$this->Nama_Pasien->LinkCustomAttributes = "";
			$this->Nama_Pasien->HrefValue = "";

			// No_RM
			$this->No_RM->LinkCustomAttributes = "";
			$this->No_RM->HrefValue = "";

			// Tgl_Lahir
			$this->Tgl_Lahir->LinkCustomAttributes = "";
			$this->Tgl_Lahir->HrefValue = "";

			// Jenis_Kelamin
			$this->Jenis_Kelamin->LinkCustomAttributes = "";
			$this->Jenis_Kelamin->HrefValue = "";

			// Alamat
			$this->Alamat->LinkCustomAttributes = "";
			$this->Alamat->HrefValue = "";

			// Id_Poliklinik
			$this->Id_Poliklinik->LinkCustomAttributes = "";
			$this->Id_Poliklinik->HrefValue = "";

			// Poliklinik
			$this->Poliklinik->LinkCustomAttributes = "";
			$this->Poliklinik->HrefValue = "";

			// Rawat
			$this->Rawat->LinkCustomAttributes = "";
			$this->Rawat->HrefValue = "";

			// Id_Rujukan
			$this->Id_Rujukan->LinkCustomAttributes = "";
			$this->Id_Rujukan->HrefValue = "";

			// Id_JenisPasien
			$this->Id_JenisPasien->LinkCustomAttributes = "";
			$this->Id_JenisPasien->HrefValue = "";

			// Lama_Baru
			$this->Lama_Baru->LinkCustomAttributes = "";
			$this->Lama_Baru->HrefValue = "";

			// Id_BiayaDaftar
			$this->Id_BiayaDaftar->LinkCustomAttributes = "";
			$this->Id_BiayaDaftar->HrefValue = "";

			// Total_Biaya
			$this->Total_Biaya->LinkCustomAttributes = "";
			$this->Total_Biaya->HrefValue = "";

			// Petugas
			$this->Petugas->LinkCustomAttributes = "";
			$this->Petugas->HrefValue = "";

			// Status
			$this->Status->LinkCustomAttributes = "";
			$this->Status->HrefValue = "";
		}
		if ($this->RowType == ROWTYPE_ADD || $this->RowType == ROWTYPE_EDIT || $this->RowType == ROWTYPE_SEARCH) // Add/Edit/Search row
			$this->setupFieldTitles();

		// Call Row Rendered event
		if ($this->RowType <> ROWTYPE_AGGREGATEINIT)
			$this->Row_Rendered();

		// Save data for Custom Template
		if ($this->RowType == ROWTYPE_VIEW || $this->RowType == ROWTYPE_EDIT || $this->RowType == ROWTYPE_ADD)
			$this->Rows[] = $this->customTemplateFieldValues();
	}

	// Validate form
	protected function validateForm()
	{
		global $Language, $FormError;

		// Initialize form error message
		$FormError = "";

		// Check if validation required
		if (!SERVER_VALIDATE)
			return ($FormError == "");
		if ($this->Id_Daftar->Required) {
			if (!$this->Id_Daftar->IsDetailKey && $this->Id_Daftar->FormValue != NULL && $this->Id_Daftar->FormValue == "") {
				AddMessage($FormError, str_replace("%s", $this->Id_Daftar->caption(), $this->Id_Daftar->RequiredErrorMessage));
			}
		}
		if ($this->Tgl_Daftar->Required) {
			if (!$this->Tgl_Daftar->IsDetailKey && $this->Tgl_Daftar->FormValue != NULL && $this->Tgl_Daftar->FormValue == "") {
				AddMessage($FormError, str_replace("%s", $this->Tgl_Daftar->caption(), $this->Tgl_Daftar->RequiredErrorMessage));
			}
		}
		if (!CheckEuroDate($this->Tgl_Daftar->FormValue)) {
			AddMessage($FormError, $this->Tgl_Daftar->errorMessage());
		}
		if ($this->Waktu->Required) {
			if (!$this->Waktu->IsDetailKey && $this->Waktu->FormValue != NULL && $this->Waktu->FormValue == "") {
				AddMessage($FormError, str_replace("%s", $this->Waktu->caption(), $this->Waktu->RequiredErrorMessage));
			}
		}
		if ($this->Id_Pasien->Required) {
			if (!$this->Id_Pasien->IsDetailKey && $this->Id_Pasien->FormValue != NULL && $this->Id_Pasien->FormValue == "") {
				AddMessage($FormError, str_replace("%s", $this->Id_Pasien->caption(), $this->Id_Pasien->RequiredErrorMessage));
			}
		}
		if ($this->Nama_Pasien->Required) {
			if (!$this->Nama_Pasien->IsDetailKey && $this->Nama_Pasien->FormValue != NULL && $this->Nama_Pasien->FormValue == "") {
				AddMessage($FormError, str_replace("%s", $this->Nama_Pasien->caption(), $this->Nama_Pasien->RequiredErrorMessage));
			}
		}
		if ($this->No_RM->Required) {
			if (!$this->No_RM->IsDetailKey && $this->No_RM->FormValue != NULL && $this->No_RM->FormValue == "") {
				AddMessage($FormError, str_replace("%s", $this->No_RM->caption(), $this->No_RM->RequiredErrorMessage));
			}
		}
		if ($this->Tgl_Lahir->Required) {
			if (!$this->Tgl_Lahir->IsDetailKey && $this->Tgl_Lahir->FormValue != NULL && $this->Tgl_Lahir->FormValue == "") {
				AddMessage($FormError, str_replace("%s", $this->Tgl_Lahir->caption(), $this->Tgl_Lahir->RequiredErrorMessage));
			}
		}
		if (!CheckEuroDate($this->Tgl_Lahir->FormValue)) {
			AddMessage($FormError, $this->Tgl_Lahir->errorMessage());
		}
		if ($this->Jenis_Kelamin->Required) {
			if (!$this->Jenis_Kelamin->IsDetailKey && $this->Jenis_Kelamin->FormValue != NULL && $this->Jenis_Kelamin->FormValue == "") {
				AddMessage($FormError, str_replace("%s", $this->Jenis_Kelamin->caption(), $this->Jenis_Kelamin->RequiredErrorMessage));
			}
		}
		if ($this->Alamat->Required) {
			if (!$this->Alamat->IsDetailKey && $this->Alamat->FormValue != NULL && $this->Alamat->FormValue == "") {
				AddMessage($FormError, str_replace("%s", $this->Alamat->caption(), $this->Alamat->RequiredErrorMessage));
			}
		}
		if ($this->Id_Poliklinik->Required) {
			if ($this->Id_Poliklinik->FormValue == "") {
				AddMessage($FormError, str_replace("%s", $this->Id_Poliklinik->caption(), $this->Id_Poliklinik->RequiredErrorMessage));
			}
		}
		if ($this->Poliklinik->Required) {
			if (!$this->Poliklinik->IsDetailKey && $this->Poliklinik->FormValue != NULL && $this->Poliklinik->FormValue == "") {
				AddMessage($FormError, str_replace("%s", $this->Poliklinik->caption(), $this->Poliklinik->RequiredErrorMessage));
			}
		}
		if ($this->Rawat->Required) {
			if (!$this->Rawat->IsDetailKey && $this->Rawat->FormValue != NULL && $this->Rawat->FormValue == "") {
				AddMessage($FormError, str_replace("%s", $this->Rawat->caption(), $this->Rawat->RequiredErrorMessage));
			}
		}
		if ($this->Id_Rujukan->Required) {
			if ($this->Id_Rujukan->FormValue == "") {
				AddMessage($FormError, str_replace("%s", $this->Id_Rujukan->caption(), $this->Id_Rujukan->RequiredErrorMessage));
			}
		}
		if ($this->Id_JenisPasien->Required) {
			if ($this->Id_JenisPasien->FormValue == "") {
				AddMessage($FormError, str_replace("%s", $this->Id_JenisPasien->caption(), $this->Id_JenisPasien->RequiredErrorMessage));
			}
		}
		if ($this->Lama_Baru->Required) {
			if (!$this->Lama_Baru->IsDetailKey && $this->Lama_Baru->FormValue != NULL && $this->Lama_Baru->FormValue == "") {
				AddMessage($FormError, str_replace("%s", $this->Lama_Baru->caption(), $this->Lama_Baru->RequiredErrorMessage));
			}
		}
		if ($this->Id_BiayaDaftar->Required) {
			if ($this->Id_BiayaDaftar->FormValue == "") {
				AddMessage($FormError, str_replace("%s", $this->Id_BiayaDaftar->caption(), $this->Id_BiayaDaftar->RequiredErrorMessage));
			}
		}
		if ($this->Total_Biaya->Required) {
			if (!$this->Total_Biaya->IsDetailKey && $this->Total_Biaya->FormValue != NULL && $this->Total_Biaya->FormValue == "") {
				AddMessage($FormError, str_replace("%s", $this->Total_Biaya->caption(), $this->Total_Biaya->RequiredErrorMessage));
			}
		}
		if ($this->Petugas->Required) {
			if (!$this->Petugas->IsDetailKey && $this->Petugas->FormValue != NULL && $this->Petugas->FormValue == "") {
				AddMessage($FormError, str_replace("%s", $this->Petugas->caption(), $this->Petugas->RequiredErrorMessage));
			}
		}
		if ($this->Status->Required) {
			if (!$this->Status->IsDetailKey && $this->Status->FormValue != NULL && $this->Status->FormValue == "") {
				AddMessage($FormError, str_replace("%s", $this->Status->caption(), $this->Status->RequiredErrorMessage));
			}
		}

		// Return validate result
		$validateForm = ($FormError == "");

		// Call Form_CustomValidate event
		$formCustomError = "";
		$validateForm = $validateForm && $this->Form_CustomValidate($formCustomError);
		if ($formCustomError <> "") {
			AddMessage($FormError, $formCustomError);
		}
		return $validateForm;
	}

	// Update record based on key values
	protected function editRow()
	{
		global $Security, $Language;
		$filter = $this->getRecordFilter();
		$filter = $this->applyUserIDFilters($filter);
		$conn = &$this->getConnection();
		$this->CurrentFilter = $filter;
		$sql = $this->getCurrentSql();
		$conn->raiseErrorFn = $GLOBALS["ERROR_FUNC"];
		$rs = $conn->execute($sql);
		$conn->raiseErrorFn = '';
		if ($rs === FALSE)
			return FALSE;
		if ($rs->EOF) {
			$this->setFailureMessage($Language->phrase("NoRecord")); // Set no record message
			$editRow = FALSE; // Update Failed
		} else {

			// Save old values
			$rsold = &$rs->fields;
			$this->loadDbValues($rsold);
			$rsnew = [];

			// Tgl_Daftar
			$this->Tgl_Daftar->setDbValueDef($rsnew, UnFormatDateTime($this->Tgl_Daftar->CurrentValue, 7), CurrentDate(), $this->Tgl_Daftar->ReadOnly);

			// Id_Pasien
			$this->Id_Pasien->setDbValueDef($rsnew, $this->Id_Pasien->CurrentValue, "", $this->Id_Pasien->ReadOnly);

			// Nama_Pasien
			$this->Nama_Pasien->setDbValueDef($rsnew, $this->Nama_Pasien->CurrentValue, NULL, $this->Nama_Pasien->ReadOnly);

			// No_RM
			$this->No_RM->setDbValueDef($rsnew, $this->No_RM->CurrentValue, NULL, $this->No_RM->ReadOnly);

			// Tgl_Lahir
			$this->Tgl_Lahir->setDbValueDef($rsnew, UnFormatDateTime($this->Tgl_Lahir->CurrentValue, 7), NULL, $this->Tgl_Lahir->ReadOnly);

			// Jenis_Kelamin
			$this->Jenis_Kelamin->setDbValueDef($rsnew, $this->Jenis_Kelamin->CurrentValue, NULL, $this->Jenis_Kelamin->ReadOnly);

			// Alamat
			$this->Alamat->setDbValueDef($rsnew, $this->Alamat->CurrentValue, NULL, $this->Alamat->ReadOnly);

			// Id_Poliklinik
			$this->Id_Poliklinik->setDbValueDef($rsnew, $this->Id_Poliklinik->CurrentValue, "", $this->Id_Poliklinik->ReadOnly);

			// Poliklinik
			$this->Poliklinik->setDbValueDef($rsnew, $this->Poliklinik->CurrentValue, NULL, $this->Poliklinik->ReadOnly);

			// Rawat
			$this->Rawat->setDbValueDef($rsnew, $this->Rawat->CurrentValue, "", $this->Rawat->ReadOnly);

			// Id_Rujukan
			$this->Id_Rujukan->setDbValueDef($rsnew, $this->Id_Rujukan->CurrentValue, "", $this->Id_Rujukan->ReadOnly);

			// Id_JenisPasien
			$this->Id_JenisPasien->setDbValueDef($rsnew, $this->Id_JenisPasien->CurrentValue, "", $this->Id_JenisPasien->ReadOnly);

			// Lama_Baru
			$this->Lama_Baru->setDbValueDef($rsnew, $this->Lama_Baru->CurrentValue, "", $this->Lama_Baru->ReadOnly);

			// Id_BiayaDaftar
			$this->Id_BiayaDaftar->setDbValueDef($rsnew, $this->Id_BiayaDaftar->CurrentValue, "", $this->Id_BiayaDaftar->ReadOnly);

			// Total_Biaya
			$this->Total_Biaya->setDbValueDef($rsnew, $this->Total_Biaya->CurrentValue, 0, $this->Total_Biaya->ReadOnly);

			// Petugas
			$this->Petugas->setDbValueDef($rsnew, $this->Petugas->CurrentValue, "", $this->Petugas->ReadOnly);

			// Status
			$this->Status->setDbValueDef($rsnew, $this->Status->CurrentValue, "", $this->Status->ReadOnly);

			// Call Row Updating event
			$updateRow = $this->Row_Updating($rsold, $rsnew);
			if ($updateRow) {
				$conn->raiseErrorFn = $GLOBALS["ERROR_FUNC"];
				if (count($rsnew) > 0)
					$editRow = $this->update($rsnew, "", $rsold);
				else
					$editRow = TRUE; // No field to update
				$conn->raiseErrorFn = '';
				if ($editRow) {
				}
			} else {
				if ($this->getSuccessMessage() <> "" || $this->getFailureMessage() <> "") {

					// Use the message, do nothing
				} elseif ($this->CancelMessage <> "") {
					$this->setFailureMessage($this->CancelMessage);
					$this->CancelMessage = "";
				} else {
					$this->setFailureMessage($Language->phrase("UpdateCancelled"));
				}
				$editRow = FALSE;
			}
		}

		// Call Row_Updated event
		if ($editRow)
			$this->Row_Updated($rsold, $rsnew);
		$rs->close();

		// Write JSON for API request
		if (IsApi() && $editRow) {
			$row = $this->getRecordsFromRecordset([$rsnew], TRUE);
			WriteJson(["success" => TRUE, $this->TableVar => $row]);
		}
		return $editRow;
	}

	// Set up Breadcrumb
	protected function setupBreadcrumb()
	{
		global $Breadcrumb, $Language;
		$Breadcrumb = new Breadcrumb();
		$url = substr(CurrentUrl(), strrpos(CurrentUrl(), "/")+1);
		$Breadcrumb->add("list", $this->TableVar, $this->addMasterUrl("lokdaftarlist.php"), "", $this->TableVar, TRUE);
		$pageId = "edit";
		$Breadcrumb->add("edit", $pageId, $url);
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

	// Form Custom Validate event
	function Form_CustomValidate(&$customError) {

		// Return error message in CustomError
		return TRUE;
	}
}
?>