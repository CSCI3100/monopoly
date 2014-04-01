
<!DOCTYPE html>
<!--[if lt IE 7]>      <html class="no-js lt-ie9 lt-ie8 lt-ie7"> <![endif]-->
<!--[if IE 7]>         <html class="no-js lt-ie9 lt-ie8"> <![endif]-->
<!--[if IE 8]>         <html class="no-js lt-ie9"> <![endif]-->
<!--[if gt IE 8]><!--> <html class="no-js"> <!--<![endif]-->
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
        <title>Monopoly - Registration</title>
        <meta name="description" content="">
        <meta name="viewport" content="width=device-width">
        <link rel="stylesheet" href="css/bootstrap.min.css">
        <link rel="stylesheet" href="css/bootstrap-theme.min.css">
        <link rel="stylesheet" href="css/main.css">

        <script src="js/vendor/modernizr-2.6.2-respond-1.1.0.min.js"></script>
    </head>
    <body>
	<svg version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px"
					 width="512px" height="512px" viewBox="0 0 512 512" enable-background="new 0 0 512 512" xml:space="preserve">
				<path id="loading-12-icon" d="M291,82.219c0,16.568-13.432,30-30,30s-30-13.432-30-30s13.432-30,30-30S291,65.65,291,82.219z
					 M261,404.781c-15.188,0-27.5,12.312-27.5,27.5s12.312,27.5,27.5,27.5s27.5-12.312,27.5-27.5S276.188,404.781,261,404.781z
					 M361.504,113.167c-4.142,7.173-13.314,9.631-20.487,5.489c-7.173-4.141-9.631-13.313-5.49-20.487
					c4.142-7.173,13.314-9.631,20.488-5.489C363.188,96.821,365.645,105.994,361.504,113.167z M188.484,382.851
					c-14.348-8.284-32.697-3.368-40.98,10.98c-8.285,14.349-3.367,32.696,10.98,40.981c14.35,8.283,32.697,3.367,40.98-10.981
					C207.75,409.482,202.834,391.135,188.484,382.851z M421.33,184.888c-8.368,4.831-19.07,1.965-23.901-6.404
					c-4.832-8.368-1.965-19.07,6.404-23.902c8.368-4.831,19.069-1.964,23.9,6.405C432.566,169.354,429.699,180.056,421.33,184.888z
					 M135.399,329.767c-8.285-14.35-26.633-19.266-40.982-10.982c-14.348,8.285-19.264,26.633-10.979,40.982
					c8.284,14.348,26.632,19.264,40.981,10.98C138.767,362.462,143.683,344.114,135.399,329.767z M436.031,277.249
					c-11.044,0-20-8.953-20-19.999c0-11.045,8.955-20.001,20.001-20.001c11.044,0,19.999,8.955,19.999,20.002
					C456.031,268.295,447.078,277.249,436.031,277.249z M115.97,257.251c-0.001-16.57-13.433-30.001-30.001-30.002
					c-16.568,0.001-29.999,13.432-30,30.002c0.001,16.566,13.433,29.998,30.001,30C102.538,287.249,115.969,273.817,115.97,257.251z
					 M401.333,364.248c-10.759-6.212-14.446-19.97-8.234-30.73c6.212-10.759,19.971-14.446,30.731-8.233
					c10.759,6.211,14.445,19.971,8.232,30.73C425.852,366.774,412.094,370.46,401.333,364.248z M135.398,184.736
					c8.285-14.352,3.368-32.698-10.98-40.983c-14.349-8.283-32.695-3.367-40.981,10.982c-8.282,14.348-3.366,32.696,10.981,40.981
					C108.768,204,127.115,199.082,135.398,184.736z M326.869,421.328c-6.902-11.953-2.807-27.242,9.148-34.145
					s27.243-2.806,34.146,9.149c6.902,11.954,2.806,27.243-9.15,34.145C349.059,437.381,333.771,433.284,326.869,421.328z
					 M188.482,131.649c14.352-8.286,19.266-26.633,10.982-40.982c-8.285-14.348-26.631-19.264-40.982-10.98
					c-14.346,8.285-19.264,26.633-10.98,40.982C155.787,135.017,174.137,139.932,188.482,131.649z"/>
			</svg>
    
    
    <?php
    if(!isset($_POST['username']) && empty($_POST['username']) && !isset($_POST['authentication'])){
        if (isset($_GET['authentication'])) {
            require './database.php';
            require './class/user.php';
            $authen = new User($db);
            $adata = $authen->getPreData($_GET['authentication']);
            if($adata==NULL){
                $msg = "Registration error";
    ?>
                <div class="bg1">
                <div class="login_form bmsg">
                <div class="login_header">
                    Registration
                </div>
                <h2 class="msg"><?=$msg;?></h2>
                <a href="./index.php"><button class="warningbutton">Home</button></a>
                </div>
                </div>
                </div> <!-- /container --> 
    <?php
            }else{
    ?>
                <div class="bg1">
                <div class="login_form">
                <div class="login_header">
                    Registration
                </div>
                <h1 class="title">Monopoly</h1>
                Confirming: <?php echo $adata['displayName']; ?>
                <form id="reg-form" name="input" action="register.php" method="post">
                  <input type="hidden" name="authentication" value="<?= $_GET['authentication'] ?>">
                  <input type="password" id="password" name="password" placeholder="Password"><br />
                  <input type="password" id="password2" name="paassword2" placeholder="Password(Confirmation)"><br />
                  <button type="submit" class="button reg">Confirm</button>
                </form>
                </div>
                </div>
                </div>

    <?php
            }
        }else{
    ?>
        	<div class="bg1">
        	<div class="login_form">
        	<div class="login_header">
        		Registration
        	</div>
        	<h1 class="title">Monopoly</h1>
            <button type="button" class="button" id="fb-login">
                <img class="_4z_e img" src="https://fbstatic-a.akamaihd.net/rsrc.php/v2/ys/r/56ifBuZRLqK.png" alt="" width="20" height="20">
                Register via Facebook
            </button><br/>
            <?php
                if(isset($_GET['referLink'])){
                    require './database.php';
                    require './class/user.php';
                    $referrer=new User($db);
                    $referrerName = $referrer->getReferrer($_GET['referLink']);
                    if($referrerName != ""){
            ?>
                        Referred by: <b><?php echo $referrerName['name']; ?></b><br/>
            <?php
                    }
                }
            ?>
            <form id="reg-form" name="input" action="register.php" method="post">
              <input type="text" id="username" name="username" placeholder="Username"><br />
              <input type="text" id="displayname" name="displayname" placeholder="Display Name"><br />
              <!--
              <input type="password" id="password" name="password" placeholder="Password"><br />
              <input type="password" id="password2" name="paassword2" placeholder="Password(Confirmation)"><br />
              -->
              <input type="email" id="email" name="email" placeholder="E-mail address"><br/>
              <input type="text" id="birthdate" name="birthdate" placeholder="Date of birth"><br/><br/>
              <input type="hidden" id="fb" name="fb" value="0">
                <input type="hidden" id="fbId" name="fbId">
              <?php
                if(isset($_GET['referLink'])){
              ?>
                <input type="hidden" name="referLink" value="<?php echo $_GET['referLink']; ?>">
              <?php
                }
              ?>

              <button type="button" class="button" id="profiles" value="0">Add Profile</button>
              
              <!-- Profile part if checked -->
              <div id="profileOption">
                <br/>
                <input type="tel" id="phone" name="phone" placeholder="Phone number"><br />
                <input type="tel" id="mobile" name="mobile" placeholder="Mobile phone number"><br />
                <textarea type="textarea" id="personalDesc" name="personalDesc" placeholder="Personal description"></textarea><br /><br />
              </div>
                    
                    
                   <!--<button type="button" class="button" id="fb-login">Facebook Login</button> --><button type="submit" class="button reg">Register</button>
            </form>
            </div>
            </div>
            </div> <!-- /container -->        

<?php
        }
}else{
require './database.php';
require './class/user.php';
$newuser=new User($db);
if(isset($_POST['authentication'])){
    $result = $newuser->postRegister($_POST['authentication'], $_POST['password']);
    if($result){
        $msg = "Successful Confirmation";
    }else{
        $msg = "Error occurs";
    }
}else{
    $fbid = (isset($_POST['fb'])?($_POST['fb'] == "1"?$_POST['fbId']:NULL):NULL);
    if($newuser->duplicate_uname($_POST['username'], $_POST['fbId'], $_POST['displayname'])){
        $msg= "Account exist or name has been used";
    }else{
        //($username, $password, $email, $dob, $phone, $mphone, $pDesc)
        if(isset($_POST['referLink'])){
            $refer = $_POST['referLink'];
        }else{
            $refer = NULL;
        }
        if($_POST['fb'] == "1"){
            $fbId = $_POST['fbId'];
        }else{
            $fbId = NULL;
        }
        if($newuser->preRegister($_POST['username'],$_POST['email'],$_POST['birthdate'],$_POST['phone'],$_POST['mobile'],$_POST['personalDesc'], $refer, $fbId, $_POST['displayname'])){
            $msg= "Registration successful";
            $submsg = "Please check your mailbox for further instruction.";
        }else{
            $msg= "Verification detail exist";
            $submsg = "Please contact administration if you cannot receive the verification.";
        }
        


        if($_POST['fb'] == "1"){
               header("Location: https://www.facebook.com/dialog/feed?app_id=303832676434874&display=popup&caption=%E4%B8%80%E8%B5%B7%E7%8E%A9%E5%86%9A%E5%AE%B6%E5%AF%8C%E8%B2%B4&link=http%3A%2F%2Fb5.hk%2Fmono%2F&redirect_uri=http%3A%2F%2Fb5.hk%2Fmono%2F");
        }
    }
}
?>
    <div class="bg1">
    <div class="login_form bmsg">
    <div class="login_header">
        Registration
    </div>
    <h2 class="msg"><?=$msg;?></h2>
    <?php
        if(isset($submsg)){
            echo $submsg;
        }
    ?><br/>
    <a href="./index.php"><button class="warningbutton">Home</button></a>
    </div>
    </div>
    </div> <!-- /container --> 
<?php
}
?>
    <script src="//ajax.googleapis.com/ajax/libs/jquery/1.10.1/jquery.min.js"></script>
        <script>window.jQuery || document.write('<script src="js/vendor/jquery-1.10.1.min.js"><\/script>')</script>

        <script src="js/vendor/bootstrap.min.js"></script>

        <script src="js/main.js"></script>

        <script>
        function chkInput(){
            if($('#username').val()==""){
                alert('Please enter a username');
                $('#username').focus();
                return false;
            }else if($('#username').val()==""){
                alert('Please enter a display name');
                $('#displayname').focus();
                return false;
            }else if($('#password').val()==""){
                alert('Please enter a password');
                $('#password').focus();
                return false;
            }else if($('#password2').val()==""){
                alert('Please enter your password again.');
                $('#password2').focus();
                return false;
            }else if($('#password').val()!=$('#password2').val()){
                alert('The password are not the same.');
                return false;
            }else if($('#email').val()==""){
                alert('Please enter an E-mail address');
                $('#email').focus();
                return false;
            }else if($('#birthdate').val()==""){
                alert('Please enter your date of birth');
                $('#birthdate').focus();
                return false;
            }else{
                return true;
            }
        }
            var _gaq=[['_setAccount','UA-XXXXX-X'],['_trackPageview']];
            (function(d,t){var g=d.createElement(t),s=d.getElementsByTagName(t)[0];
            g.src='//www.google-analytics.com/ga.js';
            s.parentNode.insertBefore(g,s)}(document,'script'));
            $(document).ready(function(){
				$('svg').fadeOut(500);
				$('.bg1').fadeIn(300);
                $('.reg').click(function(){
                    return chkInput();
                });
                $('#birthdate').focus(function(){
                    $('#birthdate').attr("type","date");
                });
                $('#profiles').click(function(){
                    if($(this).val() == 0){
                        console.log("0");
						$('.login_form').css("height","880");
                        $('#profiles').css("background","#e74c3c");
                        $('#profileOption').css("display","block");
                        $(this).val('1');
                    }else{
                        console.log("1");
						$('.login_form').css("height","600");
                        $(this).css("background","#BAC2C0");
                        $('#profileOption').css("display","none");
                        $(this).val('0');
                    }
                });
                $('#fb-login').click(function(){
                    $("#reg-form").attr("action","facebook_reg.php");
                    $("#reg-form").submit();
                    /*
                    FB.getLoginStatus(function(response) {
                          if (response.status === 'connected') {
                            // the user is logged in and has authenticated your
                            // app, and response.authResponse supplies
                            // the user's ID, a valid access token, a signed
                            // request, and the time the access token 
                            // and signed request each expire
                            var uid = response.authResponse.userID;
                            var accessToken = response.authResponse.accessToken;
                            $('#fbId').val(uid);
                            $('#fb').val('1');
                            $('#reg-form').submit();
                          } else if (response.status === 'not_authorized') {
                            // the user is logged in to Facebook, 
                            // but has not authenticated your app
                            FB.login(function(response) {
                               if (response.authResponse) {
                                    var uid = response.authResponse.userID;
                                    var accessToken = response.authResponse.accessToken;
                                    $('#fbId').val(uid);
                                    $('#fb').val('1');
                                    $('#reg-form').submit();
                               }
                            });
                          } else {
                            // the user isn't logged in to Facebook.
                            FB.login(function(response) {
                               if (response.authResponse) {
                                    var uid = response.authResponse.userID;
                                    var accessToken = response.authResponse.accessToken;
                                    $('#fbId').val(uid);
                                    $('#fb').val('1');
                                    $('#reg-form').submit();
                               }
                            });
                          }
                     });*/
                });
            });
        </script>
    </body>
</html>
