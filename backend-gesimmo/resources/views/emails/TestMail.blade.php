<!DOCTYPE html>
<html>
<head>
	<title>Test email</title>
</head>
<body>
    <p>Bonjour : {{ $details['prenom']  }} {{ $details['nom'] }}</p>
    <p>Votre Compte sur GESIMMO a été crée avec succés . Vous pouvez vous connecter
         avec le mot de passe suivant <u><b>{{ $details['body'] }} </b></u></p>
    <p>From GESIMMO </p>
    <p>Merci</p>
</body>
</html>
