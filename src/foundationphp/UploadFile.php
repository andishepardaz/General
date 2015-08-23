<?php
namespace foundationphp;
class UploadFile {
    protected $destination;
    protected $messages = array();
    protected $maxsize = 51200; //50 KiloByte
    protected $permittedTypes = array('image/jpeg','image/gif','image/png');
    protected $newName;
    protected $typeCheckingOn = true;
    protected $notrusted = array('bin', 'cgi', 'exe', 'dmg', 'js', 'pl', 'php', 'py', 'sh');
    protected $suffix = '.upload';
    protected $renameDuplicates;
    public function __construct($uploadfolder){
        if((!is_dir($uploadfolder))||(!is_writable($uploadfolder))){
            throw new \Exception("$uploadfolder must be valid, writable.");
        }
        if($uploadfolder[strlen($uploadfolder)-1] != '/'){
            $uploadfolder .= '/';
        }
        $this->destination = $uploadfolder;
    }
    public function upload($renameDuplicates = true){
        $this->renameDuplicates = $renameDuplicates;
        $uploaded = current($_FILES);
        if($this->checkfile($uploaded)){
            $this->movefile($uploaded);
        }
    }
    public function getMessages(){
        return $this->messages;
    }
    public function setMaxsize($bytes)
    {
        $serverMax = self::convertToByte(ini_get('upload_max_filesize'));
        if($bytes > $serverMax){
            throw new \Exception('Maximum size cannot exceed server limit for individual files: ' .
            self::convertFromBytes($serverMax));
        }
        if (is_numeric($bytes) && $bytes > 0) {
            $this->maxsize = $bytes;
        }
    }
    public static function convertToByte($val){
        $val = trim($val);
        $last = strtolower($val[strlen($val)-1]);
        if(in_array($last,array('g','m','k'))){
            switch($last){
                case 'g':
                    $val *= 1024;
                case 'm':
                    $val *= 1024;
                case 'k':
                    $val *= 1024;
            }
        }
        return $val;
    }
    public static function convertFromBytes($bytes){
        $bytes /= 1024;
        if($bytes > 1024){
            return number_format($bytes/1024, 1) . ' MB';
        }else{
            return number_format($bytes, 1) . ' KB';
        }
    }
    protected function checksize($file){
        if($file['size'] == 0){
            $this->messages[] = $file['name'] . ' is empty.';
            return false;
        }
        elseif($file['size'] > $this->maxsize){
            $this->messages[] = $file['name'] . ' exceeds the maximum size for the file (Max: ' . self::convertFromBytes($this->maxsize) . ')';
            return false;
        }
        else{
            return true;
        }
    }
    protected function checktype($file){
        if(in_array($file['type'], $this->permittedTypes)){
            return true;
        }else{
            $this->messages[] = $file['name'] . ' is not a permitted type of file.';
            return false;
        }
    }
    protected function checkfile($file){
        if($file['error'] !=0){
            $this->getErrorMessage($file);
            return false;
        }
        if(!$this->checksize($file)){
            return false;
        }
        if ($this->typeCheckingOn) {
            if (!$this->checktype($file)) {
                return false;
            }
        }
        $this->checkname($file);
        return true;
    }
    protected function checkname($file){
        $this->newName = null; //clearing
        $nospaces = str_replace(' ', '_', $file['name']);
        if($nospaces != $file['name']){
            $this->newName = $nospaces;
        }
        $nameparts = pathinfo($nospaces);
        $extension = isset($nameparts['extension']) ? $nameparts['extension'] : '';
        if(!$this->typeCheckingOn && !empty($this->suffix)){
            if(in_array($extension, $this->notrusted) || empty($extension)){
                $this->newName = $nospaces . $this->suffix;
            }
        }
        if($this->renameDuplicates){
            $name = isset($this->newName) ? $this->newName : $file['name'];
            $existing = scandir($this->destination);
            if(in_array($name, $existing)){
                $i = 1;
                do{
                    $this->newName = $nameparts['filename'] . '_' . $i++;
                    if(!empty($existing)){
                        $key = array_search($name, $existing);
                        $r = $existing[$key];
                        $m = explode('.',$r);
                        $end = end($m);
                        $this->newName .= ".$end";
                    }
                    if(in_array($existing, $this->notrusted)){
                        $this->newName .= $this->suffix;
                    }
                } while(in_array($this->newName, $existing));
            }
        }
    }
    protected function getErrorMessage($file){
        switch($file['error']){
            case 1:
            case 2:
                $this->messages[] = $file['name'] . ' is too big!: (Max: ' . self::convertFromBytes($this->maxsize) . ')';
                break;
            case 3:
                $this->messages[] = $file['name'] . ' is partially uploaded!';
                break;
            case 4:
                $this->messages[] = 'No file selected';
                break;
            default:
                $this->messages[] = 'Sorry! There was a problem uploading your file';
                break;
        }
    }
    public function allowAllTypes($suffix = null){
        $this->typeCheckingOn = false;
        if(!is_null($suffix)){
            if(strpos($suffix, '.') === 0 || $suffix ==''){
                $this->suffix = $suffix;
            }
            else{
                $this->suffix =".$suffix";
            }
        }
    }
    protected function movefile($file){
        $filename = isset($this->newName) ? $this->newName : $file['name'];
        $success = move_uploaded_file($file['tmp_name'], $this->destination . $filename);
        if ($success) {
            $result = $file['name'] . ' was uploaded successfully';
            if (!is_null($this->newName)) {
                $result .= ', and was renamed ' . $this->newName;
            }
            $result .= '.';
            $this->messages[] = $result;
        } else {
            $this->messages[] = 'Could not upload' . $file['name'];
        }
    }
}