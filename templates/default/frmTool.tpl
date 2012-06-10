{config_load file=$fnLanguageTpl section='tool'}
{include file='header.tpl'}
<!-- {$smarty.template} -->
<h3>{#move#}</h3>
<form action="{$smarty.server.PHP_SELF}" id="frmMove" method="post" onsubmit="return frmMove_onsubmit(this);">
  <fieldset>
  <legend>{#from#}</legend>
    {include file='frmProjectTask.tpl'}
  </fieldset>  
  <fieldset>
  <legend>{#to#}</legend>
    {include file='frmProjectTask.tpl'}
  </fieldset>
  <button type="submit" accesskey="{#accSubmit#}">{#inpSubmit#}</button>
  <button type="reset" accesskey="{#accReset#}">{#inpReset#}</button> 
</form>
{include file='footer.tpl'}
