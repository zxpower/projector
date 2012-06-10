{config_load file=$fnLanguageTpl section='index'}
{include file='header.tpl' strOnload="document.getElementById('timStart').focus();"}
<!-- {$smarty.template} -->
<div id="formAndCalendar">
  {if ! empty($strMessage)}<p class="info">{$strMessage}</p>{/if}
  <div id="calendarBox">
    {calendar year=$intYearEvent month=$intMonthEvent day=$intDayEvent events=$arrEventMonth}
  </div>
  <ul id="calendarKey">
    <li class="daySelected">{#liDaySelected#}</li>
    <li><a href="?datEvent={$smarty.now|date_format:'%Y-%m-%d'}" title="{#liToday#}"><span class="today">{#liToday#}</span></a></li>    
    <li class="dayEvent">{#liDayEvent#}</li>
  </ul>
  <form action="{$smarty.server.PHP_SELF}" id="frmEvent" method="post" onsubmit="return frmEvent_onsubmit(this);">
    <fieldset>
      <legend>{if ! empty($booEdit)}{#legEditEvent#}{else}{#legAddEvent#}{/if}</legend>
      {include file='frmProjectTask.tpl'}
      <br />
{*
      <div class="intervalInput">
        <label for="timDuration">{#labTimDuration#}</label><input type="text" id="timDuration" name="timDuration" accesskey="{#accTimDuration#}"{if ! empty($booEdit)} value="{$arrCurrentEvent.timDuration}"{/if} /> hh:mm<br />
      </div>
*}
      <div class="intervalInput">
        <label for="timStart">{*{#or#} *}{#labTimStart#}</label><input type="text" id="timStart" name="timStart" accesskey="{#accTimStart#}"{if ! empty($booEdit)} value="{$arrCurrentEvent.timStart}"{/if} /> hh:mm<br />
        <label for="timEnd">{#labTimEnd#}</label><input type="text" id="timEnd" name="timEnd" accesskey="{#accTimEnd#}"{if ! empty($booEdit)} value="{$arrCurrentEvent.timEnd}"{/if} /> hh:mm<br />
      </div>
      <label for="strRem">{#labRem#}</label><input type="text" id="strRem" name="strRem" accesskey="{#accRem#}"{if ! empty($booEdit)} value="{$arrCurrentEvent.strRem|escape:"html"}"{/if} /><br />
      <button type="submit" accesskey="{#accSubmit#}">{#inpSubmit#}</button>
      <button type="reset" accesskey="{#accReset#}">{#inpReset#}</button>
      <input type="hidden" name="datEvent" value="{$datEvent}" />
      {if ! empty($booEdit)}
      <input type="hidden" name="booEdit" value="true" />
      <input type="hidden" name="intEventId" value="{$intEventId}" />
      {/if}
    </fieldset>
  </form>
</div>
{if count($arrEvent) > 0}
<div id="events">
  <form action="{$smarty.server.PHP_SELF}" method="post" id="frmEvents" onsubmit="return frmEvents_onsubmit(this);">
    {include file='tabEvent.tpl'}
    <p>{if $strSum != '00:00:00'}{#sumByDay#} : {$strSum}<br />{/if}
      <input type="hidden" name="datEvent" value="{$datEvent}" />
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
<p class="standard">
  <a href="rss.php?strUserId={$smarty.session.strUserId}" title="{$smarty.const.STR_SITE_NAME_SILLAJ} {#for#} {$smarty.session.strUserId} ({#rssFeed#})">
    <img src="{$urlImgDir}ico_rss.png" alt="RSS" height="15" width="80" />
  </a>
  <a href="atom.php?strUserId={$smarty.session.strUserId}" title="{$smarty.const.STR_SITE_NAME_SILLAJ} {#for#} {$smarty.session.strUserId} ({#atomFeed#})">
    <img src="{$urlImgDir}ico_atom.png" alt="Atom" height="15" width="80" />
  </a>
</p>
{include file='footer.tpl'}
