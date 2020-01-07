<?php
require_once 'includes/config.php';

// Connect to mysql server
$link = mysqli_connect(
    $config['db_host'],
    $config['db_user'],
    $config['db_pass'],
    $config['db_name']
);

if (mysqli_connect_errno()) {
    exit(mysqli_connect_error());
}

if(isset($_GET['id'])){
    $id=cleanLink($_GET['id']);
    $Query="SELECT TITLE,FILEPATH,DESCRIPTION,HEIGHT,WIDTH FROM images where ID = $id;";
    $result = mysqli_query($link,$Query);
    if ($result === false) {
        printf ("Mysql error:", $result->error);
    }
    //if databse get connected get first the template and then replace the placeholder with the data from the database

    else {
        $file = 'templates/imageTpl.html';
        $imgTpl = file_get_contents($file);

        if ( $row = $result->fetch_assoc() ){

             $setTitle = str_replace('[+title+]',cleanLink($row['TITLE']),$imgTpl);
             $setDesc = str_replace('[+description+]',cleanLink($row['DESCRIPTION']),$setTitle);
             $setHeight = str_replace('[+height+]',cleanLink($row['HEIGHT']),$setDesc);
             $setWidth = str_replace('[+width+]',cleanLink($row['WIDTH']),$setHeight);
             $setImg = str_replace('[+image+]',$config['folder'].cleanLink($row['FILEPATH']),$setWidth);

             $content .= $setImg;
        }
        $result->free();
    }
}else{
    include_once 'gallery.php';
};
$link->close();

function cleanLink($link) {
    $link=stripslashes($link);
    $link=htmlentities($link);
    $link=strip_tags($link);
    return $link;
}

?>



