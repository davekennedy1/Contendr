<?php
?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <!-- bootstrap cdn -->
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
  <!-- google fonts -->
  <link href="https://fonts.googleapis.com/css?family=Alfa+Slab+One" rel="stylesheet">
  <!-- css font-family: 'Alfa Slab One', cursive; -->
  <!-- theme colours i like hsl(181,82,15), hsl(37,80,70), hsl(0,0,95) & white -->
  <!-- fontawesome icons -->
  <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.1/css/all.css" integrity="sha384-50oBUHEmvpQ+1lW4y57PTFmhCaXp0ML5d60M1M7uH2+nqUivzIebhndOJK28anvf" crossorigin="anonymous">


  <title>Contendr</title>
</head>

<body>
  <?php
    include('nav.php');
  ?>

    <div class="container">

      <div>
        <?php

            echo"
            <div class='signupLayout '>
              <form autocomplete='on' id='reggfrom' name='regform' action='registeruser.php' method='POST' enctype='multipart/form-data'>

                  <div class='form-group col mb-3'>
                    <label for='validationName'>Name:</label>
                    <input type='text' class='form-control' minlength='2' id='validationName' name='name' placeholder='Name' required>
                  </div>

                  <div class='form-group col mb-3'>
                    <div>
                    <label id='password' for='validationPassword'>Password:</label>
                    </div>
                    <div class ='form-check form-check-inline boxSize'>
                    <input type='password' class='form-control' name='pass' id='validationPassword' placeholder='password' pattern='(?=.*\d)(?=.*[A-Z]).{8,}' required>
                    <div class = 'form-check form-check-inline eyeBorder'>
                      <a id='showPass'><i class='fas fa-eye eyeSize'></i></a>
                      </div>
                    </div>
                    <small id='passwordReqs' class='form-text text-muted'>At least 1 Uppercase, 1 Number and 8 Characters long</small>
                    <div class='invalid-feedback'>
                      Number, Upper and Lower Case characters required. Min length - 8.
                    </div>
                  </div>
                  ";
                  // <div class='form-group col mb-3'>
                  //   <label for='validationDOB'>DOB:</label>
                  //   <input type='date' class='form-control' name='dob' id='validationDOB' placeholder='DOB' required>
                  //     <div class='invalid-feedback'>
                  //       Required.
                  //     </div>
                  // </div>
                  echo"
                  <div class='form-group col mb-3'>
                    <label id='email' for='validationEmail'>Email:</label>
                    <input type='email' class='form-control' id='validationEmail' name='email' placeholder='Email' required>
                    <small id='existingUser' class='form-text text-muted'>We'll never share your email with anyone else.</small>
                    <div class='invalid-feedback'>
                      Required.
                    </div>
                  </div>
                  ";
                  // <div class='form-group col mb-3'>
                  //   <label for='Phone'>Tel:</label>
                  //   <input type='text' class='form-control' name='phoneNumber' id='Phone' placeholder='Tel:'>
                  //   <small id='phoneHelp' class='form-text text-muted'>Optional</small>
                  // </div>
                  echo"
                  <div class='form-group col mb-3'>
                    <button id='button' class='btn btn-primary' type='submit'>Submit form</button>
                  </div>

              </form>
            </div>

          ";
        ?>
      </div>
    </div>


    <script>
    //check if username already exists
    $(document).ready(function(){
      var checkP = 0;
      var checkE = 0;
      $("#button").prop('disabled', true);

      $("#validationEmail").keyup(function(){
        var entry = this.value;
        var patt = new RegExp("@");
        var res = patt.test(entry);

        $.post('usercheck.php',{usermail: regform.validationEmail.value},
        function(result){
          $('#existingUser').html(result);
            var str = $("#existingUser").text();
            if(str == 'That email is already registered' || (!res)){
              $("#email").css("color", "red");
              checkE = 0;
              checkButton();
            }else{
              $("#email").css("color", "black");
              checkE = 1;
              checkButton();
            }
        });
      });

      //disable or enable submit button based on validation
      function checkButton(){
        if(checkE == 1 && checkP == 1){
          $("#button").prop('disabled', false);
        }else{
          $("#button").prop('disabled', true);
        }
      }

      //show or hide password
        $("#showPass").click(function(){
          var x = document.getElementById("validationPassword");
          if (x.type === "password") {
            x.type = "text";
          }else{
            x.type = "password";
          }
        });


      //check if password conforms to requirements
      $("#validationPassword").keyup(function(){
        var entry = this.value;
        var patt = new RegExp("(?=.*[0-9])(?=.*[A-Z]).{8,}");
        var res = patt.test(entry);

        if (res) {
          $("#password").css("color", "black");
          checkP = 1;
          checkButton();
        }else{
          $("#password").css("color", "red");
          checkP = 0;
          checkButton();
        }
      });

    });


    </script>

    <script
    src="https://code.jquery.com/jquery-3.4.0.js" integrity="sha256-DYZMCC8HTC+QDr5QNaIcfR7VSPtcISykd+6eSmBW5qo=" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
</body>
</html>
