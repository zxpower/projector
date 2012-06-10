<?xml version="1.0" encoding="{$smarty.const.STR_CHARSET_SILLAJ}"?>
<OpenSearchDescription xmlns="http://a9.com/-/spec/opensearch/1.1/" xmlns:moz="http://www.mozilla.org/2006/browser/search/">
<ShortName>{$smarty.const.STR_SITE_NAME_SILLAJ}</ShortName>
<Description>{$smarty.const.STR_META_DESCRIPTION_SILLAJ}</Description>
<InputEncoding>{$smarty.const.STR_CHARSET_SILLAJ}</InputEncoding>
<Image width="16" height="16" type="image/x-icon">http://{$smarty.server.SERVER_NAME}{$smarty.const.URL_ROOT_DIR_SILLAJ}favicon.ico</Image>
<Url type="text/html" method="get" template="http://{$smarty.server.SERVER_NAME}{$smarty.const.URL_ROOT_DIR_SILLAJ}search.php?strKeyword={ldelim}searchTerms{rdelim}" />
<moz:SearchForm>http://{$smarty.server.SERVER_NAME}{$smarty.const.URL_ROOT_DIR_SILLAJ}</moz:SearchForm>
</OpenSearchDescription>
