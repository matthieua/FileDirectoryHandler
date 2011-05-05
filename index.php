<?php
require_once 'globals.php';
require_once 'functions.php';
require_once LIB_DIR . DIRECTORY_SEPARATOR . 'utils/Autoloader.php';

// Init the autoloader
$autoloader = new \utils\Autoloader();
$autoloader->registerAutoload(LIB_DIR);

// Init Notification
$notification = new \utils\Notification();

// Create the app folder if needed
$appDir = new \filesystem\Dir(APP_ROOT_DIR, PATH_ROOT);
if (!$appDir->exists()) $appDir->create();


// If the form submitted
if (isset($_POST['process'])) {
    // Create a directory
    if (!empty($_POST['dirName'])) {
        // Create Directory Instance
        $dir = new \filesystem\Dir($_POST['dirName'], getAppFullPath());
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
    if (!empty($_POST['fileName'])) {
        // Create File Instance
        $file = new \filesystem\File($_POST['fileName'], getAppFullPath(), $_POST['fileNameContent']);
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
}

// If url parameters
if (!empty($_GET)) {
    if (isset($_GET['dirname'])) {
        $dir = new \filesystem\Dir(urldecode($_GET['dirname']), getAppFullPath());
        if ($dir->exists() && $dir->delete()) {
            $notification->setMessage('The folder has been deleted successfully', "good");
        } else {
            $notification->setMessage('An error has occurred, please try again', "bad");
        }
        // destroy Dir object whatever happened
        unset($dir);
    }

    if (isset($_GET['filename'])) {
        $file = new \filesystem\File(urldecode($_GET['filename']), getAppFullPath());
        if ($file->exists() && $file->delete()) {
            $notification->setMessage('The file has been deleted successfully', "good");
        } else {
            $notification->setMessage('An error has occurred, please try again', "bad");
        }
        // destroy File object whatever happened
        unset($file);
    }
}

// Get the directory Listing
$dirRootListing = $appDir->getDirListing();

?>
<!DOCTYPE html>
<html>
<head>
    <link rel="stylesheet" href="css/style.css">
    <title>App Directory Handler</title>
</head>
<body>
<header>
    <?php if (isset($notification)) echo $notification; ?>
</header>
<div id="main">
    <h1>App Directory Handler</h1>

    <h2>Directory Content (<?php echo APP_ROOT_DIR; ?>)</h2>

    <div id="dir-liting">
<?php
        if (empty($dirRootListing) || !$dirRootListing) : ?>
    <em>empty directory</em>
    <?php else: ?>
    <table>
        <th>Name</th>
        <th>Type</th>
        <th colspan="3">Actions</th>
        <?php foreach ($dirRootListing as $item) :
        $fileDirectory = new \filesystem\FileDirectoryHandler($item, getAppFullPath());
        ?>
        <tr>
            <td>
                <?php echo $fileDirectory->getName(); ?>
            </td>
            <?php if ($fileDirectory->isFile()) : ?>
            <td>
                file
            </td>
            <td>
                <a href="<?php echo 'edit.php?filename=' . urlencode($fileDirectory->getName()); ?>">edit</a>
            </td>
            <td>
                <a href="<?php echo 'view.php?filename=' . urlencode($fileDirectory->getName()); ?>">view</a>
            </td>
            <td>
                <a href="<?php echo 'index.php?filename=' . urlencode($fileDirectory->getName()); ?>">delete</a>
            </td>
            <?php else: ?>
            <td>
                directory
            </td>
            <td>
                <a href="<?php echo 'edit.php?dirname=' . urlencode($fileDirectory->getName()); ?>">edit</a>
            </td>
            <td>
                <a href="<?php echo 'view.php?dirname=' . urlencode($fileDirectory->getName()); ?>">view</a>
            </td>
            <td>
                <a href="<?php echo 'index.php?dirname=' . urlencode($fileDirectory->getName()); ?>">delete</a>
            </td>
            <?php endif; ?>
        </tr>
        <?php endforeach; ?>
    </table>
    <?php endif; ?>
    </div>


    <form method="post" action="index.php" id="file-directory-form">
        <div class="clearfix">
            <section>
                <h3><label>Create a new directory <span>show</span></h3>
                <fieldset>
                    <input type="text" name="dirName" id="dir-name" placeholder="Directory name"
                           value="<?php if (isset($dir)) echo $dir->getName();?>"/>
                </fieldset>
            </section>

            <section>
                <h3><label>Create a new file <span>show</span</label></h3>
                <fieldset>
                    <input type="text" name="fileName" id="file-name" placeholder="File name"
                           value="<?php if (isset($file)) echo $file->getName();?>"/>
                    <br/><br/>
                    <textarea name="fileNameContent" cols="30" rows="10"
                              placeholder="File Content"><?php if (isset($file)) echo $file->getContent();?></textarea>
                </fieldset>
            </section>

            <section>
                <h3><label>Upload a new file <span>show</span></label></h3>
                <fieldset>

                    <input type="file" name="fileUpload" id="upload-file" />
                </fieldset>
            </section>
        </div>

        <div class="clearfix">
            <section>
                <h3><label>Create a new JSON file <span>show</span></h3>
                <fieldset>
                    <input type="text" name="jsonFileName" id="json-file-name" placeholder="JSON File name"
                           value=""/>
                    <br/><br/>
                    <textarea name="jsonFileContent" cols="30" rows="10"
                              placeholder="JSON File Content"></textarea>
                </fieldset>
            </section>

            <section>
                <h3><label>Create a new XML file <span>show</span</label></h3>
                <fieldset>
                    <input type="text" name="xmlFileName" id="xml-file-name" placeholder="XML File name"
                           value=""/>
                    <br/><br/>
                    <textarea name="fileNameContent" cols="30" rows="10"
                              placeholder="XML File Content"></textarea>
                </fieldset>
            </section>

            <section>
                <h3><label>Upload a new image <span>show</span></label></h3>
                <fieldset>
                    <input type="file" name="imageUpload" id="upload-image" />
                    <br/><br/>
                    <textarea name="imageContent" cols="30" rows="10"
                              placeholder="Image Content"></textarea>
                </fieldset>
            </section>
        </div>

        <input type="submit" name="process" value="Process" id="process"/>
    </form>


</div>
<footer></footer>
<script src="//ajax.googleapis.com/ajax/libs/jquery/1.4.2/jquery.js"></script>
<script src="js/script.js"></script>

</body>
</html>
