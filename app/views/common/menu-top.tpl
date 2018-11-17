<div class="top-bar">
  <div class="top-bar-inner">
    <div class="top-bar-title">
      <a href="/"><strong>AD’HOC</strong></a>
    </div>
    <div class="top-bar-right">
      <button id="btn-burger" class="top-bar-burger">≡</button>
      <nav class="top-menu">
        <ul>
          <li>
            <a href="/" accesskey="1" title="Retour à l'accueil">Accueil</a>
            <ul>
              <li><a href="/map">Plan du site</a></li>
              <li><a href="/partners">Partenaires</a></li>
              <li><a href="/mentions-legales">Mentions Légales</a></li>
            </ul>
          </li>
          <li>
            <a href="/assoce" accesskey="2" title="Présentation de l’Association AD’HOC, l’équipe, nos concerts">L’Assoce</a>
            <ul>
              <li><a href="/concerts">Concerts</a></li>
              <li><a href="/afterworks">Afterworks</a></li>
              <li><a href="https://lespiedsdanslorge.org">Festivals</a></li>
              <li><a href="/formations">Formations</a></li>
              <li><a href="/equipe">Équipe</a></li>
            </ul>
          </li>
          <li>
            <a href="/groupes/" accesskey="3" title="Les groupes du réseau AD'HOC">Groupes</a>
          </li>
          <li>
            <a href="/events/" accesskey="3" title="Agenda">Agenda</a>
          </li>
          <li>
            <a href="/medias/" accesskey="4" title="Vidéos">Vidéos</a>
          </li>
          <li>
            <a href="/contact" accesskey="5" title="Contact">Contact</a>
          </li>
          <li>
          {if empty($is_auth)}
            <a class="avatar" href="/auth/login" accesskey="6" title="Identification">🔒</a>
          {else}
            <a class="avatar" href="/membres/tableau-de-bord" accesskey="6" title="Tableau de bord">🔓</a>
          {/if}
          </li>
        </ul>
      </nav>
    </div>
  </div>
</div>
