{extends file="main.tpl"}

{block name=top}

    <div class="bottom-margin">
        <form action="{$conf->action_root}personSave" method="post" class="pure-form pure-form-aligned">

            <fieldset>
                <legend>Dane osoby i kredytu</legend>

                <div class="pure-control-group">
                    <label for="name">Imię</label>
                    <input id="name" type="text" name="name" value="{$form->name}">
                </div>

                <div class="pure-control-group">
                    <label for="kredyt">Kwota kredytu</label>
                    <input id="kredyt" type="number" name="kredyt" value="{$form->kredyt}">
                </div>

                <div class="pure-control-group">
                    <label for="opr">Oprocentowanie (%)</label>
                    <select name="opr">
                        <option value="5" {if $form->opr==5}selected{/if}>5%</option>
                        <option value="10" {if $form->opr==10}selected{/if}>10%</option>
                        <option value="15" {if $form->opr==15}selected{/if}>15%</option>
                        {if $user->role=="menager"}
                            <option value="20" {if $form->opr==20}selected{/if}>20%</option>
                        {/if}
                    </select>
                </div>

                <div class="pure-control-group">
                    <label for="lata">Lata spłaty</label>
                    <input id="lata" type="number" name="lata" value="{$form->lata}">
                </div>

                {if isset($form->rata)}
                    <div class="pure-control-group">
                        <label>Rata kredytu</label>
                        <b>{$form->rata} zł</b>
                    </div>
                {/if}

            </fieldset>

            <div class="pure-controls">
                <input type="submit" class="pure-button pure-button-primary" value="Zapisz" />
                <a class="pure-button button-secondary" href="{$conf->action_root}personList">Powrót</a>
            </div>

            <input type="hidden" name="id" value="{$form->id}">
        </form>
    </div>

{/block}