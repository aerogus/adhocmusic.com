<ul id="menu_haut">
  <li class="{if isset($menuselected) && $menuselected == 'home'}menuselected {/if}first">
    <a href="/" accesskey="1" title="Retour à l'accueil">Accueil</a>
    <ul class="sub-menu">
      <li><a href="/map">Plan du site</a></li>
      <li><a href="/mentions-legales">Mentions Légales</a></li>
      <li><a href="/partners">Partenaires</a></li>
      <li><a href="/visuels">Visuels</a></li>
      <li><a href="/hosting">Hébergement</a></li>
      <li><a href="/api">API</a></li>
    </ul>
  </li>
  <li {if isset($menuselected) && $menuselected == 'assoce'} class="menuselected"{/if}>
    <a href="/assoce" accesskey="2" title="Présentation de l'Association AD'HOC, l'équipe, nos concerts">L'Assoce</a>
    <ul class="sub-menu">
      <li><a href="/assoce/presentation">Présentation</a></li>
      <li><a href="/assoce/concerts">Concerts</a></li>
      <li><a href="/assoce/equipe">Equipe</a></li>
      <li><a href="/assoce/statuts">Statuts</a></li>
    </ul>
  </li>
  <li {if isset($menuselected) && $menuselected == 'groupes'} class="menuselected"{/if}>
    <a href="/groupes/" accesskey="2" title="La liste et les fiches groupes du réseau AD'HOC">Groupes</a>
    <ul class="sub-menu">
      <li><a href="/groupes/?tri=m">Par date de mise à jour</a></li>
      <li><a href="/groupes/?tri=a">Par ordre alphabétique</a></li>
      <li><a href="/groupes/create">Inscrire son groupe</a></li>
    </ul>
  </li>
  <li {if isset($menuselected) && $menuselected == 'agenda'} class="menuselected"{/if}>
    <a href="/events/" accesskey="3" title="Un agenda concert des groupes de la région">Agenda</a>
    <ul class="sub-menu">
      <li style="padding-left: 205px;"><a href="/events/create">Annoncer une date</a></li>
    </ul>
  </li>
  <li {if isset($menuselected) && $menuselected == 'media'} class="menuselected"{/if}>
    <a href="/media/">Média</a>
    <ul class="sub-menu">
      <li style="padding-left: 240px;"><a href="/audios/create">Ajouter un son</a></li>
      <li><a href="/photos/create">Ajouter une photo</a></li>
      <li><a href="/videos/create">Ajouter une vidéo</a></li>
    </ul>
  </li>
  <li class="{if isset($menuselected) && $menuselected == 'contact'}menuselected {/if}last">
    <a href="/contact" accesskey="9" title="Contact">Contact</a>
    <ul class="sub-menu">
      <li></li>
    </ul>
  </li>
</ul>
