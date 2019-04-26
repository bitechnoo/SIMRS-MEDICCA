<?php
namespace PHPMaker2019\tpp;

/**
 * Page class
 */
class lokpasien_edit extends lokpasien
{

	// Page ID
	public $PageID = "edit";

	// Project ID
	public $ProjectID = "{888F026C-2D04-4F2F-A77C-CABDD56A9360}";

	// Table name
	public $TableName = 'lokpasien';

	// Page object name
	public $PageObjName = "lokpasien_edit";

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

		// Table object (lokpasien)
		if (!isset($GLOBALS["lokpasien"]) || get_class($GLOBALS["lokpasien"]) == PROJECT_NAMESPACE . "lokpasien") {
			$GLOBALS["lokpasien"] = &$this;
			$GLOBALS["Table"] = &$GLOBALS["lokpasien"];
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
			define(PROJECT_NAMESPACE . "TABLE_NAME", 'lokpasien');

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
		global $EXPORT, $lokpasien;
		if ($this->CustomExport && $this->CustomExport == $this->Export && array_key_exists($this->CustomExport, $EXPORT)) {
				$content = ob_get_contents();
			if ($ExportFileName == "")
				$ExportFileName = $this->TableVar;
			$class = PROJECT_NAMESPACE . $EXPORT[$this->CustomExport];
			if (class_exists($class)) {
				$doc = new $class($lokpasien);
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

			// Handle modal response
			if ($this->IsModal) { // Show as modal
				$row = array("url" => $url, "modal" => "1");
				$pageName = GetPageName($url);
				if ($pageName != $this->getListUrl()) { // Not List page
					$row["caption"] = $this->getModalCaption($pageName);
					if ($pageName == "lokpasienview.php")
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
			$key .= @$ar['Id_Pasien'];
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
					$this->terminate(GetUrl("lokpasienlist.php"));
				else
					$this->terminate(GetUrl("login.php"));
				return;
			}
		}

		// Create form object
		$CurrentForm = new HttpForm();
		$this->CurrentAction = Param("action"); // Set up current action
		$this->Id_Pasien->Visible = FALSE;
		$this->No_RM->setVisibility();
		$this->Nama_Pasien->setVisibility();
		$this->No_BPJS->setVisibility();
		$this->No_KTP->setVisibility();
		$this->Tempat_Lahir->setVisibility();
		$this->Tgl_Lahir->setVisibility();
		$this->Jenis_Kelamin->setVisibility();
		$this->Alamat->setVisibility();
		$this->Id_Kelurahan->setVisibility();
		$this->Agama->setVisibility();
		$this->Lama_Baru->setVisibility();
		$this->sortNo_RM->Visible = FALSE;
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
		$this->setupLookupOptions($this->Id_Kelurahan);

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
			if ($CurrentForm->hasValue("x_Id_Pasien")) {
				$this->Id_Pasien->setFormValue($CurrentForm->getValue("x_Id_Pasien"));
			}
		} else {
			$this->CurrentAction = "show"; // Default action is display

			// Load key from QueryString
			$loadByQuery = FALSE;
			if (Get("Id_Pasien") !== NULL) {
				$this->Id_Pasien->setQueryStringValue(Get("Id_Pasien"));
				$loadByQuery = TRUE;
			} else {
				$this->Id_Pasien->CurrentValue = NULL;
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
					$this->terminate("lokpasienlist.php"); // No matching record, return to list
				}
				break;
			case "update": // Update
				$returnUrl = $this->getReturnUrl();
				if (GetPageName($returnUrl) == "lokpasienlist.php")
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

		// Check field name 'No_RM' first before field var 'x_No_RM'
		$val = $CurrentForm->hasValue("No_RM") ? $CurrentForm->getValue("No_RM") : $CurrentForm->getValue("x_No_RM");
		if (!$this->No_RM->IsDetailKey) {
			if (IsApi() && $val == NULL)
				$this->No_RM->Visible = FALSE; // Disable update for API request
			else
				$this->No_RM->setFormValue($val);
		}

		// Check field name 'Nama_Pasien' first before field var 'x_Nama_Pasien'
		$val = $CurrentForm->hasValue("Nama_Pasien") ? $CurrentForm->getValue("Nama_Pasien") : $CurrentForm->getValue("x_Nama_Pasien");
		if (!$this->Nama_Pasien->IsDetailKey) {
			if (IsApi() && $val == NULL)
				$this->Nama_Pasien->Visible = FALSE; // Disable update for API request
			else
				$this->Nama_Pasien->setFormValue($val);
		}

		// Check field name 'No_BPJS' first before field var 'x_No_BPJS'
		$val = $CurrentForm->hasValue("No_BPJS") ? $CurrentForm->getValue("No_BPJS") : $CurrentForm->getValue("x_No_BPJS");
		if (!$this->No_BPJS->IsDetailKey) {
			if (IsApi() && $val == NULL)
				$this->No_BPJS->Visible = FALSE; // Disable update for API request
			else
				$this->No_BPJS->setFormValue($val);
		}

		// Check field name 'No_KTP' first before field var 'x_No_KTP'
		$val = $CurrentForm->hasValue("No_KTP") ? $CurrentForm->getValue("No_KTP") : $CurrentForm->getValue("x_No_KTP");
		if (!$this->No_KTP->IsDetailKey) {
			if (IsApi() && $val == NULL)
				$this->No_KTP->Visible = FALSE; // Disable update for API request
			else
				$this->No_KTP->setFormValue($val);
		}

		// Check field name 'Tempat_Lahir' first before field var 'x_Tempat_Lahir'
		$val = $CurrentForm->hasValue("Tempat_Lahir") ? $CurrentForm->getValue("Tempat_Lahir") : $CurrentForm->getValue("x_Tempat_Lahir");
		if (!$this->Tempat_Lahir->IsDetailKey) {
			if (IsApi() && $val == NULL)
				$this->Tempat_Lahir->Visible = FALSE; // Disable update for API request
			else
				$this->Tempat_Lahir->setFormValue($val);
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

		// Check field name 'Id_Kelurahan' first before field var 'x_Id_Kelurahan'
		$val = $CurrentForm->hasValue("Id_Kelurahan") ? $CurrentForm->getValue("Id_Kelurahan") : $CurrentForm->getValue("x_Id_Kelurahan");
		if (!$this->Id_Kelurahan->IsDetailKey) {
			if (IsApi() && $val == NULL)
				$this->Id_Kelurahan->Visible = FALSE; // Disable update for API request
			else
				$this->Id_Kelurahan->setFormValue($val);
		}

		// Check field name 'Agama' first before field var 'x_Agama'
		$val = $CurrentForm->hasValue("Agama") ? $CurrentForm->getValue("Agama") : $CurrentForm->getValue("x_Agama");
		if (!$this->Agama->IsDetailKey) {
			if (IsApi() && $val == NULL)
				$this->Agama->Visible = FALSE; // Disable update for API request
			else
				$this->Agama->setFormValue($val);
		}

		// Check field name 'Lama_Baru' first before field var 'x_Lama_Baru'
		$val = $CurrentForm->hasValue("Lama_Baru") ? $CurrentForm->getValue("Lama_Baru") : $CurrentForm->getValue("x_Lama_Baru");
		if (!$this->Lama_Baru->IsDetailKey) {
			if (IsApi() && $val == NULL)
				$this->Lama_Baru->Visible = FALSE; // Disable update for API request
			else
				$this->Lama_Baru->setFormValue($val);
		}

		// Check field name 'Id_Pasien' first before field var 'x_Id_Pasien'
		$val = $CurrentForm->hasValue("Id_Pasien") ? $CurrentForm->getValue("Id_Pasien") : $CurrentForm->getValue("x_Id_Pasien");
		if (!$this->Id_Pasien->IsDetailKey)
			$this->Id_Pasien->setFormValue($val);
	}

	// Restore form values
	public function restoreFormValues()
	{
		global $CurrentForm;
		$this->Id_Pasien->CurrentValue = $this->Id_Pasien->FormValue;
		$this->No_RM->CurrentValue = $this->No_RM->FormValue;
		$this->Nama_Pasien->CurrentValue = $this->Nama_Pasien->FormValue;
		$this->No_BPJS->CurrentValue = $this->No_BPJS->FormValue;
		$this->No_KTP->CurrentValue = $this->No_KTP->FormValue;
		$this->Tempat_Lahir->CurrentValue = $this->Tempat_Lahir->FormValue;
		$this->Tgl_Lahir->CurrentValue = $this->Tgl_Lahir->FormValue;
		$this->Tgl_Lahir->CurrentValue = UnFormatDateTime($this->Tgl_Lahir->CurrentValue, 7);
		$this->Jenis_Kelamin->CurrentValue = $this->Jenis_Kelamin->FormValue;
		$this->Alamat->CurrentValue = $this->Alamat->FormValue;
		$this->Id_Kelurahan->CurrentValue = $this->Id_Kelurahan->FormValue;
		$this->Agama->CurrentValue = $this->Agama->FormValue;
		$this->Lama_Baru->CurrentValue = $this->Lama_Baru->FormValue;
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
		$this->Id_Pasien->setDbValue($row['Id_Pasien']);
		$this->No_RM->setDbValue($row['No_RM']);
		$this->Nama_Pasien->setDbValue($row['Nama_Pasien']);
		$this->No_BPJS->setDbValue($row['No_BPJS']);
		$this->No_KTP->setDbValue($row['No_KTP']);
		$this->Tempat_Lahir->setDbValue($row['Tempat_Lahir']);
		$this->Tgl_Lahir->setDbValue($row['Tgl_Lahir']);
		$this->Jenis_Kelamin->setDbValue($row['Jenis_Kelamin']);
		$this->Alamat->setDbValue($row['Alamat']);
		$this->Id_Kelurahan->setDbValue($row['Id_Kelurahan']);
		$this->Agama->setDbValue($row['Agama']);
		$this->Lama_Baru->setDbValue($row['Lama_Baru']);
		$this->sortNo_RM->setDbValue($row['sortNo_RM']);
	}

	// Return a row with default values
	protected function newRow()
	{
		$row = [];
		$row['Id_Pasien'] = NULL;
		$row['No_RM'] = NULL;
		$row['Nama_Pasien'] = NULL;
		$row['No_BPJS'] = NULL;
		$row['No_KTP'] = NULL;
		$row['Tempat_Lahir'] = NULL;
		$row['Tgl_Lahir'] = NULL;
		$row['Jenis_Kelamin'] = NULL;
		$row['Alamat'] = NULL;
		$row['Id_Kelurahan'] = NULL;
		$row['Agama'] = NULL;
		$row['Lama_Baru'] = NULL;
		$row['sortNo_RM'] = NULL;
		return $row;
	}

	// Load old record
	protected function loadOldRecord()
	{

		// Load key values from Session
		$validKey = TRUE;
		if (strval($this->getKey("Id_Pasien")) <> "")
			$this->Id_Pasien->CurrentValue = $this->getKey("Id_Pasien"); // Id_Pasien
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
		// Call Row_Rendering event

		$this->Row_Rendering();

		// Common render codes for all row types
		// Id_Pasien
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
		// sortNo_RM

		if ($this->RowType == ROWTYPE_VIEW) { // View row

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
		} elseif ($this->RowType == ROWTYPE_EDIT) { // Edit row

			// No_RM
			// Nama_Pasien

			$this->Nama_Pasien->EditAttrs["class"] = "form-control";
			$this->Nama_Pasien->EditCustomAttributes = 'autocomplete="off"';
			if (REMOVE_XSS)
				$this->Nama_Pasien->CurrentValue = HtmlDecode($this->Nama_Pasien->CurrentValue);
			$this->Nama_Pasien->EditValue = HtmlEncode($this->Nama_Pasien->CurrentValue);

			// No_BPJS
			$this->No_BPJS->EditAttrs["class"] = "form-control";
			$this->No_BPJS->EditCustomAttributes = 'autocomplete="off"';
			if (REMOVE_XSS)
				$this->No_BPJS->CurrentValue = HtmlDecode($this->No_BPJS->CurrentValue);
			$this->No_BPJS->EditValue = HtmlEncode($this->No_BPJS->CurrentValue);

			// No_KTP
			$this->No_KTP->EditAttrs["class"] = "form-control";
			$this->No_KTP->EditCustomAttributes = 'autocomplete="off"';
			if (REMOVE_XSS)
				$this->No_KTP->CurrentValue = HtmlDecode($this->No_KTP->CurrentValue);
			$this->No_KTP->EditValue = HtmlEncode($this->No_KTP->CurrentValue);

			// Tempat_Lahir
			$this->Tempat_Lahir->EditAttrs["class"] = "form-control";
			$this->Tempat_Lahir->EditCustomAttributes = 'autocomplete="off"';
			if (REMOVE_XSS)
				$this->Tempat_Lahir->CurrentValue = HtmlDecode($this->Tempat_Lahir->CurrentValue);
			$this->Tempat_Lahir->EditValue = HtmlEncode($this->Tempat_Lahir->CurrentValue);

			// Tgl_Lahir
			$this->Tgl_Lahir->EditAttrs["class"] = "form-control";
			$this->Tgl_Lahir->EditCustomAttributes = 'autocomplete="off"';
			$this->Tgl_Lahir->EditValue = HtmlEncode(FormatDateTime($this->Tgl_Lahir->CurrentValue, 7));

			// Jenis_Kelamin
			$this->Jenis_Kelamin->EditCustomAttributes = "";
			$this->Jenis_Kelamin->EditValue = $this->Jenis_Kelamin->options(FALSE);

			// Alamat
			$this->Alamat->EditAttrs["class"] = "form-control";
			$this->Alamat->EditCustomAttributes = 'autocomplete="off"';
			$this->Alamat->EditValue = HtmlEncode($this->Alamat->CurrentValue);

			// Id_Kelurahan
			$this->Id_Kelurahan->EditCustomAttributes = "";
			$curVal = trim(strval($this->Id_Kelurahan->CurrentValue));
			if ($curVal <> "")
				$this->Id_Kelurahan->ViewValue = $this->Id_Kelurahan->lookupCacheOption($curVal);
			else
				$this->Id_Kelurahan->ViewValue = $this->Id_Kelurahan->Lookup !== NULL && is_array($this->Id_Kelurahan->Lookup->Options) ? $curVal : NULL;
			if ($this->Id_Kelurahan->ViewValue !== NULL) { // Load from cache
				$this->Id_Kelurahan->EditValue = array_values($this->Id_Kelurahan->Lookup->Options);
				if ($this->Id_Kelurahan->ViewValue == "")
					$this->Id_Kelurahan->ViewValue = $Language->phrase("PleaseSelect");
			} else { // Lookup from database
				if ($curVal == "") {
					$filterWrk = "0=1";
				} else {
					$filterWrk = "`Id_Kelurahan`" . SearchString("=", $this->Id_Kelurahan->CurrentValue, DATATYPE_STRING, "");
				}
				$sqlWrk = $this->Id_Kelurahan->Lookup->getSql(TRUE, $filterWrk, '', $this);
				$rswrk = Conn()->execute($sqlWrk);
				if ($rswrk && !$rswrk->EOF) { // Lookup values found
					$arwrk = array();
					$arwrk[1] = HtmlEncode($rswrk->fields('df'));
					$this->Id_Kelurahan->ViewValue = $this->Id_Kelurahan->displayValue($arwrk);
				} else {
					$this->Id_Kelurahan->ViewValue = $Language->phrase("PleaseSelect");
				}
				$arwrk = ($rswrk) ? $rswrk->GetRows() : array();
				if ($rswrk) $rswrk->Close();
				$this->Id_Kelurahan->EditValue = $arwrk;
			}

			// Agama
			$this->Agama->EditCustomAttributes = "";
			$this->Agama->EditValue = $this->Agama->options(FALSE);

			// Lama_Baru
			$this->Lama_Baru->EditAttrs["class"] = "form-control";
			$this->Lama_Baru->EditCustomAttributes = "";

			// Edit refer script
			// No_RM

			$this->No_RM->LinkCustomAttributes = "";
			$this->No_RM->HrefValue = "";
			$this->No_RM->TooltipValue = "";

			// Nama_Pasien
			$this->Nama_Pasien->LinkCustomAttributes = "";
			$this->Nama_Pasien->HrefValue = "";

			// No_BPJS
			$this->No_BPJS->LinkCustomAttributes = "";
			$this->No_BPJS->HrefValue = "";

			// No_KTP
			$this->No_KTP->LinkCustomAttributes = "";
			$this->No_KTP->HrefValue = "";

			// Tempat_Lahir
			$this->Tempat_Lahir->LinkCustomAttributes = "";
			$this->Tempat_Lahir->HrefValue = "";

			// Tgl_Lahir
			$this->Tgl_Lahir->LinkCustomAttributes = "";
			$this->Tgl_Lahir->HrefValue = "";

			// Jenis_Kelamin
			$this->Jenis_Kelamin->LinkCustomAttributes = "";
			$this->Jenis_Kelamin->HrefValue = "";

			// Alamat
			$this->Alamat->LinkCustomAttributes = "";
			$this->Alamat->HrefValue = "";

			// Id_Kelurahan
			$this->Id_Kelurahan->LinkCustomAttributes = "";
			$this->Id_Kelurahan->HrefValue = "";

			// Agama
			$this->Agama->LinkCustomAttributes = "";
			$this->Agama->HrefValue = "";

			// Lama_Baru
			$this->Lama_Baru->LinkCustomAttributes = "";
			$this->Lama_Baru->HrefValue = "";
		}
		if ($this->RowType == ROWTYPE_ADD || $this->RowType == ROWTYPE_EDIT || $this->RowType == ROWTYPE_SEARCH) // Add/Edit/Search row
			$this->setupFieldTitles();

		// Call Row Rendered event
		if ($this->RowType <> ROWTYPE_AGGREGATEINIT)
			$this->Row_Rendered();
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
		if ($this->Id_Pasien->Required) {
			if (!$this->Id_Pasien->IsDetailKey && $this->Id_Pasien->FormValue != NULL && $this->Id_Pasien->FormValue == "") {
				AddMessage($FormError, str_replace("%s", $this->Id_Pasien->caption(), $this->Id_Pasien->RequiredErrorMessage));
			}
		}
		if ($this->No_RM->Required) {
			if (!$this->No_RM->IsDetailKey && $this->No_RM->FormValue != NULL && $this->No_RM->FormValue == "") {
				AddMessage($FormError, str_replace("%s", $this->No_RM->caption(), $this->No_RM->RequiredErrorMessage));
			}
		}
		if ($this->Nama_Pasien->Required) {
			if (!$this->Nama_Pasien->IsDetailKey && $this->Nama_Pasien->FormValue != NULL && $this->Nama_Pasien->FormValue == "") {
				AddMessage($FormError, str_replace("%s", $this->Nama_Pasien->caption(), $this->Nama_Pasien->RequiredErrorMessage));
			}
		}
		if ($this->No_BPJS->Required) {
			if (!$this->No_BPJS->IsDetailKey && $this->No_BPJS->FormValue != NULL && $this->No_BPJS->FormValue == "") {
				AddMessage($FormError, str_replace("%s", $this->No_BPJS->caption(), $this->No_BPJS->RequiredErrorMessage));
			}
		}
		if ($this->No_KTP->Required) {
			if (!$this->No_KTP->IsDetailKey && $this->No_KTP->FormValue != NULL && $this->No_KTP->FormValue == "") {
				AddMessage($FormError, str_replace("%s", $this->No_KTP->caption(), $this->No_KTP->RequiredErrorMessage));
			}
		}
		if ($this->Tempat_Lahir->Required) {
			if (!$this->Tempat_Lahir->IsDetailKey && $this->Tempat_Lahir->FormValue != NULL && $this->Tempat_Lahir->FormValue == "") {
				AddMessage($FormError, str_replace("%s", $this->Tempat_Lahir->caption(), $this->Tempat_Lahir->RequiredErrorMessage));
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
			if ($this->Jenis_Kelamin->FormValue == "") {
				AddMessage($FormError, str_replace("%s", $this->Jenis_Kelamin->caption(), $this->Jenis_Kelamin->RequiredErrorMessage));
			}
		}
		if ($this->Alamat->Required) {
			if (!$this->Alamat->IsDetailKey && $this->Alamat->FormValue != NULL && $this->Alamat->FormValue == "") {
				AddMessage($FormError, str_replace("%s", $this->Alamat->caption(), $this->Alamat->RequiredErrorMessage));
			}
		}
		if ($this->Id_Kelurahan->Required) {
			if (!$this->Id_Kelurahan->IsDetailKey && $this->Id_Kelurahan->FormValue != NULL && $this->Id_Kelurahan->FormValue == "") {
				AddMessage($FormError, str_replace("%s", $this->Id_Kelurahan->caption(), $this->Id_Kelurahan->RequiredErrorMessage));
			}
		}
		if ($this->Agama->Required) {
			if ($this->Agama->FormValue == "") {
				AddMessage($FormError, str_replace("%s", $this->Agama->caption(), $this->Agama->RequiredErrorMessage));
			}
		}
		if ($this->Lama_Baru->Required) {
			if (!$this->Lama_Baru->IsDetailKey && $this->Lama_Baru->FormValue != NULL && $this->Lama_Baru->FormValue == "") {
				AddMessage($FormError, str_replace("%s", $this->Lama_Baru->caption(), $this->Lama_Baru->RequiredErrorMessage));
			}
		}
		if ($this->sortNo_RM->Required) {
			if (!$this->sortNo_RM->IsDetailKey && $this->sortNo_RM->FormValue != NULL && $this->sortNo_RM->FormValue == "") {
				AddMessage($FormError, str_replace("%s", $this->sortNo_RM->caption(), $this->sortNo_RM->RequiredErrorMessage));
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
		if ($this->No_RM->CurrentValue <> "") { // Check field with unique index
			$filterChk = "(`No_RM` = '" . AdjustSql($this->No_RM->CurrentValue, $this->Dbid) . "')";
			$filterChk .= " AND NOT (" . $filter . ")";
			$this->CurrentFilter = $filterChk;
			$sqlChk = $this->getCurrentSql();
			$conn->raiseErrorFn = $GLOBALS["ERROR_FUNC"];
			$rsChk = $conn->Execute($sqlChk);
			$conn->raiseErrorFn = '';
			if ($rsChk === FALSE) {
				return FALSE;
			} elseif (!$rsChk->EOF) {
				$idxErrMsg = str_replace("%f", $this->No_RM->caption(), $Language->phrase("DupIndex"));
				$idxErrMsg = str_replace("%v", $this->No_RM->CurrentValue, $idxErrMsg);
				$this->setFailureMessage($idxErrMsg);
				$rsChk->close();
				return FALSE;
			}
			$rsChk->close();
		}
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

			// Nama_Pasien
			$this->Nama_Pasien->setDbValueDef($rsnew, $this->Nama_Pasien->CurrentValue, "", $this->Nama_Pasien->ReadOnly);

			// No_BPJS
			$this->No_BPJS->setDbValueDef($rsnew, $this->No_BPJS->CurrentValue, NULL, $this->No_BPJS->ReadOnly);

			// No_KTP
			$this->No_KTP->setDbValueDef($rsnew, $this->No_KTP->CurrentValue, NULL, $this->No_KTP->ReadOnly);

			// Tempat_Lahir
			$this->Tempat_Lahir->setDbValueDef($rsnew, $this->Tempat_Lahir->CurrentValue, "", $this->Tempat_Lahir->ReadOnly);

			// Tgl_Lahir
			$this->Tgl_Lahir->setDbValueDef($rsnew, UnFormatDateTime($this->Tgl_Lahir->CurrentValue, 7), CurrentDate(), $this->Tgl_Lahir->ReadOnly);

			// Jenis_Kelamin
			$this->Jenis_Kelamin->setDbValueDef($rsnew, $this->Jenis_Kelamin->CurrentValue, "", $this->Jenis_Kelamin->ReadOnly);

			// Alamat
			$this->Alamat->setDbValueDef($rsnew, $this->Alamat->CurrentValue, "", $this->Alamat->ReadOnly);

			// Id_Kelurahan
			$this->Id_Kelurahan->setDbValueDef($rsnew, $this->Id_Kelurahan->CurrentValue, "", $this->Id_Kelurahan->ReadOnly);

			// Agama
			$this->Agama->setDbValueDef($rsnew, $this->Agama->CurrentValue, "", $this->Agama->ReadOnly);

			// Lama_Baru
			$this->Lama_Baru->setDbValueDef($rsnew, $this->Lama_Baru->CurrentValue, "", $this->Lama_Baru->ReadOnly);

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
		$Breadcrumb->add("list", $this->TableVar, $this->addMasterUrl("lokpasienlist.php"), "", $this->TableVar, TRUE);
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
						case "x_Id_Kelurahan":
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