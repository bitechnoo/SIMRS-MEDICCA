<?php
namespace PHPMaker2019\tpp;

/**
 * Page class
 */
class lokbiayadaftar_add extends lokbiayadaftar
{

	// Page ID
	public $PageID = "add";

	// Project ID
	public $ProjectID = "{888F026C-2D04-4F2F-A77C-CABDD56A9360}";

	// Table name
	public $TableName = 'lokbiayadaftar';

	// Page object name
	public $PageObjName = "lokbiayadaftar_add";

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

		// Table object (lokbiayadaftar)
		if (!isset($GLOBALS["lokbiayadaftar"]) || get_class($GLOBALS["lokbiayadaftar"]) == PROJECT_NAMESPACE . "lokbiayadaftar") {
			$GLOBALS["lokbiayadaftar"] = &$this;
			$GLOBALS["Table"] = &$GLOBALS["lokbiayadaftar"];
		}
		$this->CancelUrl = $this->pageUrl() . "action=cancel";

		// Table object (vlokpetugas)
		if (!isset($GLOBALS['vlokpetugas']))
			$GLOBALS['vlokpetugas'] = new vlokpetugas();

		// Page ID
		if (!defined(PROJECT_NAMESPACE . "PAGE_ID"))
			define(PROJECT_NAMESPACE . "PAGE_ID", 'add');

