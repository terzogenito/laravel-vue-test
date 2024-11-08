<?php

namespace App\Helpers;

use Request;
use File;

class UploadHelper
{

  
  public static function upload($f, $file, $username, $target_location)
  {
    if (Request::hasFile($f)) {
      $filename = $username . '.' . $file->getClientOriginalExtension();
      $extension = $file->getClientOriginalExtension();
      $file->move($target_location, $filename);
      return $filename;
    } else {
      return null;
    }
  }


  
  public static function update($f, $file, $username, $target_location, $old_location)
  {
    
    $target_location = $target_location . '/';
    if (File::exists($target_location . $old_location)) {
      File::delete($target_location . $old_location);
    }

    $filename = $username . '.' . $file->getClientOriginalExtension();
    $file->move($target_location, $filename);
    return $filename;
  }


  
  public static function deleteFile($location)
  {
    if (File::exists($location)) {
      File::delete($location);
    }
  }
}
