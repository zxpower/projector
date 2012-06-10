<?xml version="1.0" encoding="iso-8859-1"?>
<xsl:stylesheet version="1.0" xmlns:xsl="http://www.w3.org/1999/XSL/Transform" xmlns:a="http://www.w3.org/2005/Atom" xmlns:xhtml="http://www.w3.org/1999/xhtml" xmlns="http://www.w3.org/1999/xhtml" exclude-result-prefixes="a xhtml">
  <xsl:output method="xml" encoding="iso-8859-1" doctype-public="-//W3C//DTD XHTML 1.1//EN" doctype-system="http://www.w3.org/TR/xhtml11/DTD/xhtml11.dtd"/>

  
  <xsl:template match="*"/><!-- Ignore unknown elements -->
  <xsl:template match="*" mode="links"/>
  <xsl:template match="*" mode="categories"/>

  <xsl:template match="a:feed">
    <html xml:lang="fr">
      <head>

        <title><xsl:value-of select="a:title"/></title>
        <link rel="stylesheet" href="templates/default/styles/default.css" type="text/css"/>
      </head>
      <body>
        <div id="atomLogo"><img src="{a:logo}" alt="" /></div>
        <h1><xsl:apply-templates select="a:title" mode="text-construct"/></h1>
        <p>ID : <xsl:value-of select="a:id"/></p>

        <p>Mise à jour : <xsl:value-of select="a:updated"/></p>
        <xsl:apply-templates/>
      </body>
    </html>
  </xsl:template>

  <xsl:template match="a:summary">
    <div class="summary">
      <xsl:apply-templates select="." mode="text-construct"/>

    </div>
  </xsl:template>

  <xsl:template match="a:content">
    <div class="content">
      <xsl:apply-templates select="." mode="text-construct"/>
    </div>
  </xsl:template>

  <xsl:template match="a:entry">

    <div class="entry">
      <h2><xsl:apply-templates select="a:title" mode="text-construct"/></h2>
      <div class="categories">    	
    	<xsl:apply-templates select="a:category" mode="categories"/>
    	<xsl:text> &gt;</xsl:text>
      </div>
      <xsl:apply-templates/>
      <div class="links">
	       <xsl:text/>Liens : <xsl:apply-templates select="a:link" mode="links"/>

      </div>
      <div class="id">ID : <xsl:value-of select="a:id"/></div>
      <div class="updated">Mise à jour : <xsl:value-of select="a:updated"/></div>
      
    </div>
  </xsl:template>

  <xsl:template match="a:link" mode="links">
    <a href="{@href}">

      <xsl:value-of select="@rel"/>
      <xsl:if test="not(@rel)">[generic link]</xsl:if>
      <xsl:if test="@type">
	<xsl:text> (</xsl:text><xsl:value-of select="@type"/><xsl:text>) </xsl:text>
      </xsl:if>
      <xsl:value-of select="@title"/>
    </a>

    <xsl:if test="position() != last()">
      <xsl:text> | </xsl:text>
    </xsl:if>
  </xsl:template>

  <xsl:template match="a:category" mode="categories">
    <xsl:value-of select="@label"/>
    <xsl:if test="position() != last()">

      <xsl:text> | </xsl:text>
    </xsl:if>
  </xsl:template>

  <xsl:template match="*[@type='text']|*[not(@type)]" mode="text-construct">
    <xsl:value-of select="node()"/>
  </xsl:template>

  <xsl:template match="*[@type='xhtml']" mode="text-construct">

    <xsl:copy-of select="node()"/>
  </xsl:template>

</xsl:stylesheet>
