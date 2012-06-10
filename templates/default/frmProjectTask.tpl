{* called by index.tpl and tool.tpl and frmReport.tpl *}
<!-- {$smarty.template} -->
<label for="intProjectId" accesskey="{#accProject#}">{#labProject#}</label>
{if ! count($arrProject)}
  <span class="info">{#noProject#} <a href="project.php?add=1" title="{#aProject#}">+</a></span>
{else}
<select id="intProjectId" name="intProjectId" {if empty($booNoXhr)}onchange="frmEvent_intProjectId_onchange(this)"{/if}>
  <option value="0" label=""></option>
  {if ! empty($booEdit)}
  {html_options options=$arrProject selected=$arrCurrentEvent.intProjectId}
  {else}
  {html_options options=$arrProject selected=$intLastProjectId}
  {/if}
</select>
{/if}
<br />
<label for="intTaskId" accesskey="{#accTask#}">{if ! empty($booNoXhr)}{#or#} {/if}{#labTask#}</label>
{if ! count($arrTask)}
  <span class="info">{#noTask#} <a href="task.php?add=1" title="{#aTask#}">+</a></span>
{else}
<select id="intTaskId" name="intTaskId">
  <option value="0" label=""></option>
  {if ! empty($booEdit)}
  {html_options options=$arrTask selected=$arrCurrentEvent.intTaskId}
  {else}
  {html_options options=$arrTask selected=$intLastTaskId}
  {/if}
</select>
{/if}
