<?php

/**
 * PHPMaker Common classes and functions
 * (C) 2002-2019 e.World Technology Limited. All rights reserved.
*/
namespace PHPMaker2019\tpp;

/**
 * Get request object
 *
 * @return \Slim\Http\Request
 */
function &Request() {
	global $Request;
	if ($Request === NULL) {
		$env = new \Slim\Http\Environment($_SERVER);
		$Request = \Slim\Http\Request::createFromEnvironment($env);
	}
	return $Request;
}

/**
 * Get response object (for API only)
 *
 * @return \Slim\Http\Response
 */
function &Response() {
	global $Response;
	return $Response;
}

/**
 * Is API request
 *
 * @return boolean
 */
function IsApi() {
	global $Api;
	return is_object($Api);
}

/**
 * Autoloader
 *
 * @param string $class Class name
 * @return void
 */
function Autoloader($class) {
	global $RELATIVE_PATH, $CLASS_PATH;
	$len = strlen(PROJECT_NAMESPACE);
	if (strncmp($class, PROJECT_NAMESPACE, $len) === 0) { // Project namespace
		$file = substr($class, $len) . ".php";
	} else { // Not project namespace, e.g. "UploadHandler", "PasswordHash"
		$file = $class . ".php"; // Assume file name same as class name
	}
	$file = $CLASS_PATH . $file;
	if ($file <> "" && file_exists($RELATIVE_PATH . $file))
		include_once $RELATIVE_PATH . $file;
}

/**
 * Get request method
 *
 * @return string Request method
 */
function RequestMethod() {
	global $Request;
	return is_object($Request) ? $Request->getMethod() : ServerVar("REQUEST_METHOD");
}

/**
 * Is GET request
 *
 * @return boolean
 */
function IsGet() {
	return SameText(RequestMethod(), "GET");
}

/**
 * Is POST request
 *
 * @return boolean
 */
function IsPost() {
	return SameText(RequestMethod(), "POST");
}

/**
 * Get querystring data
 *
 * @param string $name Name of paramter
 * @param mixed $default Default value if name not found 
 * @return string
*/
function Get($name, $default = NULL) {
	global $Request;
	if (is_object($Request))
		return $Request->getQueryParam($name, $default);
	else
		return isset($_GET[$name]) ? $_GET[$name] : $default;
}

/**
 * Get post data
 *
 * @param string $name Name of paramter
 * @param mixed $default Default value if name not found 
 * @return string
*/
function Post($name, $default = NULL) {
	global $Request;
	if (is_object($Request))
		return $Request->getParsedBodyParam($name, $default);
	else
		return isset($_POST[$name]) ? $_POST[$name] : $default;
}

/**
 * Get post/querystring data
 *
 * @param string $name Name of paramter
 * @param mixed $default Default value if name not found 
 * @return string
*/
function Param($name, $default = NULL) {
	global $Request;
	if (is_object($Request))
		return $Request->getParam($name, $default);
	else
		if (isset($_POST[$name]))
			return $_POST[$name];
		elseif (isset($_GET[$name]))
			return $_GET[$name];
		else
			return $default;
}

/**
 * Get key data from Param("key")
 *
 * @param integer $i The nth (0-based) key
 * @return string|null
 */
function Key($i = 0) {
	global $COMPOSITE_KEY_SEPARATOR;
	$key = Param("key");
	if ($key !== NULL) {
		$keys = explode($COMPOSITE_KEY_SEPARATOR, $key);
		return (count($keys) > $i) ? $keys[$i] : NULL;
	}
	return NULL;
}

/**
 * Get route data
 *
 * @param integer|"key" $i The nth (0-based) route value or "key"
 * @return string|string[]|null
 */
function Route($i = NULL) {
	global $Request, $COMPOSITE_KEY_SEPARATOR;
	if (is_object($Request)) {
		$params = explode("/", strval($Request->getAttribute("route")->getArgument("params")));
		if ($i === "key") { // Get record key separated by key separator
			$params = array_slice($params, 3);
			return implode($COMPOSITE_KEY_SEPARATOR, $params);
		} elseif (is_int($i)) { // Get nth route value
			return (count($params) > $i) ? $params[$i] : NULL;
		} elseif ($i === NULL) { // Get all route values as array
			return $params;
		}
	}
	return NULL;
}

/**
 * Write data to response
 *
 * @param mixed $data Data being outputted
 * @return void
 */
function Write($data) {
	global $Response;
	if (is_object($Response))
		$Response->getBody()->write($data);
	else
		echo $data;
}

/**
 * Set HTTP response status code
 *
 * @param int $code Response status code
 * @return void
 */
function SetStatus($code) {
	global $Response;
	if (is_object($Response))
		$Response = $Response->withStatus($code);
	else
		http_response_code($code);
}

/**
 * Output JSON data (UTF-8)
 *
 * @param mixed $data Data to be encoded and outputted (non UTF-8)
 * @param integer $encodingOptions optional JSON encoding options (same as that of json_encode())
 * @return void
 */
function WriteJson($data, $encodingOptions = 0) {
	global $Response;
	$ar = IsApi() ? ["version" => PRODUCT_VERSION] : [];
	if (is_array($data))
		$data = array_merge($data, $ar);
	if (is_object($Response)) {
		$Response = $Response->withJson(ConvertToUtf8($data), NULL, $encodingOptions);
	} else {
		if (!DEBUG_ENABLED && ob_get_length())
			ob_end_clean();
		header("Content-Type: application/json; charset=utf-8");
		$json = json_encode(ConvertToUtf8($data), $encodingOptions);
		if ($json === FALSE)
			$json = json_encode(["json_encode_error" => json_last_error()], $encodingOptions);
		echo $json;
	}
}

/**
 * Add header
 *
 * @param string $name Header name
 * @param string $value Header value
 * @param boolean $replace optional Replace a previous similar header, or add a second header of the same type. Default is true.
 * @return void
 */
function AddHeader($name, $value, $replace = TRUE) {
	global $Response;
	if (is_object($Response))
		if ($replace) // Replace
			$Response = $Response->withHeader($name, $value);
		else // Append
			$Response = $Response->withAddedHeader($name, $value);
	else
		header($name . ": " . $value, $replace);
}

/**
 * Remove header
 *
 * @param string $name Header name to be removed
 * @return void
 */
function RemoveHeader($name) {
	global $Response;
	if (is_object($Response))
		$Response = $Response->withoutHeader($name);
	else
		header_remove($name);
}

/**
 * Read cookie
 *
 * @param string $name Cookie name
 * @return string
 */
function ReadCookie($name) {
	return @$_COOKIE[PROJECT_NAME][$name];
}

/**
 * Use has given consent to track cookie
 *
 * @return boolean
 */
function CanTrackCookie() {
	return ReadCookie(CONSENT_COOKIE_NAME) == "1";
}

/**
 * Create consent cookie
 *
 * @return string
 */
function CreateConsentCookie() {
	return PROJECT_NAME . '[' . CONSENT_COOKIE_NAME . ']=1';
}

/**
 * Write cookie
 *
 * @param string $name Cookie name
 * @param string $value Cookie value
 * @param boolean $expiry optional Cookie expiry time. Default is COOKIE_EXPIRY_TIME
 * @param boolean $essential optional Essential cookie, set even without user consent. Default is true
 * @return void
 */
function WriteCookie($name, $value, $expiry = COOKIE_EXPIRY_TIME, $essential = TRUE) {
	if ($essential || CanTrackCookie())
		setcookie(PROJECT_NAME . '[' . $name . ']', $value, $expiry);
}

/**
 * Get page object
 *
 * @param string $name Page name or table name
 * @return object
 */
function &Page($name = "") {
	if (!$name)
		return $GLOBALS["Page"];
	foreach ($GLOBALS as $k => $v) {
		if (is_object($v) && $k == $name)
			return $GLOBALS[$k];
	}
	$res = NULL;
	return $res;
}

/**
 * Get current language ID
 *
 * @return string
 */
function CurrentLanguageID() {
	return $GLOBALS["CurrentLanguage"];
}

// Get current project ID
function CurrentProjectID() {
	if (isset($GLOBALS["Page"]))
		return $GLOBALS["Page"]->ProjectID;
	return "{888F026C-2D04-4F2F-A77C-CABDD56A9360}";
}

/**
 * Get current export file name
 *
 * @return string
 */
function CurrentExportFile() {
	return $GLOBALS["ExportFileName"];
}

/**
 * Get current page object
 *
 * @return object
 */
function &CurrentPage() {
	return $GLOBALS["Page"];
}

/**
 * Get user table object
 *
 * @return object
 */
function &UserTable() {
	return $GLOBALS["UserTable"];
}

// Get current main table object
function &CurrentTable() {
	return $GLOBALS["Table"];
}

/**
 * Get current master table object
 *
 * @return object
 */
function &CurrentMasterTable() {
	$res = NULL;
	$tbl = &CurrentTable();
	if ($tbl && method_exists($tbl, "getCurrentMasterTable") && $tbl->getCurrentMasterTable() <> "")
		$res = $GLOBALS[$tbl->getCurrentMasterTable()];
	return $res;
}

/**
 * Get current detail table object
 *
 * @return object
 */
function &CurrentDetailTable() {
	return $GLOBALS["Grid"];
}

// Get PHP errors
function ErrorHandler($errno, $errstr, $errfile, $errline) {
	switch ($errno) {
		case E_USER_ERROR:
		case E_RECOVERABLE_ERROR:
			AddMessage($_SESSION[SESSION_FAILURE_MESSAGE], $errstr . ", file: " . $errfile . ", line: " . $errline);
			break;
		case E_WARNING:
		case E_USER_WARNING:
			AddMessage($_SESSION[SESSION_WARNING_MESSAGE], $errstr . ", file: " . $errfile . ", line: " . $errline);
			break;

		//case E_NOTICE: // Skip
		case E_USER_NOTICE:
		case E_STRICT:
		case E_DEPRECATED:
		case E_USER_DEPRECATED:
			AddMessage($_SESSION[SESSION_MESSAGE], $errstr . ", file: " . $errfile . ", line: " . $errline);
			break;
		default:
			break;
	}
	return FALSE; // Restore standard PHP error handler
}

/**
 * Export document classes
 */
// Get export document object
function &GetExportDocument(&$tbl, $style) {
	global $EXPORT;
	$inst = NULL;
	$type = strtolower($tbl->Export);
	$class = PROJECT_NAMESPACE . @$EXPORT[$type];
	if (class_exists($class))
		$inst = new $class($tbl, $style);
	return $inst;
}

/**
 * Base class for export
 */
class ExportBase
{
	public $Table;
	public $Text;
	public $Line = "";
	public $Header = "";
	public $Style = "h"; // "v"(Vertical) or "h"(Horizontal)
	public $Horizontal = TRUE; // Horizontal
	public $ExportCustom = FALSE;
	protected $RowCnt = 0;
	protected $FldCnt = 0;

	// Constructor
	public function __construct(&$tbl = NULL, $style = "")
	{
		$this->Table = $tbl;
		$this->setStyle($style);
	}

	// Style
	public function setStyle($style)
	{
		$style = strtolower($style);
		if ($style == "v" || $style == "h")
			$this->Style = $style;
		$this->Horizontal = ($this->Style <> "v");
	}

	// Field caption
	public function exportCaption(&$fld)
	{
		if (!$fld->Exportable)
			return;
		$this->FldCnt++;
		$this->exportValueEx($fld, $fld->exportCaption());
	}

	// Field value
	public function exportValue(&$fld)
	{
		$this->exportValueEx($fld, $fld->exportValue());
	}

	// Field aggregate
	public function exportAggregate(&$fld, $type)
	{
		if (!$fld->Exportable)
			return;
		$this->FldCnt++;
		if ($this->Horizontal) {
			global $Language;
			$val = "";
			if (in_array($type, ["TOTAL", "COUNT", "AVERAGE"]))
				$val = $Language->phrase($type) . ": " . $fld->exportValue();
			$this->exportValueEx($fld, $val);
		}
	}

	// Get meta tag for charset
	protected function charsetMetaTag()
	{
		return "<meta http-equiv=\"Content-Type\" content=\"text/html" . ((PROJECT_CHARSET <> "") ? "; charset=" . PROJECT_CHARSET : "") . "\">\r\n";
	}

	// Table header
	public function exportTableHeader()
	{
		$this->Text .= "<table class=\"ew-export-table\">";
	}

	// Cell styles
	protected function cellStyles($fld, $useStyle = TRUE)
	{
		return ($useStyle && EXPORT_CSS_STYLES) ? $fld->cellStyles() : "";
	}

	// Row styles
	protected function rowStyles($useStyle = TRUE)
	{
		return ($useStyle && EXPORT_CSS_STYLES) ? $this->Table->rowStyles() : "";
	}

	// Export a value (caption, field value, or aggregate)
	protected function exportValueEx(&$fld, $val, $useStyle = TRUE)
	{
		$this->Text .= "<td" . $this->cellStyles($fld, $useStyle) . ">";
		$this->Text .= strval($val);
		$this->Text .= "</td>";
	}

	// Begin a row
	public function beginExportRow($rowCnt = 0, $useStyle = TRUE)
	{
		$this->RowCnt++;
		$this->FldCnt = 0;
		if ($this->Horizontal) {
			if ($rowCnt == -1) {
				$this->Table->CssClass = "ew-export-table-footer";
			} elseif ($rowCnt == 0) {
				$this->Table->CssClass = "ew-export-table-header";
			} else {
				$this->Table->CssClass = (($rowCnt % 2) == 1) ? "ew-export-table-row" : "ew-export-table-alt-row";
			}
			$this->Text .= "<tr" . $this->rowStyles($useStyle) . ">";
		}
	}

	// End a row
	public function endExportRow($rowCnt = 0)
	{
		if ($this->Horizontal)
			$this->Text .= "</tr>";
	}

	// Empty row
	public function exportEmptyRow()
	{
		$this->RowCnt++;
		$this->Text .= "<br>";
	}

	// Page break
	public function exportPageBreak() {}

	// Export a field
	public function exportField(&$fld)
	{
		if (!$fld->Exportable)
			return;
		$this->FldCnt++;
		$wrkExportValue = "";
		if ($fld->ExportFieldImage && $fld->ExportHrefValue <> "" && is_object($fld->Upload)) { // Upload field
			if (!EmptyValue($fld->Upload->DbValue))
				$wrkExportValue = GetFileATag($fld, $fld->ExportHrefValue);
		} else {
			$wrkExportValue = $fld->exportValue();
		}
		if ($this->Horizontal) {
			$this->exportValueEx($fld, $wrkExportValue);
		} else { // Vertical, export as a row
			$this->RowCnt++;
			$this->Text .= "<tr class=\"" . (($this->FldCnt % 2 == 1) ? "ew-export-table-row" : "ew-export-table-alt-row") . "\">" .
				"<td>" . $fld->exportCaption() . "</td>";
			$this->Text .= "<td" . $this->cellStyles($fld) . ">" . $wrkExportValue . "</td></tr>";
		}
	}

	// Table Footer
	public function exportTableFooter()
	{
		$this->Text .= "</table>";
	}

	// Add HTML tags
	public function exportHeaderAndFooter()
	{
		$header = "<html><head>\r\n";
		$header .= $this->charsetMetaTag();
		if (EXPORT_CSS_STYLES && PROJECT_STYLESHEET_FILENAME <> "")
			$header .= "<style type=\"text/css\">" . file_get_contents(PROJECT_STYLESHEET_FILENAME) . "</style>\r\n";
		$header .= "</" . "head>\r\n<body>\r\n";
		$this->Text = $header . $this->Text . "</body></html>";
	}

	// Export
	public function export()
	{
		if (!DEBUG_ENABLED && ob_get_length())
			ob_end_clean();
		if (SameText(PROJECT_CHARSET, "utf-8"))
			Write("\xEF\xBB\xBF");
		AddHeader('Set-Cookie', 'fileDownload=true; path=/');
		Write($this->Text);
	}
}

// Get file IMG tag (for export to email/pdf only)
function GetFileImgTag($fld, $fn) {
	$html = "";
	if ($fn <> "") {
		if ($fld->UploadMultiple) {
			$wrkfiles = explode(MULTIPLE_UPLOAD_SEPARATOR, $fn);
			foreach ($wrkfiles as $wrkfile) {
				if ($wrkfile <> "") {
					if ($html <> "")
						$html .= "<br>";
					$html .= "<img class=\"ew-image\" src=\"" . $wrkfile . "\" alt=\"\">";
				}
			}
		} else {
			$html = "<img class=\"ew-image\" src=\"" . $fn . "\" alt=\"\">";
		}
	}
	return $html;
}

// Get file A tag
function GetFileATag($fld, $fn) {
	$wrkfiles = [];
	$wrkpath = "";
	$html = "";
	if ($fld->DataType == DATATYPE_BLOB) {
		if (!EmptyValue($fld->Upload->DbValue))
			$wrkfiles = [$fn];
	} elseif ($fld->UploadMultiple) {
		$wrkfiles = explode(MULTIPLE_UPLOAD_SEPARATOR, $fn);
		$pos = strrpos($wrkfiles[0], '/');
		if ($pos !== FALSE) {
			$wrkpath = substr($wrkfiles[0], 0, $pos + 1); // Get path from first file name
			$wrkfiles[0] = substr($wrkfiles[0], $pos + 1);
		}
	} else {
		if (!EmptyValue($fld->Upload->DbValue))
			$wrkfiles = [$fn];
	}
	foreach ($wrkfiles as $wrkfile) {
		if ($wrkfile <> "") {
			if ($html <> "")
				$html .= "<br>";
			$attrs = ["href" => FullUrl($wrkpath . $wrkfile, "href")];
			$html .= HtmlElement("a", $attrs, $fld->caption());
		}
	}
	return $html;
}

// Get file temp image
function GetFileTempImage($fld, $val) {
	if ($fld->DataType == DATATYPE_BLOB) {
		if (!EmptyValue($fld->Upload->DbValue)) {
			$tmpimage = $fld->Upload->DbValue;
			if ($fld->ImageResize)
				ResizeBinary($tmpimage, $fld->ImageWidth, $fld->ImageHeight);
			return TempImage($tmpimage);
		}
		return "";
	} elseif ($fld->UploadMultiple) {
		$files = explode(MULTIPLE_UPLOAD_SEPARATOR, $val);
		$cnt = count($files);
		$images = "";
		for ($i = 0; $i < $cnt; $i++) {
			if ($files[$i] <> "") {
				$tmpimage = file_get_contents($fld->physicalUploadPath() . $files[$i]);
				if ($fld->ImageResize)
					ResizeBinary($tmpimage, $fld->ImageWidth, $fld->ImageHeight);
				if ($images <> "") $images .= MULTIPLE_UPLOAD_SEPARATOR;
				$images .= TempImage($tmpimage);
			}
		}
		return $images;
	} else {
		$tmpimage = file_get_contents($fld->physicalUploadPath() . $val);
		if ($fld->ImageResize)
			ResizeBinary($tmpimage, $fld->ImageWidth, $fld->ImageHeight);
		return TempImage($tmpimage);
	}
}

// Get file upload URL
function GetFileUploadUrl($fld, $val, $resize = FALSE) {
	global $CurrentToken;
	if (!EmptyString($val)) {
		$sessionId = session_id();
		$fileUrl = API_URL . "?" . API_ACTION_NAME . "=" . API_FILE_ACTION . "&session=" . $sessionId . "&token=" . $CurrentToken;
		if ($fld->DataType == DATATYPE_BLOB) {
			$fn = $fileUrl;
			$tableVar = !EmptyString($fld->SourceTableVar) ? $fld->SourceTableVar : $fld->TableVar;
			$fn .= "&" . API_OBJECT_NAME . "=" . rawurlencode($tableVar); 
			$fn .= "&" . API_FIELD_NAME . "=" . rawurlencode($fld->Param);
			$fn .= "&" . API_KEY_NAME . "=" . rawurlencode($val);
			if ($resize)
				$fn .= "&resize=1&width=" . $fld->ImageWidth . "&height=" . $fld->ImageHeight;
		} else {
			$encrypt = ENCRYPT_FILE_PATH;
			$path = ($encrypt || $resize) ? $fld->physicalUploadPath() : $fld->hrefPath();
			$key = RANDOM_KEY . $sessionId;
			if ($encrypt) {
				$fn = $fileUrl . "&fn=" . Encrypt($path . $val, $key);
				if ($resize)
					$fn .= "&width=" . $fld->ImageWidth . "&height=" . $fld->ImageHeight;
			} elseif ($resize) {
				$fn = $fileUrl . "&fn=" . Encrypt($path . $val, $key) .
					"&width=" . $fld->ImageWidth . "&height=" . $fld->ImageHeight; // Encrypt the physical path
			} else {
				$fn = IsRemote($path) ? $path : UrlEncodeFilePath($path);
				$fn .= UrlEncodeFilePath($val);
			}
		}
		return $fn;
	}
	return "";
}

// URL encode file path
function UrlEncodeFilePath($path) {
	$ar = explode("/", $path);
	$scheme = parse_url($path, PHP_URL_SCHEME);
	foreach ($ar as &$c) {
		if ($c <> $scheme . ":")
			$c = rawurlencode($c);
	}
	return implode("/", $ar);
}

// Get file view tag
function GetFileViewTag(&$fld, $val) {
	global $Page;
	if (!EmptyString($val)) {
		if ($fld->DataType == DATATYPE_BLOB) {
			$wrknames = [$val];
			$wrkfiles = [$val];
		} elseif ($fld->UploadMultiple) {
			$wrknames = explode(MULTIPLE_UPLOAD_SEPARATOR, $val);
			$wrkfiles = explode(MULTIPLE_UPLOAD_SEPARATOR, $fld->Upload->DbValue);
		} else {
			$wrknames = [$val];
			$wrkfiles = [$fld->Upload->DbValue];
		}
		$multiple = (count($wrkfiles) > 1);
		$href = $fld->HrefValue;
		$images = "";
		$wrkcnt = 0;
		foreach ($wrkfiles as $wrkfile) {
			$image = "";
			if ($Page && ($Page->TableType == "REPORT" &&
				($Page->isExport("excel") && defined(PROJECT_NAMESPACE . 'USE_PHPEXCEL') ||
				$Page->isExport("word") && defined(PROJECT_NAMESPACE . 'USE_PHPWORD')) ||
				$Page->TableType <> "REPORT" && ($Page->CustomExport == "pdf" || $Page->CustomExport == "email")))
				$fn = GetFileTempImage($fld, $wrkfile);
			else
				$fn = GetFileUploadUrl($fld, $wrkfile, $fld->ImageResize);
			if ($fld->ViewTag == "IMAGE" && ($fld->IsBlobImage || IsImageFile($wrkfile))) { // Image
				if ($href == "" && !$fld->UseColorbox) {
					if ($fn <> "") {
						if (IsLazy())
							$image = "<img class=\"ew-image ew-lazy img-thumbnail\" alt=\"\" src=\"data:image/png;base64,R0lGODlhAQABAAD/ACwAAAAAAQABAAACADs=\" data-src=\"" . $fn . "\"" . $fld->viewAttributes() . ">";
						else
							$image = "<img class=\"ew-image img-thumbnail\" alt=\"\" src=\"" . $fn . "\"" . $fld->viewAttributes() . ">";
					}
				} else {
					if ($fld->UploadMultiple && ContainsString($href, "%u"))
						$fld->HrefValue = str_replace("%u", GetFileUploadUrl($fld, $wrkfile), $href);
					if ($fn <> "") {
						if (IsLazy())
							$image = "<a" . $fld->linkAttributes() . "><img class=\"ew-image ew-lazy img-thumbnail\" alt=\"\" src=\"data:image/png;base64,R0lGODlhAQABAAD/ACwAAAAAAQABAAACADs=\" data-src=\"" . $fn . "\"" . $fld->viewAttributes() . "></a>";
						else
							$image = "<a" . $fld->linkAttributes() . "><img class=\"ew-image img-thumbnail\" alt=\"\" src=\"" . $fn . "\"" . $fld->viewAttributes() . "></a>";
					}
				}
			} else {
				if ($fld->DataType == DATATYPE_BLOB) {
					$url = $href;
					$name = ($fld->Upload->FileName <> "") ? $fld->Upload->FileName : $fld->caption();
				} else {
					$url = GetFileUploadUrl($fld, $wrkfile);
					$cnt = count($wrknames);
					$name = ($wrkcnt < $cnt) ? $wrknames[$wrkcnt] : $wrknames[$cnt - 1];
				}
				if ($url <> "") {
					$className = @$fld->LinkAttrs["class"]; // Backup class
					RemoveClass($fld->LinkAttrs["class"], "ew-lightbox"); // Remove colorbox class
					if ($fld->UploadMultiple && ContainsString($href, "%u"))
						$fld->HrefValue = str_replace("%u", $url, $href);
					$image = "<a" . $fld->linkAttributes() . ">" . $name . "</a>";
					if (!EmptyString($className)) // Restore class
						$fld->LinkAttrs["class"] = $className;
				}
			}
			if ($image <> "") {
				if ($multiple)
					$images .= "<li class=\"list-inline-item\">" . $image . "</li>";
				else
					$images .= $image;
			}
			$wrkcnt += 1;
		}
		if ($multiple && $images <> "")
			$images = "<ul class=\"list-inline\">" . $images . "</ul>";
		return $images;
	}
	return "";
}

// Get image view tag
function GetImageViewTag(&$fld, $val) {
	if (!EmptyString($val)) {
		$href = $fld->HrefValue;
		$image = $val;
		if ($val && !ContainsString($val, "://") && !ContainsString($val, "\\") && !ContainsText($val, "javascript:"))
			$fn = GetImageUrl($fld, $val, $fld->ImageResize);
		else
			$fn = $val;
		if (IsImageFile($val)) { // Image
			if ($href == "" && !$fld->UseColorbox) {
				if ($fn <> "") {
					if (IsLazy())
						$image = "<img class=\"ew-image ew-lazy img-thumbnail\" alt=\"\" src=\"data:image/png;base64,R0lGODlhAQABAAD/ACwAAAAAAQABAAACADs=\" data-src=\"" . $fn . "\"" . $fld->viewAttributes() . ">";
					else
						$image = "<img class=\"ew-image img-thumbnail\" alt=\"\" src=\"" . $fn . "\"" . $fld->viewAttributes() . ">";
				}
			} else {
				if ($fn <> "") {
					if (IsLazy())
						$image = "<a" . $fld->linkAttributes() . "><img class=\"ew-image ew-lazy img-thumbnail\" alt=\"\" src=\"data:image/png;base64,R0lGODlhAQABAAD/ACwAAAAAAQABAAACADs=\" data-src=\"" . $fn . "\"" . $fld->viewAttributes() . "></a>";
					else
						$image = "<a" . $fld->linkAttributes() . "><img class=\"ew-image img-thumbnail\" alt=\"\" src=\"" . $fn . "\"" . $fld->viewAttributes() . "></a>";
				}
			}
		} else {
			$name = $val;
			if ($href <> "")
				$image = "<a" . $fld->linkAttributes() . ">" . $name . "</a>";
			else
				$image = $name;
		}
		return $image;
	}
	return "";
}

// Get image URL
function GetImageUrl($fld, $val, $resize = FALSE, $encrypt = ENCRYPT_FILE_PATH, $urlencode = TRUE) {
	global $CurrentToken;
	if (!EmptyString($val)) {
		$sessionId = session_id();
		$fileUrl = API_URL . "?" . API_ACTION_NAME . "=" . API_FILE_ACTION . "&session=" . $sessionId . "&token=" . $CurrentToken;
		if ($encrypt) {
			$key = RANDOM_KEY . $sessionId;
			$fn = $fileUrl . "&fn=" . Encrypt($val, $key);
			if ($resize)
				$fn .= "&width=" . $fld->ImageWidth . "&height=" . $fld->ImageHeight;
		} elseif ($resize) {
			$fn = $fileUrl . "&fn=" . UrlEncodeFilePath($val) .
				"&width=" . $fld->ImageWidth . "&height=" . $fld->ImageHeight;
		} else {
			$fn = $val;
			if ($urlencode)
				$fn = UrlEncodeFilePath($fn);
		}
		return $fn;
	}
	return "";
}

// Check if image file
function IsImageFile($fn) {
	if ($fn <> "") {
		$ar = parse_url($fn);
		if ($ar && array_key_exists("query", $ar)) { // Thumbnail URL
 			if ($q = parse_str($ar["query"]))
				$fn = $q["fn"];
		}
		$pathinfo = pathinfo($fn);
		$ext = strtolower(@$pathinfo["extension"]);
		return in_array($ext, explode(",", IMAGE_ALLOWED_FILE_EXT));
	}
	return FALSE;
}

// Check if lazy loading images
function IsLazy() {
	global $LAZY_LOAD, $ExportType, $CustomExportType;
	return $LAZY_LOAD && ($ExportType == "" || $ExportType == "print" && ($CustomExportType == "" || $CustomExportType == "print"));
}

/**
 * Export to email
 */
class ExportEmail extends ExportBase
{

	// Table border styles
	protected $cellStyles = "border: 1px solid #dddddd; padding: 5px;";

	// Table header
	public function exportTableHeader()
	{
		$this->Text .= "<table style=\"border-collapse: collapse;\">"; // Use inline style for Gmail
	}

	// Cell styles
	protected function cellStyles($fld, $useStyle = TRUE)
	{
		$fld->cellAttrs["style"] = Concat($this->cellStyles, @$fld->cellAttrs["style"], ";"); // Use inline style for Gmail
		return ($useStyle && EXPORT_CSS_STYLES) ? $fld->cellStyles() : "";
	}

	// Export a field
	public function exportField(&$fld)
	{
		if (!$fld->Exportable)
			return;
		$this->FldCnt++;
		$exportValue = $fld->exportValue();
		if ($fld->ExportFieldImage && $fld->ViewTag == "IMAGE") {
			if ($fld->ImageResize) {
				$exportValue = GetFileImgTag($fld, $fld->getTempImage());
			} elseif ($fld->ExportHrefValue <> "" && is_object($fld->Upload)) {
				if (!EmptyValue($fld->Upload->DbValue))
					$exportValue = GetFileATag($fld, $fld->ExportHrefValue);
			}
		} elseif ($fld->ExportFieldImage && $fld->ExportHrefValue <> "") { // Export custom view tag
			$exportValue = $fld->ExportHrefValue;
		}
		if ($this->Horizontal) {
			$this->exportValueEx($fld, $exportValue);
		} else { // Vertical, export as a row
			$this->RowCnt++;
			$this->Text .= "<tr class=\"" . (($this->FldCnt % 2 == 1) ? "ew-export-table-row" : "ew-export-table-alt-row") . "\">" .
				"<td>" . $fld->exportCaption() . "</td>";
			$this->Text .= "<td" . $this->cellStyles($fld) . ">" . $exportValue . "</td></tr>";
		}
	}

	// Export
	public function export()
	{
		if (!DEBUG_ENABLED && ob_get_length())
			ob_end_clean();
		echo $this->Text;
	}

	// Destructor
	public function __destruct()
	{
		DeleteTempImages();
	}
}

/**
 * Export to HTML
 */
class ExportHtml extends ExportBase
{

	// Export
	public function export()
	{
		global $ExportFileName;
		if (!DEBUG_ENABLED && ob_get_length())
			ob_end_clean();
		AddHeader('Set-Cookie', 'fileDownload=true; path=/');
		AddHeader('Content-Type', 'text/html' . ((PROJECT_CHARSET <> '') ? '; charset=' . PROJECT_CHARSET : ''));
		AddHeader('Content-Disposition', 'attachment; filename=' . $ExportFileName . '.html');
		Write($this->Text);
	}
}

/**
 * Export to Word
 */
class ExportWord extends ExportBase
{

	// Export
	public function export()
	{
		global $ExportFileName;
		if (!DEBUG_ENABLED && ob_get_length())
			ob_end_clean();
		AddHeader('Set-Cookie', 'fileDownload=true; path=/');
		AddHeader('Content-Type', 'application/msword' . ((PROJECT_CHARSET <> '') ? '; charset=' . PROJECT_CHARSET : ''));
		AddHeader('Content-Disposition', 'attachment; filename=' . $ExportFileName . '.doc');
		if (SameText(PROJECT_CHARSET, "utf-8"))
			Write("\xEF\xBB\xBF");
		Write($this->Text);
	}
}

/**
 * Export to Excel
 */
class ExportExcel extends ExportBase
{

	// Export a value (caption, field value, or aggregate)
	protected function exportValueEx(&$fld, $val, $useStyle = TRUE)
	{
		if (($fld->DataType == DATATYPE_STRING || $fld->DataType == DATATYPE_MEMO) && is_numeric($val))
			$val = "=\"" . strval($val) . "\"";
		$this->Text .= parent::exportValueEx($fld, $val, $useStyle);
	}

	// Export
	public function export()
	{
		global $ExportFileName;
		if (!DEBUG_ENABLED && ob_get_length())
			ob_end_clean();
		AddHeader('Set-Cookie', 'fileDownload=true; path=/');
		AddHeader('Content-Type', 'application/vnd.ms-excel' . ((PROJECT_CHARSET <> "") ? '; charset=' . PROJECT_CHARSET : ''));
		AddHeader('Content-Disposition', 'attachment; filename=' . $ExportFileName . '.xls');
		if (SameText(PROJECT_CHARSET, "utf-8"))
			Write("\xEF\xBB\xBF");
		Write($this->Text);
	}
}

/**
 * Export to CSV
 */
class ExportCsv extends ExportBase
{
	public $QuoteChar = "\"";
	public $Separator = ",";

	// Style
	public function changeStyle($style)
	{
		$this->Horizontal = TRUE;
	}

	// Table header
	public function exportTableHeader() {}

	// Export a value (caption, field value, or aggregate)
	protected function exportValueEx(&$fld, $val, $useStyle = TRUE)
	{
		if ($fld->DataType <> DATATYPE_BLOB) {
			if ($this->Line <> "")
				$this->Line .= $this->Separator;
			$this->Line .= $this->QuoteChar . str_replace($this->QuoteChar, $this->QuoteChar . $this->QuoteChar, strval($val)) . $this->QuoteChar;
		}
	}

	// Begin a row
	public function beginExportRow($rowCnt = 0, $useStyle = TRUE)
	{
		$this->Line = "";
	}

	// End a row
	public function endExportRow($rowCnt = 0)
	{
		$this->Line .= "\r\n";
		$this->Text .= $this->Line;
	}

	// Empty line
	function exportEmptyLine() {}

	// Export a field
	public function exportField(&$fld)
	{
		if (!$fld->Exportable)
			return;
		if ($fld->UploadMultiple)
			$this->exportValueEx($fld, $fld->Upload->DbValue);
		else
			$this->exportValue($fld);
	}

	// Table Footer
	public function exportTableFooter() {}

	// Add HTML tags
	public function exportHeaderAndFooter() {}

	// Export
	public function export()
	{
		global $ExportFileName;
		if (!DEBUG_ENABLED && ob_get_length())
			ob_end_clean();
		AddHeader('Set-Cookie', 'fileDownload=true; path=/');
		AddHeader('Content-Type', 'text/csv' . ((PROJECT_CHARSET <> "") ? '; charset=' . PROJECT_CHARSET : ''));
		AddHeader('Content-Disposition', 'attachment; filename=' . $ExportFileName . '.csv');
		if (SameText(PROJECT_CHARSET, "utf-8"))
			Write("\xEF\xBB\xBF");
		Write($this->Text);
	}
}

/**
 * Export to XML
 */
class ExportXml extends ExportBase
{
	public $XmlDoc;
	public $HasParent;

	// Constructor
	public function __construct(&$tbl = NULL, $style = "")
	{
		parent::__construct($tbl, $style);
		$this->XmlDoc = new XmlDocument(XML_ENCODING);
	}

	// Style
	public function setStyle($style) {}

	// Field caption
	public function exportCaption(&$fld) {}

	// Field value
	public function exportValue(&$fld) {}

	// Field aggregate
	public function exportAggregate(&$fld, $type) {}

	// Get meta tag for charset
	protected function charsetMetaTag() {}

	// Table header
	public function exportTableHeader()
	{
		$this->HasParent = is_object($this->XmlDoc->documentElement());
		if (!$this->HasParent)
			$this->XmlDoc->addRoot($this->Table->TableVar);
	}

	// Export a value (caption, field value, or aggregate)
	protected function exportValueEx(&$fld, $val, $useStyle = TRUE) {}

	// Begin a row
	public function beginExportRow($rowCnt = 0, $useStyle = TRUE)
	{
		if ($rowCnt <= 0)
			return;
		if ($this->HasParent)
			$this->XmlDoc->addRow($this->Table->TableVar);
		else
			$this->XmlDoc->addRow();
	}

	// End a row
	public function endExportRow($rowCnt = 0) {}

	// Empty row
	public function exportEmptyRow() {}

	// Page break
	public function exportPageBreak() {}

	// Export a field
	public function exportField(&$fld)
	{
		if ($fld->Exportable && $fld->DataType <> DATATYPE_BLOB) {
			if ($fld->UploadMultiple)
				$exportValue = $fld->Upload->DbValue;
			else
				$exportValue = $fld->exportValue();
			if ($exportValue === NULL)
				$exportValue = "<Null>";
			$this->XmlDoc->addField($fld->Param, $exportValue);
		}
	}

	// Table Footer
	public function exportTableFooter() {}

	// Add HTML tags
	public function exportHeaderAndFooter() {}

	// Export
	public function export()
	{

		//global $ExportFileName;
		if (!DEBUG_ENABLED && ob_get_length())
			ob_end_clean();

		//AddHeader('Set-Cookie', 'fileDownload=true; path=/');
		AddHeader('Content-Type', 'text/xml');

		//AddHeader('Content-Disposition', 'attachment; filename=' . $ExportFileName . '.xml');
		Write($this->XmlDoc->xml());
	}
}

/**
 * Export to JSON
 */
class ExportJson extends ExportBase
{
	protected $Items;
	protected $Item;
	public $HasParent;

	// Style
	public function setStyle($style) {}

	// Field caption
	public function exportCaption(&$fld) {}

	// Field value
	public function exportValue(&$fld) {}

	// Field aggregate
	public function exportAggregate(&$fld, $type) {}

	// Get meta tag for charset
	protected function charsetMetaTag() {}

	// Table header
	public function exportTableHeader()
	{
		$this->HasParent = isset($this->Items);
		if ($this->HasParent) {
			if (is_array($this->Items))
				$this->Items[$this->Table->TableName] = [];
			elseif (is_object($this->Items))
				$this->Items->{$this->Table->TableName} = [];
		}
	}

	// Export a value (caption, field value, or aggregate)
	protected function exportValueEx(&$fld, $val, $useStyle = TRUE) {}

	// Begin a row
	public function beginExportRow($rowCnt = 0, $useStyle = TRUE)
	{
		if ($rowCnt <= 0)
			return;
		$this->Item = new \stdClass();
	}

	// End a row
	public function endExportRow($rowCnt = 0)
	{
		if ($rowCnt <= 0)
			return;
		if ($this->HasParent) {
			if (is_array($this->Items))
				$this->Items[$this->Table->TableName][] = $this->Item;
			elseif (is_object($this->Items))
				$this->Items->{$this->Table->TableName}[] = $this->Item;
		} else {
			if (is_array($this->Items))
				$this->Items[] = $this->Item;
			elseif (is_object($this->Items))
				$this->Items = [$this->Items, $this->Item]; // Convert to array
			else
				$this->Items = $this->Item;
		}
	}

	// Empty row
	public function exportEmptyRow() {}

	// Page break
	public function exportPageBreak() {}

	// Export a field
	public function exportField(&$fld)
	{
		if ($fld->Exportable && $fld->DataType <> DATATYPE_BLOB) {
			if ($fld->UploadMultiple)
				$this->Item->{$fld->Name} = $fld->Upload->DbValue;
			else
				$this->Item->{$fld->Name} = $fld->exportValue();
		}
	}

	// Table Footer
	public function exportTableFooter() {}

	// Add HTML tags
	public function exportHeaderAndFooter() {}

	// Export
	public function export()
	{

		//global $ExportFileName;
		if (!DEBUG_ENABLED && ob_get_length())
			ob_end_clean();

		//AddHeader('Set-Cookie', 'fileDownload=true; path=/');
		//AddHeader('Content-Disposition', 'attachment; filename=' . $ExportFileName . '.json');

		WriteJson($this->Items, (DEBUG_ENABLED) ? JSON_PRETTY_PRINT : 0);
	}
}

/**
 * Class for export to PDF
 */
class ExportPdf extends ExportBase
{

	// Table header
	public function exportTableHeader()
	{
		$this->Text .= "<table class=\"ew-table\">\r\n";
	}

	// Export a value (caption, field value, or aggregate)
	protected function exportValueEx(&$fld, $val, $useStyle = TRUE)
	{
		$wrkVal = strval($val);
		$wrkVal = "<td" . (($useStyle && EXPORT_CSS_STYLES) ? $fld->cellStyles() : "") . ">" . $wrkVal . "</td>\r\n";
		$this->Line .= $wrkVal;
		$this->Text .= $wrkVal;
	}

	// Begin a row
	public function beginExportRow($rowCnt = 0, $useStyle = TRUE)
	{
		$this->FldCnt = 0;
		if ($this->Horizontal) {
			if ($rowCnt == -1)
				$this->Table->CssClass = "ew-table-footer";
			elseif ($rowCnt == 0)
				$this->Table->CssClass = "ew-table-header";
			else
				$this->Table->CssClass = (($rowCnt % 2) == 1) ? "ew-table-row" : "ew-table-alt-row";
			$this->Line = "<tr" . (($useStyle && EXPORT_CSS_STYLES) ? $this->Table->rowStyles() : "") . ">";
			$this->Text .= $this->Line;
		}
	}

	// End a row
	public function endExportRow($rowCnt = 0)
	{
		if ($this->Horizontal) {
			$this->Line .= "</tr>";
			$this->Text .= "</tr>";
			$this->Header = $this->Line;
		}
	}

	// Page break
	public function exportPageBreak()
	{
		if ($this->Horizontal) {
			$this->Text .= "</table>\r\n"; // End current table
			$this->Text .= "<p style=\"page-break-after:always;\">&nbsp;</p>\r\n"; // Page break
			$this->Text .= "<table class=\"ew-table ew-table-border\">\r\n"; // New page header
			$this->Text .= $this->Header;
		}
	}

	// Export a field
	public function exportField(&$fld)
	{
		if (!$fld->Exportable)
			return;
		$exportValue = $fld->exportValue();
		if ($fld->ExportFieldImage && $fld->ViewTag == "IMAGE") {
			$exportValue = GetFileImgTag($fld, $fld->getTempImage());
		} elseif ($fld->ExportFieldImage && $fld->ExportHrefValue <> "") { // Export custom view tag
			$exportValue = $fld->ExportHrefValue;
		} else {
			$exportValue = str_replace("<br>", "\r\n", $exportValue);
			$exportValue = strip_tags($exportValue);
			$exportValue = str_replace("\r\n", "<br>", $exportValue);
		}
		if ($this->Horizontal) {
			$this->exportValueEx($fld, $exportValue);
		} else { // Vertical, export as a row
			$this->FldCnt++;
			$fld->CellCssClass = ($this->FldCnt % 2 == 1) ? "ew-table-row" : "ew-table-alt-row";
			$this->Text .= "<tr><td" . ((EXPORT_CSS_STYLES) ? $fld->cellStyles() : "") . ">" . $fld->exportCaption() . "</td>";
			$this->Text .= "<td" . ((EXPORT_CSS_STYLES) ? $fld->cellStyles() : "") . ">" .
				$exportValue . "</td></tr>";
		}
	}

	// Add HTML tags
	public function exportHeaderAndFooter()
	{
		$header = "<html><head>\r\n";
		$header .= $this->charsetMetaTag();
		if (PDF_STYLESHEET_FILENAME <> "")
			$header .= "<style type=\"text/css\">" . file_get_contents(PDF_STYLESHEET_FILENAME) . "</style>\r\n";
		$header .= "</" . "head>\r\n<body>\r\n";
		$this->Text = $header . $this->Text . "</body></html>";
	}

	// Export
	public function export()
	{
		global $ExportFileName;
		@ini_set("memory_limit", PDF_MEMORY_LIMIT);
		set_time_limit(PDF_TIME_LIMIT);
		$txt = $this->Text;
		if (DEBUG_ENABLED) // Add debug message
			$txt = str_replace("</body>", GetDebugMessage() . "</body>", $txt);
		$dompdf = new \Dompdf\Dompdf(array("pdf_backend" => "Cpdf"));
		$dompdf->load_html($txt);
		$dompdf->set_paper($this->Table->ExportPageSize, $this->Table->ExportPageOrientation);
		$dompdf->render();
		if (!DEBUG_ENABLED && ob_get_length())
			ob_end_clean();
		AddHeader('Set-Cookie', 'fileDownload=true; path=/');
		$dompdf->stream($ExportFileName, array("Attachment" => 1)); // 0 to open in browser, 1 to download
		DeleteTempImages();
	}

	// Destructor
	public function __destruct()
	{
		DeleteTempImages();
	}
}

/**
 * Email class
 */
class Email
{
	public $Sender = ""; // Sender
	public $Recipient = ""; // Recipient
	public $Cc = ""; // Cc
	public $Bcc = ""; // Bcc
	public $Subject = ""; // Subject
	public $Format = ""; // Format
	public $Content = ""; // Content
	public $Attachments = []; // Attachments
	public $EmbeddedImages = []; // Embedded image
	public $Charset = EMAIL_CHARSET; // Charset
	public $SendErrDescription; // Send error description
	public $SmtpSecure = SMTP_SECURE_OPTION; // Send secure option
	protected $Prop = []; // PHPMailer properties

	// Set PHPMailer property
	public function __set($name, $value)
	{
		$this->Prop[$name] = $value;
	}

	// Load email from template
	public function load($fn, $langId = "")
	{
		global $CurrentLanguage, $EMAIL_TEMPLATE_PATH;
		$langId = ($langId == "") ? $CurrentLanguage : $langId;
		$pos = strrpos($fn, '.');
		if ($pos !== FALSE) {
			$wrkname = substr($fn, 0, $pos); // Get file name
			$wrkext = substr($fn, $pos + 1); // Get file extension
			$wrkpath = PathCombine(ScriptFolder(), $EMAIL_TEMPLATE_PATH, TRUE); // Get file path
			$ar = ($langId <> "") ? ["_" . $langId, "-" . $langId, ""] : [""];
			$exist = FALSE;
			foreach ($ar as $suffix) {
				$wrkfile = $wrkpath . $wrkname . $suffix . "." . $wrkext;
				$exist = file_exists($wrkfile);
				if ($exist)
					break;
			}
			if (!$exist)
				return;
			$wrk = file_get_contents($wrkfile); // Load template file content
			if (StartsString("\xEF\xBB\xBF", $wrk)) // UTF-8 BOM
				$wrk = substr($wrk, 3);
			$wrkid = $wrkname . "_content";
			if (ContainsString($wrk, $wrkid)) { // Replace content
				$wrkfile = $wrkpath . $wrkid . "." . $wrkext;
				if (file_exists($wrkfile)) {
					$content = file_get_contents($wrkfile);
					if (StartsString("\xEF\xBB\xBF", $content)) // UTF-8 BOM
						$content = substr($content, 3);
					$wrk = str_replace("<!--" . $wrkid . "-->", $content, $wrk);
				}
			}
		}
		if ($wrk <> "" && preg_match('/\n\n|\r\n\r\n/', $wrk, $m, PREG_OFFSET_CAPTURE)) { // Locate Header & Mail Content
			$i = $m[0][1];
			$header = trim(substr($wrk, 0, $i)) . "\r\n"; // Add last CrLf for matching
			$this->Content = trim(substr($wrk, $i));
			if (preg_match_all('/^\s*(Subject|From|To|Cc|Bcc|Format)\s*:([^\r\n]*)[\r\n]/m', $header, $m)) {
				$ar = array_combine($m[1], $m[2]);
				$this->Subject = trim(@$ar["Subject"]);
				$this->Sender = trim(@$ar["From"]);
				$this->Recipient = trim(@$ar["To"]);
				$this->Cc = trim(@$ar["Cc"]);
				$this->Bcc = trim(@$ar["Bcc"]);
				$this->Format = trim(@$ar["Format"]);
			}
		}
	}

	// Replace sender
	public function replaceSender($sender, $senderName = '')
	{
		if ($senderName <> '')
			$sender = $senderName . ' <' . $sender . '>';
		if (ContainsString($this->Sender, '<!--$From-->'))
			$this->Sender = str_replace('<!--$From-->', $sender, $this->Sender);
		else
			$this->Sender = $sender;
	}

	// Replace recipient
	public function replaceRecipient($recipient, $recipientName = '')
	{
		if ($recipientName <> '')
			$recipient = $recipientName . ' <' . $recipient . '>';
		if (ContainsString($this->Recipient, '<!--$To-->'))
			$this->Recipient = str_replace('<!--$To-->', $recipient, $this->Recipient);
		else
			$this->addRecipient($recipient);
	}

	// Add recipient
	public function addRecipient($recipient, $recipientName = '')
	{
		if ($recipientName <> '')
			$recipient = $recipientName . ' <' . $recipient . '>';
		$this->Recipient = Concat($this->Recipient, $recipient, ";");
	}

	// Add cc email
	public function addCc($cc, $ccName = '')
	{
		if ($ccName <> '')
			$cc = $ccName . ' <' . $cc . '>';
		$this->Cc = Concat($this->Cc, $cc, ";");
	}

	// Add bcc email
	public function addBcc($bcc, $bccName = '')
	{
		if ($bccName <> '')
			$bcc = $bccName . ' <' . $bcc . '>';
		$this->Bcc = Concat($this->Bcc, $bcc, ";");
	}

	// Replace subject
	public function replaceSubject($subject)
	{
		if (ContainsString($this->Subject, '<!--$Subject-->'))
			$this->Subject = str_replace('<!--$Subject-->', $subject, $this->Subject);
		else
			$this->Subject = $subject;
	}

	// Replace content
	public function replaceContent($find, $replaceWith)
	{
		$this->Content = str_replace($find, $replaceWith, $this->Content);
	}

	/**
	 * Add embedded image
	 *
	 * @param string $image File name of image (in global upload folder)
	 * @return void
	 */
	public function addEmbeddedImage($image)
	{
		if ($image <> "")
			$this->EmbeddedImages[] = $image;
	}

	/**
	 * Add attachment
	 *
	 * @param string $fileName Full file path (without $content) or file name (with $content)
	 * @param string $content File content
	 * @return void
	 */
	public function addAttachment($fileName, $content = "")
	{
		if ($fileName <> "")
			$this->Attachments[] = ["filename" => $fileName, "content" => $content];
	}

	/**
	 * Send email
	 *
	 * @return bool Whether email is sent successfully
	 */
	public function send()
	{
		$result = SendEmail($this->Sender, $this->Recipient, $this->Cc, $this->Bcc,
			$this->Subject, $this->Content, $this->Format, $this->Charset, $this->SmtpSecure,
			$this->Attachments, $this->EmbeddedImages, $this->Prop);
		if (is_bool($result)) {
			return $result;
		} else { // Error
			$this->SendErrDescription = $result;
			return FALSE;
		}
	}
}

/**
 * Pager item class
 */
class PagerItem
{
	public $Start;
	public $Text;
	public $Enabled;
}

/**
 * Numeric pager class
 */
class NumericPager
{
	public $Items = [];
	public $Count;
	public $FromIndex;
	public $ToIndex;
	public $RecordCount;
	public $PageSize;
	public $Range;
	public $FirstButton;
	public $PrevButton;
	public $NextButton;
	public $LastButton;
	public $ButtonCount = 0;
	public $AutoHidePager = TRUE;
	public $Visible = TRUE;

	// Constructor
	public function __construct($startRec, $displayRecs, $totalRecs, $recRange, $autoHidePager = AUTO_HIDE_PAGER)
	{
		$this->AutoHidePager = $autoHidePager;
		if ($this->AutoHidePager && $startRec == 1 && $totalRecs <= $displayRecs)
			$this->Visible = FALSE;
		$this->FirstButton = new PagerItem();
		$this->PrevButton = new PagerItem();
		$this->NextButton = new PagerItem();
		$this->LastButton = new PagerItem();
		$this->FromIndex = (int)$startRec;
		$this->PageSize = (int)$displayRecs;
		$this->RecordCount = (int)$totalRecs;
		$this->Range = (int)$recRange;
		if ($this->PageSize == 0)
			return;
		if ($this->FromIndex > $this->RecordCount)
			$this->FromIndex = $this->RecordCount;
		$this->ToIndex = $this->FromIndex + $this->PageSize - 1;
		if ($this->ToIndex > $this->RecordCount)
			$this->ToIndex = $this->RecordCount;

		// Setup
		$this->setupNumericPager();

		// Update button count
		if ($this->FirstButton->Enabled)
			$this->ButtonCount++;
		if ($this->PrevButton->Enabled)
			$this->ButtonCount++;
		if ($this->NextButton->Enabled)
			$this->ButtonCount++;
		if ($this->LastButton->Enabled)
			$this->ButtonCount++;
		$this->ButtonCount += count($this->Items);
	}

	// Add pager item
	protected function addPagerItem($startIndex, $text, $enabled)
	{
		$item = new PagerItem();
		$item->Start = $startIndex;
		$item->Text = $text;
		$item->Enabled = $enabled;
		$this->Items[] = $item;
	}

	// Setup pager items
	protected function setupNumericPager()
	{
		if ($this->RecordCount > $this->PageSize) {
			$eof = ($this->RecordCount < ($this->FromIndex + $this->PageSize));
			$hasPrev = ($this->FromIndex > 1);

			// First Button
			$tempIndex = 1;
			$this->FirstButton->Start = $tempIndex;
			$this->FirstButton->Enabled = ($this->FromIndex > $tempIndex);

			// Prev Button
			$tempIndex = $this->FromIndex - $this->PageSize;
			if ($tempIndex < 1)
				$tempIndex = 1;
			$this->PrevButton->Start = $tempIndex;
			$this->PrevButton->Enabled = $hasPrev;

			// Page links
			if ($hasPrev || !$eof) {
				$x = 1;
				$y = 1;
				$dx1 =(int)(($this->FromIndex - 1)/($this->PageSize * $this->Range)) * $this->PageSize * $this->Range + 1;
				$dy1 =(int)(($this->FromIndex - 1)/($this->PageSize * $this->Range)) * $this->Range + 1;
				if (($dx1 + $this->PageSize * $this->Range - 1) > $this->RecordCount) {
					$dx2 =(int)($this->RecordCount/$this->PageSize) * $this->PageSize + 1;
					$dy2 =(int)($this->RecordCount/$this->PageSize) + 1;
				} else {
					$dx2 = $dx1 + $this->PageSize * $this->Range - 1;
					$dy2 = $dy1 + $this->Range - 1;
				}
				while ($x <= $this->RecordCount) {
					if ($x >= $dx1 && $x <= $dx2) {
						$this->addPagerItem($x, $y, $this->FromIndex <> $x);
						$x += $this->PageSize;
						$y++;
					} elseif ($x >= ($dx1 - $this->PageSize * $this->Range) && $x <= ($dx2 + $this->PageSize * $this->Range)) {
						if ($x + $this->Range * $this->PageSize < $this->RecordCount) {
							$this->addPagerItem($x, $y . "-" . ($y + $this->Range - 1), TRUE);
						} else {
							$ny =(int)(($this->RecordCount - 1)/$this->PageSize) + 1;
							if ($ny == $y) {
								$this->addPagerItem($x, $y, TRUE);
							} else {
								$this->addPagerItem($x, $y . "-" . $ny, TRUE);
							}
						}
						$x += $this->Range * $this->PageSize;
						$y += $this->Range;
					} else {
						$x += $this->Range * $this->PageSize;
						$y += $this->Range;
					}
				}
			}

			// Next Button
			$tempIndex = $this->FromIndex + $this->PageSize;
			$this->NextButton->Start = $tempIndex;
			$this->NextButton->Enabled = !$eof;

			// Last Button
			$tempIndex =(int)(($this->RecordCount - 1)/$this->PageSize) * $this->PageSize + 1;
			$this->LastButton->Start = $tempIndex;
			$this->LastButton->Enabled = ($this->FromIndex < $tempIndex);
		}
	}
}

/**
 * PrevNext pager class
 */
class PrevNextPager
{
	public $FirstButton;
	public $PrevButton;
	public $NextButton;
	public $LastButton;
	public $CurrentPage;
	public $PageCount;
	public $FromIndex;
	public $ToIndex;
	public $RecordCount;
	public $AutoHidePager = TRUE;
	public $Visible = TRUE;

	// Constructor
	public function __construct($startRec, $displayRecs, $totalRecs, $autoHidePager = AUTO_HIDE_PAGER)
	{
		$this->AutoHidePager = $autoHidePager;
		$this->FirstButton = new PagerItem();
		$this->PrevButton = new PagerItem();
		$this->NextButton = new PagerItem();
		$this->LastButton = new PagerItem();
		$this->FromIndex = (int)$startRec;
		$this->PageSize = (int)$displayRecs;
		$this->RecordCount = (int)$totalRecs;
		if ($this->PageSize == 0)
			$this->PageSize = $this->RecordCount;
		$this->CurrentPage =(int)(($this->FromIndex - 1)/$this->PageSize) + 1;
		$this->PageCount =(int)(($this->RecordCount - 1)/$this->PageSize) + 1;
		if ($this->AutoHidePager && $this->PageCount == 1)
			$this->Visible = FALSE;
		if ($this->FromIndex > $this->RecordCount)
			$this->FromIndex = $this->RecordCount;
		$this->ToIndex = $this->FromIndex + $this->PageSize - 1;
		if ($this->ToIndex > $this->RecordCount)
			$this->ToIndex = $this->RecordCount;

		// First Button
		$tempIndex = 1;
		$this->FirstButton->Start = $tempIndex;
		$this->FirstButton->Enabled = ($tempIndex <> $this->FromIndex);

		// Prev Button
		$tempIndex = $this->FromIndex - $this->PageSize;
		if ($tempIndex < 1)
			$tempIndex = 1;
		$this->PrevButton->Start = $tempIndex;
		$this->PrevButton->Enabled = ($tempIndex <> $this->FromIndex);

		// Next Button
		$tempIndex = $this->FromIndex + $this->PageSize;
		if ($tempIndex > $this->RecordCount)
			$tempIndex = $this->FromIndex;
		$this->NextButton->Start = $tempIndex;
		$this->NextButton->Enabled = ($tempIndex <> $this->FromIndex);

		// Last Button
		$tempIndex =(int)(($this->RecordCount - 1)/$this->PageSize) * $this->PageSize + 1;
		$this->LastButton->Start = $tempIndex;
		$this->LastButton->Enabled = ($tempIndex <> $this->FromIndex);
	}
}

/**
 * Breadcrumb class
 */
class Breadcrumb
{
	public $Links = [];
	public $SessionLinks = [];
	public $Visible = TRUE;
	public static $CssClass = "breadcrumb float-sm-right ew-breadcrumbs";

	// Constructor
	public function __construct()
	{
		global $Language;
		$this->Links[] = ["home", "HomePage", "lokpasienlist.php", "ew-home", "", FALSE]; // Home
	}

	// Check if an item exists
	protected function exists($pageid, $table, $pageurl)
	{
		if (is_array($this->Links)) {
			$cnt = count($this->Links);
			for ($i = 0; $i < $cnt; $i++) {
				@list($id, $title, $url, $tablevar, $cur) = $this->Links[$i];
				if ($pageid == $id && $table == $tablevar && $pageurl == $url)
					return TRUE;
			}
		}
		return FALSE;
	}

	// Add breadcrumb
	public function add($pageid, $pagetitle, $pageurl, $pageurlclass = "", $table = "", $current = FALSE)
	{

		// Load session links
		$this->loadSession();

		// Get list of master tables
		$mastertable = [];
		if ($table <> "") {
			$tablevar = $table;
			while (@$_SESSION[PROJECT_NAME . "_" . $tablevar . "_" . TABLE_MASTER_TABLE] <> "") {
				$tablevar = $_SESSION[PROJECT_NAME . "_" . $tablevar . "_" . TABLE_MASTER_TABLE];
				if (in_array($tablevar, $mastertable))
					break;
				$mastertable[] = $tablevar;
			}
		}

		// Add master links first
		if (is_array($this->SessionLinks)) {
			$cnt = count($this->SessionLinks);
			for ($i = 0; $i < $cnt; $i++) {
				@list($id, $title, $url, $cls, $tbl, $cur) = $this->SessionLinks[$i];

				//if ((in_array($tbl, $mastertable) || $tbl == $table) && $id == "list") {
				if (in_array($tbl, $mastertable) && $id == "list") {
					if ($url == $pageurl)
						break;
					if (!$this->exists($id, $tbl, $url))
						$this->Links[] = [$id, $title, $url, $cls, $tbl, FALSE];
				}
			}
		}

		// Add this link
		if (!$this->exists($pageid, $table, $pageurl))
			$this->Links[] = [$pageid, $pagetitle, $pageurl, $pageurlclass, $table, $current];

		// Save session links
		$this->saveSession();
	}

	// Save links to Session
	protected function saveSession()
	{
		$_SESSION[SESSION_BREADCRUMB] = $this->Links;
	}

	// Load links from Session
	protected function loadSession()
	{
		if (is_array(@$_SESSION[SESSION_BREADCRUMB]))
			$this->SessionLinks = $_SESSION[SESSION_BREADCRUMB];
	}

	// Load language phrase
	protected function languagePhrase($title, $table, $current)
	{
		global $Language;
		$wrktitle = ($title == $table) ? $Language->TablePhrase($title, "TblCaption") : $Language->phrase($title);
		if ($current)
			$wrktitle = "<span id=\"ew-page-caption\">" . $wrktitle . "</span>";
		return $wrktitle;
	}

	// Render
	public function render()
	{
		if (!$this->Visible || PAGE_TITLE_STYLE == "" || PAGE_TITLE_STYLE == "None")
			return;
		$nav = "<ol class=\"" . self::$CssClass . "\">";
		if (is_array($this->Links)) {
			$cnt = count($this->Links);
			if (PAGE_TITLE_STYLE == "Caption") {

				// Already shown in content header, just ignore
				//list($id, $title, $url, $cls, $table, $cur) = $this->Links[$cnt - 1];
				//echo "<div class=\"ew-page-title\">" . $this->LanguagePhrase($title, $table, $cur) . "</div>";

				return;
			} else {
				for ($i = 0; $i < $cnt; $i++) {
					list($id, $title, $url, $cls, $table, $cur) = $this->Links[$i];
					if ($i < $cnt - 1) {
						$nav .= "<li class=\"breadcrumb-item\" id=\"ew-breadcrumb" . ($i + 1) . "\">";
					} else { // Last => Current page
						$nav .= "<li class=\"breadcrumb-item active\" id=\"ew-breadcrumb" . ($i + 1) . "\">";
						$url = ""; // No need to show URL for current page
					}
					$text = $this->languagePhrase($title, $table, $cur);
					$title = HtmlTitle($text);
					if ($url <> "") {
						$nav .= "<a href=\"" . GetUrl($url) . "\"";
						if ($title <> "" && $title <> $text)
							$nav .= " title=\"" . HtmlEncode($title) . "\"";
						if ($cls <> "")
							$nav .= " class=\"" . $cls . "\"";
						$nav .= ">" . $text . "</a>";
					} else {
						$nav .= $text;
					}
					$nav .= "</li>";
				}
			}
		}
		$nav .= "</ol>";
		echo $nav;
	}
}

/**
 * Table classes
 */
// Common class for table and report
class DbTableBase
{
	public $TableVar;
	public $TableName;
	public $TableType;
	public $Dbid = "DB"; // Table database id
	public $UseSelectLimit = TRUE;
	public $Visible = TRUE;
	public $fields = [];
	public $Rows = []; // Data for Custom Template
	public $Recordset = NULL; // Recordset
	public $UseTokenInUrl = USE_TOKEN_IN_URL;
	public $Export; // Export
	public $CustomExport; // Custom export
	public $ExportAll;
	public $ExportPageBreakCount; // Page break per every n record (PDF only)
	public $ExportPageOrientation; // Page orientation (PDF only)
	public $ExportPageSize; // Page size (PDF only)
	public $ExportExcelPageOrientation; // Page orientation (PhpSpreadsheet only)
	public $ExportExcelPageSize; // Page size (PhpSpreadsheet only)
	public $SendEmail; // Send email
	public $ImportCsvEncoding = ""; // Import to CSV encoding
	public $ImportCsvDelimiter = IMPORT_CSV_DELIMITER; // Import to CSV delimiter
	public $ImportCsvQuoteCharacter = IMPORT_CSV_QUOTE_CHARACTER; // Import to CSV quote character
	public $ImportMaxExecutionTime = IMPORT_MAX_EXECUTION_TIME; // Import max execution time
	public $ImportInsertOnly = IMPORT_INSERT_ONLY; // Import by insert only
	public $ImportUseTransaction = IMPORT_USE_TRANSACTION; // Import use transaction
	public $BasicSearch; // Basic search
	public $CurrentFilter; // Current filter
	public $CurrentOrder; // Current order
	public $CurrentOrderType; // Current order type
	public $RowType; // Row type
	public $CssClass; // CSS class
	public $CssStyle; // CSS style
	public $RowAttrs = []; // Row custom attributes
	public $CurrentAction; // Current action
	public $LastAction; // Last action
	public $UserIDAllowSecurity = 0; // User ID Allow
	public $UpdateTable = ""; // Update Table
	public $TableFilter = "";
	protected $TableCaption = "";
	protected $PageCaption = [];

	// Get Connection
	public function &getConnection()
	{
		return Conn($this->Dbid);
	}

	// Build filter from array
	protected function arrayToFilter(&$rs)
	{
		$filter = "";
		foreach ($rs as $name => $value) {
			if (array_key_exists($name, $this->fields))
				AddFilter($filter, QuotedName($this->fields[$name]->Name, $this->Dbid) . '=' . QuotedValue($value, $this->fields[$name]->DataType, $this->Dbid));
		}
		return $filter;
	}

	/**
	 * Build UPDATE statement
	 *
	 * @param array $rs Array of field to be updated
	 * @param string|array $where WHERE clause as string or array of field
	 * @return string
	 */
	protected function updateSql(&$rs, $where)
	{
		if (empty($this->UpdateTable) || empty($where))
			return ""; // Does not allow updating all records
		$sql = "UPDATE " . $this->UpdateTable . " SET ";
		foreach ($rs as $name => $value) {
			if (!isset($this->fields[$name]) || $this->fields[$name]->IsCustom)
				continue;
			$sql .= $this->fields[$name]->Expression . "=";
			$sql .= QuotedValue($value, $this->fields[$name]->DataType, $this->Dbid) . ",";
		}
		while (substr($sql, -1) == ",")
			$sql = substr($sql, 0, -1);
		$filter = is_array($where) ? $this->arrayToFilter($where) : $where;
		return $sql . " WHERE " . $filter;
	}

	/**
	 * Update
	 *
	 * @param array $rs Array of field to be updated
	 * @param string|array $where WHERE clause as string or array of field
	 * @return false|ADORecordSet
	 */
	public function update(&$rs, $where)
	{
		if (empty($this->UpdateTable) || empty($where))
			return FALSE; // Does not allow updating all records
		$conn = &$this->getConnection();
		return $conn->execute($this->updateSql($rs, $where));
	}

	/**
	 * Build DELETE statement
	 *
	 * @param string|array $where WHERE clause as string or array of field
	 * @return string
	 */
	protected function deleteSql(&$where)
	{
		if (empty($this->UpdateTable) || empty($where))
			return ""; // Does not allow deleting all records
		$sql = "DELETE FROM " . $this->UpdateTable;
		$filter = is_array($where) ? $this->arrayToFilter($where) : $where;
		return $sql . " WHERE " . $filter;
	}

	/**
	 * Delete
	 *
	 * @param string|array $where WHERE clause as string or array of field
	 * @return false|ADORecordSet
	 */
	public function delete(&$where)
	{
		if (empty($this->UpdateTable) || empty($where))
			return FALSE; // Does not allow deleting all records
		$conn = &$this->getConnection();
		return $conn->execute($this->deleteSql($rs));
	}

	// Reset attributes for table object
	public function resetAttributes()
	{
		$this->CssClass = "";
		$this->CssStyle = "";
		$this->RowAttrs = [];
		foreach ($this->fields as $fld) {
			$fld->resetAttributes();
		}
	}

	// Setup field titles
	public function setupFieldTitles()
	{
		foreach ($this->fields as &$fld) {
			if (strval($fld->title()) <> "") {
				$fld->EditAttrs["data-toggle"] = "tooltip";
				$fld->EditAttrs["title"] = HtmlEncode($fld->title());
			}
		}
	}

	// Get field values
	public function getFieldValues($propertyname)
	{
		$values = [];
		foreach ($this->fields as $fldname => $fld)
			$values[$fldname] = $fld->$propertyname;
		return $values;
	}

	// Get field cell attributes
	public function fieldCellAttributes()
	{
		$values = [];
		foreach ($this->fields as $fldname => $fld)
			$values[$fld->Param] = $fld->cellAttributes();
		return $values;
	}

	// Get field DB values for Custom Template
	public function customTemplateFieldValues()
	{
		global $CUSTOM_TEMPLATE_DATATYPES, $DATA_STRING_MAX_LENGTH;
		$values = [];
		foreach ($this->fields as $fldname => $fld) {
			if (in_array($fld->DataType, $CUSTOM_TEMPLATE_DATATYPES)) {
				if (is_string($fld->DbValue) && strlen($fld->DbValue) > $DATA_STRING_MAX_LENGTH)
					$values[$fld->Param] = substr($fld->DbValue, 0, $DATA_STRING_MAX_LENGTH);
				else
					$values[$fld->Param] = $fld->DbValue;
			}
		}
		return $values;
	}

	// Set table caption
	public function setTableCaption($v)
	{
		$this->TableCaption = $v;
	}

	// Table caption
	public function tableCaption()
	{
		global $Language;
		if ($this->TableCaption <> "")
			return $this->TableCaption;
		else
			return $Language->TablePhrase($this->TableVar, "TblCaption");
	}

	// Set page caption
	public function setPageCaption($page, $v)
	{
		$this->PageCaption[$page] = $v;
	}

	// Page caption
	public function pageCaption($page)
	{
		global $Language;
		$caption = @$this->PageCaption[$page];
		if ($caption <> "") {
			return $caption;
		} else {
			$caption = $Language->tablePhrase($this->TableVar, "TblPageCaption" . $page);
			if ($caption == "")
				$caption = "Page " . $page;
			return $caption;
		}
	}

	// Add URL parameter
	public function getUrlParm($parm = "")
	{
		$urlParm = ($this->UseTokenInUrl) ? "t=" . $this->TableVar : "";
		if ($parm <> "") {
			if ($urlParm <> "")
				$urlParm .= "&";
			$urlParm .= $parm;
		}
		return $urlParm;
	}

	// Row styles
	public function rowStyles()
	{
		$att = "";
		$style = trim($this->CssStyle);
		if (@$this->RowAttrs["style"] <> "")
			$style .= " " . $this->RowAttrs["style"];
		$class = trim($this->CssClass);
		if (@$this->RowAttrs["class"] <> "")
			$class .= " " . $this->RowAttrs["class"];
		if (trim($style) <> "")
			$att .= " style=\"" . trim($style) . "\"";
		if (trim($class) <> "")
			$att .= " class=\"" . trim($class) . "\"";
		return $att;
	}

	// Row attributes
	public function rowAttributes()
	{
		$att = $this->rowStyles();
		if (!$this->isExport()) {
			foreach ($this->RowAttrs as $k => $v) {
				if ($k <> "class" && $k <> "style" && trim($v) <> "")
					$att .= " " . $k . "=\"" . trim($v) . "\"";
			}
		}
		return $att;
	}

	// Field object by name
	public function fields($fldname)
	{
		return $this->fields[$fldname];
	}

	// Export
	public function isExport($format = "")
	{
		if ($format)
			return SameText($this->Export, $format);
		else
			return $this->Export <> "";
	}

	/**
	 * Set use lookup cache
	 *
	 * @param boolean $b Use lookup cache or not
	 * @return void
	 */
	public function setUseLookupCache($b)
	{
		foreach ($this->fields as &$fld)
			$fld->UseLookupCache = $b;
	}

	/**
	 * Set Lookup cache count
	 *
	 * @param integer $i Lookup cache count
	 * @return void
	 */
	public function setLookupCacheCount($i)
	{
		foreach ($this->fields as &$fld)
			$fld->LookupCacheCount = $i;
	}
}

// Class for table
class DbTable extends DbTableBase
{
	public $CurrentMode = ""; // Current mode
	public $UpdateConflict; // Update conflict
	public $EventName; // Event name
	public $EventCancelled; // Event cancelled
	public $CancelMessage; // Cancel message
	public $AllowAddDeleteRow = FALSE; // Allow add/delete row
	public $ValidateKey = TRUE; // Validate key
	public $DetailAdd; // Allow detail add
	public $DetailEdit; // Allow detail edit
	public $DetailView; // Allow detail view
	public $ShowMultipleDetails; // Show multiple details
	public $GridAddRowCount;
	public $CustomActions = []; // Custom action array

	/**
	 * Check current action
	 */
	// Display

	public function isShow()
	{
		return $this->CurrentAction == "show";
	}

	// Add
	public function isAdd()
	{
		return $this->CurrentAction == "add";
	}

	// Copy
	public function isCopy()
	{
		return $this->CurrentAction == "copy";
	}

	// Edit
	public function isEdit()
	{
		return $this->CurrentAction == "edit";
	}

	// Delete
	public function isDelete()
	{
		return $this->CurrentAction == "delete";
	}

	// Confirm
	public function isConfirm()
	{
		return $this->CurrentAction == "confirm";
	}

	// Overwrite
	public function isOverwrite()
	{
		return $this->CurrentAction == "overwrite";
	}

	// Cancel
	public function isCancel()
	{
		return $this->CurrentAction == "cancel";
	}

	// Grid add
	public function isGridAdd()
	{
		return $this->CurrentAction == "gridadd";
	}

	// Grid edit
	public function isGridEdit()
	{
		return $this->CurrentAction == "gridedit";
	}

	// Add/Copy/Edit/GridAdd/GridEdit
	public function isAddOrEdit()
	{
		return $this->isAdd() || $this->isCopy() || $this->isEdit() || $this->isGridAdd() || $this->isGridEdit();
	}

	// Insert
	public function isInsert()
	{
		return $this->CurrentAction == "insert";
	}

	// Update
	public function isUpdate()
	{
		return $this->CurrentAction == "update";
	}

	// Grid update
	public function isGridUpdate()
	{
		return $this->CurrentAction == "gridupdate";
	}

	// Grid insert
	public function isGridInsert()
	{
		return $this->CurrentAction == "gridinsert";
	}

	// Grid overwrite
	public function isGridOverwrite()
	{
		return $this->CurrentAction == "gridoverwrite";
	}

	// Import
	public function isImport()
	{
		return $this->CurrentAction == "import";
	}

	// Search
	public function isSearch()
	{
		return $this->CurrentAction == "search";
	}

	/**
	 * Check last action
	 */
	// Cancelled

	public function isCanceled()
	{
		return $this->LastAction == "cancel" && !$this->CurrentAction;
	}

	// Inline inserted
	public function isInlineInserted()
	{
		return $this->LastAction == "insert" && !$this->CurrentAction;
	}

	// Inline updated
	public function isInlineUpdated()
	{
		return $this->LastAction == "update" && !$this->CurrentAction;
	}

	// Grid updated
	public function isGridUpdated()
	{
		return $this->LastAction == "gridupdate" && !$this->CurrentAction;
	}

	// Grid inserted
	public function isGridInserted()
	{
		return $this->LastAction == "gridinsert" && !$this->CurrentAction;
	}

	/**
	 * Inline Add/Copy/Edit row
	 */
	// Inline-Add row

	public function isInlineAddRow()
	{
		return $this->isAdd() && $this->RowType == ROWTYPE_ADD;
	}

	// Inline-Copy row
	public function isInlineCopyRow()
	{
		return $this->isCopy() && $this->RowType == ROWTYPE_ADD;
	}

	// Inline-Edit row
	public function isInlineEditRow()
	{
		return $this->isEdit() && $this->RowType == ROWTYPE_EDIT;
	}

	// Inline-Add/Copy/Edit row
	public function isInlineActionRow()
	{
		return $this->isInlineAddRow() || $this->isInlineCopyRow() || $this->isInlineEditRow();
	}

	/**
	 * Other methods
	 */
	// Export return page

	public function exportReturnUrl()
	{
		$url = @$_SESSION[PROJECT_NAME . "_" . $this->TableVar . "_" . TABLE_EXPORT_RETURN_URL];
		return ($url <> "") ? $url : CurrentPageName();
	}
	public function setExportReturnUrl($v)
	{
		$_SESSION[PROJECT_NAME . "_" . $this->TableVar . "_" . TABLE_EXPORT_RETURN_URL] = $v;
	}

	// Records per page
	public function getRecordsPerPage()
	{
		return @$_SESSION[PROJECT_NAME . "_" . $this->TableVar . "_" . TABLE_REC_PER_PAGE];
	}
	public function setRecordsPerPage($v)
	{
		$_SESSION[PROJECT_NAME . "_" . $this->TableVar . "_" . TABLE_REC_PER_PAGE] = $v;
	}

	// Start record number
	public function getStartRecordNumber()
	{
		return @$_SESSION[PROJECT_NAME . "_" . $this->TableVar . "_" . TABLE_START_REC];
	}
	public function setStartRecordNumber($v)
	{
		$_SESSION[PROJECT_NAME . "_" . $this->TableVar . "_" . TABLE_START_REC] = $v;
	}

	// Search highlight name
	public function highlightName()
	{
		return $this->TableVar . "_Highlight";
	}

	// Search highlight value
	public function highlightValue($fld)
	{
		$kwlist = $this->BasicSearch->keywordList();
		if ($this->BasicSearch->Type == "") // Auto, remove ALL "OR"
			$kwlist = array_diff($kwlist, ["OR"]);
		$oprs = ["=", "LIKE", "STARTS WITH", "ENDS WITH"]; // Valid operators for highlight
		if (in_array($fld->AdvancedSearch->getValue("z"), $oprs)) {
			$akw = $fld->AdvancedSearch->getValue("x");
			if (strlen($akw) > 0)
				$kwlist[] = $akw;
		}
		if (in_array($fld->AdvancedSearch->getValue("w"), $oprs)) {
			$akw = $fld->AdvancedSearch->getValue("y");
			if (strlen($akw) > 0)
				$kwlist[] = $akw;
		}
		$src = $fld->ViewValue;
		if (count($kwlist) == 0)
			return $src;
		$pos1 = 0;
		$val = "";
		if (preg_match_all('/<([^>]*)>/i', $src, $matches, PREG_SET_ORDER|PREG_OFFSET_CAPTURE)) {
			foreach ($matches as $match) {
				$pos2 = $match[0][1];
				if ($pos2 > $pos1) {
					$src1 = substr($src, $pos1, $pos2-$pos1);
					$val .= $this->highlight($kwlist, $src1);
				}
				$val .= $match[0][0];
				$pos1 = $pos2 + strlen($match[0][0]);
			}
		}
		$pos2 = strlen($src);
		if ($pos2 > $pos1) {
			$src1 = substr($src, $pos1, $pos2-$pos1);
			$val .= $this->highlight($kwlist, $src1);
		}
		return $val;
	}

	// Highlight keyword
	protected function highlight($kwlist, $src)
	{
		$pattern = '';
		foreach ($kwlist as $kw)
			$pattern .= ($pattern == '' ? '' : '|') . preg_quote($kw, '/');
		if ($pattern == '')
			return $src;
		$pattern = '/(' . $pattern . ')/' . (SameText(PROJECT_CHARSET, 'utf-8') ? 'u' : '') . (HIGHLIGHT_COMPARE ? 'i' : '');
		$src = preg_replace_callback(
			$pattern,
			function($match) {
				return '<span class="' . $this->highlightName() . ' ew-highlight-search">' . $match[0] . '</span>';
			},
			$src
		);
		return $src;
	}

	// Search WHERE clause
	public function getSearchWhere()
	{
		return @$_SESSION[PROJECT_NAME . "_" . $this->TableVar . "_" . TABLE_SEARCH_WHERE];
	}
	public function setSearchWhere($v)
	{
		$_SESSION[PROJECT_NAME . "_" . $this->TableVar . "_" . TABLE_SEARCH_WHERE] = $v;
	}

	// Session WHERE clause
	public function getSessionWhere()
	{
		return @$_SESSION[PROJECT_NAME . "_" . $this->TableVar . "_" . TABLE_WHERE];
	}
	public function setSessionWhere($v)
	{
		$_SESSION[PROJECT_NAME . "_" . $this->TableVar . "_" . TABLE_WHERE] = $v;
	}

	// Session ORDER BY
	public function getSessionOrderBy()
	{
		return @$_SESSION[PROJECT_NAME . "_" . $this->TableVar . "_" . TABLE_ORDER_BY];
	}
	public function setSessionOrderBy($v)
	{
		$_SESSION[PROJECT_NAME . "_" . $this->TableVar . "_" . TABLE_ORDER_BY] = $v;
	}

	// Session key
	public function getKey($fld)
	{
		return @$_SESSION[PROJECT_NAME . "_" . $this->TableVar . "_" . TABLE_KEY . "_" . $fld];
	}
	public function setKey($fld, $v)
	{
		$_SESSION[PROJECT_NAME . "_" . $this->TableVar . "_" . TABLE_KEY . "_" . $fld] = $v;
	}

	// URL encode
	public function urlEncode($str)
	{
		return urlencode($str);
	}

	// Print
	public function raw($str)
	{
		return $str;
	}
}

/**
 * Field class
 */
class DbField
{
	public $TableName; // Table name
	public $TableVar; // Table variable name
	public $SourceTableVar = ""; // Source Table variable name (for Report only)
	public $Name; // Field name
	public $FieldVar; // Field variable name
	public $Param; // Field parameter name
	public $Expression; // Field expression (used in SQL)
	public $BasicSearchExpression; // Field expression (used in basic search SQL)
	public $IsCustom = FALSE; // Custom field
	public $IsVirtual; // Virtual field
	public $VirtualExpression; // Virtual field expression (used in ListSQL)
	public $ForceSelection; // Autosuggest force selection
	public $SelectMultiple; // Select multiple
	public $VirtualSearch; // Search as virtual field
	public $DefaultErrorMessage; // Default error message
	public $VirtualValue; // Virtual field value
	public $TooltipValue; // Field tooltip value
	public $TooltipWidth = 0; // Field tooltip width
	public $Type; // Field type
	public $DataType; // PHPMaker Field type
	public $BlobType; // For Oracle only
	public $ViewTag; // View Tag
	public $HtmlTag; // Html Tag
	public $IsDetailKey = FALSE; // Field is detail key
	public $IsAutoIncrement = FALSE; // Autoincrement field (FldAutoIncrement)
	public $IsPrimaryKey = FALSE; // Primary key (FldIsPrimaryKey)
	public $IsForeignKey = FALSE; // Foreign key (Master/Detail key)
	public $IsEncrypt = FALSE; // Field is encrypted
	public $Nullable = TRUE; // Nullable
	public $Required = FALSE; // Required
	public $AdvancedSearch; // AdvancedSearch Object
	public $Upload; // Upload Object
	public $DateTimeFormat; // Date time format
	public $CssStyle; // CSS style
	public $CssClass; // CSS class
	public $ImageAlt; // Image alt
	public $ImageWidth = 0; // Image width
	public $ImageHeight = 0; // Image height
	public $ImageResize = FALSE; // Image resize
	public $IsBlobImage = FALSE; // Is blob image
	public $ViewCustomAttributes; // View custom attributes
	public $EditCustomAttributes; // Edit custom attributes
	public $LinkCustomAttributes; // Link custom attributes
	public $Count; // Count
	public $Total; // Total
	public $TrueValue = '1';
	public $FalseValue = '0';
	public $Visible = TRUE; // Visible
	public $Disabled; // Disabled
	public $ReadOnly = FALSE; // Read only
	public $TruncateMemoRemoveHtml; // Remove HTML from memo field
	public $CustomMsg = ""; // Custom message
	public $CellCssClass = ""; // Cell CSS class
	public $CellCssStyle = ""; // Cell CSS style
	public $CellCustomAttributes = ""; // Cell custom attributes
	public $HeaderCellCssClass = ""; // Header cell (<th>) CSS class 
	public $FooterCellCssClass = ""; // Footer cell (<td> in <tfoot>) CSS class
	public $MultiUpdate; // Multi update
	public $OldValue; // Old Value
	public $ConfirmValue; // Confirm value
	public $CurrentValue; // Current value
	public $ViewValue; // View value (string|Object)
	public $EditValue; // Edit value
	public $EditValue2; // Edit value 2 (for search)
	public $HrefValue; // Href value
	public $ExportHrefValue; // Href value for export
	public $FormValue; // Form value
	public $QueryStringValue; // QueryString value
	public $DbValue; // Database value
	public $Sortable = TRUE; // Sortable
	public $UploadPath = UPLOAD_DEST_PATH; // Upload path
	public $OldUploadPath = UPLOAD_DEST_PATH; // Old upload path (for deleting old image)
	public $HrefPath = UPLOAD_HREF_PATH; // Href path (for download)
	public $UploadAllowedFileExt = UPLOAD_ALLOWED_FILE_EXT; // Allowed file extensions
	public $UploadMaxFileSize = MAX_FILE_SIZE; // Upload max file size
	public $UploadMaxFileCount = MAX_FILE_COUNT; // Upload max file count
	public $UploadMultiple = FALSE; // Multiple Upload
	public $UseColorbox = USE_COLORBOX; // Use Colorbox
	public $CellAttrs = []; // Cell custom attributes
	public $EditAttrs = []; // Edit custom attributes
	public $ViewAttrs = []; // View custom attributes
	public $LinkAttrs = []; // Link custom attributes
	public $DisplayValueSeparator = ", ";
	public $AutoFillOriginalValue = AUTO_FILL_ORIGINAL_VALUE;
	public $RequiredErrorMessage;
	public $Lookup = NULL;
	public $OptionCount = 0;
	public $UseLookupCache = USE_LOOKUP_CACHE; // Use lookup cache
	public $LookupCacheCount = LOOKUP_CACHE_COUNT; // Lookup cache count
	public $PlaceHolder = "";
	public $Caption = "";
	public $UsePleaseSelect = TRUE;
	public $PleaseSelectText = "";
	public $Exportable = TRUE;
	public $ExportOriginalValue = EXPORT_ORIGINAL_VALUE;
	public $ExportFieldImage = EXPORT_FIELD_IMAGE;

	// Constructor
	public function __construct($tblvar, $tblname, $fldvar, $fldname, $fldexp, $fldbsexp, $fldtype, $flddtfmt, $upload, $fldvirtualexp, $fldvirtual, $forceselect, $fldvirtualsrch, $fldviewtag="", $fldhtmltag="")
	{
		global $Language;
		$this->TableVar = $tblvar;
		$this->TableName = $tblname;
		$this->FieldVar = $fldvar;
		$this->Param = substr($this->FieldVar, 2); // Remove "x_"
		$this->Name = $fldname;
		$this->Expression = $fldexp;
		$this->BasicSearchExpression = $fldbsexp;
		$this->Type = $fldtype;
		$this->DataType = FieldDataType($fldtype);
		$this->DateTimeFormat = $flddtfmt;
		$this->AdvancedSearch = new AdvancedSearch($this->TableVar, $this->FieldVar);
		if ($upload)
			$this->Upload = new HttpUpload($this);
		$this->VirtualExpression = $fldvirtualexp;
		$this->IsVirtual = $fldvirtual;
		$this->ForceSelection = $forceselect;
		$this->VirtualSearch = $fldvirtualsrch;
		$this->ViewTag = $fldviewtag;
		$this->HtmlTag = $fldhtmltag;
		$this->RequiredErrorMessage = $Language->phrase("EnterRequiredField");
	}

	// Field encryption/decryption required
	public function isEncrypt()
	{
		$encrypt = $this->IsEncrypt && ($this->DataType == DATATYPE_STRING || $this->DataType == DATATYPE_MEMO) &&
			!$this->IsPrimaryKey && !$this->IsAutoIncrement && !$this->IsForeignKey;

		// Do not encrypt username/password/userid/userlevel/profile/activate/email fields in user table
		if ($encrypt && ($this->TableName == USER_TABLE_NAME && in_array($this->Name, [LOGIN_USERNAME_FIELD_NAME,
			LOGIN_PASSWORD_FIELD_NAME, USER_ID_FIELD_NAME, USER_LEVEL_FIELD_NAME,
			USER_PROFILE_FIELD_NAME, REGISTER_ACTIVATE_FIELD_NAME, USER_EMAIL_FIELD_NAME])))
			$encrypt = FALSE;
		return $encrypt;
	}

	// Get place holder
	public function getPlaceHolder()
	{
		return ($this->ReadOnly || array_key_exists("readonly", $this->EditAttrs)) ? "" : $this->PlaceHolder;
	}

	// Set field caption
	public function setCaption($v)
	{
		$this->Caption = $v;
	}

	// Field caption
	public function caption()
	{
		global $Language;
		if ($this->Caption <> "")
			return $this->Caption;
		else
			return $Language->fieldPhrase($this->TableVar, $this->Param, "FldCaption");
	}

	// Field title
	public function title()
	{
		global $Language;
		return $Language->fieldPhrase($this->TableVar, $this->Param, "FldTitle");
	}

	// Field image alt
	public function alt()
	{
		global $Language;
		return $Language->FieldPhrase($this->TableVar, $this->Param, "FldAlt");
	}

	// Field error message
	public function errorMessage()
	{
		global $Language;
		$err = $Language->FieldPhrase($this->TableVar, $this->Param, "FldErrMsg");
		if ($err == "")
			$err = $this->DefaultErrorMessage . " - " . $this->caption();
		return $err;
	}

	// Field option value
	public function tagValue($i)
	{
		global $Language;
		return $Language->fieldPhrase($this->TableVar, $this->Param, "FldTagValue" . $i);
	}

	// Field option caption
	public function tagCaption($i)
	{
		global $Language;
		return $Language->fieldPhrase($this->TableVar, $this->Param, "FldTagCaption" . $i);
	}

	// Set field visibility
	public function setVisibility()
	{
		$this->Visible = $GLOBALS[$this->TableVar]->getFieldVisibility($this->Param);
	}

	// Check if multiple selection
	public function isMultiSelect() {
		return $this->HtmlTag == "SELECT" && $this->SelectMultiple || $this->HtmlTag == "CHECKBOX";
	}

	// Field lookup cache option
	public function lookupCacheOption($val)
	{
		$val = strval($val);
		if ($val == "" || $this->Lookup === NULL || !is_array($this->Lookup->Options) || count($this->Lookup->Options) == 0)
			return NULL;
		$res = NULL;
		if ($this->isMultiSelect()) { // Multiple options
			$res = new OptionValues();
			$arwrk = explode(",", $val);
			foreach ($arwrk as $wrk) {
				$wrk = trim($wrk);
				if (array_key_exists($wrk, $this->Lookup->Options)) { // Lookup data found in cache
					$ar = $this->Lookup->Options[$wrk];
					$res->add($this->displayValue($ar));
				} else {
					$res->add($val); // Not found, use original value
				}
			}
		} else {
			if (array_key_exists($val, $this->Lookup->Options)) { // Lookup data found in cache
				$ar = $this->Lookup->Options[$val];
				$res = $this->displayValue($ar);
			} else {
				$res = $val; // Not found, use original value
			}
		}
		return $res;
	}

	// Field lookup options
	public function lookupOptions()
	{
		if ($this->Lookup !== NULL && is_array($this->Lookup->Options))
			return array_values($this->Lookup->Options);
		return [];
	}

	// Field option caption by option value
	public function optionCaption($val)
	{
		for ($i = 0; $i < $this->OptionCount; $i++) {
			if ($val == $this->tagValue($i + 1)) {
				$val = $this->tagCaption($i + 1) ?: $val;
				break;
			}
		}
		return $val;
	}

	// Get field user options as array
	public function options($pleaseSelect = FALSE, $client = FALSE)
	{
		global $Language;
		$arwrk = [];
		if ($pleaseSelect) // Add "Please Select"
			if ($client)
				$arwrk[] = ["lf" => "", "df" => $Language->phrase("PleaseSelect")];
			else
				$arwrk[] = ["", $Language->phrase("PleaseSelect")];
		for ($i = 0; $i < $this->OptionCount; $i++) {
			$value = $this->tagValue($i + 1);
			$caption = $this->tagCaption($i + 1) ?: $value;
			if ($client)
				$arwrk[] = ["lf" => $value, "df" => $caption];
			else
				$arwrk[] = [$value, $caption];
		}
		return $arwrk;
	}

	// Href path
	public function hrefPath()
	{
		$path = UploadPath(FALSE, ($this->HrefPath <> "") ? $this->HrefPath : $this->UploadPath);
		if (preg_match('/^s3:\/\/([^\/]+)/i', $path, $m)) {
			$options = stream_context_get_options(stream_context_get_default());
			$client = @$options["s3"]["client"];
			if ($client) {
				$r = Random();
				$path = $client->getObjectUrl($m[1], $r);
				return explode($r, $path)[0];
			}
		}
		return $path; 
	}

	// Physical upload path
	public function physicalUploadPath()
	{
		return ServerMapPath($this->UploadPath);
	}

	// Old Physical upload path
	public function oldPhysicalUploadPath()
	{
		return ServerMapPath($this->OldUploadPath);
	}

	// Get select options HTML
	public function selectOptionListHtml($name = "")
	{
		global $Language;
		$empty = TRUE;
		$curValue = (CurrentPage()->RowType == ROWTYPE_SEARCH) ? (StartsString("y", $name) ? $this->AdvancedSearch->SearchValue2 : $this->AdvancedSearch->SearchValue) : $this->CurrentValue;
		$str = "";
		if (is_array($this->EditValue)) {
			$ar = $this->EditValue;
			if ($this->SelectMultiple) {
				$armulti = (strval($curValue) <> "") ? explode(",", strval($curValue)) : [];
				$cnt = count($armulti);
				$rowcnt = count($ar);
				$empty = TRUE;
				for ($i = 0; $i < $rowcnt; $i++) {
					$sel = FALSE;
					for ($ari = 0; $ari < $cnt; $ari++) {
						if (SameString($ar[$i][0], $armulti[$ari]) && $armulti[$ari] != NULL) {
							$armulti[$ari] = NULL; // Marked for removal
							$sel = TRUE;
							$empty = FALSE;
							break;
						}
					}
					if (!$sel)
						continue;
					foreach ($ar[$i] as $k => $v)
						$ar[$i][$k] = RemoveHtml(strval($ar[$i][$k]));
					$str .= "<option value=\"" . HtmlEncode($ar[$i][0]) . "\" selected>" . $this->displayValue($ar[$i]) . "</option>";
				}
			} else {
				if ($this->UsePleaseSelect)
					$str .= "<option value=\"\">" . $this->PleaseSelectText . "</option>";
				$rowcnt = count($ar);
				$empty = TRUE;
				for ($i = 0; $i < $rowcnt; $i++) {
					if (SameString($curValue, $ar[$i][0]))
						$empty = FALSE;
					else
						continue;
					foreach ($ar[$i] as $k => $v)
						$ar[$i][$k] = RemoveHtml(strval($ar[$i][$k]));
					$str .= "<option value=\"" . HtmlEncode($ar[$i][0]) . "\" selected>" . $this->displayValue($ar[$i]) . "</option>";
				}
			}
			if ($this->SelectMultiple) {
				for ($ari = 0; $ari < $cnt; $ari++) {
					if ($armulti[$ari] != NULL)
						$str .= "<option value=\"" . HtmlEncode($armulti[$ari]) . "\" selected>" . $armulti[$ari] . "</option>";
				}
			} else {
				if ($empty && strval($curValue) <> "")
					$str .= "<option value=\"" . HtmlEncode($curValue) . "\" selected>" . $curValue . "</option>";
			}
		}
		if ($empty)
			$this->OldValue = "";
		return $str;
	}

	// Get radio buttons HTML
	public function radioButtonListHtml($isDropdown, $name, $page = -1)
	{
		$empty = TRUE;
		$curValue = (CurrentPage()->RowType == ROWTYPE_SEARCH) ? (StartsString("y", $name) ? $this->AdvancedSearch->SearchValue2 : $this->AdvancedSearch->SearchValue) : $this->CurrentValue;
		$str = '';
		$ar = $this->EditValue;
		if (is_array($ar)) {
			$rowcnt = count($ar);
			for ($i = 0; $i < $rowcnt; $i++) {
				if (SameString($curValue, $ar[$i][0]))
					$empty = FALSE;
				else
					continue;
				$html = '<input type="radio" data-table="' . $this->TableVar . '" data-field="' . $this->FieldVar . '"' .
					(($page > -1) ? ' data-page="' . $page . '"' : '') .
					' name="' . $name . '" id="' . $name . '_' . $i . '"' .
					' data-value-separator="' . $this->displayValueSeparatorAttribute() . '"' .
					' value="' . HtmlEncode($ar[$i][0]) . '" checked' . $this->editAttributes() . '>';
				$html .= '<label class="form-check-label" for="' . $name . '_' . $i . '">' . $this->displayValue($ar[$i]) . '</label>';
				$str .= '<div class="form-check">' . $html . '</div>';
			}
			if ($empty && strval($curValue) <> '') {
				$html = '<input type="radio" data-table="' . $this->TableVar . '" data-field="' . $this->FieldVar . '"' .
					(($page > -1) ? ' data-page="' . $page . '"' : '') .
					' name="' . $name . '" id="' . $name . '_' . $rowcnt . '"' .
					' data-value-separator="' . $this->displayValueSeparatorAttribute() . '"' .
					' value="' . HtmlEncode($curValue) . '" checked' . $this->editAttributes() . '>';
				$html .= '<label class="form-check-label" for="' . $name . '_' . $rowcnt . '">' . $curValue . '</label>';
				$str .= '<div class="form-check">' . $html . '</div>';
			}
		}
		if ($empty)
			$this->OldValue = '';
		return $str;
	}

	// Get checkboxes HTML
	public function checkBoxListHtml($isDropdown, $name, $page = -1)
	{
		$empty = TRUE;
		$curValue = (CurrentPage()->RowType == ROWTYPE_SEARCH) ? (StartsString("y", $name) ? $this->AdvancedSearch->SearchValue2 : $this->AdvancedSearch->SearchValue) : $this->CurrentValue;
		$str = "";
		$ar = $this->EditValue;
		if (is_array($ar)) {
			$armulti = (strval($curValue) <> "") ? explode(",", strval($curValue)) : [];
			$cnt = count($armulti);
			$rowcnt = count($ar);
			$empty = TRUE;
			for ($i = 0; $i < $rowcnt; $i++) {
				$sel = FALSE;
				for ($ari = 0; $ari < $cnt; $ari++) {
					if (SameString($ar[$i][0], $armulti[$ari]) && $armulti[$ari] != NULL) {
						$armulti[$ari] = NULL; // Marked for removal
						$sel = TRUE;
						$empty = FALSE;
						break;
					}
				}
				if (!$sel)
					continue;
				$html = '<input type="checkbox" class="form-check-input" data-table="' . $this->TableVar . '" data-field="' . $this->FieldVar . '"' .
					(($page > -1) ? ' data-page="' . $page . '"' : '') .
					' name="' . $name . '" id="' . $name . '_' . $i . '"' .
					' data-value-separator="' . $this->displayValueSeparatorAttribute() . '"' .
					' value="' . HtmlEncode($ar[$i][0]) . '" checked' . $this->editAttributes() . '>';
				$html .= '<label class="form-check-label" for="' . $name . '_' . $i . '">' . $this->displayValue($ar[$i]) . '</label>'; // Note: No spacing within the LABEL tag
				$str .= '<div class="form-check">' . $html . '</div>';
			}
			for ($ari = 0; $ari < $cnt; $ari++) {
				if ($armulti[$ari] != NULL) {
					$html = '<input type="checkbox" class="form-check-input" data-table="' . $this->TableVar . '" data-field="' . $this->FieldVar . '"' .
						(($page > -1) ? ' data-page="' . $page . '"' : '') .
						' name="' . $name . '" id="' . $name . '_' . $ari . '" value="' . HtmlEncode($armulti[$ari]) . '" checked' .
						' data-value-separator="' . $this->displayValueSeparatorAttribute() . '"' .
						$this->editAttributes() . '>';
					$html .= '<label class="form-check-label" for="' . $name . '_' . $ari . '">' . $armulti[$ari] . '</label>';
					$str .= '<div class="form-check">' . $html . '</div>';
				}
			}
		}
		if ($empty)
			$this->OldValue = '';
		return $str;
	}

	/**
	 * Get display field value separator
	 *
	 * @param integer $idx Display field index (1|2|3)
	 * @return string
	 */
	protected function getDisplayValueSeparator($idx)
	{
		$sep = $this->DisplayValueSeparator;
		return (is_array($sep)) ? @$sep[$idx - 1] : ($sep ?: ", ");
	}

	// Get display field value separator as attribute value
	public function displayValueSeparatorAttribute()
	{
		return HtmlEncode(is_array($this->DisplayValueSeparator) ? json_encode($this->DisplayValueSeparator) : $this->DisplayValueSeparator);
	}

	/**
	 * Get display value (for lookup field)
	 *
	 * @param array|ADORecordset $rs Record to be displayed
	 * @return string
	 */
	public function displayValue($rs)
	{
		$ar = is_array($rs) ? $rs : $rs->fields;
		$val = strval(@$ar[1]); // Display field 1
		for ($i = 2; $i <= 4; $i++) { // Display field 2 to 4
			$sep = $this->getDisplayValueSeparator($i - 1);
			if ($sep == NULL) // No separator, break
				break;
			if (@$ar[$i] <> "")
				$val .= $sep . $ar[$i];
		}
		return $val;
	}

	// Reset attributes for field object
	public function resetAttributes()
	{
		$this->CssStyle = "";
		$this->CssClass = "";
		$this->CellCssStyle = "";
		$this->CellCssClass = "";
		$this->CellAttrs = [];
		$this->EditAttrs = [];
		$this->ViewAttrs = [];
		$this->LinkAttrs = [];
	}

	// View Attributes
	public function viewAttributes()
	{
		$viewattrs = $this->ViewAttrs;
		if ($this->ViewTag == "IMAGE")
			$viewattrs["alt"] = (trim($this->ImageAlt) <> "") ? trim($this->ImageAlt) : ""; // IMG tag requires alt attribute
		$attrs = $this->ViewCustomAttributes; // Custom attributes
		if (is_array($attrs)) { // Custom attributes as array
			$ar = $attrs;
			$attrs = "";
			$aik = array_intersect_key($ar, $viewattrs);
			$viewattrs += $ar; // Combine attributes
			foreach ($aik as $k => $v) { // Duplicate attributes
				if ($k == "style" || StartsString("on", $k)) // "style" and events
					$viewattrs[$k] = Concat($viewattrs[$k], $v, ";");
				else // "class" and others
					$viewattrs[$k] = Concat($viewattrs[$k], $v, " ");
			}
		}
		$style = "";
		if ($this->ViewTag == "IMAGE" && (int)$this->ImageWidth > 0 && (!$this->ImageResize || (int)$this->ImageHeight <= 0))
			$style .= "width: " . (int)$this->ImageWidth . "px; ";
		if ($this->ViewTag == "IMAGE" && (int)$this->ImageHeight > 0 && (!$this->ImageResize || (int)$this->ImageWidth <= 0))
			$style .= "height: " . (int)$this->ImageHeight . "px; ";
		$viewattrs["style"] = Concat(@$viewattrs["style"], $style . trim($this->CssStyle), ";");
		$viewattrs["class"] = Concat(@$viewattrs["class"], $this->CssClass, " ");
		$att = "";
		foreach ($viewattrs as $k => $v) {
			if (trim($k) <> "" && (trim($v) <> "" || IsBooleanAttribute($k))) { // Allow boolean attributes, e.g. "disabled"
				$att .= " " . trim($k);
				if (trim($v) <> "")
					$att .= "=\"" . trim($v) . "\"";
			} elseif (trim($k) == "alt" && trim($v) == "") { // Allow alt="" since it is a required attribute
				$att .= " alt=\"\"";
			}
		}
		if ($attrs <> "") // Custom attributes as string
			$att .= " " . $attrs;
		return $att;
	}

	// Edit attributes
	public function editAttributes()
	{
		$editattrs = $this->EditAttrs;
		$attrs = $this->EditCustomAttributes; // Custom attributes
		if (is_array($attrs)) { // Custom attributes as array
			$ar = $attrs;
			$attrs = "";
			$aik = array_intersect_key($ar, $editattrs);
			$editattrs += $ar; // Combine attributes
			foreach ($aik as $k => $v) { // Duplicate attributes
				if ($k == "style" || StartsString("on", $k)) // "style" and events
					$editattrs[$k] = Concat($editattrs[$k], $v, ";");
				else // "class" and others
					$editattrs[$k] = Concat($editattrs[$k], $v, " ");
			}
		}
		$editattrs["style"] = Concat(@$editattrs["style"], $this->CssStyle, ";");
		$editattrs["class"] = Concat(@$editattrs["class"], $this->CssClass, " ");
		if ($this->Disabled)
			$editattrs["disabled"] = TRUE;
		if ($this->ReadOnly) {
			if (in_array($this->HtmlTag, ["TEXT", "PASSWORD", "TEXTAREA"])) { // Elements support readonly
				$editattrs["readonly"] = TRUE;
			} else { // Elements do not support readonly
				$editattrs["disabled"] = TRUE;
				$editattrs["data-readonly"] = "1";
				AppendClass($editattrs["class"], "disabled");
			}
		}
		$att = "";
		foreach ($editattrs as $k => $v) {
			if (trim($k) <> "" && (trim($v) <> "" || IsBooleanAttribute($k))) { // Allow boolean attributes, e.g. "disabled"
				$att .= " " . trim($k);
				if (!IsBooleanAttribute($k) && trim($v) <> "")
					$att .= "=\"" . trim($v) . "\"";
			}
		}
		if ($attrs <> "") // Custom attributes as string
			$att .= " " . $attrs;
		return $att;
	}

	// Cell styles (Used in export)
	public function cellStyles()
	{
		$att = "";
		$style = trim($this->CellCssStyle);
		if (@$this->CellAttrs["style"] <> "")
			$style .= " " . $this->CellAttrs["style"];
		$class = trim($this->CellCssClass);
		if (@$this->CellAttrs["class"] <> "")
			$class .= " " . $this->CellAttrs["class"];
		if (trim($style) <> "")
			$att .= " style=\"" . trim($style) . "\"";
		if (trim($class) <> "")
			$att .= " class=\"" . trim($class) . "\"";
		return $att;
	}

	// Cell attributes
	public function cellAttributes()
	{
		$cellattrs = $this->CellAttrs;
		$attrs = $this->CellCustomAttributes; // Custom attributes
		if (is_array($attrs)) { // Custom attributes as array
			$ar = $attrs;
			$attrs = "";
			$aik = array_intersect_key($ar, $cellattrs);
			$cellattrs += $ar; // Combine attributes
			foreach ($aik as $k => $v) { // Duplicate attributes
				if ($k == "style" || StartsString("on", $k)) // "style" and events
					$cellattrs[$k] = Concat($cellattrs[$k], $v, ";");
				else // "class" and others
					$cellattrs[$k] = Concat($cellattrs[$k], $v, " ");
			}
		}
		$cellattrs["style"] = Concat(@$cellattrs["style"], $this->CellCssStyle, ";");
		$cellattrs["class"] = Concat(@$cellattrs["class"], $this->CellCssClass, " ");
		$att = "";
		foreach ($cellattrs as $k => $v) {
			if (trim($k) <> "" && (trim($v) <> "" || IsBooleanAttribute($k))) { // Allow boolean attributes, e.g. "disabled"
				$att .= " " . trim($k);
				if (trim($v) <> "")
					$att .= "=\"" . trim($v) . "\"";
			}
		}
		if ($attrs <> "") // Custom attributes as string
			$att .= " " . $attrs;
		return $att;
	}

	// Link attributes
	public function linkAttributes()
	{
		$linkattrs = $this->LinkAttrs;
		$attrs = $this->LinkCustomAttributes; // Custom attributes
		if (is_array($attrs)) { // Custom attributes as array
			$ar = $attrs;
			$attrs = "";
			$aik = array_intersect_key($ar, $linkattrs);
			$linkattrs += $ar; // Combine attributes
			foreach ($aik as $k => $v) { // Duplicate attributes
				if ($k == "style" || StartsString("on", $k)) // "style" and events
					$linkattrs[$k] = Concat($linkattrs[$k], $v, ";");
				else // "class" and others
					$linkattrs[$k] = Concat($linkattrs[$k], $v, " ");
			}
		}
		$href = trim($this->HrefValue);
		if ($href <> "")
			$linkattrs["href"] = $href;
		$att = "";
		foreach ($linkattrs as $k => $v) {
			if (trim($k) <> "" && (trim($v) <> "" || IsBooleanAttribute($k))) { // Allow boolean attributes, e.g. "disabled"
				$att .= " " . trim($k);
				if (trim($v) <> "")
					$att .= "=\"" . trim($v) . "\"";
			}
		}
		if ($attrs <> "") // Custom attributes as string
			$att .= " " . $attrs;
		return $att;
	}

	// Header cell CSS class
	public function headerCellClass()
	{
		$class = "ew-table-header-cell";
		AppendClass($class, $this->HeaderCellCssClass);
		return $class;
	}

	// Footer cell CSS class
	public function footerCellClass()
	{
		$class = "ew-table-footer-cell";
		AppendClass($class, $this->FooterCellCssClass);
		return $class;
	}

	// Add CSS class to all cells
	public function addClass($class)
	{
		AppendClass($this->CellCssClass, $class);
		AppendClass($this->HeaderCellCssClass, $class);
		AppendClass($this->FooterCellCssClass, $class);
	}

	// Remove CSS class from all cells
	public function removeClass($class)
	{
		RemoveClass($this->CellCssClass, $class);
		RemoveClass($this->HeaderCellCssClass, $class);
		RemoveClass($this->FooterCellCssClass, $class);
	}

	// Sort
	public function getSort()
	{
		return @$_SESSION[PROJECT_NAME . "_" . $this->TableVar . "_" . TABLE_SORT . "_" . $this->FieldVar];
	}
	public function setSort($v)
	{
		if (@$_SESSION[PROJECT_NAME . "_" . $this->TableVar . "_" . TABLE_SORT . "_" . $this->FieldVar] <> $v) {
			$_SESSION[PROJECT_NAME . "_" . $this->TableVar . "_" . TABLE_SORT . "_" . $this->FieldVar] = $v;
		}
	}

	// Reverse sort
	public function reverseSort()
	{
		return ($this->getSort() == "ASC") ? "DESC" : "ASC";
	}

	// Get view value
	public function getViewValue()
	{
		if (is_object($this->ViewValue) && $this->ViewValue instanceof HtmlValueInterface)
			return $this->ViewValue->toHtml();
		return $this->ViewValue;
	}

	// Export caption
	public function exportCaption()
	{
		if (!$this->Exportable)
			return;
		return (EXPORT_FIELD_CAPTION) ? $this->caption() : $this->Name;
	}

	// Export value
	public function exportValue()
	{
		return ($this->ExportOriginalValue) ? $this->CurrentValue : $this->ViewValue;
	}

	// Get temp image
	public function getTempImage()
	{
		if ($this->DataType == DATATYPE_BLOB) {
			$wrkdata = $this->Upload->DbValue;
			if (is_array($wrkdata) || is_object($wrkdata)) // Byte array
				$wrkdata = BytesToString($wrkdata);
			if (!empty($wrkdata)) {
				if ($this->ImageResize) {
					$wrkwidth = $this->ImageWidth;
					$wrkheight = $this->ImageHeight;
					ResizeBinary($wrkdata, $wrkwidth, $wrkheight);
				}
				return TempImage($wrkdata);
			}
		} else {
			$wrkfile = $this->Upload->DbValue;
			if (empty($wrkfile))
				$wrkfile = $this->CurrentValue;
			if (!empty($wrkfile)) {
				if (!$this->UploadMultiple) {
					$imagefn = $this->physicalUploadPath() . $wrkfile;
					if (file_exists($imagefn)) {
						if ($this->ImageResize) {
							$wrkwidth = $this->ImageWidth;
							$wrkheight = $this->ImageHeight;
							$wrkdata = ResizeFileToBinary($imagefn, $wrkwidth, $wrkheight);
							return TempImage($wrkdata);
						} else {
							if (IsRemote($imagefn))
								return TempImage(file_get_contents($imagefn));
							else
								return $this->UploadPath . $wrkfile;
						}
					}
				} else {
					$tmpfiles = explode(MULTIPLE_UPLOAD_SEPARATOR, $wrkfile);
					$tmpimage = "";
					foreach ($tmpfiles as $tmpfile) {
						if ($tmpfile <> "") {
							$imagefn = $this->physicalUploadPath() . $tmpfile;
							if (!file_exists($imagefn))
								continue;
							if ($this->ImageResize) {
								$wrkwidth = $this->ImageWidth;
								$wrkheight = $this->ImageHeight;
								$wrkdata = ResizeFileToBinary($imagefn, $wrkwidth, $wrkheight);
								if ($tmpimage <> "")
									$tmpimage .= ",";
								$tmpimage .= TempImage($wrkdata);
							} else {
								if ($tmpimage <> "")
									$tmpimage .= ",";
								if (IsRemote($imagefn))
									$tmpimage .= TempImage(file_get_contents($imagefn));
								else
									$tmpimage .= $this->UploadPath . $tmpfile;
							}
						}
					}
					return $tmpimage;
				}
			}
		}
		return "";
	}

	// Form value
	public function setFormValue($v, $current = TRUE)
	{
		if (REMOVE_XSS && $this->DataType <> DATATYPE_XML)
			$v = RemoveXss($v);
		if (is_array($v))
			$v = implode(",", $v);
		if ($this->DataType == DATATYPE_NUMBER && !IsNumeric($v) && !EmptyValue($v)) // Check data type
			$this->FormValue = NULL;
		else
			$this->FormValue = $v;
		if ($current)
			$this->CurrentValue = $this->FormValue;
	}

	// Old value
	public function setOldValue($v)
	{
		if (is_array($v))
			$v = implode(",", $v);
		if ($this->DataType == DATATYPE_NUMBER && !IsNumeric($v) && !EmptyValue($v)) // Check data type
			$this->OldValue = NULL;
		else
			$this->OldValue = $v;
	}

	// QueryString value
	public function setQueryStringValue($v, $current = TRUE)
	{
		if (REMOVE_XSS)
			$v = RemoveXss($v);
		if (is_array($v))
			$v = implode(",", $v);
		if ($this->DataType == DATATYPE_NUMBER && !IsNumeric($v) && !EmptyValue($v)) // Check data type
			$this->QueryStringValue = NULL;
		else
			$this->QueryStringValue = $v;
		if ($current)
			$this->CurrentValue = $this->QueryStringValue;
	}

	// Database value
	public function setDbValue($v)
	{
		$this->DbValue = $v;
		if ($this->isEncrypt() && $v != NULL) {
			try {
				$v = PhpDecrypt($v, ENCRYPTION_KEY);
			} catch (\Defuse\Crypto\Exception\WrongKeyOrModifiedCiphertextException $e) {}
		}
		$this->CurrentValue = $v;
	}

	// Set database value with error default
	public function setDbValueDef(&$rs, $value, $default, $skip = FALSE)
	{
		if ($skip || !$this->Visible || $this->Disabled) {
			if (array_key_exists($this->Name, $rs))
				unset($rs[$this->Name]);
			return;
		}
		switch ($this->Type) {
			case 2:
			case 3:
			case 16:
			case 17:
			case 18: // Integer
				$value = trim($value);
				$value = ConvertToIntegerString($value);
				$dbValue = (is_numeric($value)) ? (int)$value : $default;
				break;
			case 19:
			case 20:
			case 21: // Big integer
				$value = trim($value);
				$value = ConvertToIntegerString($value);
				$dbValue = (is_numeric($value)) ? $value : $default;
				break;
			case 5:
			case 6:
			case 14:
			case 131: // Double
			case 139:
			case 4: // Single
				$value = trim($value);
				$value = ConvertToFloatString($value);
				$dbValue = (is_numeric($value)) ? $value : $default;
				break;
			case 7:
			case 133:
			case 134:
			case 135: // Date
			case 141: // XML
			case 145: // Time
			case 146: // DateTiemOffset
				$value = trim($value);
				$dbValue = ($value == "") ? $default : $value;
				break;
			case 201:
			case 203:
			case 129:
			case 130:
			case 200:
			case 202: // String
				$value = trim($value);
				$dbValue = ($value == "") ? $default : ($this->isEncrypt() ? PhpEncrypt($value, ENCRYPTION_KEY) : $value);
				break;
			case 128:
			case 204:
			case 205: // Binary
				$dbValue = ($value == NULL) ? $default : $value;
				break;
			case 72: // GUID
				$value = trim($value);
				$dbValue = ($value <> "" && CheckGuid($value)) ? $value : $default;
				break;
			case 11: // Boolean
				$dbValue = (is_bool($value) || is_numeric($value)) ? $value : $default;
				break;
			default:
				$dbValue = $value;
		}

		//$this->setDbValue($DbValue); // Do not override CurrentValue
		$this->OldValue = $this->DbValue; // Save old DbValue in OldValue
		$this->DbValue = $dbValue;
		$rs[$this->Name] = $this->DbValue;
	}

	// Get session value
	public function getSessionValue()
	{
		return @$_SESSION[PROJECT_NAME . "_" . $this->TableVar . "_" . $this->FieldVar . "_SessionValue"];
	}

	// Set session value
	public function setSessionValue($v)
	{
		$_SESSION[PROJECT_NAME . "_" . $this->TableVar . "_" . $this->FieldVar . "_SessionValue"] = $v;
	}
}

/**
 * Lookup class
 */
class Lookup
{
	public $LookupType = "";
	public $Options = NULL;
	public $Template = "";
	public $CurrentFilter = "";
	public $UserSelect = "";
	public $UserFilter = "";
	public $UserOrderBy = "";
	public $FilterValues = [];
	public $SearchValue = "";
	public $PageSize = -1;
	public $Offset = -1;
	public $ModalLookupSearchType = "";
	public $KeepCrLf = FALSE;
	public $LookupFilter = "";
	public $UseHtmlDecode = TRUE;
	public $Name = "";
	public $LinkTable = "";
	public $Distinct = FALSE;
	public $LinkField = "";
	public $DisplayFields = [];
	public $ParentFields = [];
	public $ChildFields = [];
	public $FilterFields = [];
	public $FilterFieldVars = [];
	public $AutoFillSourceFields = [];
	public $AutoFillTargetFields = [];
	public $Table = NULL;
	public $FormatAutoFill = FALSE;
	private $UseParentFilter = FALSE;

	/**
	 * Constructor for the Lookup class
	 *
	 * @param string $name
	 * @param string $linkTable
	 * @param bool $distinct
	 * @param string $linkField
	 * @param array $displayFields
	 * @param array $parentFields
	 * @param array $childFields
	 * @param array $filterFields
	 * @param array $filterFieldVars
	 * @param array $autoFillSourceFields
	 * @param array $autoFillTargetFields
	 * @param string $orderBy
	 * @param string $template
	 */
	public function __construct($name, $linkTable, $distinct, $linkField, $displayFields = [], $parentFields = [],
		$childFields = [], $filterFields = [], $filterFieldVars = [], $autoFillSourceFields = [], $autoFillTargetFields = [], $orderBy = "", $template = "")
	{
		$this->Name = $name;
		$this->LinkTable = $linkTable;
		$this->Distinct = $distinct;
		$this->LinkField = $linkField;
		$this->DisplayFields = $displayFields;
		$this->ParentFields = $parentFields;
		$this->ChildFields = $childFields;
		foreach ($filterFields as $filterField)
			$this->FilterFields[$filterField] = "="; // Default filter operator
		$this->FilterFieldVars = $filterFieldVars;
		$this->AutoFillSourceFields = $autoFillSourceFields;
		$this->AutoFillTargetFields = $autoFillTargetFields;
		$this->UserOrderBy = $orderBy;
		$this->Template = $template;
	}

	/**
	 * Get lookup SQL based on current filter/lookup filter, call Lookup_Selecting if necessary
	 *
	 * @param bool $useParentFilter
	 * @param string $currentFilter
	 * @param string|callable $lookupFilter
	 * @param object $page
	 * @return string
	 */
	public function getSql($useParentFilter = TRUE, $currentFilter = "", $lookupFilter = "", $page = NULL)
	{
		$this->UseParentFilter = $useParentFilter; // Save last call
		$this->CurrentFilter = $currentFilter;
		$this->LookupFilter = $lookupFilter; // Save last call
		if ($page !== NULL) {
			$this->setUserSql($useParentFilter);
			$fld = @$page->fields[$this->Name];
			if ($fld && method_exists($page, "Lookup_Selecting"))
				$page->Lookup_Selecting($fld, $this->UserFilter); // Call Lookup Selecting
			$this->resetUserSql($useParentFilter);
		}
		if ($lookupFilter <> "") // Add lookup filter as part of user filter
			AddFilter($this->UserFilter, $lookupFilter);
		return $this->getSqlPart("", TRUE, $useParentFilter);
	}

	/**
	 * Set options
	 *
	 * @param array $options Input options with formats:
	 *  1. Manual input data, e.g.: [ ["lv1", "dv", "dv2", "dv3", "dv4"], ["lv2", "dv", "dv2", "dv3", "dv4"], etc...]
	 *  2. Data from $rs->getRows(), e.g.: [ [0 => "lv1", "Field1" => "lv1", 1 => "dv", "Field2" => "dv2", ...], [0 => "lv2", "Field1" => "lv2", 1 => "dv", "Field2" => "dv2", ...], etc...]
	 * @return boolean Output array ["lv1" => [0 => "lv1", "lf" => "lv1", 1 => "dv", "df" => "dv", etc...], etc...]
	 */
	public function setOptions($options)
	{
		$opts = $this->formatOptions($options);
		if ($opts === NULL)
			return FALSE;
		$this->Options = $opts;
		return TRUE;
	}

	/**
	 * Set filter field operator
	 *
	 * @param string $name Filter field name
	 * @param string $opr Filter search operator
	 * @return void
	 */
	public function setFilterOperator($name, $opr)
	{
		if (array_key_exists($name, $this->FilterFields) && $this->isValidOperator($opr))
			$this->FilterFields[$name] = $opr;
	}

	/**
	 * Get user parameters hidden tag, if user SELECT/WHERE/ORDER BY clause is not empty
	 *
	 * @param string $var Variable name
	 * @return string
	 */
	public function getParamTag($var)
	{
		$page = isset($GLOBALS["Grid"]) ? $GLOBALS["Grid"] : CurrentPage();
		$this->getSql($this->UseParentFilter, $this->CurrentFilter, $this->LookupFilter, $page); // Call Lookup_Selecting again based on last setting
		$ar = [];
		if ($this->UserSelect <> "")
			$ar["s"] = Encrypt($this->UserSelect);
		if ($this->UserFilter <> "")
			$ar["f"] = Encrypt($this->UserFilter);
		if ($this->UserOrderBy <> "")
			$ar["o"] = Encrypt($this->UserOrderBy);
		if (count($ar) > 0)
			return '<input type="hidden" id="' . $var . '" name="' . $var . '" value="' . http_build_query($ar) . '">';
		return "";
	}

	/**
	 * Output client side list as JSON
	 *
	 * @return string
	 */
	public function toClientList()
	{
		$ar = [];
		$ar["linkTable"] = $this->LinkTable;
		$ar["linkField"] = $this->LinkField;
		$ar["ajax"] = $this->LinkTable <> "";
		$ar["autoFill"] = count($this->AutoFillSourceFields) > 0;
		$ar["distinct"] = $this->Distinct;
		$ar["displayFields"] = $this->DisplayFields;
		$ar["parentFields"] = $this->ParentFields;
		$ar["childFields"] = $this->ChildFields;
		$ar["filterFields"] = array_keys($this->FilterFields);
		$ar["filterFieldVars"] = $this->FilterFieldVars;
		$ar["filterOperators"] = array_values($this->FilterFields);
		$ar["autoFillSourceFields"] = $this->AutoFillSourceFields;
		$ar["autoFillTargetFields"] = $this->AutoFillTargetFields;
		$ar["options"] = [];
		$ar["template"] = $this->Template;
		return ArrayToJson($ar);
	}

	/**
	 * Execute SQL and write JSON response
	 *
	 * @return boolean
	 */
	public function toJson()
	{
		$tbl = $this->getTable();
		if ($tbl == NULL)
			return FALSE;
		$sql = $this->getSql();
		$orderBy = $this->UserOrderBy;
		$pageSize = $this->PageSize;
		$offset = $this->Offset;
		$rs = $this->getRecordset($sql, $orderBy, $pageSize, $offset);
		if ($pageSize > 0) {
			$totalCnt = $tbl->getRecordCount($sql);
		} else {
			$totalCnt = $rs ? $rs->RecordCount() : 0;
		}
		if ($rs) {
			$rowCnt = $rs->RecordCount();
			$fldCnt = $rs->FieldCount();
			$rsarr = $rs->getRows();
			$rs->close();

			// Clean output buffer
			if (ob_get_length())
				ob_clean();

			// Output
			if (is_array($rsarr) && $rowCnt > 0) {
				foreach ($rsarr as &$row) {
					for ($i = 1; $i < $fldCnt; $i++) {
						$str = ConvertToUtf8(strval($row[$i]));
						$str = str_replace(["\r", "\n", "\t"], $this->KeepCrLf ? ["\\r", "\\n", "\\t"] : [" ", " ", " "], $str);
						$row[$i] = $str;
						if (SameText($this->LookupType, "autofill")) {
							$autoFillSourceField = @$this->AutoFillSourceFields[$i - 1];
							$autoFillSourceField = @$tbl->fields[$autoFillSourceField];
							if ($autoFillSourceField)
								$autoFillSourceField->setDbValue($row[$i]);
						} else {
							$displayField = @$this->DisplayFields[$i - 1];
							$displayField = @$tbl->fields[$displayField];
							if ($displayField)
								$displayField->setDbValue($row[$i]);
						}
					}
					if (SameText($this->LookupType, "autofill")) {
						if ($this->FormatAutoFill) { // Format auto fill
							$tbl->RowType = ROWTYPE_EDIT;
							$tbl->renderEditRow();
							for ($i = 0; $i < $fldCnt; $i++) {
								$autoFillSourceField = @$this->AutoFillSourceFields[$i];
								$autoFillSourceField = @$tbl->fields[$autoFillSourceField];
								if ($autoFillSourceField)
									$row["af" . $i] = $autoFillSourceField->AutoFillOriginalValue ? $autoFillSourceField->CurrentValue : ((is_array($autoFillSourceField->EditValue) || $autoFillSourceField->EditValue === NULL) ? $autoFillSourceField->CurrentValue : $autoFillSourceField->EditValue);
							}
						}
					} elseif ($this->LookupType <> "unknown") { // Format display fields for known lookup type
						$tbl->RowType = ROWTYPE_VIEW;
						$tbl->renderListRow();
						for ($i = 1; $i < $fldCnt; $i++) {
							$displayField = @$this->DisplayFields[$i - 1];
							$displayField = @$tbl->fields[$displayField];
							if ($displayField) {
								$sfx = $i > 1 ? $i : "";
								if ($displayField->Lookup || $displayField->HtmlTag == "FILE")
									$row[$i] = $displayField->CurrentValue;
								else
									$row[$i] = $displayField->ViewValue;
								$row["df" . $sfx] = $row[$i];
							}
						}
					}
					if (REMOVE_XSS && $this->UseHtmlDecode) {
						foreach ($row as $key => &$value)
							$row[$key] = HtmlDecode($value);
					}
				}
			}
			$result = ["result" => "OK", "records" => $rsarr, "totalRecordCount" => $totalCnt];
			if (DEBUG_ENABLED)
				$result["sql"] = $sql;
			WriteJson($result);
			return TRUE;
		}
		return FALSE;
	}

	/**
	 * Check if filter operator is valid
	 *
	 * @param string $opr Operator, e.g. '<', '>'
	 * @return boolean
	 */
	protected function isValidOperator($opr)
	{
		return in_array($opr, ['=', '<>', '<', '<=', '>', '>=']);
	}

	/**
	 * Get part of lookup SQL
	 *
	 * @param string $part Part of the SQL (select|where|orderby|"")
	 * @param bool $isUser Whether the CurrentFilter, UserFilter and UserSelect proeprties should be used
	 * @param bool $useParentFilter Use parent filter
	 * @return string Part of (or full if $part is empty) SQL
	 */
	protected function getSqlPart($part = "", $isUser = TRUE, $useParentFilter = TRUE)
	{
		$tbl = $this->getTable();
		if ($tbl == NULL)
			return "";

		// Set up SELECT ... FROM ...
		$dbid = $tbl->Dbid;
		$select = "SELECT";
		if ($this->Distinct)
			$select .= " DISTINCT";

		// Set up link field
		$linkField = @$tbl->fields[$this->LinkField];
		if (!$linkField)
			return "";
		$select .= " " . $linkField->Expression;
		if ($this->LookupType <> "unknown") // Known lookup types
			$select .= " AS " . QuotedName("lf", $dbid);

		// Set up lookup fields
		$lookupCnt = 0;
		if (SameText($this->LookupType, "autofill")) {
			if (is_array($this->AutoFillSourceFields)) {
				foreach ($this->AutoFillSourceFields as $i => $autoFillSourceField) {
					$autoFillSourceField = @$tbl->fields[$autoFillSourceField];
					if (!$autoFillSourceField)
						$select .= ", '' AS " . QuotedName("af" . $i, $dbid);
					else
						$select .= ", " . $autoFillSourceField->Expression . " AS " . QuotedName("af" . $i, $dbid);
					if (!$autoFillSourceField->AutoFillOriginalValue)
						$this->FormatAutoFill = TRUE;
					$lookupCnt++;
				}
			}
		} else {
			if (is_array($this->DisplayFields)) {
				foreach ($this->DisplayFields as $i => $displayField) {
					$displayField = @$tbl->fields[$displayField];
					if (!$displayField) {
						$select .= ", '' AS " . QuotedName("df" . (($i == 0) ? "" : $i + 1), $dbid);
					} else {
						$select .= ", " . $displayField->Expression;
						if ($this->LookupType <> "unknown") // Known lookup types
							$select .= " AS " . QuotedName("df" . (($i == 0) ? "" : $i + 1), $dbid);
					}
					$lookupCnt++;
				}
			}
			if (is_array($this->FilterFields) && !$useParentFilter) {
				$i = 0;
				foreach ($this->FilterFields as $filterField => $filterOpr) {
					$filterField = @$tbl->fields[$filterField];
					if (!$filterField) {
						$select .= ", '' AS " . QuotedName("ff" . (($i == 0) ? "" : $i + 1), $dbid);
					} else {
						$select .= ", " . $filterField->Expression;
						if ($this->LookupType <> "unknown") // Known lookup types
							$select .= " AS " . QuotedName("ff" . (($i == 0) ? "" : $i + 1), $dbid);
					}
					$i++;
					$lookupCnt++;
				}
			}
		}
		if ($lookupCnt == 0)
			return "";
		$select .= " FROM " . $tbl->getSqlFrom();

		// User SELECT
		if ($this->UserSelect <> "" && $isUser)
			$select = $this->UserSelect;

		// Set up WHERE
		$where = "";

		// Set up user id filter
		if (method_exists($tbl, "applyUserIDFilters"))
			$where = $tbl->applyUserIDFilters($where);

		// Set up current filter
		$cnt = count($this->FilterValues);
		if ($cnt > 0) {
			$val = $this->FilterValues[0];
			if ($val <> "") {
				$val = strval($val);
				AddFilter($where, $this->getFilter($linkField, "=", $val, $tbl->Dbid));
			}

			// Set up parent filters
			if (is_array($this->FilterFields) && $useParentFilter) {
				$i = 1;
				foreach ($this->FilterFields as $filterField => $filterOpr) {
					if ($filterField <> "") {
						$filterField = @$tbl->fields[$filterField];
						if (!$filterField)
							return "";
						if ($cnt <= $i) {
							AddFilter($where, "1=0"); // Disallow
						} else {
							$val = strval($this->FilterValues[$i]);
							AddFilter($where, $this->getFilter($filterField, $filterOpr, $val, $tbl->Dbid));
						}
					}
					$i++;
				}
			}
		}

		// Set up search
		if ($this->SearchValue <> "") {

			// Set up modal lookup search
			if (SameText($this->LookupType, "modal")) {
				$flds = [];
				foreach ($this->DisplayFields as $displayField) {
					if ($displayField <> "") {
						$displayField = $tbl->fields[$displayField];
						$flds[] = $displayField->Expression;
					}
				}
				AddFilter($where, $this->getModalSearchFilter($this->SearchValue, $flds));
			} elseif (SameText($this->LookupType, "autosuggest")) {
				if (AUTO_SUGGEST_FOR_ALL_FIELDS) {
					$filter = "";
					foreach ($this->DisplayFields as $displayField) {
						if ($displayField <> "") {
							$displayField = $tbl->fields[$displayField];
							if ($filter <> "")
								$filter .= " OR ";
							$filter .= $this->getAutoSuggestFilter($this->SearchValue, $displayField);
						}
					}
					AddFilter($where, $filter);
				} else {
					$displayField = $tbl->fields[$this->DisplayFields[0]];
					AddFilter($where, $this->getAutoSuggestFilter($this->SearchValue, $displayField));
				}
			}
		}

		// Add filters
		if ($this->CurrentFilter <> "" && $isUser)
			AddFilter($where, $this->CurrentFilter);

		// User Filter
		if ($this->UserFilter <> "" && $isUser)
			AddFilter($where, $this->UserFilter);

		// Set up ORDER BY
		$orderBy = $this->UserOrderBy;

		// Return SQL part
		if ($part == "select") {
			return $select;
		} elseif ($part == "where") {
			return $where;
		} elseif ($part == "orderby") {
			return $orderBy;
		} else {
			$sql = $select;
			$dbType = GetConnectionType($tbl->Dbid);
			if ($where <> "")
				$sql .= " WHERE " . $where;
			if ($orderBy <> "")
				if ($dbType == "MSSQL")
					$sql .= " /*BeginOrderBy*/ORDER BY " . $orderBy . "/*EndOrderBy*/";
				else
					$sql .= " ORDER BY " . $orderBy;
			return $sql;
		}
	}

	/**
	 * Get filter
	 *
	 * @param object $fld Field Object
	 * @param string $opr Search Operator
	 * @param string $val Search Value
	 * @param string $dbid Database Id
	 * @return string Search Filter (SQL WHERE part)
	 */
	protected function getFilter($fld, $opr, $val, $dbid)
	{
		$validValue = $val <> "";
		$where = "";
		$arVal = explode(LOOKUP_FILTER_VALUE_SEPARATOR, $val);
		if ($fld->DataType == DATATYPE_NUMBER) { // Validate numeric fields
			foreach ($arVal as $val) {
				if (!is_numeric($val))
					$validValue = FALSE;
			}
		}
		if ($validValue) {
			if ($opr == "=") { // Use the IN operator
				foreach ($arVal as &$val)
					$val = QuotedValue($val, $fld->DataType, $dbid);
				$where = $fld->Expression . " IN (" . implode(", ", $arVal) . ")";
			} else { // Custom operator
				foreach ($arVal as $val)
					AddFilter($where, $fld->Expression . $opr . QuotedValue($val, $fld->DataType, $dbid));
			}
		} else {
			$where = "1=0"; // Disallow
		}
		return $where;
	}

	/**
	 * Set up UserSelect/UserFilter
	 *
	 * @return void
	 */
	protected function setUserSql($useParentFilter = FALSE)
	{
		$this->UserSelect = $this->getSqlPart("select", FALSE, $useParentFilter);
		$this->UserFilter = $this->getSqlPart("where", FALSE, $useParentFilter);
	}

	/**
	 * Reset UserSelect/UserFilter if not changed
	 *
	 * @return void
	 */
	protected function resetUserSql($useParentFilter = FALSE)
	{
		if ($this->UserSelect == $this->getSqlPart("select", FALSE, $useParentFilter))
			$this->UserSelect = "";
		if ($this->UserFilter == $this->getSqlPart("where", FALSE, $useParentFilter))
			$this->UserFilter = "";
	}

	/**
	 * Get table object
	 *
	 * @return object
	 */
	protected function getTable()
	{
		if ($this->LinkTable == "")
			return NULL;
		if ($this->Table == NULL) {
			$class = PROJECT_NAMESPACE . $this->LinkTable;
			$this->Table = new $class();
		}
		return $this->Table;
	}

	/**
	 * Get recordset
	 *
	 * @param string $sql SQL to be executed
	 * @param string $orderBy ORDER BY clause
	 * @param integer $pageSize
	 * @param integer $offset
	 * @return object
	 */
	protected function getRecordset($sql, $orderBy, $pageSize, $offset)
	{
		$tbl = $this->getTable();
		if ($tbl == NULL)
			return NULL;
		$conn = &$tbl->getConnection();
		if ($pageSize > 0) {
			$dbType = GetConnectionType($tbl->Dbid);
			if ($dbType == "MSSQL")
				$rs = $conn->selectLimit($sql, $pageSize, $offset, ["_hasOrderBy" => $orderBy <> ""]);
			else
				$rs = $conn->selectLimit($sql, $pageSize, $offset);
		} else {
			$rs = $conn->execute($sql);
		}
		return $rs;
	}

	/**
	 * Get auto suggest filter
	 *
	 * @param string $sv Search value
	 * @param object $fld Field object
	 * @return string
	 */
	protected function getAutoSuggestFilter($sv, $fld)
	{
		if (AUTO_SUGGEST_FOR_ALL_FIELDS)
			return $this->getCastFieldForLike($fld) . Like(QuotedValue("%" . $sv . "%", DATATYPE_STRING, $this->Table->Dbid));
		else
			return $this->getCastFieldForLike($fld) . Like(QuotedValue($sv . "%", DATATYPE_STRING, $this->Table->Dbid));
	}

	/**
	 * Get Cast SQL for LIKE operator
	 *
	 * @param object $fld Field object
	 * @return string
	 */
	protected function getCastFieldForLike($fld)
	{
		$expr = $fld->Expression;

		// Date/Time field
		if ($fld->DataType == DATATYPE_DATE || $fld->DataType == DATATYPE_TIME)
			return CastDateFieldForLike($expr, $fld->DateTimeFormat, $this->Table->Dbid);
		$dbType = GetConnectionType($this->Table->Dbid);
		if ($fld->DataType == DATATYPE_NUMBER && $dbType == "MSSQL")
			return "CAST(" . $expr . " AS NVARCHAR)";
		if ($fld->DataType != DATATYPE_STRING && $dbType == "POSTGRESQL")
			return "CAST(" . $expr . " AS varchar(255))";
		return $expr;
	}

	/**
	 * Get modal search filter
	 *
	 * @param string $sv Search value
	 * @param array $flds Field expressions
	 * @return string
	 */
	protected function getModalSearchFilter($sv, $flds)
	{
		if (EmptyString($sv))
			return "";
		$searchStr = "";
		$search = trim($sv);
		$searchType = $this->ModalLookupSearchType;
		if ($searchType <> "=") {
			$ar = [];

			// Match quoted keywords (i.e.: "...")
			if (preg_match_all('/"([^"]*)"/i', $search, $matches, PREG_SET_ORDER)) {
				foreach ($matches as $match) {
					$p = strpos($search, $match[0]);
					$str = substr($search, 0, $p);
					$search = substr($search, $p + strlen($match[0]));
					if (strlen(trim($str)) > 0)
						$ar = array_merge($ar, explode(" ", trim($str)));
					$ar[] = $match[1]; // Save quoted keyword
				}
			}

			// Match individual keywords
			if (strlen(trim($search)) > 0)
				$ar = array_merge($ar, explode(" ", trim($search)));

			// Search keyword in any fields
			if ($searchType == "OR" || $searchType == "AND") {
				foreach ($ar as $keyword) {
					if ($keyword <> "") {
						$searchFilter = $this->getModalSearchSql([$keyword], $flds);
						if ($searchFilter <> "") {
							if ($searchStr <> "")
								$searchStr .= " " . $searchType . " ";
							$searchStr .= "(" . $searchFilter . ")";
						}
					}
				}
			} else {
				$searchStr = $this->getModalSearchSql($ar, $flds);
			}
		} else {
			$searchStr = $this->getModalSearchSql([$search], $flds);
		}
		return $searchStr;
	}

	/**
	 * Get modal search SQL
	 *
	 * @param array $keywords Keywords
	 * @param array $flds Field expressions
	 * @return string
	 */
	protected function getModalSearchSql($keywords, $flds)
	{
		$where = "";
		if (is_array($flds)) {
			foreach ($flds as $fldExpr) {
				if ($fldExpr <> "")
					$this->buildModalSearchSql($where, $fldExpr, $keywords);
			}
		}
		return $where;
	}

	/**
	 * Build and set up modal search SQL
	 *
	 * @param string &$where WHERE clause
	 * @param string $fldExpr Field expression
	 * @param array $keywords Keywords
	 * @return void
	 */
	protected function buildModalSearchSql(&$where, $fldExpr, $keywords)
	{
		global $BASIC_SEARCH_IGNORE_PATTERN;
		$searchType = $this->ModalLookupSearchType;
		$defCond = ($searchType == "OR") ? "OR" : "AND";
		$arSql = []; // Array for SQL parts
		$arCond = []; // Array for search conditions
		$cnt = count($keywords);
		$j = 0; // Number of SQL parts
		for ($i = 0; $i < $cnt; $i++) {
			$keyword = $keywords[$i];
			$keyword = trim($keyword);
			if ($BASIC_SEARCH_IGNORE_PATTERN <> "") {
				$keyword = preg_replace($BASIC_SEARCH_IGNORE_PATTERN, "\\", $keyword);
				$arwrk = explode("\\", $keyword);
			} else {
				$arwrk = [$keyword];
			}
			foreach ($arwrk as $keyword) {
				if ($keyword <> "") {
					$wrk = "";
					if ($keyword == "OR" && $searchType == "") {
						if ($j > 0)
							$arCond[$j-1] = "OR";
					} else {
						$wrk = $fldExpr . Like(QuotedValue("%" . $keyword . "%", DATATYPE_STRING, $this->Table->Dbid), $this->Table->Dbid);
					}
					if ($wrk <> "") {
						$arSql[$j] = $wrk;
						$arCond[$j] = $defCond;
						$j += 1;
					}
				}
			}
		}
		$cnt = count($arSql);
		$quoted = FALSE;
		$sql = "";
		if ($cnt > 0) {
			for ($i = 0; $i < $cnt-1; $i++) {
				if ($arCond[$i] == "OR") {
					if (!$quoted)
						$sql .= "(";
					$quoted = TRUE;
				}
				$sql .= $arSql[$i];
				if ($quoted && $arCond[$i] <> "OR") {
					$sql .= ")";
					$quoted = FALSE;
				}
				$sql .= " " . $arCond[$i] . " ";
			}
			$sql .= $arSql[$cnt-1];
			if ($quoted)
				$sql .= ")";
		}
		if ($sql <> "") {
			if ($where <> "")
				$where .= " OR ";
			$where .= "(" . $sql . ")";
		}
	}

	/**
	 * Format options
	 *
	 * @param array $options Input options with formats:
	 *  1. Manual input data, e.g.: [ ["lv1", "dv", "dv2", "dv3", "dv4"], ["lv2", "dv", "dv2", "dv3", "dv4"], etc...]
	 *  2. Data from $rs->getRows(), e.g.: [ [0 => "lv1", "Field1" => "lv1", 1 => "dv", "Field2" => "dv2", ...], [0 => "lv2", "Field1" => "lv2", 1 => "dv", "Field2" => "dv2", ...], etc...]
	 * @return array ["lv1" => [0 => "lv1", "lf" => "lv1", 1 => "dv", "df" => "dv", etc...], etc...]
	 */
	protected function formatOptions($options)
	{
		if (!is_array($options))
			return NULL;
		$keys = [0, 1, 2, 3, 4, 5, 6, 7, 8];
		$keys2 = ["lf", "df", "df2", "df3", "df4", "ff", "ff2", "ff3", "ff4"];
		$opts = [];
		$cnt = count($keys);

		// Check values and remove non-numeric keys
		foreach ($options as &$ar) {
			if (is_array($ar)) {

				// Remove non-numeric keys first
				$ar = array_intersect_key($ar, array_flip(array_filter(array_keys($ar), 'is_numeric')));
				if ($cnt > count($ar))
					$cnt = count($ar);
			}
		}

		// Set up options
		if ($cnt >= 2) {
			$keys = array_splice($keys, 0, $cnt);
			$keys2 = array_splice($keys2, 0, $cnt);
			foreach ($options as &$ar) {
				if (is_array($ar)) {
					$ar = array_splice($ar, 0, $cnt);
					$ar = array_merge(array_combine($keys, $ar), array_combine($keys2, $ar)); // Set keys
					$lv = $ar[0]; // First value as link value
					$opts[$lv] = $ar;
				}
			}
		} else {
			return NULL;
		}
		return $opts;
	}
}

/**
 * List option collection class
 */
class ListOptions
{
	public $Items = [];
	public $CustomItem = "";
	public $Tag = "td";
	public $TagClassName = "";
	public $TableVar = "";
	public $RowCnt = "";
	public $ScriptType = "block";
	public $ScriptId = "";
	public $ScriptClassName = "";
	public $JavaScript = "";
	public $RowSpan = 1;
	public $UseDropDownButton = FALSE;
	public $UseButtonGroup = FALSE;
	public $ButtonClass = "";
	public $GroupOptionName = "button";
	public $DropDownButtonPhrase = "";

	// Check visible
	public function visible()
	{
		foreach ($this->Items as $item) {
			if ($item->Visible)
				return TRUE;
		}
		return FALSE;
	}

	// Check group option visible
	public function groupOptionVisible()
	{
		$cnt = 0;
		foreach ($this->Items as $item) {
			if ($item->Name <> $this->GroupOptionName &&
				($item->Visible && $item->ShowInDropDown && $this->UseDropDownButton ||
				$item->Visible && $item->ShowInButtonGroup && $this->UseButtonGroup)) {
				$cnt += 1;
				if ($this->UseDropDownButton && $cnt > 1)
					return TRUE;
				elseif ($this->UseButtonGroup)
					return TRUE;
			}
		}
		return FALSE;
	}

	// Add and return a new option
	public function &add($name)
	{
		$item = new ListOption($name);
		$item->Parent = &$this;
		$this->Items[$name] = $item;
		return $item;
	}

	// Load default settings
	public function loadDefault()
	{
		$this->CustomItem = "";
		foreach ($this->Items as $key => $item)
			$this->Items[$key]->Body = "";
	}

	// Hide all options
	public function hideAllOptions($lists = [])
	{
		foreach ($this->Items as $key => $item)
			if (!in_array($key, $lists))
				$this->Items[$key]->Visible = FALSE;
	}

	// Show all options
	public function showAllOptions()
	{
		foreach ($this->Items as $key => $item)
			$this->Items[$key]->Visible = TRUE;
	}

	/**
	 * Get item by name
	 *
	 * @param string $name Predefined names: view/edit/copy/delete/detail_<DetailTable>/userpermission/checkbox
	 * @return void
	 */
	public function &getItem($name)
	{
		$item = array_key_exists($name, $this->Items) ? $this->Items[$name] : NULL;
		return $item;
	}

	// Get item position
	public function itemPos($name)
	{
		$pos = 0;
		foreach ($this->Items as $item) {
			if ($item->Name == $name)
				return $pos;
			$pos++;
		}
		return FALSE;
	}

	// Move item to position
	public function moveItem($name, $pos)
	{
		$cnt = count($this->Items);
		if ($pos < 0) // If negative, count from the end
			$pos = $cnt + $pos;
		if ($pos < 0)
			$pos = 0;
		if ($pos >= $cnt)
			$pos = $cnt - 1;
		$item = &$this->getItem($name);
		if ($item) {
			unset($this->Items[$name]);
			$this->Items = array_merge(array_slice($this->Items, 0, $pos),
				[$name => $item], array_slice($this->Items, $pos));
		}
	}

	// Render list options
	public function render($part, $pos="", $rowCnt="", $scriptType="block", $scriptId="", $scriptClassName="")
	{
		if ($this->CustomItem == "" && $groupitem = &$this->getItem($this->GroupOptionName) && $this->showPos($groupitem->OnLeft, $pos)) {
			if ($this->UseDropDownButton) { // Render dropdown
				$buttonValue = "";
				$cnt = 0;
				foreach ($this->Items as $item) {
					if ($item->Name <> $this->GroupOptionName && $item->Visible) {
						if ($item->ShowInDropDown) {
							$buttonValue .= $item->Body;
							$cnt += 1;
						} elseif ($item->Name == "listactions") { // Show listactions as button group
							$item->Body = $this->renderButtonGroup($item->Body);
						}
					}
				}
				if ($cnt < 1 || $cnt == 1 && !ContainsString($buttonValue, "dropdown-menu")) { // No item to show in dropdown or only one item without dropdown menu 
					$this->UseDropDownButton = FALSE; // No need to use drop down button
				} else {
					$groupitem->Body = $this->renderDropDownButton($buttonValue, $pos);
					$groupitem->Visible = TRUE;
				}
			}
			if (!$this->UseDropDownButton && $this->UseButtonGroup) { // Render button group
				$visible = FALSE;
				$buttongroups = [];
				foreach ($this->Items as $item) {
					if ($item->Name <> $this->GroupOptionName && $item->Visible && $item->Body <> "") {
						if ($item->ShowInButtonGroup) {
							$visible = TRUE;
							$buttonValue = $item->Body;
							if (!array_key_exists($item->ButtonGroupName, $buttongroups))
								$buttongroups[$item->ButtonGroupName] = "";
							$buttongroups[$item->ButtonGroupName] .= $buttonValue;
						} elseif ($item->Name == "listactions") { // Show listactions as button group
							$item->Body = $this->renderButtonGroup($item->Body);
						}
					}
				}
				$groupitem->Body = "";
				foreach ($buttongroups as $buttongroup => $buttonValue)
					$groupitem->Body .= $this->renderButtonGroup($buttonValue);
				if ($visible)
					$groupitem->Visible = TRUE;
			}
		}
		if ($scriptId <> "") {
			$this->write($part, $pos, $rowCnt, "block", $scriptId, $scriptClassName); // Original block for ew.showTemplates
			$this->write($part, $pos, $rowCnt, "blocknotd", $scriptId);
			$this->write($part, $pos, $rowCnt, "single", $scriptId);
		} else {
			$this->write($part, $pos, $rowCnt, $scriptType, $scriptId, $scriptClassName);
		}
	}

	// Get custom template script tag
	protected function customScriptTag($scriptId, $scriptType, $scriptClass, $rowCnt="")
	{
		$id = "_" . $scriptId;
		if (!EmptyString($rowCnt))
			$id = $rowCnt . $id;
		$id = "tp" . $scriptType . $id;
		return "<script id=\"" . $id . "\"" . (!EmptyString($scriptClass) ? " class=\"" . $scriptClass . "\"" : "") . " type=\"text/html\">";
	}

	// Write list options
	protected function write($part, $pos="", $rowCnt="", $scriptType="block", $scriptId="", $scriptClass="")
	{
		$this->RowCnt = $rowCnt;
		$this->ScriptType = $scriptType;
		$this->ScriptId = $scriptId;
		$this->ScriptClassName = $scriptClass;
		$this->JavaScript = "";
		if ($scriptId <> "") {
			$this->Tag = ($scriptType == "block") ? "td" : "span";
			if ($scriptType == "block") {
				if ($part == "header")
					echo $this->customScriptTag($scriptId, "oh", $scriptClass);
				else if ($part == "body")
					echo $this->customScriptTag($scriptId, "ob", $scriptClass, $rowCnt);
				else if ($part == "footer")
					echo $this->customScriptTag($scriptId, "of", $scriptClass);
			} elseif ($scriptType == "blocknotd") {
				if ($part == "header")
					echo $this->customScriptTag($scriptId, "o2h", $scriptClass);
				else if ($part == "body")
					echo $this->customScriptTag($scriptId, "o2b", $scriptClass, $rowCnt);
				else if ($part == "footer")
					echo $this->customScriptTag($scriptId, "o2f", $scriptClass);
				echo "<span>";
			}
		} else {

			//$this->Tag = ($Pos <> "" && $Pos <> "bottom") ? "td" : "span";
			$this->Tag = ($pos <> "" && $pos <> "bottom") ? "td" : "div";
		}
		if ($this->CustomItem <> "") {
			$cnt = 0;
			$opt = NULL;
			foreach ($this->Items as &$item) {
				if ($this->showItem($item, $scriptId, $pos))
					$cnt++;
				if ($item->Name == $this->CustomItem)
					$opt = &$item;
			}
			$useButtonGroup = $this->UseButtonGroup; // Backup options
			$this->UseButtonGroup = TRUE; // Show button group for custom item
			if (is_object($opt) && $cnt > 0) {
				if ($scriptId <> "" || $this->showPos($opt->OnLeft, $pos)) {
					echo $opt->render($part, $cnt);
				} else {
					echo $opt->render("", $cnt);
				}
			}
			$this->UseButtonGroup = $useButtonGroup; // Restore options
		} else {
			foreach ($this->Items as &$item) {
				if ($this->showItem($item, $scriptId, $pos))
					echo $item->render($part, 1);
			}
		}
		if (($scriptType == "block" || $scriptType == "blocknotd") && $scriptId <> "") {
			if ($scriptType == "blocknotd")
				echo "</span>";
			echo "</script>";
			if ($this->JavaScript <> "")
				echo $this->JavaScript;
		}
	}

	// Show item
	protected function showItem($item, $scriptId, $pos)
	{
		$show = $item->Visible && $this->showPos($item->OnLeft, $pos);
		if ($show)
			if ($this->UseDropDownButton)
				$show = ($item->Name == $this->GroupOptionName || !$item->ShowInDropDown);
			elseif ($this->UseButtonGroup)
				$show = ($item->Name == $this->GroupOptionName || !$item->ShowInButtonGroup);
		return $show;
	}

	// Show position
	protected function showPos($onLeft, $pos)
	{
		return $onLeft && $pos == "left" || !$onLeft && $pos == "right" || $pos == "" || $pos == "bottom";
	}

	/**
	 * Concat options and return concatenated HTML
	 *
	 * @param string $pattern Regular expression pattern for matching the option names, e.g. '/^detail_/'
	 * @param string $separator optional Separator
	 * @return string
	 */
	public function concat($pattern, $separator = "")
	{
		$ar = [];
		$keys = array_keys($this->Items);
		foreach ($keys as $key) {
			if (preg_match($pattern, $key) && trim($this->Items[$key]->Body) <> "")
				$ar[] = $this->Items[$key]->Body;
		}
		return implode($separator, $ar);
	}

	/**
	 * Merge options to the first option and return it
	 *
	 * @param string $pattern Regular expression pattern for matching the option names, e.g. '/^detail_/'
	 * @param string $separator optional Separator
	 * @return string
	 */
	public function &merge($pattern, $separator = "")
	{
		$keys = array_keys($this->Items);
		$first = NULL;
		foreach ($keys as $key) {
			if (preg_match($pattern, $key)) {
				if (!$first) {
					$first = $this->Items[$key];
					$first->Body = $this->concat($pattern, $separator);
				} else {
					$this->Items[$key]->Visible = FALSE;
				}
			}
		}
		return $first;
	}

	// Get button group link
	public function renderButtonGroup($body)
	{

		// Get all hidden inputs
		// format: <input type="hidden" ...>

		$inputs = [];
		if (preg_match_all('/<input\s+([^>]*)>/i', $body, $inputmatches, PREG_SET_ORDER)) {
			foreach ($inputmatches as $inputmatch) {
				$body = str_replace($inputmatch[0], '', $body);
				if (preg_match('/\s+type\s*=\s*[\'"]hidden[\'"]/i', $inputmatch[0])) // Match type='hidden'
					$inputs[] = $inputmatch[0];
			}
		}

		// Get all buttons
		// format: <div class="btn-group ...">...</div>

		$btns = [];
		if (preg_match_all('/<div\s+class\s*=\s*[\'"]btn-group([^\'"]*)[\'"]([^>]*)>([\s\S]*?)<\/div\s*>/i', $body, $btnmatches, PREG_SET_ORDER)) {
			foreach ($btnmatches as $btnmatch) {
				$body = str_replace($btnmatch[0], '', $body);
				$btns[] = $btnmatch[0];
			}
		}
		$links = '';

		// Get all links/buttons
		// format: <a ...>...</a> / <button ...>...</button>

		if (preg_match_all('/<(a|button)([^>]*)>([\s\S]*?)<\/(a|button)\s*>/i', $body, $matches, PREG_SET_ORDER)) {
			foreach ($matches as $match) {
				$tag = $match[1];
				if (preg_match('/\s+class\s*=\s*[\'"]([\s\S]*?)[\'"]/i', $match[2], $submatches)) { // Match class='class'
					$class = $submatches[1];
					$attrs = str_replace($submatches[0], '', $match[2]);
				} else {
					$class = '';
					$attrs = $match[2];
				}
				$caption = $match[3];
				PrependClass($class, 'btn btn-default'); // Prepend button classes
				if ($this->ButtonClass <> "")
					AppendClass($class, $this->ButtonClass);
				$attrs = ' class="' . $class . '" ' . $attrs;
 				$link ='<' . $tag . $attrs . '>' . $caption . '</' . $tag . '>';
				$links .= $link;
			}
		}
		if ($links <> "")
			$btngroup = '<div class="btn-group btn-group-sm ew-btn-group">' . $links . '</div>';
		else
			$btngroup = "";
		foreach ($btns as $btn)
			$btngroup .= $btn;
		foreach ($inputs as $input)
			$btngroup .= $input;
		return $btngroup;
	}

	// Render drop down button
	public function renderDropDownButton($body, $pos)
	{

		// Get all hidden inputs
		// format: <input type="hidden" ...>

		$inputs = [];
		if (preg_match_all('/<input\s+([^>]*)>/i', $body, $inputmatches, PREG_SET_ORDER)) {
			foreach ($inputmatches as $inputmatch) {
				$body = str_replace($inputmatch[0], '', $body);
				if (preg_match('/\s+type\s*=\s*[\'"]hidden[\'"]/i', $inputmatch[0])) // Match type='hidden'
					$inputs[] = $inputmatch[0];
			}
		}

		// Remove all <div class="d-none ew-preview">...</div>
		$previewlinks = "";
		if (preg_match_all('/<div\s+class\s*=\s*[\'"]d-none\s+ew-preview[\'"]>([\s\S]*?)(<div([^>]*)>([\s\S]*?)<\/div\s*>)+([\s\S]*?)<\/div\s*>/i', $body, $inputmatches, PREG_SET_ORDER)) {
			foreach ($inputmatches as $inputmatch) {
				$body = str_replace($inputmatch[0], '', $body);
				$previewlinks .= $inputmatch[0];
			}
		}

		// Remove toggle button first <button ... data-toggle="dropdown">...</button>
		if (preg_match_all('/<button\s+([\s\S]*?)data-toggle\s*=\s*[\'"]dropdown[\'"]\s*>([\s\S]*?)<\/button\s*>/i', $body, $btnmatches, PREG_SET_ORDER)) {
			foreach ($btnmatches as $btnmatch)
				$body = str_replace($btnmatch[0], '', $body);
		}

		// Get all links/buttons <a ...>...</a> / <button ...>...</button>
		if (!preg_match_all('/<(a|button)([^>]*)>([\s\S]*?)<\/(a|button)\s*>/i', $body, $matches, PREG_SET_ORDER))
			return '';
		$links = '';
		$submenu = FALSE;
		$submenulink = "";
		$submenulinks = "";
		foreach ($matches as $match) {
			$tag = $match[1];
			if (preg_match('/\s+data-action\s*=\s*[\'"]([\s\S]*?)[\'"]/i', $match[2], $submatches)) { // Match data-action='action'
				$action = $submatches[1];
			} else {
				$action = '';
			}
			if (preg_match('/\s+class\s*=\s*[\'"]([\s\S]*?)[\'"]/i', $match[2], $submatches)) { // Match class='class'
				$classes = preg_replace('/btn[\S]*\s+/i', '', $submatches[1]);
				$attrs = str_replace($submatches[0], '', $match[2]);
			} else {
				$classes = '';
				$attrs = $match[2];
			}
			$attrs = preg_replace('/\s+title\s*=\s*[\'"]([\s\S]*?)[\'"]/i', '', $attrs); // Remove title='title'
			if (preg_match('/\s+data-caption\s*=\s*[\'"]([\s\S]*?)[\'"]/i', $attrs, $submatches)) // Match data-caption='caption'
				$caption = $submatches[1];
			else
				$caption = '';
			AppendClass($classes, "dropdown-item");
			$attrs = ' class="' . $classes . '" ' . $attrs;
			if (SameText($tag, "button")) // Add href for button
				$attrs .= ' href="javascript:void(0);"';
			if ($caption <> '' && // Has caption
				preg_match('/<i([^>]*)>([\s\S]*?)<\/i\s*>/i', $match[3], $submatches) && // Inner HTML contains <i> tag
				preg_match('/\s+class\s*=\s*[\'"]([\s\S]*?)[\'"]/i', $submatches[1], $subsubmatches) && // The <i> tag has 'class' attribute
				preg_match('/\bew-icon\b/', $subsubmatches[1])) { // The classes contains 'ew-icon' => icon
				$classes = $subsubmatches[1];
				AppendClass($classes, 'mr-2'); // Add margin-right
				$caption = str_replace($subsubmatches[1], $classes, $submatches[0]) . $caption;
			}
			if ($caption == '')
				$caption = $match[3];
			$link = '<a' . $attrs . '>' . $caption . '</a>';
			if ($action == 'list') { // Start new submenu
				if ($submenu) { // End previous submenu
					if ($submenulinks <> '') { // Set up submenu
						$links .= '<li class="dropdown-submenu">' . $submenulink . '<ul class="dropdown-menu">' . $submenulinks . '</ul></li>';
					} else {
						$links .= '<li>' . $submenulink . '</li>';
					}
				}
				$submenu = TRUE;
				$submenulink = $link;
				$submenulinks = "";
			} else {
				if ($action == '' && $submenu) { // End previous submenu
					if ($submenulinks <> '') { // Set up submenu
						$links .= '<li class="dropdown-submenu">' . $submenulink . '<ul class="dropdown-menu">' . $submenulinks . '</ul></li>';
					} else {
						$links .= '<li>' . $submenulink . '</li>';
					}
					$submenu = FALSE;
				}
				if ($submenu)
					$submenulinks .= '<li>' . $link . '</li>';
				else
					$links .= '<li>' . $link . '</li>';
			}
		}
		if ($links <> "") {
			if ($submenu) { // End previous submenu
				if ($submenulinks <> '') { // Set up submenu
					$links .= '<li class="dropdown-submenu">' . $submenulink . '<ul class="dropdown-menu">' . $submenulinks . '</ul></li>';
				} else {
					$links .= '<li>' . $submenulink . '</li>';
				}
			}
			$buttonclass = "dropdown-toggle btn btn-default";
			if ($this->ButtonClass <> "")
				AppendClass($buttonclass, $this->ButtonClass);
			$buttontitle = HtmlTitle($this->DropDownButtonPhrase);
			$buttontitle = ($this->DropDownButtonPhrase <> $buttontitle) ? ' title="' . $buttontitle . '"' : '';
			$button = '<button class="' . $buttonclass . '"' . $buttontitle . ' data-toggle="dropdown">' . $this->DropDownButtonPhrase . '</button>' .
				'<ul class="dropdown-menu ' . (($pos == 'right') ? 'dropdown-menu-right ' : '') . 'ew-menu">' . $links . '</ul>';
			if ($pos == "bottom") // Use dropup
				$btndropdown = '<div class="btn-group btn-group-sm dropup ew-btn-dropdown">' . $button . '</div>';
			else
				$btndropdown = '<div class="btn-group btn-group-sm ew-btn-dropdown">' . $button . '</div>';
		} else {
			$btndropdown = "";
		}
		foreach ($inputs as $input)
			$btndropdown .= $input;
		$btndropdown .= $previewlinks;
		return $btndropdown;
	}

	// Hide detail items for dropdown
	public function hideDetailItemsForDropDown()
	{
		$showdtl = FALSE;
		if ($this->UseDropDownButton) {
			foreach ($this->Items as $item) {
				if ($item->Name <> $this->GroupOptionName && $item->Visible && $item->ShowInDropDown && substr($item->Name,0,7) <> "detail_") {
					$showdtl = TRUE;
					break;
				}
			}
		}
		if (!$showdtl) {
			foreach ($this->Items as $item) {
				if (substr($item->Name,0,7) == "detail_") {
					$item->Visible = FALSE;
				}
			}
		}
	}
}

/**
 * List option class
 */
class ListOption
{
	public $Name;
	public $OnLeft;
	public $CssStyle;
	public $CssClass;
	public $Visible = TRUE;
	public $Header;
	public $Body;
	public $Footer;
	public $Parent;
	public $ShowInButtonGroup = TRUE;
	public $ShowInDropDown = TRUE;
	public $ButtonGroupName = "_default";

	// Constructor
	public function __construct($name)
	{
		$this->Name = $name;
	}

	// Clear
	public function clear()
	{
		$this->Body = "";
	}

	// Move to
	public function moveTo($pos)
	{
		$this->Parent->moveItem($this->Name, $pos);
	}

	// Render
	public function render($part, $colSpan = 1)
	{
		$tagclass = $this->Parent->TagClassName;
		if ($part == "header") {
			if ($tagclass == "") $tagclass = "ew-list-option-header";
			$value = $this->Header;
		} elseif ($part == "body") {
			if ($tagclass == "")
				$tagclass = "ew-list-option-body";
			if ($this->Parent->Tag <> "td")
				AppendClass($tagclass, "ew-list-option-separator");
			$value = $this->Body;
		} elseif ($part == "footer") {
			if ($tagclass == "")
				$tagclass = "ew-list-option-footer";
			$value = $this->Footer;
		} else {
			$value = $part;
		}
		if (strval($value) == "" && $this->Parent->Tag == "span" && $this->Parent->ScriptId == "")
			return "";
		$res = ($value <> "") ? $value : "&nbsp;";
		AppendClass($tagclass, $this->CssClass);
		$attrs = ["class" => $tagclass, "style" => $this->CssStyle, "data-name" => $this->Name];
		if (SameText($this->Parent->Tag, "td") && $this->Parent->RowSpan > 1)
			$attrs["rowspan"] = $this->Parent->RowSpan;
		if (SameText($this->Parent->Tag, "td") && $colSpan > 1)
			$attrs["colspan"] = $colSpan;
		$name = $this->Parent->TableVar . "_" . $this->Name;
		if ($this->Name <> $this->Parent->GroupOptionName) {
			if (!in_array($this->Name, ["checkbox", "rowcnt"])) {
				if ($this->Parent->UseButtonGroup && $this->ShowInButtonGroup) {
					$res = $this->Parent->renderButtonGroup($res);
					if ($this->OnLeft && SameText($this->Parent->Tag, "td") && $colSpan > 1)
						$res = '<div class="text-right">' . $res . '</div>';
				}
			}
			if ($part == "header")
				$res = '<span id="elh_' . $name . '" class="' . $name . '">' . $res . '</span>';
			else if ($part == 'body')
				$res = '<span id="el' . $this->Parent->RowCnt . '_' . $name . '" class="' . $name . '">' . $res . '</span>';
			else if ($part == 'footer')
				$res = '<span id="elf_' . $name . '" class="' . $name . '">' . $res . '</span>';
		}
		$tag = ($this->Parent->Tag == 'td' && $part == 'header') ? 'th' : $this->Parent->Tag;
		if ($this->Parent->UseButtonGroup && $this->ShowInButtonGroup)
			AppendClass($attrs['class'], 'text-nowrap');
		$res = HtmlElement($tag, $attrs, $res);
		if ($this->Parent->ScriptId <> '') {
			$js = ExtractScript($res, $this->Parent->ScriptClassName . '_js');
			if ($this->Parent->ScriptType == 'single') {
				if ($part == 'header')
					$res = '<script id="tpoh_' . $this->Parent->ScriptId . '_' . $this->Name . '" type="text/html">' . $res . '</script>';
				else if ($part == 'body')
					$res = '<script id="tpob' . $this->Parent->RowCnt . '_' . $this->Parent->ScriptId . '_' . $this->Name . '" type="text/html">' . $res . '</script>';
				else if ($part == 'footer')
					$res = '<script id="tpof_' . $this->Parent->ScriptId . '_' . $this->Name . '" type="text/html">' . $res . '</script>';
			}
			if ($js <> "")
				if ($this->Parent->ScriptType == "single")
					$res .= $js;
				else
					$this->Parent->JavaScript .= $js;
		}
		return $res;
	}
}

/**
 * ListOptionsArray class (Array of ListOptions)
 */
class ListOptionsArray extends \ArrayObject {

	// Constructor
	public function __construct($array = array()){
		parent::__construct($array, \ArrayObject::ARRAY_AS_PROPS);
	}

	// Render
	public function render($part, $pos = "") {
		foreach ($this as $options)
			$options->render($part, $pos);
	}

	// Hide all options
	public function hideAllOptions() {
		foreach ($this as $options)
			$options->hideAllOptions();
	}
}

/**
 * List actions class
 */
class ListActions
{
	public $Items = [];

	// Add and return a new option
	public function &add($name, $action, $allow = TRUE, $method = ACTION_POSTBACK, $select = ACTION_MULTIPLE, $confirmMsg = "", $icon = "fa fa-star ew-icon", $success = "")
	{
		if (is_string($action))
			$item = new ListAction($name, $action, $allow, $method, $select, $confirmMsg, $icon, $success);
		elseif ($action instanceof ListAction)
			$item = $action;
		$this->Items[$name] = $item;
		return $item;
	}

	// Get item by name
	public function &getItem($name)
	{
		$item = array_key_exists($name, $this->Items) ? $this->Items[$name] : NULL;
		return $item;
	}
}

/**
 * List action class
 */
class ListAction
{
	public $Action = "";
	public $Caption = "";
	public $Allow = TRUE;
	public $Method = ACTION_POSTBACK; // Post back (p) / Ajax (a)
	public $Select = ACTION_MULTIPLE; // Multiple (m) / Single (s)
	public $ConfirmMsg = "";
	public $Icon = "fa fa-star ew-icon"; // Icon
	public $Success = ""; // JavaScript callback function name

	// Constructor
	public function __construct($action, $caption, $allow = TRUE, $method = ACTION_POSTBACK, $select = ACTION_MULTIPLE, $confirmMsg = "", $icon = "fa fa-star ew-icon", $success = "")
	{
		$this->Action = $action;
		$this->Caption = $caption;
		$this->Allow = $allow;
		$this->Method = $method;
		$this->Select = $select;
		$this->ConfirmMsg = $confirmMsg;
		$this->Icon = $icon;
		$this->Success = $success;
	}

	// To JSON
	public function toJson($htmlEncode = FALSE)
	{
		$ar = [
			"msg" => $this->ConfirmMsg,
			"action" => $this->Action,
			"method" => $this->Method,
			"select" => $this->Select,
			"success" => $this->Success
		];
		$json = JsonEncode($ar);
		if ($htmlEncode)
			$json = HtmlEncode($json);
		return $json;
	}
}

/**
 * Sub pages class
 */
class SubPages
{
	public $Justified = FALSE;
	public $Fill = FALSE;
	public $Vertical = FALSE;
	public $Align = "left"; // "left" or "center" or "right"
	public $Style = ""; // "tabs" or "pills" or "" (accordion)
	public $Classes = ""; // Other CSS classes
	public $Parent = FALSE; // For accordion only, if a selector is provided, then all collapsible elements under the specified parent will be closed when a collapsible item is shown. 
	public $Items = [];
	public $ValidKeys = NULL;
	public $ActiveIndex = NULL;

	// Get nav classes
	public function navStyle()
	{
		$style = "";
		if ($this->Style)
			$style .= "nav nav-" . $this->Style;
		if ($this->Justified)
			$style .= " nav-justified";
		if ($this->Fill)
			$style .= " nav-fill";
		if (SameText($this->Align, "center")) {
			$style .= " justify-content-center";
		} elseif (SameText($this->Align, "right")) {
			$style .= " justify-content-end";
		}
		if ($this->Vertical)
			$style .= " flex-column";
		if ($this->Classes)
			$style .= " " . $this->Classes;
		return $style;
	}

	// Check if a page is active
	public function isActive($k)
	{
		return ($this->activePageIndex() == $k);
	}

	// Get page classes
	public function pageStyle($k)
	{
		if ($this->isActive($k)) { // Active page
			if ($this->Style <> "") // "tabs" or "pills"
				return " active show";
			else // accordion
				return " show"; // .collapse does not use .active
		}
		$item = &$this->getItem($k);
		if ($item) { // "tabs" or "pills"
			if (!$item->Visible)
				return " d-none ew-hidden";
			elseif ($item->Disabled)
				return " disabled ew-disabled";
		}
		return "";
	}

	// Get count
	public function count()
	{
		return count($this->Items);
	}

	// Add item by name
	public function &add($name = "")
	{
		$item = new SubPage();
		if (strval($name) <> "")
			$this->Items[$name] = $item;
		if (!is_int($name))
			$this->Items[] = $item;
		return $item;
	}

	// Get item by key
	public function &getItem($k)
	{
		$item = array_key_exists($k, $this->Items) ? $this->Items[$k] : NULL;
		return $item;
	}

	// Active page index
	public function activePageIndex()
	{
		if ($this->ActiveIndex !== NULL)
			return $this->ActiveIndex;

		// Return first active page
		foreach ($this->Items as $key => $item) {
			if ((!is_array($this->ValidKeys) || in_array($key, $this->ValidKeys)) && $item->Visible && !$item->Disabled && $item->Active && $key !== 0) { // Not common page
				$this->ActiveIndex = $key;
				return $this->ActiveIndex;
			}
		}

		// If not found, return first visible page
		foreach ($this->Items as $key => $item) {
			if ((!is_array($this->ValidKeys) || in_array($key, $this->ValidKeys)) && $item->Visible && !$item->Disabled && $key !== 0) { // Not common page
				$this->ActiveIndex = $key;
				return $this->ActiveIndex;
			}
		}

		// Not found
		return NULL;
	}
}

/**
 * Sub page class
 */
class SubPage
{
	public $Active = FALSE;
	public $Visible = TRUE; // If FALSE, add class "d-none", for tabs/pills only
	public $Disabled = FALSE; // If TRUE, add class "disabled", for tabs/pills only
}
?>
<?php
$EXPORT['word'] = 'ExportPhpWord'; // Replace the default ExportWord class

//
// Class for export to Word by PHPWord
//
class ExportPhpWord extends ExportBase
{
	protected $PhpWord;
	protected $Section;
	protected $CellWidth;
	protected $StyleTable;
	protected $PhpWordTbl;
	protected $RowType;
	public static $MaxImageWidth = 250; // Max image width

	// Constructor
	public function __construct(&$tbl, $style)
	{
		global $EXPORT_WORD_CELL_WIDTH;
		parent::__construct($tbl, $style);
		$this->PhpWord = new \PhpOffice\PhpWord\PhpWord();
		$this->Section = $this->PhpWord->createSection(array("orientation" => $tbl->ExportWordPageOrientation));
		$this->CellWidth = $tbl->ExportWordColumnWidth;
		$this->StyleTable = array("borderSize" => 6, "borderColor" => "A9A9A9", "cellMargin" => 60); // Customize table cell styles here
		$this->PhpWord->addTableStyle("ewPHPWord", $this->StyleTable);
		$this->PhpWordTbl = $this->Section->addTable("ewPHPWord");
	}

	// Convert to UTF-8
	protected function convertToUtf8($value)
	{
		return ConvertToUtf8(html_entity_decode($value));
	}

	// Table header
	public function exportTableHeader() {}

	// Field aggregate
	public function exportAggregate(&$fld, $type)
	{
		$this->FldCnt++;
		if ($this->Horizontal) {
			global $Language;
			if ($this->FldCnt == 1)
				$this->PhpWordTbl->addRow(0);
			$val = "";
			if (in_array($type, array("TOTAL", "COUNT", "AVERAGE")))
				$val = $Language->Phrase($type) . ": " . $this->convertToUtf8($fld->exportValue());
			$this->PhpWordTbl->addCell($this->CellWidth, array("gridSpan" => 1))->addText(trim($val));
		}
	}

	// Field caption
	public function exportCaption(&$fld)
	{
		$this->FldCnt++;
		$this->exportCaptionBy($fld, $this->FldCnt - 1, $this->RowCnt);
	}

	// Field caption by column and row
	public function exportCaptionBy(&$fld, $col, $row)
	{
		if ($col == 0)
			$this->PhpWordTbl->addRow(0);
		$val = $this->convertToUtf8($fld->exportCaption());
		$this->PhpWordTbl->addCell($this->CellWidth, array("gridSpan" => 1, "bgColor" => "E4E4E4"))->addText(trim($val), array("bold" => TRUE)); // Customize table header cell styles here
	}

	// Field value by column and row
	public function exportValueBy(&$fld, $col, $row)
	{
		if ($col == 0)
			$this->PhpWordTbl->addRow(0);
		$val = "";
		$maxImageWidth = self::$MaxImageWidth;
		if ($fld->ExportFieldImage && $fld->ViewTag == "IMAGE") { // Image
			$imagefn = $fld->getTempImage();
			$cell =	$this->PhpWordTbl->addCell($this->CellWidth);
			if (!$fld->UploadMultiple || !ContainsString($imagefn, ",")) {
				$fn = ServerMapPath($imagefn, TRUE);
				if ($imagefn <> "" && file_exists($fn) && !is_dir($fn)) {
					$size = @getimagesize($fn);
					$style = array();
					if ($maxImageWidth > 0 && @$size[0] > $maxImageWidth) {
						$style["width"] = $maxImageWidth;
						$style["height"] = $maxImageWidth / $size[0] * $size[1];
					}
					$cell->addImage($fn, $style);
				}
			} else {
				$ar = explode(",", $imagefn);
				foreach ($ar as $imagefn) {
					$fn = ServerMapPath($imagefn, TRUE);
					if ($imagefn <> "" && file_exists($fn) && !is_dir($fn)) {
						$size = @getimagesize($fn);
						$style = array();
						if ($maxImageWidth > 0 && @$size[0] > $maxImageWidth) {
							$style["width"] = $maxImageWidth;
							$style["height"] = $maxImageWidth / $size[0] * $size[1];
						}
						$cell->addImage($fn, $style);
					}
				}
			}
		} elseif ($fld->ExportFieldImage && $fld->ExportHrefValue <> "") { // Export custom view tag
			$imagefn = $fld->ExportHrefValue;
			$cell =	$this->PhpWordTbl->addCell($this->CellWidth);
			$fn = ServerMapPath($imagefn, TRUE);
			if ($imagefn <> "" && file_exists($fn) && !is_dir($fn)) {
				$size = @getimagesize($fn);
				$style = array();
				if ($maxImageWidth > 0 && @$size[0] > $maxImageWidth) {
					$style["width"] = $maxImageWidth;
					$style["height"] = $maxImageWidth / $size[0] * $size[1];
				}
				$cell->addImage($fn, $style);
			}
		} else { // Formatted Text
			$val = $this->convertToUtf8($fld->exportValue());
			if ($this->RowType > 0) { // Not table header/footer
				if (in_array($fld->Type, array(4, 5, 6, 14, 131))) // If float or currency
					$val = $this->convertToUtf8($fld->CurrentValue); // Use original value instead of formatted value
			}
			$this->PhpWordTbl->addCell($this->CellWidth, array("gridSpan" => 1))->addText(trim($val));
		}
	}

	// Begin a row
	public function beginExportRow($rowCnt = 0, $useStyle = TRUE)
	{
		$this->RowCnt++;
		$this->FldCnt = 0;
		$this->RowType = $rowCnt;
	}

	// End a row
	public function endExportRow($rowcnt = 0) {}

	// Empty row
	public function exportEmptyRow()
	{
		$this->RowCnt++;
	}

	// Page break
	public function exportPageBreak() {}

	// Export a field
	public function exportField(&$fld)
	{
		$this->FldCnt++;
		if ($this->Horizontal) {
			$this->exportValueBy($fld, $this->FldCnt - 1, $this->RowCnt);
		} else { // Vertical, export as a row
			$this->RowCnt++;
			$this->exportCaptionBy($fld, 0, $this->RowCnt);
			$this->exportValueBy($fld, 1, $this->RowCnt);
		}
	}

	// Table footer
	public function exportTableFooter() {}

	// Add HTML tags
	public function exportHeaderAndFooter() {}

	// Export
	public function export()
	{
		global $ExportFileName;
		if (!DEBUG_ENABLED && ob_get_length())
			ob_end_clean();
		header('Set-Cookie: fileDownload=true; path=/');
		header('Content-Type: application/vnd.openxmlformats-officedocument.wordprocessingml.document');
		header('Content-Disposition: attachment; filename=' . $ExportFileName . '.docx');
		header('Cache-Control: max-age=0');
		$objWriter = \PhpOffice\PhpWord\IOFactory::createWriter($this->PhpWord, 'Word2007');
		@$objWriter->save('php://output');
		DeleteTempImages();
	}

	// Destructor
	public function __destruct()
	{
		DeleteTempImages();
	}
}
?>
<?php

/**
 * Basic Search class
 */
class BasicSearch
{
	public $TableVar = "";
	public $BasicSearchAnyFields = BASIC_SEARCH_ANY_FIELDS;
	public $Keyword = "";
	public $KeywordDefault = "";
	public $Type = "";
	public $TypeDefault = "";
	protected $Prefix = "";

	// Constructor
	public function __construct($tblvar)
	{
		$this->TableVar = $tblvar;
		$this->Prefix = PROJECT_NAME . "_" . $tblvar . "_";
	}

	// Session variable name
	protected function getSessionName($suffix)
	{
		return $this->Prefix . $suffix;
	}

	// Load default
	public function loadDefault()
	{
		$this->Keyword = $this->KeywordDefault;
		$this->Type = $this->TypeDefault;
		if (!isset($_SESSION[$this->getSessionName(TABLE_BASIC_SEARCH_TYPE)]) && $this->TypeDefault != "") // Save default to session
			$this->setType($this->TypeDefault);
	}

	// Unset session
	public function unsetSession()
	{
		unset($_SESSION[$this->getSessionName(TABLE_BASIC_SEARCH_TYPE)]);
		unset($_SESSION[$this->getSessionName(TABLE_BASIC_SEARCH)]);
	}

	// Isset session
	public function issetSession()
	{
		return isset($_SESSION[$this->getSessionName(TABLE_BASIC_SEARCH)]);
	}

	// Set keyword
	public function setKeyword($v, $save = TRUE)
	{
		if (REMOVE_XSS)
			$v = RemoveXss($v);
		$this->Keyword = $v;
		if ($save)
			$_SESSION[$this->getSessionName(TABLE_BASIC_SEARCH)] = $v;
	}

	// Set type
	public function setType($v, $save = TRUE)
	{
		if (REMOVE_XSS)
			$v = RemoveXss($v);
		$this->Type = $v;
		if ($save)
			$_SESSION[$this->getSessionName(TABLE_BASIC_SEARCH_TYPE)] = $v;
	}

	// Save
	public function save()
	{
		$_SESSION[$this->getSessionName(TABLE_BASIC_SEARCH)] = $this->Keyword;
		$_SESSION[$this->getSessionName(TABLE_BASIC_SEARCH_TYPE)] = $this->Type;
	}

	// Get keyword
	public function getKeyword()
	{
		return @$_SESSION[$this->getSessionName(TABLE_BASIC_SEARCH)];
	}

	// Get type
	public function getType()
	{
		return @$_SESSION[$this->getSessionName(TABLE_BASIC_SEARCH_TYPE)];
	}

	// Get type name
	public function getTypeName()
	{
		global $Language;
		$typ = $this->getType();
		switch ($typ) {
			case "=": return $Language->phrase("QuickSearchExact");
			case "AND": return $Language->phrase("QuickSearchAll");
			case "OR": return $Language->phrase("QuickSearchAny");
			default: return $Language->phrase("QuickSearchAuto");
		}
	}

	// Get short type name
	public function getTypeNameShort()
	{
		global $Language;
		$typ = $this->getType();
		switch ($typ) {
			case "=": $typname = $Language->phrase("QuickSearchExactShort"); break;
			case "AND": $typname = $Language->phrase("QuickSearchAllShort"); break;
			case "OR": $typname = $Language->phrase("QuickSearchAnyShort"); break;
			default: $typname = $Language->phrase("QuickSearchAutoShort"); break;
		}
		if ($typname <> "")
			$typname .= "&nbsp;";
		return $typname;
	}

	// Get keyword list
	public function keywordList($default = FALSE)
	{
		$searchKeyword = ($default) ? $this->KeywordDefault : $this->Keyword;
		$searchType = ($default) ? $this->TypeDefault : $this->Type;
		if ($searchKeyword <> "") {
			$search = trim($searchKeyword);
			if ($searchType <> "=") {
				$ar = [];

				// Match quoted keywords (i.e.: "...")
				if (preg_match_all('/"([^"]*)"/i', $search, $matches, PREG_SET_ORDER)) {
					foreach ($matches as $match) {
						$p = strpos($search, $match[0]);
						$str = substr($search, 0, $p);
						$search = substr($search, $p + strlen($match[0]));
						if (strlen(trim($str)) > 0)
							$ar = array_merge($ar, explode(" ", trim($str)));
						$ar[] = $match[1]; // Save quoted keyword
					}
				}

				// Match individual keywords
				if (strlen(trim($search)) > 0)
					$ar = array_merge($ar, explode(" ", trim($search)));
			} else {
				$ar = [$search];
			}
			return $ar;
		}
		return [];
	}

	// Load
	public function load()
	{
		$this->Keyword = $this->getKeyword();
		$this->Type = $this->getType();
	}
}

/**
 * Advanced Search class
 */
class AdvancedSearch
{
	public $TableVar;
	public $FieldVar;
	public $SearchValue; // Search value
	public $ViewValue = ""; // View value
	public $SearchOperator; // Search operator
	public $SearchCondition; // Search condition
	public $SearchValue2; // Search value 2
	public $ViewValue2 = ""; // View value 2
	public $SearchOperator2; // Search operator 2
	public $SearchValueDefault = ""; // Search value default
	public $SearchOperatorDefault = ""; // Search operator default
	public $SearchConditionDefault = ""; // Search condition default
	public $SearchValue2Default = ""; // Search value 2 default
	public $SearchOperator2Default = ""; // Search operator 2 default
	protected $Prefix = "";
	protected $Suffix = "";

	// Constructor
	public function __construct($tblvar, $fldvar)
	{
		$this->TableVar = $tblvar;
		$this->FieldVar = $fldvar;
		$this->Prefix = PROJECT_NAME . "_" . $tblvar . "_" . TABLE_ADVANCED_SEARCH . "_";
		$this->Suffix = "_" . substr($fldvar, 2);
	}

	// Set SearchValue
	public function setSearchValue($v)
	{
		if (REMOVE_XSS)
			$v = RemoveXss($v);
		$this->SearchValue = $v;
	}

	// Set SearchOperator
	public function setSearchOperator($v)
	{
		if ($this->isValidOperator($v))
			$this->SearchOperator = $v;
	}

	// Set SearchCondition
	public function setSearchCondition($v)
	{
		if (REMOVE_XSS)
			$v = RemoveXss($v);
		$this->SearchCondition = $v;
	}

	// Set SearchValue2
	public function setSearchValue2($v)
	{
		if (REMOVE_XSS)
			$v = RemoveXss($v);
		$this->SearchValue2 = $v;
	}

	// Set SearchOperator2
	public function setSearchOperator2($v)
	{
		if ($this->isValidOperator($v))
			$this->SearchOperator2 = $v;
	}

	// Unset session
	public function unsetSession()
	{
		unset($_SESSION[$this->getSessionName("x")]);
		unset($_SESSION[$this->getSessionName("z")]);
		unset($_SESSION[$this->getSessionName("v")]);
		unset($_SESSION[$this->getSessionName("y")]);
		unset($_SESSION[$this->getSessionName("w")]);
	}

	// Isset session
	public function issetSession()
	{
		return isset($_SESSION[$this->getSessionName("x")]) ||
			isset($_SESSION[$this->getSessionName("y")]);
	}

	// Save to session
	public function save()
	{
		$fldVal = $this->SearchValue;
		if (is_array($fldVal))
			$fldVal = implode(",", $fldVal);
		$fldVal2 = $this->SearchValue2;
		if (is_array($fldVal2))
			$fldVal2 = implode(",", $fldVal2);
		if (@$_SESSION[$this->getSessionName("x")] <> $fldVal)
			$_SESSION[$this->getSessionName("x")] = $fldVal;
		if (@$_SESSION[$this->getSessionName("y")] <> $fldVal2)
			$_SESSION[$this->getSessionName("y")] = $fldVal2;
		if (@$_SESSION[$this->getSessionName("z")] <> $this->SearchOperator)
			$_SESSION[$this->getSessionName("z")] = $this->SearchOperator;
		if (@$_SESSION[$this->getSessionName("v")] <> $this->SearchCondition)
			$_SESSION[$this->getSessionName("v")] = $this->SearchCondition;
		if (@$_SESSION[$this->getSessionName("w")] <> $this->SearchOperator2)
			$_SESSION[$this->getSessionName("w")] = $this->SearchOperator2;
	}

	// Load from session
	public function load()
	{
		$this->SearchValue = @$_SESSION[$this->getSessionName("x")];
		$this->SearchOperator = @$_SESSION[$this->getSessionName("z")];
		$this->SearchCondition = @$_SESSION[$this->getSessionName("v")];
		$this->SearchValue2 = @$_SESSION[$this->getSessionName("y")];
		$this->SearchOperator2 = @$_SESSION[$this->getSessionName("w")];
	}

	// Get value
	public function getValue($infix)
	{
		return @$_SESSION[$this->getSessionName($infix)];
	}

	// Load default values
	public function loadDefault()
	{
		if ($this->SearchValueDefault != "")
			$this->SearchValue = $this->SearchValueDefault;
		if ($this->SearchOperatorDefault != "")
			$this->SearchOperator = $this->SearchOperatorDefault;
		if ($this->SearchConditionDefault != "")
			$this->SearchCondition = $this->SearchConditionDefault;
		if ($this->SearchValue2Default != "")
			$this->SearchValue2 = $this->SearchValue2Default;
		if ($this->SearchOperator2Default != "")
			$this->SearchOperator2 = $this->SearchOperator2Default;
	}

	// Convert to JSON
	public function toJson()
	{
		if ($this->SearchValue <> "" || $this->SearchValue2 <> "" || in_array($this->SearchOperator, ["IS NULL", "IS NOT NULL"]) || in_array($this->SearchOperator2, ["IS NULL", "IS NOT NULL"])) {
			return '"x' . $this->Suffix . '":"' . JsEncode($this->SearchValue) . '",' .
				'"z' . $this->Suffix . '":"' . JsEncode($this->SearchOperator) . '",' .
				'"v' . $this->Suffix . '":"' . JsEncode($this->SearchCondition) . '",' .
				'"y' . $this->Suffix . '":"' . JsEncode($this->SearchValue2) . '",' .
				'"w' . $this->Suffix . '":"' . JsEncode($this->SearchOperator2) . '"';
		} else {
			return "";
		}
	}

	// Session variable name
	protected function getSessionName($infix)
	{
		return $this->Prefix . $infix . $this->Suffix;
	}

	/**
	 * Check if search operator is valid
	 *
	 * @param string $opr Search Operator, e.g. '<', '>'
	 * @return boolean
	 */
	protected function isValidOperator($opr)
	{
		return in_array($opr, ['=', '<>', '<', '<=', '>', '>=', 'LIKE', 'NOT LIKE', 'STARTS WITH', 'ENDS WITH', 'IS NULL', 'IS NOT NULL', 'BETWEEN']);
	}
}
?>
<?php

/**
 * Upload class
 */
class HttpUpload
{
	public $Index = -1; // Index for multiple form elements
	public $Parent; // Parent field object
	public $UploadPath; // Upload path
	public $Message; // Error message
	public $DbValue; // Value from database
	public $Value = NULL; // Upload value
	public $FileToken = ""; // Upload file token (API only)
	public $FileName; // Upload file name
	public $FileSize; // Upload file size
	public $ContentType; // File content type
	public $ImageWidth; // Image width
	public $ImageHeight; // Image height
	public $Error; // Upload error
	public $UploadMultiple = FALSE; // Multiple upload
	public $KeepFile = TRUE; // Keep old file
	public $Plugins = []; // Plugins for Resize()

	// Constructor
	public function __construct($fld = NULL)
	{
		$this->Parent = $fld;
	}

	// Check file type of the uploaded file
	public function uploadAllowedFileExt($filename)
	{
		return CheckFileType($filename);
	}

	// Get upload file
	public function uploadFile()
	{
		$this->Value = NULL; // Reset first

		// Get file from token or FormData for API request
		if (IsApi() && session_status() !== PHP_SESSION_ACTIVE) {
			if (Post($this->Parent->Name) !== NULL) {
				$this->KeepFile = FALSE;
				$this->FileToken = Post($this->Parent->Name);
				$this->FileName = $this->getUploadedFileName($this->FileToken);
			} else {
				$this->KeepFile = !$this->getUploadedFiles($this->Parent->Name, FALSE);
			}
		} else {
			$fldvar = ($this->Index < 0) ? $this->Parent->FieldVar : substr($this->Parent->FieldVar, 0, 1) . $this->Index . substr($this->Parent->FieldVar, 1);
			$wrkvar = "fn_" . $fldvar;
			$this->FileName = Post($wrkvar, ""); // Get file name
			$wrkvar = "fa_" . $fldvar;
			$this->KeepFile = (Post($wrkvar, "") == "1"); // Check if keep old file
		}
		if (!$this->KeepFile && $this->FileName <> "" && !$this->UploadMultiple) {
			$f = ($this->FileToken <> "" ? UploadTempPath($this->FileToken, $this->Index) : UploadTempPath($this->Parent, $this->Index)) . $this->FileName;
			if (file_exists($f)) {
				$this->Value = file_get_contents($f);
				$this->FileSize = filesize($f);
				$this->ContentType = ContentType($this->Value, $f);
				$sizes = @getimagesize($f);
				$this->ImageWidth = @$sizes[0];
				$this->ImageHeight = @$sizes[1];
			}
		}
		return TRUE; // Normal return
	}

	// Get uploaded files
	public function getUploadedFiles($name = "", $output = TRUE)
	{
		global $Request, $Language;
		if (!is_object($Request)) {
			if ($output)
				WriteJson(["success" => FALSE, "error" => "No request object"]);
			return FALSE;
		}

		// Language object
		if (!isset($Language))
			$Language = new Language();

		// Requires JWT login for action=upload request
		global $UserProfile, $Security, $RequestSecurity;
		if ($name == "") {

			// User profile
			$UserProfile = new UserProfile();

			// Check token first
			$validRequest = FALSE;
			$func = PROJECT_NAMESPACE . CHECK_TOKEN_FUNC;
			if (is_callable($func) && Post(TOKEN_NAME) !== NULL) {
				$validRequest = $func(Post(TOKEN_NAME), SessionTimeoutTime());
				if ($validRequest) {
					if (!isset($Security)) {
						if (session_status() !== PHP_SESSION_ACTIVE)
							session_start(); // Init session data
						$Security = new AdvancedSecurity();
					}
				}
			}
			if (!$validRequest) {

				// Security
				$Security = new AdvancedSecurity();
				if (is_array($RequestSecurity) && @$RequestSecurity["username"] <> "") // Login user
					$Security->loginUser(@$RequestSecurity["username"], @$RequestSecurity["userid"], @$RequestSecurity["parentuserid"], @$RequestSecurity["userlevelid"]);
			}
			if (!$Security->isLoggedIn())
				return FALSE;
		}
		$res = TRUE;
		$req = $Request->getUploadedFiles();
		$files = [];

		// Validate request
		if (!is_array($req)) {
			if ($output)
				WriteJson(["success" => FALSE, "error" => "No uploaded files"]);
			return FALSE;
		}

		// Create temp folder
		$token = strval(Random());
		$path = UploadTempPath($token, $this->Index);
		if (!CreateFolder($path)) {
			if ($output)
				WriteJson(["success" => FALSE, "error" => "Create folder '" . $path . "' failed."]);
			return FALSE;
		}

		// Move files to temp folder
		$fileName = "";
		$fileTypes = '/\\.(' . (UPLOAD_ALLOWED_FILE_EXT <> "" ? str_replace(",", "|", UPLOAD_ALLOWED_FILE_EXT) : "[\s\S]+") . ')$/i';
		foreach ($req as $id => $uploadedFiles) {
			if ($id == $name || $name == "") {
				$ar = [];
				if (is_object($uploadedFiles)) { // Single upload
					$fileName = $uploadedFiles->getClientFilename();
					$fileSize = $uploadedFiles->getSize();
					$ar["name"] = $fileName;
					if (!preg_match($fileTypes, $fileName)) { // Check file extensions
						$ar["success"] = FALSE;
						$ar["error"] = $Language->phrase("UploadErrMsgAcceptFileTypes");
						$res = FALSE;
					} elseif (MAX_FILE_SIZE > 0 && $fileSize > MAX_FILE_SIZE) { // Check file size
						$ar["success"] = FALSE;
						$ar["error"] = $Language->phrase("UploadErrMsgMaxFileSize");
						$res = FALSE;
					} elseif ($this->moveUploadedFile($uploadedFiles, $path)) {
						$ar["success"] = TRUE;
					} else {
						$ar["success"] = FALSE;
						$ar["error"] = $uploadedFile->getError();
						$res = FALSE;
					}
				} elseif (is_array($uploadedFiles)) { // Multiple upload
					foreach ($uploadedFiles as $uploadedFile) {
						if ($fileName <> "")
							$fileName .= MULTIPLE_UPLOAD_SEPARATOR;
						$clientFilename = $uploadedFile->getClientFilename();
						$fileSize = $uploadedFile->getSize();
						$fileName .= $clientFilename;
						$arwrk = ["name" => $clientFilename];
						if (!preg_match($fileTypes, $clientFilename)) { // Check file extensions
							$arwrk["success"] = FALSE;
							$arwrk["error"] = $Language->phrase("UploadErrMsgAcceptFileTypes");
							$res = FALSE;
						} elseif (MAX_FILE_SIZE > 0 && $fileSize > MAX_FILE_SIZE) { // Check file size
							$arwrk["success"] = FALSE;
							$arwrk["error"] = $Language->phrase("UploadErrMsgMaxFileSize");
							$res = FALSE;
						} elseif ($this->moveUploadedFile($uploadedFile, $path)) {
							$arwrk["success"] = TRUE;
						} else {
							$arwrk["success"] = FALSE;
							$arwrk["error"] = $uploadedFile->getError();
							$res = FALSE;
						}
						$ar[] = $arwrk;
					}
				}
				$files[$id] = $ar;
			}
		}
		$result = ["success" => $res, "files" => $files];
		if ($res) { // Add token if any file uploaded successfully
			$this->FileToken = $token;
			$this->FileName = $fileName;
			$result[API_FILE_TOKEN_NAME] = $token;
		} else { // All failed => clean path
			CleanPath($path, TRUE);
		}
		if ($output)
			WriteJson($result);
		return $res;
	}

	/**
	 * Get uploaded file name (with or without full path)
	 *
	 * @param string $token File token to locate the uploaded temp path
	 * @param boolean $path Return file name with or without full path
	 * @return string
	 */
	public function getUploadedFileName($token, $path = FALSE)
	{
		if (EmptyValue($token)) { // Remove
			return "";
		} else { // Load file name from token
			$path = UploadTempPath($token, $this->Index);
			try {
				if (@is_dir($path)) {

					// Get all files in the folder
					if ($ar = glob($path . '*.*')) {
						$fileName = "";
						foreach ($ar as $v) {
							if ($fileName <> "")
								$fileName .= MULTIPLE_UPLOAD_SEPARATOR;
							$fileName .= $path ? $v : basename($v);
						}
					}
					return $fileName;
				}
			} catch (\Exception $e) {
				if (DEBUG_ENABLED)
					throw $e;
			}
			return "";
		}
	}

	/**
	 * Resize image
	 *
	 * @param integer $width Target width of image
	 * @param integer $height Target height of image
	 * @param integer $quality optional Deprecated, kept for backward compatibility only.
	 * @return HttpUpload
	 */
	public function resize($width, $height, $quality = THUMBNAIL_DEFAULT_QUALITY)
	{
		if (!EmptyValue($this->Value)) {
			$wrkwidth = $width;
			$wrkheight = $height;
			if (ResizeBinary($this->Value, $wrkwidth, $wrkheight, $quality, $this->Plugins)) {
				if ($wrkwidth > 0 && $wrkheight > 0) {
					$this->ImageWidth = $wrkwidth;
					$this->ImageHeight = $wrkheight;
				}
				$this->FileSize = strlen($this->Value);
			}
		}
		return $this;
	}

	/**
	 * Get file count
	 */
	public function count()
	{
		if (!$this->UploadMultiple && !EmptyValue($this->Value)) {
			return 1;
		} elseif ($this->UploadMultiple && $this->FileName <> "") {
			$ar = explode(MULTIPLE_UPLOAD_SEPARATOR, $this->FileName);
			return count($ar);
		}
		return 0;
	}

	/**
	 * Get temp file
	 *
	 * @param integer $idx
	 * @return object|object[] Instance(s) of thumbnail class ($THUMBNAIL_CLASS)
	 */
	public function getTempThumb($idx = -1)
	{
		global $RESIZE_OPTIONS, $THUMBNAIL_CLASS;
		$file = $this->getTempFile($idx);
		if (is_string($file)) {
			return file_exists($file) ? new $THUMBNAIL_CLASS($file, $RESIZE_OPTIONS, $this->Plugins) : NULL;
		} elseif (is_array($file)) {
			$thumbs = [];
			foreach ($file as $fn) {
				if (file_exists($fn))
					$thumbs[] = new $THUMBNAIL_CLASS($fn, $RESIZE_OPTIONS, $this->Plugins);
			}
			return $thumbs;
		}
		return NULL;
	}

	/**
	 * Save uploaded data to file
	 *
	 * @param string $newFileName New file name
	 * @param boolean $overWrite Overwrite existing file or not
	 * @param integer $idx Index of file
	 * @return booleanean
	 */
	public function saveToFile($newFileName, $overWrite, $idx = -1)
	{
		$path = ServerMapPath($this->UploadPath ?: $this->Parent->UploadPath);
		if (!EmptyValue($this->Value)) {
			if (trim(strval($newFileName)) == "")
				$newFileName = $this->FileName;
			if (!$overWrite)
				$newFileName = UniqueFilename($path, $newFileName);
			return SaveFile($path, $newFileName, $this->Value);
		} elseif ($idx >= 0) { // Use file from upload temp folder
			$file = $this->getTempFile($idx);
			if (file_exists($file)) {
				if (!$overWrite)
					$newFileName = UniqueFilename($path, $newFileName);
				return CopyFile($path, $newFileName, $file);
			}
		}
		return FALSE;
	}

	/**
	 * Resize and save uploaded data to file
	 *
	 * @param integer $width Target width of image
	 * @param integer $height Target height of image
	 * @param integer $quality Deprecated, kept for backward compatibility only.
	 * @param string $newFileName New file name
	 * @param boolean $overWrite Overwrite existing file or not
	 * @param integer $idx optional Index of the file
	 * @return HttpUpload
	 */
	public function resizeAndSaveToFile($width, $height, $quality, $newFileName, $overWrite, $idx = -1)
	{
		$numargs = func_num_args();
		$args = func_get_args();
		$oldPath = $this->UploadPath;
		if ($numargs >= 6 && is_string($args[4])) { // resizeAndSaveToFile($width, $height, $quality, $path, $newFileName, $overWrite, $idx = -1)
			$this->UploadPath = $args[3]; // Relative to app root
			$newFileName = $args[4];
			$overWrite = $args[5];
			$idx = ($numargs > 6) ? $args[6] : -1;
		}
		$result = FALSE;
		if (!EmptyValue($this->Value)) {
			$oldValue = $this->Value;
			$result = $this->resize($width, $height)->saveToFile($newFileName, $overWrite);
			$this->Value = $oldValue;
		} elseif ($idx >= 0) { // Use file from upload temp folder
			$file = $this->getTempFile($idx);
			if (file_exists($file)) {
				$this->Value = file_get_contents($file);
				$result = $this->resize($width, $height)->saveToFile($newFileName, $overWrite);
				$this->Value = NULL;
			}
		}
		$this->UploadPath = $oldPath;
		return $result;
	}

	// Move upload file
	protected function moveUploadedFile($uploadedFile, $path)
	{
		$uploadFileName = $uploadedFile->getClientFilename();
		if ($uploadedFile->getError() === UPLOAD_ERR_OK) {
			$uploadedFile->moveTo($path . $uploadFileName);
			return TRUE;
		} else {
			return FALSE;
		}
	}

	/**
	 * Get temp file path
	 *
	 * @param integer $idx optional Index of file
	 * @return string|string[]
	 */
	public function getTempFile($idx = -1)
	{
		if ($this->FileName <> "") {
			$path = $this->FileToken <> "" ? UploadTempPath($this->FileToken, $this->Index) : UploadTempPath($this->Parent, $this->Index);
			if ($this->UploadMultiple) {
				$ar = explode(MULTIPLE_UPLOAD_SEPARATOR, $this->FileName);
				if ($idx > -1 && $idx < count($ar)) {
					return $path . $ar[$idx];
				} else {
					$files = [];
					foreach ($ar as $fn)
						$files[] = $path . $fn;
					return $files;
				}
			} else {
				return $path . $this->FileName;
			}
		}
		return NULL;
	}
}

/**
 * Session handler
 */
class SessionHandler
{

	// Get session value
	public function getSession()
	{
		$checkTokenFn = PROJECT_NAMESPACE . CHECK_TOKEN_FUNC;
		if (is_callable($checkTokenFn) && $checkTokenFn(Get(TOKEN_NAME, ""), SessionTimeoutTime())) { // Check if valid token
			if (ob_get_length())
				ob_end_clean();
			Write(Encrypt(time())); // Return new token
			return TRUE;
		} else {
			return FALSE;
		}
	}
}
?>
<?php

/**
 * Advanced Security class
 */
class AdvancedSecurity
{
	public $UserLevel = []; // All User Levels
	public $UserLevelPriv = []; // All User Level permissions
	public $UserLevelID = []; // User Level ID array
	public $UserID = []; // User ID array
	public $CurrentUserLevelID;
	public $CurrentUserLevel; // Permissions
	public $CurrentUserID;
	public $CurrentParentUserID;
	protected $AnoymousUserLevelChecked = FALSE; // Dynamic User Level security
	private $_isLoggedIn = FALSE;
	private $_userName;

	// Constructor
	public function __construct()
	{

		// Init User Level
		if ($this->isLoggedIn()) {
			$this->CurrentUserLevelID = $this->sessionUserLevelID();
			if (is_numeric($this->CurrentUserLevelID) && (int)$this->CurrentUserLevelID >= -2) {
				$this->UserLevelID[] = $this->CurrentUserLevelID;
			}
		} else { // Anonymous user
			$this->CurrentUserLevelID = -2;
			$this->UserLevelID[] = $this->CurrentUserLevelID;
		}
		$_SESSION[SESSION_USER_LEVEL_LIST] = $this->userLevelList();

		// Init User ID
		$this->CurrentUserID = $this->sessionUserID();
		$this->CurrentParentUserID = $this->sessionParentUserID();

		// Load user level
		$this->loadUserLevel();
	}

	// Get session User ID
	protected function sessionUserID()
	{
		return isset($_SESSION[SESSION_USER_ID]) ? strval($_SESSION[SESSION_USER_ID]) : $this->CurrentUserID;
	}

	// Set session User ID
	protected function setSessionUserID($v)
	{
		$this->CurrentUserID = trim(strval($v));
		$_SESSION[SESSION_USER_ID] = $this->CurrentUserID;
	}

	// Get session Parent User ID
	protected function sessionParentUserID()
	{
		return isset($_SESSION[SESSION_PARENT_USER_ID]) ? strval($_SESSION[SESSION_PARENT_USER_ID]) : $this->CurrentParentUserID;
	}

	// Set session Parent User ID
	protected function setSessionParentUserID($v)
	{
		$this->CurrentParentUserID = trim(strval($v));
		$_SESSION[SESSION_PARENT_USER_ID] = $this->CurrentParentUserID;
	}

	// Get session User Level ID
	protected function sessionUserLevelID()
	{
		return isset($_SESSION[SESSION_USER_LEVEL_ID]) ? (int)$_SESSION[SESSION_USER_LEVEL_ID] : $this->CurrentUserLevelID;
	}

	// Set session User Level ID
	protected function setSessionUserLevelID($v)
	{
		$this->CurrentUserLevelID = $v;
		$_SESSION[SESSION_USER_LEVEL_ID] = $this->CurrentUserLevelID;
		if (is_numeric($v) && $v >= -2)
			$this->UserLevelID = [$v];
	}

	// Get session User Level
	protected function sessionUserLevel()
	{
		return isset($_SESSION[SESSION_USER_LEVEL]) ? (int)$_SESSION[SESSION_USER_LEVEL] : $this->CurrentUserLevel;
	}

	// Set session User Level
	protected function setSessionUserLevel($v)
	{
		$this->CurrentUserLevel = $v;
		$_SESSION[SESSION_USER_LEVEL] = $this->CurrentUserLevel;
	}

	// Get current user name
	protected function getCurrentUserName()
	{
		return isset($_SESSION[SESSION_USER_NAME]) ? strval($_SESSION[SESSION_USER_NAME]) : $this->_userName;
	}

	// Set current user name
	protected function setCurrentUserName($v)
	{
		$this->_userName = $v;
		$_SESSION[SESSION_USER_NAME] = $this->_userName;
	}

	// Get current user name (alias)
	public function currentUserName()
	{
		return $this->getCurrentUserName();
	}

	// Current User ID
	public function currentUserID()
	{
		return $this->CurrentUserID;
	}

	// Current Parent User ID
	public function currentParentUserID()
	{
		return $this->CurrentParentUserID;
	}

	// Current User Level ID
	public function currentUserLevelID()
	{
		return $this->CurrentUserLevelID;
	}

	// Current User Level value
	public function currentUserLevel()
	{
		return $this->CurrentUserLevel;
	}

	// Can add
	public function canAdd()
	{
		return (($this->CurrentUserLevel & ALLOW_ADD) == ALLOW_ADD);
	}
	public function setCanAdd($b)
	{
		if ($b) {
			$this->CurrentUserLevel |= ALLOW_ADD;
		} else {
			$this->CurrentUserLevel &= ~ALLOW_ADD;
		}
	}

	// Can delete
	public function canDelete()
	{
		return (($this->CurrentUserLevel & ALLOW_DELETE) == ALLOW_DELETE);
	}
	public function setCanDelete($b)
	{
		if ($b) {
			$this->CurrentUserLevel |= ALLOW_DELETE;
		} else {
			$this->CurrentUserLevel &= ~ALLOW_DELETE;
		}
	}

	// Can edit
	public function canEdit()
	{
		return (($this->CurrentUserLevel & ALLOW_EDIT) == ALLOW_EDIT);
	}
	public function setCanEdit($b)
	{
		if ($b) {
			$this->CurrentUserLevel |= ALLOW_EDIT;
		} else {
			$this->CurrentUserLevel &= ~ALLOW_EDIT;
		}
	}

	// Can view
	public function canView()
	{
		return (($this->CurrentUserLevel & ALLOW_VIEW) == ALLOW_VIEW);
	}
	public function setCanView($b)
	{
		if ($b) {
			$this->CurrentUserLevel |= ALLOW_VIEW;
		} else {
			$this->CurrentUserLevel &= ~ALLOW_VIEW;
		}
	}

	// Can list
	public function canList()
	{
		return (($this->CurrentUserLevel & ALLOW_LIST) == ALLOW_LIST);
	}
	public function setCanList($b)
	{
		if ($b) {
			$this->CurrentUserLevel |= ALLOW_LIST;
		} else {
			$this->CurrentUserLevel &= ~ALLOW_LIST;
		}
	}

	// Can report
	public function canReport()
	{
		return (($this->CurrentUserLevel & ALLOW_REPORT) == ALLOW_REPORT);
	}
	public function setCanReport($b)
	{
		if ($b) {
			$this->CurrentUserLevel |= ALLOW_REPORT;
		} else {
			$this->CurrentUserLevel &= ~ALLOW_REPORT;
		}
	}

	// Can search
	public function canSearch()
	{
		return (($this->CurrentUserLevel & ALLOW_SEARCH) == ALLOW_SEARCH);
	}
	public function setCanSearch($b)
	{
		if ($b) {
			$this->CurrentUserLevel |= ALLOW_SEARCH;
		} else {
			$this->CurrentUserLevel &= ~ALLOW_SEARCH;
		}
	}

	// Can admin
	public function canAdmin()
	{
		return (($this->CurrentUserLevel & ALLOW_ADMIN) == ALLOW_ADMIN);
	}
	public function setCanAdmin($b)
	{
		if ($b) {
			$this->CurrentUserLevel |= ALLOW_ADMIN;
		} else {
			$this->CurrentUserLevel &= ~ALLOW_ADMIN;
		}
	}

	// Can import
	public function canImport()
	{
		return (($this->CurrentUserLevel & ALLOW_IMPORT) == ALLOW_IMPORT);
	}
	public function setCanImport($b)
	{
		if ($b) {
			$this->CurrentUserLevel |= ALLOW_IMPORT;
		} else {
			$this->CurrentUserLevel &= ~ALLOW_IMPORT;
		}
	}

	// Last URL
	public function lastUrl()
	{
		return ReadCookie("LastUrl");
	}

	// Save last URL
	public function saveLastUrl()
	{
		$s = ServerVar("SCRIPT_NAME");
		$q = ServerVar("QUERY_STRING");
		if ($q <> "")
			$s .= "?" . $q;
		if ($this->lastUrl() == $s)
			$s = "";
		WriteCookie("LastUrl", $s);
	}

	// Auto login
	public function autoLogin()
	{
		$autologin = FALSE;
		if (!$autologin && ReadCookie("AutoLogin") == "autologin") {
			$usr = Decrypt(ReadCookie("Username"));
			$pwd = Decrypt(ReadCookie("Password"));
			$autologin = $this->validateUser($usr, $pwd, TRUE);
		}
		if (!$autologin && ALLOW_LOGIN_BY_URL && Get("username") !== NULL) {
			$usr = RemoveXss(Get("username"));
			$pwd = RemoveXss(Get("password"));
			$autologin = $this->validateUser($usr, $pwd, TRUE);
		}
		if (!$autologin && ALLOW_LOGIN_BY_SESSION && isset($_SESSION[PROJECT_NAME . "_Username"])) {
			$usr = $_SESSION[PROJECT_NAME . "_Username"];
			$pwd = @$_SESSION[PROJECT_NAME . "_Password"];
			$autologin = $this->validateUser($usr, $pwd, TRUE);
		}
		return $autologin;
	}

	// Login user
	public function loginUser($userName = NULL, $userID = NULL, $parentUserID = NULL, $userLevel = NULL)
	{
		$this->_isLoggedIn = TRUE;
		$_SESSION[SESSION_STATUS] = "login";
		if ($userName != NULL)
			$this->setCurrentUserName($userName);
		if ($userID != NULL)
			$this->setSessionUserID($userID);
		if ($parentUserID != NULL)
			$this->setSessionParentUserID($parentUserID);
		if ($userLevel != NULL) {
			$this->setSessionUserLevelID((int)$userLevel);
			$this->setupUserLevel();
		}
	}

	// Logout user
	public function logoutUser()
	{
		$this->_isLoggedIn = FALSE;
		$_SESSION[SESSION_STATUS] = "";
		$this->setCurrentUserName("");
		$this->setSessionUserID("");
		$this->setSessionParentUserID("");
		$this->setSessionUserLevelID(-2);
		$this->setupUserLevel();
	}

	// Validate user
	public function validateUser(&$usr, &$pwd, $autologin, $provider = "")
	{
		global $Language, $UserProfile, $AUTH_CONFIG;
		global $UserTable, $UserTableConn;
		$valid = FALSE;
		$customValid = FALSE;
		$providerValid = FALSE;

		// OAuth provider
		if ($provider <> "") {
			$providers = $AUTH_CONFIG["providers"];
			if (array_key_exists($provider, $providers) && $providers[$provider]["enabled"]) {
				try {
					$UserProfile->Provider = $provider;
					if (!array_key_exists("base_url", $AUTH_CONFIG))
						$AUTH_CONFIG["base_url"] = FullUrl("vendor/hybridauth/hybridauth/hybridauth/", "auth"); // Set base URL
					$hybridauth = new \Hybrid_Auth($AUTH_CONFIG);
					$UserProfile->Auth = $hybridauth;
					$adapter = $hybridauth->authenticate($provider); // Authenticate with the selected provider
					$profile = $adapter->getUserProfile();
					$UserProfile->assign($profile); // Save profile
					$usr = $profile->email;
					$providerValid = TRUE;
				} catch (\Exception $e) {
					if (DEBUG_ENABLED)
						die($e->getMessage()); //** side effect
					return FALSE;
				}
			} else {
				if (DEBUG_ENABLED)
					die("Provider for " . $provider . " not found or not enabled."); //** side effect
				return FALSE;
			}
		}

		// Call User Custom Validate event
		if (USE_CUSTOM_LOGIN) {
			$customValid = $this->User_CustomValidate($usr, $pwd);
		}

		// Handle provider login as custom login
		if ($providerValid)
			$customValid = TRUE;
		if ($customValid) {

			//$_SESSION[SESSION_STATUS] = "login"; // To be setup below
			$this->setCurrentUserName($usr); // Load user name
		}

		// Check hard coded admin first
		if (!$valid) {
			$adminUserName = ADMIN_USER_NAME;
			$adminPassword = ADMIN_PASSWORD;
			if (ENCRYPTION_ENABLED) {
				try {
					$adminUserName = PhpDecrypt(ADMIN_USER_NAME, ENCRYPTION_KEY);
					$adminPassword = PhpDecrypt(ADMIN_PASSWORD, ENCRYPTION_KEY);
				} catch (\Defuse\Crypto\Exception\WrongKeyOrModifiedCiphertextException $e) {
					$adminUserName = ADMIN_USER_NAME;
					$adminPassword = ADMIN_PASSWORD;
				}
			}
			if (CASE_SENSITIVE_PASSWORD) {
				$valid = (!$customValid && $adminUserName === $usr && $adminPassword === $pwd) ||
					($customValid && $adminUserName === $usr);
			} else {
				$valid = (!$customValid && SameText($adminUserName, $usr) && SameText($adminPassword, $pwd)) ||
					($customValid && SameText($adminUserName, $usr));
			}
			if ($valid) {
				$this->_isLoggedIn = TRUE;
				$_SESSION[SESSION_STATUS] = "login";
				$_SESSION[SESSION_SYS_ADMIN] = 1; // System Administrator
				$this->setCurrentUserName($Language->phrase("UserAdministrator")); // Load user name
				$this->setSessionUserLevelID(-1); // System Administrator
				$this->setupUserLevel();
			}
		}

		// Check other users
		if (!$valid) {
			$filter = str_replace("%u", AdjustSql($usr, USER_TABLE_DBID), USER_NAME_FILTER);

			// User table object (vlokpetugas)
			if (!isset($UserTable)) {
				$UserTable = new vlokpetugas();
				$UserTableConn = Conn($UserTable->Dbid);
			}

			// Set up filter (WHERE Clause)
			$sql = $UserTable->getSql($filter);
			if ($rs = $UserTableConn->execute($sql)) {
				if (!$rs->EOF) {
					$valid = $customValid || ComparePassword($rs->fields('Password'), $pwd);
					if ($valid) {
						$this->_isLoggedIn = TRUE;
						$_SESSION[SESSION_STATUS] = "login";
						$_SESSION[SESSION_SYS_ADMIN] = 0; // Non System Administrator
						$this->setCurrentUserName($rs->fields('Username')); // Load user name
						if ($rs->fields('Userlevel') == NULL) {
							$this->setSessionUserLevelID(0);
						} else {
							$this->setSessionUserLevelID((int)$rs->fields('Userlevel')); // Load User Level
						}
						$this->setupUserLevel();

						// Call User Validated event
						$row = $rs->fields;
						$UserProfile->assign($row);
						$UserProfile->delete('Password'); // Delete password
						$valid = $this->User_Validated($row) !== FALSE; // For backward compatibility
					}
				} else { // User not found in user table
					if ($customValid) { // Grant default permissions
						$this->setSessionUserLevelID(-2); // Anonymous User Level
						$this->setupUserLevel();
						$row = NULL;
						$customValid = $this->User_Validated($row) !== FALSE;
					}
				}
				$rs->close();
			}
		}
		$UserProfile->save();
		if ($customValid)
			return $customValid;
		if (!$valid && !IsPasswordExpired()) {
			$this->_isLoggedIn = FALSE;
			$_SESSION[SESSION_STATUS] = ""; // Clear login status
		}
		return $valid;
	}

	// Load user level from config file
	public function loadUserLevelFromConfigFile(&$arUserLevel, &$arUserLevelPriv, &$arTable, $userpriv = FALSE)
	{
		global $RELATED_PROJECT_ID;

		// User Level definitions
		array_splice($arUserLevel, 0);
		array_splice($arUserLevelPriv, 0);
		array_splice($arTable, 0);

		// Load user level from config files
		$doc = new XmlDocument();
		$folder = ServerMapPath(CONFIG_FILE_FOLDER);

		// Load user level settings from main config file
		$projectID = CurrentProjectID();
		$file = $folder . $projectID . ".xml";
		if (file_exists($file) && $doc->load($file) && $projnode = $doc->selectSingleNode("//configuration/project")) {
			$RELATED_PROJECT_ID = $doc->getAttribute($projnode, "relatedid");
			$userlevel = $doc->getAttribute($projnode, "userlevel");
			$usergroup = explode(";", $userlevel);
			foreach ($usergroup as $group) {
				@list($id, $name, $priv) = explode(",", $group, 3);

				// Remove quotes
				if (strlen($name) >= 2 && StartsString('"', $name) && EndsString('"', $name))
					$name = substr($name, 1, strlen($name) - 2);
				$arUserLevel[] = [$id, $name];
			}

			// Load from main config file
			$this->loadUserLevelFromXml($folder, $doc, $arUserLevelPriv, $arTable, $userpriv);

			// Load from related config file
			if ($RELATED_PROJECT_ID <> "")
				$this->loadUserLevelFromXml($folder, $RELATED_PROJECT_ID . ".xml", $arUserLevelPriv, $arTable, $userpriv);
		}

		// Warn user if user level not setup
		if (count($arUserLevel) == 0) {
			die("Unable to load user level from config file: " . $file); //** side effect
		}

		// Load user priv settings from all config files
		if ($dir_handle = @opendir($folder)) {
			while (FALSE !== ($file = readdir($dir_handle))) {
				if ($file == "." || $file == ".." || !is_file($folder . $file))
					continue;
				$pathinfo = pathinfo($file);
				if (isset($pathinfo["extension"]) && SameText($pathinfo["extension"], "xml")) {
					if ($file <> $projectID . ".xml" && $file <> $RELATED_PROJECT_ID . ".xml")
						$this->loadUserLevelFromXml($folder, $file, $arUserLevelPriv, $arTable, $userpriv);
				}
			}
		}
	}

	// Load user level from XML
	protected function loadUserLevelFromXml($folder, $file, &$arUserLevelPriv, &$arTable, $userpriv)
	{
		global $RELATED_PROJECT_ID, $RELATED_LANGUAGE_FOLDER;
		if (is_string($file)) {
			$file = $folder . $file;
			$doc = new XmlDocument();
			$doc->load($file);
		} else {
			$doc = $file;
		}
		if ($doc instanceof XmlDocument) {

			// Load project id
			$projid = "";
			$projfile = "";
			$projnode = $doc->selectSingleNode("//configuration/project");
			if ($projnode != NULL) {
				$projid = $doc->getAttribute($projnode, "id");
				$projfile = $doc->getAttribute($projnode, "file");
				if ($projid == $RELATED_PROJECT_ID)
					$RELATED_LANGUAGE_FOLDER = IncludeTrailingDelimiter($doc->getAttribute($projnode, "languagefolder"), TRUE);
			}

			// Load user priv
			$tablelist = $doc->selectNodes("//configuration/project/table");
			foreach ($tablelist as $table) {
				$tablevar = $doc->getAttribute($table, "id");
				$tablename = $doc->getAttribute($table, "name");
				$tablecaption = $doc->getAttribute($table, "caption");
				$userlevel = $doc->getAttribute($table, "userlevel");
				$priv = $doc->getAttribute($table, "priv");
				if (!$userpriv || ($userpriv && $priv == "1")) {
					$usergroup = explode(";", $userlevel);
					foreach ($usergroup as $group) {
						@list($id, $name, $priv) = explode(",", $group, 3);
						$arUserLevelPriv[] = [$projid . $tablename, $id, $priv];
					}
					$arTable[] = [$tablename, $tablevar, $tablecaption, $priv, $projid, $projfile];
				}
			}
		}
	}

	// Get User Level settings from database
	public function setupUserLevel()
	{
		$this->setupUserLevelEx(); // Load all user levels

		// User Level loaded event
		$this->UserLevel_Loaded();

		// Save the User Level to Session variable
		$this->saveUserLevel();
	}

	// Get all User Level settings from database
	public function setupUserLevelEx()
	{
		global $Language;
		global $Page;
		global $RELATED_PROJECT_ID;

		// Load user level from config file first
		$arTable = [];
		$arUserLevel = [];
		$arUserLevelPriv = [];
		$this->loadUserLevelFromConfigFile($arUserLevel, $arUserLevelPriv, $arTable);

		// Add Anonymous user level
		$conn = &Conn(USER_LEVEL_DBID);
		if (!$this->AnoymousUserLevelChecked) {
			$sql = "SELECT COUNT(*) FROM " . USER_LEVEL_TABLE . " WHERE " . USER_LEVEL_ID_FIELD . " = -2";
			if (ExecuteScalar($sql, $conn) == 0) {
				$sql = "INSERT INTO " . USER_LEVEL_TABLE .
					" (" . USER_LEVEL_ID_FIELD . ", " . USER_LEVEL_NAME_FIELD . ") VALUES (-2, '" . AdjustSql($Language->phrase("UserAnonymous"), USER_LEVEL_DBID) . "')";
				$conn->execute($sql);
			}
		}

		// Get the User Level definitions
		$sql = "SELECT " . USER_LEVEL_ID_FIELD . ", " . USER_LEVEL_NAME_FIELD . " FROM " . USER_LEVEL_TABLE;
		if ($rs = $conn->execute($sql)) {
			$this->UserLevel = $rs->getRows();
			$rs->close();
		}

		// Add Anonymous user privileges
		$conn = &Conn(USER_LEVEL_PRIV_DBID);
		if (!$this->AnoymousUserLevelChecked) {
			$sql = "SELECT COUNT(*) FROM " . USER_LEVEL_PRIV_TABLE . " WHERE " . USER_LEVEL_PRIV_USER_LEVEL_ID_FIELD . " = -2";
			if (ExecuteScalar($sql, $conn) == 0) {
				$wrkUserLevel = [];
				$wrkUserLevelPriv = [];
				$wrkTable = [];
				$this->loadUserLevelFromConfigFile($wrkUserLevel, $wrkUserLevelPriv, $wrkTable, TRUE);
				foreach ($wrkTable as $table) {
					$wrkPriv = 0;
					foreach ($wrkUserLevelPriv as $userpriv) {
						if (@$userpriv[0] == @$table[4] . @$table[0] && @$userpriv[1] == -2) {
							$wrkPriv = @$userpriv[2];
							break;
						}
					}
					$sql = "INSERT INTO " . USER_LEVEL_PRIV_TABLE .
						" (" . USER_LEVEL_PRIV_USER_LEVEL_ID_FIELD . ", " . USER_LEVEL_PRIV_TABLE_NAME_FIELD . ", " . USER_LEVEL_PRIV_PRIV_FIELD .
						") VALUES (-2, '" . AdjustSql(@$table[4] . @$table[0], USER_LEVEL_PRIV_DBID) . "', " . $wrkPriv . ")";
					$conn->execute($sql);
				}
			}
			$this->AnoymousUserLevelChecked = TRUE;
		}

		// Get the User Level privileges
		$userPrivSql = "SELECT " . USER_LEVEL_PRIV_TABLE_NAME_FIELD . ", " . USER_LEVEL_PRIV_USER_LEVEL_ID_FIELD . ", " . USER_LEVEL_PRIV_PRIV_FIELD . " FROM " . USER_LEVEL_PRIV_TABLE;
		if (!$this->isAdmin() && count($this->UserLevelID) > 0) {
			$userPrivSql .= " WHERE " . USER_LEVEL_PRIV_USER_LEVEL_ID_FIELD . " IN (" . $this->userLevelList() . ")";
			$_SESSION[SESSION_USER_LEVEL_LIST_LOADED] = $this->userLevelList(); // Save last loaded list
		} else {
			$_SESSION[SESSION_USER_LEVEL_LIST_LOADED] = ""; // Save last loaded list
		}
		if ($rs = $conn->execute($userPrivSql)) {
			$this->UserLevelPriv = $rs->getRows();
			$rs->close();
		}

		// Increase table name field size if necessary
		if (GetConnectionType(USER_LEVEL_PRIV_DBID) == "MYSQL") {
			try {
				if ($rs = $conn->execute("SHOW COLUMNS FROM " . USER_LEVEL_PRIV_TABLE . " LIKE '" . AdjustSql(USER_LEVEL_PRIV_TABLE_NAME_FIELD_2, USER_LEVEL_PRIV_DBID) . "'")) {
					$type = $rs->fields("Type");
					$rs->Close();
					if (preg_match('/varchar\(([\d]+)\)/i', $type, $matches)) {
						$size = (int)$matches[1];
						if ($size < USER_LEVEL_PRIV_TABLE_NAME_FIELD_SIZE)
							$conn->execute("ALTER TABLE " . USER_LEVEL_PRIV_TABLE . " MODIFY COLUMN " . USER_LEVEL_PRIV_TABLE_NAME_FIELD . " VARCHAR(" . USER_LEVEL_PRIV_TABLE_NAME_FIELD_SIZE . ")");
					}
				}
			} catch (\Exception $e) {}
		}

		// Update User Level privileges record if necessary
		$projectID = CurrentProjectID();
		$reloadUserPriv = 0;

		// Update table without prefix
		$sql = "SELECT COUNT(*) FROM " . USER_LEVEL_PRIV_TABLE . " WHERE EXISTS(SELECT * FROM " .
				USER_LEVEL_PRIV_TABLE . " WHERE " . USER_LEVEL_PRIV_TABLE_NAME_FIELD . " NOT LIKE '{%')";
		if (ExecuteScalar($sql, $conn) > 0) {
			$ar = array_map(function ($t) {
				return "'" . AdjustSql($t, USER_LEVEL_PRIV_DBID) . "'";
			}, $arTable);
			$sql = "UPDATE " . USER_LEVEL_PRIV_TABLE . " SET " .
				USER_LEVEL_PRIV_TABLE_NAME_FIELD . " = " . $conn->concat("'" . AdjustSql($projectID, USER_LEVEL_PRIV_DBID) . "'", USER_LEVEL_PRIV_TABLE_NAME_FIELD) . " WHERE " .
				USER_LEVEL_PRIV_TABLE_NAME_FIELD . " IN (" . implode(",", $ar) . ")";
			if ($conn->execute($sql))
				$reloadUserPriv += $conn->Affected_Rows();
		}

		// Update table with report prefix
		if ($RELATED_PROJECT_ID <> "") {
			$sql = "SELECT COUNT(*) FROM " . USER_LEVEL_PRIV_TABLE . " WHERE EXISTS(SELECT * FROM " .
				USER_LEVEL_PRIV_TABLE . " WHERE " . USER_LEVEL_PRIV_TABLE_NAME_FIELD . " LIKE '" .
				AdjustSql(TABLE_PREFIX, USER_LEVEL_PRIV_DBID) . "%')";
			if (ExecuteScalar($sql, $conn) > 0) {
				$ar = array_map(function ($t) {
					return "'" . AdjustSql(TABLE_PREFIX . $t, USER_LEVEL_PRIV_DBID) . "'";
				}, $arTable);
				$sql = "UPDATE " . USER_LEVEL_PRIV_TABLE . " SET " .
					USER_LEVEL_PRIV_TABLE_NAME_FIELD . " = REPLACE(" . USER_LEVEL_PRIV_TABLE_NAME_FIELD . "," .
					"'" . AdjustSql(TABLE_PREFIX, USER_LEVEL_PRIV_DBID) . "','" . AdjustSql($RELATED_PROJECT_ID, USER_LEVEL_PRIV_DBID) . "') WHERE " .
					USER_LEVEL_PRIV_TABLE_NAME_FIELD . " IN (" . implode(",", $ar) . ")";
				if ($conn->execute($sql))
					$reloadUserPriv += $conn->Affected_Rows();
			}
		}

		// Reload the User Level privileges
		if ($reloadUserPriv) {
			if ($rs = $conn->execute($userPrivSql)) {
				$this->UserLevelPriv = $rs->getRows();
				$rs->close();
			}
		}

		// Warn user if user level not setup
		if (count($this->UserLevelPriv) == 0 && $this->isAdmin() && $Page != NULL && @$_SESSION[SESSION_USER_LEVEL_MSG] == "") {
			$Page->setFailureMessage($Language->phrase("NoUserLevel"));
			$_SESSION[SESSION_USER_LEVEL_MSG] = "1"; // Show only once
			$Page->terminate("lokuserlevelslist.php");
		}
		return TRUE;
	}

	// Add user permission
	protected function addUserPermissionEx($userLevelName, $tableName, $userPermission)
	{
		global $PROJECT_ID;

		// Get User Level ID from user name
		$userLevelID = "";
		if (is_array($this->UserLevel)) {
			foreach ($this->UserLevel as $row) {
				list($levelid, $name) = $row;
				if (SameText($userLevelName, $name)) {
					$userLevelID = $levelid;
					break;
				}
			}
		}
		if (is_array($this->UserLevelPriv) && $userLevelID <> "") {
			$cnt = count($this->UserLevelPriv);
			for ($i = 0; $i < $cnt; $i++) {
				list($table, $levelid, $priv) = $this->UserLevelPriv[$i];
				if (SameText($table, $PROJECT_ID . $tableName) && SameString($levelid, $userLevelID)) {
					$this->UserLevelPriv[$i][2] = $priv | $userPermission; // Add permission
					break;
				}
			}
		}
	}

	// Add user permission
	public function addUserPermission($userLevelName, $tableName, $userPermission)
	{
		$arUserLevelName = is_array($userLevelName) ? $userLevelName : [$userLevelName];
		$arTableName = is_array($tableName) ? $tableName : [$tableName];
		foreach ($arUserLevelName as $userLevelName) {
			foreach ($arTableName as $tableName) {
				$this->addUserPermissionEx($userLevelName, $tableName, $userPermission);
			}
		}
	}

	// Delete user permission
	protected function deleteUserPermissionEx($userLevelName, $tableName, $userPermission)
	{
		global $PROJECT_ID;

		// Get User Level ID from user name
		$userLevelID = "";
		if (is_array($this->UserLevel)) {
			foreach ($this->UserLevel as $row) {
				list($levelid, $name) = $row;
				if (SameText($userLevelName, $name)) {
					$userLevelID = $levelid;
					break;
				}
			}
		}
		if (is_array($this->UserLevelPriv) && $userLevelID <> "") {
			$cnt = count($this->UserLevelPriv);
			for ($i = 0; $i < $cnt; $i++) {
				list($table, $levelid, $priv) = $this->UserLevelPriv[$i];
				if (SameText($table, $PROJECT_ID . $tableName) && SameString($levelid, $userLevelID)) {
					$this->UserLevelPriv[$i][2] = $priv & ~$userPermission; // Remove permission
					break;
				}
			}
		}
	}

	// Delete user permission
	public function deleteUserPermission($userLevelName, $tableName, $userPermission)
	{
		$arUserLevelName = is_array($userLevelName) ? $userLevelName : [$userLevelName];
		$arTableName = is_array($tableName) ? $tableName : [$tableName];
		foreach ($arUserLevelName as $userLevelName) {
			foreach ($arTableName as $tableName) {
				$this->deleteUserPermissionEx($userLevelName, $tableName, $userPermission);
			}
		}
	}

	// Load current User Level
	public function loadCurrentUserLevel($table)
	{

		// Load again if user level list changed
		if (@$_SESSION[SESSION_USER_LEVEL_LIST_LOADED] <> "" && @$_SESSION[SESSION_USER_LEVEL_LIST_LOADED] <> @$_SESSION[SESSION_USER_LEVEL_LIST]) {
			$_SESSION[SESSION_AR_USER_LEVEL_PRIV] = "";
		}
		$this->loadUserLevel();
		$this->setSessionUserLevel($this->currentUserLevelPriv($table));
	}

	// Get current user privilege
	protected function currentUserLevelPriv($tableName)
	{
		if ($this->isLoggedIn()) {
			$priv = 0;
			foreach ($this->UserLevelID as $userLevelID)
				$priv |= $this->getUserLevelPrivEx($tableName, $userLevelID);
			return $priv;
		} else { // Anonymous
			return $this->getUserLevelPrivEx($tableName, -2);
		}
	}

	// Get User Level ID by User Level name
	public function getUserLevelID($userLevelName)
	{
		global $Language;
		if (SameString($userLevelName, "Anonymous")) {
			return -2;
		} elseif ($Language && SameString($userLevelName, $Language->phrase("UserAnonymous"))) {
			return -2;
		} elseif (SameString($userLevelName, "Administrator")) {
			return -1;
		} elseif ($Language && SameString($userLevelName, $Language->phrase("UserAdministrator"))) {
			return -1;
		} elseif (SameString($userLevelName, "Default")) {
			return 0;
		} elseif ($Language && SameString($userLevelName, $Language->phrase("UserDefault"))) {
			return 0;
		} elseif ($userLevelName <> "") {
			if (is_array($this->UserLevel)) {
				foreach ($this->UserLevel as $row) {
					list($levelid, $name) = $row;
					if (SameString($name, $userLevelName))
						return $levelid;
				}
			}
		}
		return -2; // Anonymous
	}

	// Add User Level by name
	public function addUserLevel($userLevelName)
	{
		if (strval($userLevelName) == "")
			return;
		$userLevelID = $this->getUserLevelID($userLevelName);
		$this->addUserLevelID($userLevelID);
	}

	// Add User Level by ID
	public function addUserLevelID($userLevelID)
	{
		if (!is_numeric($userLevelID))
			return;
		if ($userLevelID < -1)
			return;
		if (!in_array($userLevelID, $this->UserLevelID)) {
			$this->UserLevelID[] = $userLevelID;
			$_SESSION[SESSION_USER_LEVEL_LIST] = $this->userLevelList(); // Update session variable
		}
	}

	// Delete User Level by name
	public function deleteUserLevel($userLevelName)
	{
		if (strval($userLevelName) == "")
			return;
		$userLevelID = $this->getUserLevelID($userLevelName);
		$this->deleteUserLevelID($userLevelID);
	}

	// Delete User Level by ID
	public function deleteUserLevelID($userLevelID)
	{
		if (!is_numeric($userLevelID))
			return;
		if ($userLevelID < -1)
			return;
		$cnt = count($this->UserLevelID);
		for ($i = 0; $i < $cnt; $i++) {
			if ($this->UserLevelID[$i] == $userLevelID) {
				unset($this->UserLevelID[$i]);
				$_SESSION[SESSION_USER_LEVEL_LIST] = $this->userLevelList(); // Update session variable
				break;
			}
		}
	}

	// User Level list
	public function userLevelList()
	{
		return implode(", ", $this->UserLevelID);
	}

	// User Level name list
	public function userLevelNameList()
	{
		$list = "";
		foreach ($this->UserLevelID as $userLevelID) {
			if ($list <> "")
				$list .= ", ";
			$list .= QuotedValue($this->getUserLevelName($userLevelID), DATATYPE_STRING, USER_LEVEL_DBID);
		}
		return $list;
	}

	// Get user privilege based on table name and User Level
	public function getUserLevelPrivEx($tableName, $userLevelID)
	{
		if (strval($userLevelID) == "-1") { // System Administrator
			return ALLOW_ALL;
		} elseif ($userLevelID >= 0 || $userLevelID == -2) {
			if (is_array($this->UserLevelPriv)) {
				foreach ($this->UserLevelPriv as $row) {
					list($table, $levelid, $priv) = $row;
					if (SameText($table, $tableName) && SameText($levelid, $userLevelID)) {
						if ($priv == NULL || !is_numeric($priv))
							return 0;
						return (int)$priv;
					}
				}
			}
		}
		return 0;
	}

	// Get current User Level name
	public function currentUserLevelName()
	{
		return $this->getUserLevelName($this->currentUserLevelID());
	}

	// Get User Level name based on User Level
	public function getUserLevelName($userLevelID, $lang = TRUE)
	{
		global $Language;
		if (strval($userLevelID) == "-2") {
			return ($lang) ? $Language->phrase("UserAnonymous") : "Anonymous";
		} elseif (strval($userLevelID) == "-1") {
			return ($lang) ? $Language->phrase("UserAdministrator") : "Administrator";
		} elseif (strval($userLevelID) == "0") {
			return ($lang) ? $Language->phrase("UserDefault") : "Default";
		} elseif ($userLevelID > 0) {
			if (is_array($this->UserLevel)) {
				foreach ($this->UserLevel as $row) {
					list($levelid, $name) = $row;
					if (SameString($levelid, $userLevelID)) {
						$userLevelName = "";
						if ($lang)
							$userLevelName = $Language->phrase($name);
						return ($userLevelName <> "") ? $userLevelName : $name;
					}
				}
			}
		}
		return "";
	}

	// Display all the User Level settings (for debug only)
	public function showUserLevelInfo()
	{
		echo "<pre>";
		print_r($this->UserLevel);
		print_r($this->UserLevelPriv);
		echo "</pre>";
		echo "<p>Current User Level ID = " . $this->currentUserLevelID() . "</p>";
		echo "<p>Current User Level ID List = " . $this->userLevelList() . "</p>";
	}

	// Check privilege for List page (for menu items)
	public function allowList($tableName)
	{
		return ($this->currentUserLevelPriv($tableName) & ALLOW_LIST);
	}

	// Check privilege for View page (for Allow-View / Detail-View)
	public function allowView($tableName)
	{
		return ($this->currentUserLevelPriv($tableName) & ALLOW_VIEW);
	}

	// Check privilege for Add page (for Allow-Add / Detail-Add)
	public function allowAdd($tableName)
	{
		return ($this->currentUserLevelPriv($tableName) & ALLOW_ADD);
	}

	// Check privilege for Edit page (for Detail-Edit)
	public function allowEdit($tableName)
	{
		return ($this->currentUserLevelPriv($tableName) & ALLOW_EDIT);
	}

	// Check if user password expired
	public function isPasswordExpired()
	{
		return (@$_SESSION[SESSION_STATUS] == "passwordexpired");
	}

	// Set session password expired
	public function setSessionPasswordExpired()
	{
		$_SESSION[SESSION_STATUS] = "passwordexpired";
	}

	// Set login status
	public function setLoginStatus($status = "")
	{
		$_SESSION[SESSION_STATUS] = $status;
	}

	// Check if user password reset
	public function isPasswordReset()
	{
		return (@$_SESSION[SESSION_STATUS] == "passwordreset");
	}

	// Check if user is logging in (after changing password)
	public function isLoggingIn()
	{
		return (@$_SESSION[SESSION_STATUS] == "loggingin");
	}

	// Check if user is logged in
	public function isLoggedIn()
	{
		return ($this->_isLoggedIn || @$_SESSION[SESSION_STATUS] == "login");
	}

	// Check if user is system administrator
	public function isSysAdmin()
	{
		return (@$_SESSION[SESSION_SYS_ADMIN] == 1);
	}

	// Check if user is administrator
	public function isAdmin()
	{
		$isAdmin = $this->isSysAdmin();
		if (!$isAdmin)
			$isAdmin = $this->CurrentUserLevelID == -1 || in_array(-1, $this->UserLevelID) || $this->canAdmin();
		return $isAdmin;
	}

	// Save User Level to Session
	public function saveUserLevel()
	{

		//$_SESSION[SESSION_PROJECT_ID] = CurrentProjectID(); // Save project id
		$_SESSION[SESSION_AR_USER_LEVEL] = $this->UserLevel;
		$_SESSION[SESSION_AR_USER_LEVEL_PRIV] = $this->UserLevelPriv;
	}

	// Load User Level from Session
	public function loadUserLevel()
	{

		//$projectID = CurrentProjectID();
		//if (!is_array(@$_SESSION[SESSION_AR_USER_LEVEL]) || !is_array(@$_SESSION[SESSION_AR_USER_LEVEL_PRIV]) || $projectID <> @$_SESSION[SESSION_PROJECT_ID]) { // Reload if different project

		if (!is_array(@$_SESSION[SESSION_AR_USER_LEVEL]) || !is_array(@$_SESSION[SESSION_AR_USER_LEVEL_PRIV])) {
			$this->setupUserLevel();
			$this->saveUserLevel();
		} else {
			$this->UserLevel = $_SESSION[SESSION_AR_USER_LEVEL];
			$this->UserLevelPriv = $_SESSION[SESSION_AR_USER_LEVEL_PRIV];
		}
	}

	// Get current user info
	public function currentUserInfo($fldname)
	{
		global $UserTableConn;
		$info = NULL;
		if (defined(PROJECT_NAMESPACE . "USER_TABLE") && !$this->isSysAdmin()) {
			$user = $this->currentUserName();
			if (strval($user) <> "")
				return ExecuteScalar("SELECT " . QuotedName($fldname, USER_TABLE_DBID) . " FROM " . USER_TABLE . " WHERE " .
					str_replace("%u", AdjustSql($user, USER_TABLE_DBID), USER_NAME_FILTER), $UserTableConn);
		}
		return $info;
	}

	// UserID Loading event
	function UserID_Loading() {

		//echo "UserID Loading: " . $this->CurrentUserID() . "<br>";
	}

	// UserID Loaded event
	function UserID_Loaded() {

		//echo "UserID Loaded: " . $this->UserIDList() . "<br>";
	}

	// User Level Loaded event
	function UserLevel_Loaded() {

		//$this->AddUserPermission(<UserLevelName>, <TableName>, <UserPermission>);
		//$this->DeleteUserPermission(<UserLevelName>, <TableName>, <UserPermission>);

	}

	// Table Permission Loading event
	function TablePermission_Loading() {

		//echo "Table Permission Loading: " . $this->CurrentUserLevelID() . "<br>";
	}

	// Table Permission Loaded event
	function TablePermission_Loaded() {

		//echo "Table Permission Loaded: " . $this->CurrentUserLevel . "<br>";
	}

	// User Custom Validate event
	function User_CustomValidate(&$usr, &$pwd) {

		// Enter your custom code to validate user, return TRUE if valid.
		return FALSE;
	}

	// User Validated event
	function User_Validated(&$rs) {

		// Example:
		//$_SESSION['UserEmail'] = $rs['Email'];

	}

	// User PasswordExpired event
	function User_PasswordExpired(&$rs) {

		//echo "User_PasswordExpired";
	}
}
?>
<?php

/**
 * Common functions
 */
// Connection/Query error handler
function ErrorFunc($dbType, $errorType, $errorNo, $errorMsg, $param1, $param2, $obj) {
	if ($errorType == 'CONNECT') {
		if ($dbType == "ado_access" || $dbType == "ado_mssql") {
			$msg = "Failed to connect to database. Error: " . $errorMsg . " (" . $errorNo . ")";
		} else {
			$msg = "Failed to connect to $param2 at $param1. Error: " . $errorMsg . " (" . $errorNo . ")";
		}
	} elseif ($errorType == 'EXECUTE') {
		if (DEBUG_ENABLED) {
			$msg = "Failed to execute SQL: $param1. Error: " . $errorMsg . " (" . $errorNo . ")";
		} else {
			$msg = "Failed to execute SQL. Error: " . $errorMsg . " (" . $errorNo . ")";
		}
	}
	AddMessage($_SESSION[SESSION_FAILURE_MESSAGE], $msg);
}

// Write HTTP header
function WriteHeader($cache, $charset = PROJECT_CHARSET, $json = FALSE) {
	$export = Get("export");
	if ($cache || IsHttps() && $export && !SameText($export, "print")) { // Allow cache
		AddHeader("Cache-Control", "private, must-revalidate");
		AddHeader("Pragma", "public");
	} else { // No cache
		AddHeader("Expires", "Sat, 26 Jul 1997 05:00:00 GMT"); // Date in the past
		AddHeader("Last-Modified", gmdate("D, d M Y H:i:s") . " GMT"); // Always modified
		AddHeader("Cache-Control", "private, no-store, no-cache, must-revalidate");
		AddHeader("Pragma", "no-cache");
	}
	AddHeader("X-UA-Compatible", "IE=edge");
	$ct = "text/html";
	if ($charset <> "")
		$ct .= "; charset=" . $charset;
	if ($json)
		$ct = "application/json; charset=utf-8";
	AddHeader("Content-Type", $ct); // Charset
}

// Get content file extension
function ContentExtension(&$data) {
	global $MIME_TYPES;
	$ct = ContentType($data);
	if ($ct) {
		foreach ($MIME_TYPES as $ext => $mimetype) {
			if ($ct == $mimetype)
				return "." . $ext;
		}
	}
	return ""; // Unknown extension
}

/**
 * Get content type
 * http://en.wikipedia.org/wiki/List_of_file_signatures
 *
 * @param string $data Data of file
 * @param string $fn File path
 * @return string Content type
 */
function ContentType(&$data, $fn = "") {
	global $DEFAULT_MIME_TYPE;
	if (StartsString("\x47\x49\x46\x38\x37\x61", $data) || StartsString("\x47\x49\x46\x38\x39\x61", $data)) { // Check if gif
		return "image/gif";
	} elseif (StartsString("\xFF\xD8\xFF\xE0", $data)) { // Check if jpg
		return "image/jpeg";
	} elseif (StartsString("\x89\x50\x4E\x47\x0D\x0A\x1A\x0A", $data)) { // Check if png
		return "image/png";
	} elseif (StartsString("\x42\x4D", $data)) { // Check if bmp
		return "image/bmp";
	} elseif (StartsString("\x25\x50\x44\x46", $data)) { // Check if pdf
		return "application/pdf";
	} elseif (StartsString("\xD0\xCF\x11\xE0\xA1\xB1\x1A\xE1", $data)) { // xls/doc/ppt
		if (ContainsString($data, "\x77\x6F\x72\x6B\x62\x6F\x6F\x6B")) // xls, find pattern "workbook"
			return "application/vnd.ms-excel";
		elseif (ContainsString($data, "\x57\x6F\x72\x64\x2E\x44\x6F\x63\x75\x6D\x65\x6E\x74")) // doc, find pattern "Word.Document"
			return "application/msword";
	} elseif (StartsString("\x50\x4B\x03\x04", $data)) { // docx/xlsx/pptx/zip
		if (ContainsString($data, "\x78\x6C\x2F\x77\x6F\x72\x6B\x62\x6F\x6F\x6B")) // xlsx, find pattern "x1/workbook"
			return "application/vnd.openxmlformats-officedocument.spreadsheetml.sheet";
		elseif (ContainsString($data, "\x77\x6F\x72\x64\x2F\x5F\x72\x65\x6C")) // docx, find pattern "word/_rel"
			return "application/vnd.openxmlformats-officedocument.wordprocessingml.document";
	} elseif ($fn <> "") { // Use file extension to get mime type
		return MimeContentType($fn);
	}
	return $DEFAULT_MIME_TYPE;
}

/**
 * Get content type for a file
 *
 * @param string $fn File path
 * @return string Content type
 */
function MimeContentType($fn) {
	global $MIME_TYPES, $DEFAULT_MIME_TYPE;
	$ext = strtolower(substr(strrchr($fn, "."), 1));
	$ct = @$MIME_TYPES[$ext];
	if ($ct == "") {
		if (file_exists($fn) && function_exists("finfo_file")) {
			$finfo = finfo_open(FILEINFO_MIME_TYPE);
			$ct = @finfo_file($finfo, $fn);
			finfo_close($finfo);
		} elseif (function_exists("mime_content_type")) {
			$ct = @mime_content_type($fn);
		}
	}
	return $ct ?: $DEFAULT_MIME_TYPE;
}

// Get connection object
function &Conn($dbid = 0) {
	$db = &Db($dbid);
	if ($db && $db["conn"] == NULL)
		ConnectDb($db);
	if ($db)
		$conn = &$db["conn"];
	else
		$conn = FALSE;
	return $conn;
}

// Get database object
function &Db($dbid = 0) {
	global $CONNECTIONS;
	if (EmptyString($dbid))
		$dbid = 0;
	if (array_key_exists($dbid, $CONNECTIONS))
		$db = &$CONNECTIONS[$dbid];
	else
		$db = FALSE;
	return $db;
}

// Get connection type
function GetConnectionType($dbid = 0) {
	$db = Db($dbid);
	if ($db) {
		return $db["type"];
	} elseif (SameText($dbid, "MYSQL")) {
		return "MYSQL";
	} elseif (SameText($dbid, "POSTGRESQL")) {
		return "POSTGRESQL";
	} elseif (SameText($dbid, "ORACLE")) {
		return "ORACLE";
	} elseif (SameText($dbid, "ACCESS")) {
		return "ACCESS";
	} elseif (SameText($dbid, "MSSQL")) {
		return "MSSQL";
	}
	return FALSE;
}

// Connect to database
function &GetConnection($dbid = 0) {
	return Conn($dbid);
}

// Connect to database
function ConnectDb(&$info) {
	global $DATE_FORMAT;
	$GLOBALS["ADODB_FETCH_MODE"] = 3; // ADODB_FETCH_BOTH
	$GLOBALS["ADODB_COUNTRECS"] = FALSE;

	// Database connecting event
	Database_Connecting($info);
	$dbid = @$info["id"];
	$dbtype = @$info["type"];
	if ($dbtype == "ACCESS" && !class_exists("COM"))
		die("<strong>PHP COM extension required for database type '" . $dbtype . "' is not installed on this server.</strong> Note that Windows server is required for database type '" . $dbtype . "' and as of PHP 5.3.15/5.4.5, the COM extension requires php_com_dotnet.dll to be enabled in php.ini. See <a href='http://php.net/manual/en/com.installation.php'>http://php.net/manual/en/com.installation.php</a> for details."); //** side effect
	if ($dbtype == "MYSQL") {
		if (USE_ADODB) {
			$conn = ADONewConnection('mysqli');
		} else {
			$conn = new \MySqlConnection();
		}
	} elseif ($dbtype == "POSTGRESQL") {
		$conn = ADONewConnection('postgres7');
	} elseif ($dbtype == "MSSQL") {
		$conn = ADONewConnection('mssqlnative');
		$conn->connectionInfo = ["ReturnDatesAsStrings" => TRUE];
		if (SameText(PROJECT_CHARSET, "utf-8"))
			$conn->connectionInfo["CharacterSet"] = "UTF-8";
		if (is_array(@$info["connectionInfo"]))
			$conn->connectionInfo = array_merge($conn->connectionInfo, $info["connectionInfo"]);
	} elseif ($dbtype == "SQLITE") {
		$conn = ADONewConnection('sqlite3');
	} elseif ($dbtype == "ACCESS") {
		$conn = ADONewConnection('ado_access');
	} elseif ($dbtype == "ORACLE") {
		$conn = ADONewConnection('oci805');
		$conn->NLS_DATE_FORMAT = 'RRRR-MM-DD HH24:MI:SS';
	}

	// Decrypt user name / password if necessary
	if (ENCRYPTION_ENABLED) {
		try {
			if (array_key_exists("user", $info))
				$info["user"] = PhpDecrypt($info["user"], ENCRYPTION_KEY);
			if (array_key_exists("pass", $info))
				$info["pass"] = PhpDecrypt($info["pass"], ENCRYPTION_KEY);
		} catch (\Defuse\Crypto\Exception\WrongKeyOrModifiedCiphertextException $e) {}
	}
	$conn->info = $info;
	$conn->debug = DEBUG_ENABLED;
	if ($dbtype == "MYSQL" || $dbtype == "POSTGRESQL" || $dbtype == "ORACLE" || $dbtype == "MSSQL")
		$conn->port = (int)@$info["port"];
	if ($dbtype == "ORACLE") {
		if (isset($info["charset"]))
			$conn->charSet = $info["charset"];
	}
	$conn->raiseErrorFn = (DEBUG_ENABLED) ? $GLOBALS["ERROR_FUNC"] : "";
	if ($dbtype == "MYSQL" || $dbtype == "POSTGRESQL" || $dbtype == "ORACLE") {
		if ($dbtype == "MYSQL")
			$conn->Connect(@$info["host"], @$info["user"], @$info["pass"], @$info["db"], @$info["new"]);
		else
			$conn->Connect(@$info["host"], @$info["user"], @$info["pass"], @$info["db"]);
		$timezone = @$info["timezone"] ?: DB_TIME_ZONE;
		if ($dbtype == "MYSQL") {
			if (MYSQL_CHARSET <> "")
				$conn->Execute("SET NAMES '" . MYSQL_CHARSET . "'");
			if ($timezone <> "")
				$conn->Execute("SET time_zone = '" . $timezone . "'");
		}
		if ($dbtype == "POSTGRESQL") {
			if (POSTGRESQL_CHARSET <> "")
				$conn->Execute("SET NAMES '" . POSTGRESQL_CHARSET . "'");
			if ($timezone <> "")
				$conn->Execute("SET TIME ZONE '" . $timezone . "'");
		}
		if ($dbtype == "ORACLE") {

			// Set schema
			$conn->Execute("ALTER SESSION SET CURRENT_SCHEMA = ". QuotedName(@$info["schema"], $dbid));
			$conn->Execute("ALTER SESSION SET NLS_TIMESTAMP_FORMAT = 'yyyy-mm-dd hh24:mi:ss'");
			$conn->Execute("ALTER SESSION SET NLS_TIMESTAMP_TZ_FORMAT = 'yyyy-mm-dd hh24:mi:ss'");
			if ($timezone <> "")
				$conn->Execute("ALTER SESSION SET TIME_ZONE = '" . $timezone . "'");
		}
		if ($dbtype == "POSTGRESQL") {

			// Set schema
			if (@$info["schema"] <> "public" && @$info["schema"] <> "")
				$conn->Execute("SET search_path TO " . QuotedName($info["schema"], $dbid));
		}
	} elseif ($dbtype == "SQLITE") {
		$relpath = @$info["relpath"];
		$dbname = @$info["dbname"];
		if ($relpath == "")
			$datasource = realpath($GLOBALS["RELATIVE_PATH"] . $dbname);

		//elseif (StartsString(".", $relpath)) // Relative path starting with "." or ".." (relative to app root)
			//$datasource = ServerMapPath($relpath . $dbname);

		elseif (StartsString("\\\\", $relpath) || ContainsString($relpath, ":")) // Physical path
			$datasource = $relpath . $dbname;
		else // Relative to app root
			$datasource = ServerMapPath($relpath) . $dbname;
		$conn->Connect($datasource);
	} elseif ($dbtype == "ACCESS") {
		if (PROJECT_CODEPAGE > 0)
			$conn->charPage = PROJECT_CODEPAGE;
		$relpath = @$info["relpath"];
		$dbname = @$info["dbname"];
		$provider = @$info["provider"];
		$password = @$info["password"];
		if ($relpath == "")
			$datasource = realpath($GLOBALS["RELATIVE_PATH"] . $dbname);

		//elseif (StartsString(".", $relpath))  // Relative path starting with "." or ".." (relative to app root)
			//$datasource = ServerMapPath($relpath . $dbname);

		elseif (StartsString("\\\\", $relpath) || ContainsString($relpath, ":")) // Physical path
			$datasource = $relpath . $dbname;
		else // Relative to app root
			$datasource = ServerMapPath($relpath) . $dbname;
		if ($password <> "")
			$connstr = $provider . ";Data Source=" . $datasource . ";Jet OLEDB:Database Password=" . $password . ";";
		elseif (EndsText(".accdb", $dbname)) // Access database
			$connstr = $provider . ";Data Source=" . $datasource . ";Persist Security Info=False;";
		else
			$connstr = $provider . ";Data Source=" . $datasource . ";";
		$conn->Connect($connstr, FALSE, FALSE);
	} elseif ($dbtype == "MSSQL") {
		$conn->Connect(@$info["host"], @$info["user"], @$info["pass"], @$info["db"]);

		// Set date format
		if ($DATE_FORMAT <> "")
			$conn->Execute("SET DATEFORMAT ymd");
	}

	//$conn->raiseErrorFn = '';
	// Database connected event

	Database_Connected($conn);
	$info["conn"] = &$conn;
}

// Close database connections
function CloseConnections() {
	global $CONNECTIONS;
	foreach ($CONNECTIONS as $dbid => &$db) {
		if ($db["conn"])
			$db["conn"]->Close();
		$db["conn"] = NULL;
	}
	$GLOBALS["Conn"] = NULL;
}

// Database Connecting event
function Database_Connecting(&$info) {

	// Example:
	//var_dump($info);
	//if ($info["id"] == "DB" && CurrentUserIP() == "127.0.0.1") { // Testing on local PC
	//	$info["host"] = "locahost";
	//	$info["user"] = "root";
	//	$info["pass"] = "";
	//}

}

// Database Connected event
function Database_Connected(&$conn) {

	// Example:
	//if ($conn->info["id"] == "DB")
	//	$conn->Execute("Your SQL");

}

// Cast date/time field for LIKE
function CastDateFieldForLike($fld, $namedformat, $dbid = 0) {
	global $DATE_SEPARATOR, $TIME_SEPARATOR, $DATE_FORMAT, $DATE_FORMAT_ID;
	$dbtype = GetConnectionType($dbid);
	$isDateTime = FALSE; // Date/Time
	if ($namedformat == 0 || $namedformat == 1 || $namedformat == 2 || $namedformat == 8) {
		$isDateTime = ($namedformat == 1 || $namedformat == 8);
		$namedformat = $DATE_FORMAT_ID;
	}
	$shortYear = ($namedformat >= 12 && $namedformat <= 17);
	$isDateTime = $isDateTime || in_array($namedformat, [9, 10, 11, 15, 16, 17]);
	$dateFormat = "";
	switch ($namedformat) {
		case 3:
			if ($dbtype == "MYSQL") {
				$dateFormat = "%h" . $TIME_SEPARATOR . "%i" . $TIME_SEPARATOR . "%s %p";
			} else if ($dbtype == "ACCESS") {
				$dateFormat = "hh" . $TIME_SEPARATOR . "nn" . $TIME_SEPARATOR . "ss AM/PM";
			} else if ($dbtype == "MSSQL") {
				$dateFormat = "REPLACE(LTRIM(RIGHT(CONVERT(VARCHAR(19), %s, 0), 7)), ':', '" . $TIME_SEPARATOR . "')"; // Use hh:miAM (or PM) only or SQL too lengthy
			} else if ($dbtype == "ORACLE") {
				$dateFormat = "HH" . $TIME_SEPARATOR . "MI" . $TIME_SEPARATOR . "SS AM";
			}
			break;
		case 4:
			if ($dbtype == "MYSQL") {
				$dateFormat = "%H" . $TIME_SEPARATOR . "%i" . $TIME_SEPARATOR . "%s";
			} else if ($dbtype == "ACCESS") {
				$dateFormat = "hh" . $TIME_SEPARATOR . "nn" . $TIME_SEPARATOR . "ss";
			} else if ($dbtype == "MSSQL") {
				$dateFormat = "REPLACE(CONVERT(VARCHAR(8), %s, 108), ':', '" . $TIME_SEPARATOR . "')";
			} else if ($dbtype == "ORACLE") {
				$dateFormat = "HH24" . $TIME_SEPARATOR . "MI" . $TIME_SEPARATOR . "SS";
			}
			break;
		case 5: case 9: case 12: case 15:
			if ($dbtype == "MYSQL") {
				$dateFormat = ($shortYear ? "%y" : "%Y") . $DATE_SEPARATOR . "%m" . $DATE_SEPARATOR . "%d";
				if ($isDateTime) $dateFormat .= " %H" . $TIME_SEPARATOR . "%i" . $TIME_SEPARATOR . "%s";
			} else if ($dbtype == "ACCESS") {
				$dateFormat = ($shortYear ? "yy" : "yyyy") . $DATE_SEPARATOR . "mm" . $DATE_SEPARATOR . "dd";
				if ($isDateTime) $dateFormat .= " hh" . $TIME_SEPARATOR . "nn" . $TIME_SEPARATOR . "ss";
			} else if ($dbtype == "MSSQL") {
				$dateFormat = "REPLACE(" . ($shortYear ? "CONVERT(VARCHAR(8), %s, 2)" : "CONVERT(VARCHAR(10), %s, 102)") . ", '.', '" . $DATE_SEPARATOR . "')";
				if ($isDateTime) $dateFormat = "(" . $dateFormat . " + ' ' + REPLACE(CONVERT(VARCHAR(8), %s, 108), ':', '" . $TIME_SEPARATOR . "'))";
			} else if ($dbtype == "ORACLE") {
				$dateFormat = ($shortYear ? "YY" : "YYYY") . $DATE_SEPARATOR . "MM" . $DATE_SEPARATOR . "DD";
				if ($isDateTime) $dateFormat .= " HH24" . $TIME_SEPARATOR . "MI" . $TIME_SEPARATOR . "SS";
			}
			break;
		case 6: case 10: case 13: case 16:
			if ($dbtype == "MYSQL") {
				$dateFormat = "%m" . $DATE_SEPARATOR . "%d" . $DATE_SEPARATOR . ($shortYear ? "%y" : "%Y");
				if ($isDateTime) $dateFormat .= " %H" . $TIME_SEPARATOR . "%i" . $TIME_SEPARATOR . "%s";
			} else if ($dbtype == "ACCESS") {
				$dateFormat = "mm" . $DATE_SEPARATOR . "dd" . $DATE_SEPARATOR . ($shortYear ? "yy" : "yyyy");
				if ($isDateTime) $dateFormat .= " hh" . $TIME_SEPARATOR . "nn" . $TIME_SEPARATOR . "ss";
			} else if ($dbtype == "MSSQL") {
				$dateFormat = "REPLACE(" . ($shortYear ? "CONVERT(VARCHAR(8), %s, 1)" : "CONVERT(VARCHAR(10), %s, 101)") . ", '/', '" . $DATE_SEPARATOR . "')";
				if ($isDateTime) $dateFormat = "(" . $dateFormat . " + ' ' + REPLACE(CONVERT(VARCHAR(8), %s, 108), ':', '" . $TIME_SEPARATOR . "'))";
			} else if ($dbtype == "ORACLE") {
				$dateFormat = "MM" . $DATE_SEPARATOR . "DD" . $DATE_SEPARATOR . ($shortYear ? "YY" : "YYYY");
				if ($isDateTime) $dateFormat .= " HH24" . $TIME_SEPARATOR . "MI" . $TIME_SEPARATOR . "SS";
			}
			break;
		case 7: case 11: case 14: case 17:
			if ($dbtype == "MYSQL") {
				$dateFormat = "%d" . $DATE_SEPARATOR . "%m" . $DATE_SEPARATOR . ($shortYear ? "%y" : "%Y");
				if ($isDateTime) $dateFormat .= " %H" . $TIME_SEPARATOR . "%i" . $TIME_SEPARATOR . "%s";
			} else if ($dbtype == "ACCESS") {
				$dateFormat = "dd" . $DATE_SEPARATOR . "mm" . $DATE_SEPARATOR . ($shortYear ? "yy" : "yyyy");
				if ($isDateTime) $dateFormat .= " hh" . $TIME_SEPARATOR . "nn" . $TIME_SEPARATOR . "ss";
			} else if ($dbtype == "MSSQL") {
				$dateFormat = "REPLACE(" . ($shortYear ? "CONVERT(VARCHAR(8), %s, 3)" : "CONVERT(VARCHAR(10), %s, 103)") . ", '/', '" . $DATE_SEPARATOR . "')";
				if ($isDateTime) $dateFormat = "(" . $dateFormat . " + ' ' + REPLACE(CONVERT(VARCHAR(8), %s, 108), ':', '" . $TIME_SEPARATOR . "'))";
			} else if ($dbtype == "ORACLE") {
				$dateFormat = "DD" . $DATE_SEPARATOR . "MM" . $DATE_SEPARATOR . ($shortYear ? "YY" : "YYYY");
				if ($isDateTime) $dateFormat .= " HH24" . $TIME_SEPARATOR . "MI" . $TIME_SEPARATOR . "SS";
			}
			break;
	}
	if ($dateFormat) {
		if ($dbtype == "MYSQL") {
			return "DATE_FORMAT(" . $fld . ", '" . $dateFormat . "')";
		} else if ($dbtype == "ACCESS") {
			return "FORMAT(" . $fld . ", '" . $dateFormat . "')";
		} else if ($dbtype == "MSSQL") {
			return str_replace("%s", $fld, $dateFormat);
		} else if ($dbtype == "ORACLE") {
			return "TO_CHAR(" . $fld . ", '" . $dateFormat . "')";
		}
	}
	return $fld;
}

// Append like operator
function Like($pat, $dbid = 0) {
	$dbtype = GetConnectionType($dbid);
	if ($dbtype == "POSTGRESQL") {
		return (USE_ILIKE_FOR_POSTGRESQL ? " ILIKE " : " LIKE ") . $pat;
	} elseif ($dbtype == "MYSQL") {
		if (LIKE_COLLATION_FOR_MYSQL <> "") {
			return " LIKE " . $pat . " COLLATE " . LIKE_COLLATION_FOR_MYSQL;
		} else {
			return " LIKE " . $pat;
		}
	} elseif ($dbtype == "MSSQL") {
		if (LIKE_COLLATION_FOR_MSSQL <> "") {
			return " COLLATE " . LIKE_COLLATION_FOR_MSSQL . " LIKE " . $pat;
		} else {
			return " LIKE " . $pat;
		}
	} else {
		return " LIKE " . $pat;
	}
}

// Return multi-value search SQL
function GetMultiSearchSql(&$fld, $fldOpr, $fldVal, $dbid) {
	if ($fldOpr == "IS NULL" || $fldOpr == "IS NOT NULL") {
		return $fld->Expression . " " . $fldOpr;
	} else {
		if ($fldOpr == "LIKE")
			$wrk = "";
		else
			$wrk = $fld->Expression . SearchString($fldOpr, $fldVal, DATATYPE_STRING, $dbid);
		$arVal = explode(",", $fldVal);
		$dbtype = GetConnectionType($dbid);
		foreach ($arVal as $val) {
			$val = trim($val);
			if ($val == NULL_VALUE) {
				$sql = $fld->Expression . " IS NULL";
			} elseif ($val == NOT_NULL_VALUE) {
				$sql = $fld->Expression . " IS NOT NULL";
			} else {
				if ($fldOpr == "LIKE") {
					if ($dbtype == "MYSQL") {
						$sql = "FIND_IN_SET('" . AdjustSql($val, $dbid) . "', " . $fld->Expression . ")";
					} else {
						if (count($arVal) == 1 || SEARCH_MULTI_VALUE_OPTION == 3) {
							$sql = $fld->Expression . " = '" . AdjustSql($val, $dbid) . "' OR " . GetMultiSearchSqlPart($fld, $val, $dbid);
						} else {
							$sql = GetMultiSearchSqlPart($fld, $val, $dbid);
						}
					}
				} else {
					$sql = $fld->Expression . SearchString($fldOpr, $val, DATATYPE_STRING, $dbid);
				}
			}
			if ($wrk <> "") {
				if (SEARCH_MULTI_VALUE_OPTION == 2) {
					$wrk .= " AND ";
				} elseif (SEARCH_MULTI_VALUE_OPTION == 3) {
					$wrk .= " OR ";
				}
			}
			$wrk .= "($sql)";
		}
		return $wrk;
	}
}

// Get multi search SQL part
function GetMultiSearchSqlPart(&$fld, $fldVal, $dbid) {
	return $fld->Expression . Like("'" . AdjustSql($fldVal, $dbid) . ",%'", $dbid) . " OR " .
		$fld->Expression . Like("'%," . AdjustSql($fldVal, $dbid) . ",%'", $dbid) . " OR " .
		$fld->Expression . Like("'%," . AdjustSql($fldVal, $dbid) . "'", $dbid);
}

// Check if float format
function IsFloatFormat($fldType) {
	return ($fldType == 4 || $fldType == 5 || $fldType == 131 || $fldType == 6);
}

// Check if is numeric
function IsNumeric($value) {
	$value = ConvertToFloatString($value);
	return is_numeric($value);
}

// Get search SQL
function GetSearchSql(&$fld, $fldVal, $fldOpr, $fldCond, $fldVal2, $fldOpr2, $dbid) {
	$sql = "";
	$virtual = ($fld->IsVirtual && $fld->VirtualSearch);
	$fldExpression = ($virtual) ? $fld->VirtualExpression : $fld->Expression;
	$fldDataType = $fld->DataType;
	if (IsFloatFormat($fld->Type)) {
		$fldVal = ConvertToFloatString($fldVal);
		$fldVal2 = ConvertToFloatString($fldVal2);
	}
	if ($virtual)
		$fldDataType = DATATYPE_STRING;
	if ($fldDataType == DATATYPE_NUMBER) { // Fix wrong operator
		if ($fldOpr == "LIKE" || $fldOpr == "STARTS WITH" || $fldOpr == "ENDS WITH") {
			$fldOpr = "=";
		} elseif ($fldOpr == "NOT LIKE") {
			$fldOpr = "<>";
		}
		if ($fldOpr2 == "LIKE" || $fldOpr2 == "STARTS WITH" || $fldOpr2 == "ENDS WITH") {
			$fldOpr2 = "=";
		} elseif ($fldOpr2 == "NOT LIKE") {
			$fldOpr2 = "<>";
		}
	}
	if ($fldOpr == "BETWEEN") {
		$isValidValue = ($fldDataType <> DATATYPE_NUMBER) ||
			($fldDataType == DATATYPE_NUMBER && is_numeric($fldVal) && is_numeric($fldVal2));
		if ($fldVal <> "" && $fldVal2 <> "" && $isValidValue)
			$sql = $fldExpression . " BETWEEN " . QuotedValue($fldVal, $fldDataType, $dbid) .
				" AND " . QuotedValue($fldVal2, $fldDataType, $dbid);
	} else {

		// Handle first value
		if ($fldVal == NULL_VALUE || $fldOpr == "IS NULL") {
			$sql = $fld->Expression . " IS NULL";
		} elseif ($fldVal == NOT_NULL_VALUE || $fldOpr == "IS NOT NULL") {
			$sql = $fld->Expression . " IS NOT NULL";
		} else {
			$isValidValue = ($fldDataType <> DATATYPE_NUMBER) ||
				($fldDataType == DATATYPE_NUMBER && is_numeric($fldVal));
			if ($fldVal <> "" && $isValidValue && IsValidOpr($fldOpr, $fldDataType)) {
				$sql = $fldExpression . SearchString($fldOpr, $fldVal, $fldDataType, $dbid);
				if ($fld->DataType == DATATYPE_BOOLEAN && $fldVal == $fld->FalseValue && $fldOpr == "=")
					$sql = "(" . $sql . " OR " . $fldExpression . " IS NULL)";
			}
		}

		// Handle second value
		$sql2 = "";
		if ($fldVal2 == NULL_VALUE || $fldOpr2 == "IS NULL") {
			$sql2 = $fld->Expression . " IS NULL";
		} elseif ($fldVal2 == NOT_NULL_VALUE || $fldOpr2 == "IS NOT NULL") {
			$sql2 = $fld->Expression . " IS NOT NULL";
		} else {
			$isValidValue = ($fldDataType <> DATATYPE_NUMBER) ||
				($fldDataType == DATATYPE_NUMBER && is_numeric($fldVal2));
			if ($fldVal2 <> "" && $isValidValue && IsValidOpr($fldOpr2, $fldDataType)) {
				$sql2 = $fldExpression . SearchString($fldOpr2, $fldVal2, $fldDataType, $dbid);
				if ($fld->DataType == DATATYPE_BOOLEAN && $fldVal2 == $fld->FalseValue && $fldOpr2 == "=")
					$sql2 = "(" . $sql2 . " OR " . $fldExpression . " IS NULL)";
			}
		}

		// Combine SQL
		if ($sql2 <> "") {
			if ($sql <> "")
				$sql = "(" . $sql . " " . (($fldCond == "OR") ? "OR" : "AND") . " " . $sql2 . ")";
			else
				$sql = $sql2;
		}
	}
	return $sql;
}

// Return search string
function SearchString($fldOpr, $fldVal, $fldType, $dbid) {
	if (strval($fldVal) == NULL_VALUE || $fldOpr == "IS NULL") {
		return " IS NULL";
	} elseif (strval($fldVal) == NOT_NULL_VALUE || $fldOpr == "IS NOT NULL") {
		return " IS NOT NULL";
	} elseif ($fldOpr == "LIKE") {
		return Like(QuotedValue("%$fldVal%", $fldType, $dbid), $dbid);
	} elseif ($fldOpr == "NOT LIKE") {
		return " NOT " . Like(QuotedValue("%$fldVal%", $fldType, $dbid), $dbid);
	} elseif ($fldOpr == "STARTS WITH") {
		return Like(QuotedValue("$fldVal%", $fldType, $dbid), $dbid);
	} elseif ($fldOpr == "ENDS WITH") {
		return Like(QuotedValue("%$fldVal", $fldType, $dbid), $dbid);
	} else {
		if ($fldType == DATATYPE_NUMBER && !is_numeric($fldVal)) // Invalid field value
 			return " = -1 AND 1 = 0"; // Always false
		else
			return " " . $fldOpr . " " . QuotedValue($fldVal, $fldType, $dbid);
	}
}

// Check if valid operator
function IsValidOpr($opr, $fldType) {
	$valid = ($opr == "=" || $opr == "<" || $opr == "<=" ||
		$opr == ">" || $opr == ">=" || $opr == "<>");
	if ($fldType == DATATYPE_STRING || $fldType == DATATYPE_MEMO || $fldType == DATATYPE_XML)
		$valid = ($valid || $opr == "LIKE" || $opr == "NOT LIKE" || $opr == "STARTS WITH" || $opr == "ENDS WITH");
	return $valid;
}

// Quote table/field name based on dbid
function QuotedName($name, $dbid = 0) {
	global $CONNECTIONS;
	$db = @$CONNECTIONS[$dbid];
	if ($db) {
		$qs = $db["qs"];
		$qe = $db["qe"];
		$name = str_replace($qe, $qe . $qe, $name);
		return $qs . $name . $qe;
	} else { // Use default quotes
		$name = str_replace(DB_QUOTE_END, DB_QUOTE_END . DB_QUOTE_END, $name);
		return DB_QUOTE_START . $name . DB_QUOTE_END;
	}
}

// Quote field value based on dbid
function QuotedValue($value, $fldType, $dbid = 0) {
	if ($value === NULL)
		return "NULL";
	$dbtype = GetConnectionType($dbid);
	switch ($fldType) {
		case DATATYPE_STRING:
		case DATATYPE_MEMO:
			if (REMOVE_XSS)
				$value = RemoveXss($value);
			if ($dbtype == "MSSQL")
				return "N'" . AdjustSql($value, $dbid) . "'";
			else
				return "'" . AdjustSql($value, $dbid) . "'";
		case DATATYPE_TIME:
			if (REMOVE_XSS)
				$value = RemoveXss($value);
			return "'" . AdjustSql($value, $dbid) . "'";
		case DATATYPE_XML:
			return "'" . AdjustSql($value, $dbid) . "'";
		case DATATYPE_BLOB:
			if ($dbtype == "MYSQL") {
				return "'" . addslashes($value) . "'";
			} elseif ($dbtype == "POSTGRESQL") {
				return "'" . Conn($dbid)->blobEncode($value) . "'";
			} else {
				return "0x" . bin2hex($value);
			}
		case DATATYPE_DATE:
			if ($dbtype == "ACCESS")
				return "#" . AdjustSql($value, $dbid) . "#";
			else
				return "'" . AdjustSql($value, $dbid) . "'";
		case DATATYPE_GUID:
			if ($dbtype == "ACCESS") {
				if (strlen($value) == 38) {
					return "{guid " . $value . "}";
				} elseif (strlen($value) == 36) {
					return "{guid {" . $value . "}}";
				}
			} else {
				return "'" . $value . "'";
			}
		case DATATYPE_BOOLEAN:
			if ($dbtype == "MYSQL" || $dbtype == "POSTGRESQL")
				return "'" . $value . "'"; // 'Y'|'N' or 'y'|'n' or '1'|'0' or 't'|'f'
			else
				return $value;
		case DATATYPE_NUMBER:
			if (IsNumeric($value))
				return $value;
			else
				return "NULL"; // Treat as null
		default:
			return $value;
	}
}

// Convert different data type value
function ConvertValue($v, $t) {
	switch ($t) {
	case 2:
	case 3:
	case 16:
	case 17:
	case 18:
	case 19: // If adSmallInt/adInteger/adTinyInt/adUnsignedTinyInt/adUnsignedSmallInt
		return ($v === NULL) ? NULL : (int)$v;
	case 4:
	Case 5:
	case 6:
	case 131:
	case 139: // If adSingle/adDouble/adCurrency/adNumeric/adVarNumeric
		return ($v === NULL) ? NULL : (float)$v;
	default:
		return ($v === NULL) ? NULL : $v;
	}
}

// Convert string to float
function ConvertToFloatString($v) {
	global $THOUSANDS_SEP, $DECIMAL_POINT;
	$v = str_replace(" ", "", $v);
	$v = str_replace([$THOUSANDS_SEP, $DECIMAL_POINT], ["", "."], $v);
	return $v;
}

// Convert string to int
function ConvertToIntegerString($v) {
	global $DECIMAL_POINT;
	$v = ConvertToFloatString($v);
	$ar = explode($DECIMAL_POINT, $v);
	return $ar[0];
}

// Concat string
function Concat($str1, $str2, $sep) {
	$str1 = trim($str1);
	$str2 = trim($str2);
	if ($str1 <> "" && $sep <> "" && !EndsString($sep, $str1))
		$str1 .= $sep;
	return $str1 . $str2;
}

// Write message to debug file
function Trace($msg) {
	$filename = "debug.txt";
	if (!$handle = fopen($filename, 'a')) exit;
	if (is_writable($filename))
		fwrite($handle, $msg . "\n");
	fclose($handle);
}

// Compare values with special handling for null values
function CompareValue($v1, $v2) {
	if ($v1 === NULL && $v2 === NULL) {
		return TRUE;
	} elseif ($v1 === NULL || $v2 === NULL) {
		return FALSE;
	} else {
		return ($v1 == $v2);
	}
}

// Check if boolean value is TRUE
function ConvertToBool($value) {
	return $value === TRUE || SameText($value, "1") || SameText($value, "y") || SameText($value, "t") || SameText($value, "true");
}

// Add message
function AddMessage(&$msg, $msgtoadd, $sep = "<br>") {
	if (strval($msgtoadd) <> "") {
		if (strval($msg) <> "")
			$msg .= $sep;
		$msg .= $msgtoadd;
	}
}

/**
 * Add filter
 *
 * @param string $filter Filter
 * @param string|callable $newfilter New filter
 * @return void
 */
function AddFilter(&$filter, $newfilter) {
	if (is_callable($newfilter))
		$newfilter = $newfilter();
	if (trim($newfilter) == "")
		return;
	if (trim($filter) <> "") {
		$filter = "(" . $filter . ") AND (" . $newfilter . ")";
	} else {
		$filter = $newfilter;
	}
}

// Adjust SQL based on dbid
function AdjustSql($val, $dbid = 0) {
	$dbtype = GetConnectionType($dbid);
	if ($dbtype == "MYSQL") {
		$val = addslashes(trim($val));
	} else {
		$val = str_replace("'", "''", trim($val)); // Adjust for single quote
	}
	return $val;
}

// Build SELECT SQL based on different sql part
function BuildSelectSql($select, $where, $groupBy, $having, $orderBy, $filter, $sort) {
	$dbWhere = $where;
	AddFilter($dbWhere, $filter);
	$dbOrderBy = $orderBy;
	if ($sort <> "")
		$dbOrderBy = $sort;
	$sql = $select;
	if ($dbWhere <> "")
		$sql .= " WHERE " . $dbWhere;
	if ($groupBy <> "")
		$sql .= " GROUP BY " . $groupBy;
	if ($having <> "")
		$sql .= " HAVING " . $having;
	if ($dbOrderBy <> "")
		$sql .= " ORDER BY " . $dbOrderBy;
	return $sql;
}

// Write audit trail
function WriteAuditTrail($pfx, $dt, $script, $usr, $action, $table, $field, $keyvalue, $oldvalue, $newvalue) {
	if ($table === AUDIT_TRAIL_TABLE_NAME)
		return;
	$usrwrk = $usr;
	if ($usrwrk == "") // Assume Administrator if no user
		$usrwrk = "-1";
	if (AUDIT_TRAIL_TO_DATABASE)
		$rsnew = [
			AUDIT_TRAIL_FIELD_NAME_DATETIME => $dt,
			AUDIT_TRAIL_FIELD_NAME_SCRIPT => $script,
			AUDIT_TRAIL_FIELD_NAME_USER => $usrwrk,
			AUDIT_TRAIL_FIELD_NAME_ACTION => $action,
			AUDIT_TRAIL_FIELD_NAME_TABLE => $table,
			AUDIT_TRAIL_FIELD_NAME_FIELD => $field,
			AUDIT_TRAIL_FIELD_NAME_KEYVALUE => $keyvalue,
			AUDIT_TRAIL_FIELD_NAME_OLDVALUE => $oldvalue,
			AUDIT_TRAIL_FIELD_NAME_NEWVALUE => $newvalue
		];
	else
		$rsnew = [
			"datetime" => $dt,
			"script" => $script,
			"user" => $usrwrk,
			"action" => $action,
			"table" => $table,
			"field" => $field,
			"keyvalue" => $keyvalue,
			"oldvalue" => $oldvalue,
			"newvalue" => $newvalue
		];

	// Call AuditTrail Inserting event
	$writeAuditTrail = AuditTrail_Inserting($rsnew);
	if ($writeAuditTrail) {
		if (AUDIT_TRAIL_TO_DATABASE) {
			$tblcls = PROJECT_NAMESPACE . AUDIT_TRAIL_TABLE_VAR;
			$tbl = new $tblcls();
			if ($tbl->Row_Inserting(NULL, $rsnew)) {
				if ($tbl->insert($rsnew))
					$tbl->Row_Inserted(NULL, $rsnew);
			}
		} else {
			$tab = "\t";
			$header = "date/time" . $tab . "script" . $tab . "user" . $tab .
				"action" . $tab . "table" . $tab . "field" . $tab .
				"key value" . $tab . "old value" . $tab . "new value";
			$msg = $rsnew["datetime"] . $tab . $rsnew["script"] . $tab . $rsnew["user"] . $tab .
					$rsnew["action"] . $tab . $rsnew["table"] . $tab . $rsnew["field"] . $tab .
					$rsnew["keyvalue"] . $tab . $rsnew["oldvalue"] . $tab . $rsnew["newvalue"];
			$folder = AUDIT_TRAIL_PATH;
			$fn = $pfx . "_" . date("Ymd") . ".txt";
			$filename = ServerMapPath($folder) . $fn;
			if (file_exists($filename)) {
				$fileHandler = fopen($filename, "a+b");
			} else {
				$fileHandler = fopen($filename, "a+b");
				fwrite($fileHandler, $header . "\r\n");
			}
			fwrite($fileHandler, $msg . "\r\n");
			fclose($fileHandler);
		}
	}
}

// AuditTrail Inserting event
function AuditTrail_Inserting(&$rsnew) {

	//var_dump($rsnew);
	return TRUE;
}

// Unformat date time based on format type
function UnFormatDateTime($dt, $namedformat) {
	global $DATE_SEPARATOR, $TIME_SEPARATOR, $DATE_FORMAT, $DATE_FORMAT_ID;
	if (preg_match('/^([0-9]{4})-([0][1-9]|[1][0-2])-([0][1-9]|[1|2][0-9]|[3][0|1])( (0[0-9]|1[0-9]|2[0-3]):([0-5][0-9]):([0-5][0-9]))?$/', $dt))
		return $dt;
	$dt = trim($dt);
	$dt = preg_replace('/ +/', " ", $dt);
	$arDateTime = explode(" ", $dt);
	if (count($arDateTime) == 0)
		return $dt;
	if ($namedformat == 0 || $namedformat == 1 || $namedformat == 2 || $namedformat == 8)
		$namedformat = $DATE_FORMAT_ID;
	if ($namedformat > 100) {
		$useShortTime = TRUE;
		$namedformat -= 100;
	} else {
		$useShortTime = DATETIME_WITHOUT_SECONDS;
	}
	$arDatePt = explode($DATE_SEPARATOR, $arDateTime[0]);
	if (count($arDatePt) == 3) {
		switch ($namedformat) {
			case 5:
			case 9: //yyyymmdd
				if (CheckStdDate($arDateTime[0])) {
					list($year, $month, $day) = $arDatePt;
					break;
				} else {
					return $dt;
				}
			case 6:
			case 10: //mmddyyyy
				if (CheckUSDate($arDateTime[0])) {
					list($month, $day, $year) = $arDatePt;
					break;
				} else {
					return $dt;
				}
			case 7:
			case 11: //ddmmyyyy
				if (CheckEuroDate($arDateTime[0])) {
					list($day, $month, $year) = $arDatePt;
					break;
				} else {
					return $dt;
				}
			case 12:
			case 15: //yymmdd
				if (CheckStdShortDate($arDateTime[0])) {
					list($year, $month, $day) = $arDatePt;
					$year = UnformatYear($year);
					break;
				} else {
					return $dt;
				}
			case 13:
			case 16: //mmddyy
				if (CheckShortUSDate($arDateTime[0])) {
					list($month, $day, $year) = $arDatePt;
					$year = UnformatYear($year);
					break;
				} else {
					return $dt;
				}
			case 14:
			case 17: //ddmmyy
				if (CheckShortEuroDate($arDateTime[0])) {
					list($day, $month, $year) = $arDatePt;
					$year = UnformatYear($year);
					break;
				} else {
					return $dt;
				}
			default:
				return $dt;
		}
		$dt = $year . "-" . str_pad($month, 2, "0", STR_PAD_LEFT) . "-" . str_pad($day, 2, "0", STR_PAD_LEFT);
		if (count($arDateTime) > 1) { // Time
			list($hr, $min, $sec) = array_pad(explode($TIME_SEPARATOR, $arDateTime[1]), 3, 0);
			$dt .= " " . str_pad($hr, 2, "0", STR_PAD_LEFT) . ":" . str_pad($min, 2, "0", STR_PAD_LEFT) . ":" . str_pad($sec, 2, "0", STR_PAD_LEFT);
		}
		return $dt;
	} else {
		if ($namedformat == 3 || $namedformat == 4) {
			$dt = str_replace($TIME_SEPARATOR, ":", $dt);
			if ($namedformat == 3)
				$dt = UnformatShortTime($dt);
		}
		return $dt;
	}
}

/**
 * Unformat short time (to HH:mm:ss)
 *
 * @param string short time (hh:mm AM/PM/midnight)
 * @return string
 */
function UnformatShortTime($tm) {
	global $Language;
	$hr = 0;
	$min = 0;
	$sec = 0;
	$ar = explode(" ", $tm);
	if (count($ar) == 2) {
		$arTimePart = explode(":", $ar[0]);
		if (count($arTimePart) >= 2) {
			$hr = (int)$arTimePart[0];
			$min = (int)$arTimePart[1];
			if ($ar[1] == $Language->phrase("AM") && $hr == 12)
				$hr = 0;
			elseif ($ar[1] == $Language->phrase("PM") && $hr < 12)
				$hr += 12;
		}
		if ($hr < 0 || $hr > 23 || $min < 0 || $min > 59) { // Avoid invalid time
			$hr = 0;
			$min = 0;
		}
	} else { // Not short time, ignore
		return $tm;
	}
	return str_pad($hr, 2, "0", STR_PAD_LEFT) . ":" . str_pad($min, 2, "0", STR_PAD_LEFT) . ":" . str_pad($sec, 2, "0", STR_PAD_LEFT);
}

/**
 * Format a timestamp, datetime, date or time field
 *
 * @param integer|string timestamp or datetime, date or time field value
 * @param integer $namedformat
 *  0 - Default date format
 *  1 - Long Date (with time)
 *  2 - Short Date (without time)
 *  3 - Long Time (hh:mm:ss AM/PM)
 *  4 - Short Time (hh:mm:ss)
 *  5 - Short Date (yyyy/mm/dd)
 *  6 - Short Date (mm/dd/yyyy)
 *  7 - Short Date (dd/mm/yyyy)
 *  8 - Short Date (Default) + Short Time (if not 00:00:00)
 *  9/109 - Short Date (yyyy/mm/dd) + Short Time (hh:mm[:ss])
 *  10/110 - Short Date (mm/dd/yyyy) + Short Time (hh:mm[:ss])
 *  11/111 - Short Date (dd/mm/yyyy) + Short Time (hh:mm[:ss])
 *  12 - Short Date - 2 digit year (yy/mm/dd)
 *  13 - Short Date - 2 digit year (mm/dd/yy)
 *  14 - Short Date - 2 digit year (dd/mm/yy)
 *  15/115 - Short Date (yy/mm/dd) + Short Time (hh:mm[:ss])
 *  16/116 - Short Date (mm/dd/yyyy) + Short Time (hh:mm[:ss])
 *  17/117 - Short Date (dd/mm/yyyy) + Short Time (hh:mm[:ss])
 * @return string
 */
function FormatDateTime($ts, $namedformat) {
	global $Language, $DATE_SEPARATOR, $TIME_SEPARATOR, $DATE_FORMAT, $DATE_FORMAT_ID;
	if ($namedformat == 0)
		$namedformat = $DATE_FORMAT_ID;
	if ($namedformat > 100) {
		$useShortTime = TRUE;
		$namedformat -= 100;
	} else {
		$useShortTime = DATETIME_WITHOUT_SECONDS;
	}
	if (is_numeric($ts)) { // Timestamp
		switch (strlen($ts)) {
			case 14:
				$patt = '/(\d{4})(\d{2})(\d{2})(\d{2})(\d{2})(\d{2})/';
				break;
			case 12:
				$patt = '/(\d{2})(\d{2})(\d{2})(\d{2})(\d{2})(\d{2})/';
				break;
			case 10:
				$patt = '/(\d{2})(\d{2})(\d{2})(\d{2})(\d{2})/';
				break;
			case 8:
				$patt = '/(\d{4})(\d{2})(\d{2})/';
				break;
			case 6:
				$patt = '/(\d{2})(\d{2})(\d{2})/';
				break;
			case 4:
				$patt = '/(\d{2})(\d{2})/';
				break;
			case 2:
				$patt = '/(\d{2})/';
				break;
			default:
				return $ts;
		}
		if (isset($patt) && preg_match($patt, $ts, $matches)) {
			$year = $matches[1];
			$month = @$matches[2];
			$day = @$matches[3];
			$hour = @$matches[4];
			$min = @$matches[5];
			$sec = @$matches[6];
		}
		if ($namedformat == 0 && strlen($ts) < 10)
			$namedformat = 2;
	} elseif (is_string($ts)) {
		if (preg_match('/(\d{4})-(\d{2})-(\d{2}) (\d{2}):(\d{2}):?(\d{2})?/', $ts, $matches)) { // Datetime
			$year = $matches[1];
			$month = $matches[2];
			$day = $matches[3];
			$hour = $matches[4];
			$min = $matches[5];
			$sec = @$matches[6];
		} elseif (preg_match('/(\d{4})-(\d{2})-(\d{2})/', $ts, $matches)) { // Date
			$year = $matches[1];
			$month = $matches[2];
			$day = $matches[3];
			if ($namedformat==0) $namedformat = 2;
		} elseif (preg_match('/(^|\s)(\d{2}):(\d{2}):?(\d{2})?/', $ts, $matches)) { // Time
			$hour = $matches[2];
			$min = $matches[3];
			$sec = @$matches[4];
			if (($namedformat==0)||($namedformat==1)) $namedformat = 3;
			if ($namedformat==2) $namedformat = 4;
		} else {
			return $ts;
		}
	} else {
		return $ts;
	}
	if (!isset($year)) $year = 0; // Dummy value for times
	if (!isset($month)) $month = 1;
	if (!isset($day)) $day = 1;
	if (!isset($hour)) $hour = 0;
	if (!isset($min)) $min = 0;
	if (!isset($sec)) $sec = 0;
	$uts = @mktime($hour, $min, $sec, $month, $day, $year);
	if ($uts < 0 || $uts == FALSE || // Failed to convert
		((int)$year == 0 && (int)$month == 0 && (int)$day == 0)) {
		$year = substr_replace("0000", $year, -1 * strlen($year));
		$month = substr_replace("00", $month, -1 * strlen($month));
		$day = substr_replace("00", $day, -1 * strlen($day));
		$hour = substr_replace("00", $hour, -1 * strlen($hour));
		$min = substr_replace("00", $min, -1 * strlen($min));
		$sec = substr_replace("00", $sec, -1 * strlen($sec));
		if (ContainsString($DATE_FORMAT, "yyyy"))
			$DefDateFormat = str_replace("yyyy", $year, $DATE_FORMAT);
		elseif (ContainsString($DATE_FORMAT, "yy"))
			$DefDateFormat = str_replace("yy", substr(strval($year), -2), $DATE_FORMAT);
		$DefDateFormat = str_replace("mm", $month, $DefDateFormat);
		$DefDateFormat = str_replace("dd", $day, $DefDateFormat);
		switch ($namedformat) {

			//case 0: // Default
			case 1:
				return $DefDateFormat . " " . $hour . $TIME_SEPARATOR . $min . ($useShortTime ? "" : $TIME_SEPARATOR . $sec);
				break;

			//case 2: // Default
			case 3:
				if ((int)$hour == 0) {
					if ($min == 0 && $sec == 0)
						return "12 " . $Language->phrase("Midnight");
					else
						return "12" . $TIME_SEPARATOR . $min . $TIME_SEPARATOR . $sec . " " . $Language->phrase("AM");
				} elseif ((int)$hour > 0 && (int)$hour < 12) {
					return $hour . $TIME_SEPARATOR . $min . ($useShortTime ? "" : $TIME_SEPARATOR . $sec) . " " . $Language->phrase("AM");
				} elseif ((int)$hour == 12) {
					if ($min == 0 && $sec == 0)
						return "12 " . $Language->phrase("Noon");
					else
						return $hour . $TIME_SEPARATOR . $min . ($useShortTime ? "" : $TIME_SEPARATOR . $sec) . " " . $Language->phrase("PM");
				} elseif ((int)$hour > 12 && (int)$hour <= 23) {
					return ((int)$hour-12) . $TIME_SEPARATOR . $min . ($useShortTime ? "" : $TIME_SEPARATOR . $sec) . " " . $Language->phrase("PM");
				} else {
					return $hour . $TIME_SEPARATOR . $min . ($useShortTime ? "" : $TIME_SEPARATOR . $sec);
				}
				break;
			case 4:
				return $hour . $TIME_SEPARATOR . $min . ($useShortTime ? "" : $TIME_SEPARATOR . $sec);
				break;
			case 5:
				return $year . $DATE_SEPARATOR . $month . $DATE_SEPARATOR . $day;
				break;
			case 6:
				return $month . $DATE_SEPARATOR . $day . $DATE_SEPARATOR . $year;
				break;
			case 7:
				return $day . $DATE_SEPARATOR . $month . $DATE_SEPARATOR . $year;
				break;
			case 8:
				return $DefDateFormat . (($hour == 0 && $min == 0 && $sec == 0) ? "" : " " . $hour . $TIME_SEPARATOR . $min . ($useShortTime ? "" : $TIME_SEPARATOR . $sec));
				break;
			case 9:
				return $year . $DATE_SEPARATOR . $month . $DATE_SEPARATOR . $day . " " . $hour . $TIME_SEPARATOR . $min . ($useShortTime ? "" : $TIME_SEPARATOR . $sec);
				break;
			case 10:
				return $month . $DATE_SEPARATOR . $day . $DATE_SEPARATOR . $year . " " . $hour . $TIME_SEPARATOR . $min . ($useShortTime ? "" : $TIME_SEPARATOR . $sec);
				break;
			case 11:
				return $day . $DATE_SEPARATOR . $month . $DATE_SEPARATOR . $year . " " . $hour . $TIME_SEPARATOR . $min . ($useShortTime ? "" : $TIME_SEPARATOR . $sec);
				break;
			case 12:
				return substr($year,-2) . $DATE_SEPARATOR . $month . $DATE_SEPARATOR . $day;
				break;
			case 13:
				return $month . $DATE_SEPARATOR . $day . $DATE_SEPARATOR . substr($year,-2);
				break;
			case 14:
				return $day . $DATE_SEPARATOR . $month . $DATE_SEPARATOR . substr($year,-2);
				break;
			case 15:
				return substr($year,-2) . $DATE_SEPARATOR . $month . $DATE_SEPARATOR . $day . " " . $hour . $TIME_SEPARATOR . $min . ($useShortTime ? "" : $TIME_SEPARATOR . $sec);
				break;
			case 16:
				return $month . $DATE_SEPARATOR . $day . $DATE_SEPARATOR . substr($year,-2) . " " . $hour . $TIME_SEPARATOR . $min . ($useShortTime ? "" : $TIME_SEPARATOR . $sec);
				break;
			case 17:
				return $day . $DATE_SEPARATOR . $month . $DATE_SEPARATOR . substr($year,-2) . " " . $hour . $TIME_SEPARATOR . $min . ($useShortTime ? "" : $TIME_SEPARATOR . $sec);
				break;
			default:
				return $DefDateFormat;
				break;
		}
	} else {
		if (ContainsString($DATE_FORMAT, "yyyy"))
			$DefDateFormat = str_replace("yyyy", $year, $DATE_FORMAT);
		elseif (ContainsString($DATE_FORMAT, "yy"))
			$DefDateFormat = str_replace("yy", substr(strval($year), -2), $DATE_FORMAT);
		$DefDateFormat = str_replace("mm", $month, $DefDateFormat);
		$DefDateFormat = str_replace("dd", $day, $DefDateFormat);
		switch ($namedformat) {

			// case 0: // Default
			case 1:
				return strftime($DefDateFormat . " %H" . $TIME_SEPARATOR . "%M" . ($useShortTime ? "" : $TIME_SEPARATOR . "%S"), $uts);
				break;

			// case 2: // Default
			case 3:
				if ((int)$hour == 0) {
					if ($min == 0 && $sec == 0)
						return "12 " . $Language->phrase("Midnight");
					else
						return strftime("%I" . $TIME_SEPARATOR . "%M" . ($useShortTime ? "" : $TIME_SEPARATOR . "%S"), $uts) . " " . $Language->phrase("AM");
				} elseif ((int)$hour > 0 && (int)$hour < 12) {
					return strftime("%I" . $TIME_SEPARATOR . "%M" . ($useShortTime ? "" : $TIME_SEPARATOR . "%S"), $uts) . " " . $Language->phrase("AM");
				} elseif ((int)$hour == 12) {
					if ($min == 0 && $sec == 0)
						return "12 " . $Language->phrase("Noon");
					else
						return strftime("%I" . $TIME_SEPARATOR . "%M" . ($useShortTime ? "" : $TIME_SEPARATOR . "%S"), $uts) . " " . $Language->phrase("PM");
				} elseif ((int)$hour > 12 && (int)$hour <= 23) {
					return strftime("%I" . $TIME_SEPARATOR . "%M" . ($useShortTime ? "" : $TIME_SEPARATOR . "%S"), $uts) . " " . $Language->phrase("PM");
				} else {
					return strftime("%I" . $TIME_SEPARATOR . "%M" . ($useShortTime ? "" : $TIME_SEPARATOR . "%S") . " %p", $uts);
				}
				break;
			case 4:
				return strftime("%H" . $TIME_SEPARATOR . "%M" . ($useShortTime ? "" : $TIME_SEPARATOR . "%S"), $uts);
				break;
			case 5:
				return strftime("%Y" . $DATE_SEPARATOR . "%m" . $DATE_SEPARATOR . "%d", $uts);
				break;
			case 6:
				return strftime("%m" . $DATE_SEPARATOR . "%d" . $DATE_SEPARATOR . "%Y", $uts);
				break;
			case 7:
				return strftime("%d" . $DATE_SEPARATOR . "%m" . $DATE_SEPARATOR . "%Y", $uts);
				break;
			case 8:
				return strftime($DefDateFormat . (($hour == 0 && $min == 0 && $sec == 0) ? "" : " %H" . $TIME_SEPARATOR . "%M" . ($useShortTime ? "" : $TIME_SEPARATOR . "%S")), $uts);
				break;
			case 9:
				return strftime("%Y" . $DATE_SEPARATOR . "%m" . $DATE_SEPARATOR . "%d %H" . $TIME_SEPARATOR . "%M" . ($useShortTime ? "" : $TIME_SEPARATOR . "%S"), $uts);
				break;
			case 10:
				return strftime("%m" . $DATE_SEPARATOR . "%d" . $DATE_SEPARATOR . "%Y %H" . $TIME_SEPARATOR . "%M" . ($useShortTime ? "" : $TIME_SEPARATOR . "%S"), $uts);
				break;
			case 11:
				return strftime("%d" . $DATE_SEPARATOR . "%m" . $DATE_SEPARATOR . "%Y %H" . $TIME_SEPARATOR . "%M" . ($useShortTime ? "" : $TIME_SEPARATOR . "%S"), $uts);
				break;
			case 12:
				return strftime("%y" . $DATE_SEPARATOR . "%m" . $DATE_SEPARATOR . "%d", $uts);
				break;
			case 13:
				return strftime("%m" . $DATE_SEPARATOR . "%d" . $DATE_SEPARATOR . "%y", $uts);
				break;
			case 14:
				return strftime("%d" . $DATE_SEPARATOR . "%m" . $DATE_SEPARATOR . "%y", $uts);
				break;
			case 15:
				return strftime("%y" . $DATE_SEPARATOR . "%m" . $DATE_SEPARATOR . "%d %H" . $TIME_SEPARATOR . "%M" . ($useShortTime ? "" : $TIME_SEPARATOR . "%S"), $uts);
				break;
			case 16:
				return strftime("%m" . $DATE_SEPARATOR . "%d" . $DATE_SEPARATOR . "%y %H" . $TIME_SEPARATOR . "%M" . ($useShortTime ? "" : $TIME_SEPARATOR . "%S"), $uts);
				break;
			case 17:
				return strftime("%d" . $DATE_SEPARATOR . "%m" . $DATE_SEPARATOR . "%y %H" . $TIME_SEPARATOR . "%M" . ($useShortTime ? "" : $TIME_SEPARATOR . "%S"), $uts);
				break;
			default:
				return strftime($DefDateFormat, $uts);
				break;
		}
	}
}

/**
 * Format currency
 *
 * @param float $amount
 * @param integer $numDigitsAfterDecimal Numeric value indicating how many places to the right of the decimal are displayed
 *  -1 Use Default
 *  -2 Retain all values after decimal place
 * @param integer $includeLeadingDigit optional Includes leading digits: 1 (True), 0 (False), or -2 (Use default)
 * @param integer $useParensForNegativeNumbers optional Use parenthesis for negative numbers: 1 (True), 0 (False), or -2 (Use default)
 * @param integer $groupDigits optional Use group digits: 1 (True), 0 (False), or -2 (Use default)
 * @return string
 */
function FormatCurrency($amount, $numDigitsAfterDecimal, $includeLeadingDigit = -2, $useParensForNegativeNumbers = -2, $groupDigits = -2) {
	extract($GLOBALS["LOCALE"]);

	// Check $numDigitsAfterDecimal
	if ($numDigitsAfterDecimal == -2) { // Use all values after decimal point
		$stramt = strval($amount);
		if (strrpos($stramt, '.') >= 0)
			$frac_digits = strlen($stramt) - strrpos($stramt, '.') - 1;
		else
			$frac_digits = 0;
	} elseif ($numDigitsAfterDecimal > -1) {
		$frac_digits = $numDigitsAfterDecimal;
	}

	// Check $useParensForNegativeNumbers
	if ($useParensForNegativeNumbers == -1) {
		$n_sign_posn = 0;
		if ($p_sign_posn == 0) {
			$p_sign_posn = 3;
		}
	} elseif ($useParensForNegativeNumbers == 0) {
		if ($n_sign_posn == 0)
			$n_sign_posn = 3;
	}

	// Check $groupDigits
	if ($groupDigits == -1) {
	} elseif ($groupDigits == 0) {
		$mon_thousands_sep = "";
	}

	// Start by formatting the unsigned number
	$number = number_format(abs($amount), $frac_digits, $mon_decimal_point, $mon_thousands_sep);

	// Check $includeLeadingDigit
	if ($includeLeadingDigit == 0 && StartsString("0.", $number))
		$number = substr($number, 1, strlen($number)-1);
	if ($amount < 0) {
		$sign = $negative_sign;

		// "extracts" the boolean value as an integer
		$n_cs_precedes = (int)($n_cs_precedes == TRUE);
		$n_sep_by_space = (int)($n_sep_by_space == TRUE);
		$key = $n_cs_precedes . $n_sep_by_space . $n_sign_posn;
	} else {
		$sign = $positive_sign;
		$p_cs_precedes = (int)($p_cs_precedes == TRUE);
		$p_sep_by_space = (int)($p_sep_by_space == TRUE);
		$key = $p_cs_precedes . $p_sep_by_space . $p_sign_posn;
	}
	$formats = [ 

		// Currency symbol after amount
		// No space between amount and sign

		'000' => '(%s' . $currency_symbol . ')',
		'001' => $sign . '%s ' . $currency_symbol,
		'002' => '%s' . $currency_symbol . $sign,
		'003' => '%s' . $sign . $currency_symbol,
		'004' => '%s' . $sign . $currency_symbol,

		// One space between amount and sign
		'010' => '(%s ' . $currency_symbol . ')',
		'011' => $sign . '%s ' . $currency_symbol,
		'012' => '%s ' . $currency_symbol . $sign,
		'013' => '%s ' . $sign . $currency_symbol,
		'014' => '%s ' . $sign . $currency_symbol,

		// Currency symbol before amount
		// No space between amount and sign

		'100' => '(' . $currency_symbol . '%s)',
		'101' => $sign . $currency_symbol . '%s',
		'102' => $currency_symbol . '%s' . $sign,
		'103' => $sign . $currency_symbol . '%s',
		'104' => $currency_symbol . $sign . '%s',

		// One space between amount and sign
		'110' => '(' . $currency_symbol . ' %s)',
		'111' => $sign . $currency_symbol . ' %s',
		'112' => $currency_symbol . ' %s' . $sign,
		'113' => $sign . $currency_symbol . ' %s',
		'114' => $currency_symbol . ' ' . $sign . '%s'
	];

	// Lookup the key in the above array
	return sprintf($formats[$key], $number);
}

/**
 * Format number
 *
 * @param float $amount
 * @param integer $numDigitsAfterDecimal Numeric value indicating how many places to the right of the decimal are displayed
 *  -1 Use Default
 *  -2 Retain all values after decimal place
 * @param integer $includeLeadingDigit optional Includes leading digits: 1 (True), 0 (False), or -2 (Use default)
 * @param integer $useParensForNegativeNumbers optional Use parenthesis for negative numbers: 1 (True), 0 (False), or -2 (Use default)
 * @param integer $groupDigits optional Use group digits: 1 (True), 0 (False), or -2 (Use default)
 * @return string
 */
function FormatNumber($amount, $numDigitsAfterDecimal, $includeLeadingDigit = -2, $useParensForNegativeNumbers = -2, $groupDigits = -2) {
	extract($GLOBALS["LOCALE"]);

	// Check $numDigitsAfterDecimal
	if ($numDigitsAfterDecimal == -2) { // Use all values after decimal point
		$stramt = strval($amount);
		if (strrpos($stramt, '.') === FALSE)
			$frac_digits = 0;
		else
			$frac_digits = strlen($stramt) - strrpos($stramt, '.') - 1;
	} elseif ($numDigitsAfterDecimal > -1) {
		$frac_digits = $numDigitsAfterDecimal;
	}

	// Check $useParensForNegativeNumbers
	if ($useParensForNegativeNumbers == -1) {
		$n_sign_posn = 0;
		if ($p_sign_posn == 0) {
			$p_sign_posn = 3;
		}
	} elseif ($useParensForNegativeNumbers == 0) {
		if ($n_sign_posn == 0)
			$n_sign_posn = 3;
	}

	// Check $groupDigits
	if ($groupDigits == -1) {
	} elseif ($groupDigits == 0) {
		$thousands_sep = "";
	}

	// Start by formatting the unsigned number
	$number = number_format(abs($amount),
		$frac_digits,
		$decimal_point,
		$thousands_sep);

	// Check $includeLeadingDigit
	if ($includeLeadingDigit == 0 && StartsString("0.", $number))
		$number = substr($number, 1, strlen($number)-1);
	if ($amount < 0) {
		$sign = $negative_sign;
		$key = $n_sign_posn;
	} else {
		$sign = $positive_sign;
		$key = $p_sign_posn;
	}
	$formats = [
		'0' => '(%s)',
		'1' => $sign . '%s',
		'2' => $sign . '%s',
		'3' => $sign . '%s',
		'4' => $sign . '%s'
	];

	// Lookup the key in the above array
	return sprintf($formats[$key], $number);
}

/**
 * Format percent
 *
 * @param float $amount
 * @param integer $numDigitsAfterDecimal Numeric value indicating how many places to the right of the decimal are displayed
 *  -1 Use Default
 * @param integer $includeLeadingDigit optional Includes leading digits: 1 (True), 0 (False), or -2 (Use default)
 * @param integer $useParensForNegativeNumbers optional Use parenthesis for negative numbers: 1 (True), 0 (False), or -2 (Use default)
 * @param integer $groupDigits optional Use group digits: 1 (True), 0 (False), or -2 (Use default)
 * @return string
 */
function FormatPercent($amount, $numDigitsAfterDecimal, $includeLeadingDigit = -2, $useParensForNegativeNumbers = -2, $groupDigits = -2) {
	extract($GLOBALS["LOCALE"]);

	// Check $numDigitsAfterDecimal
	if ($numDigitsAfterDecimal > -1)
		$frac_digits = $numDigitsAfterDecimal;

	// Check $useParensForNegativeNumbers
	if ($useParensForNegativeNumbers == -1) {
		$n_sign_posn = 0;
		if ($p_sign_posn == 0) {
			$p_sign_posn = 3;
		}
	} elseif ($useParensForNegativeNumbers == 0) {
		if ($n_sign_posn == 0)
			$n_sign_posn = 3;
	}

	// Check $groupDigits
	if ($groupDigits == -1) {
	} elseif ($groupDigits == 0) {
		$thousands_sep = "";
	}

	// Start by formatting the unsigned number
	$number = number_format(abs($amount)*100,
							$frac_digits,
							$decimal_point,
							$thousands_sep);

	// Check $includeLeadingDigit
	if ($includeLeadingDigit == 0 && StartsString("0.", $number))
		$number = substr($number, 1, strlen($number)-1);
	if ($amount < 0) {
		$sign = $negative_sign;
		$key = $n_sign_posn;
	} else {
		$sign = $positive_sign;
		$key = $p_sign_posn;
	}
	$formats = [
		'0' => '(%s%%)',
		'1' => $sign . '%s%%',
		'2' => $sign . '%s%%',
		'3' => $sign . '%s%%',
		'4' => $sign . '%s%%'
	];

	// Lookup the key in the above array
	return sprintf($formats[$key], $number);
}

// Format sequence number
function FormatSequenceNumber($seq) {
	global $Language;
	return str_replace("%s", $seq, $Language->phrase("SequenceNumber"));
}

/**
 * Display field value separator
 *
 * @param integer $idx Display field index (1|2|3)
 * @param DbField $fld field object
 * @return string
 */
function ValueSeparator($idx, $fld) {
	$sep = ($fld) ? $fld->DisplayValueSeparator : ", ";
	return (is_array($sep)) ? @$sep[$idx - 1] : $sep;
}

/**
 * Get temp upload path
 *
 * @param mixed $fld DbField
 *  If FALSE, return href path of the temp upload folder.
 *  If NULL, return physical path of the temp upload folder.
 *  If string, return physical path of the temp upload folder with the parameter as part of the subpath.
 *  If object (DbField), return physical path of the temp upload folder with tblvar/fldvar as part of the subpath.
 * @param integer $idx Index of the field
 * @param boolean $tableLevel Table level or field level 
 * @return string
 */
function UploadTempPath($fld = NULL, $idx = -1, $tableLevel = FALSE) {
	if ($fld !== FALSE) { // Physical path
		$path = (UPLOAD_TEMP_PATH && UPLOAD_TEMP_HREF_PATH) ? IncludeTrailingDelimiter(UPLOAD_TEMP_PATH, TRUE) : UploadPath(TRUE);
		if (is_object($fld)) { // Normal upload
			$fldvar = ($idx < 0) ? $fld->FieldVar : substr($fld->FieldVar, 0, 1) . $idx . substr($fld->FieldVar, 1);
			$tblvar = $fld->TableVar;
			$path = IncludeTrailingDelimiter($path . UPLOAD_TEMP_FOLDER_PREFIX . session_id(), TRUE);
			$path = IncludeTrailingDelimiter($path . $tblvar, TRUE);
			if (!$tableLevel)
				$path = IncludeTrailingDelimiter($path . $fldvar, TRUE);
		} elseif (is_string($fld)) { // API upload ($fld as token)
			$path = IncludeTrailingDelimiter($path . UPLOAD_TEMP_FOLDER_PREFIX . $fld, TRUE);
		}
		return $path;
	} else { // Href path
		return (UPLOAD_TEMP_PATH && UPLOAD_TEMP_HREF_PATH) ? IncludeTrailingDelimiter(UPLOAD_TEMP_HREF_PATH, FALSE) : UploadPath(FALSE);
	}
}

// Render upload field to temp path
function RenderUploadField(&$fld, $idx = -1) {
	global $Language;
	$folder = UploadTempPath($fld, $idx);
	CleanUploadTempPaths(); // Clean all old temp folders
	CleanPath($folder); // Clean the upload folder
	if (!file_exists($folder)) {
		if (!CreateFolder($folder))
			die("Cannot create folder: " . $folder); //** side effect
	}
	$physical = !IsRemote($folder);
	$thumbnailfolder = PathCombine($folder, UPLOAD_THUMBNAIL_FOLDER, $physical);
	if (!file_exists($thumbnailfolder)) {
		if (!CreateFolder($thumbnailfolder))
			die("Cannot create folder: " . $thumbnailfolder); //** side effect
	}
	if ($fld->DataType == DATATYPE_BLOB) { // Blob field
		if (!EmptyValue($fld->Upload->DbValue)) {

			// Create upload file
			$filename = ($fld->Upload->FileName <> "") ? $fld->Upload->FileName : $fld->Param;
			$f = IncludeTrailingDelimiter($folder, $physical) . $filename;
			CreateUploadFile($f, $fld->Upload->DbValue);

			// Create thumbnail file
			$f = IncludeTrailingDelimiter($thumbnailfolder, $physical) . $filename;
			$data = $fld->Upload->DbValue;
			$width = UPLOAD_THUMBNAIL_WIDTH;
			$height = UPLOAD_THUMBNAIL_HEIGHT;
			ResizeBinary($data, $width, $height);
			CreateUploadFile($f, $data);
			$fld->Upload->FileName = basename($f); // Update file name
		}
	} else { // Upload to folder
		$fld->Upload->FileName = $fld->Upload->DbValue; // Update file name
		if (!EmptyValue($fld->Upload->FileName)) {

			// Create upload file
			$pathinfo = pathinfo($fld->Upload->FileName);
			$filename = $pathinfo["basename"];
			$filepath = (@$pathinfo["dirname"] <> "" && @$pathinfo["dirname"] <> ".") ? PathCombine($fld->UploadPath, $pathinfo["dirname"], !IsRemote($fld->UploadPath)) : $fld->UploadPath;
			if ($fld->UploadMultiple)
				$files = explode(MULTIPLE_UPLOAD_SEPARATOR, $filename);
			else
				$files = [$filename];
			$cnt = count($files);
			for ($i = 0; $i < $cnt; $i++) {
				$filename = $files[$i];
				if ($filename <> "") {
					$srcfile = ServerMapPath($filepath) . $filename;
					$f = IncludeTrailingDelimiter($folder, $physical) . $filename;
					if (!is_dir($srcfile) && file_exists($srcfile)) {
						$data = file_get_contents($srcfile);
						CreateUploadFile($f, $data);
					} else {
						CreateImageFromText($Language->phrase("FileNotFound"), $f);
						$data = file_get_contents($f);
					}

					// Create thumbnail file
					$f = IncludeTrailingDelimiter($thumbnailfolder, $physical) . $filename;
					$width = UPLOAD_THUMBNAIL_WIDTH;
					$height = UPLOAD_THUMBNAIL_HEIGHT;
					ResizeBinary($data, $width, $height);
					CreateUploadFile($f, $data);
				}
			}
		}
	}
}

// Write uploaded file
function CreateUploadFile(&$f, $data) {
	$handle = fopen($f, "w");
	fwrite($handle, $data);
	fclose($handle);
	$pathinfo = pathinfo($f);
	if (!isset($pathinfo["extension"]) || $pathinfo["extension"] == "") {
		$ct = ContentType($data);
		switch ($ct) {
			case "image/gif":
				rename($f, $f .= '.gif');
				break;
			case "image/jpeg":
				rename($f, $f .= '.jpg');
				break;
			case "image/png":
				rename($f, $f .= '.png');
				break;
		}
	}
}

// Create image from text
function CreateImageFromText($txt, $file, $width = UPLOAD_THUMBNAIL_WIDTH, $height = 0, $font = TEMP_IMAGE_FONT) {
	$pt = round(FONT_SIZE / 1.33); // 1pt = 1.33px
	$h = ($height > 0) ? $height : round(FONT_SIZE / 14 * 20);
	$im = @imagecreate($width, $h);
	$color = @imagecolorallocate($im, 255, 255, 255);
	$color = @imagecolorallocate($im, 0, $h, 0);
	if (strrpos($font, '.') === FALSE)
		$font .= '.ttf';
	$font = IncludeTrailingDelimiter($GLOBALS["FONT_PATH"], TRUE) . $font; // Always use full path
	@imagettftext($im, $pt, 0, 0, round(($h - FONT_SIZE) / 2 + FONT_SIZE), $color, $font, ConvertToUtf8($txt));
	@imagepng($im, $file);
	@imagedestroy($im);
}

// Clean temp upload folders
function CleanUploadTempPaths($sessionid = "") {
	$folder = (UPLOAD_TEMP_PATH) ? IncludeTrailingDelimiter(UPLOAD_TEMP_PATH, TRUE) : UploadPath(TRUE);
	if (@is_dir($folder)) {

		// Load temp folders
		foreach (glob($folder . UPLOAD_TEMP_FOLDER_PREFIX . "*", GLOB_ONLYDIR) as $tempfolder) {
			$subfolder = basename($tempfolder);
			if (UPLOAD_TEMP_FOLDER_PREFIX . $sessionid == $subfolder) { // Clean session folder
				CleanPath($tempfolder, TRUE);
			} else {
				if (UPLOAD_TEMP_FOLDER_PREFIX . session_id() <> $subfolder) {
					if (IsEmptyPath($tempfolder)) { // Empty folder
						CleanPath($tempfolder, TRUE);
					} else { // Old folder
						$lastmdtime = filemtime($tempfolder);
						if ((time() - $lastmdtime) / 60 > UPLOAD_TEMP_FOLDER_TIME_LIMIT || count(@scandir($tempfolder)) == 2)
							CleanPath($tempfolder, TRUE);
					}
				}
			}
		}

		// Temp images
		foreach (glob($folder . "*.tmp.png") as $filename) {
			$lastmdtime = filemtime($tempfolder);
			if ((time() - $lastmdtime) / 60 > UPLOAD_TEMP_FOLDER_TIME_LIMIT)
				@unlink($filename);
		}
	}
}

// Clean temp upload folder
function CleanUploadTempPath($fld, $idx = -1) {
	$folder = UploadTempPath($fld, $idx);
	CleanPath($folder, TRUE); // Clean the upload folder

	// Remove table temp folder if empty
	$folder = UploadTempPath($fld, $idx, TRUE);
	$files = @scandir($folder);
	if (count($files) <= 2)
		CleanPath($folder, TRUE);
}

// Clean folder
function CleanPath($folder, $delete = FALSE) {
	$folder = IncludeTrailingDelimiter($folder, TRUE);
	try {
		if (@is_dir($folder)) {

			// Delete files in the folder
			if ($ar = glob($folder . '*.*')) {
				foreach ($ar as $v) {
					@unlink($v);
				}
			}

			// Clear sub folders
			if ($dir_handle = @opendir($folder)) {
				while (FALSE !== ($subfolder = readdir($dir_handle))) {
					$tempfolder = PathCombine($folder, $subfolder, TRUE);
					if ($subfolder == "." || $subfolder == ".." || !@is_dir($tempfolder))
						continue;
					CleanPath($tempfolder, $delete);
				}
			}
			if ($delete) {
				@closedir($dir_handle);
				@rmdir($folder);
			}
		}
	} catch (\Exception $e) {
		if (DEBUG_ENABLED)
			throw $e;
	}
}

// Check if empty folder
function IsEmptyPath($folder) {
	$IsEmptyPath = TRUE;

	// Check folder
	$folder = IncludeTrailingDelimiter($folder, TRUE);
	if (is_dir($folder)) {
		if (count(@scandir($folder)) > 2)
			return FALSE;
		if ($dir_handle = @opendir($folder)) {
			while (FALSE !== ($subfolder = readdir($dir_handle))) {
				$tempfolder = PathCombine($folder, $subfolder, TRUE);
				if ($subfolder == "." || $subfolder == "..")
					continue;
				if (is_dir($tempfolder))
					$IsEmptyPath = IsEmptyPath($tempfolder);
				if (!$IsEmptyPath)
					return FALSE; // No need to check further
			}
		}
	} else {
		$IsEmptyPath = FALSE;
	}
	return $IsEmptyPath;
}

// Truncate Memo Field based on specified length, string truncated to nearest space or CrLf
function TruncateMemo($memostr, $ln, $removehtml) {
	$str = ($removehtml) ? RemoveHtml($memostr) : $memostr;
	if (strlen($str) > 0 && strlen($str) > $ln) {
		$k = 0;
		while ($k >= 0 && $k < strlen($str)) {
			$i = strpos($str, " ", $k);
			$j = strpos($str, chr(10), $k);
			if ($i === FALSE && $j === FALSE) { // Not able to truncate
				return $str;
			} else {

				// Get nearest space or CrLf
				if ($i > 0 && $j > 0) {
					if ($i < $j) {
						$k = $i;
					} else {
						$k = $j;
					}
				} elseif ($i > 0) {
					$k = $i;
				} elseif ($j > 0) {
					$k = $j;
				}

				// Get truncated text
				if ($k >= $ln) {
					return substr($str, 0, $k) . "...";
				} else {
					$k++;
				}
			}
		}
	} else {
		return $str;
	}
}

// Remove HTML tags from text
function RemoveHtml($str) {
	return preg_replace('/<[^>]*>/', '', strval($str));
}

// Extract JavaScript from HTML and return converted script
function ExtractScript(&$html, $class = "") {
	if (!preg_match_all('/<script([^>]*)>([\s\S]*?)<\/script\s*>/i', $html, $matches, PREG_SET_ORDER))
		return "";
	$scripts = "";
	foreach ($matches as $match) {
		if (preg_match('/(\s+type\s*=\s*[\'"]*text\/javascript[\'"]*)|^((?!\s+type\s*=).)*$/i', $match[1])) { // JavaScript
			$html = str_replace($match[0], "", $html); // Remove the script from HTML
			$scripts .= HtmlElement("script", ["type" => "text/html", "class" => $class], $match[2]); // Convert script type and add CSS class, if specified
		}
	}
	return $scripts; // Return converted scripts
}

// Function to send email
function SendEmail($fromEmail, $toEmail, $ccEmail, $bccEmail, $subject, $mailContent, $format, $charset, $smtpSecure = "", $arAttachments = [], $arImages = [], $arProperties = NULL) {
	global $Language;
	$res = FALSE;
	$mail = new \PHPMailer\PHPMailer\PHPMailer();

	// Set up mailer
	if (PHPMAILER_MAILER == "smtp")
		$mail->isSMTP();
	elseif (PHPMAILER_MAILER == "mail")
		$mail->isMail();
	elseif (PHPMAILER_MAILER == "sendmail")
		$mail->isSendmail();
	elseif (PHPMAILER_MAILER == "qmail")
		$mail->isQmail();
	else // Default
		$mail->isSMTP();

	// Set up server settings
	$mail->Host = SMTP_SERVER;
	$mail->SMTPAuth = (SMTP_SERVER_USERNAME <> "" && SMTP_SERVER_PASSWORD <> "");
	$mail->Username = SMTP_SERVER_USERNAME;
	$mail->Password = SMTP_SERVER_PASSWORD;
	$mail->Port = SMTP_SERVER_PORT;
	if (DEBUG_ENABLED) {
		$mail->SMTPDebug = 2;
		$mail->Debugoutput = "SetDebugMessage";
	}
	if ($smtpSecure <> "") {
		$mail->SMTPSecure = $smtpSecure;
		$mail->SMTPOptions = ["ssl" => ["verify_peer" => FALSE, "verify_peer_name" => FALSE, "allow_self_signed" => TRUE]];
	}
	if (preg_match('/^(.+)<([\w.%+-]+@[\w.-]+\.[A-Z]{2,6})>$/i', trim($fromEmail), $m)) {
		$mail->From = $m[2];
		$mail->FromName = trim($m[1]);
	} else {
		$mail->From = $fromEmail;
		$mail->FromName = $fromEmail;
	}
	$mail->Subject = $subject;
	if (SameText($format, "html")) {
		$mail->isHTML(TRUE);
		$mail->Body = $mailContent;
	} else {
		$mail->isHTML(FALSE);
		$mail->Body = HtmlToText($mailContent);
	}
	if ($charset && !SameText($charset, "iso-8859-1"))
		$mail->CharSet = $charset;
	$toEmail = str_replace(";", ",", $toEmail);
	$arTo = explode(",", $toEmail);
	foreach ($arTo as $to) {
		if (preg_match('/^(.+)<([\w.%+-]+@[\w.-]+\.[A-Z]{2,6})>$/i', trim($to), $m)) {
			$mail->addAddress($m[2], trim($m[1]));
		} else {
			$mail->addAddress(trim($to));
		}
	}
	if ($ccEmail <> "") {
		$ccEmail = str_replace(";", ",", $ccEmail);
		$arCc = explode(",", $ccEmail);
		foreach ($arCc as $cc) {
			if (preg_match('/^(.+)<([\w.%+-]+@[\w.-]+\.[A-Z]{2,6})>$/i', trim($cc), $m)) {
				$mail->addCC($m[2], trim($m[1]));
			} else {
				$mail->addCC(trim($cc));
			}
		}
	}
	if ($bccEmail <> "") {
		$bccEmail = str_replace(";", ",", $bccEmail);
		$arBcc = explode(",", $bccEmail);
		foreach ($arBcc as $bcc) {
			if (preg_match('/^(.+)<([\w.%+-]+@[\w.-]+\.[A-Z]{2,6})>$/i', trim($bcc), $m)) {
				$mail->addBCC($m[2], trim($m[1]));
			} else {
				$mail->addBCC(trim($bcc));
			}
		}
	}
	if (is_array($arAttachments)) {
		foreach ($arAttachments as $attachment) {
			$filename = @$attachment["filename"];
			$content = @$attachment["content"];
			if ($content <> "" && $filename <> "") {
				$mail->addStringAttachment($content, $filename);
			} else if ($filename <> "") {
				$mail->addAttachment($filename);
			}
		}
	}
	if (is_array($arImages)) {
		foreach ($arImages as $tmpImage) {
			$file = UploadTempPath() . $tmpImage;
			$cid = TempImageLink($tmpImage, "cid");
			$mail->addEmbeddedImage($file, $cid, $tmpImage);
		}
	}
	if (is_array($arProperties)) {
		foreach ($arProperties as $key => $value)
			$mail->set($key, $value);
	}
	$res = $mail->send();
	if (DEBUG_ENABLED && $mail->ErrorInfo <> "") // There may be error even if $res is TRUE
		SetDebugMessage($mail->ErrorInfo, $mail->SMTPDebug);
	if (!$res)
		$res = $mail->ErrorInfo;
	return $res; // TRUE on success, error message on failure
}

// Clean email content
function CleanEmailContent($content) {
	$content = preg_replace('/class="card ew-grid \w+"/', "", $content);
	$content = preg_replace('/class="(table-responsive )?card-body ew-grid-middle-panel"/', "", $content);
	$content = str_replace("table ew-table", "ew-export-table", $content);
	return $content;
}

// Field data type
function FieldDataType($fldtype) {
	switch ($fldtype) {
		case 20:
		case 3:
		case 2:
		case 16:
		case 4:
		case 5:
		case 131:
		case 139:
		case 6:
		case 17:
		case 18:
		case 19:
		case 21: // Numeric
			return DATATYPE_NUMBER;
		case 7:
		case 133:
		case 135: // Date
		case 146: // DateTiemOffset
			return DATATYPE_DATE;
		case 134: // Time
		case 145: // Time
			return DATATYPE_TIME;
		case 201:
		case 203: // Memo
			return DATATYPE_MEMO;
		case 129:
		case 130:
		case 200:
		case 202: // String
			return DATATYPE_STRING;
		case 11: // Boolean
			return DATATYPE_BOOLEAN;
		case 72: // GUID
			return DATATYPE_GUID;
		case 128:
		case 204:
		case 205: // Binary
			return DATATYPE_BLOB;
		case 141: // XML
			return DATATYPE_XML;
		default:
			return DATATYPE_OTHER;
	}
}

/**
 * Application root
 *
 * @return string Physical path of the application root
 */
function AppRoot() {
	global $ROOT_RELATIVE_PATH;
	$path = realpath($ROOT_RELATIVE_PATH ?: "."); // Use root relative path
	$path = preg_replace('/(?<!^)\\\\\\\\/', PATH_DELIMITER, $path); // Replace '\\' (not at the start of path) by path delimiter
	return IncludeTrailingDelimiter($path, TRUE);
}

/**
 * Upload path
 * 
 * @param bool $phyPath Physical path
 * @param string $destPath Destination path
 * @return string If $phyPath is TRUE, return physical path on the server. If $phyPath is FALSE, return relative URL.
 */
function UploadPath($phyPath, $destPath = UPLOAD_DEST_PATH) {
	global $ROOT_RELATIVE_PATH;
	if ($phyPath) {
		$phyPath = !IsRemote($destPath); // Not remote
		if ($phyPath)
			$destPath = str_replace("/", PATH_DELIMITER, $destPath);
		$path = PathCombine(AppRoot(), $destPath, $phyPath);
	} else {
		$path = PathCombine($ROOT_RELATIVE_PATH, $destPath, FALSE);
	}
	return IncludeTrailingDelimiter($path, $phyPath);
}

// Get physical path relative to application root
function ServerMapPath($path, $isFile = FALSE) {
	$pathinfo = IsRemote($path) ? [] : pathinfo($path);
	if ($isFile && @$pathinfo["basename"] <> "" || @$pathinfo["extension"] <> "") // File
		return UploadPath(TRUE, $pathinfo["dirname"]) . $pathinfo["basename"];
	else // Folder
		return UploadPath(TRUE, $path);
}

// Write the paths for config/debug only
function WritePaths() {
	global $ROOT_RELATIVE_PATH, $RELATIVE_PATH;
	echo "RELATIVE_PATH = " . $RELATIVE_PATH . "<br>";
	echo "ROOT_RELATIVE_PATH = " . $ROOT_RELATIVE_PATH . "<br>";
	echo "UPLOAD_DEST_PATH = " . UPLOAD_DEST_PATH . "<br>";
	echo "AppRoot() = " . AppRoot() . "<br>";
	echo "realpath('.') = " . realpath(".") . "<br>";
	echo "DOCUMENT_ROOT = " . ServerVar("DOCUMENT_ROOT") . "<br>";
	echo "__FILE__ = " . __FILE__ . "<br>";
}

// Write info for config/debug only
function Info() {
	global $Security;
	WritePaths();
	echo "CurrentUserName() = " . CurrentUserName() . "<br>";
	echo "CurrentUserID() = " . CurrentUserID() . "<br>";
	echo "CurrentParentUserID() = " . CurrentParentUserID() . "<br>";
	echo "IsLoggedIn() = " . (IsLoggedIn() ? "TRUE" : "FALSE") . "<br>";
	echo "IsAdmin() = " . (IsAdmin() ? "TRUE" : "FALSE") . "<br>";
	echo "IsSysAdmin() = " . (IsSysAdmin() ? "TRUE" : "FALSE") . "<br>";
	if (isset($Security))
		$Security->showUserLevelInfo();
}

/**
 * Generate an unique file name for a folder (filename(n).ext)
 *
 * @param string $folder Output folder
 * @param string $orifn Original file name
 * @param boolean $indexed Index starts from '(n)' at the end of the original file name
 * @return string
 */
function UniqueFilename($folder, $orifn, $indexed = FALSE) {
	if ($orifn == "")
		$orifn = date("YmdHis") . ".bin";
	$info = pathinfo($orifn);
	$newfn = $info["basename"];
	$destpath = $folder . $newfn;
	$i = 1;
	if ($indexed && preg_match('/\(\d+\)$/', $newfn, $matches)) // Match '(n)' at the end of the file name
		$i = (int)$matches[1];
	if (!file_exists($folder) && !CreateFolder($folder))
		die("Folder does not exist: " . $folder); //** side effect
	while (file_exists(Convert(PROJECT_ENCODING, FILE_SYSTEM_ENCODING, $destpath))) {
		$file_name = preg_replace('/\(\d+\)$/', '', $info["filename"]); // Remove "(n)" at the end of the file name
		$newfn = $file_name . "(" . $i++ . ")." . $info["extension"];
		$destpath = $folder . $newfn;
	}
	return $newfn;
}

// Get refer URL
function ReferUrl() {
	return ServerVar("HTTP_REFERER");
}

// Get refer page name
function ReferPageName() {
	return GetPageName(ReferUrl());
}

// Get script physical folder
function ScriptFolder() {
	$folder = "";
	$path = ServerVar("SCRIPT_FILENAME");
	$p = strrpos($path, PATH_DELIMITER);
	if ($p !== FALSE)
		$folder = substr($path, 0, $p);
	return ($folder <> "") ? $folder : realpath(".");
}

// Get a temp folder for temp file
function TempFolder() {
	$folders = [];
	if (IS_WINDOWS) {
		$folders[] = ServerVar("TEMP");
		$folders[] = ServerVar("TMP");
	} else {
		if (USER_UPLOAD_TEMP_PATH <> "")
			$folders[] = ServerMapPath(USER_UPLOAD_TEMP_PATH);
		$folders[] = '/tmp';
	}
	if (ini_get('upload_tmp_dir'))
		$folders[] = ini_get('upload_tmp_dir');
	foreach ($folders as $folder) {
		if (is_dir($folder))
			return $folder;
	}
	return NULL;
}

// Create folder
function CreateFolder($dir, $mode = 0777) {
	if (IsRemote($dir)) // Support S3 only
		return (is_dir($dir) || @mkdir($dir, $mode, STREAM_MKDIR_RECURSIVE));
	else
		return (is_dir($dir) || @mkdir($dir, $mode, TRUE));
}

// Save file
function SaveFile($folder, $fn, $filedata) {
	$fn = Convert(PROJECT_ENCODING, FILE_SYSTEM_ENCODING, $fn);
	$res = FALSE;
	if (CreateFolder($folder)) {
		$file = IncludeTrailingDelimiter($folder, TRUE) . $fn;
		if (IsRemote($file)) // Support S3 only
			$res = file_put_contents($file, $filedata);
		else
			$res = file_put_contents($file, $filedata, LOCK_EX);
		if ($res !== FALSE)
			@chmod($file, UPLOADED_FILE_MODE);
	}
	return $res;
}

// Copy file
function CopyFile($folder, $fn, $file) {
	$fn = Convert(PROJECT_ENCODING, FILE_SYSTEM_ENCODING, $fn);
	if (file_exists($file)) {
		if (CreateFolder($folder)) {
			$newfile = IncludeTrailingDelimiter($folder, TRUE) . $fn;
			return copy($file, $newfile);
		}
	}
	return FALSE;
}

/**
 * Set cache
 *
 * @param string $key Key or token
 * @param array|object $val Values
 * @return int|FALSE Number of bytes written to the file, or FALSE on failure
 */
function SetCache($key, $val) {
	$val = var_export($val, TRUE);
	$val = str_replace("stdClass::__set_state", "(object)", $val);
	$path = IncludeTrailingDelimiter(UploadPath(TRUE) . UPLOAD_TEMP_FOLDER_PREFIX . $key, TRUE);
	$file = $key . ".txt";
	return SaveFile($path, $file, '<?php $val = ' . $val . ';');
}

/**
 * Get cache
 *
 * @param string $key Key or token
 * @return array|object Values
 */
function GetCache($key) {
	$path = IncludeTrailingDelimiter(UploadPath(TRUE) . UPLOAD_TEMP_FOLDER_PREFIX . $key, TRUE);
	$file = $key . ".txt";
	@include $path . $file;
	return isset($val) ? $val : FALSE;
}

// Generate random number
function Random() {
	return mt_rand();
}

// Calculate field hash
function GetFieldHash($value) {
	return md5(GetFieldValueAsString($value));
}

// Get field value as string
function GetFieldValueAsString($value) {
	if ($value == NULL) {
		return "";
	} else {
		if (strlen($value) > 65535) { // BLOB/TEXT
			if (BLOB_FIELD_BYTE_COUNT > 0) {
				return substr($value, 0, BLOB_FIELD_BYTE_COUNT);
			} else {
				return $value;
			}
		} else {
			return strval($value);
		}
	}
}

// Convert byte array to binary string
function BytesToString($bytes) {
	$str = "";
	foreach ($bytes as $byte)
		$str .= chr($byte);
	return $str;
}

// Convert binary string to byte array
function StringToBytes($str) {
	$cnt = strlen($str);
	$bytes = [];
	for ($i = 0; $i < $cnt; $i++)
		$bytes[] = ord($str[$i]);
	return $bytes;
}

// Create temp image file from binary data
function TempImage(&$filedata) {
	global $TempImages;
	$export = Param("export") ?: Post("exporttype");
	$folder = UploadTempPath();
	$f = tempnam($folder, "tmp");
	$handle = fopen($f, 'w');
	fwrite($handle, $filedata);
	fclose($handle);
	$info = @getimagesize($f);
	switch ($info[2]) {
		case 1:
			rename($f, $f .= '.gif'); break;
		case 2:
			rename($f, $f .= '.jpg'); break;
		case 3:
			rename($f, $f .= '.png'); break;
		case 6:
			rename($f, $f .= '.bmp'); break;
		default:
			return "";
	}
	$tmpimage = basename($f);
	$TempImages[] = $tmpimage;
	return TempImageLink($tmpimage, $export);
}

// Get temp image path
function TempImageLink($file, $lnktype = "") {
	global $ROOT_RELATIVE_PATH;
	if ($file == "")
		return "";
	if ($lnktype == "email" || $lnktype == "cid") {
		$ar = explode(".", $file);
		$lnk = implode(".", array_slice($ar, 0, count($ar) - 1));
		if ($lnktype == "email")
			$lnk = "cid:" . $lnk;
		return $lnk;
	} else {

		// If UPLOAD_TEMP_PATH, returns physical path, else returns relative path.
		return UploadTempPath(UPLOAD_TEMP_PATH && UPLOAD_TEMP_HREF_PATH) . $file; 
	}
}

// Delete temp images
function DeleteTempImages() {
	global $TempImages;
	foreach ($TempImages as $tmpimage)
		@unlink(UploadTempPath() . $tmpimage);
}

// Add query string to URL
function UrlAddQuery($url, $qry) {
	if (strval($qry) == "")
		return $url;
	return $url . (ContainsString($url, "?") ? "&" : "?") . $qry;
}

// Add "hash" parameter to URL
function UrlAddHash($url, $hash) {
	return UrlAddQuery($url, "hash=" . $hash);
}
?>
<?php

/**
 * Form class
 */
class HttpForm
{
	public $Index;
	public $FormName = "";

	// Constructor
	public function __construct()
	{
		$this->Index = -1;
	}

	// Get form element name based on index
	protected function getIndexedName($name)
	{
		if ($this->Index < 0) {
			return $name;
		} else {
			return substr($name, 0, 1) . $this->Index . substr($name, 1);
		}
	}

	// Has value for form element
	public function hasValue($name)
	{
		$wrkname = $this->getIndexedName($name);
		if (preg_match('/^(fn_)?(x|o)\d*_/', $name) && $this->FormName <> "") {
			if (Post($this->FormName . '$' . $wrkname) !== NULL)
				return TRUE;
		}
		return Post($wrkname) !== NULL;
	}

	// Get value for form element
	public function getValue($name)
	{
		$wrkname = $this->getIndexedName($name);
		$value = Post($wrkname);
		if (preg_match('/^(fn_)?(x|o)\d*_/', $name) && $this->FormName <> "") {
			$wrkname = $this->FormName . '$' . $wrkname;
			if (Post($wrkname) !== NULL)
				$value = Post($wrkname);
		}
		return $value;
	}
}
?>
<?php

/**
 * Functions for image resize
 */
// Resize binary to thumbnail
function ResizeBinary(&$filedata, &$width, &$height, $quality = THUMBNAIL_DEFAULT_QUALITY, $plugins = []) {
	global $THUMBNAIL_CLASS, $RESIZE_OPTIONS;
	if ($width <= 0 && $height <= 0)
		return FALSE;
	$f = tempnam(TempFolder(), "tmp");
	$handle = @fopen($f, 'wb');
	if ($handle) {
		fwrite($handle, $filedata);
		fclose($handle);
	}
	$format = "";
	if (file_exists($f) && filesize($f) > 0) { // Temp file created
		$info = @getimagesize($f);
		@unlink($f);
		if (!$info || !in_array($info[2], [1, 2, 3])) { // Not gif/jpg/png
			return FALSE;
		} elseif ($info[2] == 1) {
			$format = "GIF";
		} elseif ($info[2] == 2) {
			$format = "JPG";
		} elseif ($info[2] == 3) {
			$format = "PNG";
		}
	} else { // Temp file not created
		if (StartsString("\x47\x49\x46\x38\x37\x61", $filedata) || StartsString("\x47\x49\x46\x38\x39\x61", $filedata)) {
			$format = "GIF";
		} elseif (StartsString("\xFF\xD8\xFF\xE0", $filedata) && substr($filedata, 6, 5) == "\x4A\x46\x49\x46\x00") {
			$format = "JPG";
		} elseif (StartsString("\x89\x50\x4E\x47\x0D\x0A\x1A\x0A", $filedata)) {
			$format = "PNG";
		} else {
			return FALSE;
		}
	}
	$thumb = new $THUMBNAIL_CLASS($filedata, $RESIZE_OPTIONS + ["isDataStream" => TRUE, "format" => $format], $plugins);
	return $thumb->resizeEx($filedata, $width, $height);
}

// Resize file to thumbnail file
function ResizeFile($fn, $tn, &$width, &$height, $plugins = []) {
	global $THUMBNAIL_CLASS, $RESIZE_OPTIONS;
	$info = @getimagesize($fn);
	if (!$info || !in_array($info[2], [1, 2, 3]) || $width <= 0 && $height <= 0) {
		if ($fn <> $tn) copy($fn, $tn);
		return;
	}
	$thumb = new $THUMBNAIL_CLASS($fn, $RESIZE_OPTIONS, $plugins);
	$fdata = NULL;
	if (!$thumb->resizeEx($fdata, $width, $height, $tn))
		if ($fn <> $tn) copy($fn, $tn);
}

// Resize file to binary
function ResizeFileToBinary($fn, &$width, &$height, $plugins = []) {
	global $THUMBNAIL_CLASS, $RESIZE_OPTIONS;
	$info = @getimagesize($fn);
	if (!$info)
		return NULL;
	if (!in_array($info[2], [1, 2, 3]) || $width <= 0 && $height <= 0) {
		$fdata = file_get_contents($fn);
	} else {
		$thumb = new $THUMBNAIL_CLASS($fn, $RESIZE_OPTIONS, $plugins);
		$fdata = NULL;
		if (!$thumb->resizeEx($fdata, $width, $height))
			$fdata = file_get_contents($fn);
	}
	return $fdata;
}
?>
<?php

/**
 * Functions for Auto-Update fields
 */
// Get user IP
function CurrentUserIP() {
	return ServerVar("REMOTE_ADDR");
}

// Get current host name, e.g. "www.mycompany.com"
function CurrentHost() {
	return ServerVar("HTTP_HOST");
}

// Get current Windows user (for Windows Authentication)
function CurrentWindowsUser() {
	return ServerVar("AUTH_USER"); // REMOTE_USER or LOGON_USER or AUTH_USER
}

// Get current date in default date format
// $namedformat = -1|5|6|7 (see comment for FormatDateTime)
function CurrentDate($namedformat = -1) {
	if (in_array($namedformat, [5, 6, 7, 9, 10, 11, 12, 13, 14, 15, 16, 17])) {
		if ($namedformat == 5 || $namedformat == 9 || $namedformat == 12 || $namedformat == 15) {
			$dt = FormatDateTime(date('Y-m-d'), 5);
		} elseif ($namedformat == 6 || $namedformat == 10 || $namedformat == 13 || $namedformat == 16) {
			$dt = FormatDateTime(date('Y-m-d'), 6);
		} else {
			$dt = FormatDateTime(date('Y-m-d'), 7);
		}
		return $dt;
	} else {
		return date('Y-m-d');
	}
}

// Get current time in hh:mm:ss format
function CurrentTime() {
	return date("H:i:s");
}

// Get current date in default date format with time in hh:mm:ss format
// $namedformat = -1, 5-7, 9-11 (see comment for FormatDateTime)
function CurrentDateTime($namedformat = -1) {
	if (in_array($namedformat, [5, 6, 7, 9, 10, 11, 12, 13, 14, 15, 16, 17])) {
		if ($namedformat == 5 || $namedformat == 9 || $namedformat == 12 || $namedformat == 15) {
			$dt = FormatDateTime(date('Y-m-d H:i:s'), 9);
		} elseif ($namedformat == 6 || $namedformat == 10 || $namedformat == 13 || $namedformat == 16) {
			$dt = FormatDateTime(date('Y-m-d H:i:s'), 10);
		} else {
			$dt = FormatDateTime(date('Y-m-d H:i:s'), 11);
		}
		return $dt;
	} else {
		return date('Y-m-d H:i:s');
	}
}

// Get current date in standard format (yyyy/mm/dd)
function StdCurrentDate() {
	return date('Y/m/d');
}

// Get date in standard format (yyyy/mm/dd)
function StdDate($ts) {
	return date('Y/m/d', $ts);
}

// Get current date and time in standard format (yyyy/mm/dd hh:mm:ss)
function StdCurrentDateTime() {
	return date('Y/m/d H:i:s');
}

// Get date/time in standard format (yyyy/mm/dd hh:mm:ss)
function StdDateTime($ts) {
	return date('Y/m/d H:i:s', $ts);
}

// Get current date and time in database format (yyyy-mm-dd hh:mm:ss)
function DbCurrentDateTime() {
	return date('Y-m-d H:i:s');
}

// Encrypt password
function EncryptPassword($input, $salt = '') {
	if (PASSWORD_HASH)
		return password_hash($input, PASSWORD_DEFAULT);
	else
		return (strval($salt) <> "") ? md5($input . $salt) . ":" . $salt : md5($input);
}

// Compare password
// Note: If salted, password must be stored in '<hashedstring>:<salt>'
function ComparePassword($pwd, $input) {
	if (preg_match('/^\$[HP]\$/', $pwd)) { // phpass
		$ar = [10,8];
		foreach ($ar as $i) {
			$hasher = new \PasswordHash($i, TRUE);
			if ($hasher->CheckPassword($input, $pwd))
				return TRUE;
		}
		return FALSE;
	} elseif (ContainsString($pwd, ':')) { // <hashedstring>:<salt>
		@list($crypt, $salt) = explode(":", $pwd, 2);
		return ($pwd == EncryptPassword($input, $salt));
	} else {
		if (CASE_SENSITIVE_PASSWORD) {
			if (ENCRYPTED_PASSWORD) {
				if (PASSWORD_HASH)
					return password_verify($input, $pwd);
				else
					return ($pwd == EncryptPassword($input));
			} else {
				return ($pwd == $input);
			}
		} else {
			if (ENCRYPTED_PASSWORD) {
				if (PASSWORD_HASH)
					return password_verify(strtolower($input), $pwd);
				else
					return ($pwd == EncryptPassword(strtolower($input)));
			} else {
				return SameText($pwd, $input);
			}
		}
	}
}

// Get security object
function &Security() {
	return $GLOBALS["Security"];
}

// Get profile object
function &Profile($name = "", $value = NULL) {
	$profile = $GLOBALS["UserProfile"];
	if (!$profile)
		$profile = new UserProfile();
	$numargs = func_num_args();
	if ($numargs == 1) { // Get
		$value = $profile->get($name);
		return $value;
	} elseif ($numargs == 2) { // Set
		$profile->set($name, $value);
		$profile->save();
	}
	return $profile;
}

// Get language object
function &Language() {
	return $GLOBALS["Language"];
}

// Get breadcrumb object
function &Breadcrumb() {
	return $GLOBALS["Breadcrumb"];
}

/**
 * Functions for backward compatibility
 */
// Get current user name
function CurrentUserName() {
	global $Security;
	return (isset($Security)) ? $Security->currentUserName() : strval(@$_SESSION[SESSION_USER_NAME]);
}

// Get current user ID
function CurrentUserID() {
	global $Security;
	return (isset($Security)) ? $Security->currentUserID() : strval(@$_SESSION[SESSION_USER_ID]);
}

// Get current parent user ID
function CurrentParentUserID() {
	global $Security;
	return (isset($Security)) ? $Security->currentParentUserID() : strval(@$_SESSION[SESSION_PARENT_USER_ID]);
}

// Get current user level
function CurrentUserLevel() {
	global $Security;
	return (isset($Security)) ? $Security->currentUserLevelID() : @$_SESSION[SESSION_USER_LEVEL_ID];
}

// Get current user level list
function CurrentUserLevelList() {
	global $Security;
	return (isset($Security)) ? $Security->userLevelList() : strval(@$_SESSION[SESSION_USER_LEVEL_LIST]);
}

// Get Current user info
function CurrentUserInfo($fldname) {
	global $Security;
	$value = Profile($fldname);
	if ($value != NULL) {
		return $value;
	} elseif (isset($Security)) {
		return $Security->currentUserInfo($fldname);
	} elseif (defined(PROJECT_NAMESPACE . "USER_TABLE") && !IsSysAdmin()) {
		$user = CurrentUserName();
		if (strval($user) <> "")
			return ExecuteScalar("SELECT " . QuotedName($fldname, USER_TABLE_DBID) . " FROM " . USER_TABLE . " WHERE " .
				str_replace("%u", AdjustSql($user, USER_TABLE_DBID), USER_NAME_FILTER), USER_TABLE_DBID);
	}
	return NULL;
}

// Get current page ID
function CurrentPageID() {
	if (isset($GLOBALS["Page"])) {
		return $GLOBALS["Page"]->PageID;
	} elseif (defined(PROJECT_NAMESPACE . "PAGE_ID")) {
		return PAGE_ID;
	}
	return "";
}

// Allow list
function AllowList($tableName) {
	global $Security;
	return $Security->allowList($tableName);
}

// Allow add
function AllowAdd($tableName) {
	global $Security;
	return $Security->allowAdd($tableName);
}

// Is password expired
function IsPasswordExpired() {
	global $Security;
	return (isset($Security)) ? $Security->isPasswordExpired() : (@$_SESSION[SESSION_STATUS] == "passwordexpired");
}

// Set session password expired
function SetSessionPasswordExpired() {
	global $Security;
	if (isset($Security))
		$Security->setSessionPasswordExpired();
	else
		$_SESSION[SESSION_STATUS] = "passwordexpired";
}

// Is password reset
function IsPasswordReset() {
	global $Security;
	return (isset($Security)) ? $Security->isPasswordReset() : (@$_SESSION[SESSION_STATUS] == "passwordreset");
}

// Is logging in
function IsLoggingIn() {
	global $Security;
	return (isset($Security)) ? $Security->isLoggingIn() : (@$_SESSION[SESSION_STATUS] == "loggingin");
}

// Is logged in
function IsLoggedIn() {
	global $Security;
	return (isset($Security)) ? $Security->isLoggedIn() : (@$_SESSION[SESSION_STATUS] == "login");
}

// Is admin
function IsAdmin() {
	global $Security;
	return (isset($Security)) ? $Security->isAdmin() : (@$_SESSION[SESSION_SYS_ADMIN] == 1);
}

// Is system admin
function IsSysAdmin() {
	global $Security;
	return (isset($Security)) ? $Security->isSysAdmin() : (@$_SESSION[SESSION_SYS_ADMIN] == 1);
}

// Is Windows authenticated
function IsAuthenticated() {
	return CurrentWindowsUser() <> "";
}

// Is Export
function IsExport($format = "") {
	global $ExportType;
	if ($format)
		return SameText($ExportType, $format);
	else
		return ($ExportType <> "");
}

/**
 * Class for TEA encryption/decryption
 */
class Tea
{
	private static function _long2str($v, $w)
	{
		$len = count($v);
		$s = [];
		for ($i = 0; $i < $len; $i++)
		{
			$s[$i] = pack("V", $v[$i]);
		}
		if ($w) {
			return substr(join('', $s), 0, $v[$len - 1]);
		}	else {
			return join('', $s);
		}
	}
	private static function _str2long($s, $w)
	{
		$v = unpack("V*", $s. str_repeat("\0", (4 - strlen($s) % 4) & 3));
		$v = array_values($v);
		if ($w) {
			$v[count($v)] = strlen($s);
		}
		return $v;
	}

	// Encrypt
	public static function encrypt($str, $key = RANDOM_KEY)
	{
		if ($str == "")
			return "";
		$v = self::_str2long($str, true);
		$k = self::_str2long($key, false);
		$cntk = count($k);
		if ($cntk < 4) {
			for ($i = $cntk; $i < 4; $i++) {
				$k[$i] = 0;
			}
		}
		$n = count($v) - 1;
		$z = $v[$n];
		$y = $v[0];
		$delta = 0x9E3779B9;
		$q = floor(6 + 52 / ($n + 1));
		$sum = 0;
		while (0 < $q--) {
			$sum = self::_int32($sum + $delta);
			$e = $sum >> 2 & 3;
			for ($p = 0; $p < $n; $p++) {
				$y = $v[$p + 1];
				$mx = self::_int32((($z >> 5 & 0x07ffffff) ^ $y << 2) + (($y >> 3 & 0x1fffffff) ^ $z << 4)) ^ self::_int32(($sum ^ $y) + ($k[$p & 3 ^ $e] ^ $z));
				$z = $v[$p] = self::_int32($v[$p] + $mx);
			}
			$y = $v[0];
			$mx = self::_int32((($z >> 5 & 0x07ffffff) ^ $y << 2) + (($y >> 3 & 0x1fffffff) ^ $z << 4)) ^ self::_int32(($sum ^ $y) + ($k[$p & 3 ^ $e] ^ $z));
			$z = $v[$n] = self::_int32($v[$n] + $mx);
		}
		return self::_urlEncode(self::_long2str($v, false));
	}

	// Decrypt
	public static function decrypt($str, $key = RANDOM_KEY)
	{
		$str = self::_urlDecode($str);
		if ($str == "")
			return "";
		$v = self::_str2long($str, false);
		$k = self::_str2long($key, false);
		$cntk = count($k);
		if ($cntk < 4) {
			for ($i = $cntk; $i < 4; $i++) {
				$k[$i] = 0;
			}
		}
		$n = count($v) - 1;
		$z = $v[$n];
		$y = $v[0];
		$delta = 0x9E3779B9;
		$q = floor(6 + 52 / ($n + 1));
		$sum = self::_int32($q * $delta);
		while ($sum != 0) {
			$e = $sum >> 2 & 3;
			for ($p = $n; $p > 0; $p--) {
				$z = $v[$p - 1];
				$mx = self::_int32((($z >> 5 & 0x07ffffff) ^ $y << 2) + (($y >> 3 & 0x1fffffff) ^ $z << 4)) ^ self::_int32(($sum ^ $y) + ($k[$p & 3 ^ $e] ^ $z));
				$y = $v[$p] = self::_int32($v[$p] - $mx);
			}
			$z = $v[$n];
			$mx = self::_int32((($z >> 5 & 0x07ffffff) ^ $y << 2) + (($y >> 3 & 0x1fffffff) ^ $z << 4)) ^ self::_int32(($sum ^ $y) + ($k[$p & 3 ^ $e] ^ $z));
			$y = $v[0] = self::_int32($v[0] - $mx);
			$sum = self::_int32($sum - $delta);
		}
		return self::_long2str($v, true);
	}
	private static function _int32($n)
	{
		while ($n >= 2147483648) $n -= 4294967296;
		while ($n <= -2147483649) $n += 4294967296;
		return (int)$n;
	}
	private static function _urlEncode($string)
	{
		$data = base64_encode($string);
		return str_replace(['+','/','='], ['-','_','.'], $data);
	}
	private static function _urlDecode($string)
	{
		$data = str_replace(['-','_','.'], ['+','/','='], $string);
		return base64_decode($data);
	}
}

// Encrypt
function Encrypt($str, $key = RANDOM_KEY) {
	return Tea::encrypt($str, $key);
}

// Decrypt
function Decrypt($str, $key = RANDOM_KEY) {
	return Tea::decrypt($str, $key);
}

/**
 * Class for encryption/decryption with php-encryption
 */
class PhpEncryption
{
	protected $Key;

	// Constructor
	public function __construct($encodedKey, $password = "")
	{
		if ($password) { // Password protected key
			$key = \Defuse\Crypto\KeyProtectedByPassword::loadFromAsciiSafeString($encodedKey);
			$this->Key = $key->unlockKey($password);
		} else { // Random key
			$this->Key = \Defuse\Crypto\Key::loadFromAsciiSafeString($encodedKey);
		}
	}

	// Create random password protected key
	public static function CreateRandomPasswordProtectedKey($password)
	{
		$protectedKey = \Defuse\Crypto\KeyProtectedByPassword::createRandomPasswordProtectedKey($password);
		return $protectedKey->saveToAsciiSafeString();
	}

	// Create new random key without password
	public static function CreateNewRandomKey()
	{
		$key = \Defuse\Crypto\Key::createNewRandomKey();
		return $key->saveToAsciiSafeString();
	}

	// Encrypt with password
	public static function encryptWithPassword($plaintext, $password)
	{
		return \Defuse\Crypto\Crypto::encryptWithPassword($plaintext, $password);
	}

	// Decrypt with password
	public static function decryptWithPassword($plaintext, $password)
	{
		return \Defuse\Crypto\Crypto::decryptWithPassword($plaintext, $password);
	}

	// Encrypt
	public function encrypt($plaintext)
	{
		return \Defuse\Crypto\Crypto::encrypt($plaintext, $this->Key);
	}

	// Decrypt
	public function decrypt($plaintext)
	{
		return \Defuse\Crypto\Crypto::decrypt($plaintext, $this->Key);
	}
}

// Encrypt with php-encryption
function PhpEncrypt($str, $key = RANDOM_KEY) {
	return PhpEncryption::encryptWithPassword($str, $key);
}

// Decrypt with php-encryption
function PhpDecrypt($str, $key = RANDOM_KEY) {
	return PhpEncryption::decryptWithPassword($str, $key);
}

// HTML purifier config
if ($PurifierConfig === NULL) {
	$PurifierConfig = \HTMLPurifier_Config::createDefault();
}

// Remove XSS
function RemoveXss($val) {
	global $PurifierConfig, $Purifier;
	if ($Purifier === NULL)
		$Purifier = new \HTMLPurifier($PurifierConfig);
	if (is_array($val))
		return array_map(function ($v) use ($Purifier) {
			return $Purifier->purify($v);
		}, $val);
	else
		return $Purifier->purify($val);
}

// Check token
function CheckToken($token, $timeout = 0) {
	if ($timeout <= 0)
		$timeout = SessionTimeoutTime();
	return (time() - (int)Decrypt($token)) < $timeout;
}

// Create token
function CreateToken() {
	return Encrypt(time());
}

/**
 * HTTP request by cURL
 * Note: cURL must be enabled in PHP
 *
 * @param string $url URL
 * @param string $postdata Data for the request
 * @param string $method Request method, "GET"(default)  or "POST"
 * @return mixed Returns TRUE on success or FALSE on failure
 *  If the CURLOPT_RETURNTRANSFER option is set, returns the result on success, FALSE on failure.
 */
function ClientUrl($url, $postdata = "", $method = "GET") {
	if (!function_exists("curl_init"))
		die("cURL not installed."); //** side effect
	$ch = curl_init();
	$method = strtoupper($method);
	if ($method == "POST") {
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_POST, 1);
		curl_setopt($ch, CURLOPT_POSTFIELDS, $postdata);
	} elseif ($method == "GET") {
		curl_setopt($ch, CURLOPT_URL, $url . "?" . $postdata);
	}
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
	$res = curl_exec($ch);
	curl_close($ch);
	return $res;
}

// Calculate date difference
function DateDiff($dateTimeBegin, $dateTimeEnd, $interval = "d") {
	$dateTimeBegin = strtotime($dateTimeBegin);
	if ($dateTimeBegin === -1 || $dateTimeBegin === FALSE)
		return FALSE;
	$dateTimeEnd = strtotime($dateTimeEnd);
	if ($dateTimeEnd === -1 || $dateTimeEnd === FALSE)
		return FALSE;
	$dif = $dateTimeEnd - $dateTimeBegin;
	$arBegin = getdate($dateTimeBegin);
	$dateBegin = mktime(0, 0, 0, $arBegin["mon"], $arBegin["mday"], $arBegin["year"]);
	$arEnd = getdate($dateTimeEnd);
	$dateEnd = mktime(0, 0, 0, $arEnd["mon"], $arEnd["mday"], $arEnd["year"]);
	$difDate = $dateEnd - $dateBegin;
	switch ($interval) {
		case "s": // Seconds
			return $dif;
		case "n": // Minutes
			return ($dif > 0) ? floor($dif/60) : ceil($dif/60);
		case "h": // Hours
			return ($dif > 0) ? floor($dif/3600) : ceil($dif/3600);
		case "d": // Days
			return ($difDate > 0) ? floor($difDate/86400) : ceil($difDate/86400);
		case "w": // Weeks
			return ($difDate > 0) ? floor($difDate/604800) : ceil($difDate/604800);
		case "ww": // Calendar weeks
			$difWeek = (($dateEnd - $arEnd["wday"]*86400) - ($dateBegin - $arBegin["wday"]*86400))/604800;
			return ($difWeek > 0) ? floor($difWeek) : ceil($difWeek);
		case "m": // Months
			return (($arEnd["year"]*12 + $arEnd["mon"]) - ($arBegin["year"]*12 + $arBegin["mon"]));
		case "yyyy": // Years
			return ($arEnd["year"] - $arBegin["year"]);
	}
}

// Read global debug message
function GetDebugMessage() {
	global $DebugMessage, $ExportType;
	$msg = $DebugMessage;
	$DebugMessage = "";
	return ($ExportType == "" && $msg <> "") ? '<div class="card card-danger ew-debug"><div class="card-header"><h3 class="card-title">Debug</h3><div class="card-tools">
	<button type="button" class="btn btn-tool" data-widget="collapse"><i class="fa fa-minus"></i></button></div></div><div class="card-body">' . $msg . '</div></div>' : "";
}

// Set global debug message (2nd argument not used but required)
function SetDebugMessage($v, $newline = TRUE) {
	global $DebugMessage, $DebugTimer;
	$ar = preg_split('/<(hr|br)>/', trim($v));
	$ar = array_filter($ar, function($s) {
		return trim($s); 
	});
	$v = implode("; ", $ar);
	$DebugMessage .= "<p><samp>" . (isset($DebugTimer) ? number_format($DebugTimer->getElapsedTime(), 6) . ": " : "") . $v . "</samp></p>";
}

// Show debug message
function ShowDebugMessage() {
	global $DebugMessage;
	return DEBUG_ENABLED ? $DebugMessage : "";
}

// Save global debug message
function SaveDebugMessage() {
	global $DebugMessage;
	if (DEBUG_ENABLED)
		$_SESSION["DEBUG_MESSAGE"] = $DebugMessage;
}

// Load global debug message
function LoadDebugMessage() {
	global $DebugMessage;
	if (DEBUG_ENABLED) {
		$DebugMessage = @$_SESSION["DEBUG_MESSAGE"];
		$_SESSION["DEBUG_MESSAGE"] = "";
	}
}

// Permission denied message
function DeniedMessage() {
	global $Language;
	return str_replace("%s", ScriptName(), $Language->phrase("NoPermission"));
}

// Init array
function &InitArray($len, $value) {
	if ($len > 0)
		$ar = array_fill(0, $len, $value);
	else
		$ar = [];
	return $ar;
}

// Init 2D array
function &Init2DArray($len1, $len2, $value) {
	return InitArray($len1, InitArray($len2, $value));
}

// Remove elements from array by an array of keys and return the removed elements as array
function Splice(&$ar, $keys) {
	$arkeys = array_fill_keys($keys, 0);
	$res = array_intersect_key($ar, $arkeys);
	$ar = array_diff_key($ar, $arkeys);
	return $res;
}

// Extract elements from array by an array of keys
function Slice(&$ar, $keys) {
	$arkeys = array_fill_keys($keys, 0);
	return array_intersect_key($ar, $arkeys);
}

/**
 * User Profile Class
 */
class UserProfile
{
	public $Profile = [];
	public $Provider = "";
	public $Auth = "";

	// Constructor
	public function __construct()
	{
		$this->load();
	}

	// Has value
	public function has($name)
	{
		return array_key_exists($name, $this->Profile);
	}

	// Get value
	public function getValue($name)
	{
		if ($this->has($name))
			return $this->Profile[$name];
		return NULL;
	}

	// Get value (alias)
	public function get($name)
	{
		return $this->getValue($name);
	}

	// Set value
	public function setValue($name, $value)
	{
		$this->Profile[$name] = $value;
	}

	// Set value (alias)
	public function set($name, $value)
	{
		$this->setValue($name, $value);
	}

	// Set property // PHP
	public function __set($name, $value)
	{
		$this->setValue($name, $value);
	}

	// Get property // PHP
	public function __get($name)
	{
		return $this->getValue($name);
	}

	// Delete property
	public function delete($name)
	{
		if (array_key_exists($name, $this->Profile))
			unset($this->Profile[$name]);
	}

	// Assign properties
	public function assign($input)
	{
		if (is_object($input)) {
			$this->assign(get_object_vars($input));
		} elseif (is_array($input)) {
			foreach ($input as $key => $value) { // Remove integer keys
				if (is_int($key))
					unset($input[$key]);
			}
			$input = array_filter($input, function($val) {
				global $DATA_STRING_MAX_LENGTH;
				if (is_bool($val) || is_float($val) || is_int($val) || $val == NULL || is_string($val) && strlen($val) <= $DATA_STRING_MAX_LENGTH)
					return TRUE;
				return FALSE;
			});
			$this->Profile = array_merge($this->Profile, $input);
		}
	}

	// Check if System Admin
	protected function isSystemAdmin($usr)
	{
		global $Language;
		$adminUserName = ENCRYPTION_ENABLED ? PhpDecrypt(ADMIN_USER_NAME, ENCRYPTION_KEY): ADMIN_USER_NAME;
		return $usr == "" || $usr == $adminUserName || $usr == $Language->phrase("UserAdministrator");
	}

	// Load profile from session
	public function load()
	{
		if (isset($_SESSION[SESSION_USER_PROFILE]))
			$this->loadProfile($_SESSION[SESSION_USER_PROFILE]);
	}

	// Save profile to session
	public function save()
	{
		$_SESSION[SESSION_USER_PROFILE] = $this->profileToString();
	}

	// Load profile from string
	protected function loadProfile($profile)
	{
		$ar = unserialize(strval($profile));
		if (is_array($ar))
			$this->Profile = array_merge($this->Profile, $ar);
	}

	// Write (var_dump) profile
	public function writeProfile()
	{
		var_dump($this->Profile);
	}

	// Clear profile
	protected function clearProfile()
	{
		$this->Profile = [];
	}

	// Clear profile (alias)
	public function clear()
	{
		$this->clearProfile();
	}

	// Profile to string
	protected function profileToString()
	{
		return serialize($this->Profile);
	}
}

/**
 * Validation functions
 */

/**
 * Check date
 *
 * @param mixed $value Value
 * @param string $format Date format: std/stdshort/us/usshort/euro/euroshort
 * @param string $sep Date separator
 * @return booleanean
 */
function CheckDate($value, $format = "", $sep = "") {
	if (strval($value) == "")
		return TRUE;
	global $DATE_FORMAT, $DATE_SEPARATOR;
	if (!$format) {
		if (preg_match('/^yyyy/', $DATE_FORMAT))
			$format = "std";
		else if (preg_match('/^yy/', $DATE_FORMAT))
			$format = "stdshort";
		else if (preg_match('/^m/', $DATE_FORMAT) && preg_match('/yyyy$/', $DATE_FORMAT))
			$format = "us";
		else if (preg_match('/^m/', $DATE_FORMAT) && preg_match('/yy$/', $DATE_FORMAT))
			$format = "usshort";
		else if (preg_match('/^d/', $DATE_FORMAT) && preg_match('/yyyy$/', $DATE_FORMAT))
			$format = "euro";
		else if (preg_match('/^d/', $DATE_FORMAT) && preg_match('/yy$/', $DATE_FORMAT))
			$format = "euroshort";
		else
			return FALSE;
	}
	$sep = $sep ?: $DATE_SEPARATOR;
	$value = preg_replace('/ +/', " ", $value);
	$value = trim($value);
	$arDT = explode(" ", $value);
	if (count($arDT) > 0) {
		if (preg_match('/^([0-9]{4})-([0][1-9]|[1][0-2])-([0][1-9]|[1|2][0-9]|[3][0|1])$/', $arDT[0], $matches)) { // Accept yyyy-mm-dd
			$sYear = $matches[1];
			$sMonth = $matches[2];
			$sDay = $matches[3];
		} else {
			$wrksep = "\\$sep";
			switch ($format) {
				case "std":
					$pattern = '/^([0-9]{4})' . $wrksep . '([0]?[1-9]|[1][0-2])' . $wrksep . '([0]?[1-9]|[1|2][0-9]|[3][0|1])$/';
					break;
				case "stdshort":
					$pattern = '/^([0-9]{2})' . $wrksep . '([0]?[1-9]|[1][0-2])' . $wrksep . '([0]?[1-9]|[1|2][0-9]|[3][0|1])$/';
					break;
				case "us":
					$pattern = '/^([0]?[1-9]|[1][0-2])' . $wrksep . '([0]?[1-9]|[1|2][0-9]|[3][0|1])' . $wrksep . '([0-9]{4})$/';
					break;
				case "usshort":
					$pattern = '/^([0]?[1-9]|[1][0-2])' . $wrksep . '([0]?[1-9]|[1|2][0-9]|[3][0|1])' . $wrksep . '([0-9]{2})$/';
					break;
				case "euro":
					$pattern = '/^([0]?[1-9]|[1|2][0-9]|[3][0|1])' . $wrksep . '([0]?[1-9]|[1][0-2])' . $wrksep . '([0-9]{4})$/';
					break;
				case "euroshort":
					$pattern = '/^([0]?[1-9]|[1|2][0-9]|[3][0|1])' . $wrksep . '([0]?[1-9]|[1][0-2])' . $wrksep . '([0-9]{2})$/';
					break;
			}
			if (!preg_match($pattern, $arDT[0]))
				return FALSE;
			$arD = explode($sep, $arDT[0]); // Change $DATE_SEPARATOR to $sep
			switch ($format) {
				case "std":
				case "stdshort":
					$sYear = UnformatYear($arD[0]);
					$sMonth = $arD[1];
					$sDay = $arD[2];
					break;
				case "us":
				case "usshort":
					$sYear = UnformatYear($arD[2]);
					$sMonth = $arD[0];
					$sDay = $arD[1];
					break;
				case "euro":
				case "euroshort":
					$sYear = UnformatYear($arD[2]);
					$sMonth = $arD[1];
					$sDay = $arD[0];
					break;
			}
		}
		if (!CheckDay($sYear, $sMonth, $sDay))
			return FALSE;
	}
	if (count($arDT) > 1 && !CheckTime($arDT[1]))
		return FALSE;
	return TRUE;
}

// Unformat 2 digit year to 4 digit year
function UnformatYear($yr) {
	if (strlen($yr) == 2) {
		if ($yr > UNFORMAT_YEAR)
			return "19" . $yr;
		else
			return "20" . $yr;
	} else {
		return $yr;
	}
}

// Check Date format (yyyy/mm/dd)
function CheckStdDate($value) {
	global $DATE_SEPARATOR;
	return CheckDate($value, "std", $DATE_SEPARATOR);
}

// Check Date format (yy/mm/dd)
function CheckStdShortDate($value) {
	global $DATE_SEPARATOR;
	return CheckDate($value, "stdshort", $DATE_SEPARATOR);
}

// Check US Date format (mm/dd/yyyy)
function CheckUSDate($value) {
	global $DATE_SEPARATOR;
	return CheckDate($value, "us", $DATE_SEPARATOR);
}

// Check US Date format (mm/dd/yy)
function CheckShortUSDate($value) {
	global $DATE_SEPARATOR;
	return CheckDate($value, "usshort", $DATE_SEPARATOR);
}

// Check Euro Date format (dd/mm/yyyy)
function CheckEuroDate($value) {
	global $DATE_SEPARATOR;
	return CheckDate($value, "euro", $DATE_SEPARATOR);
}

// Check Euro Date format (dd/mm/yy)
function CheckShortEuroDate($value) {
	global $DATE_SEPARATOR;
	return CheckDate($value, "euroshort", $DATE_SEPARATOR);
}

// Check day
function CheckDay($checkYear, $checkMonth, $checkDay) {
	$maxDay = 31;
	if ($checkMonth == 4 || $checkMonth == 6 || $checkMonth == 9 || $checkMonth == 11) {
		$maxDay = 30;
	} elseif ($checkMonth == 2) {
		if ($checkYear % 4 > 0) {
			$maxDay = 28;
		} elseif ($checkYear % 100 == 0 && $checkYear % 400 > 0) {
			$maxDay = 28;
		} else {
			$maxDay = 29;
		}
	}
	return CheckRange($checkDay, 1, $maxDay);
}

// Check integer
function CheckInteger($value) {
	global $DECIMAL_POINT;
	if (strval($value) == "") return TRUE;
	if (ContainsString($value, $DECIMAL_POINT))
		return FALSE;
	return CheckNumber($value);
}

// Check number
function CheckNumber($value) {
	global $THOUSANDS_SEP, $DECIMAL_POINT;
	if (strval($value) == "") return TRUE;
	$pat = '/^[+-]?(\d{1,3}(' . (($THOUSANDS_SEP) ? '\\' . $THOUSANDS_SEP . '?' : '') . '\d{3})*(\\' .
		$DECIMAL_POINT . '\d+)?|\\' . $DECIMAL_POINT . '\d+)$/';
	return preg_match($pat, $value);
}

// Check range
function CheckRange($value, $min, $max) {
	if (strval($value) == "") return TRUE;
	if (is_int($min) || is_float($min) || is_int($max) || is_float($max)) { // Number
		if (CheckNumber($value))
			$value = (float)ConvertToFloatString($value);
	}
	if (($min != NULL && $value < $min) || ($max != NULL && $value > $max))
		return FALSE;
	return TRUE;
}

// Check time
function CheckTime($value) {
	global $Language, $TIME_SEPARATOR;
	if (strval($value) == "") return TRUE;
	return preg_match('/^(0[0-9]|1[0-9]|2[0-3])' . preg_quote($TIME_SEPARATOR) . '[0-5][0-9](( (' . preg_quote($Language->phrase("AM")) . '|' . preg_quote($Language->phrase("PM")) . '))|(' . preg_quote($TIME_SEPARATOR) . '[0-5][0-9](\.\d+)?)?)$/', $value);
}

// Check US phone number
function CheckPhone($value) {
	if (strval($value) == "") return TRUE;
	return preg_match('/^\(\d{3}\) ?\d{3}( |-)?\d{4}|^\d{3}( |-)?\d{3}( |-)?\d{4}$/', $value);
}

// Check US zip code
function CheckZip($value) {
	if (strval($value) == "") return TRUE;
	return preg_match('/^\d{5}$|^\d{5}-\d{4}$/', $value);
}

// Check credit card
function CheckCreditCard($value, $type="") {
	if (strval($value) == "") return TRUE;
	$creditcard = [
		"visa" => "/^4\d{3}[ -]?\d{4}[ -]?\d{4}[ -]?\d{4}$/",
		"mastercard" => "/^5[1-5]\d{2}[ -]?\d{4}[ -]?\d{4}[ -]?\d{4}$/",
		"discover" => "/^6011[ -]?\d{4}[ -]?\d{4}[ -]?\d{4}$/",
		"amex" => "/^3[4,7]\d{13}$/",
		"diners" => "/^3[0,6,8]\d{12}$/",
		"bankcard" => "/^5610[ -]?\d{4}[ -]?\d{4}[ -]?\d{4}$/",
		"jcb" => "/^[3088|3096|3112|3158|3337|3528]\d{12}$/",
		"enroute" => "/^[2014|2149]\d{11}$/",
		"switch" => "/^[4903|4911|4936|5641|6333|6759|6334|6767]\d{12}$/"
	];
	if (empty($type)) {
		$match = FALSE;
		foreach ($creditcard as $type => $pattern) {
			if (@preg_match($pattern, $value) == 1) {
				$match = TRUE;
				break;
			}
		}
		return ($match) ? CheckSum($value) : FALSE;
	}	else {
		if (!preg_match($creditcard[strtolower(trim($type))], $value)) return FALSE;
		return CheckSum($value);
	}
}

// Check sum
function CheckSum($value) {
	$value = str_replace(['-',' '], ['',''], $value);
	$checksum = 0;
	for ($i = (2 - (strlen($value) % 2)); $i <= strlen($value); $i += 2)
		$checksum += (int)($value[$i - 1]);
	for ($i = (strlen($value) % 2) + 1; $i <strlen($value); $i += 2) {
		$digit = (int)($value[$i - 1]) * 2;
		$checksum += ($digit < 10) ? $digit : ($digit - 9);
	}
	return ($checksum % 10 == 0);
}

// Check US social security number
function CheckSsc($value) {
	if (strval($value) == "") return TRUE;
	return preg_match('/^(?!000)([0-6]\d{2}|7([0-6]\d|7[012]))([ -]?)(?!00)\d\d\3(?!0000)\d{4}$/', $value);
}

// Check emails
function CheckEmailList($value, $email_cnt) {
	if (strval($value) == "") return TRUE;
	$emailList = str_replace(",", ";", $value);
	$arEmails = explode(";", $emailList);
	$cnt = count($arEmails);
	if ($cnt > $email_cnt && $email_cnt > 0)
		return FALSE;
	foreach ($arEmails as $email) {
		if (!CheckEmail($email))
			return FALSE;
	}
	return TRUE;
}

// Check email
function CheckEmail($value) {
	if (strval($value) == "") return TRUE;
	return preg_match('/^[\w.%+-]+@[\w.-]+\.[A-Z]{2,18}$/i', trim($value));
}

// Check GUID
function CheckGuid($value) {
	if (strval($value) == "") return TRUE;
	$p1 = '/^\{\w{8}-\w{4}-\w{4}-\w{4}-\w{12}\}$/';
	$p2 = '/^\w{8}-\w{4}-\w{4}-\w{4}-\w{12}$/';
	return preg_match($p1, $value) || preg_match($p2, $value);
}

// Check file extension
function CheckFileType($value, $exts = UPLOAD_ALLOWED_FILE_EXT) {
	if (strval($value) == "") return TRUE;
	$extension = substr(strtolower(strrchr($value, ".")), 1);
	$allowExt = explode(",", strtolower($exts));
	return (in_array($extension, $allowExt) || trim($exts) == "");
}

// Check empty string
function EmptyString($value) {
	$str = strval($value);
	if (preg_match('/&[^;]+;/', $str)) // Contains HTML entities
		$str = @html_entity_decode($str, ENT_COMPAT | ENT_HTML5, PROJECT_ENCODING);
	$str = str_replace(SameText(PROJECT_ENCODING, "UTF-8") ? "\xC2\xA0" : "\xA0", " ", $str);
	return (trim($str) == "");
}

// Check empty value
function EmptyValue($value) { // PHP
	return $value == NULL || strlen($value) == 0;
}

// Check by preg
function CheckByRegEx($value, $pattern) {
	if (strval($value) == "") return TRUE;
	return preg_match($pattern, $value);
}

/**
 * Convert to UTF-8
 *
 * @param mixed $val Value being converted
 * @return mixed
 */
function ConvertToUtf8($val) {
	if (IS_UTF8)
		return $val;
	if (is_string($val)) {
		return Convert(PROJECT_ENCODING, "UTF-8", $val);
	} elseif (is_array($val) || is_object($val)) {
		$isObject = is_object($val);
		if ($isObject)
			$val = (array)$val;
		$res = [];
		foreach ($val as $key => $value)
			$res[ConvertToUtf8($key)] = ConvertToUtf8($value);
		return ($isObject) ? (object)$res : $res;
	}
	return $val;
}

/**
 * Convert from UTF-8
 *
 * @param mixed $val Value being converted
 * @return mixed
 */
function ConvertFromUtf8($val) {
	if (IS_UTF8)
		return $val;
	if (is_string($val)) {
		return Convert("UTF-8", PROJECT_ENCODING, $val);
	} elseif (is_array($val) || is_object($val)) {
		$isObject = is_object($val);
		if ($isObject)
			$val = (array)$val;
		$res = [];
		foreach ($val as $key => $value)
			$res[ConvertFromUtf8($key)] = ConvertFromUtf8($value);
		return ($isObject) ? (object)$res : $res;
	}
	return $val;
}

/**
 * Convert encoding
 *
 * @param string $from Encoding (from)
 * @param string $to Encoding (to)
 * @param string $str String being converted
 * @return string
 */
function Convert($from, $to, $str) {
	if (is_string($str) && $from != "" && $to != "" && !SameText($from, $to)) {
		if (function_exists("iconv")) {
			return iconv($from, $to, $str);
		} elseif (function_exists("mb_convert_encoding")) {
			return mb_convert_encoding($str, $to, $from);
		} else {
			return $str;
		}
	} else {
		return $str;
	}
}

/**
 * Returns the JSON representation of a value
 *
 * @param mixed $val The value being encoded
 * @param string $type optional Specifies data type: "boolean" or "string"
 * @return string (No conversion to UTF-8)
 */
function VarToJson($val, $type = "") {
	global $DATA_STRING_MAX_LENGTH;
	$type = strtolower($type);
	if ($val === NULL) {
		return "null";
	} elseif ($type == "boolean" || is_bool($val)) {
		return ConvertToBool($val) ? "true" : "false";
	} elseif ($type == "string" || is_string($val)) {
		if (ContainsString($val, "\0")) // Contains null byte
			$val = "binary";
		elseif (strlen($val) > $DATA_STRING_MAX_LENGTH)
			$val = substr($val, 0, $DATA_STRING_MAX_LENGTH);
		return '"' . JsEncode($val) . '"';
	}
	return $val; // Number and other data types
}

/**
 * Convert array to JSON
 * If asscociative array, elements with integer key will not be outputted.
 *
 * @param array $ar The array being encoded
 * @param integer $offset The number of entries to skip
 * @return string (No conversion to UTF-8)
 */
function ArrayToJson(array $ar, $offset = 0) {
	if ($offset > 0)
		$ar = array_slice($ar, $offset);
	$isObject = ArraySome("is_string", array_keys($ar));
	$res = [];
	if ($isObject) {
		foreach ($ar as $key => $val) {
			if (is_int($key)) // If object, skip element with integer key
				continue;
			$res[] = VarToJson($key, "string") . ":" . JsonEncode($val);
		}
		return "{" . implode(",", $res) . "}";
	} else {
		foreach ($ar as $val)
			$res[] = JsonEncode($val);
		return "[" . implode(",", $res) . "]";
	}
}

/**
 * JSON encode
 *
 * @param mixed $val The value being encoded
 * @param integer|string $option optional Specifies offset if $val is array, or else specifies data type: "boolean" or "string".
 * @return string (non UTF-8)
 */
function JsonEncode($val, $option = NULL) {
	if (is_array($val))
		return ArrayToJson($val, (int)$option);
	elseif (is_object($val))
		return ArrayToJson((array)$val);
	else
		return VarToJson($val, $option);
}

/**
 * JSON decode
 *
 * @param string $val The JSON string being decoded (non UTF-8)
 * @param boolean $assoc optional When TRUE, returned objects will be converted into associative arrays.
 * @param integer $depth optional User specified recursion depth
 * @param integer $options optional Bitmask of JSON decode options:
 *  JSON_BIGINT_AS_STRING - allows casting big integers to string instead of floats
 *  JSON_OBJECT_AS_ARRAY - same as setting assoc to TRUE
 * @return void NULL is returned if the json cannot be decoded or if the encoded data is deeper than the recursion limit.
 */
function JsonDecode($val, $assoc = FALSE, $depth = 512, $options = 0) {
	if (!IS_UTF8)
		$val = ConvertToUtf8($val); // Convert to UTF-8
	$res = json_decode($val, $assoc, $depth, $options);
	if (!IS_UTF8)
		$res = ConvertFromUtf8($res);
	return $res;
}

/**
 * Check if a predicate is true for at least one element
 *
 * @param callable $callback Predicate
 * @param array $arr Array being tested
 * @return boolean
 */
function ArraySome(callable $callback, array $ar) {
	foreach ($ar as $element) {
		if ($callback($element))
			return TRUE;
	}
	return FALSE;
}

/**
 * Langauge class
 */
class Language
{
	protected $Phrases = NULL;
	public $LanguageId;
	public $LanguageFolder;
	public $Template = ""; // JsRender template
	public $Method = "prependTo"; // JsRender template method
	public $Target = ".navbar-nav.ml-auto"; // JsRender template target
	public $Type = "LI"; // LI/DROPDOWN (for used with top Navbar) or SELECT/RADIO (NOT for used with top Navbar)

	// Constructor
	public function __construct($langFolder = "", $langId = "")
	{
		global $CurrentLanguage, $LANGUAGE_FOLDER;
		$this->LanguageFolder = ($langFolder <> "") ? $langFolder : $LANGUAGE_FOLDER;
		$this->loadFileList(); // Set up file list
		if ($langId <> "") { // Set up language id
			$this->LanguageId = $langId;
			$_SESSION[SESSION_LANGUAGE_ID] = $this->LanguageId;
		} elseif (Param("language", "") <> "") {
			$this->LanguageId = Param("language");
			$_SESSION[SESSION_LANGUAGE_ID] = $this->LanguageId;
		} elseif (@$_SESSION[SESSION_LANGUAGE_ID] <> "") {
			$this->LanguageId = $_SESSION[SESSION_LANGUAGE_ID];
		} else {
			$this->LanguageId = LANGUAGE_DEFAULT_ID;
		}
		$CurrentLanguage = $this->LanguageId;
		$this->loadLanguage($this->LanguageId);

		// Call Language Load event
		$this->Language_Load();
	}

	// Load language file list
	protected function loadFileList()
	{
		global $LANGUAGE_FILE;
		if (is_array($LANGUAGE_FILE)) {
			$cnt = count($LANGUAGE_FILE);
			for ($i = 0; $i < $cnt; $i++)
				$LANGUAGE_FILE[$i][1] = $this->loadFileDesc($this->LanguageFolder . $LANGUAGE_FILE[$i][2]);
		}
	}

	// Load language file description
	protected function loadFileDesc($file)
	{
		$ar = Xml2Array(substr(file_get_contents($file), 0, 512)); // Just read the first part
		return (is_array($ar)) ? @$ar["ew-language"]["attr"]["desc"] : "";
	}

	// Load language file
	protected function loadLanguage($id)
	{
		global $DECIMAL_POINT, $THOUSANDS_SEP, $MON_DECIMAL_POINT, $MON_THOUSANDS_SEP,
			$CURRENCY_SYMBOL, $POSITIVE_SIGN, $NEGATIVE_SIGN, $FRAC_DIGITS,
			$P_CS_PRECEDES, $P_SEP_BY_SPACE, $N_CS_PRECEDES, $N_SEP_BY_SPACE,
			$P_SIGN_POSN, $N_SIGN_POSN, $TIME_ZONE,
			$DATE_SEPARATOR, $TIME_SEPARATOR, $DATE_FORMAT, $DATE_FORMAT_ID;
		$fileName = $this->getFileName($id);
		if ($fileName == "")
			$fileName = $this->getFileName(LANGUAGE_DEFAULT_ID);
		if ($fileName == "")
			return;
		if (is_array(@$_SESSION[PROJECT_NAME . "_" . $fileName])) {
			$this->Phrases = $_SESSION[PROJECT_NAME . "_" . $fileName];
		} else {
			$this->Phrases = Xml2Array(file_get_contents($fileName));
		}

		// Set up locale / currency format for language
		extract(LocaleConvert());
		if (!empty($decimal_point)) $DECIMAL_POINT = $decimal_point;
		if (!empty($thousands_sep)) $THOUSANDS_SEP = $thousands_sep;
		if (!empty($mon_decimal_point)) $MON_DECIMAL_POINT = $mon_decimal_point;
		if (!empty($mon_thousands_sep)) $MON_THOUSANDS_SEP = $mon_thousands_sep;
		if (!empty($currency_symbol)) $CURRENCY_SYMBOL = $currency_symbol;
		if (isset($positive_sign)) $POSITIVE_SIGN = $positive_sign; // Note: $positive_sign can be empty.
		if (!empty($negative_sign)) $NEGATIVE_SIGN = $negative_sign;
		if (isset($frac_digits)) $FRAC_DIGITS = $frac_digits;
		if (isset($p_cs_precedes)) $P_CS_PRECEDES = $p_cs_precedes;
		if (isset($p_sep_by_space)) $P_SEP_BY_SPACE = $p_sep_by_space;
		if (isset($n_cs_precedes)) $N_CS_PRECEDES = $n_cs_precedes;
		if (isset($n_sep_by_space)) $N_SEP_BY_SPACE = $n_sep_by_space;
		if (isset($p_sign_posn)) $P_SIGN_POSN = $p_sign_posn;
		if (isset($n_sign_posn)) $N_SIGN_POSN = $n_sign_posn;
		if (!empty($date_sep)) $DATE_SEPARATOR = $date_sep;
		if (!empty($time_sep)) $TIME_SEPARATOR = $time_sep;
		if (!empty($date_format)) {
			$DATE_FORMAT = DateFormat($date_format);
			$DATE_FORMAT_ID = DateFormatId($date_format);
		}

		// Set up time zone from language file for multi-language site
		// Read http://www.php.net/date_default_timezone_set for details
		//  and http://www.php.net/timezones for supported time zones

		if (!empty($time_zone))
			$TIME_ZONE = $time_zone;
		if (!empty($TIME_ZONE))
			date_default_timezone_set($TIME_ZONE);
	}

	// Get language file name
	protected function getFileName($id)
	{
		global $LANGUAGE_FILE;
		if (is_array($LANGUAGE_FILE)) {
			$cnt = count($LANGUAGE_FILE);
			for ($i = 0; $i < $cnt; $i++) {
				if ($LANGUAGE_FILE[$i][0] == $id)
					return $this->LanguageFolder . $LANGUAGE_FILE[$i][2];
			}
		}
		return "";
	}

	// Get phrase
	public function phrase($id, $useText = FALSE)
	{
		$imageClass = ConvertFromUtf8(@$this->Phrases["ew-language"]["global"]["phrase"][strtolower($id)]["attr"]["class"]);
		if (isset($this->Phrases["ew-language"]["global"]["phrase"][strtolower($id)]))
			$text = ConvertFromUtf8(@$this->Phrases["ew-language"]["global"]["phrase"][strtolower($id)]["attr"]["value"]);
		else
			$text = $id;
		if (!$useText && $imageClass <> "")
			return '<i data-phrase="' . $id . '" class="' . $imageClass . '" data-caption="' . HtmlEncode($text) . '"></i>';
		return $text;
	}

	// Set phrase
	public function setPhrase($id, $value)
	{
		$this->setPhraseAttr($id, "value", $value);
	}

	// Get project phrase
	public function projectPhrase($id)
	{
		return ConvertFromUtf8(@$this->Phrases["ew-language"]["project"]["phrase"][strtolower($id)]["attr"]["value"]);
	}

	// Set project phrase
	public function setProjectPhrase($id, $value)
	{
		$this->Phrases["ew-language"]["project"]["phrase"][strtolower($id)]["attr"]["value"] = $value;
	}

	// Get menu phrase
	public function menuPhrase($menuId, $id)
	{
		return ConvertFromUtf8(@$this->Phrases["ew-language"]["project"]["menu"][$menuId]["phrase"][strtolower($id)]["attr"]["value"]);
	}

	// Set menu phrase
	public function setMenuPhrase($menuId, $id, $value)
	{
		$this->Phrases["ew-language"]["project"]["menu"][$menuId]["phrase"][strtolower($id)]["attr"]["value"] = $value;
	}

	// Get table phrase
	public function tablePhrase($tblVar, $id)
	{
		return ConvertFromUtf8(@$this->Phrases["ew-language"]["project"]["table"][strtolower($tblVar)]["phrase"][strtolower($id)]["attr"]["value"]);
	}

	// Set table phrase
	public function setTablePhrase($tblVar, $id, $value)
	{
		$this->Phrases["ew-language"]["project"]["table"][strtolower($tblVar)]["phrase"][strtolower($id)]["attr"]["value"] = $value;
	}

	// Get field phrase
	public function fieldPhrase($tblVar, $fldVar, $id)
	{
		return ConvertFromUtf8(@$this->Phrases["ew-language"]["project"]["table"][strtolower($tblVar)]["field"][strtolower($fldVar)]["phrase"][strtolower($id)]["attr"]["value"]);
	}

	// Set field phrase
	public function setFieldPhrase($tblVar, $fldVar, $id, $value)
	{
		$this->Phrases["ew-language"]["project"]["table"][strtolower($tblVar)]["field"][strtolower($fldVar)]["phrase"][strtolower($id)]["attr"]["value"] = $value;
	}

	// Get phrase attribute
	protected function phraseAttr($id, $name)
	{
		return ConvertFromUtf8(@$this->Phrases["ew-language"]["global"]["phrase"][strtolower($id)]["attr"][strtolower($name)]);
	}

	// Set phrase attribute
	protected function setPhraseAttr($id, $name, $value)
	{
		$this->Phrases["ew-language"]["global"]["phrase"][strtolower($id)]["attr"][strtolower($name)] = $value;
	}

	// Get phrase class
	public function phraseClass($id)
	{
		return $this->PhraseAttr($id, "class");
	}

	// Set phrase attribute
	public function setPhraseClass($id, $value)
	{
		$this->setPhraseAttr($id, "class", $value);
	}

	// Output XML as JSON
	public function xmlToJson($xpath)
	{
		$nodeList = $this->Phrases->selectNodes($xpath);
		$res = [];
		foreach ($nodeList as $node) {
			$id = $this->getNodeAtt($node, "id");
			$value = $this->getNodeAtt($node, "value");
			$res[$id] = $value;
		}
		return JsonEncode($res);
	}

	// Output array as JSON
	public function arrayToJson($client)
	{
		$ar = @$this->Phrases["ew-language"]["global"]["phrase"];
		$res = [];
		if (is_array($ar)) {
			foreach ($ar as $id => $node) {
				$isClient = @$node["attr"]["client"] == '1';
				$value = ConvertFromUtf8(@$node["attr"]["value"]);
				if (!$client || $client && $isClient)
					$res[$id] = $value;
			}
		}
		return JsonEncode($res);
	}

	// Output all phrases as JSON
	public function allToJson()
	{
		return "ew.language = new ew.Language(" . $this->arrayToJson(FALSE) . ");";
	}

	// Output client phrases as JSON
	public function toJson()
	{
		SetClientVar("languages", ["languages" => $this->getLanguages()]);
		return "ew.language = new ew.Language(" . $this->arrayToJson(TRUE) . ");";
	}

	// Output languages as array
	protected function getLanguages()
	{
		global $LANGUAGE_FILE, $CurrentLanguage;
		$ar = [];
		if (is_array($LANGUAGE_FILE)) {
			$cnt = count($LANGUAGE_FILE);
			if ($cnt > 1) {
				for ($i = 0; $i < $cnt; $i++) {
					$langId = $LANGUAGE_FILE[$i][0];
					$phrase = $this->phrase($langId) ?: $LANGUAGE_FILE[$i][1];
					$ar[] = ["id" => $langId, "desc" => ConvertFromUtf8($phrase), "selected" => $langId == $CurrentLanguage];
				}
			}
		}
		return $ar;
	}

	// Get template
	public function getTemplate()
	{
		if ($this->Template == "") {
			if (SameText($this->Type, "LI")) { // LI template (for used with top Navbar)
				return '{{for languages}}<li class="nav-item"><a href="#" class="nav-link{{if selected}} active{{/if}} ew-tooltip" title="{{>desc}}" onclick="ew.setLanguage(this);" data-language="{{:id}}">{{:id}}</a></li>{{/for}}';
			} elseif (SameText($this->Type, "DROPDOWN")) { // DROPDOWN template (for used with top Navbar)
				return '<li class="nav-item dropdown"><a href="#" class="nav-link" data-toggle="dropdown"><i class="fa fa-globe ew-icon"></i></span></a><div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">{{for languages}}<a href="#" class="dropdown-item{{if selected}} active{{/if}}" onclick="ew.setLanguage(this);" data-language="{{:id}}">{{>desc}}</a>{{/for}}</div></li>';
			} elseif (SameText($this->Type, "SELECT")) { // SELECT template (NOT for used with top Navbar)
				return '<div class="ew-language-option"><select class="form-control" id="ew-language" name="ew-language" onchange="ew.setLanguage(this);">{{for languages}}<option value="{{:id}}"{{if selected}} selected{{/if}}>{{:desc}}</option>{{/for}}</select></div>';
			} elseif (SameText($this->Type, "RADIO")) { // RADIO template (NOT for used with top Navbar)
				return '<div class="ew-language-option"><div class="btn-group" data-toggle="buttons">{{for languages}}<input type="radio" name="ew-language" id="ew-Language-{{:id}}" autocomplete="off" onchange="ew.setLanguage(this);{{if selected}} checked{{/if}}" value="{{:id}}"><label class="btn btn-default ew-tooltip" for="ew-language-{{:id}}" data-container="body" data-placement="bottom" title="{{>desc}}">{{:id}}</label>{{/for}}</div></div>';
			}
		}
		return $this->Template;
	}

	// Language Load event
	function Language_Load() {

		// Example:
		//$this->setPhrase("MyID", "MyValue"); // Refer to language file for the actual phrase id
		//$this->setPhraseClass("MyID", "glyphicon glyphicon-xxx ewIcon"); // Refer to http://getbootstrap.com/components/#glyphicons [^] for icon name

		$this->setPhrase("AddLink", "Tambah Data Baru...");
		$this->setPhraseClass("AddLink", "");

	//	$this->setPhraseClass("EditLink", "");
	//	$this->setPhraseClass("DeleteLink", "");
	//	$this->setPhraseClass("ViewLink", "");

	}
}

/**
 * XML document class
 */
class XmlDocument
{
	public $Encoding = "utf-8";
	public $RootTagName;
	public $SubTblName = '';
	public $RowTagName;
	public $XmlDoc = FALSE;
	public $XmlTbl;
	public $XmlSubTbl;
	public $XmlRow;
	public $NullValue = 'NULL';

	// Constructor
	public function __construct($encoding = "")
	{
		if ($encoding <> "")
			$this->Encoding = $encoding;
		if ($this->Encoding <> "") {
			$this->XmlDoc = new \DOMDocument("1.0", strval($this->Encoding));
		} else {
			$this->XmlDoc = new \DOMDocument("1.0");
		}
	}

	// Load
	public function load($fileName)
	{
		$filePath = realpath($fileName);
		return file_exists($filePath) ? $this->XmlDoc->load($filePath) : FALSE;
	}

	// Get document element
	public function &documentElement()
	{
		$de = $this->XmlDoc->documentElement;
		return $de;
	}

	// Get attribute
	public function getAttribute($element, $name)
	{
		return ($element) ? ConvertFromUtf8($element->getAttribute($name)) : "";
	}

	// Set attribute
	public function setAttribute($element, $name, $value)
	{
		if ($element)
			$element->setAttribute($name, ConvertToUtf8($value));
	}

	// Select single node
	public function selectSingleNode($query)
	{
		$elements = $this->selectNodes($query);
		return ($elements->length > 0) ? $elements->item(0) : NULL;
	}

	// Select nodes
	public function selectNodes($query)
	{
		$xpath = new \DOMXPath($this->XmlDoc);
		return $xpath->query($query);
	}

	// Add root
	public function addRoot($rootTagName = 'table')
	{
		$this->RootTagName = XmlTagName($rootTagName);
		$this->XmlTbl = $this->XmlDoc->createElement($this->RootTagName);
		$this->XmlDoc->appendChild($this->XmlTbl);
	}

	// Add row
	public function addRow($tableTagName = '', $rowTagName = 'row')
	{
		$this->RowTagName = XmlTagName($rowTagName);
		$this->XmlRow = $this->XmlDoc->createElement($this->RowTagName);
		if ($tableTagName == '') {
			if ($this->XmlTbl)
				$this->XmlTbl->appendChild($this->XmlRow);
		} else {
			if ($this->SubTblName == '' || $this->SubTblName != $tableTagName) {
				$this->SubTblName = XmlTagName($tableTagName);
				$this->XmlSubTbl = $this->XmlDoc->createElement($this->SubTblName);
				$this->XmlTbl->appendChild($this->XmlSubTbl);
			}
			if ($this->XmlSubTbl)
				$this->XmlSubTbl->appendChild($this->XmlRow);
		}
	}

	// Add field
	public function addField($name, $value)
	{
		if ($value == NULL)
			$value = $this->NullValue;
		$value = ConvertToUtf8($value); // Convert to UTF-8
		$xmlfld = $this->XmlDoc->createElement(XmlTagName($name));
		$this->XmlRow->appendChild($xmlfld);
		$xmlfld->appendChild($this->XmlDoc->createTextNode($value));
	}

	// Get XML
	public function xml()
	{
		return $this->XmlDoc->saveXML();
	}
}

/**
 * Menu class
 */
class Menu
{
	public $Id;
	public $IsRoot;
	public $IsNavbar;
	public $Accordion = TRUE; // For sidebar menu only
	public $UseSubmenu = FALSE;
	public $Items = [];
	protected $NullItem = NULL;

	// Constructor
	public function __construct($id, $isRoot = FALSE, $isNavbar = FALSE)
	{
		$this->Id = $id;
		$this->IsRoot = $isRoot;
		$this->IsNavbar = $isNavbar;
		if ($isNavbar) {
			$this->UseSubmenu = TRUE;
			$this->Accordion = FALSE;
		}
	}

	// Add a menu item ($src for backward compatibility only)
	public function addMenuItem($id, $name, $text, $url, $parentId = -1, $src = "", $allowed = TRUE, $isHeader = FALSE, $isCustomUrl = FALSE, $icon = "", $label = "", $isNavbarItem = FALSE)
	{
		$item = new MenuItem($id, $name, $text, $url, $parentId, $allowed, $isHeader, $isCustomUrl, $icon, $label, $isNavbarItem);

		// MenuItem_Adding event
		if (function_exists(PROJECT_NAMESPACE . "MenuItem_Adding") && !MenuItem_Adding($item))
			return;
		if ($item->ParentId < 0) {
			$this->addItem($item);
		} else {
			if ($parentMenu = &$this->findItem($item->ParentId))
				$parentMenu->addItem($item);
		}
	}

	// Add item to internal array
	public function addItem($item)
	{
		$this->Items[] = $item;
	}

	// Clear all menu items
	public function clear()
	{
		$this->Items = [];
	}

	// Find item
	public function &findItem($id)
	{
		$cnt = count($this->Items);
		for ($i = 0; $i < $cnt; $i++) {
			$item = &$this->Items[$i];
			if ($item->Id == $id) {
				return $item;
			} elseif ($item->SubMenu != NULL) {
				if ($subitem = &$item->SubMenu->findItem($id))
					return $subitem;
			}
		}
		$nullItem = $this->NullItem;
		return $nullItem;
	}

	// Find item by menu text
	public function &findItemByText($txt)
	{
		$cnt = count($this->Items);
		for ($i = 0; $i < $cnt; $i++) {
			$item = &$this->Items[$i];
			if ($item->Text == $txt) {
				return $item;
			} elseif ($item->SubMenu != NULL) {
				if ($subitem = &$item->SubMenu->findItemByText($txt))
					return $subitem;
			}
		}
		$nullItem = $this->NullItem;
		return $nullItem;
	}

	// Get menu item count
	public function count()
	{
		return count($this->Items);
	}

	// Move item to position
	public function moveItem($text, $pos)
	{
		$cnt = count($this->Items);
		if ($pos < 0) {
			$pos = 0;
		} elseif ($pos >= $cnt) {
			$pos = $cnt - 1;
		}
		$item = NULL;
		$cnt = count($this->Items);
		for ($i = 0; $i < $cnt; $i++) {
			if ($this->Items[$i]->Text == $text) {
				$item = $this->Items[$i];
				break;
			}
		}
		if ($item) {
			unset($this->Items[$i]);
			$this->Items = array_merge(array_slice($this->Items, 0, $pos),
				[$item], array_slice($this->Items, $pos));
		}
	}

	// Check if a menu item should be shown
	public function renderItem($item)
	{
		if ($item->SubMenu != NULL) {
			foreach ($item->SubMenu->Items as $subitem) {
				if ($item->SubMenu->renderItem($subitem))
					return TRUE;
			}
		}
		return ($item->Allowed && $item->Url <> "");
	}

	// Check if a menu item should be opened
	public function isItemOpened($item)
	{
		if ($item->SubMenu != NULL) {
			foreach ($item->SubMenu->Items as $subitem) {
				if ($item->SubMenu->isItemOpened($subitem))
					return TRUE;
			}
		}
		return $item->Active;
	}

	// Check if this menu should be rendered
	public function renderMenu()
	{
		foreach ($this->Items as $item) {
			if ($this->renderItem($item))
				return TRUE;
		}
		return FALSE;
	}

	// Check if this menu should be opened
	public function isOpened()
	{
		foreach ($this->Items as $item) {
			if ($this->isItemOpened($item))
				return TRUE;
		}
		return FALSE;
	}

	// Render the menu as array of object
	public function render()
	{
		if ($this->IsRoot && function_exists(PROJECT_NAMESPACE . "Menu_Rendering"))
			Menu_Rendering($this);
		if (!$this->renderMenu())
			return;
		$menu = [];
		$url = CurrentUrl();
		$url = substr($url, strrpos($url, "/") + 1);
		$checkUrl = function($item) use ($url) {
			global $UNDEFINED_URL;
			if (!$item->IsCustomUrl && CurrentPageName() == GetPageName($item->Url) || $item->IsCustomUrl && $url == $item->Url) { // Active
				$item->Active = TRUE;
				$item->Url = $UNDEFINED_URL;
			} elseif ($item->SubMenu != NULL && $item->Url <> $UNDEFINED_URL && $this->IsNavbar && $this->IsRoot) { // Navbar root menu item with submenu
				$item->Attrs = 'data-url="' . $item->Url . '"';
				$item->Url = $UNDEFINED_URL; // Does not support URL for root menu item with submenu
			}
		};
		foreach ($this->Items as $item) {
			if ($this->renderItem($item)) {
				if ($item->IsHeader && (!$this->IsRoot || !$this->UseSubmenu)) { // Group title (Header)
					$checkUrl($item);
					$menu[] = $item->render(FALSE);
					if ($item->SubMenu != NULL) {
						foreach ($item->SubMenu->Items as $subitem) {
							if ($this->renderItem($subitem)) {
								$checkUrl($subitem);
								$menu[] = $subitem->render();
							}
						}
					}
				} else {
					$checkUrl($item);
					$menu[] = $item->render();
				}
			}
		}
		if ($this->IsRoot && function_exists(PROJECT_NAMESPACE . "Menu_Rendered"))
			Menu_Rendered($this);
		return count($menu) ? $menu : NULL;
	}

	// Returns the menu as JSON
	public function toJson()
	{
		return JsonEncode(["items" => $this->render(), "accordion" => $this->Accordion]);
	}

	// Returns the menu as script tag
	public function toScript()
	{
		return "<script>ew.vars." .  $this->Id . " = " . $this->toJson() . ";</script>";
	}
}

/**
 * Menu item class
 */
class MenuItem
{
	public $Id = "";
	public $Name = "";
	public $Text = "";
	public $Url = "";
	public $ParentId = -1;
	public $SubMenu = NULL; // Data type = Menu
	public $Allowed = TRUE;
	public $Target = "";
	public $IsHeader = FALSE;
	public $IsCustomUrl = FALSE;
	public $Href = ""; // Href attribute
	public $Active = FALSE;
	public $Icon = "";
	public $Attrs = ""; // HTML attributes
	public $Label = ""; // HTML (for vertical menu only)
	public $IsNavbarItem = "";

	// Constructor
	public function __construct($id, $name, $text, $url, $parentId = -1, $allowed = TRUE, $isHeader = FALSE, $isCustomUrl = FALSE, $icon = "", $label = "", $isNavbarItem = FALSE)
	{
		$this->Id = $id;
		$this->Name = $name;
		$this->Text = $text;
		$this->Url = $url;
		$this->ParentId = $parentId;
		$this->Allowed = $allowed;
		$this->IsHeader = $isHeader;
		$this->IsCustomUrl = $isCustomUrl;
		$this->Icon = $icon;
		$this->Label = $label;
		$this->IsNavbarItem = $isNavbarItem;
	}

	// Set property case-insensitively (for backward compatibility) // PHP
	function __set($name, $value) {
		$vars = get_class_vars(get_class($this));
		foreach ($vars as $key => $val) {
			if (SameText($name, $key)) {
				$this->$key = $value;
				break;
			}
		}
	}

	// Get property case-insensitively (for backward compatibility) // PHP
	function __get($name) {
		$vars = get_class_vars(get_class($this));
		foreach ($vars as $key => $val) {
			if (SameText($name, $key)) {
				return $this->$key;
				break;
			}
		}
		return NULL;
	}

	// Add submenu item
	public function addItem($item)
	{
		if ($this->SubMenu == NULL)
			$this->SubMenu = new Menu($this->Id);
		$this->SubMenu->addItem($item);
	}

	// Render
	public function render($deep = TRUE)
	{
		global $UNDEFINED_URL;
		$url = GetUrl($this->Url);
		if (IsMobile() && !$this->IsCustomUrl && $url <> $UNDEFINED_URL)
			$url = str_replace("#", (ContainsString($url, "?") ? "&" : "?") . "hash=", $url);
		if ($url == "")
			$url = $UNDEFINED_URL;
		$attrs = trim($this->Attrs);
		if ($attrs)
			$attrs = " " . $attrs;
		$class = trim($this->Icon);
		if ($class) {
			$ar = explode(" ", $class);
			foreach ($ar as $name) {
				if (StartsString("fa-", $name) && !in_array("fa", $ar))
					$ar[] = "fa";
			}
			$class = implode(" ", $ar);
		}
		return [
			"id" => $this->Id,
			"name" => $this->Name,
			"text" => $this->Text,
			"parentId" => $this->ParentId,
			"href" => $url,
			"attrs" => $attrs,
			"target" => $this->Target,
			"isHeader" => $this->IsHeader,
			"active" => $this->Active,
			"icon" => $class,
			"label" => $this->Label,
			"isNavbarItem" => $this->IsNavbarItem,
			"items" => ($deep && $this->SubMenu != NULL) ? $this->SubMenu->render() : NULL,
			"open" => ($deep && $this->Submenu != NULL) ? $this->SubMenu->isOpened() : FALSE
		];
	}
}

// MenuItem Adding event
function MenuItem_Adding($item) {

	//var_dump($item);
	// Return FALSE if menu item not allowed

	return TRUE;
}

// Menu Rendering event
function Menu_Rendering($menu) {

	// Change menu items here
}

// Menu Rendered event
function Menu_Rendered($menu) {

	// Clean up here
}

// Output SCRIPT tag
function AddClientScript($src, $attrs = NULL) {
	global $RELATIVE_PATH;
	if ($RELATIVE_PATH <> "" && !StartsString($RELATIVE_PATH, $src))
		$src = $RELATIVE_PATH . $src;
	$atts = ["src" => $src];
	if (is_array($attrs))
		$atts = array_merge($atts, $attrs);
	echo HtmlElement("script", $atts, "") . "\n";
}

// Output LINK tag
function AddStylesheet($href, $attrs = NULL) {
	global $RELATIVE_PATH;
	if ($RELATIVE_PATH <> "" && !StartsString($RELATIVE_PATH, $href))
		$href = $RELATIVE_PATH . $href;
	$atts = ["rel" => "stylesheet", "type" => "text/css", "href" => $href];
	if (is_array($attrs))
		$atts = array_merge($atts, $attrs);
	echo HtmlElement("link", $atts, "", FALSE) . "\n";
}

// Is Boolean attribute
function IsBooleanAttribute($attr) {
	global $BOOLEAN_HTML_ATTRIBUTES;
	return in_array(strtolower($attr), $BOOLEAN_HTML_ATTRIBUTES);
}

// Build HTML element
function HtmlElement($tagname, $attrs, $innerhtml = "", $endtag = TRUE) {
	$html = "<" . $tagname;
	if (is_array($attrs)) {
		foreach ($attrs as $k => $v) {
			$k = trim($k);
			$v = trim($v);
			if ($k <> "" && ($v <> "" || IsBooleanAttribute($k))) { // Allow boolean attributes, e.g. "disabled"
				$html .= " " . $k;
				if ($v <> "")
					$html .= "=\"" . HtmlEncode($v) . "\"";
			}
		}
	}
	$html .= ">";
	if (strval($innerhtml) <> "")
		$html .= $innerhtml;
	if ($endtag)
		$html .= "</" . $tagname . ">";
	return $html;
}

// Encode HTML
function HtmlEncode($exp) {
	return @htmlspecialchars(strval($exp), ENT_COMPAT | ENT_HTML5, PROJECT_ENCODING);
}

// Decode HTML
function HtmlDecode($exp) {
	return @htmlspecialchars_decode(strval($exp), ENT_COMPAT | ENT_HTML5);
}

// Get title
function HtmlTitle($name) {
	if (preg_match('/\s+title\s*=\s*[\'"]([\s\S]*?)[\'"]/i', $name, $matches)) { // Match title='title'
		return $matches[1];
	} elseif (preg_match('/\s+data-caption\s*=\s*[\'"]([\s\S]*?)[\'"]/i', $name, $matches)) { // Match data-caption='caption'
		return $matches[1];
	} else {
		return $name;
	}
}

// Get title and image
function HtmlImageAndText($name) {
	if (preg_match('/<i([^>]*)>/i', $name) || preg_match('/<span([^>]*)>([\s\S]*?)<\/span\s*>/i', $name) || preg_match('/<img([^>]*)>/i', $name))
		$title = HtmlTitle($name);
	else
		$title = $name;
	return ($title <> $name) ? $name . "&nbsp;" . $title : $name;
}

/**
 * Get HTML for an option
 *
 * @param mixed $val Value of the option
 * @return string HTML
 */
function OptionHtml($val) {
	global $OPTION_HTML_TEMPLATE;
	return preg_replace('/\{value\}/', $val, $OPTION_HTML_TEMPLATE);
}

/**
 * Get HTML for all option
 *
 * @param array $values Array of values
 * @return string HTML
 */
function OptionsHtml(array $values) {
	$html = "";
	foreach ($values as $val)
		$html .= OptionHtml($val);
	return $html;
}

// XML tag name
function XmlTagName($name) {
	if (!preg_match('/\A(?!XML)[a-z][\w0-9-]*/i', $name))
		$name = "_" . $name;
	return $name;
}

// Debug timer
class Timer
{
	public $StartTime;
	public static $Template = '<div class="alert alert-info ew-alert"><i class="icon fa fa-info"></i>Page processing time: {time} seconds</div>';

	// Constructor
	public function __construct($start = TRUE)
	{
		if ($start)
			$this->start();
	}

	// Get time
	protected function getTime()
	{
		return microtime(TRUE);
	}

	// Get elapsed time
	public function getElapsedTime()
	{
		$curtime = $this->getTime();
		if (isset($curtime) && isset($this->StartTime) && $curtime > $this->StartTime)
			return $curtime - $this->StartTime;
		else
			return 0;
	}

	// Get script start time
	public function start()
	{
		if (DEBUG_ENABLED)
			$this->StartTime = $this->getTime();
	}

	// Display elapsed time (in seconds)
	public function stop()
	{
		if (DEBUG_ENABLED) {
			$time = $this->getElapsedTime();
			echo str_replace("{time}", number_format($time, 6), self::$Template);
		}
	}
}

// Convert XML to array
function Xml2Array($contents) {
	if (!$contents)
		return [];
	$get_attributes = 1; // Always get attributes. DO NOT CHANGE!

	// Get the XML Parser of PHP
	$parser = xml_parser_create();
	xml_parser_set_option($parser, XML_OPTION_TARGET_ENCODING, "UTF-8"); // Always return in utf-8
	xml_parser_set_option($parser, XML_OPTION_CASE_FOLDING, 0);
	xml_parser_set_option($parser, XML_OPTION_SKIP_WHITE, 1);
	xml_parse_into_struct($parser, trim($contents), $xml_values);
	xml_parser_free($parser);
	if (!is_array($xml_values))
		return [];
	$xml_array = [];
	$parents = [];
	$opened_tags = [];
	$arr = [];
	$current = &$xml_array;
	$repeated_tag_index = []; // Multiple tags with same name will be turned into an array
	foreach ($xml_values as $data) {
		unset($attributes, $value); // Remove existing values

		// Extract these variables into the foreach scope
		// - tag(string), type(string), level(int), attributes(array)

		extract($data);
		$result = [];
		if (isset($value))
			$result["value"] = $value; // Put the value in a assoc array

		// Set the attributes
		if (isset($attributes) and $get_attributes) {
			foreach ($attributes as $attr => $val)
				$result["attr"][$attr] = $val; // Set all the attributes in a array called 'attr'
		}

		// See tag status and do the needed
		if ($type == "open") { // The starting of the tag '<tag>'
			$parent[$level - 1] = &$current;
			if (!is_array($current) || !in_array($tag, array_keys($current))) { // Insert New tag
				if ($tag <> 'ew-language' && @$result["attr"]["id"] <> '') {
					$last_item_index = $result["attr"]["id"];
					$current[$tag][$last_item_index] = $result;
					$repeated_tag_index[$tag . '_' . $level] = 1;
					$current = &$current[$tag][$last_item_index];
				} else {
					$current[$tag] = $result;
					$repeated_tag_index[$tag . '_' . $level] = 0;
					$current = &$current[$tag];
				}
			} else { // Another element with the same tag name
				if ($repeated_tag_index[$tag . '_' . $level] > 0) { // If there is a 0th element it is already an array
					if (@$result["attr"]["id"] <> '') {
						$last_item_index = $result["attr"]["id"];
					} else {
						$last_item_index = $repeated_tag_index[$tag . '_' . $level];
					}
					$current[$tag][$last_item_index] = $result;
					$repeated_tag_index[$tag . '_' . $level]++;
				} else { // Make the value an array if multiple tags with the same name appear together
					$temp = $current[$tag];
					$current[$tag] = [];
					if (@$temp["attr"]["id"] <> '') {
						$current[$tag][$temp["attr"]["id"]] = $temp;
					} else {
						$current[$tag][] = $temp;
					}
					if (@$result["attr"]["id"] <> '') {
						$last_item_index = $result["attr"]["id"];
					} else {
						$last_item_index = 1;
					}
					$current[$tag][$last_item_index] = $result;
					$repeated_tag_index[$tag . '_' . $level] = 2;
				}
				$current = &$current[$tag][$last_item_index];
			}
		} elseif ($type == "complete") { // Tags that ends in one line '<tag />'
			if (!isset($current[$tag])) { // New key
				$current[$tag] = []; // Always use array for "complete" type
				if (@$result["attr"]["id"] <> '') {
					$current[$tag][$result["attr"]["id"]] = $result;
				} else {
					$current[$tag][] = $result;
				}
				$repeated_tag_index[$tag . '_' . $level] = 1;
			} else { // Existing key
				if (@$result["attr"]["id"] <> '') {
					$current[$tag][$result["attr"]["id"]] = $result;
				} else {
					$current[$tag][$repeated_tag_index[$tag . '_' . $level]] = $result;
				}
				$repeated_tag_index[$tag . '_' . $level]++;
			}
		} elseif ($type == 'close') { // End of tag '</tag>'
			$current = &$parent[$level - 1];
		}
	}
	return $xml_array;
}

// Encode value for double-quoted Javascript string
function JsEncode($val) {
	$val = strval($val);
	if (IS_DOUBLE_BYTE)
		$val = ConvertToUtf8($val);
	$val = str_replace("\\", "\\\\", $val);
	$val = str_replace("\"", "\\\"", $val);
	$val = str_replace("\t", "\\t", $val);
	$val = str_replace("\r", "\\r", $val);
	$val = str_replace("\n", "\\n", $val);
	if (IS_DOUBLE_BYTE)
		$val = ConvertFromUtf8($val);
	return $val;
}

// Encode value to single-quoted Javascript string for HTML attributes
function JsEncodeAttribute($val) {
	$val = strval($val);
	if (IS_DOUBLE_BYTE)
		$val = ConvertToUtf8($val);
	$val = str_replace("\\", "\\\\", $val);
	$val = str_replace("'", "\\'", $val);
	$val = str_replace("\"", "&quot;", $val);
	if (IS_DOUBLE_BYTE)
		$val = ConvertFromUtf8($val);
	return $val;
}

// Convert array to JSON for HTML attributes
function ArrayToJsonAttribute($ar) {
	$str = "{";
	foreach ($ar as $key => $val)
		$str .= $key . ":'" . JsEncodeAttribute($val) . "',";
	if (EndsString(",", $str))
		$str = substr($str, 0, strlen($str) - 1);
	$str .= "}";
	return $str;
}

// Get current page name
function CurrentPageName() {
	return GetPageName(ScriptName());
}

// Get page name
function GetPageName($url) {
	$pageName = "";
	if ($url <> "") {
		$pageName = $url;
		$p = strpos($pageName, "?");
		if ($p !== FALSE)
			$pageName = substr($pageName, 0, $p); // Remove QueryString
		$p = strrpos($pageName, "/");
		if ($p !== FALSE)
			$pageName = substr($pageName, $p + 1); // Remove path
	}
	return $pageName;
}

// Get current user levels as array of user level IDs
function CurrentUserLevels() {
	global $Security;
	if (isset($Security)) {
		return $Security->UserLevelID;
	} else {
		if (isset($_SESSION[SESSION_USER_LEVEL_ID]))
			return [$_SESSION[SESSION_USER_LEVEL_ID]];
		return [];
	}
}

// Check if menu item is allowed for current user level
function AllowListMenu($tableName) {
	if (IsLoggedIn()) { // Get user level ID list as array
		$userlevels = CurrentUserLevels(); // Get user level ID list as array
	} else { // Get anonymous user level ID
		$userlevels = [-2];
	}
	if (in_array("-1", $userlevels)) {
		return TRUE;
	} else {
		$priv = 0;
		if (is_array(@$_SESSION[SESSION_AR_USER_LEVEL_PRIV])) {
			foreach ($_SESSION[SESSION_AR_USER_LEVEL_PRIV] as $row) {
				if (SameString($row[0], $tableName) &&
					in_array($row[1], $userlevels)) {
					$thispriv = $row[2];
					if ($thispriv == NULL)
						$thispriv = 0;
					$thispriv = (int)$thispriv;
					$priv = $priv | $thispriv;
				}
			}
		}
		return ($priv & ALLOW_LIST);
	}
}

// Get script name
function ScriptName() {
	$sn = ServerVar("SCRIPT_NAME");
	if (empty($sn)) $sn = ServerVar("URL");
	if (empty($sn)) $sn = ServerVar("PHP_SELF");
	if (empty($sn)) $sn = ServerVar("ORIG_PATH_INFO");

	//if (empty($sn)) $sn = ServerVar("ORIG_SCRIPT_NAME");
	if (empty($sn)) $sn = ServerVar("REQUEST_URI");
	if (empty($sn)) $sn = "UNKNOWN";
	return $sn;
}

// Get server variable by name
function ServerVar($name) {
	$str = @$_SERVER[$name];
	if (empty($str))
		$str = @$_ENV[$name];
	return $str;
}

// Get CSS file
function CssFile($f) {
	global $CSS_FLIP;
	if ($CSS_FLIP)
		return preg_replace('/(.css)$/i', "-rtl.css", $f);
	else
		return $f;
}

// Check if HTTPS
function IsHttps() {
	return ServerVar("HTTPS") <> "" && ServerVar("HTTPS") <> "off" || ServerVar("SERVER_PORT") == 443 ||
		ServerVar("HTTP_X_FORWARDED_PROTO") <> "" && ServerVar("HTTP_X_FORWARDED_PROTO") == "https";
}

// Get domain URL
function DomainUrl() {
	$url = "http";
	$ssl = IsHttps();
	$port = strval(ServerVar("SERVER_PORT"));
	if (ServerVar("HTTP_X_FORWARDED_PROTO") <> "" && strval(ServerVar("HTTP_X_FORWARDED_PORT")) <> "")
		$port = strval(ServerVar("HTTP_X_FORWARDED_PORT"));
	$defPort = ($ssl) ? "443" : "80";
	$port = ($port == $defPort) ? "" : (":" . $port);
	$url .= ($ssl) ? "s" : "";
	$url .= "://";
	$url .= ServerVar("SERVER_NAME") . $port;
	return $url;
}

// Get current URL
function CurrentUrl() {
	$s = ScriptName();
	$q = ServerVar("QUERY_STRING");
	if ($q <> "") $s .= "?" . $q;
	return $s;
}

// Get full URL
function FullUrl($url = "", $type = "") {
	if (IsRemote($url))
		return $url;
	global $FULL_URL_PROTOCOLS;
	$fullUrl = DomainUrl() . ScriptName();
	if ($url <> "")
		$fullUrl = substr($fullUrl, 0, strrpos($fullUrl, "/") + 1) . $url;
	while (strstr($fullUrl, "../")) // Remove parent path (../)
		$fullUrl = preg_replace("/\/[^\/]+\/\.\.\//", "/", $fullUrl);
	$protocol = @$FULL_URL_PROTOCOLS[$type];
	if ($protocol)
		$fullUrl = preg_replace('/^\w+(?!:\/\/)/i', $protocol, $fullUrl);
	return $fullUrl;
}

// Get relative URL
function GetUrl($url) {
	global $RELATIVE_PATH;
	if ($url != "" && !StartsString("/", $url) && !ContainsString($url, "://") && !ContainsString($url, "\\") && !ContainsString($url, "javascript:")) {
		$path = "";
		$p = strrpos($url, "/");
		if ($p !== FALSE) {
			$path = substr($url, 0, $p);
			$url = substr($url, $p + 1);
		}
		$path = PathCombine($RELATIVE_PATH, $path, FALSE);
		if ($path <> "")
			$path = IncludeTrailingDelimiter($path, FALSE);
		return $path . $url;
	} else {
		return $url;
	}
}

// Check if mobile device
function IsMobile() {
	global $MobileDetect, $IsMobile;
	if (isset($IsMobile))
		return $IsMobile;
	if (!isset($MobileDetect)) {
		$MobileDetect = new \Mobile_Detect();
		$IsMobile = $MobileDetect->isMobile();
	}
	return $IsMobile;
}

// Check if responsive layout
function IsResponsiveLayout() {
	return $GLOBALS["USE_RESPONSIVE_LAYOUT"];
}

// Execute UPDATE, INSERT, or DELETE statements
function Execute($sql, $fn = NULL, $c = NULL) {
	if ($c == NULL && (is_string($fn) || is_object($fn) && method_exists($fn, "execute")))
		$c = $fn;
	if (is_string($c))
		$c = &Conn($c);
	$conn = $c ?: @$GLOBALS["conn"] ?: Conn();
	$conn->raiseErrorFn = $GLOBALS["ERROR_FUNC"];
	$rs = $conn->execute($sql);
	$conn->raiseErrorFn = '';
	if (is_callable($fn) && $rs) {
		while (!$rs->EOF) {
			$fn($rs->fields);
			$rs->moveNext();
		}
		$rs->moveFirst(); // For MySQL and PostgreSQL only
	}
	return $rs;
}

// Executes the query, and returns the first column of the first row
function ExecuteScalar($sql, $c = NULL) {
	$res = FALSE;
	$rs = LoadRecordset($sql, $c);
	if ($rs && !$rs->EOF && $rs->FieldCount() > 0) {
		$res = $rs->fields[0];
		$rs->Close();
	}
	return $res;
}

// Executes the query, and returns the first row
function ExecuteRow($sql, $c = NULL) {
	$res = FALSE;
	$rs = LoadRecordset($sql, $c);
	if ($rs && !$rs->EOF) {
		$res = $rs->fields;
		$rs->Close();
	}
	return $res;
}

// Executes the query, and returns all rows
function ExecuteRows($sql, $c = NULL) {
	$res = FALSE;
	$rs = LoadRecordset($sql, $c);
	if ($rs && !$rs->EOF) {
		$res = $rs->GetRows();
		$rs->Close();
	}
	return $res;
}

/**
 * Executes the query, and returns all rows as JSON
 *
 * @param string $sql SQL to execute
 * @param array $options {
 *  @var boolean "header" Output JSON header, default: TRUE
 *  @var boolean "utf8" Convert to UTF-8, default: TRUE
 *  @var boolean "array" Output as array
 *  @var boolean "firstonly" Output first row only
 * }
 * @param ADOConnection|string $c Connection object or DB ID
 * @return string
 */
function ExecuteJson($sql, $options = NULL, $c = NULL) {
	$ar = is_array($options) ? $options : [];
	if (is_bool($options)) // First only, backward compatibility
		$ar["firstonly"] = $options;
	if ($c == NULL && is_object($options) && method_exists($options, "execute")) // ExecuteJson($sql, $c)
		$c = $options;
	$res = "false";
	$header = !array_key_exists("header", $ar) || $ar["header"]; // Set header for JSON
	$utf8 = $header || array_key_exists("utf8", $ar) && $ar["utf8"]; // Convert to utf-8
	$array = array_key_exists("array", $ar) && $ar["array"];
	$firstonly = array_key_exists("firstonly", $ar) && $ar["firstonly"];
	if ($firstonly)
		$rows = [ExecuteRow($sql, $c)];
	else
		$rows = ExecuteRows($sql, $c);
	if (is_array($rows)) {
		$arOut = [];
		foreach ($rows as $row) {
			$arwrk = [];
			foreach ($row as $key => $val) {
				if (($array && is_string($key)) || (!$array && is_int($key)))
					continue;
				$key = ($array) ? "" : "\"" . JsEncode($key) . "\":";
				$arwrk[] = $key . VarToJson($val);
			}
			if ($array) { // Array
				$arOut[] = "[" . implode(",", $arwrk) . "]";
			} else { // Object
				$arOut[] = "{" . implode(",", $arwrk) . "}";
			}
		}
		$res = ($firstonly) ? $arOut[0] : "[" . implode(",", $arOut) . "]";
		if ($utf8)
			$res = ConvertToUtf8($res);
	}
	if ($header)
		AddHeader("Content-Type", "application/json; charset=utf-8");
	return $res;
}

/**
 * Get query result in HTML table
 *
 * @param string $sql SQL to execute
 * @param array $options optional {
 *  @var bool|array "fieldcaption"
 *    TRUE Use caption and use language object
 *    FALSE Use field names directly
 *    array An associative array for looking up the field captions by field name 
 *  @var bool "horizontal" Specifies if the table is horizontal, default: false
 *  @var string|array "tablename" Table name(s) for the language object
 *  @var string "tableclass" CSS class names of the table, default: "table table-bordered ew-db-table"
 *  @var Language "language" Language object, default: the global Language object
 * }
 * @param ADOConnection|string $c optional Connection object or DB ID
 * @return string HTML string
 */
function ExecuteHtml($sql, $options = NULL, $c = NULL) {

	// Internal function to get field caption
	$getFieldCaption = function ($key) use ($options) {
		$caption = "";
		if (!is_array($options))
			return $key;
		$tableName = @$options["tablename"];
		$lang = @$options["language"] ?: $GLOBALS["Language"];
		$useCaption = (array_key_exists("fieldcaption", $options) && $options["fieldcaption"]);
		if ($useCaption) {
			if (is_array($options["fieldcaption"])) {
				$caption = @$options["fieldcaption"][$key];
			} elseif (isset($lang)) {
				if (is_array($tableName)) {
					foreach ($tableName as $tbl) {
						$caption = @$lang->FieldPhrase($tbl, $key, "FldCaption");
						if ($caption <> "")
							break;
					}
				} elseif ($tableName <> "") {
					$caption = @$lang->FieldPhrase($tableName, $key, "FldCaption");
				}
			}
		}
		return $caption ?: $key;
	};
	$options = is_array($options) ? $options : [];
	$horizontal = (array_key_exists("horizontal", $options) && $options["horizontal"]);
	$rs = LoadRecordset($sql, $c);
	if (!$rs || $rs->EOF || $rs->fieldCount() < 1)
		return "";
	$html = "";
	$class = @$options["tableclass"] ?: "table table-bordered ew-db-table"; // Table CSS class name
	if ($rs->RecordCount() > 1 || $horizontal) { // Horizontal table
		$cnt = $rs->fieldCount();
		$html = "<table class=\"" . $class . "\">";
		$html .= "<thead><tr>";
		$row = &$rs->fields;
		foreach ($row as $key => $value) {
			if (!is_numeric($key))
				$html .= "<th>" . $getFieldCaption($key) . "</th>";
		}
		$html .= "</tr></thead>";
		$html .= "<tbody>";
		$rowcnt = 0;
		while (!$rs->EOF) {
			$html .= "<tr>";
			$row = &$rs->fields;
			foreach ($row as $key => $value) {
				if (!is_numeric($key))
					$html .= "<td>" . $value . "</td>";
			}
			$html .= "</tr>";
			$rs->moveNext();
		}
		$html .= "</tbody></table>";
	} else { // Single row, vertical table
		$html = "<table class=\"" . $class . "\"><tbody>";
		$row = &$rs->fields;
		foreach ($row as $key => $value) {
			if (!is_numeric($key)) {
				$html .= "<tr>";
				$html .= "<td>" . $getFieldCaption($key) . "</td>";
				$html .= "<td>" . $value . "</td></tr>";
			}
		}
		$html .= "</tbody></table>";
	}
	return $html;
}

// Load recordset
function &LoadRecordset($sql, $c = NULL) {
	if (is_string($c))
		$c = &Conn($c);
	$conn = $c ?: @$GLOBALS["conn"] ?: Conn();
	$rs = $conn->Execute($sql);
	return $rs;
}

/**
 * Prepend CSS class name(s)
 *
 * @param string &$attr class name(s)
 * @param string $className class name(s) to prepend
 * @return void
 */
function PrependClass(&$attr, $className) {
	$attr = $className . " " . $attr;
	if ($attr <> "") {
		$ar = array_filter(explode(" ", $attr));
		$ar = array_unique($ar);
		$attr = implode(" ", $ar);
	}
}

/**
 * Append CSS class name(s)
 *
 * @param string &$attr class name(s)
 * @param string $className class name(s) to append
 * @return void
 */
function AppendClass(&$attr, $className) {
	$attr .= " " . $className;
	if ($attr <> "") {
		$ar = array_filter(explode(" ", $attr));
		$ar = array_unique($ar);
		$attr = implode(" ", $ar);
	}
}

/**
 * Remove CSS class name(s)
 *
 * @param string &$attr class name(s)
 * @param string $className class name(s) to remove
 * @return void
 */
function RemoveClass(&$attr, $className) {
	$ar = explode(" ", $attr);
	$classes = explode(" ", $className);
	$ar = array_diff($ar, $classes);
	$ar = array_filter($ar);
	$ar = array_unique($ar);
	$attr = implode(" ", $ar);
}

// Get numeric formatting information
function LocaleConvert() {
	$langid = CurrentLanguageID();
	$localefile = LOCALE_FOLDER . $langid . ".json";
	if (!file_exists($localefile)) // Locale file not found, try lowercase file name
		$localefile = LOCALE_FOLDER . strtolower($langid) . ".json";
	if (!file_exists($localefile)) // Locale file not found, fall back to English ("en") locale
		$localefile = LOCALE_FOLDER . "en.json";
	$locale = json_decode(file_get_contents($localefile), TRUE);
	$locale["currency_symbol"] = ConvertFromUtf8($locale["currency_symbol"]);
	return $locale;
}

/**
 * Get internal default date format (e.g. "yyyy/mm/dd"") from date format (int)
 *
 * @param integer $dateFormat
 *  5 - Ymd (default)
 *  6 - mdY
 *  7 - dmY
 *  9/109 - YmdHis/YmdHi
 *  10/110 - mdYHis/mdYHi
 *  11/111 - dmYHis/dmYHi
 *  12 - ymd
 *  13 - mdy
 *  14 - dmy
 *  15/115 - ymdHis/ymdHi
 *  16/116 - mdyHis/mdyHi
 *  17/117 - dmyHis/dmyHi
 * @return string
 */
function DateFormat($dateFormat) {
	global $DATE_SEPARATOR;
	if (is_numeric($dateFormat)) {
		$dateFormat = (int)$dateFormat;
		if ($dateFormat > 100) // Format without seconds
			$dateFormat -= 100;
		switch ($dateFormat) {
			case 5:
			case 9:
				return "yyyy" . $DATE_SEPARATOR . "mm" . $DATE_SEPARATOR . "dd";
			case 6:
			case 10:
				return "mm" . $DATE_SEPARATOR . "dd" . $DATE_SEPARATOR . "yyyy";
			case 7:
			case 11:
				return "dd" . $DATE_SEPARATOR . "mm" . $DATE_SEPARATOR . "yyyy";
			case 12:
			case 15:
				return "yy" . $DATE_SEPARATOR . "mm" . $DATE_SEPARATOR . "dd";
			case 13:
			case 16:
				return "mm" . $DATE_SEPARATOR . "dd" . $DATE_SEPARATOR . "yy";
			case 14:
			case 17:
				return "dd" . $DATE_SEPARATOR . "mm" . $DATE_SEPARATOR . "yy";
		}
	} elseif (is_string($dateFormat)) {
		switch (substr($dateFormat, 0, 3)) {
			case "Ymd":
				return "yyyy" . $DATE_SEPARATOR . "mm" . $DATE_SEPARATOR . "dd";
			case "mdY":
				return "mm" . $DATE_SEPARATOR . "dd" . $DATE_SEPARATOR . "yyyy";
			case "dmY":
				return "dd" . $DATE_SEPARATOR . "mm" . $DATE_SEPARATOR . "yyyy";
			case "ymd":
				return "yy" . $DATE_SEPARATOR . "mm" . $DATE_SEPARATOR . "dd";
			case "mdy":
				return "mm" . $DATE_SEPARATOR . "dd" . $DATE_SEPARATOR . "yy";
			case "dmy":
				return "dd" . $DATE_SEPARATOR . "mm" . $DATE_SEPARATOR . "yy";
		}
	}
	return "yyyy" . $DATE_SEPARATOR . "mm" . $DATE_SEPARATOR . "dd";
}

// Validate locale file date format
function DateFormatId($dateFormat) {
	if (is_numeric($dateFormat)) {
		$dateFormat = (int)$dateFormat;
		return (in_array($dateFormat, [5, 6, 7, 9, 109, 10, 110, 11, 111, 12, 13, 14, 15, 115, 16, 116, 17, 117])) ? $dateFormat : 5;
	} elseif (is_string($dateFormat)) {
		switch ($dateFormat) {
			case "Ymd":
				return 5;
			case "mdY":
				return 6;
			case "dmY":
				return 7;
			case "YmdHis":
				return 9;
			case "YmdHi":
				return 109;
			case "mdYHis":
				return 10;
			case "mdYHi":
				return 110;
			case "dmYHis":
				return 11;
			case "dmYHi":
				return 111;
			case "ymd":
				return 12;
			case "mdy":
				return 13;
			case "dmy":
				return 14;
			case "ymdHis":
				return 15;
			case "ymdHi":
				return 115;
			case "mdyHis":
				return 16;
			case "mdyHi":
				return 116;
			case "dmyHis":
				return 17;
			case "dmyHi":
				return 117;
		}
	}
	return 5;
}

// Get path relative to a base path
function PathCombine($basePath, $relPath, $phyPath) {
	if (IsRemote($relPath)) // Allow remote file
		return $relPath;
	$phyPath = !IsRemote($basePath) && $phyPath;
	$delimiter = ($phyPath) ? PATH_DELIMITER : '/';
	if ($basePath <> $delimiter) // If BasePath = root, do not remove delimiter
		$basePath = RemoveTrailingDelimiter($basePath, $phyPath);
	$relPath = ($phyPath) ? str_replace(['/', '\\'], PATH_DELIMITER, $relPath) : str_replace('\\', '/', $relPath);
	$relPath = IncludeTrailingDelimiter($relPath, $phyPath);
	$p1 = strpos($relPath, $delimiter);
	$path2 = "";
	while ($p1 !== FALSE) {
		$path = substr($relPath, 0, $p1 + 1);
		if ($path == $delimiter || $path == '.' . $delimiter) {

			// Skip
		} elseif ($path == '..' . $delimiter) {
			$p2 = strrpos($basePath, $delimiter);
			if ($p2 === 0) // BasePath = "/xxx", cannot move up
				$basePath = $delimiter;
			elseif ($p2 !== FALSE && !EndsString("..", $basePath))
				$basePath = substr($basePath, 0, $p2);
			elseif ($basePath <> "" && $basePath <> "." && $basePath <> "..")
				$basePath = "";
			else
				$path2 .= ".." . $delimiter;
		} else {
			$path2 .= $path;
		}
		$relPath = substr($relPath, $p1 + 1);
		if ($relPath === FALSE)
			$relPath = "";
		$p1 = strpos($relPath, $delimiter);
	}
	return (($basePath === "" || $basePath === ".") ? "" : IncludeTrailingDelimiter($basePath, $phyPath)) . $path2 . $relPath;
}

// Remove the last delimiter for a path
function RemoveTrailingDelimiter($path, $phyPath) {
	$delimiter = (!IsRemote($path) && $phyPath) ? PATH_DELIMITER : '/';
	while (substr($path, -1) == $delimiter)
		$path = substr($path, 0, strlen($path)-1);
	return $path;
}

// Include the last delimiter for a path
function IncludeTrailingDelimiter($path, $phyPath) {
	$path = RemoveTrailingDelimiter($path, $phyPath);
	$delimiter = (!IsRemote($path) && $phyPath) ? PATH_DELIMITER : '/';
	return $path . $delimiter;
}

// Get session timeout time (seconds)
function SessionTimeoutTime() {
	if (SESSION_TIMEOUT > 0) // User specified timeout time
		$mlt = SESSION_TIMEOUT * 60;
	else // Get max life time from php.ini
		$mlt = (int)ini_get("session.gc_maxlifetime");
	if ($mlt <= 0)
		$mlt = 1440; // PHP default (1440s = 24min)
	return $mlt - 30; // Add some safety margin
}

// Contains a substring (case-sensitive)
function ContainsString($haystack, $needle, $offset = 0) {
	return strpos($haystack, $needle, $offset) !== FALSE;
}

// Contains a substring (case-insensitive)
function ContainsText($haystack, $needle, $offset = 0) {
	return stripos($haystack, $needle, $offset) !== FALSE;
}

// Starts with a substring (case-sensitive)
function StartsString($needle, $haystack) {
	return strpos($haystack, $needle) === 0;
}

// Starts with a substring (case-insensitive)
function StartsText($needle, $haystack) {
	return stripos($haystack, $needle) === 0;
}

// Ends with a substring (case-sensitive)
function EndsString($needle, $haystack) {
	return strrpos($haystack, $needle) === strlen($haystack) - strlen($needle);
}

// Ends with a substring (case-insensitive)
function EndsText($needle, $haystack) {
	return strripos($haystack, $needle) === strlen($haystack) - strlen($needle);
}

// Same trimmed strings (case-sensitive)
function SameString($str1, $str2) {
	return strcmp(trim($str1), trim($str2)) === 0;
}

// Same trimmed strings (case-insensitive)
function SameText($str1, $str2) {
	return strcasecmp(trim($str1), trim($str2)) === 0;
}

// Set client variable
function SetClientVar($name, $value) {
	global $CLIENT_VAR;
	$key = strval($name);
	if ($key <> "")
		$CLIENT_VAR[$key] = $value;
}

// Get client variable
function GetClientVar($name) {
	global $CLIENT_VAR;
	$key = strval($name);
	if ($key <> "" && array_key_exists($key, $CLIENT_VAR))
		return $CLIENT_VAR[$key];
	return NULL;
}

// Is remote path
function IsRemote($path) {
	global $REMOTE_FILE_PATTERN;
	return preg_match($REMOTE_FILE_PATTERN, $path);
}

// Get/Set global login status array
function &LoginStatus($name = "", $value = NULL) {
	global $LoginStatus;
	$numargs = func_num_args();
	if ($numargs == 1) { // Get
		$value = (array_key_exists($name, $LoginStatus)) ? $LoginStatus[$name] : NULL;
		return $value;
	} elseif ($numargs == 2) { // Set
		$LoginStatus[$name] = $value;
	}
	return $LoginStatus;
}

// Is auto login (login with option "Auto login until I logout explicitly")
function IsAutoLogin() {
	return (@$_SESSION[SESSION_USER_LOGIN_TYPE] == "a");
}

// Get current page heading
function CurrentPageHeading() {
	global $Language, $Page;
	if (PAGE_TITLE_STYLE <> "Title" && isset($Page) && method_exists($Page, "pageHeading")) {
		$heading = $Page->pageHeading();
		if ($heading <> "")
			return $heading;
	}
	return $Language->ProjectPhrase("BodyTitle");
}

// Get current page subheading
function CurrentPageSubheading() {
	global $Page;
	$heading = "";
	if (PAGE_TITLE_STYLE <> "Title" && isset($Page) && method_exists($Page, "pageSubheading"))
		$heading = $Page->pageSubheading();
	return $heading;
}

// Set up login status
function SetupLoginStatus() {
	global $LoginStatus, $Language;
	$LoginStatus["isLoggedIn"] = IsLoggedIn();
	$LoginStatus["currentUserName"] = CurrentUserName();
	$LoginStatus["logoutUrl"] = GetUrl("logout.php");
	$LoginStatus["logoutText"] = $Language->phrase("Logout");
	$LoginStatus["loginUrl"] = GetUrl("login.php");
	$LoginStatus["loginText"] = $Language->phrase("Login");
	$LoginStatus["canLogin"] = !IsLoggedIn() && !EndsString($LoginStatus["loginUrl"], @$_SERVER["URL"]);
	$LoginStatus["canLogout"] = IsLoggedIn();
	$LoginStatus["changePasswordUrl"] = GetUrl("changepwd.php");
	$LoginStatus["changePasswordText"] = $Language->phrase("ChangePwd");
	$LoginStatus["canChangePassword"] = IsLoggedIn() && !IsSysAdmin();
}

// Convert HTML to text
function HtmlToText($html) {
	return @\Html2Text\Html2Text::convert($html);
}

/**
 * HtmlValue interface (Value that can be converted to HTML and string)
 */
interface HtmlValueInterface
{
	public function toHtml(callable $fn = NULL);
	public function __toString();
}

/**
 * Class OptionValues
 */
class OptionValues implements HtmlValueInterface {
	public $Values = [];

	// Constructor
	public function __construct($ar = NULL) {
		if (is_array($ar))
			$this->Values = $ar;
	}

	// Add value
	public function add($value) {
		$this->Values[] = $value;
	}

	// Convert to HTML
	public function toHtml(callable $fn = NULL) {
		$fn = $fn ?: PROJECT_NAMESPACE . "OptionsHtml";
		if (is_callable($fn))
			return $fn($this->Values);
		return $this->__toString();
	}

	// Convert to string (MUST return a string value)
	public function __toString() {
		global $OPTION_SEPARATOR;
		return implode($OPTION_SEPARATOR, $this->Values);
	}
}

/**
 * Get DB helper
 *
 * @param integer|string $dbid - DB ID
 * @return DbHelperBase
 */
function &DbHelper($dbid = 0) {
	$dbHelper = new DbHelperBase($dbid);
	return $dbHelper;
}

/**
 * Class DbHelper
 */
class DbHelperBase {

	// Connection
	public $Connection;

	// Constructor
	public function __construct($dbid = 0) {
		$this->Connection = &GetConnection($dbid); // Open connection
	}

	// Executes the query, and returns the row(s) as JSON
	public function executeJson($sql, $options = NULL) {
		return ExecuteJson($sql, $options, $this->Connection);
	}

	// Execute UPDATE, INSERT, or DELETE statements
	public function execute($sql, $fn = NULL) {
		return Execute($sql, $fn, $this->Connection);
	}

	// Executes the query, and returns the first column of the first row
	public function executeScalar($sql) {
		return ExecuteScalar($sql, $this->Connection);
	}

	// Executes the query, and returns the first row
	public function executeRow($sql) {
		return ExecuteRow($sql, $this->Connection);
	}

	// Executes the query, and returns all rows
	public function executeRows($sql) {
		return ExecuteRows($sql, $this->Connection);
	}

	// Executes the query, and returns as HTML
	public function executeHtml($sql, $options = NULL) {
		return ExecuteHtml($sql, $options, $this->Connection);
	}

	// Load recordset
	public function &loadRecordset($sql) {
		return LoadRecordset($sql, $this->Connection);
	}
}
?>