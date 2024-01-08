<script>
    history.pushState(null, null, null);
    window.addEventListener('popstate', function () {
        history.pushState(null, null, null);
    });
</script>


<!--Include Header-->
<?php 
/*require_once($_SERVER['DOCUMENT_ROOT'] . "/includes/output_functions.php");  
Student_Export_XLS('AA');*/


 //require_once($_SERVER['DOCUMENT_ROOT'] . "/includes/functions.php");
  $path = $_SERVER['DOCUMENT_ROOT'];
  $header = $path . "/includes/header.php";
  include ($header);

  $nav = $path . "/includes/nav.php";
  include ($nav);
?>


<article>

  <section id="marketing" style="padding-bottom: 20px;">
    <div class="marketing-site-content-section">
      <div class="marketing-site-content-section-img">
        <img src="/images/auto_logo.png" alt="AUTO Diagnostic Office" />
      </div>
      <div class="marketing-site-content-section-block">
        <h3 class="marketing-site-content-section-block-header">High Performance Data Logger</h3>
        <a href="#" class=" hollow round button small">learn more</a>
      </div>
      <div class="marketing-site-content-section-block small-order-2 medium-order-1">
        <h3 class="marketing-site-content-section-block-header">Connect. Measure. Analyze.</h3>
        <a href="#" class="hollow round button small">learn more</a>
      </div>
      <div class="marketing-site-content-section-img small-order-1 medium-order-2">
        <img src="/images/brake-disc.jpg" alt="Choose AUTO Diagnostic Office and you will never regret" />
      </div>
    </div>
  </section>

  <section id="services" style="background-color: #2c3840; padding: 20px 0;">
      <div class="row column">
        <h2 class="lead" style="color: aliceblue;">SERVICES</h2>
      </div>

      <div class="row small-up-1 medium-up-2 large-up-3">
        <div class="column">
          <div class="callout">
            <p>Visual Defects</p>
            <p><img src="/images/visual_defects.jpg" alt="image of a planet called Pegasi B"></p>
            <!--<p class="subheader">Find Earth-like planets life outside the Solar System</p>-->
          </div>
        </div>
        <div class="column">
          <div class="callout">
            <p>Brakes</p>
            <p><img src="/images/brakes.jpg" alt="image of a planet called Pegasi B"></p>
            <!--<p class="subheader">Find Earth-like planets life outside the Solar System</p>-->
          </div>
        </div>
        <div class="column">
          <div class="callout">
            <p>Extrapolation</p>
            <p><img src="/images/extrapolation.jpg" alt="image of a planet called Pegasi B"></p>
            <!--<p class="subheader">Find Earth-like planets life outside the Solar System</p>-->
          </div>
        </div>
        <div class="column">
          <div class="callout">
            <p>Suspension / Side Slip</p>
            <p><img src="/images/suspension.jpg" alt="image of a planet called Pegasi B"></p>
            <!--<p class="subheader">Find Earth-like planets life outside the Solar System</p>-->
          </div>
        </div>
        <div class="column">
          <div class="callout">
            <p>Headlight</p>
            <p><img src="/images/headlight.jpg" alt="image of a planet called Pegasi B"></p>
            <!--<p class="subheader">Find Earth-like planets life outside the Solar System</p>-->
          </div>
        </div>
        <div class="column">
          <div class="callout">
            <p>Emission</p>
            <p><img src="/images/emission.jpg" alt="image of a planet called Pegasi B"></p>
            <!--<p class="subheader">Find Earth-like planets life outside the Solar System</p>-->
          </div>
        </div>
        <div class="column">
          <div class="callout">
            <p>Alignment</p>
            <p><img src="/images/alignment.jpg" alt="image of a planet called Pegasi B"></p>
            <!--<p class="subheader">Find Earth-like planets life outside the Solar System</p>-->
          </div>
        </div>
        <div class="column">
          <div class="callout">
            <p>Vulcanize</p>
            <p><img src="/images/vulcanize.jpg" alt="image of a planet called Pegasi B"></p>
            <!--<p class="subheader">Find Earth-like planets life outside the Solar System</p>-->
          </div>
        </div>
        <div class="column">
          <div class="callout">
            <p>General Mechanic</p>
            <p><img src="/images/mechanic.jpg" alt="image of a planet called Pegasi B"></p>
            <!--<p class="subheader">Find Earth-like planets life outside the Solar System</p>-->
          </div>
        </div>

      </div>
  </section>

  <!--<section class="marketing-site-three-up" id="services">
    <h2 class="marketing-site-three-up-headline">Services</h2>
    <div class="row medium-unstack">
      <div class="columns">
        <i class="fa fa-gg" aria-hidden="true"></i>
        <h4 class="marketing-site-three-up-title">Primary School</h4>
        <p class="marketing-site-three-up-desc">These modules are interlinked by datasets that allows Parents, Teachers, School Management and Students to manage, maintain monitor and provide quality education and services to every student attending your school.</p>
      </div>
      <div class="columns">
        <i class="fa fa-user-o" aria-hidden="true"></i>
        <h4 class="marketing-site-three-up-title">Junior High School</h4>
        <p class="marketing-site-three-up-desc">SoftSchool is built on the latest computer technologies and can be used by schools of any size. Its database is robust and can support millions of records.</p>
      </div>
      <div class="columns">
        <i class="fa fa-check-square-o" aria-hidden="true"></i>
        <h4 class="marketing-site-three-up-title">Products</h4>
        <p class="marketing-site-three-up-desc">Data is never thrown away and will be available for querying long after students have graduated and left. Parents and guardians ability to access student data and reports over the internet is an added bonus. SoftSchool is developed and supported by Superior Software Systems and its customer focused network of expert channel partners.</p>
      </div>
    </div>
  </section>-->

  <section id="about-us" style="padding-top: 5vw; padding-bottom: 5vw; background-color: #2c3840;">
    <div style="margin-right: auto; margin-left: auto; max-width: 1000px; align-items: center; text-align: center;">
      <p style="color: aliceblue;"><span>ABOUT</span></p>
      <h3 style="font-weight: 800; color: #a0d9d5;">- AUTO Diagnostic Office -</h3>

      <p style="color: lightgray;"><span>The AUTO Diagnostic Office System is the integrated mechanic shop management system for the modern shops that wants to be innovative and competitive in this new millennium. It has been designed with an extensive feature set, yet it is simple to manage and configure. AUTO Diagnostic Office is modular in design and can grow as your institution and requirements grow. It grows with you, ensuring that new features that are introduced are truly features that are needed. AUTO Diagnostic Office is a system that is open to the needs and requests of its customers. In creating a large family of users, you can be assured that as requests for certain features are incorporated, all users will benefit.</span><br>

      <span style="color: darkgrey">AUTO Diagnostic Office is built on the latest computer technologies and can be used by shops of any size. Its database is robust and can support millions of records. Data is never thrown away and will be available for querying as long as the vehicle runs on the road.  Business owners ability to access operation data and reports over the internet is an added bonus AUTO Diagnostic Office is developed and supported by German Goodz and its customer focused network of expert channel partners. You can be assured that there is always a support person nearby. There is also a dedicated help desk, which is just a phone call or an e-mail away.</span></p>
    </div>
  </section>

  <div style="padding-top: 4vw; padding-bottom: 4vw; background-color: #a0d9d5;">
    <div style="margin-right: auto; margin-left: auto; max-width: 1000px;">
      <h4 style="text-align: center;">Use the code <strong>#MIXGH007BMW</strong> and get a great disccount on all our components</h4>
    </div>
  </div>

</article>


 <!--Include Nav_Footer and Footer-->
  <?php 
    $path = $_SERVER['DOCUMENT_ROOT'] ;
    include ($path . "/includes/nav_footer.php");
    include ($path . "/includes/footer.php");
  ?>