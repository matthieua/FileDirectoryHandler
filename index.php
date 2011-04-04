<?php
  require_once 'globals.php';
  require_once 'functions.php';
  require_once 'lib/FileDirectoryHandler.php';
  require_once 'lib/Notification.php';
?>

<?php
// init Notification
$notification = new Notification();

// Create the app folder if needed
$appDir = new Dir(APP_ROOT_DIR, PATH_ROOT);
if (!$appDir->exists()) $appDir->create();

// Create a directory
if (isset($_POST['addDirectory']) && !empty($_POST['dirName'])) {
    // Create Directory Instance
    $dir = new Dir($_POST['dirName'], getAppFullPath());
    // Check the name is valid
    if ($dir->exists()) {
        $notification->setMessage("The directory already exists", "bad");
    } else {
        // Create Directory name
        if ($dir->create()) {
            $notification->setMessage("The directory has been created successfully", "good");
            // destroy Dir object
            unset($dir);
        } else {
            $notification->setMessage("Ann error has occurred, please try again", "bad");
        }
    }
}

// Create a file
if (isset($_POST['addFile']) && !empty($_POST['fileName'])) {
    // Create File Instance
    $file = new File($_POST['fileName'], getAppFullPath(), $_POST['fileNameContent']);
    // Check the name is valid
    if ($file->exists()) {
        $notification->setMessage("The file already exists", "bad");
    } else {
        // Create Directory name
        if ($file->create()) {
            $notification->setMessage("The file has been created successfully", "good");
            // destroy Dir object
            unset($file);
        } else {
            $notification->setMessage("An error has occurred, please try again", "bad");
        }
    }
}

if (isset($_GET['dirname'])) {
    $dir = new Dir(urldecode($_GET['dirname']), getAppFullPath());
    if ($dir->exists() && $dir->delete()) {
        $notification->setMessage('The folder has been deleted successfully', "good");
    } else {
        $notification->setMessage('An error has occurred, please try again', "bad");
    }
    // destroy Dir object whatever happened
    unset($dir);
}

if (isset($_GET['filename'])) {
    $file = new File(urldecode($_GET['filename']), getAppFullPath());
    if ($file->exists() && $file->delete()) {
        $notification->setMessage('The file has been deleted successfully', "good");
    } else {
        $notification->setMessage('An error has occurred, please try again', "bad");
    }
    // destroy File object whatever happened
    unset($file);
}

// Get the directory Listing
$dirRootListing = $appDir->getDirListing();


?>

<!DOCTYPE html>
<html>
<head>
    <style>
        body {
            width: 960px;
            margin: 0 auto;
            color: #333;
            font-family: 'Helvetica Neue', arial, helvetica, sans-serif;
        }

        strong {
            font-size: 13px;
            padding: 10px 4px;

        }

        div.good, div.bad {
            color: green;
            background-color: #FFFBE7;
            padding: 4px 0;
            border-bottom: 1px solid #CCCCCC;
        }

        div.bad {
            color: red;
        }
    </style>
    <title>App Directory Handler</title>
</head>
<body>
<header>
<?php if (isset($notification)) echo $notification->getMessage(); ?>
</header>
<div id="main">
    <h1>App Directory Handler</h1>

    <h2><label for="dir-name">Create a new directory</label></h2>

    <form method="post" action="index.php">
        <input type="text" name="dirName" id="dir-name" placeholder="Directory name"
               value="<?php if (isset($dir)) echo $dir->getName();?>"/>
        <input type="submit" name="addDirectory" value="Add directory"/>
    </form>

    <h2><label for="file-name">Create a new file</label></h2>

    <form method="post" action="index.php">
        <input type="text" name="fileName" id="file-name" placeholder="File name"
               value="<?php if (isset($file)) echo $file->getName();?>"/>
        <input type="text" name="fileNameContent" placeholder="Content"
               value="<?php if (isset($file)) echo $file->getContent();?>"/>
        <input type="submit" name="addFile" value="Add file"/>
    </form>

    <h3>Directory Content (<?php echo APP_ROOT_DIR; ?>)</h3>

    <div id="dir-liting">
        <?php
        if (empty($dirRootListing) || !$dirRootListing) : ?>
        <em>empty directory</em>
        <?php else: ?>
        <ul>
            <?php foreach ($dirRootListing as $item) :
                $fileDirectory = new FileDirectoryHandler($item, getAppFullPath());
            ?>
            <li>
                <?php echo $fileDirectory->getName(); ?>
                <?php if ($fileDirectory->isFile()) : ?>
                <a href="<?php echo 'index.php?filename=' . urlencode($fileDirectory->getName()); ?>">delete</a>
                <?php else: ?>
                <a href="<?php echo 'index.php?dirname=' . urlencode($fileDirectory->getName()); ?>">delete</a>
                <?php endif; ?>
            </li>
            <?php endforeach; ?>
        </ul>
        <?php endif; ?>
    </div>
</div>
<footer></footer>


</body>
</html>
