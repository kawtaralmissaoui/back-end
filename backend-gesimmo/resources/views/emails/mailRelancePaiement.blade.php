<!DOCTYPE html>
<html>
<head>
    <title>Gesimmo</title>
</head>
<body>
    <h1>Bonjour {{ $details['nom'] }}</h1>
    <p>A ce jour et sauf erreur de notre part, on vous rappelle que nous n'avons toujours pas réceptionné votre paiement numero {{ $details['id'] }} pour le loyer s'élevant à {{ $details['montant'] }} dh <br>
    <p>Je vous remercie de bien vouloir procéder au règlement de cette dernière dans les plus brefs délais et je vous transmets, à cette fin</p>
    <br>
    <p>L'equipe GesimmoApp</p>
    <br>
    <p><b>Ce mail a été généré autmatiquement, Veuillez ne pas répondre </b></p>
    <br>
   
</body>
</html>