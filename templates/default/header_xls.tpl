{config_load file=$fnLanguageTpl section='report'}
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="{$smarty.session.strLocale}" lang="{$smarty.session.strLocale}">
<head>
<meta http-equiv="Content-type" content="text/html; charset={$smarty.const.STR_CHARSET_SILLAJ}" />
<meta http-equiv="Content-language" content="{$smarty.session.strLocale}" />
<meta name="description" content="{$smarty.const.STR_META_DESCRIPTION_SILLAJ}" />
<meta name="keywords" content="{$smarty.const.STR_META_KEYWORDS_SILLAJ}" />
<meta name="author" content="{$smarty.const.STR_META_AUTHOR_EMAIL_SILLAJ}" />
<meta name="generator" content=" {$smarty.const.STR_APPLI_NAME_SILLAJ} - {$smarty.const.STR_APPLI_VERSION_SILLAJ}" />
<meta name="DC.Language" content="fr" scheme="RFC1766" />
<meta name="DC.Publisher" content="{$smarty.const.STR_META_AUTHOR_EMAIL_SILLAJ}" />
<meta name="DC.Creator" content="{$smarty.const.STR_AUTHOR_SILLAJ} - {$smarty.const.STR_AUTHOR_EMAIL_SILLAJ}" />
<meta name="DC.Date.created" content="2005-04-06" scheme="W3CDTF" />
<meta name="DC.Date.issued" content="{$smarty.now|date_format:'%Y-%m-%d'}" scheme="W3CDTF" />
<title>{$smarty.const.STR_SITE_NAME_SILLAJ} &gt; {$strPageTitle}</title>
<link rel="schema.DC" href="http://purl.org/dc/elements/1.1/" />
<style type="text/css">
{literal}<!-- 
.main {
    background-color:silver;
} 
-->{/literal}
</style>
</head>
<body>
