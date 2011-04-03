<?php
  require_once 'globals.php';
require_once 'lib/Notification.php';
require_once 'lib/Dir.php';
require_once 'functions.php';
?>

<?php
// init Notification
$notification = new Notification();

// Create a directory
if (isset($_POST['submit'])) {
  // Create Directory Instance
  $dir = new Dir($_POST['dirname']);
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
      $notification->setMessage("Ann error has occured, please try again", "bad");
    }
  }
}

if (isset($_GET['dirname'])) {
  $dir = new Dir(urldecode($_GET['dirname']));
  if ($dir->exists() && $dir->delete()) {
    $notification->setMessage('The folder has been deleted succesfully', "good");
  } else {
    $notification->setMessage('An error has occured, please try again', "bad");
  }
  // destroy Dir object whatever happened
  unset($dir);
}

// Get the directory Listing
$dirRootListing = Dir::getDirListing(Dir::getDirRootFullPath());
?>

<!DOCTYPE html>
<html>
<head>
  <style>
    body {
      width: 960px;
      margin: 20px auto;
    }

    strong {
      font-size: 12px;
    }

    .good, .bad {
      color: green;
      border-bottom: 1px solid gray;
    }

    .bad {
      color: red;
    }
  </style>
</head>
<body>
<header>
<?php
if (isset($notification)) echo $notification->getMessage();
?>
</header>
<div id="main">
  <h1>Create a new directory</h1>

  <form method="post" action="index.php">
    <input type="text" name="dirname" id="dirname" placeholder="Directory name"
           value="<?php if (isset($dir)) echo $dir->getDirName();?>"/>
    <input type="submit" name="submit" value="Create directory"/>
  </form>


  <h2>Directory Content (<?php echo APP_ROOT_DIR; ?>)</h2>

  <div id="dir-liting">
  <?php if (empty($dirRootListing)) : ?>
    <em>empty directory</em>
  <?php else: ?>
    <ul>
    <?php foreach ($dirRootListing as $dir) : ?>
      <li>
      <?php echo $dir; ?>
        <a href="<?php echo 'index.php?dirname=' . urlencode($dir); ?>">delete</a>
      </li>
    <?php endforeach; ?>
    </ul>
  <?php endif; ?>
  </div>
</div>
<footer></footer>


</body>
</html>
