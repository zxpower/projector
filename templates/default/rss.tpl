<?xml version="1.0" encoding="{$smarty.const.STR_CHARSET_SILLAJ}"?>

<rdf:RDF
 xmlns:rdf="http://www.w3.org/1999/02/22-rdf-syntax-ns#"
 xmlns="http://purl.org/rss/1.0/"
 xmlns:dc="http://purl.org/dc/elements/1.1/"
 xmlns:syn="http://purl.org/rss/1.0/modules/syndication/"
>

<channel rdf:about="http://{$smarty.server.SERVER_NAME}/">
<title>{$smarty.const.STR_SITE_NAME_SILLAJ}</title>
<link>http://{$smarty.server.SERVER_NAME}{$smarty.const.URL_ROOT_DIR_SILLAJ}</link>
<description>{$smarty.const.STR_META_DESCRIPTION_SILLAJ}</description>
<dc:language>{$smarty.session.strLocale}-{$smarty.session.strLocale|upper}</dc:language>
<dc:date>{$smarty.now|date_format_w3cdtf}</dc:date>

<dc:publisher>{$smarty.const.STR_ADMIN_EMAIL_SILLAJ}</dc:publisher>
<dc:creator>{$strUserId}</dc:creator>
<dc:subject>{$smarty.const.STR_META_DESCRIPTION_SILLAJ}</dc:subject>
<syn:updatePeriod>hourly</syn:updatePeriod>
<syn:updateFrequency>1</syn:updateFrequency>
<syn:updateBase>1970-01-01T00:00+00:00</syn:updateBase>
<items>
 <rdf:Seq>
  {section name=i loop=$arrRss}
  <rdf:li rdf:resource="http://{$smarty.server.SERVER_NAME}{$smarty.const.URL_ROOT_DIR_SILLAJ}?intEventId={$arrRss[i].intEventId}" />
  {/section}
 </rdf:Seq>
</items>
<image rdf:resource="http://{$smarty.server.SERVER_NAME}{$smarty.const.URL_ROOT_DIR_SILLAJ}templates/default/img/logo_sillaj.png" />
</channel>

<image rdf:about="http://{$smarty.server.SERVER_NAME}{$smarty.const.URL_ROOT_DIR_SILLAJ}templates/default/img/logo_sillaj.png">
<title>{$smarty.const.STR_SITE_NAME_SILLAJ}</title>
<url>http://{$smarty.server.SERVER_NAME}{$smarty.const.URL_ROOT_DIR_SILLAJ}templates/default/img/logo_sillaj.png</url>
<link>http://{$smarty.server.SERVER_NAME}{$smarty.const.URL_ROOT_DIR_SILLAJ}</link>
</image>

{section name=i loop=$arrRss}
<item rdf:about="http://{$smarty.server.SERVER_NAME}{$smarty.const.URL_ROOT_DIR_SILLAJ}index.php?intEventId={$arrRss[i].intEventId}">
<title>{$arrRss[i].strProject|escape:"html"} - {$arrRss[i].strTask|escape:"html"} - {$arrRss[i].datEvent|date_format:$smarty.const.STR_DATE_FORMAT_SILLAJ} {$arrRss[i].timStart}</title>
<link>http://{$smarty.server.SERVER_NAME}{$smarty.const.URL_ROOT_DIR_SILLAJ}?intEventId={$arrRss[i].intEventId}</link>
<description>{if ($arrRss[i].timStart != '') && ($arrRss[i].timEnd != '')}{$arrRss[i].timStart} -&gt; {$arrRss[i].timEnd} = {/if}{$arrRss[i].timDuration}{if $arrRss[i].strRem != ''} - {$arrRss[i].strRem|escape:"html"}{/if}</description>
<dc:creator>{$strUserId}</dc:creator>
<dc:date>{$arrRss[i].datEvent|date_format_w3cdtf}</dc:date>
<dc:subject>{$arrRss[i].strProject|escape:"html"}</dc:subject>
</item>
{/section}

</rdf:RDF>
