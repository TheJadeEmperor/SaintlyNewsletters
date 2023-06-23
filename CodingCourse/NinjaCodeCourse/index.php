<?php

?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="BL Web Solutions">
    <link rel="icon" type="image/x-icon" href="assets/images/favicon.ico">

    <link href="https://fonts.googleapis.com/css?family=Montserrat:100,200,300,400,500,600,700,800,900" rel="stylesheet">

    <title>BL Websolutions Portfolio</title>
    
    <!-- Bootstrap core CSS -->
    <link href="vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">

    <!-- Additional CSS Files -->
    <link rel="stylesheet" href="assets/css/fontawesome.css">
    <link rel="stylesheet" href="assets/css/templatemo-grad-school.css">
    <link rel="stylesheet" href="assets/css/owl.css">
    <link rel="stylesheet" href="assets/css/lightbox.css">
    <link rel="stylesheet" href="assets/css/hoverbox.css">

    <script>

var NoExitPage = false; 

function ExitPage() { 
    if(NoExitPage == false) { 
    NoExitPage=true; 
    location.href='<?=$landingURL?>'; 
    
    return"***********************************************\n\n"+ 
    " WAIT! Sign up to get your FREE Neobux Report! \n\n"+ 
    " Learn how to get 40+ Direct Referrals Overnight! \n\n"+ 
    " Click the [Cancel] button to Download Your FREE GIFT!\n\n"+ 
    "***********************************************"; 
    } 
} 


function validateEmail(email) { /* validation for email field */
    console.log('validateEmail ' + email);
    if (/^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{3,4})+$/.test(email)) {
        return true;
    } else {
        document.getElementById('error').innerHTML = 'You have entered an invalid email address!';
        
        return false;
    }
}
</script>



<style>
.container {
  display: flex;
}

 .form-container {
    display: flex;
    flex-direction: column;
    justify-content: center;
    align-items: center;
    background-color: rgba(0, 0, 0, 0.4);
    width: 45%;
   
    margin-right: 5%;
}
    
.image-container {
    display: flex;
    justify-content: center;
    align-items: center;
    width: 50%;
}

.image-container img {
  max-width: 100%;
  height: auto;
}

form {
  padding: 60px 30px 50px 30px;
}

h1 {
  color: #FFF;
  margin: 0;
  font-size: 2em;
}

label, input, button {
  margin: 10px 0;
}

label {
  color: #FFF;
}

input {
  width: 100%;
  height: 50px;
  padding: 10px;
  box-sizing: border-box;
}

button {
  background-color: #f5a425;
    color: #fff;
    font-size: 13px;
    text-transform: uppercase;
    letter-spacing: 0.5px;
    font-weight: 700;
    padding: 12px 20px;
    display: inline-block;
    outline: none;
    cursor:pointer;
}
</style>

  </head>
<body>

  <!-- ***** Main Banner Area Start ***** -->
  <section class="section main-banner" id="top" data-section="section1">
      <video autoplay muted loop id="bg-video">
          <source src="assets/images/computer.mp4" type="video/mp4" />
      </video>

      <div class="video-overlay header-text">
          <div class="caption">
 


          <div class="container">
  <div class="form-container">

      <form method="POST" id="TRWVLCPForm" name="TRWVLCPForm" action="https://www.trafficwave.net/cgi-bin/autoresp/inforeq.cgi">

        <h1>GET YOUR FREE <em>HTML</em> CHEAT SHEET</h1>
        <h3></h3>
        <label for="email">And code like a ninja today!</label>

        <input type="email"  id="da_email" name="da_email" value="Enter your best email" onclick="this.value=''" required>
        
        <button type="submit" value="Submit" id="submit" name="subscribe" class="link button" onclick="return validateEmail(document.getElementById('email').value);">Submit</button>

        <input type="hidden" id="da_name" name="da_name" value="Ninja Coder">
        <input type="hidden" name="trwvid" value="neobux">
        <input type="hidden" name="series" value="codingcourse">
        <input type="hidden" name="subscrLandingURL" value="<?=$subscrLandingURL?>">
        <input type="hidden" name="confirmLandingURL" value="<?=$confirmLandingURL?>">
        <input type="hidden" name="langPref" value="en"><input type="hidden" name="lcpID" value=""><input type="hidden" name="lcpDE" value="0">
        
      </form>


  </div>

  <div class="image-container">
    <img src="assets/images/code.png" alt="Code" />
  </div>

</div>
             
          </div>
      </div>
  </section>
  <!-- ***** Main Banner Area End ***** -->


</body>


 