<?php
    if (empty($Dates)) $Dates = array();
    if (empty($users)) $users = array();
    if (empty($dateID)) $dateID = '';

?>

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

    <style>
        table {
            text-align: center;
            font-size: 25px;
            color: white;
            vertical-align: middle;
        }
        th {
           text-align: center;
        }
        select, option {
            color: black;
        }
        .RED {
            color: red;
        }
        .GREEN {
            color: green;
        }

        .button {
            margin: 20px;
        }
        html, body {
            background: black;
        }
    </style>

    <script>
        function moveHere()
        {
            var tagSelect = document.getElementById('chooseDate');
            var Link = tagSelect.options[tagSelect.selectedIndex].text;
            var tagBut = document.getElementById('butMove');
            tagBut.href = "{{ url('/') }}/Manage/Processed/" + Link;
        }

        function exportExcel()
        {
            var tagTable = document.getElementById('DataTable');
            window.open('data:application/vnd.ms-excel; charset=UTF-8,' + tagTable.innerHTML);
        }
        function scrollToTop()
        {
            $(window).on('beforeunload', function() {
                $(window).scrollTop(0);
            });
        }

    </script>
</head>

<body>

<!-- Top content -->
<div class="top-content">
    <div class="inner-bg">
        <div class="container">
            <div class="row">
                <div class="col-sm-8 col-sm-offset-2 text">
                    <h1>
                        Admin Portal For MSP Management
                    </h1>
                    <p>
                        If you have any problems, please contact: <br>
                        Mr. DucLTM - CM HCM Team - Duc.LaiTrunMinh@studentpartner.com <br>
                        Mr. Bach Tri - MSP Lead HCMC - v-TriBT@microsoft.com <br>
                    </p>
                    <h1>
                        You are at date: {{$dateID}}
                    </h1>
                    <br>
                        <select id="chooseDate" name="chooseDate" class="form-control">
                            @forelse($Dates as $DateID)
                                <option value="{{$DateID['RowKey']}}">{{$DateID['RowKey']}}</option>
                            @empty
                            @endforelse
                        </select>
                        <a href="" id="butMove" onclick="moveHere();" class="btn btn-success button">Move here</a>
                        <input type="button" id="butExport" value="Export Excel" class="btn btn-info button pull-right"/>
                        <a href="{{url('/')}}/Manage/InProgress" class="btn btn-default button pull-right ">In Progress</a>
                </div>
            </div>
            <div class="row" id="DataTable">
                <table class="table">
                    <thead>
                        <tr>
                            <th>No.</th>
                            <th>Full name</th>
                            <th>University</th>
                            <th>Roll No.</th>
                            <th>Email</th>
                            <th>Status</th>
                        </tr>
                    </thead>

                    <tbody>
                        <?php $i = 1 ?>
                        @forelse ($users as $user)
                            <tr>
                                <td>{{$i++}}</td>
                                <td>{{$user['Fullname']}}</td>
                                <td>
                                    @if (array_key_exists('Shortname', $user))
                                        {{$user['Shortname']}}
                                    @endif
                                </td>
                                <td><a href="{{$user['LinkStudentID']}}">{{$user['StudentID']}}</a></td>
                                <td width="30%">{{$user['Email']}}</td>
                                <td>{{$user['Status']}}</td>
                            </tr>
                        @empty
                            <p>No users</p>
                        @endforelse
                        {!! Form::close() !!}
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>


<!-- Javascript -->
<script src="{{ url('/') }}/assets/js/jquery-1.11.1.min.js"></script>
<script src="{{ url('/') }}/assets/bootstrap/js/bootstrap.min.js"></script>
<script src="{{ url('/') }}/assets/js/jquery.backstretch.min.js"></script>
<script src="{{ url('/') }}/assets/js/jquery.table2excel.min.js"></script>
<script src="{{ url('/') }}/assets/js/scripts.js"></script>

<script>
    $(document).ready(function(){
        $('#butExport').click(function(){
            $('#DataTable').table2excel({
                name: "{{$dateID}}",
                filename: "{{$dateID}}"
            });
        })
    });
</script>

<!--[if lt IE 10]>
<script src="{{ url('/') }}.assets/js/placeholder.js"></script>
<![endif]-->

</body>

</html>