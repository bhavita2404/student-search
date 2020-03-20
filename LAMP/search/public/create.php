<?php

/**
 * Use an HTML form to create a new entry in the
 * users table.
 *
 */

require "../config.php";
require "../common.php";

if (isset($_POST['submit'])) {
  if (!hash_equals($_SESSION['csrf'], $_POST['csrf'])) die();

  try  {
    $connection = new PDO($dsn, $username, $password, $options);
    
    $new_user = array(
      "rollno" => $_POST['rollno'],
      "name" => $_POST['name'],
      "prog" => $_POST['prog'],
      "dept" => $_POST['dept'],
    );

    $sql = sprintf(
      "INSERT INTO %s (%s) values (%s)",
      "users",
      implode(", ", array_keys($new_user)),
      ":" . implode(", :", array_keys($new_user))
    );
    
    $statement = $connection->prepare($sql);
    $statement->execute($new_user);
  } catch(PDOException $error) {
      echo $sql . "<br>" . $error->getMessage();
  }
}
?>
<?php require "templates/header.php"; ?>

  <?php if (isset($_POST['submit']) && $statement) : ?>
    <blockquote><?php echo escape($_POST['rollno']); ?> successfully added.</blockquote>
  <?php endif; ?>

  <h2>Add a user</h2>

  <form method="post">
    <input name="csrf" type="hidden" value="<?php echo escape($_SESSION['csrf']); ?>">
    <label for="rollno">Roll number</label>
    <input type="text" name="rollno" id="rollno">
    <label for="name">Name</label>
    <input type="text" name="name" id="name">
    <label for="prog">Program</label>
    <input type="text" name="prog" id="prog">
    <label for="dept">Department</label>
    <input type="text" name="dept" id="dept">
    <input type="submit" name="submit" value="Submit">
  </form>

  <a href="index1.php">Back to home</a>

<?php require "templates/footer.php"; ?>