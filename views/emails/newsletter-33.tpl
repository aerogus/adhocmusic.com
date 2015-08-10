<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">

<html xmlns="http://www.w3.org/1999/xhtml">

<head>
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>[AD'HOC] - {$title|escape}</title>
</head>

<body text="#000000" vlink="#000000" alink="#000000" link="#000000" bgcolor="#ffffff">

<style type="text/css">
a{ color: #000000; }
p{ color: #000000; }
strong{ color: #000000; }
th{ }
td{ }
</style>

<p align="center"><a href="{$url|link}"><font color="#000000">Consulter cet e-mail sur le web</font></a></p>

<table cellspacing="0" cellpadding="10" width="550" align="center" border="0" bgcolor="#ffffff">
<tr>
<td><a href="http://www.adhocmusic.com"><img src="http://www.adhocmusic.com/dynimg/logo_adhoc/{$id}.jpg" border="0" alt="AD'HOC" /></a></td>
<td><font face="arial" color="#000000"><strong>Association oeuvrant pour le développement de la vie musicale en Essonne depuis 1996</strong></font></td>
</tr>
</table>

<br />

<p align="center"><font color="#000000">
{if !empty($show_unsubscribe_wording)}
Pour vous désinscrire de cette newsletter, veuillez<br />
répondre à ce message avec "remove" dans le sujet.<br />
{/if}
email inscrite : {$email}</font></p>

<p align="center"><a href="{$url}"><font color="#000000">{$url}</font></a></p>

<br />

</body>

</html>
