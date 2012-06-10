{* called by search.tpl, index.tpl, event.tpl *}
<!-- {$smarty.template} -->
<table id="eventsTable" summary="{#sumEvent#}">
  {section name=i loop=$arrEvent}
  <tr{if ! empty($booEdit) && ($arrEvent[i].intEventId == $intEventId)} class="eventEdited"{/if}>    
    {if (basename($smarty.server.PHP_SELF) == 'event.php') || (basename($smarty.server.PHP_SELF) == 'search.php')}
    <td class="date">{$arrEvent[i].datEvent|date_format:$smarty.const.STR_DATE_FORMAT_SILLAJ}</td>
    {/if}
    <td class="interval">{if ($arrEvent[i].timStart != '') || ($arrEvent[i].timEnd != '')}{$arrEvent[i].timStart} - {$arrEvent[i].timEnd}{/if}</td>     
    <td class="duration">{if $arrEvent[i].timDuration != ''}{$arrEvent[i].timDuration}{/if}</td>
    <td class="occupation">
       <input type="radio" id="event{$arrEvent[i].intEventId}" name="intEventId" value="{$arrEvent[i].intEventId}"{if ! empty($booEdit) && ($arrEvent[i].intEventId == $intEventId)} checked="checked"{/if} />
       <label for="event{$arrEvent[i].intEventId}">             
         <span class="project" id="project{$arrEvent[i].intEventId}">{$arrEvent[i].strMain|escape:"html"}</span>
         {if (basename($smarty.server.PHP_SELF) == 'index.php') || (basename($smarty.server.PHP_SELF) == 'search.php')}<br />
         <span class="task" id="task{$arrEvent[i].intEventId}">{$arrEvent[i].strSub|escape:"html"}</span>
         {/if}
       </label>
       {if $arrEvent[i].strRem != ''}
       <p class="rem">
         <label for="event{$arrEvent[i].intEventId}">
           {$arrEvent[i].strRem|escape:"html"}
         </label>      
       </p> 
      {/if}
    </td>
    {if $smarty.session.booUseShare && isset($arrEvent[i].strUserId)}<td class="user">{$arrEvent[i].strUserId|escape:"html"}</td>{/if}
  </tr>
  {/section}
</table>    
