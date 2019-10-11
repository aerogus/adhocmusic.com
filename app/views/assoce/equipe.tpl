{include file="common/header.tpl"}

    <div class="box">
      <header>
        <h1>L’Équipe</h1>
      </header>
      <div>
        <p>Voici les forces actives de l’association pour la saison 2018/2019</p>
        <ul class="staff">
          {foreach from=$membres item=membre}
          <li>
            <img src="{$membre.avatar_interne|escape}" alt="">
            <strong>{$membre.first_name|escape} {$membre.last_name|escape}</strong><br>
            <em>{$membre.function|escape}</em>
          </li>
          {/foreach}
        </ul>
      </div>
    </div>

    <div class="box">
      <header>
        <h1>Les anciens</h1>
      </header>
      <div>
        <p>De 1996 à aujourd’hui, nombre de bénévoles ont participé à l’aventure AD’HOC de près ou de loin. Qu’ils en soient remerciés:</p>
        <p>
          <strong>Pablo Ruamps Simon</strong> (2007 à 2010),
          <strong>Myriam Fiévé</strong> (2008 à 2010),
          <strong>Mika Apamian</strong> (2008 à 2010),
          <strong>Franck Chassot</strong> (2006 à 2010),
          <strong>Marie-Cécile Preux</strong> (2007 à 2010),
          <strong>Grégory Chassot</strong> (1996 à 2009),
          <strong>Guillaume Drivierre</strong> (1996 à 2009),
          <strong>Sylvain Pendino</strong> (2000 à 2009),
          <strong>Aïssa Guigon</strong> (2004 à 2008),
          <strong>Mathias Gorenflot</strong> (2002 à 2007),
          <strong>Julien Perronnet</strong> (1996 à 2006),
          <strong>Julie Busnel</strong> (2005 à 2006),
          <strong>Christophe Boutin</strong> (1996 à 2002),
          <strong>Patrice Popineau</strong> (1996 à 2019),
          <strong>Vincent Pendino</strong> (2019 à 2019),
          <strong>Milena Leclere</strong> (2011 à 2015),
          <strong>Frederic Decaen</strong> (2006 à 2014),
          <strong>Noémie Luxain</strong> (2016 à 2019),
          <strong>Eugénie Cottel</strong> (2007 à 2009),
          <strong>Cédric Pereira</strong> (1996 à 2014),
          <strong>Léa Vroome</strong> (2016 à 2019),
          <strong>Candice Vergès</strong> (2013 à 2014),
          <strong>Michel Dechenaud</strong> (1996 à 2012),
          <strong>William Bonin</strong> (2013 à 2019),
          <strong>Oriane Rondou</strong> (2014 à 2016),
          <strong>Julie Madeira</strong> (2004 à 2014),
          <strong>Aurélie Turmine</strong> (2008 à 2014),
          <strong>Eric Redon</strong> (2002 à 2012),
          <strong>Guilhem Dubernet</strong> (2010 à 2013),
          <strong>Juliette Bigey</strong> (2008 à 2016),
          <strong>Pierre Gerard</strong> (2002 à 2012),
          <strong>Juan Ramon Alvarez</strong> (1996 à 2006),
          <strong>Quentin Goffic</strong> (2009 à 2012),
          <strong>Hugues Delacroix</strong> (1996 à 2000),
          <strong>Guillaume Dessay</strong> (1996 à 2010),
          <strong>Louis Cabrera</strong> (2010 à 2013),
          <strong>Alexandre Bellepeau</strong> (2010 à 2012),
          <strong>Christina Ribeiro</strong> (2011 à 2012),
          <strong>Emilie Lacombe</strong> (2000 à 2012),
          et <strong>Francisque Vigouroux</strong> (1996 à 2002).
        </p>
      </div>
    </div>

  </div>

{include file="common/footer.tpl"}
