<!DOCTYPE html>
<html>
<head>
    <title>Gesimmo</title>
</head>
<body>
    <h1>Bonjour {{ $details['nom'] }}</h1>
    <p>Suite à votre demande de réinitialisation de mot de passe. Vous trouverez ci-dessous votre nouveau mot de passe: <br>
    <p>Mot de passe : </p><u><b>{{ $details['pass'] }}</b></u></p>
    <br>
    <p>NB : <i>Nous vous recomandons de modifier votre mot de passe apres connexion en allant sur Mon Profil > Changer mon mot de passe </i></p>
    <br>
    <p>Sincères salutations</p>
    <br>
    <p>L'equipe GesimmoApp</p>
    <br>
    <p><b>Ce mail a été généré autmatiquement, Veuillez ne pas y répondre </b></p>
    <br>
   
</body>
</html>