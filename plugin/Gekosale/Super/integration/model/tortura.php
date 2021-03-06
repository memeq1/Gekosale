<?php

/**
 * Gekosale, Open Source E-Commerce Solution
 * http://www.gekosale.com
 *
 * Copyright (c) 2009 Gekosale
 *
 * This program is free software; you can redistribute it and/or modify it under the terms
 * of the GNU General Public License Version 3, 29 June 2007 as published by the Free Software
 * Foundation (http://opensource.org/licenses/gpl-3.0.html).
 * If you did not receive a copy of the license and are unable to obtain it through the
 * world-wide-web, please send an email to license@verison.pl so we can send you a copy immediately.
 */
namespace Gekosale;

class TorturaModel extends Component\Model
{

	public function getDescription ()
	{
		return '<b>TorturaCen.pl</b> to porównywarka cen produktów, zawierająca katalog sklepów internetowych i gwarantująca tanie zakupy w internecie. Przedstawiamy wiele ofert w jednym miejscu, aby ułatwić potencjalnemu klientowi wybór sklepu. TorturaCen.pl to także rodzaj programu lojalnościowego, dzięki któremu kupujący przy współpracy z serwisem mogą dodatkowo zarobić na zniżkach oferowanych przez sklepy partnerskie.';
	}

	public function getConfigurationFields ()
	{
		return Array();
	}

	public function getProductListIntegration ()
	{
		$sql = "SELECT
					PC.categoryid AS id,
					P.idproduct,
					PT.name,
					P.sellprice,
					PT.shortdescription,
					Photo.photoid,
					PT.seo,
					CT.name AS categoryname,
					PRT.name AS producername
				FROM product P
				LEFT JOIN producttranslation PT ON PT.productid = P.idproduct AND PT.languageid=:languageid
				LEFT JOIN productcategory PC ON PC.productid = P.idproduct
				LEFT JOIN categorytranslation CT ON PC.categoryid = CT.categoryid AND CT.languageid = :languageid
				LEFT JOIN producertranslation PRT ON PRT.producerid = P.producerid AND PRT.languageid = :languageid
				LEFT JOIN productphoto Photo ON Photo.productid = P.idproduct AND Photo.mainphoto = 1
				WHERE P.enable = 1
	            GROUP BY P.idproduct";
		$stmt = Db::getInstance()->prepare($sql);
		$stmt->BindParam('languageid', Helper::getLanguageId());
		$stmt->execute();
		$Data = Array();
		while ($rs = $stmt->fetch()){
			$Data[] = Array(
				'categoryid' => $rs['id'],
				'seo' => $rs['seo'],
				'producername' => $rs['producername'],
				'idproduct' => $rs['idproduct'],
				'name' => $rs['name'],
				'shortdescription' => $rs['shortdescription'],
				'sellprice' => $rs['sellprice'],
				'photoid' => $rs['photoid'],
				'categoryname' => $rs['categoryname']
			);
		}
		foreach ($Data as $key => $Product){
			$Image = App::getModel('gallery')->getOrginalImageById($Product['photoid']);
			$Data[$key]['photo'] = App::getModel('gallery')->getImagePath($Image, App::getURLAdress());
		}
		return $Data;
	}
}