{include file="common/header.tpl"}

{if !empty($from)}
<div class="error">
<p>La page que vous demandez n'existe pas</p>
<p>Voici le plan du site ainsi que les principaux liens.</p>
</div>
{/if}

{include file="common/boxstart.tpl" boxtitle="Plan du Site"}

<div class="tree_top"><a href="/">adhocmusic.com</a></div>
<ul class="tree">
  <li><a href="/">Accueil</a>
    <ul>
      <li><a href="/map">Plan du Site</a></li>
      <li><a href="/mobile">Site Mobile</a></li>
      <li><a href="/mentions-legales">Mentions Légales</a></li>
      <li><a href="/partners">Partenaires</a></li>
      <li class="last"><a href="/visuels">Visuels</a></li>
    </ul>
  </li>
  <li><a href="/assoce/">L'Assoce</a>
    <ul>
      <li><a href="/assoce/presentation">Présentation</a></li>
      <li><a href="/assoce/concerts">Concerts</a></li>
      <li><a href="/assoce/equipe">Equipe</a></li>
      <li class="last"><a href="/assoce/statuts">Statuts</a></li>
    </ul>
  </li>
  <li><a href="/groupes/">Groupes</a>
    <ul>
      <li><a href="/groupes/?tri=m">Par Date De Mise à Jour</a></li>
      <li><a href="/groupes/?tri=a">Par Ordre Alphabétique</a></li>
      <li class="last"><a href="/groupes/create">Inscrire Son Groupe</a></li>
    </ul>
  </li>
  <li><a href="/agenda/">Agenda</a>
    <ul>
      <li class="last"><a href="/agenda/create">Annoncer Une Date</a></li>
    </ul>
  </li>
  <li><a href="/media/">Média</a>
  </li>
  <li><a href="/lieux/">Lieux</a>
    <ul>
      <li><a href="/lieux/">Proches De Chez Moi</a></li>
      <li class="last"><a href="/lieux/create">Inscrire Un Lieu</a></li>
    </ul>
  </li>
  <li><a href="/articles/">Articles</a>
    <ul>
      <li><a href="/articles/chroniques">Chroniques D'Albums</a></li>
      <li><a href="/articles/pedagogie">Pédagogie Musicale</a></li>
      <li><a href="/articles/live">Live Reports</a></li>
      <li><a href="/articles/dossiers">Dossiers</a></li>
      <li><a href="/articles/interviews">Interviews</a></li>
      <li class="last"><a href="/articles/locale">Revue De Presse</a></li>
    </ul>
  </li>
  <li><a href="/forums/forum/a">Forum</a>
  </li>
  <li class="last"><a href="/contact">Contact</a>
  </li>
</ul>

{include file="common/boxend.tpl"}

{include file="common/footer.tpl"}
