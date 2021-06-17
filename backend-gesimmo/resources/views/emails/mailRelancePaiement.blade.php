<!DOCTYPE html>
<html>
<head>
    <title>Gesimmo</title>
</head>
<body>
    <h1>Bonjour {{ $details['nom'] }}</h1>
    <p>A ce jour et sauf erreur de notre part, nous vous rappellons que nous n'avons toujours pas réceptionné votre paiement numero {{ $details['id'] }} pour le loyer s'élevant à {{ $details['montant'] }} dh <br>
    <p>nous vous remercions de bien vouloir procéder au règlement de cette dernière dans les plus brefs délais.</p>
    <br>
    <p>Sincères salutations</p>
    <br>
    <p>L'equipe GesimmoApp</p>
    <br>
    <p><b>Ce mail a été généré autmatiquement, Veuillez ne pas y répondre </b></p>
    <br>
   
</body>
</html>