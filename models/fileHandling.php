<?php

/**
 * Class fileHandling
 */
class fileHandling{

    /**
     * default path where we want to store the files
     * @var string
     */
    private $target_dir;

    /**
     * fileHandling constructor.
     */
    function __construct()
    {
        $this->target_dir = "../assets/uploads/";
    }

    /**
     *
     */
    public function storeFiles()
    {

    }

    /**
     * delete a file
     * @param $name
     */
    public function deleteFile($name){

        $path = realpath('./') . '/assets/uploads/' . $name;
        $tpath = realpath('./') . '/assets/uploads/t_' . $name;    
        unlink($path);
        unlink($tpath);

    }


    /**
     * save any file
     * @param $file
     * @return string
     */
    public function saveFile($file){

        $ext = explode(".",$file["name"])[1];
        sleep(1);
        $filename = time() . "." . $ext; 
        $thumName = "t_" . $filename; 
        $path =  $path = realpath('./') . '/assets/uploads/' . $filename;
        $tpath = realpath('./') . '/assets/uploads/t_' . $filename;
        move_uploaded_file($file["tmp_name"], $path);
        $this->createThumbs($path,$tpath,60);
        return $filename;

    }

    /**
     * create the thumb of the picture to reduce the size to optimized the site loading
     * @param $pathToImages
     * @param $pathToThumbs
     * @param $thumbWidth
     */
    function createThumbs($pathToImages, $pathToThumbs, $thumbWidth )
{
    
    $info = pathinfo($pathToImages);

    if ( strtolower($info['extension']) == 'jpg' )
    {
    

      // load image and get image size
      $img = imagecreatefromjpeg( "{$pathToImages}" );
      $width = imagesx( $img );
      $height = imagesy( $img );

      // calculate thumbnail size
      $new_width = $thumbWidth;
      $new_height = floor( $height * ( $thumbWidth / $width ) );

      // create a new temporary image
      $tmp_img = imagecreatetruecolor( $new_width, $new_height );

      // copy and resize old image into new image
      imagecopyresized( $tmp_img, $img, 0, 0, 0, 0, $new_width, $new_height, $width, $height );

      // save thumbnail into a file
      imagejpeg( $tmp_img, "{$pathToThumbs}" );
    }

}

    /**
     * when uploading multiple files converting into desire structure
     * @param $photos
     * @return array
     */
    public function convertFileArray($photos){

    $count = count($photos["name"]);

    $temp = [];

    for($i =0;$i<$count;$i++){
        $p = [];
        $p["name"] = $photos["name"][$i];
        $p["tmp_name"] = $photos["tmp_name"][$i];
        $temp[] = $p;
    }

    return $temp;

}

    
    



}



?>