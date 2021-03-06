<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<link rel="stylesheet" type="text/css" href="css/bootstrap.min.css">
<link rel="stylesheet" type="text/css" href="css/font-awesome.min.css">
<link rel="stylesheet" type="text/css" href="css/style.css">
<title>Poll</title>
<script type="text/javascript" src="https://www.google.com/jsapi"></script>
<script type="text/javascript">
    google.load("visualization", "1", {packages:["corechart"]});
</script>
</head>

<body>
<div id="fb-root"></div>
<script>(function(d, s, id) {
        var js, fjs = d.getElementsByTagName(s)[0];
        if (d.getElementById(id)) return;
        js = d.createElement(s); js.id = id;
        js.src = "//connect.facebook.net/en_US/sdk.js#xfbml=1&appId=289564377872077&version=v2.0";
        fjs.parentNode.insertBefore(js, fjs);
    }(document, 'script', 'facebook-jssdk'));</script>


<?php
if(isset($_SESSION['username'])):
$user = new \Poll\Models\User;
$result = $user->getIdByUsername($_SESSION['username']);
endif;
?> >
<nav class="navbar navbar-fixed-top" role="navigation">
  <div class="container">
    <div class="navbar-header">
      <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
        <span class="sr-only">Toggle navigation</span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
      </button>
      <a class="navbar-brand" href="index.php">Poll</a>
    </div>
    <div id="navbar" class="collapse navbar-collapse">
      <ul class="nav navbar-nav">

          <?php if(isset($_SESSION['username'])): ?>
              <li>
                  <a href="index.php?page=modifyUser&id=<?= $result?>">
                      Welcome, <?php echo $_SESSION['username'] ?>
                  </a>
              </li>
              <li><a href="index.php?page=createPoll">New Poll</a></li>
              <li><a href="index.php?page=logout">Logout</a></li>
        <?php else: ?>
          <li><a href="index.php?page=login">Login</a></li>
          <li><a href="index.php?page=register">Register</a></li>
        <?php endif; ?>
        
      </ul>
      <ul class="nav navbar-nav navbar-right">
      <form action="index.php" class="navbar-form navbar-left" role="search" method="GET">
        <div class="form-group">
            <input type="hidden" name="page" value="search" />
            <input id="search" name="query" type="text" class="typeahead form-control" placeholder="Search polls" />
            <input type="submit" style="position: absolute; left: -9999px; width: 1px; height: 1px;"/>
        </div>
      </form>
      </ul>
    </div><!--/.nav-collapse -->
  </div>
</nav>