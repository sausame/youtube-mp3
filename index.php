<html>
<head>
  <meta http-equiv="Content-Type" content="text/html; CHARSET=utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=0.5, maximum-scale=2.0, user-scalable=yes" />

  <style>
    body {
      font-family:Arial, Sans-Serif;
    }
    .clearfix:before, .clearfix:after {
      content: ""; display: table;
    }
    .clearfix:after {
      clear: both;
    }
    a {
      color:#0067ab; text-decoration:none;
    }
    a:hover {
      text-decoration:underline;
    }
    .form {
      width: 300px;
      margin: 0 auto;
    }
    input[type='text'], input[type='email'], input[type='password'] {
      width: 400px;
      border-radius: 2px;
      border: 1px solid #CCC;
      padding: 10px;
      color: #333;
      font-size: 14px;
      margin-top: 10px;
    }
    input[type='submit']{
      padding: 10px 25px 8px;
      color: #fff;
      background-color: #0067ab;
      text-shadow: rgba(0,0,0,0.24) 0 1px 0;
      font-size: 16px;
      box-shadow: rgba(255,255,255,0.24) 0 2px 0 0 inset,#fff 0 1px 0 0;
      border: 1px solid #0164a5;
      border-radius: 2px;
      margin-top: 10px;
      cursor:pointer;
    }
    input[type='submit']:hover {
      background-color: #024978;
    }
  </style>
  <title>Youtube Mp3 Convertor</title>
</head>
<body>
<?php

$isToStart = false;
$prefix = "https://www.youtube.com/watch?v=";

session_start();

if (isset($_SESSION['url'])) {
	$url = $_SESSION['url'];
} elseif (! empty($_POST)) {
	$url = $_POST['url'];
} elseif (! empty($_GET)) {
	$url = $_GET['url'];
}

if (! empty($url) && ! isset($_SESSION['url'])) {
	$_SESSION['url'] = $url;
	$isToStart = true;
}
?>
  <h2>Convertor</h2>
  <div id="convert">
<?php
if ('' != $url) {
	echo("<h3>Converting $url ...</h3>");
} else {
?>
    <form name="form1" method="post" action="" >
      <input type="text" name="url" placeholder="<?php echo($prefix); ?>" required />
      <input type="submit" value="convert" />
    </form>
<?php
}
?>
  </div>
  <hr/>
  <iframe id="files" width="100%" height="100%" src="files/" frameborder="0" allowfullscreen>
  </iframe>
<?php
if ('' != $url) {
?>
  <script>
<?php
	if ($isToStart) {
?>
    function getData() {

      clearInterval(timer);

      var xhr = new XMLHttpRequest();

      xhr.onload = function() {

        console.log(xhr.status);
        console.log(xhr.responseText);

        clearInterval(timer);

        var content = '';

        if (200 === xhr.status) {
          content += '<p><?php echo($url); ?> is converted.';
        } else {
          content += '<p>Convertion is failed for <?php echo($url); ?>.';
        }

        content += '<form name="form1" method="post" action="" >'
          + '<input type="text" name="url" placeholder="<?php echo($prefix); ?>" required />'
          + '<input type="submit" value="convert" />'
          + '</form>';
        document.getElementById('convert').innerHTML = content;

        var iframe = document.getElementById('files');
        iframe.src = iframe.src;
      };

      xhr.open('GET', 'convertor.php', true);
      xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
      xhr.send();
    }

<?php
	} else /* isToStart == false */ {
?>
    function getData() {

      var xhr = new XMLHttpRequest();

      xhr.onload = function() {

        console.log(xhr.status);
        console.log(xhr.responseText);

        if (200 === xhr.status) {
          clearInterval(timer);

          var content = '';

          content += '<p><?php echo($url); ?> is converted.';
          content += '<form name="form1" method="post" action="" >'
            + '<input type="text" name="url" placeholder="<?php echo($prefix); ?>" required />'
            + '<input type="submit" value="convert" />'
            + '</form>';

          document.getElementById('convert').innerHTML = content;
          document.getElementById('files').contentWindow.location.reload(true);
        }
      };

      xhr.open('GET', 'updater.php', true);
      xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
      xhr.send();
    }
<?php
	} // if isToStart
?>

    var timer = setInterval(getData, 1000);
  </script>
<?php
}
?>
</body>
</html>

