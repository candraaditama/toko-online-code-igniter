<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

include_once dirname(__FILE__).DIRECTORY_SEPARATOR.'external/elfinder/ElFinderConnector.class.php';
include_once dirname(__FILE__).DIRECTORY_SEPARATOR.'external/elfinder/ElFinder.class.php';
include_once dirname(__FILE__).DIRECTORY_SEPARATOR.'external/elfinder/ElFinderVolumeDriver.class.php';
include_once dirname(__FILE__).DIRECTORY_SEPARATOR.'external/elfinder/ElFinderVolumeLocalFileSystem.class.php';

class Elfinder_lib 
{
  public function __construct($opts) 
  {
    $connector = new elFinderConnector(new elFinder($opts));
    $connector->run();
  }
}