{config_load file=$fnLanguageTpl section="project"}
{include file="header.tpl"}
<!-- {$smarty.template} -->
{if ! empty($strMessage)}<p class="info">{$strMessage}</p>{/if}
<p><a href="project.php?add=1" title="{#aTitleAddProject#}">{#aAddProject#}</a></p>
{if count($arrProject) == 0}
<p class="info">{$smarty.const.STR_PROJECT_NOT_FOUND_SILLAJ}</p>
{else}
<ul>
  {foreach key=intProjectId item=strProject from=$arrProject}
  <li>
   <a href="{$smarty.server.PHP_SELF}?intProjectId={$intProjectId}" title="{#titleEdit#}">{$strProject|escape:"html"}</a>
  </li>
  {/foreach}
</ul>
{/if}
{include file="footer.tpl"}
