{include file="common/header.tpl"}

{if !empty($from)}
<div class="error">
<p>La page que vous demandez n'existe pas</p>
<p>Voici le plan du site ainsi que les principaux liens.</p>
</div>
{/if}

<div class="box">
  <header>
    <h3>Plan du site</h3>
  </header>
<div>
<div class="tree_top"><a href="/">adhocmusic.com</a></div>
<ul class="tree">
  <li>
    <a href="/">Accueil</a>
    <ul>
      <li><a href="/map">Plan du Site</a></li>
      <li><a href="/mentions-legales">Mentions Légales</a></li>
      <li><a href="/partners">Partenaires</a></li>
      <li><a href="/visuels">Visuels</a></li>
    </ul>
  </li>
  <li>
    <a href="/assoce/">L'Assoce</a>
    <ul>
      <li><a href="/assoce/presentation">Présentation</a></li>
      <li><a href="/assoce/concerts">Concerts</a></li>
      <li><a href="/assoce/equipe">Equipe</a></li>
      <li><a href="/assoce/statuts">Statuts</a></li>
    </ul>
  </li>
  <li>
    <a href="/groupes/">Groupes</a>
    <ul>
      <li><a href="/groupes/?tri=m">Par Date De Mise à Jour</a></li>
      <li><a href="/groupes/?tri=a">Par Ordre Alphabétique</a></li>
      <li><a href="/groupes/create">Inscrire Son Groupe</a></li>
    </ul>
  </li>
  <li>
    <a href="/agenda/">Agenda</a>
    <ul>
      <li><a href="/agenda/create">Annoncer Une Date</a></li>
    </ul>
  </li>
  <li>
    <a href="/media/">Média</a>
  </li>
  <li>
    <a href="/lieux/">Lieux</a>
    <ul>
      <li><a href="/lieux/">Proches De Chez Moi</a></li>
      <li><a href="/lieux/create">Inscrire Un Lieu</a></li>
    </ul>
  </li>
  <li>
    <a href="/contact">Contact</a>
  </li>
</ul>
</div>
</div>

{include file="common/footer.tpl"}
