{include file="common/header.tpl"}

<div class="box">
  <header>
    <h1>Guide de style</h1>
  </header>
  <div>

    <h2>Les titres</h2>

    <h1>Titre 1</h1>
    <h2>Titre 2</h2>
    <h3>Titre 3</h3>
    <h4>Titre 4</h4>
    <h5>Titre 5</h5>
    <h6>Titre 6</h6>

    <h2>Les paragraphes</h2>

    <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed a erat nulla. Nunc accumsan justo euismod ipsum aliquam aliquet. Mauris vitae feugiat quam. Etiam commodo sollicitudin quam sit amet varius. Nunc eget neque massa. Ut sit amet magna tristique, sagittis odio vitae, suscipit sem. Sed pulvinar ipsum id lorem porttitor, eu efficitur nunc posuere. Etiam laoreet quam mauris, nec pharetra arcu feugiat sit amet.</p>
    <p>Aliquam vitae mauris pretium erat convallis malesuada. Phasellus vel mauris sem. Pellentesque fermentum fringilla neque, quis vulputate mi condimentum eu. Morbi ut vestibulum mi. Maecenas posuere non ligula eu maximus. Cras eget nibh porttitor, lobortis velit at, imperdiet lorem. Morbi id ante imperdiet, rutrum dui sed, viverra felis. Ut interdum eros non ligula malesuada egestas. Integer a velit in quam auctor porttitor.</p>
    <p>Ut interdum, mauris quis dignissim cursus, ante augue dapibus nisl, sed efficitur diam nisi et lacus. Aenean facilisis ut neque id volutpat. Suspendisse gravida eget diam et cursus. Nullam convallis augue nec fringilla tristique. Vestibulum tristique, nibh at tincidunt facilisis, leo dui pharetra ipsum, a bibendum metus velit et nulla. In sollicitudin sem enim, quis pulvinar eros facilisis in. Sed eget justo ipsum. Donec neque augue, feugiat vitae viverra a, feugiat sed lorem. Fusce finibus luctus odio, nec volutpat magna iaculis viverra. Praesent quis purus quis lacus eleifend dignissim. Fusce cursus at quam sed bibendum. Mauris scelerisque quis tortor a cursus. Aliquam ac malesuada enim. Aenean risus enim, facilisis nec nunc vel, aliquet placerat enim. Sed eget euismod neque. Donec suscipit massa ut elementum finibus.</p>

    <h2>Les infobulles</h2>

    <div class="infobulle info">Infobulle info</div>
    <div class="infobulle success">Infobulle success</div>
    <div class="infobulle warning">Infobulle warning</div>
    <div class="infobulle error">Infobulle error</div>
    <div class="infobulle validation">Infobulle validation</div>

    <h2>Les listes</h2>

    <ul>
      <li>Liste</li>
      <li>non</li>
      <li>ordonnée</li>
    </il>

    <ol>
      <li>Liste</li>
      <li>ordonnée</li>
    </ol>

    <h2>Les tableaux</h2>

    <table>
      <thead>
        <tr>
          <th>Colonne 1</th>
          <th>Colonne 2</th>
          <th>Colonne 3</th>
        </tr>
      </thead>
      <tbody>
        <tr>
          <td>l1c1</td>
          <td>l1c2</td>
          <td>l1c3</td>
        </tr>
        <tr>
          <td>l1c1</td>
          <td>l1c2</td>
          <td>l1c3</td>
        </tr>
        <tr>
          <td>l1c1</td>
          <td>l1c2</td>
          <td>l1c3</td>
        </tr>
      </tbody>
      <tfoot>
        <tr>
          <th>Colonne 1</th>
          <th>Colonne 2</th>
          <th>Colonne 3</th>
        </tr>
      </tfoot>
    </table>

    <h2>Les formulaires</h2>

	<h2>La pagination</h2>

	{pagination nb_items=100 nb_items_per_page=10 page=0}
	{pagination nb_items=100 nb_items_per_page=10 page=5}
	{pagination nb_items=100 nb_items_per_page=10 page=9}

  </div>
</div>

{include file="common/footer.tpl"}
