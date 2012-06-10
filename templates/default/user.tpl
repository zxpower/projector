{config_load file=$fnLanguageTpl section="user"}
{include file="header.tpl"}
<!-- {$smarty.template} -->
<form action="{$smarty.server.PHP_SELF}" id="frmUser" method="post" onsubmit="return frmUser_onsubmit(this, {if ! empty($booEdit)}true{else}false{/if});" autocomplete="off">
  <fieldset>    
    {if ! empty($booEdit)}
    <legend>{#editUser#}</legend>
    <input type="hidden" name="strUserId" value="{$arrUser.strUserId|escape:"html"}" />
    <input type="hidden" name="booEdit" value="true" />   
    {else}
    <legend>{#addUser#}</legend>
    {/if}
    <label for="strUserId" accesskey="{#accLogin#}">{#labLogin#}</label><input type="text" id="strUserId" name="strUserId" {if ! empty($booEdit)}disabled="disabled" value="{$arrUser.strUserId|escape:"html"}"{/if} /><br />     
    <label for="strName" accesskey="{#accName#}">{#labName#}</label><input type="text" id="strName" name="strName"{if ! empty($booEdit)} value="{$arrUser.strName|escape:"html"}"{/if} /><br />
    <label for="strFirstname" accesskey="{#accFirstname#}">{#labFirstname#}</label><input type="text" id="strFirstname" name="strFirstname"{if ! empty($booEdit)} value="{$arrUser.strFirstname|escape:"html"}"{/if} /><br />
    <label for="strPassword" accesskey="{#accPassword#}">{#labPassword#}</label><input type="password" id="strPassword" name="strPassword" />{if ! empty($booEdit)} {#notModifiedIfEmpty#}{/if}<br />
    <label for="strEmail" accesskey="{#accEmail#}" >{#labEmail#}</label><input type="text" id="strEmail" name="strEmail"{if ! empty($booEdit)} value="{$arrUser.strEmail|escape:"html"}"{/if} /><br />
    {if $smarty.const.BOO_ALLOW_EVERYONE_REPORT_SILLAJ}
    <label for="cbxAllowOther" accesskey="{#accAllowOther#}"><input type="checkbox" id="cbxAllowOther" name="cbxAllowOther"{if ! empty($booEdit) && $arrUser.booAllowOther} checked="checked"{/if} /> {#labAllowOther#}</label><br />
    {/if}
    <label for="cbxUseShare" accesskey="{#accUseShare#}"><input id="cbxUseShare" name="cbxUseShare" type="checkbox"{if ! empty($booEdit) && $arrUser.booUseShare} checked="checked"{/if} />{#labUseShare#}</label><br />  
    <label for="strLanguage" accesskey="{#accLanguage#}">{#labLanguage#}</label>
    <select id="strLanguage" name="strLanguage">
      {html_options options=$arrLanguage selected=$arrUser.strLanguage}
    </select><br />
    <label for="strTemplate" accesskey="{#accTemplate#}">{#labTemplate#}</label>
    <select id="strTemplate" name="strTemplate">
      {html_options values=$arrTemplate output=$arrTemplate selected=$arrUser.strTemplate}
    </select><br />
    <button type="submit" accesskey="{#accSubmit#}">{#inpSubmit#}</button>
    <button type="reset" accesskey="{#accReset#}">{#inpReset#}</button>
  </fieldset>
</form>
{include file="footer.tpl"}
