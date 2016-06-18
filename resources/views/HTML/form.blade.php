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
        <link rel="stylesheet" href="{{ url('/') }}/assets/css/form-elements.css">
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

                            <div class="description">
                                <p>
                                Please fill this form correctly in order to get <br>
                                <strong> MSPVN News, Code, Events and more </strong>
                                </p>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-6 col-sm-offset-3 form-box">
                            <div class="form-bottom"> 
                            @if (count($errors) > 0)
                                <div class="alert alert-danger">
                                    <ul>
                                        @foreach ($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            @endif                                

                                {!! Form::open(array('action' => 'StoreDatabase@Store')) !!}
                                <div class="alert alert-info">
                                    Hello, <strong>{{ $name }}</strong> <br>
                                    Email: <strong>{{ $email }}</strong> 
                                    {!! Form::hidden('Email', $email)!!}
                                </div>
                                    <div class="form-group">
                                        {!! Form::label('Fullname', 'Full-name on Student Card', array('class' => 'sr-only')) !!}
                                        {!! Form::text('Fullname', '', array('class' => 'form-control', 'placeholder' => 'Full-name on Student Card', 'required' => 'required'))!!}
                                    </div>

                                    <div class="form-group">
                                        {!! Form::label('StudentID', 'Student ID', array('class' => 'sr-only')) !!}
                                        {!! Form::text('StudentID', '', array('class' => 'form-control', 'placeholder' => 'Student ID', 'required' => 'required'))!!}
                                    </div>

                                    <div class="form-group">
                                        {!! Form::label('University', 'University', array('class' => 'sr-only')) !!}
                                        {!! Form::text('University', '', array('class' => 'form-control', 'placeholder' => 'University', 'required' => 'required','maxlength' => '100'))!!}
                                    </div>

                                    <div class="form-group">
                                        {!! Form::label('Shortname', 'Short-name of University (Ex: VGU, FTU, RMIT,…)', array('class' => 'sr-only')) !!}
                                        {!! Form::text('Shortname', '', array('class' => 'form-control', 'placeholder' => 'Short-name of University (Ex: VGU, FTU, RMIT,…)', 'required' => 'required', 'maxlength' => '10'))!!}
                                    </div>

                                    <div class="form-group">
                                        {!! Form::label('Class', 'Class', array('class' => 'sr-only')) !!}
                                        {!! Form::text('Class', '', array('class' => 'form-control', 'placeholder' => 'Class', 'required' => 'required'))!!}
                                    </div>

                                    <div class="form-group">
                                        {!! Form::label('LinkStudentID', 'Link to Student Card photo', array('class' => 'sr-only')) !!}
                                        {!! Form::url('LinkStudentID', '', array('class' => 'form-control', 'placeholder' => 'Link to Student Card photo', 'required' => 'required'))!!}
                                    </div>

                                    <button type="submit" class="btn">Save it!</button>    
                                {!! Form::close() !!}
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