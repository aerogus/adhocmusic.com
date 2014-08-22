<ul id="menu_haut">
  <li class="{if isset($menuselected) && $menuselected == 'home'}menuselected {/if}first">
    <a href="/" accesskey="1" title="Retour à l'accueil">Accueil</a>
    <ul class="sub-menu">
      <li><a href="/map">Plan du site</a></li>
      <li><a href="/mentions-legales">Mentions Légales</a></li>
      <li><a href="/partners">Partenaires</a></li>
      <li><a href="/visuels">Visuels</a></li>
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
    </ul>
  </li>
  <li {if isset($menuselected) && $menuselected == 'lieux'} class="menuselected"{/if}>
    <a href="/lieux/" accesskey="4" title="Les lieux de diffusion partout en France">Lieux</a>
    <ul class="sub-menu">
      <li style="padding-left: 270px;"><a href="/lieux/">Proches de chez moi</a></li>
      <li><a href="/lieux/create">Inscrire un lieu</a></li>
    </ul>
  </li>
  <li {if isset($menuselected) && $menuselected == 'articles'} class="menuselected"{/if}>
    <a href="/articles/" accesskey="6" title="Des chroniques de disques, des cours de pédagogie musicale et bien d'autres">Articles</a>
    <ul class="sub-menu">
      <li style="padding-left: 0px;"><a href="/articles/chroniques">Chroniques d'Albums</a></li>
      <li><a href="/articles/pedagogie">Pédagogie Musicale</a></li>
      <li><a href="/articles/live">Live Reports</a></li>
      <li><a href="/articles/dossiers">Dossiers</a></li>
      <li><a href="/articles/interviews">Interviews</a></li>
      <li><a href="/articles/locale">Revue de presse</a></li>
    </ul>
  </li>
  <li class="{if isset($menuselected) && $menuselected == 'contact'}menuselected {/if}last">
    <a href="/contact" accesskey="9" title="Contact">Contact</a>
    <ul class="sub-menu">
      <li></li>
    </ul>
  </li>
</ul>
