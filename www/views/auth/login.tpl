{include file="common/header.tpl"}

<div id="left">

{if !empty($auth_failed)}

{include file="common/boxlogin.tpl"}

</div>

<div id="center-right">

<div class="error">Authentification échouée</div>

{/if}

{if !empty($not_auth)}

{include file="common/boxlogin.tpl"}

</div>

<div id="center-right">

<div class="warning">Vous devez posséder un compte AD'HOC pour accéder à cette page ou vous n'avez pas les droits suffisants</div>

<div class="registerblock">
  <h3>Compte AD'HOC</h3>
  <p>Le <em>compte AD'HOC</em>, dont l'inscription est <strong>totalement gratuite</strong>, donne accès à toute la zone membre du site.</p>
  <p>Vos Avantages :</p>
  <ul>
    <li>Annoncer des concerts dans l'agenda</li>
    <li>Accès au forum</li>
    <li>Communiquer entre membres par messagerie interne</li>
    <li>S'abonner aux alertes</li>
    <li>Faire partie d'une communauté de musiciens et d'amateurs de musique</li>
  </ul>
  <a href="/membres/create" class="registerbutton">Créer son Compte AD'HOC</a>
</div>

<div class="registerblock">
  <h3>Fiche Artiste</h3>
  <p>Note: <strong>Vous devez posséder un compte AD'HOC</strong></p>
  <p>Elle vous donne la possibilité de <strong>Promotion de votre groupe</strong> par le biais de notre site et ceux de nos partenaires.</p>
  <p>Vos Avantages :</p>
  <ul>
    <li>Création de votre Fiche Groupe accessible publiquement</li>
    <li>Une adresse de type : www.adhocmusic.com/mongroupe</li>
    <li>Vous saisissez vous-même les infos sur votre groupe : <strong>Dates de concerts et News dans l'Agenda</strong>, <strong>Photos, Extraits Musicaux et Vidéos sur votre Fiche Groupe</strong></li>
    <li>Vous bénéficiez d'un référencement de qualité dans les moteurs de recherche</li>
  </ul>
  <a href="/groupes/create" class="registerbutton">Créer sa fiche Artiste/Groupe</a>
</div>

<div class="registerblock">
  <h3>Fiche Lieu</h3>
  <p>Note: <strong>Vous devez posséder un compte AD'HOC</strong></p>
  <p>Vous êtes propriétaire d'un lieu de diffusion de musique ? Bar, MJC, salle de concerts ? Profiter de l'audience du site AD'HOC pour annoncer votre actualité et déposer vos photos.</p>
  <p>Vos Avantages :</p>
  <ul>
    <li>Création d'une fiche Lieu avec vos coordonnées</li>
  </ul>
  <a href="/lieux/create" class="registerbutton">Créer sa fiche Lieu</a>
</div>

{/if}

</div>

{include file="common/footer.tpl"}
