{config_load file=$fnLanguageTpl section="task"}
{include file="header.tpl"}
<!-- {$smarty.template} -->
{if ! empty($strMessage)}<p class="info">{$strMessage}</p>{/if}
<p><a href="task.php?add=1" title="{#aTitleAddTask#}">{#aAddTask#}</a></p>
{if count($arrTask) == 0}
<p class="info">{$smarty.const.STR_TASK_NOT_FOUND_SILLAJ}</p>
{else}
<ul>
  {foreach key=intTaskId item=strTask from=$arrTask}
  <li>
   <a href="{$smarty.server.PHP_SELF}?intTaskId={$intTaskId}" title="{#titleEdit#}">{$strTask|escape:"html"}</a>
  </li>
  {/foreach}
</ul>
{/if}
{include file="footer.tpl"}
