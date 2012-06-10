{config_load file=$fnLanguageTpl section='login'}
{include file='header.tpl'}
<!-- {$smarty.template} -->
<noscript><p class="info">{#javascriptNeeded#}</p></noscript>
<form action="{$smarty.server.PHP_SELF}" id="frmLogin" method="post" onsubmit="return frmLogin_onsubmit(this);">
  <fieldset>
    <legend>{#login#}</legend>
    <label for="strUserId">{#labLogin#}</label><input type="text" id="strUserId" name="strUserId" accesskey="{#accLogin#}" /><br />
    <label for="strPassword">{#labPassword#}</label><input type="password" id="strPassword" name="strPassword" accesskey="{#accPassword#}" /><br />
    <input type="hidden" name="urlDest" value="{$urlDest|default:""}" />
    <input type="hidden" name="strNonce" value="{$strNonce}" />
    <input type="hidden" name="strResponse" value="" />
    <button type="submit" accesskey="{#accSubmit#}">{#inpSubmit#}</button>
    <button type="reset" accesskey="{#accReset#}">{#inpReset#}</button>
  </fieldset>
</form>
<p>
  <a href="user.php" title="{#aTitleCreateAccount#}">{#aCreateAccount#}</a><br />
  <a href="mail.php" title="{#aTitleForgotEmail#}">{#aForgotEmail#}</a>
</p>
<p class="webmaster">
  <a href="mailto:{$smarty.const.STR_ADMIN_EMAIL_SILLAJ}" title="{#aTitleWriteAdmin#}">{#aWriteAdmin#}</a>
</p>
<p class="standard">
  <a href="http://validator.w3.org/check?uri=referer" title="{#xhtmlValid#}"><img src="{$urlImgDir}ico_xhtml.png" alt="XHTML 1.0 strict" height="15" width="80" /></a>
  <a href="http://jigsaw.w3.org/css-validator/" title="{#cssValid#}"><img src="{$urlImgDir}ico_css.png" alt="CSS 3.0" height="15" width="80" /></a>
  <a href="http://www.w3.org/WAI/WCAG1AA-Conformance" title="{#accessValid#}"><img src="{$urlImgDir}ico_wai.png" alt="WAI-AA" height="15" width="80" /></a>
</p>
{include file='footer.tpl'}
