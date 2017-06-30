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
<div style="width:800px;">
<xsl:for-each select="unishippersdomesticrateresponse/rates/rate">
<div style="float:left;">
	<table style="border:1px solid;width:175px;font-family: arial, helvetica;font-size: 11px;">
		<tr>
			<td colspan="2" style="background-color:#BFBFBF;">Service:<b><xsl:choose>          
									<xsl:when test="service = 'ND'">UPS Next Day Air</xsl:when>
									<xsl:when test="service = 'ND4'">UPS Next Day Air Saver</xsl:when>
									<xsl:when test="service = 'ND5'">UPS Next Day Air Early A.M.</xsl:when>
									<xsl:when test="service = 'SC'">UPS 2nd Day Air</xsl:when>
									<xsl:when test="service = 'SC25'">UPS 2nd Day Air A.M.</xsl:when>
									<xsl:when test="service = 'SC3'">UPS 3 Day Select</xsl:when>
									<xsl:when test="service = 'SG'">UPS Ground</xsl:when>
									<xsl:when test="service = 'SND'">UPS Next Day Air (Saturday Delivery)</xsl:when>
									<xsl:when test="service = 'SSC'">UPS 2nd Day Air (Saturday Delivery)</xsl:when>
									<xsl:when test="service = 'SND5'">UPS Next Day Air Early A.M. (Saturday Delivery)</xsl:when>			
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