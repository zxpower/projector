<?xml version="1.0" encoding="{$smarty.const.STR_CHARSET_SILLAJ}"?>
<?xml-stylesheet href="templates/default/styles/atom.xsl" type="text/xsl" ?>
<feed xmlns="http://www.w3.org/2005/Atom">
    <title type="text">{$smarty.const.STR_SITE_NAME_SILLAJ}</title>
    <subtitle type="text">{$smarty.const.STR_META_DESCRIPTION_SILLAJ}</subtitle>
    <updated>{$smarty.now|date_format_w3cdtf}</updated>
    <id>tag:{$smarty.server.SERVER_NAME},{$smarty.now|date_format:"%Y-%m-%d"}:{$smarty.const.STR_APPLI_NAME_SILLAJ}</id>
    <link rel="alternate" type="application/xhtml+html" hreflang="{$smarty.session.strLocale}" href="http://{$smarty.server.SERVER_NAME}{$smarty.const.URL_ROOT_DIR_SILLAJ}" />
    <link rel="self" type="application/atom+xml" href="http://{$smarty.server.SERVER_NAME}{$smarty.server.SCRIPT_NAME}" />
    <rights>{$smarty.const.STR_ADMIN_EMAIL_SILLAJ}</rights>
    <generator version="{$smarty.const.STR_APPLI_VERSION_SILLAJ}">{$smarty.const.STR_APPLI_NAME_SILLAJ}</generator>
    <icon>http://{$smarty.server.SERVER_NAME}{$smarty.const.URL_ROOT_DIR_SILLAJ}favicon.ico</icon>
    <logo>http://{$smarty.server.SERVER_NAME}{$smarty.const.URL_ROOT_DIR_SILLAJ}templates/default/img/logo_sillaj.png</logo>
    {section name=i loop=$arrAtom}
    <entry>
        <title>{$arrAtom[i].strProject|escape:"html"} - {$arrAtom[i].strTask|escape:"html"} - {$arrAtom[i].datEvent|date_format:$smarty.const.STR_DATE_FORMAT_SILLAJ} {$arrAtom[i].timStart}</title>
        <link rel="alternate" type="application/xhtml+html" href="http://{$smarty.server.SERVER_NAME}{$smarty.const.URL_ROOT_DIR_SILLAJ}?intEventId={$arrAtom[i].intEventId}" />    
        <id>tag:{$smarty.server.SERVER_NAME},{$smarty.now|date_format:"%Y-%m-%d"}:{$smarty.const.STR_APPLI_NAME_SILLAJ}-{$arrAtom[i].intEventId}</id>
        <updated>{$arrAtom[i].datUpdate|date_format_w3cdtf}</updated>
        <published>{$arrAtom[i].datEvent|date_format_w3cdtf}</published>
        <author>
        <name>{$strUserId|escape:"html"}</name>
        <email></email>
        </author>
        <summary>{if ($arrAtom[i].timStart != '') && ($arrAtom[i].timEnd != '')}{$arrAtom[i].timStart} -&gt; {$arrAtom[i].timEnd} = {/if}{$arrAtom[i].timDuration}{if $arrAtom[i].strRem != ''} - {$arrAtom[i].strRem|escape:"html"}{/if}</summary> 
        <category term="{$arrAtom[i].intProjectId}" label="{$arrAtom[i].strProject|escape:"html"}" />       
    </entry>
    {/section}
</feed>
