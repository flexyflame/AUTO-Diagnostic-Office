<!--Include Header-->
<?php  
 //require_once($_SERVER['DOCUMENT_ROOT'] . "/includes/functions.php");
  $path = $_SERVER['DOCUMENT_ROOT'];
  $header = $path . "/includes/header.php";
  include ($header);

  $nav = $path . "/includes/nav.php";
  include ($nav);
?>


<article>
  <div class="callout large">
      <div class="row column text-center">
        <h1 style="color: #2ba6cb; font-weight: 600;"> - About eSoftSchool - </h1>
        <p class="lead" style="color: darkblue;">School Admin Anytime, Anywhere.</p>
        <a href="#" class="button large">Learn More</a>
      </div>
    </div>

    <div class="row">
      <div class="small-12 medium-6 large-6 columns medium-push-6">
        <img style="box-shadow: 0 0 4px 3px rgb(25 80 204 / 26%);" class="thumbnail" src="/images/logo-banner.jpg">
      </div>
      <div class="small-12 medium-6 large-6 columns medium-pull-6">
        <h2>The SoftSchool System - </h2>
        <p>is the integrated school management system for the Primary, Junior High School (JHS) and Senior High School (SHS) that wants to be innovative and competitive in this new millennium. It has been designed with an extensive feature set, yet it is simple to manage and configure. SoftSchool is modular in design and can grow as your institution and requirements grow. It grows with you, ensuring that new features that are introduced are truly features that are needed. SoftSchool is a system that is open to the needs and requests of its customers. In creating a large family of users, you can be assured that as requests for certain features are incorporated, all users will benefit.</p>
      </div>
    </div>

    <div class="row">
      <div class="small-12 medium-4 large-4 columns">
        <h3>Technology</h3>
        <p>SoftSchool is built on the latest computer technologies and can be used by schools of any size. Its database is robust and can support millions of records. </p>
      </div>
      <div class="small-12 medium-4 large-4 columns">
        <h3>Data</h3>
        <p>Data is never thrown away and will be available for querying long after students have graduated and left. Parents and guardians ability to access student data and reports over the internet is an added bonus. </p>
      </div>
      <div class="small-12 medium-4 large-4 columns">
        <h3>Support</h3>
        <p>SoftSchool is developed and supported by Superior Software Systems and its customer focused network of expert channel partners. You can be assured that there is always a support person nearby. There is also a dedicated help desk, which is just a phone call or an e-mail away.</p>
      </div>
    </div>

    <hr>

</article>

  <!--Include Nav_Footer and Footer-->
  <?php 
    $path = $_SERVER['DOCUMENT_ROOT'] ;
    include ($path . "/includes/nav_footer.php");
    include ($path . "/includes/footer.php");
    include($path . "/includes/app-dashboard-footer.php");
  ?>