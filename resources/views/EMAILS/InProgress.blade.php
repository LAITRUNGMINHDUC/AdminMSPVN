<!DOCTYPE html>
<html>
<head>
	<title></title>
	<meta charset="utf-8"/>
</head>
<body>
	<p>
	<h1>Link Confirm: <a href="https://admin-mspvietnam.azurewebsites.net/">Admin Portal</a></p>
	<table border="1">
		<thead>
			<th>STT</th>
			<th>Email</th>
			<th>Họ Tên</th>
			<th>Trường</th>
		</thead>
		<tbody>		
			<?php $i=1; ?>	
			@forelse ($Data as $User)
				<tr>
					<td>{{$i++}}</td>
					<td>{{$User['Email']}}</td>
					<td>{{$User['Fullname']}}</td>
					<td>{{$User['University']}}</td>
				</tr>
			@empty
				<p>Hơm có ai hết</p>
			@endforelse			
		</tbody>
	</table>
</body>
</html>