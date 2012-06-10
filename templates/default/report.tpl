{config_load file=$fnLanguageTpl section="report"}
{if $booExcel}
  {include file="header_xls.tpl"}
{else}
  {include file="header.tpl"}
  <p>
    {#from#} {$datStart|date_format:$smarty.const.STR_DATE_FORMAT_SILLAJ} {#to#} {$datEnd|date_format:$smarty.const.STR_DATE_FORMAT_SILLAJ}<br />
    {#For#} {if ($arrUser.strFirstname != '') || ($arrUser.strName != '')}
    {$arrUser.strFirstname|escape:"html"} {$arrUser.strName|escape:"html"}
    {else}
    {$arrUser.strUserId|escape:"html"}
    {/if}
  </p>
  {if $booDetail}
  <form id="frmReportDetail" action="#">
    <div>
    <label for="cbxDetail" accesskey="{#accDetail#}">
      <input type="checkbox" id="cbxDetail" onclick="report_toggleDetail(this);" checked="checked" />
      {#labDetail#}
    </label>
    </div>
  </form>
  {/if}
{/if}
<!-- {$smarty.template} -->
<table id="report" summary="Report">
  <tr>
    <th colspan="2">{if $booByProject}{#project#}{else}{#task#}{/if}</th>
    <th colspan="2">{#duration#}</th>
    <th colspan="2">{#labRem#|strip_tags:false}</th>
  </tr>
{section name=i loop=$arrReport}
  {if $smarty.section.i.first || ( $arrReport[$smarty.section.i.index].strMain != $arrReport[$smarty.section.i.index_prev].strMain )}
  <tr class="main">
    <td class="index">{counter}.</td>
    <td class="main">
    {if ! $booOtherUser}<a href="{if $booExcel}http://{$smarty.server.SERVER_NAME}{$smarty.const.URL_ROOT_DIR_SILLAJ}{/if}event.php?{if $booByProject}intProjectId{else}intTaskId{/if}={$arrReport[i].intMainId}" title="{#seeEvents#}">{/if}{$arrReport[i].strMain|escape:"html"}{if ! $booOtherUser}</a>{/if}    
    </td>    
    <td class="duration">{$arrReport[i].timDurationTotMain}</td>
    <td class="percent">{$arrReport[i].numPcentDurationTotMain}&nbsp;%</td>
    <td class="rem">{$arrReport[i].strRemM}</td>
  </tr>
  {/if}
  {if $booDetail}<tr class="detail">
    <td class="sub" colspan="2">{$arrReport[i].strSub|escape:"html"}</td>
    <td class="duration">{$arrReport[i].timDurationTotSub}</td>
    <td class="percent">{$arrReport[i].numPcentDurationTotSub}&nbsp;%</td>
    <td class="rem">{$arrReport[i].strRemS}</td>
  </tr>
  {/if}
{/section}
  <tr>
    <th></th>
    <th>{#sumWorked#}</th>
    <th>{$strSumWorked}</th>
    <th class="percent">100&nbsp;%</th>
    <th></th>
  </tr>
</table>
{if $booExcel}
{include file='footer_xls.tpl'}
{else}
<p class="noprint">
  <a href="{$smarty.server.REQUEST_URI|replace:"&":"&amp;"}&amp;cbxExcel=on" title="{#excelDownload#}"><img src="{$urlImgDir}ico_sxw.png" alt="Excel" /></a>
</p>  
{include file="footer.tpl"}
{/if}
