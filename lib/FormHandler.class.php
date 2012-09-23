<?php
/**
 * FormHandler class processes application form
 */
class FormHandler {
	// Salt for crc32
	const SALT = "glitch";
	
	// @var FormHandler
	private static $instance = null;
	
	// date in YmdHis form
	private $time;
	
	private function __construct() {
		$this->time = date('YmdHis');
	}
	
	public static function getInstance() {
		if (self::$instance === null) {
			self::$instance = new FormHandler();
		}
		return self::$instance;
	}

	public function handle() {
		if (isset($_POST['key'])
			&& strlen($_POST['key']) > 0
			&& $_POST['key'] === Session::getSession()->getValue('key')) {
				Session::getSession()->unsetValue('key');
			
				// handle form
				$processed = $this->processForm();
				if ($processed === true) {
					return true;
				} else {
					Session::getSession()->setValue('msg','Could not process form data');
				}
		} else {
			Vtlog::log('Form key mismatch.');
		}
		return false;
	}

	public static function getKey() {
		Session::getSession()->unsetValue('key');
		$key = uniqid();
		Session::getSession()->setValue('key', $key);
		return $key;
	}
	
	private function processForm() {
		if ($this->isValid()) {
			$uploadId = crc32($_POST['name'] . self::SALT . $_POST['hometown'] . $this->time);
			// save stuff to dir and to db
			
			$saveDbSuccess = $this->storeData($uploadId);
			
			// create jpg of any PSD, EPS, AI or TIFF file
			$saveSuccess = $this->saveFile($uploadId);
			if ($saveSuccess === true && $saveDbSuccess === true) {
				return true;
			}
		}
		Vtlog::log("Form data not valid.");
		return false;
	}
	
	private function isValid() {
		$isValid = isset($_FILES['design']) && $_FILES['design']['error'] === UPLOAD_ERR_OK
				&& isset($_POST['name']) && strlen($_POST['name']) > 0
				&& isset($_POST['url']) && strlen($_POST['url']) > 0
				&& isset($_POST['email']) && strlen($_POST['email']) > 0
				&& isset($_POST['hometown']) && strlen($_POST['hometown']) > 0;
		if ($_FILES['design']['error'] !== UPLOAD_ERR_OK) {
			Vtlog::log("File upload error: " . $_FILES['design']['error']);
		}
		return $isValid;
	}
	
	private function saveFile($uploadId) {
		$dirname = 'U'.$uploadId;
		$filename = 'F'.$uploadId;
		if ($_FILES['design']['error'] === UPLOAD_ERR_OK) {
			
			@mkdir(VT_UPLOADS . DS . $dirname);
			$tmp = $_FILES['design']['tmp_name'];
			$path = VT_UPLOADS . DS . $dirname . DS . $filename;
			
			$type = $_FILES['design']['type'];
			switch ($type) {
				case 'image/jpeg':
				case 'image/jpg':
					// handle jpg
					move_uploaded_file($tmp, $path . '.jpg');

					break;
				case 'application/pdf':
					// handle pdf
					move_uploaded_file($tmp, $path . '.pdf');
					$im = new Imagick($path . '.pdf');
					$im->flattenImages();
					$im->setImageFormat('jpg');
					$im->writeImage($path . '.jpg');

					break;
				case 'image/vnd.adobe.photoshop':
					// handle psd
					move_uploaded_file($tmp, $path . '.psd');
					$im = new Imagick($path . '.psd');
					$im->flattenImages();
					$im->setImageFormat('jpg');
					$im->writeImage($path . '.jpg');

					break;
				case 'image/tiff':
					// handle tiff
					move_uploaded_file($tmp, $path . '.tiff');
					$im = new Imagick($path . '.tiff');
					$im->setImageFormat('jpg');
					$im->writeImage($path . '.jpg');

					break;
				case 'application/postscript':
					// handle eps and ai
					move_uploaded_file($tmp, $path . '.eps');
					$im = new Imagick($path . '.eps');
					$im->setImageFormat('jpg');
					$im->writeImage($path . '.jpg');

					break;
				default:
					Vtlog::log("Could not handle file of type " . $type);
					return false;
					break;
			}
			return true;
		}
		return false;
	}
	
	private function storeData($id) {
		$data = array();
		$data['name'] = $_POST['name'];
		$data['url'] = $_POST['url'];
		$data['email'] = $_POST['email'];
		$data['hometown'] = $_POST['hometown'];
		$data['design'] = 'U'.$id;
		$data['adddate'] = $this->time;
		
		$db = VtDb::getInstance();
		return $db->addDesignData($data);
	}
}

