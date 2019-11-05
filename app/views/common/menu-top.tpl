<div class="top-bar">
  <div class="top-bar-inner">
    <div class="top-bar-title">
      <a href="/" accesskey="1" title="Retour à l'accueil"><strong>AD’HOC</strong></a>
    </div>
    <div class="top-bar-right">
      <button id="btn-burger" class="top-bar-burger">≡</button>
      <nav class="top-menu">
        <ul>
          <li>
            <a href="/assoce" accesskey="2" title="Présentation de l’Association AD’HOC, l’équipe, nos concerts">L’Assoce</a>
            <ul>
              <li><a href="/concerts">Concerts</a></li>
              <li><a href="/afterworks">Afterworks</a></li>
              <li><a href="/festival">Le festival</a></li>
              <li><a href="/equipe">Équipe</a></li>
            </ul>
          </li>
          <li>
            <a href="/events/" accesskey="2" title="Agenda">Agenda</a>
          </li>
          <li>
            <a href="/medias/" accesskey="3" title="Vidéos">Vidéos</a>
          </li>
          <li>
            <a href="/groupes/" accesskey="4" title="Groupes">Groupes</a>
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
