<p align="center"><h1>POURPRE</h1></p>  

<h2>SOMMAIRE</h2>  
I. Zones et fonctionnalités

- Zone publique
- Zone client  
- Zone gestion 
- Zone logistique  
- Zone administration
   
II. Contraintes techniques 
- Technologies utilisées 
- Éléments externes
- Obligations de réalisation
 
III. Fonctionnalités bonus

<h2>Zones et fonctionnalités</h2> 

Votre projet sera une application web reprenant l'idée de Airbnb pour une entreprise familiale haut de gamme. <br>
De ce fait, vous aurez besoin de plusieurs zones, en fonction du profil
de l'utilisateur·ice, avec chacune différentes fonctionnalités associées.
Pour la suite de cette explication, "les internes" fera référence aux membres de
l'entreprise (du client vous demandant ce projet) et "les externes" fera référence au
grand public. Seul·e·s les internes seront capables d'obtenir les rôles gestion,
entretien et admin.<br>
Les utilisateur·ice·s pourront créer un compte utilisateur qui sera associé à un ou
plusieurs rôles ; chaque rôle donne accès à une zone de l'application. Les nouveaux
comptes auront par défaut le rôle client ; ce rôle ne peut pas être retiré d'un compte.<br>
Les internes pouvant eux-mêmes être amenés à faire des réservations, ils devront
avoir accès à l'ensemble des fonctionnalités des utilisateur·ice·s externes.<br>
Le rôle admin doit permettre d'accéder à l'ensemble des fonctionnalités.<br>
Le projet n'intègre pas de partie "paiement". Dans le contexte de ce projet, il est
considéré que le paiement est fait "sur place" (au logement) et ne fait donc pas partie
de vos prérogatives.<br>

<strong>Zone publique</strong><br>
La zone publique permet de retrouver l'ensemble des logements à disposition sur votre outil.<br>
Cette zone est accessible en public sur le web, sans avoir à créer de compte ni avoir de rôle affecté. Seule la réservation de logement nécessitera d'être connecté avec un compte ayant le rôle client lors de l'utilisation de cette zone.

__Les fonctionnalités de la zone publique sont :__

- L'affichage des différents logements à disposition
- L'affichage du détail d'un logement : nom, position, nombre de places, prestations
- incluses, prix, disponibilités, avis, photos, etc.
- La recherche de logements par localisation, par nombre de places et par
disponibilité
- La possibilité de choisir des dates pour un logement afin de vérifier sa
disponibilité
- La réservation de logements (à condition d'être connecté)
- La création d'un compte client
- La connexion au compte client

<h2>Zone client</h2>
La zone client permet à un·e utilisateur·ice d'accéder à l'ensemble de ses réservations.<br>  
L'accès à cette zone nécessite le rôle client.  

__Les fonctionnalités de la zone client sont :__

- L'affichage des réservations passées, présentes et futures
- L'affichage du détail de chaque réservation
- Un système de messagerie associé à chaque réservation, pour communiquer avec l'équipe interne au sujet d'une réservation
- L'annulation d'une réservation future
- L'ajout d'un avis sur des réservations passées
- La modification de ses informations personnelles

<h2>Zone gestion</h2>
La zone gestion permet à un·e utilisateur·ice d'administrer les logements et de communiquer des informations à l'équipe entretien.   
L'accès à cette zone nécessite le rôle gestion.

__Les fonctionnalités de la zone gestion sont :__

- L'affichage et la recherche des logements
- L'accès au détail des réservations de chaque logement
- Le système de messagerie sur chaque réservation
- La possibilité d'annuler des réservations
- La modération des avis
- La gestion des disponibilités des logements
- L'ajout / modification / suppression de logements
- L'ajout de notes d'information sur une action d'entretien

<h2>Zone logistique</h2>
La zone logistique permet à un·e utilisateur·ice d'obtenir des informations sur les actions à mener sur les logements pour leur entretien.  
L'accès à cette zone nécessite le rôle entretien.<br>
Lors de la réservation d'un logement, une action d'entretien est automatiquement créée.

__Les fonctionnalités de la zone entretien sont :__
- La liste des actions d'entretiens prévus par jour
- Le détail de chaque action d'entretien : détails du logement concerné, notes d'information, etc.
- L'ajout d'une nouvelle note (champ de texte libre) sur l'action d'entretien
- Une vision des dates de réservations anonymisées de chaque logement, pour anticiper les prochains entretiens
- Un concept d'état de l'entretien : à faire, en cours, fait
- La modification de l'état de l'entretien

<h2>Zone administration</h2>
La zone entretien permet à un·e utilisateur·ice d'administrer les autres comptes
utilisateurs.<br>
L'accès à cette zone nécessite le rôle admin.

__Les fonctionnalités de la zone administration sont :__

- La modification des rôles des comptes utilisateur
- La possibilité de désactiver / réactiver un compte
- La suppression de compte utilisateur

<h2>Contraintes techniques</h2>
<strong>Technologies utilisées<br></strong>
Ce projet devra être réalisé avec les technologies qui vous ont été enseignées lors de
cette année scolaire.<br>
<strong>Front</strong><br>
La partie front devra être réalisée avec les langages HTML, CSS et JavaScript.<br>
<strong>Back</strong><br>
La partie back devra être réalisée en PHP ou en Python avec le module Flask.<br>
<strong>Base de données</strong><br>
Les données étant hautement relationnelles dans ce projet, vous devrez utiliser une
base de données relationnelle, de préférence MariaDB.<br>
<h3>Éléments externes</h3>
<strong>Code externe</strong><br>
En dehors de Flask, pour celleux qui l'utiliseront, l'utilisation de frameworks,
bibliothèques ou autres paquets n'est pas autorisée.<br>
Si un bloc de code vient du web, un commentaire contenant la source de ce code
devra apparaitre avant celui-ci.<br>
<strong>Médias</strong><br>
L'ensemble des médias utilisés (images, vidéos, polices d'écriture, icones, etc.)
devront être sur une licence compatible avec l'utilisation dans votre projet.

