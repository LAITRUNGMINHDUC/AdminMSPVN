<!DOCTYPE html>
<html lang="en">

    <head>

        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>MSP VN Portal For Student</title>

        <!-- CSS -->
        <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Roboto:400,100,300,500">
        <link rel="stylesheet" href="{{ url('/') }}/assets/bootstrap/css/bootstrap.min.css">
        <link rel="stylesheet" href="{{ url('/') }}/assets/font-awesome/css/font-awesome.min.css">		
        <link rel="stylesheet" href="{{ url('/') }}/assets/css/style.css">

        <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
        <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
        <!--[if lt IE 9]>
            <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
            <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
        <![endif]-->
    </head>

    <body>

        <!-- Top content -->
        <div class="top-content">        	
            <div class="inner-bg">
                <div class="container">
                    <div class="row">
                        <div class="col-sm-8 col-sm-offset-2 text">
                            <h1><strong>Microsoft Student Partners Vietnam</strong> <br> Portal For Student</h1>
                    </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-6 col-sm-offset-3 form-box">
                        	<div class="form-top">
                        		<div class="form-top-left">
                        			<h3>Signin to our site</h3>
                                    <p>
                                        Using your social account to Signin and Signup
                                    </p>
                        		</div>
                        		<div class="form-top-right">
                        			<i class="fa fa-key"></i>
                        		</div>
                            </div>
                            <div class="form-bottom">                            
                                    <a class="btn btn-link-1 btn-link-1-microsoft" href="Auth/Redirect/Microsoft">
                                        <i class="fa fa-windows"></i> Microsoft Account
                                    </a>
                                    <a class="btn btn-link-1 btn-link-1-google-plus" href="Auth/Redirect/Google">
                                        <i class="fa fa-google-plus"></i> Google Account
                                    </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>            
        </div>


        <!-- Javascript -->
        <script src="{{ url('/') }}/assets/js/jquery-1.11.1.min.js"></script>
        <script src="{{ url('/') }}/assets/bootstrap/js/bootstrap.min.js"></script>
        <script src="{{ url('/') }}/assets/js/jquery.backstretch.min.js"></script>
        <script src="{{ url('/') }}/assets/js/scripts.js"></script>
        
        <!--[if lt IE 10]>
            <script src="{{ url('/') }}.assets/js/placeholder.js"></script>
        <![endif]-->

    </body>

</html>