		// Table name (for backward compatibility)
		if (!defined(PROJECT_NAMESPACE . "TABLE_NAME"))
			define(PROJECT_NAMESPACE . "TABLE_NAME", 'lokbiayadaftar');

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
		global $EXPORT, $lokbiayadaftar;
		if ($this->CustomExport && $this->CustomExport == $this->Export && array_key_exists($this->CustomExport, $EXPORT)) {
				$content = ob_get_contents();
			if ($ExportFileName == "")
				$ExportFileName = $this->TableVar;
			$class = PROJECT_NAMESPACE . $EXPORT[$this->CustomExport];
			if (class_exists($class)) {
				$doc = new $class($lokbiayadaftar);
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
					if ($pageName == "lokbiayadaftarview.php")
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
			$key .= @$ar['Id_Biayadaftar'];
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
	public $FormClassName = "ew-horizontal ew-form ew-add-form";
	public $IsModal = FALSE;
	public $IsMobileOrModal = FALSE;
	public $DbMasterFilter = "";
	public $DbDetailFilter = "";
	public $StartRec;
	public $Priv = 0;
	public $OldRecordset;
	public $CopyRecord;

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
			if (!$Security->canAdd()) {
				$Security->saveLastUrl();
				$this->setFailureMessage(DeniedMessage()); // Set no permission
				if ($Security->canList())
					$this->terminate(GetUrl("lokbiayadaftarlist.php"));
				else
					$this->terminate(GetUrl("login.php"));
				return;
			}
		}

		// Create form object
		$CurrentForm = new HttpForm();
		$this->CurrentAction = Param("action"); // Set up current action
		$this->Id_Biayadaftar->setVisibility();
		$this->Nama_Biaya->setVisibility();
		$this->Jasa_Dokter->setVisibility();
		$this->Jasa_Layanan->setVisibility();
		$this->Jasa_Sarana->setVisibility();
		$this->Total_Biaya->setVisibility();
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
		// Check modal

		if ($this->IsModal)
			$SkipHeaderFooter = TRUE;
		$this->IsMobileOrModal = IsMobile() || $this->IsModal;
		$this->FormClassName = "ew-form ew-add-form ew-horizontal";
		$postBack = FALSE;

		// Set up current action
		if (IsApi()) {
			$this->CurrentAction = "insert"; // Add record directly
			$postBack = TRUE;
		} elseif (Post("action") !== NULL) {
			$this->CurrentAction = Post("action"); // Get form action
			$postBack = TRUE;
		} else { // Not post back

			// Load key values from QueryString
			$this->CopyRecord = TRUE;
			if (Get("Id_Biayadaftar") !== NULL) {
				$this->Id_Biayadaftar->setQueryStringValue(Get("Id_Biayadaftar"));
				$this->setKey("Id_Biayadaftar", $this->Id_Biayadaftar->CurrentValue); // Set up key
			} else {
				$this->setKey("Id_Biayadaftar", ""); // Clear key
				$this->CopyRecord = FALSE;
			}
			if ($this->CopyRecord) {
				$this->CurrentAction = "copy"; // Copy record
			} else {
				$this->CurrentAction = "show"; // Display blank record
			}
		}

		// Load old record / default values
		$loaded = $this->loadOldRecord();

		// Load form values
		if ($postBack) {
			$this->loadFormValues(); // Load form values
		}

		// Validate form if post back
		if ($postBack) {
			if (!$this->validateForm()) {
				$this->EventCancelled = TRUE; // Event cancelled
				$this->restoreFormValues(); // Restore form values
				$this->setFailureMessage($FormError);
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
				if (!$loaded) { // Record not loaded
					if ($this->getFailureMessage() == "")
						$this->setFailureMessage($Language->phrase("NoRecord")); // No record found
					$this->terminate("lokbiayadaftarlist.php"); // No matching record, return to list
				}
				break;
			case "insert": // Add new record
				$this->SendEmail = TRUE; // Send email on add success
				if ($this->addRow($this->OldRecordset)) { // Add successful
					if ($this->getSuccessMessage() == "")
						$this->setSuccessMessage($Language->phrase("AddSuccess")); // Set up success message
					$returnUrl = $this->getReturnUrl();
					if (GetPageName($returnUrl) == "lokbiayadaftarlist.php")
						$returnUrl = $this->addMasterUrl($returnUrl); // List page, return to List page with correct master key if necessary
					elseif (GetPageName($returnUrl) == "lokbiayadaftarview.php")
						$returnUrl = $this->getViewUrl(); // View page, return to View page with keyurl directly
					if (IsApi()) { // Return to caller
						$this->terminate(TRUE);
						return;
					} else {
						$this->terminate($returnUrl);
					}
				} elseif (IsApi()) { // API request, return
					$this->terminate();
					return;
				} else {
					$this->EventCancelled = TRUE; // Event cancelled
					$this->restoreFormValues(); // Add failed, restore form values
				}
		}

		// Set up Breadcrumb
		$this->setupBreadcrumb();

		// Render row based on row type
		$this->RowType = ROWTYPE_ADD; // Render add type

		// Render row
		$this->resetAttributes();
		$this->renderRow();
	}

	// Get upload files
	protected function getUploadFiles()
	{
		global $CurrentForm, $Language;
	}

	// Load default values
	protected function loadDefaultValues()
	{
		$this->Id_Biayadaftar->CurrentValue = NULL;
		$this->Id_Biayadaftar->OldValue = $this->Id_Biayadaftar->CurrentValue;
		$this->Nama_Biaya->CurrentValue = NULL;
		$this->Nama_Biaya->OldValue = $this->Nama_Biaya->CurrentValue;
		$this->Jasa_Dokter->CurrentValue = 0.00;
		$this->Jasa_Layanan->CurrentValue = 0.00;
		$this->Jasa_Sarana->CurrentValue = 0.00;
		$this->Total_Biaya->CurrentValue = NULL;
		$this->Total_Biaya->OldValue = $this->Total_Biaya->CurrentValue;
	}

	// Load form values
	protected function loadFormValues()
	{

		// Load from form
		global $CurrentForm;

		// Check field name 'Id_Biayadaftar' first before field var 'x_Id_Biayadaftar'
		$val = $CurrentForm->hasValue("Id_Biayadaftar") ? $CurrentForm->getValue("Id_Biayadaftar") : $CurrentForm->getValue("x_Id_Biayadaftar");
		if (!$this->Id_Biayadaftar->IsDetailKey) {
			if (IsApi() && $val == NULL)
				$this->Id_Biayadaftar->Visible = FALSE; // Disable update for API request
			else
				$this->Id_Biayadaftar->setFormValue($val);
		}

		// Check field name 'Nama_Biaya' first before field var 'x_Nama_Biaya'
		$val = $CurrentForm->hasValue("Nama_Biaya") ? $CurrentForm->getValue("Nama_Biaya") : $CurrentForm->getValue("x_Nama_Biaya");
		if (!$this->Nama_Biaya->IsDetailKey) {
			if (IsApi() && $val == NULL)
				$this->Nama_Biaya->Visible = FALSE; // Disable update for API request
			else
				$this->Nama_Biaya->setFormValue($val);
		}

		// Check field name 'Jasa_Dokter' first before field var 'x_Jasa_Dokter'
		$val = $CurrentForm->hasValue("Jasa_Dokter") ? $CurrentForm->getValue("Jasa_Dokter") : $CurrentForm->getValue("x_Jasa_Dokter");
		if (!$this->Jasa_Dokter->IsDetailKey) {
			if (IsApi() && $val == NULL)
				$this->Jasa_Dokter->Visible = FALSE; // Disable update for API request
			else
				$this->Jasa_Dokter->setFormValue($val);
		}

		// Check field name 'Jasa_Layanan' first before field var 'x_Jasa_Layanan'
		$val = $CurrentForm->hasValue("Jasa_Layanan") ? $CurrentForm->getValue("Jasa_Layanan") : $CurrentForm->getValue("x_Jasa_Layanan");
		if (!$this->Jasa_Layanan->IsDetailKey) {
			if (IsApi() && $val == NULL)
				$this->Jasa_Layanan->Visible = FALSE; // Disable update for API request
			else
				$this->Jasa_Layanan->setFormValue($val);
		}

		// Check field name 'Jasa_Sarana' first before field var 'x_Jasa_Sarana'
		$val = $CurrentForm->hasValue("Jasa_Sarana") ? $CurrentForm->getValue("Jasa_Sarana") : $CurrentForm->getValue("x_Jasa_Sarana");
		if (!$this->Jasa_Sarana->IsDetailKey) {
			if (IsApi() && $val == NULL)
				$this->Jasa_Sarana->Visible = FALSE; // Disable update for API request
			else
				$this->Jasa_Sarana->setFormValue($val);
		}

		// Check field name 'Total_Biaya' first before field var 'x_Total_Biaya'
		$val = $CurrentForm->hasValue("Total_Biaya") ? $CurrentForm->getValue("Total_Biaya") : $CurrentForm->getValue("x_Total_Biaya");
		if (!$this->Total_Biaya->IsDetailKey) {
			if (IsApi() && $val == NULL)
				$this->Total_Biaya->Visible = FALSE; // Disable update for API request
			else
				$this->Total_Biaya->setFormValue($val);
		}
	}

	// Restore form values
	public function restoreFormValues()
	{
		global $CurrentForm;
		$this->Id_Biayadaftar->CurrentValue = $this->Id_Biayadaftar->FormValue;
		$this->Nama_Biaya->CurrentValue = $this->Nama_Biaya->FormValue;
		$this->Jasa_Dokter->CurrentValue = $this->Jasa_Dokter->FormValue;
		$this->Jasa_Layanan->CurrentValue = $this->Jasa_Layanan->FormValue;
		$this->Jasa_Sarana->CurrentValue = $this->Jasa_Sarana->FormValue;
		$this->Total_Biaya->CurrentValue = $this->Total_Biaya->FormValue;
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
		$this->Id_Biayadaftar->setDbValue($row['Id_Biayadaftar']);
		$this->Nama_Biaya->setDbValue($row['Nama_Biaya']);
		$this->Jasa_Dokter->setDbValue($row['Jasa_Dokter']);
		$this->Jasa_Layanan->setDbValue($row['Jasa_Layanan']);
		$this->Jasa_Sarana->setDbValue($row['Jasa_Sarana']);
		$this->Total_Biaya->setDbValue($row['Total_Biaya']);
	}

	// Return a row with default values
	protected function newRow()
	{
		$this->loadDefaultValues();
		$row = [];
		$row['Id_Biayadaftar'] = $this->Id_Biayadaftar->CurrentValue;
		$row['Nama_Biaya'] = $this->Nama_Biaya->CurrentValue;
		$row['Jasa_Dokter'] = $this->Jasa_Dokter->CurrentValue;
		$row['Jasa_Layanan'] = $this->Jasa_Layanan->CurrentValue;
		$row['Jasa_Sarana'] = $this->Jasa_Sarana->CurrentValue;
		$row['Total_Biaya'] = $this->Total_Biaya->CurrentValue;
		return $row;
	}

	// Load old record
	protected function loadOldRecord()
	{

		// Load key values from Session
		$validKey = TRUE;
		if (strval($this->getKey("Id_Biayadaftar")) <> "")
			$this->Id_Biayadaftar->CurrentValue = $this->getKey("Id_Biayadaftar"); // Id_Biayadaftar
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

		if ($this->Jasa_Dokter->FormValue == $this->Jasa_Dokter->CurrentValue && is_numeric(ConvertToFloatString($this->Jasa_Dokter->CurrentValue)))
			$this->Jasa_Dokter->CurrentValue = ConvertToFloatString($this->Jasa_Dokter->CurrentValue);

		// Convert decimal values if posted back
		if ($this->Jasa_Layanan->FormValue == $this->Jasa_Layanan->CurrentValue && is_numeric(ConvertToFloatString($this->Jasa_Layanan->CurrentValue)))
			$this->Jasa_Layanan->CurrentValue = ConvertToFloatString($this->Jasa_Layanan->CurrentValue);

		// Convert decimal values if posted back
		if ($this->Jasa_Sarana->FormValue == $this->Jasa_Sarana->CurrentValue && is_numeric(ConvertToFloatString($this->Jasa_Sarana->CurrentValue)))
			$this->Jasa_Sarana->CurrentValue = ConvertToFloatString($this->Jasa_Sarana->CurrentValue);

		// Convert decimal values if posted back
		if ($this->Total_Biaya->FormValue == $this->Total_Biaya->CurrentValue && is_numeric(ConvertToFloatString($this->Total_Biaya->CurrentValue)))
			$this->Total_Biaya->CurrentValue = ConvertToFloatString($this->Total_Biaya->CurrentValue);

		// Call Row_Rendering event
		$this->Row_Rendering();

		// Common render codes for all row types
		// Id_Biayadaftar
		// Nama_Biaya
		// Jasa_Dokter
		// Jasa_Layanan
		// Jasa_Sarana
		// Total_Biaya

		if ($this->RowType == ROWTYPE_VIEW) { // View row

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
		} elseif ($this->RowType == ROWTYPE_ADD) { // Add row

			// Id_Biayadaftar
			// Nama_Biaya

			$this->Nama_Biaya->EditAttrs["class"] = "form-control";
			$this->Nama_Biaya->EditCustomAttributes = 'autocomplete="off"';
			if (REMOVE_XSS)
				$this->Nama_Biaya->CurrentValue = HtmlDecode($this->Nama_Biaya->CurrentValue);
			$this->Nama_Biaya->EditValue = HtmlEncode($this->Nama_Biaya->CurrentValue);

			// Jasa_Dokter
			$this->Jasa_Dokter->EditAttrs["class"] = "form-control";
			$this->Jasa_Dokter->EditCustomAttributes = 'autocomplete="off"';
			$this->Jasa_Dokter->EditValue = HtmlEncode($this->Jasa_Dokter->CurrentValue);
			if (strval($this->Jasa_Dokter->EditValue) <> "" && is_numeric($this->Jasa_Dokter->EditValue))
				$this->Jasa_Dokter->EditValue = FormatNumber($this->Jasa_Dokter->EditValue, -2, -1, -2, 0);

			// Jasa_Layanan
			$this->Jasa_Layanan->EditAttrs["class"] = "form-control";
			$this->Jasa_Layanan->EditCustomAttributes = 'autocomplete="off"';
			$this->Jasa_Layanan->EditValue = HtmlEncode($this->Jasa_Layanan->CurrentValue);
			if (strval($this->Jasa_Layanan->EditValue) <> "" && is_numeric($this->Jasa_Layanan->EditValue))
				$this->Jasa_Layanan->EditValue = FormatNumber($this->Jasa_Layanan->EditValue, -2, -1, -2, 0);

			// Jasa_Sarana
			$this->Jasa_Sarana->EditAttrs["class"] = "form-control";
			$this->Jasa_Sarana->EditCustomAttributes = 'autocomplete="off"';
			$this->Jasa_Sarana->EditValue = HtmlEncode($this->Jasa_Sarana->CurrentValue);
			if (strval($this->Jasa_Sarana->EditValue) <> "" && is_numeric($this->Jasa_Sarana->EditValue))
				$this->Jasa_Sarana->EditValue = FormatNumber($this->Jasa_Sarana->EditValue, -2, -1, -2, 0);

			// Total_Biaya
			$this->Total_Biaya->EditAttrs["class"] = "form-control";
			$this->Total_Biaya->EditCustomAttributes = 'autocomplete="off"';
			$this->Total_Biaya->EditValue = HtmlEncode($this->Total_Biaya->CurrentValue);
			if (strval($this->Total_Biaya->EditValue) <> "" && is_numeric($this->Total_Biaya->EditValue))
				$this->Total_Biaya->EditValue = FormatNumber($this->Total_Biaya->EditValue, -2, -1, -2, 0);

			// Add refer script
			// Id_Biayadaftar

			$this->Id_Biayadaftar->LinkCustomAttributes = "";
			$this->Id_Biayadaftar->HrefValue = "";

			// Nama_Biaya
			$this->Nama_Biaya->LinkCustomAttributes = "";
			$this->Nama_Biaya->HrefValue = "";

			// Jasa_Dokter
			$this->Jasa_Dokter->LinkCustomAttributes = "";
			$this->Jasa_Dokter->HrefValue = "";

			// Jasa_Layanan
			$this->Jasa_Layanan->LinkCustomAttributes = "";
			$this->Jasa_Layanan->HrefValue = "";

			// Jasa_Sarana
			$this->Jasa_Sarana->LinkCustomAttributes = "";
			$this->Jasa_Sarana->HrefValue = "";

			// Total_Biaya
			$this->Total_Biaya->LinkCustomAttributes = "";
			$this->Total_Biaya->HrefValue = "";
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
		if ($this->Id_Biayadaftar->Required) {
			if (!$this->Id_Biayadaftar->IsDetailKey && $this->Id_Biayadaftar->FormValue != NULL && $this->Id_Biayadaftar->FormValue == "") {
				AddMessage($FormError, str_replace("%s", $this->Id_Biayadaftar->caption(), $this->Id_Biayadaftar->RequiredErrorMessage));
			}
		}
		if ($this->Nama_Biaya->Required) {
			if (!$this->Nama_Biaya->IsDetailKey && $this->Nama_Biaya->FormValue != NULL && $this->Nama_Biaya->FormValue == "") {
				AddMessage($FormError, str_replace("%s", $this->Nama_Biaya->caption(), $this->Nama_Biaya->RequiredErrorMessage));
			}
		}
		if ($this->Jasa_Dokter->Required) {
			if (!$this->Jasa_Dokter->IsDetailKey && $this->Jasa_Dokter->FormValue != NULL && $this->Jasa_Dokter->FormValue == "") {
				AddMessage($FormError, str_replace("%s", $this->Jasa_Dokter->caption(), $this->Jasa_Dokter->RequiredErrorMessage));
			}
		}
		if (!CheckNumber($this->Jasa_Dokter->FormValue)) {
			AddMessage($FormError, $this->Jasa_Dokter->errorMessage());
		}
		if ($this->Jasa_Layanan->Required) {
			if (!$this->Jasa_Layanan->IsDetailKey && $this->Jasa_Layanan->FormValue != NULL && $this->Jasa_Layanan->FormValue == "") {
				AddMessage($FormError, str_replace("%s", $this->Jasa_Layanan->caption(), $this->Jasa_Layanan->RequiredErrorMessage));
			}
		}
		if (!CheckNumber($this->Jasa_Layanan->FormValue)) {
			AddMessage($FormError, $this->Jasa_Layanan->errorMessage());
		}
		if ($this->Jasa_Sarana->Required) {
			if (!$this->Jasa_Sarana->IsDetailKey && $this->Jasa_Sarana->FormValue != NULL && $this->Jasa_Sarana->FormValue == "") {
				AddMessage($FormError, str_replace("%s", $this->Jasa_Sarana->caption(), $this->Jasa_Sarana->RequiredErrorMessage));
			}
		}
		if (!CheckNumber($this->Jasa_Sarana->FormValue)) {
			AddMessage($FormError, $this->Jasa_Sarana->errorMessage());
		}
		if ($this->Total_Biaya->Required) {
			if (!$this->Total_Biaya->IsDetailKey && $this->Total_Biaya->FormValue != NULL && $this->Total_Biaya->FormValue == "") {
				AddMessage($FormError, str_replace("%s", $this->Total_Biaya->caption(), $this->Total_Biaya->RequiredErrorMessage));
			}
		}
		if (!CheckNumber($this->Total_Biaya->FormValue)) {
			AddMessage($FormError, $this->Total_Biaya->errorMessage());
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

	// Add record
	protected function addRow($rsold = NULL)
	{
		global $Language, $Security;
		$conn = &$this->getConnection();

		// Load db values from rsold
		$this->loadDbValues($rsold);
		if ($rsold) {
		}
		$rsnew = [];

		// Id_Biayadaftar
		$this->Id_Biayadaftar->setDbValueDef($rsnew, getGUID(), "");
		$rsnew['Id_Biayadaftar'] = &$this->Id_Biayadaftar->DbValue;

		// Nama_Biaya
		$this->Nama_Biaya->setDbValueDef($rsnew, $this->Nama_Biaya->CurrentValue, "", FALSE);

		// Jasa_Dokter
		$this->Jasa_Dokter->setDbValueDef($rsnew, $this->Jasa_Dokter->CurrentValue, 0, strval($this->Jasa_Dokter->CurrentValue) == "");

		// Jasa_Layanan
		$this->Jasa_Layanan->setDbValueDef($rsnew, $this->Jasa_Layanan->CurrentValue, 0, strval($this->Jasa_Layanan->CurrentValue) == "");

		// Jasa_Sarana
		$this->Jasa_Sarana->setDbValueDef($rsnew, $this->Jasa_Sarana->CurrentValue, 0, strval($this->Jasa_Sarana->CurrentValue) == "");

		// Total_Biaya
		$this->Total_Biaya->setDbValueDef($rsnew, $this->Total_Biaya->CurrentValue, 0, FALSE);

		// Call Row Inserting event
		$rs = ($rsold) ? $rsold->fields : NULL;
		$insertRow = $this->Row_Inserting($rs, $rsnew);

		// Check if key value entered
		if ($insertRow && $this->ValidateKey && strval($rsnew['Id_Biayadaftar']) == "") {
			$this->setFailureMessage($Language->phrase("InvalidKeyValue"));
			$insertRow = FALSE;
		}

		// Check for duplicate key
		if ($insertRow && $this->ValidateKey) {
			$filter = $this->getRecordFilter();
			$rsChk = $this->loadRs($filter);
			if ($rsChk && !$rsChk->EOF) {
				$keyErrMsg = str_replace("%f", $filter, $Language->phrase("DupKey"));
				$this->setFailureMessage($keyErrMsg);
				$rsChk->close();
				$insertRow = FALSE;
			}
		}
		if ($insertRow) {
			$conn->raiseErrorFn = $GLOBALS["ERROR_FUNC"];
			$addRow = $this->insert($rsnew);
			$conn->raiseErrorFn = '';
			if ($addRow) {
			}
		} else {
			if ($this->getSuccessMessage() <> "" || $this->getFailureMessage() <> "") {

				// Use the message, do nothing
			} elseif ($this->CancelMessage <> "") {
				$this->setFailureMessage($this->CancelMessage);
				$this->CancelMessage = "";
			} else {
				$this->setFailureMessage($Language->phrase("InsertCancelled"));
			}
			$addRow = FALSE;
		}
		if ($addRow) {

			// Call Row Inserted event
			$rs = ($rsold) ? $rsold->fields : NULL;
			$this->Row_Inserted($rs, $rsnew);
		}

		// Write JSON for API request
		if (IsApi() && $addRow) {
			$row = $this->getRecordsFromRecordset([$rsnew], TRUE);
			WriteJson(["success" => TRUE, $this->TableVar => $row]);
		}
		return $addRow;
	}

	// Set up Breadcrumb
	protected function setupBreadcrumb()
	{
		global $Breadcrumb, $Language;
		$Breadcrumb = new Breadcrumb();
		$url = substr(CurrentUrl(), strrpos(CurrentUrl(), "/")+1);
		$Breadcrumb->add("list", $this->TableVar, $this->addMasterUrl("lokbiayadaftarlist.php"), "", $this->TableVar, TRUE);
		$pageId = ($this->isCopy()) ? "Copy" : "Add";
		$Breadcrumb->add("add", $pageId, $url);
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