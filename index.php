<?php
//from: Stefano Bau

//create empty variable
$content = '';

require_once 'includes/config.php';
require_once 'includes/functions.php';

if(!isset($_GET['page'])){
    $id = 'home';
} else
{
$id = $_GET['page'];	}

//load all templates
	
$tempHead = $config['app_dir'].'/includes/head.html';
$Head = include_once($tempHead);


switch ($id){
    case 'home' :
        include 'views/gallery.php';
        break;
    case 'image' :
        include 'views/images.php';
        break;
    default:
        include 'views/404.php';
}

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
	
// Check form subbmission
//first check if the form is submitted, then check the image file type, then check that title and description are not emty, if evrything is fine save the variables and store them inside database
	
if (isset($_POST['uploadForm'])) {
    if (is_uploaded_file($_FILES['imgFile']['tmp_name']) && ($_FILES['imgFile']['type']=='image/jpeg')) {
        if (empty($_POST['title']) || empty(trim($_POST['description']))) {
            echo "Please enter description AND enter image title";
        } else {
            $filenm = basename($_FILES['imgFile']['name']);
            $filenm = $link->real_escape_string(cleanLink($filenm));
            $title = $link->real_escape_string($_POST['title']);
            $temphname = $_FILES['imgFile']['tmp_name'];
            $description = $link->real_escape_string($_POST['description']);
            $newname = $config['upload_dir'].$filenm;
            resizeImage($temphname,$temphname,600,600);
            list($width,$height) = getimagesize($temphname);	

            if (move_uploaded_file($temphname, $newname)) {
                $sql = "INSERT INTO images (TITLE,FILEPATH,DESCRIPTION,WIDTH,HEIGHT) 
                        VALUES(
                        '$title',
                        '$filenm',
                        '$description',
                        '$width',
                        '$height');";
                if($link->query($sql)===TRUE){
                    resizeImage($newname,$config['thumbs'].$filenm,150,150);
                    echo "Image successfully uploaded";
                }else {
                    unlink($newname);
                    printf("Error: %s\n", $link->error);
                }
            }

        } 
    } else {
        echo "<p>Upload a jpeg file Pls</p>";
    }
}
$link->close();

$tempForm = $config['app_dir'].'/includes/form.html';
$Form = include_once($tempForm);

// Display content values.
echo $content;

$tempFooter = $config['app_dir'].'/includes/footer.html';
$Footer = include_once($tempFooter);


?>