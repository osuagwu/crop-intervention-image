<?php
/**
     * Crop the given Intervention Image
     *
     * @param \Intervention\Image\Image $image
     * @param int $width
     * @param int $height
     * @param int $x
     * @param int $y
     * @param string $bg_color Any color format acceptable to @see \Intervention\Image\Image::fill();
     * @return \Intervention\Image\Image
     */
    function cropImage(Image $image,$width,$height,$x=null,$y=null,$bg_color='#cccccc'){

        // What is the size of the image to crop
        $image_width=$image->width();
        $image_height=$image->height();

        // Do we have a special case based on the following conditions
        if ($image_width<$width+abs($x) or $x<0   // Is the crop width outside the image
            or $image_height<$height+abs($y) or $y<0) {// Is the crop height outside the image

            // Determine the size of background image
            $canvas_width=abs($x)+$width;
            $canvas_height=abs($y)+ $height;

            // Create a background image with  background color ;
            $background = \Intervention\Image\Image::canvas($canvas_width, $canvas_height)->fill($bg_color);
            

            // Determine the insert position of the image to crop inside the background image
            $ins_x=abs(($x-abs($x))/2);
            $ins_y=abs(($y-abs($y))/2);

            // Adjust x and y with respect to the background image
            $x=abs(($x+abs($x))/2);
            $y=abs(($y+abs($y))/2);

            // Insert the image to crop into the background.
            //TODO: I can't really think now, but I think we could just return this as the crop?
            $background->insert($image, 'top-left',$ins_x,$ins_y);
            
            //TODO: Any need to unset $image here to reclaim memory? 
            //unset($image);

            $image=$background;

            //TODO: Any need for this to reclaim memory? 
            unset($background);
        }


        return $image->crop($width,$height,$x,$y);
    }
