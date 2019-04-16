<!--<nav class="navbar navbar-expand-md navbar-dark bg-dark fixed-top">-->
<nav class="navbar navbar-expand-lg navbar-dark bg-dark mb-3">
  
  <div class="container">

    <a class="navbar-brand" href="<?= URLROOT; ?>"><?= SITENAME; ?></a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarsExampleDefault" aria-controls="navbarsExampleDefault" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" id="navbarsExampleDefault">
      <ul class="navbar-nav mr-auto">
        <li class="nav-item">
          <!-- <a class="nav-link" href="#">Home <span class="sr-only">(current)</span></a> -->
          <a class="nav-link" href="<?= URLROOT; ?>">Home </a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="<?= URLROOT; ?>/pages/about">About</a>
        </li>

        <!-- <li class="nav-item">
          <a class="nav-link disabled" href="#" tabindex="-1" aria-disabled="true">Disabled</a>
        </li>
        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle" href="#" id="dropdown01" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Dropdown</a>
          <div class="dropdown-menu" aria-labelledby="dropdown01">
            <a class="dropdown-item" href="#">Action</a>
            <a class="dropdown-item" href="#">Another action</a>
            <a class="dropdown-item" href="#">Something else here</a>
          </div>
        </li> -->

      </ul>
      
      <!-- <form class="form-inline my-2 my-lg-0">
        <input class="form-control mr-sm-2" type="text" placeholder="Search" aria-label="Search">
        <button class="btn btn-secondary my-2 my-sm-0" type="submit">Search</button>
      </form> -->

      <ul class="navbar-nav ml-auto">
        <?php if(!Session::exists(SESSION_USER_ID)) : ?>
          <li class="nav-item ">   
            <a class="nav-link" href="<?= URLROOT; ?>/users/register">Register </a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="<?= URLROOT; ?>/users/login">Login</a>
          </li>
        <?php else : ?>
        
        <li class="nav-item "> 
          <a class="nav-link text-white" > <i class="fa fa-user-circle" aria-hidden="true"></i>
            <?= Session::get(SESSION_USER_NAME); ?>
          </a>
     
        </li>
        <li class="nav-item ">
            <a class="nav-link" href="<?= URLROOT; ?>/users/logout">Logout </a>
        </li>
        <?php endif; ?>
      </ul>
      
    </div>

  </div>
  
</nav>