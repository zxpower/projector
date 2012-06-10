{config_load file=$fnLanguageTpl section='user'}
{include file='header.tpl'}
<!-- {$smarty.template} -->
<form action="{$smarty.server.PHP_SELF}" id="frmMail" method="post" onsubmit="return frmMail_onsubmit(this);">
  <fieldset>        
    <legend>{#sendTo#}</legend>
    <label for="strEmail" accesskey="{#accEmail#}" >{#labEmail#}</label><input type="text" id="strEmail" name="strEmail" /><br />
    <button type="submit" accesskey="{#accSubmit#}">{#inpSubmit#}</button>
    <button type="reset" accesskey="{#accReset#}">{#inpReset#}</button>
  </fieldset>
</form>   
{include file='footer.tpl'}
