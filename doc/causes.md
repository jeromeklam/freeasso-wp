## Causes

Cela ne concerne que les programmes de type "Animaux".
Une extension sera apportée pour récupérer les autres causes (forêt)

Le but ici est de mettre à disposition plusieurs APIs permettant déjà de récupérer une liste de valeurs pouvant servir de filtre pour au final retourner une liste paginée d'animaux à parrainer.

### Insertion

Une vue de recherche est en cours de réalisation.

```php
<?php do_shortcode('[FreeAsso_Causes]', '00'); ?>
```

La classe Freeasso_Causes_Search avec la vue cause_search sont un bon exemple.

### Filtres

#### Les genres

Les genres ne sont pas récupérés de l'administration mais sont en dur dans la classe.
Ils seront boentôt disponible via l'API.

```
$myApi = Freeasso_Api_Genders::getFactory();
$myApi->getGenders();
```

Retourne un tableau d'objets :

* id : identifiant principal
* label : le libellé du genre

#### Les sites

Les sites sont à récupérer de l'administration.

```
$myApi = Freeasso_Api_Sites::getFactory();
$myApi->getSites();
```

Retourne un tableau d'objets :

* id : identifiant principal
* code : code pour les traductions
* label : le nom du site

#### Les espèces

Les espèces sont à récupérer de l'administration.
Il existe les espèces détaillées et simplifiées. Pour simplifier la compréhension le nom commmun à privilégier.
La recherche s'effectuera toujours sur l'espère détaillée, un filtre de type OPER_IN sera alors nécessaire.

```
$myApi = Freeasso_Api_Species::getFactory();
$myApi->getMainSpecies();
```

Retourne un tableau d'objets :

* id : identifiant principal
* code : code pour les traductions
* label : le nom de l'espèce simplifié
* all : un tableau des Ids des espèces détaillées pour la recherche

#### Personnaliser les filtres

Les api ont des filtres par défaut que l'on ne peut pas retirer, en fonction de la version de l'administration.

Il existe aussi la possibilité de rajouter des filtres personnalisés, saisis par exemple depuis un formulaire.

```php
    /**
     * Add filter
     *
     * @param string $p_name
     * @param mixed  $p_value
     * @param string $p_oper
     * @param mixed  $p_other
     *
     * @return Freeasso_Api_Base
     */
    public function addSimpleFilter($p_name, $p_value, $p_oper = self::OPER_EQUAL, $p_other = null)
```

```php
    $myCausesApi->addSimpleFilter('cau_sex', $gender);
```

Liste des principaux opérateurs disponibles, (liste complète dans la classe Freeasso_Api_Base) :

* Freeasso_Api_Base::OPER_EQUAL : égalité stricte
* Freeasso_Api_Base::OPER_IN : dans une liste de valeurs
* Freeasso_Api_Base::OPER_LOWER : plus petit
* Freeasso_Api_Base::OPER_LOWER_EQUAL : plus petit ou égal
* Freeasso_Api_Base::OPER_GREATER : plus grand
* Freeasso_Api_Base::OPER_GREATER_EQUAL : plus grand ou égal

#### Pagination

```php
/**
 * Set pagination
 *
 * @param number $p_page
 * @param number $p_len
 *
 * @return Freeasso_Api_Base
 */
public function setPagination($p_page=1, $p_len=16)
{
    $this->page       = $p_page;
    $this->page_size  = $p_len;
    return $this;
}
```

On peut ainsi spécifier la page et le nombre par page.
L'API retourne le nombre total de résultat de la requête afin de pouvoir paginer le retour.

#### Avec identifiant

Il existe la possibilité de récupérer une seule cause.

```php
/**
 * Set id
 *
 * @param string $p_id
 *
 * @return Freeasso_Api_Base
 */
public function setId($p_id)
{
    $this->id = $p_id;
    return $this;
}
```

Dans ce cas les autres filtres non fixes seront ignorés.

#### Rechercher

```php
$myCausesApi = FreeAsso_Api_Causes::getFactory();
$myCausesApi->setPagination(1, 16);
$myCausesApi->addSimpleFilter('cau_sex', 'M');
// Lance la recherche et retourne un tableau de résultat
$causes = $myCausesApi->getCauses();
// On récupère le nombre total de résultat (pour gérer la pagination)
$total_causes = $myCausesApi->getTotalCauses();
```

#### Champs disponibles

Pour chaque cause voici la description de l'objet retourné :

* id : identifiant de l'animal
* code : non utilisé pour l'instant
* name : nom de l'animal
* gender : sexe de l'animal
* born : année de naissance
* site : le nom du site (île)
* desc : description complète
* photo1 : photo principale de l'animal
* photo2 : photo alternative
* sponsors : liste des parrains, séparés par une virgule
* species : libellé de l'espère
* raised : montant récolté
* left : montant restant à récolter
