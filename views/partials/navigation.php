<header id="header">
  <div class="wrapper">
    <div class="flex-wrapper">
      <div id="logo">
       <a href="./"><img src="public/images/logo.png" alt=""></a>
      </div>
      <nav id="menu">
        <?php if(isset($_SESSION['userid'])):?>
        <ul>
          <li><a href="./">Home</a></li>
          <li><a href="./profile">Profile</a></li>
          <li><a href="./stage-picker">Play</a></li>
          <li><a href="./logout">Logout</a></li>
        </ul>
      <?php else: ?>
        <ul>
          <li><a href="./">Login</a></li>
          <li><a href="./register">Register</a></li>
        </ul>
      <?php endif;?>
      </nav>
    </div>
  </div>
</header>
<div class="wrapper">
    <div class="flex-wrapper">
