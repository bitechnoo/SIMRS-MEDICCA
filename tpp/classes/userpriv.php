<?php
namespace PHPMaker2019\tpp;

/**
 * Page class
 */
class userpriv extends lokuserlevels
{

	// Page ID
	public $PageID = "userpriv";

	// Project ID
	public $ProjectID = "{888F026C-2D04-4F2F-A77C-CABDD56A9360}";

	// Page object name
	public $PageObjName = "userpriv";

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

		// Table object (lokuserlevels)
		if (!isset($GLOBALS["lokuserlevels"]) || get_class($GLOBALS["lokuserlevels"]) == PROJECT_NAMESPACE . "lokuserlevels") {
			$GLOBALS["lokuserlevels"] = &$this;
			$GLOBALS["Table"] = &$GLOBALS["lokuserlevels"];
		}
		if (!isset($GLOBALS["lokuserlevels"]))
			$GLOBALS["lokuserlevels"] = &$this;

		// Page ID
		if (!defined(PROJECT_NAMESPACE . "PAGE_ID"))
			define(PROJECT_NAMESPACE . "PAGE_ID", 'userpriv');

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
	public $Disabled;
	public $TableNameCount;
	public $ReportLanguage;
	public $Privileges = [];
	public $UserLevelList = [];
	public $UserLevelPrivList = [];
	public $TableList = [];

	//
	// Page run
	//

	public function run()
	{
		global $ExportType, $CustomExportType, $ExportFileName, $UserProfile, $Language, $Security, $RequestSecurity, $CurrentForm,
			$RELATED_LANGUAGE_FOLDER, $Breadcrumb;

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
			$Security->loadCurrentUserLevel(CurrentProjectID() . 'lokuserlevels');
			if ($Security->isLoggedIn())
				$Security->TablePermission_Loaded();
			if (!$Security->canAdmin()) {
				$Security->saveLastUrl();
				$this->setFailureMessage(DeniedMessage()); // Set no permission
				if ($Security->canList())
					$this->terminate(GetUrl("lokuserlevelslist.php"));
				else
					$this->terminate(GetUrl("login.php"));
				return;
			}
		}
		$this->CurrentAction = Param("action"); // Set up current action

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
		$url = CurrentUrl();
		$url = substr($url, strrpos($url, "/") + 1);
		$Breadcrumb = new Breadcrumb();
		$Breadcrumb->add("list", "lokuserlevels", "lokuserlevelslist.php", "", "lokuserlevels");
		$Breadcrumb->add("userpriv", "UserLevelPermission", $url);
		$this->Heading = $Language->phrase("UserLevelPermission");

		// Try to load PHP Report Maker language file
		// Note: The langauge IDs must be the same in both projects

		$ar = [];
		$Security->loadUserLevelFromConfigFile($this->UserLevelList, $this->UserLevelPrivList, $ar, TRUE);
		if ($RELATED_LANGUAGE_FOLDER <> "")
			$this->ReportLanguage = new Language($RELATED_LANGUAGE_FOLDER);

		// Set up allowed table list
		foreach ($ar as $t) {
			$tempPriv = $Security->getUserLevelPrivEx($t[4] . $t[0], $Security->CurrentUserLevelID);
			if (($tempPriv & ALLOW_ADMIN) == ALLOW_ADMIN) // Allow Admin
				$this->TableList[] = array_merge($t, [$tempPriv]);
		}
		$this->TableNameCount = count($this->TableList);

		// Get action
		if (Post("action") == "") {
			$this->CurrentAction = "show"; // Display with input box

			// Load key from QueryString
			if (Get("userlevelid") !== NULL) {
				$this->userlevelid->setQueryStringValue(Get("userlevelid"));
			} else {
				$this->terminate("lokuserlevelslist.php"); // Return to list
			}
			if ($this->userlevelid->QueryStringValue == "-1") {
				$this->Disabled = " disabled";
			} else {
				$this->Disabled = "";
			}
		} else {
			$this->CurrentAction = Post("action");

			// Get fields from form
			$this->userlevelid->setFormValue(Post("x_userlevelid"));
			for ($i = 0; $i < $this->TableNameCount; $i++) {
				if (Post("table_" . $i) !== NULL) {
					if (defined(PROJECT_NAMESPACE . "USER_LEVEL_COMPAT")) {
						$this->Privileges[$i] = (int)Post("add_" . $i) +
							(int)Post("delete_" . $i) + (int)Post("edit_" . $i) +
							(int)Post("list_" . $i) + (int)Post("admin_" . $i);
					} else {
						$this->Privileges[$i] = (int)Post("add_" . $i) +
							(int)Post("delete_" . $i) + (int)Post("edit_" . $i) +
							(int)Post("list_" . $i) + (int)Post("view_" . $i) +
							(int)Post("search_" . $i) + (int)Post("admin_" . $i);
					}
				}
			}
		}

