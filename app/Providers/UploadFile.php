<?php

namespace App\Providers;


class UploadFile extends ServiceProvider
{
    protected $filename;
    protected $max_filesize = 2097152;
    protected $extension;
    protected $path;

    /**
     * get the file name
     *
     * @return mixed
     */
    public function getName()
    {
        return $this->filename;
    }

    /**
     * get the path where file was uploaded to
     *
     * @return mixed]
     */
    public function path()
    {
        return $this->path;
    }

    /**
     * set file extension
     *
     * @param $file
     * @return mixed
     */
    public function fileExtension($file)
    {
        return $this->extension = pathinfo($file, PATHINFO_EXTENSION);
    }

    /**
     * validate file size
     *
     * @param $file
     * @return bool
     */
    public static function fileSize($file)
    {
        $fileObj = new static;
        return $file > $fileObj->max_filesize ? true : false;
    }

    /**
     * validate file upload
     *
     * @param $file
     * @return bool
     */
    public static function isImage($file)
    {
        $fileObj = new static;
        $ext = $fileObj->fileExtension($file);
        $validExt = ['jpg', 'jpeg', 'png', 'bpm', 'gif'];

        if(!in_array(strtolower($ext), $validExt))
            return false;

        return true;
    }

    /**
     * move the file to intended location
     *
     * @param $temp_path
     * @param $folder
     * @param $file
     * @param $new_filename
     * @return UploadFile
     */
    public static function move($temp_path, $folder, $file, $new_filename)
    {
        $fileObj = new static;
        $ds = DIRECTORY_SEPARATOR;

        $fileObj->setName($file, $new_filename);
        $file_name = $fileObj->getName();

        if(!is_dir($folder))
            mkdir($folder, 0777, true);

        $fileObj->path = "{$folder}{$ds}{$file_name}";
        $absolute_path = BASE_PATH . "{$ds}public{$ds}$fileObj->path";

        if(move_uploaded_file($temp_path, $absolute_path))
            return $fileObj;

        return null;
    }

    /**
     * set the name of the file
     *
     * @param $file
     * @param $name
     */
    protected function setName($file, $name)
    {
        if($name === '')
            $name = pathinfo($file, PATHINFO_FILENAME);

        $name = strtolower(str_replace(['-', ''], '-', $name));
        $hash = md5(microtime());
        $ext = $this->fileExtension($file);
        $this->filename = "{$name}-{$hash}.{$ext}";
    }
}