<html>
<head>
	<title>Data User</title>
</head>
<body>
 
<h1>Data Pengguna</h1>
<h3>www.malasngoding.com</h3>
 
<ul>
	@foreach($user as $p)
		<li>{{ "Username: ". $p->username . ' | Password : ' . $p->password }}</li>
	@endforeach
</ul>
 
</body>
</html>