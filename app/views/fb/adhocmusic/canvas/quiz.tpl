{include file="fb/adhocmusic/canvas/common/header.tpl"}

{include file="fb/adhocmusic/canvas/common/boxstart.tpl" title="Quiz AD'HOC Music"}

{if $etape == 1}

  <h2 align="center">Vote pour les 5 plus grands groupes AD'HOC de tous les temps:</h2>
  <h3 align="center">Les groupes présents ici sont les groupes référencés sur le site AD'HOC et ayant joué à au moins une manifestation organisée par l'association AD'HOC à Epinay-sur-Orge (Pidou, Cavom, Mairie, Templiers...) depuis sa création en 1996.</h3>
  <h3 align="center">Clique sur les groupes pour les (re)découvrir avant de voter !</h3>

  <form id="quiz1">

  <table bgcolor="#999999" cellspacing="1" align="center">
    <tr>
    {foreach from=$groupes item=groupe name=grp}
      {if ($smarty.foreach.grp.index > 0) && ($smarty.foreach.grp.index % 4 == 0)}
        </tr><tr>
      {/if}
      <td bgcolor="#cccccc" align="center" width="25%"><a href="{$groupe.url}{*groupe/{$groupe.id|escape}.html*}"><strong>{$groupe.name|escape}</strong><br /><img src="{$groupe.pic|escape}" /></a><br /><input type="checkbox" name="grp[{$groupe.id|escape}]" />Choisir</td>
    {/foreach}
    </tr>
  </table>

  <p align="center"><input type="submit" value=" &gt;&gt; Etape suivante " /></p>
  <input type="hidden" name="etape" value="2" />

  </form>

{else if $etape == 2}

  {if !empty($etape_2_erreur)}

    <p>Tu n'as pas choisi 5 groupes !! Retourne à <a href="quiz.html">l'étape précédente</a></p>

  {else}

  <form action="http://fb.adhocmusic.com/quiz-callback.json" fbtype="feedStory">

  <table bgcolor="#999999" cellspacing="1" align="center">
    <tr>
      <th>Groupe</th>
      <th>Classement</th>
    </tr>
    {foreach from=$selgrps item=selgrp name=selgrpt}
    <tr>
      <td><strong>{$selgrp.name|escape}</strong><br /><img src="{$selgrp.pic|escape}" alt="" /></td>
      <td>
      <select name="rang[{$selgrp.id|escape}]" size="1">
      {foreach from=$rang item=lib key=num}
        <option value="{$num|escape}"{if ($num === $smarty.foreach.selgrpt.iteration)} selected="selected"{/if}>{$lib|escape}</option>
      {/foreach}
      </select>
      </td>
    </tr>
    {/foreach}
  </table>

  <p align="center"><input type="submit" value="je confirme mon vote !" label="je confirme mon vote !" /></p>
  </form>

  {/if}

{else if $etape == 3}

  <p>Participation OK ! merci d'avoir joué :)</p>

{else if $etape == 4}

  <h3>Participants</h3>
  <table>
    <tr>
      <th>Date</th>
      <th>Participant</th>
      <th>Groupe n°1<br />5 pts</th>
      <th>Groupe n°2<br />4 pts</th>
      <th>Groupe n°3<br />3 pts</th>
      <th>Groupe n°4<br />2 pts</th>
      <th>Groupe n°5<br />1 pt</th>
    </tr>
    {foreach from=$votes item=vote}
    <tr>
      <td>{$vote.date}</td>
      <td><fb:profile-pic uid="{$vote.facebook_uid}" linked="true" /><br />{$vote.first_name|escape} {$vote.last_name|escape}</td>
      <td><a href=""><img src="{$vote.id_groupe_1}" /></td>
      <td><a href=""><img src="{$vote.id_groupe_2}" /></td>
      <td><a href=""><img src="{$vote.id_groupe_3}" /></td>
      <td><a href=""><img src="{$vote.id_groupe_4}" /></td>
      <td><a href=""><img src="{$vote.id_groupe_5}" /></td>
    </tr>
    {/foreach}
  </table>

  <h3>Classement</h3>
  <table>
    <tr>
      <th>Groupe</th>
      <th>Position</th>
      <th>Points</th>
    </tr>
    {foreach from=$resultats item=resultat name=res}
    <tr>
      <td><a href=""><img src="{$resultat.id_groupe}" /></td>
      <td>{$smarty.foreach.res.iteration}</td>
      <td>{$resultat.points} pts</td>
    </tr>
    {/foreach}
    </table>

{else}

{/if}

{include file="fb/adhocmusic/canvas/common/boxend.tpl"}

{include file="fb/adhocmusic/canvas/common/footer.tpl"}
