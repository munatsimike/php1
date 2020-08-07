<?php
spl_autoload_register('autoload');

function autoload($className)
{
//list comma separated directory name
$directory = array('View/', 'Model/', 'Controller/','Config/','Logic/','classes/');

//list of comma separated file format
$fileFormat = array('%s.php', '%s.class.php');

foreach ($directory as $current_dir)
{
    foreach ($fileFormat as $current_format)
    {
        $path1 = '../'.$current_dir.sprintf($current_format, $className);
        $path2 = 'include/'.$current_dir.sprintf($current_format, $className);
        if (file_exists($path1))
        {
            require_once $path1;
            return ;
        }elseif(file_exists($path2)){
          require_once $path2;
        }
    }
}
}

 ?>
