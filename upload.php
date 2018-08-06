<?php

    define('IMG_SIZE', 1000);
    define('IMG_QUALITY', 100);

    if (array_key_exists('image', $_FILES))
    {
        $extension = pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION);
        switch ($extension)
        {
            case 'jpg':
            case 'jpeg':
                $image = imagecreatefromjpeg($_FILES['image']['tmp_name']);
                break;
            case 'png':
                $image = imagecreatefrompng($_FILES['image']['tmp_name']);
                break;
            case 'gif':
                $image = imagecreatefromgif($_FILES['image']['tmp_name']);
                break;
            case 'bmp':
                $image = imagecreatefrombmp($_FILES['image']['tmp_name']);
                break;
            default:
                $image = false;
        }
        if ($image)
        {
            $width = imagesx($image);
            $height = imagesy($image);
            if ($width < $height)
            {
                $size = $width;
                $x = 0;
                $y = ($height - $width) / 2;
            }
            else if ($width > $height)
            {
                $size = $height;
                $y = 0;
                $x = ($width - $height) / 2;
            }
            else
            {
                $size = $width;
                $x = $y = 0;
            }
            
            $img = imagecreatetruecolor(IMG_SIZE, IMG_SIZE);
            imagecopyresampled($img, $image, 0, 0, $x, $y, IMG_SIZE, IMG_SIZE, $size, $size);
            imagejpeg($img, 'pictures/' . $_POST['id'] . '.jpg', IMG_QUALITY);
        }
    }

?>