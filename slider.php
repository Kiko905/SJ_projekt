<div id="myCarousel" class="carousel slide" data-ride="carousel">
  <!-- Indicators -->
  <ol class="carousel-indicators">
    <li data-target="#myCarousel" data-slide-to="0" class="active"></li>
    <li data-target="#myCarousel" data-slide-to="1"></li>
    <li data-target="#myCarousel" data-slide-to="2"></li>
  </ol>

  <!-- Wrapper for slides -->
  <div class="carousel-inner">
    <div class="item active">
      <img src="nature1.jpg" alt="Familia" class="centered-image">
    </div>

    <div class="item">
      <img src="nature2.jpg" alt="Familia2" class="centered-image">
    </div>

    <div class="item">
      <img src="nature3.jpg" alt="Familia3" class="centered-image">
    </div>
  </div>

  <!-- Left and right controls -->
  <a class="left carousel-control" href="#myCarousel" data-slide="prev">
    <span class="glyphicon glyphicon-chevron-left"></span>
    <span class="sr-only">Previous</span>
  </a>
  <a class="right carousel-control" href="#myCarousel" data-slide="next">
    <span class="glyphicon glyphicon-chevron-right"></span>
    <span class="sr-only">Next</span>
  </a>
</div>

<style>
  .carousel-inner .item .centered-image {
    display: block;
    margin-left: auto;
    margin-right: auto;
    width: 100%;
  }
</style>
