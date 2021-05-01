<!DOCTYPE html>
<html>
<head>
    <title>Gesimmo</title>
</head>
<body>
    <h1>Bonjour {{ $details['nom'] }}</h1>
    <p>Suite à votre demande de réientialisation de mot de passe. Vous trouverez ci_dessous votre nouveau mot de passe: <br>
    <p>Mot de passe : </p><u><b>{{ $details['pass'] }}</b></u></p>
    <br>
    <p>NB : <i>Nous vous recomandons de modifier votre mot de passe apres connexion en allant sur Mon Prfile > Changer mon mot de passe </i></p>
    <br>
    <p>L'equipe GesimmoApp</p>
    <br>
    <p><b>Ce mail a été généré autmatiquement, Veuillez ne pas répondre </b></p>
    <br>
   
</body>
</html>