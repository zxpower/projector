{* called by project.php *}
{config_load file=$fnLanguageTpl section='edit_project'}
{include file="header.tpl"}
<!-- {$smarty.template} -->
{if ! empty($booEdit)}
<p>
  <a href="event.php?intProjectId={$intProjectId}" title="{#aTitleEventForProject#}">{#aEventForProject#}</a>
  {if $smarty.const.BOO_ENABLE_GRAPH_SILLAJ}
  <br />
  <a href="gantt.php?intProjectId={$intProjectId}" title="{#aTitleGanttForProject#}">{#aGantt#}</a>
  {/if}
</p>
{/if}
<form action="{$smarty.server.PHP_SELF}" id="frmProject" method="post" onsubmit="return frmProject_onsubmit(this);">
  <fieldset>        
    {if ! empty($booEdit)}
    <legend>{#editProject#}</legend>
    <input type="hidden" name="intProjectId" value="{$intProjectId}" />
    <input type="hidden" name="booEdit" value="true" />
    {else}
    <legend>{#addProject#}</legend>    
    {/if}    
    <label for="strProject">{#labProject#}</label><input type="text" id="strProject" name="strProject"{if ! empty($booEdit)} value="{$strProject|escape:"html"}"{/if} accesskey="{#accProject#}" /><br />
    <label for="strRem">{#labRem#}</label><input type="text" id="strRem" name="strRem"{if ! empty($booEdit)} value="{$strRem|escape:"html"}"{/if} accesskey="{#accRem#}" /><br />
    <label for="arrTask" accesskey="{#accTask#}">{#labTask#}</label>
    {if ! count($arrTask)}
      <span class="info">{#noTask#}</span>
    {else}
    <select id="arrTask" name="arrTask[]" multiple="multiple">
      {html_options options=$arrTask selected=$arrTaskSelected}
    </select>
    {/if}
    <br />
{*
    <label for="cbxShare" accesskey="{#accShare#}">
      <input id="cbxShare" name="cbxShare" type="checkbox"{if ! empty($booEdit) && $booShare} checked="checked"{/if} />
      {#labShare#}
    </label><br />
*}
    <label for="cbxUseInReport" accesskey="{#accUseInReport#}">
      <input id="cbxUseInReport" name="cbxUseInReport" type="checkbox"{if (! empty($booEdit) && $booUseInReport) || ! isset($booUseInReport)} checked="checked"{/if} />
      {#labUseInReport#}
    </label>
    <br />
    <button type="submit" accesskey="{#accSubmit#}">{#inpSubmit#}</button>
    <button type="reset" accesskey="{#accReset#}">{#inpReset#}</button>
  </fieldset>
</form>
{if ! empty($booEdit)}
<form action="{$smarty.server.PHP_SELF}" id="frmDeleteProject" method="post" onsubmit="return frmDeleteProject_onsubmit();">
  <p>
    <input type="hidden" name="intProjectId" value="{$intProjectId}" />
    <input type="hidden" name="booDelete" value="1" />
    <button type="submit" accesskey="{#accDelete#}">{#inpDelete#}</button>
  </p>
</form>
{/if}
{include file="footer.tpl"}
