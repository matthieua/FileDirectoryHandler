<?php
  require_once 'globals.php';
require_once 'lib/Notification.php';
require_once 'lib/Dir.php';
?>

<?php
// Check if the form has been submitted
if (isset($_POST['submit'])) {

  // Create Directory Instance
  $dir = new Dir($_POST['dirname']);

  // Check the name is valid
  if (!$dir->isValid()) {
    $notification = new Notification("The directory name is invalid", 'bad');
  } else {
    // Create Directory name
    if ($dir->create()) {
      $notification = new Notification("The directory has been created successfully");
      unset($dir);
    } else {
      $notification = new Notification("Ann error has occured, please try again");
    }
  }
}
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
      border-bottom: 1px solid grey;
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
  <h1>Create a new file</h1>

  <form method="post" action="index.php">
    <input type="text" name="dirname" id="dirname" placeholder="Directory name"
           value="<?php if (isset($dir)) echo $dir->getDirName();?>"/>
    <input type="submit" name="submit" value="Create directory"/>
  </form>
</div>
<footer></footer>


</body>
</html>
