{config_load file=$fnLanguageTpl section='search'}
{include file='header.tpl'}
<!-- {$smarty.template} -->
{if count($arrEvent) > 0}
<div id="events">
  <h3>{$arrEvent|@count} {if count($arrEvent) > 1}{#results#}{else}{#result#}{/if} '{$strKeyword}'</h3>
  <form action="index.php" method="post" id="frmEvents" onsubmit="return frmEvents_onsubmit(this);">
    {include file='tabEvent.tpl'}
    <p>
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
{/if}
{include file='footer.tpl'}
