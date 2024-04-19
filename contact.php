<?php
    session_start();
    include 'connect.php';
    include 'includes/header.php';
    include 'includes/footer.php'; //much better if naa jud ni sa taas
?>
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="css/teknoStyles.css">
    <title>TeknoEvents Contact Page</title>
</head>

<body>
<div class="container">  
    <div class="column">
      <form>
        <h1>Contact Us</h1>
        <span>Do you have any concerns?</span>
        <input type="text" id="fname" name="firstname" placeholder="Full Name">
        <select id="country" name="country">
          <option value="philippines">Philippines</option>
          <option value="australia">Australia</option>
          <option value="canada">Canada</option>
          <option value="usa">USA</option>
          <option value="nicaragua">Nicaragua</option>
        </select>
        <textarea id="subject" name="subject" placeholder="Write your concern" style="height:100px; width:690px"></textarea>
        <input type="submit" value="Submit">
      </form>
    </div>
  
</div>
</body>
