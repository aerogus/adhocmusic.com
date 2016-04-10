<ul id="menu_haut">
  <li{if isset($menuselected) && $menuselected === 'home'} class="menuselected"{/if}>
    <a href="/" accesskey="1" title="Retour à l'accueil">Accueil</a>
    <ul>
      <li><a href="/map">Plan du site</a></li>
      <li><a href="/mentions-legales">Mentions Légales</a></li>
      <li><a href="/partners">Partenaires</a></li>
      <li><a href="/visuels">Visuels</a></li>
      <li><a href="/hosting">Hébergement</a></li>
    </ul>
  </li>
  <li{if isset($menuselected) && $menuselected === 'assoce'} class="menuselected"{/if}>
    <a href="/assoce" accesskey="2" title="Présentation de l'Association AD'HOC, l'équipe, nos concerts">L'Assoce</a>
    <ul>
      <li><a href="/assoce/presentation">Présentation</a></li>
      <li><a href="/assoce/concerts">Concerts</a></li>
      <li><a href="/assoce/afterworks">Afterworks</a></li>
      <li><a href="/assoce/equipe">Equipe</a></li>
      <li><a href="/assoce/statuts">Statuts</a></li>
    </ul>
  </li>
  <li{if isset($menuselected) && $menuselected === 'groupes'} class="menuselected"{/if}>
    <a href="/groupes/" accesskey="3" title="La liste et les fiches groupes du réseau AD'HOC">Groupes</a>
  </li>
  <li{if isset($menuselected) && $menuselected === 'agenda'} class="menuselected"{/if}>
    <a href="/events/" accesskey="3" title="Agenda Culturel">Agenda</a>
    <ul>
      <li><a href="/events/create">Annoncer une date</a></li>
    </ul>
  </li>
  <li{if isset($menuselected) && $menuselected === 'media'} class="menuselected"{/if}>
    <a href="/medias/" accesskey="4" title="Média">Média</a>
    <ul>
      <li><a href="/audios/create">Ajouter un son</a></li>
      <li><a href="/photos/create">Ajouter une photo</a></li>
      <li><a href="/videos/create">Ajouter une vidéo</a></li>
    </ul>
  </li>
  <li{if isset($menuselected) && $menuselected === 'contact'} class="menuselected"{/if}>
    <a href="/contact" accesskey="5" title="Contact">Contact</a>
  </li>
</ul>
