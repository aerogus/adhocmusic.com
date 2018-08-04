{include file="common/header.tpl"}

{if !empty($from)}
<div class="infobulle error">
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
          <li><a href="/partners">Partenaires</a></li>
          <li><a href="/mentions-legales">Mentions Légales</a></li>
        </ul>
      </li>
      <li>
        <a href="/assoce">L'Assoce</a>
        <ul>
          <li><a href="/concerts">Concerts</a></li>
          <li><a href="/afterworks">Afterworks</a></li>
          <li><a href="/formations">Formations</a></li>
          <li><a href="/equipe">Équipe</a></li>
        </ul>
      </li>
      <li>
        <a href="/groupes/">Groupes</a>
      </li>
      <li>
        <a href="/agenda/">Agenda</a>
      </li>
      <li>
        <a href="/media/">Média</a>
      </li>
      <li>
        <a href="/contact">Contact</a>
      </li>
      <li>
        <a href="/login">Connexion</a>
      </li>
    </ul>
  </div>
</div>

{include file="common/footer.tpl"}
