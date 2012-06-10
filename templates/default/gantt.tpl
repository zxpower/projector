{config_load file=$fnLanguageTpl section='gantt'}
{include file='header.tpl'}
<!-- {$smarty.template} -->
<div><!-- Due to technical restrictions Sillaj can't render Gantt charts on Sourceforge. Sorry -->
  <img src="{$smarty.const.URL_CACHE_SILLAJ}{$fnImage}" ismap="ismap" usemap="#gantt" alt="Gantt" />
  {$strCsim}
</div>
<form action="{$smarty.server.PHP_SELF}" id="frmGanttNav" method="get" class="noprint">
  <div>
    <a href="{$smarty.server.PHP_SELF}?{$strMain}={$intObjId}&amp;intSpan={$intSpan}&amp;datEndGantt={$datPrev}" title="{#aPrevGantt#}">{#aPrevGantt#} &lt;</a>  
    
    <select name="intSpan" id="intSpan" title="{#selSpan#}" onchange="frmGanttNav_intSpan_onchange(this)">
      {html_options values=$arrGanttSpan selected=$intSpan output=$arrGanttSpan}
    </select>
    <input type="hidden" name="{$strMain}" value="{$intObjId}" />
    <input type="hidden" name="datEnd" value="{$datEnd}" />      
    
    <a href="{$smarty.server.PHP_SELF}?{$strMain}={$intObjId}&amp;intSpan={$intSpan}&amp;datEndGantt={$datNext}" title="{#aNextGantt#}">&gt; {#aNextGantt#}</a>
  </div>
</form>  

{include file='footer.tpl'}
