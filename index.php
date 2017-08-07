<?php
include_once 'header.php';
?>

<form id="loginForm">
  <div class="form-group">
    <label for="email">Email address:</label>
    <input type="email" class="form-control" id="email">
  </div>
  <div class="form-group">
    <label for="pwd">Password:</label>
    <input type="password" class="form-control" id="pwd">
  </div>
  <div id="error"></div>
  <button type="submit" class="btn btn-default">Submit</button>
</form>

<div id="results" class="hidden"></div>

<?php
include_once 'footer.php';
?>