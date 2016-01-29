<config>
  <param name="mp3" value="{foreach from=$audios item=audio name=mp3}{if !$smarty.foreach.mp3.first}|{/if}/media/audio/{$audio.id}.mp3{/foreach}" />
  <param name="title" value="{foreach from=$audios item=audio name=title}{if !$smarty.foreach.title.first}|{/if}{$audio.name|escape}{/foreach}" />
  <param name="width" value="250" />
  <param name="height" value="150" />
  <param name="loop" value="1" />
  <param name="showvolume" value="1" />
  <param name="showinfo" value="1" />
  <param name="buttonwidth" value="20" />
  <param name="sliderwidth" value="15" />
  <param name="volumewidth" value="35" />
  <param name="volumeheight" value="10" />
  <param name="playlistcolor" value="ffffff" />
  <param name="currentmp3color" value="ffff00" />
  <param name="showplaylistnumbers" value="1" />
</config>
