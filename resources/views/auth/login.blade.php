<!DOCTYPE html>
<html lang="en">

<head>
    <!-- basic -->
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <!-- mobile metas -->
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="viewport" content="initial-scale=1, maximum-scale=1">
    <!-- site metas -->
    <title>Login</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        .logo_login {
            background-image: url('images/layout_img/login_image.jpg');
        }
    </style>
</head>

<body class="inner_page login">
    <div class="full_container">
        <div class="container">
            <div class="center verticle_center full_height">
                <div class="login_section">
                    <div class="logo_login">
                        <div class="center">
                            <img width="210" src="images/logo/logo.png" alt="#" />
                        </div>
                    </div>
                    <div class="login_form">
                        <form>
                            <fieldset>
                                <div class="field">
                                    <label class="label_field">Email Address</label>
                                    <input type="email" name="email" placeholder="E-mail" required />
                                </div>
                                <div class="field">
                                    <label class="label_field">Password</label>
                                    <input type="password" name="password" placeholder="Password" required />
                                </div>
                                <br>
                                {{-- <div class="field">
                                    <label class="label_field hidden">hidden label</label>
                                    <label class="form-check-label"><input type="checkbox" class="form-check-input">
                                        Remember Me</label>
                                    <a class="forgot" href="">Forgotten Password?</a>
                                </div> --}}
                                <div class="field margin_0">
                                    <label class="label_field hidden">hidden label</label>
                                    <button class="main_bt">Sing In</button>
                                </div>
                            </fieldset>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>

</html>
