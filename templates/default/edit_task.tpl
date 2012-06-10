{* called by task.php *}
{config_load file=$fnLanguageTpl section='edit_task'}
{include file="header.tpl"}
<!-- {$smarty.template} -->
{if ! empty($booEdit)}
<p>
  <a href="event.php?intTaskId={$intTaskId}" title="{#aTitleEventForTask#}">{#aEventForTask#}</a>
  {if $smarty.const.BOO_ENABLE_GRAPH_SILLAJ}
  <br />
  <a href="gantt.php?intTaskId={$intTaskId}" title="{#aTitleGanttForTask#}">{#aGantt#}</a>
  {/if}
</p>
{/if}
<form action="{$smarty.server.PHP_SELF}" id="frmTask" method="post" onsubmit="return frmTask_onsubmit(this);">
  <fieldset>    
    {if ! empty($booEdit)}
    <legend>{#editTask#}</legend>    
    <input type="hidden" name="intTaskId" value="{$intTaskId}" />
    <input type="hidden" name="booEdit" value="true" />
    {else}
    <legend>{#addTask#}</legend>  
    {/if}
    <label for="strTask">{#labTask#}</label><input type="text" id="strTask" name="strTask"{if ! empty($booEdit)} value="{$strTask|escape:"html"}"{/if} accesskey="{#accTask#}" /><br />
    <label for="strRem">{#labRem#}</label><input type="text" id="strRem" name="strRem"{if ! empty($booEdit)} value="{$strRem|escape:"html"}"{/if} accesskey="{#accRem#}" /><br />
    <label for="arrProject" accesskey="{#accProject#}">{#labProject#}</label>
    {if ! count($arrProject)}
      <span class="info">{#noProject#}</span>
    {else}
    <select id="arrProject" name="arrProject[]" multiple="multiple">
      {html_options options=$arrProject selected=$arrProjectSelected}
    </select>
    {/if}
    <br />
    <label for="cbxShare" accesskey="{#accShare#}">
      <input id="cbxShare" name="cbxShare" type="checkbox"{if ! empty($booEdit) && $booShare} checked="checked"{/if} />
      {#labShare#}
    </label>
    <br />
    <label for="cbxUseInReport" accesskey="{#accUseInReport#}">
      <input id="cbxUseInReport" name="cbxUseInReport" type="checkbox"{if (! empty($booEdit) && $booUseInReport)  || ! isset($booUseInReport)} checked="checked"{/if} />
      {#labUseInReport#}
    </label>
    <br />
    <button type="submit" accesskey="{#accSubmit#}">{#inpSubmit#}</button>
    <button type="reset" accesskey="{#accReset#}">{#inpReset#}</button>
  </fieldset>
</form>
{if ! empty($booEdit)}
<form action="{$smarty.server.PHP_SELF}" id="frmDeleteTask" method="post" onsubmit="return frmDeleteTask_onsubmit();">
  <p>
    <input type="hidden" name="intTaskId" value="{$intTaskId}" />
    <input type="hidden" name="booDelete" value="1" />
    <button type="submit" accesskey="{#accDelete#}">{#inpDelete#}</button>
  </p>
</form>
{/if}
{include file="footer.tpl"}
