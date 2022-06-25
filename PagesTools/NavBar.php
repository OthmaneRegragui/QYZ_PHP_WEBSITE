
<nav class="navbar navbar-expand-lg bg-light" id="nav">
  <div class="container-fluid">
    <a class="navbar-brand" href="<?php echo $Url;?>">QYZ</a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarSupportedContent">
      <ul class="navbar-nav me-auto mb-2 mb-lg-0">
        <li class="nav-item">
          <a class="nav-link active" aria-current="page" href="<?php echo $Url;?>">Home</a>
        </li>
      </ul>
      <div class="d-grid gap-2 d-md-block">
        <button type="button" onclick="location.href='<?php echo $Url;?>Auth/Login.php';" class="btn btn-outline-primary" >Login</button>
        <button type="button" onclick="location.href='<?php echo $Url;?>Auth/Register.php';"  class="btn btn-outline-secondary">Register</button>
      </div>

    </div>
  </div>
</nav>