    <div id="footer">
      <hr />
      {$smarty.now|date_format:$smarty.const.STR_DATE_FORMAT_SILLAJ}<br />
      <a href="http://sillaj.sourceforge.net/" title="{#sillajHomepage#}"{if $smarty.session.strLocale != "en"} lang="en"{/if}>
        {$smarty.const.STR_APPLI_NAME_SILLAJ}
      </a> - {$smarty.const.STR_APPLI_VERSION_SILLAJ}
    </div>
  </body>
</html>


