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

$Query="SELECT ID,TITLE,FILEPATH,DESCRIPTION FROM images;";

$content = '';

$result = mysqli_query($link,$Query);

if ($result === false) {
    printf ("Mysql error:", $result->error);
}
//if databse get connected get first the template and then replace the placeholder with the data from the database
else {
    $file = 'templates/imgGallery.html';
    $galleryTpl = file_get_contents($file);

    while ( $row = $result->fetch_assoc() ) {
        
         $setImgID = str_replace('[+imageID+]',cleanLink($row['ID']),$galleryTpl);
         $setTitle = str_replace('[+title+]',cleanLink($row['TITLE']),$setImgID);
         $setDesc = str_replace('[+description+]',cleanLink($row['DESCRIPTION']),$setTitle);
         $setImg = str_replace('[+image+]',$config['thumbs'].cleanLink($row['FILEPATH']),$setDesc);
         $content .= $setImg;
    }
    $result->free();
}

$link->close();

function cleanLink($link) {
    $link=stripslashes($link);
    $link=htmlentities($link);
    $link=strip_tags($link);
    return $link;
}

?>