		// Should not edit own permissions
		if ($this->userlevelid->CurrentValue == $Security->CurrentUserLevelID)
			$this->terminate("lokuserlevelslist.php"); // Return to list
		switch ($this->CurrentAction) {
			case "show": // Display
				if (!$Security->setupUserLevelEx()) // Get all User Level info
					$this->terminate("lokuserlevelslist.php"); // Return to list
				$ar = [];
				for ($i = 0; $i < $this->TableNameCount; $i++) {
					$tempPriv = $Security->getUserLevelPrivEx($this->TableList[$i][4] . $this->TableList[$i][0], $this->userlevelid->CurrentValue);
					$ar[] = ["table" => ConvertToUtf8($this->getTableCaption($i)), "index" => $i, "permission" => $tempPriv, "allowed" => $this->TableList[$i][6]];
				}
				$this->Privileges["disabled"] = $this->Disabled;
				$this->Privileges["permissions"] = $ar;
				$this->Privileges["ALLOW_ADD"] = 1; // Add
				$this->Privileges["ALLOW_DELETE"] = 2; // Delete
				$this->Privileges["ALLOW_EDIT"] = 4; // Edit
				$this->Privileges["ALLOW_LIST"] = 8; // List
				$this->Privileges["USER_LEVEL_COMPAT"] = defined(PROJECT_NAMESPACE . "USER_LEVEL_COMPAT"); // USER_LEVEL_COMPAT
				if (defined(PROJECT_NAMESPACE . "USER_LEVEL_COMPAT")) {
					$this->Privileges["ALLOW_VIEW"] = 8; // View
					$this->Privileges["ALLOW_SEARCH"] = 8; // Search
				} else {
					$this->Privileges["ALLOW_VIEW"] = 32; // View
					$this->Privileges["ALLOW_SEARCH"] = 64; // Search
				}
				$this->Privileges["ALLOW_REPORT"] = 8; // Report
				$this->Privileges["ALLOW_ADMIN"] = 16; // Admin
				break;
			case "update": // Update
				if ($this->editRow()) { // Update record based on key
					if ($this->getSuccessMessage() == "")
						$this->setSuccessMessage($Language->phrase("UpdateSuccess")); // Set up update success message

					// Alternatively, comment out the following line to go back to this page
					$this->terminate("lokuserlevelslist.php"); // Return to list
				}
		}
	}

	// Update privileges
	protected function editRow()
	{
		global $Security;
		$c = &Conn(USER_LEVEL_PRIV_DBID);
		foreach ($this->Privileges as $i => $privilege) {
			$sql = "SELECT * FROM " . USER_LEVEL_PRIV_TABLE . " WHERE " .
				USER_LEVEL_PRIV_TABLE_NAME_FIELD . " = '" . AdjustSql($this->TableList[$i][4] . $this->TableList[$i][0], USER_LEVEL_PRIV_DBID) . "' AND " .
				USER_LEVEL_PRIV_USER_LEVEL_ID_FIELD . " = " . $this->userlevelid->CurrentValue;
			$privilege = $privilege & $this->TableList[$i][6]; // Set maximum allowed privilege (protect from hacking) 
			$rs = $c->execute($sql);
			if ($rs && !$rs->EOF) {
				$sql = "UPDATE " . USER_LEVEL_PRIV_TABLE . " SET " . USER_LEVEL_PRIV_PRIV_FIELD . " = " . $privilege . " WHERE " .
					USER_LEVEL_PRIV_TABLE_NAME_FIELD . " = '" . AdjustSql($this->TableList[$i][4] . $this->TableList[$i][0], USER_LEVEL_PRIV_DBID) . "' AND " .
					USER_LEVEL_PRIV_USER_LEVEL_ID_FIELD . " = " . $this->userlevelid->CurrentValue;
				$c->execute($sql);
			} else {
				$sql = "INSERT INTO " . USER_LEVEL_PRIV_TABLE . " (" . USER_LEVEL_PRIV_TABLE_NAME_FIELD . ", " . USER_LEVEL_PRIV_USER_LEVEL_ID_FIELD . ", " . USER_LEVEL_PRIV_PRIV_FIELD . ") VALUES ('" . AdjustSql($this->TableList[$i][4] . $this->TableList[$i][0], USER_LEVEL_PRIV_DBID) . "', " . $this->userlevelid->CurrentValue . ", " . $privilege . ")";
				$c->execute($sql);
			}
			if ($rs)
				$rs->close();
		}
		$Security->setupUserLevel();
		return TRUE;
	}

	// Get table caption
	protected function getTableCaption($i)
	{
		global $Language, $RELATED_PROJECT_ID;
		$caption = "";
		if ($i < $this->TableNameCount) {
			$report = ($this->TableList[$i][4] == $RELATED_PROJECT_ID);
			$other = (!$report && $this->TableList[$i][4] <> CurrentProjectID());
			if (!$report && !$other)
				$caption = $Language->TablePhrase($this->TableList[$i][1], "TblCaption");
			if ($report && is_object($this->ReportLanguage))
				$caption = $this->ReportLanguage->TablePhrase($this->TableList[$i][1], "TblCaption");
			if ($caption == "")
				$caption = $this->TableList[$i][2];
			if ($caption == "") {
				$caption = $this->TableList[$i][0];
				$caption = preg_replace('/^\{\w{8}-\w{4}-\w{4}-\w{4}-\w{12}\}/', '', $caption); // Remove project id
			}
			if ($report)
				$caption .= "<span class=\"ew-user-priv-project\"> (" . $Language->phrase("Report") . ")</span>";
			if ($other) {
				if ($this->TableList[$i][5] <> "") {
					$pathinfo = pathinfo($this->TableList[$i][5]);
					$ext = $pathinfo['extension'];
					$project = basename($this->TableList[$i][5], "." . $ext);
				} else {
					$project = $this->TableList[$i][4];
				}

				//$project = $this->TableList[$i][4]; // ** Uncomment to use project id
				$caption .= "<span class=\"ew-user-priv-project\"> (" . $project . ")</span>";
			}
		}
		return $caption;
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
	// $type = ''|'success'|'failure'
	function Message_Showing(&$msg, $type) {

		// Example:
		//if ($type == 'success') $msg = "your success message";

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