{extends file="main.tpl"}

{block name=content}

	<div class="pure-menu pure-menu-horizontal bottom-margin">
		<a href="{$conf->action_url}logout" class="pure-menu-heading pure-menu-link">wyloguj</a>
		<span style="float:right;">użytkownik: {$user->login}, rola: {$user->role}</span>
	</div>

	<form action="{$conf->action_url}calcCompute" method="post" class="pure-form pure-form-aligned bottom-margin">
		<legend>Kalkulator kredytowy</legend>
		<fieldset>
			<div class="pure-control-group">
				<label for="id_kredyt">Jak duży chcesz kredyt?</label>
				<input id="id_kredyt" type="text" name="kredyt" value="{$form->kredyt}" />
			</div>
			<div class="pure-control-group">
				<label for="id_opr">Operocentowanie: </label>
				<select name="opr">
					{if isset($res->opr_name)}
						<option value="{$form->opr}">ponownie: {$res->opr_name}</option>
						<option value="" disabled="true">---</option>
					{/if}
					<option value="5%">5%</option>
					<option value="10%">10% </option>
					<option value="15%">15%</option>
					{if $user->role == "menager"}
						<option value="20%">20%</option>
					{/if}
				</select>
			</div>
			<div class="pure-control-group">
				<label for="id_lata">Na ile lat chcesz kredyt? </label>
				<input id="id_lata" type="text" name="lata" value="{$form->lata}" />
			</div>
			<div class="pure-controls">
				<input type="submit" value="Oblicz" class="pure-button pure-button-primary" />
			</div>
		</fieldset>
	</form>

	{include file='messages.tpl'}

	{if isset($res->result)}
		<div class="messages info">
			Twoja rata będzie wynosić: {$res->result}
		</div>
	{/if}

{/block}