<?php

/**
 * generateur waveform png à partir d'un mp3
 *
 * utilisation :
 *
 * $a = new AudioWaveForm();
 * $a->setSourceFile('test.mp3');
 * $a->setSourceFormat('MP3');
 * $a->setDestinationFile('test.png');
 * $a->setDestinationFormat('PNG');
 * $a->setDestinationWidth(500);
 * $a->setDestinationHeight(100);
 * $a->setDestinationColor('#00FF00');
 * $a->setDestinationBgcolor('#000000');
 * $a->run();
 *
 */

ini_set("max_execution_time", "30000");

class AudioWaveForm
{
    protected $_source_file         = null;
    protected $_source_format       = 'MP3';
    protected $_destination_file    = null;
    protected $_destination_format  = 'PNG';
    protected $_destination_width   = '500';
    protected $_destination_height  = '100';
    protected $_destination_color   = '#000000';
    protected $_destination_bgcolor = '#FFFFFF';

    function setSourceFile($val)
    {
        $this->_source_file = $val;
    }

    function setSourceFormat($val)
    {
        $this->_source_format = $val;
    }

    function setDestinationFile($val)
    {
        $this->_destination_file = $val;
    }

    function setDestinationFormat($val)
    {
        $this->_destination_format = $val;
    }

    function setDestinationWidth($val)
    {
        $this->_destination_width = (int) $val;
    }

    function setDestinationHeight($val)
    {
        $this->_destination_height = (int) $val;
    }

    function setDestinationColor($val)
    {
        $this->_destination_color = $val;
    }

    function setDestinationBgcolor($val)
    {
        $this->_destination_bgcolor = $val;
    }

    /**
     * GENERAL FUNCTIONS
     */
    function findValues($byte1, $byte2)
    {
        $byte1 = hexdec(bin2hex($byte1));
        $byte2 = hexdec(bin2hex($byte2));
        return ($byte1 + ($byte2*256));
    }

    /**
     * Great function slightly modified as posted by Minux at
     * http://forums.clantemplates.com/showthread.php?t=133805
     */
    function html2rgb($input)
    {
        $input = ($input[0]=="#") ? substr($input, 1, 6) : substr($input, 0, 6);
        return array(
            hexdec(substr($input, 0, 2)),
            hexdec(substr($input, 2, 2)),
            hexdec(substr($input, 4, 2))
        );
    }

    /**
     * process the file
     */
    function run()
    {
        // temporary file name
        $tmpname = '/tmp/' . substr(md5(time()), 0, 10);

        // copy from temp upload directory to current
        copy($this->_source_file, "{$tmpname}_o.mp3");

        /**
         * convert mp3 to wav using lame decoder
         * First, resample the original mp3 using as mono (-m m), 16 bit (-b 16), and 8 KHz (--resample 8)
         * Secondly, convert that resampled mp3 into a wav
         * We don't necessarily need high quality audio to produce a waveform, doing this process reduces the WAV
         * to it's simplest form and makes processing significantly faster
         */
        exec("lame {$tmpname}_o.mp3 -f -m m -b 16 --resample 8 {$tmpname}.mp3 && lame --decode {$tmpname}.mp3 {$tmpname}.wav");

        // delete temporary files
        @unlink("{$tmpname}_o.mp3");
        @unlink("{$tmpname}.mp3");

        $filename = "{$tmpname}.wav";

        /**
         * Below as posted by "zvoneM" on
         * http://forums.devshed.com/php-development-5/reading-16-bit-wav-file-318740.html
         * as findValues() defined above
         * Translated from Croation to English - July 11, 2011
         */
        $handle = fopen ($filename, "r");
        //dohvacanje zaglavlja wav datoteke
        $heading[] = fread ($handle, 4);
        $heading[] = bin2hex(fread ($handle, 4));
        $heading[] = fread ($handle, 4);
        $heading[] = fread ($handle, 4);
        $heading[] = bin2hex(fread ($handle, 4));
        $heading[] = bin2hex(fread ($handle, 2));
        $heading[] = bin2hex(fread ($handle, 2));
        $heading[] = bin2hex(fread ($handle, 4));
        $heading[] = bin2hex(fread ($handle, 4));
        $heading[] = bin2hex(fread ($handle, 2));
        $heading[] = bin2hex(fread ($handle, 2));
        $heading[] = fread ($handle, 4);
        $heading[] = bin2hex(fread ($handle, 4));

        //bitrate wav datoteke
        $peek = hexdec(substr($heading[10], 0, 2));
        $byte = $peek / 8;

        //provjera da li se radi o mono ili stereo wavu
        $channel = hexdec(substr($heading[6], 0, 2));

        if($channel == 2) {
            $omjer = 40;
        } else {
            $omjer = 80;
        }

        while(!feof($handle)) {
            $bytes = array();
            //get number of bytes depending on bitrate
            for ($i = 0; $i < $byte; $i++){
                $bytes[$i] = fgetc($handle);
            }
            switch($byte) {
                //get value for 8-bit wav
                case 1:
                    $data[] = $this->findValues($bytes[0], $bytes[1]);
                    break;
                //get value for 16-bit wav
                case 2:
                    if(ord($bytes[1]) & 128){
                        $temp = 0;
                    } else {
                        $temp = 128;
                    }
                    $temp = chr((ord($bytes[1]) & 127) + $temp);
                    $data[]= floor($this->findValues($bytes[0], $temp) / 256);
                    break;
          }
          //skip bytes for memory optimization
          fread ($handle, $omjer);
        }

        // close and cleanup
        fclose ($handle);
        unlink("{$tmpname}.wav");

        /**
         * Image generation
         */

        // how much detail we want. Larger number means less detail
        // (basically, how many bytes/frames to skip processing)
        // the lower the number means longer processing time
        define("DETAIL", 5);

        // get user vars from form
        $width = $this->_destination_width;
        $height = $this->_destination_height;
        $foreground = $this->_destination_color;
        $background = $this->_destination_bgcolor;

        // create original image width based on amount of detail
        $img = imagecreatetruecolor(sizeof($data) / DETAIL, $height);

        // fill background of image
        list($r, $g, $b) = $this->html2rgb($background);
        imagefilledrectangle($img, 0, 0, sizeof($data) / DETAIL, $height, imagecolorallocate($img, $r, $g, $b));

        // generate background color
        list($r, $g, $b) = $this->html2rgb($foreground);

        // loop through frames/bytes of wav data as genearted above
        for($d = 0; $d < sizeof($data); $d += DETAIL) {
            // relative value based on height of image being generated
            // data values can range between 0 and 255
            $v = (int) ($data[$d] / 255 * $height);
            // draw the line on the image using the $v value and centering it vertically on the canvas
            imageline($img, $d / DETAIL, 0 + ($height - $v), $d / DETAIL, $height - ($height - $v), imagecolorallocate($img, $r, $g, $b));
        }

        // want it resized?
        if ($width) {

            // resample the image to the proportions defined in the form
            $rimg = imagecreatetruecolor($width, $height);
            imagecopyresampled($rimg, $img, 0, 0, 0, 0, $width, $height, sizeof($data) / DETAIL, $height);
            imagepng($rimg, $this->_destination_file);
            imagedestroy($rimg);

        } else {

            // print out at it's raw width (size of $data / detail level)
            imagepng($img, $this->_destination_file);
            imagedestroy($img);

        }
    }
}
