## Espace membre

Cette partie permet de récupérer et afficher les informations relatives a l'utilisateur connecté.
Pour cela on utilise le champ email retourné via la méthode wp_get_current_user() :

```
    $user  = wp_get_current_user();
    $email = false;
    if ($user && $user->ID) {
        $email = $user->user_email;
    }
    return $email;
```

Si il n'eexiste pas de membre avec l'email indiqué un 404 est retourné.
Si il existe plus d'un membre avec cet email c'est un 412 qui sera retourné.
Dans ces deux cas un formulaire de contact pourra être adressé à un contact. Ce formulaire pourra être complété par les informations suiavntes afin de facilter le rapprochament ou la création d'un membre :

* Nom
* Prénom
* Adresse
* Pays
* Adresse email

### tags disponibles

Il existe un tag général qui gère via des onglets l'ensemble des informations. Mais il existe aussi un tag par information disponible :

* FreeAsso_Member_Tabs : Gestion d'onglets avec toutes les informations ci-dessous
* FreeAsso_Member_Infos : Les coordonnées du membre (email non modifiable)
* FreeAsso_Member_Receipts : Les reçus
* FreeAsso_Member_Certificates : Les certificats
* FreeAsso_Member_Gibbons : Les Gibbons parrainés
* FreeAsso_Member_Sponsorships : Les parrainages
* FreeAsso_Member_Donations : Les dons

### Enregistrement

Les informations peuvent être modifiées, excepté l'email.
Pour modifier l'email il existe la méthode updateMemberEmail sur la classe Freeasso_Api_Member