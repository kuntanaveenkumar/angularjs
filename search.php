<?php
// site search in .php fo;es
//error_reporting(1);
//phpinfo();
$path = getcwd();
$findThisString = 'Outpatient Clinics';
$findThisString=urldecode(trim($_GET['keyword']));
$dir = dir(getcwd());

// Get next file/dir name in directory
while (false !== ($file = $dir->read()))
{   

    if ($file != '.' && $file != '..')
    {
		
        // Is this entry a file or directory?
        if (is_file($path . '/' . $file))
        {

			$pos = strpos($file, "_body.php");

			//echo $file;
			//echo getcwd();
            // Its a file, yay! Lets get the file's contents
            $data = file_get_contents($path . '/' . $file);
			if ($pos !== false) 
			{
				
				$pattern = preg_quote($findThisString, '/');
				$pattern = "/^.*$pattern.*\$/mi";
				if(preg_match_all($pattern, $data, $matches))
				{
					$file=str_replace("_body","",$file);
					$pos22 = strpos($file, "-ar.php");
					if ($pos22 === false) 
					{
						echo str_replace("-","&nbsp;",str_replace(".php","",$file));	
						$content=substr(strip_tags($data),0,500);
						$content=str_ireplace($findThisString,"<b style='color:#f00;background-color:#ff0;'>".ucwords($findThisString)."</b>",$content);

						//$findThisString=strtolower($findThisString);
					?>
					  <li><a href="<?php echo $file."?keyword=".$findThisString;?>"><?php echo $content."...";?></a></li>
					<?php 
					}
				}		

				/*
				if (stripos($data, $findThisString) !== false)
				{
				$file=str_replace("_body","",$file);	
				$pos22 = strpos($file, "-ar.php");
				if ($pos22 === false) {
				
				 <li><a href="<?php echo $file;?>"><?php echo substr(strip_tags($data),0,500)."...";</a></li>
			  
				
				}
				}*/
			}
        }
    }
}

?>