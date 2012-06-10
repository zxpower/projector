{* called by report.php *}
{config_load file=$fnLanguageTpl section='report'}
{include file='header.tpl'}
<!-- {$smarty.template} -->
<form action="{$smarty.server.PHP_SELF}" id="frmReport" method="get" onsubmit="return frmReport_onsubmit(this);">    

   <fieldset id="fldDate">  
    {if $smarty.const.BOO_ALLOW_EVERYONE_REPORT_SILLAJ}
    <fieldset id="fldUser">
      <legend>{#user#}</legend>
      <label for="strUserId" accesskey="{#accFor#}">{#labFor#}</label>
      <select id="strUserId" name="strUserId">
        {html_options options=$arrUser selected=$smarty.session.strUserId}
      </select>
    </fieldset>
    {/if}
    
    <fieldset id="fldReportType">
      <legend>{#reportType#}</legend>
      <label for="radProject" accesskey="{#accProject#}">
        <input id="radProject" name="radType" type="radio" value="project" checked="checked" />
        {#labProject#}
      </label>
      <label for="radTask" accesskey="{#accTask#}">
        <input id="radTask" name="radType" type="radio" value="task" />
        {#labTask#}
      </label><br />
      <label for="cbxDetail" accesskey="{#accDetail#}" >
        <input id="cbxDetail" name="cbxDetail" type="checkbox" checked="checked"/>
        {#labDetail#}
      </label>
    </fieldset>
    
    <fieldset id="fldSort">
      <legend>{#sort#}</legend>
      <label for="radTime" accesskey="{#accTime#}">
        <input id="radTime" name="radSort" type="radio" value="time" checked="checked" />
        {#labTime#}
      </label>
      <label for="radAlpha" accesskey="{#accAlpha#}">
        <input id="radAlpha" name="radSort" type="radio" value="alpha" />
        {#labAlpha#}
      </label>    
    </fieldset>
  
    <legend>{#timeInterval#}</legend>
    <button type="button" onclick="frmReport_updateDates('{$datStartPreviousWeek|date_format:$smarty.const.STR_DATE_FORMAT_SILLAJ}', '{$datEndPreviousWeek|date_format:$smarty.const.STR_DATE_FORMAT_SILLAJ}')">{#previousWeek#}</button>
    <button type="button" onclick="frmReport_updateDates('{$datStartCurrentWeek|date_format:$smarty.const.STR_DATE_FORMAT_SILLAJ}', '{$datEndCurrentWeek|date_format:$smarty.const.STR_DATE_FORMAT_SILLAJ}')">{#currentWeek#}</button>
    <button type="button" onclick="frmReport_updateDates('{$datStartPreviousMonth|date_format:$smarty.const.STR_DATE_FORMAT_SILLAJ}', '{$datEndPreviousMonth|date_format:$smarty.const.STR_DATE_FORMAT_SILLAJ}')">{#previousMonth#}</button>
    <button type="button" onclick="frmReport_updateDates('{$datStartCurrentMonth|date_format:$smarty.const.STR_DATE_FORMAT_SILLAJ}', '{$datEndCurrentMonth|date_format:$smarty.const.STR_DATE_FORMAT_SILLAJ}')">{#currentMonth#}</button>
    <button type="button" onclick="frmReport_updateDates('{$datStartPreviousYear|date_format:$smarty.const.STR_DATE_FORMAT_SILLAJ}', '{$datEndPreviousYear|date_format:$smarty.const.STR_DATE_FORMAT_SILLAJ}')">{#previousYear#}</button>
    <button type="button" onclick="frmReport_updateDates('{$datStartCurrentYear|date_format:$smarty.const.STR_DATE_FORMAT_SILLAJ}', '{$datEndCurrentYear|date_format:$smarty.const.STR_DATE_FORMAT_SILLAJ}')">{#currentYear#}</button><br />    
    
    <script type="text/javascript">
      var cal1 = new CalendarPopup('divcal');
      cal1.setMonthNames({foreach from=$arrMonthNames item=m name=fem}'{$m}'{if ! $smarty.foreach.fem.last},{/if}{/foreach});
      cal1.setDayHeaders({foreach from=$arrDayIni item=d name=fed}'{$d}'{if ! $smarty.foreach.fed.last},{/if}{/foreach});
      cal1.setTodayText('{#liToday#|escape:"quotes"}');
      cal1.setWeekStartDay({$smarty.const.INT_START_WEEK_DAY_SILLAJ});
      cal1.setCssPrefix('CAL');
      cal1.showNavigationDropdowns();
    </script>    
    <div id="divcal" style="position:absolute;visibility:hidden;background-color:white;layer-background-color:white;"></div>
    
    <label for="datStart" accesskey="{#accDatStart#}">{#labDatStart#}</label>
    <input type="text" id="datStart" name="datStart" value="{$datStartCurrentMonth|date_format:$smarty.const.STR_DATE_FORMAT_SILLAJ}" maxlength="10" size="10" />    
    <a href="#" onclick="cal1.select(document.forms['frmReport'].datStart, 'anchor2', '{$strDateFormatCal}'); return false;" title="{#choseDate#}" name="anchor2" id="anchor2">
      <img src="{$urlImgDir}ico_cal.gif" id="ico_cal2" alt="{#choseDate#}" />
    </a>        
    <br />
    
    <label for="datEnd" accesskey="{#accDatEnd#}">{#labDatEnd#}</label>
    <input type="text" id="datEnd" name="datEnd" value="{$datEndCurrentMonth|date_format:$smarty.const.STR_DATE_FORMAT_SILLAJ}" maxlength="10" size="10" /> 
    <a href="#" onclick="cal1.select(document.forms['frmReport'].datEnd, 'anchor1', '{$strDateFormatCal}'); return false;" title="{#choseDate#}" name="anchor1" id="anchor1">
      <img src="{$urlImgDir}ico_cal.gif" id="ico_cal1" alt="{#choseDate#}" />
    </a>    
       
    <div>
      <button type="submit" accesskey="{#accSubmit#}">{#inpSubmit#}</button>
      <button type="reset" accesskey="{#accReset#}">{#inpReset#}</button>
    </div>     
  </fieldset>    
</form>
{if $smarty.const.BOO_ENABLE_GRAPH_SILLAJ}
<form action="gantt.php" id="frmReportGantt" method="get" onsubmit="return frmReportGantt_onsubmit(this);">    
  <fieldset id="fldReportGantt">
    <legend>{#aGantt#}</legend>
      {include file='frmProjectTask.tpl' booNoXhr=true}
    <div>
      <button type="submit" accesskey="{#accSubmit#}">{#inpSubmit#}</button>
      <button type="reset" accesskey="{#accReset#}">{#inpReset#}</button>
    </div>  
  </fieldset>    
</form>
{/if}
{include file='footer.tpl'}
