{include file="common/header.tpl"}

{include file="common/boxstart.tpl" boxtitle="Page de test design"}

<fieldset>
  <legend>Titres</legend>
  <h1>Titre H1</h1>
  <h2>Titre H2</h2>
  <h3>Titre H3</h3>
  <h4>Titre H4</h4>
  <h5>Titre H5</h5>
  <h6>Titre H6</h6>
</fieldset>

<fieldset>
  <legend>Textes</legend>
  <p><strong>Lorem ipsum</strong> dolor sit amet, consectetur adipisicing <em>elit</em>, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum</p>
  <p>Lorem ipsum dolor sit amet, <a href="#">consectetur adipisicing</a> elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum</p>
</fieldset>

<fieldset>
  <legend>Listes</legend>
  <ul>
    <li>liste non ordonnée</li>
    <li>liste non ordonnée</li>
    <li>liste non ordonnée</li>
  </ul>
  <ol>
    <li>liste ordonnée</li>
    <li>liste ordonnée</li>
    <li>liste ordonnée</li>
  </ol>
</fieldset>

<fieldset>
  <legend>Tableaux</legend>
  <table>
    <thead>
      <tr><th>Col 1</th><th>Col 2</th></tr>
    </thead>
    <tbody>
      <tr><td>Col 1</td><td>Col 2</td></tr>
      <tr><td>Col 1</td><td>Col 2</td></tr>
    </tbody>
    <tfoot>
      <tr><td>Col 1</td><td>Col 2</td></tr>
    </tfoot>
  </table>
</fieldset>

<fieldset>
  <legend>Formulaires</legend>
  <form>
    <textarea name="textarea">textarea</textarea><br />
    <input type="text" name="text" value="input text" /><br />
    <input type="text" name="text" class="optional" value="input text optional" /><br />
    <input type="text" name="text" class="conditional" value="input text conditional" /><br />
    <input type="text" name="text" class="required" value="input text required" /><br />
    <select name="select">
      <option value="1">Select 1</option>
      <option value="2">Select 2</option>
      <option value="3">Select 3</option>
    </select><br />
    <input type="checkbox" name="check1" /> Checkbox 1<br />
    <input type="checkbox" name="check2" /> Checkbox 2<br />
    <input type="checkbox" name="check3" /> Checkbox 3<br />
    <br />
    <input type="radio" name="radio" /> Radio 1<br />
    <input type="radio" name="radio" /> Radio 2<br />
    <input type="radio" name="radio" /> Radio 1<br />
    <br />
    <input type="submit" name="text" value="OK" />
  </form>
</fieldset>

<fieldset>
  <legend>Divers / autres</legend>
  Lien avec classe button : <a class="button">class button</a>
  Pagination debut : {pagination nb_items=100 nb_items_per_page=10 page=0}
  Pagination milieu : {pagination nb_items=100 nb_items_per_page=10 page=5}
  Pagination fin :  {pagination nb_items=100 nb_items_per_page=10 page=9}
</fieldset>

<fieldset>
  <legend>Boites de messages</legend>
  <div class="info">C'est un message avec la classe info</div>
  <div class="warning">C'est un message avec la classe warning</div>
  <div class="error">C'est un message avec la classe error</div>
  <div class="success">C'est un message avec la classe success</div>
  <div class="validation">C'est un message avec la classe validation</div>
</fieldset>

{include file="common/boxend.tpl"}

{include file="common/footer.tpl"}