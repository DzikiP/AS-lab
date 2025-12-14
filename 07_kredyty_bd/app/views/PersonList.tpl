{extends file="main.tpl"}

{block name=top}

	<div class="bottom-margin">
		<form class="pure-form pure-form-stacked" action="{$conf->action_url}personList">
			<legend>Opcje wyszukiwania</legend>
			<fieldset>
				<input type="text" placeholder="imie" name="sf_name" value="{$searchForm->name}" /><br />
				<button type="submit" class="pure-button pure-button-primary">Filtruj</button>
			</fieldset>
		</form>
	</div>

{/block}

{block name=bottom}

	<div class="bottom-margin">
		<a class="pure-button button-success" href="{$conf->action_root}personNew">+ Nowa osoba</a>
	</div>

	<table id="tab_people" class="pure-table pure-table-bordered">
		<thead>
			<tr>
				<th>imię</th>
				<th>kwota kredytu</th>
				<th>lata</th>
				<th>oprocentowanie</th>
				<th>rata miesięczna</th>
			</tr>
		</thead>
		<tbody>
			{foreach $people as $p}
				{strip}
					<tr>
						<td>{$p["name"]}</td>
						<td>{$p["kredyt"]}</td>
						<td>{$p["lata"]}</td>
						<td>{$p["opr"]}</td>
						<td>{$p["rata"]}</td>
						<td>
							<a class="button-small pure-button button-secondary"
								href="{$conf->action_url}personEdit&id={$p['idperson']}">Edytuj</a>
							&nbsp;
							<a class="button-small pure-button button-warning"
								href="{$conf->action_url}personDelete&id={$p['idperson']}">Usuń</a>
						</td>
					</tr>
				{/strip}
			{/foreach}
		</tbody>
	</table>

{/block}