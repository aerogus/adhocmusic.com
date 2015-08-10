{include file="fb/adhocmusic/canvas/common/header.tpl"}

{if $lieu->getPhoto()}
  <img src="http://www.adhocmusic.com/media/lieu/{$lieu->getId()|escape}.jpg" alt="" style="float: right" />
{/if}

<table>
  <tr>
    <td>Adresse :</td>
    <td><strong>{$lieu->getName()|escape}</strong><br />{$lieu->getAddress()|escape}<br />{$lieu->getCp()|escape} {$lieu->getCity()|escape}</td>
  </tr>
  <tr>
    <td>Type :</td>
    <td><strong>{$lieu->getType()|escape}</strong></td>
  </tr>
  <tr>
    <td>Département :</td>
    <td><strong>{$lieu->getIdDepartement()|escape} / {$lieu->getDepartement()|escape}</strong></td>
  </tr>
  <tr>
    <td>Région :</td>
    <td><strong>{$lieu->getRegion()|escape}</strong></td>
  </tr>
  <tr>
    <td>Pays :</td>
    <td><strong>{$lieu->getIdCountry()|escape}</strong></td>
  </tr>
  <tr>
    <td>Tel :</td>
    <td><strong>{$lieu->getTel()|escape}</strong></td>
  </tr>
  <tr>
    <td>Fax :</td>
    <td><strong>{$lieu->getFax()|escape}</strong></td>
  </tr>
  <tr>
    <td>Email :</td>
    <td><strong>{$lieu->getEmail()|escape}</strong></td>
  </tr>
  <tr>
    <td>Site :</td>
    <td><a href="{$lieu->getSite()|escape}" class="extlink"><strong>{$lieu->getSite()|escape}</strong></a></td>
  </tr>
  <tr>
    <td>Description :</td>
    <td>{$lieu->getText()|escape}</td>
  </tr>
</table>

{include file="fb/adhocmusic/canvas/common/footer.tpl"}
