{config_load file=$fnLanguageTpl}
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="{$smarty.session.strLocale}" lang="{$smarty.session.strLocale}">
<head>
<meta http-equiv="Content-type" content="text/html; charset={$smarty.const.STR_CHARSET_SILLAJ}" />
<meta http-equiv="Content-language" content="{$smarty.session.strLocale}" />
<meta name="description" content="{$smarty.const.STR_META_DESCRIPTION_SILLAJ}" />
<meta name="keywords" content="{$smarty.const.STR_META_KEYWORDS_SILLAJ}" />
<meta name="author" content="{if empty($smarty.session.strEmail)}{$smarty.const.STR_ADMIN_EMAIL_SILLAJ}{else}{$smarty.session.strEmail}{/if}" />
<meta name="robots" content="index,follow" />
<meta name="generator" content="{$smarty.const.STR_APPLI_NAME_SILLAJ}/{$smarty.const.STR_APPLI_VERSION_SILLAJ}" />
<meta name="DC.Language" content="{$smarty.session.strLocale}" scheme="RFC1766" />
<meta name="DC.Publisher" content="{$smarty.const.STR_ADMIN_EMAIL_SILLAJ}" />
<meta name="DC.Creator" content="{$smarty.const.STR_AUTHOR_SILLAJ} - {$smarty.const.STR_AUTHOR_EMAIL_SILLAJ}" />
<meta name="DC.Date.created" content="2005-02-02" scheme="W3CDTF" />
<meta name="DC.Date.issued" content="{$smarty.now|date_format_w3cdtf}" scheme="W3CDTF" />
<meta name="DC.Title" content="{$smarty.const.STR_SITE_NAME_SILLAJ}{$smarty.const.STR_SEP_SILLAJ}{$strPageTitle}" />
<title>{$smarty.const.STR_SITE_NAME_SILLAJ}{$smarty.const.STR_SEP_SILLAJ}{$strPageTitle}</title>
<link rel="schema.DC" href="http://purl.org/dc/elements/1.1/" />
<link rel="shortcut icon" type="image/x-icon" href="{$smarty.const.URL_ROOT_DIR_SILLAJ}favicon.ico" />
<link rel="stylesheet" type="text/css" href="{$urlThemeDir}styles/default.css" media="all" title="{#defaultTheme#}" />
{section name=i loop=$arrCss}
<link rel="alternate stylesheet" type="text/css" href="{$urlThemeDir}styles/{$arrCss[i].fnCss}" media="all" title="{#theme#} {$arrCss[i].strNameCss}" />
{/section}
<link rel="stylesheet" type="text/css" href="{$urlThemeDir}styles/print.css" media="print" />
{if basename($smarty.server.SCRIPT_NAME) != 'login.php'}<link rel="alternate" type="application/atom+xml" href="{$smarty.const.URL_ROOT_DIR_SILLAJ}atom.php?strUserId={$smarty.session.strUserId}" title="{#atomFeed#}" />
<link rel="alternate" type="application/rss+xml" href="{$smarty.const.URL_ROOT_DIR_SILLAJ}rss.php?strUserId={$smarty.session.strUserId}" title="{#rssFeed#}" />
{/if}
<link rel="search" type="application/opensearchdescription+xml" href="{$smarty.const.URL_ROOT_DIR_SILLAJ}opensearch.php" title="{$smarty.const.STR_SITE_NAME_SILLAJ}" />
{if basename($smarty.server.SCRIPT_NAME) == 'index.php'}
<link rel="start" href="?datEvent={$smarty.now|date_format:'%Y-%m-%d'}" title="{#liToday#}" />
<link rel="prev" href="?datEvent={$datYesterday}" title="{#dayPrev#}" />
<link rel="next" href="?datEvent={$datTomorrow}" title="{#dayNext#}" />
{/if}
{if basename($smarty.server.SCRIPT_NAME) == 'gantt.php'}
<link rel="prev" href="{$smarty.server.PHP_SELF}?{$strMain}={$intObjId}&amp;intSpan={$intSpan}&amp;datEndGantt={$datPrev}" title="&lt;" />
<link rel="next" href="{$smarty.server.PHP_SELF}?{$strMain}={$intObjId}&amp;intSpan={$intSpan}&amp;datEndGantt={$datNext}" title="&gt;" />
{/if}
<script type="text/javascript" src="{$smarty.const.URL_ROOT_DIR_SILLAJ}lang/{$smarty.session.strLocale}/lang.js"></script>
{if ! empty($strNonce)}<script type="text/javascript" src="{$smarty.const.URL_ROOT_DIR_SILLAJ}scripts/md5.js"></script>{/if}    
<script type="text/javascript" src="{$smarty.const.URL_ROOT_DIR_SILLAJ}scripts/sillaj.js"></script>
{if ! empty($booCal)}<script type="text/javascript" src="{$smarty.const.URL_ROOT_DIR_SILLAJ}scripts/CalendarPopup.js"></script>
<link rel="stylesheet" type="text/css" href="{$urlThemeDir}styles/calendar.css" media="screen" />{/if}
</head>
<body{if ! empty($strOnload)} onload="{$strOnload}"{/if}>
  <div id="header">
    <a href="{$smarty.const.URL_ROOT_DIR_SILLAJ}" title="{#appliHome#}">
      <img src="{$urlImgDir}logo_sillaj.png" width="64" height="70" id="logo" alt="{$smarty.const.STR_APPLI_NAME_SILLAJ}" />
    </a>
    <h1><a href="{$smarty.const.URL_ROOT_DIR_SILLAJ}" title="{#appliHome#}">{$smarty.const.STR_SITE_NAME_SILLAJ}</a></h1>    
    {if $booDisplayMenu}
    <div id="toolbar">
      <ul id="menu">     
        {foreach key=urlFile from=$arrMenu item=arrDetail}
        {if $arrDetail.booDisplay}<li{if $urlFile == basename($smarty.server.SCRIPT_NAME)} id="menuTabSelected"{/if}><a href="{$urlFile}" title="{$arrDetail.strTip}">{$arrDetail.strMenu}</a></li>{/if}
        {/foreach}      
      </ul>
      <form action="search.php" method="get" id="frmSearch" onsubmit="return frmSearch_onsubmit(this);">
        <div>
          <input type="text" id="strKeyword" name="strKeyword" accesskey="{#accKeyword#}"{if ! empty($strKeyword)} value="{$strKeyword}"{/if} />
          <button type="submit" accesskey="{#accSubmit#}">{#labKeyword#}</button>
        </div>
      </form>
      <!-- <a href="tool.php" title="{#aTitleTools#}"><img src="{$urlImgDir}ico_tools.png" alt="{#altTools#}" width="22" height="22" /></a> -->
    </div>    
    {/if}
    <h2>{$strPageTitle}</h2>
  </div>
