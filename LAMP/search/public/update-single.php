<?php

/**
 * Use an HTML form to edit an entry in the
 * users table.
 *
 */

require "../config.php";
require "../common.php";

if (isset($_POST['submit'])) {
  if (!hash_equals($_SESSION['csrf'], $_POST['csrf'])) die();

  try {
    $connection = new PDO($dsn, $username, $password, $options);

    $user =[
      "rollno"  => $_POST['rollno'],
      "name" => $_POST['name'],
      "prog"     => $_POST['prog'],
      "dept"       => $_POST['dept'],
      "date"      => $_POST['date']
    ];

    $sql = "UPDATE users 
            SET rollno = :rollno, 
              name = :name, 
              prog = :prog, 
              dept = :dept,  
              date = :date 
            WHERE rollno = :rollno";
  
  $statement = $connection->prepare($sql);
  $statement->execute($user);
  } catch(PDOException $error) {
      echo $sql . "<br>" . $error->getMessage();
  }
}
  
if (isset($_GET['rollno'])) {
  try {
    $connection = new PDO($dsn, $username, $password, $options);
    $rollno = $_GET['rollno'];

    $sql = "SELECT * FROM users WHERE rollno = :rollno";
    $statement = $connection->prepare($sql);
    $statement->bindValue(':rollno', $rollno);
    $statement->execute();
    
    $user = $statement->fetch(PDO::FETCH_ASSOC);
  } catch(PDOException $error) {
      echo $sql . "<br>" . $error->getMessage();
  }
} else {
    echo "Something went wrong!";
    exit;
}
?>

<?php require "templates/header.php"; ?>

<?php if (isset($_POST['submit']) && $statement) : ?>
	<blockquote><?php echo escape($_POST['rollno']); ?> successfully updated.</blockquote>
<?php endif; ?>

<h2>Edit a user</h2>

<form method="post">
    <input name="csrf" type="hidden" value="<?php echo escape($_SESSION['csrf']); ?>">
    <?php foreach ($user as $key => $value) : ?>
      <label for="<?php echo $key; ?>"><?php echo ucfirst($key); ?></label>
	    <input type="text" name="<?php echo $key; ?>" id="<?php echo $key; ?>" value="<?php echo escape($value); ?>" <?php echo ($key === 'rollno' ? 'readonly' : null); ?>>
    <?php endforeach; ?> 
    <input type="submit" name="submit" value="Submit">
</form>

<a href="index1.php">Back to home</a>

<?php require "templates/footer.php"; ?>
