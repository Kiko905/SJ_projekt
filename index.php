<?php session_start(); ?>
<?php require_once 'header.php'; ?>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.carousel.min.js"></script>

<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">

<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>

<main class="container-lg"> 
  <div class="shadow p-4 mb-4 bg-white border border-light rounded-lg">
    <h1>Vitajte na GymCold.</h1>
    <p>Pripravte sa zmenit si zivot.</p>

    <div class="jumbotron m-3 font-italic">
      <div class="container">
        <div class="row">
          <div class="col-lg-6">
            <h1 class="display-4">Vitajte na správnej ceste!</h1>
            <p class="lead">Ocitol si sa v snahe dostať sa do formy?</p>
            <hr class="my-4">
            <p>Zisti viac o tom ako dosiahnuť svoje ciele.</p>
          </div>
          <div class="col-lg-6 d-flex align-items-center justify-content-center">
            <a class="btn btn-light btn-lg" href="contact.php" role="button">Kontaktuj nás!</a>
          </div>
        </div>
      </div>
    </div>

    <div class="container my-5">
      <div class="row">
        <div class="col-lg-4 mb-4">
          <div class="card">
            <img src="img/image1.jpg" class="card-img-top" alt="Card image">
            <div class="card-body">
              <h5 class="card-title">Kardiovaskulárny program</h5>
              <p class="card-text">Náš kardiovaskulárny program je navrhnutý tak, aby zlepšil zdravie vášho srdca a vytrvalosť. Zahrňuje rôzne cvičenia, ako je beh, cyklistika a plávanie.</p>
              <a href="contact.php" class="btn btn-primary">Dozvedieť sa viac</a>
            </div>
          </div>
        </div>
        <div class="col-lg-4 mb-4">
          <div class="card">
            <img src="img/image2.jpg" class="card-img-top" alt="Card image">
            <div class="card-body">
              <h5 class="card-title">Program silového tréningu</h5>
              <p class="card-text">Náš program silového tréningu je navrhnutý tak, aby zlepšil silu a vytrvalosť vašich svalov. Zahrňuje cvičenia, ako je zdvíhanie činiek a odporový tréning.</p>
              <a href="contact.php" class="btn btn-primary">Dozvedieť sa viac</a>
            </div>
          </div>
        </div>
        <div class="col-lg-4 mb-4">
          <div class="card">
            <img src="img/image3.jpg" class="card-img-top" alt="Card image">
            <div class="card-body">
              <h5 class="card-title">Program flexibility</h5>
              <p class="card-text">Náš program flexibility je navrhnutý tak, aby zlepšil vašu flexibilitu a rovnováhu. Zahrňuje cvičenia, ako je joga a strečing.</p>
              <a href="contact.php" class="btn btn-primary">Dozvedieť sa viac</a>
            </div>
          </div>
        </div>
      </div>
    </div>

    <div class="container py-5" id="testimonials">
      <h2 class="text-center">Recenzie naších zákazníkov</h2>
      <div class="row">
        <div class="col-md-4">
          <blockquote>
            <p>"Toto je najlepšia služba, akú som kedy použil. Vrelo odporúčam!"</p>
            <footer>- Jožko Mrkvička</footer>
          </blockquote>
        </div>
        <div class="col-md-4">
          <blockquote>
            <p>"Som velmi spokojný so službou. Dobrá práca!"</p>
            <footer>- Janko Hraško</footer>
          </blockquote>
        </div>
        <div class="col-md-4">
          <blockquote>
            <p>"Excelentné služby a skvelý personál. Určite odporučím známim."</p>
            <footer>- Pop Smoke</footer>
          </blockquote>
        </div>
      </div>
    </div>

    <button id="scrollButton" style="display: none;">Scroll to top</button>
  </div>
</main>

<?php require_once 'footer.php'; ?>
