<!DOCTYPE html>
<html>
<head>
	<title>Test email</title>
</head>
<body>
    <p>Bonjour {{ $details['prenom']  }} {{ $details['nom'] }};</p>
    <p>Nous vous remercions d'avoir fait confiance à notre société et nous vous souhaitons un bon séjour 
            dans votre nouvelle location. Pour suivre l'état de vos paiements, un compte d'accès à notre plateforme. http://gesimmoapp.000webhostapp.com/
    Vous a été crée.
    <br>
    Login : <u><b>{{ $details['title'] }} </b></u></p> 
    Mot de passe : <u><b>{{ $details['body'] }} </b></u></p>
    <p>Sincères salutations</p>
    <p>L'équipe GESIMMO </p>
    <p>Merci</p>
</body>
</html>
