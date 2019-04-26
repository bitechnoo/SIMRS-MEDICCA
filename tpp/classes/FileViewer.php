<?php
namespace PHPMaker2019\tpp;

/**
 * File Viewer class
 */
class FileViewer
{

	/**
	 * Output file
	 * Note: Uncomment ** for database connectivity
	 *
	 * @return bool Whether file is outputted successfully
	 */
	public function getFile()
	{
		global $Security, $RequestSecurity, $PROJECT_ID;

		//**$GLOBALS["Conn"] = &GetConnection();
		// Get parameters

		$tbl = NULL;
		$tableName = "";
		if (IsPost()) {
			$token = Post(TOKEN_NAME, "");
			$sessionId = Post("session", "");
			$fn = Post("fn", "");
			$table = Post("object", "");
			$field = Post("field", "");
			$recordkey = Post("key", "");
			$resize = Post("resize", "0") == "1";
			$width = Post("width", 0);
			$height = Post("height", 0);
			$download = Post("download", "1") == "1"; // Download by default
		} else { // api/file/object/field/key
			$token = Get(TOKEN_NAME, "");
			$sessionId = Get("session", "");
			$fn = Get("fn", "");
			$table = Get("object", Route(1));
			$field = Get("field", Route(2));
			$recordkey = Get("key", Route("key"));
			$resize = Get("resize", "0") == "1";
			$width = Get("width", 0);
			$height = Get("height", 0);
			$download = Get("download", "1") == "1"; // Download by default
		}
		$sessionId = Decrypt($sessionId);
		$key = RANDOM_KEY . $sessionId;
		if (!is_numeric($width))
			$width = 0;
		if (!is_numeric($height))
			$height = 0;
		if ($width == 0 && $height == 0 && $resize) {
			$width = THUMBNAIL_DEFAULT_WIDTH;
			$height = THUMBNAIL_DEFAULT_HEIGHT;
		}
		$validRequest = FALSE;

		// Get table object
		$tbl = $this->getTable($table);
		$tableName = is_object($tbl) ? $tbl->TableName : "";

		// For internal request, check if valid token
		$func = PROJECT_NAMESPACE . CHECK_TOKEN_FUNC;
		if ($token <> "") {
			if (is_callable($func))
				$validRequest = $func($token, SessionTimeoutTime());
			$fn = Decrypt($fn, $key); // File path is always encrypted
			if ($validRequest && !isset($Security)) { // Set up Security from session
				if (session_status() !== PHP_SESSION_ACTIVE)
					session_start(); // Init session data
				$Security = new AdvancedSecurity();
			}
		} else { // DO NOT support external request for file path
			$fn = "";
		}

		// For external request, login user via JWT
		if (!$validRequest && $tableName <> "") {

			// Security
			$Security = new AdvancedSecurity();
			if (is_array($RequestSecurity)) { // Login user
				$Security->loginUser(@$RequestSecurity["username"], @$RequestSecurity["userid"], @$RequestSecurity["parentuserid"], @$RequestSecurity["userlevelid"]);
				$validRequest = TRUE;
			}
		}

		// Check security
		if ($validRequest && $tableName <> "") {
			if ($Security->isLoggedIn())
				$Security->TablePermission_Loading();
			$Security->loadCurrentUserLevel($PROJECT_ID . $tableName);
			if ($Security->isLoggedIn())
				$Security->TablePermission_Loaded();
			$validRequest = $Security->canList() || $Security->canView() || $Security->canDelete(); // With permission
		}

		// Reject invalid request
		if (!$validRequest)
			return FALSE;

		// Resize image from physical file
		$res = FALSE;
		if ($fn <> "") {
			$fn = str_replace("\0", "", $fn);
			$info = pathinfo($fn);
			if (file_exists($fn) || @fopen($fn, "rb") !== FALSE) {
				$ext = strtolower(@$info["extension"]);
				$ct = MimeContentType($fn);
				if ($ct <> "")
					AddHeader("Content-type", $ct);
				if ($download)
					AddHeader("Content-Disposition", "attachment; filename=\"" . $info["basename"] . "\"");
				if (in_array($ext, explode(",", IMAGE_ALLOWED_FILE_EXT))) {
					$size = @getimagesize($fn);
					if ($size && @$size['mime'] <> "")
						AddHeader("Content-type", $size['mime']);
					if ($width > 0 || $height > 0)
						$data = ResizeFileToBinary($fn, $width, $height);
					else
						$data = file_get_contents($fn);
				} elseif (in_array($ext, explode(",", DOWNLOAD_ALLOWED_FILE_EXT))) {
					$data = file_get_contents($fn);
				}

				// Clear output buffer
				if (ob_get_length())
					ob_end_clean();

				// Write binary data
				Write($data);
				$res = TRUE;
			}

		// Get image from table
		} elseif (is_object($tbl) && $field <> "" && $recordkey <> "") {
			$res = $tbl->getFileData($field, $recordkey, $resize, $width, $height);
		}

		// Close connection
		//**CloseConnections();

		return $res;
	}

	/**
	 * Get table object
	 *
	 * @param string $table Table variable name
	 * @return mixed Table class
	 */
	protected function getTable($table) {
		$class = PROJECT_NAMESPACE . $table;
		if (class_exists($class)) {
			$tbl = new $class();
			return $tbl;
		}
		return NULL;
	}
}
?>