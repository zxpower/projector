{config_load file=$fnLanguageTpl section='event'}
{include file='header.tpl'}
<!-- {$smarty.template} -->
{if count($arrEvent) > 0}
<div id="events">
  <h3>{if $booProject}{#project#}{else}{#task#}{/if} : {$arrEvent[0].strSub}</h3>
  <form action="index.php" method="post" id="frmEvents" onsubmit="return frmEvents_onsubmit(this);">
    {include file='tabEvent.tpl'}
    <p>{if $strSum != '00:00:00'}{#sumWorked#} : {$strSum}<br />{/if}
    <script type="text/javascript">
      <!--
      strIniEdit = '{#inpEdit#}';
      strIniDelete = '{#inpDelete#}';
      // -->
    </script>
    <button type="submit" name="inpEdit" id="inpEdit" value="edit" accesskey="{#accEdit#}" onclick="this.setAttribute('value', 'edit');assignSubmitButton(this)">{#inpEdit#}</button>
    <button type="submit" name="inpDelete" id="inpDelete" value="delete" accesskey="{#accDelete#}" onclick="this.setAttribute('value', 'delete');assignSubmitButton(this)">{#inpDelete#}</button>
    </p>
  </form>
</div>
{if $smarty.const.BOO_ENABLE_GRAPH_SILLAJ}
<p class="noprint"><a href="gantt.php?{if $booProject}intProjectId{else}intTaskId{/if}={$intObjId}&amp;datEndGantt={$datLastEvent}">{#aGantt#}</a></p>
{/if}
{/if}
{include file='footer.tpl'}
