<?php namespace Poll\Models;

class Image {

    protected $image;

    function __construct($image)
    {
        $this->image = $image;
    }

    public function validate()
    {
        $validImage = true;

        $imageSize = getimagesize($this->image["tmp_name"]);

        if($imageSize !== false 
            || endsWith($this->image["name"],".mp4")
            || endsWith($this->image["name"],".ogg")
            || endsWith($this->image["name"],".webm")
            ) {
            $validImage = true;
        } else {
            $validImage = false;
        }

        //if image is larger than 1MB
        if ($this->image["size"] > 1 * 1000 * 1000) {
            $validImage = false;
        }

        return $validImage;
    }

    public function save()
    {
        $directory = "uploads/";
        $uniqueName = uniqid() . "-". basename($this->image["name"]);
        $targetFile = $directory . $uniqueName;

        if (move_uploaded_file($this->image["tmp_name"], $targetFile)) {
            return $uniqueName;
        } else {
            return false;
        }
    }

}