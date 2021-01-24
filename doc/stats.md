## Statistiques

* Le nombre d'amis (membres effectuant des dons réguliers, tous programmes confondus),
* Des variables saisies directement dans l'administration :
    * Le nombre d'hectares de forêt protégés
    * Le nombre d'animaux protégés

### Description

La classe permettant de gérer ces statistiques est Freeasso_Api_Stats.
C'est un singleton qui n'effectue qu'un seul appel et au moment d'un get uniquemet.
De plus, toutes les statiqtiques sont récuprées en une seule fois.

Utilisation:

```PHP
$myApi = Freeasso_Api_Stats::getFactory();
$myApi->getAmis();
$myApi->getGibbons();
$myApi->getHectares();
```

### Intégration d'une donnée dans une page

#### Insérer une donnée via un Widget

Le plus imple mais le moins paramétrable, il suffit de choisir parmis les Widget FreeAsso.

#### Insérer une donnée via un shortcode

```
   <?php echo do_shortcode('[FreeAsso_Amis]', '---'); ?>
```

* FreeAsso_Amis
* FreeAsso_Gibbons
* FreeAsso_Hectares

#### Insérer une donnée issue des statistiques directement dans le template

Il est possible d'ajouter une information directement dans le template, via du code PHP

```
    ...
    <?php $freeassoStats = Freeasso_Api_Stats::getFactory();?>
    ...
    <p>Kalaweit a déjà <?php echo $freeassoStats->getAmis(); ?> amis;<p>
    ...
```

* getAmis
* getGibbons
* getHectares

Par défaut ces méthodes retournent le résultat formaté. Pour avoir la valeur brute, il faut passer "false" en paramètre.

#### Insérer une donnée issue des statistiques via une substitution

Il est également possible d'utiliser une chaine de remplacement à placer dans le contenu. Il suffit ensuite d'appeler un hook sur le bon élément.

```
    add_filter('the_content', ['Freeasso', 'filterStats']);
```

Il faut suivre le pattern de remplacement ci-dessous :

```
[[:FreeAsso_Amis:]]
```

* FreeAsso_Amis
* FreeAsso_Gibbons
* FreeAsso_Hectares