<h2>Obligations de réalisation</h2>
<strong>Sécurisation des mots de passe</strong><br>
Les mots de passe doivent être hashés dans la base de données avec l'algorithme
bcrypt (les autres algorithmes comme md5 ou sha1 sont interdits).<br>
<strong>UI / UX </strong><br>
Un effort sur l'interface et l'expérience utilisateur vous est demandé sur ce projet.
Sans aller jusqu'à concevoir une charte graphique du niveau d'une grande entreprise,
votre interface devra être accueillante et facile d'utilisation.<br>
<strong>Responsive <br></strong>
Votre application devra être "Responsive" (utilisable sur tout type d'écrans). Il est
admis que certaines interfaces pourraient être plus difficiles à rendre élégantes et
utilisables ; à vous de trouver des solutions palliatives.

<h2>Fonctionnalités bonus</h2>

Dans cette partie, vous retrouverez une liste non exhaustive d'idées pour pousser
plus loin votre projet. La réalisation de ces fonctionnalités ne fait pas partie du
barème de notation mais réussir à implémenter celles-ci pourra vous octroyer des
points bonus.<br>
<strong>PWA et hors ligne</strong><br>
Il serait plus agréable pour les utilisateur·ice·s mobiles que l'outil se comporte comme
une application mobile ; on parle de PWA (Progressive Web Application).
Il serait également utile de pouvoir accéder à une partie des données, même lorsque
l'on a plus de connexion internet ; par exemple les informations de la réservation en
cours pour le client ou la liste des entretiens du jour pour l'équipe d'entretien.<br>
<strong>Amélioration de la messagerie</strong><br>
La messagerie envisagée dans le projet est limitée. Il serait pertinent de lui ajouter
différentes fonctionnalités comme :
- Un envoi automatique de message personnalisé par logement lors de la
réservation
- Des modèles de messages prédéfinis
- De la mise en forme du texte
- La possibilité d'ajouter une image au message
- etc

<strong>D'avantage de données</strong><br>
La liste des fonctionnalités n'est pas exhaustive, y compris sur les informations
affichées. Vous pouvez donc ajouter plus de données sur les différentes interfaces
(par exemple, le montant total dépensé par un client, sur son interface).
<strong>Meilleur contrôle de compte utilisateur·ice</strong><br>
La gestion de l'authentification reste basique sur le projet et pourrait être améliorée
avec différentes fonctionnalités que l'on retrouve sur des applications équivalentes,
comme : la fonctionnalité "mot de passe oublié", la capacité de changer son mot de
passe, la validation de compte par mail, etc.<br>
<strong>Affichage de planning</strong><br>
Le projet traitant un certain nombre de données de type date, il serait intéressant
d'intégrer au projet un affichage sous forme de planning sur différentes interfaces
pour améliorer la lisibilité de ces données.<br>
Un planning pourrait par exemple être pertinent pour lister les réservations sur un
logement ou la liste des entretiens prévus à la journée.<br>
<strong>Impersonation</strong><br>
Lors du développement d'une application et de sa maintenance, il est parfois utile de
pouvoir visualiser celle-ci comme si on était une autre personne ; on parle de
subrogation d'identité.<br>
Cette fonctionnalité n'est souvent accordée qu'aux seules personnes en charge de la
partie technique, qui ont de toute façon déjà accès à la base de données et au code.<br>
Cette fonctionnalité permet à une personne de se faire passer pour un·e autre
utilisateur·ice et d'utiliser l'application avec son profil et ses rôles.<br>
Un rôle supplémentaire devra être créé (super-admin et ne pourra être ajouté qu'en
base de données.

<h3>Je remercie aux autres développeurs d'avoir participer au projet, c'était un réel plaisir d'avoir pu partager ce projet avec cette équipe :</h3>
- Lejeune Lorys (Back-end)<br>
https://github.com/MrStagiaire<br>
- Lin Alexis (Back-end)<br>
https://github.com/Kosei32<br>
- Mahalinham Tharishanan (Front-end)<br>
https://github.com/ImThari<br>
- Yang Rosine (Fullstack)<br>
https://github.com/Myakii<br>
- Lu Luc (Back-end)<br>
https://github.com/CapriceSeum<br>
- Gaucher Joffrey (Back-end)

<h2>Informations supplémentaires</h2>
<strong>Comptes de connexion</strong><br>
Voici les informations de connexion pour accéder aux différents rôles du site :<br>

<strong>Administrateur</strong><br>
Email : Alexis_L@gmail.com
Mot de passe : Azerty123azerty&&<br>
<strong>Client </strong><br>
Email : Lorys_l@gmail.com
Mot de passe : Azerty123azerty&&<br>
Email : r_yang@gmail.com
Mot de passe : Azerty123azerty&&<br>
<strong>Staff </strong><br>
Email : solene_m@gmail.com
Mot de passe : Azerty123azerty&&<br>
