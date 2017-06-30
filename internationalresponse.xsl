<?xml version="1.0"?>
<!--
Unishippers PriceLink API - Sample Code
 
Copyright 2007-2009, Unishippers Global Logistics, LLC.
 
Modification and use of this file is governed by the terms
outlined in the LICENSE file which is included in this
software distribution.
-->
<xsl:stylesheet xmlns:xsl="http://www.w3.org/1999/XSL/Transform" version="1.0">
<xsl:template match="/">
<div style="clear:both;width:800px;">
<xsl:for-each select="unishippersinternationalrateresponse/rates/rate">
<div style="float:left;">
	<table style="border:1px solid;width:175px;font-family: arial, helvetica;font-size: 11px;">
		<tr>
			<td colspan="2" style="background-color:#BFBFBF;">Service:<b><xsl:choose>          
									<xsl:when test="service = 'ZZ1'">UPS Worldwide Express</xsl:when>
									<xsl:when test="service = 'ZZ2'">UPS Worldwide Expedited</xsl:when>
									<xsl:when test="service = 'ZZ90'">UPS Worldwide Saver</xsl:when>
									<xsl:when test="service = 'ZZ11'">UPS Standard (Canada)</xsl:when>
									<xsl:otherwise></xsl:otherwise>
									</xsl:choose><xsl:choose>          
									<xsl:when test="Carrier = 'UPS'">UPS</xsl:when>
									<xsl:otherwise></xsl:otherwise>
									</xsl:choose></b> Weight:<xsl:value-of select="weight"/>
			</td>
		</tr>
		<xsl:for-each select="fees/fee">
		<tr>
			<td><xsl:value-of select="description"/>:</td><td align="right"><xsl:value-of select="sellrate"/></td>
		</tr>
		</xsl:for-each>
		<tr>
			<td align="right"><b>Total:</b></td><td align="right"><xsl:value-of select="total"/></td>
		</tr>
	</table>
</div>	
</xsl:for-each>
</div>
</xsl:template>
</xsl:stylesheet>