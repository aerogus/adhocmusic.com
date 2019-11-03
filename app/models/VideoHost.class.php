<?php declare(strict_types=1);

class VideoHost extends Reference
{
    /**
     * @var object
     */
    protected static $_instance = null;

    /**
     * @var string
     */
    protected static $_pk = 'id_video_host';

    /**
     * @var string
     */
    protected static $_table = 'adhoc_video_host';

    /**
     * @var int
     */
    protected $_id_video_host = 0;
}