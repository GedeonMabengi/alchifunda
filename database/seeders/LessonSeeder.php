<?php
// database/seeders/LessonSeeder.php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class LessonSeeder extends Seeder
{
    public function run(): void
    {
        $lessons = [
            // Leçons du chapitre "La Matière et ses États"
            [
                'id' => 1,
                'chapter_id' => 1,
                'title' => 'Qu\'est-ce que la Matière ?',
                'slug' => 'qu-est-ce-que-la-matiere',
                'introduction' => 'Bienvenue dans cette première leçon ! Nous allons découvrir ensemble ce qu\'est la matière, un concept fondamental en chimie. Tout ce qui nous entoure est fait de matière : l\'eau du fleuve Congo, l\'air que nous respirons, les métaux de nos téléphones...',
                'content' => 'La matière est tout ce qui a une masse et occupe un espace (volume). Elle est constituée de particules microscopiques appelées atomes et molécules.

## Propriétés de la matière

La matière possède deux types de propriétés :

Les propriétés physiques sont observables sans modifier la nature de la substance. Par exemple, la couleur, l\'odeur, la densité, le point de fusion et le point d\'ébullition sont des propriétés physiques. L\'eau bout à 100°C et gèle à 0°C sous pression atmosphérique normale.

Les propriétés chimiques décrivent la capacité d\'une substance à se transformer en une autre. Par exemple, le fer peut rouiller en présence d\'oxygène et d\'humidité, formant de l\'oxyde de fer. Le bois peut brûler pour produire du dioxyde de carbone et de la cendre.

## La masse et le volume

La masse mesure la quantité de matière dans un objet. Elle se mesure en kilogrammes (kg) ou en grammes (g). La masse reste constante peu importe où se trouve l\'objet.

Le volume mesure l\'espace occupé par la matière. Il se mesure en mètres cubes (m³) ou en litres (L). Pour les solides réguliers, on peut calculer le volume avec des formules géométriques. Pour les liquides et les solides irréguliers, on utilise des instruments de mesure comme l\'éprouvette graduée.

## Exemples au Congo

Considérons quelques exemples de matière présents dans notre environnement quotidien au Congo. Le manioc contient de l\'amidon, une matière organique essentielle pour notre alimentation. Le cuivre extrait des mines du Katanga est une matière métallique utilisée dans l\'industrie électrique mondiale. L\'eau du fleuve Congo est de la matière à l\'état liquide qui soutient tout un écosystème.',
                'math_demonstrations' => json_encode([
                    [
                        'title' => 'Calcul de la densité',
                        'formula' => 'ρ = m / V',
                        'explanation' => 'La densité (ρ) est le rapport entre la masse (m) et le volume (V)',
                        'example' => 'Si un bloc de cuivre a une masse de 89,6 g et un volume de 10 cm³, sa densité est : ρ = 89,6 g / 10 cm³ = 8,96 g/cm³'
                    ]
                ]),
                'practical_examples' => json_encode([
                    'L\'huile de palme flotte sur l\'eau car sa densité est inférieure à celle de l\'eau',
                    'Le fer coule dans l\'eau car sa densité est supérieure à celle de l\'eau',
                    'L\'or est très dense, c\'est pourquoi il est si lourd pour sa taille'
                ]),
                'summary' => 'La matière est tout ce qui possède une masse et occupe un volume. Elle possède des propriétés physiques (observables) et chimiques (transformation). La densité est une propriété importante qui relie la masse au volume.',
                'keywords' => json_encode(['matière', 'masse', 'volume', 'densité', 'propriétés physiques', 'propriétés chimiques']),
                'order' => 1,
                'estimated_duration_minutes' => 30,
                'difficulty' => 'easy',
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => 2,
                'chapter_id' => 1,
                'title' => 'Les Trois États de la Matière',
                'slug' => 'les-trois-etats-de-la-matiere',
                'introduction' => 'Dans cette leçon, nous allons explorer les trois états dans lesquels la matière peut exister. Pensez à l\'eau : elle peut être liquide dans votre verre, solide sous forme de glace, ou gazeuse sous forme de vapeur. Comprendre ces états est essentiel pour saisir le comportement de la matière.',
                'content' => 'La matière existe sous trois états principaux : solide, liquide et gazeux. Chaque état a des propriétés distinctes qui dépendent de l\'arrangement et du mouvement des particules.

## L\'état solide

Dans un solide, les particules sont très rapprochées et organisées de façon régulière. Elles vibrent sur place mais ne peuvent pas se déplacer librement. C\'est pourquoi les solides ont une forme propre et un volume défini.

Les caractéristiques de l\'état solide incluent une forme fixe qui ne dépend pas du récipient, un volume constant, une incompressibilité pratique, et une densité généralement élevée.

Exemples au Congo : le diamant extrait du Kasaï, le sel de cuisine, les minerais de coltan.

## L\'état liquide

Dans un liquide, les particules sont proches mais peuvent glisser les unes sur les autres. Elles sont moins ordonnées que dans un solide.

Les liquides n\'ont pas de forme propre et prennent la forme de leur récipient. Ils ont un volume défini et constant, sont pratiquement incompressibles, et peuvent s\'écouler.

Exemples au Congo : l\'eau du fleuve Congo, l\'huile de palme, le pétrole brut.

## L\'état gazeux

Dans un gaz, les particules sont très éloignées les unes des autres et se déplacent très rapidement dans toutes les directions. Il y a très peu d\'interactions entre elles.

Les gaz n\'ont ni forme propre ni volume propre : ils occupent tout l\'espace disponible. Ils sont très compressibles et ont une densité faible.

Exemples au Congo : l\'air que nous respirons, le gaz méthane du lac Kivu, la vapeur d\'eau dans l\'atmosphère équatoriale.

## Comparaison des trois états

Pour comparer les trois états, considérons l\'eau comme exemple universel. À l\'état solide (glace), les molécules d\'eau sont fixes et ordonnées, la glace a une forme et un volume définis. À l\'état liquide (eau), les molécules peuvent bouger mais restent proches, l\'eau prend la forme de son contenant tout en gardant son volume. À l\'état gazeux (vapeur), les molécules sont libres et éloignées, la vapeur remplit tout l\'espace disponible.',
                'math_demonstrations' => json_encode([
                    [
                        'title' => 'Comparaison des volumes',
                        'formula' => 'V_gaz >> V_liquide ≈ V_solide',
                        'explanation' => 'Un même nombre de molécules occupe un volume beaucoup plus grand à l\'état gazeux',
                        'example' => '1 L d\'eau liquide produit environ 1700 L de vapeur d\'eau à 100°C et pression atmosphérique'
                    ]
                ]),
                'practical_examples' => json_encode([
                    'La rosée du matin : la vapeur d\'eau de l\'air se condense en gouttelettes sur les feuilles',
                    'Les glaçons dans une boisson : le solide fond pour devenir liquide',
                    'L\'eau qui bout dans une marmite : le liquide se transforme en vapeur'
                ]),
                'summary' => 'La matière existe sous trois états : solide (forme et volume fixes), liquide (volume fixe, forme variable) et gazeux (ni forme ni volume fixes). Ces états dépendent de l\'arrangement et de l\'énergie des particules.',
                'keywords' => json_encode(['état solide', 'état liquide', 'état gazeux', 'particules', 'arrangement moléculaire']),
                'order' => 2,
                'estimated_duration_minutes' => 35,
                'difficulty' => 'easy',
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            // Leçons du chapitre "L'Atome et sa Structure"
            [
                'id' => 3,
                'chapter_id' => 2,
                'title' => 'Histoire de la Découverte de l\'Atome',
                'slug' => 'histoire-decouverte-atome',
                'introduction' => 'Comment les scientifiques ont-ils découvert que toute la matière est faite de minuscules particules appelées atomes ? Cette leçon retrace les grandes étapes de cette découverte fascinante, depuis la Grèce antique jusqu\'à nos jours.',
                'content' => 'L\'idée que la matière est constituée de petites particules indivisibles est très ancienne. Découvrons comment cette idée a évolué au fil des siècles.

## Les philosophes grecs (5ème siècle avant J.-C.)

Démocrite, un philosophe grec, a proposé que toute matière est composée de particules minuscules et indivisibles qu\'il a appelées "atomos" (du grec "a-tomos" signifiant "qu\'on ne peut couper"). Pour lui, ces atomes étaient solides, éternels et se différenciaient par leur forme et leur taille.

Cependant, cette théorie est restée philosophique car Démocrite n\'avait aucun moyen de prouver expérimentalement ses idées.

## John Dalton et le modèle atomique moderne (1803)

Le scientifique anglais John Dalton a développé la première théorie atomique basée sur des expériences scientifiques. Selon lui, chaque élément est composé d\'atomes identiques entre eux. Les atomes de différents éléments ont des masses différentes. Les atomes ne peuvent être ni créés, ni détruits, ni divisés. Les réactions chimiques réarrangent les atomes mais ne les modifient pas.

La théorie de Dalton a permis d\'expliquer les lois de la conservation de la masse et des proportions définies.

## J.J. Thomson et l\'électron (1897)

Le physicien britannique Joseph John Thomson a découvert l\'électron, une particule négative présente dans tous les atomes. Il a proposé le modèle du "pudding aux prunes" : l\'atome serait une sphère positive dans laquelle les électrons négatifs sont dispersés comme des prunes dans un pudding.

Cette découverte a montré que l\'atome n\'était pas indivisible comme le pensait Démocrite.

## Ernest Rutherford et le noyau atomique (1911)

Rutherford a réalisé une expérience célèbre en bombardant une fine feuille d\'or avec des particules alpha. Il a découvert que l\'atome est surtout constitué de vide, que presque toute la masse est concentrée dans un noyau central positif très petit, et que les électrons gravitent autour du noyau.

## Le modèle actuel de l\'atome

Aujourd\'hui, nous savons que l\'atome est constitué d\'un noyau contenant des protons (positifs) et des neutrons (neutres), entouré d\'électrons (négatifs) qui se déplacent dans des zones appelées orbitales.',
                'math_demonstrations' => null,
                'practical_examples' => json_encode([
                    'L\'or est un élément chimique : tous les atomes d\'or sont identiques',
                    'L\'eau est un composé : chaque molécule contient 2 atomes d\'hydrogène et 1 atome d\'oxygène',
                    'Lors de la digestion, les molécules des aliments sont réarrangées mais les atomes restent intacts'
                ]),
                'summary' => 'La théorie atomique a évolué de Démocrite (atome indivisible) à Dalton (théorie scientifique) puis Thomson (découverte de l\'électron) et Rutherford (découverte du noyau). L\'atome est constitué d\'un noyau (protons et neutrons) entouré d\'électrons.',
                'keywords' => json_encode(['atome', 'Démocrite', 'Dalton', 'Thomson', 'Rutherford', 'électron', 'noyau']),
                'order' => 1,
                'estimated_duration_minutes' => 40,
                'difficulty' => 'medium',
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => 4,
                'chapter_id' => 2,
                'title' => 'La Structure de l\'Atome',
                'slug' => 'structure-de-l-atome',
                'introduction' => 'Maintenant que nous connaissons l\'histoire de la découverte de l\'atome, plongeons au cœur de sa structure. Quelles sont les particules qui le composent ? Comment sont-elles organisées ? Découvrons ensemble l\'architecture fascinante de l\'atome.',
                'content' => 'L\'atome est constitué de deux parties principales : le noyau central et le nuage électronique qui l\'entoure.

## Le noyau atomique

Le noyau est situé au centre de l\'atome. Il est extrêmement petit par rapport à la taille totale de l\'atome, mais contient presque toute sa masse.

Le noyau contient deux types de particules appelées nucléons. Les protons sont des particules de charge positive (+). Chaque proton porte une charge de +1. Le nombre de protons définit l\'élément chimique et s\'appelle le numéro atomique (Z). Les neutrons sont des particules sans charge (neutres). Ils contribuent à la masse de l\'atome et à la stabilité du noyau.

Le nombre de masse (A) est la somme des protons et des neutrons dans le noyau.

## Les électrons

Les électrons sont des particules de charge négative (-) qui se déplacent autour du noyau dans des régions appelées orbitales ou couches électroniques. Chaque électron porte une charge de -1. La masse d\'un électron est environ 1836 fois plus petite que celle d\'un proton.

Dans un atome neutre, le nombre d\'électrons est égal au nombre de protons.

## Notation atomique

On représente un atome par son symbole chimique accompagné de deux nombres : le numéro atomique Z en bas à gauche et le nombre de masse A en haut à gauche.

Par exemple, pour le carbone-12, on écrit le symbole C avec A=12 et Z=6. Cela signifie que cet atome possède 6 protons (Z=6), 6 neutrons (A-Z = 12-6 = 6), et 6 électrons (car l\'atome est neutre).

## Dimensions de l\'atome

Pour mieux comprendre les dimensions de l\'atome, imaginons une analogie. Si le noyau était de la taille d\'une bille (1 cm), l\'atome entier aurait la taille d\'un stade de football (100 m). Le reste est essentiellement du vide !

Le diamètre du noyau est d\'environ 10⁻¹⁵ m tandis que le diamètre de l\'atome est d\'environ 10⁻¹⁰ m. Le noyau est donc 100 000 fois plus petit que l\'atome lui-même.

## Les isotopes

Les isotopes sont des atomes d\'un même élément qui ont le même nombre de protons mais un nombre différent de neutrons.

Exemple : Le carbone a trois isotopes naturels. Le carbone-12 a 6 protons et 6 neutrons (stable, le plus abondant). Le carbone-13 a 6 protons et 7 neutrons (stable, utilisé en spectroscopie). Le carbone-14 a 6 protons et 8 neutrons (radioactif, utilisé pour la datation).',
                'math_demonstrations' => json_encode([
                    [
                        'title' => 'Calcul du nombre de neutrons',
                        'formula' => 'N = A - Z',
                        'explanation' => 'Le nombre de neutrons (N) égale le nombre de masse (A) moins le numéro atomique (Z)',
                        'example' => 'Pour l\'oxygène-18 : A = 18, Z = 8, donc N = 18 - 8 = 10 neutrons'
                    ],
                    [
                        'title' => 'Masse atomique approximative',
                        'formula' => 'm ≈ A × 1,66 × 10⁻²⁷ kg',
                        'explanation' => 'La masse d\'un atome est approximativement égale au nombre de masse multiplié par la masse d\'un nucléon',
                        'example' => 'Pour le carbone-12 : m ≈ 12 × 1,66 × 10⁻²⁷ = 1,99 × 10⁻²⁶ kg'
                    ]
                ]),
                'practical_examples' => json_encode([
                    'Le cobalt-60 (isotope radioactif) est utilisé en médecine pour traiter certains cancers',
                    'L\'uranium-235 (isotope fissile) est utilisé comme combustible nucléaire',
                    'Le carbone-14 permet de dater des objets anciens comme les fossiles'
                ]),
                'summary' => 'L\'atome est constitué d\'un noyau (protons + neutrons) et d\'électrons. Le numéro atomique (Z) = nombre de protons. Le nombre de masse (A) = protons + neutrons. Les isotopes sont des atomes d\'un même élément avec des nombres de neutrons différents.',
                'keywords' => json_encode(['noyau', 'proton', 'neutron', 'électron', 'numéro atomique', 'nombre de masse', 'isotope']),
                'order' => 2,
                'estimated_duration_minutes' => 45,
                'difficulty' => 'medium',
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ];

        DB::table('lessons')->insert($lessons);
    }
}